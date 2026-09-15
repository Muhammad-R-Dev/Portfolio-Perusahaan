@extends('admin.layouts.app')

@section('title', 'Kelola Tim | AdminHub')
@section('page-title', 'Kelola Tim')

@push('styles')
<style>
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
			box-shadow: 0 4px 14px rgba(0, 0, 0, .04);
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
			box-shadow: 0 4px 14px rgba(0, 0, 0, .04);
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
			font-size: 18px;
			color: var(--dark-grey);
			transition: color .15s ease;
		}
		#content main .table-data .head .bx:hover {
			color: var(--blue);
		}

		#content main .table-data .order {
			flex-grow: 1;
			flex-basis: 500px;
		}
		#content main .table-data .order table {
			width: 100%;
			border-collapse: collapse;
			table-layout: fixed;
		}
		#content main .table-data .order table th {
			padding: 0 10px 12px;
			font-size: 12px;
			text-align: left;
			text-transform: uppercase;
			letter-spacing: .04em;
			color: var(--dark-grey);
			font-weight: 600;
			border-bottom: 1px solid var(--grey);
		}
		#content main .table-data .order table th:first-child,
		#content main .table-data .order table td:first-child {
			padding-left: 6px;
		}
		#content main .table-data .order table th:last-child,
		#content main .table-data .order table td:last-child {
			padding-right: 6px;
		}
		#content main .table-data .order table td {
			padding: 14px 10px;
			vertical-align: middle;
		}
		#content main .table-data .order table tbody tr {
			transition: background .15s ease;
		}
		#content main .table-data .order table tbody tr:not(:last-child) td {
			border-bottom: 1px solid var(--grey);
		}
		#content main .table-data .order table tbody tr:hover {
			background: var(--grey);
		}
		#content main .table-data .order table td img {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			object-fit: cover;
		}
		#content main .table-data .order table tr td .status {
			font-size: 10px;
			padding: 6px 16px;
			color: var(--light);
			border-radius: 20px;
			font-weight: 700;
		}
		#content main .table-data .order table tr td .status.aktif {
			background: var(--blue);
		}
		#content main .table-data .order table tr td .status.nonaktif {
			background: var(--red);
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

			#content main .box-info {
				grid-template-columns: 1fr;
			}

			#content main .table-data .head {
				min-width: 420px;
			}
			#content main .table-data .order table {
				min-width: 420px;
			}
		}

		/* TIM TABLE EXTRAS */
		#content main .table-data .order table th:nth-child(1) { width: 44px; }
		#content main .table-data .order table th:nth-child(2) { width: 22%; }
		#content main .table-data .order table th:nth-child(3) { width: 22%; }
		#content main .table-data .order table th:nth-child(4) { width: 16%; }
		#content main .table-data .order table th:nth-child(5) { width: 12%; }
		#content main .table-data .order table th:nth-child(6) { width: 90px; }
		#content main .table-data .order table td.col-no {
			text-align: center;
			padding-left: 0 !important;
		}
		#content main .table-data .order table td.col-nama {
			font-weight: 500;
			display: flex;
			align-items: center;
			grid-gap: 10px;
		}
		#content main .table-data .order table td.col-divisi span {
			background: var(--light-blue);
			color: var(--blue);
			padding: 4px 12px;
			border-radius: 20px;
			font-size: 12px;
			font-weight: 600;
			white-space: nowrap;
		}
		#content main .table-data .order table td.col-aksi {
			white-space: nowrap;
		}
		#content main .table-data .order table td.col-aksi .bx {
			cursor: pointer;
			font-size: 18px;
			padding: 6px;
			border-radius: 8px;
			margin-right: 4px;
			transition: transform .15s ease, filter .15s ease;
		}
		#content main .table-data .order table td.col-aksi .bx:hover {
			transform: translateY(-2px);
			filter: brightness(.9);
		}
		#content main .table-data .order table td.col-aksi .bx-edit {
			color: var(--blue);
			background: var(--light-blue);
		}
		#content main .table-data .order table td.col-aksi .bx-trash {
			color: var(--red);
			background: var(--light-orange);
		}

		.alert-flash {
			margin-top: 24px;
			padding: 14px 20px;
			border-radius: 12px;
			background: var(--light-blue);
			color: var(--blue);
			font-weight: 500;
		}

		/* MODAL */
		.modal-overlay {
			display: flex;
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 5000;
			justify-content: center;
			align-items: center;
			opacity: 0;
			visibility: hidden;
			transition: opacity .25s ease, visibility .25s ease;
		}
		.modal-overlay.show {
			opacity: 1;
			visibility: visible;
		}
		.modal-box {
			background: var(--light);
			border-radius: 16px;
			padding: 28px;
			width: 100%;
			max-width: 480px;
			max-height: 90vh;
			overflow-y: auto;
			font-family: var(--poppins);
			color: var(--dark);
			position: relative;
			transform: scale(.92) translateY(10px);
			transition: transform .25s ease;
		}
		.modal-overlay.show .modal-box {
			transform: scale(1) translateY(0);
		}
		.modal-box .modal-close {
			position: absolute;
			top: 18px;
			right: 18px;
			font-size: 22px;
			color: var(--dark-grey);
			cursor: pointer;
			line-height: 1;
			transition: color .15s ease, transform .15s ease;
		}
		.modal-box .modal-close:hover {
			color: var(--red);
			transform: rotate(90deg);
		}
		.modal-box h2 {
			font-size: 20px;
			font-weight: 600;
			margin-bottom: 20px;
			padding-right: 24px;
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
		.modal-box input[type="url"],
		.modal-box select {
			width: 100%;
			padding: 10px 14px;
			border-radius: 10px;
			border: 1px solid var(--grey);
			background: var(--grey);
			font-family: var(--poppins);
			font-size: 14px;
			color: var(--dark);
			outline: none;
			transition: border-color .15s ease, background .15s ease;
		}
		.modal-box input[type="text"]:focus,
		.modal-box input[type="url"]:focus,
		.modal-box select:focus {
			border-color: var(--blue);
			background: var(--light);
		}
		.modal-box .upload-zone {
			border: 2px dashed var(--dark-grey);
			border-radius: 12px;
			padding: 18px;
			text-align: center;
			cursor: pointer;
			position: relative;
			color: var(--dark-grey);
			transition: .2s ease;
			display: flex;
			align-items: center;
			grid-gap: 14px;
		}
		.modal-box .upload-zone:hover {
			border-color: var(--blue);
			color: var(--blue);
		}
		.modal-box .upload-zone .bx {
			font-size: 28px;
		}
		.modal-box .upload-zone input[type="file"] {
			position: absolute;
			inset: 0;
			opacity: 0;
			cursor: pointer;
		}
		.modal-box .preview-img {
			width: 56px;
			height: 56px;
			border-radius: 50%;
			object-fit: cover;
			flex-shrink: 0;
			border: 1px solid var(--grey);
		}
		.modal-box .form-error {
			color: var(--red);
			font-size: 12px;
			margin-top: 6px;
			display: block;
		}
		.modal-box .modal-actions {
			display: flex;
			justify-content: flex-end;
			grid-gap: 10px;
			margin-top: 24px;
		}
		.modal-box .btn {
			padding: 10px 20px;
			border-radius: 36px;
			border: none;
			font-weight: 500;
			cursor: pointer;
			font-family: var(--poppins);
			font-size: 14px;
			transition: background .15s ease, transform .15s ease;
		}
		.modal-box .btn:hover {
			transform: translateY(-1px);
		}
		.modal-box .btn-cancel {
			background: var(--grey);
			color: var(--dark);
		}
		.modal-box .btn-cancel:hover {
			background: var(--dark-grey);
			color: var(--light);
		}
		.modal-box .btn-save {
			background: var(--blue);
			color: var(--light);
		}
		.modal-box .btn-save:hover {
			background: #2f7dd1;
		}
		.modal-box .btn-danger {
			background: var(--red);
			color: var(--light);
		}
		.modal-box .btn-danger:hover {
			opacity: .9;
		}

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
		.modal-box.modal-confirm h2 {
			margin-bottom: 8px;
			color: var(--dark);
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
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Kelola Tim</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('admin.dashboard') }}">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Kelola Tim</a>
						</li>
					</ul>
				</div>
				<button type="button" class="btn-download" id="btnTambahTim">
					<i class='bx bxs-plus-circle bx-fade-down-hover' ></i>
					<span class="text">Tambah Tim</span>
				</button>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>{{ $totalAnggota }}</h3>
						<p>Total Anggota</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-check-circle' ></i>
					<span class="text">
						<h3>{{ $aktif }}</h3>
						<p>Aktif</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-x-circle' ></i>
					<span class="text">
						<h3>{{ $nonaktif }}</h3>
						<p>Nonaktif</p>
					</span>
				</li>
			</ul>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Daftar Anggota Tim</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Jabatan</th>
								<th>Divisi</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($teams as $team)
							<tr>
								<td class="col-no">{{ $loop->iteration }}</td>
								<td class="col-nama">
									<img src="{{ $team->foto_url }}" alt="{{ $team->nama }}">
									{{ $team->nama }}
								</td>
								<td>{{ $team->jabatan }}</td>
								<td class="col-divisi"><span>{{ $team->divisi }}</span></td>
								<td><span class="status {{ $team->status }}">{{ ucfirst($team->status) }}</span></td>
								<td class="col-aksi">
									<i class='bx bx-edit'
									   title="Edit"
									   data-id="{{ $team->id }}"
									   data-nama="{{ $team->nama }}"
									   data-jabatan="{{ $team->jabatan }}"
									   data-divisi="{{ $team->divisi }}"
									   data-status="{{ $team->status }}"
									   data-foto="{{ $team->foto_url }}"
									   data-url="{{ route('admin.kelola-tim.update', $team->id) }}"
									   onclick="openModal('edit', this)"></i>
									<i class='bx bx-trash' title="Hapus" onclick="confirmDelete({{ $team->id }})"></i>
									<form id="deleteFormTim{{ $team->id }}" action="{{ route('admin.kelola-tim.destroy', $team->id) }}" method="POST" style="display:none;">
										@csrf
										@method('DELETE')
									</form>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6" style="text-align:center; color: var(--dark-grey);">Belum ada anggota tim.</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>

			<!-- Modal Tambah/Edit Tim -->
			<div class="modal-overlay" id="timModal">
				<div class="modal-box">
					<span class="modal-close" id="btnCloseModal">&times;</span>
					<h2 id="modalTitle">Tambah Tim</h2>
					<form id="timForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.kelola-tim.store') }}">
						@csrf
						<input type="hidden" name="_method" id="formMethod" value="">

						<div class="form-group">
							<label for="teamFoto">Foto Profil</label>
							<div class="upload-zone">
								<img src="{{ asset('image/profile.png') }}" alt="Preview" class="preview-img" id="previewFoto">
								<span id="uploadLabel">Klik untuk pilih foto (opsional, default: profile.png)</span>
								<input type="file" name="foto" id="teamFoto" accept="image/*">
							</div>
						</div>

						<div class="form-group">
							<label for="teamNama">Nama</label>
							<input type="text" name="nama" id="teamNama" required maxlength="100">
						</div>

						<div class="form-group">
							<label for="teamJabatan">Jabatan</label>
							<input type="text" name="jabatan" id="teamJabatan" required maxlength="100">
						</div>

						<div class="form-group">
							<label for="teamDivisi">Divisi</label>
							<input type="text" name="divisi" id="teamDivisi" required maxlength="100">
						</div>

						<div class="modal-actions">
							<button type="button" class="btn btn-cancel" id="btnCancelModal">Batal</button>
							<button type="submit" class="btn btn-save">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2>Hapus Anggota Tim?</h2>
					<p>Yakin ingin menghapus anggota tim ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnCancelDelete">Batal</button>
						<button type="button" class="btn btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
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
@endsection

@push('scripts')
<script>
		const timModal   = document.getElementById('timModal');
		const modalTitle = document.getElementById('modalTitle');
		const timForm    = document.getElementById('timForm');
		const formMethod = document.getElementById('formMethod');

		const teamFoto    = document.getElementById('teamFoto');
		const previewFoto = document.getElementById('previewFoto');
		const uploadLabel = document.getElementById('uploadLabel');

		const teamNama    = document.getElementById('teamNama');
		const teamJabatan = document.getElementById('teamJabatan');
		const teamDivisi  = document.getElementById('teamDivisi');

		const STORE_URL   = "{{ route('admin.kelola-tim.store') }}";
		const DEFAULT_FOTO = "{{ asset('image/profile.png') }}";

		function openModal(mode, el) {
			timForm.reset();
			previewFoto.src = DEFAULT_FOTO;
			uploadLabel.textContent = 'Klik untuk pilih foto (opsional, default: profile.png)';

			if (mode === 'edit' && el) {
				modalTitle.textContent = 'Edit Tim';
				timForm.action = el.dataset.url;
				formMethod.value = 'PUT';

				teamNama.value    = el.dataset.nama;
				teamJabatan.value = el.dataset.jabatan;
				teamDivisi.value  = el.dataset.divisi;
				previewFoto.src   = el.dataset.foto;
			} else {
				modalTitle.textContent = 'Tambah Tim';
				timForm.action = STORE_URL;
				formMethod.value = '';
			}

			timModal.classList.add('show');
		}

		function closeModal() {
			timModal.classList.remove('show');
		}

		// Modal konfirmasi hapus
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete    = document.getElementById('btnCancelDelete');
		const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
		let formToDelete = null;

		function confirmDelete(id) {
			formToDelete = document.getElementById('deleteFormTim' + id);
			deleteConfirmModal.classList.add('show');
		}

		btnCancelDelete.addEventListener('click', function () {
			formToDelete = null;
			deleteConfirmModal.classList.remove('show');
		});

		btnConfirmDelete.addEventListener('click', function () {
			if (formToDelete) {
				formToDelete.submit();
			}
			deleteConfirmModal.classList.remove('show');
		});

		deleteConfirmModal.addEventListener('click', function (e) {
			if (e.target === deleteConfirmModal) {
				formToDelete = null;
				deleteConfirmModal.classList.remove('show');
			}
		});

		// Modal notifikasi sukses (tambah / update / hapus)
		const successModal    = document.getElementById('successModal');
		const successMessage  = document.getElementById('successMessage');
		const btnCloseSuccess = document.getElementById('btnCloseSuccess');

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

		@if(session('success'))
			showSuccessPopup(@json(session('success')));
		@endif

		teamFoto.addEventListener('change', function () {
			const file = this.files[0];
			if (!file) return;
			const reader = new FileReader();
			reader.onload = function (e) {
				previewFoto.src = e.target.result;
			};
			reader.readAsDataURL(file);
			uploadLabel.textContent = file.name;
		});

		document.getElementById('btnTambahTim').addEventListener('click', function (e) {
			e.preventDefault();
			openModal('add');
		});

		document.getElementById('btnCancelModal').addEventListener('click', closeModal);
		document.getElementById('btnCloseModal').addEventListener('click', closeModal);

		// Fungsi buka/tutup menu generik (navbar)
		function toggleMenu(menuId) {
		  var menu = document.getElementById(menuId);
		  var allMenus = document.querySelectorAll('.menu');

		  allMenus.forEach(function(m) {
			if (m !== menu) {
			  m.style.display = 'none';
			}
		  });

		  if (menu.style.display === 'none' || menu.style.display === '') {
			menu.style.display = 'block';
		  } else {
			menu.style.display = 'none';
		  }
		}

		document.addEventListener("DOMContentLoaded", function() {
		  var allMenus = document.querySelectorAll('.menu');
		  allMenus.forEach(function(menu) {
			menu.style.display = 'none';
		  });
		});
</script>
@endpush