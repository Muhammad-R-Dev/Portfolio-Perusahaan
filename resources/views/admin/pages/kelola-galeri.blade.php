@extends('admin.layouts.app')

@section('title', 'Kelola Galeri | AdminHub')
@section('page-title', 'Kelola Galeri')
@section('search-id', 'gallerySearch')
@section('search-placeholder', 'Cari galeri...')

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

		/* GALLERY FILTER TABS */
		#content main .gallery-filter {
			display: flex;
			align-items: center;
			grid-gap: 12px;
			margin-top: 36px;
			flex-wrap: wrap;
		}
		#content main .gallery-filter .filter-btn {
			padding: 8px 20px;
			border-radius: 36px;
			border: none;
			background: var(--light);
			color: var(--dark);
			font-family: var(--poppins);
			font-size: 14px;
			cursor: pointer;
			transition: .2s ease;
		}
		#content main .gallery-filter .filter-btn:hover {
			background: var(--light-blue);
			color: var(--blue);
		}
		#content main .gallery-filter .filter-btn.active {
			background: var(--blue);
			color: var(--light);
		}

		/* GALLERY GRID */
		#content main .gallery-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
			grid-gap: 24px;
			margin-top: 24px;
		}
		#content main .gallery-card {
			background: var(--light);
			border-radius: 16px;
			overflow: hidden;
			transition: transform .2s ease, box-shadow .2s ease;
			position: relative;
		}
		#content main .gallery-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 10px 24px rgba(0,0,0,.08);
		}
		#content main .gallery-card .thumb {
			width: 100%;
			height: 160px;
			position: relative;
			overflow: hidden;
		}
		#content main .gallery-card .thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			transition: transform .3s ease;
		}
		#content main .gallery-card:hover .thumb img {
			transform: scale(1.08);
		}
		#content main .gallery-card .thumb .category-tag {
			position: absolute;
			top: 10px;
			left: 10px;
			background: rgba(0,0,0,.55);
			color: var(--light);
			font-size: 11px;
			font-weight: 600;
			padding: 4px 12px;
			border-radius: 20px;
		}
		#content main .gallery-card .thumb .card-actions {
			position: absolute;
			top: 10px;
			right: 10px;
			display: flex;
			grid-gap: 6px;
			opacity: 0;
			transition: opacity .2s ease;
		}
		#content main .gallery-card:hover .thumb .card-actions {
			opacity: 1;
		}
		#content main .gallery-card .thumb .card-actions button {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			border: none;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			font-size: 15px;
		}
		#content main .gallery-card .thumb .card-actions .btn-edit {
			background: var(--light);
			color: var(--blue);
		}
		#content main .gallery-card .thumb .card-actions .btn-delete {
			background: var(--red);
			color: var(--light);
		}
		#content main .gallery-card .info {
			padding: 14px 16px;
		}
		#content main .gallery-card .info h4 {
			font-size: 15px;
			font-weight: 600;
			color: var(--dark);
			margin-bottom: 4px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}
		#content main .gallery-card .info p {
			font-size: 12px;
			color: var(--dark-grey);
		}

		#content main .empty-state {
			display: none;
			text-align: center;
			padding: 60px 20px;
			color: var(--dark-grey);
		}
		#content main .empty-state.show {
			display: block;
		}
		#content main .empty-state .bx {
			font-size: 48px;
			margin-bottom: 12px;
		}

		.alert-flash {
			margin-top: 24px;
			padding: 14px 20px;
			border-radius: 12px;
			background: var(--light-blue);
			color: var(--blue);
			font-weight: 500;
		}

		/* MODAL UPLOAD */
		.modal-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0,0,0,.5);
			z-index: 3000;
			align-items: center;
			justify-content: center;
		}
		.modal-overlay.show {
			display: flex;
		}
		.modal-box {
			background: var(--light);
			width: 100%;
			max-width: 460px;
			border-radius: 16px;
			padding: 28px;
			font-family: var(--poppins);
			max-height: 90vh;
			overflow-y: auto;
		}
		.modal-box h2 {
			font-size: 20px;
			color: var(--dark);
			margin-bottom: 20px;
		}
		.modal-box .form-group {
			margin-bottom: 16px;
		}
		.modal-box label {
			display: block;
			font-size: 13px;
			font-weight: 600;
			color: var(--dark);
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
			outline: none;
			font-family: var(--poppins);
			font-size: 14px;
			color: var(--dark);
		}
		.modal-box .upload-zone {
			border: 2px dashed var(--dark-grey);
			border-radius: 12px;
			padding: 24px;
			text-align: center;
			cursor: pointer;
			position: relative;
			color: var(--dark-grey);
			transition: .2s ease;
		}
		.modal-box .upload-zone:hover {
			border-color: var(--blue);
			color: var(--blue);
		}
		.modal-box .upload-zone .bx {
			font-size: 32px;
			display: block;
			margin-bottom: 8px;
		}
		.modal-box .upload-zone input[type="file"] {
			position: absolute;
			inset: 0;
			opacity: 0;
			cursor: pointer;
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

		.modal-box .preview-wrap {
			position: relative;
			display: none;
			margin-top: 12px;
		}
		.modal-box .preview-wrap.show {
			display: block;
		}
		.modal-box .preview-img {
			display: block;
			width: 100%;
			max-height: 180px;
			object-fit: cover;
			border-radius: 12px;
		}
		.modal-box .btn-remove-preview {
			position: absolute;
			top: 8px;
			right: 8px;
			width: 28px;
			height: 28px;
			border-radius: 50%;
			border: none;
			background: rgba(0, 0, 0, .55);
			color: var(--light);
			font-size: 16px;
			line-height: 1;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			transition: background .15s ease;
		}
		.modal-box .btn-remove-preview:hover {
			background: var(--red);
		}
		.modal-box .form-error {
			color: var(--red);
			font-size: 12px;
			margin-top: 6px;
			display: block;
		}
		.modal-box .modal-actions {
			display: flex;
			justify-content: flex-end;
			grid-gap: 10px;
			margin-top: 24px;
		}
		.modal-box .modal-actions button {
			padding: 10px 22px;
			border-radius: 36px;
			border: none;
			font-family: var(--poppins);
			font-size: 14px;
			font-weight: 500;
			cursor: pointer;
		}
		.modal-box .btn-cancel {
			background: var(--grey);
			color: var(--dark);
		}
		/* Khusus tombol Batal di form Tambah/Edit Galeri -> merah */
		#galleryModal .btn-cancel {
			background: var(--red);
			color: var(--light);
		}
		#galleryModal .btn-cancel:hover {
			filter: brightness(.9);
		}
		.modal-box .btn-save {
			background: var(--blue);
			color: var(--light);
		}

		#content main .menu, #content nav .menu {
			display: none;
			list-style-type: none;
			padding-left: 20px;
			margin-top: 5px;
			position: absolute;
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			border-radius: 5px;
			width: 200px;
		}
		#content main .menu a , #content nav .menu a {
			color: white;
			text-decoration: none;
			display: block;
			padding: 8px 16px;
		}
		#content main .menu a:hover , #content nav .menu a:hover {
			background-color: #444;
		}
		#content main .menu-link , #content nav .menu-link {
			margin: 5px;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
			text-decoration: none;
			color: #007bff;
		}
		#content main .menu-link:hover, #content nav .menu-link:hover {
			text-decoration: underline;
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

		/* GALLERY TABLE LIST */
		#content main .table-section {
			margin-top: 40px;
			background: var(--light);
			border-radius: 20px;
			padding: 24px;
		}
		#content main .table-section .table-toolbar {
			display: flex;
			align-items: center;
			justify-content: space-between;
			flex-wrap: wrap;
			grid-gap: 12px;
			margin-bottom: 20px;
		}
		#content main .table-section .table-toolbar h3 {
			margin-right: auto;
			font-size: 18px;
			font-weight: 600;
			color: var(--dark);
		}
		#content main .table-section .table-toolbar .toolbar-controls {
			display: flex;
			align-items: center;
			grid-gap: 10px;
			flex-wrap: wrap;
		}
		#content main .table-section .search-box {
			display: flex;
			align-items: center;
			grid-gap: 8px;
			background: var(--grey);
			border-radius: 36px;
			padding: 0 16px;
			height: 38px;
		}
		#content main .table-section .search-box .bx {
			font-size: 16px;
			color: var(--dark-grey);
		}
		#content main .table-section .search-box input {
			border: none;
			background: transparent;
			outline: none;
			font-family: var(--poppins);
			font-size: 13px;
			color: var(--dark);
			width: 180px;
		}
		#content main .table-section select.filter-select {
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
		#content main .table-responsive {
			overflow-x: auto;
		}
		#content main .gallery-table {
			width: 100%;
			border-collapse: collapse;
			min-width: 620px;
		}
		#content main .gallery-table caption {
			text-align: left;
			font-size: 18px;
			font-weight: 600;
			color: var(--dark);
			padding: 14px 16px 18px;
			caption-side: top;
		}
		#content main .gallery-table thead th {
			text-align: left;
			font-size: 13px;
			font-weight: 600;
			color: var(--dark-grey);
			text-transform: uppercase;
			letter-spacing: .02em;
			padding: 14px 16px;
			border-bottom: 1px solid var(--grey);
			white-space: nowrap;
		}
		#content main .gallery-table tbody td {
			padding: 12px 16px;
			border-bottom: 1px solid var(--grey);
			color: var(--dark);
			font-size: 14px;
			vertical-align: middle;
		}
		#content main .gallery-table tbody tr:last-child td {
			border-bottom: none;
		}
		#content main .gallery-table tbody tr:hover {
			background: var(--light-blue);
		}
		#content main .gallery-table .table-thumb {
			width: 64px;
			height: 64px;
			object-fit: cover;
			border-radius: 10px;
			cursor: zoom-in;
			display: block;
			transition: transform .2s ease, box-shadow .2s ease;
		}
		#content main .gallery-table .table-thumb:hover {
			transform: scale(1.06);
			box-shadow: 0 6px 16px rgba(0,0,0,.15);
		}
		#content main .gallery-table .table-category-tag {
			display: inline-block;
			background: var(--light-blue);
			color: var(--blue);
			font-size: 12px;
			font-weight: 600;
			padding: 4px 14px;
			border-radius: 20px;
			white-space: nowrap;
		}
		#content main .gallery-table .table-actions {
			display: flex;
			grid-gap: 8px;
		}
		#content main .gallery-table .table-actions button {
			width: 32px;
			height: 32px;
			border-radius: 8px;
			border: none;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			font-size: 15px;
		}
		#content main .gallery-table .table-actions .btn-edit {
			background: var(--light-blue);
			color: var(--blue);
		}
		#content main .gallery-table .table-actions .btn-delete {
			background: var(--light-orange);
			color: var(--red);
		}
		#content main .gallery-table .table-empty {
			text-align: center;
			padding: 40px 16px;
			color: var(--dark-grey);
		}
		#content main .gallery-table tbody tr.row-hidden {
			display: none;
		}

		/* PAGINATION */
		#content main .table-section .table-pagination {
			display: flex;
			justify-content: flex-end;
			align-items: center;
			grid-gap: 6px;
			flex-wrap: wrap;
			margin-top: 20px;
		}
		#content main .table-section .table-pagination .page-btn {
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
		#content main .table-section .table-pagination .page-btn:hover:not(:disabled) {
			background: var(--light-blue);
			color: var(--blue);
		}
		#content main .table-section .table-pagination .page-btn.active {
			background: var(--blue);
			color: var(--light);
			font-weight: 600;
		}
		#content main .table-section .table-pagination .page-btn:disabled {
			opacity: .4;
			cursor: not-allowed;
		}

		/* ZOOM MODE MODAL */
		.zoom-modal-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0,0,0,.85);
			z-index: 4000;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			cursor: zoom-out;
		}
		.zoom-modal-overlay.show {
			display: flex;
		}
		.zoom-modal-overlay .zoom-stage {
			max-width: 90vw;
			max-height: 85vh;
			display: flex;
			flex-direction: column;
			align-items: center;
			transform: scale(.94);
			transition: transform .25s ease;
		}
		.zoom-modal-overlay.show .zoom-stage {
			transform: scale(1);
		}
		.zoom-modal-overlay .zoom-image-wrap {
			position: relative;
			display: inline-flex;
			max-width: 90vw;
			max-height: 85vh;
		}
		.zoom-modal-overlay img {
			max-width: 90vw;
			max-height: 85vh;
			border-radius: 12px;
			box-shadow: 0 20px 60px rgba(0,0,0,.5);
			cursor: default;
			display: block;
		}
		.zoom-modal-overlay .zoom-caption {
			position: absolute;
			left: 0;
			right: 0;
			bottom: 0;
			padding: 32px 20px 16px;
			border-radius: 0 0 12px 12px;
			background: linear-gradient(to top, rgba(0, 0, 0, .85) 0%, rgba(0, 0, 0, .55) 55%, rgba(0, 0, 0, 0) 100%);
			text-align: left;
			cursor: default;
			pointer-events: none;
		}
		.zoom-modal-overlay .zoom-caption h4 {
			color: var(--light);
			font-family: var(--poppins);
			font-size: 17px;
			font-weight: 600;
			margin: 0 0 6px;
		}
		.zoom-modal-overlay .zoom-caption span {
			display: inline-block;
			background: var(--light);
			color: var(--blue);
			font-size: 12px;
			font-weight: 600;
			padding: 4px 14px;
			border-radius: 20px;
			pointer-events: auto;
		}
		.zoom-modal-overlay .btn-zoom-close {
			position: absolute;
			top: -14px;
			right: -14px;
			width: 34px;
			height: 34px;
			border-radius: 50%;
			border: 2px solid var(--light);
			background: var(--dark);
			color: var(--light);
			font-size: 18px;
			cursor: pointer;
			display: flex;
			align-items: center;
			justify-content: center;
			box-shadow: 0 4px 12px rgba(0,0,0,.35);
		}
		.zoom-modal-overlay .btn-zoom-close:hover {
			background: var(--red);
		}

		@media screen and (max-width: 576px) {
			#content main .gallery-table {
				min-width: 560px;
			}
		}

</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Kelola Galeri</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('admin.dashboard') }}">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Kelola Galeri</a>
						</li>
					</ul>
				</div>
				<button type="button" class="btn-download" id="btnAddGallery">
					<i class='bx bxs-plus-circle bx-fade-down-hover' ></i>
					<span class="text">Tambah Foto</span>
				</button>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-image' ></i>
					<span class="text">
						<h3 id="statTotal">{{ $totalFoto }}</h3>
						<p>Total Foto</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-category' ></i>
					<span class="text">
						<h3>{{ $totalKategori }}</h3>
						<p>Kategori</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-cloud-upload' ></i>
					<span class="text">
						<h3>{{ $bulanIni }}</h3>
						<p>Diunggah Bulan Ini</p>
					</span>
				</li>
			</ul>

			<!-- Form hapus tersembunyi (dipakai tombol Hapus pada tabel) -->
			<div style="display:none;">
				@forelse($galleries as $gallery)
				<form id="deleteFormGaleri{{ $gallery->id }}" action="{{ route('admin.kelola-galeri.destroy', $gallery->id) }}" method="POST">
					@csrf
					@method('DELETE')
				</form>
				@empty
				@endforelse
			</div>

			<div class="empty-state" id="emptyState">
				<i class='bx bx-image-alt'></i>
				<p>Tidak ada foto pada kategori ini.</p>
			</div>

			<!-- Daftar Galeri (Tabel) -->
			<div class="table-section">
				<div class="table-toolbar">
					<h3>Daftar Foto Galeri</h3>
					<div class="toolbar-controls">
						<div class="search-box">
							<i class='bx bx-search'></i>
							<input type="text" id="galleryTableSearch" placeholder="Cari judul foto...">
						</div>
						<select id="galleryFilterKategori" class="filter-select">
							<option value="">Semua Kategori</option>
							<option value="kegiatan">Kegiatan</option>
							<option value="fasilitas">Fasilitas</option>
							<option value="tim">Tim</option>
							<option value="acara">Acara</option>
						</select>
						<select id="galleryFilterPerPage" class="filter-select">
							<option value="">Semua</option>
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
						</select>
					</div>
				</div>
				<div class="table-responsive">
					<table class="gallery-table" id="galleryTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($galleries as $index => $gallery)
							<tr class="gallery-row" data-category="{{ $gallery->kategori }}" data-title="{{ $gallery->judul }}">
								<td>{{ $index + 1 }}</td>
								<td>
									<img src="{{ $gallery->foto_url }}" alt="{{ $gallery->judul }}" class="table-thumb"
										data-zoom
										data-zoom-title="{{ $gallery->judul }}"
										data-zoom-category="{{ $gallery->kategori_label }}">
								</td>
								<td>{{ $gallery->judul }}</td>
								<td><span class="table-category-tag">{{ $gallery->kategori_label }}</span></td>
								<td>
									<div class="table-actions">
										<button type="button" class="btn-edit" title="Edit"
											data-id="{{ $gallery->id }}"
											data-judul="{{ $gallery->judul }}"
											data-kategori="{{ $gallery->kategori }}"
											data-foto="{{ $gallery->foto_url }}"
											data-url="{{ route('admin.kelola-galeri.update', $gallery->id) }}">
											<i class='bx bx-edit'></i>
										</button>
										<button type="button" class="btn-delete" title="Hapus" onclick="confirmDeleteGaleri('{{ $gallery->id }}')">
											<i class='bx bx-trash'></i>
										</button>
									</div>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="5" class="table-empty">Belum ada foto galeri.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<div class="table-pagination" id="galleryPagination"></div>
			</div>

			<!-- Modal Zoom Mode Foto -->
			<div class="zoom-modal-overlay" id="zoomModal">
				<div class="zoom-stage">
					<div class="zoom-image-wrap">
						<img src="" alt="" id="zoomImage">
						<button type="button" class="btn-zoom-close" id="btnZoomClose" aria-label="Tutup">&times;</button>
						<div class="zoom-caption">
							<h4 id="zoomTitle"></h4>
							<span id="zoomCategory"></span>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Tambah/Edit Foto Galeri -->
			<div class="modal-overlay" id="galleryModal">
				<div class="modal-box">
					<h2 id="modalTitle">Tambah Foto Galeri</h2>
					<form id="galleryForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.kelola-galeri.store') }}">
						@csrf
						<input type="hidden" name="_method" id="formMethod" value="">

						<div class="form-group">
							<label for="photoTitle">Judul Foto</label>
							<input type="text" name="judul" id="photoTitle" required maxlength="150">
						</div>

						<div class="form-group">
							<label for="photoCategory">Kategori</label>
							<select name="kategori" id="photoCategory" required>
								<option value="kegiatan">Kegiatan</option>
								<option value="fasilitas">Fasilitas</option>
								<option value="tim">Tim</option>
								<option value="acara">Acara</option>
							</select>
						</div>

						<div class="form-group">
							<label>Foto</label>
							<div class="upload-zone">
								<i class='bx bx-cloud-upload'></i>
								<span id="uploadLabel">Klik atau seret foto ke sini</span>
								<input type="file" name="foto" id="photoInput" accept="image/*">
							</div>
							<div class="preview-wrap" id="previewWrap">
								<img src="" alt="Preview" class="preview-img" id="previewImg">
								<button type="button" class="btn-remove-preview" id="btnRemovePreview" title="Batal foto">&times;</button>
							</div>
							<input type="hidden" name="hapus_gambar" id="hapusGambarInput" value="0">
						</div>

						<div class="modal-actions">
							<button type="button" class="btn-cancel" id="btnCancelModal">Batal</button>
							<button type="submit" class="btn-save">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2>Hapus Foto?</h2>
					<p>Yakin ingin menghapus foto ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
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
@endsection

@push('scripts')
<script>
		/* ================= KELOLA GALERI (khusus halaman ini) ================= */

		const galleryTableRows = () => Array.from(document.querySelectorAll('#galleryTable tbody .gallery-row'));
		const emptyState = document.getElementById('emptyState');
		const gallerySearch = document.getElementById('gallerySearch');
		const galleryTableSearch = document.getElementById('galleryTableSearch');
		const galleryFilterKategori = document.getElementById('galleryFilterKategori');
		const galleryFilterPerPage = document.getElementById('galleryFilterPerPage');
		const galleryPagination = document.getElementById('galleryPagination');

		let galleryCurrentPage = 1;

		function getGalleryFilteredRows() {
			const keywordNav = gallerySearch ? gallerySearch.value.trim().toLowerCase() : '';
			const keywordTabel = galleryTableSearch ? galleryTableSearch.value.trim().toLowerCase() : '';
			const keyword = keywordTabel || keywordNav;
			const kategori = galleryFilterKategori ? galleryFilterKategori.value.toLowerCase() : '';

			return galleryTableRows().filter(row => {
				const cocokJudul = row.dataset.title.toLowerCase().includes(keyword);
				const cocokKategori = kategori === '' || row.dataset.category.toLowerCase() === kategori;
				return cocokJudul && cocokKategori;
			});
		}

		function applyFilters(resetPage) {
			if (resetPage) {
				galleryCurrentPage = 1;
			}

			const allRows      = galleryTableRows();
			const filteredRows = getGalleryFilteredRows();
			const perPageValue = galleryFilterPerPage ? galleryFilterPerPage.value : '';
			const perPage      = perPageValue === '' ? filteredRows.length : parseInt(perPageValue, 10);
			const totalPages   = perPage > 0 ? Math.max(1, Math.ceil(filteredRows.length / perPage)) : 1;

			if (galleryCurrentPage > totalPages) {
				galleryCurrentPage = totalPages;
			}
			if (galleryCurrentPage < 1) {
				galleryCurrentPage = 1;
			}

			// Sembunyikan semua baris dahulu
			allRows.forEach(row => row.classList.add('row-hidden'));

			// Tampilkan hanya baris pada halaman aktif
			const start = perPage > 0 ? (galleryCurrentPage - 1) * perPage : 0;
			const end   = perPage > 0 ? start + perPage : filteredRows.length;

			filteredRows.slice(start, end).forEach(row => row.classList.remove('row-hidden'));

			emptyState.classList.toggle('show', filteredRows.length === 0);

			renderGalleryPagination(filteredRows.length, perPage, totalPages);
		}

		function renderGalleryPagination(totalItems, perPage, totalPages) {
			if (!galleryPagination) return;
			galleryPagination.innerHTML = '';

			// "Semua" atau data muat dalam satu halaman -> tidak perlu navigasi
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
						galleryCurrentPage = page;
						applyFilters(false);
					});
				}
				return btn;
			};

			galleryPagination.appendChild(buatTombol('<', galleryCurrentPage - 1, { disabled: galleryCurrentPage === 1 }));

			for (let i = 1; i <= totalPages; i++) {
				galleryPagination.appendChild(buatTombol(i, i, { active: i === galleryCurrentPage }));
			}

			galleryPagination.appendChild(buatTombol('>', galleryCurrentPage + 1, { disabled: galleryCurrentPage === totalPages }));
		}

		// Pencarian (kolom tabel & kolom navbar, keduanya otomatis)
		if (galleryTableSearch) {
			galleryTableSearch.addEventListener('input', function () { applyFilters(true); });
		}
		if (gallerySearch) {
			gallerySearch.addEventListener('input', function () { applyFilters(true); });
		}
		if (galleryFilterKategori) {
			galleryFilterKategori.addEventListener('change', function () { applyFilters(true); });
		}
		if (galleryFilterPerPage) {
			galleryFilterPerPage.addEventListener('change', function () { applyFilters(true); });
		}
		const navSearchForm = document.querySelector('#content nav form');
		if (navSearchForm) {
			navSearchForm.addEventListener('submit', function (e) {
				e.preventDefault();
				applyFilters(true);
			});
		}

		// Hapus foto — modal konfirmasi
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete    = document.getElementById('btnCancelDelete');
		const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
		let formToDelete = null;

		function confirmDeleteGaleri(id) {
			formToDelete = document.getElementById('deleteFormGaleri' + id);
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

		// Modal notifikasi sukses (tambah / update / hapus)
		const successModal   = document.getElementById('successModal');
		const successMessage = document.getElementById('successMessage');
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

		@if(session('success'))
			showSuccessPopup(@json(session('success')));
		@endif

		/* ---------- MODAL TAMBAH / EDIT FOTO ---------- */

		const galleryModal   = document.getElementById('galleryModal');
		const btnAddGallery  = document.getElementById('btnAddGallery');
		const btnCancelModal = document.getElementById('btnCancelModal');
		const galleryForm    = document.getElementById('galleryForm');
		const modalTitle     = document.getElementById('modalTitle');
		const formMethod     = document.getElementById('formMethod');

		const photoTitle    = document.getElementById('photoTitle');
		const photoCategory = document.getElementById('photoCategory');
		const photoInput    = document.getElementById('photoInput');
		const previewImg    = document.getElementById('previewImg');
		const previewWrap   = document.getElementById('previewWrap');
		const uploadLabel   = document.getElementById('uploadLabel');
		const hapusGambarInput  = document.getElementById('hapusGambarInput');
		const btnRemovePreview  = document.getElementById('btnRemovePreview');

		const STORE_URL = "{{ route('admin.kelola-galeri.store') }}";

		function openModal(mode, data = null) {
			galleryForm.reset();
			previewWrap.classList.remove('show');
			previewImg.src = '';
			uploadLabel.textContent = 'Klik atau seret foto ke sini';
			photoInput.required = true;
			hapusGambarInput.value = '0';

			if (mode === 'edit' && data) {
				modalTitle.textContent = 'Edit Foto Galeri';
				galleryForm.action = data.url;
				formMethod.value = 'PUT';
				photoInput.required = false; // opsional saat edit

				photoTitle.value = data.judul;
				photoCategory.value = data.kategori;
				previewImg.src = data.foto;
				previewWrap.classList.add('show');
			} else {
				modalTitle.textContent = 'Tambah Foto Galeri';
				galleryForm.action = STORE_URL;
				formMethod.value = '';
			}

			galleryModal.classList.add('show');
		}

		function closeModal() {
			galleryModal.classList.remove('show');
		}

		btnAddGallery.addEventListener('click', () => openModal('add'));
		btnCancelModal.addEventListener('click', closeModal);

		// Edit foto (delegasi event, berlaku untuk grid & tabel)
		document.addEventListener('click', function (e) {
			const editBtn = e.target.closest('.btn-edit');
			if (!editBtn) return;
			openModal('edit', {
				id: editBtn.dataset.id,
				judul: editBtn.dataset.judul,
				kategori: editBtn.dataset.kategori,
				foto: editBtn.dataset.foto,
				url: editBtn.dataset.url,
			});
		});

		// Preview foto sebelum disimpan
		photoInput.addEventListener('change', function () {
			const file = this.files[0];
			if (!file) return;
			const reader = new FileReader();
			reader.onload = function (e) {
				previewImg.src = e.target.result;
				previewWrap.classList.add('show');
				uploadLabel.textContent = file.name;
				hapusGambarInput.value = '0';
			};
			reader.readAsDataURL(file);
		});

		// Tombol silang di pojok kanan atas foto -> batalkan foto yang dipilih/ditampilkan
		btnRemovePreview.addEventListener('click', function () {
			photoInput.value = '';
			previewImg.src = '';
			previewWrap.classList.remove('show');
			uploadLabel.textContent = 'Klik atau seret foto ke sini';
			// Menandai foto lama (saat edit) untuk dihapus jika form disimpan tanpa foto baru
			hapusGambarInput.value = '1';
		});

		/* ---------- ZOOM MODE FOTO ---------- */
		const zoomModal    = document.getElementById('zoomModal');
		const zoomImage    = document.getElementById('zoomImage');
		const zoomTitle    = document.getElementById('zoomTitle');
		const zoomCategory = document.getElementById('zoomCategory');
		const btnZoomClose = document.getElementById('btnZoomClose');

		function openZoom(src, title, category) {
			zoomImage.src = src;
			zoomImage.alt = title || '';
			zoomTitle.textContent = title || '';
			zoomCategory.textContent = category || '';
			zoomModal.classList.add('show');
		}

		function closeZoom() {
			zoomModal.classList.remove('show');
			zoomImage.src = '';
		}

		document.addEventListener('click', function (e) {
			const zoomTarget = e.target.closest('[data-zoom]');
			if (!zoomTarget) return;
			openZoom(zoomTarget.src, zoomTarget.dataset.zoomTitle, zoomTarget.dataset.zoomCategory);
		});

		if (btnZoomClose) btnZoomClose.addEventListener('click', closeZoom);
		if (zoomModal) {
			zoomModal.addEventListener('click', function (e) {
				if (e.target === zoomModal) closeZoom();
			});
		}
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && zoomModal.classList.contains('show')) closeZoom();
		});

		// Inisialisasi awal
		applyFilters(true);

		// Fungsi buka/tutup menu generik
		function toggleMenu(menuId) {
		  var menu = document.getElementById(menuId);
		  var allMenus = document.querySelectorAll('.menu');

		  allMenus.forEach(function(m) {
			if (m !== menu) {
			  m.style.display = 'none';
			}
		  });

		  if (menu.style.display === 'none' || menu.style.display === '') {
			menu.style.display = 'block';
		  } else {
			menu.style.display = 'none';
		  }
		}

		document.addEventListener("DOMContentLoaded", function() {
		  var allMenus = document.querySelectorAll('.menu');
		  allMenus.forEach(function(menu) {
			menu.style.display = 'none';
		  });
		});
</script>
@endpush