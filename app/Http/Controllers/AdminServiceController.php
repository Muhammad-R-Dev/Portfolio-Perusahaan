<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminServiceController extends Controller
{
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
            // Kita hapus 'mimes' bawaan laravel, dan naikin kapasitas jadi 10MB (10240 KB)
            'image'       => 'nullable|file|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'heic'];
            
            // Validasi ekstensi manual (Bypass kelemahan deteksi MIME Laravel)
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['image' => 'Format file gagal diupload. Pastikan formatnya jpg, jpeg, png, jfif, atau heic.']);
            }
            
            $validated['image'] = $file->store('services', 'public');
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
            // Kapasitas 10MB
            'image'       => 'nullable|file|max:10240',
        ]);

        $service = Service::findOrFail($id);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension());
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'jfif', 'heic'];
            
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['image' => 'Format file gagal diupload. Pastikan formatnya jpg, jpeg, png, jfif, atau heic.']);
            }

            // Ganti gambar: hapus file lama, simpan yang baru
            $this->hapusGambarLama($service->image);
            $validated['image'] = $file->store('services', 'public');
            
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

    private function hapusGambarLama(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}