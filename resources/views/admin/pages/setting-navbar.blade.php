@extends('admin.layouts.app')

@section('title', 'Pengaturan Header & Footer | Admin Astabrata Teknologi')
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

	/* Success toast */
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

					<form id="navbarForm" action="#" method="POST" enctype="multipart/form-data">
						@csrf

						<div class="settings-main-row">
							<div class="settings-fields">
								<div class="form-group">
									<label for="logo_name">Nama Logo</label>
									<input type="text" class="form-control" id="logo_name" name="logo_name" value="Astabrata Teknologi" placeholder="Nama logo" disabled>
									<small class="hint">Muncul di sebelah logo pada sidebar.</small>
								</div>

								<div class="form-group">
									<label for="footer_description">Deskripsi Singkat Footer</label>
									<textarea class="form-control" id="footer_description" name="footer_description" placeholder="Tulis deskripsi singkat untuk footer" disabled>Astabrata Teknologi - Solusi digital terpercaya untuk kebutuhan bisnis Anda.</textarea>
									<small class="hint">Teks singkat yang tampil di bagian footer admin.</small>
								</div>
							</div>

							<div class="settings-media">
								<label for="media_upload" class="media-label">Gambar Logo</label>
								<label class="media-upload-box is-locked" id="mediaUploadBox" for="media_upload">
									<div class="media-preview" id="mediaPreview">
										<div class="placeholder-content">
											<i class='bx bx-image-add'></i>
											<span>Belum ada media dipilih</span>
										</div>
									</div>
									<span class="upload-btn">
										<i class='bx bx-upload'></i> Upload Media
									</span>
									<input type="file" id="media_upload" name="media" accept="image/png, image/jpeg" disabled>
									<small>Klik atau tarik gambar ke sini &mdash; PNG/JPG, disarankan transparan, maks. 2MB.</small>
								</label>
							</div>
						</div>

						<div class="form-actions">
							<button type="button" class="btn-save" id="toggleEditBtn" data-mode="view">
								<i class='bx bx-edit-alt' id="toggleEditIcon"></i>
								<span id="toggleEditLabel">Edit</span>
							</button>
								<button type="button" class="btn-cancel-edit" id="cancelEditBtn" hidden>
									<i class='bx bx-x'></i>
									Batal
								</button>
						</div>
					</form>

					<!-- Confirmation modal -->
					<div class="confirm-overlay" id="confirmOverlay">
						<div class="confirm-box">
							<div class="confirm-icon"><i class='bx bx-error-circle'></i></div>
							<h4>Simpan Perubahan?</h4>
							<p>Anda baru saja mengubah data Nama Logo, Deskripsi Footer, dan/atau Media. Pastikan data sudah benar sebelum menyimpan.</p>
							<div class="confirm-actions">
								<button type="button" class="btn-cancel" id="confirmCancelBtn">Batal</button>
								<button type="button" class="btn-confirm" id="confirmSaveBtn">Ya, Simpan</button>
							</div>
						</div>
					</div>

					<!-- Cancel confirmation modal -->
					<div class="confirm-overlay" id="cancelOverlay">
						<div class="confirm-box">
							<div class="confirm-icon"><i class='bx bx-undo'></i></div>
							<h4>Batalkan Perubahan?</h4>
							<p>Perubahan yang sudah Anda buat tidak akan disimpan dan data akan kembali seperti semula.</p>
							<div class="confirm-actions">
								<button type="button" class="btn-cancel" id="cancelKeepBtn">Lanjut Edit</button>
								<button type="button" class="btn-confirm" id="cancelDiscardBtn">Ya, Batalkan</button>
							</div>
						</div>
					</div>

					<!-- Success toast -->
					<div class="save-toast" id="saveToast">
						<i class='bx bx-check-circle'></i> Perubahan berhasil disimpan.
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
	document.addEventListener('DOMContentLoaded', function () {
		var mediaInput = document.getElementById('media_upload');
		var mediaPreview = document.getElementById('mediaPreview');
		var mediaBox = document.getElementById('mediaUploadBox');

		function handleFile(file) {
			if (!file) return;

			if (!file.type.match('image/png') && !file.type.match('image/jpeg')) {
				alert('Format file harus PNG atau JPG.');
				mediaInput.value = '';
				return;
			}

			if (file.size > 2 * 1024 * 1024) {
				alert('Ukuran file maksimal 2MB.');
				mediaInput.value = '';
				return;
			}

			var reader = new FileReader();
			reader.onload = function (ev) {
				mediaPreview.innerHTML = '<img src="' + ev.target.result + '" alt="Preview Media">';
			};
			reader.readAsDataURL(file);
		}

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
		var logoNameInput = document.getElementById('logo_name');
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
		var confirmOverlay = document.getElementById('confirmOverlay');
		var confirmCancelBtn = document.getElementById('confirmCancelBtn');
		var confirmSaveBtn = document.getElementById('confirmSaveBtn');
		var saveToast = document.getElementById('saveToast');
		var mediaChanged = false;

		// remember original values so we can detect real changes
		var originalValues = {
			logo_name: logoNameInput.value,
			footer_description: footerDescInput.value
		};

		if (mediaInput) {
			mediaInput.addEventListener('change', function () {
				mediaChanged = true;
			});
			mediaBox.addEventListener('drop', function () {
				mediaChanged = true;
			});
		}

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
			logoNameInput.disabled = false;
			footerDescInput.disabled = false;
			mediaInput.disabled = false;
			mediaBox.classList.remove('is-locked');

			toggleBtn.dataset.mode = 'edit';
			toggleIcon.className = 'bx bx-save';
			toggleLabel.textContent = 'Simpan';

			logoNameInput.focus();
		}

		function exitEditMode() {
			setBackDisabled(false);
			cancelBtn.hidden = true;
			logoNameInput.disabled = true;
			footerDescInput.disabled = true;
			mediaInput.disabled = true;
			mediaBox.classList.add('is-locked');

			toggleBtn.dataset.mode = 'view';
			toggleIcon.className = 'bx bx-edit-alt';
			toggleLabel.textContent = 'Edit';
		}

		function hasChanges() {
			return (
				logoNameInput.value !== originalValues.logo_name ||
				footerDescInput.value !== originalValues.footer_description ||
				mediaChanged
			);
		}

		function openConfirmModal() {
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
			originalValues.logo_name = logoNameInput.value;
			originalValues.footer_description = footerDescInput.value;
			mediaChanged = false;
			originalPreviewHTML = mediaPreview.innerHTML;
			exitEditMode();
			closeConfirmModal();
			showToast();
			// Mockup only — hook this up to the real submit/AJAX call when the backend is ready.
		}

		toggleBtn.addEventListener('click', function () {
			if (toggleBtn.dataset.mode === 'view') {
				enterEditMode();
				return;
			}

			// currently in edit mode, acting as "Simpan"
			if (hasChanges()) {
				openConfirmModal();
			} else {
				exitEditMode();
			}
		});

		// ---------- Batal edit ----------
		function openCancelModal() { cancelOverlay.classList.add('is-open'); }
		function closeCancelModal() { cancelOverlay.classList.remove('is-open'); }

		function discardChanges() {
			logoNameInput.value = originalValues.logo_name;
			footerDescInput.value = originalValues.footer_description;
			mediaPreview.innerHTML = originalPreviewHTML;
			mediaInput.value = '';
			mediaChanged = false;
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
</script>
@endpush