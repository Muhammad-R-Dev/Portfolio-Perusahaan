@extends('admin.layouts.app')

@section('title', 'Edit Welcome | Admin Astabrata Teknologi')
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
		grid-gap: 12px;
		margin-bottom: 24px;
		flex-wrap: wrap;
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

	/* Layout 2 kolom: kiri teks, kanan uploader */
	#content main .welcome-layout {
		display: grid;
		grid-template-columns: 1fr 380px;
		grid-gap: 32px;
		align-items: start;
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
		padding: 0 16px;
		height: 44px;
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
		min-height: 200px;
		resize: vertical;
	}
	#content main .form-group .form-control:focus {
		border-color: var(--blue);
		background: var(--light);
	}
	#content main .form-group .form-control:disabled {
		background: var(--grey);
		color: var(--dark);
		-webkit-text-fill-color: var(--dark);
		cursor: not-allowed;
		opacity: 1;
	}
	#content main .form-group small.hint {
		display: block;
		margin-top: 6px;
		font-size: 12px;
		color: var(--dark-grey);
	}

	/* ===== UPLOADER MEDIA ===== */
	#content main .media-uploader > label.title {
		display: block;
		font-size: 14px;
		font-weight: 500;
		margin-bottom: 8px;
		color: var(--dark);
	}
	#content main .dropzone {
		position: relative;
		width: 100%;
		aspect-ratio: 12 / 7;
		border-radius: 14px;
		background: var(--grey) center / cover no-repeat;
		border: 2px dashed var(--dark-grey);
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		grid-gap: 6px;
		overflow: hidden;
		color: var(--dark-grey);
		font-size: 13px;
		text-align: center;
		padding: 12px;
		cursor: pointer;
		transition: .2s ease;
		outline: none;
	}
	#content main .dropzone:hover,
	#content main .dropzone:focus-visible {
		border-color: var(--blue);
		color: var(--blue);
	}
	/* Mode lihat: dropzone terkunci (hanya bisa preview jika sudah ada gambar) */
	#content main .dropzone.is-locked,
	#content main .dropzone.is-locked:hover,
	#content main .dropzone.is-locked:focus-visible {
		cursor: not-allowed;
		border-color: var(--dark-grey);
		color: var(--dark-grey);
	}
	#content main .dropzone.is-locked.has-image,
	#content main .dropzone.is-locked.has-image:hover {
		cursor: pointer;
		border-color: var(--grey);
	}
	#content main .dropzone.dragover {
		border-color: var(--blue);
		background-color: var(--light-blue);
		color: var(--blue);
	}
	#content main .dropzone .bx { font-size: 40px; }
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
		font-size: 14px;
		font-weight: 500;
		opacity: 0;
		transition: .2s ease;
	}
	#content main .dropzone .overlay .bx { font-size: 24px; }
	#content main .dropzone.has-image:hover .overlay { opacity: 1; }
	#content main .dropzone .badge {
		position: absolute;
		top: 10px;
		left: 10px;
		padding: 3px 10px;
		border-radius: 20px;
		font-size: 11px;
		font-weight: 600;
		color: #fff;
		background: var(--orange);
	}

	#content main .file-meta {
		display: flex;
		align-items: center;
		grid-gap: 6px;
		margin-top: 10px;
		font-size: 12.5px;
		color: var(--dark-grey);
		min-width: 0;
	}
	#content main .file-meta .bx { font-size: 16px; flex-shrink: 0; }
	#content main .file-meta .fname {
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}
	#content main .file-meta.picked { color: var(--blue); font-weight: 500; }
	#content main .file-error {
		display: none;
		margin-top: 6px;
		font-size: 12.5px;
		color: #a13e1e;
	}
	#content main .file-error.show { display: block; }

	#content main .media-actions {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 10px;
		margin-top: 14px;
	}
	#content main .media-actions input[type="file"] { display: none; }
	.btn-act {
		height: 38px;
		padding: 0 16px;
		border-radius: 36px;
		font-family: var(--poppins);
		font-size: 13px;
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

	#content main .media-uploader small.hint {
		display: block;
		margin-top: 12px;
		font-size: 12px;
		color: var(--dark-grey);
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
	#content main .btn-back-inline.is-disabled {
		opacity: .4;
		cursor: not-allowed;
		pointer-events: none;
	}

	/* ===== MODAL PREVIEW ===== */
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
		max-width: 960px;
		max-height: 92vh;
		overflow-y: auto;
		font-family: var(--poppins);
		color: var(--dark);
		padding: 18px;
	}
	.modal-box .modal-image {
		width: 100%;
		aspect-ratio: 12 / 7;
		border-radius: 12px;
		background: var(--grey) center / contain no-repeat;
		border: 1px solid var(--grey);
		margin-bottom: 14px;
	}
	.modal-box .modal-actions {
		display: flex;
		align-items: center;
		justify-content: space-between;
		grid-gap: 10px;
	}
	.modal-box .modal-actions span {
		font-size: 13px;
		color: var(--dark-grey);
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	/* Modal konfirmasi batal */
	.modal-box.small {
		max-width: 380px;
		text-align: center;
		padding: 32px 28px;
	}
	.modal-box.small .confirm-icon {
		width: 64px;
		height: 64px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto 16px;
		font-size: 34px;
		background: var(--light-orange);
		color: var(--orange);
	}
	.modal-box.small h4 { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
	.modal-box.small p { font-size: 13px; color: var(--dark-grey); line-height: 1.6; }
	.modal-box.small .modal-actions { justify-content: center; margin-top: 24px; }

	body.dark #content main .btn-save,
	body.dark #content main .btn-save:hover,
	body.dark .btn-act.primary {
		background: var(--blue) !important;
		color: #fff !important;
	}
	body.dark .btn-act.outline {
		background: transparent !important;
		border-color: var(--dark-grey) !important;
		color: var(--dark) !important;
	}

	@media screen and (max-width: 992px) {
		#content main .welcome-layout { grid-template-columns: 1fr; }
		#content main .form-group textarea.form-control { min-height: 130px; }
	}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Edit Welcome</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="{{ route('admin.setting.index') }}">Settings</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">Welcome</a></li>
					</ul>
				</div>
			</div>

			<div class="alert" id="mockAlert">
				<i class='bx bx-info-circle'></i>
				<span>Tampilan ini masih mockup, perubahan belum disimpan ke server.</span>
			</div>

			<div class="settings-wrapper">

				<div class="settings-card" style="flex-basis: 100%;">
					<div class="head">
						<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" id="btnBack" title="Kembali ke Settings">
							<i class='bx bx-arrow-back'></i>
						</a>
						<i class='bx bxs-happy-heart-eyes'></i>
						<h3>Welcome Section</h3>
					</div>

					<form id="welcomeForm" action="#" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="welcome-layout">

							{{-- KIRI: Judul & Teks --}}
							<div class="welcome-fields">
								<div class="form-group">
									<label for="welcome_title">Judul</label>
									<input type="text" class="form-control" id="welcome_title" name="welcome_title" value="Astabrata Teknologi" placeholder="Judul utama" disabled>
								</div>

								<div class="form-group">
									<label for="welcome_text">Teks</label>
									<textarea class="form-control" id="welcome_text" name="welcome_text" placeholder="Tulis teks di sini..." disabled>Kami membantu mewujudkan solusi digital terbaik untuk kebutuhan bisnis Anda.</textarea>
									<small class="hint">Teks ini akan tampil sebagai paragraf di halaman welcome.</small>
								</div>
							</div>

							{{-- KANAN: Uploader media --}}
							<div class="media-uploader">
								<label class="title">Gambar Welcome</label>

								<div class="dropzone" id="dropzone" tabindex="0" role="button" aria-label="Unggah gambar welcome"></div>

								<div class="file-meta" id="fileMeta">
									<i class='bx bx-file-blank'></i>
									<span class="fname" id="fileName">Belum ada file</span>
								</div>
								<div class="file-error" id="fileError"></div>

								<div class="media-actions">
									<input type="file" id="welcome_image" name="welcome_image" accept="image/jpeg,image/png,image/webp" disabled>
									<button type="button" class="btn-act soft" id="btnPick">
										<i class='bx bx-upload'></i> <span id="btnPickText">Pilih Gambar</span>
									</button>
									<button type="button" class="btn-act outline" id="btnPreview" disabled>
										<i class='bx bx-show'></i> Preview
									</button>
									<button type="button" class="btn-act danger" id="btnRemove" disabled>
										<i class='bx bx-trash'></i> Hapus
									</button>
								</div>

								<small class="hint">Disarankan ukuran 1200x700px, maks. 3MB. Format JPG/PNG/WEBP.</small>
							</div>

						</div>

						<div class="form-actions">
							<button type="button" class="btn-save" id="toggleEditBtn" data-mode="view">
								<i class='bx bx-edit-alt' id="toggleEditIcon"></i>
								<span id="toggleEditLabel">Edit</span>
							</button>
							<button type="button" class="btn-cancel-edit" id="btnCancelEdit" hidden>
								<i class='bx bx-x'></i>
								Batal
							</button>
						</div>
					</form>
				</div>

			</div>

			<!-- Modal Preview (lightbox) -->
			<div class="modal-overlay" id="previewModal">
				<div class="modal-box">
					<div class="modal-image" id="previewImage"></div>
					<div class="modal-actions">
						<span id="previewCaption"></span>
						<button type="button" class="btn-act outline" id="btnClosePreview">Tutup</button>
					</div>
				</div>
			</div>

			<!-- Modal Konfirmasi Batal -->
			<div class="modal-overlay" id="cancelModal">
				<div class="modal-box small">
					<div class="confirm-icon"><i class='bx bx-undo'></i></div>
					<h4>Batalkan Perubahan?</h4>
					<p>Perubahan yang sudah Anda buat tidak akan disimpan dan data akan kembali seperti semula.</p>
					<div class="modal-actions">
						<button type="button" class="btn-act outline" id="btnKeepEditing">Lanjut Edit</button>
						<button type="button" class="btn-act primary" id="btnDiscard">Ya, Batalkan</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
	const MAX_SIZE = 3 * 1024 * 1024; // 3MB
	const ALLOWED  = ['image/jpeg', 'image/png', 'image/webp'];

	const dropzone   = document.getElementById('dropzone');
	const fileInput  = document.getElementById('welcome_image');
	const fileMeta   = document.getElementById('fileMeta');
	const fileName   = document.getElementById('fileName');
	const fileError  = document.getElementById('fileError');
	const btnPick    = document.getElementById('btnPick');
	const btnPickTxt = document.getElementById('btnPickText');
	const btnPreview = document.getElementById('btnPreview');
	const btnRemove  = document.getElementById('btnRemove');
	const previewModal = document.getElementById('previewModal');

	const titleInput = document.getElementById('welcome_title');
	const textInput  = document.getElementById('welcome_text');
	const toggleBtn  = document.getElementById('toggleEditBtn');
	const toggleIcon = document.getElementById('toggleEditIcon');
	const toggleLbl  = document.getElementById('toggleEditLabel');
	const btnBack    = document.getElementById('btnBack');

	let current = null; // { name, size, url, saved } (hanya di memori, mockup)
	let editing = false; // false = mode lihat, true = mode edit

	const btnCancelEdit = document.getElementById('btnCancelEdit');
	const cancelModal   = document.getElementById('cancelModal');

	// Data terakhir yang "tersimpan" (dipakai untuk membatalkan perubahan)
	let saved = { title: titleInput.value, text: textInput.value, image: current };

	function formatSize(bytes) {
		if (bytes < 1024 * 1024) return Math.round(bytes / 1024) + ' KB';
		return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
	}

	function showError(msg) {
		fileError.textContent = msg || '';
		fileError.classList.toggle('show', !!msg);
	}

	function render() {
		dropzone.classList.toggle('is-locked', !editing);
		dropzone.setAttribute('aria-disabled', editing ? 'false' : 'true');

		if (!current) {
			dropzone.classList.remove('has-image');
			dropzone.style.backgroundImage = '';
			dropzone.innerHTML = editing
				? "<i class='bx bx-cloud-upload'></i><span><strong>Klik untuk unggah</strong><br>atau seret &amp; lepas gambar</span>"
				: "<i class='bx bx-image'></i><span>Belum ada gambar</span>";
			fileName.textContent = 'Belum ada file';
			fileMeta.classList.remove('picked');
			btnPickTxt.textContent = 'Pilih Gambar';
		} else {
			dropzone.classList.add('has-image');
			dropzone.style.backgroundImage = "url('" + current.url + "')";
			dropzone.innerHTML = (current.saved ? '' : "<span class='badge'>Belum disimpan</span>") + "<div class='overlay'><i class='bx bx-show'></i> Lihat preview</div>";
			fileName.textContent = current.name + ' (' + formatSize(current.size) + ')';
			fileMeta.classList.add('picked');
			btnPickTxt.textContent = 'Ganti Gambar';
		}
		btnPreview.disabled = !current;            // preview boleh di mode lihat
		btnRemove.disabled  = !current || !editing;
		btnPick.disabled    = !editing;
	}

	// ===== Mode lihat / edit =====
	function setEditing(on) {
		editing = on;
		titleInput.disabled = !on;
		textInput.disabled  = !on;
		fileInput.disabled  = !on;
		showError('');

		// Tombol kembali dinonaktifkan selama mode edit
		btnBack.classList.toggle('is-disabled', on);
		btnBack.setAttribute('aria-disabled', on ? 'true' : 'false');
		btnBack.tabIndex = on ? -1 : 0;

		btnCancelEdit.hidden = !on;
		toggleBtn.dataset.mode = on ? 'edit' : 'view';
		toggleIcon.className   = on ? 'bx bx-save' : 'bx bx-edit-alt';
		toggleLbl.textContent  = on ? 'Simpan' : 'Edit';

		render();
		if (on) titleInput.focus();
	}

	function handleFile(file) {
		showError('');
		if (!file) return;

		if (!ALLOWED.includes(file.type)) {
			showError('Format harus JPG, PNG, atau WEBP.');
			return;
		}
		if (file.size > MAX_SIZE) {
			showError('Ukuran gambar maksimal 3MB (file ini ' + formatSize(file.size) + ').');
			return;
		}

		const reader = new FileReader();
		reader.onload = function (ev) {
			current = { name: file.name, size: file.size, url: ev.target.result };
			render();
		};
		reader.readAsDataURL(file);
	}

	// Klik dropzone: kosong -> pilih file, sudah ada -> preview
	dropzone.addEventListener('click', function () {
		if (current) openPreview();
		else if (editing) fileInput.click();
	});
	dropzone.addEventListener('keydown', function (e) {
		if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); dropzone.click(); }
	});

	// Drag & drop
	['dragenter', 'dragover'].forEach(ev => dropzone.addEventListener(ev, function (e) {
		e.preventDefault();
		if (editing) dropzone.classList.add('dragover');
	}));
	['dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, function (e) {
		e.preventDefault();
		dropzone.classList.remove('dragover');
	}));
	dropzone.addEventListener('drop', e => { if (editing) handleFile(e.dataTransfer.files[0]); });

	btnPick.addEventListener('click', () => fileInput.click());
	fileInput.addEventListener('change', function () {
		handleFile(this.files[0]);
		this.value = ''; // supaya file yang sama bisa dipilih lagi
	});

	btnRemove.addEventListener('click', function () {
		if (!editing) return;
		current = null;
		showError('');
		render();
	});

	// ===== Preview (lightbox) =====
	function openPreview() {
		if (!current) return;
		document.getElementById('previewImage').style.backgroundImage = "url('" + current.url + "')";
		document.getElementById('previewCaption').textContent = current.name;
		previewModal.classList.add('show');
	}
	function closePreview() { previewModal.classList.remove('show'); }

	btnPreview.addEventListener('click', openPreview);
	document.getElementById('btnClosePreview').addEventListener('click', closePreview);
	previewModal.addEventListener('click', e => { if (e.target === previewModal) closePreview(); });
	document.addEventListener('keydown', e => { if (e.key === 'Escape') { closePreview(); closeCancelModal(); } });

	// ===== Batal edit =====
	function hasChanges() {
		return titleInput.value !== saved.title
			|| textInput.value !== saved.text
			|| current !== saved.image;
	}
	function openCancelModal()  { cancelModal.classList.add('show'); }
	function closeCancelModal() { cancelModal.classList.remove('show'); }

	btnCancelEdit.addEventListener('click', function () {
		if (hasChanges()) openCancelModal();
		else setEditing(false); // tidak ada perubahan, langsung keluar dari mode edit
	});
	document.getElementById('btnKeepEditing').addEventListener('click', closeCancelModal);
	document.getElementById('btnDiscard').addEventListener('click', function () {
		titleInput.value = saved.title;
		textInput.value  = saved.text;
		current = saved.image;
		closeCancelModal();
		setEditing(false);
	});
	cancelModal.addEventListener('click', e => { if (e.target === cancelModal) closeCancelModal(); });

	// Tombol Edit <-> Simpan. Belum ada backend, jadi simpan hanya menampilkan info.
	toggleBtn.addEventListener('click', function () {
		if (!editing) {
			setEditing(true);
			return;
		}

		// Sedang edit -> "Simpan"
		if (current) current.saved = true;
		saved = { title: titleInput.value, text: textInput.value, image: current };
		setEditing(false);

		const el = document.getElementById('mockAlert');
		el.classList.add('show');
		window.scrollTo({ top: 0, behavior: 'smooth' });
		clearTimeout(window._mockTimer);
		window._mockTimer = setTimeout(() => el.classList.remove('show'), 4000);
	});

	// Jaga-jaga: blokir klik/Enter pada tombol kembali saat mode edit
	btnBack.addEventListener('click', function (e) {
		if (editing) e.preventDefault();
	});

	// Cegah submit form (Enter di input) karena belum ada backend
	document.getElementById('welcomeForm').addEventListener('submit', e => e.preventDefault());

	render();
</script>
@endpush