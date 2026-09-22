<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'project' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_awal' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'project' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_awal' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $client->update($validated);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json(['message' => 'Deleted']);
    }

    /**
     * Hapus banyak data Client sekaligus (tombol "Hapus Terpilih").
     * Menerima JSON: { "ids": [1, 2, 3] }
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:clients,id',
        ]);

        $deleted = Client::whereIn('id', $validated['ids'])->delete();

        return response()->json([
            'message' => 'Deleted',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Hapus SEMUA data Client (tombol "Hapus Semua").
     */
    public function destroyAll()
    {
        $deleted = Client::query()->delete();

        return response()->json([
            'message' => 'Deleted all',
            'deleted' => $deleted,
        ]);
    }

    /**
     * Export data Client ke CSV
     */
    public function export()
    {
        $fileName = 'data-klien-proyek.csv';
        $clients = Client::latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Judul kolom CSV (tanpa nomor urut biar import-nya gampang)
        $columns = ['Nama Client', 'Nama Project', 'Deskripsi', 'Tanggal Mulai', 'Deadline'];

        $callback = function() use($clients, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tulis header
            fputcsv($file, $columns);

            // Tulis data per baris
            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->nama,
                    $client->project,
                    // Hilangkan tag HTML bawaan dari text-editor (opsional tapi bikin rapi di Excel)
                    strip_tags($client->deskripsi), 
                    $client->tanggal_awal,
                    $client->deadline
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Download Template CSV Kosong untuk Import
     */
    public function template()
    {
        $fileName = 'Template-Import-Proyek.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama Client', 'Nama Project', 'Deskripsi', 'Tanggal Mulai', 'Deadline'];

        $callback = function() use($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            // Isi baris dummy sebagai panduan admin
            fputcsv($file, ['PT Contoh Sukses', 'Pembuatan Aplikasi Kasir', 'Dibuat dengan Laravel', '2026-10-01', '2026-12-31']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import data Client dari Frontend (Menerima Data Mentah dari SheetJS)
     */
    public function import(Request $request)
    {
        // Tangkap data array yang dikirim dari Javascript
        $rows = $request->input('data');

        if (!$rows || !is_array($rows)) {
            return response()->json(['success' => false, 'message' => 'Data tidak valid atau kosong.'], 400);
        }

        // Hapus baris pertama jika itu adalah judul kolom (Header)
        if (isset($rows[0]) && is_array($rows[0]) && stripos($rows[0][0], 'Nama') !== false) {
            array_shift($rows);
        }

        $berhasil = 0;

        foreach ($rows as $row) {
            // Pastikan minimal ada 5 kolom yang terisi (Nama, Project, Desk, Mulai, Deadline)
            if (is_array($row) && count($row) >= 5) {
                // Abaikan jika Nama Client kosong
                if (trim($row[0]) == '') continue;

                // Rapikan format tanggal
                $tanggalMulai = date('Y-m-d', strtotime(trim($row[3])));
                $deadline     = date('Y-m-d', strtotime(trim($row[4])));

                Client::create([
                    'nama'         => trim($row[0]),
                    'project'      => trim($row[1]),
                    'deskripsi'    => trim($row[2]),
                    'tanggal_awal' => $tanggalMulai,
                    'deadline'     => $deadline,
                ]);
                
                $berhasil++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "$berhasil data client berhasil di-import!"
        ]);
    }
}