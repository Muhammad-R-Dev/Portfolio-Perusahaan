<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();

        $totalFoto     = $galleries->count();
        $totalKategori = $galleries->pluck('kategori')->unique()->count();
        $bulanIni      = $galleries->filter(fn ($g) => $g->created_at->isCurrentMonth())->count();

        return view('admin.pages.kelola-galeri', compact('galleries', 'totalFoto', 'totalKategori', 'bulanIni'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'    => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'in:kegiatan,fasilitas,tim,acara'],
            'foto'     => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $validated['foto'] = $request->file('foto')->store('galeri', 'public');

        Gallery::create($validated);

        return redirect()
            ->route('admin.kelola-galeri')
            ->with('success', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function update(Request $request, Gallery $galeri)
    {
        $validated = $request->validate([
            'judul'    => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'in:kegiatan,fasilitas,tim,acara'],
            'foto'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $this->hapusFotoLama($galeri->foto);
            $validated['foto'] = $request->file('foto')->store('galeri', 'public');
        }

        $galeri->update($validated);

        return redirect()
            ->route('admin.kelola-galeri')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $galeri)
    {
        $this->hapusFotoLama($galeri->foto);
        $galeri->delete();

        return redirect()
            ->route('admin.kelola-galeri')
            ->with('success', 'Foto berhasil dihapus dari galeri.');
    }

    private function hapusFotoLama(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
