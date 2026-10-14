<!-- SIDEBAR -->
<style>
	/* ============================================================
	   WARNA SIDEBAR - sama dengan palet Kelola Blog (dark & light mode)
	   --light = permukaan sidebar (sama dengan kartu)
	   --grey  = latar halaman, supaya menu aktif menyatu dengan konten
	   ============================================================ */
	body.dark #sidebar {
		--light: #25324a;          /* permukaan sidebar */
		--grey: #1b2538;           /* latar halaman (menu aktif & lengkungannya) */
		--dark: #eef2f9;           /* teks menu */
		--dark-grey: #a9b8d2;
		--light-blue: #2f4a7a;
		--blue: #4f8ef7;           /* menu aktif / hover */
		--red: #ef5a5a;            /* logout */
	}
	body:not(.dark) #sidebar {
		--light: #ffffff;          /* permukaan sidebar */
		--grey: #e9eef5;           /* latar halaman (menu aktif & lengkungannya) */
		--dark: #1e293b;           /* teks menu */
		--dark-grey: #64748b;
		--light-blue: #dbeafe;
	}

	/* Beri jarak sedikit antara menu Settings dengan tombol Logout di bawahnya */
	#sidebar .side-menu.bottom li.settings-menu-item {
		margin-bottom: 10px;
	}

	/* ===== Modal konfirmasi Logout ===== */
	.logout-confirm-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(15, 23, 42, .5);
		z-index: 6000;
		align-items: center;
		justify-content: center;
		padding: 16px;
	}
	.logout-confirm-overlay.show { display: flex; }
	.logout-confirm-box {
		background: var(--light, #fff);
		border-radius: 18px;
		padding: 28px 26px 24px;
		width: 100%;
		max-width: 320px;
		text-align: center;
		box-shadow: 0 20px 50px rgba(0, 0, 0, .25);
		transform: scale(.92);
		opacity: 0;
		transition: transform .2s ease, opacity .2s ease;
		font-family: var(--poppins, 'Poppins', sans-serif);
	}
	.logout-confirm-overlay.show .logout-confirm-box { transform: scale(1); opacity: 1; }
	.logout-confirm-icon {
		width: 54px;
		height: 54px;
		border-radius: 50%;
		background: rgba(239, 90, 90, .12);
		color: var(--red, #ef5a5a);
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 26px;
		margin: 0 auto 14px;
	}
	.logout-confirm-box h4 {
		font-family: inherit;
		font-size: 16.5px;
		font-weight: 600;
		letter-spacing: -.01em;
		color: var(--dark, #1e293b);
		margin-bottom: 8px;
	}
	.logout-confirm-box p {
		font-family: inherit;
		font-size: 13px;
		font-weight: 400;
		color: var(--dark-grey, #64748b);
		line-height: 1.6;
		margin-bottom: 22px;
	}
	.logout-confirm-actions { display: flex; gap: 10px; }
	.logout-confirm-btn {
		flex: 1;
		border: none;
		border-radius: 36px;
		padding: 11px 14px;
		font-size: 13.5px;
		font-weight: 500;
		cursor: pointer;
		font-family: inherit;
		transition: opacity .2s ease;
	}
	.logout-confirm-btn.cancel { background: var(--grey, #e2e8f0); color: var(--dark, #1e293b); }
	.logout-confirm-btn.cancel:hover { opacity: .85; }
	.logout-confirm-btn.confirm { background: var(--red, #ef5a5a); color: #fff; }
	.logout-confirm-btn.confirm:hover { opacity: .9; }
	.logout-confirm-btn[disabled] { opacity: .7; cursor: default; }
</style>
<section id="sidebar">
	<a href="#" class="brand">
		<img src="{{ asset('img/logo asta.png') }}" alt="Logo" class="brand-logo">
		<span class="text brand-text">
			<span class="brand-astabrata">Astabrata</span>
			<span class="brand-teknologi">Teknologi</span>
		</span>
	</a>
	<ul class="side-menu top">
		<li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
			<a href="{{ route('admin.dashboard') }}">
				<i class='bx bxs-dashboard bx-sm' ></i>
				<span class="text">Dashboard</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.kelola-layanan.*') ? 'active' : '' }}">
			<a href="{{ route('admin.kelola-layanan.index') }}">
				<i class='bx bxs-briefcase-alt-2 bx-sm' ></i>
				<span class="text">Kelola Layanan </span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.kelola-blog.*') ? 'active' : '' }}">
			<a href="{{ route('admin.kelola-blog.index') }}">
				<i class='bx bxs-news bx-sm' ></i>
				<span class="text">Kelola Blog</span>
			</a>
		</li>
    <li class="{{ request()->routeIs('admin.kelola-tim') ? 'active' : '' }}">
			<a href="{{ route('admin.kelola-tim') }}">
				<i class='bx bxs-group bx-sm' ></i>
				<span class="text">Kelola Tim</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.kelola-galeri') ? 'active' : '' }}">
			<a href="{{ route('admin.kelola-galeri') }}">
				<i class='bx bxs-image bx-sm' ></i>
				<span class="text">Kelola Galeri</span>
			</a>
		</li>
		<li class="{{ request()->routeIs('admin.kelola-proyek') ? 'active' : '' }}">
			<a href="{{ route('admin.kelola-proyek') }}">
				<i class='bx bxs-folder-open bx-sm' ></i>
				<span class="text">Kelola Proyek</span>
			</a>
		</li>
	</ul>
	<ul class="side-menu bottom">
	<li class="settings-menu-item {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}">
    <a href="{{ route('admin.setting.index') }}">
				<i class='bx bxs-cog bx-sm bx-spin-hover' ></i>
				<span class="text">Settings</span>
			</a>
		</li>
		<li>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
				@csrf
			</form>
			<a href="#" class="logout" id="logoutTrigger">
				<i class='bx bx-power-off bx-sm bx-burst-hover' ></i>
				<span class="text">Logout</span>
			</a>
		</li>
	</ul>
</section>
<!-- SIDEBAR -->

<!-- Modal konfirmasi Logout -->
<div class="logout-confirm-overlay" id="logoutConfirmOverlay">
	<div class="logout-confirm-box">
		<div class="logout-confirm-icon"><i class='bx bx-log-out'></i></div>
		<h4>Keluar dari Akun?</h4>
		<p>Anda yakin ingin logout dari portal admin ini?</p>
		<div class="logout-confirm-actions">
			<button type="button" class="logout-confirm-btn cancel" id="logoutConfirmCancel">Batal</button>
			<button type="button" class="logout-confirm-btn confirm" id="logoutConfirmYes">Ya, Logout</button>
		</div>
	</div>
</div>

<script>
	(function () {
		var trigger = document.getElementById('logoutTrigger');
		var overlay = document.getElementById('logoutConfirmOverlay');
		var btnYes = document.getElementById('logoutConfirmYes');
		var btnCancel = document.getElementById('logoutConfirmCancel');
		var form = document.getElementById('logout-form');
		if (!trigger || !overlay || !btnYes || !btnCancel || !form) return;

		function openConfirm() { overlay.classList.add('show'); }
		function closeConfirm() { overlay.classList.remove('show'); }

		trigger.addEventListener('click', function (e) {
			e.preventDefault();
			openConfirm();
		});

		btnCancel.addEventListener('click', closeConfirm);

		overlay.addEventListener('click', function (e) {
			if (e.target === overlay) closeConfirm();
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && overlay.classList.contains('show')) closeConfirm();
		});

		btnYes.addEventListener('click', function () {
			btnYes.disabled = true;
			btnYes.textContent = 'Memproses...';
			if (form.requestSubmit) { form.requestSubmit(); } else { form.submit(); }
		});
	})();
</script>