@extends('admin.layouts.app')

@section('title', 'Settings | Admin Astabrata Teknologi')
@section('page-title', 'Settings')

@push('styles')
<style>
	/* SETTINGS MENU PAGE (list horizontal, 2 kolom: 3 kiri + 3 kanan) */
	#content main .settings-menu-list {
		display: grid;
		/* 2 kolom, 3 baris, urutan diisi turun ke bawah dulu:
		   item 1-3 di kiri, item 4-6 di kanan */
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
						<h3>Pengaturan Navbar &amp; Header</h3>
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

				{{-- ===== KOLOM KANAN (item 4-6) ===== --}}
				<a href="{{ route('admin.setting.welcome') }}" class="settings-menu-item c-dark">
					<div class="icon-wrap"><i class='bx bxs-happy-heart-eyes'></i></div>
					<div class="text-wrap">
						<h3>Welcome</h3>
						<p>Ubah judul, teks, dan gambar yang dilihat pengguna di halaman welcome.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				<a href="{{ route('admin.setting.banner') }}" class="settings-menu-item c-blue">
					<div class="icon-wrap"><i class='bx bxs-image'></i></div>
					<div class="text-wrap">
						<h3>Pengaturan Banner</h3>
						<p>Ganti gambar latar hero section di halaman Blog, Layanan, dan About.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

				<a href="{{ route('admin.setting.contact') }}" class="settings-menu-item c-orange">
					<div class="icon-wrap"><i class='bx bxs-phone-call'></i></div>
					<div class="text-wrap">
						<h3>Kontak &amp; Lokasi</h3>
						<p>Atur nomor WhatsApp, link sosial media, alamat kantor, dan link Google Maps.</p>
					</div>
					<span class="go-link"><i class='bx bx-right-arrow-alt'></i></span>
				</a>

			</div>
@endsection