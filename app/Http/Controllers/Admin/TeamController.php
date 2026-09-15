<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('urutan')->orderBy('id')->get();

        $totalAnggota = $teams->count();
        $aktif        = $teams->where('status', 'aktif')->count();
        $nonaktif     = $teams->where('status', 'nonaktif')->count();

        return view('admin.pages.kelola-tim', compact('teams', 'totalAnggota', 'aktif', 'nonaktif'));
    }

    public function store(Request $request)
    {
        $validated = $this->validasi($request);
        $validated['status'] = 'aktif';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('tim', 'public');
        }

        Team::create($validated);

        return redirect()
            ->route('admin.kelola-tim')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function update(Request $request, Team $tim)
    {
        $validated = $this->validasi($request);

        if ($request->hasFile('foto')) {
            $this->hapusFotoLama($tim->foto);
            $validated['foto'] = $request->file('foto')->store('tim', 'public');
        }

        $tim->update($validated);

        return redirect()
            ->route('admin.kelola-tim')
            ->with('success', 'Data tim berhasil diperbarui.');
    }

    public function destroy(Team $tim)
    {
        $this->hapusFotoLama($tim->foto);
        $tim->delete();

        return redirect()
            ->route('admin.kelola-tim')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama'    => ['required', 'string', 'max:100'],
            'jabatan' => ['required', 'string', 'max:100'],
            'divisi'  => ['required', 'string', 'max:100'],
            'foto'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function hapusFotoLama(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}