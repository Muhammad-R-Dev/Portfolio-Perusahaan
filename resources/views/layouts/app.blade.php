<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Astabrata Teknologi')</title>
    
    <!-- Tambahkan Favicon Logo Asta di sini -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo asta.png') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body>

    @include('layouts.partials.navbar')

    <div id="page-content">
        @yield('content')
    </div>

    @include('layouts.partials.footer')

    @stack('scripts')

    <!-- TAMBAHKAN SCRIPT INI UNTUK MENDAFTARKAN SERVICE WORKER (OFFLINE MODE) -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').then(function(reg) {
                console.log('Service Worker berhasil didaftarkan!', reg);
            }).catch(function(err) {
                console.log('Service Worker gagal didaftarkan: ', err);
            });
        }
    </script>
</body>
</html>