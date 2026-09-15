@extends('admin.layouts.app')

@section('title', 'Kelola Blog | AdminHub')
@section('page-title', 'Kelola Blog')

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.snow.min.css" rel="stylesheet">
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
		#content main .table-data .order table td.col-kategori span {
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
		}
		#content main .table-data .order table td.col-aksi .bx-edit {
			color: var(--blue);
			background: var(--light-blue);
		}
		#content main .table-data .order table td.col-aksi .bx-trash {
			color: var(--red);
			background: var(--light-orange);
		}
		#content main .table-data .order table .empty-row td {
			text-align: center;
			padding: 32px 0;
			color: var(--dark-grey);
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
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.5);
			z-index: 5000;
			justify-content: center;
			align-items: center;
		}
		.modal-overlay.show {
			display: flex;
		}
		.modal-box {
			background: var(--light);
			border-radius: 16px;
			padding: 32px;
			width: 100%;
			max-width: 980px;
			max-height: 92vh;
			overflow-y: auto;
			font-family: var(--poppins);
			color: var(--dark);
		}
		.modal-box .form-grid {
			display: grid;
			grid-template-columns: 1fr 1.3fr;
			grid-gap: 28px;
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
		.modal-box .form-col-right .quill-editor {
			display: flex;
			flex-direction: column;
			flex: 1;
		}
		.modal-box .form-col-right .ql-container.ql-snow {
			flex: 1;
		}
		@media screen and (max-width: 768px) {
			.modal-box {
				max-width: 560px;
			}
			.modal-box .form-grid {
				grid-template-columns: 1fr;
			}
			.modal-box .form-col-right {
				height: auto;
			}
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
		.modal-box input[type="file"],
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
		.modal-box .current-image {
			display: block;
			width: 100%;
			max-width: 160px;
			border-radius: 10px;
			margin-bottom: 10px;
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
		.modal-box .btn-save {
			background: var(--blue);
			color: var(--light);
		}

		/* WYSIWYG EDITOR (Quill) */
		.modal-box .quill-editor {
			background: var(--light);
			border-radius: 10px;
			overflow: hidden;
		}
		.modal-box .ql-toolbar.ql-snow {
			border-radius: 10px 10px 0 0;
			border-color: var(--grey);
			background: var(--grey);
			font-family: var(--poppins);
		}
		.modal-box .ql-container.ql-snow {
			border-radius: 0 0 10px 10px;
			border-color: var(--grey);
			min-height: 320px;
			font-family: var(--poppins);
			font-size: 14px;
			color: var(--dark);
		}
		.modal-box .ql-editor {
			min-height: 320px;
		}

		/* FILE UPLOADER */
		.modal-box .uploader {
			position: relative;
			border: 2px dashed var(--grey);
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
		.image-zoom-overlay img {
			max-width: 90%;
			max-height: 85%;
			border-radius: 10px;
			box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
		}
		.image-zoom-overlay .image-zoom-close {
			position: absolute;
			top: 24px;
			right: 32px;
			color: var(--light);
			font-size: 32px;
			cursor: pointer;
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
					<i class='bx bxs-plus-circle bx-fade-down-hover' ></i>
					<span class="text">Tambah Blog</span>
				</button>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">
						<h3>{{ $totalBlog }}</h3>
						<p>Total Blog</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-check-circle' ></i>
					<span class="text">
						<h3>{{ $totalTerbit }}</h3>
						<p>Terbit</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-edit' ></i>
					<span class="text">
						<h3>{{ $totalDraft }}</h3>
						<p>Draft</p>
					</span>
				</li>
			</ul>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Daftar Blog</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Judul</th>
								<th>Kategori</th>
								<th>Tanggal Dibuat</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse($blogs as $blog)
							<tr>
								<td class="col-no">{{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}</td>
								<td class="col-gambar">
									<img src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/600x400/png' }}" alt="{{ $blog->judul }}">
								</td>
								<td class="col-judul">{{ $blog->judul }}</td>
								<td class="col-kategori"><span>{{ $blog->kategori }}</span></td>
								<td>{{ $blog->created_at->format('d-m-Y') }}</td>
								<td class="col-aksi">
									<i
										class='bx bx-edit'
										title="Edit"
										data-id="{{ $blog->id }}"
										data-judul="{{ $blog->judul }}"
										data-kategori="{{ $blog->kategori }}"
										data-konten="{{ $blog->konten }}"
										data-gambar="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : '' }}"
										data-update-url="{{ route('admin.kelola-blog.update', $blog->id) }}"
										onclick="openEditModal(this)"
									></i>
									<form action="{{ route('admin.kelola-blog.destroy', $blog->id) }}" method="POST" class="form-delete" style="display:inline;">
										@csrf
										@method('DELETE')
										<i class='bx bx-trash' title="Hapus" onclick="confirmDelete(this)"></i>
									</form>
								</td>
							</tr>
							@empty
							<tr class="empty-row">
								<td colspan="6">Belum ada data blog.</td>
							</tr>
							@endforelse
						</tbody>
					</table>

					@if($blogs->hasPages())
						<div style="margin-top: 20px;">
							{{ $blogs->links() }}
						</div>
					@endif
				</div>
			</div>

			<!-- Modal Tambah/Edit Blog -->
			<div class="modal-overlay" id="blogModal">
				<div class="modal-box">
					<h2 id="modalTitle">Tambah Blog</h2>

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
									<input type="text" name="judul" id="inputJudul" value="{{ old('judul') }}" required>
								</div>

								<div class="form-group">
									<label>Kategori</label>
									<select name="kategori" id="inputKategori" required>
										<option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih Kategori</option>
										<option value="project" {{ old('kategori') === 'project' ? 'selected' : '' }}>Project</option>
										<option value="berita" {{ old('kategori') === 'berita' ? 'selected' : '' }}>Berita</option>
										<option value="kegiatan" {{ old('kategori') === 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
									</select>
								</div>

								<div class="form-group">
									<label>Gambar</label>
									<div class="uploader" id="uploaderBox">
										<div class="uploader-empty" id="uploaderEmpty">
											<i class='bx bx-cloud-upload'></i>
											<p>Klik atau seret gambar ke sini</p>
											<span>PNG, JPG, JPEG (maks. 2MB)</span>
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
									<div id="inputKontenEditor" class="quill-editor"></div>
									<textarea name="konten" id="inputKonten" style="display:none;"></textarea>
								</div>
							</div>
						</div>

						<div class="modal-actions">
							<button type="button" class="btn btn-cancel" id="btnCancelModal">Batal</button>
							<button type="submit" class="btn btn-save">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Zoom Mode untuk Preview Gambar -->
			<div class="image-zoom-overlay" id="imageZoomOverlay">
				<span class="image-zoom-close" id="btnCloseZoom"><i class='bx bx-x'></i></span>
				<img src="" alt="Zoom Gambar" id="zoomedImage">
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteConfirmModal">
				<div class="modal-box modal-confirm">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2>Hapus Blog Ini?</h2>
					<p>Yakin ingin menghapus blog ini? Data yang sudah dihapus tidak dapat dikembalikan.</p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.6/quill.min.js"></script>
<script>
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

		// Modal konfirmasi hapus
		const deleteConfirmModal = document.getElementById('deleteConfirmModal');
		const btnCancelDelete = document.getElementById('btnCancelDelete');
		const btnConfirmDelete = document.getElementById('btnConfirmDelete');
		let formToDelete = null;

		// Modal notifikasi sukses
		const successModal = document.getElementById('successModal');
		const successMessage = document.getElementById('successMessage');
		const btnCloseSuccess = document.getElementById('btnCloseSuccess');

		let isEditMode = false;

		// ===== WYSIWYG Editor (Quill) =====
		const quill = new Quill('#inputKontenEditor', {
			theme: 'snow',
			placeholder: 'Tulis isi konten di sini...',
			modules: {
				toolbar: [
					[{ header: [2, 3, false] }],
					['bold', 'italic', 'underline', 'strike'],
					[{ list: 'ordered' }, { list: 'bullet' }],
					['link', 'image', 'blockquote'],
					['clean']
				]
			}
		});
		quill.on('text-change', function () {
			document.getElementById('inputKonten').value = quill.root.innerHTML;
		});

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
			if (file) {
				showImagePreview(file);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
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
				inputGambar.files = e.dataTransfer.files;
				showImagePreview(file);
				inputHapusGambar.value = '0';
				gambarHint.textContent = '';
			}
		});

		btnRemoveImage.addEventListener('click', function (e) {
			e.stopPropagation();
			inputGambar.value = '';
			resetUploader();
			inputHapusGambar.value = '1';
		});

		// ===== Zoom Mode =====
		btnZoomImage.addEventListener('click', function (e) {
			e.stopPropagation();
			zoomedImage.src = previewImage.src;
			imageZoomOverlay.classList.add('show');
		});
		btnCloseZoom.addEventListener('click', function () {
			imageZoomOverlay.classList.remove('show');
		});
		imageZoomOverlay.addEventListener('click', function (e) {
			if (e.target === imageZoomOverlay) imageZoomOverlay.classList.remove('show');
		});

		// ===== Modal open/close =====
		function openAddModal() {
			isEditMode = false;
			modalTitle.textContent = 'Tambah Blog';
			blogForm.reset();
			blogForm.action = "{{ route('admin.kelola-blog.store') }}";
			methodFieldWrapper.innerHTML = '';

			quill.setContents([]);
			document.getElementById('inputKonten').value = '';

			resetUploader();
			inputHapusGambar.value = '0';
			gambarHint.textContent = '';

			blogModal.classList.add('show');
		}

		function openEditModal(el) {
			isEditMode = true;

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

			// Laravel butuh method spoofing PUT lewat form HTML biasa
			methodFieldWrapper.innerHTML = '<input type="hidden" name="_method" value="PUT">';

			document.getElementById('inputJudul').value = data.judul;
			document.getElementById('inputKategori').value = data.kategori;

			quill.root.innerHTML = data.konten || '';
			document.getElementById('inputKonten').value = data.konten || '';

			inputHapusGambar.value = '0';
			gambarHint.textContent = 'Kosongkan jika tidak ingin mengganti gambar.';

			if (data.gambar) {
				previewImage.src = data.gambar;
				uploaderEmpty.style.display = 'none';
				uploaderPreview.style.display = 'block';
			} else {
				resetUploader();
			}

			blogModal.classList.add('show');
		}

		function closeModal() {
			blogModal.classList.remove('show');
		}

		function confirmDelete(icon) {
			formToDelete = icon.closest('form');
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

		// ===== Popup Notifikasi Sukses (tambah / update) =====
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

		// ===== Validasi sebelum submit =====
		blogForm.addEventListener('submit', function (e) {
			document.getElementById('inputKonten').value = quill.root.innerHTML;

			if (quill.getText().trim().length === 0) {
				e.preventDefault();
				alert('Isi konten tidak boleh kosong.');
				return;
			}

			if (!isEditMode && !inputGambar.files.length) {
				e.preventDefault();
				gambarHint.textContent = 'Gambar wajib diunggah.';
				gambarHint.style.color = 'var(--red)';
			}
		});

		document.getElementById('btnTambahBlog').addEventListener('click', function (e) {
			e.preventDefault();
			openAddModal();
		});

		document.getElementById('btnCancelModal').addEventListener('click', closeModal);

		@if($errors->any())
			// Kalau validasi gagal saat submit, otomatis buka lagi modal tambah
			openAddModal();
			quill.root.innerHTML = @json(old('konten', ''));
			document.getElementById('inputKonten').value = @json(old('konten', ''));
		@endif
</script>
@endpush