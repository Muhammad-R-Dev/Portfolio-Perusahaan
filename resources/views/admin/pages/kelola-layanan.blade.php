@extends('admin.layouts.app')

@section('title', 'Kelola Layanan | AdminHub')
@section('page-title', 'Kelola Layanan')

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

		#content main .table-data .order {
			width: 100%;
			flex-grow: 1;
			flex-basis: 100%;
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
		#content main .table-data .order table tr td.col-layanan {
			display: flex;
			align-items: center;
			grid-gap: 12px;
			padding-left: 6px;
		}
		#content main .table-data .order table td img {
			width: 48px;
			height: 48px;
			border-radius: 8px;
			object-fit: cover;
		}
		#content main .table-data .order table td img.table-thumb {
			cursor: zoom-in;
			transition: opacity .15s ease, transform .15s ease;
		}
		#content main .table-data .order table td img.table-thumb:hover {
			opacity: .8;
			transform: scale(1.05);
		}
		#content main .table-data .order table tbody tr:hover {
			background: var(--grey);
		}
		#content main .table-data .order table tr td .status {
			font-size: 10px;
			padding: 6px 16px;
			color: var(--light);
			border-radius: 20px;
			font-weight: 700;
		}
		#content main .table-data .order table tr td .status.completed {
			background: var(--blue);
		}
		#content main .table-data .order table tr td .status.process {
			background: var(--yellow);
		}
		#content main .table-data .order table tr td .status.pending {
			background: var(--orange);
		}

		#content main .table-data .order table td .desc-kategori {
			font-weight: 500;
			color: var(--dark);
		}
		#content main .table-data .order table td .desc-harga {
			font-size: 13px;
			color: var(--dark-grey);
		}
		#content main .table-data .order table td.aksi {
			display: flex;
			align-items: center;
			grid-gap: 8px;
		}
		#content main .table-data .order table td.aksi form {
			display: inline-flex;
			margin: 0;
		}
		.btn-icon {
			width: 32px;
			height: 32px;
			border-radius: 8px;
			border: none;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			font-size: 16px;
		}
		.btn-icon.btn-edit {
			background: var(--light-blue);
			color: var(--blue);
		}
		.btn-icon.btn-delete {
			background: var(--light-orange);
			color: var(--red);
		}

		/* MODAL FORM LAYANAN */
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
			padding: 40px;
			width: 100%;
			max-width: 900px;
			max-height: 92vh;
			overflow-y: auto;
			font-family: var(--poppins);
		}
		.modal-box .modal-head {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
		}
		.modal-box .modal-head h3 {
			font-size: 22px;
			font-weight: 600;
			color: var(--dark);
		}
		.modal-box .modal-head .bx {
			cursor: pointer;
			font-size: 22px;
			color: var(--dark);
		}
		.modal-box .form-group {
			margin-bottom: 16px;
			display: flex;
			flex-direction: column;
			grid-gap: 6px;
		}
		.modal-box .form-group label {
			font-size: 13px;
			color: var(--dark);
			font-weight: 500;
		}
		.modal-box .form-group input,
		.modal-box .form-group select,
		.modal-box .form-group textarea {
			padding: 12px 14px;
			border-radius: 8px;
			border: 1px solid var(--grey);
			background: var(--grey);
			color: var(--dark);
			outline: none;
			font-family: var(--poppins);
			font-size: 15px;
		}
		.modal-box .modal-actions {
			display: flex;
			justify-content: flex-end;
			grid-gap: 12px;
			margin-top: 8px;
		}
		.modal-box .btn-cancel,
		.modal-box .btn-save {
			padding: 10px 20px;
			border-radius: 36px;
			border: none;
			font-weight: 500;
			cursor: pointer;
			font-family: var(--poppins);
		}
		.modal-box .btn-cancel {
			background: var(--grey);
			color: var(--dark);
		}
		.modal-box .btn-save {
			background: var(--blue);
			color: var(--light);
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
		.modal-box .btn-danger {
			padding: 10px 20px;
			border-radius: 36px;
			border: none;
			font-weight: 500;
			cursor: pointer;
			font-family: var(--poppins);
			background: var(--red);
			color: var(--light);
		}

		.modal-box .form-cols {
			display: flex;
			flex-wrap: wrap;
			grid-gap: 16px;
			margin-bottom: 4px;
		}
		.modal-box .form-cols .col-text {
			flex: 1 1 58%;
			min-width: 260px;
		}
		.modal-box .form-cols .col-image {
			flex: 1 1 38%;
			min-width: 220px;
		}
		.modal-box .form-cols .col-text .form-group textarea {
			min-height: 200px;
			resize: vertical;
		}
		.modal-box .uploader {
			position: relative;
			border: 2px dashed var(--grey);
			border-radius: 12px;
			background: var(--grey);
			min-height: 220px;
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
		.modal-box .uploader-empty .bx {
			font-size: 34px;
			color: var(--blue);
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
		.modal-box .uploader-preview {
			position: relative;
			width: 100%;
			height: 100%;
		}
		.modal-box .uploader-preview img {
			width: 100%;
			height: 220px;
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
		.modal-box .btn-icon.btn-remove:hover {
			background: var(--red);
		}

		/* LIGHTBOX ZOOM GAMBAR */
		.image-zoom-overlay {
			display: none;
			position: fixed;
			inset: 0;
			background: rgba(0, 0, 0, .8);
			z-index: 6000;
			justify-content: center;
			align-items: center;
			padding: 32px 16px;
		}
		.image-zoom-overlay.show {
			display: flex;
		}
		.image-zoom-overlay img {
			max-width: 100%;
			max-height: 85vh;
			border-radius: 8px;
			box-shadow: 0 10px 40px rgba(0,0,0,.4);
		}
		.image-zoom-overlay .image-zoom-close {
			position: absolute;
			top: 20px;
			right: 28px;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background: rgba(255,255,255,.15);
			color: #fff;
			font-size: 26px;
			line-height: 1;
			display: flex;
			align-items: center;
			justify-content: center;
			cursor: pointer;
			border: none;
		}
		.image-zoom-overlay .image-zoom-close:hover {
			background: rgba(255,255,255,.3);
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

			.modal-box .form-cols {
				flex-direction: column;
			}
		}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Kelola Layanan</h1>
					<ul class="breadcrumb">
						<li>
							<a href="{{ route('admin.dashboard') }}">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Kelola Layanan</a>
						</li>
					</ul>
				</div>
				<button type="button" class="btn-download" onclick="openAddModal()">
					<i class='bx bxs-plus-circle' ></i>
					<span class="text">Tambah Layanan</span>
				</button>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">
						<h3>18</h3>
						<p>Total Layanan</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-check-circle' ></i>
					<span class="text">
						<h3>14</h3>
						<p>Layanan Aktif</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-x-circle' ></i>
					<span class="text">
						<h3>4</h3>
						<p>Layanan Nonaktif</p>
					</span>
				</li>
			</ul>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Daftar Layanan</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th style="width:48px; text-align:center;">No</th>
								<th>Layanan</th>
								<th>Deskripsi</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="layananTableBody">
							@foreach($services as $service)
							<tr>
								<td style="text-align:center;">{{ $loop->iteration }}</td>
								<td class="col-layanan">
									@if($service->image)
										<img src="{{ asset('images/services/' . $service->image) }}" class="table-thumb" onclick="openTableImageZoom(this)">
									@else
										<img src="https://placehold.co/600x400/png" class="table-thumb" onclick="openTableImageZoom(this)">
									@endif
									<p>{{ $service->title }}</p>
								</td>
								<td>
									<p class="desc-kategori">{{ Str::limit($service->description, 50) }}</p>
								</td>
								<td class="aksi">
									<button type="button" class="btn-icon btn-edit" onclick="openEditModal({{ $service->id }}, '{{ addslashes($service->title) }}', '{{ addslashes($service->description) }}', '{{ $service->image ? asset('images/services/' . $service->image) : '' }}')">
										<i class='bx bx-edit'></i>
									</button>
									<button type="button" class="btn-icon btn-delete" onclick="confirmDeleteLayanan({{ $service->id }})">
										<i class='bx bx-trash'></i>
									</button>
									<form id="deleteFormLayanan{{ $service->id }}" action="{{ route('admin.kelola-layanan.destroy', $service->id) }}" method="POST" style="display:none;">
										@csrf
										@method('DELETE')
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<!-- MODAL -->
		<div class="modal-overlay" id="modalLayanan">
			<div class="modal-box">
				<div class="modal-head">
					<h3 id="modalLayananTitle">Tambah Layanan</h3>
					<i class='bx bx-x' onclick="closeModalLayanan()"></i>
				</div>
				<form id="formLayanan" action="{{ route('admin.kelola-layanan.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" id="formMethod" value="POST">

					<div class="form-cols">
						<div class="col-text">
							<div class="form-group">
								<label for="title">Judul Layanan</label>
								<input type="text" id="title" name="title" placeholder="Masukkan judul layanan" required>
							</div>
							<div class="form-group">
								<label for="description">Deskripsi</label>
								<textarea id="description" name="description" rows="4" placeholder="Masukkan deskripsi layanan" required></textarea>
							</div>
						</div>
						<div class="col-image">
							<div class="form-group">
								<label>Gambar (Opsional)</label>
								<div class="uploader" id="uploaderBox">
									<div class="uploader-empty" id="uploaderEmpty">
										<i class='bx bx-cloud-upload'></i>
										<p>Klik atau seret gambar ke sini</p>
										<span>PNG, JPG, JPEG (maks. 2MB)</span>
									</div>
									<div class="uploader-preview" id="uploaderPreview" style="display:none;">
										<img src="" alt="Preview" id="imgPreview">
										<div class="uploader-actions">
											<button type="button" class="btn-icon btn-zoom" id="btnZoomImage" title="Perbesar Gambar">
												<i class='bx bx-fullscreen'></i>
											</button>
											<button type="button" class="btn-icon btn-remove" id="btnRemoveImage" title="Hapus Gambar">
												<i class='bx bx-trash'></i>
											</button>
										</div>
									</div>
									<input type="file" id="image" name="image" accept="image/*" hidden>
								</div>
								<input type="hidden" name="hapus_gambar" id="hapusGambarFlag" value="0">
								<small style="color: var(--dark-grey); font-size: 12px; margin-top: 4px; display: block;">Kosongkan jika tidak ingin mengganti gambar.</small>
							</div>
						</div>
					</div>

					<div class="modal-actions">
						<button type="button" class="btn-cancel" onclick="closeModalLayanan()">Batal</button>
						<button type="submit" class="btn-save">Simpan</button>
					</div>
				</form>
			</div>
		</div>

		<!-- LIGHTBOX ZOOM GAMBAR -->
		<div class="image-zoom-overlay" id="imageZoomOverlay" onclick="closeImageZoomBackdrop(event)">
			<button type="button" class="image-zoom-close" onclick="closeImageZoom()">&times;</button>
			<img id="imageZoomImg" src="" alt="Preview diperbesar">
		</div>

		<!-- Modal Konfirmasi Hapus -->
		<div class="modal-overlay" id="deleteConfirmModal">
			<div class="modal-box modal-confirm">
				<div class="confirm-icon"><i class='bx bx-trash'></i></div>
				<h2>Hapus Layanan?</h2>
				<p>Yakin ingin menghapus layanan ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
				<div class="modal-actions">
					<button type="button" class="btn-cancel" id="btnCancelDelete">Batal</button>
					<button type="button" class="btn-danger" id="btnConfirmDelete">Ya, Hapus</button>
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
					<button type="button" class="btn-save" id="btnCloseSuccess">OK</button>
				</div>
			</div>
		</div>
@endsection

@push('scripts')
<script>
		const modalLayanan = document.getElementById('modalLayanan');
		const formLayanan  = document.getElementById('formLayanan');
		const modalLayananTitle = document.getElementById('modalLayananTitle');
		const imageZoomOverlay = document.getElementById('imageZoomOverlay');
		const imageZoomImg = document.getElementById('imageZoomImg');
		const hapusGambarFlag = document.getElementById('hapusGambarFlag');

		// Uploader elements
		const uploaderBox     = document.getElementById('uploaderBox');
		const uploaderEmpty   = document.getElementById('uploaderEmpty');
		const uploaderPreview = document.getElementById('uploaderPreview');
		const imgPreview      = document.getElementById('imgPreview');
		const inputImage      = document.getElementById('image');
		const btnRemoveImage  = document.getElementById('btnRemoveImage');
		const btnZoomImage    = document.getElementById('btnZoomImage');

		function resetUploader() {
			imgPreview.src = '';
			uploaderPreview.style.display = 'none';
			uploaderEmpty.style.display = 'block';
		}

		function showImagePreview(file) {
			const reader = new FileReader();
			reader.onload = function (e) {
				imgPreview.src = e.target.result;
				uploaderEmpty.style.display = 'none';
				uploaderPreview.style.display = 'block';
			};
			reader.readAsDataURL(file);
		}

		function setImagePreviewUrl(url) {
			imgPreview.src = url;
			uploaderEmpty.style.display = 'none';
			uploaderPreview.style.display = 'block';
		}

		uploaderBox.addEventListener('click', function (e) {
			if (e.target.closest('.btn-icon')) return;
			inputImage.click();
		});

		inputImage.addEventListener('change', function () {
			const file = this.files[0];
			if (file) {
				showImagePreview(file);
				hapusGambarFlag.value = '0';
			}
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
			if (file) {
				inputImage.files = e.dataTransfer.files;
				showImagePreview(file);
				hapusGambarFlag.value = '0';
			}
		});

		btnRemoveImage.addEventListener('click', function (e) {
			e.stopPropagation();
			inputImage.value = '';
			resetUploader();
			hapusGambarFlag.value = '1';
		});

		// Zoom Mode — pakai lightbox yang sama dengan zoom di tabel
		btnZoomImage.addEventListener('click', function (e) {
			e.stopPropagation();
			imageZoomImg.src = imgPreview.src;
			imageZoomOverlay.classList.add('show');
		});

		// Buka modal tambah
		function openAddModal() {
			modalLayananTitle.innerText = 'Tambah Layanan';
			formLayanan.reset();
			formLayanan.action = "{{ route('admin.kelola-layanan.store') }}";
			document.getElementById('formMethod').value = 'POST';
			hapusGambarFlag.value = '0';
			resetUploader();
			modalLayanan.classList.add('show');
		}

		// Buka modal edit — menerima data dari atribut tombol
		function openEditModal(id, title, description, image) {
			modalLayananTitle.innerText = 'Edit Layanan';
			formLayanan.action = '/admin/kelola-layanan/' + id;
			document.getElementById('formMethod').value = 'PUT';
			document.getElementById('title').value  = title;
			document.getElementById('description').value = description;
			hapusGambarFlag.value = '0';

			// Tampilkan gambar yang sudah pernah diupload (kalau ada)
			if (image) {
				setImagePreviewUrl(image);
			} else {
				resetUploader();
			}

			modalLayanan.classList.add('show');
		}

		// Tutup modal
		function closeModalLayanan() {
			modalLayanan.classList.remove('show');
		}

		// Zoom gambar dari tabel Daftar Layanan
		function openTableImageZoom(el) {
			imageZoomImg.src = el.src;
			imageZoomOverlay.classList.add('show');
		}

		function closeImageZoom() {
			imageZoomOverlay.classList.remove('show');
			imageZoomImg.src = '';
		}

		// Tutup lightbox kalau klik area gelap di luar gambar/tombol close
		function closeImageZoomBackdrop(e) {
			if (e.target === imageZoomOverlay) closeImageZoom();
		}

		// ===== Modal Konfirmasi Hapus =====
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete    = document.getElementById('btnCancelDelete');
		const btnConfirmDelete   = document.getElementById('btnConfirmDelete');
		let formToDelete = null;

		function confirmDeleteLayanan(id) {
			formToDelete = document.getElementById('deleteFormLayanan' + id);
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

		// ===== Modal Notifikasi Sukses (tambah / update / hapus) =====
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
</script>
@endpush