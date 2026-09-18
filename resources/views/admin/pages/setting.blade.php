@extends('admin.layouts.app')

@section('title', 'Settings | AdminHub')
@section('page-title', 'Settings')

@push('styles')
<style>
		/* SETTINGS PAGE */
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

		#content main .avatar-row {
			display: flex;
			align-items: center;
			grid-gap: 20px;
			margin-bottom: 28px;
		}
		#content main .avatar-row img {
			width: 84px;
			height: 84px;
			border-radius: 50%;
			object-fit: cover;
			border: 3px solid var(--grey);
		}
		#content main .avatar-row .avatar-actions label {
			display: inline-flex;
			align-items: center;
			grid-gap: 8px;
			background: var(--blue);
			color: var(--light);
			padding: 8px 18px;
			border-radius: 36px;
			font-size: 14px;
			font-weight: 500;
			cursor: pointer;
		}
		#content main .avatar-row .avatar-actions input[type="file"] {
			display: none;
		}
		#content main .avatar-row .avatar-actions small {
			display: block;
			margin-top: 8px;
			color: var(--dark-grey);
			font-size: 12px;
		}

		#content main .form-group {
			margin-bottom: 20px;
		}
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
			resize: vertical;
			min-height: 90px;
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
		#content main .form-row {
			display: flex;
			flex-wrap: wrap;
			grid-gap: 16px;
		}
		#content main .form-row .form-group {
			flex: 1 1 200px;
		}
		#content main .form-row-2col {
			display: grid;
			grid-template-columns: 1fr 1fr;
			grid-gap: 20px 24px;
		}

		#content main .password-field {
			position: relative;
		}
		#content main .password-field .bx {
			position: absolute;
			right: 16px;
			top: 50%;
			transform: translateY(-50%);
			cursor: pointer;
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
		#content main .btn-save:hover {
			opacity: .9;
		}
		#content main .btn-save.outline {
			background: transparent;
			border: 1px solid var(--dark-grey);
			color: var(--dark);
		}

		#content main .form-actions {
			display: flex;
			flex-wrap: wrap;
			grid-gap: 12px;
			margin-top: 8px;
		}

		/* MODAL KONFIRMASI & NOTIFIKASI */
		.modal-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, .5);
			z-index: 5000;
			justify-content: center;
			align-items: center;
			padding: 16px;
		}
		.modal-overlay.show {
			display: flex;
		}
		.modal-box {
			background: var(--light);
			border-radius: 16px;
			width: 100%;
			max-width: 380px;
			max-height: 92vh;
			overflow-y: auto;
			font-family: var(--poppins);
			color: var(--dark);
			text-align: center;
			padding: 36px 28px;
		}
		.modal-box .confirm-icon {
			width: 64px;
			height: 64px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 16px;
			font-size: 34px;
			background: var(--light-blue);
			color: var(--blue);
		}
		.modal-box .confirm-icon.success {
			background: var(--light-blue);
			color: var(--blue);
		}
		.modal-box h2 {
			font-size: 20px;
			margin-bottom: 8px;
		}
		.modal-box p {
			color: var(--dark-grey);
			font-size: 14px;
			margin: 0;
		}
		.modal-box .modal-actions {
			display: flex;
			justify-content: center;
			grid-gap: 10px;
			margin-top: 24px;
		}
		.modal-box .btn {
			padding: 10px 22px;
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
		.modal-box .btn-confirm {
			background: var(--blue);
			color: var(--light);
		}

		#content main .alert {
			padding: 14px 18px;
			border-radius: 10px;
			font-size: 14px;
			margin-bottom: 20px;
			display: flex;
			align-items: center;
			grid-gap: 10px;
		}
		#content main .alert.success {
			background: var(--light-blue);
			color: #1d5fa3;
		}
		#content main .alert.error {
			background: var(--light-orange);
			color: #a13e1e;
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

		@media screen and (max-width: 576px) {
			#content nav .notification-menu,
			#content nav .profile-menu {
				width: 150px;
			}
			#content nav form .form-input input {
				display: none;
			}

			#content nav form .form-input button {
				width: auto;
				height: auto;
				background: transparent;
				border-radius: none;
				color: var(--dark);
			}

			#content nav form.show .form-input input {
				display: block;
				width: 100%;
			}

			#content nav form.show .form-input button {
				width: 36px;
				height: 100%;
				border-radius: 0 36px 36px 0;
				color: var(--light);
				background: var(--red);
			}

			#content nav form.show ~ .notification,
			#content nav form.show ~ .profile {
				display: none;
			}

			#content main .settings-wrapper {
				grid-template-columns: 1fr;
			}
			#content main .form-row-2col {
				grid-template-columns: 1fr;
			}
		}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Settings</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Settings</a>
						</li>
					</ul>
				</div>
			</div>

			{{-- Notifikasi error tetap tampil inline (butuh konteks form) --}}
			@if (session('error'))
				<div class="alert error">
					<i class='bx bx-error-circle'></i>
					{{ session('error') }}
				</div>
			@endif

			<div class="settings-wrapper">

				<!--
					DESAIN digabung jadi 1 tampilan utuh (tanpa header/divider terpisah).
					SISTEM tetap sama seperti semula: 2 proses terpisah (update username &
					update password), masing-masing tombol submit ke route aslinya lewat
					atribut formaction. Controller/route tidak ada yang diubah.
				-->
				
				<div class="settings-card" style="flex-basis: 100%;">
					<div class="head">
						<i class='bx bxs-user-detail'></i>
						<h3>Edit Akun</h3>
						<p>Perbarui username dan/atau kata sandi yang digunakan untuk masuk ke portal.</p>
					</div>

					<form id="accountForm" action="{{ route('admin.setting.username.update') }}" method="POST">
						@csrf

						<div class="form-row-2col">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" id="username" name="username" value="{{ old('username', auth()->user()->username) }}" placeholder="Masukkan username">
								@error('username')
									<small class="hint" style="color:#a13e1e;">{{ $message }}</small>
								@enderror
								<small class="hint">Username ini digunakan untuk masuk (login) ke halaman admin.</small>
							</div>

							<div class="form-group">
								<label for="new_password">Sandi Baru</label>
								<div class="password-field">
									<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Kosongkan jika tidak ganti sandi">
									<i class='bx bx-show toggle-password' data-target="new_password"></i>
								</div>
								@error('new_password')
									<small class="hint" style="color:#a13e1e;">{{ $message }}</small>
								@enderror
								<small class="hint">Minimal 8 karakter, kombinasi huruf & angka.</small>
							</div>

							<div class="form-group">
								<label for="current_password">Sandi Saat Ini</label>
								<div class="password-field">
									<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Masukkan sandi saat ini">
									<i class='bx bx-show toggle-password' data-target="current_password"></i>
								</div>
								@error('current_password')
									<small class="hint" style="color:#a13e1e;">{{ $message }}</small>
								@enderror
								<small class="hint">Wajib diisi kalau kamu mau ganti username atau sandi.</small>
							</div>

							<div class="form-group">
								<label for="new_password_confirmation">Konfirmasi Sandi Baru</label>
								<div class="password-field">
									<input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi sandi baru">
									<i class='bx bx-show toggle-password' data-target="new_password_confirmation"></i>
								</div>
							</div>
						</div>


						<div class="form-actions">
							<button type="button" class="btn-save" id="btnSaveUsername" data-action="{{ route('admin.setting.username.update') }}">
								<i class='bx bx-save'></i>
								Simpan Username
							</button>
							<button type="button" class="btn-save" id="btnUpdatePassword" data-action="{{ route('admin.setting.password.update') }}">
								<i class='bx bx-lock-alt'></i>
								Update Sandi
							</button>
						</div>
					</form>
				</div>

			</div>

			<!-- Modal Konfirmasi -->
			<div class="modal-overlay" id="confirmModal">
				<div class="modal-box">
					<div class="confirm-icon"><i class='bx bx-help-circle'></i></div>
					<h2 id="confirmTitle">Konfirmasi</h2>
					<p id="confirmMessage"></p>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnCancelConfirm">Batal</button>
						<button type="button" class="btn btn-confirm" id="btnYesConfirm">Ya, Lanjutkan</button>
					</div>
				</div>
			</div>

			<!-- Modal Notifikasi Sukses -->
			<div class="modal-overlay" id="successModal">
				<div class="modal-box">
					<div class="confirm-icon success"><i class='bx bx-check-circle'></i></div>
					<h2>Berhasil!</h2>
					<p id="successMessage"></p>
					<div class="modal-actions">
						<button type="button" class="btn btn-confirm" id="btnCloseSuccess">OK</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
		// Preview foto profil sebelum diupload
		const avatarInput = document.getElementById('avatar');
		if (avatarInput) {
			avatarInput.addEventListener('change', function (e) {
				const file = e.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function (ev) {
						document.querySelector('.avatar-row img').src = ev.target.result;
					};
					reader.readAsDataURL(file);
				}
			});
		}

		// Toggle lihat/sembunyikan sandi
		document.querySelectorAll('.toggle-password').forEach(function (icon) {
			icon.addEventListener('click', function () {
				const targetId = this.getAttribute('data-target');
				const input = document.getElementById(targetId);
				if (input.type === 'password') {
					input.type = 'text';
					this.classList.replace('bx-show', 'bx-hide');
				} else {
					input.type = 'password';
					this.classList.replace('bx-hide', 'bx-show');
				}
			});
		});

		// ===== Modal Konfirmasi sebelum simpan =====
		const accountForm    = document.getElementById('accountForm');
		const confirmModal   = document.getElementById('confirmModal');
		const confirmTitle   = document.getElementById('confirmTitle');
		const confirmMessage = document.getElementById('confirmMessage');
		const btnCancelConfirm = document.getElementById('btnCancelConfirm');
		const btnYesConfirm  = document.getElementById('btnYesConfirm');
		let pendingAction = null;

		function askConfirm(action, title, message) {
			pendingAction = action;
			confirmTitle.textContent = title;
			confirmMessage.textContent = message;
			confirmModal.classList.add('show');
		}

		document.getElementById('btnSaveUsername').addEventListener('click', function () {
			askConfirm(this.dataset.action, 'Simpan Username?', 'Yakin ingin menyimpan perubahan username ini?');
		});

		document.getElementById('btnUpdatePassword').addEventListener('click', function () {
			askConfirm(this.dataset.action, 'Update Sandi?', 'Yakin ingin mengganti kata sandi login kamu?');
		});

		btnCancelConfirm.addEventListener('click', function () {
			pendingAction = null;
			confirmModal.classList.remove('show');
		});

		btnYesConfirm.addEventListener('click', function () {
			if (pendingAction) {
				accountForm.action = pendingAction;
				accountForm.submit();
			}
			confirmModal.classList.remove('show');
		});

		confirmModal.addEventListener('click', function (e) {
			if (e.target === confirmModal) {
				pendingAction = null;
				confirmModal.classList.remove('show');
			}
		});

		// ===== Modal Notifikasi Sukses =====
		const successModal    = document.getElementById('successModal');
		const successMessageEl = document.getElementById('successMessage');
		const btnCloseSuccess = document.getElementById('btnCloseSuccess');

		function showSuccessPopup(message) {
			successMessageEl.textContent = message;
			successModal.classList.add('show');
		}

		btnCloseSuccess.addEventListener('click', function () {
			successModal.classList.remove('show');
		});

		successModal.addEventListener('click', function (e) {
			if (e.target === successModal) successModal.classList.remove('show');
		});

		@if(session('success'))
			showSuccessPopup(@json(session('success')));
		@endif
</script>
@endpush