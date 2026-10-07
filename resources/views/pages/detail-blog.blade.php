<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->judul }} - PT Astabrata Teknologi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @php
        // Warna header mengikuti navbar (Settings > Header & Footer), sama seperti navbar_blade.php
        $__navSet = $siteSetting ?? null;
        if (class_exists(\App\Models\SiteSetting::class)) {
            try {
                $__navFresh = \App\Models\SiteSetting::first();
                if ($__navFresh) { $__navSet = $__navFresh; }
            } catch (\Throwable $e) {}
        }
        $__navColor = function ($key, $default) use ($__navSet) {
            $v = $__navSet->{$key} ?? null;
            return (is_string($v) && preg_match('/^#[0-9a-fA-F]{6}$/', $v)) ? $v : $default;
        };
    @endphp
    <style>
        :root {
            --nav-bg: {{ $__navColor('navbar_bg_light', '#094356') }};
            --nav-text: {{ $__navColor('navbar_text_light', '#ffffff') }};
        }
        html[data-theme="dark"] {
            --nav-bg: {{ $__navColor('navbar_bg_dark', '#094356') }};
            --nav-text: {{ $__navColor('navbar_text_dark', '#ffffff') }};
        }
    </style>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; }

        :root {
            --primary: #094356;
            --primary-soft: #0d5978;
            --primary-tint: #E7F1F3;
            --ivory: #FAFAFA;
            --muted: #6B7280;
            --border: #E7E9EE;
            --text: #171923;
            --text-soft: rgba(23, 25, 35, 0.78);
            --shadow-soft: 0 12px 30px rgba(17, 24, 39, 0.06);
            --shadow-lift: 0 20px 40px rgba(17, 24, 39, 0.12);
            --font-display: 'Sora', sans-serif;
            --font-heading: 'Sora', sans-serif;
            --font-body: 'Poppins', sans-serif;
        }

        .detail-wrapper {
            background: #FFFFFF;
            font-family: var(--font-body);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            padding-bottom: 100px;
        }

        .detail-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px 5% 0;
        }

        /* ===== Topbar: tombol back ===== */
        .detail-topbar {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 22px;
        }

        /* Header hijau: full lebar dari pojok kiri ke pojok kanan */
        .top-header {
            width: 100%;
            background: var(--nav-bg);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        /* DIUBAH: Lebar 100% dan padding kiri-kanan kecil supaya mepet ujung layar */
        .top-header-inner {
            width: 100%;
            padding: 0 16px; 
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Tombol dark / light mode (pojok kanan atas, gaya sama dengan navbar) */
        .theme-toggle {
            position: relative;
            width: 34px;
            height: 34px;
            padding: 0;
            border: none;
            background: transparent;
            color: var(--nav-text);
            cursor: pointer;
            flex-shrink: 0;
            -webkit-tap-highlight-color: transparent;
            transition: transform 0.25s ease;
        }
        .theme-toggle:hover { transform: scale(1.08); }
        .theme-toggle:active { transform: scale(0.94); }
        .theme-toggle:focus-visible { outline: 2px solid #FFFFFF; outline-offset: 4px; border-radius: 6px; }
        .tt-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 22px;
            height: 22px;
            margin: -11px 0 0 -11px;
            transition: transform 0.5s cubic-bezier(.65, .05, 0, 1), opacity 0.35s ease;
        }
        .tt-icon--moon { opacity: 0; transform: rotate(-90deg) scale(0.5); }
        .theme-toggle[data-theme="dark"] .tt-icon--sun { opacity: 0; transform: rotate(90deg) scale(0.5); }
        .theme-toggle[data-theme="dark"] .tt-icon--moon { opacity: 1; transform: rotate(0) scale(1); }
        @media (prefers-reduced-motion: reduce) {
            .tt-icon, .theme-toggle { transition-duration: 0.01s; }
        }

        /* Tombol kembali simpel dengan ikon < (di atas latar hijau) */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px 8px 8px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: var(--nav-text);
            font-family: var(--font-body);
            font-size: 0.92rem;
            font-weight: 500;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.2s ease;
        }
        .back-button:hover {
            background: rgba(127, 127, 127, 0.16);
        }
        .back-button:active { transform: scale(0.97); }
        .back-button svg { width: 20px; height: 20px; }

        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 48px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }
        }

        /* ===== Kolom kiri: konten utama ===== */
        .detail-main {
            min-width: 0;
        }

        .detail-header {
            text-align: left;
            margin-bottom: 20px;
        }

        .detail-title {
            font-family: var(--font-display);
            font-size: clamp(1.7rem, 3.2vw, 2.5rem);
            font-weight: 700;
            line-height: 1.28;
            margin: 0 0 16px;
            color: var(--primary);
        }

        .detail-meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .detail-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-body);
            font-size: 0.86rem;
            color: var(--muted);
        }
        .detail-meta-item svg { flex-shrink: 0; color: var(--primary); }

        .detail-badge {
            display: inline-flex;
            align-items: center;
            background: var(--primary-tint);
            color: var(--primary);
            padding: 5px 14px;
            border-radius: 999px;
            font-family: var(--font-heading);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .detail-image-frame {
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            margin: 26px 0 32px;
            background: #F2F3F5;
        }
        .detail-image {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        @media (max-width: 640px) {
            .detail-image { aspect-ratio: 4 / 3; }
        }

        .detail-body {
            font-size: 1.02rem;
            line-height: 1.85;
            color: var(--text-soft);
            text-align: left;
        }

        .detail-body p { margin: 0 0 1.2em; }
        .detail-body h1,
        .detail-body h2,
        .detail-body h3,
        .detail-body h4 {
            font-family: var(--font-heading);
            color: var(--text);
            text-align: left;
            line-height: 1.35;
            margin: 1.6em 0 0.6em;
        }
        .detail-body h1 { font-size: 1.6rem; }
        .detail-body h2 { font-size: 1.35rem; }
        .detail-body h3 { font-size: 1.15rem; }
        .detail-body ul,
        .detail-body ol {
            margin: 0 0 1.2em;
            padding-left: 1.4em;
        }
        .detail-body li { margin-bottom: 0.4em; }
        .detail-body a {
            color: var(--primary);
            text-decoration: underline;
        }
        .detail-body strong { color: var(--text); }

        /* Video YouTube dari editor: selalu lebar penuh kolom, rasio 16:9, tampil sama seperti preview di editor */
        .detail-body .chb-video {
            position: relative !important;
            display: block !important;
            width: 100% !important;
            max-width: 480px !important;
            height: auto !important;
            aspect-ratio: 16 / 9;
            float: none !important;
            margin: 1.6em auto !important;
            border-radius: 12px;
            overflow: hidden;
            background: #000;
            box-shadow: var(--shadow-soft);
        }
        .detail-body .chb-video iframe {
            position: absolute !important;
            top: 0; left: 0;
            width: 100% !important;
            height: 100% !important;
            border: 0;
        }

        /* Kartu video: thumbnail + tombol play. Video baru dimuat saat diklik. */
        .detail-body .chb-video.yt-ready { cursor: pointer; }
        /* Spesifisitas dinaikkan supaya tidak tertimpa aturan ".detail-body img" (margin & height:auto) -> penyebab thumbnail tampil dobel */
        .detail-body .chb-video .yt-thumb {
            position: absolute !important; top: 0; left: 0;
            width: 100% !important; height: 100% !important;
            margin: 0 !important; border-radius: 0 !important; max-width: none !important;
            object-fit: cover; display: block;
        }
        .yt-play {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 68px; height: 48px; padding: 0; border: 0; border-radius: 14px;
            background: #ef4444; color: #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .35); transition: transform .15s ease, filter .15s ease;
        }
        .yt-play svg { width: 26px; height: 26px; margin-left: 2px; }
        .chb-video.yt-ready:hover .yt-play { transform: translate(-50%, -50%) scale(1.08); filter: brightness(.94); }
        .yt-fallback {
            position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;
            gap: 12px; padding: 20px; text-align: center; color: #fff;
            background: rgba(15, 23, 42, .72);
        }
        .yt-fallback p { margin: 0; font-size: .95rem; line-height: 1.5; color: #fff; }
        .yt-fallback a {
            display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 999px;
            background: #fff; color: #0f172a !important; font-weight: 600; font-size: .9rem; text-decoration: none !important;
        }
        .yt-fallback a:hover { filter: brightness(.94); }
        .detail-body blockquote {
            margin: 1.6em 0;
            padding: 14px 20px;
            border-left: 3px solid var(--primary);
            background: var(--primary-tint);
            color: var(--text);
            font-style: italic;
            text-align: left;
            border-radius: 0 8px 8px 0;
        }
        .detail-body img {
            max-width: 100% !important;
            height: auto;
            border-radius: 12px;
            margin: 1.6em 0;
            display: block;
        }
        .detail-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.6em 0;
            text-align: left;
        }
        .detail-body table th,
        .detail-body table td {
            border: 1px solid var(--border);
            padding: 8px 12px;
        }

        /* ===== Kolom kanan: sidebar ===== */
        .detail-sidebar {
            position: sticky;
            top: 84px;
            display: flex;
            flex-direction: column;
            gap: 36px;
        }

        .sidebar-block {
            background: transparent;
        }

        .sidebar-heading {
            margin: 0 0 22px;
        }
        .sidebar-heading.sidebar-subsep {
            margin-top: 8px;
        }
        .tab-label {
            display: inline-block;
            vertical-align: top;
            background: #000000;
            color: #FFFFFF;
            font-family: var(--font-heading);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            padding: 9px 18px;
            border-radius: 4px 4px 0 0;
        }
        .tab-line {
            display: block;
            width: 100%;
            height: 2px;
            background: var(--primary);
        }
        .sidebar-block-body {
            padding: 0;
        }
        .sidebar-block-empty {
            font-size: 0.82rem;
            color: var(--muted);
            margin: 0;
        }
        .sidebar-list {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }
        .sidebar-card {
            display: grid;
            grid-template-columns: 84px 1fr;
            gap: 14px;
            text-decoration: none;
            align-items: center;
        }
        .sidebar-image {
            width: 84px;
            aspect-ratio: 1 / 1;
            border-radius: 8px;
            background-image: var(--bgImage);
            background-size: cover;
            background-position: center;
            background-color: #F2F3F5;
            flex-shrink: 0;
        }
        .sidebar-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
            gap: 4px;
        }
        .sidebar-category {
            display: inline-block;
            font-family: var(--font-heading);
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--primary);
        }
        .sidebar-info h3 {
            font-family: var(--font-heading);
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1.35;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.2s ease;
        }
        .sidebar-card:hover .sidebar-info h3 {
            color: var(--primary);
        }
        .sidebar-date {
            font-size: 0.74rem;
            color: var(--muted);
        }

        /* ============ LATAR PENUH KIRI-KANAN + DARK MODE ============ */
        html, body { width: 100%; margin: 0; background: #FFFFFF; }
        html[data-theme="dark"] { color-scheme: dark; }
        html[data-theme="dark"],
        html[data-theme="dark"] body { background: #0a0f1a; }
        html[data-theme="dark"] {
            --primary-tint: #14303a;
            --muted: #9aa8a4;
            --border: #26304a;
            --text: #e8f1ee;
            --text-soft: rgba(232, 241, 238, 0.82);
            --shadow-soft: 0 12px 30px rgba(0, 0, 0, 0.45);
            --shadow-lift: 0 20px 40px rgba(0, 0, 0, 0.6);
        }
        html[data-theme="dark"] .detail-wrapper { background: #0a0f1a; }
        html[data-theme="dark"] .detail-title,
        html[data-theme="dark"] .detail-body a,
        html[data-theme="dark"] .detail-badge,
        html[data-theme="dark"] .detail-meta-item svg,
        html[data-theme="dark"] .sidebar-category,
        html[data-theme="dark"] .sidebar-card:hover .sidebar-info h3 { color: #8fd0bf; }
        html[data-theme="dark"] .tab-label { background: #FFFFFF; color: #000000; }
        html[data-theme="dark"] .detail-image-frame,
        html[data-theme="dark"] .sidebar-image { background-color: #151c2c; }
    </style>
    <script>
        // Terapkan tema tersimpan (dari tombol navbar) sebelum halaman digambar
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t === 'dark' || t === 'light') document.documentElement.setAttribute('data-theme', t);
            } catch (e) {}
            // Ikuti perubahan tema dari tab/halaman lain
            window.addEventListener('storage', function (e) {
                if (e.key === 'theme' && (e.newValue === 'dark' || e.newValue === 'light')) {
                    document.documentElement.setAttribute('data-theme', e.newValue);
                }
            });
        })();
    </script>
</head>
<body>
    {{-- Header hijau dengan tombol kembali mepet pojok kiri full --}}
    <header class="top-header">
        <div class="top-header-inner">
            <button type="button" class="back-button" id="backButton" aria-label="Kembali">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Kembali
            </button>
            <button type="button" id="themeToggle" class="theme-toggle" role="switch" aria-checked="false" aria-label="Ganti mode gelap / terang" data-theme="light">
                <svg class="tt-icon tt-icon--sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"/>
                    <path d="M12 2.5v2.2M12 19.3v2.2M4.9 4.9l1.6 1.6M17.5 17.5l1.6 1.6M2.5 12h2.2M19.3 12h2.2M4.9 19.1l1.6-1.6M17.5 6.5l1.6-1.6"/>
                </svg>
                <svg class="tt-icon tt-icon--moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5a8.5 8.5 0 1 0 10.7 10.7z"/>
                </svg>
            </button>
        </div>
    </header>

    <div class="detail-wrapper">
        <div class="detail-shell">

            @php
                $blogRekomendasi = $blogLainnya->where('kategori', $blog->kategori);
                $blogBerbeda     = $blogLainnya->where('kategori', '!=', $blog->kategori);
            @endphp

            <div class="detail-layout">
                {{-- KOLOM KIRI: KONTEN UTAMA --}}
                <article class="detail-main">
                    <div class="detail-header">
                        <h1 class="detail-title">{{ $blog->judul }}</h1>
                        <div class="detail-meta">
                            <span class="detail-meta-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                                    <path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                {{ $blog->created_at->translatedFormat('d F Y') }}
                            </span>
                            <span class="detail-badge">{{ $blog->kategori }}</span>
                        </div>
                    </div>

                    <div class="detail-image-frame">
                        <img
                            src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/1200x600/png' }}"
                            alt="{{ $blog->judul }}"
                            class="detail-image"
                        >
                    </div>

                    <div class="detail-body">
                        {!! $blog->konten !!}
                    </div>
                </article>

                {{-- KOLOM KANAN: REKOMENDASI + LAINNYA --}}
                <aside class="detail-sidebar">
                    <div class="sidebar-block">

                        {{-- Rekomendasi --}}
                        <div class="sidebar-heading">
                            <span class="tab-label">Rekomendasi</span>
                            <span class="tab-line"></span>
                        </div>
                        <div class="sidebar-block-body">
                            @if($blogRekomendasi->isNotEmpty())
                                <div class="sidebar-list">
                                    @foreach($blogRekomendasi as $item)
                                    <a href="{{ route('blog.show', $item->slug) }}" class="sidebar-card">
                                        <div class="sidebar-image" style="--bgImage: url('{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://placehold.co/600x400/png' }}');"></div>
                                        <div class="sidebar-info">
                                            <span class="sidebar-category">{{ $item->kategori }}</span>
                                            <h3>{{ $item->judul }}</h3>
                                            <span class="sidebar-date">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="sidebar-block-empty">Belum ada artikel dengan kategori yang sama.</p>
                            @endif
                        </div>

                        {{-- Lainnya --}}
                        <div class="sidebar-heading sidebar-subsep">
                            <span class="tab-label">Lainnya</span>
                            <span class="tab-line"></span>
                        </div>
                        <div class="sidebar-block-body">
                            @if($blogBerbeda->isNotEmpty())
                                <div class="sidebar-list">
                                    @foreach($blogBerbeda as $item)
                                    <a href="{{ route('blog.show', $item->slug) }}" class="sidebar-card">
                                        <div class="sidebar-image" style="--bgImage: url('{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://placehold.co/600x400/png' }}');"></div>
                                        <div class="sidebar-info">
                                            <span class="sidebar-category">{{ $item->kategori }}</span>
                                            <h3>{{ $item->judul }}</h3>
                                            <span class="sidebar-date">{{ $item->created_at->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="sidebar-block-empty">Belum ada artikel dari kategori lain.</p>
                            @endif
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </div>

    <script>
        /* ===== Kartu video YouTube di isi artikel =====
           Tampil sebagai thumbnail + tombol play. Saat diklik, video diputar di tempat.
           Jika pemilik video menonaktifkan embed (error 101/150), tampil tombol "Tonton di YouTube". */
        (function () {
            var ytApiPromise = null;
            function loadYtApi() {
                if (ytApiPromise) return ytApiPromise;
                ytApiPromise = new Promise(function (resolve) {
                    if (window.YT && window.YT.Player) { resolve(); return; }
                    var prev = window.onYouTubeIframeAPIReady;
                    window.onYouTubeIframeAPIReady = function () { if (prev) prev(); resolve(); };
                    var s = document.createElement('script');
                    s.src = 'https://www.youtube.com/iframe_api';
                    document.head.appendChild(s);
                });
                return ytApiPromise;
            }

            function makeThumb(id) {
                var img = document.createElement('img');
                img.className = 'yt-thumb';
                img.alt = 'Thumbnail video YouTube';
                img.loading = 'lazy';
                img.referrerPolicy = 'no-referrer';
                img.src = 'https://i.ytimg.com/vi/' + id + '/maxresdefault.jpg';
                img.onload = function () {
                    // maxresdefault yang tidak tersedia mengembalikan gambar kecil (120px): pakai hqdefault
                    if (img.naturalWidth <= 120) img.src = 'https://i.ytimg.com/vi/' + id + '/hqdefault.jpg';
                };
                img.onerror = function () { img.onerror = null; img.src = 'https://i.ytimg.com/vi/' + id + '/hqdefault.jpg'; };
                return img;
            }

            function showFallback(box, id) {
                box.innerHTML = '';
                box.classList.remove('yt-ready');
                box.style.cursor = 'default';
                box.appendChild(makeThumb(id));
                var fb = document.createElement('div');
                fb.className = 'yt-fallback';
                fb.innerHTML = '<p>Video ini tidak bisa diputar di halaman ini.</p>';
                var a = document.createElement('a');
                a.href = 'https://www.youtube.com/watch?v=' + id;
                a.target = '_blank';
                a.rel = 'noopener';
                a.textContent = 'Tonton di YouTube';
                fb.appendChild(a);
                box.appendChild(fb);
            }

            function play(box, id) {
                box.classList.remove('yt-ready');
                box.style.cursor = 'default';
                box.innerHTML = '';
                var holder = document.createElement('div');
                holder.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;';
                box.appendChild(holder);
                loadYtApi().then(function () {
                    new YT.Player(holder, {
                        videoId: id,
                        width: '100%',
                        height: '100%',
                        playerVars: { autoplay: 1, rel: 0, playsinline: 1 },
                        events: {
                            onReady: function (e) { e.target.playVideo(); },
                            onError: function () { showFallback(box, id); }
                        }
                    });
                    // iframe hasil API harus memenuhi kartu
                    setTimeout(function () {
                        var f = box.querySelector('iframe');
                        if (f) { f.style.cssText = 'position:absolute;top:0;left:0;width:100%;height:100%;border:0;'; }
                    }, 0);
                });
            }

            document.querySelectorAll('.detail-body .chb-video').forEach(function (box) {
                var f = box.querySelector('iframe');
                var m = f && (f.getAttribute('src') || '').match(/embed\/([\w-]{11})/);
                if (!m) return;
                var id = m[1];
                box.innerHTML = '';
                box.style.background = '#000'; // buang thumbnail latar bawaan agar tidak tampil dobel
                box.classList.add('yt-ready');
                box.appendChild(makeThumb(id));
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'yt-play';
                btn.setAttribute('aria-label', 'Putar video');
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';
                box.appendChild(btn);
                box.addEventListener('click', function () {
                    if (box.classList.contains('yt-ready')) play(box, id);
                });
            });
        })();
    </script>

    <script>
        // Tombol dark / light mode (kunci 'theme' sama dengan navbar)
        (function () {
            const themeToggle = document.getElementById('themeToggle');
            if (!themeToggle) return;
            const applyTheme = (theme) => {
                document.documentElement.setAttribute('data-theme', theme);
                themeToggle.setAttribute('data-theme', theme);
                themeToggle.setAttribute('aria-checked', theme === 'dark' ? 'true' : 'false');
            };
            let saved = 'light';
            try { saved = localStorage.getItem('theme') === 'dark' ? 'dark' : 'light'; } catch (e) {}
            applyTheme(saved);
            themeToggle.addEventListener('click', () => {
                const next = themeToggle.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                applyTheme(next);
                try { localStorage.setItem('theme', next); } catch (e) {}
            });
        })();

        document.getElementById('backButton').addEventListener('click', function () {
            if (document.referrer && document.referrer.includes(window.location.host) && window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = "{{ route('blog.index') }}";
            }
        });
    </script>
</body>
</html>