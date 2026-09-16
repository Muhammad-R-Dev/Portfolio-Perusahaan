<!-- SIDEBAR -->
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
	</ul>
	<ul class="side-menu bottom">
		<li class="{{ request()->routeIs('admin.setting') ? 'active' : '' }}">
			<a href="{{ route('admin.setting') }}">
				<i class='bx bxs-cog bx-sm bx-spin-hover' ></i>
				<span class="text">Settings</span>
			</a>
		</li>
		<li>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
				@csrf
			</form>
			<a href="#" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<i class='bx bx-power-off bx-sm bx-burst-hover' ></i>
				<span class="text">Logout</span>
			</a>
		</li>
	</ul>
</section>
<!-- SIDEBAR -->