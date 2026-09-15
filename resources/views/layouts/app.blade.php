<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Astabrata Teknologi')</title>
    
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
</body>
</html>