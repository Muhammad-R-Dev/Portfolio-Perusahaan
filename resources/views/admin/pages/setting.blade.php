@extends('admin.layouts.app')

@section('title', 'Settings | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
<style>
	/* SETTINGS MENU PAGE (list horizontal, 2 kolom: 3 kiri + 3 kanan) */
	#content main .settings-menu-list {
		display: grid;
		/* 2 kolom, 3 baris, urutan diisi turun ke bawah dulu:
		   item 1-3 di kiri, item 4-5 di kanan */
		grid-template-columns: repeat(2, minmax(0, 1fr));
		grid-template-rows: repeat(3, auto);
		grid-auto-flow: column;
		grid-gap: 14px 20px;
		margin-top: 36px;
		width: 100%;
	}

	#content main .settings-menu-item {
		display: flex;
		align-items: center;
		grid-gap: 18px;
		background: var(--light);
		border-radius: 16px;
		padding: 18px 22px;
		color: var(--dark);
		text-decoration: none;
		transition: .2s ease;
		border: 1px solid transparent;
	}
	#content main .settings-menu-item:hover {
		transform: translateX(4px);
		box-shadow: 0 6px 20px rgba(0,0,0,.07);
		border-color: var(--light-blue);
	}

	#content main .settings-menu-item .icon-wrap {
		flex-shrink: 0;
		width: 52px;
		height: 52px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
		background: var(--light-blue);
		color: var(--blue);
	}
	#content main .settings-menu-item.c-orange .icon-wrap { background: var(--light-orange); color: var(--orange); }
	#content main .settings-menu-item.c-yellow .icon-wrap { background: var(--light-yellow); color: #b48a00; }
	#content main .settings-menu-item.c-blue .icon-wrap { background: var(--light-blue); color: var(--blue); }
	#content main .settings-menu-item.c-dark .icon-wrap { background: var(--grey); color: var(--dark); }

	#content main .settings-menu-item .text-wrap {
		flex: 1;
		min-width: 0;
	}
	#content main .settings-menu-item h3 {
		font-size: 17px;
		font-weight: 600;
		margin-bottom: 4px;
	}
	#content main .settings-menu-item p {
		font-size: 13.5px;
		color: var(--dark-grey);
		line-height: 1.5;
		margin: 0;
	}

	/* Di mode 2 kolom, ruang lebih sempit: cukup tampilkan panah */
	#content main .settings-menu-item .go-link {
		flex-shrink: 0;
		display: inline-flex;
		align-items: center;
		color: var(--blue);
	}
	#content main .settings-menu-item .go-link .bx {
		font-size: 24px;
		transition: .2s ease;
	}
	#content main .settings-menu-item:hover .go-link .bx {
		transform: translateX(4px);
	}

	/* Tablet & HP: kembali 1 kolom */
	@media screen and (max-width: 992px) {
		#content main .settings-menu-list {
			grid-template-columns: 1fr;
			grid-template-rows: none;
			grid-auto-flow: row;
		}
	}
	@media screen and (max-width: 576px) {
		#content main .settings-menu-item {
			padding: 16px;
			grid-gap: 14px;
		}
		#content main .settings-menu-item .icon-wrap {
			width: 44px;
			height: 44px;
			font-size: 22px;
		}
	}

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
	/* Halaman menu Settings isinya pendek, jadi #content perlu dipaksa
	   setinggi layar supaya warna latar menutupi sampai ke bawah
	   (tidak berhenti di akhir konten). */
	#content {
		min-height: 100vh;
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

			<div class="settings-menu-list">

				{{-- ===== KOLOM KIRI (item 1-3) ===== --}}
				<a href="{{ route('admin.setting.account') }}" class="settings-menu-item c-blue">
					<div class="icon-wrap"><i class='bx bxs-user-detail'></i></div>
					<div class="text-wrap">
						<h3>Edit Profile</h3>
						<p>Ubah username dan kata sandi akun admin yang digunakan untuk login.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				<a href="{{ route('admin.setting.navbar') }}" class="settings-menu-item c-orange">
					<div class="icon-wrap"><i class='bx bxs-dashboard'></i></div>
					<div class="text-wrap">
						<h3>Pengaturan Header &amp; Footer</h3>
						<p>Atur logo, judul situs, dan tampilan navbar/header yang muncul di halaman admin.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				<a href="{{ route('admin.setting.faq') }}" class="settings-menu-item c-yellow">
					<div class="icon-wrap"><i class='bx bxs-help-circle'></i></div>
					<div class="text-wrap">
						<h3>FAQ</h3>
						<p>Kelola daftar pertanyaan yang sering ditanyakan beserta jawabannya.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				{{-- ===== KOLOM KANAN (item 4-5) ===== --}}

				<a href="{{ route('admin.setting.contact') }}" class="settings-menu-item c-orange">
					<div class="icon-wrap"><i class='bx bxs-phone-call'></i></div>
					<div class="text-wrap">
						<h3>Kontak &amp; Lokasi</h3>
						<p>Atur nomor WhatsApp, link sosial media, alamat kantor, dan link Google Maps.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				<a href="{{ Route::has('admin.setting.pages') ? route('admin.setting.pages') : '#' }}" class="settings-menu-item c-yellow">
					<div class="icon-wrap"><i class='bx bxs-file-blank'></i></div>
					<div class="text-wrap">
						<h3>Pengaturan Halaman</h3>
						<p>Atur judul, deskripsi, gambar Welcome, dan warna tampilan tiap halaman.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

			</div>
@endsection