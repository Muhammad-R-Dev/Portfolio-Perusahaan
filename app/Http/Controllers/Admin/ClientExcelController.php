<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ProyekExcel;
use App\Services\ProyekImportException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ClientExcelController extends Controller
{
    private const MAX_UPLOAD_BYTES = 5 * 1024 * 1024; // 5 MB

    /** Unduh semua data client sebagai file Excel yang sudah dirapikan. */
    public function export(ProyekExcel $excel): StreamedResponse
    {
        // Urutan baris di Excel: deadline terdekat dulu. Ubah orderBy di sini jika ingin urutan lain.
        $clients = Client::orderBy('deadline')->orderBy('id')->get();

        return $this->download(
            $excel->buildExport($clients),
            'Data-Kelola-Proyek_' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    /** Unduh template kosong (berisi sheet petunjuk) untuk import. */
    public function template(ProyekExcel $excel): StreamedResponse
    {
        return $this->download($excel->buildTemplate(), 'Template-Import-Proyek.xlsx');
    }

    /** Import dari .xlsx / .xls / .csv. Baris valid disimpan, baris bermasalah dilaporkan per nomor baris. */
    public function import(Request $request, ProyekExcel $excel): RedirectResponse
    {
        $file = $request->file('file');

        if (! $file || ! $file->isValid()) {
            return $this->fail('File gagal diunggah. Pilih file lagi dan pastikan ukurannya tidak lebih dari 5 MB.');
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (! in_array($extension, ['xlsx', 'xls', 'csv'], true)) {
            return $this->fail('Format file tidak didukung. Gunakan file .xlsx, .xls, atau .csv.');
        }
        if ($file->getSize() > self::MAX_UPLOAD_BYTES) {
            return $this->fail('Ukuran file maksimal 5 MB.');
        }

        try {
            $parsed = $excel->parse($file->getRealPath(), $extension);
        } catch (ProyekImportException $e) {
            return $this->fail($e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return $this->fail('File tidak dapat dibaca. Pastikan file berformat Excel (.xlsx/.xls) atau CSV yang valid, atau gunakan template.');
        }

        if (! $parsed['rows'] && ! $parsed['errors']) {
            return $this->fail('Tidak ada baris data yang ditemukan. Isi data mulai baris ke-2, lalu unggah lagi.');
        }

        // Baris yang sama dengan data lama (Nama Client + Nama Project + Tanggal Mulai) dilewati.
        $existing = Client::query()
            ->get(['nama', 'project', 'tanggal_awal'])
            ->map(fn ($c) => ProyekExcel::dedupeKey($c->nama, $c->project, $c->tanggal_awal))
            ->all();

        $plan = $excel->planImport($parsed['rows'], $existing);

        DB::transaction(function () use ($plan) {
            foreach ($plan['new'] as $row) {
                Client::create($row);
            }
        });

        $inserted = count($plan['new']);
        $skipped  = $plan['skipped'];
        $errors   = $parsed['errors'];

        if ($skipped === 0 && ! $errors) {
            return back()->with('success', "{$inserted} data client berhasil diimport.");
        }

        return back()->with('import_report', [
            'inserted'    => $inserted,
            'skipped'     => $skipped,
            'error_total' => count($errors),
            'errors'      => array_slice($errors, 0, 50), // cukup 50 baris pertama agar popup tidak kepanjangan
        ]);
    }

    private function fail(string $message): RedirectResponse
    {
        return back()->with('import_report', ['fatal' => $message]);
    }

    private function download(Spreadsheet $book, string $filename): StreamedResponse
    {
        return response()->streamDownload(function () use ($book) {
            (new Xlsx($book))->save('php://output');
            $book->disconnectWorksheets();
        }, $filename, [
            'Content-Type'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0, no-cache, must-revalidate',
        ]);

        
    }
}
