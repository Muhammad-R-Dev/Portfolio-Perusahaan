<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $blog->judul }} - PT Astabrata Teknologi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

        .back-button {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: #FFFFFF;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            box-shadow: var(--shadow-soft);
            transition: background 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease;
        }
        .back-button:hover {
            background: var(--primary);
            color: #FFFFFF;
            box-shadow: var(--shadow-lift);
            transform: translateX(-2px);
        }
        .back-button:active { transform: scale(0.92); }
        .back-button svg { width: 17px; height: 17px; }

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

        /* 1. Judul rata kiri, tegas & besar */
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
            color: var(--text);
        }

        /* 2. Tanggal + kategori sejajar, dengan ikon, rata kiri */
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

        /* 3. Gambar utama */
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

        /* 4. Isi artikel, rata kiri agar mudah dibaca (bukan justify) */
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
            max-width: 100%;
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
            top: 24px;
            display: flex;
            flex-direction: column;
            gap: 36px;
        }

        .sidebar-block {
            background: transparent;
        }

        /* ===== Heading gaya "tab": label solid menempel di atas garis ===== */
        .sidebar-heading {
            margin: 0 0 22px;
        }
        .sidebar-heading.sidebar-subsep {
            margin-top: 8px;
        }
        .tab-label {
            display: inline-block;
            vertical-align: top;
            background: var(--text);
            color: #FFFFFF;
            font-family: var(--font-heading);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            padding: 9px 18px;
            border-radius: 4px 4px 0 0;
        }
        .sidebar-heading.sidebar-subsep .tab-label {
            background: var(--primary);
        }
        .tab-line {
            display: block;
            width: 100%;
            height: 2px;
            background: var(--text);
        }
        .sidebar-heading.sidebar-subsep .tab-line {
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
    </style>
</head>
<body>
    <div class="detail-wrapper">
        <div class="detail-shell">

            {{-- Tombol Back --}}
            <div class="detail-topbar">
                <button type="button" class="back-button" id="backButton" aria-label="Kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5"></path>
                        <path d="M12 19l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            @php
                // Pisahkan artikel lainnya menjadi: kategori sama (Rekomendasi)
                // dan kategori berbeda (Lainnya). Aman walaupun $blogLainnya kosong.
                $blogRekomendasi = $blogLainnya->where('kategori', $blog->kategori);
                $blogBerbeda     = $blogLainnya->where('kategori', '!=', $blog->kategori);
            @endphp

            <div class="detail-layout">
                {{-- KOLOM KIRI: KONTEN UTAMA --}}
                <article class="detail-main">
                    {{-- 1. Judul besar rata kiri --}}
                    {{-- 2. Tanggal + kategori sejajar dengan ikon di bawah judul --}}
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

                    {{-- 3. Gambar di dalam bingkai/card --}}
                    <div class="detail-image-frame">
                        <img
                            src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/1200x600/png' }}"
                            alt="{{ $blog->judul }}"
                            class="detail-image"
                        >
                    </div>

                    {{-- 4. Isi konten paling bawah --}}
                    {{-- Konten dari WYSIWYG editor dirender langsung sebagai HTML, --}}
                    {{-- JANGAN dibungkus e()/nl2br() karena akan merusak tag (p, strong, ul, img, dll) --}}
                    <div class="detail-body">
                        {!! $blog->konten !!}
                    </div>
                </article>

                {{-- KOLOM KANAN: REKOMENDASI + LAINNYA --}}
                <aside class="detail-sidebar">
                    <div class="sidebar-block">

                        {{-- Rekomendasi: artikel dengan kategori yang sama --}}
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

                        {{-- Lainnya: artikel dengan kategori yang berbeda --}}
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
        // Tombol Back: kembali ke halaman sebelumnya kalau ada riwayatnya dari situs
        // ini, kalau tidak (misal dibuka langsung dari link luar) balik ke halaman Blog
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