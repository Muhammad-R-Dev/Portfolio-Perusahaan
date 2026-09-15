<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Tampilkan halaman Kelola Blog (list + statistik).
     */
    public function index(): View
    {
        $blogs = Blog::latest()->paginate(10);

        $totalBlog   = Blog::count();
        $totalTerbit = Blog::where('status', 'publish')->count();
        $totalDraft  = Blog::where('status', 'draft')->count();
        
        return view('admin.pages.kelola-blog', compact(
            'blogs',
            'totalBlog',
            'totalTerbit',
            'totalDraft'
        ));
    }

    /**
     * Simpan blog baru dari modal "Tambah Blog".
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|in:project,berita,kegiatan',
            'konten'   => 'required|string',
            'gambar'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Status selalu "publish" otomatis, tidak lagi dipilih lewat form.
        $validated['status'] = 'publish';

        $validated['slug'] = Blog::generateUniqueSlug($validated['judul']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('blog', 'public');
        }

        Blog::create($validated);

        return redirect()
            ->route('admin.kelola-blog.index')
            ->with('success', 'Blog berhasil ditambahkan.');
    }

    /**
     * Perbarui blog dari modal "Edit Blog".
     */
    public function update(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'judul'    => 'required|string|max:255',
            'kategori' => 'required|in:project,berita,kegiatan',
            'konten'   => 'required|string',
            // gambar opsional saat edit — hanya wajib diisi kalau mau diganti
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Status selalu "publish" otomatis, tidak lagi dipilih lewat form.
        $validated['status'] = 'publish';

        // Slug hanya dibuat ulang kalau judul berubah, supaya URL lama tidak berubah tiap edit kecil
        if ($blog->judul !== $validated['judul']) {
            $validated['slug'] = Blog::generateUniqueSlug($validated['judul'], $blog->id);
        }

        if ($request->hasFile('gambar')) {
            // Ada gambar baru diunggah -> hapus yang lama, pakai yang baru.
            if ($blog->gambar) {
                Storage::disk('public')->delete($blog->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('blog', 'public');
        } elseif ($request->boolean('hapus_gambar')) {
            // Tombol hapus di uploader ditekan tanpa upload gambar baru -> kosongkan.
            if ($blog->gambar) {
                Storage::disk('public')->delete($blog->gambar);
            }
            $validated['gambar'] = null;
        }

        $blog->update($validated);

        return redirect()
            ->route('admin.kelola-blog.index')
            ->with('success', 'Blog berhasil diperbarui.');
    }

    /**
     * Hapus blog beserta gambarnya.
     */
    public function destroy(Blog $blog): RedirectResponse
    {
        if ($blog->gambar) {
            Storage::disk('public')->delete($blog->gambar);
        }

        $blog->delete();

        return redirect()
            ->route('admin.kelola-blog.index')
            ->with('success', 'Blog berhasil dihapus.');
    }
}