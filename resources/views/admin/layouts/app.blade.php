<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Astabrata Teknologi')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo asta.png') }}">

    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css">

    <!-- CSS Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }
        a { text-decoration: none; }
        li { list-style: none; }

        :root {
            --poppins: 'Poppins', sans-serif;
            --lato: 'Lato', sans-serif;
            --light: #F9F9F9;
            --blue: #3C91E6;
            --light-blue: #CFE8FF;
            --grey: #eee;
            --dark-grey: #AAAAAA;
            --dark: #342E37;
            --red: #DB504A;
            --yellow: #FFCE26;
            --light-yellow: #FFF2C6;
            --orange: #FD7238;
            --light-orange: #FFE0D3;
            --brand-accent: #084154;
        }

        html { overflow-x: hidden; }

        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
            --brand-accent: #3FA7C7;
        }

        body {
            background: var(--grey);
            overflow-x: hidden;
        }

        /* SIDEBAR */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100%;
            background: var(--light);
            z-index: 2000;
            font-family: var(--lato);
            transition: .3s ease;
            overflow-x: hidden;
            scrollbar-width: none;
        }
        #sidebar::--webkit-scrollbar { display: none; }
        #sidebar.hide { width: 60px; }
        #sidebar .brand {
            font-size: 24px;
            font-weight: 700;
            height: 64px;
            display: flex;
            align-items: center;
            color: var(--blue);
            position: sticky;
            top: 0;
            left: 0;
            background: var(--light);
            z-index: 500;
            padding-bottom: 20px;
            box-sizing: content-box;
        }
        #sidebar .brand .bx { min-width: 60px; display: flex; justify-content: center; }
        #sidebar .brand .brand-logo { min-width: 56px; max-width: 60px; height: 42px; width: auto; object-fit: contain; display: flex; justify-content: center; padding: 0 8px; }
        #sidebar.hide .brand .brand-logo { max-width: 40px; height: 30px; padding: 0 6px; }
        #sidebar .brand .brand-text { display: flex; flex-direction: column; justify-content: center; line-height: 1; gap: 1px; }
        #sidebar .brand .brand-astabrata, #sidebar .brand .brand-teknologi { font-size: 13px; font-weight: 600; white-space: nowrap; }
        #sidebar .brand .brand-astabrata { color: var(--dark); }
        #sidebar .brand .brand-teknologi { color: var(--brand-accent); letter-spacing: .5px; }
        #sidebar.hide .brand .brand-text { display: none; }
        
        #sidebar .side-menu { width: 100%; margin-top: 24px; }
        #sidebar .side-menu li { height: 48px; background: transparent; margin-left: 6px; border-radius: 48px 0 0 48px; padding: 4px; }
        #sidebar .side-menu li.active { background: var(--grey); position: relative; }
        #sidebar .side-menu li.active::before { content: ''; position: absolute; width: 40px; height: 40px; border-radius: 50%; top: -40px; right: 0; box-shadow: 20px 20px 0 var(--grey); z-index: -1; }
        #sidebar .side-menu li.active::after { content: ''; position: absolute; width: 40px; height: 40px; border-radius: 50%; bottom: -40px; right: 0; box-shadow: 20px -20px 0 var(--grey); z-index: -1; }
        #sidebar .side-menu li a { width: 100%; height: 100%; background: var(--light); display: flex; align-items: center; border-radius: 48px; font-size: 16px; color: var(--dark); white-space: nowrap; overflow-x: hidden; }
        #sidebar .side-menu.top li.active a { color: var(--blue); }
        #sidebar.hide .side-menu li a { width: calc(48px - (4px * 2)); transition: width .3s ease; }
        #sidebar .side-menu li a.logout { color: var(--red); }
        #sidebar .side-menu.top li a:hover { color: var(--blue); }
        #sidebar .side-menu li a .bx { min-width: calc(60px  - ((4px + 6px) * 2)); display: flex; justify-content: center; }

        #sidebar .side-menu.bottom li:nth-last-of-type(-n+2) { position: absolute; bottom: 0; left: 0; right: 0; text-align: center; }
        #sidebar .side-menu.bottom li:nth-last-of-type(2) { bottom: 40px; }

        /* CONTENT */
        #content { position: relative; width: calc(100% - 220px); left: 220px; transition: .3s ease; }
        #sidebar.hide ~ #content { width: calc(100% - 60px); left: 60px; }

        /* NAVBAR */
        #content nav { height: 56px; background: var(--light); padding: 0 24px; display: flex; align-items: center; grid-gap: 24px; font-family: var(--lato); position: sticky; top: 0; left: 0; z-index: 1000; }
        #content nav::before { content: ''; position: absolute; width: 40px; height: 40px; bottom: -40px; left: 0; border-radius: 50%; box-shadow: -20px -20px 0 var(--light); }
        #content nav a { color: var(--dark); }
        #content nav .bx.bx-menu { cursor: pointer; color: var(--dark); }
        #content nav .nav-link { font-size: 16px; transition: .3s ease; }
        #content nav .nav-link:hover { color: var(--blue); }
        #content nav form { max-width: 400px; width: 100%; margin-right: auto; }
        #content nav form .form-input { display: flex; align-items: center; height: 36px; }
        #content nav form .form-input input { flex-grow: 1; padding: 0 16px; height: 100%; border: none; background: var(--grey); border-radius: 36px 0 0 36px; outline: none; width: 100%; color: var(--dark); }
        #content nav form .form-input button { width: 36px; height: 100%; display: flex; justify-content: center; align-items: center; background: var(--blue); color: var(--light); font-size: 18px; border: none; outline: none; border-radius: 0 36px 36px 0; cursor: pointer; }
        
        #content nav .notification { font-size: 20px; position: relative; }
        #content nav .notification .num { position: absolute; top: -6px; right: -6px; width: 20px; height: 20px; border-radius: 50%; border: 2px solid var(--light); background: var(--red); color: var(--light); font-weight: 700; font-size: 12px; display: flex; justify-content: center; align-items: center; }

        #content nav .notification-menu { display: none; position: absolute; top: 56px; right: 0; background: var(--light); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 15px; width: 250px; max-height: 300px; overflow-y: auto; z-index: 9999; font-family: var(--lato); }
        #content nav .notification-menu.show { display: block; }
        #content nav .notification-menu ul { list-style: none; padding: 10px; margin: 0; }
        #content nav .notification-menu li { padding: 10px; border-bottom: 1px solid var(--grey); color: var(--dark); }
        #content nav .notification-menu li:hover { background-color: var(--light-blue); color: var(--dark); }
        #content nav .notification-menu li:hover a{ background-color: var(--dark-grey); color: var(--light); }
        body.dark #content nav .notification-menu li:hover { background-color: var(--light-blue); color: var(--light); }
        body.dark #content nav .notification-menu li a{ background-color: var(--dark-grey); color: var(--light); }

        #content nav .switch-mode { display: block; min-width: 50px; height: 25px; border-radius: 25px; background: var(--grey); cursor: pointer; position: relative; }
        #content nav .switch-mode::before { content: ''; position: absolute; top: 2px; left: 2px; bottom: 2px; width: calc(25px - 4px); background: var(--blue); border-radius: 50%; transition: all .3s ease; }
        #content nav #switch-mode:checked + .switch-mode::before { left: calc(100% - (25px - 4px) - 2px); }

        #content nav .swith-lm { background-color: var(--grey); border-radius: 50px; cursor: pointer; display: flex; align-items: center; justify-content: space-between; padding: 3px; position: relative; height: 21px; width: 45px; transform: scale(1.5); }
        #content nav .swith-lm .ball { background-color: var(--blue); border-radius: 50%; position: absolute; top: 2px; left: 2px; height: 20px; width: 20px; transform: translateX(0px); transition: transform 0.2s linear; }
        #content nav .checkbox:checked + .swith-lm .ball { transform: translateX(22px); }
        .bxs-moon { color: var(--yellow); }
        .bx-sun { color: var(--orange); animation: shakeOn .7s; }

        /* MAIN */
        #content main { width: 100%; padding: 36px 24px; font-family: var(--poppins); max-height: calc(100vh - 56px); overflow-y: auto; }
        #content main .head-title { display: flex; align-items: center; justify-content: space-between; grid-gap: 16px; flex-wrap: wrap; }
        #content main .head-title .left h1 { font-size: 36px; font-weight: 600; margin-bottom: 10px; color: var(--dark); }
        #content main .head-title .left .breadcrumb { display: flex; align-items: center; grid-gap: 16px; }
        #content main .head-title .left .breadcrumb li { color: var(--dark); }
        #content main .head-title .left .breadcrumb li a { color: var(--dark-grey); pointer-events: none; }
        #content main .head-title .left .breadcrumb li a.active { color: var(--blue); pointer-events: unset; }

        /* =========================================================
           STYLE SELECT DROPDOWN (Memaksa gaya basic di seluruh halaman)
        ========================================================= */
        #content main select,
        #content main .table-data .head select.filter-select {
            font-family: var(--poppins) !important;
            font-size: 13px !important;
            padding: 6px 12px !important;
            border: 1px solid var(--dark-grey) !important;
            border-radius: 6px !important;
            background-color: var(--light) !important;
            color: var(--dark) !important;
            outline: none !important;
            cursor: pointer !important;
            height: auto !important;
            -webkit-appearance: auto !important;
            -moz-appearance: auto !important;
            appearance: auto !important;
            box-shadow: none !important;
        }
        #content main select:focus, #content main .table-data .head select.filter-select:focus { border-color: var(--blue) !important; }
        body.dark #content main select, body.dark #content main .table-data .head select.filter-select { background-color: var(--grey) !important; color: var(--light) !important; border-color: #444 !important; }
    </style>

    @stack('styles')
</head>
<body>

    <script>
        (function () {
            if (localStorage.getItem('adminhub-theme') === 'dark') {
                document.body.classList.add('dark');
            }
        })();
    </script>

    @include('admin.layouts.partials.sidebar')

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu bx-sm'></i>
            <a href="#" class="nav-link">@yield('page-title', 'Dashboard')</a>
            <form action="#">
                <div class="form-input"></div>
            </form>
            <input type="checkbox" class="checkbox" id="switch-mode" hidden />
            <label class="swith-lm" for="switch-mode">
                <i class="bx bxs-moon"></i>
                <i class="bx bx-sun"></i>
                <div class="ball"></div>
            </label>

            <!-- Notification Bell -->
            <a href="#" class="notification" id="notificationIcon">
                <i class='bx bxs-bell bx-tada-hover'></i>
                <span class="num">8</span>
            </a>
            <div class="notification-menu" id="notificationMenu">
                <ul>
                    <li>New message from John</li>
                    <li>Your order has been shipped</li>
                    <li>New comment on your post</li>
                    <li>Update available for your app</li>
                    <li>Reminder: Meeting at 3PM</li>
                </ul>
            </div>
            
            <!-- BAGIAN DROPDOWN PROFIL SUDAH DIHAPUS DARI SINI SESUAI INSTRUKSI DIREKTUR -->

        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
@yield('content')
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script>
        const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

        allSideMenu.forEach(item => {
            const li = item.parentElement;
            item.addEventListener('click', function () {
                allSideMenu.forEach(i => { i.parentElement.classList.remove('active'); })
                li.classList.add('active');
            })
        });

        // TOGGLE SIDEBAR
        const menuBar = document.querySelector('#content nav .bx.bx-menu');
        const sidebar = document.getElementById('sidebar');

        menuBar.addEventListener('click', function () { sidebar.classList.toggle('hide'); });

        function adjustSidebar() {
            if (window.innerWidth <= 576) {
                sidebar.classList.add('hide'); sidebar.classList.remove('show');
            } else {
                sidebar.classList.remove('hide'); sidebar.classList.add('show');
            }
        }
        window.addEventListener('load', adjustSidebar);
        window.addEventListener('resize', adjustSidebar);

        // Toggle pencarian
        const searchButton = document.querySelector('#content nav form .form-input button');
        const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
        const searchForm = document.querySelector('#content nav form');

        if (searchButton) {
            searchButton.addEventListener('click', function (e) {
                if (window.innerWidth < 768) {
                    e.preventDefault();
                    searchForm.classList.toggle('show');
                    if (searchForm.classList.contains('show')) {
                        searchButtonIcon.classList.replace('bx-search', 'bx-x');
                    } else {
                        searchButtonIcon.classList.replace('bx-x', 'bx-search');
                    }
                }
            })
        }

        // Dark Mode Switch
        const switchMode = document.getElementById('switch-mode');
        switchMode.checked = document.body.classList.contains('dark');

        switchMode.addEventListener('change', function () {
            if (this.checked) {
                document.body.classList.add('dark'); localStorage.setItem('adminhub-theme', 'dark');
            } else {
                document.body.classList.remove('dark'); localStorage.setItem('adminhub-theme', 'light');
            }
        });

        // Notification Menu Toggle
        document.querySelector('.notification').addEventListener('click', function () {
            document.querySelector('.notification-menu').classList.toggle('show');
        });

        // Tutup menu notifikasi jika klik di luar
        window.addEventListener('click', function (e) {
            if (!e.target.closest('.notification')) {
                const notifMenu = document.querySelector('.notification-menu');
                if(notifMenu) notifMenu.classList.remove('show');
            }
        });

        // Fungsi buka/tutup menu generik
        function toggleMenu(menuId) {
          var menu = document.getElementById(menuId);
          var allMenus = document.querySelectorAll('.menu');
          allMenus.forEach(function(m) { if (m !== menu) { m.style.display = 'none'; } });
          if (menu.style.display === 'none' || menu.style.display === '') { menu.style.display = 'block'; } else { menu.style.display = 'none'; }
        }

        document.addEventListener("DOMContentLoaded", function() {
          var allMenus = document.querySelectorAll('.menu');
          allMenus.forEach(function(menu) { menu.style.display = 'none'; });
        });
    </script>

    @stack('scripts')
</body>
</html>