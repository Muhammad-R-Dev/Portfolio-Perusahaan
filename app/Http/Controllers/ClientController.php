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
     * Import data Client dari file CSV
     */
    public function import(Request $request)
    {
        // Validasi file yang masuk harus berformat CSV atau TXT
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file');
        $fileHandle = fopen($file->getPathname(), 'r');
        
        // Lewati baris pertama (karena isinya cuma judul kolom 'Nama Client', dll)
        fgetcsv($fileHandle);

        $berhasil = 0;

        // Looping baca baris demi baris dari file CSV
        while (($row = fgetcsv($fileHandle)) !== false) {
            // Pastikan baris tersebut punya 5 kolom (sesuai format export kita)
            if (count($row) >= 5) {
                // Abaikan kalau nama client kosong
                if(trim($row[0]) == '') continue;

                Client::create([
                    'nama'         => trim($row[0]),
                    'project'      => trim($row[1]),
                    'deskripsi'    => trim($row[2]),
                    'tanggal_awal' => trim($row[3]),
                    'deadline'     => trim($row[4]),
                ]);
                
                $berhasil++;
            }
        }

        fclose($fileHandle);

        // Lempar kembali ke halaman tadi sambil bawa pesan sukses
        return redirect()->back()->with('success', "$berhasil data client berhasil di-import!");
    }
}