@extends('admin.layouts.app')

@section('title', 'Kelola Blog | Admin Astabrata Teknologi')
@section('page-title', 'Kelola Blog')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
		/* ===== Modal Crop Gambar (16:9, mengikuti tampilan kartu blog) ===== */
		.crop-modal-box { max-width: 560px; width: 92%; }
		.crop-modal-body { margin-bottom: 4px; }
		.crop-container {
			width: 100%; max-height: 420px; min-height: 240px;
			background: transparent; overflow: hidden; border-radius: 12px;
		}
		.crop-container img { display: block; max-width: 100%; }
		.crop-hint { margin-top: 10px; font-size: 12px; color: var(--dark-grey); text-align: center; }
		.crop-container.crop-circle .cropper-view-box,
		.crop-container.crop-circle .cropper-face { border-radius: 50%; }
		/* Pastikan modal crop selalu tampil di DEPAN modal form tambah/edit */
		#cropModal { z-index: 6000; }

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
		/* Kategori: teks sederhana, sama seperti kolom Judul (tanpa badge) */
		#content main .table-data .order table td.col-kategori {
			font-weight: 600;
		}
		#content main .table-data .order table td.col-kategori span {
			text-transform: capitalize;
			white-space: nowrap;
		}
		#content main .table-data .order table td.col-aksi {
			white-space: nowrap;
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
			inset: 0;
			background: rgba(0, 0, 0, 0.5);
			z-index: 5000;
			justify-content: center;
			align-items: center;
			padding: 20px;
			box-sizing: border-box;
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
		/* FORM TAMBAH/EDIT BLOG: besar memenuhi area konten dengan jarak di setiap sisi */
		#blogModal {
			padding: 32px;
			align-items: stretch;
		}
		#blogModal .modal-box {
			width: 100%;
			max-width: none;
			height: 100%;
			max-height: none;
			border-radius: 16px;
			padding: 28px 40px;
		}
		#blogModal .modal-box form { flex: 1; min-height: 0; }
		#blogModal .modal-box .form-grid { flex: 1; min-height: 0; }
		#blogModal .modal-box .form-col-right { height: auto; min-height: 0; }
		#blogModal .modal-box .editor-box { height: 100%; }
		#blogModal .modal-box .editor-content { min-height: 320px; }
		#blogModal .modal-actions {
			bottom: -28px;
			margin: 24px -40px -28px -40px;
			padding: 16px 40px;
			border-radius: 0 0 16px 16px;
		}
		@media screen and (max-width: 768px) {
			#blogModal { padding: 12px; }
			#blogModal .modal-box { max-width: none; padding: 20px 16px; }
			#blogModal .modal-actions { bottom: -20px; margin: 20px -16px -20px -16px; padding: 14px 16px; }
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
		/* Tombol Batal/Terapkan pada modal Crop Gambar (gambar utama) -> merah & biru, konsisten di mode terang/gelap */
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

		/* WYSIWYG EDITOR */
		.editor-box {
			border: 1px solid #cbd5e1;
			border-radius: 10px;
			background: #fff;
			transition: border-color 0.2s;
			display: flex;
			flex-direction: column;
			height: 100%;
			min-height: 0;
			overflow: hidden;
		}
		.editor-box:focus-within {
			border-color: #3b82f6;
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
		}
		.editor-toolbar {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
			gap: 6px;
			padding: 8px 12px;
			border-bottom: 1px solid #cbd5e1;
			background: #f8fafc;
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
			color: #334155;
			font-family: var(--poppins), sans-serif;
			width: auto;
		}
		.editor-btn {
			background: transparent;
			border: none;
			padding: 4px;
			font-size: 16px;
			cursor: pointer;
			border-radius: 6px;
			color: #475569;
			width: 30px;
			height: 30px;
			transition: 0.2s;
			display: inline-flex;
			align-items: center;
			justify-content: center;
		}
		.editor-btn:hover { background: #e2e8f0; color: #0f172a; }
		.editor-btn.is-image { color: #2563eb; }
		.editor-divider { width: 1px; height: 18px; background: #cbd5e1; margin: 0 4px; }

		.editor-canvas { position: relative; flex: 1; min-height: 0; display: flex; }
		.editor-content {
			flex: 1; min-height: 220px; overflow-y: auto; padding: 18px 20px;
			font-size: 14px; line-height: 1.7; outline: none; color: #1e293b;
		}
		.editor-content:empty:before { content: attr(data-placeholder); color: #94a3b8; }
		.editor-content img { max-width: 100%; height: auto; border-radius: 6px; cursor: pointer; }
		.editor-content img.is-selected { outline: 2px solid #3b82f6; outline-offset: 1px; }

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

		/* ============================================================
		   MODE FOKUS MENULIS: form membesar penuh, input lain disembunyikan
		   ============================================================ */
		.modal-head {
			display: flex;
			align-items: center;
			justify-content: space-between;
			gap: 12px;
			margin-bottom: 20px;
		}
		.modal-head h2 { margin-bottom: 0; }
		.modal-box .btn-back {
			display: none;
			align-items: center;
			gap: 6px;
			background: #f59e0b;
			color: #fff;
		}
		.modal-box .btn-back:hover { filter: brightness(.92); }
		.editor-toolbar .editor-toggle {
			margin-left: auto;
			width: auto;
			height: 30px;
			padding: 0 12px;
			gap: 6px;
			border-radius: 20px;
			background: var(--blue);
			color: #fff;
			font-family: var(--poppins), sans-serif;
			font-size: 12px;
			font-weight: 600;
			white-space: nowrap;
		}
		.editor-toolbar .editor-toggle:hover { background: var(--blue); color: #fff; filter: brightness(.92); }

		#blogModal .modal-box.focus-mode {
			max-width: none;
			width: 100%;
			height: 100%;
			max-height: 100%;
			overflow: hidden;
			animation: focusExpand .2s ease;
		}
		/* Mode zoom: Batal disembunyikan, Kembali (kuning) muncul di kiri tombol Simpan, header disembunyikan */
		#blogModal .modal-box.focus-mode .modal-actions .btn-back { display: inline-flex; }
		#blogModal .modal-box.focus-mode .modal-actions .btn-cancel { display: none; }
		#blogModal .modal-box.focus-mode .modal-head { display: none; }
		#blogModal .modal-box.focus-mode .form-grid {
			flex: 1;
			min-height: 0;
			grid-template-columns: minmax(0, 1fr);
			grid-template-rows: minmax(0, 1fr);
		}
		#blogModal .modal-box.focus-mode .form-col-left { display: none; }
		#blogModal .modal-box.focus-mode .form-col-right { height: auto; min-height: 0; }
		#blogModal .modal-box.focus-mode .editor-content {
			font-size: 16px;
			padding: 32px 32px;
		}
		@keyframes focusExpand {
			from { opacity: .7; transform: scale(.985); }
			to   { opacity: 1;  transform: scale(1); }
		}

		/* ============================================================
		   FITUR EDITOR: warna teks, shape, crop, video YouTube
		   ============================================================ */
		.editor-pop { position: relative; display: inline-flex; }
		.editor-pop .editor-btn { position: relative; }
		.editor-btn .icon-shape { display: block; pointer-events: none; }
		.editor-btn .color-a { font-weight: 700; font-size: 15px; line-height: 1; margin-top: -3px; }
		.editor-btn .color-bar { position: absolute; left: 7px; right: 7px; bottom: 4px; height: 3px; border-radius: 2px; background: #ef4444; }
		.editor-popover {
			display: none; position: absolute; top: calc(100% + 6px); left: 0; z-index: 50;
			background: var(--light, #fff); border: 1px solid #cbd5e1; border-radius: 10px;
			padding: 10px; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.18);
		}
		.editor-popover.show { display: block; }
		.swatch-grid { display: grid; grid-template-columns: repeat(10, 20px); gap: 6px; }
		.swatch-grid button {
			width: 20px; height: 20px; border-radius: 50%; padding: 0; cursor: pointer;
			border: 1px solid rgba(0, 0, 0, 0.18); transition: transform .12s;
		}
		.swatch-grid button:hover { transform: scale(1.18); }
		.editor-popover .pop-more {
			margin-top: 10px; width: 100%; padding: 6px 8px; border-radius: 6px; cursor: pointer;
			border: 1px solid #cbd5e1; background: transparent; color: var(--dark, #334155);
			font-size: 12px; font-weight: 600; font-family: var(--poppins), sans-serif;
			display: inline-flex; align-items: center; justify-content: center; gap: 6px;
		}
		.editor-popover .pop-more:hover { background: var(--grey, #e2e8f0); }
		#chbColorCustom { position: absolute; width: 0; height: 0; opacity: 0; pointer-events: none; border: 0; padding: 0; }
		.shape-grid { display: grid; grid-template-columns: repeat(4, 46px); gap: 6px; }
		.shape-grid button {
			width: 46px; height: 46px; border-radius: 8px; cursor: pointer; background: transparent;
			border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;
		}
		.shape-grid button:hover { background: var(--grey, #f1f5f9); border-color: #3b82f6; }

		.editor-content .chb-shape, .editor-content .chb-video { cursor: pointer; max-width: 100%; box-sizing: border-box; }
		.editor-content img { max-width: 100%; }
		.editor-content .chb-video.is-selected { outline: 2px solid #3b82f6; outline-offset: 2px; }
		/* Pelindung klik: video hanya dipilih (bukan diputar) saat mengedit. Tidak ikut tersimpan. */
		.editor-content .chb-video:not(.chb-playing)::after { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 2; }

		/* Video YouTube: ukuran TETAP (lebar penuh, rasio 16:9) sama seperti di halaman blog -> tidak bisa diubah */
		.img-toolbar[data-type="video"] [data-hide-video] { display: none; }
		/* Kartu video di editor: thumbnail + tombol play (seperti di halaman blog). Video baru tampil saat tombol "Putar" ditekan. */
		.editor-content .chb-video:not(.chb-playing) iframe { visibility: hidden; }
		.editor-content .chb-video:not(.chb-playing)::before {
			content: ''; position: absolute; top: 50%; left: 50%; width: 68px; height: 48px; transform: translate(-50%, -50%);
			background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 68 48'%3E%3Crect width='68' height='48' rx='14' fill='%23ef4444'/%3E%3Cpath d='M27 14l20 10-20 10z' fill='white'/%3E%3C/svg%3E") center/contain no-repeat;
			filter: drop-shadow(0 6px 10px rgba(0, 0, 0, .35)); z-index: 1; pointer-events: none;
		}
		.img-frame.no-resize .handle { display: none; }
		.editor-content .chb-video { width: 100%; max-width: 480px; margin-left: auto; margin-right: auto; }
		.editor-content img { max-width: 100%; }
		.img-toolbar [data-only] { display: none; }
		.img-toolbar[data-type="img"] [data-only="img"],
		.img-toolbar[data-type="shape"] [data-only="shape"],
		.img-toolbar[data-type="video"] [data-only="video"] { display: inline-flex; }
		.img-toolbar .tb-color {
			display: inline-flex; align-items: center; gap: 4px; padding: 3px 8px; border-radius: 6px;
			cursor: pointer; color: #e2e8f0; font-size: 14px;
		}
		.img-toolbar .tb-color:hover { background: rgba(255, 255, 255, 0.14); }
		.img-toolbar .tb-color input { width: 24px; height: 20px; border: none; padding: 0; background: none; cursor: pointer; }

		/* Dialog crop & YouTube */
		.chb-dialog-overlay { z-index: 5500; }
		.modal-box.chb-dialog { max-width: 560px; }
		.modal-box.chb-dialog.chb-dialog-wide { max-width: 860px; }
		.chb-crop-ratios { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 14px; }
		.chb-crop-ratios button {
			border: 1px solid var(--grey); background: var(--grey); color: var(--dark); padding: 6px 16px;
			border-radius: 20px; font-size: 12px; font-weight: 600; cursor: pointer; font-family: var(--poppins), sans-serif;
		}
		.chb-crop-ratios button.active { background: var(--blue); border-color: var(--blue); color: #fff; }
		.chb-crop-wrap { display: flex; justify-content: center; background: var(--grey); border-radius: 10px; padding: 14px; overflow: hidden; }
		.chb-crop-stage { position: relative; display: inline-block; line-height: 0; user-select: none; -webkit-user-select: none; touch-action: none; }
		.chb-crop-stage img { display: block; max-width: 100%; max-height: 56vh; }
		.chb-crop-box {
			position: absolute; box-sizing: border-box; border: 2px solid #fff; cursor: move;
			box-shadow: 0 0 0 9999px rgba(0, 0, 0, 0.55);
			background-image: linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.4)), linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.4)),
				linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.4)), linear-gradient(rgba(255,255,255,.4), rgba(255,255,255,.4));
			background-size: 1px 100%, 1px 100%, 100% 1px, 100% 1px;
			background-position: 33.33% 0, 66.66% 0, 0 33.33%, 0 66.66%;
			background-repeat: no-repeat;
		}
		.chb-crop-box .ch { position: absolute; width: 14px; height: 14px; background: #fff; border: 2px solid var(--blue); border-radius: 3px; box-sizing: border-box; }
		.chb-crop-box .ch.nw { left: -8px; top: -8px; cursor: nwse-resize; }
		.chb-crop-box .ch.ne { right: -8px; top: -8px; cursor: nesw-resize; }
		.chb-crop-box .ch.sw { left: -8px; bottom: -8px; cursor: nesw-resize; }
		.chb-crop-box .ch.se { right: -8px; bottom: -8px; cursor: nwse-resize; }
		.chb-crop-box .ch.n { left: 50%; top: -8px; margin-left: -7px; cursor: ns-resize; }
		.chb-crop-box .ch.s { left: 50%; bottom: -8px; margin-left: -7px; cursor: ns-resize; }
		.chb-crop-box .ch.w { left: -8px; top: 50%; margin-top: -7px; cursor: ew-resize; }
		.chb-crop-box .ch.e { right: -8px; top: 50%; margin-top: -7px; cursor: ew-resize; }
		.chb-crop-stage.ratio-locked .ch.n, .chb-crop-stage.ratio-locked .ch.s,
		.chb-crop-stage.ratio-locked .ch.w, .chb-crop-stage.ratio-locked .ch.e { display: none; }
		.chb-yt-hint { display: block; margin-top: 6px; font-size: 12px; color: var(--dark-grey); }
		.chb-yt-hint.error { color: var(--red); }
		.chb-yt-preview {
			position: relative; width: 100%; aspect-ratio: 16 / 9; background: var(--grey); border-radius: 10px; overflow: hidden;
			display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;
			color: var(--dark-grey); font-size: 13px; margin-top: 4px;
		}
		.chb-yt-preview > i { font-size: 46px; color: #ef4444; }
		.chb-yt-preview iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
		/* Tombol Batal/Terapkan pada dialog Crop & YouTube di dalam editor blog -> merah & biru, selalu tampil (sebelumnya hanya berwarna di dark mode) */
		.chb-dialog .btn-cancel, .chb-dialog .btn-cancel:hover { background: var(--red); color: #fff; }
		.chb-dialog .btn-save, .chb-dialog .btn-save:hover { background: var(--blue); color: #fff; }
		.chb-dialog .btn-save:disabled { opacity: .5; cursor: not-allowed; }

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
		.modal-box .uploader-shape {
			width: 150px;
			aspect-ratio: 16 / 9;
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

		/* ============================================================
		   PERBAIKAN: scroll zoom, toolbar/tombol tetap, teks di shape, preview YouTube, sidebar
		   ============================================================ */
		/* Saat form terbuka: halaman di belakang tidak ikut scroll */
		body.chb-modal-open { overflow: hidden; }

		/* Kotak form tidak scroll sendiri -> Kembali & Batal/Simpan selalu tetap di tempatnya.
		   Yang scroll hanya isi form (form-grid). */
		#blogModal .modal-box { overflow: hidden; }
		#blogModal .modal-head { flex-shrink: 0; }
		#blogModal .modal-box .form-grid { overflow-y: auto; overflow-x: hidden; overscroll-behavior: contain; }
		#blogModal .modal-box .editor-box { min-height: 420px; overflow: hidden; overflow: clip; }
		/* Toolbar WYSIWYG selalu menempel di atas editor walau di-scroll */
		#blogModal .editor-toolbar { position: sticky; top: 0; z-index: 25; }
		#blogModal .modal-actions {
			position: static;
			flex-shrink: 0;
			margin: 16px -40px -28px -40px;
			padding: 16px 40px;
		}
		@media screen and (max-width: 768px) {
			#blogModal .modal-actions { margin: 14px -16px -20px -16px; padding: 14px 16px; }
		}

		/* Zoom gambar: gambar tinggi bisa digeser ke atas/bawah */
		.image-zoom-overlay {
			overflow-y: auto;
			overflow-x: hidden;
			align-items: flex-start;
			padding: 48px 0;
			box-sizing: border-box;
			overscroll-behavior: contain;
		}
		.image-zoom-overlay .image-zoom-stage { margin: auto; max-width: 90%; max-height: none; }
		/* Ukuran maksimum zoom: lebar maks 640px (atau 90% layar di HP); gambar tinggi tetap bisa digeser */
		.image-zoom-overlay img { max-width: min(90vw, 640px); width: auto; max-height: none; }
		.image-zoom-overlay .image-zoom-close { position: absolute; top: -12px; right: -12px; z-index: 2; }
		@media screen and (max-width: 700px) {
			/* Di HP gambar hampir selebar layar, jadi tombol X masuk sedikit ke dalam sudut gambar */
			.image-zoom-overlay .image-zoom-close { top: 8px; right: 8px; }
		}

		/* Teks di dalam shape */
		.editor-content .chb-shape-text { cursor: text; }
		.editor-content .chb-shape-text:empty:before { content: 'Ketik teks...'; opacity: .55; pointer-events: none; }

		/* Preview YouTube (thumbnail + tombol play) */
		.chb-yt-preview .chb-yt-thumb { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
		.chb-yt-preview .chb-yt-play {
			position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
			width: 68px; height: 48px; border: none; border-radius: 14px; background: #ef4444; color: #fff;
			font-size: 34px; cursor: pointer; display: flex; align-items: center; justify-content: center;
			box-shadow: 0 6px 18px rgba(0, 0, 0, .35); padding: 0;
		}
		.chb-yt-preview .chb-yt-play:hover { filter: brightness(.92); }

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
		.modal-box.modal-confirm .confirm-icon.warning {
			background: var(--light-yellow);
			color: var(--yellow);
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
		/* ============================================================
		   DARK MODE - EDITOR DESKRIPSI SAMA DENGAN KELola PROYEK
		   ============================================================ */
		body.dark #blogModal .modal-box {
			background: var(--light) !important;
			color: var(--dark) !important;
		}

		body.dark #blogModal h2,
		body.dark #blogModal .form-group label {
			color: var(--dark) !important;
		}

		body.dark #blogModal .form-group input,
		body.dark #blogModal .form-group select,
		body.dark #blogModal .form-group textarea {
			background: var(--grey) !important;
			border-color: var(--grey) !important;
			color: var(--dark) !important;
		}

		body.dark #blogModal .form-group input::placeholder,
		body.dark #blogModal .form-group textarea::placeholder {
			color: var(--dark-grey) !important;
		}

		/* WYSIWYG editor */
		body.dark #blogModal .editor-box {
			background: var(--light) !important;
			border-color: var(--grey) !important;
		}

		body.dark #blogModal .editor-toolbar {
			background: var(--grey) !important;
			border-bottom-color: var(--grey) !important;
		}

		body.dark #blogModal .editor-toolbar select {
			background: var(--light) !important;
			border-color: var(--grey) !important;
			color: var(--dark) !important;
			color-scheme: dark;
		}

		body.dark #blogModal .editor-btn {
			color: var(--dark-grey) !important;
		}

		body.dark #blogModal .editor-btn:hover {
			background: var(--grey) !important;
			color: var(--dark) !important;
		}

		body.dark #blogModal .editor-btn.is-image {
			color: var(--blue) !important;
		}

		body.dark #blogModal .editor-divider {
			background: var(--grey) !important;
		}

		body.dark #blogModal .editor-content {
			background: var(--light) !important;
			color: var(--dark) !important;
		}

		body.dark #blogModal .editor-content:empty:before {
			color: var(--dark-grey) !important;
		}

		body.dark #blogModal .img-frame .handle {
			background: var(--light) !important;
		}

		body.dark #blogModal .chb-modal .form-actions,
		body.dark #blogModal .modal-actions {
			background: var(--light) !important;
			border-top-color: var(--grey) !important;
		}

		/* Tombol Kembali & Minimize editor tetap biru di dark mode */
		body.dark #blogModal .editor-toggle,
		body.dark #blogModal .editor-toggle:hover {
			background: var(--blue) !important;
			color: #fff !important;
		}

		/* Tombol Kembali (mode zoom) kuning di dark mode */
		body.dark #blogModal .btn-back,
		body.dark #blogModal .btn-back:hover {
			background: #f59e0b !important;
			color: #fff !important;
		}

		/* Tombol Batal tambah/update tetap merah */
		body.dark #blogModal .btn-cancel,
		body.dark #blogModal .btn-cancel:hover,
		body.dark #blogModal .btn-cancel:focus,
		body.dark #blogModal .btn-cancel:active {
			background: var(--red) !important;
			color: #fff !important;
			filter: none !important;
			box-shadow: none !important;
		}

		/* Tombol Simpan tetap biru dengan tulisan putih, tidak hilang di dark mode */
		body.dark #blogModal .btn-save,
		body.dark #blogModal .btn-save:hover,
		body.dark #blogModal .btn-save:focus,
		body.dark #blogModal .btn-save:active {
			background: var(--blue) !important;
			color: #fff !important;
			filter: none !important;
			box-shadow: none !important;
		}

		/* Tombol "Tambah Blog" tetap biru dengan tulisan putih di dark mode */
		body.dark #content main .head-title .btn-download,
		body.dark #content main .head-title .btn-download:hover {
			background: var(--blue) !important;
			color: #fff !important;
		}

		/* Tombol "Edit" di tabel tetap biru dengan tulisan putih di dark mode */
		body.dark #content main .table-data .order table td.col-aksi .btn-edit,
		body.dark #content main .table-data .order table td.col-aksi .btn-edit:hover {
			background: var(--blue) !important;
			color: #fff !important;
		}

		/* Tombol "Hapus" (mode pilih & hapus terpilih) tetap kontras di dark mode */
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

		/* Tombol "Ya, Hapus" di modal konfirmasi hapus tetap kontras di dark mode */
		body.dark .modal-box.modal-confirm .btn-danger,
		body.dark .modal-box.modal-confirm .btn-danger:hover {
			background: var(--red) !important;
			color: #fff !important;
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
		body.dark #blogModal .form-group input:focus,
		body.dark #blogModal .form-group select:focus,
		body.dark #blogModal .form-group textarea:focus {
			border-color: #4f8ef7 !important;
			box-shadow: 0 0 0 3px rgba(79, 142, 247, 0.25);
		}
		body.dark #blogModal .editor-box:focus-within {
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
		body:not(.dark) .modal-box input[type="text"],
		body:not(.dark) .modal-box select,
		body:not(.dark) .modal-box textarea {
			background: #f1f5f9;
			border-color: #cbd5e1;
		}
		body:not(.dark) .modal-box input[type="text"]:focus,
		body:not(.dark) .modal-box select:focus,
		body:not(.dark) .modal-box textarea:focus {
			background: #fff;
			border-color: #3b82f6;
		}
		body:not(.dark) .modal-box .uploader {
			background: #f1f5f9;
			border-color: #cbd5e1;
		}
		body:not(.dark) .editor-toolbar {
			background: #f1f5f9;
			border-bottom-color: #d5deea;
		}
		body:not(.dark) #blogModal .modal-actions {
			background: #f8fafc;
		}

	#content main .head-title.page-header-fixed { position: fixed; z-index: 60; padding: 10px 0; margin: 0; }
	#content main .table-data .order { overflow-y: auto; overscroll-behavior: contain; -webkit-overflow-scrolling: touch; }
	#content main .table-data .order thead th { position: sticky; top: 0; z-index: 2; background: var(--light); }

		/* Kartu daftar: judul & header tabel menempel di atas, baris yang lewat tersembunyi di bawahnya */
		@media screen and (min-width: 769px) {
			#content main .table-data .order { isolation: isolate; padding: 0 24px 24px 24px; overflow-y: auto; overflow-x: hidden; }
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
					<i class='bx bxs-plus-circle' ></i>
					<span class="text">Tambah Blog</span>
				</button>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Daftar Blog</h3>
						@php
							// Kategori bawaan + kategori buatan sendiri yang sudah dipakai di data blog
							$kategoriBawaan = ['project', 'berita', 'kegiatan'];
							$kategoriLain = collect($kategoriTersimpan ?? $blogs->pluck('kategori'))
								->map(fn ($k) => trim((string) $k))
								->filter()
								->unique(fn ($k) => strtolower($k))
								->reject(fn ($k) => in_array(strtolower($k), $kategoriBawaan))
								->values();
						@endphp
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
								@foreach($kategoriLain as $kat)
								<option value="{{ strtolower($kat) }}">{{ ucfirst($kat) }}</option>
								@endforeach
							</select>
							<!-- FILTER HALAMAN / ENTRIES -->
							<select id="blogPerPage" class="filter-select" title="Tampilkan per halaman">
								<option value="all">Semua</option>
								<option value="5">5 per Hal</option>
								<option value="10">10 per Hal</option>
								<option value="20">20 per Hal</option>
							</select>
							<button type="button" class="btn-select-mode" id="btnToggleBlogSelectMode" onclick="toggleBlogSelectMode()">
								<i class='bx bx-list-check'></i> <span id="btnToggleBlogSelectModeText">Hapus</span>
							</button>
							<div class="bulk-actions-group" id="blogBulkActionsGroup">
								<button type="button" class="btn-bulk-delete" id="btnBlogBulkDelete" disabled onclick="confirmBulkDeleteBlog()">
									<i class='bx bx-trash'></i> Hapus (<span id="blogBulkDeleteCount">0</span>)
								</button>
							</div>
						</div>
					</div>
					<div class="table-scroll">
					<table id="blogTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Tanggal Dibuat</th>
								<th id="blogAksiHeader">Aksi</th>
							</tr>
						</thead>
						<tbody id="blogTableBody">
							@forelse($blogs as $blog)
							<tr class="blog-row" data-id="{{ $blog->id }}" data-judul="{{ strtolower($blog->judul) }}" data-kategori="{{ strtolower($blog->kategori) }}">
								<td class="col-no">{{ $loop->iteration }}</td>
								<td class="col-gambar">
									<img src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/600x400/png' }}" alt="{{ $blog->judul }}" onclick="openListImageZoom(this.src)">
								</td>
								<td class="col-judul">{{ $blog->judul }}</td>
								<td class="col-kategori"><span>{{ $blog->kategori }}</span></td>
								<td>{{ $blog->created_at->format('d-m-Y') }}</td>
								<td class="col-aksi">
									<button type="button" class="btn-edit"
										title="Edit"
										data-id="{{ $blog->id }}"
										data-judul="{{ $blog->judul }}"
										data-kategori="{{ $blog->kategori }}"
										data-konten="{{ $blog->konten }}"
										data-gambar="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : '' }}"
										data-update-url="{{ route('admin.kelola-blog.update', $blog->id) }}"
										onclick="openEditModal(this)">Edit</button>
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
					</div>

					<!-- Form hapus disimpan terpisah di luar tabel, supaya TIDAK ikut terhapus
					     saat kolom Aksi diganti jadi checkbox waktu mode pilih aktif. -->
					<div style="display:none;">
						@foreach($blogs as $blog)
						<form id="deleteFormBlog{{ $blog->id }}" action="{{ route('admin.kelola-blog.destroy', $blog->id) }}" method="POST">
							@csrf
							@method('DELETE')
						</form>
						@endforeach
					</div>

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
					<div class="modal-head">
						<h2 id="modalTitle">Tambah Blog</h2>
					</div>

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
									<input type="text" name="judul" id="inputJudul" value="{{ old('judul') }}" required placeholder="Masukkan judul blog">
								</div>

								<div class="form-group">
									<label>Kategori</label>
									<select name="kategori" id="inputKategori" required>
										<option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
										<option value="project" {{ old('kategori') === 'project' ? 'selected' : '' }}>Project</option>
										<option value="berita" {{ old('kategori') === 'berita' ? 'selected' : '' }}>Berita</option>
										<option value="kegiatan" {{ old('kategori') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
										@foreach($kategoriLain as $kat)
										<option value="{{ $kat }}" {{ old('kategori') === $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
										@endforeach
										<option value="__lainnya__">Lainnya... (ketik sendiri)</option>
									</select>
									<input type="text" id="inputKategoriLainnya" maxlength="50" placeholder="Ketik kategori baru" autocomplete="off" style="display:none; margin-top:8px;">
								</div>

								<div class="form-group">
									<label>Gambar Utama</label>
									<div class="uploader" id="uploaderBox">
										<div class="uploader-empty" id="uploaderEmpty">
											<div class="uploader-shape" aria-hidden="true">
												<i class='bx bx-image-add'></i>
											</div>
											<p>Klik atau seret gambar ke sini</p>
											<span>PNG, JPG, JPEG (maks. 2MB)</span>
											<span class="uploader-size-hint">Ukuran pas: 1280 × 720 px (rasio 16:9)</span>
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
											<div class="editor-pop" id="chbColorWrap">
												<button type="button" class="editor-btn" onmousedown="event.preventDefault()" onclick="toggleEditorPop('chbColorPop')" title="Warna Teks"><span class="color-a">A</span><span class="color-bar" id="chbColorBar"></span></button>
												<div class="editor-popover" id="chbColorPop" onmousedown="event.preventDefault()">
													<div class="swatch-grid" id="chbColorGrid"></div>
													<button type="button" class="pop-more" onclick="document.getElementById('chbColorCustom').click()"><i class='bx bx-palette'></i> Warna lainnya</button>
													<input type="color" id="chbColorCustom" value="#2563eb" tabindex="-1" aria-hidden="true">
												</div>
											</div>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyLeft')" title="Rata Kiri"><i class='bx bx-align-left'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyCenter')" title="Rata Tengah"><i class='bx bx-align-middle'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('justifyRight')" title="Rata Kanan"><i class='bx bx-align-right'></i></button>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="formatDoc('insertUnorderedList')" title="Bullet List"><i class='bx bx-list-ul'></i></button>
											<button type="button" class="editor-btn" onclick="formatDoc('insertOrderedList')" title="Numbering"><i class='bx bx-list-ol'></i></button>
											<div class="editor-divider"></div>
											<button type="button" class="editor-btn" onclick="addLink()" title="Link"><i class='bx bx-link'></i></button>
											<button type="button" class="editor-btn" onclick="triggerEditorImage()" title="Sisipkan Gambar"><i class='bx bx-image-add'></i></button>
											<div class="editor-pop" id="chbShapeWrap">
												<button type="button" class="editor-btn" onmousedown="event.preventDefault()" onclick="toggleEditorPop('chbShapePop')" title="Sisipkan Shape"><svg class="icon-shape" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" aria-hidden="true"><rect x="3" y="12" width="9" height="9" rx="1.5"></rect><circle cx="16.5" cy="7.5" r="4.5"></circle><path d="M14 21l3.5-6.5L21 21z"></path></svg></button>
												<div class="editor-popover" id="chbShapePop" onmousedown="event.preventDefault()">
													<div class="shape-grid" id="chbShapeGrid"></div>
												</div>
											</div>
											<button type="button" class="editor-btn" onmousedown="event.preventDefault()" onclick="openYoutubeDialog()" title="Sisipkan Video YouTube"><i class='bx bxl-youtube' style="color:#ef4444"></i></button>
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
											<div class="img-toolbar" id="chbImgToolbar" data-type="img">
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgWidth('25%')">25%</button>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgWidth('50%')">50%</button>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgWidth('75%')">75%</button>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgWidth('100%')">100%</button>
												<div class="tb-divider" data-hide-video></div>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgAlign('left')" title="Rata kiri (teks membungkus)"><i class='bx bx-align-left'></i></button>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgAlign('center')" title="Rata tengah"><i class='bx bx-align-middle'></i></button>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="setImgAlign('right')" title="Rata kanan (teks membungkus)"><i class='bx bx-align-right'></i></button>
												<div class="tb-divider" data-hide-video></div>
												<button type="button" data-only="img" onmousedown="event.preventDefault()" onclick="openCropDialog()" title="Crop gambar"><i class='bx bx-crop'></i> Crop</button>
												<label class="tb-color" data-only="shape" title="Warna shape"><i class='bx bx-palette'></i><input type="color" id="chbShapeColor" oninput="setShapeColor(this.value)"></label>
										<label class="tb-color" data-only="shape" title="Warna teks di dalam shape"><i class='bx bx-font-color'></i><input type="color" id="chbShapeTextColor" oninput="setShapeTextColor(this.value)"></label>
												<button type="button" data-only="video" onmousedown="event.preventDefault()" onclick="toggleVideoPlay()" title="Putar / hentikan preview video"><i class='bx bx-play-circle'></i> Putar</button>
												<div class="tb-divider"></div>
												<button type="button" data-hide-video onmousedown="event.preventDefault()" onclick="resetImgSize()" title="Ukuran asli"><i class='bx bx-reset'></i></button>
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
							<button type="button" class="btn btn-back" id="btnEditorBack"><i class='bx bx-arrow-back'></i> Kembali</button>
							<button type="submit" class="btn btn-save">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal Crop Gambar (16:9, mengikuti tampilan kartu blog di halaman depan) -->
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
						<p class="crop-hint">Geser &amp; perbesar untuk mengatur area gambar. Rasio mengikuti tampilan kartu blog (16:9).</p>
					</div>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" onclick="closeCropModal()">Batal</button>
						<button type="button" class="btn btn-save" id="btnApplyCrop">Terapkan</button>
					</div>
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
					<h2 id="deleteConfirmTitle">Hapus Blog Ini?</h2>
					<p id="deleteConfirmText">Yakin ingin menghapus blog ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnCancelDelete">Batal</button>
						<button type="button" class="btn btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
					</div>
				</div>
			</div>

			<!-- Modal Konfirmasi Keluar Tanpa Menyimpan -->
			<div class="modal-overlay" id="unsavedConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon warning"><i class='bx bx-error'></i></div>
					<h2>Batalkan Perubahan?</h2>
					<p>Perubahan yang belum disimpan akan hilang. Yakin ingin keluar tanpa menyimpan?</p>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnTetapIsi">Lanjut Isi</button>
						<button type="button" class="btn btn-danger" id="btnKeluarTanpaSimpan">Ya, Keluar</button>
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

			<!-- Dialog Crop Gambar -->
			<div class="modal-overlay chb-dialog-overlay" id="chbCropOverlay">
				<div class="modal-box chb-dialog chb-dialog-wide">
					<h2>Crop Gambar</h2>
					<div class="chb-crop-ratios" id="chbCropRatios">
						<button type="button" data-ratio="free" class="active">Bebas</button>
						<button type="button" data-ratio="1">1:1</button>
						<button type="button" data-ratio="1.3333333">4:3</button>
						<button type="button" data-ratio="1.7777778">16:9</button>
					</div>
					<div class="chb-crop-wrap">
						<div class="chb-crop-stage" id="chbCropStage">
							<img id="chbCropImg" alt="Crop gambar" draggable="false">
							<div class="chb-crop-box" id="chbCropBox">
								<span class="ch nw" data-dir="nw"></span><span class="ch n" data-dir="n"></span><span class="ch ne" data-dir="ne"></span>
								<span class="ch e" data-dir="e"></span><span class="ch se" data-dir="se"></span><span class="ch s" data-dir="s"></span>
								<span class="ch sw" data-dir="sw"></span><span class="ch w" data-dir="w"></span>
							</div>
						</div>
					</div>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnCropCancel">Batal</button>
						<button type="button" class="btn btn-save" id="btnCropApply">Terapkan</button>
					</div>
				</div>
			</div>

			<!-- Dialog Video YouTube -->
			<div class="modal-overlay chb-dialog-overlay" id="chbYtOverlay">
				<div class="modal-box chb-dialog">
					<h2>Sisipkan Video YouTube</h2>
					<div class="form-group">
						<label for="chbYtInput">Link YouTube</label>
						<input type="text" id="chbYtInput" placeholder="https://www.youtube.com/watch?v=..." autocomplete="off">
						<small id="chbYtHint" class="chb-yt-hint">Tempel link video (youtube.com, youtu.be, atau Shorts). Ukuran video tetap (lebar penuh, 16:9) dan sama seperti di halaman blog.</small>
					</div>
					<div class="chb-yt-preview" id="chbYtPreview">
						<i class='bx bxl-youtube'></i>
						<span>Preview video akan tampil di sini</span>
					</div>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnYtCancel">Batal</button>
						<button type="button" class="btn btn-save" id="btnYtInsert" disabled>Sisipkan</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
		/* ============================================================
		   MODAL CROP GAMBAR — pakai Cropper.js
		   Rasio tetap 16:9 agar pas dengan tampilan kartu blog di front-end.
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
					const croppedFile = new File([blob], 'blog-' + Date.now() + '.jpg', { type: 'image/jpeg' });
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

		// ===== State editor gambar =====
		let chbSelectedImg = null;
		let chbSavedRange = null;
		let chbResizeState = null;

		// ===== State Paginasi =====
		let currentPage = 1;

		// ===== Sinkronkan lebar modal dengan area konten =====
		// Overlay tetap layar penuh (lapisan abu-abu menutupi sidebar sehingga tidak bisa diklik),
		// sedangkan kotak form dibatasi di area konten lewat padding overlay -> ukuran form sama seperti sebelumnya.
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
			initEditorImageEvents();
			initEditorExtras();
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

		/* ============================================================
		   MODE PILIH: kolom "Aksi" berubah jadi kolom checkbox
		   ============================================================ */
		let blogSelectMode = false;
		let blogSelectedIds = new Set();
		const blogActionCellCache = new Map(); // id -> HTML tombol aksi asli (Edit)

		function toggleBlogSelectMode() {
			blogSelectMode = !blogSelectMode;
			blogSelectedIds.clear();
			renderBlogActionCells();
			updateBlogAksiHeader();
			updateBlogBulkToolbar();
		}

		function renderBlogActionCells() {
			document.querySelectorAll('#blogTableBody tr.blog-row').forEach(function (tr) {
				const id = tr.dataset.id;
				const cell = tr.querySelector('td.col-aksi');
				if (!id || !cell) return;

				if (blogSelectMode) {
					if (!blogActionCellCache.has(id)) {
						blogActionCellCache.set(id, cell.innerHTML);
					}
					const checked = blogSelectedIds.has(id);
					cell.innerHTML = '<input type="checkbox" class="blog-row-checkbox" value="' + id + '" ' + (checked ? 'checked' : '') + ' onchange="toggleBlogRowSelect(\'' + id + '\', this.checked)">';
					tr.classList.toggle('row-selected', checked);
				} else {
					if (blogActionCellCache.has(id)) {
						cell.innerHTML = blogActionCellCache.get(id);
					}
					tr.classList.remove('row-selected');
				}
			});
		}

		function updateBlogAksiHeader() {
			const th = document.getElementById('blogAksiHeader');
			const toggleBtn = document.getElementById('btnToggleBlogSelectMode');
			const toggleBtnText = document.getElementById('btnToggleBlogSelectModeText');
			const bulkGroup = document.getElementById('blogBulkActionsGroup');
			if (!th) return;

			if (blogSelectMode) {
				th.innerHTML = '<input type="checkbox" id="blogSelectAll" title="Pilih semua di halaman ini" onclick="toggleBlogSelectAllOnPage(this.checked)">';
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

		function toggleBlogRowSelect(id, checked) {
			if (checked) blogSelectedIds.add(id);
			else blogSelectedIds.delete(id);

			const cb = document.querySelector('.blog-row-checkbox[value="' + id + '"]');
			const row = cb ? cb.closest('tr') : null;
			if (row) row.classList.toggle('row-selected', checked);

			syncBlogSelectAllCheckbox();
			updateBlogBulkToolbar();
		}

		function getVisibleBlogCheckboxes() {
			return Array.from(document.querySelectorAll('#blogTableBody .blog-row .blog-row-checkbox')).filter(function (cb) {
				const tr = cb.closest('tr');
				return tr && tr.style.display !== 'none';
			});
		}

		function toggleBlogSelectAllOnPage(checked) {
			getVisibleBlogCheckboxes().forEach(function (cb) {
				cb.checked = checked;
				const id = cb.value;
				if (checked) blogSelectedIds.add(id);
				else blogSelectedIds.delete(id);
				const row = cb.closest('tr');
				if (row) row.classList.toggle('row-selected', checked);
			});
			updateBlogBulkToolbar();
		}

		function syncBlogSelectAllCheckbox() {
			const selectAll = document.getElementById('blogSelectAll');
			if (!selectAll) return; // hanya ada saat mode pilih aktif
			const boxes = getVisibleBlogCheckboxes();
			if (!boxes.length) { selectAll.checked = false; selectAll.indeterminate = false; return; }
			const checkedCount = boxes.filter(function (cb) { return cb.checked; }).length;
			selectAll.checked = checkedCount === boxes.length;
			selectAll.indeterminate = checkedCount > 0 && checkedCount < boxes.length;
		}

		function updateBlogBulkToolbar() {
			const count = blogSelectedIds.size;
			document.getElementById('blogBulkDeleteCount').textContent = count;
			document.getElementById('btnBlogBulkDelete').disabled = count === 0;
		}

		// Modal konfirmasi hapus
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete = document.getElementById('btnCancelDelete');
		const btnConfirmDelete = document.getElementById('btnConfirmDelete');
		const deleteConfirmTitle = document.getElementById('deleteConfirmTitle');
		const deleteConfirmText = document.getElementById('deleteConfirmText');
		let formToDelete = null;
		let blogDeleteMode = 'single'; // 'single' | 'bulk'

		// Modal notifikasi sukses
		const successModal = document.getElementById('successModal');
		const successMessage = document.getElementById('successMessage');
		const btnCloseSuccess = document.getElementById('btnCloseSuccess');

		// Modal konfirmasi keluar tanpa menyimpan
		const unsavedConfirmModal = document.getElementById('unsavedConfirmModal');
		const btnTetapIsi = document.getElementById('btnTetapIsi');
		const btnKeluarTanpaSimpan = document.getElementById('btnKeluarTanpaSimpan');

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
				syncBlogSelectAllCheckbox();
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
			syncBlogSelectAllCheckbox();
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
			const html = `<img src="${dataUrl}" class="chb-img" style="width:60%;max-width:100%;height:auto;display:block;margin:10px 0;border-radius:6px;"><p><br></p>`;
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
				const mediaEl = e.target.closest ? e.target.closest('img, .chb-shape, .chb-video') : null;
				if (mediaEl && editor.contains(mediaEl)) {
					selectEditorImage(mediaEl);
					if (e.target.closest && e.target.closest('.chb-shape-text')) saveRange();
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
				else if (chbSelectedImg) positionImgUI();
			});

			document.addEventListener('keydown', function (e) {
				if (!chbSelectedImg) return;
				if (['INPUT', 'TEXTAREA', 'SELECT'].indexOf(e.target.tagName) !== -1) return;
				// Sedang mengetik di dalam teks shape: Backspace/Delete jangan menghapus shape-nya
				if (e.key !== 'Escape' && e.target.closest && e.target.closest('.chb-shape-text')) return;
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
			const tb = document.getElementById('chbImgToolbar');
			tb.dataset.type = img.tagName === 'IMG' ? 'img' : (img.classList.contains('chb-video') ? 'video' : 'shape');
			if (tb.dataset.type === 'shape') {
				document.getElementById('chbShapeColor').value = rgbToHex(getComputedStyle(img).backgroundColor);
				const st = img.querySelector('.chb-shape-text');
				if (st) document.getElementById('chbShapeTextColor').value = rgbToHex(getComputedStyle(st).color);
			}
			document.getElementById('chbImgFrame').classList.toggle('no-resize', tb.dataset.type === 'video');
			document.getElementById('chbImgFrame').classList.add('active');
			document.getElementById('chbImgToolbar').classList.add('active');
			positionImgUI();
		}

		function deselectEditorImage() {
			if (chbSelectedImg && chbSelectedImg.classList.contains('chb-playing')) stopVideoPreview(chbSelectedImg);
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

		// Batas ukuran maksimum gambar = lebar penuh area konten (sama dengan lebar banner/gambar utama di halaman blog).
		const CHB_VIDEO_MAX_W = 480;  // ukuran kartu YouTube (tetap)
		function chbImgMaxCss() { return '100%'; }

		// Semua gambar/shape/video diberi batas lebar maksimum 100% supaya di layar kecil (mobile)
		// otomatis mengecil sesuai lebar halaman, sementara di desktop tetap memakai ukuran yang dipilih.
		// Tinggi mengikuti proporsi (height:auto / aspect-ratio), jadi tidak gepeng.
		function chbMakeResponsive(el) {
			if (!el || !el.style) return;
			if (el.classList && el.classList.contains('chb-video')) {
				// Ukuran video dikunci: lebar penuh kolom, proporsi 16:9 (sama dengan tampilan front end)
				el.style.width = '100%';
				el.style.maxWidth = CHB_VIDEO_MAX_W + 'px';
				el.style.height = 'auto';
				el.style.aspectRatio = '16/9';
				el.style.float = 'none';
				el.style.display = 'block';
				el.style.margin = '1.6em auto';
				el.dataset.defw = '100%';
				return;
			}
			el.style.maxWidth = el.tagName === 'IMG' ? chbImgMaxCss() : '100%';
			if (el.tagName === 'IMG') {
				el.style.height = 'auto';
			} else {
				el.style.height = 'auto';
				if (!el.style.aspectRatio) el.style.aspectRatio = el.classList.contains('chb-video') ? '16/9' : (({ rect: '16/9', rounded: '16/9', arrow: '2/1', line: '100/1' })[el.dataset.shape] || '1/1');
			}
		}

		function chbNormalizeMedia(root) {
			(root || document.getElementById('inputKontenEditor')).querySelectorAll('img, .chb-shape, .chb-video').forEach(chbMakeResponsive);
		}

		function setImgWidth(w) {
			if (!chbSelectedImg || chbSelectedImg.classList.contains('chb-video')) return;
			chbSelectedImg.style.width = w;
			chbSelectedImg.style.height = 'auto';
			chbMakeResponsive(chbSelectedImg);
			setTimeout(positionImgUI, 30);
		}

		function resetImgSize() {
			if (!chbSelectedImg || chbSelectedImg.classList.contains('chb-video')) return;
			if (chbSelectedImg.tagName !== 'IMG') {
				chbSelectedImg.style.width = chbSelectedImg.dataset.defw || '60%';
				chbSelectedImg.style.height = '';
				chbMakeResponsive(chbSelectedImg);
				setTimeout(positionImgUI, 30);
				return;
			}
			chbSelectedImg.style.width = '';
			chbSelectedImg.style.height = '';
			chbSelectedImg.style.maxWidth = chbImgMaxCss();
			setTimeout(positionImgUI, 30);
		}

		function setImgAlign(pos) {
			if (!chbSelectedImg || chbSelectedImg.classList.contains('chb-video')) return;
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
			if (!chbSelectedImg || chbSelectedImg.classList.contains('chb-video')) return;
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

			let maxW = document.getElementById('inputKontenEditor').clientWidth - 40;
			if (newW < 60) newW = 60;
			if (newW > maxW) newW = maxW;

			chbSelectedImg.style.width = Math.round(newW) + 'px';
			chbSelectedImg.style.height = 'auto';
			chbMakeResponsive(chbSelectedImg);

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


		/* ============================================================
		   FITUR TAMBAHAN EDITOR: warna teks, shape, crop gambar, video YouTube
		============================================================ */
		const CHB_COLORS = [
			'#0f172a', '#475569', '#94a3b8', '#ffffff', '#ef4444', '#f97316', '#f59e0b', '#eab308', '#22c55e', '#14b8a6',
			'#06b6d4', '#3b82f6', '#6366f1', '#8b5cf6', '#d946ef', '#ec4899', '#b91c1c', '#166534', '#1e40af', '#7e22ce'
		];

		// Shape dibuat dari <div> + CSS inline (bukan SVG) supaya aman dipakai di halaman blog.
		const CHB_SHAPES = {
			rect:     { label: 'Persegi panjang', ar: '16/9', w: '240px', thumb: [28, 18], style: '' },
			rounded:  { label: 'Persegi tumpul',  ar: '16/9', w: '240px', thumb: [28, 18], style: 'border-radius:18px;' },
			circle:   { label: 'Lingkaran',       ar: '1/1',  w: '160px', thumb: [26, 26], style: 'border-radius:50%;' },
			triangle: { label: 'Segitiga',        ar: '1/1',  w: '160px', thumb: [26, 26], style: 'clip-path:polygon(50% 0,100% 100%,0 100%);' },
			diamond:  { label: 'Belah ketupat',   ar: '1/1',  w: '160px', thumb: [26, 26], style: 'clip-path:polygon(50% 0,100% 50%,50% 100%,0 50%);' },
			star:     { label: 'Bintang',         ar: '1/1',  w: '160px', thumb: [26, 26], style: 'clip-path:polygon(50% 0%,61% 35%,98% 35%,68% 57%,79% 91%,50% 70%,21% 91%,32% 57%,2% 35%,39% 35%);' },
			arrow:    { label: 'Panah',           ar: '2/1',  w: '200px', thumb: [30, 15], style: 'clip-path:polygon(0 30%,60% 30%,60% 0,100% 50%,60% 100%,60% 70%,0 70%);' },
			line:     { label: 'Garis pemisah',   ar: '100/1', w: '100%', thumb: [30, 3],  style: 'border-radius:4px;' }
		};

		function rgbToHex(rgb) {
			const m = (rgb || '').match(/\d+/g);
			if (!m || m.length < 3) return '#3b82f6';
			return '#' + m.slice(0, 3).map(function (n) { return (+n).toString(16).padStart(2, '0'); }).join('');
		}

		function chbDialogOpen() {
			return ['chbCropOverlay', 'chbYtOverlay'].some(function (id) {
				return document.getElementById(id).classList.contains('show');
			});
		}

		// ---------- Popover toolbar (warna teks & shape) ----------
		function closeEditorPops() {
			document.querySelectorAll('.editor-popover.show').forEach(function (p) { p.classList.remove('show'); });
		}

		function toggleEditorPop(id) {
			saveRange();
			const pop = document.getElementById(id);
			const willShow = !pop.classList.contains('show');
			closeEditorPops();
			if (!willShow) return;
			pop.style.left = '0';
			pop.style.right = 'auto';
			pop.classList.add('show');
			const box = document.getElementById('chbEditorBox').getBoundingClientRect();
			if (pop.getBoundingClientRect().right > box.right - 6) {
				pop.style.left = 'auto';
				pop.style.right = '0';
			}
		}

		// ---------- Warna teks ----------
		function applyTextColor(color) {
			const editor = document.getElementById('inputKontenEditor');
			editor.focus();
			restoreRange();
			document.execCommand('styleWithCSS', false, true);
			document.execCommand('foreColor', false, color);
			document.execCommand('styleWithCSS', false, false);
			saveRange();
			document.getElementById('chbColorBar').style.background = color;
		}

		// ---------- Sisipkan blok (shape / video) di posisi kursor ----------
		function insertBlockAtCaret(node) {
			const editor = document.getElementById('inputKontenEditor');
			editor.focus();
			restoreRange();
			const sel = window.getSelection();
			let range = null;
			if (sel.rangeCount && editor.contains(sel.getRangeAt(0).commonAncestorContainer)) range = sel.getRangeAt(0);

			if (!range || range.startContainer === editor) {
				const ref = range ? editor.childNodes[range.startOffset] : null;
				editor.insertBefore(node, ref || null);
			} else {
				let anchor = range.startContainer;
				while (anchor && anchor.parentNode !== editor) anchor = anchor.parentNode;
				if (!anchor) {
					editor.appendChild(node);
				} else if (anchor.nodeType === 1 && /^(P|DIV)$/.test(anchor.tagName) && anchor.textContent.trim() === '' && !anchor.querySelector('img, iframe, .chb-shape')) {
					anchor.replaceWith(node);
				} else {
					anchor.after(node);
				}
			}
			const p = document.createElement('p');
			p.innerHTML = '<br>';
			node.after(p);
			const r = document.createRange();
			r.setStart(p, 0);
			r.collapse(true);
			sel.removeAllRanges();
			sel.addRange(r);
			saveRange();
		}

		// ---------- Shape ----------
		// Padding area teks per bentuk supaya teks tetap berada di dalam bentuknya
		const CHB_TEXT_PAD = {
			circle: '14%', triangle: '48% 22% 6%', diamond: '22%', star: '28%', arrow: '4% 30% 4% 8%'
		};

		function insertShape(key) {
			const s = CHB_SHAPES[key];
			if (!s) return;
			const el = document.createElement('div');
			el.className = 'chb-shape';
			el.setAttribute('contenteditable', 'false');
			el.dataset.shape = key;
			el.dataset.defw = s.w;
			el.style.cssText = 'position:relative;width:' + s.w + ';max-width:100%;height:auto;aspect-ratio:' + s.ar + ';container-type:inline-size;background:#3b82f6;display:block;margin:10px 0;' + s.style;
			if (key !== 'line') {
				// Area teks: style inline supaya tampil sama di halaman blog
				const t = document.createElement('div');
				t.className = 'chb-shape-text';
				t.setAttribute('contenteditable', 'true');
				t.style.cssText = 'position:absolute;top:0;left:0;right:0;bottom:0;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;box-sizing:border-box;padding:' + (CHB_TEXT_PAD[key] || '8px 14%') + ';color:#ffffff;font-weight:600;font-size:16px;font-size:clamp(10px,7cqw,26px);line-height:1.3;outline:none;overflow:hidden;word-break:break-word;';
				el.appendChild(t);
			}
			insertBlockAtCaret(el);
			closeEditorPops();
			setTimeout(function () { selectEditorImage(el); }, 260);
		}

		function setShapeTextColor(color) {
			if (!chbSelectedImg || !chbSelectedImg.classList.contains('chb-shape')) return;
			const t = chbSelectedImg.querySelector('.chb-shape-text');
			if (t) t.style.color = color;
		}

		// Shape yang dimuat ulang dari database: aktifkan lagi area teksnya
		function chbReviveShapes() {
			document.querySelectorAll('#inputKontenEditor .chb-shape-text').forEach(function (n) { n.setAttribute('contenteditable', 'true'); });
		}

		function setShapeColor(color) {
			if (chbSelectedImg && chbSelectedImg.classList.contains('chb-shape')) chbSelectedImg.style.background = color;
		}

		// ---------- Video YouTube ----------
		let chbYtId = null;

		function parseYoutubeId(input) {
			input = (input || '').trim();
			if (!input) return null;
			if (/^[\w-]{11}$/.test(input)) return input;
			let u;
			try { u = new URL(/^https?:\/\//i.test(input) ? input : 'https://' + input); } catch (err) { return null; }
			const host = u.hostname.replace(/^(www\.|m\.)/, '');
			let id = null;
			if (host === 'youtu.be') {
				id = u.pathname.split('/')[1];
			} else if (host === 'youtube.com' || host === 'youtube-nocookie.com' || host === 'music.youtube.com') {
				if (u.pathname === '/watch') {
					id = u.searchParams.get('v');
				} else {
					const m = u.pathname.match(/^\/(embed|shorts|live|v)\/([\w-]{11})/);
					if (m) id = m[2];
				}
			}
			return id && /^[\w-]{11}$/.test(id) ? id : null;
		}

		function chbMakeYtIframe(id, autoplay) {
			const f = document.createElement('iframe');
			f.src = 'https://www.youtube.com/embed/' + id + '?rel=0&playsinline=1' + (autoplay ? '&autoplay=1' : '');
			f.setAttribute('title', 'Video YouTube');
			f.setAttribute('frameborder', '0');
			// YouTube menolak embed tanpa referrer (error 153), jadi referrer harus dikirim
			f.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
			f.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen');
			f.setAttribute('allowfullscreen', '');
			f.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:0;';
			return f;
		}

		// Preview: thumbnail langsung tampil, video dimuat saat tombol play ditekan
		function chbBuildYoutubePreview(preview, id) {
			const img = document.createElement('img');
			img.className = 'chb-yt-thumb';
			img.alt = 'Thumbnail video YouTube';
			img.referrerPolicy = 'no-referrer';
			img.src = 'https://i.ytimg.com/vi/' + id + '/hqdefault.jpg';
			img.onerror = function () { img.onerror = null; img.src = 'https://img.youtube.com/vi/' + id + '/0.jpg'; };
			const btn = document.createElement('button');
			btn.type = 'button';
			btn.className = 'chb-yt-play';
			btn.title = 'Putar preview';
			btn.innerHTML = "<i class='bx bx-play'></i>";
			btn.addEventListener('click', function () {
				preview.innerHTML = '';
				preview.appendChild(chbMakeYtIframe(id, true));
			});
			preview.appendChild(img);
			preview.appendChild(btn);
		}

		function updateYoutubePreview() {
			const input = document.getElementById('chbYtInput');
			const hint = document.getElementById('chbYtHint');
			const preview = document.getElementById('chbYtPreview');
			const btn = document.getElementById('btnYtInsert');
			const id = parseYoutubeId(input.value);
			if (id === chbYtId && id) return;
			chbYtId = id;
			preview.innerHTML = '';
			hint.classList.remove('error');
			if (id) {
				chbBuildYoutubePreview(preview, id);
				hint.textContent = 'Link valid. Video akan tampil lebar penuh (16:9) seperti di halaman blog. Tekan play untuk mencoba.';
				btn.disabled = false;
			} else {
				preview.innerHTML = "<i class='bx bxl-youtube'></i><span>Preview video akan tampil di sini</span>";
				btn.disabled = true;
				if (input.value.trim()) {
					hint.textContent = 'Link YouTube belum valid.';
					hint.classList.add('error');
				} else {
					hint.textContent = 'Tempel link video (youtube.com, youtu.be, atau Shorts). Ukuran video tetap (lebar penuh, 16:9) dan sama seperti di halaman blog.';
				}
			}
		}

		function openYoutubeDialog() {
			saveRange();
			deselectEditorImage();
			closeEditorPops();
			syncModalWithContentArea();
			document.getElementById('chbYtInput').value = '';
			chbYtId = null;
			updateYoutubePreview();
			document.getElementById('chbYtOverlay').classList.add('show');
			setTimeout(function () { document.getElementById('chbYtInput').focus(); }, 50);
		}

		function closeYoutubeDialog() {
			document.getElementById('chbYtOverlay').classList.remove('show');
			document.getElementById('chbYtPreview').innerHTML = '';
			chbYtId = null;
		}

		function insertYoutubeVideo() {
			if (!chbYtId) return;
			const id = chbYtId;
			closeYoutubeDialog();
			const wrap = document.createElement('div');
			wrap.className = 'chb-video';
			wrap.setAttribute('contenteditable', 'false');
			wrap.dataset.defw = '100%';
			wrap.style.cssText = 'position:relative;width:100%;max-width:480px;height:auto;aspect-ratio:16/9;display:block;margin:1.6em auto;background:#000 url(https://i.ytimg.com/vi/' + id + '/hqdefault.jpg) center/cover no-repeat;border-radius:10px;overflow:hidden;';
			const f = chbMakeYtIframe(id, false);
			wrap.appendChild(f);
			insertBlockAtCaret(wrap);
			setTimeout(function () { selectEditorImage(wrap); }, 260);
		}

		function toggleVideoPlay() {
			if (!chbSelectedImg || !chbSelectedImg.classList.contains('chb-video')) return;
			if (chbSelectedImg.classList.contains('chb-playing')) stopVideoPreview(chbSelectedImg);
			else chbSelectedImg.classList.add('chb-playing');
		}

		function stopVideoPreview(el) {
			el.classList.remove('chb-playing');
			const f = el.querySelector('iframe');
			if (f) f.src = f.src; // muat ulang supaya video berhenti
		}

		// ---------- Crop gambar ----------
		let chbCrop = null;

		function openCropDialog() {
			const img = chbSelectedImg;
			if (!img || img.tagName !== 'IMG') return;
			const cropImg = document.getElementById('chbCropImg');
			chbCrop = { target: img, ratio: null, rect: null, dw: 0, dh: 0, drag: null };
			deselectEditorImage();
			syncModalWithContentArea();
			setCropRatioButton('free');
			document.getElementById('chbCropStage').classList.remove('ratio-locked');
			document.getElementById('chbCropOverlay').classList.add('show');
			cropImg.onload = initCropBox;
			cropImg.src = img.src;
			if (cropImg.complete && cropImg.naturalWidth) initCropBox();
		}

		function closeCropDialog() {
			document.getElementById('chbCropOverlay').classList.remove('show');
			document.getElementById('chbCropImg').onload = null;
			chbCrop = null;
		}

		function initCropBox() {
			if (!chbCrop) return;
			const img = document.getElementById('chbCropImg');
			chbCrop.dw = img.clientWidth;
			chbCrop.dh = img.clientHeight;
			const dw = chbCrop.dw, dh = chbCrop.dh;
			chbCrop.ratio = null;
			chbCrop.rect = { x: dw * 0.1, y: dh * 0.1, w: dw * 0.8, h: dh * 0.8 };
			renderCropBox();
		}

		function renderCropBox() {
			if (!chbCrop || !chbCrop.rect) return;
			const b = document.getElementById('chbCropBox');
			const r = chbCrop.rect;
			b.style.left = r.x + 'px';
			b.style.top = r.y + 'px';
			b.style.width = r.w + 'px';
			b.style.height = r.h + 'px';
		}

		function setCropRatioButton(key) {
			document.querySelectorAll('#chbCropRatios button').forEach(function (b) {
				b.classList.toggle('active', b.dataset.ratio === key);
			});
		}

		function setCropRatio(key) {
			if (!chbCrop || !chbCrop.rect) return;
			const r = key === 'free' ? null : parseFloat(key);
			chbCrop.ratio = r;
			setCropRatioButton(key);
			document.getElementById('chbCropStage').classList.toggle('ratio-locked', !!r);
			if (r) {
				const dw = chbCrop.dw, dh = chbCrop.dh;
				const w = Math.min(dw * 0.8, dh * 0.8 * r);
				const h = w / r;
				chbCrop.rect = { x: (dw - w) / 2, y: (dh - h) / 2, w: w, h: h };
			}
			renderCropBox();
		}

		function cropDrag(dir, dx, dy, s) {
			const dw = chbCrop.dw, dh = chbCrop.dh, ratio = chbCrop.ratio, min = 24;
			const clamp = function (v, a, b) { return Math.max(a, Math.min(b, v)); };
			if (dir === 'move') {
				return { x: clamp(s.x + dx, 0, dw - s.w), y: clamp(s.y + dy, 0, dh - s.h), w: s.w, h: s.h };
			}
			let x1 = s.x, y1 = s.y, x2 = s.x + s.w, y2 = s.y + s.h;
			if (dir.indexOf('w') !== -1) x1 = clamp(s.x + dx, 0, x2 - min);
			if (dir.indexOf('e') !== -1) x2 = clamp(s.x + s.w + dx, x1 + min, dw);
			if (dir.indexOf('n') !== -1) y1 = clamp(s.y + dy, 0, y2 - min);
			if (dir.indexOf('s') !== -1) y2 = clamp(s.y + s.h + dy, y1 + min, dh);
			if (ratio && dir.length === 2) {
				const west = dir.indexOf('w') !== -1, north = dir.indexOf('n') !== -1;
				const ax = west ? s.x + s.w : s.x;
				const ay = north ? s.y + s.h : s.y;
				const maxW = west ? ax : dw - ax;
				const maxH = north ? ay : dh - ay;
				let nw = Math.min(x2 - x1, maxW, maxH * ratio);
				nw = Math.max(nw, min);
				const nh = nw / ratio;
				x1 = west ? ax - nw : ax;
				y1 = north ? ay - nh : ay;
				x2 = x1 + nw;
				y2 = y1 + nh;
			}
			return { x: x1, y: y1, w: x2 - x1, h: y2 - y1 };
		}

		function applyCrop() {
			const c = chbCrop;
			if (!c || !c.rect) return;
			const src = document.getElementById('chbCropImg');
			const sx = src.naturalWidth / c.dw, sy = src.naturalHeight / c.dh;
			const cw = Math.max(1, Math.round(c.rect.w * sx)), ch = Math.max(1, Math.round(c.rect.h * sy));
			const canvas = document.createElement('canvas');
			canvas.width = cw;
			canvas.height = ch;
			canvas.getContext('2d').drawImage(src, c.rect.x * sx, c.rect.y * sy, c.rect.w * sx, c.rect.h * sy, 0, 0, cw, ch);
			const isJpg = /^data:image\/jpe?g/i.test(c.target.src) || /\.jpe?g(\?|$)/i.test(c.target.src);
			let out;
			try {
				out = canvas.toDataURL(isJpg ? 'image/jpeg' : 'image/png', 0.92);
			} catch (err) {
				alert('Gambar ini tidak bisa di-crop karena berasal dari sumber lain.');
				return;
			}
			const target = c.target;
			closeCropDialog();
			target.addEventListener('load', function () { selectEditorImage(target); }, { once: true });
			target.src = out;
		}

		function initEditorExtras() {
			// Palet warna teks
			const grid = document.getElementById('chbColorGrid');
			CHB_COLORS.forEach(function (c) {
				const b = document.createElement('button');
				b.type = 'button';
				b.title = c;
				b.style.background = c;
				b.addEventListener('mousedown', function (e) { e.preventDefault(); });
				b.addEventListener('click', function () { applyTextColor(c); closeEditorPops(); });
				grid.appendChild(b);
			});
			document.getElementById('chbColorCustom').addEventListener('input', function () { applyTextColor(this.value); });

			// Grid shape
			const sg = document.getElementById('chbShapeGrid');
			Object.keys(CHB_SHAPES).forEach(function (key) {
				const s = CHB_SHAPES[key];
				const b = document.createElement('button');
				b.type = 'button';
				b.title = s.label;
				const t = document.createElement('span');
				t.style.cssText = 'display:block;background:#3b82f6;width:' + s.thumb[0] + 'px;height:' + s.thumb[1] + 'px;' + s.style.replace('border-radius:18px;', 'border-radius:5px;');
				b.appendChild(t);
				b.addEventListener('mousedown', function (e) { e.preventDefault(); });
				b.addEventListener('click', function () { insertShape(key); });
				sg.appendChild(b);
			});

			// Tutup popover saat klik di luar
			document.addEventListener('mousedown', function (e) {
				if (!e.target.closest || !e.target.closest('.editor-pop')) closeEditorPops();
			});

			// Crop
			document.querySelectorAll('#chbCropRatios button').forEach(function (b) {
				b.addEventListener('click', function () { setCropRatio(b.dataset.ratio); });
			});
			document.getElementById('btnCropCancel').addEventListener('click', closeCropDialog);
			document.getElementById('btnCropApply').addEventListener('click', applyCrop);
			const box = document.getElementById('chbCropBox');
			box.addEventListener('pointerdown', function (e) {
				if (!chbCrop || !chbCrop.rect) return;
				e.preventDefault();
				box.setPointerCapture(e.pointerId);
				chbCrop.drag = { dir: e.target.dataset.dir || 'move', sx: e.clientX, sy: e.clientY, start: Object.assign({}, chbCrop.rect) };
			});
			box.addEventListener('pointermove', function (e) {
				if (!chbCrop || !chbCrop.drag) return;
				chbCrop.rect = cropDrag(chbCrop.drag.dir, e.clientX - chbCrop.drag.sx, e.clientY - chbCrop.drag.sy, chbCrop.drag.start);
				renderCropBox();
			});
			['pointerup', 'pointercancel'].forEach(function (t) {
				box.addEventListener(t, function () { if (chbCrop) chbCrop.drag = null; });
			});

			// YouTube
			const yt = document.getElementById('chbYtInput');
			yt.addEventListener('input', updateYoutubePreview);
			yt.addEventListener('paste', function () { setTimeout(updateYoutubePreview, 0); });
			yt.addEventListener('keydown', function (e) {
				if (e.key === 'Enter') { e.preventDefault(); insertYoutubeVideo(); }
			});
			document.getElementById('btnYtCancel').addEventListener('click', closeYoutubeDialog);
			document.getElementById('btnYtInsert').addEventListener('click', insertYoutubeVideo);
			document.getElementById('chbYtOverlay').addEventListener('click', function (e) {
				if (e.target === this) closeYoutubeDialog();
			});

			document.addEventListener('keydown', function (e) {
				if (e.key !== 'Escape') return;
				if (document.getElementById('chbCropOverlay').classList.contains('show')) closeCropDialog();
				else if (document.getElementById('chbYtOverlay').classList.contains('show')) closeYoutubeDialog();
				else closeEditorPops();
			});
		}

		// ===== Mode Fokus Menulis: ketik/klik editor -> form penuh, tombol Kembali -> normal =====
		// Input lain hanya disembunyikan (CSS), tidak dihapus, jadi semua data tetap tersimpan.
		let chbFocusMode = false;
		let chbFocusLock = false;

		// Penanda aksi yang dijalankan saat tombol "Ya, Keluar" di modal konfirmasi ditekan:
		// 'modal' = menutup seluruh modal Tambah/Edit Blog (dari tombol "Batal")
		// 'focus' = hanya menutup mode zoom "Isi Konten Lengkap", modal Tambah/Edit tetap terbuka (dari tombol "Kembali")
		let unsavedConfirmTarget = 'modal';

		function updateFocusToggle() {
			// Tombol Perbesar sudah dihapus; tombol Kembali ada di pojok kiri atas (header) saat mode fokus.
		}

		function enterFocusMode() {
			if (chbFocusMode || chbFocusLock || !blogModal.classList.contains('show')) return;
			blogModal.querySelector('.modal-box').classList.add('focus-mode');
			chbFocusMode = true;
			deselectEditorImage();
			updateFocusToggle();
		}

		function exitFocusMode() {
			if (!chbFocusMode) return;
			saveRange();
			blogModal.querySelector('.modal-box').classList.remove('focus-mode');
			chbFocusMode = false;
			deselectEditorImage();
			updateFocusToggle();
			chbFocusLock = true; // cegah langsung membesar lagi karena fokus editor
			document.getElementById('inputKontenEditor').blur();
			setTimeout(function () { chbFocusLock = false; }, 400);
		}

		function toggleFocusMode() {
			if (chbFocusMode) {
				exitFocusMode();
			} else {
				enterFocusMode();
				document.getElementById('inputKontenEditor').focus();
			}
		}

		(function initFocusMode() {
			const editor = document.getElementById('inputKontenEditor');
			editor.addEventListener('focus', enterFocusMode);
			editor.addEventListener('click', enterFocusMode);
			editor.addEventListener('input', enterFocusMode);
			// Tombol "Kembali" saat mode fokus/zoom = hanya menutup mode zoom (modal Tambah/Edit tetap terbuka)
			document.getElementById('btnEditorBack').addEventListener('click', requestExitFocusMode);

			// Saat Simpan ditekan, kembalikan tampilan dulu supaya validasi input (Judul, Kategori) bisa berjalan
			document.querySelector('#blogForm .btn-save').addEventListener('click', exitFocusMode);

			document.addEventListener('keydown', function (e) {
				if (e.key === 'Escape' && chbFocusMode && !chbSelectedImg && !chbDialogOpen() && !imageZoomOverlay.classList.contains('show')) {
					exitFocusMode();
				}
			});
		})();

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
			if (!file) return;
			openCropModal(file, 16 / 9, inputGambar, function (croppedFile, inputEl) {
				const dt = new DataTransfer();
				dt.items.add(croppedFile);
				inputEl.files = dt.files;
				showImagePreview(croppedFile);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
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
			openCropModal(file, 16 / 9, inputGambar, function (croppedFile, inputEl) {
				const dt = new DataTransfer();
				dt.items.add(croppedFile);
				inputEl.files = dt.files;
				showImagePreview(croppedFile);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
			}, false);
		});

		btnRemoveImage.addEventListener('click', function (e) {
			e.stopPropagation();
			inputGambar.value = '';
			resetUploader();
			inputHapusGambar.value = '1';
			// Gambar lama sudah dihapus: wajib upload gambar baru sebelum bisa disimpan.
			gambarHint.textContent = 'Gambar telah dihapus, silakan unggah gambar baru.';
			gambarHint.style.color = 'var(--red)';
		});

		// ===== Zoom Mode =====
		btnZoomImage.addEventListener('click', function (e) {
			e.stopPropagation();
			zoomedImage.src = previewImage.src;
			imageZoomOverlay.classList.add('show'); imageZoomOverlay.scrollTop = 0;
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
			imageZoomOverlay.classList.add('show'); imageZoomOverlay.scrollTop = 0;
		}

		// ===== Kategori: pilihan "Lainnya..." untuk mengetik kategori sendiri =====
		const inputKategori = document.getElementById('inputKategori');
		const inputKategoriLainnya = document.getElementById('inputKategoriLainnya');

		function toggleKategoriLainnya() {
			const aktif = inputKategori.value === '__lainnya__';
			inputKategoriLainnya.style.display = aktif ? '' : 'none';
			inputKategoriLainnya.required = aktif;
			if (!aktif) inputKategoriLainnya.value = '';
		}
		inputKategori.addEventListener('change', function () {
			toggleKategoriLainnya();
			if (inputKategori.value === '__lainnya__') inputKategoriLainnya.focus();
		});

		// Cari option kategori yang sama (tanpa membedakan huruf besar/kecil)
		function findKategoriOption(nilai) {
			const target = String(nilai || '').trim().toLowerCase();
			return Array.from(inputKategori.options).find(function (o) {
				return o.value !== '__lainnya__' && o.value !== '' && o.value.toLowerCase() === target;
			});
		}

		// Set kategori (dipakai saat edit); kalau belum ada di daftar, ditambahkan sebagai pilihan
		function setKategoriValue(nilai) {
			const val = String(nilai || '').trim();
			let opt = findKategoriOption(val);
			if (!opt && val) {
				opt = new Option(val.charAt(0).toUpperCase() + val.slice(1), val);
				inputKategori.insertBefore(opt, inputKategori.querySelector('option[value="__lainnya__"]'));
			}
			inputKategori.value = opt ? opt.value : '';
			toggleKategoriLainnya();
		}

		// ===== Modal open/close =====
		function openAddModal() {
			isEditMode = false;
			syncModalWithContentArea();
			modalTitle.textContent = 'Tambah Blog';
			blogForm.reset();
			toggleKategoriLainnya();
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
			document.body.classList.add('chb-modal-open');
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
			setKategoriValue(data.kategori);

			document.getElementById('inputKontenEditor').innerHTML = data.konten || '';
			chbReviveShapes();
			chbNormalizeMedia();
			document.getElementById('inputKonten').value = data.konten || '';
			deselectEditorImage();
			chbSavedRange = null;

			if (data.gambar) {
				inputHapusGambar.value = '0';
				gambarHint.textContent = 'Kosongkan jika tidak ingin mengganti gambar.';
				gambarHint.style.color = '';
				previewImage.src = data.gambar;
				uploaderEmpty.style.display = 'none';
				uploaderPreview.style.display = 'block';
			} else {
				// Data lama memang belum punya gambar sama sekali, jadi tetap wajib upload.
				inputHapusGambar.value = '1';
				gambarHint.textContent = 'Gambar utama wajib diunggah.';
				gambarHint.style.color = 'var(--red)';
				resetUploader();
			}

			blogModal.classList.add('show');
			document.body.classList.add('chb-modal-open');
		}

		function closeModal() {
			exitFocusMode();
			deselectEditorImage();
			blogModal.classList.remove('show');
			document.body.classList.remove('chb-modal-open');
		}

		// Cek apakah form Tambah/Edit Blog sudah ada isinya (judul, kategori, konten, atau gambar)
		function isBlogFormDirty() {
			const judul = (document.getElementById('inputJudul').value || '').trim();
			const kategori = inputKategori.value || '';
			const editorEl = document.getElementById('inputKontenEditor');
			const kontenText = (editorEl.textContent || '').trim();
			const adaMediaKonten = /<(img|iframe)\b|chb-shape/.test(editorEl.innerHTML || '');
			const adaGambarBaru = inputGambar.files && inputGambar.files.length > 0;
			const gambarDihapus = inputHapusGambar.value === '1';
			return !!(judul || kategori || kontenText.length > 0 || adaMediaKonten || adaGambarBaru || gambarDihapus);
		}

		// Tombol "Batal": menutup seluruh modal Tambah/Edit Blog.
		// Kalau ada isian yang belum disimpan, minta konfirmasi dulu.
		function requestCloseModal() {
			unsavedConfirmTarget = 'modal';
			if (isBlogFormDirty()) {
				unsavedConfirmModal.classList.add('show');
			} else {
				closeModal();
			}
		}

		// Tombol "Kembali" (saat mode zoom "Isi Konten Lengkap" aktif): hanya menutup mode zoom,
		// modal Tambah/Edit Blog TETAP TERBUKA. Kalau ada isian yang belum disimpan, minta konfirmasi dulu;
		// jika dikonfirmasi "Ya, Keluar", ketikan yang baru dibuat TIDAK disimpan (form tidak ikut tersubmit),
		// dan tampilan kembali ke mode normal (bukan menutup seluruh modal).
		function requestExitFocusMode() {
			unsavedConfirmTarget = 'focus';
			if (isBlogFormDirty()) {
				unsavedConfirmModal.classList.add('show');
			} else {
				exitFocusMode();
			}
		}

		function openBlogDeleteConfirm(title, text) {
			deleteConfirmTitle.textContent = title;
			deleteConfirmText.textContent = text;
			deleteConfirmModal.classList.add('show');
		}

		// Hapus satu blog (dipanggil manual jika diperlukan)
		function confirmDelete(icon) {
			blogDeleteMode = 'single';
			formToDelete = icon.closest('form');
			openBlogDeleteConfirm('Hapus Blog Ini?', 'Yakin ingin menghapus blog ini? Data yang sudah dihapus tidak dapat dikembalikan.');
		}

		// Hapus semua blog yang dicentang (tombol "Hapus Terpilih")
		function confirmBulkDeleteBlog() {
			if (blogSelectedIds.size === 0) return;
			blogDeleteMode = 'bulk';
			openBlogDeleteConfirm(
				'Hapus Blog Terpilih?',
				'Yakin ingin menghapus ' + blogSelectedIds.size + ' blog yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.'
			);
		}

		btnCancelDelete.addEventListener('click', function () {
			formToDelete = null;
			blogDeleteMode = 'single';
			deleteConfirmModal.classList.remove('show');
		});

		btnConfirmDelete.addEventListener('click', async function () {
			if (blogDeleteMode === 'single') {
				if (formToDelete) {
					formToDelete.submit();
				}
				deleteConfirmModal.classList.remove('show');
				return;
			}

			// Mode massal: kirim form hapus untuk tiap blog yang dicentang
			const ids = Array.from(blogSelectedIds);
			if (ids.length === 0) {
				deleteConfirmModal.classList.remove('show');
				return;
			}

			const originalText = btnConfirmDelete.innerHTML;
			btnConfirmDelete.innerHTML = 'Menghapus...';
			btnConfirmDelete.disabled = true;

			let gagal = 0;
			for (const id of ids) {
				const form = document.getElementById('deleteFormBlog' + id);
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
				'blogBulkDeleteMessage',
				gagal === 0
					? berhasil + ' blog berhasil dihapus.'
					: berhasil + ' dari ' + ids.length + ' blog berhasil dihapus.'
			);

			btnConfirmDelete.innerHTML = originalText;
			btnConfirmDelete.disabled = false;
			deleteConfirmModal.classList.remove('show');
			window.location.reload();
		});

		deleteConfirmModal.addEventListener('click', function (e) {
			if (e.target === deleteConfirmModal && !btnConfirmDelete.disabled) {
				formToDelete = null;
				blogDeleteMode = 'single';
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

		const blogBulkDeleteMessage = sessionStorage.getItem('blogBulkDeleteMessage');
		if (blogBulkDeleteMessage) {
			sessionStorage.removeItem('blogBulkDeleteMessage');
			showSuccessPopup(blogBulkDeleteMessage);
		}
		@if(session('success'))
			else {
				showSuccessPopup(@json(session('success')));
			}
		@endif

		// ===== Validasi sebelum submit =====
		blogForm.addEventListener('submit', function (e) {
			// Kategori wajib dipilih, baik saat Tambah maupun Edit
			if (!inputKategori.value) {
				e.preventDefault();
				inputKategori.focus();
				return;
			}

			// Kategori "Lainnya...": jadikan teks yang diketik sebagai nilai kategori yang dikirim
			if (inputKategori.value === '__lainnya__') {
				const teks = inputKategoriLainnya.value.trim().replace(/\s+/g, ' ');
				if (!teks) {
					e.preventDefault();
					inputKategoriLainnya.focus();
					return;
				}
				let opt = findKategoriOption(teks);
				if (!opt) {
					opt = new Option(teks.charAt(0).toUpperCase() + teks.slice(1), teks);
					inputKategori.insertBefore(opt, inputKategori.querySelector('option[value="__lainnya__"]'));
				}
				inputKategori.value = opt.value;
			}

			// Salin isi editor tanpa class sementara (terpilih / preview video sedang diputar)
			const editorClone = document.getElementById('inputKontenEditor').cloneNode(true);
			editorClone.querySelectorAll('.is-selected, .chb-playing').forEach(function (n) { n.classList.remove('is-selected', 'chb-playing'); });
			chbNormalizeMedia(editorClone);
			editorClone.querySelectorAll('.chb-shape-text').forEach(function (n) { n.removeAttribute('contenteditable'); });
			editorClone.querySelectorAll('[class=""]').forEach(function (n) { n.removeAttribute('class'); });
			const editorHtml = editorClone.innerHTML;
			document.getElementById('inputKonten').value = editorHtml;

			const editorText = document.getElementById('inputKontenEditor').textContent.trim();
			if (editorText.length === 0 && !/<(img|iframe)\b|chb-shape/.test(editorHtml)) {
				e.preventDefault();
				alert('Isi konten tidak boleh kosong.');
				return;
			}

			// Gambar utama wajib ada:
			// - Saat Tambah: wajib upload gambar baru.
			// - Saat Edit: kalau gambar lama dihapus (hapus_gambar = '1') dan belum ada gambar baru, tetap wajib upload.
			if (!inputGambar.files.length && (!isEditMode || inputHapusGambar.value === '1')) {
				e.preventDefault();
				gambarHint.textContent = 'Gambar utama wajib diunggah.';
				gambarHint.style.color = 'var(--red)';
				return;
			}
		});

		document.getElementById('btnTambahBlog').addEventListener('click', function (e) {
			e.preventDefault();
			openAddModal();
		});

		document.getElementById('btnCancelModal').addEventListener('click', requestCloseModal);

		// Popup konfirmasi keluar tanpa menyimpan
		btnTetapIsi.addEventListener('click', function () {
			unsavedConfirmModal.classList.remove('show');
		});
		btnKeluarTanpaSimpan.addEventListener('click', function () {
			unsavedConfirmModal.classList.remove('show');
			if (unsavedConfirmTarget === 'focus') {
				// Dari tombol "Kembali" di mode zoom: hanya tutup mode zoom, modal Tambah/Edit tetap terbuka
				// dan ketikan yang baru dibuat tidak tersimpan (tidak ikut disubmit).
				exitFocusMode();
			} else {
				// Dari tombol "Batal": tutup seluruh modal Tambah/Edit Blog.
				closeModal();
			}
			unsavedConfirmTarget = 'modal';
		});
		unsavedConfirmModal.addEventListener('click', function (e) {
			if (e.target === unsavedConfirmModal) unsavedConfirmModal.classList.remove('show');
		});

		@if($errors->any())
			openAddModal();
			document.getElementById('inputKontenEditor').innerHTML = @json(old('konten', ''));
			chbReviveShapes();
			chbNormalizeMedia();
			document.getElementById('inputKonten').value = @json(old('konten', ''));
		@endif

	/* ===== Header diam di atas; kartu daftar bisa discroll (seperti Pengaturan Halaman) ===== */
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