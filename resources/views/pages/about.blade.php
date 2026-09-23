@extends('layouts.app')

@section('title', 'About Us - PT Astabrata Teknologi')

@section('content')
<div class="page-wrapper">
    <div class="about-header reveal">
        <span class="eyebrow">Tentang Perusahaan</span>
        <h1>PT Astabrata Teknologi</h1>
        <p class="subtitle">Membangun inovasi masa depan melalui solusi teknologi yang andal, estetis, dan berdampak nyata bagi pertumbuhan bisnis Anda.</p>
    </div>

    <section class="about-section reveal">
        <div class="about-content">
            <div class="about-container">
                <div class="about-text">
                    <p>PT Astabrata Teknologi adalah perusahaan penyedia layanan IT terkemuka yang berdedikasi untuk mentransformasi ide menjadi solusi digital tingkat tinggi. Kami percaya bahwa setiap masalah bisnis memiliki jawaban teknologi yang tepat. Dengan perpaduan keahlian rekayasa perangkat lunak dan desain UI/UX yang modern, kami hadir sebagai mitra strategis untuk akselerasi digital Anda.</p>
                    <p>Filosofi "Astabrata" yang melambangkan 8 sifat alam semesta menjadi pedoman kami dalam berkarya: adaptif seperti air, kokoh seperti bumi, dan menerangi seperti matahari. Kami berkomitmen memberikan layanan terbaik dengan standar profesionalisme tertinggi.</p>

                    <div class="about-social">
                        <a href="#" title="Facebook" aria-label="Facebook" target="_blank" rel="noopener"><i class="bx bxl-facebook"></i></a>
                        <a href="#" title="Instagram" aria-label="Instagram" target="_blank" rel="noopener"><i class="bx bxl-instagram"></i></a>
                        <a href="#" title="Twitter" aria-label="Twitter" target="_blank" rel="noopener"><i class="bx bxl-twitter"></i></a>
                        <a href="#" title="YouTube" aria-label="YouTube" target="_blank" rel="noopener"><i class="bx bxl-youtube"></i></a>
                    </div>
                </div>
                <div class="about-image" role="img" aria-label="Tentang Astabrata" style="background-image: url('{{ asset('image/kantor.jpeg') }}');"></div>
            </div>
        </div>
    </section>

    <section class="team-section reveal" id="tim-kami">
        <div class="th-card-wrapper">
            <div class="particle-background" aria-hidden="true">
                <div id="particle-canvas"></div>
            </div>

            <div class="section-heading text-center">
                <h2>Tim Kami</h2>
                <p>Orang-orang hebat di balik setiap baris kode dan desain yang kami buat.</p>
            </div>

            <div class="th-slider-container" id="thSliderContainer">
                <div class="th-slider-track" id="thSliderTrack">
                    @forelse($teams as $team)
                    <div class="th-card" data-title="{{ $team->nama }}" data-desc="{{ $team->jabatan }} &bull; {{ $team->divisi }}">
                        <div class="th-card-photo">
                            <img src="{{ $team->foto_url }}" alt="{{ $team->nama }}">
                            <div class="th-hover-overlay"><span>{{ $team->jabatan }}</span></div>
                        </div>
                        <div class="th-card-name">
                            <h3>{{ $team->nama }}</h3>
                            <p>{{ $team->jabatan }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="th-card" data-title="Tim Astabrata" data-desc="Segera hadir">
                        <div class="th-card-photo">
                            <img src="{{ asset('image/profile.png') }}" alt="Tim Astabrata">
                            <div class="th-hover-overlay"><span>Segera hadir</span></div>
                        </div>
                        <div class="th-card-name">
                            <h3>Tim Astabrata</h3>
                            <p>Segera hadir</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    @php
        // Data untuk filter galeri
        $galleryList = collect($galleries ?? []);
        $galleryCategories = $galleryList
            ->map(fn ($g) => trim((string) ($g->kategori ?? '')))
            ->filter()
            ->unique()
            ->values();
        $hasCategories = $galleryCategories->isNotEmpty();
        $hasUncategorized = $hasCategories && $galleryList->contains(fn ($g) => trim((string) ($g->kategori ?? '')) === '');
    @endphp

    <section class="gallery-section reveal">
        <div class="gallery-particles" id="galleryParticles" aria-hidden="true"></div>
        <div class="gallery-inner">
            <div class="section-heading text-center">
                <h2>Galeri Kegiatan</h2>
                <p>Momen-momen di balik layar tim Astabrata Teknologi.</p>
            </div>

            @if($galleryList->count() > 1)
            <div class="gallery-filter" role="group" aria-label="Filter galeri">
                <div class="gallery-filter-track">
                    <button type="button" class="gallery-filter-btn is-active" data-type="all" data-filter="all" aria-pressed="true">Semua</button>
                    @if($hasCategories)
                        @foreach($galleryCategories as $galleryCat)
                            <button type="button" class="gallery-filter-btn" data-type="category" data-filter="{{ \Illuminate\Support\Str::slug($galleryCat) }}" aria-pressed="false">{{ $galleryCat }}</button>
                        @endforeach
                        @if($hasUncategorized)
                            <button type="button" class="gallery-filter-btn" data-type="category" data-filter="lainnya" aria-pressed="false">Lainnya</button>
                        @endif
                    @else
                        {{-- Belum ada kolom "kategori" di data galeri: filter berdasarkan bentuk foto --}}
                        <button type="button" class="gallery-filter-btn" data-type="orientation" data-filter="landscape" aria-pressed="false">Lanskap</button>
                        <button type="button" class="gallery-filter-btn" data-type="orientation" data-filter="portrait" aria-pressed="false">Potret</button>
                    @endif
                </div>
            </div>
            @endif

            <div class="gallery-grid" id="galleryGrid">
                @forelse($galleries as $gallery)
                    @php
                        $itemCat = trim((string) ($gallery->kategori ?? ''));
                        $itemCatSlug = $hasCategories ? ($itemCat !== '' ? \Illuminate\Support\Str::slug($itemCat) : 'lainnya') : '';
                        $itemTitle = trim((string) ($gallery->judul ?? ''));
                    @endphp
                    <figure class="gallery-card" data-category="{{ $itemCatSlug }}" tabindex="0" role="button" aria-label="Lihat foto{{ $itemTitle !== '' ? ': ' . $itemTitle : '' }}">
                        <img src="{{ $gallery->foto_url }}" class="gallery-item" data-caption="{{ $itemTitle }}" data-category-label="{{ $itemCat }}" alt="{{ $itemTitle !== '' ? $itemTitle : 'Foto galeri' }}" decoding="async" @if($hasCategories) loading="lazy" @endif>
                        @if($itemCat !== '' || $itemTitle !== '')
                            <figcaption class="gallery-overlay">
                                @if($itemTitle !== '')<span class="gallery-title">{{ $itemTitle }}</span>@endif
                                @if($itemCat !== '')<span class="gallery-cat">{{ $itemCat }}</span>@endif
                            </figcaption>
                        @endif
                        <span class="gallery-zoom" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                        </span>
                    </figure>
                @empty
                    <figure class="gallery-card" data-category="" tabindex="0" role="button" aria-label="Lihat foto: Galeri Astabrata">
                        <img src="{{ asset('image/asta1.png') }}" class="gallery-item" data-caption="Galeri Astabrata" alt="Galeri Astabrata" decoding="async">
                        <figcaption class="gallery-overlay">
                            <span class="gallery-title">Galeri Astabrata</span>
                        </figcaption>
                        <span class="gallery-zoom" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                        </span>
                    </figure>
                @endforelse
            </div>

            <p class="gallery-empty" id="galleryEmpty" hidden>Belum ada foto pada kategori ini.</p>
        </div>
    </section>
</div>

<div id="imageModal" class="custom-modal">
    <div class="modal-content-wrapper">
        <div class="modal-photo">
            <img class="modal-content" id="zoomedImage" alt="">

            <div class="modal-info" id="modalInfo" hidden>
                <h3 class="modal-info-title" id="modalTitle"></h3>
                <p class="modal-info-cat" id="modalCategory"></p>
            </div>

            <button type="button" class="close-modal" aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            </button>
        </div>

        <button type="button" class="modal-nav-btn prev-btn" id="modalPrev" aria-label="Foto sebelumnya">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button type="button" class="modal-nav-btn next-btn" id="modalNext" aria-label="Foto berikutnya">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<style>
    /* RESET PENTING UNTUK MENCEGAH MENGGESER KE KANAN */
    html, body {
        width: 100% !important;
        max-width: 100vw !important;
        overflow-x: hidden !important; /* MENGUNCI LAYAR KANAN KIRI */
        margin: 0;
        padding: 0;
    }

    *, *::before, *::after {
        box-sizing: border-box;
    }

    .page-wrapper {
        position: relative;
        padding: 90px 5% 0;
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        isolation: isolate;
        background: #ffffff;
    }

    .page-wrapper > * {
        position: relative;
        z-index: 5;
    }
    
    .about-header {
        text-align: center;
        margin-bottom: 60px;
    }
    .eyebrow {
        font-family: 'Poppins', sans-serif;
        color: #094356;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-size: 1rem;
        display: block;
        margin-bottom: 15px;
    }
    .about-header h1 {
        font-family: 'Sora', sans-serif;
        font-size: 3.5rem;
        color: #094356;
        margin-bottom: 20px;
        font-weight: 800;
    }
    .subtitle {
        color: #4A5A61;
        font-size: 1.2rem;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .section-heading {
        margin-bottom: 50px;
    }
    .section-heading h2 {
        font-family: 'Sora', sans-serif;
        font-size: 2.5rem;
        color: #094356;
        margin-bottom: 10px;
    }
    .section-heading p {
        color: #57676D;
        font-size: 1.1rem;
    }
    .text-center { text-align: center; }

    /* About Section */
    .about-section {
        position: relative;
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        background: transparent;
        border: 0;
        box-shadow: none;
    }

    .particle-background {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
        opacity: 0.72;
        background:
            radial-gradient(circle at 18% 18%, rgba(126, 190, 207, 0.18) 0%, rgba(126, 190, 207, 0) 28%),
            radial-gradient(circle at 84% 38%, rgba(159, 214, 185, 0.15) 0%, rgba(159, 214, 185, 0) 30%),
            radial-gradient(circle at 42% 82%, rgba(78, 151, 170, 0.10) 0%, rgba(78, 151, 170, 0) 32%);
    }

    .particle-background #particle-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        opacity: 1;
    }

    /* ===== Siapa Kami (gaya mengikuti about.html: Roboto, biru teal, teks putih) ===== */
    .about-section {
        --about-font: "Roboto", ui-sans-serif, sans-serif;
        --about-white: #ffffff;
        --about-bg: #0d4358;
        --about-blue-300: hsl(217, 80%, 55%);
        --about-shadow-medium: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px,
                               rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
    }

    /* Band penuh selebar layar */
    .about-content {
        position: relative;
        z-index: 5;
        width: calc(100% + 10vw);
        max-width: none;
        margin-left: -5vw;
        margin-right: -5vw;
        padding: 6rem 5vw 5rem;
        box-sizing: border-box;
        overflow: hidden; /* foto yang dipojokkan & animasi scale tidak menyembul keluar band */
        background-color: var(--about-bg);
        color: var(--about-white);
        font-family: var(--about-font);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }

    .about-container {
        position: relative;
        display: grid;
        align-items: stretch;
        row-gap: 3rem;
        column-gap: 2rem;
        max-width: 75rem;
        margin-inline: auto;
    }

    .about-text {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        row-gap: 1.5rem;
        position: relative;
        z-index: 5;
        font-family: var(--about-font);
    }

    .about-text::before {
        content: 'TENTANG KAMI';
        display: block;
        font-family: var(--about-font);
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.18em;
        color: rgba(255, 255, 255, 0.7);
    }

    .about-text h2 {
        margin: 0;
        font-family: var(--about-font);
        font-size: clamp(2.65rem, 6vw, 4rem);
        font-weight: 700;
        line-height: 1.15;
        letter-spacing: normal;
        color: var(--about-white);
        text-wrap: balance;
    }

    .about-text p {
        margin: 0;
        font-family: var(--about-font);
        font-size: clamp(1rem, 2vw, 1.125rem);
        font-weight: 400;
        line-height: 1.5;
        color: var(--about-white);
        text-wrap: pretty;
    }

    .about-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        column-gap: 0.35rem;
        padding: 0.5rem 1.25rem;
        font-family: var(--about-font);
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.5;
        white-space: nowrap;
        text-decoration: none;
        color: var(--about-white);
        background-color: var(--about-blue-300);
        border: none;
        border-radius: 3rem;
        box-shadow: var(--about-shadow-medium);
        transition: all 0.25s ease;
    }

    .about-btn:hover {
        color: var(--about-white);
        filter: brightness(1.1);
        transform: translateY(-2px);
    }

    /* MOBILE & TABLET (default, di bawah 64rem): layout bertumpuk.
       Rasio dikunci sama dengan foto asli (kantor.jpeg 1152x921) supaya
       seluruh foto tampil pas, tidak terpotong. Tanpa blur dan tanpa fade. */
    .about-image {
        position: relative;
        z-index: 5;
        width: 100%;
        max-width: 40rem;
        aspect-ratio: 1152 / 921;
        justify-self: center;
        border-radius: 0.6rem;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .about-image::before {
        content: none;
    }

    /* Tint gelap tipis di bagian bawah foto + "selimut" tint tipis merata
       di seluruh foto supaya warnanya lebih menyatu dengan background band */
    .about-image::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background:
            linear-gradient(180deg, rgba(13, 67, 88, 0) 60%, rgba(13, 67, 88, 0.45) 100%),
            rgba(13, 67, 88, 0.22);
    }

    /* ===== Ikon sosial media =====
       Sekarang menyatu di bawah paragraf deskripsi (.about-text), horizontal
       di semua ukuran layar, diapit garis kiri & kanan. */
    .about-social {
        display: flex;
        align-items: center;
        justify-content: center;
        column-gap: 1.25rem;
        width: 100%;
        position: relative;
        z-index: 5;
    }

    .about-social > a {
        font-size: 1.5rem;
        line-height: 1;
        text-decoration: none;
        color: var(--about-white);
        transition: opacity 0.25s ease, transform 0.25s ease;
    }

    .about-social > a:hover {
        opacity: 0.7;
        transform: translateY(-2px);
    }

    .about-social::before,
    .about-social::after {
        content: "";
        flex: 1 1 0;
        height: 1.5px;
        background: var(--about-white);
    }

    /* DESKTOP (>= 64rem): 2 kolom, foto dipojokkan ke kanan.
       Foto dikeluarkan dari alur grid (absolute terhadap .about-content yang
       selebar layar) dan menempel di tepi kanan, atas, dan bawah band.
       Lebar foto = kolom kanan + jarak container ke tepi layar
       (max(5vw, (lebar band - 75rem) / 2)), jadi tetap mentok kanan di
       layar selebar apa pun. Kolom kanan ikut mengecil di laptop kecil
       (44vw) supaya kotak foto tidak jadi terlalu sempit/tinggi. */
    @media screen and (min-width: 64rem) {
        .about-container {
            --about-img-col: min(38rem, 44vw);
            position: static; /* supaya foto mengacu ke .about-content */
            grid-template-columns: minmax(0, 1fr) var(--about-img-col);
            column-gap: 4rem;
        }

        .about-image {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: calc(var(--about-img-col) + max(5vw, (100% - 75rem) / 2));
            max-width: none;
            aspect-ratio: auto;
            justify-self: auto;
            border-radius: 0;
            /* Sisi kiri foto tertutup fade, jadi fokus ke papan nama + fasad:
               sedikit ke kanan, dan agak ke atas supaya papan tidak terpotong. */
            background-position: 60% 20%;
            /* Sisi kiri foto larut jadi transparan sehingga warna band
               (#0d4358) di belakangnya langsung tampil: foto, blur, dan
               background menyatu, tanpa garis/seam putih di tepi kiri.
               (Tepi kiri sengaja 100% transparan, jadi tidak ada piksel
               foto yang bisa "bocor" akibat pembulatan sub-piksel.) */
            -webkit-mask-image: linear-gradient(90deg,
                transparent 0%,
                rgba(0, 0, 0, 0.03) 7%,
                rgba(0, 0, 0, 0.10) 14%,
                rgba(0, 0, 0, 0.22) 21%,
                rgba(0, 0, 0, 0.35) 28%,
                rgba(0, 0, 0, 0.50) 35%,
                rgba(0, 0, 0, 0.65) 42%,
                rgba(0, 0, 0, 0.78) 49%,
                rgba(0, 0, 0, 0.90) 56%,
                rgba(0, 0, 0, 0.97) 63%,
                #000 70%);
            mask-image: linear-gradient(90deg,
                transparent 0%,
                rgba(0, 0, 0, 0.03) 7%,
                rgba(0, 0, 0, 0.10) 14%,
                rgba(0, 0, 0, 0.22) 21%,
                rgba(0, 0, 0, 0.35) 28%,
                rgba(0, 0, 0, 0.50) 35%,
                rgba(0, 0, 0, 0.65) 42%,
                rgba(0, 0, 0, 0.78) 49%,
                rgba(0, 0, 0, 0.90) 56%,
                rgba(0, 0, 0, 0.97) 63%,
                #000 70%);
        }

        /* Blur hanya di sisi kiri (sempit), memudar ke kanan lewat mask */
        .about-image::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            -webkit-mask-image: linear-gradient(90deg,
                #000 0%,
                rgba(0, 0, 0, 0.97) 3%,
                rgba(0, 0, 0, 0.90) 6%,
                rgba(0, 0, 0, 0.78) 10%,
                rgba(0, 0, 0, 0.65) 13%,
                rgba(0, 0, 0, 0.50) 16%,
                rgba(0, 0, 0, 0.35) 19%,
                rgba(0, 0, 0, 0.22) 22%,
                rgba(0, 0, 0, 0.10) 26%,
                rgba(0, 0, 0, 0.03) 29%,
                transparent 32%);
            mask-image: linear-gradient(90deg,
                #000 0%,
                rgba(0, 0, 0, 0.97) 3%,
                rgba(0, 0, 0, 0.90) 6%,
                rgba(0, 0, 0, 0.78) 10%,
                rgba(0, 0, 0, 0.65) 13%,
                rgba(0, 0, 0, 0.50) 16%,
                rgba(0, 0, 0, 0.35) 19%,
                rgba(0, 0, 0, 0.22) 22%,
                rgba(0, 0, 0, 0.10) 26%,
                rgba(0, 0, 0, 0.03) 29%,
                transparent 32%);
        }

        /* Fade ke warna section kini ditangani mask di .about-image, jadi
           overlay teal horizontal tidak diperlukan lagi (itulah yang dulu
           menimbulkan garis putih tipis di tepi kiri). Sisakan tint bawah. */
        .about-image::after {
            background:
                linear-gradient(180deg, rgba(13, 67, 88, 0) 60%, rgba(13, 67, 88, 0.45) 100%),
                rgba(13, 67, 88, 0.22);
        }
    }

    #tim-kami { scroll-margin-top: 90px; }

    /* ===== Tim Kami ===== */
    :root {
        --th-card-width: 240px;
    }

    .team-section {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .th-card-wrapper .section-heading {
        position: relative;
        z-index: 5;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
        padding: 0 12px;
    }

    .th-card-wrapper {
        position: relative;
        width: calc(100% + 10vw);
        max-width: none;
        margin-left: -5vw;
        margin-right: -5vw;
        background: transparent;
        padding: 56px 20px 20px;
        overflow: hidden;
        box-sizing: border-box;
    }

    .th-slider-container {
        position: relative;
        z-index: 5;
        perspective: 1500px;
        perspective-origin: 50% 50%;
        cursor: grab;
        width: 100%;
        max-width: none;
        margin: 0;
        overflow: hidden;
        touch-action: pan-y;
    }

    .th-slider-container.dragging {
        cursor: grabbing;
    }

    .th-slider-track {
        position: relative;
        width: 100%;
        transform-style: preserve-3d;
        will-change: transform;
    }

    .th-card {
        position: absolute;
        top: 50%;
        left: 50%;
        width: var(--th-card-width);
        background: transparent;
        overflow: hidden;
        transform-style: preserve-3d;
        cursor: pointer;
        will-change: transform, clip-path;
        border-radius: 6px;
        box-shadow: 
            0 18px 40px rgba(9, 67, 86, 0.14),
            0 6px 16px rgba(9, 67, 86, 0.06);
        display: flex;
        flex-direction: column;
    }

    .th-card-photo {
        position: relative;
        flex: 1 1 auto;
        min-height: 0;
        overflow: hidden;
        background: #eef3f3;
        border-radius: 6px;
    }

    .th-card-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        pointer-events: none;
        position: relative;
        z-index: 1;
    }

    /* Nama + jabatan menumpuk di atas foto (tanpa kotak putih terpisah),
       memakai gradien gelap di bawah supaya teks tetap terbaca. */
    .th-card-name {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 4;
        padding: 44px 14px 22px;
        text-align: left;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.55) 55%, transparent 100%);
        pointer-events: none;
    }

    .th-card-name h3 {
        margin: 0;
        color: #ffffff;
        font-family: 'Sora', sans-serif;
        font-size: clamp(14px, 2vw, 19px);
        line-height: 1.2;
        font-weight: 800;
        word-break: break-word;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.45);
        position: relative;
        z-index: 1;
    }

    .th-card-name p {
        margin: 4px 0 0;
        color: #f0f0f0;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(10px, 1.5vw, 12.5px);
        line-height: 1.3;
        font-weight: 500;
        word-break: break-word;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.45);
        position: relative;
        z-index: 1;
    }

    /* Saat kartu diperbesar, info sudah ditampilkan oleh .th-expand-info,
       jadi overlay kecil ini disembunyikan agar tidak dobel. */
    .th-card.clone .th-card-name {
        display: none;
    }

    @media (max-width: 768px) {
        .th-card-name { padding: 28px 8px 16px; }
        .th-card-name h3 { font-size: clamp(11px, 3vw, 14px); }
        .th-card-name p { font-size: clamp(9px, 2.4vw, 11px); }
    }

    .th-card::before,
    .th-card::after {
        display: none !important;
    }

    .th-card-photo .th-hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
        border-radius: 6px;
    }

    .th-card:hover .th-card-photo .th-hover-overlay {
        opacity: 1;
    }

    .th-card .th-hover-overlay span {
        display: none; /* jabatan sudah tampil di bagian bawah foto */
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(11px, 2.5vw, 15px);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
        padding: 0 8px;
    }

    .th-slider-track.blurred .th-card:not(.expanded) {
        filter: blur(8px);
        transition: filter 0.6s ease;
    }

    .th-card.expanded {
        z-index: 1000 !important;
    }

    .th-expand-close {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.92);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
    }

    .th-expand-close.visible {
        opacity: 1;
        pointer-events: all;
    }

    .th-expand-close:hover {
        background: #ff6b35;
        color: white;
        transform: rotate(90deg) scale(1.1);
    }

    .th-expand-close svg {
        width: 18px;
        height: 18px;
        stroke: #0a0a0a;
    }

    .th-expand-close:hover svg {
        stroke: white;
    }

    .th-expand-info {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 5;
        padding: 24px 20px 20px;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.55) 55%, transparent 100%);
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        pointer-events: none;
    }

    .th-expand-info.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .th-expand-info h2 {
        font-family: 'Sora', sans-serif;
        font-size: clamp(18px, 4vw, 26px);
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 6px;
    }

    .th-expand-info p {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12px, 2.5vw, 15px);
        color: #f0f0f0;
        line-height: 1.5;
    }

    /* Gallery Section */
    .gallery-section {
        position: relative;
        width: calc(100% + 10vw);
        max-width: none;
        margin: 0 -5vw;
        padding: 40px 5vw 80px;
        box-sizing: border-box;
        /* Latar putih polos; animasi partikel digambar oleh lapisan .gallery-particles di bawah. */
        background: #ffffff;
        isolation: isolate; /* lapisan partikel tidak "bocor" ke bagian lain halaman */
    }
    .gallery-section .section-heading p {
        color: #3f5359;
    }
    .gallery-inner {
        position: relative;
        z-index: 1; /* selalu di atas lapisan partikel */
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ===== Partikel cincin (CSS Houdini PaintWorklet, dari bg.html) =====
       Hanya aktif di browser yang mendukung paint() (Chrome/Edge/Brave/Opera).
       Di browser lain (Firefox/Safari) latar tetap putih polos, tanpa error. */
    .gallery-particles {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    @supports (background: paint(something)) {
        @property --animation-tick { syntax: '<number>'; inherits: false; initial-value: 0; }
        @property --ring-radius { syntax: '<number> | auto'; inherits: false; initial-value: auto; }
        @property --ring-x { syntax: '<number>'; inherits: false; initial-value: 50; }
        @property --ring-y { syntax: '<number>'; inherits: false; initial-value: 50; }

        @keyframes galleryRipple { 0% { --animation-tick: 0; } 100% { --animation-tick: 1; } }
        @keyframes galleryRing { 0% { --ring-radius: 150; } 100% { --ring-radius: 250; } }

        .gallery-particles {
            /* Posisi cincin dikunci di tengah galeri (50% / 50%), tidak mengikuti mouse atau scroll. */
            --ring-x: 50;
            --ring-y: 50;
            --ring-radius: 100;
            --ring-thickness: 600;
            --particle-count: 80;
            --particle-rows: 25;
            --particle-size: 2;
            --particle-color: navy;
            --particle-min-alpha: 0.1;
            --particle-max-alpha: 1.0;
            --seed: 200;

            background-image: paint(ring-particles);
            animation: galleryRipple 6s linear infinite, galleryRing 6s ease-in-out infinite alternate;
        }

        @media (prefers-reduced-motion: reduce) {
            .gallery-particles { animation: none; }
        }
    }
    /* ===== Galeri: filter + masonry ===== */
    .gallery-section .section-heading { margin-bottom: 28px; }

    /* Navbar filter: teks menu + garis bawah pada menu aktif */
    .gallery-filter {
        --gf-text: #094356;
        --gf-accent: #094356;
        display: flex;
        justify-content: center;
        margin: 0 auto 40px;
    }

    .gallery-filter-track {
        display: flex;
        gap: 2.5rem;
        max-width: 100%;
        padding: 4px 4px 0;
        overflow-x: auto;
        background: none;
        border: 0;
        border-radius: 0;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .gallery-filter-track::-webkit-scrollbar { display: none; }

    .gallery-filter-btn {
        position: relative;
        flex: 0 0 auto;
        padding: 8px 2px 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
        white-space: nowrap;
        color: var(--gf-text);
        background: none;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        cursor: pointer;
        transition: color 0.25s ease;
    }

    /* Garis bawah */
    .gallery-filter-btn::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--gf-accent);
        transform: scaleX(0);
        opacity: 1;
        transform-origin: center;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .gallery-filter-btn:hover::after {
        transform: scaleX(1);
        opacity: 0.35;
    }

    .gallery-filter-btn.is-active {
        color: var(--gf-accent);
        background: none;
        box-shadow: none;
    }

    .gallery-filter-btn.is-active::after {
        transform: scaleX(1);
        opacity: 1;
    }

    .gallery-filter-btn:focus-visible {
        outline: 2px solid var(--gf-accent);
        outline-offset: 2px;
        border-radius: 4px;
    }

    /* Grid masonry: tinggi tiap kartu dihitung JS dari rasio foto (potret / lanskap) */
    .gallery-grid {
        --g-gap: 12px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-auto-rows: 4px;
        column-gap: var(--g-gap);
        row-gap: 0;
    }

    @media (min-width: 640px) {
        .gallery-grid {
            --g-gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 1100px) {
        .gallery-grid {
            --g-gap: 18px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    .gallery-card {
        position: relative;
        align-self: start;
        min-width: 0;
        height: 240px; /* sementara, diatur ulang oleh JS */
        margin: 0;
        overflow: hidden;
        border-radius: 16px;
        background: #e6eef0;
        box-shadow: 0 6px 18px rgba(9, 67, 86, 0.08);
        cursor: pointer;
        transition: box-shadow 0.35s ease;
    }

    /* Skeleton shimmer selama foto belum termuat */
    .gallery-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, #e6eef0 30%, #f4f9fa 50%, #e6eef0 70%);
        background-size: 200% 100%;
        animation: galleryShimmer 1.4s linear infinite;
    }

    .gallery-card.is-loaded::before { display: none; }

    .gallery-card:hover { box-shadow: 0 16px 34px rgba(9, 67, 86, 0.2); }

    .gallery-card:focus-visible {
        outline: 3px solid #4d8b78;
        outline-offset: 3px;
    }

    .gallery-card .gallery-item {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .gallery-card:hover .gallery-item { transform: scale(1.06); }

    .gallery-overlay {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
        padding: 44px 16px 14px;
        background: linear-gradient(to top, rgba(6, 40, 52, 0.88) 0%, rgba(6, 40, 52, 0.5) 55%, transparent 100%);
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }

    .gallery-card:hover .gallery-overlay,
    .gallery-card:focus-visible .gallery-overlay {
        opacity: 1;
        transform: none;
    }

    .gallery-title {
        font-family: 'Sora', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
    }

    /* kategori: teks polos di bawah judul (tanpa card) */
    .gallery-cat {
        font-family: 'Poppins', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        line-height: 1.4;
        color: rgba(255, 255, 255, 0.85);
    }

    .gallery-zoom {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        color: #094356;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 50%;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: scale(0.85);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }

    .gallery-card:hover .gallery-zoom {
        opacity: 1;
        transform: none;
    }

    /* Layar sentuh (tanpa hover): caption selalu terlihat, ikon zoom disembunyikan */
    @media (hover: none) {
        .gallery-overlay { opacity: 1; transform: none; padding-top: 36px; }
        .gallery-zoom { display: none; }
    }

    .gallery-card.is-hidden { display: none !important; }

    .gallery-card.is-entering {
        animation: galleryCardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) backwards;
    }

    .gallery-empty {
        padding: 40px 0 10px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        color: #57676D;
    }

    @keyframes galleryShimmer {
        from { background-position: 200% 0; }
        to   { background-position: -200% 0; }
    }

    @keyframes galleryCardIn {
        from { opacity: 0; transform: translateY(16px) scale(0.97); }
        to   { opacity: 1; transform: none; }
    }

    @media (max-width: 480px) {
        .gallery-filter-track { gap: 1.5rem; }
        .gallery-filter-btn { padding: 8px 2px 12px; font-size: 0.85rem; }
        .gallery-card { border-radius: 12px; }
        .gallery-title { font-size: 0.85rem; }
        .gallery-cat { font-size: 0.72rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        .gallery-card,
        .gallery-card .gallery-item,
        .gallery-overlay,
        .gallery-zoom,
        .gallery-filter-btn,
        .gallery-filter-btn::after { transition: none; }
        .gallery-card::before,
        .gallery-card.is-entering { animation: none; }
    }

    /* ===== MOBILE RESPONSIVE TWEAKS ===== */
    @media (max-width: 768px) {
        .about-content {
            padding: 4rem 5vw 3.5rem;
        }
        .about-header h1 { font-size: 2.2rem; }
        .page-wrapper { padding-top: 70px; }

        .th-card-wrapper {
            width: calc(100% + 10vw);
            max-width: none;
            margin-left: -5vw;
            margin-right: -5vw;
            padding: 30px 15px 12px;
            border-radius: 0;
        }
        .th-card-wrapper .section-heading { margin-bottom: 18px; }

        /* Galeri lebih naik mendekati bagian tim */
        .gallery-section { padding: 28px 5vw 56px; }
        .gallery-section .section-heading { margin-bottom: 20px; }
        .gallery-filter { margin-bottom: 24px; }
    }

    /* ===== LIGHTBOX MODAL CSS ===== */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(11, 15, 25, 0.92);
        backdrop-filter: blur(6px);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .custom-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
    }

    /* Pembungkus mengikuti ukuran foto, jadi tombol bisa menempel di foto */
    .modal-content-wrapper {
        position: relative;
        display: block;
        animation: zoomIn 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .modal-photo {
        position: relative;
        overflow: hidden;
        line-height: 0;
        background: #0b0f19;
        border-radius: 14px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        display: block;
        width: auto;
        height: auto;
        max-width: calc(100vw - 170px); /* sisakan ruang untuk tombol kiri & kanan */
        max-height: 84vh;
        object-fit: contain;
    }

    /* Judul + kategori di bawah foto (gradien gelap, seperti kartu tim) */
    .modal-info {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 56px 22px 20px;
        text-align: left;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.55) 55%, transparent 100%);
        pointer-events: none;
    }

    .modal-info-title {
        margin: 0;
        font-family: 'Sora', sans-serif;
        font-size: clamp(18px, 4vw, 26px);
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
    }

    .modal-info-cat {
        margin: 0;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12px, 2.5vw, 15px);
        font-weight: 500;
        line-height: 1.5;
        color: #f0f0f0;
    }

    .modal-info[hidden],
    .modal-info-title[hidden],
    .modal-info-cat[hidden],
    .modal-nav-btn[hidden] { display: none; }

    /* Tombol silang: kanan atas foto, merah */
    .close-modal {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        padding: 0;
        color: #e53935;
        background: rgba(255, 255, 255, 0.92);
        border: 0;
        border-radius: 50%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }

    .close-modal svg { width: 18px; height: 18px; }

    .close-modal:hover {
        color: #ffffff;
        background: #e53935;
        transform: rotate(90deg) scale(1.08);
    }

    /* Tombol kiri/kanan: menempel di samping foto */
    .modal-nav-btn {
        position: absolute;
        top: 50%;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        padding: 0;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 50%;
        backdrop-filter: blur(4px);
        cursor: pointer;
        transform: translateY(-50%);
        transition: background-color 0.25s ease, transform 0.25s ease;
    }

    .modal-nav-btn svg { width: 22px; height: 22px; }

    .modal-nav-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.08);
    }

    .prev-btn { left: -60px; }
    .next-btn { right: -60px; }

    /* Mobile: foto hampir selebar layar, tombol pindah ke dalam foto (kiri & kanan) */
    @media (max-width: 768px) {
        .modal-content { max-width: calc(100vw - 24px); max-height: 78vh; }
        .modal-info { padding: 44px 16px 16px; }
        .close-modal { top: 10px; right: 10px; width: 36px; height: 36px; }
        .close-modal svg { width: 16px; height: 16px; }
        .modal-nav-btn {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.45);
            border-color: rgba(255, 255, 255, 0.25);
        }
        .modal-nav-btn svg { width: 18px; height: 18px; }
        .prev-btn { left: 8px; }
        .next-btn { right: 8px; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
    /* ===== Animasi Scroll (GSAP + ScrollTrigger) ===== */
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof gsap === 'undefined') return;
        gsap.registerPlugin(typeof ScrollTrigger !== 'undefined' ? ScrollTrigger : {});

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const hasST = typeof ScrollTrigger !== 'undefined';

        // Jika user minta motion minim, cukup pastikan semua elemen 'reveal' terlihat normal.
        if (prefersReduced || !hasST) {
            document.querySelectorAll('.reveal, .about-header .eyebrow, .about-header h1, .subtitle, .about-text p, .about-image, .about-social a, .section-heading h2, .section-heading p, .gallery-filter-btn, .gallery-card').forEach(el => {
                el.style.opacity = 1;
                el.style.transform = 'none';
            });
            return;
        }

        /* --- Helper: pecah judul jadi per-kata untuk efek reveal bertingkat --- */
        function splitWords(el) {
            if (!el || el.dataset.split === '1') return [];
            const text = el.textContent.trim();
            el.textContent = '';
            el.dataset.split = '1';
            const words = text.split(/\s+/).filter(Boolean);
            return words.map((word, i) => {
                const outer = document.createElement('span');
                outer.style.cssText = 'display:inline-block;overflow:hidden;vertical-align:top;padding-bottom:0.18em;margin-bottom:-0.18em;';
                const inner = document.createElement('span');
                inner.style.display = 'inline-block';
                inner.textContent = word + (i < words.length - 1 ? '\u00A0' : '');
                outer.appendChild(inner);
                el.appendChild(outer);
                return inner;
            });
        }

        // toggleActions: [onEnter] [onLeave] [onEnterBack] [onLeaveBack]
        // "restart reverse restart reverse" = tiap kali elemen masuk viewport (dari
        // scroll ke bawah ATAU ke atas), animasi diputar ulang dari awal; tiap kali
        // keluar viewport, animasi dibalik (fade/keluar lagi). Jadi animasi tidak
        // hanya jalan sekali di awal, tapi berulang terus mengikuti arah scroll.
        const TOGGLE = 'restart reverse restart reverse';

        /* ===== 1. HERO (ikut terpicu ulang saat scroll naik-turun) ===== */
        const heroEyebrow = document.querySelector('.about-header .eyebrow');
        const heroTitle = document.querySelector('.about-header h1');
        const heroSubtitle = document.querySelector('.about-header .subtitle');

        if (heroTitle) {
            const words = splitWords(heroTitle);
            gsap.timeline({
                scrollTrigger: {
                    trigger: '.about-header',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: TOGGLE
                }
            })
                .fromTo(heroEyebrow, { autoAlpha: 0, y: 22 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'power3.out' })
                .fromTo(words, { yPercent: 130, rotate: 7, transformOrigin: '0% 100%' }, { yPercent: 0, rotate: 0, duration: 1, ease: 'power4.out', stagger: 0.09 }, '-=0.3')
                .fromTo(heroSubtitle, { autoAlpha: 0, y: 22 }, { autoAlpha: 1, y: 0, duration: 0.7, ease: 'power3.out' }, '-=0.55');
        }

        /* ===== 2. ABOUT SECTION (teks, gambar, sosial media) ===== */
        const aboutSection = document.querySelector('.about-section');
        if (aboutSection) {
            const paras = aboutSection.querySelectorAll('.about-text p');
            const aboutImg = aboutSection.querySelector('.about-image');
            const socialLinks = aboutSection.querySelectorAll('.about-social a');

            const aboutTl = gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 78%',
                    end: 'bottom 20%',
                    toggleActions: TOGGLE
                }
            });
            aboutTl.fromTo(paras, { autoAlpha: 0, y: 45 }, { autoAlpha: 1, y: 0, duration: 0.75, stagger: 0.18 });
            if (aboutImg) aboutTl.fromTo(aboutImg, { autoAlpha: 0, scale: 1.18, clipPath: 'inset(8%)' }, { autoAlpha: 1, scale: 1, clipPath: 'inset(0%)', duration: 1.1, ease: 'power4.out' }, '-=0.5');
            aboutTl.fromTo(socialLinks, { autoAlpha: 0, y: 18, scale: 0.5 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.5, stagger: 0.08, ease: 'back.out(2.2)' }, '-=0.4');
        }

        /* ===== 3. TIM KAMI (heading + kartu tim) ===== */
        const teamSection = document.querySelector('.team-section');
        if (teamSection) {
            const teamHeading = teamSection.querySelectorAll('.section-heading h2, .section-heading p');
            const teamSlider = teamSection.querySelector('.th-slider-container');

            // PENTING: jangan menganimasikan .th-card satu per satu di sini.
            // Posisi/rotasi 3D tiap kartu sudah diatur penuh oleh slider (TeamHtmlSlider);
            // kalau ScrollTrigger ikut menggeser y/scale/opacity kartu yang sama, keduanya
            // saling menimpa dan kartu bisa "turun sendiri" / nyangkut di posisi salah.
            // Jadi cukup animasikan pembungkus slider-nya saja.
            gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: { trigger: teamSection, start: 'top 80%', end: 'bottom 20%', toggleActions: TOGGLE }
            })
                .fromTo(teamHeading, { autoAlpha: 0, y: 30 }, { autoAlpha: 1, y: 0, duration: 0.7, stagger: 0.12 })
                .fromTo(teamSlider, { autoAlpha: 0, y: 40 }, { autoAlpha: 1, y: 0, duration: 0.8 }, '-=0.35');
        }

        /* ===== 4. GALERI KEGIATAN (heading, filter, kartu galeri) ===== */
        const gallerySection = document.querySelector('.gallery-section');
        if (gallerySection) {
            const galHeading = gallerySection.querySelectorAll('.section-heading h2, .section-heading p');
            const filterBtns = gallerySection.querySelectorAll('.gallery-filter-btn');
            const galCards = gallerySection.querySelectorAll('.gallery-card');

            gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: { trigger: gallerySection, start: 'top 82%', end: 'bottom 20%', toggleActions: TOGGLE }
            })
                .fromTo(galHeading, { autoAlpha: 0, y: 30 }, { autoAlpha: 1, y: 0, duration: 0.7, stagger: 0.12 })
                .fromTo(filterBtns, { autoAlpha: 0, y: 16 }, { autoAlpha: 1, y: 0, duration: 0.5, stagger: 0.05 }, '-=0.35');

            gsap.set(galCards, { autoAlpha: 0, y: 42, scale: 0.92 });
            ScrollTrigger.batch(galCards, {
                start: 'top 92%',
                end: 'bottom 8%',
                onEnter: (batch) => gsap.to(batch, { autoAlpha: 1, y: 0, scale: 1, duration: 0.65, stagger: 0.08, ease: 'power3.out', overwrite: true }),
                onEnterBack: (batch) => gsap.to(batch, { autoAlpha: 1, y: 0, scale: 1, duration: 0.65, stagger: 0.08, ease: 'power3.out', overwrite: true }),
                onLeave: (batch) => gsap.to(batch, { autoAlpha: 0, y: -35, scale: 0.94, duration: 0.4, stagger: 0.04, ease: 'power2.in', overwrite: true }),
                onLeaveBack: (batch) => gsap.to(batch, { autoAlpha: 0, y: 35, scale: 0.94, duration: 0.4, stagger: 0.04, ease: 'power2.in', overwrite: true })
            });
        }

        // Refresh setelah semua gambar termuat agar posisi trigger akurat
        window.addEventListener('load', () => ScrollTrigger.refresh());
        setTimeout(() => ScrollTrigger.refresh(), 800);
    });

    /* ===== Particle Technology Background ===== */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){if(this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.background))this.l(this.k,{background:this.options.background});else{if(!/\.(gif|jpg|jpeg|tiff|png)$/i.test(this.options.background))return console.error("Please specify a valid background image or hexadecimal color"),!1;this.l(this.k,{background:'url("'+this.options.background+'") no-repeat center',"background-size":"cover"})}if(!/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.particleColor))return console.error("Please specify a valid particleColor hexadecimal color"),!1;this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.i,{position:"relative"}),this.l(this.canvas,{"z-index":"20",position:"relative"}),window.addEventListener("resize",function(){return this.i.offsetWidth===this.i.size.width&&this.i.offsetHeight===this.i.size.height?!1:(this.canvas.width=this.i.size.width=this.i.offsetWidth,this.canvas.height=this.i.size.height=this.i.offsetHeight,clearTimeout(this.m),void(this.m=setTimeout(function(){this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&this.o.push(this.p),requestAnimationFrame(this.update.bind(this))}.bind(this),500)))}.bind(this)),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&(this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p),this.canvas.addEventListener("mousemove",function(a){this.p.x=a.clientX-this.canvas.offsetLeft,this.p.y=a.clientY-this.canvas.offsetTop}.bind(this)),this.canvas.addEventListener("mouseup",function(a){this.p.velocity={x:(Math.random()-.5)*this.options.velocity,y:(Math.random()-.5)*this.options.velocity},this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p)}.bind(this))),requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height),this.g.globalAlpha=1;for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}0!==this.options.velocity&&requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:"none"===a?0:.66},b.prototype.j=function(a){return"high"===a?5e3:"low"===a?2e4:isNaN(parseInt(a,10))?1e4:a},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    document.addEventListener('DOMContentLoaded', function() {
        const canvasDiv = document.getElementById('particle-canvas');

        if (canvasDiv) {
            const options = {
                particleColor: '#a8c4bd',
                background: '#f7faf9',
                interactive: true,
                speed: 'medium',
                density: 'high'
            };

            new ParticleNetwork(canvasDiv, options);
        }
    });

    /* ===== Tim Kami — Slider 3D ===== */
    (function () {
        const BASE_POSITIONS = [
            { height: 620, z: 220, rotateY: 48, y: 0, clip: 'polygon(0px 0px, 100% 10%, 100% 90%, 0px 100%)' },
            { height: 580, z: 165, rotateY: 35, y: 0, clip: 'polygon(0px 0px, 100% 8%, 100% 92%, 0px 100%)' },
            { height: 495, z: 110, rotateY: 15, y: 0, clip: 'polygon(0px 0px, 100% 7%, 100% 93%, 0px 100%)' },
            { height: 420, z: 66, rotateY: 15, y: 0, clip: 'polygon(0px 0px, 100% 7%, 100% 93%, 0px 100%)' },
            { height: 353, z: 46, rotateY: 6, y: 0, clip: 'polygon(0px 0px, 100% 7%, 100% 93%, 0px 100%)' },
            { height: 310, z: 0, rotateY: 0, y: 0, clip: 'polygon(0 0, 100% 0, 100% 100%, 0 100%)' },
            { height: 353, z: 54, rotateY: 348, y: 0, clip: 'polygon(0px 7%, 100% 0px, 100% 100%, 0px 93%)' },
            { height: 420, z: 89, rotateY: -15, y: 0, clip: 'polygon(0px 7%, 100% 0px, 100% 100%, 0px 93%)' },
            { height: 495, z: 135, rotateY: -15, y: 1, clip: 'polygon(0px 7%, 100% 0px, 100% 100%, 0px 93%)' },
            { height: 580, z: 195, rotateY: 325, y: 0, clip: 'polygon(0px 8%, 100% 0px, 100% 100%, 0px 92%)' },
            { height: 620, z: 240, rotateY: 312, y: 0, clip: 'polygon(0px 10%, 100% 0px, 100% 100%, 0px 90%)' }
        ];

        const BASE_CARD_WIDTH = 240;
        const BASE_GAP = 8;
        const BASE_PERSPECTIVE = 1500;
        const CENTER_SLOT = Math.floor(BASE_POSITIONS.length / 2);
        const MAX_BASE_HEIGHT = Math.max(...BASE_POSITIONS.map((p) => p.height));

        function thComputeScale(width) {
            const MAX_W = 1200, MIN_W = 320;
            const MAX_S = 1, MIN_S = 0.42;
            if (width >= MAX_W) return MAX_S;
            if (width <= MIN_W) return MIN_S;
            const t = (width - MIN_W) / (MAX_W - MIN_W);
            return MIN_S + t * (MAX_S - MIN_S);
        }

        function thClamp(val, min, max) {
            return Math.max(min, Math.min(max, val));
        }

        class TeamHtmlSlider {
            constructor() {
                this.container = document.getElementById('thSliderContainer');
                this.track = document.getElementById('thSliderTrack');
                if (!this.container || !this.track) return;

                this.cards = Array.from(document.querySelectorAll('.th-card'));
                this.totalCards = this.cards.length;

                this.isDragging = false;
                this.isAnimating = false;
                this.startX = 0;
                this.dragDistance = 0;
                this.threshold = 50;
                this.expandedCard = null;
                this.offset = 0;

                this.sectionEl = this.container.closest('.team-section');

                this.scale = thComputeScale(window.innerWidth);
                this.positions = this.getScaledPositions(this.scale);

                this.trackXTo = gsap.quickTo(this.track, 'x', { duration: 0.4, ease: 'power3.out' });

                this.init();
            }

            getScaledPositions(scale) {
                const cardW = BASE_CARD_WIDTH * scale;
                const gap = BASE_GAP * scale;
                const step = cardW + gap;

                return BASE_POSITIONS.map((p, slot) => ({
                    height: p.height * scale,
                    z: p.z * scale,
                    rotateY: p.rotateY,
                    y: p.y * scale,
                    clip: p.clip,
                    x: (slot - CENTER_SLOT) * step
                }));
            }

            computeRel(i, offsetVal) {
                const half = Math.floor(this.totalCards / 2);
                let rel = ((i - offsetVal) % this.totalCards + this.totalCards) % this.totalCards;
                if (rel > half) rel -= this.totalCards;
                return rel;
            }

            computeSlot(i, offsetVal) {
                const rel = this.computeRel(i, offsetVal);
                const slot = CENTER_SLOT + rel;
                return Math.max(0, Math.min(BASE_POSITIONS.length - 1, slot));
            }

            getSlot(i) {
                return this.computeSlot(i, this.offset);
            }

            buildTransform(pos) {
                return `translate(-50%, -50%) translateX(${pos.x}px) translateZ(${pos.z}px) rotateY(${pos.rotateY}deg) translateY(${pos.y}px)`;
            }

            init() {
                this.applyResponsiveSizing();
                this.applyPositions();
                this.attachEvents();
            }

            applyResponsiveSizing() {
                const perspective = Math.max(600, BASE_PERSPECTIVE * this.scale);
                document.documentElement.style.setProperty('--th-card-width', `${BASE_CARD_WIDTH * this.scale}px`);
                this.container.style.perspective = `${perspective}px`;
                this.track.style.height = `${this.computeTrackHeight(perspective)}px`;
            }

            // Desktop: tinggi penuh (tidak berubah).
            // Mobile: layar sempit hanya menampilkan ~3-5 kartu tengah, sedangkan kartu
            // terjangkung (620px x skala) ada di luar layar. Tinggi track dipangkas sesuai
            // kartu yang benar-benar terlihat supaya tidak ada ruang kosong di bawah tim,
            // sehingga bagian galeri naik mendekat.
            computeTrackHeight(perspective) {
                const full = MAX_BASE_HEIGHT * this.scale;
                if (window.innerWidth > 768) return full;

                const halfView = (this.container.clientWidth || window.innerWidth) / 2;
                const cardHalf = (BASE_CARD_WIDTH * this.scale) / 2;
                const usedSlots = new Set(this.cards.map((_, i) => this.computeSlot(i, 0)));

                let tallest = 0;
                usedSlots.forEach((slot) => {
                    const p = this.positions[slot];
                    if (Math.abs(p.x) - cardHalf >= halfView) return; // di luar layar
                    const depthScale = perspective / Math.max(1, perspective - p.z); // kartu yang maju tampak lebih besar
                    tallest = Math.max(tallest, p.height * depthScale);
                });

                if (!tallest) return full;
                const breathing = 44; // ruang untuk bayangan kartu (container overflow: hidden)
                return Math.min(full, Math.ceil(tallest + breathing));
            }

            applyPositions(animate = false) {
                this.cards.forEach((card, index) => {
                    const pos = this.positions[this.getSlot(index)];
                    const transform = this.buildTransform(pos);

                    if (animate) {
                        gsap.to(card, { height: pos.height, clipPath: pos.clip, transform, duration: 0.5, ease: 'power2.out', overwrite: 'auto' });
                    } else {
                        gsap.set(card, { height: pos.height, clipPath: pos.clip, transform });
                    }
                });
            }

            handleResize() {
                const newScale = thComputeScale(window.innerWidth);
                if (Math.abs(newScale - this.scale) < 0.001) return;

                this.scale = newScale;
                this.positions = this.getScaledPositions(this.scale);
                this.applyResponsiveSizing();

                if (!this.expandedCard) {
                    this.applyPositions(false);
                }
            }

            expandCard(card) {
                if (this.expandedCard || this.isAnimating) return;

                this.expandedCard = card;
                const title = card.dataset.title;
                const desc = card.dataset.desc;

                const sectionRect = this.sectionEl.getBoundingClientRect();
                const rect = card.getBoundingClientRect();
                const clone = card.cloneNode(true);
                const overlay = clone.querySelector('.th-hover-overlay');
                if (overlay) overlay.remove();

                clone.style.position = 'absolute';
                // Clone menyalin inline transform kartu asli (translate -50%, translateX, rotateY, dst).
                // Karena posisinya sudah dihitung lewat left/top, transform itu harus dibuang;
                // kalau tidak, clone muncul melenceng dulu lalu "melompat" ke tengah.
                clone.style.transform = 'none';
                clone.style.opacity = '1';
                clone.style.visibility = 'visible';
                clone.style.left = (rect.left - sectionRect.left) + 'px';
                clone.style.top = (rect.top - sectionRect.top) + 'px';
                clone.style.width = rect.width + 'px';
                clone.style.height = rect.height + 'px';
                clone.style.margin = '0';
                clone.style.zIndex = '1000';
                clone.classList.add('clone');

                const closeBtnEl = document.createElement('button');
                closeBtnEl.className = 'th-expand-close';
                closeBtnEl.setAttribute('aria-label', 'Tutup');
                closeBtnEl.innerHTML = '<svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" /></svg>';
                closeBtnEl.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.closeCard();
                });
                clone.appendChild(closeBtnEl);

                const infoEl = document.createElement('div');
                infoEl.className = 'th-expand-info';
                infoEl.innerHTML = `<h2>${title}</h2><p>${desc}</p>`;
                clone.appendChild(infoEl);

                this.sectionEl.appendChild(clone);
                this.cardClone = clone;
                this.closeBtnEl = closeBtnEl;
                this.infoEl = infoEl;

                gsap.set(card, { opacity: 0 });
                this.track.classList.add('blurred');

                const finalWidth = Math.min(500, sectionRect.width * 0.85);
                const finalHeight = Math.min(600, sectionRect.height * 0.85);
                const centerX = sectionRect.width / 2;
                const centerY = sectionRect.height / 2;

                gsap.to(clone, {
                    width: finalWidth,
                    height: finalHeight,
                    left: centerX - finalWidth / 2,
                    top: centerY - finalHeight / 2,
                    clipPath: 'polygon(0 0, 100% 0, 100% 100%, 0 100%)',
                    duration: 0.8,
                    ease: 'power2.out',
                    onComplete: () => {
                        closeBtnEl.classList.add('visible');
                        infoEl.classList.add('visible');
                    }
                });
            }

            closeCard() {
                if (!this.expandedCard) return;

                const card = this.expandedCard;
                const clone = this.cardClone;
                const closeBtnEl = this.closeBtnEl;
                const infoEl = this.infoEl;

                if (closeBtnEl) closeBtnEl.classList.remove('visible');
                if (infoEl) infoEl.classList.remove('visible');

                const sectionRect = this.sectionEl.getBoundingClientRect();
                const rect = card.getBoundingClientRect();
                const index = this.cards.indexOf(card);
                const pos = this.positions[this.getSlot(index)];

                gsap.to(clone, {
                    width: rect.width,
                    height: rect.height,
                    left: (rect.left - sectionRect.left),
                    top: (rect.top - sectionRect.top),
                    clipPath: pos.clip,
                    duration: 0.8,
                    ease: 'power2.out',
                    onComplete: () => {
                        clone.remove();
                        gsap.set(card, { opacity: 1 });
                        this.track.classList.remove('blurred');
                        this.expandedCard = null;
                        this.cardClone = null;
                        this.closeBtnEl = null;
                        this.infoEl = null;
                    }
                });
            }

            checkScrollClose() {
                if (!this.expandedCard) return;
                const rect = this.sectionEl.getBoundingClientRect();
                if (rect.bottom < 0 || rect.top > window.innerHeight) {
                    this.closeCard();
                }
            }

            rotate(direction) {
                if (this.expandedCard || this.isAnimating) return;

                this.isAnimating = true;
                const oldOffset = this.offset;
                this.offset = (this.offset + (direction === 'next' ? 1 : -1) + this.totalCards) % this.totalCards;

                this.cards.forEach((card, index) => {
                    const oldRel = this.computeRel(index, oldOffset);
                    const newRel = this.computeRel(index, this.offset);
                    const pos = this.positions[this.getSlot(index)];

                    const isWrap = Math.abs(newRel - oldRel) > 1;

                    if (isWrap) {
                        gsap.to(card, {
                            opacity: 0,
                            duration: 0.18,
                            ease: 'power1.out',
                            overwrite: 'auto',
                            onComplete: () => {
                                gsap.set(card, { height: pos.height, clipPath: pos.clip, transform: this.buildTransform(pos) });
                                gsap.to(card, {
                                    opacity: 1,
                                    duration: 0.27,
                                    ease: 'power1.in',
                                    onComplete: () => {
                                        if (index === this.cards.length - 1) this.isAnimating = false;
                                    }
                                });
                            }
                        });
                    } else {
                        gsap.set(card, { clipPath: pos.clip });
                        gsap.to(card, {
                            height: pos.height,
                            transform: this.buildTransform(pos),
                            opacity: 1,
                            duration: 0.45,
                            ease: 'power2.out',
                            overwrite: 'auto',
                            onComplete: () => {
                                if (index === this.cards.length - 1) this.isAnimating = false;
                            }
                        });
                    }
                });

                this.trackXTo(0);
            }

            attachEvents() {
                this.cards.forEach((card) => {
                    card.addEventListener('click', () => {
                        if (!this.isDragging && !this.expandedCard) {
                            this.expandCard(card);
                        }
                    });
                });

                this.container.addEventListener('mousedown', (e) => this.handleDragStart(e));
                this.container.addEventListener('touchstart', (e) => this.handleDragStart(e), { passive: false });

                document.addEventListener('mousemove', (e) => this.handleDragMove(e));
                document.addEventListener('touchmove', (e) => this.handleDragMove(e), { passive: false });

                document.addEventListener('mouseup', () => this.handleDragEnd());
                document.addEventListener('touchend', () => this.handleDragEnd());

                this.container.addEventListener('wheel', (e) => {
                    if (this.expandedCard || this.isAnimating) return;
                    e.preventDefault();
                    const direction = e.deltaY > 0 || e.deltaX > 0 ? 'next' : 'prev';
                    this.rotate(direction);
                }, { passive: false });

                document.addEventListener('keydown', (e) => {
                    if (document.getElementById('imageModal').classList.contains('show')) return;

                    if (e.key === 'Escape' && this.expandedCard) {
                        this.closeCard();
                    } else if (e.key === 'ArrowLeft' && !this.expandedCard) {
                        this.rotate('prev');
                    } else if (e.key === 'ArrowRight' && !this.expandedCard) {
                        this.rotate('next');
                    }
                });

                window.addEventListener('scroll', () => this.checkScrollClose(), { passive: true });

                let resizeTimer;
                const onResize = () => {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(() => this.handleResize(), 120);
                };
                window.addEventListener('resize', onResize);
                window.addEventListener('orientationchange', onResize);
            }

            handleDragStart(e) {
                if (this.expandedCard) return;
                this.isDragging = true;
                this.container.classList.add('dragging');
                const isMouse = e.type.includes('mouse');
                this.startX = isMouse ? e.clientX : e.touches[0].clientX;
                this.startY = isMouse ? e.clientY : e.touches[0].clientY;
                this.gesture = isMouse ? 'h' : null; // arah geser: 'h' (slider) / 'v' (scroll halaman)
                this.dragDistance = 0;
            }

            handleDragMove(e) {
                if (!this.isDragging) return;

                const isMouse = e.type.includes('mouse');
                const currentX = isMouse ? e.clientX : e.touches[0].clientX;

                // Layar sentuh: kalau jari bergerak dominan ke atas/bawah, biarkan halaman scroll
                // normal (dulu selalu di-preventDefault sehingga halaman "macet" saat jari di slider).
                if (!isMouse) {
                    if (this.gesture === null) {
                        const dx = Math.abs(currentX - this.startX);
                        const dy = Math.abs(e.touches[0].clientY - this.startY);
                        if (dx < 8 && dy < 8) return; // belum jelas arahnya
                        this.gesture = dx > dy ? 'h' : 'v';
                    }
                    if (this.gesture === 'v') {
                        this.isDragging = false;
                        this.container.classList.remove('dragging');
                        this.trackXTo(0);
                        return;
                    }
                }

                e.preventDefault();
                this.dragDistance = currentX - this.startX;

                const liveOffset = thClamp(this.dragDistance, -this.threshold, this.threshold) * 0.5;
                this.trackXTo(liveOffset);

                if (Math.abs(this.dragDistance) > this.threshold) {
                    const direction = this.dragDistance > 0 ? 'prev' : 'next';
                    if (!this.isAnimating) {
                        this.rotate(direction);
                        this.startX = currentX;
                        this.dragDistance = 0;
                    }
                }
            }

            handleDragEnd() {
                if (!this.isDragging) return;
                this.isDragging = false;
                this.container.classList.remove('dragging');
                this.trackXTo(0);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            new TeamHtmlSlider();
        });
    })();

    /* ===== Galeri: filter + masonry ===== */
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('galleryGrid');
        if (!grid) return;

        const cards = Array.from(grid.querySelectorAll('.gallery-card'));
        const buttons = Array.from(document.querySelectorAll('.gallery-filter-btn'));
        const emptyEl = document.getElementById('galleryEmpty');
        let active = { type: 'all', value: 'all' };
        let rafId = null;

        // Hitung tinggi tiap kartu dari rasio foto (potret tinggi, lanskap pendek)
        function layout() {
            const cs = getComputedStyle(grid);
            const rowH = parseFloat(cs.gridAutoRows) || 4;
            const gap = parseFloat(cs.columnGap) || 0;

            cards.forEach((card) => {
                if (card.classList.contains('is-hidden')) return;
                const w = card.offsetWidth;
                if (!w) return;
                const ratio = parseFloat(card.dataset.ratio) || 0.75;
                const span = Math.max(1, Math.round((w * ratio + gap) / rowH));
                card.style.gridRowEnd = 'span ' + span;
                card.style.height = (span * rowH - gap) + 'px';
            });
        }

        function scheduleLayout() {
            if (rafId) cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(function () {
                rafId = null;
                layout();
            });
        }

        function matches(card) {
            if (active.type === 'category') return card.dataset.category === active.value;
            if (active.type === 'orientation') return card.dataset.orientation === active.value;
            return true;
        }

        function applyFilter(animate) {
            let shown = 0;

            cards.forEach((card) => {
                const ok = matches(card);
                card.classList.toggle('is-hidden', !ok);
                card.classList.remove('is-entering');

                if (ok) {
                    if (animate) {
                        void card.offsetWidth; // restart animasi
                        card.style.animationDelay = Math.min(shown, 12) * 35 + 'ms';
                        card.classList.add('is-entering');
                    }
                    shown++;
                }
            });

            if (emptyEl) emptyEl.hidden = shown !== 0;
            layout();
        }

        // Rasio & orientasi foto diambil setelah foto termuat
        function onImageReady(card, img) {
            if (img.naturalWidth && img.naturalHeight) {
                const raw = img.naturalHeight / img.naturalWidth;
                // dibatasi supaya foto ekstrem (panorama / sangat tinggi) tetap proporsional
                card.dataset.ratio = Math.min(1.6, Math.max(0.55, raw)).toFixed(4);
                card.dataset.orientation = raw > 1.05 ? 'portrait' : 'landscape';
            }
            card.classList.add('is-loaded');

            if (active.type === 'orientation') applyFilter(false);
            else scheduleLayout();
        }

        cards.forEach((card) => {
            const img = card.querySelector('.gallery-item');
            if (!img) return;

            if (img.complete && img.naturalWidth) {
                onImageReady(card, img);
            } else {
                img.addEventListener('load', () => onImageReady(card, img), { once: true });
                img.addEventListener('error', () => {
                    card.classList.add('is-loaded');
                    scheduleLayout();
                }, { once: true });
            }
        });

        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                active = { type: btn.dataset.type, value: btn.dataset.filter };

                buttons.forEach((b) => {
                    const on = b === btn;
                    b.classList.toggle('is-active', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });

                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
                applyFilter(true);
            });
        });

        window.addEventListener('resize', scheduleLayout);
        window.addEventListener('load', scheduleLayout);

        applyFilter(false);
    });

    /* ===== LIGHTBOX MODAL JS (Dengan Fitur Slide) ===== */
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("zoomedImage");
        const modalInfo = document.getElementById("modalInfo");
        const modalTitle = document.getElementById("modalTitle");
        const modalCat = document.getElementById("modalCategory");
        const closeBtn = document.querySelector(".close-modal");
        const prevBtn = document.getElementById("modalPrev");
        const nextBtn = document.getElementById("modalNext");
        
        // Daftar foto = hanya kartu yang sedang tampil (mengikuti filter aktif)
        function getImages() {
            return Array.from(document.querySelectorAll(".gallery-card"))
                .filter((card) => !card.classList.contains("is-hidden"))
                .map((card) => card.querySelector(".gallery-item"))
                .filter(Boolean);
        }

        let images = [];
        let currentIndex = 0;

        // Buka gambar sesuai index
        function openModal(index) {
            currentIndex = index;
            updateModalContent();
            modal.classList.add("show");
        }

        // Update gambar & caption pas digeser
        function updateModalContent() {
            const img = images[currentIndex];
            if (!img) return;
            modalImg.src = img.currentSrc || img.src;
            modalImg.alt = img.alt || "";

            // Judul (tebal) + kategori (polos di bawahnya)
            const title = (img.getAttribute("data-caption") || "").trim();
            const cat = (img.getAttribute("data-category-label") || "").trim();
            modalTitle.textContent = title;
            modalTitle.hidden = !title;
            modalCat.textContent = cat;
            modalCat.hidden = !cat;
            modalInfo.hidden = !title && !cat;

            // Tombol kiri/kanan disembunyikan kalau hanya ada 1 foto
            const single = images.length < 2;
            if (prevBtn) prevBtn.hidden = single;
            if (nextBtn) nextBtn.hidden = single;
        }

        // Fungsi Tombol Prev & Next
        function showPrev(e) {
            if (e) e.stopPropagation();
            if (!images.length) return;
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateModalContent();
        }

        function showNext(e) {
            if (e) e.stopPropagation();
            if (!images.length) return;
            currentIndex = (currentIndex + 1) % images.length;
            updateModalContent();
        }

        // Klik / Enter pada kartu galeri (delegasi event)
        const galleryGrid = document.getElementById("galleryGrid");
        if (galleryGrid) {
            const openFromCard = (card) => {
                images = getImages();
                const idx = images.indexOf(card.querySelector(".gallery-item"));
                if (idx > -1) openModal(idx);
            };

            galleryGrid.addEventListener("click", (e) => {
                const card = e.target.closest(".gallery-card");
                if (card) openFromCard(card);
            });

            galleryGrid.addEventListener("keydown", (e) => {
                if (e.key !== "Enter" && e.key !== " ") return;
                const card = e.target.closest(".gallery-card");
                if (!card) return;
                e.preventDefault();
                openFromCard(card);
            });
        }

        // Event Tombol Navigasi Modal
        if (prevBtn) prevBtn.addEventListener("click", showPrev);
        if (nextBtn) nextBtn.addEventListener("click", showNext);
        if (closeBtn) closeBtn.addEventListener("click", () => modal.classList.remove("show"));

        // Tutup Modal kalau background luar di-klik
        if (modal) {
            modal.addEventListener("click", function(e) {
                if (e.target === modal || e.target.classList.contains('modal-content-wrapper')) {
                    modal.classList.remove("show");
                }
            });
        }

        // Kontrol Keyboard (Kiri-Kanan) khusus Lightbox (PERBAIKAN TYPO DI SINI)
        document.addEventListener('keydown', function(e) {
            if (!modal.classList.contains('show')) return;
            
            if (e.key === 'Escape') modal.classList.remove("show");
            if (e.key === 'ArrowLeft') showPrev();
            if (e.key === 'ArrowRight') showNext();
        });
    });
</script>

<script>
    /* ===== Partikel cincin di latar galeri (CSS Houdini PaintWorklet, dari bg.html) =====
       Posisi cincin dikunci di tengah lewat CSS (.gallery-particles), jadi di sini cukup
       mendaftarkan worklet-nya. Browser tanpa dukungan paint() (mis. Firefox/Safari)
       melewati blok ini; latar tetap putih polos. */
    (function () {
        if (!('paintWorklet' in CSS)) return;

        CSS.paintWorklet
            .addModule('https://unpkg.com/css-houdini-ringparticles/dist/ringparticles.js')
            .catch(function () { /* worklet gagal dimuat: biarkan latar putih polos */ });
    })();
</script>
@endpush
@endsection