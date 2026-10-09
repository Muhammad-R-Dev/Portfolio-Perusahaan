@extends('admin.layouts.app')

@section('title', 'Pengaturan Halaman | Admin Astabrata Teknologi')
@section('page-title', 'Pengaturan Halaman')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
	/* ===== PENGATURAN HALAMAN (satu kartu lebar, preview menyatu di dalamnya) ===== */
	#content main .pages-card {
		background: var(--light);
		border-radius: 24px;
		padding: 36px 40px 28px;
		margin-top: 0px;
		width: 100%;
		box-sizing: border-box;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
	}
	#content main .pages-card h3 {
		font-size: 24px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 6px;
	}
	#content main .pages-card .sub {
		font-size: 15px;
		color: var(--dark-grey);
		margin-bottom: 26px;
	}

	/* Notifikasi */
	#content main .alert-box {
		margin-top: 20px;
		padding: 14px 18px;
		border-radius: 12px;
		font-size: 14.5px;
	}
	#content main .alert-box.success { background: #e7f6ec; color: #1b6b3a; }
	#content main .alert-box.error { background: #fdecec; color: #a12a2a; }
	#content main .alert-box ul { margin: 0; padding-left: 18px; }

	/* Tab pilih halaman */
	#content main .page-tabs {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 10px;
		margin-bottom: 28px;
	}
	#content main .page-tab {
		border: 1px solid var(--grey);
		background: var(--grey);
		color: var(--dark);
		font-size: 15px;
		font-weight: 500;
		padding: 11px 26px;
		border-radius: 36px;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .page-tab:hover { border-color: var(--blue); }
	#content main .page-tab.active {
		background: var(--blue);
		border-color: var(--blue);
		color: #fff;
	}

	/* ===== Layout 2 kolom: form di kiri, preview kecil di kanan ===== */
	#content main .pages-layout {
		display: grid;
		grid-template-columns: minmax(0, 1fr);
		grid-gap: 28px;
		align-items: start;
	}
	/* Edit warna di kiri, card preview di kanannya */
	#content main .color-layout {
		display: grid;
		grid-template-columns: minmax(0, 340px) 420px;
		grid-gap: 24px;
		justify-content: start;
		align-items: start;
	}
	#content main .color-fields { min-width: 0; }
	#content main .pages-main { min-width: 0; }
	#content main .preview-aside {
		position: sticky;
		top: 20px;
	}

	/* ===== PREVIEW (kartu kecil di sidebar kanan) ===== */
	#content main .preview-section {
		border: 1px solid var(--grey);
		border-radius: 18px;
		padding: 22px;
	}
	#content main .preview-head {
		display: flex;
		flex-direction: column;
		align-items: stretch;
		grid-gap: 10px;
		margin-bottom: 14px;
	}
	#content main .preview-head h4 {
		display: flex;
		align-items: center;
		grid-gap: 8px;
		font-size: 15px;
		font-weight: 600;
		color: var(--dark);
	}
	#content main .preview-head h4 i { font-size: 19px; color: var(--blue); }
	#content main .preview-head h4 span {
		font-size: 12px;
		font-weight: 400;
		color: var(--dark-grey);
	}
	#content main .preview-head .mode-switch { display: flex; width: 100%; }
	#content main .preview-head .mode-btn {
		flex: 1;
		justify-content: center;
		padding: 8px 10px;
		font-size: 12.5px;
		grid-gap: 6px;
	}
	#content main .preview-head .mode-btn .bx { font-size: 15px; }
	#content main .preview-box {
		border-radius: 14px;
		border: 1px solid var(--grey);
		padding: 40px 28px;
		min-height: 260px;
		display: flex;
		flex-direction: column;
		justify-content: center;
		text-align: center;
		overflow: hidden;
		transition: background .25s ease;
	}
	#content main .preview-box h2 {
		font-size: 26px;
		font-weight: 700;
		line-height: 1.25;
		margin-bottom: 12px;
		word-break: break-word;
	}
	#content main .preview-box p {
		font-size: 14.5px;
		line-height: 1.6;
		margin: 0 auto;
		max-width: 100%;
		white-space: pre-line;
		word-break: break-word;
	}
	#content main .preview-note { display: none; margin-top: 10px; font-size: 11.5px; color: var(--dark-grey); }

	/* Switch mode terang / gelap */
	#content main .mode-switch {
		display: inline-flex;
		background: var(--grey);
		border-radius: 36px;
		padding: 5px;
	}
	#content main .mode-btn {
		display: inline-flex;
		align-items: center;
		grid-gap: 8px;
		border: none;
		background: transparent;
		color: var(--dark);
		font-size: 14.5px;
		font-weight: 500;
		padding: 9px 20px;
		border-radius: 36px;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .mode-btn .bx { font-size: 18px; }
	#content main .mode-btn.active { background: var(--blue); color: #fff; }

	#content main #pagesForm[data-mode="light"] .mode-block[data-mode="dark"] { display: none; }
	#content main #pagesForm[data-mode="dark"] .mode-block[data-mode="light"] { display: none; }

	/* ===== PANEL HALAMAN ===== */
	#content main .page-panel { display: none; }
	#content main .page-panel.active { display: block; }

	#content main .panel-hint {
		display: flex;
		grid-gap: 10px;
		align-items: flex-start;
		padding: 14px 18px;
		margin-bottom: 26px;
		border-radius: 14px;
		background: var(--light-blue);
		color: var(--dark);
		font-size: 14px;
		line-height: 1.55;
	}
	#content main .panel-hint i { font-size: 22px; color: var(--blue); flex-shrink: 0; }

	#content main .block-title {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		grid-gap: 4px 10px;
		margin: 6px 0 18px;
	}
	#content main .block-title h4 {
		display: flex;
		align-items: center;
		grid-gap: 10px;
		font-size: 17px;
		font-weight: 600;
		color: var(--dark);
	}
	#content main .block-title h4 i { font-size: 22px; color: var(--blue); }
	#content main .block-title p { width: 100%; font-size: 13.5px; color: var(--dark-grey); }
	#content main .block-divider {
		margin: 12px 0 28px;
		border: 0;
		border-top: 1px solid var(--grey);
	}

	/* Form */
	#content main .form-group { margin-bottom: 22px; }
	#content main .form-group label {
		display: block;
		font-size: 14.5px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 10px;
	}
	#content main .form-group input[type="text"],
	#content main .form-group textarea {
		width: 100%;
		background: var(--grey);
		border: 1px solid transparent;
		border-radius: 14px;
		padding: 15px 18px;
		font-size: 15px;
		font-family: inherit;
		color: var(--dark);
		outline: none;
		transition: .2s ease;
	}
	#content main .form-group textarea { min-height: 130px; resize: vertical; line-height: 1.6; }
	#content main .form-group input[type="text"]:focus,
	#content main .form-group textarea:focus {
		border-color: var(--blue);
		background: var(--light);
	}
	#content main .form-group small.hint {
		display: block;
		margin-top: 8px;
		font-size: 13px;
		color: var(--dark-grey);
	}

	/* Judul di atas, deskripsi di bawahnya (tersusun atas-bawah) */
	#content main .text-grid {
		display: grid;
		grid-template-columns: minmax(0, 1fr);
		grid-gap: 0;
	}

	/* Warna */
	#content main .color-section {
		margin-top: 10px;
		padding-top: 26px;
		border-top: 1px solid var(--grey);
	}
	#content main .custom-toggle {
		display: flex;
		align-items: center;
		grid-gap: 12px;
		margin-bottom: 20px;
		font-size: 14.5px;
		font-weight: 500;
		color: var(--dark);
		cursor: pointer;
	}
	#content main .custom-toggle input { width: 20px; height: 20px; cursor: pointer; accent-color: var(--blue); }

	#content main .color-row { display: flex; align-items: center; grid-gap: 12px; }
	#content main .color-row input[type="color"] {
		width: 56px;
		height: 56px;
		padding: 4px;
		border: 1px solid var(--grey);
		border-radius: 14px;
		background: var(--light);
		cursor: pointer;
		flex-shrink: 0;
	}
	#content main .color-row input[type="text"] {
		max-width: 170px;
		text-transform: uppercase;
		font-family: monospace;
	}
	#content main .color-row input:disabled { opacity: .45; cursor: not-allowed; }

	#content main .form-grid-3 {
		display: grid;
		grid-template-columns: minmax(0, 1fr);
		grid-gap: 0;
	}

	/* Welcome: teks kiri, gambar kanan */
	#content main .welcome-layout {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 380px;
		grid-gap: 32px;
		align-items: start;
	}

	/* Uploader gambar (Welcome & Background): tampilan sama dengan Pengaturan Navbar */
	#content main .media-uploader { width: 100%; }
	#content main .media-uploader .media-label {
		display: block;
		font-size: 14.5px;
		font-weight: 600;
		margin-bottom: 10px;
		color: var(--dark);
	}
	#content main .media-upload-box {
		position: relative;
		border: 2px dashed var(--grey);
		border-radius: 14px;
		padding: 14px;
		text-align: center;
		background: var(--grey);
		cursor: pointer;
		transition: .2s ease;
		outline: none;
	}
	#content main .media-upload-box:hover,
	#content main .media-upload-box:focus-visible,
	#content main .media-upload-box.is-dragover {
		border-color: var(--blue);
		background: rgba(79, 142, 247, .08);
	}
	#content main .media-upload-box.is-locked { cursor: default; opacity: .75; }
	#content main .media-upload-box.is-locked:hover { border-color: var(--grey); background: var(--grey); }
	#content main .media-upload-box .media-preview {
		position: relative;
		width: 100%;
		aspect-ratio: var(--ratio, 16 / 9);
		border-radius: 10px;
		background: var(--light);
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		margin-bottom: 12px;
	}
	#content main .media-upload-box.is-empty .media-preview { border: 2px dashed var(--dark-grey); }
	#content main .media-upload-box .media-preview img {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
	#content main .media-upload-box .placeholder-content {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		grid-gap: 6px;
		padding: 10px;
		color: var(--dark-grey);
	}
	#content main .media-upload-box .placeholder-content .bx { font-size: 30px; color: var(--blue); }
	#content main .media-upload-box .placeholder-content span { font-size: 11px; font-weight: 500; }
	#content main .media-upload-box .badge {
		position: absolute;
		left: 12px;
		bottom: 12px;
		padding: 3px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
		color: #fff;
		background: var(--orange);
	}
	#content main .media-upload-box .upload-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		grid-gap: 6px;
		background: var(--blue);
		color: #fff;
		padding: 7px 16px;
		border-radius: 36px;
		font-size: 12px;
		font-weight: 600;
		pointer-events: none;
	}
	#content main .media-upload-box small {
		display: block;
		margin-top: 10px;
		font-size: 11.5px;
		color: var(--dark-grey);
	}
	#content main .media-upload-box .media-clear-btn,
	#content main .media-upload-box .media-view-btn {
		position: absolute;
		top: 20px;
		z-index: 2;
		width: 30px;
		height: 30px;
		border: none;
		border-radius: 50%;
		display: none;
		align-items: center;
		justify-content: center;
		font-size: 18px;
		cursor: pointer;
	}
	#content main .media-upload-box .media-clear-btn { right: 20px; background: var(--red); color: #fff; }
	#content main .media-upload-box .media-clear-btn:hover { opacity: .9; }
	#content main .media-upload-box .media-view-btn { left: 20px; background: var(--light); color: var(--dark); }
	#content main .media-upload-box .media-view-btn:hover { opacity: .85; }
	#content main .media-upload-box.has-media .media-view-btn { display: flex; }
	#content main .media-upload-box.has-media:not(.is-locked) .media-clear-btn { display: flex; }
	#content main .media-uploader .btn-recrop {
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		height: 34px;
		margin-top: 10px;
		padding: 0 14px;
		border: none;
		border-radius: 36px;
		background: var(--light-blue);
		color: var(--blue);
		font-family: inherit;
		font-size: 13px;
		font-weight: 600;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .media-uploader .btn-recrop:hover { background: var(--blue); color: var(--light); }
	#content main .media-uploader .btn-recrop[hidden] { display: none; }
	#content main .media-uploader .file-error { display: none; margin-top: 8px; font-size: 13.5px; color: #a13e1e; }
	#content main .media-uploader .file-error.show { display: block; }

	/* Background uploader: 2 card About dibuat lebih besar dan ukurannya sama */
	#content main .bg-uploader { max-width: 100%; }
	#content main .bg-pair {
		display: grid;
		grid-template-columns: repeat(2, minmax(0, 1fr));
		grid-gap: 28px;
		align-items: start;
	}
	#content main .bg-pair .bg-col {
		min-width: 0;
		width: 100%;
	}
	#content main .bg-pair .bg-uploader {
		max-width: none;
		width: 100%;
	}
	#content main .bg-pair .media-upload-box {
		width: 100%;
		aspect-ratio: 16 / 9;
	}

	/* Blog: judul & deskripsi di kiri, background gambar di kanan dengan tinggi sejajar */
	#content main .blog-layout {
		display: grid;
		grid-template-columns: minmax(0, 1fr) 380px;
		grid-gap: 32px;
		align-items: stretch;
	}
	#content main .blog-layout .blog-text { min-width: 0; }
	#content main .blog-layout .bg-col { min-width: 0; display: flex; flex-direction: column; }
	#content main .blog-layout .bg-uploader { max-width: none; flex: 1; display: flex; flex-direction: column; }
	#content main .blog-layout .media-upload-box { flex: 1; }
	@media screen and (max-width: 992px) {
		#content main .blog-layout { grid-template-columns: 1fr; }
	}
	@media screen and (max-width: 700px) {
		#content main .bg-pair { grid-template-columns: 1fr; }
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
	/* Ruang kosong di bawah kartu supaya konten tidak tertutup bar tombol yang fixed */
	#content main .pages-card { padding-bottom: 36px; }
	@media screen and (max-width: 576px) {
		#content main .form-actions {
			left: 16px;
			right: 16px;
			bottom: 12px;
			padding: 10px 12px;
			justify-content: stretch;
			border-radius: 0 0 14px 14px;
		}
		#content main .form-actions .btn-pages { flex: 1; padding: 13px 10px; font-size: 14px; }
	}
	#content main .btn-pages {
		border: none;
		border-radius: 36px;
		padding: 14px 32px;
		font-size: 15px;
		font-weight: 600;
		cursor: pointer;
		transition: .2s ease;
	}
	#content main .btn-pages.primary { background: var(--blue); color: #fff; }
	#content main .btn-pages.primary:hover { opacity: .88; }
	#content main .btn-pages.ghost { background: var(--red, #ef5a5a); color: #fff; }
	#content main .btn-pages.ghost:hover { opacity: .88; }
	#content main .btn-pages .bx { font-size: 18px; vertical-align: -3px; margin-right: 4px; }

	/* Input dalam mode lihat (sebelum klik Edit) */
	#content main .form-group input[type="text"]:disabled,
	#content main .form-group textarea:disabled,
	#content main .color-row input:disabled,
	#content main .custom-toggle input:disabled {
		opacity: .65;
		cursor: not-allowed;
	}

	/* Modal konfirmasi perubahan */
	.pg-modal-box.confirm-box { max-width: 480px; }
	.confirm-box h4 {
		font-size: 18px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 8px;
		display: flex;
		align-items: center;
		grid-gap: 8px;
	}
	.confirm-box h4 i { font-size: 22px; color: var(--blue); }
	.confirm-box p.confirm-message {
		font-size: 14px;
		color: var(--dark-grey);
		margin-bottom: 4px;
	}
	.confirm-list {
		list-style: disc;
		margin: 12px 0 4px;
		max-height: 220px;
		overflow-y: auto;
		font-size: 13.5px;
		color: var(--dark);
		background: var(--grey);
		border-radius: 12px;
		padding: 14px 14px 14px 30px;
	}
	.confirm-list li { margin-bottom: 7px; line-height: 1.5; }
	.confirm-list li:last-child { margin-bottom: 0; }
	.confirm-actions {
		display: flex;
		justify-content: flex-end;
		grid-gap: 10px;
		margin-top: 20px;
	}

	/* Modal preview gambar */
	.pg-modal {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, .6);
		z-index: 5000;
		justify-content: center;
		align-items: center;
		padding: 16px;
	}
	.pg-modal.show { display: flex; }
	.pg-modal-box {
		background: var(--light);
		border-radius: 16px;
		width: 100%;
		max-width: 900px;
		padding: 18px;
		color: var(--dark);
	}
	.pg-modal-image {
		width: 100%;
		aspect-ratio: 12 / 7;
		border-radius: 12px;
		background: var(--grey) center / contain no-repeat;
		border: 1px solid var(--grey);
		margin-bottom: 14px;
	}
	.pg-modal-actions { display: flex; align-items: center; justify-content: space-between; grid-gap: 10px; }
	.pg-modal-actions span { font-size: 13px; color: var(--dark-grey); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
	.pg-modal-close {
		height: 36px;
		padding: 0 16px;
		border-radius: 36px;
		border: 1px solid var(--dark-grey);
		background: transparent;
		color: var(--dark);
		font-family: inherit;
		font-size: 13px;
		font-weight: 600;
		cursor: pointer;
	}

	@media screen and (max-width: 992px) {
		#content main .pages-card { padding: 28px 24px 32px; }
		#content main .text-grid { grid-template-columns: 1fr; }
		#content main .welcome-layout { grid-template-columns: 1fr; }
		#content main .pages-layout { grid-template-columns: 1fr; }
		#content main .color-layout { grid-template-columns: 1fr; }
		#content main .preview-aside { position: static; order: -1; margin-bottom: 8px; }
		#content main .preview-head { flex-direction: row; align-items: center; justify-content: space-between; }
		#content main .preview-head .mode-switch { width: auto; }
		#content main .preview-box { padding: 36px 24px; min-height: 220px; }
		#content main .preview-box h2 { font-size: 24px; }
		#content main .preview-box p { font-size: 14px; }
	}
	@media screen and (max-width: 700px) {
		#content main .form-grid-3 { grid-template-columns: 1fr; }
		#content main .preview-box h2 { font-size: 26px; }
		#content main .preview-box p { font-size: 15px; }
	}
	@media screen and (max-width: 576px) {
		#content main .pages-card { padding: 22px 16px 28px; border-radius: 18px; }
		#content main .page-tab { padding: 9px 18px; font-size: 14px; }
	}

	/* ===== Judul + tab halaman menempel di atas kartu saat scroll ===== */
	#content main .pages-card { --pc-x: 40px; --pc-t: 36px; padding-top: 0; }
	#content main .pages-fixed-head {
		position: sticky;
		top: 0;
		z-index: 20;
		background: var(--light);
		margin: 0 calc(-1 * var(--pc-x)) 24px;
		padding: var(--pc-t) var(--pc-x) 14px;
		border-bottom: 1px solid var(--grey);
	}
	#content main .pages-fixed-head .sub { margin-bottom: 18px; }
	#content main .pages-fixed-head .page-tabs { margin-bottom: 0; }
	#content main .preview-aside { top: calc(var(--pages-head-h, 170px) + 16px); }
	@media screen and (max-width: 992px) {
		#content main .pages-card { --pc-x: 24px; --pc-t: 28px; padding-top: 0; }
	}
	@media screen and (max-width: 576px) {
		#content main .pages-card { --pc-x: 16px; --pc-t: 22px; padding-top: 0; }
	}

	#content main .pages-title-row { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }
	#content main .pages-title-row h3 { margin-bottom: 0; }
	#content main .pages-back-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 36px;
		height: 36px;
		border-radius: 50%;
		background: var(--grey);
		color: var(--blue);
		font-size: 18px;
		flex-shrink: 0;
		text-decoration: none;
	}
	#content main a.pages-back-btn { background: var(--grey) !important; color: var(--blue) !important; }
	#content main a.pages-back-btn i { color: var(--blue) !important; }
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

	body.dark #content main .form-actions {
		box-shadow: 0 12px 30px rgba(0, 0, 0, .30);
	}
	#content main .pages-card { border-bottom-left-radius: 0; border-bottom-right-radius: 0; }

	/* Modal crop gambar: tampilan sama dengan Pengaturan Navbar */
	.pg-crop-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 5000; align-items: center; justify-content: center; padding: 16px; }
	.pg-crop-overlay.is-open { display: flex; }
	.pg-crop-box { background: var(--light); border-radius: 20px; padding: 24px; width: 100%; max-width: 640px; max-height: 94vh; overflow-y: auto; box-shadow: 0 10px 40px rgba(0, 0, 0, .25); font-family: var(--poppins); color: var(--dark); }
	.pg-crop-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
	.pg-crop-head h4 { font-size: 18px; font-weight: 600; margin: 0; }
	.pg-crop-head p { font-size: 12px; color: var(--dark-grey); margin-top: 2px; }
	.pg-crop-x { width: 34px; height: 34px; border: none; border-radius: 50%; background: var(--grey); color: var(--dark); font-size: 20px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
	.pg-crop-x:hover { opacity: .85; }
	.pg-crop-stage { width: 100%; height: min(50vh, 400px); background: #1b1b1b; border-radius: 12px; overflow: hidden; }
	.pg-crop-stage img { display: block; max-width: 100%; }
	.pg-crop-tools { display: flex; justify-content: flex-end; margin: 14px 0 18px; }
	.pg-crop-group { display: flex; flex-wrap: wrap; gap: 6px; }
	.pg-crop-group button { height: 34px; min-width: 34px; padding: 0 12px; border: none; border-radius: 36px; background: var(--grey); color: var(--dark); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; }
	.pg-crop-group button:hover { opacity: .85; }
	.pg-crop-actions { display: flex; gap: 12px; justify-content: flex-end; }
	.pg-crop-actions button { height: 42px; padding: 0 22px; border: none; border-radius: 36px; font-family: var(--poppins); font-size: 14px; font-weight: 600; color: #fff; cursor: pointer; }
	.pg-crop-actions button:hover { opacity: .9; }
	#pgCropCancel { background: var(--red); }
	#pgCropApply { background: var(--blue); }
	#pgCropCancel { background: var(--red); }
	#pgCropApply { background: var(--blue); }

	/* Zoom kolom teks (deskripsi): ukuran sebesar card */
	.pg-zoom-overlay { display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .45); z-index: 5000; }
	.pg-zoom-overlay.is-open { display: block; }
	.pg-zoom-box { position: fixed; background: var(--light); border-radius: 20px; padding: 24px; display: flex; flex-direction: column; box-shadow: 0 10px 40px rgba(0, 0, 0, .25); font-family: var(--poppins); color: var(--dark); }
	.pg-zoom-label { font-size: 14px; font-weight: 500; margin-bottom: 8px; color: var(--dark); }
	.pg-zoom-area { flex: 1 1 auto; min-height: 0; resize: none; padding: 12px 16px; border: 1px solid var(--grey); background: var(--grey); border-radius: 10px; color: var(--dark); -webkit-text-fill-color: var(--dark); font-family: var(--poppins); font-size: 14px; line-height: 1.6; outline: none; }
	.pg-zoom-area:focus { border-color: var(--blue); background: var(--light); }
	.pg-zoom-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 16px; }
	.pg-zoom-actions button { height: 42px; padding: 0 22px; border: none; border-radius: 36px; font-family: var(--poppins); font-size: 14px; font-weight: 600; cursor: pointer; color: #fff; }
	.pg-zoom-actions button:hover { opacity: .9; }
	#pgZoomBack { background: #f5b800; }
	#pgZoomSave { background: var(--blue); }
</style>
@endpush

@section('content')
			@if(session('success'))
				<div id="successFlash" style="display:none;" data-message="{{ session('success') }}"></div>
			@endif
			@if($errors->any())
				<div class="alert-box error">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div class="pages-card">
				{{-- Judul + tab halaman: menempel (fixed) di atas kartu, hanya isi di bawahnya yang discroll --}}
				<div class="pages-fixed-head" id="pagesFixedHead">
					<div class="pages-title-row">
						<a href="{{ route('admin.setting.index') }}" class="pages-back-btn" title="Kembali ke Pengaturan" aria-label="Kembali ke Pengaturan"><i class='bx bx-arrow-back'></i></a>
						<h3>Edit Tampilan Halaman</h3>
					</div>
					<p class="sub">Pilih halaman, lihat hasilnya langsung di preview, lalu ubah teks dan warna untuk mode terang maupun gelap.</p>

					<div class="page-tabs" id="pageTabs">
						@foreach($defaults as $key => $def)
							<button type="button" class="page-tab {{ $loop->first ? 'active' : '' }}" data-page="{{ $key }}">{{ $def['label'] }}</button>
						@endforeach
					</div>
				</div>

				<div class="pages-layout">
					<div class="pages-main">
						<form id="pagesForm" method="POST" action="{{ route('admin.setting.pages.update') }}" enctype="multipart/form-data" data-mode="light" data-start-editing="{{ $errors->any() ? '1' : '0' }}">
							@csrf
							@method('PUT')

					@foreach($settings as $key => $ps)
						@php $def = $defaults[$key]; @endphp
						<div class="page-panel {{ $loop->first ? 'active' : '' }}"
							data-panel="{{ $key }}"
							data-name="{{ $def['label'] }}"
							data-default-title="{{ $def['title'] }}"
							data-default-desc="{{ $def['description'] }}">

							@if($key === 'beranda')
								{{-- ===== TENTANG KAMI (WELCOME) — ditaruh paling atas ===== --}}
								<div class="block-title">
									<h4><i class='bx bxs-happy-heart-eyes'></i> Tentang Kami (Welcome)</h4>
									<p>Judul, teks, dan gambar pada bagian sambutan di beranda.</p>
								</div>

								<div class="welcome-fields">
									<div class="form-group">
										<label for="welcome_title">Judul (Nama Perusahaan)</label>
										<input type="text" id="welcome_title" name="welcome_title" maxlength="150"
											value="{{ old('welcome_title', $welcome->title) }}" placeholder="Judul utama" required>
									</div>

									<div class="form-group">
										<label for="welcome_subtitle">Subjudul</label>
										<input type="text" id="welcome_subtitle" name="welcome_subtitle" maxlength="150"
											value="{{ old('welcome_subtitle', $welcome->subtitle) }}" placeholder="Contoh: Solusi Digital Terpadu" required>
									</div>

									<div class="form-group">
										<label for="welcome_text">Teks</label>
										<textarea id="welcome_text" name="welcome_text" maxlength="1000" placeholder="Tulis teks di sini..." required style="min-height: 190px;">{{ old('welcome_text', $welcome->description) }}</textarea>
										<small class="hint">Tampil sebagai paragraf di bagian Tentang Kami (maks. 1000 karakter).</small>
									</div>
								</div>

								{{-- ===== BACKGROUND HERO SECTION + GAMBAR WELCOME — dua uploader sejajar, ukuran sama ===== --}}
								<div class="bg-pair">
									<div class="bg-col">
										<div class="block-title">
											<h4><i class='bx bx-image'></i> Background Hero Section</h4>
											<p>Gambar latar paling atas (hero) di halaman Beranda.</p>
										</div>
										@php $bgUrlBeranda = $ps->bgUrl(); @endphp
										<div class="media-uploader bg-uploader" data-key="beranda">
											<div class="media-upload-box is-locked is-empty" tabindex="0" role="button"
												aria-label="Unggah background Beranda" data-ratio="16 / 9" data-size="1920 x 1080 px" data-crop-page="beranda_hero"
												data-existing-url="{{ $bgUrlBeranda ?? '' }}" data-existing-name="{{ $ps->bg_image ? basename($ps->bg_image) : '' }}">
												<div class="media-preview"></div>
												<button type="button" class="media-view-btn" title="Lihat preview" aria-label="Lihat preview"><i class='bx bx-show'></i></button>
												<button type="button" class="media-clear-btn" title="Hapus gambar" aria-label="Hapus gambar"><i class='bx bx-x'></i></button>
												<span class="upload-btn"><i class='bx bx-upload'></i> Upload Media</span>
												<small>Crop otomatis mengikuti area tampilan frontend halaman ini. Maks. 3MB. Format JPG/PNG/WEBP.</small>
											</div>
											<input type="file" class="media-input" name="bg_image[beranda]" accept="image/jpeg,image/png,image/webp" hidden>
											<input type="hidden" class="media-remove" name="remove_bg_image[beranda]" value="0">
											<button type="button" class="btn-recrop" hidden><i class='bx bx-crop'></i> Crop Ulang</button>
											<div class="file-error"></div>
										</div>
									</div>

									<div class="bg-col">
										<div class="block-title">
											<h4><i class='bx bx-image'></i> Gambar Welcome</h4>
											<p>Gambar pada bagian sambutan (Tentang Kami) di beranda.</p>
										</div>
										<div class="media-uploader bg-uploader" data-key="welcome">
											<div class="media-upload-box is-locked is-empty" id="dropzone" tabindex="0" role="button"
												aria-label="Unggah gambar welcome" data-ratio="12 / 7" data-size="1200 x 700 px"
												data-existing-url="{{ $welcome->image ? (\Illuminate\Support\Str::startsWith($welcome->image, ['http://', 'https://']) ? $welcome->image : asset('storage/' . $welcome->image)) : '' }}" data-existing-name="{{ $welcome->image ? basename($welcome->image) : '' }}">
												<div class="media-preview"></div>
												<button type="button" class="media-view-btn" title="Lihat preview" aria-label="Lihat preview"><i class='bx bx-show'></i></button>
												<button type="button" class="media-clear-btn" title="Hapus gambar" aria-label="Hapus gambar"><i class='bx bx-x'></i></button>
												<span class="upload-btn"><i class='bx bx-upload'></i> Upload Media</span>
												<small>Disarankan 1200x700px, maks. 3MB. Format JPG/PNG/WEBP.</small>
											</div>
											<input type="file" id="welcome_image" class="media-input" name="welcome_image" accept="image/jpeg,image/png,image/webp" hidden>
											<input type="hidden" id="removeWelcomeImage" class="media-remove" name="remove_welcome_image" value="0">
											<button type="button" class="btn-recrop" id="recropBtn" hidden><i class='bx bx-crop'></i> Crop Ulang</button>
											<div class="file-error" id="fileError"></div>
										</div>
									</div>
								</div>

								<hr class="block-divider">
							@endif

							@if($key !== 'login')
							{{-- ===== TEKS ===== --}}
@if($key === 'blog')<div class="blog-layout"><div class="blog-text">@endif
							<div class="block-title">
								<h4><i class='bx bx-text'></i> {{ $key === 'beranda' ? 'Judul & Deskripsi FAQ' : 'Judul & Deskripsi' }}</h4>
								@if($key === 'layanan')
								<p>Judul dan deskripsi yang tampil di atas daftar kartu layanan (bagian "Pilih Layanan Yang Anda Butuhkan").</p>
								@endif
							</div>

							<div class="text-grid">
								<div class="form-group">
									<label for="title-{{ $key }}">Judul</label>
									<input type="text" id="title-{{ $key }}" name="pages[{{ $key }}][title]" maxlength="120"
										value="{{ old("pages.$key.title", $ps->titleText()) }}"
										data-role="title" placeholder="Masukkan judul">
								</div>

								<div class="form-group">
								<label for="desc-{{ $key }}">{{ $key === 'about' ? 'Visi & Misi' : 'Deskripsi' }}</label>
									<textarea id="desc-{{ $key }}" name="pages[{{ $key }}][description]" maxlength="1000"
										data-role="desc" placeholder="Masukkan deskripsi">{{ old("pages.$key.description", $ps->descriptionText()) }}</textarea>
								</div>
							</div>
							@if($key === 'blog')</div>@endif

							@if($key === 'about')
							{{-- ===== DESKRIPSI (caption di bawah gambar "Tentang Kami") ===== --}}
							<div class="form-group">
								<label for="caption-{{ $key }}">Deskripsi</label>
								<textarea id="caption-{{ $key }}" name="pages[{{ $key }}][caption]" maxlength="1000"
									data-role="caption" placeholder="Masukkan deskripsi">{{ old("pages.$key.caption", $ps->captionText()) }}</textarea>
								<small class="hint">Tampil sebagai caption di bagian bawah gambar Tentang Kami.</small>
							</div>
							@endif
							@endif

							@if(in_array($key, ['blog', 'about', 'login']))
@if(in_array($key, ['about', 'login']))
<div class="bg-pair">
@endif
<div class="bg-col">
<div class="block-title">
    <h4><i class='bx bx-image'></i> {{ $key === 'about' ? 'Background Hero Section' : ($key === 'login' ? 'Background Halaman Login' : 'Background Gambar') }}</h4>
    <p>Gambar latar di bagian atas halaman {{ ucfirst($key) }}.</p>
</div>
@php $bgUrl = $ps->bgUrl(); @endphp
<div class="media-uploader bg-uploader" data-key="{{ $key }}">
									<div class="media-upload-box is-locked is-empty" tabindex="0" role="button"
										aria-label="Unggah background {{ $def['label'] }}" data-ratio="16 / 9" data-size="1920 x 1080 px" data-crop-page="{{ $key }}"
										data-existing-url="{{ $bgUrl ?? '' }}" data-existing-name="{{ $ps->bg_image ? basename($ps->bg_image) : '' }}">
										<div class="media-preview"></div>
										<button type="button" class="media-view-btn" title="Lihat preview" aria-label="Lihat preview"><i class='bx bx-show'></i></button>
										<button type="button" class="media-clear-btn" title="Hapus gambar" aria-label="Hapus gambar"><i class='bx bx-x'></i></button>
										<span class="upload-btn"><i class='bx bx-upload'></i> Upload Media</span>
										<small>Crop otomatis mengikuti area tampilan frontend halaman ini. Maks. 3MB. Format JPG/PNG/WEBP.</small>
									</div>
									<input type="file" class="media-input" name="bg_image[{{ $key }}]" accept="image/jpeg,image/png,image/webp" hidden>
									<input type="hidden" class="media-remove" name="remove_bg_image[{{ $key }}]" value="0">
									<button type="button" class="btn-recrop" hidden><i class='bx bx-crop'></i> Crop Ulang</button>
									<div class="file-error"></div>
								</div>
</div>
@if($key === 'blog')</div>@endif
@if($key === 'about')
<div class="bg-col">
{{-- ===== BACKGROUND GAMBAR 2 (deskripsi Tentang Kami) ===== --}}
@php $ps2 = \App\Models\PageSetting::for('about_desc'); $bgUrl2 = $ps2->bgUrl(); @endphp
<div class="block-title">
    <h4><i class='bx bx-image'></i> Background Deskripsi</h4>
    <p>Gambar latar di bagian deskripsi Tentang Kami (gambar kedua di halaman About).</p>
</div>
<div class="media-uploader bg-uploader" data-key="about_desc">
									<div class="media-upload-box is-locked is-empty" tabindex="0" role="button"
										aria-label="Unggah background deskripsi About" data-ratio="16 / 9" data-size="1920 x 1080 px" data-crop-page="about_desc" data-crop-page="{{ $key }}"
										data-existing-url="{{ $bgUrl2 ?? '' }}" data-existing-name="{{ $ps2->bg_image ? basename($ps2->bg_image) : '' }}">
										<div class="media-preview"></div>
										<button type="button" class="media-view-btn" title="Lihat preview" aria-label="Lihat preview"><i class='bx bx-show'></i></button>
										<button type="button" class="media-clear-btn" title="Hapus gambar" aria-label="Hapus gambar"><i class='bx bx-x'></i></button>
										<span class="upload-btn"><i class='bx bx-upload'></i> Upload Media</span>
										<small>Crop otomatis mengikuti area tampilan frontend halaman ini. Maks. 3MB. Format JPG/PNG/WEBP.</small>
									</div>
									<input type="file" class="media-input" name="bg_image[about_desc]" accept="image/jpeg,image/png,image/webp" hidden>
									<input type="hidden" class="media-remove" name="remove_bg_image[about_desc]" value="0">
									<button type="button" class="btn-recrop" hidden><i class='bx bx-crop'></i> Crop Ulang</button>
									<div class="file-error"></div>
								</div>
</div>
@endif
@if(in_array($key, ['about', 'login']))
</div>
@endif
@endif

							@if($key !== 'login')
							{{-- ===== WARNA ===== --}}
							<div class="color-section">
								<div class="block-title">
									<h4><i class='bx bx-palette'></i> Warna Tampilan</h4>
									@if($key !== 'layanan')
									<p>Mengikuti mode yang dipilih di atas preview.</p>
									@endif
								</div>

								<div class="color-layout">
									<div class="color-fields">
								@foreach(['light' => 'Mode Terang', 'dark' => 'Mode Gelap'] as $mode => $modeLabel)
									@php $custom = $key === 'layanan' ? true : $ps->isCustom($mode); @endphp
									<div class="mode-block" data-mode="{{ $mode }}">
										@if($key === 'layanan')
											<input type="hidden" name="pages[{{ $key }}][{{ $mode }}_custom]" value="1">
										@else
											<label class="custom-toggle">
												<input type="checkbox" class="js-custom" name="pages[{{ $key }}][{{ $mode }}_custom]" value="1" {{ $custom ? 'checked' : '' }}>
												Pakai warna kustom untuk {{ $modeLabel }}
											</label>
										@endif

										<div class="form-grid-3">
											@php
													$parts = $key === 'layanan'
														? ['canvas' => 'Warna Canvas (Kotak Kanan)', 'title' => 'Warna Teks Judul', 'desc' => 'Warna Teks Deskripsi']
														: ['bg' => 'Warna Background', 'title' => 'Warna Teks Judul', 'desc' => 'Warna Teks Deskripsi'];
												@endphp
												@foreach($parts as $part => $partLabel)
												@php
													$field = $mode . '_' . $part;
													$val = $ps->colorValue($field);
												@endphp
												<div class="form-group">
													<label>{{ $partLabel }}</label>
													<div class="color-row" data-key="{{ $part }}">
														<input type="color" class="c-picker" name="pages[{{ $key }}][{{ $field }}]" value="{{ $val }}" {{ $custom ? '' : 'disabled' }}>
														<input type="text" class="c-hex" maxlength="7" value="{{ strtoupper($val) }}" aria-label="Kode {{ strtolower($partLabel) }}" {{ $custom ? '' : 'disabled' }}>
													</div>
												</div>
											@endforeach
										</div>
									</div>
								@endforeach
									</div>
									<div class="preview-slot"></div>
								</div>
							</div>
							@endif
						</div>
					@endforeach

					<div class="form-actions">
						<button type="button" class="btn-pages ghost" id="btnCancelEdit" style="display:none;"><i class='bx bx-x'></i>Batal</button>
						<button type="button" class="btn-pages primary" id="btnEdit"><i class='bx bx-edit-alt'></i>Edit</button>
						<button type="submit" class="btn-pages primary" id="btnSave" style="display:none;"><i class='bx bx-save'></i>Simpan Perubahan</button>
					</div>
						</form>
					</div>

					<aside class="preview-aside">
						{{-- ===== PREVIEW (kartu kecil di sebelah kanan) ===== --}}
						<div class="preview-section">
							<div class="preview-head">
								<h4><i class='bx bx-show'></i> Preview <span id="previewInfo"></span></h4>
								<div class="mode-switch" id="modeSwitch">
									<button type="button" class="mode-btn active" data-mode="light"><i class='bx bx-sun'></i> Terang</button>
									<button type="button" class="mode-btn" data-mode="dark"><i class='bx bx-moon'></i> Gelap</button>
								</div>
							</div>
							<div class="preview-box" id="previewBox">
								<h2 id="previewTitle"></h2>
								<p id="previewDesc"></p>
							</div>
							<p class="preview-note" id="previewNote">Warna kustom nonaktif: website memakai warna bawaan. Preview di atas hanya perkiraan.</p>
						</div>
					</aside>
				</div>
			</div>

			{{-- Zoom kolom teks (deskripsi) --}}
			<div class="pg-zoom-overlay" id="pgZoomOverlay">
				<div class="pg-zoom-box" id="pgZoomBox">
					<label class="pg-zoom-label" id="pgZoomLabel" for="pgZoomArea">Deskripsi</label>
					<textarea class="pg-zoom-area" id="pgZoomArea"></textarea>
					<div class="pg-zoom-actions">
						<button type="button" id="pgZoomBack"><i class='bx bx-arrow-back'></i> Kembali</button>
						<button type="button" id="pgZoomSave"><i class='bx bx-save'></i> Simpan</button>
					</div>
				</div>
			</div>

			{{-- Modal crop gambar (dipakai saat upload foto) --}}
<div class="pg-crop-overlay" id="pgCropOverlay">
    <div class="pg-crop-box">
        <div class="pg-crop-head">
            <div>
                <h4>Crop Gambar</h4>
                <p>Geser dan atur area potong, lalu klik &ldquo;Pakai Gambar&rdquo;.</p>
            </div>
            <button type="button" class="pg-crop-x" id="pgCropClose" aria-label="Tutup"><i class='bx bx-x'></i></button>
        </div>
        <div class="pg-crop-stage"><img id="pgCropImage" alt="Gambar yang akan di-crop"></div>
        <div class="pg-crop-tools">
            <div class="pg-crop-group">
                <button type="button" id="pgCropZoomIn" title="Zoom in"><i class='bx bx-zoom-in'></i></button>
                <button type="button" id="pgCropZoomOut" title="Zoom out"><i class='bx bx-zoom-out'></i></button>
                <button type="button" id="pgCropRotL" title="Putar kiri"><i class='bx bx-rotate-left'></i></button>
                <button type="button" id="pgCropRotR" title="Putar kanan"><i class='bx bx-rotate-right'></i></button>
                <button type="button" id="pgCropReset" title="Reset"><i class='bx bx-reset'></i></button>
            </div>
        </div>
        <div class="pg-crop-actions">
            <button type="button" id="pgCropCancel">Batal</button>
            <button type="button" id="pgCropApply">Pakai Gambar</button>
        </div>
    </div>
</div>

			{{-- Modal preview gambar Welcome --}}
			<div class="pg-modal" id="previewModal">
				<div class="pg-modal-box">
					<div class="pg-modal-image" id="previewImage"></div>
					<div class="pg-modal-actions">
						<span id="previewCaption"></span>
						<button type="button" class="pg-modal-close" id="btnClosePreview">Tutup</button>
					</div>
				</div>
			</div>

			{{-- Modal konfirmasi perubahan (Simpan / Batal) --}}
			<div class="pg-modal" id="confirmModal">
				<div class="pg-modal-box confirm-box">
					<h4><i class='bx bx-info-circle' id="confirmIcon"></i> <span id="confirmTitle">Konfirmasi</span></h4>
					<p class="confirm-message" id="confirmMessage"></p>
					<ul class="confirm-list" id="confirmList"></ul>
					<div class="confirm-actions">
						<button type="button" class="btn-pages ghost" id="confirmNo">Batal</button>
						<button type="button" class="btn-pages primary" id="confirmYes">Ya</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
	// Zoom kolom teks: klik textarea (saat mode edit) membuka layar sebesar card
	(function () {
		var form = document.getElementById('pagesForm');
		var overlay = document.getElementById('pgZoomOverlay');
		var box = document.getElementById('pgZoomBox');
		var area = document.getElementById('pgZoomArea');
		var labelEl = document.getElementById('pgZoomLabel');
		var card = document.querySelector('.pages-card');
		var target = null;

		function openZoom(t) {
			target = t;
			var r = card.getBoundingClientRect();
			box.style.left = r.left + 'px';
			box.style.top = r.top + 'px';
			box.style.width = r.width + 'px';
			box.style.height = r.height + 'px';
			var lbl = t.id ? document.querySelector('label[for="' + t.id + '"]') : null;
			labelEl.textContent = lbl ? lbl.textContent.trim() : 'Deskripsi';
			area.value = t.value;
			area.maxLength = t.maxLength > 0 ? t.maxLength : 1000;
			overlay.classList.add('is-open');
			area.focus();
		}
		function closeZoom() {
			overlay.classList.remove('is-open');
			target = null;
		}
		form.addEventListener('click', function (e) {
			var t = e.target;
			if (t && t.tagName === 'TEXTAREA' && !t.disabled && !t.readOnly && t.id !== 'pgZoomArea') openZoom(t);
		});
		document.getElementById('pgZoomBack').addEventListener('click', closeZoom);
		document.getElementById('pgZoomSave').addEventListener('click', function () {
			if (target) {
				target.value = area.value;
				target.dispatchEvent(new Event('input', { bubbles: true }));
				target.dispatchEvent(new Event('change', { bubbles: true }));
			}
			closeZoom();
		});
		overlay.addEventListener('click', function (e) { if (e.target === overlay) closeZoom(); });
	})();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
	// Helper crop gambar: dipanggil saat user memilih foto (sebelum dipasang)
	(function () {
		var overlay = document.getElementById('pgCropOverlay');
		var img = document.getElementById('pgCropImage');
		var cropper = null, objUrl = null, okCb = null, cancelCb = null, srcFile = null, aspect = 1;
		var MAX_OUT = 2 * 1024 * 1024;

		function closeCrop() {
			overlay.classList.remove('is-open');
			if (cropper) { cropper.destroy(); cropper = null; }
			if (objUrl) { URL.revokeObjectURL(objUrl); objUrl = null; }
			img.removeAttribute('src');
		}
		function cancelCrop() {
			var cb = cancelCb;
			closeCrop();
			if (cb) cb();
		}
		window.openImageCrop = function (file, onOk, onCancel, ratio) {
			if (typeof Cropper === 'undefined') { onOk(file); return; } // library gagal dimuat: pakai gambar apa adanya
			srcFile = file; okCb = onOk; cancelCb = onCancel; aspect = ratio || 1;
			objUrl = URL.createObjectURL(file);
			overlay.classList.add('is-open');
			img.onload = function () {
				if (cropper) cropper.destroy();
				cropper = new Cropper(img, { viewMode: 1, dragMode: 'move', autoCropArea: 0.9, responsive: true, checkOrientation: false, background: true, aspectRatio: aspect });
			};
			img.src = objUrl;
		};
		function exportCrop(sizes, i, type, done) {
			var canvas = cropper.getCroppedCanvas({ maxWidth: sizes[i], maxHeight: sizes[i], fillColor: type === 'image/jpeg' ? '#ffffff' : undefined, imageSmoothingQuality: 'high' });
			if (!canvas) { done(null); return; }
			canvas.toBlob(function (blob) {
				if (blob && blob.size <= MAX_OUT) { done(blob); return; }
				if (i + 1 < sizes.length) { exportCrop(sizes, i + 1, type, done); return; }
				done(null);
			}, type, 0.92);
		}
		document.getElementById('pgCropApply').addEventListener('click', function () {
			if (!cropper || !srcFile) return;
			var type = srcFile.type === 'image/png' ? 'image/png' : 'image/jpeg';
			exportCrop([2000, 1600, 1200, 800, 500], 0, type, function (blob) {
				if (!blob) { alert('Hasil crop masih lebih dari 2MB. Pilih area yang lebih kecil.'); return; }
				var ext = type === 'image/png' ? '.png' : '.jpg';
				var base = srcFile.name.replace(/\.[^.]+$/, '');
				var cropped = new File([blob], base + '-crop' + ext, { type: type, lastModified: Date.now() });
				var cb = okCb;
				closeCrop();
				if (cb) cb(cropped);
			});
		});
		document.getElementById('pgCropCancel').addEventListener('click', cancelCrop);
		document.getElementById('pgCropClose').addEventListener('click', cancelCrop);
		// Klik di luar card crop TIDAK menutup modal (hanya tombol Batal/X/Esc yang menutup)
		document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && overlay.classList.contains('is-open')) cancelCrop(); });
		document.getElementById('pgCropZoomIn').addEventListener('click', function () { if (cropper) cropper.zoom(0.1); });
		document.getElementById('pgCropZoomOut').addEventListener('click', function () { if (cropper) cropper.zoom(-0.1); });
		document.getElementById('pgCropRotL').addEventListener('click', function () { if (cropper) cropper.rotate(-90); });
		document.getElementById('pgCropRotR').addEventListener('click', function () { if (cropper) cropper.rotate(90); });
		document.getElementById('pgCropReset').addEventListener('click', function () { if (cropper) cropper.reset(); });
	})();
</script>

<script>
	// Status edit dipakai bersama oleh script form utama & script uploader gambar
	window.PagesEdit = { editing: false };

	(function () {
		var $ = function (id) { return document.getElementById(id); };
		var form = $('pagesForm');
		var box = $('previewBox'), pTitle = $('previewTitle'), pDesc = $('previewDesc');
		var info = $('previewInfo'), note = $('previewNote');
		var mode = 'light';

		var actionsBar = document.querySelector('.form-actions');
		var pagesCard = document.querySelector('.pages-card');
		function syncActionsBar() {
			if (!actionsBar || !pagesCard) return;
			var rect = pagesCard.getBoundingClientRect();
			actionsBar.style.left = rect.left + 'px';
			actionsBar.style.width = rect.width + 'px';
		}
		window.addEventListener('resize', syncActionsBar);
		window.addEventListener('load', syncActionsBar);
		setTimeout(syncActionsBar, 300); // jaga-jaga kalau sidebar admin baru selesai render

		var btnEdit = $('btnEdit'), btnCancelEdit = $('btnCancelEdit'), btnSave = $('btnSave');
		var confirmModal = $('confirmModal'), confirmTitle = $('confirmTitle'), confirmMessage = $('confirmMessage'),
			confirmList = $('confirmList'), confirmYes = $('confirmYes'), confirmNo = $('confirmNo'), confirmIcon = $('confirmIcon');

		var originalSnapshot = null;   // nilai field saat tombol Edit ditekan
		var uploaderSnapshot;
		var bgSnapshots = {};
		function eachBg(fn) {
			var m = window.pagesBgUploaders || {};
			Object.keys(m).forEach(function (k) { fn(k, m[k]); });
		}          // state gambar welcome saat tombol Edit ditekan
		var allowSubmit = false;       // flag supaya form boleh benar-benar terkirim setelah dikonfirmasi
		var pendingConfirm = null;

		/* ===== Util: label field untuk ditampilkan di daftar perubahan ===== */
		function fieldLabel(el) {
			if (el.id) {
				var lbl = form.querySelector('label[for="' + el.id + '"]');
				if (lbl) return lbl.textContent.trim();
			}
			if (el.classList.contains('c-picker')) {
				var row = el.closest('.color-row');
				var fg = row ? row.closest('.form-group') : null;
				var l2 = fg ? fg.querySelector('label') : null;
				if (l2) return l2.textContent.trim();
			}
			if (el.classList.contains('js-custom')) {
				var wrap = el.closest('.custom-toggle');
				if (wrap) return wrap.textContent.trim();
			}
			return el.name || el.id || 'Field';
		}
		function panelLabel(el) {
			var p = el.closest('.page-panel');
			if (p) return p.dataset.name;
			if (el.closest('.welcome-layout')) return 'Tentang Kami (Welcome)';
			return '';
		}

		/* ===== Snapshot & diff nilai form (di luar input gambar) ===== */
		function snapshotForm() {
			var data = {};
			form.querySelectorAll('[name]').forEach(function (el) {
				var n = el.name;
				if (!n || n === '_token' || n === '_method' || n === 'remove_welcome_image' || n.indexOf('remove_bg_image') === 0) return;
				if (el.type === 'file') return;
				data[n] = (el.type === 'checkbox' || el.type === 'radio') ? el.checked : el.value;
			});
			return data;
		}

		function describeChange(el, before, after) {
			var pl = panelLabel(el), label = fieldLabel(el), prefix = pl ? pl + ' — ' : '';
			if (el.type === 'checkbox') {
				return prefix + label + ': ' + (before ? 'Aktif' : 'Nonaktif') + ' → ' + (after ? 'Aktif' : 'Nonaktif');
			}
			if (el.classList.contains('c-picker')) {
				var modeBlock = el.closest('.mode-block');
				var modeLbl = (modeBlock && modeBlock.dataset.mode === 'dark') ? 'Mode Gelap' : 'Mode Terang';
				return prefix + label + ' (' + modeLbl + '): ' + String(before).toUpperCase() + ' → ' + String(after).toUpperCase();
			}
			return prefix + label;
		}

		function diffChanges() {
			var changes = [];
			if (!originalSnapshot) return changes;
			form.querySelectorAll('[name]').forEach(function (el) {
				var n = el.name;
				if (!n || n === '_token' || n === '_method' || n === 'remove_welcome_image' || n.indexOf('remove_bg_image') === 0) return;
				if (el.type === 'file') return;
				var before = originalSnapshot[n];
				var after = (el.type === 'checkbox' || el.type === 'radio') ? el.checked : el.value;
				if (before === after) return;
				changes.push(describeChange(el, before, after));
			});
			if (window.pagesUploader) {
				if (window.pagesUploader.hasChanged(uploaderSnapshot)) {
					changes.push('Tentang Kami (Welcome) — Gambar Welcome diubah');
				}
			}
			eachBg(function (k, u) {
				if (u.hasChanged(bgSnapshots[k])) {
					changes.push('Background ' + ({ beranda: 'Hero Beranda', blog: 'Blog', about: 'Hero About', about_desc: 'Deskripsi About' }[k] || k) + ' — Gambar diubah');
				}
			});
			return changes;
		}

		/* ===== Modal konfirmasi generik ===== */
		function openConfirm(opts) {
			confirmTitle.textContent = opts.title;
			confirmMessage.textContent = opts.message;
			confirmIcon.className = 'bx ' + (opts.icon || 'bx-info-circle');
			confirmIcon.style.color = opts.iconColor || '';
			confirmList.innerHTML = '';
			if (opts.changes && opts.changes.length) {
				opts.changes.forEach(function (c) {
					var li = document.createElement('li');
					li.textContent = c;
					confirmList.appendChild(li);
				});
				confirmList.style.display = '';
			} else {
				confirmList.style.display = 'none';
			}
			confirmYes.textContent = opts.confirmText || 'Ya';
			confirmNo.style.display = opts.hideCancel ? 'none' : '';
			confirmNo.textContent = opts.cancelText || 'Batal';
			pendingConfirm = opts.onConfirm || null;
			confirmModal.classList.add('show');
		}
		function closeConfirm() { confirmModal.classList.remove('show'); pendingConfirm = null; }
		confirmYes.addEventListener('click', function () {
			var cb = pendingConfirm;
			closeConfirm();
			if (cb) cb();
		});
		confirmNo.addEventListener('click', closeConfirm);
		confirmModal.addEventListener('click', function (e) { if (e.target === confirmModal) closeConfirm(); });

		/* ===== Mode Edit / Lihat ===== */
		function applyCustomToggles() {
			form.querySelectorAll('.js-custom').forEach(function (cb) { toggleCustom(cb); });
		}
		function enterEditMode() {
			window.PagesEdit.editing = true;
			originalSnapshot = snapshotForm();
			uploaderSnapshot = window.pagesUploader ? window.pagesUploader.getSnapshot() : null;
			eachBg(function (k, u) { bgSnapshots[k] = u.getSnapshot(); u.setEditing(true); });
			form.querySelectorAll('input, textarea').forEach(function (el) {
				if (el.type === 'hidden') return;
				el.disabled = false;
			});
			applyCustomToggles(); // kunci lagi color picker yang togglenya nonaktif
			if (window.pagesUploader) window.pagesUploader.setEditing(true);
			btnEdit.style.display = 'none';
			btnCancelEdit.style.display = '';
			btnSave.style.display = '';
		}
		function exitEditMode() {
			window.PagesEdit.editing = false;
			form.querySelectorAll('input, textarea').forEach(function (el) {
				if (el.type === 'hidden') return;
				el.disabled = true;
			});
			eachBg(function (k, u) { u.setEditing(false); });
			if (window.pagesUploader) window.pagesUploader.setEditing(false);
			btnEdit.style.display = '';
			btnCancelEdit.style.display = 'none';
			btnSave.style.display = 'none';
		}
		function restoreSnapshot() {
			if (!originalSnapshot) return;
			form.querySelectorAll('[name]').forEach(function (el) {
				var n = el.name;
				if (!n || !(n in originalSnapshot)) return;
				if (el.type === 'checkbox' || el.type === 'radio') {
					el.checked = originalSnapshot[n];
				} else if (el.type !== 'file') {
					el.value = originalSnapshot[n];
					if (el.classList.contains('c-picker')) {
						var hex = el.closest('.color-row').querySelector('.c-hex');
						if (hex) hex.value = el.value.toUpperCase();
					}
				}
			});
			form.querySelectorAll('.js-custom').forEach(function (cb) { toggleCustom(cb); });
			eachBg(function (k, u) { u.restore(bgSnapshots[k]); });
		if (window.pagesUploader) window.pagesUploader.restore(uploaderSnapshot);
		}

		btnEdit.addEventListener('click', function () { enterEditMode(); render(); });

		btnCancelEdit.addEventListener('click', function () {
			var changes = diffChanges();
			if (changes.length === 0) { exitEditMode(); render(); return; }
			openConfirm({
				title: 'Batalkan Perubahan?',
				message: 'Perubahan berikut belum disimpan dan akan hilang jika dibatalkan:',
				changes: changes,
				confirmText: 'Ya, Batalkan',
				cancelText: 'Tetap Edit',
				onConfirm: function () {
					restoreSnapshot();
					exitEditMode();
					render();
				}
			});
		});

		form.addEventListener('submit', function (e) {
			if (allowSubmit) { allowSubmit = false; return; }
			e.preventDefault();
			var changes = diffChanges();
			if (changes.length === 0) {
				openConfirm({
					title: 'Tidak Ada Perubahan',
					message: 'Anda belum melakukan perubahan apa pun pada pengaturan ini.',
					changes: [],
					hideCancel: true,
					confirmText: 'OK'
				});
				return;
			}
			openConfirm({
				title: 'Konfirmasi Simpan Perubahan',
				message: 'Perubahan berikut akan disimpan:',
				changes: changes,
				confirmText: 'Ya, Simpan',
				cancelText: 'Batal',
				onConfirm: function () {
					allowSubmit = true;
					if (form.requestSubmit) { form.requestSubmit(btnSave); } else { form.submit(); }
				}
			});
		});

		function panel() { return document.querySelector('.page-panel.active'); }
		var previewAside = document.querySelector('.preview-aside');
		function placePreview() {
			var slot = panel().querySelector('.preview-slot');
			if (slot && previewAside && previewAside.parentNode !== slot) { slot.appendChild(previewAside); }
		}
		function block() { return panel().querySelector('.mode-block[data-mode="' + mode + '"]'); }
		function col(key) { return block().querySelector('.color-row[data-key="' + key + '"] .c-picker').value; }
		function isHex(v) { return /^#[0-9a-fA-F]{6}$/.test(v); }

		function render() {
			var p = panel();
			var titleInput = p.querySelector('[data-role="title"]');
			var descInput = p.querySelector('[data-role="desc"]');
			pTitle.textContent = (titleInput ? titleInput.value : '') || p.dataset.defaultTitle || 'Judul halaman';
			pDesc.textContent = (descInput ? descInput.value : '') || p.dataset.defaultDesc || 'Deskripsi halaman';
			box.style.background = col(panel().dataset.panel === 'layanan' ? 'canvas' : 'bg');
			pTitle.style.color = col('title');
			pDesc.style.color = col('desc');
			info.textContent = '· ' + p.dataset.name + ' · ' + (mode === 'light' ? 'Mode Terang' : 'Mode Gelap');
			var customCb = block().querySelector('.js-custom');
			note.style.display = (!customCb || customCb.checked) ? 'none' : 'block';
		}

		// Aktif/nonaktifkan input warna sesuai centang "Pakai warna kustom"
		function toggleCustom(cb) {
			var on = cb.checked;
			cb.closest('.mode-block').querySelectorAll('.c-picker, .c-hex').forEach(function (el) {
				el.disabled = !on;
			});
		}

		// Ganti halaman
		document.querySelectorAll('#pageTabs .page-tab').forEach(function (btn) {
			btn.addEventListener('click', function () {
				document.querySelectorAll('#pageTabs .page-tab').forEach(function (b) { b.classList.remove('active'); });
				document.querySelectorAll('.page-panel').forEach(function (p) { p.classList.remove('active'); });
				btn.classList.add('active');
				document.querySelector('.page-panel[data-panel="' + btn.dataset.page + '"]').classList.add('active');
				placePreview();
				render();
				syncActionsBar();
			});
		});

		// Ganti mode terang / gelap
		document.querySelectorAll('#modeSwitch .mode-btn').forEach(function (btn) {
			btn.addEventListener('click', function () {
				document.querySelectorAll('#modeSwitch .mode-btn').forEach(function (b) { b.classList.remove('active'); });
				btn.classList.add('active');
				mode = btn.dataset.mode;
				form.setAttribute('data-mode', mode);
				render();
			});
		});

		// Input teks & warna (sinkron color picker <-> kode hex)
		form.addEventListener('input', function (e) {
			var t = e.target;
			if (t.classList.contains('c-picker')) {
				t.closest('.color-row').querySelector('.c-hex').value = t.value.toUpperCase();
			} else if (t.classList.contains('c-hex')) {
				var v = t.value.charAt(0) === '#' ? t.value : '#' + t.value;
				if (isHex(v)) { t.closest('.color-row').querySelector('.c-picker').value = v; }
			}
			render();
		});

		form.addEventListener('change', function (e) {
			if (e.target.classList.contains('js-custom')) { toggleCustom(e.target); render(); }
		});

		placePreview();
		if (form.dataset.startEditing === '1') { enterEditMode(); } else { exitEditMode(); }
		render();
		syncActionsBar();

		// Notifikasi pop up hasil simpan (menggantikan alert-box lama)
		var successFlash = $('successFlash');
		if (successFlash && successFlash.dataset.message) {
			openConfirm({
				title: 'Berhasil',
				message: successFlash.dataset.message,
				icon: 'bx-check-circle',
				iconColor: '#1b6b3a',
				changes: [],
				hideCancel: true,
				confirmText: 'OK'
			});
		}
	})();

		/* ===== Uploader gambar (Welcome & Background): tampilan & perilaku sama dengan Pengaturan Navbar ===== */
		(function () {
			var MAX = 3 * 1024 * 1024;
			var ALLOWED = ['image/jpeg', 'image/png', 'image/webp'];
			var modal = document.getElementById('previewModal');
			var previewImg = document.getElementById('previewImage');
			var previewCap = document.getElementById('previewCaption');

			function formatSize(b) {
				return b < 1024 * 1024 ? Math.round(b / 1024) + ' KB' : (b / (1024 * 1024)).toFixed(1) + ' MB';
			}
			function parseRatio(s) {
				var p = String(s || '').split('/');
				var r = parseFloat(p[0]) / parseFloat(p[1]);
				return r > 0 ? r : 1;
			}
			function isEditing() {
				return !!(window.PagesEdit && window.PagesEdit.editing);
			}

			function closePreview() { modal.classList.remove('show'); }
			document.getElementById('btnClosePreview').addEventListener('click', closePreview);
			modal.addEventListener('click', function (e) { if (e.target === modal) closePreview(); });
			document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closePreview(); });

			function setup(wrap) {
				var key = wrap.dataset.key;
				var box = wrap.querySelector('.media-upload-box');
				var preview = box.querySelector('.media-preview');
				var input = wrap.querySelector('.media-input');
				var removeFlag = wrap.querySelector('.media-remove');
				var recropBtn = wrap.querySelector('.btn-recrop');
				var fileError = wrap.querySelector('.file-error');
				var ratio = parseRatio(box.dataset.ratio);
				// Rasio crop mengikuti area media yang benar-benar dipakai di frontend.
				var cropPage = box.dataset.cropPage || key;
				function getFrontendCropRatio() {
					var w = window.innerWidth || 1920;
					var h = window.innerHeight || 1080;

					if (key === 'welcome') return 12 / 7;
					if (cropPage === 'beranda_hero') return w / Math.max(h, 1);
					if (cropPage === 'blog') return w / Math.max(460, 1);
					if (cropPage === 'about') return w / Math.max(h, 1);
					if (cropPage === 'about_desc') return 16 / 9;
					if (cropPage === 'login') return (1080 * 0.62) / 640;
					return ratio || 16 / 9;
				}

				var hadSaved = !!box.dataset.existingUrl;
				var current = hadSaved
					? { name: box.dataset.existingName || 'gambar', size: 0, url: box.dataset.existingUrl, saved: true }
					: null;
				var applied = null;       // file yang terpasang di input (hasil crop / file langsung)
				var lastOriginal = null;  // file asli sebelum di-crop (untuk Crop Ulang)

				function showError(msg) {
					fileError.textContent = msg || '';
					fileError.classList.toggle('show', !!msg);
				}
				function setInputFile(file) {
					if (!file) { input.value = ''; return; }
					var dt = new DataTransfer();
					dt.items.add(file);
					input.files = dt.files;
				}
				function restoreInput() { setInputFile(applied); }

				function render() {
					var has = !!current;
					box.classList.toggle('has-media', has);
					box.classList.toggle('is-empty', !has);
					box.classList.toggle('is-locked', !isEditing());
					preview.innerHTML = '';
					if (has) {
						var img = document.createElement('img');
						img.src = current.url;
						img.alt = 'Preview media';
						preview.appendChild(img);
						if (!current.saved) {
							var badge = document.createElement('span');
							badge.className = 'badge';
							badge.textContent = 'Belum disimpan';
							preview.appendChild(badge);
						}
					} else {
						preview.innerHTML = '<div class="placeholder-content"><i class="bx bx-image-add"></i>' +
							'<span>Belum ada media dipilih</span><span>Ukuran pas ' + box.dataset.size + '</span></div>';
					}
					recropBtn.hidden = !(isEditing() && current && lastOriginal);
					// Gambar tersimpan yang dihapus -> beri tahu server saat Simpan
					removeFlag.value = (!current && hadSaved) ? '1' : '0';
				}

				function openPreview() {
					if (!current) return;
					previewImg.style.backgroundImage = "url('" + current.url + "')";
					previewCap.textContent = current.name;
					modal.classList.add('show');
				}
				function clearMedia() {
					current = null;
					lastOriginal = null;
					applied = null;
					setInputFile(null);
					showError('');
					render();
				}
				function openCrop(file) {
					lastOriginal = file;
					window.openImageCrop(file, function (cropped) {
						cropped._cropped = true;
						handleFile(cropped);
					}, restoreInput, getFrontendCropRatio());
				}
				function handleFile(file) {
					if (!isEditing()) return;
					showError('');
					if (!file) return;
					if (!file._cropped && window.openImageCrop) { openCrop(file); return; }
					if (ALLOWED.indexOf(file.type) === -1) {
						showError('Format harus JPG, PNG, atau WEBP.');
						restoreInput();
						return;
					}
					if (file.size > MAX) {
						showError('Ukuran gambar maksimal 3MB (file ini ' + formatSize(file.size) + ').');
						restoreInput();
						return;
					}
					setInputFile(file);
					applied = file;
					var reader = new FileReader();
					reader.onload = function (ev) {
						current = { name: file.name, size: file.size, url: ev.target.result, saved: false };
						render();
					};
					reader.readAsDataURL(file);
				}

				box.addEventListener('click', function (e) {
					if (e.target.closest('.media-clear-btn')) {
						e.stopPropagation();
						if (isEditing()) clearMedia();
						return;
					}
					if (e.target.closest('.media-view-btn')) {
						e.stopPropagation();
						openPreview();
						return;
					}
					if (isEditing()) input.click();
					else if (current) openPreview();
				});
				box.addEventListener('keydown', function (e) {
					if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); box.click(); }
				});
				['dragenter', 'dragover'].forEach(function (ev) {
					box.addEventListener(ev, function (e) {
						e.preventDefault();
						if (isEditing()) box.classList.add('is-dragover');
					});
				});
				['dragleave', 'drop'].forEach(function (ev) {
					box.addEventListener(ev, function (e) {
						e.preventDefault();
						box.classList.remove('is-dragover');
					});
				});
				box.addEventListener('drop', function (e) {
					if (isEditing()) handleFile(e.dataTransfer.files[0]);
				});
				input.addEventListener('change', function () { handleFile(this.files[0]); });
				recropBtn.addEventListener('click', function () {
					if (isEditing() && lastOriginal) openCrop(lastOriginal);
				});

				var api = {
					getSnapshot: function () {
						return current ? { name: current.name, url: current.url, saved: current.saved } : null;
					},
					hasChanged: function (snap) {
						var before = snap || null;
						var after = current ? { name: current.name, url: current.url, saved: current.saved } : null;
						if (!before && !after) return false;
						if (!!before !== !!after) return true;
						return before.saved !== after.saved || before.name !== after.name || before.url !== after.url;
					},
					restore: function (snap) {
						current = snap ? { name: snap.name, url: snap.url, saved: snap.saved } : null;
						lastOriginal = null;
						applied = null;
						setInputFile(null);
						showError('');
						render();
					},
					setEditing: function () { render(); }
				};
				if (key === 'welcome') {
					window.pagesUploader = api;
				} else {
					window.pagesBgUploaders = window.pagesBgUploaders || {};
					window.pagesBgUploaders[key] = api;
				}
				render();
			}

			document.querySelectorAll('.media-uploader[data-key]').forEach(function (wrap) { setup(wrap); });
		})();


	/* ===== Header "Pengaturan Halaman" diam di atas, hanya kartu "Edit Tampilan Halaman" yang bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var card = document.querySelector('.pages-card');
		var actionsBar = document.querySelector('.form-actions');
		if (!main || !card) return;

		function syncLayout() {
			// Kunci tinggi area konten utama sesuai sisa tinggi layar, lalu matikan scroll di situ
			var mainTop = main.getBoundingClientRect().top;
			main.style.height = (window.innerHeight - mainTop) + 'px';
			main.style.overflow = 'hidden';

			// Sisakan ruang untuk kartu agar bisa discroll sendiri tanpa tertutup bar tombol fixed di bawah
			var cardRect = card.getBoundingClientRect();
			if (actionsBar) {
				actionsBar.style.left = cardRect.left + 'px';
				actionsBar.style.width = cardRect.width + 'px';
			}
			var barHeight = actionsBar ? actionsBar.getBoundingClientRect().height : 0;
			var available = window.innerHeight - cardRect.top - barHeight - 4;
			if (available < 200) available = 200; // jaga-jaga di layar sangat pendek
			card.style.maxHeight = available + 'px';

			// Tinggi header kartu (judul + tab) dipakai supaya preview yang sticky tidak tertutup
			var fixedHead = document.getElementById('pagesFixedHead');
			if (fixedHead) card.style.setProperty('--pages-head-h', fixedHead.offsetHeight + 'px');
		}

		syncLayout();
		window.addEventListener('resize', syncLayout);
		setTimeout(syncLayout, 300); // jaga-jaga kalau layout admin (sidebar dll) baru selesai render
	})();
</script>
@endpush