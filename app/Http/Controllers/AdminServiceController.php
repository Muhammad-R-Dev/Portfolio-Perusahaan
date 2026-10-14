<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminServiceController extends Controller
{
    // Ekstensi gambar yang diizinkan (samakan dengan ALLOWED_IMAGE_EXT di blade)
    private const ALLOWED_IMAGE_EXT = [
        'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp',
        'png', 'webp', 'gif', 'bmp', 'avif', 'heic', 'heif',
    ];

    public function index()
    {
        $services = Service::all();
        return view('admin.pages.kelola-layanan', compact('services'));
    }

    public function create()
    {
        // unused as we use modal
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required',
            'description' => 'required',
            // 10MB (10240 KB). Tanpa 'mimes' karena deteksi MIME Laravel
            // sering gagal untuk jfif/heic/avif; ekstensi dicek manual di bawah.
            'image'       => 'nullable|file|max:10240',
        ]);

        // Jangan biarkan 'image' => null ikut tersimpan
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($error = $this->cekFormatGambar($request->file('image'))) {
                return back()->withInput()->withErrors(['image' => $error]);
            }
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);

        return redirect()->route('admin.kelola-layanan.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'image'       => 'nullable|file|max:10240',
        ]);

        $service = Service::findOrFail($id);

        // PENTING: buang 'image' dari data validasi supaya gambar lama
        // tidak tertimpa null ketika user tidak memilih file baru.
        unset($validated['image']);

        if ($request->hasFile('image')) {
            if ($error = $this->cekFormatGambar($request->file('image'))) {
                return back()->withInput()->withErrors(['image' => $error]);
            }

            // Ganti gambar: simpan yang baru dulu, baru hapus yang lama
            $pathBaru = $request->file('image')->store('services', 'public');
            $this->hapusGambarLama($service->image);
            $validated['image'] = $pathBaru;

        } elseif ($request->boolean('hapus_gambar')) {
            // User menekan "hapus gambar" tanpa upload gambar baru
            $this->hapusGambarLama($service->image);
            $validated['image'] = null;
        }

        $service->update($validated);

        return redirect()->route('admin.kelola-layanan.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $this->hapusGambarLama($service->image);
        $service->delete();

        return redirect()->route('admin.kelola-layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Validasi ekstensi manual. Return pesan error, atau null jika valid.
     */
    private function cekFormatGambar($file): ?string
    {
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, self::ALLOWED_IMAGE_EXT, true)) {
            return 'Format file tidak didukung. Gunakan: '
                . strtoupper(implode(', ', self::ALLOWED_IMAGE_EXT)) . '.';
        }

        return null;
    }

    private function hapusGambarLama(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}