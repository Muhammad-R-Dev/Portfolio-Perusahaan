@extends('admin.layouts.app')

@section('title', 'Pengaturan Banner | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
<style>
	#content main .settings-wrapper {
		margin-top: 36px;
		width: 100%;
		color: var(--dark);
	}
	#content main .settings-card {
		border-radius: 20px;
		background: var(--light);
		padding: 24px;
	}
	#content main .settings-card .head {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		grid-gap: 12px;
		margin-bottom: 20px;
	}
	#content main .settings-card .head .bx { font-size: 24px; color: var(--blue); }
	#content main .settings-card .head h3 { font-size: 22px; font-weight: 600; }
	#content main .settings-card .head p {
		width: 100%;
		font-size: 13px;
		color: var(--dark-grey);
		margin-top: 4px;
	}

	/* Daftar linier */
	#content main .banner-list {
		display: flex;
		flex-direction: column;
		grid-gap: 14px;
	}
	#content main .banner-row {
		display: flex;
		align-items: center;
		grid-gap: 22px;
		border: 1px solid var(--grey);
		border-radius: 14px;
		padding: 16px 20px;
	}

	/* ===== DROPZONE / UPLOADER ===== */
	#content main .dropzone {
		position: relative;
		flex-shrink: 0;
		width: 260px;
		aspect-ratio: 16 / 7;
		border-radius: 12px;
		background: var(--grey) center / cover no-repeat;
		border: 2px dashed var(--dark-grey);
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		grid-gap: 4px;
		overflow: hidden;
		color: var(--dark-grey);
		font-size: 12.5px;
		text-align: center;
		padding: 8px;
		cursor: pointer;
		transition: .2s ease;
		outline: none;
	}
	#content main .dropzone:hover,
	#content main .dropzone:focus-visible {
		border-color: var(--blue);
		color: var(--blue);
	}
	#content main .dropzone.dragover {
		border-color: var(--blue);
		background-color: var(--light-blue);
		color: var(--blue);
	}
	#content main .dropzone .bx { font-size: 32px; }
	#content main .dropzone strong { font-weight: 600; }
	#content main .dropzone.has-image {
		border-style: solid;
		border-color: var(--grey);
		padding: 0;
	}
	#content main .dropzone .overlay {
		position: absolute;
		inset: 0;
		background: rgba(0,0,0,.45);
		color: #fff;
		display: flex;
		align-items: center;
		justify-content: center;
		grid-gap: 6px;
		font-size: 13px;
		font-weight: 500;
		opacity: 0;
		transition: .2s ease;
	}
	#content main .dropzone .overlay .bx { font-size: 22px; }
	#content main .dropzone.has-image:hover .overlay { opacity: 1; }
	#content main .dropzone .badge {
		position: absolute;
		top: 8px;
		left: 8px;
		padding: 3px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
		color: #fff;
		background: rgba(0,0,0,.6);
	}
	#content main .dropzone .badge.pending { background: var(--orange); }
	#content main .dropzone .badge.saved { background: #2e9e5b; }

	/* Info di tengah */
	#content main .banner-info {
		flex: 1;
		min-width: 0;
	}
	#content main .banner-info h4 {
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 4px;
	}
	#content main .banner-info p {
		font-size: 13px;
		color: var(--dark-grey);
		line-height: 1.5;
	}
	#content main .banner-info .file-meta {
		display: flex;
		align-items: center;
		grid-gap: 6px;
		margin-top: 8px;
		font-size: 12.5px;
		color: var(--dark-grey);
		min-width: 0;
	}
	#content main .banner-info .file-meta .bx { font-size: 16px; flex-shrink: 0; }
	#content main .banner-info .file-meta .fname {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	#content main .banner-info .file-meta.picked { color: var(--blue); font-weight: 500; }
	#content main .banner-info .file-error {
		display: none;
		margin-top: 6px;
		font-size: 12.5px;
		color: #a13e1e;
	}
	#content main .banner-info .file-error.show { display: block; }

	/* Tombol di kanan */
	#content main .banner-actions {
		flex-shrink: 0;
		display: flex;
		align-items: center;
		grid-gap: 10px;
	}
	#content main .banner-actions input[type="file"],
	.modal-box input[type="file"] { display: none; }

	#content main .btn-act,
	.modal-box .btn-act {
		height: 40px;
		padding: 0 18px;
		border-radius: 36px;
		font-family: var(--poppins);
		font-size: 13.5px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		transition: .2s ease;
		white-space: nowrap;
		border: none;
	}
	.btn-act .bx { font-size: 18px; }
	.btn-act:hover { opacity: .9; }
	.btn-act:disabled { opacity: .4; cursor: not-allowed; }
	.btn-act.primary { background: var(--blue); color: var(--light); }
	.btn-act.soft { background: var(--light-blue); color: var(--blue); }
	.btn-act.outline {
		background: transparent;
		border: 1px solid var(--dark-grey);
		color: var(--dark);
	}
	.btn-act.danger { background: var(--light-orange); color: #a13e1e; }

	#content main .hint-bottom {
		margin-top: 16px;
		font-size: 12.5px;
		color: var(--dark-grey);
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

	/* ===== MODAL (Preview & Edit) ===== */
	.modal-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(0, 0, 0, .6);
		z-index: 5000;
		justify-content: center;
		align-items: center;
		padding: 16px;
	}
	.modal-overlay.show { display: flex; }
	.modal-box {
		background: var(--light);
		border-radius: 16px;
		width: 100%;
		max-width: 640px;
		max-height: 92vh;
		overflow-y: auto;
		font-family: var(--poppins);
		color: var(--dark);
		padding: 26px;
	}
	.modal-box h2 { font-size: 20px; margin-bottom: 4px; }
	.modal-box .modal-sub {
		font-size: 13px;
		color: var(--dark-grey);
		margin-bottom: 18px;
		word-break: break-all;
	}
	.modal-box .modal-image {
		width: 100%;
		aspect-ratio: 16 / 7;
		border-radius: 12px;
		background: var(--grey) center / contain no-repeat;
		border: 1px solid var(--grey);
		margin-bottom: 18px;
	}
	.modal-box .modal-actions {
		display: flex;
		flex-wrap: wrap;
		justify-content: flex-end;
		grid-gap: 10px;
	}
	.modal-box.lightbox {
		max-width: 1000px;
		padding: 18px;
	}
	.modal-box.lightbox .modal-image {
		aspect-ratio: 16 / 7;
		margin-bottom: 14px;
	}

	body.dark .btn-act.primary,
	body.dark .btn-act.primary:hover {
		background: var(--blue) !important;
		color: #fff !important;
	}
	body.dark .btn-act.outline {
		background: transparent !important;
		border-color: var(--dark-grey) !important;
		color: var(--dark) !important;
	}
	body.dark #content main .banner-row { border-color: #2a2a3d; }

	@media screen and (max-width: 992px) {
		#content main .banner-row { flex-wrap: wrap; }
		#content main .banner-info { flex-basis: calc(100% - 282px); }
		#content main .banner-actions { width: 100%; flex-wrap: wrap; }
	}
	@media screen and (max-width: 576px) {
		#content main .dropzone { width: 100%; }
		#content main .banner-info { flex-basis: 100%; }
	}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Pengaturan Banner</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="{{ route('admin.setting.index') }}">Settings</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Banner</a></li>
					</ul>
				</div>
			</div>

			<div class="alert" id="mockAlert">
				<i class='bx bx-info-circle'></i>
				<span id="mockAlertText">Tampilan ini masih mockup, perubahan belum disimpan ke server.</span>
			</div>

			@php
				$pages = [
					'blog'    => ['label' => 'Halaman Blog',    'desc' => 'Gambar latar hero section di halaman Blog.'],
					'layanan' => ['label' => 'Halaman Layanan', 'desc' => 'Gambar latar hero section di halaman Layanan.'],
					'about'   => ['label' => 'Halaman About',   'desc' => 'Gambar latar hero section di halaman About.'],
				];
			@endphp

			<div class="settings-wrapper">
				<div class="settings-card">
					<div class="head">
						<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" title="Kembali ke Settings">
							<i class='bx bx-arrow-back'></i>
						</a>
						<i class='bx bxs-image'></i>
						<h3>Media Banner Hero Section</h3>
						<p>Unggah gambar latar hero section untuk tiap halaman. Seret &amp; lepas file ke kotak unggah, atau klik untuk memilih. (Tampilan ini masih mockup, belum terhubung ke backend.)</p>
					</div>

					<div class="banner-list">

						@foreach ($pages as $key => $page)
							<form class="banner-row banner-form" data-key="{{ $key }}" action="#" method="POST" enctype="multipart/form-data">
								@csrf

								<div class="dropzone" id="dz_{{ $key }}" data-key="{{ $key }}" tabindex="0" role="button" aria-label="Unggah banner {{ $page['label'] }}"></div>

								<div class="banner-info">
									<h4>{{ $page['label'] }}</h4>
									<p>{{ $page['desc'] }}</p>
									<div class="file-meta" id="meta_{{ $key }}">
										<i class='bx bx-file-blank'></i>
										<span class="fname" id="fname_{{ $key }}">Belum ada file</span>
									</div>
									<div class="file-error" id="error_{{ $key }}"></div>
								</div>

								<div class="banner-actions">
									<input type="file" id="input_{{ $key }}" name="image" accept="image/jpeg,image/png,image/webp" data-key="{{ $key }}">
									<button type="button" class="btn-act outline btn-preview" data-key="{{ $key }}" disabled>
										<i class='bx bx-show'></i> Preview
									</button>
									<button type="button" class="btn-act soft btn-edit" data-key="{{ $key }}" disabled>
										<i class='bx bx-edit-alt'></i> Edit
									</button>
									<button type="submit" class="btn-act primary btn-save" id="save_{{ $key }}" disabled>
										<i class='bx bx-save'></i> Simpan
									</button>
								</div>
							</form>
						@endforeach

					</div>

					<p class="hint-bottom">Disarankan ukuran 1920x600px, format JPG/PNG/WEBP, maks. 3MB.</p>
				</div>
			</div>

			<!-- Modal Preview (lightbox) -->
			<div class="modal-overlay" id="previewModal">
				<div class="modal-box lightbox">
					<div class="modal-image" id="previewImage"></div>
					<div class="modal-actions">
						<span id="previewCaption" style="margin-right:auto; align-self:center; font-size:13px; color:var(--dark-grey);"></span>
						<button type="button" class="btn-act outline" id="btnClosePreview">Tutup</button>
					</div>
				</div>
			</div>

			<!-- Modal Edit -->
			<div class="modal-overlay" id="editModal">
				<div class="modal-box">
					<h2 id="editTitle">Edit Banner</h2>
					<p class="modal-sub" id="editSub"></p>
					<div class="modal-image" id="editImage"></div>
					<div class="modal-actions">
						<button type="button" class="btn-act danger" id="btnRemove">
							<i class='bx bx-trash'></i> Hapus Gambar
						</button>
						<button type="button" class="btn-act soft" id="btnReplace">
							<i class='bx bx-refresh'></i> Ganti Gambar
						</button>
						<button type="button" class="btn-act primary" id="btnDoneEdit">Selesai</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
	const MAX_SIZE = 3 * 1024 * 1024; // 3MB
	const ALLOWED  = ['image/jpeg', 'image/png', 'image/webp'];
	const LABELS   = { blog: 'Halaman Blog', layanan: 'Halaman Layanan', about: 'Halaman About' };

	// Status per halaman (mockup, hanya di memori browser)
	const state = { blog: null, layanan: null, about: null };
	let editKey = null;

	function formatSize(bytes) {
		if (bytes < 1024 * 1024) return Math.round(bytes / 1024) + ' KB';
		return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
	}

	function showMockAlert(text) {
		const el = document.getElementById('mockAlert');
		document.getElementById('mockAlertText').textContent = text || 'Tampilan ini masih mockup, perubahan belum disimpan ke server.';
		el.classList.add('show');
		window.scrollTo({ top: 0, behavior: 'smooth' });
		clearTimeout(window._mockTimer);
		window._mockTimer = setTimeout(() => el.classList.remove('show'), 4000);
	}

	function showError(key, msg) {
		const el = document.getElementById('error_' + key);
		el.textContent = msg;
		el.classList.toggle('show', !!msg);
	}

	// ===== Render satu baris uploader =====
	function render(key) {
		const dz   = document.getElementById('dz_' + key);
		const item = state[key];
		const meta = document.getElementById('meta_' + key);
		const fname = document.getElementById('fname_' + key);

		if (!item) {
			dz.classList.remove('has-image');
			dz.style.backgroundImage = '';
			dz.innerHTML = "<i class='bx bx-cloud-upload'></i><span><strong>Klik untuk unggah</strong><br>atau seret &amp; lepas gambar</span>";
			fname.textContent = 'Belum ada file';
			meta.classList.remove('picked');
		} else {
			dz.classList.add('has-image');
			dz.style.backgroundImage = "url('" + item.url + "')";
			dz.innerHTML =
				"<span class='badge " + (item.saved ? 'saved' : 'pending') + "'>" + (item.saved ? 'Tersimpan' : 'Belum disimpan') + "</span>" +
				"<div class='overlay'><i class='bx bx-show'></i> Lihat preview</div>";
			fname.textContent = item.name + ' (' + formatSize(item.size) + ')';
			meta.classList.add('picked');
		}

		document.querySelector('.btn-preview[data-key="' + key + '"]').disabled = !item;
		document.querySelector('.btn-edit[data-key="' + key + '"]').disabled = !item;
		document.getElementById('save_' + key).disabled = !item || item.saved;
	}

	// ===== Proses file yang dipilih / di-drop =====
	function handleFile(key, file) {
		showError(key, '');
		if (!file) return;

		if (!ALLOWED.includes(file.type)) {
			showError(key, 'Format harus JPG, PNG, atau WEBP.');
			return;
		}
		if (file.size > MAX_SIZE) {
			showError(key, 'Ukuran gambar maksimal 3MB (file ini ' + formatSize(file.size) + ').');
			return;
		}

		const reader = new FileReader();
		reader.onload = function (ev) {
			state[key] = { name: file.name, size: file.size, url: ev.target.result, saved: false };
			render(key);
			if (editKey === key) refreshEditModal();
		};
		reader.readAsDataURL(file);
	}

	// ===== Pasang event tiap baris =====
	Object.keys(state).forEach(function (key) {
		const dz    = document.getElementById('dz_' + key);
		const input = document.getElementById('input_' + key);

		// Klik: kosong -> pilih file, sudah ada -> preview
		dz.addEventListener('click', function () {
			if (state[key]) openPreview(key);
			else input.click();
		});
		dz.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); dz.click(); }
		});

		// Drag & drop
		['dragenter', 'dragover'].forEach(ev => dz.addEventListener(ev, function (e) {
			e.preventDefault();
			dz.classList.add('dragover');
		}));
		['dragleave', 'drop'].forEach(ev => dz.addEventListener(ev, function (e) {
			e.preventDefault();
			dz.classList.remove('dragover');
		}));
		dz.addEventListener('drop', function (e) {
			handleFile(key, e.dataTransfer.files[0]);
		});

		input.addEventListener('change', function () {
			handleFile(key, this.files[0]);
			this.value = ''; // supaya file yang sama bisa dipilih lagi
		});

		render(key);
	});

	// Tombol Preview & Edit di tiap baris
	document.querySelectorAll('.btn-preview').forEach(b => b.addEventListener('click', () => openPreview(b.dataset.key)));
	document.querySelectorAll('.btn-edit').forEach(b => b.addEventListener('click', () => openEdit(b.dataset.key)));

	// Simpan (mockup)
	document.querySelectorAll('.banner-form').forEach(function (form) {
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			const key = this.dataset.key;
			if (!state[key]) return;
			state[key].saved = true;
			render(key);
			showMockAlert('Banner ' + LABELS[key] + ' ditandai tersimpan (mockup, belum dikirim ke server).');
		});
	});

	// ===== Modal Preview =====
	const previewModal = document.getElementById('previewModal');

	function openPreview(key) {
		if (!state[key]) return;
		document.getElementById('previewImage').style.backgroundImage = "url('" + state[key].url + "')";
		document.getElementById('previewCaption').textContent = LABELS[key] + ' - ' + state[key].name;
		previewModal.classList.add('show');
	}
	function closePreview() { previewModal.classList.remove('show'); }

	document.getElementById('btnClosePreview').addEventListener('click', closePreview);
	previewModal.addEventListener('click', e => { if (e.target === previewModal) closePreview(); });

	// ===== Modal Edit =====
	const editModal = document.getElementById('editModal');

	function refreshEditModal() {
		const item = state[editKey];
		if (!item) { closeEdit(); return; }
		document.getElementById('editImage').style.backgroundImage = "url('" + item.url + "')";
		document.getElementById('editSub').textContent = item.name + ' (' + formatSize(item.size) + ')';
	}

	function openEdit(key) {
		if (!state[key]) return;
		editKey = key;
		document.getElementById('editTitle').textContent = 'Edit Banner ' + LABELS[key];
		refreshEditModal();
		editModal.classList.add('show');
	}
	function closeEdit() {
		editModal.classList.remove('show');
		editKey = null;
	}

	document.getElementById('btnReplace').addEventListener('click', function () {
		if (editKey) document.getElementById('input_' + editKey).click();
	});
	document.getElementById('btnRemove').addEventListener('click', function () {
		if (!editKey) return;
		const key = editKey;
		state[key] = null;
		showError(key, '');
		render(key);
		closeEdit();
	});
	document.getElementById('btnDoneEdit').addEventListener('click', closeEdit);
	editModal.addEventListener('click', e => { if (e.target === editModal) closeEdit(); });

	// Esc menutup modal
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') { closePreview(); closeEdit(); }
	});
</script>
@endpush