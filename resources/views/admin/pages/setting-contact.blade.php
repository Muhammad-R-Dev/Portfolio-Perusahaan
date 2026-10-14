@extends('admin.layouts.app')

@section('title', 'Pengaturan Kontak & Lokasi | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
<style>
	#content main .settings-wrapper {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 24px;
		margin-top: 4px;
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
		flex-wrap: wrap;
		grid-gap: 12px;
		margin-bottom: 24px;
	}
	#content main .settings-card .head .bx { font-size: 24px; color: var(--blue); }
	#content main .settings-card .head h3 { font-size: 22px; font-weight: 600; }
	#content main .settings-card .head p {
		width: 100%;
		font-size: 13px;
		color: var(--dark-grey);
		margin-top: 4px;
	}

	/* Satu card berisi beberapa bagian */
	#content main .settings-cols {
		display: grid;
		grid-template-columns: 1fr 1fr;
		grid-gap: 32px;
		align-items: start;
	}
	#content main .settings-cols > .settings-col { min-width: 0; }
	#content main .settings-cols > .settings-col + .settings-col {
		padding-left: 32px;
		border-left: 1px solid var(--grey);
	}
	#content main .settings-col > .settings-section + .settings-section {
		margin-top: 28px;
		padding-top: 28px;
		border-top: 1px solid var(--grey);
	}
	#content main .settings-card .head.sub { margin-bottom: 16px; }
	#content main .settings-card .head.sub .bx { font-size: 20px; }
	#content main .settings-card .head.sub h3 { font-size: 17px; }
	#content main .settings-card .head.sub p { font-size: 12.5px; margin-top: 0; }

	#content main .form-group { margin-bottom: 20px; }
	#content main .form-group:last-child { margin-bottom: 0; }
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
		padding: 12px 16px;
		min-height: 90px;
		resize: vertical;
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

	/* Input dengan prefix (+62 / ikon) */
	#content main .input-prefix {
		display: flex;
		align-items: stretch;
		border: 1px solid var(--grey);
		background: var(--grey);
		border-radius: 10px;
		overflow: hidden;
		transition: .2s ease;
	}
	#content main .input-prefix:focus-within {
		border-color: var(--blue);
		background: var(--light);
	}
	#content main .input-prefix .prefix {
		display: flex;
		align-items: center;
		justify-content: center;
		min-width: 48px;
		padding: 0 14px;
		font-size: 14px;
		font-weight: 600;
		color: var(--dark-grey);
		border-right: 1px solid var(--light);
	}
	#content main .input-prefix .prefix .bx { font-size: 20px; }
	#content main .input-prefix .form-control {
		border: none;
		background: transparent;
		border-radius: 0;
	}
	#content main .input-prefix .form-control:focus { background: transparent; }

	/* ===== Input sosial media (disamakan dengan Kelola Tim) ===== */
	#content main .social-rows { display: flex; flex-direction: column; gap: 10px; }

	#content main .sosmed-item {
		position: relative;
		display: flex;
		align-items: center;
		gap: 8px;
		width: 100%;
	}
	#content main .sosmed-item .platform-icon {
		position: absolute;
		left: 14px;
		font-size: 20px;
		pointer-events: none;
		transition: transform .3s ease;
	}
	/* Input ini di luar .form-group, jadi style ukuran/border/background
	   ditulis eksplisit di sini (tidak ikut rule ".form-group .form-control"). */
	#content main .sosmed-item .social-url-input {
		flex: 1;
		min-width: 0;
		height: 44px;
		padding: 0 16px 0 44px !important;
		border: 1px solid var(--grey);
		background: var(--grey);
		border-radius: 10px;
		outline: none;
		color: var(--dark);
		font-family: var(--poppins);
		font-size: 14px;
		transition: .2s ease;
	}
	#content main .sosmed-item .social-url-input:focus {
		border-color: var(--blue);
		background: var(--light);
	}
	#content main .sosmed-item .social-url-input:disabled {
		cursor: default;
		opacity: .9;
		color: var(--dark-grey);
	}

	/* Warna ikon platform di dalam input (sama seperti Kelola Tim) */
	#content main .brand-text-ig { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; }
	#content main .brand-text-fb { color: #1877F2 !important; }
	#content main .brand-text-in { color: #0A66C2 !important; }
	#content main .brand-text-yt { color: #FF0000 !important; }
	#content main .brand-text-x { color: #000000 !important; }
	body.dark #content main .brand-text-x { color: #ffffff !important; }
	#content main .brand-text-gh { color: #333333 !important; }
	body.dark #content main .brand-text-gh { color: #ffffff !important; }
	#content main .brand-text-tt { color: #000000 !important; }
	body.dark #content main .brand-text-tt { color: #ffffff !important; }
	#content main .brand-text-wa { color: #25D366 !important; }
	#content main .brand-text-tg { color: #2ca5e0 !important; }
	#content main .brand-text-link { color: var(--dark-grey) !important; }

	#content main .btn-hapus-sosmed {
		background: var(--red, #ef5a5a); color: #fff; border: none; border-radius: 8px;
		width: 42px; height: 42px; display: flex; align-items: center; justify-content: center;
		cursor: pointer; font-size: 20px; transition: .2s; flex-shrink: 0;
	}
	#content main .btn-hapus-sosmed:hover { filter: brightness(.9); }
	#content main .btn-hapus-sosmed:disabled { opacity: .35; cursor: not-allowed; pointer-events: none; }

	/* Empty state saat belum ada link sama sekali */
	#content main .social-empty {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 6px;
		padding: 24px 16px;
		border: 1.5px dashed var(--grey);
		border-radius: 14px;
		color: var(--dark-grey);
		font-size: 13px;
		text-align: center;
	}
	#content main .social-empty .bx { font-size: 26px; color: var(--dark-grey); }

	#content main .btn-add-social {
		background: transparent; color: var(--blue); border: 2px dashed var(--blue);
		padding: 10px 16px; border-radius: 8px; cursor: pointer; font-family: var(--poppins);
		font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;
		transition: .2s; width: 100%; justify-content: center; margin-top: 12px;
	}
	#content main .btn-add-social:hover:not(:disabled) { background: var(--light-blue); }
	#content main .btn-add-social:disabled { opacity: .5; cursor: not-allowed; pointer-events: none; }
	#content main .btn-add-social .bx { font-size: 18px; }
	#content main .social-counter {
		font-size: 12px;
		color: var(--dark-grey);
		text-align: right;
		margin-top: 6px;
	}

	/* Peringatan link sosial media & status baca link Google Maps */
	#content main .field-warn {
		display: none;
		margin-top: 6px;
		font-size: 12px;
		color: var(--orange);
	}
	#content main .field-warn.show { display: block; }
	#content main .map-status {
		display: none;
		align-items: flex-start;
		grid-gap: 6px;
		margin-top: 8px;
		font-size: 12.5px;
		font-weight: 500;
		line-height: 1.5;
	}
	#content main .map-status.show { display: flex; }
	#content main .map-status .bx { font-size: 16px; margin-top: 2px; flex-shrink: 0; }
	#content main .map-status.ok { color: #1e9e5a; }
	#content main .map-status.info { color: var(--dark-grey); }
	#content main .map-status.error { color: var(--orange); }

	/* Link pengecekan WA */
	#content main .wa-check {
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		margin-top: 8px;
		font-size: 13px;
		font-weight: 500;
		color: var(--blue);
	}
	#content main .wa-check.disabled {
		color: var(--dark-grey);
		pointer-events: none;
	}

	/* Preview Google Maps (embed) */
	#content main .map-embed {
		position: relative;
		width: 100%;
		aspect-ratio: 16 / 9;
		border-radius: 14px;
		overflow: hidden;
		background: var(--grey);
		border: 1px solid var(--grey);
	}
	#content main .map-embed iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; display: none; }
	#content main .map-embed.has-map iframe { display: block; }
	#content main .map-embed .map-empty {
		position: absolute; inset: 0;
		display: flex; flex-direction: column; align-items: center; justify-content: center;
		grid-gap: 8px; padding: 16px; text-align: center;
		font-size: 13px; color: var(--dark-grey);
	}
	#content main .map-embed .map-empty .bx { font-size: 34px; color: var(--orange); }
	#content main .map-embed.has-map .map-empty { display: none; }
	#content main .btn-open {
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		margin-top: 12px;
		padding: 6px 16px;
		border-radius: 36px;
		background: var(--blue);
		color: var(--light);
		font-size: 13px;
		font-weight: 500;
	}
	#content main .btn-open.disabled { opacity: .45; pointer-events: none; }

	/* Preview lokasi (lama, tidak dipakai lagi) */
	#content main .map-preview {
		margin-top: 20px;
		border-radius: 14px;
		background: var(--grey);
		border: 1px dashed var(--dark-grey);
		padding: 20px;
		display: flex;
		align-items: flex-start;
		grid-gap: 14px;
	}
	#content main .map-preview .pin {
		flex-shrink: 0;
		width: 44px;
		height: 44px;
		border-radius: 12px;
		background: var(--light-orange);
		color: var(--orange);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}
	#content main .map-preview .info { flex: 1; min-width: 0; }
	#content main .map-preview .info strong {
		display: block;
		font-size: 15px;
		margin-bottom: 4px;
		color: var(--dark);
	}
	#content main .map-preview .info span {
		display: block;
		font-size: 13px;
		color: var(--dark-grey);
		line-height: 1.5;
	}
	#content main .map-preview .btn-open {
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		margin-top: 10px;
		padding: 6px 16px;
		border-radius: 36px;
		background: var(--blue);
		color: var(--light);
		font-size: 13px;
		font-weight: 500;
	}
	#content main .map-preview .btn-open.disabled {
		opacity: .45;
		pointer-events: none;
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

	/* ===== Mode lihat / mode edit ===== */
	#content main .form-control:disabled {
		cursor: default;
		opacity: 1;
		color: var(--dark-grey);
	}

	#content main .input-prefix:has(.form-control:disabled) {
		cursor: default;
		opacity: .9;
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

	#content main .btn-edit,
	#content main .btn-cancel {
		height: 44px;
		padding: 0 24px;
		border: none;
		border-radius: 36px;
		font-family: var(--poppins);
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		grid-gap: 8px;
		transition: .2s ease;
	}

	#content main .btn-edit {
		background: var(--blue);
		color: #fff;
	}

	#content main .btn-edit:hover,
	#content main .btn-cancel:hover,
	#content main .btn-save:hover { opacity: .9; }

	#content main .btn-cancel {
		background: var(--red, #ef5a5a);
		color: #fff;
	}

	#content main .btn-save,
	#content main .btn-cancel { display: none; }

	#content main.edit-mode .btn-edit { display: none; }
	#content main.edit-mode .btn-save,
	#content main.edit-mode .btn-cancel { display: inline-flex; }

	body.dark #content main .form-actions {
		box-shadow: 0 12px 30px rgba(0, 0, 0, .30);
	}

	@media screen and (max-width: 576px) {
		#content main .form-actions {
			left: 16px;
			right: 16px;
			bottom: 12px;
			padding: 10px 12px;
			justify-content: stretch;
			border-radius: 0 0 14px 14px;
		}

		#content main .form-actions > button {
			flex: 1;
		}
	}

	#content main .form-actions-original-marker { display: none; }


	#content main .alert {
		padding: 14px 18px;
		border-radius: 10px;
		font-size: 14px;
		margin-bottom: 20px;
		display: none;
		align-items: center;
		grid-gap: 10px;
		background: var(--light-blue);
		color: var(--blue);
	}
	#content main .alert.show { display: flex; }
	#content main .alert.alert-success { display: flex; background: #e3f7ec; color: #1e9e5a; }
	#content main .alert.alert-error { display: flex; background: var(--light-orange); color: var(--orange); align-items: flex-start; }
	#content main .alert.alert-error ul { margin: 0; padding-left: 18px; }

	/* ===== Modal popup "berhasil disimpan" ===== */
	.success-modal-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(15, 23, 42, .45);
		z-index: 9999;
		align-items: center;
		justify-content: center;
		padding: 16px;
	}
	.success-modal-overlay.show { display: flex; }
	.success-modal-overlay .success-modal-box {
		background: var(--light);
		border-radius: 16px;
		padding: 32px 28px;
		max-width: 360px;
		width: 100%;
		text-align: center;
		box-shadow: 0 20px 50px rgba(15, 23, 42, .25);
	}
	.success-modal-overlay .success-modal-icon {
		width: 56px;
		height: 56px;
		border-radius: 50%;
		background: #e3f7ec;
		color: #1e9e5a;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 30px;
		margin: 0 auto 16px;
	}
	.success-modal-overlay .success-modal-text {
		font-size: 15px;
		font-weight: 600;
		color: var(--dark);
		margin-bottom: 20px;
	}
	.success-modal-overlay .success-modal-ok {
		border: none;
		background: var(--blue);
		color: #fff;
		font-family: var(--poppins);
		font-size: 14px;
		font-weight: 600;
		padding: 10px 28px;
		border-radius: 36px;
		cursor: pointer;
		transition: .2s ease;
	}
	.success-modal-overlay .success-modal-ok:hover { opacity: .9; }

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

	body.dark #content main .btn-save,
	body.dark #content main .btn-save:hover,
	body.dark #content main .btn-open {
		background: var(--blue) !important;
		color: #fff !important;
	}

	@media screen and (max-width: 900px) {
		#content main .settings-cols { grid-template-columns: 1fr; }
		#content main .settings-cols > .settings-col + .settings-col {
			padding-left: 0;
			border-left: none;
			padding-top: 28px;
			border-top: 1px solid var(--grey);
		}
	}

	@media screen and (max-width: 576px) {
		#content main .settings-wrapper > div { flex-basis: 100%; }
	}

	/* Card Kontak & Lokasi: sudut bawah kiri & kanan lancip */
	#content main .settings-wrapper > .settings-card {
		border-bottom-left-radius: 0;
		border-bottom-right-radius: 0;
	}
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
</style>
@endpush

@section('content')
			@php
				$setting = $setting ?? \App\Models\SiteSetting::first();
			@endphp
			@if(session('success'))
				<div class="success-modal-overlay" id="successModal">
					<div class="success-modal-box">
						<div class="success-modal-icon"><i class='bx bx-check'></i></div>
						<div class="success-modal-text">Berhasil mengubah Pengaturan Kontak &amp; Lokasi</div>
						<button type="button" class="success-modal-ok" id="successModalOk">OK</button>
					</div>
				</div>
			@endif
			@if($errors->any())
				<div class="alert alert-error">
					<i class='bx bx-error-circle'></i>
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form id="contactForm" action="{{ route('admin.setting.contact.update') }}" method="POST">
				@csrf
				@method('PUT')

				<div class="settings-wrapper">

					<div class="settings-card" style="flex-basis: 100%;">
						<div class="head">
							<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" title="Kembali ke Settings">
								<i class='bx bx-arrow-back'></i>
							</a>
							<i class='bx bxs-contact'></i>
							<h3>Edit Kontak &amp; Lokasi</h3>
							<p>Nomor WhatsApp, sosial media, dan alamat kantor perusahaan.</p>
						</div>

						{{-- ===== KIRI: WhatsApp + Lokasi | KANAN: Sosial Media + Preview ===== --}}
						<div class="settings-cols">

							<div class="settings-col">
								<section class="settings-section">
									<div class="head sub">
										<i class='bx bxl-whatsapp'></i>
										<h3>Kontak WhatsApp</h3>
										<p>Nomor untuk tombol "Hubungi Kami" di website.</p>
									</div>

									<div class="form-group">
										<label for="wa_number">Nomor WhatsApp Perusahaan</label>
										<div class="input-prefix">
											<span class="prefix">+62</span>
											<input type="text" class="form-control" id="wa_number" disabled name="wa_number" value="{{ old('wa_number', $setting->wa_number ?? '') }}" placeholder="81234567890" inputmode="numeric">
										</div>
										<small class="hint">Tulis tanpa angka 0 di depan dan tanpa spasi/tanda hubung. Contoh: 81234567890</small>
										<a href="#" target="_blank" rel="noopener" class="wa-check" id="waCheck">
											<i class='bx bxl-whatsapp'></i> Tes buka chat WhatsApp
										</a>
									</div>

									<div class="form-group">
										<label for="email">Alamat Email</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bx-envelope'></i></span>
											<input type="email" class="form-control" id="email" disabled name="email" value="{{ old('email', $setting->email ?? '') }}" placeholder="nama@email.com" autocomplete="off">
										</div>
										<small class="hint">Email ini akan tampil di halaman Contact.</small>
									</div>
								</section>

								<section class="settings-section">
									<div class="head sub">
										<i class='bx bxs-map'></i>
										<h3>Lokasi</h3>
										<p>Isi alamat lengkap, lalu tempel link Google Maps. Peta tampil di bawahnya.</p>
									</div>

									<div class="form-group">
										<label for="address_full">Alamat Lengkap</label>
										<textarea class="form-control" id="address_full" disabled name="address_full" placeholder="Jl. ..., Kelurahan, Kecamatan, Kota, Kode Pos">{{ old('address_full', $setting->address_full ?? 'Jl.STPP karanglo, Area Sawah/Kebun, Glagahombo, Tegalrejo, Magelang, Jawa Tengah 56192') }}</textarea>
									</div>

									<div class="form-group">
										<label for="map_link">Link Google Maps</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bx-link'></i></span>
											<input type="text" class="form-control" id="map_link" disabled name="map_link" value="{{ old('map_link', $setting->map_link ?? '') }}" placeholder="https://www.google.com/maps/place/..." inputmode="url" autocomplete="off">
										</div>
										<small class="hint">Peta di halaman Contact mengikuti link ini. Boleh link biasa, link pendek (Bagikan), atau kode &lt;iframe&gt; dari Bagikan &gt; Sematkan peta.</small>
										<div class="map-status" id="mapStatus"></div>
									</div>

									<div class="form-group">
										<label>Preview Google Maps</label>
										<div class="map-embed" id="mapEmbed">
											<iframe id="mapFrame" title="Preview Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
											<div class="map-empty"><i class='bx bxs-map-pin'></i><span>Isi alamat atau link Google Maps untuk melihat peta.</span></div>
										</div>
										<a href="#" target="_blank" rel="noopener" class="btn-open" id="previewMapBtn">
											<i class='bx bx-link-external'></i> Buka di Google Maps
										</a>
									</div>
								</section>
							</div>

							<div class="settings-col">
								<section class="settings-section">
									<div class="head sub">
										<i class='bx bx-share-alt'></i>
										<h3>Sosial Media</h3>
										<p>Tambah link sosial media (maks. 5). URL otomatis terdeteksi platformnya.</p>
									</div>

									{{-- Hidden inputs untuk masing-masing platform (dikosongkan dulu, diisi JS saat submit) --}}
									<input type="hidden" name="social_youtube"   id="hid_social_youtube"   value="">
									<input type="hidden" name="social_facebook"  id="hid_social_facebook"  value="">
									<input type="hidden" name="social_instagram" id="hid_social_instagram" value="">
									<input type="hidden" name="social_linkedin"  id="hid_social_linkedin"  value="">
									<input type="hidden" name="social_twitter"   id="hid_social_twitter"   value="">
									<input type="hidden" name="social_github"    id="hid_social_github"    value="">

									{{-- Data awal dari DB --}}
									<div id="socialInitData"
										data-youtube="{{ old('social_youtube',   $setting->social_youtube   ?? '') }}"
										data-facebook="{{ old('social_facebook',  $setting->social_facebook  ?? '') }}"
										data-instagram="{{ old('social_instagram', $setting->social_instagram ?? '') }}"
										data-linkedin="{{ old('social_linkedin',  $setting->social_linkedin  ?? '') }}"
										data-twitter="{{ old('social_twitter',   $setting->social_twitter   ?? '') }}"
										data-github="{{ old('social_github',    $setting->social_github    ?? '') }}"
										style="display:none;"
									></div>

									<div class="social-rows" id="socialRows"></div>

									<button type="button" class="btn-add-social" id="btnAddSocial" disabled>
										<i class='bx bx-plus'></i> Tambah Link Sosmed
									</button>
									<div class="social-counter" id="socialCounter">0 / 5 link ditambahkan</div>
								</section>
							</div>

						</div>
					</div>

				</div>

				<div class="form-actions">
					<button type="button" class="btn-edit" id="editContactBtn">
						<i class='bx bx-edit'></i>
						Edit Pengaturan
					</button>

					<button type="button" class="btn-cancel" id="cancelEditBtn">
						<i class='bx bx-x'></i>
						Batal
					</button>

					<button type="submit" class="btn-save">
						<i class='bx bx-save'></i>
						Simpan Perubahan
					</button>
				</div>
			</form>
@endsection

@push('scripts')
<script>
	// ===== Popup modal berhasil disimpan =====
	(function () {
		var modal = document.getElementById('successModal');
		if (!modal) return;
		var okBtn = document.getElementById('successModalOk');
		requestAnimationFrame(function () { modal.classList.add('show'); });
		function closeModal() { modal.classList.remove('show'); }
		if (okBtn) okBtn.addEventListener('click', closeModal);
		modal.addEventListener('click', function (e) {
			if (e.target === modal) closeModal();
		});
	})();

	// ===== Mode lihat / mode edit =====
	const contactMain = document.querySelector('#content main');
	const contactForm = document.getElementById('contactForm');
	const editContactBtn = document.getElementById('editContactBtn');
	const cancelEditBtn = document.getElementById('cancelEditBtn');
	const editableFields = contactForm ? contactForm.querySelectorAll('input.form-control, textarea.form-control') : [];

	function setEditMode(enabled) {
		if (!contactMain || !contactForm) return;

		contactMain.classList.toggle('edit-mode', enabled);
		editableFields.forEach(function (field) {
			field.disabled = !enabled;
		});

		// Sync mode ke UI sosial media
		if (typeof window._socialSetEdit === 'function') window._socialSetEdit(enabled);

		if (enabled) {
			contactMain.scrollIntoView({ behavior: 'smooth', block: 'start' });
			setTimeout(function () {
				const firstField = contactForm.querySelector('input.form-control:not([type="hidden"]):not(:disabled), textarea.form-control:not(:disabled)');
				if (firstField) firstField.focus();
			}, 250);
		}
	}

	if (editContactBtn) {
		editContactBtn.addEventListener('click', function () {
			setEditMode(true);
		});
	}

	if (cancelEditBtn) {
		cancelEditBtn.addEventListener('click', function () {
			contactForm.reset();
			setEditMode(false);
			// Reset sosial media ke nilai awal dari DB
			if (typeof loadInitialSocial === 'function') {
				socialItems = loadInitialSocial();
				renderSocial();
				updateHiddenInputs();
			}
			if (typeof updateWa === 'function') updateWa();
			if (typeof schedulePreview === 'function') schedulePreview();
			if (typeof updatePreview === 'function') updatePreview();
			editableFields.forEach(function (field) {
				field.dispatchEvent(new Event('input', { bubbles: true }));
			});
		});
	}

	if (contactForm) {
		contactForm.addEventListener('submit', function (event) {
			if (!contactMain.classList.contains('edit-mode')) {
				event.preventDefault();
				return;
			}
			// Pastikan hidden inputs sosmed ter-update sebelum submit
			if (typeof updateHiddenInputs === 'function') updateHiddenInputs();
			// Field biasa harus aktif agar nilainya ikut terkirim ke Laravel.
			editableFields.forEach(function (field) {
				field.disabled = false;
			});
		});
	}

	// ===== Tes link WhatsApp =====
	const waInput = document.getElementById('wa_number');
	const waCheck = document.getElementById('waCheck');

	function updateWa() {
		// Ambil angka saja, buang 0/62 di depan kalau terlanjur diketik
		let num = waInput.value.replace(/\D/g, '').replace(/^(62|0)+/, '');
		if (num.length >= 8) {
			waCheck.href = 'https://wa.me/62' + num;
			waCheck.classList.remove('disabled');
		} else {
			waCheck.href = '#';
			waCheck.classList.add('disabled');
		}
	}
	waInput.addEventListener('input', updateWa);
	updateWa();

	// ===== Preview lokasi =====
	const addrFull = document.getElementById('address_full');
	const mapLink  = document.getElementById('map_link');
	const prevBtn  = document.getElementById('previewMapBtn');
	const mapEmbed = document.getElementById('mapEmbed');
	const mapFrame = document.getElementById('mapFrame');
	let lastEmbedSrc = '';
	let embedTimer = null;

	// Ambil src kalau yang ditempel berupa kode <iframe>
	function iframeSrc(raw) {
		const m = raw.match(/<iframe[^>]+src=["']([^"']+)["']/i);
		return m ? m[1].replace(/&amp;/g, '&') : '';
	}

	function buildEmbed() {
		const link = mapLink.value.trim();
		const addr = addrFull.value.trim();

		const fromIframe = iframeSrc(link);
		if (fromIframe) return { src: fromIframe, open: fromIframe };

		// Prioritas: koordinat di link > alamat lengkap > nama tempat dari link
		let query = '';
		const m = link.match(/@(-?\d+\.\d+),(-?\d+\.\d+)/);
		if (m) query = m[1] + ',' + m[2];
		else if (addr) query = addr;
		else {
			const r = parseMapLink(link);
			if (r.status === 'ok') query = [r.name, r.address].filter(Boolean).join(', ');
		}
		const open = /^https?:\/\//i.test(link)
			? link
			: (query ? 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(query) : '');
		if (!query) return { src: '', open: open };
		return { src: 'https://maps.google.com/maps?q=' + encodeURIComponent(query) + '&z=16&output=embed', open: open };
	}

	function updatePreview() {
		const e = buildEmbed();
		if (e.src !== lastEmbedSrc) {
			lastEmbedSrc = e.src;
			if (e.src) { mapFrame.src = e.src; mapEmbed.classList.add('has-map'); }
			else { mapFrame.removeAttribute('src'); mapEmbed.classList.remove('has-map'); }
		}
		if (e.open) { prevBtn.href = e.open; prevBtn.classList.remove('disabled'); }
		else { prevBtn.href = '#'; prevBtn.classList.add('disabled'); }
	}
	// Tunda sebentar supaya peta tidak reload di setiap ketikan
	function schedulePreview() { clearTimeout(embedTimer); embedTimer = setTimeout(updatePreview, 600); }
	[addrFull, mapLink].forEach(el => el.addEventListener('input', schedulePreview));
	updatePreview();

	// ===== Sosial media: UI dinamis tambah / hapus (maks 5) =====
	const MAX_SOCIAL = 5;

	// Database platform: key = field DB, value = info platform
	const PLATFORM_MAP = [
		{ key: 'youtube',   label: 'YouTube',    icon: 'bxl-youtube',        brand: 'brand-text-yt', domains: ['youtube.com', 'youtu.be'] },
		{ key: 'facebook',  label: 'Facebook',   icon: 'bxl-facebook-circle',brand: 'brand-text-fb', domains: ['facebook.com', 'fb.com', 'fb.me', 'fb.watch'] },
		{ key: 'instagram', label: 'Instagram',  icon: 'bxl-instagram',      brand: 'brand-text-ig', domains: ['instagram.com', 'instagr.am'] },
		{ key: 'linkedin',  label: 'LinkedIn',   icon: 'bxl-linkedin-square',brand: 'brand-text-in', domains: ['linkedin.com', 'lnkd.in'] },
		{ key: 'twitter',   label: 'Twitter / X',icon: 'bxl-twitter',        brand: 'brand-text-x',  domains: ['twitter.com', 'x.com'] },
		{ key: 'github',    label: 'GitHub',     icon: 'bxl-github',         brand: 'brand-text-gh', domains: ['github.com'] },
		{ key: 'tiktok',    label: 'TikTok',     icon: 'bxl-tiktok',         brand: 'brand-text-tt', domains: ['tiktok.com'] },
		{ key: 'whatsapp',  label: 'WhatsApp',   icon: 'bxl-whatsapp',       brand: 'brand-text-wa', domains: ['wa.me', 'whatsapp.com', 'api.whatsapp.com'] },
		{ key: 'telegram',  label: 'Telegram',   icon: 'bxl-telegram',       brand: 'brand-text-tg', domains: ['t.me', 'telegram.me', 'telegram.org'] },
	];

	// Link boleh tanpa https://
	function toUrl(raw) {
		const v = (raw || '').trim();
		const withScheme = /^[a-z][a-z0-9+.-]*:\/\//i.test(v) ? v : 'https://' + v;
		try {
			const u = new URL(withScheme);
			if (!/^https?:$/.test(u.protocol) || !u.hostname.includes('.')) return null;
			return u;
		} catch (e) { return null; }
	}

	// Deteksi platform dari URL
	function detectPlatform(url) {
		const u = toUrl(url);
		if (!u) return null;
		const host = u.hostname.toLowerCase();
		for (const p of PLATFORM_MAP) {
			if (p.domains.some(d => host === d || host.endsWith('.' + d))) return p;
		}
		return null;
	}

	// State: array of { key, url } — urutan tampil
	let socialItems = [];
	let socialEditMode = false;

	const socialRows    = document.getElementById('socialRows');
	const btnAddSocial  = document.getElementById('btnAddSocial');
	const socialCounter = document.getElementById('socialCounter');
	const socialInit    = document.getElementById('socialInitData');

	// Ambil data awal dari DB
	const KNOWN_KEYS = ['youtube','facebook','instagram','linkedin','twitter','github'];
	function loadInitialSocial() {
		const items = [];
		for (const k of KNOWN_KEYS) {
			const url = (socialInit.dataset[k] || '').trim();
			if (url) items.push({ key: k, url });
		}
		return items;
	}
	socialItems = loadInitialSocial();

	function updateHiddenInputs() {
		// Reset semua ke kosong
		for (const k of KNOWN_KEYS) {
			const el = document.getElementById('hid_social_' + k);
			if (el) el.value = '';
		}
		// Isi dari socialItems
		for (const item of socialItems) {
			const el = document.getElementById('hid_social_' + item.key);
			if (el) el.value = item.url;
		}
	}

	function renderSocial() {
		socialRows.innerHTML = '';

		// Belum ada link sama sekali -> tampilkan empty state, bukan card kosong.
		if (socialItems.length === 0) {
			const empty = document.createElement('div');
			empty.className = 'social-empty';
			empty.innerHTML = `<i class='bx bx-link-alt'></i><span>${socialEditMode ? 'Belum ada link sosial media. Klik tombol di bawah untuk menambah.' : 'Belum ada link sosial media ditambahkan.'}</span>`;
			socialRows.appendChild(empty);
			updateSocialUI();
			updateHiddenInputs();
			return;
		}

		socialItems.forEach(function (item, idx) {
			const platform = detectPlatform(item.url);
			const icon  = platform ? platform.icon  : 'bx-link';
			const brand = platform ? platform.brand : 'brand-text-link';

			// Satu baris = ikon di dalam input + tombol hapus, persis seperti di Kelola Tim.
			const row = document.createElement('div');
			row.className = 'sosmed-item';
			row.innerHTML = `
				<i class="bx ${icon} platform-icon ${brand}" data-prefix-icon></i>
				<input type="text" class="form-control social-url-input"
					value="${escHtml(item.url)}"
					placeholder="https://instagram.com/username"
					inputmode="url" autocomplete="off"
					${socialEditMode ? '' : 'disabled'}
					data-idx="${idx}">
				<button type="button" class="btn-hapus-sosmed" data-idx="${idx}" title="Hapus" ${socialEditMode ? '' : 'disabled'}>
					<i class='bx bx-trash'></i>
				</button>`;

			socialRows.appendChild(row);

			const prefixI = row.querySelector('[data-prefix-icon]');

			// Event: input URL -> deteksi ulang ikon platform saat diketik
			const input = row.querySelector('.social-url-input');
			input.addEventListener('input', function () {
				socialItems[idx].url = this.value;
				const v  = this.value.trim();
				const p2 = detectPlatform(v);
				const ic2 = p2 ? p2.icon  : 'bx-link';
				const br2 = p2 ? p2.brand : 'brand-text-link';
				if (prefixI) prefixI.className = 'bx ' + ic2 + ' platform-icon ' + br2;
				socialItems[idx].key = p2 ? p2.key : '';
				updateHiddenInputs();
			});

			// Event: hapus
			row.querySelector('.btn-hapus-sosmed').addEventListener('click', function () {
				socialItems.splice(idx, 1);
				updateHiddenInputs();
				renderSocial();
				updateSocialUI();
			});
		});

		updateSocialUI();
		updateHiddenInputs();
	}

	function updateSocialUI() {
		const count = socialItems.length;
		socialCounter.textContent = count + ' / ' + MAX_SOCIAL + ' link ditambahkan';
		btnAddSocial.disabled = !socialEditMode || count >= MAX_SOCIAL;
		// disable/enable tombol hapus & input tiap baris
		socialRows.querySelectorAll('.btn-hapus-sosmed').forEach(function (btn) {
			btn.disabled = !socialEditMode;
		});
		socialRows.querySelectorAll('.social-url-input').forEach(function (inp) {
			inp.disabled = !socialEditMode;
		});
	}

	function escHtml(s) {
		return String(s).replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
	}

	// Tambah baris baru
	btnAddSocial.addEventListener('click', function () {
		if (!socialEditMode || socialItems.length >= MAX_SOCIAL) return;
		socialItems.push({ key: '', url: '' });
		renderSocial();
		// Fokus ke input terakhir
		setTimeout(function () {
			const inputs = socialRows.querySelectorAll('.social-url-input');
			if (inputs.length) inputs[inputs.length - 1].focus();
		}, 50);
	});

	// Render awal
	renderSocial();

	// Daftarkan ke window agar bisa dipanggil dari setEditMode (didefinisikan sebelum blok ini)
	window._socialSetEdit = function (enabled) {
		socialEditMode = enabled;
		renderSocial();
		updateSocialUI();
	};

	// ===== Link Google Maps -> alamat terisi otomatis =====
	const mapStatus = document.getElementById('mapStatus');

	function setMapStatus(type, msg) {
		mapStatus.innerHTML = '';
		mapStatus.className = 'map-status';
		if (!msg) return;
		const icons = { ok: 'bx-check-circle', info: 'bx-info-circle', error: 'bx-error-circle' };
		const i = document.createElement('i');
		i.className = 'bx ' + icons[type];
		const t = document.createElement('span');
		t.textContent = msg;
		mapStatus.append(i, t);
		mapStatus.classList.add('show', type);
	}

	function safeDecode(str) {
		try { return decodeURIComponent(str); } catch (err) { return str; }
	}

	// Hasil: { status: empty|invalid|notmaps|short|noaddr|ok, name, address }
	function parseMapLink(raw) {
		if (!raw.trim()) return { status: 'empty' };
		const u = toUrl(raw);
		if (!u) return { status: 'invalid' };

		const host = u.hostname.toLowerCase();
		const path = u.pathname;

		// Link pendek hanya bisa dibuka lewat server (redirect), tidak bisa dibaca di browser
		if (host === 'maps.app.goo.gl' || (host === 'goo.gl' && path.indexOf('/maps') === 0)) {
			return { status: 'short' };
		}
		const isMaps = /(^|\.)google\.[a-z.]+$/.test(host) && (path.indexOf('/maps') === 0 || host.indexOf('maps.') === 0);
		if (!isMaps) return { status: 'notmaps' };

		let text = '';
		let fromPlace = false;
		const m = path.match(/\/maps\/place\/([^/]+)/);
		if (m) {
			text = safeDecode(m[1].replace(/\+/g, ' '));
			fromPlace = true;
		} else {
			const q = u.searchParams.get('q') || u.searchParams.get('query') ||
			          u.searchParams.get('destination') || u.searchParams.get('daddr');
			if (q) text = q;
		}
		text = text.trim();

		// Kosong atau hanya koordinat -> tidak ada alamat yang bisa dibaca
		if (!text || /^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/.test(text)) return { status: 'noaddr' };

		// "Nama Tempat, Jl. ..., Kota" -> pisahkan nama & alamat. Kalau diawali jalan/angka, semuanya alamat.
		const parts = text.split(/\s*,\s*/);
		const streetLike = /^(jl\.?|jalan|gg\.?|gang|komp\.?|kompleks|perumahan|dusun|dsn\.?|desa|kel\.?|kec\.?|rt|rw|no\.?)(\s|$)|^\d/i;
		if (parts.length > 1 && !streetLike.test(parts[0])) {
			return { status: 'ok', name: parts[0], address: parts.slice(1).join(', ') };
		}
		// Link /place/ berisi satu nama saja (tanpa alamat) -> dianggap nama tempat
		if (fromPlace && parts.length === 1 && !streetLike.test(text)) {
			return { status: 'ok', name: text, address: '' };
		}
		return { status: 'ok', name: '', address: text };
	}

	mapLink.addEventListener('input', function () {
		const r = parseMapLink(mapLink.value);
		switch (r.status) {
			case 'ok':
				if (r.address) addrFull.value = r.address;
				schedulePreview();
				if (r.address) setMapStatus('ok', 'Alamat terisi otomatis dari link. Silakan periksa sebelum menyimpan.');
				else setMapStatus('info', 'Alamat tidak ada di link ini. Isi alamat secara manual.');
				break;
			case 'short':
				setMapStatus('info', 'Link pendek (maps.app.goo.gl) akan diubah ke link lengkap otomatis saat disimpan. Alamat di bawah isi manual.');
				break;
			case 'noaddr':
				setMapStatus('info', 'Alamat tidak bisa dibaca dari link ini. Isi alamat secara manual.');
				break;
			case 'notmaps':
				setMapStatus('error', 'Ini bukan link Google Maps.');
				break;
			case 'invalid':
				setMapStatus('error', 'Link belum valid.');
				break;
			default:
				setMapStatus('', '');
		}
	});

	/* ===== Header diam di atas; kartu pengaturan bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var card = document.querySelector('#content main .settings-card');
		if (!main || !card) return;
		var cardHead = card.querySelector(':scope > .head');
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
			var cardRect = card.getBoundingClientRect();
			var bar = document.querySelector('.form-actions');

			// Bar tombol mengikuti persis posisi kiri dan lebar card di atasnya.
			if (bar) {
				bar.style.left = cardRect.left + 'px';
				bar.style.width = cardRect.width + 'px';
			}

			var barH = (bar && getComputedStyle(bar).position === 'fixed') ? bar.getBoundingClientRect().height : 0;
			var available = window.innerHeight - cardRect.top - barH - 4;
			if (available < 200) available = 200;
			card.style.maxHeight = available + 'px';
		}
		pinCardHead();
		syncLayout();
		window.addEventListener('resize', syncLayout);
		window.addEventListener('scroll', syncLayout, { passive: true });
		setTimeout(syncLayout, 300);

		// Selalu samakan lebar & posisi bar dengan card, termasuk saat edit mode
		// berubah atau baris sosial media ditambah/dihapus (perubahan ukuran card
		// yang tidak memicu resize/scroll).
		if (window.ResizeObserver) {
			var ro = new ResizeObserver(function () { syncLayout(); });
			ro.observe(card);
		}
	})();
</script>
@endpush