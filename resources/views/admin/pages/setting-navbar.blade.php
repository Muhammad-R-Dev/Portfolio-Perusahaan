@extends('admin.layouts.app')

@section('title', 'Pengaturan Header & Footer | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
	#content main .settings-wrapper {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 24px;
		margin-top: 36px;
		width: 100%;
		color: var(--dark);
	}
	#content main .settings-wrapper > div {
		border-radius: 20px;
		background: var(--light);
		padding: 24px;
		flex-grow: 1;
		flex-basis: 420px;
	}
	#content main .settings-card .head {
		display: flex;
		align-items: center;
		grid-gap: 12px;
		margin-bottom: 24px;
	}
	#content main .settings-card .head .bx {
		font-size: 24px;
		color: var(--blue);
	}
	#content main .settings-card .head h3 {
		font-size: 22px;
		font-weight: 600;
	}
	#content main .settings-card .head p {
		width: 100%;
		font-size: 13px;
		color: var(--dark-grey);
		margin-top: 4px;
	}

	#content main .form-group { margin-bottom: 20px; }
	#content main .form-group label {
		display: block;
		font-size: 14px;
		font-weight: 500;
		margin-bottom: 8px;
		color: var(--dark);
	}
	#content main .form-group .form-control {
		width: 100%;
		height: 44px;
		padding: 0 16px;
		border: 1px solid var(--grey);
		background: var(--grey);
		border-radius: 10px;
		outline: none;
		color: var(--dark);
		font-family: var(--poppins);
		font-size: 14px;
		transition: .2s ease;
	}
	#content main .form-group textarea.form-control {
		height: auto;
		min-height: 110px;
		padding: 12px 16px;
		resize: vertical;
		line-height: 1.5;
	}
	#content main .form-group .form-control:focus {
		border-color: var(--blue);
		background: var(--light);
	}
	#content main .form-group small.hint {
		display: block;
		margin-top: 6px;
		font-size: 12px;
		color: var(--dark-grey);
	}

	/* Main layout: text fields on the left, media upload on the right */
	#content main .settings-main-row {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 16px;
		align-items: flex-start;
		justify-content: flex-start;
		margin-bottom: 8px;
	}
	#content main .settings-main-row .settings-fields {
		flex: 1 1 320px;
	}
	#content main .settings-main-row .settings-media {
		flex: 0 1 200px;
		max-width: 200px;
	}

	#content main .settings-media .media-label {
		display: block;
		font-size: 14px;
		font-weight: 500;
		margin-bottom: 8px;
		color: var(--dark);
	}

	/* Media upload card — big dropzone style */
	#content main .media-upload-box {
		position: relative;
		border: 2px dashed var(--grey);
		border-radius: 14px;
		padding: 14px;
		text-align: center;
		background: var(--grey);
		display: block;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .media-upload-box:hover,
	#content main .media-upload-box.is-dragover {
		border-color: var(--blue);
		background: rgba(60, 145, 230, .08);
	}
	#content main .media-upload-box .media-preview {
		width: 100%;
		height: 140px;
		border-radius: 10px;
		background: var(--light);
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		margin-bottom: 12px;
		position: relative;
	}
	#content main .media-upload-box .media-preview img {
		width: 100%;
		height: 100%;
		object-fit: contain;
	}
	#content main .media-upload-box .media-preview .placeholder-content {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		grid-gap: 6px;
		color: var(--dark-grey);
	}
	#content main .media-upload-box .media-preview .placeholder-content .bx {
		font-size: 30px;
		color: var(--blue);
	}
	#content main .media-upload-box .media-preview .placeholder-content span {
		font-size: 11px;
		font-weight: 500;
	}
	#content main .media-upload-box .upload-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		grid-gap: 6px;
		background: var(--blue);
		color: var(--light);
		padding: 7px 16px;
		border-radius: 36px;
		font-size: 12px;
		font-weight: 600;
		pointer-events: none;
	}
	#content main .media-upload-box input[type="file"] {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
		cursor: pointer;
	}
	#content main .media-upload-box small {
		display: block;
		margin-top: 10px;
		color: var(--dark-grey);
		font-size: 11px;
	}

	#content main .btn-save {
		height: 44px;
		padding: 0 28px;
		border: none;
		border-radius: 36px;
		background: var(--blue);
		color: var(--light);
		font-family: var(--poppins);
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		grid-gap: 8px;
		transition: .2s ease;
	}
	#content main .btn-save:hover { opacity: .9; }

	#content main .btn-cancel-edit {
		height: 44px;
		padding: 0 28px;
		border: none;
		border-radius: 36px;
		background: var(--grey);
		color: var(--dark);
		font-family: var(--poppins);
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		grid-gap: 8px;
		transition: .2s ease;
	}
	#content main .btn-cancel-edit:hover { opacity: .85; }
	#content main .btn-cancel-edit[hidden] { display: none; }

	#content main .form-actions {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 12px;
		margin-top: 8px;
	}

	#content main .btn-back-inline {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 36px;
		height: 36px;
		border-radius: 50%;
		background: var(--grey);
		color: var(--dark);
		font-size: 18px;
		flex-shrink: 0;
	}
	#content main .btn-back-inline.is-disabled {
		opacity: .4;
		cursor: not-allowed;
		pointer-events: none;
	}

	body.dark #content main .btn-save,
	body.dark #content main .btn-save:hover {
		background: var(--blue) !important;
		color: #fff !important;
	}

	@media screen and (max-width: 576px) {
		#content main .settings-main-row {
			flex-direction: column;
		}
		#content main .settings-main-row .settings-media {
			flex-basis: 100%;
		}
	}

	/* Disabled / read-only state */
	#content main .form-group .form-control:disabled {
		background: var(--grey);
		color: var(--dark);
		-webkit-text-fill-color: var(--dark);
		cursor: not-allowed;
		opacity: 1;
	}
	#content main .media-upload-box.is-locked {
		cursor: not-allowed;
		opacity: .75;
		pointer-events: none;
	}
	#content main .media-upload-box.is-locked .upload-btn {
		background: var(--dark-grey);
	}

	/* Confirmation modal */
	#content main .confirm-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, .45);
		z-index: 999;
		align-items: center;
		justify-content: center;
		padding: 16px;
	}
	#content main .confirm-overlay.is-open {
		display: flex;
	}
	#content main .confirm-box {
		background: var(--light);
		border-radius: 20px;
		padding: 28px;
		max-width: 360px;
		width: 100%;
		text-align: center;
		box-shadow: 0 10px 40px rgba(0, 0, 0, .2);
	}
	#content main .confirm-box .confirm-icon {
		font-size: 44px;
		color: #f0a500;
		margin-bottom: 10px;
	}
	#content main .confirm-box h4 {
		font-size: 18px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 10px;
	}
	#content main .confirm-box p {
		font-size: 13px;
		color: var(--dark-grey);
		line-height: 1.6;
		margin-bottom: 22px;
	}
	#content main .confirm-actions {
		display: flex;
		grid-gap: 12px;
		justify-content: center;
	}
	#content main .confirm-actions button {
		flex: 1;
		height: 42px;
		border: none;
		border-radius: 36px;
		font-family: var(--poppins);
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .confirm-actions .btn-cancel {
		background: var(--grey);
		color: var(--dark);
	}
	#content main .confirm-actions .btn-cancel:hover { opacity: .85; }
	#content main .confirm-actions .btn-confirm {
		background: var(--blue);
		color: var(--light);
	}
	#content main .confirm-actions .btn-confirm:hover { opacity: .9; }

	/* Daftar perubahan di modal konfirmasi */
	#content main .confirm-box.wide { max-width: 480px; }
	#content main .confirm-box .confirm-list {
		list-style: disc;
		text-align: left;
		margin: 0 0 22px;
		max-height: 220px;
		overflow-y: auto;
		font-size: 13px;
		line-height: 1.5;
		color: var(--dark);
		background: var(--grey);
		border-radius: 12px;
		padding: 14px 14px 14px 32px;
	}
	#content main .confirm-box .confirm-list li { margin-bottom: 7px; }
	#content main .confirm-box .confirm-list li:last-child { margin-bottom: 0; }
	#content main .confirm-box .confirm-icon.is-success { color: #2ecc71; }
	#content main .confirm-box .confirm-icon.is-info { color: var(--blue); }

	/* Success toast (tidak dipakai lagi, diganti pop up) */
	#content main .save-toast {
		position: fixed;
		bottom: 28px;
		right: 28px;
		background: #2ecc71;
		color: #fff;
		padding: 14px 22px;
		border-radius: 12px;
		font-size: 14px;
		font-weight: 500;
		display: flex;
		align-items: center;
		grid-gap: 8px;
		box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
		transform: translateY(20px);
		opacity: 0;
		pointer-events: none;
		transition: .25s ease;
		z-index: 1000;
	}
	#content main .save-toast.is-visible {
		transform: translateY(0);
		opacity: 1;
	}

	/* ---------- Image cropper ---------- */
	#content main .btn-recrop {
		display: inline-flex; align-items: center; justify-content: center; grid-gap: 6px; width: 100%; margin-top: 10px;
		height: 36px; border: 1px solid var(--blue); border-radius: 36px; background: transparent; color: var(--blue);
		font-family: var(--poppins); font-size: 12px; font-weight: 600; cursor: pointer; transition: .2s ease;
	}
	#content main .btn-recrop:hover { background: var(--blue); color: var(--light); }
	#content main .btn-recrop[hidden] { display: none; }

	#content main .crop-box {
		background: var(--light); border-radius: 20px; padding: 20px; width: 100%; max-width: 640px;
		max-height: 94vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
	}
	#content main .crop-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
	#content main .crop-head h4 { font-size: 18px; font-weight: 600; color: var(--dark); margin: 0; }
	#content main .crop-head p { font-size: 12px; color: var(--dark-grey); margin-top: 2px; }
	#content main .crop-x {
		width: 34px; height: 34px; border: none; border-radius: 50%; background: var(--grey); color: var(--dark);
		font-size: 20px; cursor: pointer; display: grid; place-items: center;
	}
	#content main .crop-stage {
		width: 100%; height: min(50vh, 400px); background: #1b1b1b; border-radius: 12px; overflow: hidden;
	}
	#content main .crop-stage img { display: block; max-width: 100%; }
	#content main .crop-tools { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; grid-gap: 10px; margin: 14px 0 18px; }
	#content main .crop-group { display: flex; flex-wrap: wrap; grid-gap: 6px; }
	#content main .crop-group button {
		height: 34px; min-width: 34px; padding: 0 12px; border: none; border-radius: 36px; background: var(--grey); color: var(--dark);
		font-family: var(--poppins); font-size: 12px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;
		transition: .2s ease;
	}
	#content main .crop-group button .bx { font-size: 18px; }
	#content main .crop-group button:hover { opacity: .85; }
	#content main .crop-group button.is-active { background: var(--blue); color: var(--light); }
	#content main .crop-info { font-size: 12px; color: var(--dark-grey); margin-bottom: 14px; }

	/* ---------- Pengaturan warna header & footer ---------- */
	#content main .color-settings {
		margin: 8px 0 24px;
		padding-top: 24px;
		border-top: none;
	}
	#content main .color-settings-head {
		display: flex;
		align-items: flex-start;
		grid-gap: 12px;
		margin-bottom: 18px;
	}
	#content main .color-settings-head .bx { font-size: 24px; color: var(--blue); margin-top: 2px; }
	#content main .color-settings-head h4 { font-size: 18px; font-weight: 600; color: var(--dark); margin: 0; }
	#content main .color-settings-head p { font-size: 13px; color: var(--dark-grey); margin-top: 4px; }
	#content main .color-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
		grid-gap: 16px;
		margin-bottom: 16px;
	}
	#content main .color-settings-actions {
		display: flex;
		justify-content: flex-start;
	}
	#content main .color-card {
		border: 1px solid var(--grey);
		border-radius: 14px;
		padding: 16px;
		background: var(--light);
	}
	#content main .color-card-title {
		display: flex;
		align-items: center;
		grid-gap: 8px;
		font-size: 14px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 14px;
	}
	#content main .color-card-title .bx { font-size: 18px; color: var(--blue); }
	#content main .color-card .form-group { margin-bottom: 12px; }
	#content main .color-input { display: flex; align-items: center; grid-gap: 8px; }
	#content main .color-picker {
		flex: 0 0 44px;
		width: 44px;
		height: 44px;
		padding: 3px;
		border: 1px solid var(--grey);
		border-radius: 10px;
		background: var(--grey);
		cursor: pointer;
	}
	#content main .color-picker:disabled { cursor: not-allowed; opacity: .75; }
	#content main .color-hex { text-transform: uppercase; font-family: monospace; letter-spacing: .04em; }
	#content main .color-preview {
		display: flex;
		align-items: center;
		justify-content: space-between;
		grid-gap: 10px;
		margin-top: 4px;
		padding: 12px 14px;
		border-radius: 10px;
		border: 1px solid rgba(128, 128, 128, .25);
		font-size: 13px;
		font-weight: 600;
		transition: background .2s ease, color .2s ease;
	}
	#content main .color-preview span:last-child { font-weight: 400; opacity: .8; }
	#content main #resetColorsBtn:disabled { opacity: .5; cursor: not-allowed; }

	/* ===== Header diam di atas; kartu pengaturan bisa discroll (seperti Pengaturan Halaman) ===== */
	#content main .head-title.page-header-fixed { position: fixed; z-index: 60; padding: 10px 0; margin: 0; }
	#content main .settings-card { overflow-y: auto; overflow-x: hidden; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; }
	#content main .settings-card > .head.card-head-fixed { position: sticky; top: 0; z-index: 5; background: var(--light, #fff); background-clip: padding-box; }
	/* ============================================================
	   DARK MODE / LIGHT MODE
	   Warna disamakan persis dengan palet halaman KELOLA BLOG
	   (sama seperti Kelola Proyek & Dashboard):
	     halaman #1b2538  <  kartu #25324a  <  input/hover #34456a  (dark)
	     halaman #e9eef5  <  kartu putih                             (light)
	   ============================================================ */
	body.dark #content,
	body.dark #content main {
		--light: #25324a;          /* kartu, modal, header tabel */
		--grey: #34456a;           /* input, hover baris, border */
		--dark: #eef2f9;           /* teks utama */
		--dark-grey: #a9b8d2;      /* teks sekunder */
		--light-blue: #2f4a7a;     /* baris/ikon terpilih */
		--light-orange: #4d3b33;
		--blue: #4f8ef7;
		--red: #ef5a5a;
	}
	body.dark #content {
		background: #1b2538 !important;
	}
	body:not(.dark) #content,
	body:not(.dark) #content main {
		--light: #ffffff;          /* kartu, modal, header tabel */
		--grey: #e2e8f0;           /* input, border */
		--dark: #1e293b;           /* teks utama */
		--dark-grey: #64748b;      /* teks sekunder */
		--light-blue: #dbeafe;     /* baris/ikon terpilih */
		--light-orange: #fee2e2;
	}
	body:not(.dark) #content {
		background: #e9eef5 !important;
	}

	/* ===== Layout: field di kiri, upload di kanan (tinggi sejajar 3 input) ===== */
	#content main .settings-main-row {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 340px;
		grid-gap: 28px;
		align-items: stretch;
	}
	#content main .settings-main-row .settings-fields { min-width: 0; flex: none; }
	#content main .settings-main-row .settings-media {
		flex: none;
		max-width: none;
		min-width: 0;
		display: flex;
		flex-direction: column;
	}
	#content main .settings-media .media-upload-box {
		flex: 1 1 auto;
		display: flex;
		flex-direction: column;
	}
	#content main .settings-media .media-upload-box .media-preview {
		flex: 1 1 auto;
		height: auto;
		min-height: 220px;
	}
	#content main .settings-media .media-upload-box .media-preview img {
		position: absolute;
		inset: 0;
		object-fit: cover;
	}
	@media screen and (max-width: 576px) {
		#content main .settings-main-row { grid-template-columns: 1fr; }
	}

	/* ===== Bar tombol aksi: di bawah card, lebar sama dengan card, tetap fixed ===== */
	#content main .form-actions {
		position: fixed;
		left: 0;
		right: 0;
		bottom: 16px;
		z-index: 80;
		box-sizing: border-box;
		min-height: 64px;
		display: flex;
		align-items: center;
		justify-content: flex-end;
		flex-wrap: wrap;
		gap: 12px;
		padding: 10px 24px;
		margin: 0;
		border-radius: 0 0 16px 16px;
		background: var(--light);
		box-shadow: 0 12px 30px rgba(15, 23, 42, .14);
		border: 1px solid var(--grey);
	}
	#content main .settings-card { padding-bottom: 36px; }
	#content main .settings-card,
	#content main .settings-wrapper > .settings-card { border-bottom-left-radius: 0; border-bottom-right-radius: 0; }
	#content main .settings-card { margin-bottom: 0; }
	#content main #cancelEditBtn { background: var(--red); color: #fff; }
	#content main #cancelEditBtn:hover { opacity: .9; }

	body.dark #content main .form-actions {
		box-shadow: 0 12px 30px rgba(0, 0, 0, .30);
	}

	/* Tombol aksi rata kanan: [Batal] [Edit/Simpan] */
	#content main .form-actions { justify-content: flex-end; }
	#content main #resetColorsBtn { background: #f5b800; color: #fff; }
	#content main #resetColorsBtn:hover { opacity: .9; }
	#content main #resetColorsBtn:disabled { opacity: .5; }

	/* Zoom deskripsi footer: ukuran sebesar card */
	#content main .footer-zoom-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 1100; }
	#content main .footer-zoom-overlay.is-open { display: block; }
	#content main .footer-zoom-box {
		position: fixed;
		background: var(--light);
		border-radius: 20px;
		padding: 24px;
		display: flex;
		flex-direction: column;
		box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
	}
	#content main .footer-zoom-label { display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px; color: var(--dark); }
	#content main .footer-zoom-area {
		flex: 1 1 auto;
		min-height: 0;
		height: auto;
		resize: none;
		padding: 12px 16px;
		border: 1px solid var(--grey);
		background: var(--grey);
		border-radius: 10px;
		color: var(--dark);
		-webkit-text-fill-color: var(--dark);
		font-family: var(--poppins);
		font-size: 14px;
		line-height: 1.5;
		outline: none;
	}
	#content main .footer-zoom-area:focus { border-color: var(--blue); background: var(--light); }
	#content main #footerDescBackBtn { background: #f5b800; color: #fff; }
	#content main #footerDescBackBtn:hover { opacity: .9; }
	#content main .footer-zoom-actions { display: flex; justify-content: flex-end; grid-gap: 12px; margin-top: 16px; }

	/* Tombol silang hapus gambar (hanya saat edit) */
	#content main .media-upload-box .media-clear-btn {
		position: absolute;
		top: 20px;
		right: 20px;
		z-index: 2;
		width: 30px;
		height: 30px;
		border: none;
		border-radius: 50%;
		background: var(--red);
		color: #fff;
		font-size: 18px;
		display: none;
		align-items: center;
		justify-content: center;
		cursor: pointer;
	}
	#content main .media-upload-box.has-media:not(.is-locked) .media-clear-btn { display: flex; }
	/* Kosong: kotak berbentuk 1000 x 600 px */
	#content main .media-upload-box.is-empty .media-preview {
		flex: none;
		height: auto;
		min-height: 0;
		width: 100%;
		aspect-ratio: 1000 / 600;
		border: 2px dashed var(--dark-grey);
		background: var(--light);
	}
	#content main .media-upload-box.is-empty .media-preview .placeholder-content span + span { font-size: 11px; }

	/* Crop: Batal merah, Pakai Gambar biru (tulisan putih) */
	#content main #cropCancelBtn { background: var(--red); color: #fff; }
	#content main #cropCancelBtn:hover { opacity: .9; }
	#content main #cropApplyBtn { background: var(--blue); color: #fff; }
	#content main #cropApplyBtn:hover { opacity: .9; }
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Pengaturan Header &amp; Footer</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="{{ route('admin.setting.index') }}">Settings</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Header &amp; Footer</a></li>
					</ul>
				</div>
			</div>

			<div class="settings-wrapper">
				<div class="settings-card" style="flex-basis: 100%;">
					<div class="head">
						<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" id="btnBack" title="Kembali ke Settings">
							<i class='bx bx-arrow-back'></i>
						</a>
						<i class='bx bxs-dashboard'></i>
						<h3>Header &amp; Footer</h3>
					</div>

					@if (session('success'))
						<div id="successFlash" data-message="{{ session('success') }}" hidden></div>
						@endif
					@if ($errors->any())
					<div class="save-toast is-visible" style="position: static; margin-bottom: 20px; transform: none; background: #e74c3c;">
						<i class='bx bx-error-circle'></i> {{ $errors->first() }}
					</div>
					@endif

					<form id="navbarForm" action="{{ route('admin.setting.navbar.update') }}" method="POST" enctype="multipart/form-data">
						@csrf
						@method('PUT')

						<div class="settings-main-row">
							<div class="settings-fields">
								<div class="form-group">
									<label for="brand_name">Nama Perusahaan</label>
									<input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name', $setting->brand_name) }}" placeholder="Contoh: Astabrata" disabled>
									<small class="hint">Muncul di sebelah logo pada header & footer.</small>
								</div>

								<div class="form-group">
									<label for="brand_tagline">Tagline / Baris Kedua</label>
									<input type="text" class="form-control" id="brand_tagline" name="brand_tagline" value="{{ old('brand_tagline', $setting->brand_tagline) }}" placeholder="Contoh: Teknologi" disabled>
									<small class="hint">Tampil di bawah nama perusahaan pada header (boleh dikosongkan).</small>
								</div>

								<div class="form-group">
									<label for="footer_description">Deskripsi Singkat Footer</label>
									<textarea class="form-control" id="footer_description" name="footer_description" placeholder="Tulis deskripsi singkat untuk footer" disabled>{{ old('footer_description', $setting->footer_description) }}</textarea>
									<small class="hint">Teks singkat yang tampil di bawah nama perusahaan pada footer.</small>
								</div>
							</div>

							<div class="settings-media">
								<label for="media_upload" class="media-label">Gambar Logo</label>
								@php
									$currentLogoUrl = $setting->logo
										? (\Illuminate\Support\Str::startsWith($setting->logo, ['http://', 'https://'])
											? $setting->logo
											: asset('storage/' . $setting->logo))
										: null;
								@endphp
								<label class="media-upload-box is-locked" id="mediaUploadBox" for="media_upload" data-existing-url="{{ $currentLogoUrl }}">
									<div class="media-preview" id="mediaPreview">
										@if ($currentLogoUrl)
											<img src="{{ $currentLogoUrl }}" alt="Logo saat ini">
										@else
											<div class="placeholder-content">
												<i class='bx bx-image-add'></i>
												<span>Belum ada media dipilih</span>
													<span>Ukuran pas 1000 x 600 px</span>
											</div>
										@endif
									</div>
									<button type="button" class="media-clear-btn" id="mediaClearBtn" title="Hapus gambar"><i class='bx bx-x'></i></button>
										<span class="upload-btn">
										<i class='bx bx-upload'></i> Upload Media
									</span>
									<input type="file" id="media_upload" name="media" accept="image/png, image/jpeg" disabled>
									<small>Klik atau tarik gambar ke sini &mdash; PNG/JPG, disarankan transparan. Bisa di-crop sebelum dipasang (hasil maks. 2MB).</small>
								</label>
								<button type="button" class="btn-recrop" id="recropBtn" hidden>
									<i class='bx bx-crop'></i> Crop Ulang
								</button>
							</div>
						</div>

						@php
							$colorDefaults = [
								'navbar_bg_light' => '#094356', 'navbar_text_light' => '#ffffff',
								'navbar_bg_dark' => '#094356', 'navbar_text_dark' => '#ffffff',
								'footer_bg_light' => '#094356', 'footer_text_light' => '#ffffff',
								'footer_bg_dark' => '#1c2842', 'footer_text_dark' => '#ffffff',
							];
							$colorVal = function ($key) use ($setting, $colorDefaults) {
								$v = old($key, $setting->{$key} ?? null);
								return $v ?: $colorDefaults[$key];
							};
							$colorGroups = [
								['el' => 'navbar', 'mode' => 'light', 'title' => 'Header — Mode Terang', 'icon' => 'bx-sun'],
								['el' => 'navbar', 'mode' => 'dark', 'title' => 'Header — Mode Gelap', 'icon' => 'bx-moon'],
								['el' => 'footer', 'mode' => 'light', 'title' => 'Footer — Mode Terang', 'icon' => 'bx-sun'],
								['el' => 'footer', 'mode' => 'dark', 'title' => 'Footer — Mode Gelap', 'icon' => 'bx-moon'],
							];
						@endphp
						<div class="color-settings">
							<div class="color-settings-head">
								<i class='bx bx-palette'></i>
								<div>
									<h4>Warna Header &amp; Footer</h4>
									<p>Atur warna latar dan teks untuk mode terang dan mode gelap. Klik Edit untuk mengubah, perubahan tampil di website setelah disimpan.</p>
								</div>
							</div>
							<div class="color-grid">
								@foreach ($colorGroups as $g)
									@php
										$bgKey = $g['el'] . '_bg_' . $g['mode'];
										$txKey = $g['el'] . '_text_' . $g['mode'];
									@endphp
									<div class="color-card">
										<div class="color-card-title"><i class='bx {{ $g['icon'] }}'></i> {{ $g['title'] }}</div>
										<div class="form-group">
											<label for="{{ $bgKey }}">Warna Latar</label>
											<div class="color-input">
												<input type="color" class="color-picker" data-for="{{ $bgKey }}" value="{{ strtolower($colorVal($bgKey)) }}" aria-label="Pilih warna latar" disabled>
												<input type="text" class="form-control color-hex" id="{{ $bgKey }}" name="{{ $bgKey }}" value="{{ $colorVal($bgKey) }}" data-default="{{ $colorDefaults[$bgKey] }}" maxlength="7" placeholder="{{ $colorDefaults[$bgKey] }}" autocomplete="off" disabled>
											</div>
										</div>
										<div class="form-group">
											<label for="{{ $txKey }}">Warna Teks</label>
											<div class="color-input">
												<input type="color" class="color-picker" data-for="{{ $txKey }}" value="{{ strtolower($colorVal($txKey)) }}" aria-label="Pilih warna teks" disabled>
												<input type="text" class="form-control color-hex" id="{{ $txKey }}" name="{{ $txKey }}" value="{{ $colorVal($txKey) }}" data-default="{{ $colorDefaults[$txKey] }}" maxlength="7" placeholder="{{ $colorDefaults[$txKey] }}" autocomplete="off" disabled>
											</div>
										</div>
										<div class="color-preview" id="pv_{{ $g['el'] }}_{{ $g['mode'] }}">
											<span>{{ $g['el'] === 'navbar' ? ($setting->brand_name ?? 'Astabrata') : 'Footer' }}</span>
											<span>Contoh teks</span>
										</div>
									</div>
								@endforeach
							</div>

							<div class="color-settings-actions">
								<button type="button" class="btn-cancel-edit" id="resetColorsBtn" disabled hidden>
									<i class='bx bx-reset'></i>
									Reset Warna
								</button>
							</div>
						</div>

						<div class="form-actions">
								<button type="button" class="btn-cancel-edit" id="cancelEditBtn" hidden>
									<i class='bx bx-x'></i>
									Batal
								</button>
							<button type="button" class="btn-save" id="toggleEditBtn" data-mode="view">
								<i class='bx bx-edit-alt' id="toggleEditIcon"></i>
								<span id="toggleEditLabel">Edit</span>
							</button>
						</div>
					</form>

					<!-- Confirmation modal -->
					<div class="confirm-overlay" id="confirmOverlay">
							<div class="confirm-box wide">
								<div class="confirm-icon"><i class='bx bx-error-circle'></i></div>
								<h4>Simpan Perubahan?</h4>
								<p>Perubahan berikut akan disimpan dan langsung tampil di website:</p>
								<ul class="confirm-list" id="confirmList"></ul>
								<div class="confirm-actions">
									<button type="button" class="btn-cancel" id="confirmCancelBtn">Batal</button>
									<button type="button" class="btn-confirm" id="confirmSaveBtn">Ya, Simpan</button>
								</div>
							</div>
						</div>

						<!-- Cancel confirmation modal -->
					<div class="confirm-overlay" id="cancelOverlay">
						<div class="confirm-box wide">
							<div class="confirm-icon"><i class='bx bx-undo'></i></div>
							<h4>Batalkan Perubahan?</h4>
							<p>Perubahan berikut belum disimpan dan akan hilang jika dibatalkan:</p>
								<ul class="confirm-list" id="cancelList"></ul>
							<div class="confirm-actions">
								<button type="button" class="btn-cancel" id="cancelKeepBtn">Lanjut Edit</button>
								<button type="button" class="btn-confirm" id="cancelDiscardBtn">Ya, Batalkan</button>
							</div>
						</div>
					</div>

					<!-- Zoom deskripsi footer (ukuran sebesar card) -->
					<div class="footer-zoom-overlay" id="footerDescZoomOverlay">
						<div class="footer-zoom-box" id="footerDescZoomBox">
							<label class="footer-zoom-label" for="footerDescZoomArea">Deskripsi Singkat Footer</label>
							<textarea class="form-control footer-zoom-area" id="footerDescZoomArea" placeholder="Tulis deskripsi singkat untuk footer"></textarea>
							<div class="footer-zoom-actions">
								<button type="button" class="btn-cancel-edit" id="footerDescBackBtn"><i class='bx bx-arrow-back'></i> Kembali</button>
								<button type="button" class="btn-save" id="footerDescSaveBtn"><i class='bx bx-save'></i> Simpan</button>
							</div>
						</div>
					</div>

					<!-- Image crop modal -->
					<div class="confirm-overlay" id="cropOverlay">
						<div class="crop-box">
							<div class="crop-head">
								<div>
									<h4>Crop Gambar</h4>
									<p>Geser dan atur area potong, lalu klik &ldquo;Pakai Gambar&rdquo;.</p>
								</div>
								<button type="button" class="crop-x" id="cropCloseBtn" aria-label="Tutup"><i class='bx bx-x'></i></button>
							</div>
							<div class="crop-stage"><img id="cropImage" alt="Gambar yang akan di-crop"></div>
							<div class="crop-tools">
								<div class="crop-group" id="cropRatios">
									<button type="button" data-ratio="1" class="is-active">1:1</button>
								</div>
								<div class="crop-group">
									<button type="button" id="cropZoomIn" title="Zoom in"><i class='bx bx-zoom-in'></i></button>
									<button type="button" id="cropZoomOut" title="Zoom out"><i class='bx bx-zoom-out'></i></button>
									<button type="button" id="cropRotL" title="Putar kiri"><i class='bx bx-rotate-left'></i></button>
									<button type="button" id="cropRotR" title="Putar kanan"><i class='bx bx-rotate-right'></i></button>
									<button type="button" id="cropReset" title="Reset"><i class='bx bx-reset'></i></button>
								</div>
							</div>
							<div class="confirm-actions">
								<button type="button" class="btn-cancel" id="cropCancelBtn">Batal</button>
								<button type="button" class="btn-confirm" id="cropApplyBtn">Pakai Gambar</button>
							</div>
						</div>
					</div>

					<!-- Pop up notifikasi (berhasil / tidak ada perubahan / peringatan) -->
					<div class="confirm-overlay" id="noticeOverlay">
						<div class="confirm-box">
							<div class="confirm-icon" id="noticeIconWrap"><i class='bx bx-check-circle' id="noticeIcon"></i></div>
							<h4 id="noticeTitle">Berhasil</h4>
							<p id="noticeMessage"></p>
							<div class="confirm-actions">
								<button type="button" class="btn-confirm" id="noticeOkBtn">OK</button>
							</div>
						</div>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var mediaInput = document.getElementById('media_upload');
		var mediaPreview = document.getElementById('mediaPreview');
		var mediaBox = document.getElementById('mediaUploadBox');

		/* ---------- Image cropper ---------- */
		var cropOverlay = document.getElementById('cropOverlay');
		var cropImage = document.getElementById('cropImage');
		var recropBtn = document.getElementById('recropBtn');
		var cropper = null;
		var cropSourceFile = null;   // file asli yang sedang di-crop
		var lastOriginalFile = null; // file asli terakhir (untuk Crop Ulang)
		var appliedFile = null;	  // hasil crop yang sudah dipasang ke input
		var cropIsRecrop = false;
		var cropObjectUrl = null;
		var MAX_OUTPUT = 2 * 1024 * 1024;

		function setInputFile(file) {
			try {
				var dt = new DataTransfer();
				if (file) dt.items.add(file);
				mediaInput.files = dt.files;
			} catch (err) {
				if (!file) mediaInput.value = '';
			}
		}

		function syncMediaState() {
			var has = !!mediaPreview.querySelector('img');
			mediaBox.classList.toggle('has-media', has);
			mediaBox.classList.toggle('is-empty', !has);
		}
		var mediaClearBtn = document.getElementById('mediaClearBtn');
		mediaClearBtn.addEventListener('click', function (e) {
			e.preventDefault();   // jangan ikut membuka file-picker (ada di dalam label)
			e.stopPropagation();
			setInputFile(null);
			appliedFile = null;
			mediaChanged = true;
			recropBtn.hidden = true;
			mediaPreview.innerHTML = '<div class="placeholder-content"><i class="bx bx-image-add"></i><span>Belum ada media dipilih</span><span>Ukuran pas 1000 x 600 px</span></div>';
			syncMediaState();
		});

		function showPreview(file) {
			var reader = new FileReader();
			reader.onload = function (ev) {
				mediaPreview.innerHTML = '<img src="' + ev.target.result + '" alt="Preview Media">';
				syncMediaState();
			};
			reader.readAsDataURL(file);
		}

		function closeCropper() {
			cropOverlay.classList.remove('is-open');
			if (cropper) { cropper.destroy(); cropper = null; }
			if (cropObjectUrl) { URL.revokeObjectURL(cropObjectUrl); cropObjectUrl = null; }
			cropImage.removeAttribute('src');
		}

		function openCropper(file, isRecrop) {
			cropSourceFile = file;
			cropIsRecrop = !!isRecrop;
			cropObjectUrl = URL.createObjectURL(file);
			cropOverlay.classList.add('is-open');

			document.querySelectorAll('#cropRatios button').forEach(function (b) {
				b.classList.toggle('is-active', b.dataset.ratio === '1');
			});

			cropImage.onload = function () {
				if (cropper) cropper.destroy();
				cropper = new Cropper(cropImage, {
					viewMode: 1,
					dragMode: 'move',
					autoCropArea: 0.9,
					responsive: true,
					checkOrientation: false,
					background: true,
					aspectRatio: 1
				});
			};
			cropImage.src = cropObjectUrl;
		}

		// Batalkan crop: kembalikan ke kondisi sebelumnya
		function cancelCrop() {
			closeCropper();
			if (!cropIsRecrop) {
				setInputFile(appliedFile); // file lama (kalau ada) dipulihkan, kalau tidak input dikosongkan
			}
		}

		function exportCropped(sizes, idx, type, done) {
			var canvas = cropper.getCroppedCanvas({
				maxWidth: sizes[idx],
				maxHeight: sizes[idx],
				fillColor: type === 'image/jpeg' ? '#ffffff' : undefined,
				imageSmoothingQuality: 'high'
			});
			if (!canvas) { done(null); return; }
			canvas.toBlob(function (blob) {
				if (blob && blob.size <= MAX_OUTPUT) { done(blob); return; }
				if (idx + 1 < sizes.length) { exportCropped(sizes, idx + 1, type, done); return; }
				done(null);
			}, type, 0.92);
		}

		function applyCrop() {
			if (!cropper || !cropSourceFile) return;
			var type = cropSourceFile.type === 'image/png' ? 'image/png' : 'image/jpeg';
			exportCropped([2000, 1600, 1200, 800, 500], 0, type, function (blob) {
				if (!blob) {
					alert('Hasil crop masih lebih dari 2MB. Pilih area yang lebih kecil atau gunakan gambar lain.');
					return;
				}
				var ext = type === 'image/png' ? '.png' : '.jpg';
				var base = cropSourceFile.name.replace(/\.[^.]+$/, '');
				var cropped = new File([blob], base + '-crop' + ext, { type: type, lastModified: Date.now() });

				setInputFile(cropped);
				appliedFile = cropped;
				lastOriginalFile = cropSourceFile;
				mediaChanged = true;
				showPreview(cropped);
				recropBtn.hidden = false;
				closeCropper();
			});
		}

		function handleFile(file) {
			if (!file) return;

			if (!file.type.match('image/png') && !file.type.match('image/jpeg')) {
				alert('Format file harus PNG atau JPG.');
				setInputFile(appliedFile);
				return;
			}

			// Ukuran asli boleh lebih besar; yang dibatasi 2MB adalah hasil setelah di-crop
			if (file.size > 10 * 1024 * 1024) {
				alert('Ukuran file maksimal 10MB.');
				setInputFile(appliedFile);
				return;
			}

			if (typeof Cropper === 'undefined') {
				// Fallback: library cropper gagal dimuat, pakai perilaku lama
				if (file.size > 2 * 1024 * 1024) {
					alert('Ukuran file maksimal 2MB.');
					setInputFile(appliedFile);
					return;
				}
				mediaChanged = true;
				showPreview(file);
				return;
			}

			openCropper(file, false);
		}

		document.getElementById('cropApplyBtn').addEventListener('click', applyCrop);
		document.getElementById('cropCancelBtn').addEventListener('click', cancelCrop);
		document.getElementById('cropCloseBtn').addEventListener('click', cancelCrop);
		cropOverlay.addEventListener('click', function (e) { if (e.target === cropOverlay) cancelCrop(); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && cropOverlay.classList.contains('is-open')) cancelCrop();
		});
		document.getElementById('cropZoomIn').addEventListener('click', function () { if (cropper) cropper.zoom(0.1); });
		document.getElementById('cropZoomOut').addEventListener('click', function () { if (cropper) cropper.zoom(-0.1); });
		document.getElementById('cropRotL').addEventListener('click', function () { if (cropper) cropper.rotate(-90); });
		document.getElementById('cropRotR').addEventListener('click', function () { if (cropper) cropper.rotate(90); });
		document.getElementById('cropReset').addEventListener('click', function () { if (cropper) cropper.reset(); });
		document.getElementById('cropRatios').addEventListener('click', function (e) {
			var btn = e.target.closest('button');
			if (!btn || !cropper) return;
			document.querySelectorAll('#cropRatios button').forEach(function (b) { b.classList.remove('is-active'); });
			btn.classList.add('is-active');
			cropper.setAspectRatio(1);
		});
		recropBtn.addEventListener('click', function () {
			if (lastOriginalFile) openCropper(lastOriginalFile, true);
		});

		if (mediaInput && mediaPreview && mediaBox) {
			mediaInput.addEventListener('change', function (e) {
				handleFile(e.target.files && e.target.files[0]);
			});

			['dragenter', 'dragover'].forEach(function (evt) {
				mediaBox.addEventListener(evt, function (e) {
					e.preventDefault();
					e.stopPropagation();
					mediaBox.classList.add('is-dragover');
				});
			});

			['dragleave', 'drop'].forEach(function (evt) {
				mediaBox.addEventListener(evt, function (e) {
					e.preventDefault();
					e.stopPropagation();
					mediaBox.classList.remove('is-dragover');
				});
			});

			mediaBox.addEventListener('drop', function (e) {
				var file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
				if (file) {
					mediaInput.files = e.dataTransfer.files;
					handleFile(file);
				}
			});
		}

		/* ---------- View / Edit mode toggle ---------- */
		var navbarForm = document.getElementById('navbarForm');
		var logoNameInput = document.getElementById('brand_name');
		var taglineInput = document.getElementById('brand_tagline');
		var footerDescInput = document.getElementById('footer_description');
		var toggleBtn = document.getElementById('toggleEditBtn');
		var toggleIcon = document.getElementById('toggleEditIcon');
		var toggleLabel = document.getElementById('toggleEditLabel');
		var btnBack = document.getElementById('btnBack');
		var cancelBtn = document.getElementById('cancelEditBtn');
		var cancelOverlay = document.getElementById('cancelOverlay');
		var cancelKeepBtn = document.getElementById('cancelKeepBtn');
		var cancelDiscardBtn = document.getElementById('cancelDiscardBtn');
		var originalPreviewHTML = mediaPreview.innerHTML;
		syncMediaState();
		var confirmOverlay = document.getElementById('confirmOverlay');
		var confirmCancelBtn = document.getElementById('confirmCancelBtn');
		var confirmSaveBtn = document.getElementById('confirmSaveBtn');
		var saveToast = document.getElementById('saveToast');
		var mediaChanged = false;

		// remember original values so we can detect real changes
		var originalValues = {
			logo_name: logoNameInput.value,
			brand_tagline: taglineInput.value,
			footer_description: footerDescInput.value
		};


		/* ---------- Zoom deskripsi footer ---------- */
		var footerZoomOverlay = document.getElementById('footerDescZoomOverlay');
		var footerZoomBox = document.getElementById('footerDescZoomBox');
		var footerZoomArea = document.getElementById('footerDescZoomArea');
		var footerCard = document.querySelector('#content main .settings-card');
		function openFooterZoom() {
			var cr = footerCard.getBoundingClientRect();
			footerZoomBox.style.left = cr.left + 'px';
			footerZoomBox.style.top = cr.top + 'px';
			footerZoomBox.style.width = cr.width + 'px';
			footerZoomBox.style.height = cr.height + 'px';
			footerZoomArea.value = footerDescInput.value;
			footerZoomOverlay.classList.add('is-open');
			footerZoomArea.focus();
		}
		function closeFooterZoom() {
			footerZoomOverlay.classList.remove('is-open');
		}
		footerDescInput.addEventListener('click', function () {
			if (!footerDescInput.disabled) openFooterZoom();
		});
		document.getElementById('footerDescBackBtn').addEventListener('click', closeFooterZoom);
		document.getElementById('footerDescSaveBtn').addEventListener('click', function () {
			footerDescInput.value = footerZoomArea.value;
			footerDescInput.dispatchEvent(new Event('input'));
			closeFooterZoom();
		});
		footerZoomOverlay.addEventListener('click', function (e) {
			if (e.target === footerZoomOverlay) closeFooterZoom();
		});

		/* ---------- Warna header & footer ---------- */
		var colorInputs = Array.prototype.slice.call(document.querySelectorAll('.color-hex'));
		var colorPickers = Array.prototype.slice.call(document.querySelectorAll('.color-picker'));
		var resetColorsBtn = document.getElementById('resetColorsBtn');
		var originalColors = {};
		colorInputs.forEach(function (i) { originalColors[i.name] = i.value.toLowerCase(); });

		function isHex(v) { return /^#[0-9a-fA-F]{6}$/.test(v); }
		function colorField(name) { return document.querySelector('.color-hex[name="' + name + '"]'); }
		function pickerFor(name) { return document.querySelector('.color-picker[data-for="' + name + '"]'); }

		function updateAllPreviews() {
			['navbar', 'footer'].forEach(function (el) {
				['light', 'dark'].forEach(function (mode) {
					var box = document.getElementById('pv_' + el + '_' + mode);
					var bg = colorField(el + '_bg_' + mode).value.trim();
					var tx = colorField(el + '_text_' + mode).value.trim();
					if (box && isHex(bg)) box.style.background = bg;
					if (box && isHex(tx)) box.style.color = tx;
				});
			});
		}

		function setColor(name, value) {
			var inp = colorField(name);
			var pk = pickerFor(name);
			inp.value = value;
			if (pk && isHex(value)) pk.value = value.toLowerCase();
		}

		colorInputs.forEach(function (inp) {
			inp.addEventListener('input', function () {
				var v = inp.value.trim();
				if (v && v.charAt(0) !== '#') { v = '#' + v; inp.value = v; }
				var pk = pickerFor(inp.name);
				if (pk && isHex(v)) pk.value = v.toLowerCase();
				updateAllPreviews();
			});
		});
		colorPickers.forEach(function (pk) {
			pk.addEventListener('input', function () {
				colorField(pk.dataset.for).value = pk.value;
				updateAllPreviews();
			});
		});
		resetColorsBtn.addEventListener('click', function () {
			colorInputs.forEach(function (i) { setColor(i.name, i.dataset.default); });
			updateAllPreviews();
		});

		function setColorsDisabled(on) {
			colorInputs.concat(colorPickers).forEach(function (el) { el.disabled = on; });
			resetColorsBtn.disabled = on;
		}
		function colorsChanged() {
			return colorInputs.some(function (i) { return i.value.trim().toLowerCase() !== originalColors[i.name]; });
		}
		function colorsValid() {
			return colorInputs.every(function (i) { return isHex(i.value.trim()); });
		}
		function restoreColors() {
			colorInputs.forEach(function (i) { setColor(i.name, originalColors[i.name]); });
			updateAllPreviews();
		}
		updateAllPreviews();
		setColorsDisabled(true);

		// Tombol kembali dinonaktifkan selama mode edit
		function setBackDisabled(on) {
			btnBack.classList.toggle('is-disabled', on);
			btnBack.setAttribute('aria-disabled', on ? 'true' : 'false');
			btnBack.tabIndex = on ? -1 : 0;
		}
		btnBack.addEventListener('click', function (e) {
			if (btnBack.classList.contains('is-disabled')) e.preventDefault();
		});

		function enterEditMode() {
			setBackDisabled(true);
			cancelBtn.hidden = false;
			resetColorsBtn.hidden = false;
			logoNameInput.disabled = false;
			taglineInput.disabled = false;
			footerDescInput.disabled = false;
			mediaInput.disabled = false;
			mediaBox.classList.remove('is-locked');
			setColorsDisabled(false);

			toggleBtn.dataset.mode = 'edit';
			toggleIcon.className = 'bx bx-save';
			toggleLabel.textContent = 'Simpan';

			logoNameInput.focus();
		}

		function exitEditMode() {
			setBackDisabled(false);
			cancelBtn.hidden = true;
			resetColorsBtn.hidden = true;
			logoNameInput.disabled = true;
			taglineInput.disabled = true;
			footerDescInput.disabled = true;
			mediaInput.disabled = true;
			mediaBox.classList.add('is-locked');
			setColorsDisabled(true);
			recropBtn.hidden = true;

			toggleBtn.dataset.mode = 'view';
			toggleIcon.className = 'bx bx-edit-alt';
			toggleLabel.textContent = 'Edit';
		}

		function hasChanges() {
			return (
				logoNameInput.value !== originalValues.logo_name ||
				taglineInput.value !== originalValues.brand_tagline ||
				footerDescInput.value !== originalValues.footer_description ||
				mediaChanged ||
				colorsChanged()
			);
		}

		/* ---------- Daftar perubahan ---------- */
		function listChanges() {
			var out = [];
			if (logoNameInput.value !== originalValues.logo_name) out.push('Nama Perusahaan diubah');
			if (taglineInput.value !== originalValues.brand_tagline) out.push('Tagline / Baris Kedua diubah');
			if (footerDescInput.value !== originalValues.footer_description) out.push('Deskripsi Singkat Footer diubah');
			if (mediaChanged) out.push('Gambar Logo diganti');
			colorInputs.forEach(function (i) {
				var now = i.value.trim().toLowerCase();
				if (now === originalColors[i.name]) return;
				var card = i.closest('.color-card');
				var title = card ? card.querySelector('.color-card-title').textContent.trim() : '';
				var group = i.closest('.form-group');
				var label = group ? group.querySelector('label').textContent.trim() : i.name;
				out.push(title + ' \u2014 ' + label + ': ' + originalColors[i.name].toUpperCase() + ' \u2192 ' + now.toUpperCase());
			});
			return out;
		}
		function fillList(el, items) {
			el.innerHTML = '';
			items.forEach(function (t) {
				var li = document.createElement('li');
				li.textContent = t;
				el.appendChild(li);
			});
		}

		/* ---------- Pop up notifikasi ---------- */
		var noticeOverlay = document.getElementById('noticeOverlay');
		var noticeIconWrap = document.getElementById('noticeIconWrap');
		var noticeIcon = document.getElementById('noticeIcon');
		var noticeTitle = document.getElementById('noticeTitle');
		var noticeMessage = document.getElementById('noticeMessage');
		function showNotice(type, title, message) {
			var icons = { success: 'bx-check-circle', info: 'bx-info-circle', warn: 'bx-error-circle' };
			noticeIcon.className = 'bx ' + (icons[type] || icons.info);
			noticeIconWrap.className = 'confirm-icon' + (type === 'success' ? ' is-success' : type === 'info' ? ' is-info' : '');
			noticeTitle.textContent = title;
			noticeMessage.textContent = message;
			noticeOverlay.classList.add('is-open');
		}
		document.getElementById('noticeOkBtn').addEventListener('click', function () { noticeOverlay.classList.remove('is-open'); });
		noticeOverlay.addEventListener('click', function (e) { if (e.target === noticeOverlay) noticeOverlay.classList.remove('is-open'); });

		// Pop up berhasil setelah simpan (halaman dimuat ulang oleh server)
		var successFlash = document.getElementById('successFlash');
		if (successFlash && successFlash.dataset.message) {
			showNotice('success', 'Berhasil', successFlash.dataset.message);
		}

		function openConfirmModal() {
			fillList(document.getElementById('confirmList'), listChanges());
			confirmOverlay.classList.add('is-open');
		}

		function closeConfirmModal() {
			confirmOverlay.classList.remove('is-open');
		}

		function showToast() {
			saveToast.classList.add('is-visible');
			setTimeout(function () {
				saveToast.classList.remove('is-visible');
			}, 2800);
		}

		function commitSave() {
			closeConfirmModal();
			// Submit form sungguhan ke route admin.setting.navbar.update
			navbarForm.submit();
		}

		toggleBtn.addEventListener('click', function () {
			if (toggleBtn.dataset.mode === 'view') {
				enterEditMode();
				return;
			}

			// currently in edit mode, acting as "Simpan"
			if (!colorsValid()) {
				showNotice('warn', 'Kode Warna Tidak Valid', 'Kode warna harus berformat hex 6 digit, contoh: #094356.');
				return;
			}
			if (hasChanges()) {
				openConfirmModal();
			} else {
				showNotice('info', 'Tidak Ada Perubahan', 'Anda belum melakukan perubahan apa pun pada pengaturan ini.');
			}
		});

		// ---------- Batal edit ----------
		function openCancelModal() { fillList(document.getElementById('cancelList'), listChanges()); cancelOverlay.classList.add('is-open'); }
		function closeCancelModal() { cancelOverlay.classList.remove('is-open'); }

		function discardChanges() {
			logoNameInput.value = originalValues.logo_name;
			taglineInput.value = originalValues.brand_tagline;
			footerDescInput.value = originalValues.footer_description;
			mediaPreview.innerHTML = originalPreviewHTML;
			syncMediaState();
			mediaInput.value = '';
			appliedFile = null;
			lastOriginalFile = null;
			recropBtn.hidden = true;
			mediaChanged = false;
			restoreColors();
			exitEditMode();
			closeCancelModal();
		}

		cancelBtn.addEventListener('click', function () {
			if (hasChanges()) {
				openCancelModal();
			} else {
				exitEditMode(); // tidak ada perubahan, langsung keluar dari mode edit
			}
		});
		cancelKeepBtn.addEventListener('click', closeCancelModal);
		cancelDiscardBtn.addEventListener('click', discardChanges);
		cancelOverlay.addEventListener('click', function (e) {
			if (e.target === cancelOverlay) closeCancelModal();
		});

		confirmCancelBtn.addEventListener('click', function () {
			closeConfirmModal();
		});

		confirmSaveBtn.addEventListener('click', function () {
			commitSave();
		});

		confirmOverlay.addEventListener('click', function (e) {
			if (e.target === confirmOverlay) {
				closeConfirmModal();
			}
		});
	});

	/* ===== Header diam di atas; kartu pengaturan bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var header = main ? main.querySelector('.head-title') : null;
		var card = document.querySelector('#content main .settings-card');
		if (!main || !header || !card) return;
		var spacer = null;
		var cardHead = card.querySelector(':scope > .head');
		function pinHeader() {
			if (header.classList.contains('page-header-fixed')) return;
			var r = header.getBoundingClientRect();
			spacer = document.createElement('div');
			spacer.style.height = r.height + 'px';
			header.parentNode.insertBefore(spacer, header.nextSibling);
			header.style.top = r.top + 'px';
			header.classList.add('page-header-fixed');
		}
		function pinCardHead() {
			if (!cardHead || cardHead.classList.contains('card-head-fixed')) return;
			var cs = getComputedStyle(card);
			var pt = parseFloat(cs.paddingTop) || 0, pl = parseFloat(cs.paddingLeft) || 0, pr = parseFloat(cs.paddingRight) || 0;
			card.style.paddingTop = '0px';
			cardHead.style.margin = '0 -' + pr + 'px 0 -' + pl + 'px';
			cardHead.style.padding = pt + 'px ' + pr + 'px 16px ' + pl + 'px';
			cardHead.classList.add('card-head-fixed');
		}
		function syncLayout() {
			var mainTop = main.getBoundingClientRect().top;
			main.style.height = (window.innerHeight - mainTop) + 'px';
			main.style.overflow = 'hidden';
			var ref = spacer || header;
			var hr = ref.getBoundingClientRect();
			header.style.left = hr.left + 'px';
			header.style.width = hr.width + 'px';
			var cardRect = card.getBoundingClientRect();
			var bar = document.querySelector('.form-actions');
			if (bar) {
				bar.style.left = cardRect.left + 'px';
				bar.style.width = cardRect.width + 'px';
			}
			var barH = (bar && getComputedStyle(bar).position === 'fixed') ? bar.getBoundingClientRect().height : 0;
			var available = window.innerHeight - cardRect.top - barH - 16;
			if (available < 200) available = 200;
			card.style.maxHeight = available + 'px';
		}
		pinHeader();
		pinCardHead();
		syncLayout();
		window.addEventListener('resize', syncLayout);
		setTimeout(syncLayout, 300);
	})();
</script>
@endpush