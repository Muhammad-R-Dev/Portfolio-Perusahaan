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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $service = Service::findOrFail($id);

        if ($request->hasFile('image')) {
            // Ganti gambar: hapus file lama, simpan yang baru
            $this->hapusGambarLama($service->image);
            $validated['image'] = $request->file('image')->store('services', 'public');
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