@extends('admin.layouts.app')

@section('title', 'Kelola Blog | AdminHub')
@section('page-title', 'Kelola Blog')

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

		#content main .table-data .order {
			flex-grow: 1;
			flex-basis: 500px;
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
		#content main .table-data .order table tr td:first-child {
			display: flex;
			align-items: center;
			grid-gap: 12px;
			padding-left: 6px;
		}
		#content main .table-data .order table td img {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			object-fit: cover;
		}

		/* BLOG TABLE EXTRAS */
		#content main .table-data .order table th,
		#content main .table-data .order table td {
			vertical-align: middle;
		}
		#content main .table-data .order table td.col-no {
			text-align: center;
			width: 40px;
		}
		#content main .table-data .order table td.col-gambar img {
			width: 60px;
			height: 45px;
			border-radius: 8px;
			object-fit: cover;
			display: block;
			cursor: zoom-in;
			transition: transform .15s ease;
		}
		#content main .table-data .order table td.col-gambar img:hover {
			transform: scale(1.08);
		}
		#content main .table-data .order table td.col-judul {
			font-weight: 600;
			max-width: 200px;
		}
		#content main .table-data .order table td.col-deskripsi {
			max-width: 260px;
			color: var(--dark-grey);
			font-size: 13px;
			overflow: hidden;
			text-overflow: ellipsis;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
		}
		#content main .table-data .order table td.col-kategori span {
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
		}
		#content main .table-data .order table td.col-aksi .bx {
			cursor: pointer;
			font-size: 18px;
			padding: 6px;
			border-radius: 8px;
			margin-right: 4px;
		}
		#content main .table-data .order table td.col-aksi .bx-edit {
			color: var(--blue);
			background: var(--light-blue);
		}
		#content main .table-data .order table td.col-aksi .bx-trash {
			color: var(--red);
			background: var(--light-orange);
		}
		#content main .table-data .order table .empty-row td {
			text-align: center;
			padding: 32px 0;
			color: var(--dark-grey);
		}

		/* PAGINATION STYLES */
		.pagination-container {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-top: 24px;
			flex-wrap: wrap;
			gap: 12px;
		}
		.pagination-info {
			font-size: 13px;
			color: var(--dark-grey);
		}
		.pagination-buttons {
			display: flex;
			align-items: center;
			gap: 6px;
		}
		.pagination-buttons button {
			min-width: 34px;
			height: 34px;
			padding: 0 10px;
			border-radius: 8px;
			border: 1px solid var(--grey);
			background: var(--light);
			color: var(--dark);
			font-family: var(--poppins);
			font-size: 13px;
			font-weight: 500;
			cursor: pointer;
			transition: all 0.2s ease;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}
		.pagination-buttons button:hover:not(:disabled) {
			background: var(--grey);
		}
		.pagination-buttons button.active {
			background: var(--blue);
			color: var(--light);
			border-color: var(--blue);
		}
		.pagination-buttons button:disabled {
			opacity: 0.4;
			cursor: not-allowed;
		}

		/* ALERT */
		.alert-box {
			padding: 14px 20px;
			border-radius: 12px;
			margin-top: 24px;
			font-weight: 500;
			background: var(--light-blue);
			color: var(--blue);
		}

		/* MODAL */
		.modal-overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 5000;
			justify-content: center;
			align-items: center;
			padding: 20px;
			box-sizing: border-box;
			transition: left .2s ease, width .2s ease;
		}
		.modal-overlay.show {
			display: flex;
		}
		.modal-box {
			background: var(--light);
			border-radius: 16px;
			padding: 32px;
			width: 100%;
			max-width: 1100px;
			max-height: 94vh;
			overflow-y: auto;
			font-family: var(--poppins);
			color: var(--dark);
			position: relative;
			display: flex;
			flex-direction: column;
		}
		#blogModal .modal-box {
			max-width: 1520px;
			width: 96%;
		}
		.modal-box .form-grid {
			display: grid;
			grid-template-columns: 1fr 1.6fr;
			grid-gap: 32px;
			align-items: stretch;
		}
		.modal-box .form-col-left,
		.modal-box .form-col-right {
			display: flex;
			flex-direction: column;
			min-width: 0;
		}
		.modal-box .form-col-right {
			height: 100%;
		}
		.modal-box .form-col-right .form-group {
			display: flex;
			flex-direction: column;
			flex: 1;
		}
		
		@media screen and (max-width: 1200px) {
			#blogModal .modal-box {
				max-width: 96vw;
			}
			.modal-box .form-grid {
				grid-template-columns: 1fr 1.2fr;
				grid-gap: 24px;
			}
		}
		@media screen and (max-width: 768px) {
			.modal-box, #blogModal .modal-box {
				max-width: 560px;
			}
			.modal-box .form-grid {
				grid-template-columns: 1fr;
			}
			.modal-box .form-col-right {
				height: auto;
			}
		}
		.modal-box h2 {
			font-size: 20px;
			margin-bottom: 20px;
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
		.modal-box select,
		.modal-box textarea {
			width: 100%;
			padding: 10px 14px;
			border-radius: 10px;
			border: 1px solid var(--grey);
			background: var(--grey);
			font-family: var(--poppins);
			font-size: 14px;
			color: var(--dark);
			outline: none;
			box-sizing: border-box;
		}
		.modal-box textarea {
			resize: vertical;
			min-height: 80px;
		}
		.modal-box .field-error {
			color: var(--red);
			font-size: 12px;
			margin-top: 4px;
			display: block;
		}
		.modal-box .modal-actions {
			display: flex;
			justify-content: flex-end;
			grid-gap: 10px;
			margin-top: 24px;
		}
		#blogModal .modal-box form {
			display: flex;
			flex-direction: column;
			flex: 1;
			min-height: 0;
		}
		#blogModal .modal-actions {
			position: sticky;
			bottom: -32px;
			margin: 24px -32px -32px -32px;
			padding: 16px 32px;
			background: var(--light);
			border-top: 1px solid var(--grey);
			border-radius: 0 0 16px 16px;
			z-index: 10;
			flex-shrink: 0;
		}
		.modal-box .btn {
			padding: 10px 20px;
			border-radius: 36px;
			border: none;
			font-weight: 500;
			cursor: pointer;
			font-family: var(--poppins);
			font-size: 14px;
		}
		.modal-box .btn-cancel {
			background: var(--grey);
			color: var(--dark);
		}
		/* Khusus tombol Batal di form Tambah/Edit Blog -> merah */
		#blogModal .btn-cancel {
			background: var(--red);
			color: var(--light);
		}
		#blogModal .btn-cancel:hover {
			filter: brightness(.9);
		}
		.modal-box .btn-save {
			background: var(--blue);
			color: var(--light);
		}

		/* WYSIWYG EDITOR */
		.editor-box {
			border: 1px solid var(--grey);
			border-radius: 10px;
			background: #fff;
			transition: border-color 0.2s;
			display: flex;
			flex-direction: column;
			height: 100%;
			min-height: 460px;
			overflow: hidden;
		}
		.editor-box:focus-within {
			border-color: var(--blue);
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
		}
		.editor-toolbar {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			gap: 6px;
			padding: 8px 12px;
			border-bottom: 1px solid var(--grey);
			background: var(--grey);
			flex-shrink: 0;
		}
		.editor-toolbar select {
			padding: 4px 8px;
			font-size: 13px;
			border-radius: 6px;
			border: 1px solid #cbd5e1;
			background: #fff;
			cursor: pointer;
			outline: none;
			color: var(--dark);
			width: auto;
		}
		.editor-btn {
			background: transparent;
			border: none;
			padding: 4px;
			font-size: 16px;
			cursor: pointer;
			border-radius: 6px;
			color: var(--dark-grey);
			width: 30px;
			height: 30px;
			transition: 0.2s;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}
		.editor-btn:hover { background: #e2e8f0; color: var(--dark); }
		.editor-btn.is-image { color: var(--blue); }
		.editor-divider { width: 1px; height: 18px; background: #cbd5e1; margin: 0 4px; }

		.editor-canvas { position: relative; flex: 1; min-height: 0; display: flex; }
		.editor-content {
			flex: 1; min-height: 220px; overflow-y: auto; padding: 18px 20px;
			font-size: 14px; line-height: 1.7; outline: none; color: var(--dark);
		}
		.editor-content:empty:before { content: attr(data-placeholder); color: #94a3b8; }
		.editor-content img { max-width: 100%; height: auto; border-radius: 6px; cursor: pointer; }
		.editor-content img.is-selected { outline: 2px solid var(--blue); outline-offset: 1px; }

		/* Frame resize gambar */
		.img-frame { position: absolute; display: none; pointer-events: none; z-index: 20; }
		.img-frame.active { display: block; }
		.img-frame .frame-border { position: absolute; inset: 0; border: 1.5px solid var(--blue); border-radius: 4px; }
		.img-frame .handle {
			position: absolute; width: 11px; height: 11px; background: #fff;
			border: 2px solid var(--blue); border-radius: 2px; pointer-events: auto;
		}
		.img-frame .handle.tl { left: -6px; top: -6px; cursor: nwse-resize; }
		.img-frame .handle.tr { right: -6px; top: -6px; cursor: nesw-resize; }
		.img-frame .handle.bl { left: -6px; bottom: -6px; cursor: nesw-resize; }
		.img-frame .handle.br { right: -6px; bottom: -6px; cursor: nwse-resize; }
		.img-frame .handle.mr { right: -6px; top: 50%; margin-top: -5px; cursor: ew-resize; }
		.img-frame .handle.ml { left: -6px; top: 50%; margin-top: -5px; cursor: ew-resize; }

		.img-toolbar {
			position: absolute; display: none; z-index: 30; background: #0f172a; color: #fff;
			border-radius: 10px; padding: 6px; gap: 2px; align-items: center;
			box-shadow: 0 10px 24px rgba(15, 23, 42, 0.28);
		}
		.img-toolbar.active { display: flex; }
		.img-toolbar button {
			background: transparent; border: none; color: #e2e8f0; cursor: pointer;
			padding: 5px 9px; border-radius: 6px; font-size: 12px; font-weight: 600;
			display: inline-flex; align-items: center; gap: 4px; transition: 0.15s;
		}
		.img-toolbar button:hover { background: rgba(255,255,255,0.14); color: #fff; }
		.img-toolbar button.danger:hover { background: var(--red); color: #fff; }
		.img-toolbar .tb-divider { width: 1px; height: 18px; background: rgba(255,255,255,0.2); margin: 0 4px; }
		.img-size-badge {
			position: absolute; background: #0f172a; color: #fff; font-size: 11px; font-weight: 600;
			padding: 3px 8px; border-radius: 6px; display: none; z-index: 31;
		}
		.img-size-badge.active { display: block; }

		/* FILE UPLOADER */
		.modal-box .uploader {
			position: relative;
			border: 2px dashed var(--dark-grey);
			border-radius: 12px;
			background: var(--grey);
			min-height: 170px;
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
		.modal-box .uploader-empty .bx {
			font-size: 34px;
			color: var(--blue);
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
		.modal-box .uploader-preview {
			position: relative;
			width: 100%;
			height: 100%;
		}
		.modal-box .uploader-preview img {
			width: 100%;
			height: 170px;
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
		.modal-box .btn-remove:hover {
			background: var(--red);
		}

		/* IMAGE ZOOM MODE */
		.image-zoom-overlay {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.85);
			z-index: 6000;
			justify-content: center;
			align-items: center;
		}
		.image-zoom-overlay.show {
			display: flex;
		}
		.image-zoom-overlay .image-zoom-stage {
			position: relative;
			display: inline-flex;
			max-width: 90%;
			max-height: 85%;
		}
		.image-zoom-overlay img {
			max-width: 90vw;
			max-height: 85vh;
			border-radius: 10px;
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
			display: block;
		}
		.image-zoom-overlay .image-zoom-close {
			position: absolute;
			top: -14px;
			right: -14px;
			width: 34px;
			height: 34px;
			border-radius: 50%;
			background: var(--red);
			color: var(--light);
			font-size: 20px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 4px 12px rgba(0, 0, 0, .35);
			transition: filter .15s ease;
		}
		.image-zoom-overlay .image-zoom-close:hover {
			filter: brightness(.9);
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
		.modal-box.modal-confirm .btn-danger {
			background: var(--red);
			color: var(--light);
		}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Kelola Blog</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('admin.dashboard') }}">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Kelola Blog</a>
						</li>
					</ul>
				</div>
				<button type="button" class="btn-download" id="btnTambahBlog">
					<i class='bx bxs-plus-circle bx-fade-down-hover' ></i>
					<span class="text">Tambah Blog</span>
				</button>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Daftar Blog</h3>
						<div class="table-toolbar">
							<div class="search-box">
								<i class='bx bx-search'></i>
								<input type="text" id="blogSearch" placeholder="Cari judul blog...">
							</div>
							<select id="blogFilterKategori" class="filter-select">
								<option value="">Semua Kategori</option>
								<option value="project">Project</option>
								<option value="berita">Berita</option>
								<option value="kegiatan">Kegiatan</option>
							</select>
							<!-- FILTER HALAMAN / ENTRIES -->
							<select id="blogPerPage" class="filter-select" title="Tampilkan per halaman">
								<option value="all">Semua</option>
								<option value="5">5 per Hal</option>
								<option value="10">10 per Hal</option>
								<option value="20">20 per Hal</option>
							</select>
						</div>
					</div>
					<table id="blogTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Tanggal Dibuat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="blogTableBody">
							@forelse($blogs as $blog)
							<tr class="blog-row" data-judul="{{ strtolower($blog->judul) }}" data-kategori="{{ strtolower($blog->kategori) }}">
								<td class="col-no">{{ $loop->iteration }}</td>
								<td class="col-gambar">
									<img src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/600x400/png' }}" alt="{{ $blog->judul }}" onclick="openListImageZoom(this.src)">
								</td>
								<td class="col-judul">{{ $blog->judul }}</td>
								<td class="col-kategori"><span>{{ $blog->kategori }}</span></td>
								<td>{{ $blog->created_at->format('d-m-Y') }}</td>
								<td class="col-aksi">
									<i
										class='bx bx-edit'
										title="Edit"
										data-id="{{ $blog->id }}"
										data-judul="{{ $blog->judul }}"
										data-kategori="{{ $blog->kategori }}"
										data-konten="{{ $blog->konten }}"
										data-gambar="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : '' }}"
										data-update-url="{{ route('admin.kelola-blog.update', $blog->id) }}"
										onclick="openEditModal(this)"
									></i>
									<form action="{{ route('admin.kelola-blog.destroy', $blog->id) }}" method="POST" class="form-delete" style="display:inline;">
										@csrf
										@method('DELETE')
										<i class='bx bx-trash' title="Hapus" onclick="confirmDelete(this)"></i>
									</form>
								</td>
							</tr>
							@empty
							<tr class="empty-row">
								<td colspan="6">Belum ada data blog.</td>
							</tr>
							@endforelse
							<tr class="no-result-row" id="blogNoResult" style="display:none;">
								<td colspan="6">Data tidak ditemukan.</td>
							</tr>
						</tbody>
					</table>

					<!-- AREA PAGINASI DINAMIS -->
					<div class="pagination-container" id="paginationWrapper">
						<div class="pagination-info" id="paginationInfo"></div>
						<div class="pagination-buttons" id="paginationButtons"></div>
					</div>
				</div>
			</div>

			<!-- Modal Tambah/Edit Blog -->
			<div class="modal-overlay" id="blogModal">
				<div class="modal-box">
					<h2 id="modalTitle">Tambah Blog</h2>

					@if($errors->any())
						<div class="alert-box" style="background: var(--light-orange); color: var(--red); margin-top: 0; margin-bottom: 16px;">
							<strong>Gagal menyimpan, periksa kembali:</strong>
							<ul style="margin: 6px 0 0 18px; padding: 0;">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form id="blogForm" action="{{ route('admin.kelola-blog.store') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<div id="methodFieldWrapper"></div>
						<input type="hidden" name="status" value="publish">

						<div class="form-grid">
							<div class="form-col-left">
								<div class="form-group">
									<label>Judul</label>
									<input type="text" name="judul" id="inputJudul" value="{{ old('judul') }}" required>
								</div>

								<div class="form-group">
									<label>Kategori</label>
									<select name="kategori" id="inputKategori" required>
										<option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
										<option value="project" {{ old('kategori') === 'project' ? 'selected' : '' }}>Project</option>
										<option value="berita" {{ old('kategori') === 'berita' ? 'selected' : '' }}>Berita</option>
										<option value="kegiatan" {{ old('kategori') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
									</select>
								</div>

								<div class="form-group">
									<label>Gambar Utama</label>
									<div class="uploader" id="uploaderBox">
										<div class="uploader-empty" id="uploaderEmpty">
											<i class='bx bx-cloud-upload'></i>
											<p>Klik atau seret gambar ke sini</p>
											<span>PNG, JPG, JPEG (maks. 2MB)</span>
										</div>
										<div class="uploader-preview" id="uploaderPreview" style="display:none;">
											<img src="" alt="Preview Gambar" id="previewImage">
											<div class="uploader-actions">
												<button type="button" class="btn-icon btn-zoom" id="btnZoomImage" title="Perbesar Gambar">
													<i class='bx bx-fullscreen'></i>
												</button>
												<button type="button" class="btn-icon btn-remove" id="btnRemoveImage" title="Hapus Gambar">
													<i class='bx bx-trash'></i>
												</button>
											</div>
										</div>
										<input type="file" name="gambar" id="inputGambar" accept="image/*" hidden>
									</div>
									<input type="hidden" name="hapus_gambar" id="inputHapusGambar" value="0">
									<span class="field-error" id="gambarHint"></span>
								</div>
							</div>

							<div class="form-col-right">
								<div class="form-group">
									<label>Isi Konten Lengkap</label>
									
									<div class="editor-box" id="chbEditorBox">
										<div class="editor-toolbar">
											<select onchange="formatDoc('formatBlock', this.value); this.selectedIndex=0;" title="Gaya Paragraf">
												<option value="" selected>Normal</option>
												<option value="h2">Heading 2</option>
												<option value="h3">Heading 3</option>
												<option value="h4">Heading 4</option>
												<option value="blockquote">Kutipan</option>
											</select>
											<select onchange="formatDoc('fontSize', this.value); this.selectedIndex=0;" title="Ukuran Huruf">
												<option value="" selected>Ukuran</option>
												<option value="2">Kecil</option>
												<option value="3">Normal</option>
												<option value="5">Besar</option>
												<option value="6">Sangat Besar</option>
											</select>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="formatDoc('bold')" title="Bold"><i class='bx bx-bold'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('italic')" title="Italic"><i class='bx bx-italic'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('underline')" title="Underline"><i class='bx bx-underline'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('strikeThrough')" title="Coret"><i class='bx bx-strikethrough'></i></button>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyLeft')" title="Rata Kiri"><i class='bx bx-align-left'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyCenter')" title="Rata Tengah"><i class='bx bx-align-middle'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyRight')" title="Rata Kanan"><i class='bx bx-align-right'></i></button>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="formatDoc('insertUnorderedList')" title="Bullet List"><i class='bx bx-list-ul'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('insertOrderedList')" title="Numbering"><i class='bx bx-list-ol'></i></button>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="addLink()" title="Link"><i class='bx bx-link'></i></button>
											<button type="button" class="editor-btn is-image" onclick="triggerEditorImage()" title="Sisipkan Gambar"><i class='bx bx-image-add'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('removeFormat')" title="Hapus Format"><i class='bx bx-eraser'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('undo')" title="Undo"><i class='bx bx-undo'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('redo')" title="Redo"><i class='bx bx-redo'></i></button>
										</div>

										<div class="editor-canvas" id="chbEditorCanvas">
											<div class="editor-content" id="inputKontenEditor" contenteditable="true"
												data-placeholder="Tulis isi konten blog di sini... (gambar bisa disisipkan lewat tombol gambar atau paste langsung)"></div>

											{{-- Frame resize gambar --}}
											<div class="img-frame" id="chbImgFrame">
												<div class="frame-border"></div>
												<div class="handle tl" data-dir="tl"></div>
												<div class="handle tr" data-dir="tr"></div>
												<div class="handle bl" data-dir="bl"></div>
												<div class="handle br" data-dir="br"></div>
												<div class="handle ml" data-dir="ml"></div>
												<div class="handle mr" data-dir="mr"></div>
											</div>

											{{-- Toolbar melayang untuk gambar terpilih --}}
											<div class="img-toolbar" id="chbImgToolbar">
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgWidth('25%')">25%</button>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgWidth('50%')">50%</button>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgWidth('75%')">75%</button>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgWidth('100%')">100%</button>
												<div class="tb-divider"></div>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgAlign('left')" title="Rata kiri (teks membungkus)"><i class='bx bx-align-left'></i></button>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgAlign('center')" title="Rata tengah"><i class='bx bx-align-middle'></i></button>
												<button type="button" onmousedown="event.preventDefault()" onclick="setImgAlign('right')" title="Rata kanan (teks membungkus)"><i class='bx bx-align-right'></i></button>
												<div class="tb-divider"></div>
												<button type="button" onmousedown="event.preventDefault()" onclick="resetImgSize()" title="Ukuran asli"><i class='bx bx-reset'></i></button>
												<button type="button" class="danger" onmousedown="event.preventDefault()" onclick="deleteSelectedImg()" title="Hapus gambar"><i class='bx bx-trash'></i> Hapus</button>
											</div>

											<div class="img-size-badge" id="chbImgSizeBadge">0 px</div>
										</div>
									</div>
									<input type="file" id="chbEditorImageInput" accept="image/*" multiple style="display:none" onchange="handleEditorImage(event)">
									
									<textarea name="konten" id="inputKonten" style="display:none;"></textarea>
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

			<!-- Zoom Mode untuk Preview Gambar -->
			<div class="image-zoom-overlay" id="imageZoomOverlay">
				<div class="image-zoom-stage">
					<img src="" alt="Zoom Gambar" id="zoomedImage">
					<span class="image-zoom-close" id="btnCloseZoom"><i class='bx bx-x'></i></span>
				</div>
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2>Hapus Blog Ini?</h2>
					<p>Yakin ingin menghapus blog ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
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
@endsection

@push('scripts')
<script>
		// ===== State editor gambar =====
		let chbSelectedImg = null;
		let chbSavedRange = null;
		let chbResizeState = null;

		// ===== State Paginasi =====
		let currentPage = 1;

		// ===== Sinkronkan lebar modal dengan area konten =====
		function syncModalWithContentArea() {
			const contentEl = document.getElementById('content');
			if (!contentEl) return;
			const rect = contentEl.getBoundingClientRect();
			document.querySelectorAll('.modal-overlay').forEach(function (overlay) {
				overlay.style.left = rect.left + 'px';
				overlay.style.width = rect.width + 'px';
			});
		}
		
		window.addEventListener('resize', syncModalWithContentArea);
		document.addEventListener('DOMContentLoaded', function () {
			syncModalWithContentArea();
			initEditorImageEvents(); 
			applyBlogFilters(); // Jalankan paginasi & filter pertama kali
		});

		const blogModal = document.getElementById('blogModal');
		const modalTitle = document.getElementById('modalTitle');
		const blogForm = document.getElementById('blogForm');
		const methodFieldWrapper = document.getElementById('methodFieldWrapper');
		const gambarHint = document.getElementById('gambarHint');

		// Uploader elements
		const uploaderBox = document.getElementById('uploaderBox');
		const uploaderEmpty = document.getElementById('uploaderEmpty');
		const uploaderPreview = document.getElementById('uploaderPreview');
		const previewImage = document.getElementById('previewImage');
		const inputGambar = document.getElementById('inputGambar');
		const inputHapusGambar = document.getElementById('inputHapusGambar');
		const btnRemoveImage = document.getElementById('btnRemoveImage');
		const btnZoomImage = document.getElementById('btnZoomImage');

		// Zoom mode elements
		const imageZoomOverlay = document.getElementById('imageZoomOverlay');
		const zoomedImage = document.getElementById('zoomedImage');
		const btnCloseZoom = document.getElementById('btnCloseZoom');

		// Modal konfirmasi hapus
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete = document.getElementById('btnCancelDelete');
		const btnConfirmDelete = document.getElementById('btnConfirmDelete');
		let formToDelete = null;

		// Modal notifikasi sukses
		const successModal = document.getElementById('successModal');
		const successMessage = document.getElementById('successMessage');
		const btnCloseSuccess = document.getElementById('btnCloseSuccess');

		let isEditMode = false;

		// ===== Elements Filter & Paginasi =====
		const blogSearchInput = document.getElementById('blogSearch');
		const blogFilterKategori = document.getElementById('blogFilterKategori');
		const blogPerPageSelect = document.getElementById('blogPerPage');
		const blogNoResult = document.getElementById('blogNoResult');
		const paginationInfo = document.getElementById('paginationInfo');
		const paginationButtons = document.getElementById('paginationButtons');

		/* ============================================================
		   FUNGSI FILTER & PAGINASI OTOMATIS (CLIENT-SIDE)
		============================================================ */
		function applyBlogFilters() {
			const keyword = blogSearchInput ? blogSearchInput.value.trim().toLowerCase() : '';
			const kategori = blogFilterKategori ? blogFilterKategori.value.toLowerCase() : '';
			const perPageVal = blogPerPageSelect ? blogPerPageSelect.value : 'all';
			const rows = Array.from(document.querySelectorAll('#blogTableBody .blog-row'));

			// 1. Saring baris sesuai pencarian & kategori
			const filteredRows = rows.filter(function (row) {
				const cocokJudul = row.dataset.judul.includes(keyword);
				const cocokKategori = kategori === '' || row.dataset.kategori === kategori;
				return cocokJudul && cocokKategori;
			});

			// Sembunyikan semua data terlebih dahulu
			rows.forEach(r => r.style.display = 'none');

			const totalData = filteredRows.length;

			if (totalData === 0) {
				if (blogNoResult) blogNoResult.style.display = '';
				if (paginationInfo) paginationInfo.textContent = '';
				if (paginationButtons) paginationButtons.innerHTML = '';
				return;
			} else {
				if (blogNoResult) blogNoResult.style.display = 'none';
			}

			// 2. Hitung jumlah total halaman
			let totalPages = 1;
			let limit = totalData;

			if (perPageVal !== 'all') {
				limit = parseInt(perPageVal, 10);
				totalPages = Math.ceil(totalData / limit);
			}

			// Jaga agar currentPage tidak melebihi totalPages
			if (currentPage > totalPages) currentPage = totalPages;
			if (currentPage < 1) currentPage = 1;

			const startIndex = (perPageVal === 'all') ? 0 : (currentPage - 1) * limit;
			const endIndex = (perPageVal === 'all') ? totalData : Math.min(startIndex + limit, totalData);

			// 3. Tampilkan data untuk halaman aktif saja & sesuaikan No urut
			filteredRows.forEach((row, index) => {
				if (index >= startIndex && index < endIndex) {
					row.style.display = '';
					const colNo = row.querySelector('.col-no');
					if (colNo) {
						colNo.textContent = index + 1;
					}
				}
			});

			// 4. Tampilkan Info Paginasi (contoh: Menampilkan 1-5 dari 6 data)
			if (paginationInfo) {
				paginationInfo.textContent = `Menampilkan ${startIndex + 1} - ${endIndex} dari ${totalData} data`;
			}

			// 5. Render Tombol Paginasi (1, 2, 3...)
			renderPaginationControls(totalPages, perPageVal);
		}

		function renderPaginationControls(totalPages, perPageVal) {
			if (!paginationButtons) return;
			paginationButtons.innerHTML = '';

			// Jika pilih "Semua" atau hanya 1 halaman, tombol paginasi disembunyikan
			if (perPageVal === 'all' || totalPages <= 1) {
				return;
			}

			// Tombol Previous
			const prevBtn = document.createElement('button');
			prevBtn.type = 'button';
			prevBtn.innerHTML = "<i class='bx bx-chevron-left'></i>";
			prevBtn.disabled = currentPage === 1;
			prevBtn.addEventListener('click', () => {
				if (currentPage > 1) {
					currentPage--;
					applyBlogFilters();
				}
			});
			paginationButtons.appendChild(prevBtn);

			// Tombol Nomor Halaman
			for (let i = 1; i <= totalPages; i++) {
				const pageBtn = document.createElement('button');
				pageBtn.type = 'button';
				pageBtn.textContent = i;
				if (i === currentPage) {
					pageBtn.classList.add('active');
				}
				pageBtn.addEventListener('click', () => {
					currentPage = i;
					applyBlogFilters();
				});
				paginationButtons.appendChild(pageBtn);
			}

			// Tombol Next
			const nextBtn = document.createElement('button');
			nextBtn.type = 'button';
			nextBtn.innerHTML = "<i class='bx bx-chevron-right'></i>";
			nextBtn.disabled = currentPage === totalPages;
			nextBtn.addEventListener('click', () => {
				if (currentPage < totalPages) {
					currentPage++;
					applyBlogFilters();
				}
			});
			paginationButtons.appendChild(nextBtn);
		}

		// Event Listener Filter & Pencarian
		if (blogSearchInput) {
			blogSearchInput.addEventListener('input', () => {
				currentPage = 1;
				applyBlogFilters();
			});
		}
		if (blogFilterKategori) {
			blogFilterKategori.addEventListener('change', () => {
				currentPage = 1;
				applyBlogFilters();
			});
		}
		if (blogPerPageSelect) {
			blogPerPageSelect.addEventListener('change', () => {
				currentPage = 1;
				applyBlogFilters();
			});
		}

		/* ============================================================
		   FUNGSI CUSTOM TEXT EDITOR (WYSIWYG)
		============================================================ */
		function formatDoc(cmd, value = null) {
			const editor = document.getElementById('inputKontenEditor');
			editor.focus();
			restoreRange();
			if (value) document.execCommand(cmd, false, value);
			else document.execCommand(cmd, false, null);
			saveRange();
		}

		function addLink() {
			const url = prompt('Masukkan Link/URL:');
			if (url) formatDoc('createLink', url);
		}

		function saveRange() {
			const sel = window.getSelection();
			if (sel && sel.rangeCount > 0) {
				const r = sel.getRangeAt(0);
				if (document.getElementById('inputKontenEditor').contains(r.commonAncestorContainer)) {
					chbSavedRange = r.cloneRange();
				}
			}
		}

		function restoreRange() {
			if (!chbSavedRange) return;
			const sel = window.getSelection();
			sel.removeAllRanges();
			sel.addRange(chbSavedRange);
		}

		function triggerEditorImage() {
			saveRange();
			document.getElementById('chbEditorImageInput').click();
		}

		function handleEditorImage(e) {
			const files = Array.from(e.target.files || []);
			files.forEach(file => {
				if (!file.type.startsWith('image/')) return;
				if (file.size > 3 * 1024 * 1024) {
					alert(`Gambar "${file.name}" melebihi 3MB dan dilewati.`);
					return;
				}
				const reader = new FileReader();
				reader.onload = ev => insertImageToEditor(ev.target.result);
				reader.readAsDataURL(file);
			});
			e.target.value = '';
		}

		function insertImageToEditor(dataUrl) {
			const editor = document.getElementById('inputKontenEditor');
			editor.focus();
			restoreRange();
			const html = `<img src="${dataUrl}" class="chb-img" style="width:60%;height:auto;display:block;margin:10px 0;border-radius:6px;"><p><br></p>`;
			document.execCommand('insertHTML', false, html);
			saveRange();
		}

		function initEditorImageEvents() {
			const editor = document.getElementById('inputKontenEditor');
			const canvas = document.getElementById('chbEditorCanvas');
			const frame = document.getElementById('chbImgFrame');

			editor.addEventListener('paste', function (e) {
				const items = (e.clipboardData || window.clipboardData).items;
				for (let i = 0; i < items.length; i++) {
					if (items[i].type.indexOf('image') !== -1) {
						e.preventDefault();
						const file = items[i].getAsFile();
						const reader = new FileReader();
						reader.onload = ev => insertImageToEditor(ev.target.result);
						reader.readAsDataURL(file);
					}
				}
			});

			editor.addEventListener('click', function (e) {
				if (e.target.tagName === 'IMG') {
					selectEditorImage(e.target);
				} else {
					deselectEditorImage();
					saveRange();
				}
			});

			editor.addEventListener('keyup', saveRange);
			editor.addEventListener('mouseup', saveRange);
			editor.addEventListener('scroll', () => { if (chbSelectedImg) positionImgUI(); });
			editor.addEventListener('input', () => {
				if (chbSelectedImg && !editor.contains(chbSelectedImg)) deselectEditorImage();
			});

			document.addEventListener('keydown', function (e) {
				if (!chbSelectedImg) return;
				if (e.key === 'Delete' || e.key === 'Backspace') {
					e.preventDefault();
					deleteSelectedImg();
				}
				if (e.key === 'Escape') deselectEditorImage();
			});

			frame.querySelectorAll('.handle').forEach(h => {
				h.addEventListener('mousedown', startResize);
			});
			document.addEventListener('mousemove', doResize);
			document.addEventListener('mouseup', stopResize);

			document.addEventListener('mousedown', function (e) {
				if (!chbSelectedImg) return;
				if (canvas.contains(e.target) || document.getElementById('chbImgToolbar').contains(e.target)) return;
				deselectEditorImage();
			});

			window.addEventListener('resize', () => { if (chbSelectedImg) positionImgUI(); });
		}

		function selectEditorImage(img) {
			if (chbSelectedImg && chbSelectedImg !== img) chbSelectedImg.classList.remove('is-selected');
			chbSelectedImg = img;
			img.classList.add('is-selected');
			document.getElementById('chbImgFrame').classList.add('active');
			document.getElementById('chbImgToolbar').classList.add('active');
			positionImgUI();
		}

		function deselectEditorImage() {
			if (chbSelectedImg) chbSelectedImg.classList.remove('is-selected');
			chbSelectedImg = null;
			document.getElementById('chbImgFrame').classList.remove('active');
			document.getElementById('chbImgToolbar').classList.remove('active');
			document.getElementById('chbImgSizeBadge').classList.remove('active');
		}

		function positionImgUI() {
			if (!chbSelectedImg) return;
			const canvas = document.getElementById('chbEditorCanvas');
			const frame = document.getElementById('chbImgFrame');
			const toolbar = document.getElementById('chbImgToolbar');

			const cRect = canvas.getBoundingClientRect();
			const iRect = chbSelectedImg.getBoundingClientRect();

			const top = iRect.top - cRect.top;
			const left = iRect.left - cRect.left;

			frame.style.left = left + 'px';
			frame.style.top = top + 'px';
			frame.style.width = iRect.width + 'px';
			frame.style.height = iRect.height + 'px';

			const tbHeight = toolbar.offsetHeight || 40;
			let tbTop = top - tbHeight - 8;
			if (tbTop < 4) tbTop = top + iRect.height + 8;
			toolbar.style.top = tbTop + 'px';

			let tbLeft = left;
			const maxLeft = canvas.offsetWidth - (toolbar.offsetWidth || 320) - 8;
			if (tbLeft > maxLeft) tbLeft = Math.max(4, maxLeft);
			if (tbLeft < 4) tbLeft = 4;
			toolbar.style.left = tbLeft + 'px';

			const visible = iRect.bottom > cRect.top + 4 && iRect.top < cRect.bottom - 4;
			frame.style.visibility = visible ? 'visible' : 'hidden';
			toolbar.style.visibility = visible ? 'visible' : 'hidden';
		}

		function setImgWidth(w) {
			if (!chbSelectedImg) return;
			chbSelectedImg.style.width = w;
			chbSelectedImg.style.height = 'auto';
			setTimeout(positionImgUI, 30);
		}

		function resetImgSize() {
			if (!chbSelectedImg) return;
			chbSelectedImg.style.width = '';
			chbSelectedImg.style.height = '';
			chbSelectedImg.style.maxWidth = '100%';
			setTimeout(positionImgUI, 30);
		}

		function setImgAlign(pos) {
			if (!chbSelectedImg) return;
			const img = chbSelectedImg;
			img.style.float = 'none';
			img.style.display = 'block';
			img.style.margin = '10px 0';
			if (pos === 'center') {
				img.style.margin = '10px auto';
			} else if (pos === 'left') {
				img.style.float = 'left';
				img.style.display = 'inline';
				img.style.margin = '6px 16px 10px 0';
			} else if (pos === 'right') {
				img.style.float = 'right';
				img.style.display = 'inline';
				img.style.margin = '6px 0 10px 16px';
			}
			setTimeout(positionImgUI, 30);
		}

		function deleteSelectedImg() {
			if (!chbSelectedImg) return;
			const img = chbSelectedImg;
			deselectEditorImage();
			img.remove();
			document.getElementById('inputKontenEditor').focus();
		}

		function startResize(e) {
			if (!chbSelectedImg) return;
			e.preventDefault();
			e.stopPropagation();
			const rect = chbSelectedImg.getBoundingClientRect();
			chbResizeState = {
				dir: e.currentTarget.dataset.dir,
				startX: e.clientX,
				startW: rect.width,
				ratio: rect.height / rect.width
			};
			document.body.style.userSelect = 'none';
			document.getElementById('chbImgSizeBadge').classList.add('active');
		}

		function doResize(e) {
			if (!chbResizeState || !chbSelectedImg) return;
			const dx = e.clientX - chbResizeState.startX;
			const grow = (chbResizeState.dir === 'tl' || chbResizeState.dir === 'bl' || chbResizeState.dir === 'ml') ? -1 : 1;
			let newW = chbResizeState.startW + (dx * grow);

			const maxW = document.getElementById('inputKontenEditor').clientWidth - 40;
			if (newW < 60) newW = 60;
			if (newW > maxW) newW = maxW;

			chbSelectedImg.style.width = Math.round(newW) + 'px';
			chbSelectedImg.style.height = 'auto';

			const badge = document.getElementById('chbImgSizeBadge');
			badge.textContent = `${Math.round(newW)} × ${Math.round(newW * chbResizeState.ratio)} px`;
			const canvas = document.getElementById('chbEditorCanvas');
			const cRect = canvas.getBoundingClientRect();
			const iRect = chbSelectedImg.getBoundingClientRect();
			badge.style.left = (iRect.left - cRect.left) + 'px';
			badge.style.top = (iRect.top - cRect.top + iRect.height + 8) + 'px';

			positionImgUI();
		}

		function stopResize() {
			if (!chbResizeState) return;
			chbResizeState = null;
			document.body.style.userSelect = '';
			setTimeout(() => document.getElementById('chbImgSizeBadge').classList.remove('active'), 600);
			positionImgUI();
		}


		// ===== Uploader helpers =====
		function resetUploader() {
			previewImage.src = '';
			uploaderPreview.style.display = 'none';
			uploaderEmpty.style.display = 'block';
		}

		function showImagePreview(file) {
			const reader = new FileReader();
			reader.onload = function (e) {
				previewImage.src = e.target.result;
				uploaderEmpty.style.display = 'none';
				uploaderPreview.style.display = 'block';
			};
			reader.readAsDataURL(file);
		}

		uploaderBox.addEventListener('click', function (e) {
			if (e.target.closest('.btn-icon')) return;
			inputGambar.click();
		});

		inputGambar.addEventListener('change', function () {
			const file = this.files[0];
			if (file) {
				showImagePreview(file);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
			}
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
			if (file) {
				inputGambar.files = e.dataTransfer.files;
				showImagePreview(file);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
			}
		});

		btnRemoveImage.addEventListener('click', function (e) {
			e.stopPropagation();
			inputGambar.value = '';
			resetUploader();
			inputHapusGambar.value = '1';
		});

		// ===== Zoom Mode =====
		btnZoomImage.addEventListener('click', function (e) {
			e.stopPropagation();
			zoomedImage.src = previewImage.src;
			imageZoomOverlay.classList.add('show');
		});
		btnCloseZoom.addEventListener('click', function () {
			imageZoomOverlay.classList.remove('show');
		});
		imageZoomOverlay.addEventListener('click', function (e) {
			if (e.target === imageZoomOverlay) imageZoomOverlay.classList.remove('show');
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && imageZoomOverlay.classList.contains('show')) {
				imageZoomOverlay.classList.remove('show');
			}
		});

		// Zoom gambar dari daftar/tabel blog
		function openListImageZoom(src) {
			zoomedImage.src = src;
			imageZoomOverlay.classList.add('show');
		}

		// ===== Modal open/close =====
		function openAddModal() {
			isEditMode = false;
			syncModalWithContentArea();
			modalTitle.textContent = 'Tambah Blog';
			blogForm.reset();
			blogForm.action = "{{ route('admin.kelola-blog.store') }}";
			methodFieldWrapper.innerHTML = '';

			document.getElementById('inputKontenEditor').innerHTML = '';
			document.getElementById('inputKonten').value = '';
			deselectEditorImage();
			chbSavedRange = null;

			resetUploader();
			inputHapusGambar.value = '0';
			gambarHint.textContent = '';

			blogModal.classList.add('show');
		}

		function openEditModal(el) {
			isEditMode = true;
			syncModalWithContentArea();

			const data = {
				judul: el.dataset.judul,
				kategori: el.dataset.kategori,
				konten: el.dataset.konten,
				gambar: el.dataset.gambar,
				updateUrl: el.dataset.updateUrl,
			};

			modalTitle.textContent = 'Edit Blog';
			blogForm.reset();
			blogForm.action = data.updateUrl;

			methodFieldWrapper.innerHTML = '<input type="hidden" name="_method" value="PUT">';

			document.getElementById('inputJudul').value = data.judul;
			document.getElementById('inputKategori').value = data.kategori;

			document.getElementById('inputKontenEditor').innerHTML = data.konten || '';
			document.getElementById('inputKonten').value = data.konten || '';
			deselectEditorImage();
			chbSavedRange = null;

			inputHapusGambar.value = '0';
			gambarHint.textContent = 'Kosongkan jika tidak ingin mengganti gambar.';

			if (data.gambar) {
				previewImage.src = data.gambar;
				uploaderEmpty.style.display = 'none';
				uploaderPreview.style.display = 'block';
			} else {
				resetUploader();
			}

			blogModal.classList.add('show');
		}

		function closeModal() {
			deselectEditorImage();
			blogModal.classList.remove('show');
		}

		function confirmDelete(icon) {
			formToDelete = icon.closest('form');
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

		// ===== Popup Notifikasi Sukses =====
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

		@if(session('success'))
			showSuccessPopup(@json(session('success')));
		@endif

		// ===== Validasi sebelum submit =====
		blogForm.addEventListener('submit', function (e) {
			const editorHtml = document.getElementById('inputKontenEditor').innerHTML;
			document.getElementById('inputKonten').value = editorHtml;

			const editorText = document.getElementById('inputKontenEditor').textContent.trim();
			if (editorText.length === 0 && editorHtml.indexOf('<img') === -1) {
				e.preventDefault();
				alert('Isi konten tidak boleh kosong.');
				return;
			}

			if (!isEditMode && !inputGambar.files.length) {
				e.preventDefault();
				gambarHint.textContent = 'Gambar utama wajib diunggah.';
				gambarHint.style.color = 'var(--red)';
			}
		});

		document.getElementById('btnTambahBlog').addEventListener('click', function (e) {
			e.preventDefault();
			openAddModal();
		});

		document.getElementById('btnCancelModal').addEventListener('click', closeModal);

		@if($errors->any())
			openAddModal();
			document.getElementById('inputKontenEditor').innerHTML = @json(old('konten', ''));
			document.getElementById('inputKonten').value = @json(old('konten', ''));
		@endif
</script>
@endpush