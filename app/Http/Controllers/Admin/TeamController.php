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
        // Tangkap input sosial media (sekarang bentuknya Array dari HTML)
        $links = $request->input('sosial_media', []);
        $cleanLinks = [];

        if (is_array($links)) {
            foreach ($links as $link) {
                $link = trim((string) $link);
                // Hanya proses kotak input yang benar-benar diisi admin
                if (!empty($link)) {
                    // Kalau diisi tapi belum pakai http/https, otomatis tambahkan
                    if (!preg_match('#^https?://#i', $link)) {
                        $link = 'https://' . $link;
                    }
                    $cleanLinks[] = $link;
                }
            }
        }
        
        // Simpan kembali array yang sudah dibersihkan ke request
        // Jika kosong (admin tidak mengisi sosmed sama sekali), jadikan null
        $request->merge(['sosial_media' => count($cleanLinks) > 0 ? $cleanLinks : null]);

        // Validasi Utama
        return $request->validate([
            'nama'             => ['required', 'string', 'max:100'],
            'jabatan'          => ['required', 'string', 'max:100'],
            // Field utama boleh kosong, tapi HARUS berupa array kalau ada
            'sosial_media'     => ['nullable', 'array'],
            // Validasi link di dalam array satu per satu
            'sosial_media.*'   => ['url', 'max:255'], 
            'foto'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama.required'      => 'Nama anggota tim wajib diisi.',
            'jabatan.required'   => 'Jabatan wajib dipilih atau diisi.',
            'sosial_media.*.url' => 'Salah satu format link sosial media yang Anda masukkan tidak valid.',
            'foto.image'         => 'File yang diupload harus berupa gambar.',
            'foto.max'           => 'Ukuran foto maksimal adalah 2MB.',
        ]);
    }

    private function hapusFotoLama(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}