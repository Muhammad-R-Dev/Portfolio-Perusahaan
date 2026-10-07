@extends('admin.layouts.app')

@section('title', 'Kelola Galeri | Admin Astabrata Teknologi')
@section('page-title', 'Kelola Galeri')
@section('search-id', 'gallerySearch')
@section('search-placeholder', 'Cari galeri...')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
		/* ===== Modal Crop Gambar (bebas: landscape / potret / 1:1 / bebas) ===== */
		.crop-modal-box { max-width: 580px; width: 92%; }
		.crop-modal-body { margin-bottom: 4px; }
		.crop-container {
			width: 100%; max-height: 420px; min-height: 260px;
			background: transparent; overflow: hidden; border-radius: 12px;
		}
		.crop-container img { display: block; max-width: 100%; }
		.crop-hint { margin-top: 10px; font-size: 12px; color: var(--dark-grey); text-align: center; }
		.crop-container.crop-circle .cropper-view-box,
		.crop-container.crop-circle .cropper-face { border-radius: 50%; }
		.crop-ratio-options {
			display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; justify-content: center;
		}
		.crop-ratio-btn {
			padding: 6px 16px; border-radius: 20px; border: 1px solid var(--grey);
			background: var(--light); cursor: pointer; font-size: 12px;
			font-family: var(--poppins); color: var(--dark); transition: .15s ease;
		}
		.crop-ratio-btn.active { background: var(--blue); color: var(--light); border-color: var(--blue); }
		/* Pastikan modal crop selalu tampil di DEPAN modal form tambah/edit (#galleryModal pakai z-index 5000) */
		#cropModal { z-index: 5600; }

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
			max-width: 760px;
			border-radius: 18px;
			padding: 28px;
			font-family: var(--poppins);
			max-height: 90vh;
			overflow-y: auto;
			box-shadow: 0 20px 60px rgba(0,0,0,.16);
		}
		/* Judul modal - dipaksa tetap gelap agar tidak putih/hilang saat dark mode */
		#galleryModal .modal-box h2,
		#galleryModal #modalTitle {
			color: var(--dark) !important;
			margin: 0 0 24px;
		}

		/* FORM TAMBAH / EDIT GALERI - INPUT KIRI & MEDIA FOTO KANAN */
		#galleryModal .gallery-form-layout {
			display: grid;
			grid-template-columns: minmax(0, 1.45fr) minmax(320px, 380px);
			gap: 28px;
			align-items: stretch;
			margin-top: 4px;
		}
		#galleryModal .gallery-form-left,
		#galleryModal .gallery-form-right {
			min-width: 0;
		}
		#galleryModal .gallery-form-right .form-group {
			margin-bottom: 0;
		}

		/* Menyeragamkan tampilan label & input/select agar sejajar dan rapi */
		#galleryModal .gallery-form-left .form-group {
			margin-top: 18px;
			margin-bottom: 20px;
		}
		#galleryModal .gallery-form-left .form-group:first-child {
			margin-top: 0;
		}
		#galleryModal .gallery-form-left .form-group:last-child {
			margin-bottom: 0;
		}
		#galleryModal .gallery-form-left .form-group label {
			display: block;
			margin-top: 4px;
			margin-bottom: 10px;
			font-size: 13px;
			font-weight: 600;
			color: var(--dark) !important;
		}
		#galleryModal .gallery-form-left .form-group input[type="text"],
		#galleryModal .gallery-form-left .form-group select {
			display: block;
			width: 100%;
			height: 44px;
			padding: 0 14px;
			box-sizing: border-box;
			border: 1px solid var(--grey);
			border-radius: 10px;
			background: var(--light) !important;
			color: var(--dark) !important;
			font-family: var(--poppins);
			font-size: 14px;
			line-height: 44px;
		}
		#galleryModal .gallery-form-left .form-group select {
			cursor: pointer;
		}
		#galleryModal .gallery-form-left .form-group input[type="text"]:focus,
		#galleryModal .gallery-form-left .form-group select:focus {
			outline: none;
			border-color: var(--blue);
		}

		#galleryModal .gallery-media-card {
			border: 1px solid var(--grey);
			background: var(--light);
			border-radius: 14px;
			padding: 16px;
		}
		#galleryModal .gallery-media-card .media-title {
			font-size: 13px;
			font-weight: 600;
			color: var(--dark);
			margin-bottom: 10px;
		}

		#galleryModal .gallery-media-preview {
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
		#galleryModal .gallery-media-preview.has-image {
			border-style: solid;
			border-color: var(--grey);
		}

		#galleryModal .gallery-media-preview img {
			width: 100%;
			height: 250px;
			object-fit: cover;
			display: block;
		}
		#galleryModal .gallery-media-empty {
			text-align: center;
			color: var(--dark-grey);
			padding: 18px;
		}
		#galleryModal .gallery-media-shape {
			width: 110px; height: 90px; margin: 0 auto 10px;
			border: 2px dashed var(--blue); border-radius: 8px;
			background: transparent; display: flex; align-items: center; justify-content: center;
		}
		#galleryModal .gallery-media-shape .bx { font-size: 28px; color: var(--blue); margin: 0; }
		#galleryModal .gallery-media-empty strong {
			display: block;
			color: var(--dark);
			font-size: 13px;
			margin-bottom: 4px;
		}
		#galleryModal .gallery-media-empty span {
			display: block;
			font-size: 11px;
			line-height: 1.5;
		}
		#galleryModal .gallery-media-empty .gallery-media-size-hint {
			margin-top: 4px;
			font-weight: 600;
			color: var(--blue);
		}

		#galleryModal .gallery-media-actions {
			position: absolute;
			top: 10px;
			right: 10px;
			display: flex;
			gap: 6px;
			z-index: 3;
			pointer-events: none;
		}
		#galleryModal .gallery-media-btn {
			width: 32px;
			height: 32px;
			border: none;
			border-radius: 8px;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			background: rgba(15, 23, 42, .72);
			color: #fff;
			cursor: pointer;
			font-size: 15px;
			pointer-events: auto;
			transition: background .15s ease;
		}
		#galleryModal .gallery-media-btn:hover {
			background: var(--blue);
		}
		#galleryModal .gallery-media-btn.danger:hover {
			background: var(--red);
		}

		#galleryModal .gallery-media-preview.upload-clickable {
			cursor: pointer;
			transition: border-color .15s ease, background .15s ease;
		}
		#galleryModal .gallery-media-preview.upload-clickable:hover {
			border-color: var(--blue);
			background: var(--light-blue);
		}
		#galleryModal .gallery-media-preview.upload-clickable.has-image {
			background: var(--grey);
		}
		#galleryModal .gallery-media-preview.upload-clickable.has-image:hover {
			background: var(--grey);
		}

		#galleryModal .gallery-media-file-input {
			position: absolute !important;
			inset: 0 !important;
			width: 100% !important;
			height: 100% !important;
			opacity: 0 !important;
			cursor: pointer !important;
			z-index: 1 !important;
		}

		#galleryModal .gallery-media-meta {
			margin-top: 8px;
			font-size: 11px;
			color: var(--dark-grey);
			text-align: center;
			line-height: 1.5;
		}

		@media screen and (max-width: 700px) {
			#galleryModal .gallery-form-layout {
				grid-template-columns: 1fr;
			}
			#galleryModal .gallery-media-card {
				order: -1;
			}
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
		/* Tombol Batal/Terapkan pada modal Crop Foto -> merah & biru, konsisten di mode terang/gelap */
		#cropModal .btn-cancel,
		#cropModal .btn-cancel:hover {
			background: var(--red);
			color: var(--light);
		}
		#cropModal .btn-save,
		#cropModal .btn-save:hover {
			background: var(--blue);
			color: var(--light);
		}

		/* ============================================================
		   DARK MODE - TOMBOL TETAP KONTRAS (TIDAK PUTIH POLOS)
		   ============================================================ */

		/* Tombol "Tambah Foto" tetap biru, tulisan putih */
		body.dark #content main .head-title .btn-download,
		body.dark #content main .head-title .btn-download:hover {
			background: var(--blue) !important;
			color: #fff !important;
		}

		/* Tombol "Edit" di tabel & di kartu galeri tetap kontras */
		body.dark #content main .gallery-table .table-actions .btn-edit,
		body.dark #content main .gallery-table .table-actions .btn-edit:hover {
			background: var(--blue) !important;
			color: #fff !important;
		}
		body.dark #content main .gallery-card .thumb .card-actions .btn-edit {
			background: #fff !important;
			color: var(--blue) !important;
		}
		body.dark #content main .gallery-card .thumb .card-actions .btn-delete {
			background: var(--red) !important;
			color: #fff !important;
		}

		/* Tombol "Hapus" (mode pilih & hapus terpilih) tetap kontras */
		body.dark #content main .table-section .btn-select-mode {
			background: var(--red) !important;
			color: #fff !important;
		}
		/* Tombol berubah jadi "Batal" saat mode pilih aktif -> warna kuning */
		body.dark #content main .table-section .btn-select-mode.active {
			background: var(--yellow) !important;
			color: #1a1a1a !important;
		}
		/* Tombol "Hapus (n)" di sebelahnya -> merah polos, tanpa efek hover ganti warna lagi */
		body.dark #content main .table-section .btn-bulk-delete,
		body.dark #content main .table-section .btn-bulk-delete:hover:not(:disabled) {
			background: var(--red) !important;
			color: #fff !important;
		}

		/* Tombol "Batal" tetap merah, tulisan putih */
		body.dark #galleryModal .btn-cancel,
		body.dark #galleryModal .btn-cancel:hover {
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
		body.dark .modal-box.modal-confirm .btn-danger,
		body.dark .modal-box.modal-confirm .btn-danger:hover {
			background: var(--red) !important;
			color: #fff !important;
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
		/* TOMBOL MODE PILIH (HAPUS) & HAPUS TERPILIH */
		#content main .table-section .btn-select-mode,
		#content main .table-section .btn-bulk-delete {
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
		#content main .table-section .btn-select-mode {
			background: var(--red);
			color: var(--light);
		}
		#content main .table-section .btn-select-mode:hover {
			opacity: .9;
		}
		#content main .table-section .btn-select-mode.active {
			background: var(--dark);
			color: var(--light);
		}
		#content main .table-section .bulk-actions-group {
			display: none;
			align-items: center;
			grid-gap: 10px;
		}
		#content main .table-section .bulk-actions-group.show {
			display: flex;
		}
		#content main .table-section .btn-bulk-delete {
			background: var(--light-orange);
			color: var(--red);
		}
		#content main .table-section .btn-bulk-delete:hover:not(:disabled) {
			background: var(--red);
			color: var(--light);
		}
		#content main .table-section .btn-bulk-delete:disabled {
			opacity: .5;
			cursor: not-allowed;
		}
		#content main .gallery-table thead th#galleryAksiHeader.select-mode-header {
			display: flex;
			align-items: center;
			grid-gap: 8px;
		}
		#content main .gallery-table td.select-cell {
			text-align: left;
		}
		#content main .gallery-table th input[type="checkbox"],
		#content main .gallery-table td.select-cell input[type="checkbox"] {
			width: 16px;
			height: 16px;
			cursor: pointer;
			accent-color: var(--blue);
		}
		#content main .gallery-table tbody tr.row-selected {
			background: transparent;
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
			border-bottom: none;
			white-space: nowrap;
		}
		#content main .gallery-table tbody td {
			padding: 12px 16px;
			border-bottom: none;
			color: var(--dark);
			font-size: 14px;
			vertical-align: middle;
		}
		#content main .gallery-table tbody tr:last-child td {
			border-bottom: none;
		}
		#content main .gallery-table tbody tr:hover {
			background: transparent;
		}
		#content main .gallery-table .table-thumb {
			width: 64px;
			height: 64px;
			object-fit: cover;
			border-radius: 10px;
			cursor: zoom-in;
			display: block;
		}
		#content main .gallery-table .table-thumb:hover {
			transform: none;
			box-shadow: none;
		}
		/* Kategori: teks biasa, sama seperti kolom Judul (tanpa badge) */
		#content main .gallery-table .table-category-tag {
			display: inline;
			background: none;
			color: inherit;
			font-size: inherit;
			font-weight: inherit;
			padding: 0;
			border-radius: 0;
			white-space: nowrap;
		}
		#content main .gallery-table .table-actions {
			display: flex;
			grid-gap: 8px;
		}
		#content main .gallery-table .table-actions .btn-edit {
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

		/* Responsive modal form */
		@media screen and (max-width: 700px) {
			#galleryModal .modal-box {
				max-width: calc(100% - 24px);
				padding: 22px;
			}
			#galleryModal .gallery-form-layout {
				grid-template-columns: 1fr;
				gap: 18px;
			}
			#galleryModal .upload-zone {
				min-height: 240px;
			}
		}

		@media screen and (max-width: 576px) {
			#content main .gallery-table {
				min-width: 560px;
			}
		}


		/* ============================================================
		   FORM TAMBAH/EDIT GALERI DIPERBESAR (seperti Kelola Layanan)
		   Overlay layar penuh (sidebar tertutup abu-abu transparan), kotak form memenuhi area konten
		   ============================================================ */
		body.chb-modal-open { overflow: hidden; }
		#galleryModal {
			padding: 32px;
			align-items: stretch;
			box-sizing: border-box;
			z-index: 5000;
		}
		#galleryModal .modal-box {
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
		#galleryModal .modal-box h2,
		#galleryModal #modalTitle { flex-shrink: 0; font-size: 22px; margin: 0 0 20px; }
		#galleryModal .modal-box form { flex: 1; min-height: 0; display: flex; flex-direction: column; }
		#galleryModal .gallery-form-layout {
			flex: 1;
			min-height: 0;
			overflow-y: auto;
			overflow-x: hidden;
			overscroll-behavior: contain;
			grid-template-columns: minmax(0, 1.45fr) minmax(320px, 0.9fr);
			gap: 32px;
			margin-top: 0;
			align-items: stretch;
		}
		#galleryModal .gallery-form-left .form-group input[type="text"],
		#galleryModal .gallery-form-left .form-group select {
			height: 50px;
			line-height: 50px;
			font-size: 15px;
		}
		#galleryModal .gallery-form-right { display: flex; flex-direction: column; }
		#galleryModal .gallery-media-card { flex: 1; display: flex; flex-direction: column; }
		#galleryModal .gallery-media-preview { flex: 1; min-height: 340px; }
		#galleryModal .gallery-media-preview img {
			position: absolute;
			inset: 0;
			width: 100%;
			height: 100%;
		}
		/* Tombol Batal/Simpan tetap di bawah, tidak ikut ter-scroll */
		#galleryModal .modal-actions {
			flex-shrink: 0;
			margin: 16px -40px -28px -40px;
			padding: 16px 40px;
			border-top: 1px solid var(--grey);
			background: var(--light);
			border-radius: 0 0 18px 18px;
		}
		@media screen and (max-width: 768px) {
			#galleryModal { padding: 12px; }
			#galleryModal .modal-box { max-width: none; padding: 20px 16px; }
			#galleryModal .gallery-form-layout { grid-template-columns: 1fr; gap: 16px; }
			#galleryModal .gallery-media-card { order: -1; flex: none; }
			#galleryModal .gallery-media-preview { min-height: 240px; }
			#galleryModal .modal-actions { margin: 14px -16px -20px -16px; padding: 14px 16px; }
		}


		/* ===== Layout kartu daftar (seperti Kelola Proyek, Blog, Layanan & Tim) ===== */
		#content main .head-title.page-header-fixed { position: fixed; z-index: 60; padding: 10px 0; margin: 0; }
		@media screen and (min-width: 769px) {
			#content main .table-section { isolation: isolate; padding: 0 24px 24px 24px; overflow-y: auto; overflow-x: hidden; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; }
			#content main .table-section .table-toolbar {
				position: sticky; top: 0; z-index: 5; background: var(--light, #fff) !important; background-clip: padding-box;
				margin: 0 -24px 0 -24px; padding: 24px 24px 16px 24px;
			}
			#content main .table-section .table-responsive { overflow: visible; }
			#content main .table-section table thead th {
				position: sticky; top: var(--head-h, 0px); z-index: 4; background: var(--light, #fff) !important;
				background-clip: padding-box; box-shadow: 0 1px 0 var(--grey);
			}
		}

		/* Input kategori manual ("Lainnya...") */
		#galleryModal .gallery-form-left .form-group input#photoCategoryLainnya {
			margin-top: 10px;
		}

		/* ============================================================
		   DARK MODE - PALET LEBIH TERANG & BERLAPIS (slate-navy)
		   (sama seperti Kelola Proyek, Layanan, Blog & Tim)
		     halaman  #1b2538  <  kartu  #25324a  <  input/hover  #34456a
		   Hanya berlaku di area konten & modal halaman ini (sidebar tidak diubah).
		   ============================================================ */
		body.dark #content,
		body.dark #content main,
		body.dark .modal-overlay,
		body.dark .zoom-modal-overlay {
			--light: #25324a;          /* kartu, modal, header tabel */
			--grey: #34456a;           /* input, hover baris, border */
			--dark: #eef2f9;           /* teks utama */
			--dark-grey: #a9b8d2;      /* teks sekunder */
			--light-blue: #2f4a7a;     /* baris terpilih, tag kategori */
			--light-orange: #4d3b33;
			--blue: #4f8ef7;
			--red: #ef5a5a;
		}
		body.dark #content {
			background: #1b2538 !important;
		}
		body.dark #content main .gallery-table tbody tr:hover {
			background: #2d3c5a !important;
		}
		body.dark .modal-box {
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
		}
		body.dark #galleryModal .gallery-form-left .form-group input[type="text"],
		body.dark #galleryModal .gallery-form-left .form-group select {
			background: var(--grey) !important;
			border-color: var(--grey) !important;
		}
		body.dark #galleryModal .gallery-form-left .form-group input[type="text"]:focus,
		body.dark #galleryModal .gallery-form-left .form-group select:focus {
			border-color: #4f8ef7 !important;
			box-shadow: 0 0 0 3px rgba(79, 142, 247, 0.25);
		}
		body.dark #galleryModal .gallery-media-preview {
			border-color: #4a5f8a;
		}

		/* ============================================================
		   LIGHT MODE - AREA BERLAPIS AGAR MUDAH DIBEDAKAN
		     halaman  #e9eef5  <  kartu putih (+ border & bayangan)  <  input #f1f5f9
		   ============================================================ */
		body:not(.dark) #content,
		body:not(.dark) #content main,
		body:not(.dark) .modal-overlay,
		body:not(.dark) .zoom-modal-overlay {
			--light: #ffffff;          /* kartu, modal, header tabel */
			--grey: #e2e8f0;           /* input, border */
			--dark: #1e293b;           /* teks utama */
			--dark-grey: #64748b;      /* teks sekunder */
			--light-blue: #dbeafe;     /* baris terpilih, tag kategori */
			--light-orange: #fee2e2;
		}
		body:not(.dark) #content {
			background: #e9eef5 !important;
		}
		body:not(.dark) #content main .box-info li,
		body:not(.dark) #content main .table-section,
		body:not(.dark) #content main .gallery-card {
			border: 1px solid #d5deea;
			box-shadow: 0 2px 8px rgba(30, 41, 59, 0.07);
		}
		body:not(.dark) #content main .gallery-table tbody tr:hover {
			background: #f1f5f9;
		}
		body:not(.dark) #galleryModal .gallery-form-left .form-group input[type="text"],
		body:not(.dark) #galleryModal .gallery-form-left .form-group select {
			background: #f1f5f9 !important;
			border-color: #cbd5e1 !important;
		}
		body:not(.dark) #galleryModal .gallery-form-left .form-group input[type="text"]:focus,
		body:not(.dark) #galleryModal .gallery-form-left .form-group select:focus {
			background: #fff !important;
			border-color: #3b82f6 !important;
		}
		body:not(.dark) #galleryModal .gallery-media-card {
			border-color: #d5deea;
		}
		body:not(.dark) #galleryModal .gallery-media-preview {
			background: #f1f5f9;
			border-color: #cbd5e1;
		}

		/* Garis pembatas antar baris daftar (seperti daftar Tim) */
		#content main .gallery-table thead th {
			border-bottom: 1px solid var(--grey);
		}
		#content main .gallery-table tbody tr:not(:last-child) td {
			border-bottom: 1px solid var(--grey);
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
					<i class='bx bxs-plus-circle' ></i>
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
			@php
				// Kategori bawaan + kategori buatan sendiri yang sudah dipakai di data galeri
				$kategoriBawaan = ['kegiatan', 'fasilitas', 'tim', 'acara'];
				$kategoriLain = collect($galleries)->pluck('kategori')
					->map(fn ($k) => trim((string) $k))
					->filter()
					->unique(fn ($k) => strtolower($k))
					->reject(fn ($k) => in_array(strtolower($k), $kategoriBawaan))
					->values();
			@endphp
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
							@foreach($kategoriLain as $kat)
							<option value="{{ strtolower($kat) }}">{{ ucfirst($kat) }}</option>
							@endforeach
						</select>
						<select id="galleryFilterPerPage" class="filter-select">
							<option value="">Semua</option>
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
						</select>
						<button type="button" class="btn-select-mode" id="btnToggleGallerySelectMode" onclick="toggleGallerySelectMode()">
							<i class='bx bx-list-check'></i> <span id="btnToggleGallerySelectModeText">Hapus</span>
						</button>
						<div class="bulk-actions-group" id="galleryBulkActionsGroup">
							<button type="button" class="btn-bulk-delete" id="btnGalleryBulkDelete" disabled onclick="confirmBulkDeleteGaleri()">
								<i class='bx bx-trash'></i> Hapus (<span id="galleryBulkDeleteCount">0</span>)
							</button>
						</div>
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
								<th id="galleryAksiHeader">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($galleries as $index => $gallery)
							<tr class="gallery-row" data-id="{{ $gallery->id }}" data-category="{{ $gallery->kategori }}" data-title="{{ $gallery->judul }}">
								<td>{{ $index + 1 }}</td>
								<td>
									<img src="{{ $gallery->foto_url }}" alt="{{ $gallery->judul }}" class="table-thumb"
										data-zoom
										data-zoom-title="{{ $gallery->judul }}"
										data-zoom-category="{{ in_array(strtolower($gallery->kategori), $kategoriBawaan) ? $gallery->kategori_label : ucfirst($gallery->kategori) }}">
								</td>
								<td>{{ $gallery->judul }}</td>
								<td><span class="table-category-tag">{{ in_array(strtolower($gallery->kategori), $kategoriBawaan) ? $gallery->kategori_label : ucfirst($gallery->kategori) }}</span></td>
								<td class="action-cell">
									<div class="table-actions">
										<button type="button" class="btn-edit" title="Edit"
											data-id="{{ $gallery->id }}"
											data-judul="{{ $gallery->judul }}"
											data-kategori="{{ $gallery->kategori }}"
											data-foto="{{ $gallery->foto_url }}"
											data-url="{{ route('admin.kelola-galeri.update', $gallery->id) }}">
											Edit
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

						<div class="gallery-form-layout">
							<div class="gallery-form-left">
								<div class="form-group">
									<label for="photoTitle">Judul Foto</label>
									<input type="text" name="judul" id="photoTitle" required maxlength="150" placeholder="Masukkan judul foto">
								</div>

								<div class="form-group">
									<label for="photoCategory">Kategori</label>
									<select name="kategori" id="photoCategory" required>
										<option value="kegiatan">Kegiatan</option>
										<option value="fasilitas">Fasilitas</option>
										<option value="tim">Tim</option>
										<option value="acara">Acara</option>
										@foreach($kategoriLain as $kat)
										<option value="{{ $kat }}">{{ ucfirst($kat) }}</option>
										@endforeach
										<option value="__lainnya__">Lainnya... (ketik sendiri)</option>
									</select>
									<input type="text" id="photoCategoryLainnya" maxlength="50" placeholder="Ketik kategori baru" autocomplete="off" style="display:none;">
								</div>
							</div>

							<div class="gallery-form-right">
								<div class="gallery-media-card">
									<div class="media-title">Media Foto</div>

									<div class="gallery-media-preview upload-clickable" id="galleryMediaPreview" title="Klik untuk memilih foto">
										<div class="gallery-media-empty" id="galleryMediaEmpty">
											<div class="gallery-media-shape" aria-hidden="true">
												<i class='bx bx-image-add'></i>
											</div>
											<strong>Upload Foto</strong>
											<span>Klik area ini untuk memilih foto</span>
											<span class="gallery-media-size-hint">Rasio bebas — Landscape 16:9, Potret 3:4, atau 1:1</span>
										</div>

										<img
											src=""
											alt="Preview Foto"
											id="previewImg"
											style="display:none;"
										>

										<div class="gallery-media-actions" id="galleryMediaActions" style="display:none;">
											<button type="button" class="gallery-media-btn" id="btnPreviewZoom" title="Zoom Foto" aria-label="Zoom Foto">
												<i class='bx bx-fullscreen'></i>
											</button>
											<button type="button" class="gallery-media-btn danger" id="btnRemovePreview" title="Hapus Foto" aria-label="Hapus Foto">
												<i class='bx bx-trash'></i>
											</button>
										</div>

										<input type="file" name="foto" id="photoInput" accept="image/*" class="gallery-media-file-input">
									</div>

									<div class="gallery-media-meta">
										JPG, JPEG, PNG, WEBP · Maks. 2MB
									</div>
								</div>

								<input type="hidden" name="hapus_gambar" id="hapusGambarInput" value="0">
							</div>
						</div>

						<div class="modal-actions">
							<button type="button" class="btn-cancel" id="btnCancelModal">Batal</button>
							<button type="submit" class="btn-save">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal Crop Gambar (bebas: landscape / potret / 1:1 / bebas, sesuai kebutuhan galeri) -->
			<div class="modal-overlay" id="cropModal">
				<div class="modal-box crop-modal-box">
					<div class="modal-head">
						<h3>Sesuaikan Foto</h3>
						<i class='bx bx-x' onclick="closeCropModal()"></i>
					</div>
					<div class="crop-modal-body">
						<div class="crop-container" id="cropContainer">
							<img id="cropImageEl" src="" alt="Crop foto">
						</div>
						<div class="crop-ratio-options" id="cropRatioOptions">
							<button type="button" class="crop-ratio-btn active" data-ratio="free">Bebas</button>
							<button type="button" class="crop-ratio-btn" data-ratio="1.7778">Landscape (16:9)</button>
							<button type="button" class="crop-ratio-btn" data-ratio="0.75">Potret (3:4)</button>
							<button type="button" class="crop-ratio-btn" data-ratio="1">1:1</button>
						</div>
						<p class="crop-hint">Galeri bebas: pilih rasio di atas atau geser sudut area crop untuk bentuk bebas.</p>
					</div>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" onclick="closeCropModal()">Batal</button>
						<button type="button" class="btn btn-save" id="btnApplyCrop">Terapkan</button>
					</div>
				</div>
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2 id="deleteConfirmTitle">Hapus Foto?</h2>
					<p id="deleteConfirmText">Yakin ingin menghapus foto ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
					<div class="modal-actions">
						<button type="button" class="btn-cancel" id="btnCancelDelete">Batal</button>
						<button type="button" class="btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
					</div>
				</div>
			</div>

			<!-- Modal Notifikasi Gagal (error validasi dari server) -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
		/* ============================================================
		   MODAL CROP FOTO — pakai Cropper.js
		   Galeri bebas: Bebas / Landscape (16:9) / Potret (3:4) / 1:1
		   ============================================================ */
		(function () {
			const cropModal        = document.getElementById('cropModal');
			const cropContainer    = document.getElementById('cropContainer');
			const cropImageEl      = document.getElementById('cropImageEl');
			const btnApplyCrop     = document.getElementById('btnApplyCrop');
			const cropRatioOptions = document.getElementById('cropRatioOptions');
			const cropRatioBtns    = cropRatioOptions ? Array.from(cropRatioOptions.querySelectorAll('.crop-ratio-btn')) : [];
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

					// Reset pilihan rasio ke "Bebas" setiap kali buka modal
					cropRatioBtns.forEach(function (b) { b.classList.toggle('active', b.dataset.ratio === 'free'); });

					if (cropper) { cropper.destroy(); cropper = null; }
					cropper = new Cropper(cropImageEl, {
						aspectRatio: isNaN(aspectRatio) ? NaN : aspectRatio,
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

			// Tombol pilihan rasio (khusus galeri: bebas / landscape / potret / 1:1)
			cropRatioBtns.forEach(function (btn) {
				btn.addEventListener('click', function () {
					if (!cropper) return;
					cropRatioBtns.forEach(function (b) { b.classList.remove('active'); });
					btn.classList.add('active');
					const r = btn.dataset.ratio;
					cropper.setAspectRatio(r === 'free' ? NaN : parseFloat(r));
				});
			});

			btnApplyCrop.addEventListener('click', function () {
				if (!cropper || !cropApplyCallback) return;
				const canvas = cropper.getCroppedCanvas({ imageSmoothingQuality: 'high' });
				canvas.toBlob(function (blob) {
					const croppedFile = new File([blob], 'galeri-' + Date.now() + '.jpg', { type: 'image/jpeg' });
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
			syncGallerySelectAllCheckbox();
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

		/* ============================================================
		   MODE PILIH: kolom "Aksi" berubah jadi kolom checkbox
		   ============================================================ */
		let gallerySelectMode = false;
		let gallerySelectedIds = new Set();
		const galleryActionCellCache = new Map(); // id -> HTML tombol aksi asli (edit/hapus)

		function toggleGallerySelectMode() {
			gallerySelectMode = !gallerySelectMode;
			gallerySelectedIds.clear();
			renderGalleryActionCells();
			updateGalleryAksiHeader();
			updateGalleryBulkToolbar();
		}

		function renderGalleryActionCells() {
			document.querySelectorAll('#galleryTable tbody tr.gallery-row').forEach(function (tr) {
				const id = tr.dataset.id;
				const cell = tr.querySelector('td.action-cell');
				if (!id || !cell) return;

				if (gallerySelectMode) {
					if (!galleryActionCellCache.has(id)) {
						galleryActionCellCache.set(id, cell.innerHTML);
					}
					const checked = gallerySelectedIds.has(id);
					cell.innerHTML = '<input type="checkbox" class="gallery-row-checkbox" value="' + id + '" ' + (checked ? 'checked' : '') + ' onchange="toggleGalleryRowSelect(\'' + id + '\', this.checked)">';
					cell.classList.add('select-cell');
					tr.classList.toggle('row-selected', checked);
				} else {
					if (galleryActionCellCache.has(id)) {
						cell.innerHTML = galleryActionCellCache.get(id);
					}
					cell.classList.remove('select-cell');
					tr.classList.remove('row-selected');
				}
			});
		}

		function updateGalleryAksiHeader() {
			const th = document.getElementById('galleryAksiHeader');
			const toggleBtn = document.getElementById('btnToggleGallerySelectMode');
			const toggleBtnText = document.getElementById('btnToggleGallerySelectModeText');
			const bulkGroup = document.getElementById('galleryBulkActionsGroup');
			if (!th) return;

			if (gallerySelectMode) {
				th.innerHTML = '<input type="checkbox" id="gallerySelectAll" title="Pilih semua di halaman ini" onclick="toggleGallerySelectAllOnPage(this.checked)">';
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

		function toggleGalleryRowSelect(id, checked) {
			if (checked) gallerySelectedIds.add(id);
			else gallerySelectedIds.delete(id);

			const cb = document.querySelector('.gallery-row-checkbox[value="' + id + '"]');
			const row = cb ? cb.closest('tr') : null;
			if (row) row.classList.toggle('row-selected', checked);

			syncGallerySelectAllCheckbox();
			updateGalleryBulkToolbar();
		}

		function toggleGallerySelectAllOnPage(checked) {
			document.querySelectorAll('#galleryTable tbody tr.gallery-row:not(.row-hidden) .gallery-row-checkbox').forEach(function (cb) {
				cb.checked = checked;
				const id = cb.value;
				if (checked) gallerySelectedIds.add(id);
				else gallerySelectedIds.delete(id);
				const row = cb.closest('tr');
				if (row) row.classList.toggle('row-selected', checked);
			});
			updateGalleryBulkToolbar();
		}

		function syncGallerySelectAllCheckbox() {
			const selectAll = document.getElementById('gallerySelectAll');
			if (!selectAll) return; // hanya ada saat mode pilih aktif
			const boxes = document.querySelectorAll('#galleryTable tbody tr.gallery-row:not(.row-hidden) .gallery-row-checkbox');
			if (!boxes.length) { selectAll.checked = false; selectAll.indeterminate = false; return; }
			const checkedCount = Array.from(boxes).filter(function (cb) { return cb.checked; }).length;
			selectAll.checked = checkedCount === boxes.length;
			selectAll.indeterminate = checkedCount > 0 && checkedCount < boxes.length;
		}

		function updateGalleryBulkToolbar() {
			const count = gallerySelectedIds.size;
			document.getElementById('galleryBulkDeleteCount').textContent = count;
			document.getElementById('btnGalleryBulkDelete').disabled = count === 0;
		}

		/* ============================================================
		   HAPUS FOTO — modal konfirmasi (satu data / data terpilih)
		   ============================================================ */
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete    = document.getElementById('btnCancelDelete');
		const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
		const deleteConfirmTitle = document.getElementById('deleteConfirmTitle');
		const deleteConfirmText  = document.getElementById('deleteConfirmText');
		let formToDelete = null;
		let galleryDeleteMode = 'single'; // 'single' | 'bulk'

		function openGalleryDeleteConfirm(title, text) {
			deleteConfirmTitle.textContent = title;
			deleteConfirmText.textContent = text;
			deleteConfirmModal.classList.add('show');
		}

		// Hapus satu foto (tombol tong sampah per baris)
		function confirmDeleteGaleri(id) {
			galleryDeleteMode = 'single';
			formToDelete = document.getElementById('deleteFormGaleri' + id);
			openGalleryDeleteConfirm('Hapus Foto?', 'Yakin ingin menghapus foto ini? Data yang sudah dihapus tidak dapat dikembalikan.');
		}

		// Hapus semua foto yang dicentang (tombol "Hapus Terpilih")
		function confirmBulkDeleteGaleri() {
			if (gallerySelectedIds.size === 0) return;
			galleryDeleteMode = 'bulk';
			openGalleryDeleteConfirm(
				'Hapus Foto Terpilih?',
				'Yakin ingin menghapus ' + gallerySelectedIds.size + ' foto yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.'
			);
		}

		btnCancelDelete.addEventListener('click', function () {
			formToDelete = null;
			galleryDeleteMode = 'single';
			deleteConfirmModal.classList.remove('show');
		});

		btnConfirmDelete.addEventListener('click', async function () {
			if (galleryDeleteMode === 'single') {
				if (formToDelete) {
					formToDelete.submit();
				}
				deleteConfirmModal.classList.remove('show');
				return;
			}

			// Mode massal: kirim form hapus untuk tiap foto yang dicentang
			const ids = Array.from(gallerySelectedIds);
			if (ids.length === 0) {
				deleteConfirmModal.classList.remove('show');
				return;
			}

			const originalText = btnConfirmDelete.innerHTML;
			btnConfirmDelete.innerHTML = 'Menghapus...';
			btnConfirmDelete.disabled = true;

			let gagal = 0;
			for (const id of ids) {
				const form = document.getElementById('deleteFormGaleri' + id);
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
				'galleryBulkDeleteMessage',
				gagal === 0
					? berhasil + ' foto berhasil dihapus.'
					: berhasil + ' dari ' + ids.length + ' foto berhasil dihapus.'
			);

			btnConfirmDelete.innerHTML = originalText;
			btnConfirmDelete.disabled = false;
			deleteConfirmModal.classList.remove('show');
			window.location.reload();
		});

		deleteConfirmModal.addEventListener('click', function (e) {
			if (e.target === deleteConfirmModal && !btnConfirmDelete.disabled) {
				formToDelete = null;
				galleryDeleteMode = 'single';
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

		const galleryBulkDeleteMessage = sessionStorage.getItem('galleryBulkDeleteMessage');
		if (galleryBulkDeleteMessage) {
			sessionStorage.removeItem('galleryBulkDeleteMessage');
			showSuccessPopup(galleryBulkDeleteMessage);
		}
		@if(session('success'))
			else {
				showSuccessPopup(@json(session('success')));
			}
		@endif

		// Tampilkan error validasi dari server (sebelumnya gagal simpan tidak terlihat sama sekali)
		const errorModal = document.getElementById('errorModal');
		document.getElementById('btnCloseError').addEventListener('click', function () { errorModal.classList.remove('show'); });
		errorModal.addEventListener('click', function (e) { if (e.target === errorModal) errorModal.classList.remove('show'); });
		@if($errors->any())
			document.getElementById('errorMessage').textContent = @json(implode("\n", $errors->all()));
			errorModal.classList.add('show');
		@endif

		/* ---------- MODAL TAMBAH / EDIT FOTO ---------- */

		const galleryModal   = document.getElementById('galleryModal');
		const btnAddGallery  = document.getElementById('btnAddGallery');
		const btnCancelModal = document.getElementById('btnCancelModal');
		const galleryForm    = document.getElementById('galleryForm');
		const modalTitle     = document.getElementById('modalTitle');
		const formMethod     = document.getElementById('formMethod');

		const photoTitle       = document.getElementById('photoTitle');
		const photoCategory    = document.getElementById('photoCategory');
		const photoInput       = document.getElementById('photoInput');
		const previewImg       = document.getElementById('previewImg');
		const galleryMediaPreview = document.getElementById('galleryMediaPreview');
		const galleryMediaEmpty   = document.getElementById('galleryMediaEmpty');
		const galleryMediaActions = document.getElementById('galleryMediaActions');
		const hapusGambarInput    = document.getElementById('hapusGambarInput');
		const btnPreviewZoom      = document.getElementById('btnPreviewZoom');
		const btnRemovePreview    = document.getElementById('btnRemovePreview');

		const STORE_URL = "{{ route('admin.kelola-galeri.store') }}";

		function setGalleryMediaPreview(src) {
			if (src) {
				previewImg.src = src;
				previewImg.style.display = 'block';
				galleryMediaEmpty.style.display = 'none';
				galleryMediaActions.style.display = 'flex';
				galleryMediaPreview.classList.add('has-image');
			} else {
				previewImg.src = '';
				previewImg.style.display = 'none';
				galleryMediaEmpty.style.display = 'block';
				galleryMediaActions.style.display = 'none';
				galleryMediaPreview.classList.remove('has-image');
			}
		}

		function removeGalleryMedia() {
			photoInput.value = '';
			setGalleryMediaPreview('');
		}

		// ===== Kategori: pilihan "Lainnya..." untuk mengetik kategori sendiri =====
		const photoCategoryLainnya = document.getElementById('photoCategoryLainnya');

		function toggleKategoriLainnya() {
			const aktif = photoCategory.value === '__lainnya__';
			photoCategoryLainnya.style.display = aktif ? 'block' : 'none';
			photoCategoryLainnya.required = aktif;
			if (!aktif) photoCategoryLainnya.value = '';
		}
		photoCategory.addEventListener('change', function () {
			toggleKategoriLainnya();
			if (photoCategory.value === '__lainnya__') photoCategoryLainnya.focus();
		});

		// Cari option kategori yang sama (tanpa membedakan huruf besar/kecil)
		function findKategoriOption(nilai) {
			const target = String(nilai || '').trim().toLowerCase();
			return Array.from(photoCategory.options).find(function (o) {
				return o.value !== '__lainnya__' && o.value.toLowerCase() === target;
			});
		}

		function tambahKategoriOption(nilai) {
			const opt = new Option(nilai.charAt(0).toUpperCase() + nilai.slice(1), nilai);
			photoCategory.insertBefore(opt, photoCategory.querySelector('option[value="__lainnya__"]'));
			return opt;
		}

		// Set kategori (dipakai saat edit); kalau belum ada di daftar, ditambahkan sebagai pilihan
		function setKategoriValue(nilai) {
			const val = String(nilai || '').trim();
			let opt = findKategoriOption(val);
			if (!opt && val) opt = tambahKategoriOption(val);
			photoCategory.value = opt ? opt.value : 'kegiatan';
			toggleKategoriLainnya();
		}

		// Saat disimpan: teks yang diketik menjadi nilai kategori yang dikirim
		galleryForm.addEventListener('submit', function (e) {
			if (photoCategory.value !== '__lainnya__') return;
			const teks = photoCategoryLainnya.value.trim().replace(/\s+/g, ' ');
			if (!teks) {
				e.preventDefault();
				photoCategoryLainnya.focus();
				return;
			}
			const opt = findKategoriOption(teks) || tambahKategoriOption(teks);
			photoCategory.value = opt.value;
		});

		function openModal(mode, data = null) {
			galleryForm.reset();
			toggleKategoriLainnya();
			setGalleryMediaPreview('');
			hapusGambarInput.value = '0';
			photoInput.required = true;

			if (mode === 'edit' && data) {
				modalTitle.textContent = 'Edit Foto Galeri';
				galleryForm.action = data.url;
				formMethod.value = 'PUT';
				photoInput.required = false;

				photoTitle.value = data.judul;
				setKategoriValue(data.kategori);

				if (data.foto) {
					setGalleryMediaPreview(data.foto);
				}
			} else {
				modalTitle.textContent = 'Tambah Foto Galeri';
				galleryForm.action = STORE_URL;
				formMethod.value = '';
				photoCategory.value = 'kegiatan';
			}

			syncModalWithContentArea();
			galleryModal.classList.add('show');
			document.body.classList.add('chb-modal-open');
		}

		function closeModal() {
			galleryModal.classList.remove('show');
			document.body.classList.remove('chb-modal-open');
		}

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

		btnAddGallery.addEventListener('click', () => openModal('add'));
		btnCancelModal.addEventListener('click', closeModal);

		// Tutup modal galeri saat klik area gelap
		galleryModal.addEventListener('click', function (e) {
			if (e.target === galleryModal) closeModal();
		});

		// Edit foto
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

		// Pilih foto
		photoInput.addEventListener('change', function () {
			const file = this.files[0];
			if (!file) return;

			if (!file.type.startsWith('image/')) {
				this.value = '';
				setGalleryMediaPreview('');
				return;
			}

			if (file.size > 2 * 1024 * 1024) {
				this.value = '';
				setGalleryMediaPreview('');
				alert('Ukuran foto maksimal 2MB.');
				return;
			}

			openCropModal(file, NaN, photoInput, function (croppedFile, inputEl) {
				const dt = new DataTransfer();
				dt.items.add(croppedFile);
				inputEl.files = dt.files;
				setGalleryMediaPreview(URL.createObjectURL(croppedFile));
				hapusGambarInput.value = '0';
			}, false);
		});

		// Tombol zoom
		btnPreviewZoom.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();

			if (!previewImg.src || previewImg.style.display === 'none') return;

			const categoryText = photoCategory.options[photoCategory.selectedIndex]
				? photoCategory.options[photoCategory.selectedIndex].text
				: '';

			openZoom(
				previewImg.src,
				photoTitle.value || 'Preview Foto',
				categoryText
			);
		});

		// Tombol hapus foto
		btnRemovePreview.addEventListener('click', function (e) {
			e.preventDefault();
			e.stopPropagation();

			removeGalleryMedia();
			hapusGambarInput.value = '1';
		});

		// Klik area media untuk memilih file
		galleryMediaPreview.addEventListener('click', function (e) {
			if (e.target.closest('.gallery-media-actions')) return;
			photoInput.click();
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
			if (e.key === 'Escape' && galleryModal.classList.contains('show')) closeModal();
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

	/* ===== Header diam di atas; kartu daftar bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var header = main ? main.querySelector('.head-title') : null;
		var card = document.querySelector('#content main .table-section');
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
			var headEl = card.querySelector('.table-toolbar');
			if (headEl) card.style.setProperty('--head-h', headEl.offsetHeight + 'px');
		}
		pinHeader();
		syncLayout();
		window.addEventListener('resize', syncLayout);
		setTimeout(syncLayout, 300);
	})();
</script>
@endpush