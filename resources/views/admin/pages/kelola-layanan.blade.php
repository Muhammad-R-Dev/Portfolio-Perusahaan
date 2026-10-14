@extends('admin.layouts.app')

@section('title', 'Kelola Layanan | Admin Astabrata Teknologi')
@section('page-title', 'Kelola Layanan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
        #content main .head-title .btn-download {
            height: 36px;
            padding: 0 16px;
            border-radius: 36px;
            background: var(--blue);
            color: var(--light);
            display: flex;
            justify-content: center;
            align-items: center;
            grid-gap: 10px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            font-family: var(--poppins);
            font-size: 14px;
        }

        #content main .box-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            grid-gap: 24px;
            margin-top: 36px;
        }
        #content main .box-info li {
            padding: 24px;
            background: var(--light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            grid-gap: 24px;
        }
        #content main .box-info li .bx {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            font-size: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #content main .box-info li:nth-child(1) .bx {
            background: var(--light-blue);
            color: var(--blue);
        }
        #content main .box-info li:nth-child(2) .bx {
            background: var(--light-yellow);
            color: var(--yellow);
        }
        #content main .box-info li:nth-child(3) .bx {
            background: var(--light-orange);
            color: var(--orange);
        }
        #content main .box-info li .text h3 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }
        #content main .box-info li .text p {
            color: var(--dark); 
        }

        #content main .table-data {
            display: flex;
            flex-wrap: wrap;
            grid-gap: 24px;
            margin-top: 24px;
            width: 100%;
            color: var(--dark);
        }
        #content main .table-data > div {
            border-radius: 20px;
            background: var(--light);
            padding: 24px;
            overflow-x: auto;
        }
        #content main .table-data .head {
            display: flex;
            align-items: center;
            grid-gap: 16px;
            margin-bottom: 24px;
        }
        #content main .table-data .head h3 {
            margin-right: auto;
            font-size: 24px;
            font-weight: 600;
        }
        #content main .table-data .head .bx {
            cursor: pointer;
        }

        /* TOOLBAR PENCARIAN & FILTER */
        #content main .table-data .head .table-toolbar {
            display: flex;
            align-items: center;
            grid-gap: 10px;
            flex-wrap: wrap;
        }
        #content main .table-data .head .search-box {
            display: flex;
            align-items: center;
            grid-gap: 8px;
            background: var(--grey);
            border-radius: 36px;
            padding: 0 16px;
            height: 38px;
        }
        #content main .table-data .head .search-box .bx {
            font-size: 16px;
            color: var(--dark-grey);
            cursor: default;
        }
        #content main .table-data .head .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-family: var(--poppins);
            font-size: 13px;
            color: var(--dark);
            width: 200px;
        }
        #content main .table-data .head select.filter-select {
            height: 38px;
            padding: 0 14px;
            border-radius: 36px;
            border: none;
            background: var(--grey);
            color: var(--dark);
            font-family: var(--poppins);
            font-size: 13px;
            outline: none;
            cursor: pointer;
        }
        #content main .table-data .order table .no-result-row td {
            text-align: center;
            padding: 32px 0;
            color: var(--dark-grey);
        }

        #content main .table-data .order {
            width: 100%;
            flex-grow: 1;
            flex-basis: 100%;
        }
        #content main .table-data .order table {
            width: 100%;
            border-collapse: collapse;
        }
        #content main .table-data .order table th {
            padding-bottom: 12px;
            font-size: 13px;
            text-align: left;
            border-bottom: 1px solid var(--grey);
        }
        #content main .table-data .order table td {
            padding: 16px 0;
        }
        #content main .table-data .order table tr td.col-layanan {
            display: flex;
            align-items: center;
            grid-gap: 12px;
            padding-left: 6px;
        }
        #content main .table-data .order table td img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
        }
        #content main .table-data .order table td img.table-thumb {
            cursor: zoom-in;
            transition: opacity .15s ease, transform .15s ease;
        }
        #content main .table-data .order table td img.table-thumb:hover {
            opacity: .8;
            transform: scale(1.05);
        }
        #content main .table-data .order table tbody tr:hover {
            background: var(--grey);
        }
        #content main .table-data .order table tr td .status {
            font-size: 10px;
            padding: 6px 16px;
            color: var(--light);
            border-radius: 20px;
            font-weight: 700;
        }
        #content main .table-data .order table tr td .status.completed {
            background: var(--blue);
        }
        #content main .table-data .order table tr td .status.process {
            background: var(--yellow);
        }
        #content main .table-data .order table tr td .status.pending {
            background: var(--orange);
        }

        #content main .table-data .order table td .desc-kategori {
            font-weight: 500;
            color: var(--dark);
        }
        #content main .table-data .order table td .desc-harga {
            font-size: 13px;
            color: var(--dark-grey);
        }
        #content main .table-data .order table td.aksi {
            display: flex;
            align-items: center;
            grid-gap: 8px;
        }
        #content main .table-data .order table td.aksi form {
            display: inline-flex;
            margin: 0;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-icon.btn-edit {
            background: var(--light-blue);
            color: var(--blue);
        }
        .btn-icon.btn-delete {
            background: var(--light-orange);
            color: var(--red);
        }
        #content main .table-data .aksi .btn-edit-text {
            border: none;
            cursor: pointer;
            font-family: var(--poppins);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            background: var(--blue);
            color: var(--light);
        }

        /* TOMBOL MODE PILIH (HAPUS) & HAPUS TERPILIH - sama seperti Kelola Galeri */
        #content main .table-data .btn-select-mode,
        #content main .table-data .btn-bulk-delete {
            height: 38px;
            padding: 0 16px;
            border-radius: 36px;
            border: none;
            cursor: pointer;
            font-family: var(--poppins);
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            grid-gap: 6px;
            transition: all .2s ease;
            white-space: nowrap;
        }
        #content main .table-data .btn-select-mode {
            background: var(--red);
            color: var(--light);
        }
        #content main .table-data .btn-select-mode:hover {
            opacity: .9;
        }
        #content main .table-data .btn-select-mode.active {
            background: var(--dark);
            color: var(--light);
        }
        #content main .table-data .bulk-actions-group {
            display: none;
            align-items: center;
            grid-gap: 10px;
        }
        #content main .table-data .bulk-actions-group.show {
            display: flex;
        }
        #content main .table-data .btn-bulk-delete {
            background: var(--light-orange);
            color: var(--red);
        }
        #content main .table-data .btn-bulk-delete:hover:not(:disabled) {
            background: var(--red);
            color: var(--light);
        }
        #content main .table-data .btn-bulk-delete:disabled {
            opacity: .5;
            cursor: not-allowed;
        }
        #content main .table-data th#layananAksiHeader.select-mode-header {
            display: flex;
            align-items: center;
            grid-gap: 8px;
        }
        #content main .table-data td.select-cell {
            text-align: left;
        }
        #content main .table-data th input[type="checkbox"],
        #content main .table-data td.select-cell input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--blue);
        }
        #content main .table-data tbody tr.row-selected {
            background: var(--light-blue);
        }

        /* PAGINASI HALAMAN */
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            flex-wrap: wrap;
            grid-gap: 12px;
        }
        .pagination-info {
            font-size: 13px;
            color: var(--dark-grey);
        }
        .pagination-controls {
            display: flex;
            align-items: center;
            grid-gap: 6px;
            flex-wrap: wrap;
        }
        .pagination-btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid var(--grey);
            background: var(--light);
            color: var(--dark);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            font-family: var(--poppins);
        }
        .pagination-btn:hover:not(:disabled) {
            background: var(--grey);
        }
        .pagination-btn.active {
            background: var(--blue);
            color: var(--light);
            border-color: var(--blue);
        }
        .pagination-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        /* MODAL FORM LAYANAN */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 5000;
            justify-content: center;
            align-items: center;
            padding: 16px;
            box-sizing: border-box;
        }
        .modal-overlay.show {
            display: flex;
        }
        .modal-box {
            background: var(--light);
            border-radius: 16px;
            padding: 40px;
            width: 100%;
            max-width: 900px;
            max-height: 92vh;
            overflow-y: auto;
            font-family: var(--poppins);
        }
        .modal-box .modal-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .modal-box .modal-head h3 {
            font-size: 22px;
            font-weight: 600;
            color: var(--dark);
        }
        .modal-box .modal-head .bx {
            cursor: pointer;
            font-size: 22px;
            color: var(--dark);
        }
        .modal-box .form-group {
            margin-bottom: 16px;
            display: flex;
            flex-direction: column;
            grid-gap: 6px;
        }
        .modal-box .form-group label {
            font-size: 13px;
            color: var(--dark);
            font-weight: 500;
        }
        .modal-box .form-group input,
        .modal-box .form-group select,
        .modal-box .form-group textarea {
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid var(--grey);
            background: var(--grey);
            color: var(--dark);
            outline: none;
            font-family: var(--poppins);
            font-size: 15px;
        }
        .modal-box .modal-actions {
            display: flex;
            justify-content: flex-end;
            grid-gap: 12px;
            margin-top: 8px;
        }
        .modal-box .btn-cancel,
        .modal-box .btn-save {
            padding: 10px 20px;
            border-radius: 36px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            font-family: var(--poppins);
        }
        .modal-box .btn-cancel {
            background: var(--red);
            color: var(--light);
        }
        .modal-box .btn-save {
            background: var(--blue);
            color: var(--light);
        }

        /* ============================================================
           FORM TAMBAH/EDIT LAYANAN DIPERBESAR (seperti Kelola Blog)
           ============================================================ */
        body.chb-modal-open { overflow: hidden; }
        #modalLayanan {
            padding: 32px;
            align-items: stretch;
            box-sizing: border-box;
        }
        #modalLayanan .modal-box {
            max-width: none;
            width: 100%;
            height: 100%;
            max-height: none;
            padding: 28px 40px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }
        #modalLayanan .modal-head { flex-shrink: 0; }
        #modalLayanan .modal-box form { flex: 1; min-height: 0; display: flex; flex-direction: column; }
        #modalLayanan .form-cols {
            flex: 1;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            align-items: stretch;
            grid-gap: 32px;
            margin-bottom: 0;
        }
        #modalLayanan .form-cols .col-text { flex: 1 1 58%; display: flex; flex-direction: column; min-width: 260px; }
        #modalLayanan .form-cols .col-image { flex: 1 1 38%; display: flex; flex-direction: column; min-width: 220px; }
        #modalLayanan .form-cols .col-text .form-group:last-child { flex: 1; margin-bottom: 0; }
        #modalLayanan .form-cols .col-text .form-group textarea { flex: 1; min-height: 240px; resize: none; }
        #modalLayanan .uploader { min-height: 340px; }
        #modalLayanan .uploader-preview img { height: 340px; }
        /* Tombol Batal/Simpan tetap di bawah, tidak ikut ter-scroll */
        #modalLayanan .modal-actions {
            flex-shrink: 0;
            margin: 16px -40px -28px -40px;
            padding: 16px 40px;
            border-top: 1px solid var(--grey);
            background: var(--light);
            border-radius: 0 0 16px 16px;
        }
        @media screen and (max-width: 768px) {
            #modalLayanan { padding: 12px; }
            #modalLayanan .modal-box { padding: 20px 16px; }
            #modalLayanan .form-cols { grid-gap: 16px; }
            #modalLayanan .modal-actions { margin: 14px -16px -20px -16px; padding: 14px 16px; }
        }

        /* MODAL KONFIRMASI & NOTIFIKASI */
        .modal-box.modal-confirm {
            max-width: 380px;
            text-align: center;
            padding: 36px 28px;
        }
        .modal-box.modal-confirm .confirm-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 34px;
            background: var(--light-orange);
            color: var(--red);
        }
        .modal-box.modal-confirm .confirm-icon.success {
            background: var(--light-blue);
            color: var(--blue);
        }
        .modal-box.modal-confirm h2 {
            margin-bottom: 8px;
            color: var(--dark);
        }
        .modal-box.modal-confirm p {
            color: var(--dark-grey);
            font-size: 14px;
            margin: 0;
        }
        .modal-box.modal-confirm .modal-actions {
            justify-content: center;
            margin-top: 24px;
        }
        .modal-box .btn-danger {
            padding: 10px 20px;
            border-radius: 36px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            font-family: var(--poppins);
            background: var(--red);
            color: var(--light);
        }

        /* ============================================================
           DARK MODE - TOMBOL TETAP KONTRAS (TIDAK PUTIH POLOS)
           ============================================================ */

        /* Tombol "Tambah Layanan" tetap biru, tulisan putih */
        body.dark #content main .head-title .btn-download,
        body.dark #content main .head-title .btn-download:hover {
            background: var(--blue) !important;
            color: #fff !important;
        }

        /* Tombol "Edit" (ikon & teks) tetap kontras */
        body.dark .btn-icon.btn-edit {
            background: var(--light-blue) !important;
            color: var(--blue) !important;
        }
        body.dark .btn-icon.btn-delete {
            background: var(--light-orange) !important;
            color: var(--red) !important;
        }
        body.dark #content main .table-data .aksi .btn-edit-text,
        body.dark #content main .table-data .aksi .btn-edit-text:hover {
            background: var(--blue) !important;
            color: #fff !important;
        }

        /* Tombol "Hapus" (mode pilih & hapus terpilih) tetap kontras */
        body.dark #content main .table-data .btn-select-mode {
            background: var(--red) !important;
            color: #fff !important;
        }
        /* Tombol berubah jadi "Batal" saat mode pilih aktif -> warna kuning */
        body.dark #content main .table-data .btn-select-mode.active {
            background: var(--yellow) !important;
            color: #1a1a1a !important;
        }
        /* Tombol "Hapus (n)" di sebelahnya -> merah polos, tanpa efek hover ganti warna lagi */
        body.dark #content main .table-data .btn-bulk-delete,
        body.dark #content main .table-data .btn-bulk-delete:hover:not(:disabled) {
            background: var(--red) !important;
            color: #fff !important;
        }

        /* Tombol "Batal" tetap merah, tulisan putih */
        body.dark .modal-box .btn-cancel,
        body.dark .modal-box .btn-cancel:hover {
            background: var(--red) !important;
            color: #fff !important;
        }

        /* Tombol "Simpan" tetap biru, tulisan putih */
        body.dark .modal-box .btn-save,
        body.dark .modal-box .btn-save:hover {
            background: var(--blue) !important;
            color: #fff !important;
        }

        /* Tombol "Ya, Hapus" di modal konfirmasi tetap merah, tulisan putih */
        body.dark .modal-box .btn-danger,
        body.dark .modal-box .btn-danger:hover {
            background: var(--red) !important;
            color: #fff !important;
        }

        .modal-box .form-cols {
            display: flex;
            flex-wrap: wrap;
            grid-gap: 16px;
            margin-bottom: 4px;
        }
        .modal-box .form-cols .col-text {
            flex: 1 1 58%;
            min-width: 260px;
        }
        .modal-box .form-cols .col-image {
            flex: 1 1 38%;
            min-width: 220px;
        }
        .modal-box .form-cols .col-text .form-group textarea {
            min-height: 200px;
            resize: vertical;
        }
        .modal-box .uploader {
            position: relative;
            border: 2px dashed var(--grey);
            border-radius: 12px;
            background: var(--grey);
            min-height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color .2s ease;
            overflow: hidden;
        }
        .modal-box .uploader.dragover {
            border-color: var(--blue);
        }
        .modal-box .uploader-empty {
            text-align: center;
            color: var(--dark-grey);
            padding: 20px;
        }
        .modal-box .uploader-shape {
            width: 128px;
            aspect-ratio: 4 / 3;
            margin: 0 auto 10px;
            border: 2px dashed var(--blue);
            border-radius: 8px;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-box .uploader-shape .bx {
            font-size: 28px;
            color: var(--blue);
            margin: 0;
        }
        .modal-box .uploader-empty p {
            margin: 6px 0 2px;
            font-size: 13px;
            font-weight: 500;
            color: var(--dark);
        }
        .modal-box .uploader-empty span {
            font-size: 11px;
            color: var(--dark-grey);
        }
        .modal-box .uploader-empty .uploader-size-hint {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            font-weight: 600;
            color: var(--blue);
        }
        .modal-box .uploader-preview {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .modal-box .uploader-preview img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }
        .modal-box .uploader-actions {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            grid-gap: 6px;
        }
        .modal-box .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, 0.55);
            color: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
        }
        .modal-box .btn-icon:hover {
            background: rgba(0, 0, 0, 0.8);
        }
        .modal-box .btn-icon.btn-remove:hover {
            background: var(--red);
        }

        /* LIGHTBOX ZOOM GAMBAR */
        .image-zoom-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .8);
            z-index: 6000;
            justify-content: center;
            align-items: center;
            padding: 32px 16px;
        }
        .image-zoom-overlay.show {
            display: flex;
        }
        .image-zoom-overlay .image-zoom-inner {
            position: relative;
            display: inline-flex;
            max-width: 100%;
            max-height: 85vh;
        }
        .image-zoom-overlay img {
            display: block;
            max-width: 100%;
            max-height: 85vh;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,.4);
        }
        .image-zoom-overlay .image-zoom-close {
            position: absolute;
            top: -16px;
            right: -16px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--red);
            color: #fff;
            font-size: 26px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
        }
        .image-zoom-overlay .image-zoom-close:hover {
            background: #c0392b;
        }

        /* ============================================================
           DARK MODE - PALET LEBIH TERANG & BERLAPIS (slate-navy)
           (sama seperti Kelola Proyek)
             halaman  #1b2538  <  kartu  #25324a  <  input/hover  #34456a
           Hanya berlaku di area konten & modal halaman ini (sidebar tidak diubah).
           ============================================================ */
        body.dark #content,
        body.dark #content main,
        body.dark .modal-overlay {
            --light: #25324a;          /* kartu, modal, header tabel */
            --grey: #34456a;           /* input, hover baris, border */
            --dark: #eef2f9;           /* teks utama */
            --dark-grey: #a9b8d2;      /* teks sekunder */
            --light-blue: #2f4a7a;     /* baris terpilih */
            --light-orange: #4d3b33;
            --blue: #4f8ef7;
            --red: #ef5a5a;
        }
        body.dark #content {
            background: #1b2538 !important;
        }
        body.dark #content main .table-data .order table tbody tr:hover {
            background: #2d3c5a !important;
        }
        body.dark .modal-box {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
        }
        body.dark .modal-box .uploader {
            border-color: #4a5f8a;
        }
        body.dark .modal-box .form-group input:focus,
        body.dark .modal-box .form-group select:focus,
        body.dark .modal-box .form-group textarea:focus {
            border-color: #4f8ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 142, 247, 0.25);
        }

        /* ============================================================
           LIGHT MODE - AREA BERLAPIS AGAR MUDAH DIBEDAKAN
             halaman  #e9eef5  <  kartu putih (+ border & bayangan)  <  input #f1f5f9
           ============================================================ */
        body:not(.dark) #content,
        body:not(.dark) #content main,
        body:not(.dark) .modal-overlay {
            --light: #ffffff;          /* kartu, modal, header tabel */
            --grey: #e2e8f0;           /* input, border */
            --dark: #1e293b;           /* teks utama */
            --dark-grey: #64748b;      /* teks sekunder */
            --light-blue: #dbeafe;     /* baris terpilih */
            --light-orange: #fee2e2;
        }
        body:not(.dark) #content {
            background: #e9eef5 !important;
        }
        body:not(.dark) #content main .box-info li,
        body:not(.dark) #content main .table-data > div {
            border: 1px solid #d5deea;
            box-shadow: 0 2px 8px rgba(30, 41, 59, 0.07);
        }
        body:not(.dark) #content main .table-data .order table tbody tr:hover {
            background: #f1f5f9;
        }
        body:not(.dark) .modal-box .form-group input,
        body:not(.dark) .modal-box .form-group select,
        body:not(.dark) .modal-box .form-group textarea {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        body:not(.dark) .modal-box .form-group input:focus,
        body:not(.dark) .modal-box .form-group select:focus,
        body:not(.dark) .modal-box .form-group textarea:focus {
            background: #fff;
            border-color: #3b82f6;
        }
        body:not(.dark) .modal-box .uploader {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        body:not(.dark) #modalLayanan .modal-actions {
            background: #f8fafc;
        }

        /* Media Query for Smaller Screens */
        @media screen and (max-width: 768px) {
            #content nav .notification-menu,
            #content nav .profile-menu {
                width: 180px;
            }
            #sidebar {
                width: 200px;
            }

            #content {
                width: calc(100% - 60px);
                left: 200px;
            }

            #content nav .nav-link {
                display: none;
            }
        }

        @media screen and (max-width: 576px) {
            #content nav .notification-menu,
            #content nav .profile-menu {
                width: 150px;
            }
            #content nav form .form-input input {
                display: none;
            }

            #content nav form .form-input button {
                width: auto;
                height: auto;
                background: transparent;
                border-radius: none;
                color: var(--dark);
            }

            #content nav form.show .form-input input {
                display: block;
                width: 100%;
            }

            #content nav form.show .form-input button {
                width: 36px;
                height: 100%;
                border-radius: 0 36px 36px 0;
                color: var(--light);
                background: var(--red);
            }

            #content nav form.show ~ .notification,
            #content nav form.show ~ .profile {
                display: none;
            }

            #content main .box-info {
                grid-template-columns: 1fr;
            }

            #content main .table-data .head {
                min-width: 420px;
            }
            #content main .table-data .order table {
                min-width: 420px;
            }

            .modal-box .form-cols {
                flex-direction: column;
            }
        }

		/* ===== Layout kartu daftar (seperti Kelola Proyek & Kelola Blog) ===== */
		#content main .head-title.page-header-fixed { position: fixed; z-index: 60; padding: 10px 0; margin: 0; }
		@media screen and (min-width: 769px) {
			#content main .table-data .order { isolation: isolate; padding: 0 24px 24px 24px; overflow-y: auto; overflow-x: hidden; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; }
			#content main .table-data .order .head {
				position: sticky; top: 0; z-index: 5; background: var(--light, #fff) !important; background-clip: padding-box;
				margin: 0 -24px 0 -24px; padding: 24px 24px 16px 24px;
			}
			#content main .table-data .order table thead th {
				position: sticky; top: var(--head-h, 0px); z-index: 4; background: var(--light, #fff) !important;
				background-clip: padding-box; box-shadow: 0 1px 0 var(--grey);
			}
		}

        /* Garis pembatas antar baris daftar (seperti daftar Tim) */
        #content main .table-data .order table thead th {
        	border-bottom: 1px solid var(--grey);
        }
        #content main .table-data .order table tbody tr:not(:last-child) td {
        	border-bottom: 1px solid var(--grey);
        }

        /* ===== Modal Crop Gambar ===== */
        .crop-modal-box {
            max-width: 560px;
            width: 92%;
        }
        .crop-modal-body { margin-bottom: 4px; }
        .crop-container {
            width: 100%;
            max-height: 420px;
            min-height: 260px;
            background: transparent;
            overflow: hidden;
            border-radius: 12px;
        }
        .crop-container img { display: block; max-width: 100%; }
        .crop-hint {
            margin-top: 10px;
            font-size: 12px;
            color: var(--dark-grey);
            text-align: center;
        }
        /* Crop lingkaran (dipakai khusus halaman Tim) */
        .crop-container.crop-circle .cropper-view-box,
        .crop-container.crop-circle .cropper-face {
            border-radius: 50%;
        }
        .crop-ratio-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 14px;
            justify-content: center;
        }
        .crop-ratio-btn {
            padding: 6px 16px;
            border-radius: 20px;
            border: 1px solid var(--grey);
            background: var(--light);
            cursor: pointer;
            font-size: 12px;
            font-family: var(--poppins);
            color: var(--dark);
            transition: .15s ease;
        }
        .crop-ratio-btn.active {
            background: var(--blue);
            color: var(--light);
            border-color: var(--blue);
        }
        /* Pastikan modal crop selalu tampil di DEPAN modal form tambah/edit */
        #cropModal { z-index: 6000; }
</style>
@endpush

@section('content')
            <div class="head-title">
                <div class="left">
                    <h1>Kelola Layanan</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Kelola Layanan</a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-download" onclick="openAddModal()">
                    <i class='bx bxs-plus-circle' ></i>
                    <span class="text">Tambah Layanan</span>
                </button>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Layanan</h3>
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class='bx bx-search'></i>
                                <input type="text" id="layananSearch" placeholder="Cari layanan...">
                            </div>
                            <select id="layananFilterGambar" class="filter-select">
                                <option value="">Semua Layanan</option>
                                <option value="ada">Ada Gambar</option>
                                <option value="tanpa">Tanpa Gambar</option>
                            </select>
                            <select id="layananLimit" class="filter-select">
                                <option value="semua">Semua Baris</option>
                                <option value="5">5 Baris</option>
                                <option value="10">10 Baris</option>
                                <option value="20">20 Baris</option>
                            </select>
                            <button type="button" class="btn-select-mode" id="btnToggleLayananSelectMode" onclick="toggleLayananSelectMode()">
                                <i class='bx bx-list-check'></i> <span id="btnToggleLayananSelectModeText">Hapus</span>
                            </button>
                            <div class="bulk-actions-group" id="layananBulkActionsGroup">
                                <button type="button" class="btn-bulk-delete" id="btnLayananBulkDelete" disabled onclick="confirmBulkDeleteLayanan()">
                                    <i class='bx bx-trash'></i> Hapus (<span id="layananBulkDeleteCount">0</span>)
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Form hapus tersembunyi (dipakai tombol Hapus Terpilih) -->
                    <div style="display:none;">
                        @foreach($services as $service)
                        <form id="deleteFormLayanan{{ $service->id }}" action="{{ route('admin.kelola-layanan.destroy', $service->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endforeach
                    </div>

                    <table id="layananTable">
                        <thead>
                            <tr>
                                <th style="width:48px; text-align:center;">No</th>
                                <th>Layanan</th>
                                <th>Deskripsi</th>
                                <th id="layananAksiHeader">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="layananTableBody">
                            @foreach($services as $service)
                            <tr class="layanan-row" data-id="{{ $service->id }}" data-title="{{ strtolower($service->title) }}" data-desc="{{ strtolower($service->description) }}" data-gambar="{{ $service->image ? 'ada' : 'tanpa' }}" data-status="{{ $service->status ?? 'aktif' }}">
                                <td style="text-align:center;">{{ $loop->iteration }}</td>
                                <td class="col-layanan">
                                    <img src="{{ $service->image_url }}" class="table-thumb" onclick="openTableImageZoom(this)">
                                    <p>{{ $service->title }}</p>
                                </td>
                                <td>
                                    <p class="desc-kategori">{{ Str::limit($service->description, 50) }}</p>
                                </td>
                                <td class="aksi action-cell">
                                    <button type="button" class="btn-edit-text"
                                        data-id="{{ $service->id }}"
                                        data-title="{{ $service->title }}"
                                        data-description="{{ $service->description }}"
                                        data-image="{{ $service->image ? $service->image_url : '' }}"
                                        onclick="openEditModalFromButton(this)">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            <tr class="no-result-row" id="layananNoResult" style="display:none;">
                                <td colspan="4">Data tidak ditemukan.</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- KONTROL PAGINASI HALAMAN (1, 2, dst.) -->
                    <div class="pagination-wrapper" id="layananPagination">
                        <div class="pagination-info" id="paginationInfo">
                            
                        </div>
                        <div class="pagination-controls" id="paginationControls">
                            <!-- Navigasi 1, 2, dst. di-generate secara dinamis oleh JS -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
        <div class="modal-overlay" id="modalLayanan">
            <div class="modal-box">
                <div class="modal-head">
                    <h3 id="modalLayananTitle">Tambah Layanan</h3>
                    <i class='bx bx-x' onclick="closeModalLayanan()"></i>
                </div>
                <form id="formLayanan" action="{{ route('admin.kelola-layanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="form-cols">
                        <div class="col-text">
                            <div class="form-group">
                                <label for="title">Judul Layanan <span class="required-mark" style="color:#e63946;">*</span></label>
                                <input type="text" id="title" name="title" placeholder="Masukkan judul layanan" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi <span class="required-mark" style="color:#e63946;">*</span></label>
                                <textarea id="description" name="description" rows="4" placeholder="Masukkan deskripsi layanan" required></textarea>
                            </div>
                        </div>
                        <div class="col-image">
                            <div class="form-group">
                                <label>Gambar <span class="required-mark" style="color:#e63946;">*</span></label>
                                <div class="uploader" id="uploaderBox">
                                    <div class="uploader-empty" id="uploaderEmpty">
                                        <div class="uploader-shape" aria-hidden="true">
                                            <i class='bx bx-image-add'></i>
                                        </div>
                                        <p>Klik atau seret gambar ke sini</p>
                                        <!-- Update keterangan format file -->
                                        <span>JPG, JPEG, JFIF, PNG, WEBP, GIF, BMP, AVIF, HEIC (maks. 5MB)</span>
                                        <span class="uploader-size-hint">Ukuran pas: 1000 × 750 px (rasio 4:3)</span>
                                    </div>
                                    <div class="uploader-preview" id="uploaderPreview" style="display:none;">
                                        <img src="" alt="Preview" id="imgPreview">
                                        <div class="uploader-actions">
                                            <button type="button" class="btn-icon btn-zoom" id="btnZoomImage" title="Perbesar Gambar">
                                                <i class='bx bx-fullscreen'></i>
                                            </button>
                                            <button type="button" class="btn-icon btn-remove" id="btnRemoveImage" title="Hapus Gambar">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- accept memakai image/* + ekstensi eksplisit agar JFIF, WEBP, HEIC, dll. bisa dipilih -->
                                    <input type="file" id="image" name="image" accept="image/*,.jpg,.jpeg,.jfif,.pjpeg,.pjp,.png,.webp,.gif,.bmp,.avif,.heic,.heif" hidden>
                                </div>
                                <input type="hidden" name="hapus_gambar" id="hapusGambarFlag" value="0">
                                <small id="uploaderNote" style="color: var(--dark-grey); font-size: 12px; margin-top: 4px; display: block;">Gambar wajib diisi. Saat edit, kosongkan jika tidak ingin mengganti gambar yang sudah ada.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeModalLayanan()">Batal</button>
                        <button type="submit" class="btn-save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Crop Gambar (rasio 4:3, mengikuti tampilan kartu layanan di halaman depan) -->
        <div class="modal-overlay" id="cropModal">
            <div class="modal-box crop-modal-box">
                <div class="modal-head">
                    <h3>Sesuaikan Gambar</h3>
                    <i class='bx bx-x' onclick="closeCropModal()"></i>
                </div>
                <div class="crop-modal-body">
                    <div class="crop-container" id="cropContainer">
                        <img id="cropImageEl" src="" alt="Crop gambar">
                    </div>
                    <p class="crop-hint">Geser &amp; perbesar untuk mengatur area gambar. Rasio mengikuti tampilan kartu layanan (4:3).</p>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeCropModal()">Batal</button>
                    <button type="button" class="btn btn-save" id="btnApplyCrop">Terapkan</button>
                </div>
            </div>
        </div>

        <!-- LIGHTBOX ZOOM GAMBAR -->
        <div class="image-zoom-overlay" id="imageZoomOverlay" onclick="closeImageZoomBackdrop(event)">
            <div class="image-zoom-inner">
                <img id="imageZoomImg" src="" alt="Preview diperbesar">
                <button type="button" class="image-zoom-close" onclick="closeImageZoom()">&times;</button>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div class="modal-overlay" id="deleteConfirmModal">
            <div class="modal-box modal-confirm">
                <div class="confirm-icon"><i class='bx bx-trash'></i></div>
                <h2 id="deleteConfirmTitle">Hapus Layanan?</h2>
                <p id="deleteConfirmText">Yakin ingin menghapus layanan ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" id="btnCancelDelete">Batal</button>
                    <button type="button" class="btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
                </div>
            </div>
        </div>

        <!-- Modal Notifikasi Sukses -->
        <div class="modal-overlay" id="successModal">
            <div class="modal-box modal-confirm">
                <div class="confirm-icon success"><i class='bx bx-check-circle'></i></div>
                <h2>Berhasil!</h2>
                <p id="successMessage"></p>
                <div class="modal-actions">
                    <button type="button" class="btn-save" id="btnCloseSuccess">OK</button>
                </div>
            </div>
        </div>

        <!-- Modal Notifikasi Error -->
        <div class="modal-overlay" id="errorModal">
            <div class="modal-box modal-confirm">
                <div class="confirm-icon"><i class='bx bx-error-circle'></i></div>
                <h2>Gagal!</h2>
                <p id="errorMessage" style="white-space:pre-line;"></p>
                <div class="modal-actions">
                    <button type="button" class="btn-save" id="btnCloseError">OK</button>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
        /* ============================================================
           MODAL CROP GAMBAR — pakai Cropper.js
           Rasio tetap 4:3 agar pas dengan tampilan kartu layanan di front-end.
           ============================================================ */
        (function () {
            const cropModal     = document.getElementById('cropModal');
            const cropContainer = document.getElementById('cropContainer');
            const cropImageEl   = document.getElementById('cropImageEl');
            const btnApplyCrop  = document.getElementById('btnApplyCrop');
            let cropper = null;
            let cropApplyCallback = null;
            let cropTargetInput = null;

            window.openCropModal = function (file, aspectRatio, inputEl, onApply, circle) {
                cropTargetInput = inputEl;
                cropApplyCallback = onApply;
                const reader = new FileReader();
                reader.onload = function (e) {
                    cropImageEl.src = e.target.result;
                    cropModal.classList.add('show');
                    cropContainer.classList.toggle('crop-circle', !!circle);
                    if (cropper) { cropper.destroy(); cropper = null; }
                    cropper = new Cropper(cropImageEl, {
                        aspectRatio: aspectRatio,
                        viewMode: 1,
                        autoCropArea: 1,
                        background: true,
                        responsive: true,
                        dragMode: 'move'
                    });
                };
                reader.readAsDataURL(file);
            };

            window.closeCropModal = function () {
                cropModal.classList.remove('show');
                if (cropper) { cropper.destroy(); cropper = null; }
                if (cropTargetInput) { cropTargetInput.value = ''; }
                cropTargetInput = null;
                cropApplyCallback = null;
            };

            btnApplyCrop.addEventListener('click', function () {
                if (!cropper || !cropApplyCallback) return;
                const canvas = cropper.getCroppedCanvas({ imageSmoothingQuality: 'high' });
                canvas.toBlob(function (blob) {
                    const croppedFile = new File([blob], 'layanan-' + Date.now() + '.jpg', { type: 'image/jpeg' });
                    const cb = cropApplyCallback;
                    const inputEl = cropTargetInput;
                    cropModal.classList.remove('show');
                    if (cropper) { cropper.destroy(); cropper = null; }
                    cropTargetInput = null;
                    cropApplyCallback = null;
                    cb(croppedFile, inputEl);
                }, 'image/jpeg', 0.92);
            });

            // Catatan: modal crop SENGAJA tidak ditutup saat klik di luar area kartu.
            // Pengguna harus menekan tombol "Batal" atau "Terapkan" untuk menutupnya.
        })();

        // ===== Menghitung Statistik Dinamis =====
        function updateLayananStats() {
            const rows = document.querySelectorAll('#layananTableBody .layanan-row');
            let total = rows.length;
            let aktif = 0;
            let nonaktif = 0;

            rows.forEach(row => {
                const status = row.dataset.status ? row.dataset.status.toLowerCase() : 'aktif';
                if (status === 'nonaktif' || status === '0' || status === 'inactive') {
                    nonaktif++;
                } else {
                    aktif++;
                }
            });

            document.getElementById('statTotalLayanan').textContent = total;
            document.getElementById('statLayananAktif').textContent = aktif;
            document.getElementById('statLayananNonaktif').textContent = nonaktif;
        }

        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateLayananStats();
            applyLayananFilters();
        });

        // ===== Pencarian, Filter & Paginasi Dinamis =====
        const layananSearchInput = document.getElementById('layananSearch');
        const layananFilterGambar = document.getElementById('layananFilterGambar');
        const layananLimit = document.getElementById('layananLimit');
        const layananNoResult = document.getElementById('layananNoResult');

        let currentPage = 1;

        function applyLayananFilters() {
            const keyword = layananSearchInput ? layananSearchInput.value.trim().toLowerCase() : '';
            const gambar = layananFilterGambar ? layananFilterGambar.value : '';
            const limitVal = layananLimit ? layananLimit.value : 'semua';
            
            const rows = Array.from(document.querySelectorAll('#layananTableBody .layanan-row'));
            
            // 1. Filter baris data
            const filteredRows = rows.filter(function (row) {
                const cocokKeyword = row.dataset.title.includes(keyword) || row.dataset.desc.includes(keyword);
                const cocokGambar = gambar === '' || row.dataset.gambar === gambar;
                return cocokKeyword && cocokGambar;
            });

            // Sembunyikan semua baris
            rows.forEach(row => row.style.display = 'none');

            const totalFiltered = filteredRows.length;

            if (totalFiltered === 0) {
                if (layananNoResult) layananNoResult.style.display = '';
                renderPagination(0, limitVal, 1, 1, 0, 0);
                return;
            } else {
                if (layananNoResult) layananNoResult.style.display = 'none';
            }

            // 2. Hitung jumlah halaman
            const isSemua = (limitVal === 'semua');
            const limit = isSemua ? totalFiltered : parseInt(limitVal);
            const totalPages = isSemua ? 1 : Math.ceil(totalFiltered / limit);

            // Validasi halaman aktif
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIndex = (currentPage - 1) * limit;
            const endIndex = Math.min(startIndex + limit, totalFiltered);

            // 3. Tampilkan data halaman aktif
            for (let i = startIndex; i < endIndex; i++) {
                if (filteredRows[i]) {
                    filteredRows[i].style.display = '';
                }
            }

            // 4. Render tombol paginasi
            renderPagination(totalFiltered, limitVal, currentPage, totalPages, startIndex + 1, endIndex);
        }

        function renderPagination(totalFiltered, limitVal, page, totalPages, start, end) {
            const paginationInfo = document.getElementById('paginationInfo');
            const paginationControls = document.getElementById('paginationControls');

            if (!paginationInfo || !paginationControls) return;

            if (totalFiltered === 0) {
                paginationInfo.textContent = 'Menampilkan 0 data';
                paginationControls.innerHTML = '';
                return;
            }

            paginationInfo.textContent = `Menampilkan ${start} - ${end} dari ${totalFiltered} data`;

            if (limitVal === 'semua' || totalPages <= 1) {
                paginationControls.innerHTML = '';
                return;
            }

            let html = '';

            // Tombol Sebelumnya (<)
            html += `<button type="button" class="pagination-btn" ${page === 1 ? 'disabled' : ''} onclick="changePage(${page - 1})"><i class='bx bx-chevron-left'></i></button>`;

            // Tombol Angka Halaman (1, 2, dst.)
            for (let i = 1; i <= totalPages; i++) {
                html += `<button type="button" class="pagination-btn ${i === page ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            }

            // Tombol Selanjutnya (>)
            html += `<button type="button" class="pagination-btn" ${page === totalPages ? 'disabled' : ''} onclick="changePage(${page + 1})"><i class='bx bx-chevron-right'></i></button>`;

            paginationControls.innerHTML = html;
        }

        function changePage(page) {
            currentPage = page;
            applyLayananFilters();
        }

        if (layananSearchInput) {
            layananSearchInput.addEventListener('input', function() {
                currentPage = 1;
                applyLayananFilters();
            });
        }
        if (layananFilterGambar) {
            layananFilterGambar.addEventListener('change', function() {
                currentPage = 1;
                applyLayananFilters();
            });
        }
        if (layananLimit) {
            layananLimit.addEventListener('change', function() {
                currentPage = 1;
                applyLayananFilters();
            });
        }

        const modalLayanan = document.getElementById('modalLayanan');
        const formLayanan  = document.getElementById('formLayanan');
        const modalLayananTitle = document.getElementById('modalLayananTitle');
        const imageZoomOverlay = document.getElementById('imageZoomOverlay');
        const imageZoomImg = document.getElementById('imageZoomImg');
        const hapusGambarFlag = document.getElementById('hapusGambarFlag');
        // Menandai apakah data yang sedang diedit sudah punya gambar tersimpan di server
        let currentImageExists = false;

        // Uploader elements
        const uploaderBox     = document.getElementById('uploaderBox');
        const uploaderEmpty   = document.getElementById('uploaderEmpty');
        const uploaderPreview = document.getElementById('uploaderPreview');
        const imgPreview      = document.getElementById('imgPreview');
        const inputImage      = document.getElementById('image');
        const btnRemoveImage  = document.getElementById('btnRemoveImage');
        const btnZoomImage    = document.getElementById('btnZoomImage');

        function resetUploader() {
            imgPreview.src = '';
            uploaderPreview.style.display = 'none';
            uploaderEmpty.style.display = 'block';
        }

        // Format gambar yang diizinkan (samakan dengan validasi di Controller)
        const ALLOWED_IMAGE_EXT = ['jpg','jpeg','jfif','pjpeg','pjp','png','webp','gif','bmp','avif','heic','heif'];
        const MAX_IMAGE_MB = 5;
        const uploaderNote = document.getElementById('uploaderNote');
        const uploaderNoteDefault = uploaderNote ? uploaderNote.textContent : '';

        function setUploaderNote(text, isError) {
            if (!uploaderNote) return;
            uploaderNote.textContent = text || uploaderNoteDefault;
            uploaderNote.style.color = isError ? '#e74c3c' : 'var(--dark-grey)';
        }

        // Cek ekstensi (bukan MIME, karena browser sering memberi MIME kosong untuk .jfif/.heic)
        function validateImageFile(file) {
            const ext = (file.name.split('.').pop() || '').toLowerCase();
            const isImageMime = file.type && file.type.indexOf('image/') === 0;
            if (!ALLOWED_IMAGE_EXT.includes(ext) && !isImageMime) {
                return 'Format .' + ext + ' tidak didukung. Gunakan: ' + ALLOWED_IMAGE_EXT.join(', ').toUpperCase() + '.';
            }
            if (file.size > MAX_IMAGE_MB * 1024 * 1024) {
                return 'Ukuran gambar maksimal ' + MAX_IMAGE_MB + 'MB.';
            }
            return null;
        }

        function showImagePreview(file) {
            const err = validateImageFile(file);
            if (err) {
                inputImage.value = '';
                setUploaderNote(err, true);
                return false;
            }
            setUploaderNote('', false);
            const reader = new FileReader();
            reader.onload = function (e) {
                imgPreview.onerror = function () {
                    // Browser tidak bisa menampilkan format ini (mis. HEIC), file tetap dikirim ke server
                    imgPreview.removeAttribute('src');
                    setUploaderNote('Pratinjau tidak tersedia untuk format ini, tetapi file "' + file.name + '" tetap akan diunggah.', false);
                };
                imgPreview.src = e.target.result;
                uploaderEmpty.style.display = 'none';
                uploaderPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
            return true;
        }

        function setImagePreviewUrl(url) {
            imgPreview.src = url;
            uploaderEmpty.style.display = 'none';
            uploaderPreview.style.display = 'block';
        }

        uploaderBox.addEventListener('click', function (e) {
            if (e.target.closest('.btn-icon')) return;
            inputImage.click();
        });

        inputImage.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const err = validateImageFile(file);
            if (err) {
                inputImage.value = '';
                setUploaderNote(err, true);
                return;
            }
            openCropModal(file, 4 / 3, inputImage, function (croppedFile, inputEl) {
                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                inputEl.files = dt.files;
                if (showImagePreview(croppedFile)) {
                    hapusGambarFlag.value = '0';
                }
            }, false);
        });

        ['dragover', 'dragleave', 'drop'].forEach(function (evt) {
            uploaderBox.addEventListener(evt, function (e) {
                e.preventDefault();
                e.stopPropagation();
            });
        });
        uploaderBox.addEventListener('dragover', function () {
            uploaderBox.classList.add('dragover');
        });
        uploaderBox.addEventListener('dragleave', function () {
            uploaderBox.classList.remove('dragover');
        });
        uploaderBox.addEventListener('drop', function (e) {
            uploaderBox.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (!file) return;
            const err = validateImageFile(file);
            if (err) {
                setUploaderNote(err, true);
                return;
            }
            openCropModal(file, 4 / 3, inputImage, function (croppedFile, inputEl) {
                const dt = new DataTransfer();
                dt.items.add(croppedFile);
                inputEl.files = dt.files;
                if (showImagePreview(croppedFile)) {
                    hapusGambarFlag.value = '0';
                }
            }, false);
        });

        btnRemoveImage.addEventListener('click', function (e) {
            e.stopPropagation();
            inputImage.value = '';
            resetUploader();
            setUploaderNote('', false);
            hapusGambarFlag.value = '1';
        });

        // Zoom Mode — pakai lightbox yang sama dengan zoom di tabel
        btnZoomImage.addEventListener('click', function (e) {
            e.stopPropagation();
            imageZoomImg.src = imgPreview.src;
            imageZoomOverlay.classList.add('show');
        });

        // Overlay layar penuh (menutupi sidebar), kotak form dibatasi di area konten lewat padding overlay
        function syncModalWithContentArea() {
            const contentEl = document.getElementById('content');
            if (!contentEl) return;
            const rect = contentEl.getBoundingClientRect();
            const vw = document.documentElement.clientWidth;
            document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
                overlay.style.paddingLeft = '';
                overlay.style.paddingRight = '';
                const base = parseFloat(getComputedStyle(overlay).paddingRight) || 0;
                overlay.style.paddingLeft = (rect.left + base) + 'px';
                overlay.style.paddingRight = (Math.max(0, vw - rect.right) + base) + 'px';
            });
        }
        window.addEventListener('resize', syncModalWithContentArea);
        document.addEventListener('DOMContentLoaded', function () {
            syncModalWithContentArea();
            const contentEl = document.getElementById('content');
            if (window.ResizeObserver && contentEl) new ResizeObserver(syncModalWithContentArea).observe(contentEl);
        });

        // Buka modal tambah
        function openAddModal() {
            syncModalWithContentArea();
            modalLayananTitle.innerText = 'Tambah Layanan';
            formLayanan.reset();
            formLayanan.action = "{{ route('admin.kelola-layanan.store') }}";
            document.getElementById('formMethod').value = 'POST';
            hapusGambarFlag.value = '0';
            currentImageExists = false;
            resetUploader();
            setUploaderNote('', false);
            modalLayanan.classList.add('show');
            document.body.classList.add('chb-modal-open');
        }

        // Buka modal edit
        function openEditModalFromButton(btn) {
            openEditModal(btn.dataset.id, btn.dataset.title || '', btn.dataset.description || '', btn.dataset.image || '');
        }

        function openEditModal(id, title, description, image) {
            syncModalWithContentArea();
            inputImage.value = '';
            setUploaderNote('', false);
            modalLayananTitle.innerText = 'Edit Layanan';
            formLayanan.action = '/admin/kelola-layanan/' + id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('title').value  = title;
            document.getElementById('description').value = description;
            hapusGambarFlag.value = '0';
            currentImageExists = !!image;

            if (image) {
                setImagePreviewUrl(image);
            } else {
                resetUploader();
            }

            modalLayanan.classList.add('show');
            document.body.classList.add('chb-modal-open');
        }

        function closeModalLayanan() {
            modalLayanan.classList.remove('show');
            document.body.classList.remove('chb-modal-open');
        }

        // Zoom gambar dari tabel
        function openTableImageZoom(el) {
            imageZoomImg.src = el.src;
            imageZoomOverlay.classList.add('show');
        }

        function closeImageZoom() {
            imageZoomOverlay.classList.remove('show');
            imageZoomImg.src = '';
        }

        function closeImageZoomBackdrop(e) {
            if (e.target === imageZoomOverlay) closeImageZoom();
        }

        /* ============================================================
           MODE PILIH: kolom "Aksi" berubah jadi kolom checkbox
           (sama persis polanya dengan Kelola Galeri)
           ============================================================ */
        let layananSelectMode = false;
        let layananSelectedIds = new Set();
        const layananActionCellCache = new Map(); // id -> HTML tombol aksi asli (edit)

        function toggleLayananSelectMode() {
            layananSelectMode = !layananSelectMode;
            layananSelectedIds.clear();
            renderLayananActionCells();
            updateLayananAksiHeader();
            updateLayananBulkToolbar();
        }

        function renderLayananActionCells() {
            document.querySelectorAll('#layananTable tbody tr.layanan-row').forEach(function (tr) {
                const id = tr.dataset.id;
                const cell = tr.querySelector('td.action-cell');
                if (!id || !cell) return;

                if (layananSelectMode) {
                    if (!layananActionCellCache.has(id)) {
                        layananActionCellCache.set(id, cell.innerHTML);
                    }
                    const checked = layananSelectedIds.has(id);
                    cell.innerHTML = '<input type="checkbox" class="layanan-row-checkbox" value="' + id + '" ' + (checked ? 'checked' : '') + ' onchange="toggleLayananRowSelect(\'' + id + '\', this.checked)">';
                    cell.classList.add('select-cell');
                    tr.classList.toggle('row-selected', checked);
                } else {
                    if (layananActionCellCache.has(id)) {
                        cell.innerHTML = layananActionCellCache.get(id);
                    }
                    cell.classList.remove('select-cell');
                    tr.classList.remove('row-selected');
                }
            });
        }

        function updateLayananAksiHeader() {
            const th = document.getElementById('layananAksiHeader');
            const toggleBtn = document.getElementById('btnToggleLayananSelectMode');
            const toggleBtnText = document.getElementById('btnToggleLayananSelectModeText');
            const bulkGroup = document.getElementById('layananBulkActionsGroup');
            if (!th) return;

            if (layananSelectMode) {
                th.innerHTML = '<input type="checkbox" id="layananSelectAll" title="Pilih semua di halaman ini" onclick="toggleLayananSelectAllOnPage(this.checked)">';
                toggleBtn.classList.add('active');
                toggleBtnText.textContent = 'Batal';
                bulkGroup.classList.add('show');
            } else {
                th.textContent = 'Aksi';
                toggleBtn.classList.remove('active');
                toggleBtnText.textContent = 'Hapus';
                bulkGroup.classList.remove('show');
            }
        }

        function isLayananRowVisible(row) {
            return row.style.display !== 'none';
        }

        function toggleLayananRowSelect(id, checked) {
            if (checked) layananSelectedIds.add(id);
            else layananSelectedIds.delete(id);

            const cb = document.querySelector('.layanan-row-checkbox[value="' + id + '"]');
            const row = cb ? cb.closest('tr') : null;
            if (row) row.classList.toggle('row-selected', checked);

            syncLayananSelectAllCheckbox();
            updateLayananBulkToolbar();
        }

        function toggleLayananSelectAllOnPage(checked) {
            document.querySelectorAll('#layananTable tbody tr.layanan-row').forEach(function (tr) {
                if (!isLayananRowVisible(tr)) return;
                const cb = tr.querySelector('.layanan-row-checkbox');
                if (!cb) return;
                cb.checked = checked;
                const id = cb.value;
                if (checked) layananSelectedIds.add(id);
                else layananSelectedIds.delete(id);
                tr.classList.toggle('row-selected', checked);
            });
            updateLayananBulkToolbar();
        }

        function syncLayananSelectAllCheckbox() {
            const selectAll = document.getElementById('layananSelectAll');
            if (!selectAll) return; // hanya ada saat mode pilih aktif
            const boxes = Array.from(document.querySelectorAll('#layananTable tbody tr.layanan-row')).filter(isLayananRowVisible).map(function (tr) { return tr.querySelector('.layanan-row-checkbox'); }).filter(Boolean);
            if (!boxes.length) { selectAll.checked = false; selectAll.indeterminate = false; return; }
            const checkedCount = boxes.filter(function (cb) { return cb.checked; }).length;
            selectAll.checked = checkedCount === boxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < boxes.length;
        }

        function updateLayananBulkToolbar() {
            const count = layananSelectedIds.size;
            document.getElementById('layananBulkDeleteCount').textContent = count;
            document.getElementById('btnLayananBulkDelete').disabled = count === 0;
        }

        /* ============================================================
           HAPUS LAYANAN — modal konfirmasi (satu data / data terpilih)
           ============================================================ */
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const btnCancelDelete    = document.getElementById('btnCancelDelete');
        const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
        const deleteConfirmTitle = document.getElementById('deleteConfirmTitle');
        const deleteConfirmText  = document.getElementById('deleteConfirmText');
        let formToDelete = null;
        let layananDeleteMode = 'single'; // 'single' | 'bulk'

        function openLayananDeleteConfirm(title, text) {
            deleteConfirmTitle.textContent = title;
            deleteConfirmText.textContent = text;
            deleteConfirmModal.classList.add('show');
        }

        // Hapus satu layanan
        function confirmDeleteLayanan(id) {
            layananDeleteMode = 'single';
            formToDelete = document.getElementById('deleteFormLayanan' + id);
            openLayananDeleteConfirm('Hapus Layanan?', 'Yakin ingin menghapus layanan ini? Data yang sudah dihapus tidak dapat dikembalikan.');
        }

        // Hapus semua layanan yang dicentang (tombol "Hapus Terpilih")
        function confirmBulkDeleteLayanan() {
            if (layananSelectedIds.size === 0) return;
            layananDeleteMode = 'bulk';
            openLayananDeleteConfirm(
                'Hapus Layanan Terpilih?',
                'Yakin ingin menghapus ' + layananSelectedIds.size + ' layanan yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.'
            );
        }

        btnCancelDelete.addEventListener('click', function () {
            formToDelete = null;
            layananDeleteMode = 'single';
            deleteConfirmModal.classList.remove('show');
        });

        btnConfirmDelete.addEventListener('click', async function () {
            if (layananDeleteMode === 'single') {
                if (formToDelete) {
                    formToDelete.submit();
                }
                deleteConfirmModal.classList.remove('show');
                return;
            }

            // Mode massal: kirim form hapus untuk tiap layanan yang dicentang
            const ids = Array.from(layananSelectedIds);
            if (ids.length === 0) {
                deleteConfirmModal.classList.remove('show');
                return;
            }

            const originalText = btnConfirmDelete.innerHTML;
            btnConfirmDelete.innerHTML = 'Menghapus...';
            btnConfirmDelete.disabled = true;

            let gagal = 0;
            for (const id of ids) {
                const form = document.getElementById('deleteFormLayanan' + id);
                if (!form) { gagal++; continue; }
                try {
                    const res = await fetch(form.action, { method: 'POST', body: new FormData(form) });
                    if (!res.ok) gagal++;
                } catch (e) {
                    gagal++;
                }
            }

            const berhasil = ids.length - gagal;
            sessionStorage.setItem(
                'layananBulkDeleteMessage',
                gagal === 0
                    ? berhasil + ' layanan berhasil dihapus.'
                    : berhasil + ' dari ' + ids.length + ' layanan berhasil dihapus.'
            );

            btnConfirmDelete.innerHTML = originalText;
            btnConfirmDelete.disabled = false;
            deleteConfirmModal.classList.remove('show');
            window.location.reload();
        });

        deleteConfirmModal.addEventListener('click', function (e) {
            if (e.target === deleteConfirmModal && !btnConfirmDelete.disabled) {
                formToDelete = null;
                layananDeleteMode = 'single';
                deleteConfirmModal.classList.remove('show');
            }
        });

        // ===== Modal Notifikasi Sukses =====
        const successModal    = document.getElementById('successModal');
        const successMessage  = document.getElementById('successMessage');
        const btnCloseSuccess = document.getElementById('btnCloseSuccess');

        function showSuccessPopup(message) {
            successMessage.textContent = message;
            successModal.classList.add('show');
        }

        btnCloseSuccess.addEventListener('click', function () {
            successModal.classList.remove('show');
        });

        successModal.addEventListener('click', function (e) {
            if (e.target === successModal) successModal.classList.remove('show');
        });

        // ===== Modal Notifikasi Error =====
        const errorModal    = document.getElementById('errorModal');
        const errorMessage  = document.getElementById('errorMessage');
        const btnCloseError = document.getElementById('btnCloseError');

        function showErrorPopup(message) {
            errorMessage.textContent = message;
            errorModal.classList.add('show');
        }
        btnCloseError.addEventListener('click', function () { errorModal.classList.remove('show'); });
        errorModal.addEventListener('click', function (e) {
            if (e.target === errorModal) errorModal.classList.remove('show');
        });

        // Cegah submit jika file yang dipilih tidak valid, dan pastikan gambar wajib diisi
        formLayanan.addEventListener('submit', function (e) {
            const f = inputImage.files[0];

            if (f) {
                const err = validateImageFile(f);
                if (err) { e.preventDefault(); showErrorPopup(err); }
                return;
            }

            // Tidak ada file baru dipilih: gambar tetap wajib ada.
            // Diperbolehkan hanya jika sedang edit, sudah ada gambar tersimpan,
            // dan gambar tersebut tidak sedang dihapus.
            const masihPunyaGambarLama = currentImageExists && hapusGambarFlag.value !== '1';
            if (!masihPunyaGambarLama) {
                e.preventDefault();
                showErrorPopup('Gambar wajib diisi.');
            }
        });

        const layananBulkDeleteMessage = sessionStorage.getItem('layananBulkDeleteMessage');
        if (layananBulkDeleteMessage) {
            sessionStorage.removeItem('layananBulkDeleteMessage');
            showSuccessPopup(layananBulkDeleteMessage);
        }
        @if(session('success'))
            else {
                showSuccessPopup(@json(session('success')));
            }
        @endif
        @if($errors->any())
            showErrorPopup(@json(implode("\n", $errors->all())));
        @endif

	/* ===== Header diam di atas; kartu daftar bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var header = main ? main.querySelector('.head-title') : null;
		var card = document.querySelector('#content main .table-data .order');
		if (!main || !header || !card) return;
		var spacer = null;
		function pinHeader() {
			if (header.classList.contains('page-header-fixed')) return;
			var r = header.getBoundingClientRect();
			spacer = document.createElement('div');
			spacer.style.height = r.height + 'px';
			header.parentNode.insertBefore(spacer, header.nextSibling);
			header.style.top = r.top + 'px';
			header.classList.add('page-header-fixed');
		}
		function syncLayout() {
			var mainTop = main.getBoundingClientRect().top;
			main.style.height = (window.innerHeight - mainTop) + 'px';
			main.style.overflow = 'hidden';
			var ref = spacer || header;
			var hr = ref.getBoundingClientRect();
			header.style.left = hr.left + 'px';
			header.style.width = hr.width + 'px';
			var cardTop = card.getBoundingClientRect().top;
			var available = window.innerHeight - cardTop - 24;
			if (available < 200) available = 200;
			card.style.maxHeight = available + 'px';
			var headEl = card.querySelector('.head');
			if (headEl) card.style.setProperty('--head-h', headEl.offsetHeight + 'px');
		}
		pinHeader();
		syncLayout();
		window.addEventListener('resize', syncLayout);
		setTimeout(syncLayout, 300);
	})();
</script>
@endpush