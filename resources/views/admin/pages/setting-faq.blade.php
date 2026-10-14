@extends('admin.layouts.app')

@section('title', 'Edit FAQ | Admin Astabrata Teknologi')
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
	#content main .settings-card .head .faq-count {
		padding: 4px 12px;
		border-radius: 20px;
		font-size: 12.5px;
		font-weight: 600;
		background: var(--light-blue);
		color: var(--blue);
	}
	#content main .settings-card .head .faq-count.full {
		background: var(--light-orange);
		color: var(--orange);
	}
	#content main .settings-card .head p {
		width: 100%;
		font-size: 13px;
		color: var(--dark-grey);
		margin-top: 4px;
	}
	#content main .settings-card .head .btn-add {
		margin-left: auto;
		height: 40px;
		padding: 0 20px;
		border: none;
		border-radius: 36px;
		background: var(--blue);
		color: var(--light);
		font-family: var(--poppins);
		font-size: 13.5px;
		font-weight: 600;
		cursor: pointer;
		display: inline-flex;
		align-items: center;
		grid-gap: 6px;
		transition: .2s ease;
	}
	#content main .settings-card .head .btn-add .bx { color: inherit; font-size: 18px; }
	#content main .settings-card .head .btn-add:hover { opacity: .9; }
	#content main .settings-card .head .btn-add:disabled {
		opacity: .45;
		cursor: not-allowed;
	}

	#content main .limit-note {
		display: none;
		align-items: center;
		grid-gap: 10px;
		padding: 12px 16px;
		border-radius: 10px;
		margin-bottom: 18px;
		font-size: 13.5px;
		background: var(--light-orange);
		color: #a13e1e;
	}
	#content main .limit-note.show { display: flex; }

	/* Daftar FAQ */
	#content main .faq-list {
		display: flex;
		flex-direction: column;
		grid-gap: 14px;
	}
	#content main .faq-item {
		display: flex;
		align-items: flex-start;
		grid-gap: 16px;
		border: 1px solid var(--grey);
		border-radius: 14px;
		padding: 18px 20px;
	}
	#content main .faq-item .faq-number {
		flex-shrink: 0;
		width: 34px;
		height: 34px;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-weight: 700;
		font-size: 14px;
		background: var(--light-blue);
		color: var(--blue);
	}
	#content main .faq-item .faq-body {
		flex: 1;
		min-width: 0;
	}
	#content main .faq-item .faq-body h4 {
		font-size: 15.5px;
		font-weight: 600;
		margin-bottom: 6px;
		word-break: break-word;
	}
	#content main .faq-item .faq-body p {
		font-size: 13.5px;
		color: var(--dark-grey);
		line-height: 1.6;
		word-break: break-word;
	}
	#content main .faq-item .faq-actions {
		flex-shrink: 0;
		display: flex;
		grid-gap: 8px;
	}
	#content main .faq-item .faq-actions button {
		height: 36px;
		padding: 0 16px;
		border: none;
		border-radius: 10px;
		cursor: pointer;
		font-family: var(--poppins);
		font-size: 13px;
		font-weight: 600;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: .2s ease;
	}
	#content main .faq-item .faq-actions button.edit { background: var(--blue); color: #fff; }
	#content main .faq-item .faq-actions button.edit:hover { opacity: .9; }
	#content main .faq-item .faq-actions button.delete { background: var(--red); color: #fff; }
	#content main .faq-item .faq-actions button.delete:hover { opacity: .9; }
	body.dark #content main .faq-item .faq-actions button.edit,
	body.dark #content main .faq-item .faq-actions button.edit:hover {
		background: var(--blue) !important;
		color: #fff !important;
	}
	body.dark #content main .faq-item .faq-actions button.delete,
	body.dark #content main .faq-item .faq-actions button.delete:hover {
		background: var(--red) !important;
		color: #fff !important;
	}

	#content main .faq-empty {
		text-align: center;
		padding: 40px 16px;
		color: var(--dark-grey);
		font-size: 14px;
		border: 1px dashed var(--dark-grey);
		border-radius: 14px;
	}
	#content main .faq-empty .bx {
		display: block;
		font-size: 40px;
		margin-bottom: 8px;
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

	/* MODAL */
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
	.modal-overlay.show { display: flex; }
	.modal-box {
		background: var(--light);
		border-radius: 16px;
		width: 100%;
		max-width: 560px;
		max-height: 92vh;
		overflow-y: auto;
		font-family: var(--poppins);
		color: var(--dark);
		padding: 28px;
	}
	.modal-box.large {
		max-width: 1200px;
		padding: 36px;
	}
	.modal-box.large h2 { font-size: 24px; }
	.modal-box.large .modal-sub { font-size: 14px; margin-bottom: 28px; }
	.modal-box.large .form-group { margin-bottom: 24px; }
	.modal-box.large .form-group label { font-size: 15px; }
	.modal-box.large .form-control { padding: 14px 18px; font-size: 15px; }
	.modal-box.large textarea.form-control { min-height: 220px; }
	.modal-box.large textarea.form-control.question-input {
		min-height: 110px;
		line-height: 1.5;
	}
	.modal-box.large .btn { padding: 12px 28px; font-size: 15px; }
	.modal-box.small {
		max-width: 380px;
		text-align: center;
		padding: 36px 28px;
	}
	.modal-box h2 {
		font-size: 20px;
		margin-bottom: 4px;
	}
	.modal-box .modal-sub {
		font-size: 13px;
		color: var(--dark-grey);
		margin-bottom: 22px;
	}
	.modal-box p.msg {
		color: var(--dark-grey);
		font-size: 14px;
		margin: 0;
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
		background: var(--light-orange);
		color: var(--orange);
	}
	.modal-box .form-group { margin-bottom: 18px; }
	.modal-box .form-group label {
		display: flex;
		justify-content: space-between;
		font-size: 14px;
		font-weight: 500;
		margin-bottom: 8px;
		color: var(--dark);
	}
	.modal-box .form-group label .counter {
		font-size: 12px;
		font-weight: 400;
		color: var(--dark-grey);
	}
	.modal-box .form-control {
		width: 100%;
		padding: 11px 14px;
		border: 1px solid var(--grey);
		background: var(--grey);
		border-radius: 10px;
		outline: none;
		color: var(--dark);
		font-family: var(--poppins);
		font-size: 14px;
		transition: .2s ease;
	}
	.modal-box textarea.form-control {
		min-height: 120px;
		resize: vertical;
	}
	.modal-box .form-control:focus {
		border-color: var(--blue);
		background: var(--light);
	}
	.modal-box .form-control.invalid { border-color: var(--red); }
	.modal-box .field-error {
		display: none;
		margin-top: 6px;
		font-size: 12px;
		color: #a13e1e;
	}
	.modal-box .field-error.show { display: block; }

	.modal-box .modal-actions {
		display: flex;
		justify-content: flex-end;
		grid-gap: 10px;
		margin-top: 8px;
	}
	.modal-box.small .modal-actions {
		justify-content: center;
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
	.modal-box .btn-cancel { background: var(--grey); color: var(--dark); }
	.modal-box .btn-confirm { background: var(--blue); color: var(--light); }
	.modal-box .btn-danger { background: var(--red); color: #fff; }

	body.dark #content main .settings-card .head .btn-add,
	body.dark .modal-box .btn-confirm,
	body.dark .modal-box .btn-confirm:hover {
		background: var(--blue) !important;
		color: #fff !important;
	}
	body.dark .modal-box .btn-cancel,
	body.dark .modal-box .btn-cancel:hover {
		background: var(--grey) !important;
		color: var(--dark) !important;
	}
	body.dark #content main .faq-item { border-color: #2a2a3d; }

	@media screen and (max-width: 576px) {
		#content main .faq-item { flex-wrap: wrap; }
		#content main .faq-item .faq-actions { margin-left: auto; }
		#content main .settings-card .head .btn-add { margin-left: 0; }
	}

	/* ===== Header diam di atas; kartu pengaturan bisa discroll (seperti Pengaturan Halaman) ===== */
	#content main .head-title.page-header-fixed { position: fixed; z-index: 60; padding: 10px 0; margin: 0; }
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
			<div class="head-title">
				<div class="left">
					<h1>Edit FAQ</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a href="{{ route('admin.setting.index') }}">Settings</a></li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li><a class="active" href="#">FAQ</a></li>
					</ul>
				</div>
			</div>

			<div class="settings-wrapper">
				<div class="settings-card" style="flex-basis: 100%;">
					<div class="head">
						<a href="{{ route('admin.setting.index') }}" class="btn-back-inline" id="btnBack" title="Kembali ke Settings">
							<i class='bx bx-arrow-back'></i>
						</a>
						<i class='bx bxs-help-circle'></i>
						<h3>Daftar FAQ</h3>
						<span class="faq-count" id="faqCount">0/5</span>
						<button type="button" class="btn-add" id="btnAddFaq"><i class='bx bx-plus'></i> Tambah FAQ</button>
					</div>

					<div class="limit-note" id="limitNote">
						<i class='bx bx-info-circle'></i>
						Batas maksimal 5 FAQ sudah tercapai. Hapus salah satu FAQ untuk menambah yang baru.
					</div>

					<div class="faq-list" id="faqList"></div>
				</div>
			</div>

			<!-- Modal Tambah / Edit FAQ -->
			<div class="modal-overlay" id="faqModal">
				<div class="modal-box large">
					<h2 id="faqModalTitle">Tambah FAQ</h2>
					<p class="modal-sub" id="faqModalSub">Isi pertanyaan dan jawaban yang akan tampil di halaman FAQ.</p>

					<form id="faqForm" novalidate>
						<div class="form-group">
							<label for="faqQuestion">Pertanyaan <span class="counter" id="qCounter">0/150</span></label>
							<textarea class="form-control question-input" id="faqQuestion" maxlength="150" rows="3" placeholder="Contoh: Berapa lama proses pengerjaan proyek?"></textarea>
							<span class="field-error" id="qError">Pertanyaan wajib diisi.</span>
						</div>

						<div class="form-group">
							<label for="faqAnswer">Jawaban <span class="counter" id="aCounter">0/500</span></label>
							<textarea class="form-control" id="faqAnswer" maxlength="500" placeholder="Tulis jawaban di sini..."></textarea>
							<span class="field-error" id="aError">Jawaban wajib diisi.</span>
						</div>

						<div class="modal-actions">
							<button type="button" class="btn btn-cancel" id="btnCancelFaq">Batal</button>
							<button type="submit" class="btn btn-confirm" id="btnSubmitFaq">Simpan</button>
						</div>
					</form>
				</div>
			</div>

			<!-- Modal Konfirmasi Hapus -->
			<div class="modal-overlay" id="deleteModal">
				<div class="modal-box small">
					<div class="confirm-icon"><i class='bx bx-trash'></i></div>
					<h2>Hapus FAQ?</h2>
					<p class="msg" id="deleteMessage"></p>
					<div class="modal-actions">
						<button type="button" class="btn btn-cancel" id="btnCancelDelete">Batal</button>
						<button type="button" class="btn btn-danger" id="btnYesDelete">Ya, Hapus</button>
					</div>
				</div>
			</div>
@endsection

@push('scripts')
<script>
	// ===== Data asli dari server (tabel faqs) =====
	const MAX_FAQ = {{ \App\Models\Faq::MAX_FAQ }};
	const CSRF_TOKEN = '{{ csrf_token() }}';
	// Pakai helper route() Laravel dengan placeholder __ID__ supaya tidak menebak pola URL
	const STORE_URL   = @json(route('admin.setting.faq.store'));
	const UPDATE_URL  = @json(route('admin.setting.faq.update', ['faq' => '__ID__']));
	const DESTROY_URL = @json(route('admin.setting.faq.destroy', ['faq' => '__ID__']));
	const ROUTES = {
		store: STORE_URL,
		update: (id) => UPDATE_URL.replace('__ID__', id),
		destroy: (id) => DESTROY_URL.replace('__ID__', id),
	};

	let faqs = @json($faqs->map(fn ($f) => ['id' => $f->id, 'q' => $f->question, 'a' => $f->answer]));
	let editIndex = null;   // null = mode tambah
	let deleteIndex = null;
	let isSubmitting = false;

	async function apiRequest(url, method, body) {
		const res = await fetch(url, {
			method: method,
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
				'X-CSRF-TOKEN': CSRF_TOKEN,
			},
			body: body ? JSON.stringify(body) : undefined,
		});
		const data = await res.json().catch(() => ({}));
		if (!res.ok) {
			const err = new Error(data.message || 'Terjadi kesalahan.');
			err.data = data;
			throw err;
		}
		return data;
	}

	const faqList   = document.getElementById('faqList');
	const faqCount  = document.getElementById('faqCount');
	const btnAdd    = document.getElementById('btnAddFaq');
	const limitNote = document.getElementById('limitNote');

	const faqModal  = document.getElementById('faqModal');
	const faqForm   = document.getElementById('faqForm');
	const inQ       = document.getElementById('faqQuestion');
	const inA       = document.getElementById('faqAnswer');
	const qError    = document.getElementById('qError');
	const aError    = document.getElementById('aError');

	const deleteModal = document.getElementById('deleteModal');
	const btnBack     = document.getElementById('btnBack');

	// Tombol kembali dinonaktifkan selama form tambah/edit terbuka
	function setBackDisabled(on) {
		btnBack.classList.toggle('is-disabled', on);
		btnBack.setAttribute('aria-disabled', on ? 'true' : 'false');
		btnBack.tabIndex = on ? -1 : 0;
	}
	btnBack.addEventListener('click', function (e) {
		if (btnBack.classList.contains('is-disabled')) e.preventDefault();
	});

	// ===== Render daftar =====
	function renderFaqs() {
		faqList.innerHTML = '';

		if (faqs.length === 0) {
			faqList.innerHTML = "<div class='faq-empty'><i class='bx bx-message-square-detail'></i>Belum ada FAQ. Klik \"Tambah FAQ\" untuk membuat yang pertama.</div>";
		}

		faqs.forEach(function (item, i) {
			const row = document.createElement('div');
			row.className = 'faq-item';

			const num = document.createElement('div');
			num.className = 'faq-number';
			num.textContent = i + 1;

			const body = document.createElement('div');
			body.className = 'faq-body';
			const h4 = document.createElement('h4');
			h4.textContent = item.q;
			const p = document.createElement('p');
			p.textContent = item.a;
			body.append(h4, p);

			const actions = document.createElement('div');
			actions.className = 'faq-actions';

			const btnEdit = document.createElement('button');
			btnEdit.type = 'button';
			btnEdit.className = 'edit';
			btnEdit.title = 'Edit';
			btnEdit.textContent = 'Edit';
			btnEdit.addEventListener('click', () => openFaqModal(i));

			const btnDel = document.createElement('button');
			btnDel.type = 'button';
			btnDel.className = 'delete';
			btnDel.title = 'Hapus';
			btnDel.textContent = 'Hapus';
			btnDel.addEventListener('click', () => openDeleteModal(i));

			actions.append(btnEdit, btnDel);
			row.append(num, body, actions);
			faqList.appendChild(row);
		});

		// Counter & batas maksimal
		const full = faqs.length >= MAX_FAQ;
		faqCount.textContent = faqs.length + '/' + MAX_FAQ;
		faqCount.classList.toggle('full', full);
		btnAdd.disabled = full;
		btnAdd.title = full ? 'Batas maksimal 5 FAQ tercapai' : '';
		limitNote.classList.toggle('show', full);
	}

	// ===== Modal Tambah / Edit =====
	function updateCounters() {
		document.getElementById('qCounter').textContent = inQ.value.length + '/150';
		document.getElementById('aCounter').textContent = inA.value.length + '/500';
	}

	function clearErrors() {
		qError.classList.remove('show');
		aError.classList.remove('show');
		inQ.classList.remove('invalid');
		inA.classList.remove('invalid');
	}

	function openFaqModal(index) {
		clearErrors();
		editIndex = (typeof index === 'number') ? index : null;

		if (editIndex === null) {
			if (faqs.length >= MAX_FAQ) return; // pengaman tambahan
			document.getElementById('faqModalTitle').textContent = 'Tambah FAQ';
			document.getElementById('faqModalSub').textContent = 'Isi pertanyaan dan jawaban yang akan tampil di halaman FAQ.';
			document.getElementById('btnSubmitFaq').textContent = 'Simpan';
			inQ.value = '';
			inA.value = '';
		} else {
			document.getElementById('faqModalTitle').textContent = 'Edit FAQ #' + (editIndex + 1);
			document.getElementById('faqModalSub').textContent = 'Ubah pertanyaan atau jawaban, lalu simpan.';
			document.getElementById('btnSubmitFaq').textContent = 'Simpan Perubahan';
			inQ.value = faqs[editIndex].q;
			inA.value = faqs[editIndex].a;
		}

		updateCounters();
		faqModal.classList.add('show');
		setBackDisabled(true);
		inQ.focus();
	}

	function closeFaqModal() {
		faqModal.classList.remove('show');
		setBackDisabled(false);
		editIndex = null;
	}

	btnAdd.addEventListener('click', () => openFaqModal());
	document.getElementById('btnCancelFaq').addEventListener('click', closeFaqModal);
	// Form tambah/edit sengaja TIDAK ditutup saat klik di luar kotak,
	// supaya isian tidak hilang. Tutup lewat tombol Batal atau Simpan.
	// Pertanyaan: kalimat otomatis turun ke baris berikutnya, tapi tidak boleh ada enter manual
	inQ.addEventListener('keydown', function (e) {
		if (e.key === 'Enter') e.preventDefault();
	});
	inQ.addEventListener('input', function () {
		if (/[\r\n]/.test(inQ.value)) inQ.value = inQ.value.replace(/[\r\n]+/g, ' ');
		updateCounters();
	});
	inA.addEventListener('input', updateCounters);

	faqForm.addEventListener('submit', async function (e) {
		e.preventDefault();
		if (isSubmitting) return;
		clearErrors();

		const q = inQ.value.trim();
		const a = inA.value.trim();
		let valid = true;

		if (!q) { qError.classList.add('show'); inQ.classList.add('invalid'); valid = false; }
		if (!a) { aError.classList.add('show'); inA.classList.add('invalid'); valid = false; }
		if (!valid) return;

		isSubmitting = true;
		const btnSubmit = document.getElementById('btnSubmitFaq');
		btnSubmit.disabled = true;

		try {
			if (editIndex === null) {
				if (faqs.length >= MAX_FAQ) { closeFaqModal(); return; }
				const res = await apiRequest(ROUTES.store, 'POST', { question: q, answer: a });
				faqs.push({ id: res.faq.id, q: res.faq.question, a: res.faq.answer });
			} else {
				const id = faqs[editIndex].id;
				const res = await apiRequest(ROUTES.update(id), 'PUT', { question: q, answer: a });
				faqs[editIndex] = { id: res.faq.id, q: res.faq.question, a: res.faq.answer };
			}
			closeFaqModal();
			renderFaqs();
		} catch (err) {
			const serverErrors = (err.data && err.data.errors) || {};
			if (serverErrors.question) { qError.textContent = serverErrors.question[0]; qError.classList.add('show'); inQ.classList.add('invalid'); }
			if (serverErrors.answer) { aError.textContent = serverErrors.answer[0]; aError.classList.add('show'); inA.classList.add('invalid'); }
			if (!serverErrors.question && !serverErrors.answer) { alert(err.message); }
		} finally {
			isSubmitting = false;
			btnSubmit.disabled = false;
		}
	});

	// ===== Modal Hapus =====
	function openDeleteModal(index) {
		deleteIndex = index;
		document.getElementById('deleteMessage').textContent =
			'Yakin ingin menghapus FAQ #' + (index + 1) + '? "' + faqs[index].q + '"';
		deleteModal.classList.add('show');
	}

	function closeDeleteModal() {
		deleteModal.classList.remove('show');
		deleteIndex = null;
	}

	document.getElementById('btnCancelDelete').addEventListener('click', closeDeleteModal);
	deleteModal.addEventListener('click', e => { if (e.target === deleteModal) closeDeleteModal(); });
	document.getElementById('btnYesDelete').addEventListener('click', async function () {
		if (deleteIndex === null) { closeDeleteModal(); return; }
		const btnYes = this;
		btnYes.disabled = true;
		try {
			const id = faqs[deleteIndex].id;
			await apiRequest(ROUTES.destroy(id), 'DELETE');
			faqs.splice(deleteIndex, 1);
			renderFaqs();
		} catch (err) {
			alert(err.message);
		} finally {
			btnYes.disabled = false;
			closeDeleteModal();
		}
	});

	// Tutup modal hapus dengan tombol Esc
	document.addEventListener('keydown', function (e) {
		if (e.key === 'Escape') {
			closeDeleteModal(); // form tambah/edit tidak ditutup dengan Esc
		}
	});

	renderFaqs();

	/* ===== Header diam di atas; kartu pengaturan bisa discroll ===== */
	(function () {
		var main = document.querySelector('#content main');
		var header = main ? main.querySelector('.head-title') : null;
		var card = document.querySelector('#content main .settings-card');
		if (!main || !header || !card) return;
		var spacer = null;
		var cardHead = card.querySelector(':scope > .head');
		function pinHeader() {
			if (header.classList.contains('page-header-fixed')) return;
			var r = header.getBoundingClientRect();
			spacer = document.createElement('div');
			spacer.style.height = r.height + 'px';
			header.parentNode.insertBefore(spacer, header.nextSibling);
			header.style.top = r.top + 'px';
			header.classList.add('page-header-fixed');
		}
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
			var ref = spacer || header;
			var hr = ref.getBoundingClientRect();
			header.style.left = hr.left + 'px';
			header.style.width = hr.width + 'px';
			var cardTop = card.getBoundingClientRect().top;
			var bar = document.querySelector('.form-actions');
			var barH = (bar && getComputedStyle(bar).position === 'fixed') ? bar.getBoundingClientRect().height : 0;
			var available = window.innerHeight - cardTop - barH - 16;
			if (available < 200) available = 200;
			card.style.maxHeight = available + 'px';
		}
		pinHeader();
		pinCardHead();
		syncLayout();
		window.addEventListener('resize', syncLayout);
		setTimeout(syncLayout, 300);
	})();
</script>
@endpush