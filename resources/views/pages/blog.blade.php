@extends('layouts.app')

@section('title', 'Blog - PT Astabrata Teknologi')

@section('content')
@php
    $categories = $blogs->pluck('kategori')->filter()->unique()->values();
@endphp
<div class="page-wrapper">
    <!-- Header Gelap (DIpertahankan persis seperti bawaan) -->
    <div class="page-header">
        <div class="page-header-media">
            <!-- Background Premium Matte Dark + Grain Murni CSS -->
        </div>
        <div class="page-header-text">
            <h1>Wawasan <em>Kami</em></h1>
            <p class="subtitle">Kumpulan artikel, tips, dan cerita seputar teknologi yang kami bagikan untuk Anda.</p>
        </div>
        <div class="page-header-inner">
            <div class="header-search-row">
                <div class="header-search-bar">
                    <input type="text" id="blogSearch" class="header-search-input" placeholder="Cari artikel...">

                    <div class="search-bar-divider"></div>

                    <div class="category-filter" id="categoryFilter">
                        <button type="button" class="header-search-btn" id="filterToggleBtn" aria-label="Filter kategori" aria-haspopup="listbox" aria-expanded="false">
                            <svg class="filter-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 5H20L14 12.2V19L10 17V12.2L4 5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                            </svg>
                            <span class="filter-label" id="categoryFilterLabel">Semua Kategori</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="chevron" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <ul class="category-filter-dropdown" id="categoryFilterDropdown" role="listbox">
                            <li data-category="all" class="active" role="option">Semua</li>
                            @foreach($categories as $cat)
                            <li data-category="{{ $cat }}" role="option">{{ $cat }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="search-bar-divider row-filter-divider"></div>

                <div class="count-filter" id="countFilter">
                    <button type="button" class="count-filter-btn" id="countFilterBtn" aria-label="Filter jumlah baris" aria-haspopup="listbox" aria-expanded="false">
                        <svg class="row-filter-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M7 4V18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M3.5 14.5L7 18L10.5 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13 6H21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M13 11H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M13 16H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span id="countFilterLabel">Semua Baris</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="chevron" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <ul class="count-filter-dropdown" id="countFilterDropdown" role="listbox">
                        <li data-count="all" class="active" role="option">Semua</li>
                        <li data-count="5" role="option">5</li>
                        <li data-count="10" role="option">10</li>
                        <li data-count="20" role="option">20</li>
                    </ul>
                </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Area Konten Artikel dengan Background PARTICLE ENGINEERING -->
    <div class="content-area" id="mainContentArea">
        
        <!-- Canvas partikel -->
        <div class="particle-wrapper" aria-hidden="true"><canvas id="particle-canvas"></canvas></div>

        <div class="projects-container" id="projectsContainer">
            @forelse($blogs as $blog)
            <a
                href="{{ route('blog.show', $blog->slug) }}"
                class="project-card reveal"
                data-title="{{ $blog->judul }}"
                data-category="{{ $blog->kategori }}"
                style="text-decoration:none; --bgImage: url('{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/600x400/png' }}');"
            >
                <div class="card-photo"></div>
                <span class="badge">{{ $blog->kategori }}</span>
                <div class="card-content">
                    <div class="card-text-content">
                        <h3>{{ $blog->judul }}</h3>
                        <p>{{ $blog->deskripsi }}</p>
                        
                        <!-- FOOTER CARD BARU (Bikin gak kopong) -->
                        <div class="card-footer">
                            <span class="project-date">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                {{ $blog->created_at->translatedFormat('d F Y') }}
                            </span>
                            <span class="btn-detail">
                                Detail 
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                        
                    </div>
                </div>
                <div class="background-hider"></div>
            </a>
            @empty
            <p class="no-results show">Belum ada artikel blog yang tersedia.</p>
            @endforelse

            <p class="no-results" id="noResults">Tidak ada artikel yang cocok dengan pencarian kamu.</p>
        </div>

        <nav class="blog-pagination" id="blogPagination" aria-label="Navigasi halaman artikel"></nav>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --ink: #094356;
        --forest: #0A3547;
        --deep-teal: #0d5978;
        --primary: #094356;
        --primary-soft: #0d5978;
        --mint: #E7F1F3;
        --mint-bright: #FFFFFF;
        --sage: #6B7280;
        --gold: #094356;
        --gold-soft: #0d5978;
        --cream: #FAFAFA;
        --cream-warm: #F2F6F7;
        --ivory: #FFFFFF;
        --stone: #E7E9EE;
        --muted: #6B7280;
        --text: #171923;
        --text-soft: rgba(23, 25, 35, 0.68);
        --shadow-soft: 0 16px 40px rgba(0, 0, 0, 0.06);
        --shadow-lift: 0 22px 48px rgba(0, 0, 0, 0.12);
        --font-display: 'Inter', sans-serif;
        --font-heading: 'Inter', sans-serif;
        --font-body: 'Inter', sans-serif;
    }

    .page-wrapper {
        padding: 90px 0 0;
        background: #FFFFFF;
        min-height: 100vh;
        font-family: var(--font-body);
        color: var(--text);
        -webkit-font-smoothing: antialiased;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }

    /* ===== AREA KONTEN BAWAH ===== */
    .content-area {
        position: relative;
        padding: 70px 5% 100px;
        min-height: 60vh;
        background-color: #FAFAFA; 
        z-index: 1;

        width: 100vw;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        box-sizing: border-box; 
    }

    .particle-wrapper { 
        position: absolute; 
        inset: 0; 
        width: 100%; 
        height: 100%; 
        overflow: hidden; 
        z-index: 1; 
        pointer-events: none;
        opacity: 1; 
    }
    #particle-canvas { 
        display: block;
        width: 100%; 
        height: 100%; 
    }

    .content-area .projects-container,
    .content-area .blog-pagination {
        position: relative;
        z-index: 5; 
    }

    /* ===== HEADER ASLI ===== */
    .page-header {
        position: relative;
        width: 100vw;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-top: -90px;
        margin-bottom: 0;
        min-height: 460px;
        display: flex;
        align-items: center;
        background: var(--ink);
        box-shadow: var(--shadow-lift);
        isolation: isolate;
        z-index: 10; 
    }

    .page-header-media {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
        background-color: #03151c; 
        background-image: 
            radial-gradient(circle at 15% 0%, rgba(13, 89, 120, 0.35), transparent 45%),
            radial-gradient(circle at 85% 100%, rgba(9, 67, 86, 0.4), transparent 50%),
            url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.06'/%3E%3C/svg%3E"),
            url("https://images.unsplash.com/photo-1754548930550-be9fa88874f4?auto=format&fit=crop&w=1920&q=70");
        background-size: auto, auto, auto, cover;
        background-position: 0 0, 0 0, 0 0, center;
        background-repeat: repeat, repeat, repeat, no-repeat;
    }
    .page-header-media::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(3, 21, 28, 0.92) 0%, rgba(3, 21, 28, 0.72) 45%, rgba(3, 21, 28, 0.5) 100%),
            linear-gradient(rgba(9, 67, 86, 0.3), rgba(9, 67, 86, 0.3));
        pointer-events: none;
    }

    .page-header::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 1;
        background: radial-gradient(circle, transparent 50%, rgba(3, 21, 28, 0.6) 100%);
        pointer-events: none;
    }

    .page-header-text {
        position: relative;
        z-index: 2;
        max-width: 480px;
        padding: 0 5%;
    }
    .page-header-inner {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        max-width: 620px;
        width: 50%;
        min-width: 320px;
        margin: 0;
        padding: 16px 4% 18px;
        box-sizing: border-box;
        text-align: center;
        background: #FAFAFA; 
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
    }
    .page-header-inner::before,
    .page-header-inner::after {
        content: '';
        display: block;
        position: absolute;
        bottom: 0;
        width: 19px;
        height: 18px;
        background-color: transparent;
    }
    .page-header-inner::before {
        right: calc(100% - 1px);
        background-image: radial-gradient(circle at top left, transparent 70%, #FAFAFA 70%);
    }
    .page-header-inner::after {
        left: calc(100% - 1px);
        background-image: radial-gradient(circle at top right, transparent 70%, #FAFAFA 70%);
    }
    
    .page-header-text h1 {
        font-family: var(--font-display);
        font-size: clamp(2.1rem, 3.6vw, 3rem);
        color: #FFFFFF;
        margin-bottom: 14px;
        font-weight: 700;
        letter-spacing: -0.025em;
        line-height: 1.06;
    }
    .page-header-text h1 em {
        font-style: normal;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }
    .page-header-text .subtitle {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.98rem;
        font-family: var(--font-body);
        max-width: 420px;
        margin: 0;
        line-height: 1.65;
        font-weight: 400;
    }

    .header-search-row {
        position: relative;
        display: flex;
        align-items: stretch;
        justify-content: center;
        gap: 10px;
        max-width: 560px;
        margin: 0 auto;
    }

    .header-search-bar {
        position: relative;
        display: flex;
        align-items: center;
        flex: 1 1 auto;
        min-width: 0;
        height: 48px;
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 999px;
        padding: 0 5px 0 20px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .header-search-bar:focus-within {
        border-color: var(--primary);
        background: #FFFFFF;
        box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.08);
    }
    .header-search-input {
        flex: 1 1 auto;
        min-width: 0;
        width: 100%;
        height: 100%;
        font-family: var(--font-body);
        font-size: 0.92rem;
        color: var(--text);
        background: transparent;
        border: none;
        outline: none;
        padding: 0 10px 0 0;
        box-sizing: border-box;
    }
    .header-search-input::placeholder { color: var(--muted); }
    .search-bar-divider {
        width: 1px;
        align-self: stretch;
        margin: 10px 8px;
        background: rgba(0, 0, 0, 0.12);
        flex: 0 0 auto;
    }

    .category-filter {
        position: relative;
        flex: 0 0 auto;
        display: flex;
        align-items: center;
    }
    .header-search-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: var(--ivory);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.25s ease;
    }
    .header-search-btn:hover { background: var(--primary-soft); }
    .header-search-btn.active, .category-filter.open .header-search-btn { background: var(--primary-soft); }
    .category-filter.has-selection .header-search-btn { box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12); }
    .header-search-btn .filter-icon { color: #FFFFFF; }
    .header-search-btn .filter-label, .header-search-btn .chevron { display: none; }

    .count-filter {
        position: relative;
        flex: 0 0 auto;
    }
    .count-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 48px;
        padding: 0 18px;
        background: #FFFFFF;
        color: var(--text);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 999px;
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
        box-shadow: var(--shadow-soft);
        box-sizing: border-box;
        transition: border-color 0.25s ease, background 0.25s ease;
    }
    .count-filter-btn:hover { border-color: rgba(0, 0, 0, 0.2); }
    .count-filter-btn .chevron { transition: transform 0.2s ease; }
    .count-filter.open .count-filter-btn { border-color: var(--primary); background: #FFFFFF; }
    .count-filter.open .count-filter-btn .chevron { transform: rotate(180deg); }

    .count-filter-dropdown, .category-filter-dropdown {
        list-style: none;
        margin: 0;
        padding: 8px;
        position: absolute;
        top: calc(100% + 10px);
        right: 0;
        min-width: 140px;
        max-height: 260px;
        overflow-y: auto;
        background: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 14px;
        box-shadow: var(--shadow-lift);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(-8px);
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
        z-index: 30;
        text-align: left;
    }
    .category-filter-dropdown { min-width: 180px; }
    .count-filter.open .count-filter-dropdown, .category-filter.open .category-filter-dropdown {
        opacity: 1; visibility: visible; pointer-events: auto; transform: translateY(0);
    }
    .count-filter-dropdown li, .category-filter-dropdown li {
        padding: 9px 12px; border-radius: 8px; font-family: var(--font-body); font-size: 0.85rem; font-weight: 500; color: var(--text); cursor: pointer; transition: background 0.15s ease, color 0.15s ease;
    }
    .count-filter-dropdown li:hover, .category-filter-dropdown li:hover { background: var(--cream-warm); }
    .count-filter-dropdown li.active, .category-filter-dropdown li.active { background: var(--primary); color: #FFFFFF; }

    @media (min-width: 641px) {
        .page-header-inner { width: 90%; max-width: 960px; min-width: 0; }
        .header-search-row { max-width: none; gap: 12px; }
        .header-search-bar { height: auto; padding: 0; gap: 12px; background: transparent; border: none; border-radius: 0; box-shadow: none; }
        .header-search-bar:focus-within { background: transparent; box-shadow: none; }
        .header-search-input { height: 48px; padding: 0 22px; background: #FFFFFF; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 999px; transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease; }
        .header-search-input:focus { border-color: var(--primary); background: #FFFFFF; box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.08); }
        .search-bar-divider { display: none; }
        .row-filter-divider { display: none; }
        .header-search-btn { width: auto; height: 48px; padding: 0 18px; gap: 8px; background: #FFFFFF; color: var(--text); border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 999px; font-family: var(--font-body); font-size: 0.85rem; font-weight: 500; white-space: nowrap; box-shadow: var(--shadow-soft); box-sizing: border-box; transition: border-color 0.25s ease, background 0.25s ease; }
        .header-search-btn:hover { background: #FFFFFF; border-color: rgba(0, 0, 0, 0.2); }
        .header-search-btn.active, .category-filter.open .header-search-btn { background: var(--cream-warm); border-color: var(--primary); }
        .category-filter.has-selection .header-search-btn { border-color: var(--primary); box-shadow: var(--shadow-soft); }
        .header-search-btn .filter-icon { color: var(--text); }
        .header-search-btn .filter-label { display: inline-block; max-width: 150px; overflow: hidden; text-overflow: ellipsis; }
        .header-search-btn .chevron { display: block; transition: transform 0.2s ease; }
        .category-filter.open .header-search-btn .chevron { transform: rotate(180deg); }
        .category-filter-dropdown { right: auto; left: 0; min-width: 200px; }
        .count-filter { display: flex; align-items: center; }
        .count-filter-btn { width: auto; height: 48px; padding: 0 18px; gap: 8px; background: #FFFFFF; color: var(--text); border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 999px; box-shadow: var(--shadow-soft); }
        .count-filter-btn:hover { background: #FFFFFF; border-color: rgba(0, 0, 0, 0.2); }
        .count-filter.open .count-filter-btn { background: var(--cream-warm); border-color: var(--primary); }
        .count-filter-btn .row-filter-icon { width: 18px; height: 18px; }
        .count-filter-btn #countFilterLabel, .count-filter-btn .chevron { display: inline-block; }
    }

    /* ===== TAMPILAN MOBILE KHUSUS ===== */
    @media (max-width: 768px) {
        .page-header { min-height: 480px; flex-direction: column; justify-content: flex-end; align-items: stretch; padding-top: 56px; margin-bottom: 0 !important; }
        .page-header-text { padding: 0 6%; max-width: none; margin-bottom: 40px; }
        .page-header-text h1 { font-size: 2.2rem; }
        .page-header-text .subtitle { max-width: none; }
        .page-header-inner { position: relative; left: auto; bottom: auto; transform: none; width: 100%; max-width: none; min-width: 0; padding: 16px 5% 20px; border-top-left-radius: 0; border-top-right-radius: 0; box-sizing: border-box; }
        .page-header-media::before { background: linear-gradient(180deg, rgba(3, 21, 28, 0.5) 0%, rgba(3, 21, 28, 0.72) 55%, rgba(3, 21, 28, 0.92) 100%), linear-gradient(rgba(9, 67, 86, 0.3), rgba(9, 67, 86, 0.3)); }
        .page-header-inner::before, .page-header-inner::after { display: none; }
        
        .header-search-row { flex-wrap: nowrap; align-items: center; gap: 8px; }
        .header-search-bar { flex: 1 1 auto; min-width: 0; padding-left: 16px; padding-right: 10px; }
        .header-search-btn, .count-filter-btn { width: 34px; height: 34px; min-width: 34px; padding: 0; background: transparent !important; border: none !important; border-radius: 0; box-shadow: none !important; color: #000000 !important; justify-content: center; gap: 0; }
        .header-search-btn:hover, .header-search-btn.active, .category-filter.open .header-search-btn, .count-filter-btn:hover, .count-filter.open .count-filter-btn { background: transparent !important; border: none !important; box-shadow: none !important; color: #000000 !important; }
        .header-search-btn .filter-icon, .count-filter-btn .row-filter-icon { color: #000000 !important; stroke: #000000; }
        .category-filter, .count-filter { position: relative; flex: 0 0 auto; width: auto; display: flex; align-items: center; }
        .row-filter-divider { display: block; width: 1px; height: 22px; margin: 0 3px; background: rgba(0, 0, 0, 0.13); flex: 0 0 1px; }
        .count-filter-btn #countFilterLabel, .count-filter-btn .chevron { display: none; }
        .count-filter-btn .row-filter-icon { width: 20px; height: 20px; }
        .count-filter-dropdown { right: 0; left: auto; min-width: 145px; transform: translateY(-8px); }
        .count-filter.open .count-filter-dropdown { transform: translateY(0); }
        .category-filter-dropdown { right: 0; left: auto; min-width: 170px; max-width: calc(100vw - 40px); transform: translateY(-8px); }
        .category-filter.open .category-filter-dropdown { transform: translateY(0); }

        .content-area { 
            padding-top: 24px !important; 
            padding-left: 20px !important; 
            padding-right: 20px !important; 
            padding-bottom: 70px; 
            box-sizing: border-box; 
        }
        
        .projects-container { 
            display: grid;
            grid-template-columns: 1fr !important; 
            gap: 20px; 
            padding: 0; 
            width: 100%; 
            max-width: 450px; 
            margin: 0 auto !important; 
            box-sizing: border-box;
        }

        /* Penyesuaian Card di Mobile agar tetap rapi */
        .project-card { --card-border-radius: 12px; }
        .project-card .card-photo { aspect-ratio: 16 / 9; }
        .project-card .card-text-content { padding: 1rem; }
        .project-card .card-text-content h3 { font-size: 0.95rem; margin-bottom: 6px; }
        .project-card .card-text-content p { font-size: 0.78rem; margin-bottom: 12px; }
        
        .project-card .card-footer { padding-top: 12px; margin-top: auto; }
        .project-card .project-date { font-size: 0.7rem; }
        .project-card .btn-detail { font-size: 0.7rem; padding: 6px 12px; }
        
        .project-card .badge { top: 12px; min-height: 24px; padding: 0 16px 0 10px; font-size: 0.6rem; letter-spacing: 0.06em; clip-path: polygon(0 0, 100% 0, calc(100% - 10px) 50%, 100% 100%, 0 100%); }
        .project-card .badge::after { border-width: 5px 5px 0 0; }
        .project-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lift); }
        
        .blog-pagination { margin-top: 24px; gap: 6px; }
        .blog-pagination button { width: 36px; height: 36px; border-radius: 9px; font-size: 0.78rem; }
    }

    .no-results { display: none; grid-column: 1 / -1; text-align: center; color: var(--text-soft); font-family: var(--font-body); font-size: 0.95rem; padding: 48px 0; }
    .no-results.show { display: block; }

    /* ===== GRID CARD: Desktop 3 kolom & Styling Footer Card ===== */
    .projects-container {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
        max-width: 1080px;
        margin: 0 auto;
    }

    .project-card {
        --card-border-radius: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        min-width: 0;
        background-color: #FFFFFF;
        background-image: var(--bgImage);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
        border-radius: var(--card-border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        cursor: pointer;
        opacity: 0;
        transform: translateY(34px);
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1),
                    box-shadow 0.45s ease-out,
                    opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        will-change: opacity, transform;
    }

    .projects-container .project-card:nth-child(3n+2) { transition-delay: 0.08s; }
    .projects-container .project-card:nth-child(3n+3) { transition-delay: 0.16s; }

    .project-card.in-view { opacity: 1; transform: translateY(0); }

    @media (prefers-reduced-motion: reduce) {
        .project-card { transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s ease-out; opacity: 1 !important; transform: translateY(0) !important; }
    }

    .project-card:hover { transform: translateY(-8px) scale(1.01); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }

    .project-card .card-photo { position: relative; flex-shrink: 0; width: 100%; aspect-ratio: 16 / 9; border-radius: 0 0 0 var(--card-border-radius); overflow: hidden; z-index: 2; }
    .project-card .card-photo::before { content: ''; position: absolute; inset: 0; background-image: var(--bgImage); background-position: center; background-size: cover; background-repeat: no-repeat; transform: scale(1); transform-origin: center; transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1); will-change: transform; }
    .project-card:hover .card-photo::before { transform: scale(1.08); }

    .project-card .card-content { 
        position: relative; 
        box-sizing: border-box; 
        flex: 1 1 auto; /* Penting biar card-text-content ngisi full tinggi sisa */
        display: flex;
        flex-direction: column;
        width: 100%; 
        background: #FFFFFF; 
        border-radius: 0 var(--card-border-radius) 0 0; 
        border-top: 1px solid rgba(11, 20, 18, 0.06); 
        z-index: 2; 
    }
    .project-card .background-hider { position: absolute; width: var(--card-border-radius); height: 100%; background: #FFFFFF; left: 0; top: 0; z-index: 1; }

    .project-card .card-text-content { 
        position: relative; 
        box-sizing: border-box; 
        width: 100%; 
        flex: 1 1 auto;
        display: flex; 
        flex-direction: column; 
        justify-content: flex-start; 
        padding: 1.2rem; /* Agak dilebarin biar nafasnya lega */
    }
    .project-card .card-text-content h3 { font-family: var(--font-heading); font-size: 1.05rem; color: #000000; margin: 0 0 8px; line-height: 1.38; font-weight: 700; letter-spacing: -0.01em; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .project-card .card-text-content p { color: var(--text-soft); line-height: 1.45; font-size: 0.82rem; margin: 0 0 16px; font-weight: 400; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    
    /* STYLE CARD FOOTER BARU */
    .project-card .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto; /* Mendorong footer otomatis ke paling bawah card */
        padding-top: 14px;
        border-top: 1px dashed rgba(0, 0, 0, 0.08); /* Garis batas elegan */
    }

    .project-card .project-date { 
        display: flex;
        align-items: center;
        font-family: var(--font-heading); 
        font-size: 0.72rem; 
        font-weight: 500; 
        color: var(--sage); 
        margin: 0; 
    }

    .project-card .btn-detail { 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
        background: #f1f5f9; /* Warna awal soft abu-abu */
        color: var(--primary); 
        font-family: var(--font-heading); 
        font-size: 0.75rem; 
        font-weight: 600; 
        border-radius: 8px; /* Kotak rounded elegan ala startup */
        text-decoration: none; 
        padding: 6px 14px; 
        margin: 0; 
        transition: all 0.3s ease; 
    }
    .project-card:hover .btn-detail {
        background: var(--primary);
        color: #fff;
    }
    .project-card .btn-detail svg {
        margin-left: 4px;
        transition: transform 0.3s ease;
    }
    .project-card:hover .btn-detail svg {
        transform: translateX(3px); /* Efek panah maju pas di hover */
    }

    .project-card .badge { position: absolute; top: 20px; left: 0; z-index: 3; display: inline-flex; align-items: center; min-height: 32px; padding: 0 24px 0 16px; background: linear-gradient(135deg, #ff4d4d 0%, #e50000 55%, #b30000 100%); color: #FFFFFF; font-family: var(--font-heading); font-size: 0.66rem; font-weight: 700; letter-spacing: 0.09em; text-transform: uppercase; clip-path: polygon(0 0, 100% 0, calc(100% - 14px) 50%, 100% 100%, 0 100%); filter: drop-shadow(0 6px 10px rgba(0, 0, 0, 0.22)); }
    .project-card .badge::after { content: ''; position: absolute; left: 0; top: 100%; width: 0; height: 0; border-style: solid; border-width: 8px 8px 0 0; border-color: #7a0000 transparent transparent transparent; }

    /* ===== Pagination ===== */
    .blog-pagination { display: none; justify-content: center; align-items: center; gap: 7px; margin: 32px auto 0; max-width: 1200px; flex-wrap: wrap; }
    .blog-pagination.show { display: flex; }
    .blog-pagination button { width: 38px; height: 38px; padding: 0; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 10px; background: #FFFFFF; color: var(--text); font-family: var(--font-body); font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; }
    .blog-pagination button:hover:not(:disabled) { border-color: rgba(9, 67, 86, 0.35); background: var(--cream); }
    .blog-pagination button.active { background: var(--primary); border-color: var(--primary); color: #FFFFFF; }
    .blog-pagination button:disabled { opacity: 0.45; cursor: not-allowed; }
    .blog-pagination .pagination-arrow { font-size: 1rem; }

    @media (max-width: 1024px) {
        .projects-container { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
    }
</style>
@endpush

@push('styles')
<style>
    /* ===== Latar penuh sampai pojok kiri & kanan (mode terang maupun gelap) ===== */
    html, body {
        margin: 0;
        background-color: #FFFFFF;
        overflow-x: hidden;   /* cadangan untuk browser lama */
        overflow-x: clip;     /* mencegah scroll ke samping akibat lebar 100vw, tanpa memutus posisi fixed navbar */
    }
    html[data-theme="dark"],
    html[data-theme="dark"] body { background-color: #0a0f1a; }
    /* Pembungkus halaman dilebarkan penuh selebar layar, dan tidak lagi memotong (overflow hidden) elemen full-width di dalamnya */
    .page-wrapper {
        width: 100vw;
        max-width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        box-sizing: border-box;
        overflow: visible;
        overflow-x: clip;
    }

    /* ===== Mode gelap halaman Blog (aktif lewat html[data-theme="dark"], diatur tombol di navbar) ===== */
    html[data-theme="dark"] {
        --text: #e8eef0;
        --text-soft: rgba(232, 238, 240, 0.68);
        --muted: #8b97a8;
        --sage: #8b97a8;
        --cream: #131a2c;
        --cream-warm: #1f2a44;
        --shadow-soft: 0 16px 40px rgba(0, 0, 0, 0.35);
        --shadow-lift: 0 22px 48px rgba(0, 0, 0, 0.5);
    }
    .page-wrapper, .content-area, .page-header-inner, .project-card .card-content { transition: background-color 0.5s ease, color 0.5s ease; }

    html[data-theme="dark"] .page-wrapper,
    html[data-theme="dark"] .content-area,
    html[data-theme="dark"] .page-header-inner { background-color: #0a0f1a; }
    html[data-theme="dark"] .page-header-inner::before { background-image: radial-gradient(circle at top left, transparent 70%, #0a0f1a 70%); }
    html[data-theme="dark"] .page-header-inner::after { background-image: radial-gradient(circle at top right, transparent 70%, #0a0f1a 70%); }

    /* --- Kolom cari & filter --- */
    html[data-theme="dark"] .search-bar-divider,
    html[data-theme="dark"] .row-filter-divider { background: rgba(255, 255, 255, 0.16); }
    html[data-theme="dark"] .header-search-input::placeholder { color: rgba(232, 238, 240, 0.45); }
    html[data-theme="dark"] .header-search-btn .filter-icon { color: #e8eef0; }
    html[data-theme="dark"] .count-filter-dropdown,
    html[data-theme="dark"] .category-filter-dropdown { background: #182036; border-color: rgba(255, 255, 255, 0.1); }
    html[data-theme="dark"] .count-filter-dropdown li.active,
    html[data-theme="dark"] .category-filter-dropdown li.active { background: #0d6f86; color: #FFFFFF; }

    /* Mobile: bar pencarian berbentuk pil putih */
    @media (max-width: 640px) {
        html[data-theme="dark"] .header-search-bar,
        html[data-theme="dark"] .header-search-bar:focus-within { background: #182036; border-color: rgba(255, 255, 255, 0.14); }
        html[data-theme="dark"] .header-search-bar:focus-within { border-color: #8fd0bf; box-shadow: 0 0 0 4px rgba(143, 208, 191, 0.14); }
    }
    /* Ikon filter di mobile dipaksa hitam oleh kode asli, jadi perlu !important */
    html[data-theme="dark"] .header-search-btn .filter-icon,
    html[data-theme="dark"] .count-filter-btn .row-filter-icon { color: #e8eef0 !important; stroke: #e8eef0; }

    /* Desktop: input & tombol filter berbentuk pil putih */
    @media (min-width: 641px) {
        html[data-theme="dark"] .header-search-input,
        html[data-theme="dark"] .header-search-btn,
        html[data-theme="dark"] .count-filter-btn { background: #182036; border-color: rgba(255, 255, 255, 0.14); }
        html[data-theme="dark"] .header-search-input:focus { background: #182036; border-color: #8fd0bf; box-shadow: 0 0 0 4px rgba(143, 208, 191, 0.14); }
        html[data-theme="dark"] .header-search-btn:hover,
        html[data-theme="dark"] .count-filter-btn:hover { background: #1f2a44; border-color: rgba(255, 255, 255, 0.28); }
        html[data-theme="dark"] .header-search-btn.active,
        html[data-theme="dark"] .category-filter.open .header-search-btn,
        html[data-theme="dark"] .count-filter.open .count-filter-btn,
        html[data-theme="dark"] .category-filter.has-selection .header-search-btn { background: #1f2a44; border-color: #8fd0bf; }
        html[data-theme="dark"] .header-search-btn .filter-icon { color: #e8eef0; }
    }

    /* --- Kartu artikel --- */
    html[data-theme="dark"] .project-card { background-color: #131a2c; }
    html[data-theme="dark"] .project-card .card-content { background: #131a2c; border-top-color: rgba(255, 255, 255, 0.06); }
    html[data-theme="dark"] .project-card .background-hider { background: #131a2c; }
    html[data-theme="dark"] .project-card .card-text-content h3 { color: #eef6f3; }
    html[data-theme="dark"] .project-card .card-footer { border-top-color: rgba(255, 255, 255, 0.1); }
    html[data-theme="dark"] .project-card .btn-detail { background: #1f2a44; color: #8fd0bf; }
    html[data-theme="dark"] .project-card:hover .btn-detail { background: #0d6f86; color: #FFFFFF; }
    html[data-theme="dark"] .project-card:hover { box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5); }

    /* --- Pagination --- */
    html[data-theme="dark"] .blog-pagination button { background: #182036; border-color: rgba(255, 255, 255, 0.14); color: #e8eef0; }
    html[data-theme="dark"] .blog-pagination button:hover:not(:disabled) { background: #1f2a44; border-color: rgba(143, 208, 191, 0.5); }
    html[data-theme="dark"] .blog-pagination button.active { background: #0d6f86; border-color: #0d6f86; color: #FFFFFF; }
</style>
@endpush

@push('scripts')
<script>
    /* ===== Particle Technology Background Khusus Area Konten Bawah ===== */
    (function(){
        const canvas = document.getElementById('particle-canvas');
        const container = document.getElementById('mainContentArea'); 
        if(!canvas || !container) return;
        
        const ctx = canvas.getContext('2d');
        let particles = [], w = 0, h = 0, raf;
        
        function resize() { 
            w = canvas.width = container.offsetWidth * devicePixelRatio; 
            h = canvas.height = container.offsetHeight * devicePixelRatio; 
            ctx.setTransform(devicePixelRatio, 0, 0, devicePixelRatio, 0, 0); 
            w = container.offsetWidth; 
            h = container.offsetHeight; 
            
            particles = Array.from({ length: Math.max(45, Math.min(130, Math.floor(w * h / 15000))) }, () => ({
                x: Math.random() * w, y: Math.random() * h, 
                vx: (Math.random() - .5) * .22, vy: (Math.random() - .5) * .22
            })); 
        }
        
        function draw() { 
            ctx.clearRect(0, 0, w, h); 
            for(let i = 0; i < particles.length; i++) {
                let a = particles[i]; 
                a.x += a.vx; a.y += a.vy; 
                if(a.x < 0 || a.x > w) a.vx *= -1; 
                if(a.y < 0 || a.y > h) a.vy *= -1; 
                
                for(let j = i + 1; j < particles.length; j++) {
                    let b = particles[j], dx = a.x - b.x, dy = a.y - b.y, d = Math.hypot(dx, dy);
                    if(d < 140) { 
                        ctx.beginPath();
                        ctx.strokeStyle = 'rgba(115,165,160,' + ((140 - d) / 140 * 0.75) + ')'; 
                        ctx.lineWidth = 1.0; 
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                } 
                ctx.beginPath();
                ctx.fillStyle = 'rgba(115,165,160, 0.85)';
                ctx.arc(a.x, a.y, 1.6, 0, Math.PI * 2); 
                ctx.fill();
            } 
            raf = requestAnimationFrame(draw); 
        }
        
        resize(); 
        draw(); 

        window.addEventListener('resize', resize);
        
        if (window.ResizeObserver) {
            new ResizeObserver(resize).observe(container);
        }
    })();

    // --- Reveal saat discroll untuk kartu blog
    document.addEventListener('DOMContentLoaded', function () {
        try {
            const revealEls = document.querySelectorAll('.reveal');
            if (!revealEls.length) return;
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (prefersReducedMotion || !('IntersectionObserver' in window)) {
                revealEls.forEach(el => el.classList.add('in-view'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    entry.target.classList.toggle('in-view', entry.isIntersecting);
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -6% 0px' });
            revealEls.forEach(el => observer.observe(el));
        } catch (err) {
            document.querySelectorAll('.reveal').forEach(el => el.classList.add('in-view'));
        }
    });

    /* ===== Search + Filter + Pagination Blog ===== */
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('blogSearch');
        const cards = Array.from(document.querySelectorAll('.project-card'));
        const projectsContainer = document.getElementById('projectsContainer');
        const noResults = document.getElementById('noResults');
        const pagination = document.getElementById('blogPagination');

        const countFilter = document.getElementById('countFilter');
        const countFilterBtn = document.getElementById('countFilterBtn');
        const countFilterLabel = document.getElementById('countFilterLabel');
        const countFilterDropdown = document.getElementById('countFilterDropdown');
        const countItems = countFilterDropdown ? Array.from(countFilterDropdown.querySelectorAll('li')) : [];

        const categoryFilter = document.getElementById('categoryFilter');
        const filterToggleBtn = document.getElementById('filterToggleBtn');
        const categoryFilterLabel = document.getElementById('categoryFilterLabel');
        const categoryFilterDropdown = document.getElementById('categoryFilterDropdown');
        const categoryItems = categoryFilterDropdown ? Array.from(categoryFilterDropdown.querySelectorAll('li')) : [];

        let activeCategory = 'all';
        let activeCount = 'all'; 
        let currentPage = 1;

        function getColumnCount() {
            if (!projectsContainer) return 1;
            const style = window.getComputedStyle(projectsContainer);
            const columns = style.gridTemplateColumns.split(' ').map(v => v.trim()).filter(Boolean);
            return Math.max(1, columns.length);
        }

        function getFilteredCards() {
            const keyword = (searchInput?.value || '').trim().toLowerCase();
            return cards.filter(card => {
                const title = (card.dataset.title || '').toLowerCase();
                const category = card.dataset.category || '';
                const matchesKeyword = keyword === '' || title.includes(keyword);
                const matchesCategory = activeCategory === 'all' || category === activeCategory;
                return matchesKeyword && matchesCategory;
            });
        }

        function renderPagination(totalPages) {
            if (!pagination) return;
            pagination.innerHTML = '';
            if (activeCount === 'all' || totalPages <= 1) {
                pagination.classList.remove('show');
                return;
            }
            pagination.classList.add('show');

            const createButton = (label, page, extraClass = '', disabled = false) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = label;
                button.className = extraClass;
                button.disabled = disabled;
                button.addEventListener('click', function() {
                    if (disabled || page === currentPage) return;
                    currentPage = page;
                    applyFilters();
                    window.requestAnimationFrame(() => {
                        projectsContainer?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });
                pagination.appendChild(button);
            };

            createButton('‹', Math.max(1, currentPage - 1), 'pagination-arrow', currentPage === 1);
            for (let page = 1; page <= totalPages; page++) {
                createButton(String(page), page, page === currentPage ? 'active' : '');
            }
            createButton('›', Math.min(totalPages, currentPage + 1), 'pagination-arrow', currentPage === totalPages);
        }

        function applyFilters() {
            const matchedCards = getFilteredCards();
            const columns = getColumnCount();
            const rowsPerPage = activeCount === 'all' ? Infinity : Math.max(1, parseInt(activeCount, 10));
            const cardsPerPage = rowsPerPage === Infinity ? Infinity : columns * rowsPerPage;
            const totalPages = cardsPerPage === Infinity ? 1 : Math.max(1, Math.ceil(matchedCards.length / cardsPerPage));

            if (currentPage > totalPages) currentPage = totalPages;

            const startIndex = cardsPerPage === Infinity ? 0 : (currentPage - 1) * cardsPerPage;
            const endIndex = cardsPerPage === Infinity ? matchedCards.length : startIndex + cardsPerPage;
            const visibleSet = new Set(matchedCards.slice(startIndex, endIndex));

            cards.forEach(card => {
                const shouldShow = visibleSet.has(card);
                card.style.display = shouldShow ? '' : 'none';
                if (shouldShow) {
                    card.classList.remove('in-view');
                    window.requestAnimationFrame(() => card.classList.add('in-view'));
                }
            });

            noResults?.classList.toggle('show', matchedCards.length === 0);
            renderPagination(totalPages);
        }

        function closeAllDropdowns(except) {
            if (countFilter && except !== countFilter) { countFilter.classList.remove('open'); countFilterBtn?.setAttribute('aria-expanded', 'false'); }
            if (categoryFilter && except !== categoryFilter) { categoryFilter.classList.remove('open'); filterToggleBtn?.setAttribute('aria-expanded', 'false'); filterToggleBtn?.classList.remove('active'); }
        }

        countFilterBtn?.addEventListener('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            const isOpen = countFilter.classList.toggle('open');
            countFilterBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            closeAllDropdowns(countFilter);
        });

        countItems.forEach(item => {
            item.addEventListener('click', function() {
                countItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                activeCount = item.dataset.count || 'all';
                if (countFilterLabel) countFilterLabel.textContent = item.textContent.trim();
                currentPage = 1;
                countFilter.classList.remove('open'); countFilterBtn.setAttribute('aria-expanded', 'false');
                applyFilters();
            });
        });

        filterToggleBtn?.addEventListener('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            const isOpen = categoryFilter.classList.toggle('open');
            filterToggleBtn.classList.toggle('active', isOpen);
            filterToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            closeAllDropdowns(categoryFilter);
        });

        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                categoryItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                activeCategory = item.dataset.category || 'all';
                if (categoryFilterLabel) { categoryFilterLabel.textContent = activeCategory === 'all' ? 'Semua Kategori' : item.textContent.trim(); }
                categoryFilter.classList.toggle('has-selection', activeCategory !== 'all');
                categoryFilter.classList.remove('open'); filterToggleBtn?.classList.remove('active'); filterToggleBtn?.setAttribute('aria-expanded', 'false');
                currentPage = 1; applyFilters();
            });
        });

        document.addEventListener('click', function(e) {
            if (countFilter && !countFilter.contains(e.target)) { countFilter.classList.remove('open'); countFilterBtn?.setAttribute('aria-expanded', 'false'); }
            if (categoryFilter && !categoryFilter.contains(e.target)) { categoryFilter.classList.remove('open'); filterToggleBtn?.classList.remove('active'); filterToggleBtn?.setAttribute('aria-expanded', 'false'); }
        });

        searchInput?.addEventListener('input', function() { currentPage = 1; applyFilters(); });

        let resizeTimer;
        window.addEventListener('resize', function() { clearTimeout(resizeTimer); resizeTimer = setTimeout(function() { currentPage = 1; applyFilters(); }, 120); });

        applyFilters();
    });
</script>
@endpush
@endsection