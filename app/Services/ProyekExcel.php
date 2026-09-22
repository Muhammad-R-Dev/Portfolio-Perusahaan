<?php

namespace App\Services;

use DateTimeImmutable;
use DateTimeInterface;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Membuat & membaca file Excel untuk halaman Kelola Proyek.
 *
 * - buildExport()   : data client -> workbook rapi (judul, ringkasan, header, zebra, status warna)
 * - buildTemplate() : template kosong + sheet petunjuk untuk import
 * - parse()         : membaca file .xlsx/.xls/.csv -> baris valid + daftar error per baris
 * - planImport()    : memisahkan baris baru vs duplikat
 *
 * Class ini tidak bergantung pada Eloquent, jadi mudah diuji sendiri.
 */
class ProyekExcel
{
    public const SHEET      = 'Data Proyek';
    public const MAX_ROWS   = 1000;   // batas baris data per file import
    public const MAX_LENGTH = 255;    // batas karakter Nama Client / Nama Project

    private const FONT       = 'Arial';
    private const C_PRIMARY  = 'FF2563EB';
    private const C_DARK     = 'FF1E293B';
    private const C_TEXT     = 'FF334155';
    private const C_MUTED    = 'FF64748B';
    private const C_BORDER   = 'FFE2E8F0';
    private const C_ZEBRA    = 'FFF1F5F9';
    private const C_BANNER   = 'FFEFF6FF';
    private const C_BANNER_T = 'FF1E40AF';

    private const MONTHS_ID = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    /** Nama bulan (Indonesia/Inggris) -> nomor bulan, untuk tanggal yang diketik sebagai teks. */
    private const MONTH_LOOKUP = [
        'jan' => 1, 'januari' => 1, 'january' => 1,
        'feb' => 2, 'februari' => 2, 'pebruari' => 2, 'february' => 2,
        'mar' => 3, 'maret' => 3, 'march' => 3,
        'apr' => 4, 'april' => 4,
        'mei' => 5, 'may' => 5,
        'jun' => 6, 'juni' => 6, 'june' => 6,
        'jul' => 7, 'juli' => 7, 'july' => 7,
        'agu' => 8, 'agt' => 8, 'agus' => 8, 'agustus' => 8, 'aug' => 8, 'august' => 8,
        'sep' => 9, 'sept' => 9, 'september' => 9,
        'okt' => 10, 'oct' => 10, 'oktober' => 10, 'october' => 10,
        'nov' => 11, 'nop' => 11, 'november' => 11, 'nopember' => 11,
        'des' => 12, 'dec' => 12, 'desember' => 12, 'december' => 12,
    ];

    /** Variasi judul kolom yang dikenali saat import (sudah dinormalisasi: huruf kecil, tanpa spasi/simbol). */
    private const HEADER_ALIASES = [
        'nama'         => ['namaclient', 'client', 'namaklien', 'klien', 'nama'],
        'project'      => ['namaproject', 'project', 'namaproyek', 'proyek'],
        'deskripsi'    => ['deskripsi', 'deskripsilengkap', 'keterangan', 'catatan'],
        'tanggal_awal' => ['tanggalmulai', 'tanggalawal', 'tglmulai', 'mulai', 'startdate'],
        'deadline'     => ['deadline', 'deadlineproject', 'tanggaldeadline', 'tenggat', 'tenggatwaktu', 'batasakhir'],
    ];

    private const HEADER_LABELS = [
        'nama'         => 'Nama Client',
        'project'      => 'Nama Project',
        'deskripsi'    => 'Deskripsi',
        'tanggal_awal' => 'Tanggal Mulai',
        'deadline'     => 'Deadline',
    ];

    /* =====================================================================
     * EXPORT
     * ===================================================================== */

    /**
     * @param iterable $clients  Model/array dengan key: nama, project, deskripsi, tanggal_awal, deadline
     */
    public function buildExport(iterable $clients): Spreadsheet
    {
        $rows = [];
        foreach ($clients as $client) {
            $rows[] = $client;
        }
        $count = count($rows);

        $book  = $this->newBook('Data Kelola Proyek');
        $sheet = $book->getActiveSheet();
        $sheet->setTitle(self::SHEET);
        $sheet->setShowGridLines(false);
        $sheet->getTabColor()->setARGB(self::C_PRIMARY);

        $headerRow = 5;
        $first     = 6;
        $last      = $count > 0 ? $first + $count - 1 : $first;

        foreach (['A' => 6, 'B' => 28, 'C' => 32, 'D' => 60, 'E' => 15, 'F' => 15, 'G' => 18] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // --- Judul, waktu export, ringkasan ---------------------------------
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValueExplicit('A1', 'Data Kelola Proyek', DataType::TYPE_STRING);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->getColor()->setARGB(self::C_DARK);
        $sheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells('A2:G2');
        $sheet->setCellValueExplicit(
            'A2',
            'Astabrata Teknologi   |   Diekspor pada ' . $this->indoDateTime(new DateTimeImmutable('now')),
            DataType::TYPE_STRING
        );
        $sheet->getStyle('A2')->getFont()->getColor()->setARGB(self::C_MUTED);
        $sheet->getRowDimension(2)->setRowHeight(18);

        $sheet->mergeCells('A3:G3');
        $sheet->setCellValue(
            'A3',
            '="Total client: "&COUNTA(B' . $first . ':B' . $last . ')'
            . '&"          Project berjalan: "&COUNTIF(G' . $first . ':G' . $last . ',"Berjalan")'
            . '&"          Lewat deadline: "&COUNTIF(G' . $first . ':G' . $last . ',"Lewat Deadline")'
        );
        $banner = $sheet->getStyle('A3:G3');
        $banner->getFont()->setBold(true)->getColor()->setARGB(self::C_BANNER_T);
        $banner->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(self::C_BANNER);
        $banner->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)->setIndent(1);
        $sheet->getRowDimension(3)->setRowHeight(24);

        $sheet->getRowDimension(4)->setRowHeight(8);

        // --- Header tabel ---------------------------------------------------
        $sheet->fromArray([['No', 'Nama Client', 'Nama Project', 'Deskripsi', 'Tanggal Mulai', 'Deadline', 'Status']], null, 'A' . $headerRow);
        $this->styleHeader($sheet, "A{$headerRow}:G{$headerRow}");
        $sheet->getStyle("A{$headerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(0);
        $sheet->getStyle("E{$headerRow}:G{$headerRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(0);
        $sheet->getRowDimension($headerRow)->setRowHeight(26);

        // --- Isi tabel ------------------------------------------------------
        if ($count === 0) {
            $sheet->mergeCells("A{$first}:G{$first}");
            $sheet->setCellValueExplicit("A{$first}", 'Belum ada data client.', DataType::TYPE_STRING);
            $sheet->getStyle("A{$first}")->getFont()->setItalic(true)->getColor()->setARGB(self::C_MUTED);
            $sheet->getStyle("A{$first}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($first)->setRowHeight(32);
        }

        $r = $first;
        foreach ($rows as $i => $client) {
            $nama    = (string) self::attr($client, 'nama');
            $project = (string) self::attr($client, 'project');
            $desc    = self::htmlToPlain((string) self::attr($client, 'deskripsi'));

            $sheet->setCellValue("A{$r}", $i + 1);
            $this->setText($sheet, "B{$r}", $nama);
            $this->setText($sheet, "C{$r}", $project);
            $this->setText($sheet, "D{$r}", $desc);
            $this->setDate($sheet, "E{$r}", self::attr($client, 'tanggal_awal'));
            $this->setDate($sheet, "F{$r}", self::attr($client, 'deadline'));
            // Status dihitung Excel sendiri, jadi selalu ikut hari ini saat file dibuka.
            $sheet->setCellValue("G{$r}", "=IF(F{$r}=\"\",\"Berjalan\",IF(F{$r}<TODAY(),\"Lewat Deadline\",\"Berjalan\"))");

            $sheet->getRowDimension($r)->setRowHeight($this->estimateRowHeight($nama, $project, $desc));
            $r++;
        }

        if ($count > 0) {
            $body = "A{$first}:G{$last}";
            $style = $sheet->getStyle($body);
            $style->getFont()->getColor()->setARGB(self::C_TEXT);
            $style->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB(self::C_BORDER);

            $sheet->getStyle("A{$first}:A{$last}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$first}:G{$last}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$first}:D{$last}")->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true)->setIndent(1);
            $sheet->getStyle("B{$first}:B{$last}")->getFont()->setBold(true)->getColor()->setARGB(self::C_DARK);
            $sheet->getStyle("G{$first}:G{$last}")->getFont()->setBold(true);
            $sheet->getStyle("E{$first}:F{$last}")->getNumberFormat()->setFormatCode('dd mmm yyyy');

            // Warna dibuat lewat conditional formatting supaya tetap benar setelah
            // data diurutkan/difilter atau saat tanggal berganti.
            $zebra = $this->condition('MOD(ROW(),2)=1', null, self::C_ZEBRA);
            $sheet->getStyle("A{$first}:E{$last}")->setConditionalStyles([$zebra]);
            $sheet->getStyle("F{$first}:F{$last}")->setConditionalStyles([
                $this->condition("AND(\$F{$first}<>\"\",\$F{$first}<TODAY())", 'FFB91C1C', null, true),
                $zebra,
            ]);
            $sheet->getStyle("G{$first}:G{$last}")->setConditionalStyles([
                $this->condition("\$G{$first}=\"Lewat Deadline\"", 'FFB91C1C', 'FFFEE2E2', true),
                $this->condition("\$G{$first}=\"Berjalan\"", 'FF15803D', null, true),
                $zebra,
            ]);
        }

        $sheet->freezePane('A' . $first);
        $sheet->setAutoFilter("A{$headerRow}:G{$last}");

        $this->applyPrintSetup($sheet, $headerRow);

        $book->setActiveSheetIndex(0);
        $sheet->setSelectedCell('A' . $first);

        return $book;
    }

    /* =====================================================================
     * TEMPLATE IMPORT
     * ===================================================================== */

    public function buildTemplate(): Spreadsheet
    {
        $book  = $this->newBook('Template Import Kelola Proyek');
        $sheet = $book->getActiveSheet();
        $sheet->setTitle(self::SHEET);
        $sheet->getTabColor()->setARGB(self::C_PRIMARY);

        $inputRows = 300;
        $lastRow   = $inputRows + 1;

        foreach (['A' => 30, 'B' => 34, 'C' => 60, 'D' => 16, 'E' => 16] as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->fromArray([['Nama Client', 'Nama Project', 'Deskripsi', 'Tanggal Mulai', 'Deadline']], null, 'A1');
        $this->styleHeader($sheet, 'A1:E1');
        $sheet->getStyle('D1:E1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(0);
        $sheet->getRowDimension(1)->setRowHeight(26);

        $body = $sheet->getStyle("A2:E{$lastRow}");
        $body->getFont()->getColor()->setARGB(self::C_TEXT);
        $body->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $body->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB(self::C_BORDER);
        $sheet->getStyle("A2:C{$lastRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true)->setIndent(1);
        $sheet->getStyle("D2:E{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:E{$lastRow}")->getNumberFormat()->setFormatCode('dd mmm yyyy');

        $this->addDateValidation($sheet, "D2:D{$lastRow}", 'Tanggal Mulai', 'Isi tanggal, contoh: 15/03/2026');
        $this->addDateValidation($sheet, "E2:E{$lastRow}", 'Deadline', 'Isi tanggal, contoh: 30/06/2026');

        $sheet->freezePane('A2');
        $sheet->setSelectedCell('A2');
        $this->applyPrintSetup($sheet, 1);

        // --- Sheet petunjuk -------------------------------------------------
        $guide = $book->createSheet();
        $guide->setTitle('Petunjuk');
        $guide->setShowGridLines(false);
        $guide->getTabColor()->setARGB('FF94A3B8');
        foreach (['A' => 18, 'B' => 10, 'C' => 58, 'D' => 30] as $col => $width) {
            $guide->getColumnDimension($col)->setWidth($width);
        }

        $guide->mergeCells('A1:D1');
        $guide->setCellValueExplicit('A1', 'Cara mengisi template', DataType::TYPE_STRING);
        $guide->getStyle('A1')->getFont()->setBold(true)->setSize(14)->getColor()->setARGB(self::C_DARK);
        $guide->getRowDimension(1)->setRowHeight(28);

        $steps = [
            '1.  Isi data di sheet "' . self::SHEET . '", satu baris untuk satu project, mulai dari baris ke-2.',
            '2.  Jangan mengubah atau menghapus judul kolom di baris pertama.',
            '3.  Tulis tanggal dengan urutan hari/bulan/tahun, contoh 15/03/2026.',
            '4.  Baris yang sama dengan data yang sudah ada (Nama Client, Nama Project, dan Tanggal Mulai sama) akan dilewati.',
            '5.  Simpan file, lalu unggah lewat tombol Import Excel. Maksimal ' . number_format(self::MAX_ROWS, 0, ',', '.') . ' baris dan 5 MB per file.',
        ];
        $r = 3;
        foreach ($steps as $step) {
            $guide->mergeCells("A{$r}:D{$r}");
            $guide->setCellValueExplicit("A{$r}", $step, DataType::TYPE_STRING);
            $guide->getStyle("A{$r}")->getFont()->getColor()->setARGB(self::C_TEXT);
            $guide->getRowDimension($r)->setRowHeight(18);
            $r++;
        }

        $r += 1;
        $tableHead = $r;
        $guide->fromArray([['Kolom', 'Wajib', 'Aturan', 'Contoh']], null, "A{$r}");
        $this->styleHeader($guide, "A{$r}:D{$r}");
        $guide->getRowDimension($r)->setRowHeight(24);

        $table = [
            ['Nama Client',   'Ya',    'Nama perusahaan atau perorangan. Maksimal 255 karakter.', 'PT Astabrata Mandiri'],
            ['Nama Project',  'Ya',    'Nama proyek yang dikerjakan. Maksimal 255 karakter.',     'Website Company Profile'],
            ['Deskripsi',     'Tidak', 'Catatan proyek berupa teks biasa. Boleh beberapa baris.', 'Redesign website 8 halaman dan integrasi form kontak.'],
            ['Tanggal Mulai', 'Ya',    'Format hari/bulan/tahun.',                                '15/03/2026'],
            ['Deadline',      'Ya',    'Format hari/bulan/tahun. Tidak boleh sebelum Tanggal Mulai.', '30/06/2026'],
        ];
        foreach ($table as $line) {
            $r++;
            foreach ($line as $k => $text) {
                $guide->setCellValueExplicit(chr(65 + $k) . $r, $text, DataType::TYPE_STRING);
            }
            $guide->getRowDimension($r)->setRowHeight(32);
        }
        $tbl = $guide->getStyle('A' . ($tableHead + 1) . ":D{$r}");
        $tbl->getFont()->getColor()->setARGB(self::C_TEXT);
        $tbl->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true)
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)->setIndent(1);
        $tbl->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB(self::C_BORDER);
        $guide->getStyle('A' . ($tableHead + 1) . ':A' . $r)->getFont()->setBold(true);
        $guide->getStyle('B' . ($tableHead + 1) . ':B' . $r)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setIndent(0);

        $this->applyPrintSetup($guide, $tableHead);
        $book->setActiveSheetIndex(0);

        return $book;
    }

    /* =====================================================================
     * IMPORT
     * ===================================================================== */

    /**
     * Membaca file import.
     *
     * @return array{rows: array<int, array>, errors: array<int, array{row:int, message:string}>}
     *
     * @throws ProyekImportException  untuk masalah yang pesannya aman ditampilkan ke pengguna
     */
    public function parse(string $path, string $extension): array
    {
        $extension = strtolower($extension);

        if ($extension === 'csv') {
            $reader = IOFactory::createReader('Csv');
            $reader->setDelimiter($this->detectCsvDelimiter($path));
            $reader->setInputEncoding($this->detectCsvEncoding($path));
        } else {
            try {
                $reader = IOFactory::createReaderForFile($path);
            } catch (\Throwable $e) {
                // Nama file .xlsx/.xls tapi isinya bukan format itu (mis. sebenarnya CSV/HTML yang di-rename).
                throw new ProyekImportException(
                    'File tidak bisa dibaca sebagai Excel. Kemungkinan file rusak, atau formatnya sebenarnya CSV/HTML yang cuma diganti nama jadi .xlsx/.xls. Buka lagi filenya di Excel lalu "Save As" ke .xlsx, atau gunakan template dari tombol Import Excel.'
                );
            }
        }
        $reader->setReadDataOnly(true);

        try {
            $book = $reader->load($path);
        } catch (ProyekImportException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new ProyekImportException(
                'File tidak bisa dibaca. Pastikan file tidak terkunci/dilindungi password, tidak rusak, dan benar-benar format ' . strtoupper($extension) . '. Gunakan template dari tombol Import Excel kalau masih gagal.'
            );
        }
        $sheet = $book->getSheetByName(self::SHEET) ?: $book->getSheet(0);

        $highestRow = $sheet->getHighestDataRow();
        $highestCol = $sheet->getHighestDataColumn();
        if ($highestRow < 1) {
            throw new ProyekImportException('File kosong. Isi data dulu menggunakan template.');
        }

        // Formula tidak dihitung (false) supaya file dari luar tidak bisa menjalankan fungsi apa pun.
        $grid = $sheet->rangeToArray("A1:{$highestCol}{$highestRow}", null, false, false, false);
        $book->disconnectWorksheets();
        unset($book, $sheet);

        [$headerIndex, $map] = $this->findHeader($grid);

        $rows   = [];
        $errors = [];
        $total  = count($grid);

        for ($i = $headerIndex + 1; $i < $total; $i++) {
            $line = $grid[$i];
            $excelRow = $i + 1;

            $rawNama     = $this->cellFrom($line, $map, 'nama');
            $rawProject  = $this->cellFrom($line, $map, 'project');
            $rawDesc     = $this->cellFrom($line, $map, 'deskripsi');
            $rawStart    = $this->cellFrom($line, $map, 'tanggal_awal');
            $rawDeadline = $this->cellFrom($line, $map, 'deadline');

            $nama    = $this->singleLine(self::cellText($rawNama));
            $project = $this->singleLine(self::cellText($rawProject));
            $desc    = trim(str_replace(["\r\n", "\r"], "\n", self::cellText($rawDesc)));

            if ($nama === '' && $project === '' && $desc === ''
                && self::isBlank($rawStart) && self::isBlank($rawDeadline)) {
                continue; // baris kosong
            }

            if (count($rows) + count($errors) >= self::MAX_ROWS) {
                throw new ProyekImportException(
                    'File berisi lebih dari ' . number_format(self::MAX_ROWS, 0, ',', '.') . ' baris data. Pecah menjadi beberapa file.'
                );
            }

            $problems = [];
            if ($nama === '') {
                $problems[] = 'Nama Client kosong';
            } elseif (mb_strlen($nama) > self::MAX_LENGTH) {
                $problems[] = 'Nama Client lebih dari ' . self::MAX_LENGTH . ' karakter';
            }
            if ($project === '') {
                $problems[] = 'Nama Project kosong';
            } elseif (mb_strlen($project) > self::MAX_LENGTH) {
                $problems[] = 'Nama Project lebih dari ' . self::MAX_LENGTH . ' karakter';
            }

            $start = self::parseDate($rawStart);
            if (self::isBlank($rawStart)) {
                $problems[] = 'Tanggal Mulai kosong';
            } elseif ($start === null) {
                $problems[] = 'Tanggal Mulai tidak valid ("' . mb_substr(self::cellText($rawStart), 0, 30) . '")';
            }

            $deadline = self::parseDate($rawDeadline);
            if (self::isBlank($rawDeadline)) {
                $problems[] = 'Deadline kosong';
            } elseif ($deadline === null) {
                $problems[] = 'Deadline tidak valid ("' . mb_substr(self::cellText($rawDeadline), 0, 30) . '")';
            }

            if ($start !== null && $deadline !== null && $deadline < $start) {
                $problems[] = 'Deadline lebih awal dari Tanggal Mulai';
            }

            if ($problems) {
                $errors[] = ['row' => $excelRow, 'message' => implode('; ', $problems)];
                continue;
            }

            $rows[] = [
                'row'          => $excelRow,
                'nama'         => $nama,
                'project'      => $project,
                'deskripsi'    => self::textToHtml($desc),
                'tanggal_awal' => $start,
                'deadline'     => $deadline,
            ];
        }

        return ['rows' => $rows, 'errors' => $errors];
    }

    /**
     * Memisahkan baris baru dan baris yang sudah ada (duplikat).
     * Duplikat = Nama Client + Nama Project + Tanggal Mulai sama (tanpa membedakan huruf besar/kecil).
     *
     * @param array $rows          hasil parse()['rows']
     * @param array $existingKeys  daftar dedupeKey() dari data yang sudah ada di database
     *
     * @return array{new: array<int, array>, skipped: int}
     */
    public function planImport(array $rows, array $existingKeys): array
    {
        $seen    = array_fill_keys($existingKeys, true);
        $new     = [];
        $skipped = 0;

        foreach ($rows as $row) {
            $key = self::dedupeKey($row['nama'], $row['project'], $row['tanggal_awal']);
            if (isset($seen[$key])) {
                $skipped++;
                continue;
            }
            $seen[$key] = true;
            $new[] = [
                'nama'         => $row['nama'],
                'project'      => $row['project'],
                'deskripsi'    => $row['deskripsi'],
                'tanggal_awal' => $row['tanggal_awal'],
                'deadline'     => $row['deadline'],
            ];
        }

        return ['new' => $new, 'skipped' => $skipped];
    }

    public static function dedupeKey($nama, $project, $tanggalAwal): string
    {
        $date = self::toDateTime($tanggalAwal);

        return mb_strtolower(trim((string) $nama)) . '|' . mb_strtolower(trim((string) $project)) . '|' . ($date ? $date->format('Y-m-d') : '');
    }

    /* =====================================================================
     * Konversi teks <-> HTML (kolom deskripsi di aplikasi berisi HTML dari editor)
     * ===================================================================== */

    /** HTML dari editor -> teks biasa yang enak dibaca di sel Excel. */
    public static function htmlToPlain(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $t = $html;
        // Gambar (biasanya base64 dan sangat besar) diganti penanda saja.
        $t = self::regex('/<img\b[^>]*>/i', ' [gambar] ', $t);
        $t = self::regex('/<(script|style)\b.*?<\/\1>/is', '', $t);
        $t = self::regex('/<\s*br\s*\/?>/i', "\n", $t);
        $t = self::regex('/<\s*li\b[^>]*>/i', "\n• ", $t);
        $t = self::regex('/<\/\s*(p|div|h[1-6]|ul|ol|blockquote|tr)\s*>/i', "\n", $t);
        $t = strip_tags($t);
        $t = html_entity_decode($t, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $t = str_replace(["\r\n", "\r", "\xC2\xA0"], ["\n", "\n", ' '], $t);
        $t = self::regex('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $t);
        $t = self::regex('/[ \t]+\n/', "\n", $t);
        $t = self::regex('/\n{3,}/', "\n\n", $t);
        $t = trim($t);

        // Batas isi satu sel Excel adalah 32.767 karakter.
        return mb_strlen($t) > 32000 ? mb_substr($t, 0, 32000) : $t;
    }

    /** Teks biasa dari Excel -> HTML aman (di-escape) untuk disimpan di kolom deskripsi. */
    public static function textToHtml(string $text): string
    {
        if ($text === '') {
            return '';
        }

        return nl2br(htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'), false);
    }

    /* =====================================================================
     * Tanggal
     * ===================================================================== */

    /**
     * Sel Excel/teks -> 'Y-m-d', atau null jika tidak valid.
     * Mengenali tanggal Excel asli, 2026-03-15, 15/03/2026, 15-03-2026, 15 Mar 2026, 15 Maret 2026.
     *
     * @param mixed $value
     */
    public static function parseDate($value): ?string
    {
        if (self::isBlank($value)) {
            return null;
        }
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        if (is_int($value) || is_float($value)) {
            $n = (float) $value;
            if ($n >= 19000101 && $n <= 21001231) {           // 20260315
                return self::validYmd((int) substr((string) (int) $n, 0, 4), (int) substr((string) (int) $n, 4, 2), (int) substr((string) (int) $n, 6, 2));
            }
            if ($n < 1 || $n > 2958465) {
                return null;
            }

            return ExcelDate::excelToDateTimeObject($n)->format('Y-m-d');  // tanggal asli Excel (serial number)
        }

        $s = trim((string) $value);
        if (preg_match('/^(\d{4})[-\/.](\d{1,2})[-\/.](\d{1,2})(?:[ T].*)?$/', $s, $m)) {
            return self::validYmd((int) $m[1], (int) $m[2], (int) $m[3]);
        }
        if (preg_match('/^(\d{1,2})[-\/.](\d{1,2})[-\/.](\d{4})(?:[ T].*)?$/', $s, $m)) {
            return self::validYmd((int) $m[3], (int) $m[2], (int) $m[1]);       // hari/bulan/tahun
        }
        if (preg_match('/^(\d{1,2})[\s\-\/.]+([A-Za-z]+)\.?[\s\-\/.,]+(\d{4})$/', $s, $m)) {
            $month = self::MONTH_LOOKUP[strtolower($m[2])] ?? null;

            return $month ? self::validYmd((int) $m[3], $month, (int) $m[1]) : null;
        }
        if (preg_match('/^\d{8}$/', $s)) {
            return self::validYmd((int) substr($s, 0, 4), (int) substr($s, 4, 2), (int) substr($s, 6, 2));
        }

        return null;
    }

    private static function validYmd(int $y, int $m, int $d): ?string
    {
        if ($y < 1900 || $y > 2100 || !checkdate($m, $d, $y)) {
            return null;
        }

        return sprintf('%04d-%02d-%02d', $y, $m, $d);
    }

    /** @param mixed $value */
    private static function toDateTime($value): ?DateTimeImmutable
    {
        if ($value === null || $value === '') {
            return null;
        }
        try {
            $text = $value instanceof DateTimeInterface ? $value->format('Y-m-d') : (string) $value;

            return (new DateTimeImmutable($text))->setTime(0, 0, 0);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function indoDateTime(DateTimeImmutable $d): string
    {
        return $d->format('j') . ' ' . self::MONTHS_ID[(int) $d->format('n')] . ' ' . $d->format('Y') . ', ' . $d->format('H:i');
    }

    /* =====================================================================
     * Helper styling
     * ===================================================================== */

    private function newBook(string $title): Spreadsheet
    {
        $book = new Spreadsheet();
        $book->getProperties()
            ->setCreator('Astabrata Teknologi')
            ->setCompany('Astabrata Teknologi')
            ->setTitle($title);
        $book->getDefaultStyle()->getFont()->setName(self::FONT)->setSize(10);

        return $book;
    }

    /** Cetak: A4 landscape, lebar muat 1 halaman, baris judul diulang di setiap halaman, nomor halaman di footer. */
    private function applyPrintSetup(Worksheet $sheet, int $headerRow): void
    {
        $page = $sheet->getPageSetup();
        $page->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $page->setPaperSize(PageSetup::PAPERSIZE_A4);
        $page->setFitToPage(true);
        $page->setFitToWidth(1);
        $page->setFitToHeight(0);
        $page->setHorizontalCentered(true);
        $page->setRowsToRepeatAtTopByStartAndEnd($headerRow, $headerRow);
        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.6)->setLeft(0.4)->setRight(0.4);
        $sheet->getHeaderFooter()->setOddFooter('&L&8Astabrata Teknologi&C&8Halaman &P dari &N&R&8&D');
    }

    private function styleHeader(Worksheet $sheet, string $range): void
    {
        $style = $sheet->getStyle($range);
        $style->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB(self::C_PRIMARY);
        $style->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true)->setIndent(1);
        $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setARGB(self::C_PRIMARY);
    }

    private function condition(string $formula, ?string $fontArgb, ?string $fillArgb, bool $bold = false): Conditional
    {
        $c = new Conditional();
        $c->setConditionType(Conditional::CONDITION_EXPRESSION);
        $c->addCondition($formula);

        $style = $c->getStyle();
        if ($fontArgb !== null) {
            $style->getFont()->getColor()->setARGB($fontArgb);
        }
        if ($bold) {
            $style->getFont()->setBold(true);
        }
        if ($fillArgb !== null) {
            $style->getFill()->setFillType(Fill::FILL_SOLID);
            $style->getFill()->getStartColor()->setARGB($fillArgb);
            $style->getFill()->getEndColor()->setARGB($fillArgb);
        }

        return $c;
    }

    private function addDateValidation(Worksheet $sheet, string $range, string $title, string $prompt): void
    {
        $min = (string) (int) ExcelDate::PHPToExcel(new DateTimeImmutable('2000-01-01'));
        $max = (string) (int) ExcelDate::PHPToExcel(new DateTimeImmutable('2100-12-31'));

        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_DATE);
        $dv->setOperator(DataValidation::OPERATOR_BETWEEN);
        $dv->setFormula1($min);
        $dv->setFormula2($max);
        $dv->setAllowBlank(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setErrorStyle(DataValidation::STYLE_STOP);
        $dv->setPromptTitle($title);
        $dv->setPrompt($prompt);
        $dv->setErrorTitle('Tanggal tidak valid');
        $dv->setError('Isi dengan tanggal yang valid, contoh: 15/03/2026.');

        $sheet->setDataValidation($range, $dv);
    }

    /** Teks selalu ditulis sebagai string murni, jadi isi seperti "=SUM(A1)" tidak pernah dijalankan sebagai rumus. */
    private function setText(Worksheet $sheet, string $cell, string $value): void
    {
        $value = self::regex('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $value);
        if ($value === '') {
            return;
        }
        if (mb_strlen($value) > 32000) {
            $value = mb_substr($value, 0, 32000);
        }
        $sheet->setCellValueExplicit($cell, $value, DataType::TYPE_STRING);
    }

    /** @param mixed $value */
    private function setDate(Worksheet $sheet, string $cell, $value): void
    {
        $date = self::toDateTime($value);
        if ($date === null) {
            return;
        }
        $sheet->setCellValue($cell, ExcelDate::PHPToExcel($date));
    }

    /**
     * Tinggi baris diperkirakan dari panjang teks (maksimal 10 baris teks).
     * Teks yang lebih panjang tetap utuh di dalam sel, hanya tampilannya dipotong supaya tabel tetap rapi.
     */
    private function estimateRowHeight(string $nama, string $project, string $desc): float
    {
        $lines = max(
            $this->countLines($nama, 25),
            $this->countLines($project, 30),
            $this->countLines($desc, 62)
        );

        return (float) max(21, min($lines, 10) * 12.75 + 8);
    }

    private function countLines(string $text, int $charsPerLine): int
    {
        if ($text === '') {
            return 1;
        }
        $n = 0;
        foreach (explode("\n", $text) as $line) {
            $n += max(1, (int) ceil(mb_strlen($line) / $charsPerLine));
        }

        return $n;
    }

    /** Ambil nilai dari model Eloquent, objek, atau array dengan cara yang sama. */
    private static function attr($item, string $key)
    {
        if (is_array($item)) {
            return $item[$key] ?? null;
        }

        return $item->{$key} ?? null;
    }

    /* =====================================================================
     * Helper import
     * ===================================================================== */

    /** @return array{0:int, 1:array<string,int>} [indeks baris judul, peta kolom] */
    /** Menebak pemisah kolom CSV (koma, titik koma, atau tab) dari baris pertama file. */
    private function detectCsvDelimiter(string $path): string
    {
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return ',';
        }

        $firstLine = fgets($handle) ?: '';
        fclose($handle);

        // Buang BOM UTF-8 kalau ada, supaya tidak ikut terhitung sebagai karakter aneh.
        $firstLine = preg_replace('/^\xEF\xBB\xBF/', '', $firstLine);

        $candidates = [',' => 0, ';' => 0, "\t" => 0];
        foreach (array_keys($candidates) as $delim) {
            $candidates[$delim] = substr_count($firstLine, $delim);
        }
        arsort($candidates);
        $best = array_key_first($candidates);

        // Kalau baris pertama tidak mengandung pemisah sama sekali, default ke koma.
        return $candidates[$best] > 0 ? $best : ',';
    }

    /** Menebak encoding file CSV (Excel Windows biasanya menyimpan sebagai Windows-1252, bukan UTF-8). */
    private function detectCsvEncoding(string $path): string
    {
        $sample = file_get_contents($path, false, null, 0, 8192) ?: '';

        if (str_starts_with($sample, "\xEF\xBB\xBF")) {
            return 'UTF-8';
        }
        if (str_starts_with($sample, "\xFF\xFE") || str_starts_with($sample, "\xFE\xFF")) {
            return 'UTF-16';
        }

        return mb_check_encoding($sample, 'UTF-8') ? 'UTF-8' : 'Windows-1252';
    }

    private function findHeader(array $grid): array
    {
        $limit = min(count($grid), 15);
        for ($i = 0; $i < $limit; $i++) {
            $map = [];
            foreach ($grid[$i] as $col => $cell) {
                $key = $this->headerKey(self::cellText($cell));
                if ($key !== null && !isset($map[$key])) {
                    $map[$key] = $col;
                }
            }
            if (isset($map['nama'], $map['project'])) {
                $missing = [];
                foreach (['tanggal_awal', 'deadline'] as $need) {
                    if (!isset($map[$need])) {
                        $missing[] = self::HEADER_LABELS[$need];
                    }
                }
                if ($missing) {
                    throw new ProyekImportException('Kolom ' . implode(' dan ', $missing) . ' tidak ditemukan. Gunakan template dari tombol Import Excel.');
                }

                return [$i, $map];
            }
        }

        throw new ProyekImportException('Judul kolom tidak ditemukan. Baris judul harus memuat "Nama Client" dan "Nama Project". Gunakan template dari tombol Import Excel.');
    }

    private function headerKey(string $text): ?string
    {
        $norm = preg_replace('/[^a-z0-9]/', '', mb_strtolower(trim($text)));
        if ($norm === '' || $norm === null) {
            return null;
        }
        foreach (self::HEADER_ALIASES as $key => $aliases) {
            if (in_array($norm, $aliases, true)) {
                return $key;
            }
        }

        return null;
    }

    /** @return mixed */
    private function cellFrom(array $line, array $map, string $key)
    {
        return isset($map[$key]) ? ($line[$map[$key]] ?? null) : null;
    }

    /** @param mixed $value */
    private static function cellText($value): string
    {
        if ($value === null || is_bool($value)) {
            return '';
        }
        if (is_float($value)) {
            if ($value == floor($value) && abs($value) < 1e15) {
                return (string) (int) $value;
            }

            return rtrim(rtrim(sprintf('%.10F', $value), '0'), '.');
        }

        return (string) $value;   // RichText punya __toString
    }

    /** @param mixed $value */
    private static function isBlank($value): bool
    {
        return $value === null || (is_string($value) && trim($value) === '');
    }

    private function singleLine(string $text): string
    {
        $text = self::regex('/\s+/u', ' ', $text);

        return trim($text);
    }

    /** preg_replace yang tidak pernah mengembalikan null (mis. karena teks bukan UTF-8 valid). */
    private static function regex(string $pattern, string $replacement, string $subject): string
    {
        $result = preg_replace($pattern, $replacement, $subject);

        return $result === null ? $subject : $result;
    }
}