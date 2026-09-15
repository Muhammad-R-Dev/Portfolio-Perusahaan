@extends('layouts.app')

@section('title', 'Blog - PT Astabrata Teknologi')

@section('content')
@php
    $categories = $blogs->pluck('kategori')->filter()->unique()->values();
@endphp
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-header-media">
            <img class="page-header-img" src="https://images.unsplash.com/photo-1711025372958-db48a4fe0ba1?fm=jpg&q=80&w=2000&auto=format&fit=crop" alt="Wawasan Kami">
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
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 5H20L14 12.2V19L10 17V12.2L4 5Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="category-filter-dropdown" id="categoryFilterDropdown" role="listbox">
                            <li data-category="all" class="active" role="option">Semua</li>
                            @foreach($categories as $cat)
                            <li data-category="{{ $cat }}" role="option">{{ $cat }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="count-filter" id="countFilter">
                    <button type="button" class="count-filter-btn" id="countFilterBtn" aria-haspopup="listbox" aria-expanded="false">
                        <span id="countFilterLabel">Semua</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" class="chevron" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                    <span class="project-date">{{ $blog->created_at->translatedFormat('d F Y') }}</span>
                    <span class="btn-detail">Detail</span>
                </div>
            </div>
            <div class="background-hider"></div>
        </a>
        @empty
        <p class="no-results show">Belum ada artikel blog yang tersedia.</p>
        @endforelse

        <p class="no-results" id="noResults">Tidak ada artikel yang cocok dengan pencarian kamu.</p>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --ink: #0A0A0A;
        --forest: #141414;
        --deep-teal: #1A1A1A;
        --primary: #111111;
        --primary-soft: #2E2E2E;
        --mint: #E5E5E5;
        --mint-bright: #FFFFFF;
        --sage: #8A8A8A;
        --gold: #000000;
        --gold-soft: #4D4D4D;
        --cream: #F5F5F5;
        --cream-warm: #EFEFEF;
        --ivory: #FFFFFF;
        --stone: #E2E2E2;
        --muted: #6E6E6E;
        --text: #111111;
        --text-soft: rgba(17, 17, 17, 0.68);
        --shadow-soft: 0 16px 40px rgba(0, 0, 0, 0.06);
        --shadow-lift: 0 22px 48px rgba(0, 0, 0, 0.12);
        --font-display: 'Inter', sans-serif;
        --font-heading: 'Inter', sans-serif;
        --font-body: 'Inter', sans-serif;
    }

    .page-wrapper {
        padding: 90px 5% 100px;
        background: #FFFFFF;
        min-height: 100vh;
        font-family: var(--font-body);
        color: var(--text);
        -webkit-font-smoothing: antialiased;
        position: relative;
        overflow: hidden;
        isolation: isolate;
    }
    .page-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(0, 0, 0, 0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 0, 0, 0.025) 1px, transparent 1px);
        background-size: 64px 64px;
        mask-image: radial-gradient(ellipse 70% 60% at 50% 20%, #000 20%, transparent 75%);
        pointer-events: none;
        z-index: 0;
    }
    .page-wrapper > * {
        position: relative;
        z-index: 1;
    }

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
        z-index: 5;
    }
    .page-header-media {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
    }
    .page-header-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .page-header::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 1;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.25) 45%, transparent 72%);
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
        background: #FFFFFF;
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
        background-image: radial-gradient(
            circle at top left,
            transparent 70%,
            #fff 70%
        );
    }
    .page-header-inner::after {
        left: calc(100% - 1px);
        background-image: radial-gradient(
            circle at top right,
            transparent 70%,
            #fff 70%
        );
    }
    .page-header .eyebrow {
        font-family: var(--font-heading);
        color: #FFFFFF;
        font-weight: 600;
        letter-spacing: 0.24em;
        text-transform: uppercase;
        font-size: 0.76rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding: 9px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.28);
        backdrop-filter: blur(8px);
    }
    .page-header .eyebrow::before {
        content: '';
        width: 18px;
        height: 1px;
        background: linear-gradient(90deg, transparent, #FFFFFF, transparent);
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

    /* ===== Unified search bar: input + category filter icon in one pill ===== */
    .header-search-bar {
        position: relative;
        display: flex;
        align-items: center;
        flex: 1 1 auto;
        min-width: 0;
        height: 48px;
        background: var(--cream);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 999px;
        padding: 0 5px 0 20px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
    }
    .header-search-bar:focus-within {
        border-color: var(--primary);
        background: var(--ivory);
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
    .header-search-input::placeholder {
        color: var(--muted);
    }
    .search-bar-divider {
        width: 1px;
        align-self: stretch;
        margin: 10px 8px;
        background: rgba(0, 0, 0, 0.12);
        flex: 0 0 auto;
    }

    /* ===== Filter icon button (opens category dropdown), merged into the search pill ===== */
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
    .header-search-btn:hover {
        background: var(--primary-soft);
    }
    .header-search-btn.active,
    .category-filter.open .header-search-btn {
        background: var(--primary-soft);
    }
    .category-filter.has-selection .header-search-btn {
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.12);
    }

    /* ===== Count filter — its own separate card beside the search bar ===== */
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
    .count-filter-btn:hover {
        border-color: rgba(0, 0, 0, 0.2);
    }
    .count-filter-btn .chevron {
        transition: transform 0.2s ease;
    }
    .count-filter.open .count-filter-btn {
        border-color: var(--primary);
        background: var(--cream);
    }
    .count-filter.open .count-filter-btn .chevron {
        transform: rotate(180deg);
    }

    /* ===== Shared dropdown list style ===== */
    .count-filter-dropdown,
    .category-filter-dropdown {
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
    .category-filter-dropdown {
        min-width: 180px;
    }
    .count-filter.open .count-filter-dropdown,
    .category-filter.open .category-filter-dropdown {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0);
    }
    .count-filter-dropdown li,
    .category-filter-dropdown li {
        padding: 9px 12px;
        border-radius: 8px;
        font-family: var(--font-body);
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--text);
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease;
    }
    .count-filter-dropdown li:hover,
    .category-filter-dropdown li:hover {
        background: var(--cream);
    }
    .count-filter-dropdown li.active,
    .category-filter-dropdown li.active {
        background: var(--primary);
        color: #FFFFFF;
    }

    @media (max-width: 640px) {
        .page-header { min-height: 480px; align-items: flex-start; padding-top: 56px; }
        .page-header-text { padding: 0 6%; max-width: none; }
        .page-header-text .subtitle { max-width: none; }
        .page-header-inner {
            width: 100%;
            max-width: none;
            min-width: 0;
            padding: 20px 6% 24px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
        .page-header-inner::before,
        .page-header-inner::after {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .header-search-row {
            flex-wrap: wrap;
        }
        .header-search-bar {
            flex: 1 1 100%;
        }
        .count-filter {
            flex: 1 1 100%;
        }
        .count-filter-btn {
            width: 100%;
            justify-content: center;
        }
        .count-filter-dropdown,
        .category-filter-dropdown {
            right: auto;
            left: 50%;
            transform: translateX(-50%) translateY(-8px);
        }
        .count-filter.open .count-filter-dropdown,
        .category-filter.open .category-filter-dropdown {
            transform: translateX(-50%) translateY(0);
        }
    }

    .no-results {
        display: none;
        grid-column: 1 / -1;
        text-align: center;
        color: var(--text-soft);
        font-family: var(--font-body);
        font-size: 0.95rem;
        padding: 48px 0;
    }
    .no-results.show {
        display: block;
    }

    @media (max-width: 720px) {
        .page-wrapper {
            padding-top: 80px;
            padding-left: 14px;
            padding-right: 14px;
            padding-bottom: 70px;
        }
        .projects-container {
            grid-template-columns: minmax(0, 420px);
            justify-content: center;
            padding: 0;
            max-width: none;
        }
        .project-card {
            width: 100%;
        }
    }

    .projects-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 340px));
        justify-content: center;
        gap: 36px;
        max-width: 1200px;
        margin: 56px auto 0;
    }

    .project-card {
        --card-border-radius: 20px;
        position: relative;
        display: block;
        width: 100%;
        aspect-ratio: 3 / 4;
        background-color: #FFFFFF;
        background-image: var(--bgImage);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
        border-radius: var(--card-border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-soft);
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.45s ease-out;
        cursor: pointer;
    }
    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lift);
    }

    .project-card .card-photo {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 58%;
        border-radius: 0 0 0 var(--card-border-radius);
        overflow: hidden;
        z-index: 2;
    }
    .project-card .card-photo::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: var(--bgImage);
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        transform: scale(1);
        transform-origin: center;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        will-change: transform;
    }
    .project-card:hover .card-photo::before {
        transform: scale(1.08);
    }

    .project-card .card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 42%;
        background: #FFFFFF;
        border-radius: 0 var(--card-border-radius) 0 0;
        border-top: 1px solid rgba(11, 20, 18, 0.06);
        z-index: 2;
    }

    .project-card .background-hider {
        position: absolute;
        width: var(--card-border-radius);
        height: 100%;
        background: #FFFFFF;
        left: 0;
        top: 0;
        z-index: 1;
    }

    .project-card .card-text-content {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        gap: 6px;
        padding: 1.05rem 1.35rem 1.1rem;
    }

    .project-card .project-date {
        font-family: var(--font-heading);
        font-size: 0.76rem;
        font-weight: 500;
        color: var(--muted);
        letter-spacing: 0.01em;
        display: block;
        margin-top: 2px;
    }

    .project-card .btn-detail {
        align-self: flex-start;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: var(--ivory);
        font-family: var(--font-heading);
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.02em;
        border-radius: 999px;
        text-decoration: none;
        padding: 9px 22px;
        margin-top: 10px;
        opacity: 1;
        transform: none;
        transition: none;
    }

    /* Category label styled as a ribbon banner, flush with the card's left edge */
    .project-card .badge {
        position: absolute;
        top: 20px;
        left: 0;
        z-index: 3;
        display: inline-flex;
        align-items: center;
        min-height: 32px;
        padding: 0 24px 0 16px;
        background: linear-gradient(135deg, #ff4d4d 0%, #e50000 55%, #b30000 100%);
        color: #FFFFFF;
        font-family: var(--font-heading);
        font-size: 0.66rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        clip-path: polygon(0 0, 100% 0, calc(100% - 14px) 50%, 100% 100%, 0 100%);
        filter: drop-shadow(0 6px 10px rgba(0, 0, 0, 0.22));
    }
    .project-card .badge::after {
        content: '';
        position: absolute;
        left: 0;
        top: 100%;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 8px 8px 0 0;
        border-color: #7a0000 transparent transparent transparent;
    }
    .project-card .card-text-content h3 {
        font-family: var(--font-heading);
        font-size: 1.02rem;
        color: #000000;
        margin-bottom: 0;
        line-height: 1.3;
        font-weight: 600;
        letter-spacing: -0.01em;
    }
    .project-card .card-text-content p {
        color: var(--text-soft);
        line-height: 1.5;
        font-size: 0.86rem;
        margin: 2px 0 0;
        font-weight: 400;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .page-header-text h1 { font-size: 1.7rem; }
        .projects-container { gap: 28px; }
        .project-card { aspect-ratio: 3 / 4; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const revealEls = document.querySelectorAll('.reveal');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1;
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealEls.forEach(el => {
            el.style.opacity = 0;
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    });

    /* ===== Search + Filter Blog ===== */
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('blogSearch');
        const cards = document.querySelectorAll('.project-card');
        const noResults = document.getElementById('noResults');

        const countFilter = document.getElementById('countFilter');
        const countFilterBtn = document.getElementById('countFilterBtn');
        const countFilterLabel = document.getElementById('countFilterLabel');
        const countFilterDropdown = document.getElementById('countFilterDropdown');
        const countItems = countFilterDropdown ? countFilterDropdown.querySelectorAll('li') : [];

        const categoryFilter = document.getElementById('categoryFilter');
        const filterToggleBtn = document.getElementById('filterToggleBtn');
        const categoryFilterDropdown = document.getElementById('categoryFilterDropdown');
        const categoryItems = categoryFilterDropdown ? categoryFilterDropdown.querySelectorAll('li') : [];

        let activeCategory = 'all';
        let activeCount = 'all';

        function applyFilters() {
            const keyword = (searchInput?.value || '').trim().toLowerCase();
            const limit = activeCount === 'all' ? Infinity : parseInt(activeCount, 10);
            let visibleCount = 0;
            let shown = 0;

            cards.forEach(card => {
                const title = (card.dataset.title || '').toLowerCase();
                const category = card.dataset.category || '';
                const matchesKeyword = keyword === '' || title.includes(keyword);
                const matchesCategory = activeCategory === 'all' || category === activeCategory;

                let show = matchesKeyword && matchesCategory;
                if (show && shown >= limit) {
                    show = false;
                }

                card.style.display = show ? '' : 'none';
                if (show) {
                    shown++;
                    visibleCount++;
                }
            });

            noResults?.classList.toggle('show', visibleCount === 0);
        }

        function closeAllDropdowns(except) {
            if (countFilter && except !== countFilter) {
                countFilter.classList.remove('open');
                countFilterBtn?.setAttribute('aria-expanded', 'false');
            }
            if (categoryFilter && except !== categoryFilter) {
                categoryFilter.classList.remove('open');
                filterToggleBtn?.setAttribute('aria-expanded', 'false');
            }
        }

        // Toggle count dropdown (5 / 10 / 20 / Semua)
        countFilterBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = countFilter.classList.toggle('open');
            countFilterBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            closeAllDropdowns(countFilter);
        });

        countItems.forEach(item => {
            item.addEventListener('click', function() {
                countItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                activeCount = item.dataset.count;
                countFilterLabel.textContent = item.textContent;
                countFilter.classList.remove('open');
                countFilterBtn.setAttribute('aria-expanded', 'false');
                applyFilters();
            });
        });

        // Toggle category dropdown (opened by the filter icon)
        filterToggleBtn?.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = categoryFilter.classList.toggle('open');
            filterToggleBtn.classList.toggle('active', isOpen);
            filterToggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            closeAllDropdowns(categoryFilter);
        });

        categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                categoryItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                activeCategory = item.dataset.category;
                categoryFilter.classList.toggle('has-selection', activeCategory !== 'all');
                categoryFilter.classList.remove('open');
                filterToggleBtn.classList.remove('active');
                filterToggleBtn.setAttribute('aria-expanded', 'false');
                applyFilters();
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (countFilter && !countFilter.contains(e.target)) {
                countFilter.classList.remove('open');
                countFilterBtn?.setAttribute('aria-expanded', 'false');
            }
            if (categoryFilter && !categoryFilter.contains(e.target)) {
                categoryFilter.classList.remove('open');
                filterToggleBtn?.classList.remove('active');
                filterToggleBtn?.setAttribute('aria-expanded', 'false');
            }
        });

        // Live search as the user types
        searchInput?.addEventListener('input', applyFilters);
    });

</script>
@endpush
@endsection