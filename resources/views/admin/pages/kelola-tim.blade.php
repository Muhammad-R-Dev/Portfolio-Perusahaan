@extends('admin.layouts.app')

@section('title', 'Kelola Tim | Admin Astabrata Teknologi')
@section('page-title', 'Kelola Tim')

@push('styles')
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
            box-shadow: 0 4px 14px rgba(0, 0, 0, .04);
            width: 100%;
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
            font-size: 18px;
            color: var(--dark-grey);
            transition: color .15s ease;
        }
        #content main .table-data .head .bx:hover {
            color: var(--blue);
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
            width: 180px;
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

        /* PAGINATION */
        #content main .table-data .table-pagination {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            grid-gap: 6px;
            flex-wrap: wrap;
            margin-top: 18px;
        }
        #content main .table-data .table-pagination .page-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 8px;
            border-radius: 8px;
            border: none;
            background: var(--grey);
            color: var(--dark);
            font-family: var(--poppins);
            font-size: 13px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }
        #content main .table-data .table-pagination .page-btn:hover:not(:disabled) {
            background: var(--light-blue);
            color: var(--blue);
        }
        #content main .table-data .table-pagination .page-btn.active {
            background: var(--blue);
            color: var(--light);
            font-weight: 600;
        }
        #content main .table-data .table-pagination .page-btn:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        #content main .table-data .order {
            width: 100%;
        }
        #content main .table-data .order table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Memastikan lebar kolom konsisten */
        }
        #content main .table-data .order table th {
            padding: 0 10px 12px;
            font-size: 12px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--dark-grey);
            font-weight: 600;
            border-bottom: 1px solid var(--grey);
        }
        
        /* PENGATURAN LEBAR KOLOM AGAR RAPI MENYAMBUNG KANAN */
        #content main .table-data .order table th:nth-child(1),
        #content main .table-data .order table td:nth-child(1) { width: 50px; text-align: center; } /* No */

        #content main .table-data .order table th:nth-child(2),
        #content main .table-data .order table td:nth-child(2) { width: 70px; text-align: center; } /* Foto */

        #content main .table-data .order table th:nth-child(3),
        #content main .table-data .order table td:nth-child(3) { width: 27%; } /* Nama */

        #content main .table-data .order table th:nth-child(4),
        #content main .table-data .order table td:nth-child(4) { width: 25%; } /* Jabatan */

        #content main .table-data .order table th:nth-child(5),
        #content main .table-data .order table td:nth-child(5) { width: 22%; } /* Divisi */

        #content main .table-data .order table th:nth-child(6),
        #content main .table-data .order table td:nth-child(6) { width: 110px; text-align: right; padding-right: 16px; } /* Aksi */

        #content main .table-data .order table td {
            padding: 14px 10px;
            vertical-align: middle;
        }
        #content main .table-data .order table tbody tr {
            transition: background .15s ease;
        }
        #content main .table-data .order table tbody tr:not(:last-child) td {
            border-bottom: 1px solid var(--grey);
        }
        #content main .table-data .order table tbody tr:hover {
            background: var(--grey);
        }
        #content main .table-data .order table td img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }
        #content main .table-data .order table td img.foto-zoomable {
            cursor: zoom-in;
            transition: transform .15s ease;
        }
        #content main .table-data .order table td img.foto-zoomable:hover {
            transform: scale(1.12);
        }
        #content main .table-data .order table td.col-foto {
            text-align: center;
        }
        #content main .table-data .order table td.col-nama {
            font-weight: 500;
        }
        #content main .table-data .order table td.col-divisi span {
            background: var(--light-blue);
            color: var(--blue);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        #content main .table-data .order table td.col-aksi {
            white-space: nowrap;
            text-align: right;
        }
        #content main .table-data .order table td.col-aksi .btn-edit {
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

        /* TOMBOL MODE PILIH (HAPUS) & HAPUS TERPILIH */
        #content main .table-data .head .btn-select-mode,
        #content main .table-data .head .btn-bulk-delete {
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
        #content main .table-data .head .btn-select-mode {
            background: var(--red);
            color: var(--light);
        }
        #content main .table-data .head .btn-select-mode:hover {
            opacity: .9;
        }
        #content main .table-data .head .btn-select-mode.active {
            background: var(--dark);
            color: var(--light);
        }
        #content main .table-data .head .bulk-actions-group {
            display: none;
            align-items: center;
            grid-gap: 10px;
        }
        #content main .table-data .head .bulk-actions-group.show {
            display: flex;
        }
        #content main .table-data .head .btn-bulk-delete {
            background: var(--light-orange);
            color: var(--red);
        }
        #content main .table-data .head .btn-bulk-delete:hover:not(:disabled) {
            background: var(--red);
            color: var(--light);
        }
        #content main .table-data .head .btn-bulk-delete:disabled {
            opacity: .5;
            cursor: not-allowed;
        }
        #content main .table-data .order table th input[type="checkbox"],
        #content main .table-data .order table td.col-aksi input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--blue);
        }
        #content main .table-data .order table tbody tr.row-selected {
            background: var(--light-blue);
        }

        /* MODAL */
        .modal-overlay {
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 5000;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity .25s ease, visibility .25s ease;
        }
        .modal-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        .modal-box {
            background: var(--light);
            border-radius: 16px;
            padding: 28px;
            width: 100%;
            max-width: 980px;
            max-height: 90vh;
            overflow-y: auto;
            font-family: var(--poppins);
            color: var(--dark);
            position: relative;
            transform: scale(.92) translateY(10px);
            transition: transform .25s ease;
        }
        .modal-overlay.show .modal-box {
            transform: scale(1) translateY(0);
        }
        .modal-box .modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 22px;
            color: var(--dark-grey);
            cursor: pointer;
            line-height: 1;
            transition: color .15s ease, transform .15s ease;
        }
        .modal-box .modal-close:hover {
            color: var(--red);
            transform: rotate(90deg);
        }
        .modal-box h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-right: 24px;
        }
        .modal-box .form-group {
            margin-bottom: 16px;
        }
        .modal-box label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        /* FORM TAMBAH / EDIT TIM - INPUT KIRI & MEDIA FOTO KANAN */
        .tim-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(320px, 380px);
            gap: 28px;
            align-items: stretch;
        }

        .tim-form-left {
            min-width: 0;
        }

        .tim-media-card {
            border: 1px solid var(--grey);
            background: var(--light);
            border-radius: 14px;
            padding: 16px;
        }

        .tim-media-card .media-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .tim-media-preview {
            position: relative;
            min-height: 250px;
            border: 2px dashed var(--dark-grey);
            border-radius: 12px;
            background: var(--grey);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .tim-media-preview.has-image {
            border-style: solid;
            border-color: var(--grey);
        }

        .tim-media-preview img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            display: block;
        }

        .tim-media-empty {
            text-align: center;
            color: var(--dark-grey);
            padding: 18px;
        }

        .tim-media-empty .bx {
            font-size: 38px;
            color: var(--blue);
            display: block;
            margin-bottom: 8px;
        }

        .tim-media-empty strong {
            display: block;
            color: var(--dark);
            font-size: 13px;
            margin-bottom: 4px;
        }

        .tim-media-empty span {
            display: block;
            font-size: 11px;
            line-height: 1.5;
        }

        .tim-media-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 6px;
            z-index: 3;
        }

        .tim-media-btn {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .75);
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            transition: background .15s ease, transform .15s ease;
        }

        .tim-media-btn:hover {
            background: rgba(15, 23, 42, .95);
            transform: translateY(-1px);
        }

        .tim-media-btn.danger:hover {
            background: var(--red);
        }

        .tim-media-preview.upload-clickable {
            cursor: pointer;
            transition: border-color .15s ease, background .15s ease, transform .15s ease;
        }

        .tim-media-preview.upload-clickable:hover {
            border-color: var(--blue);
            background: var(--light-blue);
        }

        .tim-media-preview.upload-clickable.has-image {
            background: var(--grey);
        }

        .tim-media-preview.upload-clickable.has-image:hover {
            background: var(--grey);
        }

        .tim-media-file-input {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            opacity: 0 !important;
            cursor: pointer !important;
            z-index: 1 !important;
        }

        .tim-media-actions {
            pointer-events: none;
        }

        .tim-media-btn {
            pointer-events: auto;
        }

        .tim-media-meta {
            margin-top: 8px;
            font-size: 11px;
            color: var(--dark-grey);
            text-align: center;
            line-height: 1.5;
        }

        @media screen and (max-width: 700px) {
            .tim-form-grid {
                grid-template-columns: 1fr;
            }

            .tim-media-card {
                order: -1;
            }
        }
        .modal-box input[type="text"],
        .modal-box input[type="url"],
        .modal-box select {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid var(--grey);
            background: var(--grey);
            font-family: var(--poppins);
            font-size: 14px;
            color: var(--dark);
            outline: none;
            transition: border-color .15s ease, background .15s ease;
        }
        .modal-box input[type="text"]:focus,
        .modal-box input[type="url"]:focus,
        .modal-box select:focus {
            border-color: var(--blue);
            background: var(--light);
        }
        /* Placeholder tetap terbaca di light maupun dark mode (pakai variabel tema, bukan warna tetap) */
        .modal-box input[type="text"]::placeholder,
        .modal-box input[type="url"]::placeholder {
            color: var(--dark-grey);
            opacity: 1;
        }
        .custom-input-hidden {
            display: none;
            margin-top: 8px;
        }
        .custom-input-hidden.show {
            display: block;
        }

        .modal-box .upload-zone {
            border: 2px dashed var(--dark-grey);
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            cursor: pointer;
            position: relative;
            color: var(--dark-grey);
            transition: .2s ease;
            display: flex;
            align-items: center;
            grid-gap: 14px;
        }
        .modal-box .upload-zone:hover {
            border-color: var(--blue);
            color: var(--blue);
        }
        .modal-box .upload-zone .bx {
            font-size: 28px;
        }
        .modal-box .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }
        .modal-box .preview-img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid var(--grey);
        }
        .modal-box .modal-actions {
            display: flex;
            justify-content: flex-end;
            grid-gap: 10px;
            margin-top: 24px;
        }
        .modal-box .btn {
            padding: 10px 20px;
            border-radius: 36px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            font-family: var(--poppins);
            font-size: 14px;
            transition: background .15s ease, transform .15s ease;
        }
        .modal-box .btn:hover {
            transform: translateY(-1px);
        }
        .modal-box .btn-cancel {
            background: var(--red);
            color: var(--light);
        }
        .modal-box .btn-cancel:hover {
            filter: brightness(.9);
        }
        .modal-box .btn-save {
            background: var(--blue);
            color: var(--light);
        }
        .modal-box .btn-save:hover {
            background: #2f7dd1;
        }
        .modal-box .btn-danger {
            background: var(--red);
            color: var(--light);
        }

        /* ============================================================
           DARK MODE - TOMBOL TETAP KONTRAS (TIDAK PUTIH POLOS)
           ============================================================ */

        /* Tombol "Tambah Tim" tetap biru, tulisan putih */
        body.dark #content main .head-title .btn-download,
        body.dark #content main .head-title .btn-download:hover {
            background: var(--blue) !important;
            color: #fff !important;
        }

        /* Tombol "Edit" di tabel tetap biru, tulisan putih */
        body.dark #content main .table-data .order table td.col-aksi .btn-edit,
        body.dark #content main .table-data .order table td.col-aksi .btn-edit:hover {
            background: var(--blue) !important;
            color: #fff !important;
        }

        /* Tombol "Hapus" (mode pilih & hapus terpilih) tetap kontras */
        body.dark #content main .table-data .head .btn-select-mode {
            background: var(--red) !important;
            color: #fff !important;
        }
        /* Tombol berubah jadi "Batal" saat mode pilih aktif -> warna kuning */
        body.dark #content main .table-data .head .btn-select-mode.active {
            background: var(--yellow) !important;
            color: #1a1a1a !important;
        }
        /* Tombol "Hapus (n)" di sebelahnya -> merah polos, tanpa efek hover ganti warna lagi */
        body.dark #content main .table-data .head .btn-bulk-delete,
        body.dark #content main .table-data .head .btn-bulk-delete:hover:not(:disabled) {
            background: var(--red) !important;
            color: #fff !important;
        }

        /* Tombol "Batal" tetap merah, tulisan putih */
        body.dark .modal-box .btn-cancel,
        body.dark .modal-box .btn-cancel:hover {
            background: var(--red) !important;
            color: #fff !important;
            filter: none !important;
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

        /* ZOOM FOTO */
        .zoom-overlay {
            background: rgba(0, 0, 0, 0.85);
            flex-direction: column;
        }
        .zoom-overlay .zoom-img-wrap {
            position: relative;
            display: inline-flex;
            max-width: 90vw;
            max-height: 80vh;
            transform: scale(.92);
            transition: transform .25s ease;
        }
        .zoom-overlay.show .zoom-img-wrap {
            transform: scale(1);
        }
        .zoom-overlay .zoom-img {
            max-width: 90vw;
            max-height: 80vh;
            border-radius: 12px;
            object-fit: contain;
            display: block;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .5);
        }
        .zoom-overlay .zoom-caption {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 32px 20px 16px;
            border-radius: 0 0 12px 12px;
            background: linear-gradient(to top, rgba(0, 0, 0, .85) 0%, rgba(0, 0, 0, .55) 55%, rgba(0, 0, 0, 0) 100%);
            text-align: left;
            pointer-events: none;
        }
        .zoom-overlay .zoom-caption h4 {
            color: var(--light);
            font-family: var(--poppins);
            font-size: 17px;
            font-weight: 600;
            margin: 0 0 4px;
        }
        .zoom-overlay .zoom-caption p {
            color: rgba(255, 255, 255, .85);
            font-family: var(--poppins);
            font-size: 13px;
            font-weight: 400;
            margin: 0;
        }
        .zoom-overlay .zoom-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 2px solid var(--light);
            background: var(--dark);
            color: var(--light);
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .35);
            transition: background .15s ease;
        }
        .zoom-overlay .zoom-close:hover {
            background: var(--red);
        }
</style>
@endpush

@section('content')
            <div class="head-title">
                <div class="left">
                    <h1>Kelola Tim</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Kelola Tim</a>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-download" id="btnTambahTim">
                    <i class='bx bxs-plus-circle' ></i>
                    <span class="text">Tambah Tim</span>
                </button>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Anggota Tim</h3>
                        <div class="table-toolbar">
                            <div class="search-box">
                                <i class='bx bx-search'></i>
                                <input type="text" id="timSearch" placeholder="Cari nama / jabatan...">
                            </div>
                            <select id="timFilterDivisi" class="filter-select">
                                <option value="">Semua Divisi</option>
                                @foreach($teams->pluck('divisi')->unique()->filter() as $divisi)
                                    <option value="{{ strtolower($divisi) }}">{{ $divisi }}</option>
                                @endforeach
                            </select>
                            <select id="timFilterPerPage" class="filter-select">
                                <option value="">Semua</option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                            </select>
                            <button type="button" class="btn-select-mode" id="btnToggleTimSelectMode" onclick="toggleTimSelectMode()">
                                <i class='bx bx-list-check'></i> <span id="btnToggleTimSelectModeText">Hapus</span>
                            </button>
                            <div class="bulk-actions-group" id="timBulkActionsGroup">
                                <button type="button" class="btn-bulk-delete" id="btnTimBulkDelete" disabled onclick="confirmBulkDeleteTim()">
                                    <i class='bx bx-trash'></i> Hapus (<span id="timBulkDeleteCount">0</span>)
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="timTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
                                <th id="timAksiHeader" style="text-align: right; padding-right: 16px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="timTableBody">
                            @forelse($teams as $team)
                            <tr class="tim-row" data-id="{{ $team->id }}" data-nama="{{ strtolower($team->nama) }}" data-jabatan="{{ strtolower($team->jabatan) }}" data-divisi="{{ strtolower($team->divisi) }}">
                                <td class="col-no">{{ $loop->iteration }}</td>
                                <td class="col-foto">
                                    <img class="foto-zoomable" src="{{ $team->foto_url }}" alt="{{ $team->nama }}"
                                    data-jabatan="{{ $team->jabatan }}" data-divisi="{{ $team->divisi }}"
                                    onclick="openZoomFoto(this.src, this.alt, this.dataset.jabatan, this.dataset.divisi)">
                                </td>
                                <td class="col-nama">{{ $team->nama }}</td>
                                <td>{{ $team->jabatan }}</td>
                                <td class="col-divisi"><span>{{ $team->divisi }}</span></td>
                                <td class="col-aksi">
                                    <button type="button" class="btn-edit"
                                        title="Edit"
                                        data-id="{{ $team->id }}"
                                        data-nama="{{ $team->nama }}"
                                        data-jabatan="{{ $team->jabatan }}"
                                        data-divisi="{{ $team->divisi }}"
                                        data-foto="{{ $team->foto_url }}"
                                        data-url="{{ route('admin.kelola-tim.update', $team->id) }}"
                                        onclick="openModal('edit', this)">Edit</button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center; color: var(--dark-grey);">Belum ada anggota tim.</td>
                            </tr>
                            @endforelse
                            <tr class="no-result-row" id="timNoResult" style="display:none;">
                                <td colspan="6">Data tidak ditemukan.</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Form hapus diletakkan TERPISAH dari tabel (bukan di dalam td.col-aksi) -->
                    <!-- agar tidak ikut terhapus saat kolom Aksi diganti jadi checkbox pada mode pilih -->
                    <div id="timDeleteForms" style="display:none;">
                        @foreach($teams as $team)
                        <form id="deleteFormTim{{ $team->id }}" action="{{ route('admin.kelola-tim.destroy', $team->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endforeach
                    </div>

                    <div class="table-pagination" id="timPagination"></div>
                </div>
            </div>

            <!-- Modal Tambah/Edit Tim -->
            <div class="modal-overlay" id="timModal">
                <div class="modal-box">
                    <span class="modal-close" id="btnCloseModal">&times;</span>
                    <h2 id="modalTitle">Tambah Tim</h2>
                    <form id="timForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.kelola-tim.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="">

                        <div class="tim-form-grid">
                            <div class="tim-form-left">
                                <div class="form-group">
                                    <label for="teamNama">Nama</label>
                                    <input type="text" name="nama" id="teamNama" required maxlength="100" placeholder="Masukkan nama lengkap">
                                </div>

                                <!-- JABATAN DENGAN OPSI PILIH & KETIK MANUAL -->
                                <div class="form-group">
                                    <label for="selectJabatan">Jabatan</label>
                                    <select id="selectJabatan" onchange="handleJabatanChange(this)">
                                        <option value="" disabled selected>Pilih Jabatan</option>
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="Fullstack Developer">Fullstack Developer</option>
                                        <option value="Frontend Developer">Frontend Developer</option>
                                        <option value="Backend Developer">Backend Developer</option>
                                        <option value="UI/UX Designer">UI/UX Designer</option>
                                        <option value="Quality Assurance">Quality Assurance</option>
                                        <option value="Lainnya">Lainnya (Ketik Manual)...</option>
                                    </select>
                                    <input type="text" name="jabatan" id="inputJabatanManual" class="custom-input-hidden" placeholder="Ketik jabatan baru..." maxlength="100">
                                </div>

                                <!-- DIVISI DENGAN OPSI PILIH & KETIK MANUAL -->
                                <div class="form-group">
                                    <label for="selectDivisi">Divisi</label>
                                    <select id="selectDivisi" onchange="handleDivisiChange(this)">
                                        <option value="" disabled selected>Pilih Divisi</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="UI/UX Design">UI/UX Design</option>
                                        <option value="Project Management">Project Management</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Human Resources">Human Resources</option>
                                        <option value="Lainnya">Lainnya (Ketik Manual)...</option>
                                    </select>
                                    <input type="text" name="divisi" id="inputDivisiManual" class="custom-input-hidden" placeholder="Ketik divisi baru..." maxlength="100">
                                </div>
                            </div>

                            <div class="tim-media-card">
                                <div class="media-title">Media Foto</div>

                                <div class="tim-media-preview upload-clickable" id="timMediaPreview" title="Klik untuk memilih foto">
                                    <div class="tim-media-empty" id="timMediaEmpty">
                                        <i class='bx bx-image-add'></i>
                                        <strong>Upload Foto</strong>
                                        <span>Klik area ini untuk memilih foto</span>
                                    </div>

                                    <img
                                        src="{{ asset('image/profile.png') }}"
                                        alt="Preview Foto"
                                        id="previewFoto"
                                        style="display:none;"
                                    >

                                    <div class="tim-media-actions" id="timMediaActions" style="display:none;">
                                        <button type="button" class="tim-media-btn" id="btnZoomMedia" title="Zoom Foto">
                                            <i class='bx bx-fullscreen'></i>
                                        </button>
                                        <button type="button" class="tim-media-btn danger" id="btnRemoveMedia" title="Hapus Foto">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>

                                    <input type="file" name="foto" id="teamFoto" accept="image/*" class="tim-media-file-input">
                                </div>

                                <div class="tim-media-meta">
                                    PNG, JPG, JPEG · Maks. 2MB
                                </div>
                            </div>
                        </div>

                        <div class="modal-actions">
                            <button type="button" class="btn btn-cancel" id="btnCancelModal">Batal</button>
                            <button type="submit" class="btn btn-save">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Konfirmasi Hapus -->
            <div class="modal-overlay" id="deleteConfirmModal">
                <div class="modal-box modal-confirm">
                    <div class="confirm-icon"><i class='bx bx-trash'></i></div>
                    <h2 id="deleteConfirmTitle">Hapus Anggota Tim?</h2>
                    <p id="deleteConfirmText">Yakin ingin menghapus anggota tim ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
                    <div class="modal-actions">
                        <button type="button" class="btn btn-cancel" id="btnCancelDelete">Batal</button>
                        <button type="button" class="btn btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
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
                        <button type="button" class="btn btn-save" id="btnCloseSuccess">OK</button>
                    </div>
                </div>
            </div>

            <!-- Modal Zoom Foto -->
            <div class="modal-overlay zoom-overlay" id="zoomFotoModal">
                <div class="zoom-img-wrap">
                    <img src="" alt="" class="zoom-img" id="zoomFotoImg">
                    <span class="zoom-close" id="btnCloseZoomFoto">&times;</span>
                    <div class="zoom-caption">
                        <h4 id="zoomFotoNama"></h4>
                        <p id="zoomFotoInfo"></p>
                    </div>
                </div>
            </div>
@endsection

@push('scripts')
<script>
        // ===== Pencarian, Filter & Pagination Otomatis (Daftar Anggota Tim) =====
        const timSearchInput   = document.getElementById('timSearch');
        const timFilterDivisi  = document.getElementById('timFilterDivisi');
        const timFilterPerPage = document.getElementById('timFilterPerPage');
        const timNoResult      = document.getElementById('timNoResult');
        const timPagination    = document.getElementById('timPagination');

        let timCurrentPage = 1;

        function getTimFilteredRows() {
            const keyword = timSearchInput ? timSearchInput.value.trim().toLowerCase() : '';
            const divisi  = timFilterDivisi ? timFilterDivisi.value.toLowerCase() : '';
            const rows    = Array.from(document.querySelectorAll('#timTableBody .tim-row'));

            return rows.filter(function (row) {
                const cocokKeyword = row.dataset.nama.includes(keyword) || row.dataset.jabatan.includes(keyword);
                const cocokDivisi  = divisi === '' || row.dataset.divisi === divisi;
                return cocokKeyword && cocokDivisi;
            });
        }

        function applyTimFilters(resetPage) {
            if (resetPage) {
                timCurrentPage = 1;
            }

            const allRows      = document.querySelectorAll('#timTableBody .tim-row');
            const filteredRows = getTimFilteredRows();
            const perPageValue = timFilterPerPage ? timFilterPerPage.value : '';
            const perPage      = perPageValue === '' ? filteredRows.length : parseInt(perPageValue, 10);
            const totalPages   = perPage > 0 ? Math.max(1, Math.ceil(filteredRows.length / perPage)) : 1;

            if (timCurrentPage > totalPages) {
                timCurrentPage = totalPages;
            }
            if (timCurrentPage < 1) {
                timCurrentPage = 1;
            }

            allRows.forEach(function (row) {
                row.style.display = 'none';
            });

            const start = perPage > 0 ? (timCurrentPage - 1) * perPage : 0;
            const end   = perPage > 0 ? start + perPage : filteredRows.length;

            filteredRows.slice(start, end).forEach(function (row) {
                row.style.display = '';
            });

            if (timNoResult) {
                timNoResult.style.display = (allRows.length > 0 && filteredRows.length === 0) ? '' : 'none';
            }

            renderTimPagination(filteredRows.length, perPage, totalPages);
            syncTimSelectAllCheckbox();
        }

        function renderTimPagination(totalItems, perPage, totalPages) {
            if (!timPagination) return;
            timPagination.innerHTML = '';

            if (perPage <= 0 || totalItems <= perPage || totalPages <= 1) {
                return;
            }

            const buatTombol = function (label, page, opts) {
                opts = opts || {};
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = label;
                btn.className = 'page-btn' + (opts.active ? ' active' : '');
                if (opts.disabled) {
                    btn.disabled = true;
                } else {
                    btn.addEventListener('click', function () {
                        timCurrentPage = page;
                        applyTimFilters(false);
                    });
                }
                return btn;
            };

            timPagination.appendChild(buatTombol('<', timCurrentPage - 1, { disabled: timCurrentPage === 1 }));

            for (let i = 1; i <= totalPages; i++) {
                timPagination.appendChild(buatTombol(i, i, { active: i === timCurrentPage }));
            }

            timPagination.appendChild(buatTombol('>', timCurrentPage + 1, { disabled: timCurrentPage === totalPages }));
        }

        if (timSearchInput) {
            timSearchInput.addEventListener('input', function () { applyTimFilters(true); });
        }
        if (timFilterDivisi) {
            timFilterDivisi.addEventListener('change', function () { applyTimFilters(true); });
        }
        if (timFilterPerPage) {
            timFilterPerPage.addEventListener('change', function () { applyTimFilters(true); });
        }

        applyTimFilters(true);

        /* ============================================================
           MODE PILIH: kolom "Aksi" berubah jadi kolom checkbox
           ============================================================ */
        let timSelectMode = false;
        let timSelectedIds = new Set();
        const timActionCellCache = new Map(); // id -> HTML tombol aksi asli (Edit)

        function toggleTimSelectMode() {
            timSelectMode = !timSelectMode;
            timSelectedIds.clear();
            renderTimActionCells();
            updateTimAksiHeader();
            updateTimBulkToolbar();
        }

        function renderTimActionCells() {
            document.querySelectorAll('#timTableBody tr.tim-row').forEach(function (tr) {
                const id = tr.dataset.id;
                const cell = tr.querySelector('td.col-aksi');
                if (!id || !cell) return;

                if (timSelectMode) {
                    if (!timActionCellCache.has(id)) {
                        timActionCellCache.set(id, cell.innerHTML);
                    }
                    const checked = timSelectedIds.has(id);
                    cell.innerHTML = '<input type="checkbox" class="tim-row-checkbox" value="' + id + '" ' + (checked ? 'checked' : '') + ' onchange="toggleTimRowSelect(\'' + id + '\', this.checked)">';
                    tr.classList.toggle('row-selected', checked);
                } else {
                    if (timActionCellCache.has(id)) {
                        cell.innerHTML = timActionCellCache.get(id);
                    }
                    tr.classList.remove('row-selected');
                }
            });
        }

        function updateTimAksiHeader() {
            const th = document.getElementById('timAksiHeader');
            const toggleBtn = document.getElementById('btnToggleTimSelectMode');
            const toggleBtnText = document.getElementById('btnToggleTimSelectModeText');
            const bulkGroup = document.getElementById('timBulkActionsGroup');
            if (!th) return;

            if (timSelectMode) {
                th.innerHTML = '<input type="checkbox" id="timSelectAll" title="Pilih semua di halaman ini" onclick="toggleTimSelectAllOnPage(this.checked)">';
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

        function toggleTimRowSelect(id, checked) {
            if (checked) timSelectedIds.add(id);
            else timSelectedIds.delete(id);

            const cb = document.querySelector('.tim-row-checkbox[value="' + id + '"]');
            const row = cb ? cb.closest('tr') : null;
            if (row) row.classList.toggle('row-selected', checked);

            syncTimSelectAllCheckbox();
            updateTimBulkToolbar();
        }

        function getVisibleTimCheckboxes() {
            return Array.from(document.querySelectorAll('#timTableBody .tim-row .tim-row-checkbox')).filter(function (cb) {
                const tr = cb.closest('tr');
                return tr && tr.style.display !== 'none';
            });
        }

        function toggleTimSelectAllOnPage(checked) {
            getVisibleTimCheckboxes().forEach(function (cb) {
                cb.checked = checked;
                const id = cb.value;
                if (checked) timSelectedIds.add(id);
                else timSelectedIds.delete(id);
                const row = cb.closest('tr');
                if (row) row.classList.toggle('row-selected', checked);
            });
            updateTimBulkToolbar();
        }

        function syncTimSelectAllCheckbox() {
            const selectAll = document.getElementById('timSelectAll');
            if (!selectAll) return; // hanya ada saat mode pilih aktif
            const boxes = getVisibleTimCheckboxes();
            if (!boxes.length) { selectAll.checked = false; selectAll.indeterminate = false; return; }
            const checkedCount = boxes.filter(function (cb) { return cb.checked; }).length;
            selectAll.checked = checkedCount === boxes.length;
            selectAll.indeterminate = checkedCount > 0 && checkedCount < boxes.length;
        }

        function updateTimBulkToolbar() {
            const count = timSelectedIds.size;
            document.getElementById('timBulkDeleteCount').textContent = count;
            document.getElementById('btnTimBulkDelete').disabled = count === 0;
        }

        const timModal   = document.getElementById('timModal');
        const modalTitle = document.getElementById('modalTitle');
        const timForm    = document.getElementById('timForm');
        const formMethod = document.getElementById('formMethod');

        const teamFoto       = document.getElementById('teamFoto');
        const previewFoto    = document.getElementById('previewFoto');
        const timMediaPreview = document.getElementById('timMediaPreview');
        const timMediaEmpty   = document.getElementById('timMediaEmpty');
        const timMediaActions = document.getElementById('timMediaActions');
        const btnZoomMedia    = document.getElementById('btnZoomMedia');
        const btnRemoveMedia  = document.getElementById('btnRemoveMedia');

        const teamNama    = document.getElementById('teamNama');
        
        // Elemen Jabatan & Divisi (Dropdown & Manual Input)
        const selectJabatan      = document.getElementById('selectJabatan');
        const inputJabatanManual = document.getElementById('inputJabatanManual');
        const selectDivisi       = document.getElementById('selectDivisi');
        const inputDivisiManual  = document.getElementById('inputDivisiManual');

        const STORE_URL   = "{{ route('admin.kelola-tim.store') }}";
        const DEFAULT_FOTO = "{{ asset('image/profile.png') }}";

        // Fungsi interaksi opsi Lainnya pada Jabatan
        function handleJabatanChange(selectObj) {
            if (selectObj.value === 'Lainnya') {
                inputJabatanManual.classList.add('show');
                inputJabatanManual.required = true;
                inputJabatanManual.value = '';
                inputJabatanManual.focus();
            } else {
                inputJabatanManual.classList.remove('show');
                inputJabatanManual.required = false;
                inputJabatanManual.value = selectObj.value;
            }
        }

        // Fungsi interaksi opsi Lainnya pada Divisi
        function handleDivisiChange(selectObj) {
            if (selectObj.value === 'Lainnya') {
                inputDivisiManual.classList.add('show');
                inputDivisiManual.required = true;
                inputDivisiManual.value = '';
                inputDivisiManual.focus();
            } else {
                inputDivisiManual.classList.remove('show');
                inputDivisiManual.required = false;
                inputDivisiManual.value = selectObj.value;
            }
        }

        function setTimMediaPreview(src, fileName) {
            if (src) {
                previewFoto.src = src;
                previewFoto.style.display = 'block';
                timMediaEmpty.style.display = 'none';
                timMediaActions.style.display = 'flex';
                timMediaPreview.classList.add('has-image');
            } else {
                previewFoto.src = DEFAULT_FOTO;
                previewFoto.style.display = 'none';
                timMediaEmpty.style.display = 'block';
                timMediaActions.style.display = 'none';
                timMediaPreview.classList.remove('has-image');
            }
        }

        function removeTimMedia() {
            teamFoto.value = '';
            setTimMediaPreview('', '');
        }

                function openModal(mode, el) {
            timForm.reset();

            if (typeof setTimMediaPreview === 'function') {
                setTimMediaPreview('', '');
            }

            inputJabatanManual.classList.remove('show');
            inputDivisiManual.classList.remove('show');
            inputJabatanManual.required = false;
            inputDivisiManual.required = false;

            if (mode === 'edit' && el) {
                modalTitle.textContent = 'Edit Tim';
                timForm.action = el.dataset.url;
                formMethod.value = 'PUT';

                teamNama.value = el.dataset.nama;
                if (el.dataset.foto) {
                    setTimMediaPreview(el.dataset.foto, 'Ganti Foto');
                } else {
                    setTimMediaPreview('', '');
                }

                // Set logika Jabatan
                const valJabatan = el.dataset.jabatan;
                let optionJabatanExists = false;
                for (let opt of selectJabatan.options) {
                    if (opt.value === valJabatan) {
                        optionJabatanExists = true;
                        break;
                    }
                }
                if (optionJabatanExists) {
                    selectJabatan.value = valJabatan;
                    inputJabatanManual.value = valJabatan;
                } else {
                    selectJabatan.value = 'Lainnya';
                    inputJabatanManual.classList.add('show');
                    inputJabatanManual.required = true;
                    inputJabatanManual.value = valJabatan;
                }

                // Set logika Divisi
                const valDivisi = el.dataset.divisi;
                let optionDivisiExists = false;
                for (let opt of selectDivisi.options) {
                    if (opt.value === valDivisi) {
                        optionDivisiExists = true;
                        break;
                    }
                }
                if (optionDivisiExists) {
                    selectDivisi.value = valDivisi;
                    inputDivisiManual.value = valDivisi;
                } else {
                    selectDivisi.value = 'Lainnya';
                    inputDivisiManual.classList.add('show');
                    inputDivisiManual.required = true;
                    inputDivisiManual.value = valDivisi;
                }

            } else {
                modalTitle.textContent = 'Tambah Tim';
                timForm.action = STORE_URL;
                formMethod.value = '';
                selectJabatan.value = '';
                selectDivisi.value = '';
            }

            timModal.classList.add('show');
        }

        function closeModal() {
            timModal.classList.remove('show');
        }

        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const btnCancelDelete    = document.getElementById('btnCancelDelete');
        const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
        const deleteConfirmTitle = document.getElementById('deleteConfirmTitle');
        const deleteConfirmText  = document.getElementById('deleteConfirmText');
        let formToDelete = null;
        let timDeleteMode = 'single'; // 'single' | 'bulk'

        function openTimDeleteConfirm(title, text) {
            deleteConfirmTitle.textContent = title;
            deleteConfirmText.textContent = text;
            deleteConfirmModal.classList.add('show');
        }

        // Hapus satu anggota tim (tombol tong sampah lama / dipanggil manual)
        function confirmDelete(id) {
            timDeleteMode = 'single';
            formToDelete = document.getElementById('deleteFormTim' + id);
            openTimDeleteConfirm('Hapus Anggota Tim?', 'Yakin ingin menghapus anggota tim ini? Data yang sudah dihapus tidak dapat dikembalikan.');
        }

        // Hapus semua anggota tim yang dicentang (tombol "Hapus Terpilih")
        function confirmBulkDeleteTim() {
            if (timSelectedIds.size === 0) return;
            timDeleteMode = 'bulk';
            openTimDeleteConfirm(
                'Hapus Anggota Tim Terpilih?',
                'Yakin ingin menghapus ' + timSelectedIds.size + ' anggota tim yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.'
            );
        }

        btnCancelDelete.addEventListener('click', function () {
            formToDelete = null;
            timDeleteMode = 'single';
            deleteConfirmModal.classList.remove('show');
        });

        btnConfirmDelete.addEventListener('click', async function () {
            if (timDeleteMode === 'single') {
                if (formToDelete) {
                    formToDelete.submit();
                }
                deleteConfirmModal.classList.remove('show');
                return;
            }

            // Mode massal: kirim form hapus untuk tiap anggota tim yang dicentang
            const ids = Array.from(timSelectedIds);
            if (ids.length === 0) {
                deleteConfirmModal.classList.remove('show');
                return;
            }

            const originalText = btnConfirmDelete.innerHTML;
            btnConfirmDelete.innerHTML = 'Menghapus...';
            btnConfirmDelete.disabled = true;

            let gagal = 0;
            for (const id of ids) {
                const form = document.getElementById('deleteFormTim' + id);
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
                'timBulkDeleteMessage',
                gagal === 0
                    ? berhasil + ' anggota tim berhasil dihapus.'
                    : berhasil + ' dari ' + ids.length + ' anggota tim berhasil dihapus.'
            );

            btnConfirmDelete.innerHTML = originalText;
            btnConfirmDelete.disabled = false;
            deleteConfirmModal.classList.remove('show');
            window.location.reload();
        });

        deleteConfirmModal.addEventListener('click', function (e) {
            if (e.target === deleteConfirmModal && !btnConfirmDelete.disabled) {
                formToDelete = null;
                timDeleteMode = 'single';
                deleteConfirmModal.classList.remove('show');
            }
        });

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

        const zoomFotoModal    = document.getElementById('zoomFotoModal');
        const zoomFotoImg      = document.getElementById('zoomFotoImg');
        const zoomFotoNama     = document.getElementById('zoomFotoNama');
        const zoomFotoInfo     = document.getElementById('zoomFotoInfo');
        const btnCloseZoomFoto = document.getElementById('btnCloseZoomFoto');

        function openZoomFoto(src, nama, jabatan, divisi) {
            zoomFotoImg.src = src;
            zoomFotoImg.alt = nama || '';
            zoomFotoNama.textContent = nama || '';
            zoomFotoInfo.textContent = [jabatan, divisi].filter(Boolean).join(' • ');
            zoomFotoModal.classList.add('show');
        }

        function closeZoomFoto() {
            zoomFotoModal.classList.remove('show');
        }

        btnCloseZoomFoto.addEventListener('click', closeZoomFoto);

        zoomFotoModal.addEventListener('click', function (e) {
            if (e.target === zoomFotoModal) closeZoomFoto();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && zoomFotoModal.classList.contains('show')) closeZoomFoto();
        });

        const timBulkDeleteMessage = sessionStorage.getItem('timBulkDeleteMessage');
        if (timBulkDeleteMessage) {
            sessionStorage.removeItem('timBulkDeleteMessage');
            showSuccessPopup(timBulkDeleteMessage);
        }
        @if(session('success'))
            else {
                showSuccessPopup(@json(session('success')));
            }
        @endif

        teamFoto.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                this.value = '';
                setTimMediaPreview('', '');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                setTimMediaPreview(e.target.result, file.name);
            };
            reader.readAsDataURL(file);
        });

        btnRemoveMedia.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            removeTimMedia();
        });

        timMediaPreview.addEventListener('click', function (e) {
            if (e.target.closest('.tim-media-btn')) return;
            teamFoto.click();
        });

        btnZoomMedia.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            if (!previewFoto.src || previewFoto.style.display === 'none') return;

            zoomFotoImg.src = previewFoto.src;
            zoomFotoImg.alt = teamNama.value || 'Preview Foto';
            zoomFotoNama.textContent = teamNama.value || 'Preview Foto';

            const jabatan = inputJabatanManual.value || selectJabatan.value || '';
            const divisi = inputDivisiManual.value || selectDivisi.value || '';
            zoomFotoInfo.textContent = [jabatan, divisi].filter(Boolean).join(' • ');

            zoomFotoModal.classList.add('show');
        });

        const btnTambahTim = document.getElementById('btnTambahTim');

        if (btnTambahTim) {
            btnTambahTim.addEventListener('click', function (e) {
                e.preventDefault();
                openModal('add');
            });
        }

        document.getElementById('btnCancelModal').addEventListener('click', closeModal);
        document.getElementById('btnCloseModal').addEventListener('click', closeModal);
</script>
@endpush