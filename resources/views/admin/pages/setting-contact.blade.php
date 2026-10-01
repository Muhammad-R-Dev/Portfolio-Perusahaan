@extends('admin.layouts.app')

@section('title', 'Pengaturan Kontak & Lokasi | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
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

	/* Ikon sosial media berwarna */
	#content main .prefix .bxl-instagram { color: #e1306c; }
	#content main .prefix .bxl-facebook-circle { color: #1877f2; }
	#content main .prefix .bxl-linkedin-square { color: #0a66c2; }
	#content main .prefix .bxl-youtube { color: #ff0000; }
	#content main .prefix .bxl-tiktok { color: var(--dark); }
	#content main .prefix .bxl-twitter { color: #1da1f2; }
	#content main .prefix .bxl-whatsapp { color: #25d366; }

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

	/* Preview lokasi */
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

	#content main .form-actions {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 12px;
		margin-top: 24px;
	}

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
	body.dark #content main .map-preview .btn-open {
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
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Pengaturan Kontak &amp; Lokasi</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="{{ route('admin.setting.index') }}">Settings</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Kontak &amp; Lokasi</a></li>
					</ul>
				</div>
			</div>

			<div class="alert" id="mockAlert">
				<i class='bx bx-info-circle'></i>
				<span>Tampilan ini masih mockup, perubahan belum disimpan ke server.</span>
			</div>

			<form id="contactForm" action="#" method="POST">
				@csrf

				<div class="settings-wrapper">

					<div class="settings-card" style="flex-basis: 100%;">
						<div class="head">
							<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" title="Kembali ke Settings">
								<i class='bx bx-arrow-back'></i>
							</a>
							<i class='bx bxs-contact'></i>
							<h3>Kontak &amp; Lokasi</h3>
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
											<input type="text" class="form-control" id="wa_number" name="wa_number" value="81234567890" placeholder="81234567890" inputmode="numeric">
										</div>
										<small class="hint">Tulis tanpa angka 0 di depan dan tanpa spasi/tanda hubung. Contoh: 81234567890</small>
										<a href="#" target="_blank" rel="noopener" class="wa-check" id="waCheck">
											<i class='bx bxl-whatsapp'></i> Tes buka chat WhatsApp
										</a>
									</div>
								</section>

								<section class="settings-section">
									<div class="head sub">
										<i class='bx bxs-map'></i>
										<h3>Lokasi</h3>
										<p>Tempel link Google Maps, alamat akan terisi otomatis.</p>
									</div>

									<div class="form-group">
										<label for="map_link">Link Google Maps</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bx-link'></i></span>
											<input type="text" class="form-control" id="map_link" name="map_link" value="https://maps.google.com/?q=Yogyakarta" placeholder="https://www.google.com/maps/place/..." inputmode="url" autocomplete="off">
										</div>
										<small class="hint">Buka Google Maps, cari lokasi kantor, lalu salin link lengkap dari address bar browser.</small>
										<div class="map-status" id="mapStatus"></div>
									</div>

									<div class="form-group">
										<label for="address_full">Alamat Lengkap</label>
										<textarea class="form-control" id="address_full" name="address_full" placeholder="Jl. ..., Kelurahan, Kecamatan, Kota, Kode Pos">Jl. Contoh No. 123, Caturtunggal, Depok, Sleman, Yogyakarta 55281</textarea>
									</div>

									<div class="form-group">
										<label for="address_name">Nama Lokasi / Kantor</label>
										<input type="text" class="form-control" id="address_name" name="address_name" value="Kantor Astabrata Teknologi" placeholder="Contoh: Kantor Pusat Astabrata Teknologi">
									</div>
								</section>
							</div>

							<div class="settings-col">
								<section class="settings-section">
									<div class="head sub">
										<i class='bx bx-share-alt'></i>
										<h3>Sosial Media</h3>
										<p>Isi link akun yang dimiliki, kosongkan yang tidak dipakai.</p>
									</div>

									<div class="form-group">
										<label for="social_youtube">YouTube</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bxl-youtube'></i></span>
											<input type="text" class="form-control" id="social_youtube" name="social_youtube" value="" placeholder="https://youtube.com/@channel" inputmode="url" autocomplete="off">
										</div>
										<span class="field-warn" id="social_youtube_warn"></span>
									</div>
									<div class="form-group">
										<label for="social_facebook">Facebook</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bxl-facebook-circle'></i></span>
											<input type="text" class="form-control" id="social_facebook" name="social_facebook" value="" placeholder="https://facebook.com/namahalaman" inputmode="url" autocomplete="off">
										</div>
										<span class="field-warn" id="social_facebook_warn"></span>
									</div>
									<div class="form-group">
										<label for="social_instagram">Instagram</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bxl-instagram'></i></span>
											<input type="text" class="form-control" id="social_instagram" name="social_instagram" value="https://instagram.com/astabrata" placeholder="https://instagram.com/username" inputmode="url" autocomplete="off">
										</div>
										<span class="field-warn" id="social_instagram_warn"></span>
									</div>
									<div class="form-group">
										<label for="social_linkedin">LinkedIn</label>
										<div class="input-prefix">
											<span class="prefix"><i class='bx bxl-linkedin-square'></i></span>
											<input type="text" class="form-control" id="social_linkedin" name="social_linkedin" value="" placeholder="https://linkedin.com/company/nama" inputmode="url" autocomplete="off">
										</div>
										<span class="field-warn" id="social_linkedin_warn"></span>
									</div>
								</section>

								<section class="settings-section">
									<div class="head sub">
										<i class='bx bxs-map-pin'></i>
										<h3>Preview Lokasi</h3>
										<p>Tampilan lokasi di halaman kontak.</p>
									</div>

									<div class="map-preview" style="margin-top: 0;">
										<div class="pin"><i class='bx bxs-map-pin'></i></div>
										<div class="info">
											<strong id="previewName">Kantor Astabrata Teknologi</strong>
											<span id="previewAddress">Jl. Contoh No. 123, Caturtunggal, Depok, Sleman, Yogyakarta 55281</span>
											<a href="#" target="_blank" rel="noopener" class="btn-open" id="previewMapBtn">
												<i class='bx bx-link-external'></i> Buka di Google Maps
											</a>
										</div>
									</div>
								</section>
							</div>

						</div>
					</div>

				</div>

				<div class="form-actions">
					<button type="submit" class="btn-save">
						<i class='bx bx-save'></i>
						Simpan Perubahan
					</button>
				</div>
			</form>
@endsection

@push('scripts')
<script>
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
	const addrName = document.getElementById('address_name');
	const addrFull = document.getElementById('address_full');
	const mapLink  = document.getElementById('map_link');
	const prevName = document.getElementById('previewName');
	const prevAddr = document.getElementById('previewAddress');
	const prevBtn  = document.getElementById('previewMapBtn');

	function updatePreview() {
		prevName.textContent = addrName.value || 'Nama lokasi belum diisi';
		prevAddr.textContent = addrFull.value || 'Alamat belum diisi';

		const link = mapLink.value.trim();
		if (/^https?:\/\//i.test(link)) {
			prevBtn.href = link;
			prevBtn.classList.remove('disabled');
		} else {
			prevBtn.href = '#';
			prevBtn.classList.add('disabled');
		}
	}
	[addrName, addrFull, mapLink].forEach(el => el.addEventListener('input', updatePreview));
	updatePreview();

	// ===== Sosial media: cek link sesuai platform =====
	const SOCIAL_DOMAINS = {
		social_youtube:   { label: 'YouTube',   domains: ['youtube.com', 'youtu.be'] },
		social_facebook:  { label: 'Facebook',  domains: ['facebook.com', 'fb.com', 'fb.me', 'fb.watch'] },
		social_instagram: { label: 'Instagram', domains: ['instagram.com', 'instagr.am'] },
		social_linkedin:  { label: 'LinkedIn',  domains: ['linkedin.com', 'lnkd.in'] }
	};

	// Link boleh tanpa https:// ; kembalikan URL atau null kalau tidak valid
	function toUrl(raw) {
		const v = (raw || '').trim();
		const withScheme = /^[a-z][a-z0-9+.-]*:\/\//i.test(v) ? v : 'https://' + v;
		try {
			const u = new URL(withScheme);
			if (!/^https?:$/.test(u.protocol) || !u.hostname.includes('.')) return null;
			return u;
		} catch (err) { return null; }
	}

	Object.keys(SOCIAL_DOMAINS).forEach(function (id) {
		const input = document.getElementById(id);
		const warn  = document.getElementById(id + '_warn');
		const cfg   = SOCIAL_DOMAINS[id];

		function check() {
			const v = input.value.trim();
			let msg = '';
			if (v) {
				const u = toUrl(v);
				if (!u) msg = 'Link belum valid.';
				else {
					const host = u.hostname.toLowerCase();
					if (!cfg.domains.some(d => host === d || host.endsWith('.' + d))) {
						msg = 'Ini bukan link ' + cfg.label + '.';
					}
				}
			}
			warn.textContent = msg;
			warn.classList.toggle('show', !!msg);
		}
		input.addEventListener('input', check);
		check();
	});

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
				if (r.name) addrName.value = r.name;
				if (r.address) addrFull.value = r.address;
				updatePreview();
				if (r.address) setMapStatus('ok', 'Alamat terisi otomatis dari link. Silakan periksa sebelum menyimpan.');
				else setMapStatus('info', 'Nama lokasi terisi dari link, tetapi alamatnya tidak ada di link. Isi alamat secara manual.');
				break;
			case 'short':
				setMapStatus('info', 'Link pendek (maps.app.goo.gl) belum bisa dibaca otomatis. Buka link-nya, salin link lengkap dari address bar, atau isi alamat manual.');
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

	// ===== Simpan: belum ada backend =====
	document.getElementById('contactForm').addEventListener('submit', function (e) {
		e.preventDefault();
		const el = document.getElementById('mockAlert');
		el.classList.add('show');
		window.scrollTo({ top: 0, behavior: 'smooth' });
		clearTimeout(window._mockTimer);
		window._mockTimer = setTimeout(() => el.classList.remove('show'), 4000);
	});
</script>
@endpush