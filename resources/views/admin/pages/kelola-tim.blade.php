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
        #content main .table-data .order table td:nth-child(1) { width: 60px; text-align: center; } /* No */

        #content main .table-data .order table th:nth-child(2),
        #content main .table-data .order table td:nth-child(2) { width: 30%; } /* Nama */

        #content main .table-data .order table th:nth-child(3),
        #content main .table-data .order table td:nth-child(3) { width: 28%; } /* Jabatan */

        #content main .table-data .order table th:nth-child(4),
        #content main .table-data .order table td:nth-child(4) { width: 25%; } /* Divisi */

        #content main .table-data .order table th:nth-child(5),
        #content main .table-data .order table td:nth-child(5) { width: 110px; text-align: right; padding-right: 16px; } /* Aksi */

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
        #content main .table-data .order table td.col-nama {
            font-weight: 500;
            display: flex;
            align-items: center;
            grid-gap: 10px;
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
        #content main .table-data .order table td.col-aksi .bx {
            cursor: pointer;
            font-size: 18px;
            padding: 6px;
            border-radius: 8px;
            margin-left: 4px;
            transition: transform .15s ease, filter .15s ease;
        }
        #content main .table-data .order table td.col-aksi .bx:hover {
            transform: translateY(-2px);
            filter: brightness(.9);
        }
        #content main .table-data .order table td.col-aksi .bx-edit {
            color: var(--blue);
            background: var(--light-blue);
        }
        #content main .table-data .order table td.col-aksi .bx-trash {
            color: var(--red);
            background: var(--light-orange);
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
            max-width: 480px;
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
                    <i class='bx bxs-plus-circle bx-fade-down-hover' ></i>
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
                        </div>
                    </div>
                    <table id="timTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
                                <th style="text-align: right; padding-right: 16px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="timTableBody">
                            @forelse($teams as $team)
                            <tr class="tim-row" data-nama="{{ strtolower($team->nama) }}" data-jabatan="{{ strtolower($team->jabatan) }}" data-divisi="{{ strtolower($team->divisi) }}">
                                <td class="col-no">{{ $loop->iteration }}</td>
                                <td class="col-nama">
                                    <img class="foto-zoomable" src="{{ $team->foto_url }}" alt="{{ $team->nama }}"
                                    data-jabatan="{{ $team->jabatan }}" data-divisi="{{ $team->divisi }}"
                                    onclick="openZoomFoto(this.src, this.alt, this.dataset.jabatan, this.dataset.divisi)">
                                    {{ $team->nama }}
                                </td>
                                <td>{{ $team->jabatan }}</td>
                                <td class="col-divisi"><span>{{ $team->divisi }}</span></td>
                                <td class="col-aksi">
                                    <i class='bx bx-edit'
                                        title="Edit"
                                        data-id="{{ $team->id }}"
                                        data-nama="{{ $team->nama }}"
                                        data-jabatan="{{ $team->jabatan }}"
                                        data-divisi="{{ $team->divisi }}"
                                        data-foto="{{ $team->foto_url }}"
                                        data-url="{{ route('admin.kelola-tim.update', $team->id) }}"
                                        onclick="openModal('edit', this)"></i>
                                    <i class='bx bx-trash' title="Hapus" onclick="confirmDelete({{ $team->id }})"></i>
                                    <form id="deleteFormTim{{ $team->id }}" action="{{ route('admin.kelola-tim.destroy', $team->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color: var(--dark-grey);">Belum ada anggota tim.</td>
                            </tr>
                            @endforelse
                            <tr class="no-result-row" id="timNoResult" style="display:none;">
                                <td colspan="5">Data tidak ditemukan.</td>
                            </tr>
                        </tbody>
                    </table>
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

                        <div class="form-group">
                            <label for="teamFoto">Foto Profil</label>
                            <div class="upload-zone">
                                <img src="{{ asset('image/profile.png') }}" alt="Preview" class="preview-img" id="previewFoto">
                                <span id="uploadLabel">Klik untuk pilih foto (opsional, default: profile.png)</span>
                                <input type="file" name="foto" id="teamFoto" accept="image/*">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="teamNama">Nama</label>
                            <input type="text" name="nama" id="teamNama" required maxlength="100">
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
                    <h2>Hapus Anggota Tim?</h2>
                    <p>Yakin ingin menghapus anggota tim ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
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

        const timModal   = document.getElementById('timModal');
        const modalTitle = document.getElementById('modalTitle');
        const timForm    = document.getElementById('timForm');
        const formMethod = document.getElementById('formMethod');

        const teamFoto    = document.getElementById('teamFoto');
        const previewFoto = document.getElementById('previewFoto');
        const uploadLabel = document.getElementById('uploadLabel');

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

        function openModal(mode, el) {
            timForm.reset();
            previewFoto.src = DEFAULT_FOTO;
            uploadLabel.textContent = 'Klik untuk pilih foto (opsional, default: profile.png)';

            inputJabatanManual.classList.remove('show');
            inputDivisiManual.classList.remove('show');
            inputJabatanManual.required = false;
            inputDivisiManual.required = false;

            if (mode === 'edit' && el) {
                modalTitle.textContent = 'Edit Tim';
                timForm.action = el.dataset.url;
                formMethod.value = 'PUT';

                teamNama.value    = el.dataset.nama;
                previewFoto.src   = el.dataset.foto;

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
        let formToDelete = null;

        function confirmDelete(id) {
            formToDelete = document.getElementById('deleteFormTim' + id);
            deleteConfirmModal.classList.add('show');
        }

        btnCancelDelete.addEventListener('click', function () {
            formToDelete = null;
            deleteConfirmModal.classList.remove('show');
        });

        btnConfirmDelete.addEventListener('click', function () {
            if (formToDelete) {
                formToDelete.submit();
            }
            deleteConfirmModal.classList.remove('show');
        });

        deleteConfirmModal.addEventListener('click', function (e) {
            if (e.target === deleteConfirmModal) {
                formToDelete = null;
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

        @if(session('success'))
            showSuccessPopup(@json(session('success')));
        @endif

        teamFoto.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                previewFoto.src = e.target.result;
            };
            reader.readAsDataURL(file);
            uploadLabel.textContent = file.name;
        });

        document.getElementById('btnTambahTim').addEventListener('click', function (e) {
            e.preventDefault();
            openModal('add');
        });

        document.getElementById('btnCancelModal').addEventListener('click', closeModal);
        document.getElementById('btnCloseModal').addEventListener('click', closeModal);
</script>
@endpush