@extends('admin.layouts.app')

@section('title', 'Kelola Proyek - Admin Astabrata Teknologi')
@section('page-title', 'Kelola Proyek')

@push('styles')
<style>
    /* ========== DASBOR UTAMA ========== */
    #content main {
        font-family: var(--poppins), sans-serif;
    }
    #content main .head-title .btn-download {
        height: 36px;
        padding: 0 16px;
        border-radius: 36px;
        background: #3b82f6;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        grid-gap: 10px;
        font-weight: 500;
        font-family: var(--poppins), sans-serif;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }
    #content main .head-title .btn-download:hover { background: #2563eb; transform: translateY(-2px); }

    /* Tombol Import & Export Custom */
    .btn-export {
        background: #10B981 !important;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2) !important;
    }
    .btn-export:hover { background: #059669 !important; }
    
    .btn-import {
        background: #F59E0B !important;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2) !important;
    }
    .btn-import:hover { background: #D97706 !important; }

    #content main .box-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); grid-gap: 24px; margin-top: 36px; }
    #content main .box-info li { padding: 24px; background: #fff; border-radius: 20px; display: flex; align-items: center; grid-gap: 24px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
    #content main .box-info li .bx { width: 80px; height: 80px; border-radius: 14px; font-size: 36px; display: flex; justify-content: center; align-items: center; }
    #content main .box-info li:nth-child(1) .bx { background: #e0f2fe; color: #0284c7; }
    #content main .box-info li:nth-child(2) .bx { background: #fef08a; color: #ca8a04; }
    #content main .box-info li:nth-child(3) .bx { background: #ffedd5; color: #ea580c; }
    #content main .box-info li .text h3 { font-size: 24px; font-weight: 600; color: #1e293b; }
    #content main .box-info li .text p { color: #64748b; font-size: 14px; font-weight: 500; }

    #content main .table-data { display: flex; flex-wrap: wrap; grid-gap: 24px; margin-top: 24px; width: 100%; color: #1e293b; }
    #content main .table-data > div { border-radius: 20px; background: #fff; padding: 24px; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    
    /* Kartu Daftar Client */
    #content main .table-data .client { flex: 1 1 100%; width: 100%; max-width: 100%; min-width: 0; }
    #content main .table-data .head { display: flex; align-items: center; grid-gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    #content main .table-data .head h3 { margin-right: auto; font-size: 20px; font-weight: 600; white-space: nowrap; }

    /* TOOLBAR PENCARIAN & FILTER */
    #content main .table-data .head .table-toolbar { display: flex; align-items: center; grid-gap: 10px; flex-wrap: wrap; }
    #content main .table-data .head .search-box { display: flex; align-items: center; grid-gap: 8px; background: #f1f5f9; border-radius: 36px; padding: 0 16px; height: 38px; }
    #content main .table-data .head .search-box .bx { font-size: 16px; color: #64748b; cursor: default; }
    #content main .table-data .head .search-box input { border: none; background: transparent; outline: none; font-family: var(--poppins), sans-serif; font-size: 13px; color: #1e293b; width: 180px; }
    #content main .table-data .head select.filter-select { height: 38px; padding: 0 14px; border-radius: 36px; border: none; background: #f1f5f9; color: #1e293b; font-family: var(--poppins), sans-serif; font-size: 13px; outline: none; cursor: pointer; }

    /* TOMBOL PILIH DATA (toggle mode) & HAPUS TERPILIH / HAPUS SEMUA */
    #content main .table-data .head .btn-select-mode,
    #content main .table-data .head .btn-bulk-delete {
        height: 38px; padding: 0 16px; border-radius: 36px; border: none; cursor: pointer;
        font-family: var(--poppins), sans-serif; font-size: 13px; font-weight: 500;
        display: flex; align-items: center; grid-gap: 6px; transition: all 0.2s ease; white-space: nowrap;
    }
    #content main .table-data .head .btn-select-mode { background: #ef4444; color: #fff; }
    #content main .table-data .head .btn-select-mode:hover { background: #dc2626; }
    #content main .table-data .head .btn-select-mode.active { background: #1e293b; color: #fff; }
    #content main .table-data .head .bulk-actions-group { display: none; align-items: center; grid-gap: 10px; }
    #content main .table-data .head .bulk-actions-group.show { display: flex; }
    #content main .table-data .head .btn-bulk-delete { background: #fee2e2; color: #ef4444; }
    #content main .table-data .head .btn-bulk-delete:hover:not(:disabled) { background: #ef4444; color: #fff; }
    #content main .table-data .head .btn-bulk-delete:disabled { opacity: 0.5; cursor: not-allowed; }

    #content main .table-data .client table { width: 100%; min-width: 820px; border-collapse: collapse; table-layout: fixed; }
    #content main .table-data .client table th:nth-child(1) { width: 50px; }
    #content main .table-data .client table th:nth-child(2) { width: 17%; }
    #content main .table-data .client table th:nth-child(3) { width: 17%; }
    #content main .table-data .client table th:nth-child(4) { width: 220px; }
    #content main .table-data .client table th:nth-child(5),
    #content main .table-data .client table th:nth-child(6) { width: 110px; }
    #content main .table-data .client table th:nth-child(7) { width: 130px; }
    #content main .table-data .client table th:nth-child(8) { width: 230px; }
    #content main .table-data .client table th#chbAksiHeader { display: flex; align-items: center; justify-content: center; text-align: center; grid-gap: 8px; }
    #content main .table-data .client table th#chbAksiHeader.select-mode-header {
        display: grid;
        grid-template-columns: 1fr 16px 1fr;
        align-items: center;
        text-align: left;
    }
    #content main .table-data .client table th#chbAksiHeader.select-mode-header #chbSelectAll {
        grid-column: 2;
        margin: 0;
    }
    #content main .table-data .client table th#chbAksiHeader.select-mode-header .chb-select-label {
        grid-column: 3;
        margin-left: 8px;
        white-space: nowrap;
    }
    #content main .table-data .client table td.select-cell { text-align: center; }
    #content main .table-data .client table th input[type="checkbox"],
    #content main .table-data .client table td.select-cell input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; accent-color: #3b82f6; }
    #content main .table-data .client table tr.row-selected { background: #eff6ff; }
    #content main .table-data .client table th { padding-bottom: 14px; font-size: 13px; text-align: left; border-bottom: 2px solid #f1f5f9; color: #64748b; white-space: nowrap; font-weight: 600; }
    #content main .table-data .client table td { padding: 16px 12px 16px 0; vertical-align: top; font-size: 14px; color: #334155; border-bottom: 1px solid #f8fafc; }
    #content main .table-data .client table td.desc-cell { max-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: #64748b; }

    #content main .table-data .client table td.action-cell { white-space: nowrap; text-align: center; }
    #content main .table-data .client table .btn-detail,
    #content main .table-data .client table .btn-edit,
    #content main .table-data .client table .btn-delete { border: none; cursor: pointer; font-family: var(--poppins), sans-serif; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; color: #fff; margin-right: 4px; transition: opacity 0.2s; display: inline-block; }
    #content main .table-data .client table .btn-delete { margin-right: 0; }
    #content main .table-data .client table .btn-detail { background: #3b82f6; }
    #content main .table-data .client table .btn-edit { background: #f59e0b; }
    #content main .table-data .client table .btn-delete { background: #ef4444; }

    /* ========== INDIKATOR DEADLINE ========== */
    .status-lewat { border-left: 4px solid #ef4444 !important; padding-left: 8px !important; }
    .status-h1 { border-left: 4px solid #eab308 !important; padding-left: 8px !important; }
    .status-aktif { border-left: 4px solid #22c55e !important; padding-left: 8px !important; }
    
    .badge-lewat {
        display: inline-block; font-size: 11px;
        background: #fee2e2; color: #ef4444; padding: 2px 8px; border-radius: 12px; font-weight: 600;
    }
    .badge-h1 {
        display: inline-block; font-size: 11px;
        background: #fef9c3; color: #ca8a04; padding: 2px 8px; border-radius: 12px; font-weight: 600;
    }
    .badge-aktif {
        display: inline-block; font-size: 11px;
        background: #dcfce7; color: #22c55e; padding: 2px 8px; border-radius: 12px; font-weight: 600;
    }

    /* ========== PAGINATION ========== */
    .pagination-container { display: flex; align-items: center; justify-content: flex-end; grid-gap: 8px; margin-top: 24px; }
    .pagination-container button { border: none; background: #f1f5f9; color: #475569; width: 32px; height: 32px; border-radius: 8px; font-family: var(--poppins), sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
    .pagination-container button:hover:not(:disabled) { background: #e2e8f0; color: #1e293b; }
    .pagination-container button.active { background: #3b82f6; color: #fff; }
    .pagination-container button:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ========== MODAL LAYOUT & ANIMASI ========== */
    .chb-modal-overlay {
        display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
        z-index: 1000; justify-content: center; align-items: center; padding: 20px;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .chb-modal-overlay.show { display: flex; opacity: 1; }
    .chb-modal {
        background: #ffffff; border-radius: 16px; padding: 30px 30px 0 30px;
        width: 100%; max-width: 860px; max-height: 90vh; overflow-y: auto;
        color: #1e293b; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative; transform: translateY(20px) scale(0.95); transition: transform 0.3s ease;
        font-family: var(--poppins), sans-serif;
    }
    .chb-modal-overlay.show .chb-modal { transform: translateY(0) scale(1); }
    .chb-modal h3 { margin-bottom: 25px; font-size: 22px; font-weight: 600; color: #0f172a; }

    /* ---------- MODAL FULLSCREEN ---------- */
    .chb-modal-overlay.overlay-full {
        left: var(--chb-sidebar-w, 0px);
        padding: 28px 32px;
        align-items: stretch; justify-content: stretch;
        z-index: 1200;
        transition: left 0.3s ease;
    }
    .chb-modal.modal-full {
        max-width: none; width: 100%; height: 100%; max-height: 100%;
        padding: 0; overflow: hidden; display: flex; flex-direction: column;
        border-radius: 18px;
    }
    .modal-full-header { display: flex; align-items: center; gap: 14px; padding: 20px 32px; border-bottom: 1px solid #e2e8f0; background: #fff; flex-shrink: 0; }
    .modal-full-header h3 { margin: 0; font-size: 20px; font-weight: 600; }
    .modal-full-header .modal-subtitle { font-size: 13px; color: #64748b; margin-top: 2px; }
    .chb-modal.modal-full form { display: flex; flex-direction: column; flex: 1; min-height: 0; }
    .modal-full-body { flex: 1; min-height: 0; overflow-y: auto; padding: 26px 32px; }

    .form-split { display: grid; grid-template-columns: 360px 1fr; gap: 28px; align-items: start; min-height: 100%; }
    .form-col-left { display: flex; flex-direction: column; gap: 18px; }
    .form-col-right { display: flex; flex-direction: column; height: 100%; min-height: 420px; }
    .form-col-right .form-group { flex: 1; min-height: 0; }
    .field-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px 18px; background: #fff; }
    .chb-modal .form-group { display: flex; flex-direction: column; }
    .chb-modal .form-group label { font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #1e293b; }
    .chb-modal .form-group input, 
    .chb-modal .form-group select,
    .chb-modal .form-group textarea {
        padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 8px;
        font-size: 14px; outline: none; transition: all 0.2s; background: #fff; width: 100%;
        font-family: var(--poppins), sans-serif; color: #1e293b;
    }
    .chb-modal .form-group input:focus, 
    .chb-modal .form-group select:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    /* ========== TEXT EDITOR (WYSIWYG) ========== */
    .editor-box { border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; transition: border-color 0.2s; display: flex; flex-direction: column; height: 100%; min-height: 0; overflow: hidden; }
    .editor-box:focus-within { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .editor-toolbar { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; padding: 8px 12px; border-bottom: 1px solid #cbd5e1; background: #f8fafc; flex-shrink: 0; }
    .editor-toolbar select { padding: 4px 8px; font-size: 13px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; cursor: pointer; outline: none; color: #334155; font-family: var(--poppins), sans-serif; }
    .editor-btn { background: transparent; border: none; padding: 4px; font-size: 16px; cursor: pointer; border-radius: 6px; color: #475569; width: 30px; height: 30px; transition: 0.2s; display: inline-flex; align-items: center; justify-content: center; }
    .editor-btn:hover { background: #e2e8f0; color: #0f172a; }
    .editor-btn.is-image { color: #2563eb; }
    .editor-divider { width: 1px; height: 18px; background: #cbd5e1; margin: 0 4px; }
    .editor-canvas { position: relative; flex: 1; min-height: 0; display: flex; }
    .editor-content { flex: 1; min-height: 220px; overflow-y: auto; padding: 18px 20px; font-size: 14px; line-height: 1.7; outline: none; color: #1e293b; }
    .editor-content:empty:before { content: attr(data-placeholder); color: #94a3b8; }
    .editor-content img { max-width: 100%; height: auto; border-radius: 6px; cursor: pointer; }
    .editor-content img.is-selected { outline: 2px solid #3b82f6; outline-offset: 1px; }

    .img-frame { position: absolute; display: none; pointer-events: none; z-index: 20; }
    .img-frame.active { display: block; }
    .img-frame .frame-border { position: absolute; inset: 0; border: 1.5px solid #3b82f6; border-radius: 4px; }
    .img-frame .handle { position: absolute; width: 11px; height: 11px; background: #fff; border: 2px solid #3b82f6; border-radius: 2px; pointer-events: auto; }
    .img-frame .handle.tl { left: -6px; top: -6px; cursor: nwse-resize; }
    .img-frame .handle.tr { right: -6px; top: -6px; cursor: nesw-resize; }
    .img-frame .handle.bl { left: -6px; bottom: -6px; cursor: nesw-resize; }
    .img-frame .handle.br { right: -6px; bottom: -6px; cursor: nwse-resize; }
    .img-frame .handle.mr { right: -6px; top: 50%; margin-top: -5px; cursor: ew-resize; }
    .img-frame .handle.ml { left: -6px; top: 50%; margin-top: -5px; cursor: ew-resize; }
    .img-toolbar { position: absolute; display: none; z-index: 30; background: #0f172a; color: #fff; border-radius: 10px; padding: 6px; gap: 2px; align-items: center; box-shadow: 0 10px 24px rgba(15, 23, 42, 0.28); }
    .img-toolbar.active { display: flex; }
    .img-toolbar button { background: transparent; border: none; color: #e2e8f0; cursor: pointer; padding: 5px 9px; border-radius: 6px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; transition: 0.15s; font-family: var(--poppins), sans-serif; }
    .img-toolbar button:hover { background: rgba(255,255,255,0.14); color: #fff; }
    .img-toolbar button.danger:hover { background: #ef4444; color: #fff; }
    .img-toolbar .tb-divider { width: 1px; height: 18px; background: rgba(255,255,255,0.2); margin: 0 4px; }
    .img-size-badge { position: absolute; background: #0f172a; color: #fff; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 6px; display: none; z-index: 31; }
    .img-size-badge.active { display: block; }

    /* ========== STICKY FOOTER ACTION BAR ========== */
    .chb-modal .form-actions { position: sticky; bottom: 0; background: rgba(255, 255, 255, 0.98); padding: 20px 30px; margin: 25px -30px 0 -30px; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; grid-gap: 12px; z-index: 100; border-radius: 0 0 16px 16px; }
    .chb-modal.modal-full .form-actions { position: static; margin: 0; padding: 18px 32px; border-top: 1px solid #e2e8f0; flex-shrink: 0; border-radius: 0 0 18px 18px; }
    .chb-modal .form-actions button { border: none; cursor: pointer; padding: 10px 24px; border-radius: 36px; font-weight: 500; font-size: 14px; transition: 0.2s; font-family: var(--poppins), sans-serif; }
    .chb-modal .btn-cancel { background: transparent; color: #64748b; font-weight: 600; }
    .chb-modal .btn-cancel:hover { background: #f1f5f9; color: #1e293b; }
    /* Form Tambah/Edit (fullscreen): tombol Batal berwarna merah */
    .chb-modal.modal-full .btn-cancel { background: var(--red, #ef4444); color: #fff; }
    .chb-modal.modal-full .btn-cancel:hover { background: var(--red, #ef4444); color: #fff; filter: brightness(0.92); }
    .chb-modal .btn-save { background: #3b82f6; color: #fff; display: flex; align-items: center; gap: 6px; }
    .chb-modal .btn-save:hover { background: #2563eb; }

    /* ========== MODAL DETAIL ========== */
    .detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 20px; }
    .detail-item { background: #ffffff; padding: 16px 20px; border-radius: 12px; border: 1px solid #e2e8f0; }
    .detail-item-full { grid-column: 1 / -1; }
    .detail-label { font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 8px; display: block; }
    .detail-value { font-size: 14px; color: #0f172a; line-height: 1.6; }
    .detail-value img { max-width: 100%; height: auto; border-radius: 8px; cursor: zoom-in; }

    /* ========== MODAL KONFIRMASI & NOTIFIKASI (HAPUS, SIMPAN/EDIT, BERHASIL) ==========
       Tampilan disamakan dengan halaman Kelola Layanan */
    .modal-overlay {
        display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, .5);
        z-index: 5000; justify-content: center; align-items: center; padding: 16px;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: var(--light); border-radius: 16px; padding: 40px; width: 100%; max-width: 900px;
        max-height: 92vh; overflow-y: auto; font-family: var(--poppins), sans-serif;
    }
    .modal-box .modal-actions { display: flex; justify-content: flex-end; grid-gap: 12px; margin-top: 8px; }
    .modal-box .btn-cancel,
    .modal-box .btn-save,
    .modal-box .btn-danger { padding: 10px 20px; border-radius: 36px; border: none; font-weight: 500; cursor: pointer; font-family: var(--poppins), sans-serif; }
    .modal-box .btn-cancel { background: var(--red); color: var(--light); }
    .modal-box .btn-save { background: var(--blue); color: var(--light); }
    .modal-box .btn-danger { background: var(--red); color: var(--light); }
    .modal-box .btn-cancel:disabled,
    .modal-box .btn-save:disabled,
    .modal-box .btn-danger:disabled { opacity: .6; cursor: not-allowed; }

    .modal-box.modal-confirm { max-width: 380px; text-align: center; padding: 36px 28px; }
    .modal-box.modal-confirm .confirm-icon {
        width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 34px; background: var(--light-orange); color: var(--red);
    }
    .modal-box.modal-confirm .confirm-icon.success { background: var(--light-blue); color: var(--blue); }
    .modal-box.modal-confirm h2 { margin-bottom: 8px; color: var(--dark); }
    .modal-box.modal-confirm p { color: var(--dark-grey); font-size: 14px; margin: 0; }
    .modal-box.modal-confirm .modal-actions { justify-content: center; margin-top: 24px; }

    /* ========== IMPORT EXCEL: MODAL UNGGAH & MODAL HASIL ========== */
    .modal-box.modal-import { max-width: 520px; padding: 32px 32px 28px; }
    .modal-import .import-head { display: flex; align-items: center; gap: 16px; margin-bottom: 20px; }
    .modal-import .import-icon { width: 52px; height: 52px; flex: 0 0 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; background: #fef3c7; color: #d97706; }
    .modal-import h2 { font-size: 20px; margin: 0 0 2px; color: var(--dark); }
    .modal-import .import-sub { margin: 0; font-size: 13px; color: var(--dark-grey); }
    .modal-import .import-steps { margin: 0 0 18px; padding-left: 20px; font-size: 13.5px; line-height: 1.7; color: #334155; }
    .modal-import .import-link { display: inline-flex; align-items: center; gap: 4px; margin-left: 4px; color: #2563eb; font-weight: 600; text-decoration: none; }
    .modal-import .import-link:hover { text-decoration: underline; }
    .import-drop { display: flex; flex-direction: column; align-items: center; gap: 6px; text-align: center; padding: 22px 16px; border: 2px dashed #cbd5e1; border-radius: 14px; background: #f8fafc; color: #475569; cursor: pointer; transition: border-color .2s, background .2s; }
    .import-drop:hover, .import-drop.is-over { border-color: #3b82f6; background: #eff6ff; }
    .import-drop.has-file { border-style: solid; border-color: #22c55e; background: #f0fdf4; }
    .import-drop .bx { font-size: 30px; color: #64748b; }
    .import-drop.has-file .bx { color: #16a34a; }
    .import-drop strong { font-size: 14px; font-weight: 600; color: #1e293b; word-break: break-all; }
    .import-drop small { font-size: 12px; color: #64748b; }
    .import-msg { min-height: 18px; margin: 10px 2px 0; font-size: 12.5px; color: #dc2626; }
    .modal-import .import-note { margin: 4px 2px 0; font-size: 12px; line-height: 1.5; color: var(--dark-grey); }
    .modal-import .modal-actions { margin-top: 20px; }

    .modal-box.modal-result { max-width: 520px; }
    .modal-result .confirm-icon.warn { background: #fef3c7; color: #d97706; }
    .result-stats { display: flex; gap: 10px; margin: 20px 0 0; }
    .result-stats .stat { flex: 1; padding: 12px 6px; border-radius: 12px; background: #f1f5f9; }
    .result-stats .stat b { display: block; font-size: 22px; font-weight: 600; color: #0f172a; }
    .result-stats .stat span { font-size: 12px; color: #64748b; }
    .result-stats .stat.ok b { color: #16a34a; }
    .result-stats .stat.skip b { color: #d97706; }
    .result-stats .stat.bad b { color: #dc2626; }
    .result-errors { list-style: none; margin: 14px 0 0; padding: 0; max-height: 220px; overflow-y: auto; text-align: left; border: 1px solid #e2e8f0; border-radius: 12px; }
    .result-errors li { display: flex; gap: 12px; padding: 9px 14px; font-size: 13px; color: #334155; border-bottom: 1px solid #f1f5f9; }
    .result-errors li:last-child { border-bottom: 0; }
    .result-errors li b { flex: 0 0 64px; color: #0f172a; }
    .result-hint { margin: 12px 2px 0 !important; font-size: 12.5px !important; text-align: left; }

    /* ========== LIGHTBOX ZOOM (GLOBAL) ========== */
    .db-lightbox { display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.95); backdrop-filter: blur(8px); align-items: center; justify-content: center; flex-direction: column; opacity: 0; transition: opacity 0.3s ease; }
    .db-lightbox.show { display: flex; opacity: 1; }
    .db-lightbox-content { position: relative; max-width: 90%; max-height: 85vh; display: flex; justify-content: center; align-items: center; }
    .db-lightbox-content img { max-width: 100%; max-height: 85vh; border-radius: 12px; box-shadow: 0 15px 40px rgba(0,0,0,0.4); object-fit: contain; }
    .db-lightbox-close { position: absolute; top: 25px; right: 40px; color: #fff; font-size: 40px; font-weight: 300; cursor: pointer; z-index: 10001; transition: 0.2s; }
    .db-lightbox-close:hover { color: #ef4444; transform: scale(1.1); }
    .db-lightbox-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.1); border: none; color: #fff; font-size: 24px; width: 50px; height: 50px; border-radius: 50%; cursor: pointer; z-index: 10001; transition: 0.3s; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .db-lightbox-btn:hover { background: rgba(255,255,255,0.25); transform: translateY(-50%) scale(1.1); }
    .db-lightbox-btn.prev { left: 30px; }
    .db-lightbox-btn.next { right: 30px; }

    @media screen and (max-width: 992px) {
        .form-split { grid-template-columns: 1fr; }
        .form-col-right { min-height: 340px; }
    }
    @media screen and (max-width: 768px) {
        .modal-grid, .detail-grid { grid-template-columns: 1fr; }
        .chb-modal-overlay.overlay-full { left: 0; padding: 14px; }
        .modal-full-header, .modal-full-body, .chb-modal.modal-full .form-actions { padding-left: 18px; padding-right: 18px; }
        #sidebar { width: 200px; }
        #content { width: calc(100% - 60px); left: 200px; }
        .db-lightbox-btn { width: 40px; height: 40px; font-size: 18px; }
        .db-lightbox-btn.prev { left: 10px; }
        .db-lightbox-btn.next { right: 10px; }
    }
</style>
@endpush

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Kelola Proyek</h1>
            <ul class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Kelola Proyek</a></li>
            </ul>
        </div>
        
        <!-- TOMBOL EXPORT, IMPORT, & TAMBAH CLIENT -->
        <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">

            <!-- Export: unduh semua data client sebagai file Excel (.xlsx) -->
            <a href="{{ route('admin.kelola-proyek.export') }}" class="btn-download btn-export" id="btnExportExcel" onclick="return chbHandleExportClick(event, this.href)">
                <i class='bx bxs-file-export'></i>
                <span class="text">Export Excel</span>
            </a>

            <!-- Import: membuka popup berisi petunjuk, template, dan pilihan file -->
            <button type="button" class="btn-download btn-import" onclick="openImportModal()">
                <i class='bx bxs-file-import'></i>
                <span class="text">Import Excel</span>
            </button>

            <!-- Tombol Tambah Client (Bawaan lu) -->
            <button type="button" class="btn-download" onclick="chbOpenAddModal()">
                <i class='bx bx-plus'></i> 
                <span class="text">Tambah Client</span>
            </button>
        </div>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3 id="statTotalClient">0</h3>
                <p>Total Client</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-briefcase'></i>
            <span class="text">
                <h3 id="statProjectAktif">0</h3>
                <p>Project Aktif</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-calendar-x'></i>
            <span class="text">
                <h3 id="statLewatDeadline">0</h3>
                <p>Lewat Deadline</p>
            </span>
        </li>
    </ul>

    <div class="table-data">
        <div class="client">
            <div class="head">
                <h3>Daftar Client</h3>
                <div class="table-toolbar">
                    <div class="search-box">
                        <i class='bx bx-search'></i>
                        <input type="text" id="clientSearch" placeholder="Cari client/project...">
                    </div>
                    <select id="clientFilterStatus" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Project Aktif</option>
                        <option value="lewat">Lewat Deadline</option>
                    </select>
                    <select id="clientLimit" class="filter-select">
                        <option value="semua">Semua Baris</option>
                        <option value="5">5 Baris</option>
                        <option value="10">10 Baris</option>
                        <option value="20">20 Baris</option>
                    </select>
                    <button type="button" class="btn-select-mode" id="btnToggleSelectMode" onclick="chbToggleSelectMode()">
                        <i class='bx bx-list-check'></i> <span id="btnToggleSelectModeText">Hapus</span>
                    </button>
                    <div class="bulk-actions-group" id="bulkActionsGroup">
                        <button type="button" class="btn-bulk-delete" id="btnBulkDelete" disabled onclick="chbBulkDeleteSelected()">
                            <i class='bx bx-trash'></i> Hapus (<span id="bulkDeleteCount">0</span>)
                        </button>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Client</th>
                        <th>Project</th>
                        <th>Deskripsi</th>
                        <th>Mulai</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th id="chbAksiHeader">Aksi</th>
                    </tr>
                </thead>
                <tbody id="chbClientTableBody">
                    {{-- Diisi JavaScript --}}
                </tbody>
            </table>
            <!-- Area Pagination (Halaman) -->
            <div id="clientPagination" class="pagination-container"></div>
        </div>
    </div>

    {{-- ===================== MODAL: TAMBAH / EDIT (FULLSCREEN) ===================== --}}
    <div class="chb-modal-overlay overlay-full" id="chbFormModalOverlay">
        <div class="chb-modal modal-full">
            <div class="modal-full-header">
                <div>
                    <h3 id="chbFormModalTitle">Tambah Data Client</h3>
                    <div class="modal-subtitle">Lengkapi data pokok di kiri, tulis deskripsi project di kanan.</div>
                </div>
            </div>

            <form id="chbClientForm" onsubmit="chbProcessFormSubmit(event)">
                <input type="hidden" id="chbClientId">

                <div class="modal-full-body">
                    <div class="form-split">
                        {{-- ---------- KOLOM KIRI: data pokok bertumpuk ---------- --}}
                        <div class="form-col-left">
                            <div class="form-group field-card">
                                <label>NAMA CLIENT</label>
                                <input type="text" id="chbNamaClient" placeholder="Contoh: PT Astabrata" required>
                            </div>
                            <div class="form-group field-card">
                                <label>NAMA PROJECT</label>
                                <input type="text" id="chbNamaProject" placeholder="Contoh: Website Redesign" required>
                            </div>
                            <div class="form-group field-card">
                                <label>TANGGAL MULAI</label>
                                <input type="date" id="chbTanggalAwal" required>
                            </div>
                            <div class="form-group field-card">
                                <label>DEADLINE PROJECT</label>
                                <input type="date" id="chbDeadline" required>
                            </div>
                        </div>

                        {{-- ---------- KOLOM KANAN: WYSIWYG editor ---------- --}}
                        <div class="form-col-right">
                            <div class="form-group">
                                <label>DESKRIPSI LENGKAP</label>
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
                                        <div class="editor-content" id="chbDeskripsiEditor" contenteditable="true"
                                             data-placeholder="Tulis deskripsi / catatan detail project di sini... (gambar bisa disisipkan lewat tombol gambar atau paste langsung)"></div>

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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="chbCloseFormModal()">Batal</button>
                    <button type="submit" class="btn-save"><i class='bx bx-save'></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL: DETAIL CLIENT ===================== --}}
    <div class="chb-modal-overlay" id="chbDetailModalOverlay">
        <div class="chb-modal">
            <h3 style="margin-bottom: 24px;">Informasi Lengkap Client</h3>
            <div class="detail-grid" id="chbDetailContent">
                {{-- Diisi JS --}}
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="chbCloseDetailModal()">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL: KONFIRMASI SIMPAN/EDIT ===================== --}}
    <div class="modal-overlay" id="saveConfirmModal">
        <div class="modal-box modal-confirm">
            <div class="confirm-icon success"><i class='bx bx-save'></i></div>
            <h2 id="saveConfirmTitle">Simpan Perubahan?</h2>
            <p id="saveConfirmText">Yakin ingin menyimpan data ini?</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeSaveConfirmModal()">Batal</button>
                <button type="button" class="btn-save" id="btnConfirmSave" onclick="executeSaveClient()">Ya, Edit dan Simpan</button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL: KONFIRMASI HAPUS ===================== --}}
    <div class="modal-overlay" id="deleteConfirmModal">
        <div class="modal-box modal-confirm">
            <div class="confirm-icon"><i class='bx bx-trash'></i></div>
            <h2 id="deleteConfirmTitle">Hapus Client?</h2>
            <p id="deleteConfirmText">Yakin ingin menghapus client ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnCancelDelete">Batal</button>
                <button type="button" class="btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL: KONFIRMASI EXPORT SAAT DATA KOSONG ===================== --}}
    <div class="modal-overlay" id="exportEmptyModal">
        <div class="modal-box modal-confirm">
            <div class="confirm-icon"><i class='bx bx-error'></i></div>
            <h2>Data Masih Kosong</h2>
            <p>Belum ada data client sama sekali, jadi belum ada yang bisa diexport.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="btnCancelExportEmpty">Tutup</button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL: NOTIFIKASI SUKSES (TAMBAH / EDIT / HAPUS / IMPORT) ===================== --}}
    <div class="modal-overlay" id="successModal">
        <div class="modal-box modal-confirm">
            <div class="confirm-icon success"><i class='bx bx-check-circle'></i></div>
            <h2>Berhasil!</h2>
            <p id="successModalText">Data berhasil diproses.</p>
            <div class="modal-actions">
                <button type="button" class="btn-save" onclick="closeSuccessModal()">OK</button>
            </div>
        </div>
    </div>

    {{-- ===================== MODAL: IMPORT EXCEL ===================== --}}
    <div class="modal-overlay" id="importModal">
        <div class="modal-box modal-import">
            <form action="{{ route('admin.kelola-proyek.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                @csrf
                <div class="import-head">
                    <div class="import-icon"><i class='bx bxs-file-import'></i></div>
                    <div>
                        <h2>Import data client</h2>
                        <p class="import-sub">Tambahkan banyak client dan project sekaligus dari file Excel.</p>
                    </div>
                </div>

                <ol class="import-steps">
                    <li>Unduh template lalu isi datanya.
                        <a class="import-link" href="{{ route('admin.kelola-proyek.template') }}"><i class='bx bx-download'></i>Unduh template</a>
                    </li>
                    <li>Nama Client, Nama Project, Tanggal Mulai, dan Deadline wajib diisi.</li>
                    <li>Pilih file yang sudah diisi di bawah ini.</li>
                </ol>

                <label class="import-drop" id="importDrop" for="importFile">
                    <i class='bx bx-cloud-upload'></i>
                    <strong id="importFileName">Klik untuk memilih file, atau seret ke sini</strong>
                    <small id="importFileHint">.xlsx, .xls, atau .csv, maksimal 5 MB</small>
                </label>
                <input type="file" name="file" id="importFile" accept=".xlsx,.xls,.csv" hidden>
                <p class="import-msg" id="importMsg" role="alert"></p>
                <p class="import-note">Data yang sama dengan yang sudah ada (Nama Client, Nama Project, dan Tanggal Mulai sama) akan dilewati, jadi file boleh diunggah ulang dengan aman.</p>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeImportModal()">Batal</button>
                    <button type="submit" class="btn-save" id="importSubmitBtn" disabled>Import data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===================== MODAL: HASIL IMPORT (file bermasalah, atau ada baris dilewati / gagal) ===================== --}}
    @if(session('import_report'))
        @php
            $importReport     = session('import_report');
            $importFatal      = $importReport['fatal'] ?? null;
            $importErrors     = $importReport['errors'] ?? [];
            $importErrorTotal = $importReport['error_total'] ?? count($importErrors);
            $importInserted   = $importReport['inserted'] ?? 0;
            $importSkipped    = $importReport['skipped'] ?? 0;
        @endphp
        <div class="modal-overlay show" id="importResultModal">
            <div class="modal-box modal-confirm modal-result">
                <div class="confirm-icon {{ $importFatal ? '' : 'warn' }}">
                    <i class='bx {{ $importFatal ? 'bx-error-circle' : 'bx-info-circle' }}'></i>
                </div>

                @if($importFatal)
                    <h2>Import gagal</h2>
                    <p>{{ $importFatal }}</p>
                @else
                    <h2>{{ $importInserted > 0 ? 'Import selesai' : 'Tidak ada data baru yang ditambahkan' }}</h2>

                    <div class="result-stats">
                        <div class="stat ok"><b>{{ $importInserted }}</b><span>Ditambahkan</span></div>
                        <div class="stat skip"><b>{{ $importSkipped }}</b><span>Dilewati (sudah ada)</span></div>
                        <div class="stat bad"><b>{{ $importErrorTotal }}</b><span>Perlu diperbaiki</span></div>
                    </div>

                    @if(count($importErrors))
                        <ul class="result-errors">
                            @foreach($importErrors as $err)
                                <li><b>Baris {{ $err['row'] }}</b><span>{{ $err['message'] }}</span></li>
                            @endforeach
                        </ul>
                        @if($importErrorTotal > count($importErrors))
                            <p class="result-hint">Menampilkan {{ count($importErrors) }} dari {{ $importErrorTotal }} baris bermasalah.</p>
                        @endif
                        <p class="result-hint">Perbaiki baris di atas lalu unggah file yang sama lagi. Data yang sudah masuk tidak akan terduplikasi.</p>
                    @endif
                @endif

                <div class="modal-actions">
                    <button type="button" class="btn-save" onclick="closeImportResultModal()">OK</button>
                </div>
            </div>
        </div>
        <script>
            function closeImportResultModal() {
                document.getElementById('importResultModal').classList.remove('show');
            }
            document.getElementById('importResultModal').addEventListener('click', function (e) {
                if (e.target === this) closeImportResultModal();
            });
        </script>
    @endif

    {{-- Memunculkan modal success jika ada session 'success' dari controller (misal setelah Import berhasil penuh) --}}
    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('successModalText').textContent = @json(session('success'));
                document.getElementById('successModal').classList.add('show');
            });
        </script>
    @endif

    {{-- ===================== GLOBAL LIGHTBOX ZOOM ===================== --}}
    <div id="dbLightbox" class="db-lightbox">
        <span class="db-lightbox-close" onclick="closeDbLightbox()" title="Tutup">&times;</span>
        <button class="db-lightbox-btn prev" onclick="slideDbLightbox(-1)" title="Sebelumnya">&#10094;</button>
        <button class="db-lightbox-btn next" onclick="slideDbLightbox(1)" title="Selanjutnya">&#10095;</button>
        <div class="db-lightbox-content" id="dbLightboxContentWrapper">
            <img id="dbLightboxImg" src="" alt="Zoomed Image">
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const CHB_CSRF = document.querySelector('meta[name="csrf-token"]').content;
    let chbClients = [];

    // State Filter, Pencarian, & Pagination
    let chbSearchQuery = '';
    let chbFilterStatus = '';
    let chbLimit = 'semua';
    let chbCurrentPage = 1;

    // State pilihan checkbox untuk Hapus Terpilih / Hapus Semua
    let chbSelectedIds = new Set();
    let chbSelectMode = false; // true = kolom Aksi berubah jadi kolom checkbox

    let lbImagesArr = [];
    let lbCurrentIndex = 0;

    /* State editor gambar */
    let chbSelectedImg = null;
    let chbSavedRange = null;
    let chbResizeState = null;

    /* State pending action (Simpan/Edit) */
    let pendingSavePayload = null;
    let pendingSaveUrl = '';
    let pendingSaveMethod = '';

    document.addEventListener('DOMContentLoaded', async function () {
        await chbFetchClients();
        initLightboxEvents();
        initEditorImageEvents();
        initSidebarOffset();
        initTableFilters();
        initImportModal();
        chbOpenHighlightFromUrl();
    });

    /* ============================================================
       Buka otomatis detail proyek saat halaman ini diakses dari klik
       notifikasi lonceng di halaman lain, mis: /admin/kelola-proyek?highlight=5
       ============================================================ */
    function chbOpenHighlightFromUrl() {
        const params = new URLSearchParams(window.location.search);
        const highlightId = parseInt(params.get('highlight'), 10);
        if (!highlightId) return;

        chbOpenDetailModal(highlightId);

        // Bersihkan parameter dari URL supaya tidak terbuka lagi saat refresh
        params.delete('highlight');
        const sisaQuery = params.toString();
        window.history.replaceState({}, '', window.location.pathname + (sisaQuery ? '?' + sisaQuery : ''));
    }

    /* ============================================================
       FUNGSI PENCARIAN & FILTER TABEL
       ============================================================ */
    function initTableFilters() {
        document.getElementById('clientSearch').addEventListener('input', function(e) {
            chbSearchQuery = e.target.value;
            chbCurrentPage = 1; 
            chbRenderTable();
        });

        document.getElementById('clientFilterStatus').addEventListener('change', function(e) {
            chbFilterStatus = e.target.value;
            chbCurrentPage = 1; 
            chbRenderTable();
        });

        document.getElementById('clientLimit').addEventListener('change', function(e) {
            chbLimit = e.target.value;
            chbCurrentPage = 1; 
            chbRenderTable();
        });
    }

    /* ============================================================
       PERBARUI DATA STATISTIK PADA KARTU (BOX INFO)
       ============================================================ */
    function chbUpdateStats() {
        const totalClient = chbClients.length;
        let projectAktif = 0;
        let lewatDeadline = 0;

        const hariIni = new Date();
        hariIni.setHours(0, 0, 0, 0); 

        chbClients.forEach(client => {
            if (client.deadline) {
                const deadlineDate = new Date(client.deadline + 'T00:00:00');
                deadlineDate.setHours(0, 0, 0, 0);
                
                if (deadlineDate >= hariIni) {
                    projectAktif++;
                } else {
                    lewatDeadline++;
                }
            } else {
                projectAktif++;
            }
        });

        document.getElementById('statTotalClient').textContent = totalClient;
        document.getElementById('statProjectAktif').textContent = projectAktif;
        document.getElementById('statLewatDeadline').textContent = lewatDeadline;
    }

    function chbSyncSidebarOffset() {
        const sidebar = document.getElementById('sidebar') || document.querySelector('#sidebar, .sidebar, aside');
        let w = 0;

        if (sidebar && window.innerWidth > 768) {
            const style = window.getComputedStyle(sidebar);
            const fixed = style.position === 'fixed' || style.position === 'absolute';
            if (fixed && style.display !== 'none' && style.visibility !== 'hidden') {
                w = sidebar.getBoundingClientRect().width;
            }
        }
        document.documentElement.style.setProperty('--chb-sidebar-w', Math.round(w) + 'px');
    }

    function initSidebarOffset() {
        chbSyncSidebarOffset();
        window.addEventListener('resize', chbSyncSidebarOffset);
        const sidebar = document.getElementById('sidebar') || document.querySelector('#sidebar, .sidebar, aside');
        if (sidebar && window.MutationObserver) {
            new MutationObserver(() => setTimeout(chbSyncSidebarOffset, 320))
                .observe(sidebar, { attributes: true, attributeFilter: ['class', 'style'] });
        }
        setTimeout(chbSyncSidebarOffset, 400);
    }

    /* ============================================================
       EDITOR TEKS
       ============================================================ */
    function formatDoc(cmd, value = null) {
        const editor = document.getElementById('chbDeskripsiEditor');
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
            if (document.getElementById('chbDeskripsiEditor').contains(r.commonAncestorContainer)) {
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
                alert(`Gambar "${file.name}" melebihi 3MB dan dilewati.`); return;
            }
            const reader = new FileReader();
            reader.onload = ev => insertImageToEditor(ev.target.result);
            reader.readAsDataURL(file);
        });
        e.target.value = '';
    }
    function insertImageToEditor(dataUrl) {
        const editor = document.getElementById('chbDeskripsiEditor');
        editor.focus();
        restoreRange();
        const html = `<img src="${dataUrl}" class="chb-img" style="width:60%;height:auto;display:block;margin:10px 0;border-radius:6px;"><p><br></p>`;
        document.execCommand('insertHTML', false, html);
        saveRange();
    }
    function initEditorImageEvents() {
        const editor = document.getElementById('chbDeskripsiEditor');
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
            if (e.target.tagName === 'IMG') selectEditorImage(e.target);
            else { deselectEditorImage(); saveRange(); }
        });
        editor.addEventListener('keyup', saveRange);
        editor.addEventListener('mouseup', saveRange);
        editor.addEventListener('scroll', () => { if (chbSelectedImg) positionImgUI(); });
        editor.addEventListener('input', () => {
            if (chbSelectedImg && !editor.contains(chbSelectedImg)) deselectEditorImage();
        });
        document.addEventListener('keydown', function (e) {
            if (!chbSelectedImg) return;
            if (e.key === 'Delete' || e.key === 'Backspace') { e.preventDefault(); deleteSelectedImg(); }
            if (e.key === 'Escape') deselectEditorImage();
        });
        frame.querySelectorAll('.handle').forEach(h => { h.addEventListener('mousedown', startResize); });
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
        chbSelectedImg = img; img.classList.add('is-selected');
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
        frame.style.left = left + 'px'; frame.style.top = top + 'px'; frame.style.width = iRect.width + 'px'; frame.style.height = iRect.height + 'px';
        const tbHeight = toolbar.offsetHeight || 40;
        let tbTop = top - tbHeight - 8; if (tbTop < 4) tbTop = top + iRect.height + 8;
        toolbar.style.top = tbTop + 'px';
        let tbLeft = left; const maxLeft = canvas.offsetWidth - (toolbar.offsetWidth || 320) - 8;
        if (tbLeft > maxLeft) tbLeft = Math.max(4, maxLeft); if (tbLeft < 4) tbLeft = 4;
        toolbar.style.left = tbLeft + 'px';
        const visible = iRect.bottom > cRect.top + 4 && iRect.top < cRect.bottom - 4;
        frame.style.visibility = visible ? 'visible' : 'hidden'; toolbar.style.visibility = visible ? 'visible' : 'hidden';
    }
    function setImgWidth(w) { if (!chbSelectedImg) return; chbSelectedImg.style.width = w; chbSelectedImg.style.height = 'auto'; setTimeout(positionImgUI, 30); }
    function resetImgSize() { if (!chbSelectedImg) return; chbSelectedImg.style.width = ''; chbSelectedImg.style.height = ''; chbSelectedImg.style.maxWidth = '100%'; setTimeout(positionImgUI, 30); }
    function setImgAlign(pos) {
        if (!chbSelectedImg) return; const img = chbSelectedImg; img.style.float = 'none'; img.style.display = 'block'; img.style.margin = '10px 0';
        if (pos === 'center') { img.style.margin = '10px auto'; } else if (pos === 'left') { img.style.float = 'left'; img.style.display = 'inline'; img.style.margin = '6px 16px 10px 0'; } else if (pos === 'right') { img.style.float = 'right'; img.style.display = 'inline'; img.style.margin = '6px 0 10px 16px'; }
        setTimeout(positionImgUI, 30);
    }
    function deleteSelectedImg() { if (!chbSelectedImg) return; const img = chbSelectedImg; deselectEditorImage(); img.remove(); document.getElementById('chbDeskripsiEditor').focus(); }
    function startResize(e) {
        if (!chbSelectedImg) return; e.preventDefault(); e.stopPropagation(); const rect = chbSelectedImg.getBoundingClientRect();
        chbResizeState = { dir: e.currentTarget.dataset.dir, startX: e.clientX, startW: rect.width, ratio: rect.height / rect.width };
        document.body.style.userSelect = 'none'; document.getElementById('chbImgSizeBadge').classList.add('active');
    }
    function doResize(e) {
        if (!chbResizeState || !chbSelectedImg) return; const dx = e.clientX - chbResizeState.startX; const grow = (chbResizeState.dir === 'tl' || chbResizeState.dir === 'bl' || chbResizeState.dir === 'ml') ? -1 : 1; let newW = chbResizeState.startW + (dx * grow);
        const maxW = document.getElementById('chbDeskripsiEditor').clientWidth - 40; if (newW < 60) newW = 60; if (newW > maxW) newW = maxW;
        chbSelectedImg.style.width = Math.round(newW) + 'px'; chbSelectedImg.style.height = 'auto';
        const badge = document.getElementById('chbImgSizeBadge'); badge.textContent = `${Math.round(newW)} × ${Math.round(newW * chbResizeState.ratio)} px`;
        const canvas = document.getElementById('chbEditorCanvas'); const cRect = canvas.getBoundingClientRect(); const iRect = chbSelectedImg.getBoundingClientRect();
        badge.style.left = (iRect.left - cRect.left) + 'px'; badge.style.top = (iRect.top - cRect.top + iRect.height + 8) + 'px';
        positionImgUI();
    }
    function stopResize() { if (!chbResizeState) return; chbResizeState = null; document.body.style.userSelect = ''; setTimeout(() => document.getElementById('chbImgSizeBadge').classList.remove('active'), 600); positionImgUI(); }

    /* ============================================================
       MODE PILIH: kolom "Aksi" berubah jadi kolom checkbox
       ============================================================ */
    function chbToggleSelectMode() {
        chbSelectMode = !chbSelectMode;
        chbSelectedIds.clear();
        chbUpdateAksiHeader();
        chbRenderTable();
    }

    function chbUpdateAksiHeader() {
        const th = document.getElementById('chbAksiHeader');
        const toggleBtn = document.getElementById('btnToggleSelectMode');
        const toggleBtnText = document.getElementById('btnToggleSelectModeText');
        const bulkGroup = document.getElementById('bulkActionsGroup');

        if (chbSelectMode) {
            th.innerHTML = `<input type="checkbox" id="chbSelectAll" title="Pilih semua di halaman ini" onclick="chbToggleSelectAllOnPage(this.checked)"><span class="chb-select-label">Pilih</span>`;
            th.classList.add('select-mode-header');
            toggleBtn.classList.add('active');
            toggleBtnText.textContent = 'Batal Pilih';
            bulkGroup.classList.add('show');
        } else {
            th.textContent = 'Aksi';
            th.classList.remove('select-mode-header');
            toggleBtn.classList.remove('active');
            toggleBtnText.textContent = 'Hapus';
            bulkGroup.classList.remove('show');
        }
    }

    function chbToggleRowSelect(id, checked) {
        if (checked) chbSelectedIds.add(id);
        else chbSelectedIds.delete(id);

        const row = document.querySelector(`.chb-row-checkbox[value="${id}"]`)?.closest('tr');
        if (row) row.classList.toggle('row-selected', checked);

        chbSyncSelectAllCheckbox();
        chbUpdateBulkToolbar();
    }

    function chbToggleSelectAllOnPage(checked) {
        document.querySelectorAll('.chb-row-checkbox').forEach(cb => {
            const id = parseInt(cb.value, 10);
            cb.checked = checked;
            cb.closest('tr')?.classList.toggle('row-selected', checked);
            if (checked) chbSelectedIds.add(id);
            else chbSelectedIds.delete(id);
        });
        chbUpdateBulkToolbar();
    }

    function chbSyncSelectAllCheckbox() {
        const selectAll = document.getElementById('chbSelectAll');
        if (!selectAll) return; // hanya ada saat mode pilih aktif
        const boxes = document.querySelectorAll('.chb-row-checkbox');
        if (!boxes.length) { selectAll.checked = false; selectAll.indeterminate = false; return; }
        const checkedCount = Array.from(boxes).filter(cb => cb.checked).length;
        selectAll.checked = checkedCount === boxes.length;
        selectAll.indeterminate = checkedCount > 0 && checkedCount < boxes.length;
    }

    function chbUpdateBulkToolbar() {
        const count = chbSelectedIds.size;
        document.getElementById('bulkDeleteCount').textContent = count;
        document.getElementById('btnBulkDelete').disabled = count === 0;
    }

    /* ============================================================
       CRUD CLIENT
       ============================================================ */
    async function chbFetchClients() {
        try {
            const res = await fetch('/admin/clients');
            chbClients = await res.json();
            chbRenderTable();
            chbUpdateStats();
        } catch (err) { console.error(err); }
    }

    /* ============================================================
       Notifikasi lonceng (fetch data, hitung H-1/lewat, render list)
       sekarang ditangani secara GLOBAL di admin.layouts.app supaya
       tampil di semua halaman, bukan cuma di Kelola Proyek.
       Lihat: globalLoadNotifications() & globalGoToProjectNotif().

       Halaman ini hanya perlu tahu cara MEMBUKA detail proyek saat
       diarahkan dari notifikasi (lihat chbOpenHighlightFromUrl di bawah).
       ============================================================ */
    function chbFormatDate(dateStr) {
        if (!dateStr) return '-'; const d = new Date(dateStr + 'T00:00:00'); if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }
    function chbTruncate(text, max) {
        if (!text) return ''; const cleanText = text.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
        return cleanText.length > max ? cleanText.substring(0, max) + '...' : cleanText;
    }
    function chbEscape(str) { const div = document.createElement('div'); div.textContent = str == null ? '' : str; return div.innerHTML; }

    function chbRenderTable() {
        const tbody = document.getElementById('chbClientTableBody');
        tbody.innerHTML = '';
        
        const hariIni = new Date();
        hariIni.setHours(0, 0, 0, 0);

        let filtered = chbClients.filter(client => {
            const query = chbSearchQuery.toLowerCase();
            const matchSearch = client.nama.toLowerCase().includes(query) || client.project.toLowerCase().includes(query);
            
            let status = 'aktif';
            if (client.deadline) {
                const deadlineDate = new Date(client.deadline + 'T00:00:00');
                deadlineDate.setHours(0, 0, 0, 0);
                if (deadlineDate < hariIni) status = 'lewat';
            }
            const matchStatus = (chbFilterStatus === '') || (chbFilterStatus === status);

            return matchSearch && matchStatus;
        });

        let limit = chbLimit === 'semua' ? filtered.length : parseInt(chbLimit);
        if (limit === 0 || isNaN(limit)) limit = 1; 

        const totalPages = Math.ceil(filtered.length / limit);
        if (chbCurrentPage > totalPages) chbCurrentPage = totalPages || 1;

        const startIndex = (chbCurrentPage - 1) * limit;
        const endIndex = startIndex + limit;
        
        const paginatedData = filtered.slice(startIndex, endIndex);

        if (paginatedData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding:30px;">Data tidak ditemukan.</td></tr>';
            renderPagination(0, 1);
            chbSyncSelectAllCheckbox();
            chbUpdateBulkToolbar();
            return;
        }

        paginatedData.forEach((client, index) => {
            const actualIndex = startIndex + index + 1; 
            
            // CEK STATUS DEADLINE UNTUK INDIKATOR VISUAL
            let isLewat = false;
            let isH1 = false;
            if (client.deadline) {
                const dDate = new Date(client.deadline + 'T00:00:00');
                dDate.setHours(0, 0, 0, 0);
                const diffHari = Math.round((dDate - hariIni) / 86400000);
                if (diffHari < 0) isLewat = true;
                else if (diffHari === 1) isH1 = true;
            }

            // Tentukan Class Border Kiri dan Tampilan Teks Deadline
            let borderClass = 'status-aktif';
            let deadlineHtml = chbFormatDate(client.deadline);
            let badgeHtml = `<span class="badge-aktif">Berjalan</span>`;

            if (isLewat) {
                borderClass = 'status-lewat';
                deadlineHtml = `<span style="color: #ef4444; font-weight: 600;">${deadlineHtml}</span>`;
                badgeHtml = `<span class="badge-lewat">Lewat Deadline</span>`;
            } else if (isH1) {
                borderClass = 'status-h1';
                deadlineHtml = `<span style="color: #ca8a04; font-weight: 600;">${deadlineHtml}</span>`;
                badgeHtml = `<span class="badge-h1">H-1 Deadline</span>`;
            }

            const isChecked = chbSelectedIds.has(client.id);

            const aksiCellHtml = chbSelectMode
                ? `<td class="action-cell select-cell"><input type="checkbox" class="chb-row-checkbox" value="${client.id}" ${isChecked ? 'checked' : ''} onchange="chbToggleRowSelect(${client.id}, this.checked)"></td>`
                : `<td class="action-cell">
                    <button class="btn-detail" onclick="chbOpenDetailModal(${client.id})">Detail</button>
                    <button class="btn-edit" onclick="chbOpenEditModal(${client.id})">Edit</button>
                   </td>`;

            const tr = document.createElement('tr');
            if (chbSelectMode && isChecked) tr.classList.add('row-selected');
            tr.innerHTML = `
                <td class="${borderClass}"><b>${actualIndex}</b></td>
                <td><strong>${chbEscape(client.nama)}</strong></td>
                <td>${chbEscape(client.project)}</td>
                <td class="desc-cell">${chbEscape(chbTruncate(client.deskripsi, 32))}</td>
                <td>${chbFormatDate(client.tanggal_awal)}</td>
                <td>${deadlineHtml}</td>
                <td>${badgeHtml}</td>
                ${aksiCellHtml}
            `;
            tbody.appendChild(tr);
        });

        renderPagination(totalPages, chbCurrentPage);
        chbSyncSelectAllCheckbox();
        chbUpdateBulkToolbar();
    }

    function renderPagination(totalPages, currentPage) {
        const container = document.getElementById('clientPagination');
        container.innerHTML = '';

        if (totalPages <= 1) return; 

        const prevBtn = document.createElement('button');
        prevBtn.innerHTML = "<i class='bx bx-chevron-left'></i>";
        prevBtn.title = "Halaman Sebelumnya";
        prevBtn.disabled = currentPage === 1;
        prevBtn.onclick = () => {
            if (chbCurrentPage > 1) {
                chbCurrentPage--;
                chbRenderTable();
            }
        };
        container.appendChild(prevBtn);

        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.innerText = i;
            if (i === currentPage) pageBtn.classList.add('active');
            pageBtn.onclick = () => {
                chbCurrentPage = i;
                chbRenderTable();
            };
            container.appendChild(pageBtn);
        }

        const nextBtn = document.createElement('button');
        nextBtn.innerHTML = "<i class='bx bx-chevron-right'></i>";
        nextBtn.title = "Halaman Selanjutnya";
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.onclick = () => {
            if (chbCurrentPage < totalPages) {
                chbCurrentPage++;
                chbRenderTable();
            }
        };
        container.appendChild(nextBtn);
    }

    function chbOpenAddModal() {
        document.getElementById('chbFormModalTitle').textContent = 'Tambah Data Client';
        document.getElementById('chbClientForm').reset();
        document.getElementById('chbClientId').value = '';
        document.getElementById('chbDeskripsiEditor').innerHTML = '';
        deselectEditorImage();
        chbSavedRange = null;
        chbSyncSidebarOffset();
        document.getElementById('chbFormModalOverlay').classList.add('show');
        setTimeout(() => document.getElementById('chbNamaClient').focus(), 150);
    }

    function chbOpenEditModal(id) {
        const client = chbClients.find(c => c.id === id);
        if (!client) return;
        document.getElementById('chbFormModalTitle').textContent = 'Edit Data Client';
        document.getElementById('chbClientId').value = client.id;
        document.getElementById('chbNamaClient').value = client.nama;
        document.getElementById('chbNamaProject').value = client.project;
        document.getElementById('chbDeskripsiEditor').innerHTML = client.deskripsi || '';
        document.getElementById('chbTanggalAwal').value = client.tanggal_awal;
        document.getElementById('chbDeadline').value = client.deadline;
        deselectEditorImage();
        chbSavedRange = null;
        chbSyncSidebarOffset();
        document.getElementById('chbFormModalOverlay').classList.add('show');
    }

    function chbCloseFormModal() { 
        deselectEditorImage(); 
        document.getElementById('chbFormModalOverlay').classList.remove('show'); 
    }

    /* ============================================================
       MODAL KONFIRMASI SIMPAN / EDIT & SUCCESS
       ============================================================ */
    function chbProcessFormSubmit(event) {
        event.preventDefault(); 
        deselectEditorImage();
        
        const id = document.getElementById('chbClientId').value;
        
        pendingSavePayload = {
            nama: document.getElementById('chbNamaClient').value.trim(), 
            project: document.getElementById('chbNamaProject').value.trim(),
            deskripsi: document.getElementById('chbDeskripsiEditor').innerHTML.trim(), 
            tanggal_awal: document.getElementById('chbTanggalAwal').value, 
            deadline: document.getElementById('chbDeadline').value
        };
        pendingSaveUrl = id ? `/admin/clients/${id}` : '/admin/clients'; 
        pendingSaveMethod = id ? 'PUT' : 'POST';

        if(id) {
            document.getElementById('saveConfirmTitle').textContent = 'Edit Data?';
            document.getElementById('saveConfirmText').textContent = 'Yakin ingin menyimpan perubahan pada data client ini?';
            document.getElementById('btnConfirmSave').textContent = 'Ya, Edit dan Simpan';
        } else {
            document.getElementById('saveConfirmTitle').textContent = 'Simpan Data?';
            document.getElementById('saveConfirmText').textContent = 'Yakin ingin menyimpan data client baru ini?';
            document.getElementById('btnConfirmSave').textContent = 'Ya, Simpan';
        }

        document.getElementById('saveConfirmModal').classList.add('show');
    }

    function closeSaveConfirmModal() {
        document.getElementById('saveConfirmModal').classList.remove('show');
    }

    async function executeSaveClient() {
        const btnConfirm = document.getElementById('btnConfirmSave');
        const originalText = btnConfirm.innerHTML;
        btnConfirm.innerHTML = 'Menyimpan...';
        btnConfirm.disabled = true;

        try {
            const res = await fetch(pendingSaveUrl, { 
                method: pendingSaveMethod, 
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CHB_CSRF, 'Accept': 'application/json' }, 
                body: JSON.stringify(pendingSavePayload) 
            });
            
            if (!res.ok) { 
                alert('Gagal menyimpan. Cek form atau koneksi server.'); 
                return; 
            }
            
            await chbFetchClients(); 
            chbCloseFormModal();
            closeSaveConfirmModal();

            const isEdit = pendingSaveMethod === 'PUT';
            document.getElementById('successModalText').textContent = isEdit ? 'Data client berhasil diedit dan disimpan.' : 'Data client baru berhasil ditambahkan.';
            document.getElementById('successModal').classList.add('show');

        } catch (err) { 
            alert('Terjadi kesalahan saat menyimpan data.'); 
        } finally {
            btnConfirm.innerHTML = originalText;
            btnConfirm.disabled = false;
        }
    }

    function closeSuccessModal() {
        document.getElementById('successModal').classList.remove('show');
    }

    /* ============================================================
       MODAL KONFIRMASI HAPUS
       ============================================================ */
    const deleteConfirmModal = document.getElementById('deleteConfirmModal');
    const btnCancelDelete = document.getElementById('btnCancelDelete');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    let chbIdToDelete = null;
    let chbDeleteMode = 'single'; // 'single' | 'bulk' | 'all'

    function chbOpenDeleteConfirm(title, text) {
        document.getElementById('deleteConfirmTitle').textContent = title;
        document.getElementById('deleteConfirmText').textContent = text;
        deleteConfirmModal.classList.add('show');
    }

    // Hapus satu data (tombol "Hapus" per baris)
    function chbDeleteClient(id) {
        chbDeleteMode = 'single';
        chbIdToDelete = id;
        chbOpenDeleteConfirm('Hapus Client?', 'Yakin ingin menghapus client ini? Data yang sudah dihapus tidak dapat dikembalikan.');
    }

    // Hapus semua data yang dicentang (tombol "Hapus Terpilih")
    function chbBulkDeleteSelected() {
        if (chbSelectedIds.size === 0) return;
        chbDeleteMode = 'bulk';
        chbOpenDeleteConfirm(
            'Hapus Data Terpilih?',
            `Yakin ingin menghapus ${chbSelectedIds.size} data client yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.`
        );
    }

    btnCancelDelete.addEventListener('click', function () {
        chbIdToDelete = null;
        chbDeleteMode = 'single';
        deleteConfirmModal.classList.remove('show');
    });

    btnConfirmDelete.addEventListener('click', async function () {
        if (chbDeleteMode === 'single' && !chbIdToDelete) return;
        if (chbDeleteMode === 'bulk' && chbSelectedIds.size === 0) return;
        if (chbDeleteMode === 'all' && chbClients.length === 0) return;

        const originalText = btnConfirmDelete.innerHTML;
        btnConfirmDelete.innerHTML = 'Menghapus...';
        btnConfirmDelete.disabled = true;

        try {
            let res;

            if (chbDeleteMode === 'single') {
                res = await fetch(`/admin/clients/${chbIdToDelete}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CHB_CSRF }
                });
            } else if (chbDeleteMode === 'bulk') {
                res = await fetch(`/admin/clients/bulk-delete`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CHB_CSRF, 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: Array.from(chbSelectedIds) })
                });
            } else if (chbDeleteMode === 'all') {
                res = await fetch(`/admin/clients/delete-all`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CHB_CSRF }
                });
            }

            if (res.ok) {
                if (chbDeleteMode === 'bulk' || chbDeleteMode === 'all') {
                    chbSelectedIds.clear();
                    if (chbSelectMode) { chbSelectMode = false; chbUpdateAksiHeader(); }
                }

                await chbFetchClients();
                deleteConfirmModal.classList.remove('show');

                let successText = 'Data client berhasil dihapus selamanya.';
                if (chbDeleteMode === 'bulk') successText = 'Data client yang dipilih berhasil dihapus.';
                if (chbDeleteMode === 'all') successText = 'Semua data client berhasil dihapus.';

                document.getElementById('successModalText').textContent = successText;
                document.getElementById('successModal').classList.add('show');
            } else {
                alert('Gagal menghapus data.');
            }
        } catch (err) {
            console.error(err);
            alert('Terjadi kesalahan saat menghapus data.');
        } finally {
            btnConfirmDelete.innerHTML = originalText;
            btnConfirmDelete.disabled = false;
            chbIdToDelete = null;
            chbDeleteMode = 'single';
        }
    });

    /* Klik area gelap di luar kotak = tutup popup (sama seperti Kelola Layanan) */
    deleteConfirmModal.addEventListener('click', function (e) {
        if (e.target === deleteConfirmModal && !btnConfirmDelete.disabled) {
            chbIdToDelete = null;
            chbDeleteMode = 'single';
            deleteConfirmModal.classList.remove('show');
        }
    });

    const chbSaveConfirmModal = document.getElementById('saveConfirmModal');
    chbSaveConfirmModal.addEventListener('click', function (e) {
        if (e.target === chbSaveConfirmModal && !document.getElementById('btnConfirmSave').disabled) {
            closeSaveConfirmModal();
        }
    });

    const chbSuccessModal = document.getElementById('successModal');
    chbSuccessModal.addEventListener('click', function (e) {
        if (e.target === chbSuccessModal) closeSuccessModal();
    });

    /* ============================================================
       EXPORT: konfirmasi dulu kalau data masih kosong
       ============================================================ */
    const exportEmptyModal = document.getElementById('exportEmptyModal');
    const btnCancelExportEmpty = document.getElementById('btnCancelExportEmpty');

    function chbHandleExportClick(e, url) {
        if (chbClients.length === 0) {
            e.preventDefault();
            exportEmptyModal.classList.add('show');
            return false;
        }
        return true; // data ada, lanjutkan link download seperti biasa
    }

    btnCancelExportEmpty.addEventListener('click', function () {
        exportEmptyModal.classList.remove('show');
    });

    exportEmptyModal.addEventListener('click', function (e) {
        if (e.target === exportEmptyModal) {
            exportEmptyModal.classList.remove('show');
        }
    });

    /* ============================================================
       IMPORT EXCEL (popup unggah file)
       ============================================================ */
    const IMPORT_MAX_BYTES = 5 * 1024 * 1024;
    const IMPORT_EXT = ['xlsx', 'xls', 'csv'];
    const IMPORT_DEFAULT_LABEL = 'Klik untuk memilih file, atau seret ke sini';

    function openImportModal() {
        resetImportModal();
        document.getElementById('importModal').classList.add('show');
    }

    function closeImportModal() {
        if (document.getElementById('importSubmitBtn').dataset.busy === '1') return;
        document.getElementById('importModal').classList.remove('show');
    }

    function resetImportModal() {
        document.getElementById('importFile').value = '';
        document.getElementById('importDrop').classList.remove('has-file', 'is-over');
        document.getElementById('importFileName').textContent = IMPORT_DEFAULT_LABEL;
        document.getElementById('importFileHint').style.display = '';
        document.getElementById('importMsg').textContent = '';
        document.getElementById('importSubmitBtn').disabled = true;
    }

    function initImportModal() {
        const modal = document.getElementById('importModal');
        const form  = document.getElementById('importForm');
        const input = document.getElementById('importFile');
        const drop  = document.getElementById('importDrop');
        const name  = document.getElementById('importFileName');
        const hint  = document.getElementById('importFileHint');
        const msg   = document.getElementById('importMsg');
        const btn   = document.getElementById('importSubmitBtn');

        function checkFile() {
            const file = input.files[0];
            drop.classList.remove('has-file');
            msg.textContent = '';
            btn.disabled = true;

            if (!file) { name.textContent = IMPORT_DEFAULT_LABEL; hint.style.display = ''; return; }

            name.textContent = file.name;
            hint.style.display = 'none';

            const ext = file.name.split('.').pop().toLowerCase();
            if (!IMPORT_EXT.includes(ext)) { msg.textContent = 'Format file tidak didukung. Pilih file .xlsx, .xls, atau .csv.'; return; }
            if (file.size > IMPORT_MAX_BYTES) { msg.textContent = 'Ukuran file lebih dari 5 MB. Kecilkan atau pecah file-nya.'; return; }

            drop.classList.add('has-file');
            btn.disabled = false;
        }

        input.addEventListener('change', checkFile);

        ['dragenter', 'dragover'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.add('is-over'); }));
        ['dragleave', 'drop'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.remove('is-over'); }));
        drop.addEventListener('drop', e => {
            if (!e.dataTransfer || !e.dataTransfer.files.length) return;
            const dt = new DataTransfer();
            dt.items.add(e.dataTransfer.files[0]);
            input.files = dt.files;
            checkFile();
        });

        form.addEventListener('submit', () => {
            btn.dataset.busy = '1';
            btn.disabled = true;
            btn.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Mengimpor...";
        });

        modal.addEventListener('click', e => { if (e.target === modal) closeImportModal(); });
    }

    /* ============================================================
       DETAIL
       ============================================================ */
    function chbOpenDetailModal(id) {
        const client = chbClients.find(c => c.id === id); if (!client) return;
        document.getElementById('chbDetailContent').innerHTML = `
            <div class="detail-item"><span class="detail-label">NAMA CLIENT</span><div class="detail-value" style="font-weight:600;">${chbEscape(client.nama)}</div></div>
            <div class="detail-item"><span class="detail-label">PROJECT</span><div class="detail-value">${chbEscape(client.project)}</div></div>
            <div class="detail-item"><span class="detail-label">TANGGAL MULAI</span><div class="detail-value">${chbFormatDate(client.tanggal_awal)}</div></div>
            <div class="detail-item"><span class="detail-label">DEADLINE PROJECT</span><div class="detail-value">${chbFormatDate(client.deadline)}</div></div>
            <div class="detail-item detail-item-full"><span class="detail-label">DESKRIPSI / CATATAN LENGKAP</span><div class="detail-value" id="chbDetailDesc">${client.deskripsi || '<em>Tidak ada deskripsi.</em>'}</div></div>
        `;
        const imgs = Array.from(document.querySelectorAll('#chbDetailDesc img')); const srcs = imgs.map(i => i.src);
        imgs.forEach((img, idx) => { img.style.cursor = 'zoom-in'; img.addEventListener('click', () => openDbLightbox(srcs, idx)); });
        document.getElementById('chbDetailModalOverlay').classList.add('show');
    }
    function chbCloseDetailModal() { document.getElementById('chbDetailModalOverlay').classList.remove('show'); }

    /* ============================================================
       LIGHTBOX
       ============================================================ */
    function openDbLightbox(imagesArr, index = 0) {
        if (!imagesArr || imagesArr.length === 0) return;
        lbImagesArr = imagesArr; lbCurrentIndex = index;
        document.getElementById('dbLightboxImg').src = lbImagesArr[lbCurrentIndex];
        document.getElementById('dbLightbox').classList.add('show');
        const showNav = lbImagesArr.length > 1 ? 'flex' : 'none';
        document.querySelector('.db-lightbox-btn.prev').style.display = showNav; document.querySelector('.db-lightbox-btn.next').style.display = showNav;
    }
    function closeDbLightbox() {
        document.getElementById('dbLightbox').classList.remove('show');
        setTimeout(() => document.getElementById('dbLightboxImg').src = '', 300);
    }
    function slideDbLightbox(direction) {
        if (lbImagesArr.length <= 1) return; lbCurrentIndex += direction;
        if (lbCurrentIndex < 0) lbCurrentIndex = lbImagesArr.length - 1; if (lbCurrentIndex >= lbImagesArr.length) lbCurrentIndex = 0;
        document.getElementById('dbLightboxImg').src = lbImagesArr[lbCurrentIndex];
    }
    function initLightboxEvents() {
        const lightbox = document.getElementById('dbLightbox');
        lightbox.addEventListener('click', function(e) { if (e.target === lightbox || e.target.id === 'dbLightboxContentWrapper') closeDbLightbox(); });
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('show')) return;
            if (e.key === 'Escape') closeDbLightbox(); if (e.key === 'ArrowLeft') slideDbLightbox(-1); if (e.key === 'ArrowRight') slideDbLightbox(1);
        });
    }
</script>
@endpush