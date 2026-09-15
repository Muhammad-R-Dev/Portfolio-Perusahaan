<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = \App\Models\Service::all();
        return view('admin.pages.kelola-layanan', compact('services'));
    }

    public function create()
    {
        // unused as we use modal
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/services'), $imageName);
            $data['image'] = $imageName;
        }

        \App\Models\Service::create($data);

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
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $service = \App\Models\Service::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/services'), $imageName);
            $data['image'] = $imageName;
        }

        $service->update($data);

        return redirect()->route('admin.kelola-layanan.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $service = \App\Models\Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.kelola-layanan.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
