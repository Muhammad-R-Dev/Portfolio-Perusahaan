@extends('layouts.app')

@section('title', 'Contact Us - PT Astabrata Teknologi')

@section('content')
<div class="contact-page">

    <!-- Header: breadcrumb + judul (pita abu-abu, full lebar layar) -->
    @php $heroImage = file_exists(public_path('images/contact-hero.jpg')); @endphp
    <header class="contact-hero {{ $heroImage ? 'has-image' : '' }}"
            @if($heroImage) style="--hero-image: url('{{ asset('images/contact-hero.jpg') }}')" @endif>
        @unless($heroImage)
        <div class="hero-particles" aria-hidden="true">
            <div id="particle-canvas"></div>
        </div>
        @endunless
        <br>
        <div class="contact-inner">
            <h1>Hubungi Kami</h1>
            <p class="hero-sub">Ceritakan kebutuhan Anda, tim kami akan membalas langsung lewat WhatsApp.</p>
        </div>
    </header>

    <!-- Satu card gabungan (full lebar, kiri sampai kanan): form amplop di kiri, info + lokasi di kanan -->
    <section class="contact-card">
        <div class="contact-inner contact-grid">

            <!-- Kiri: form amplop kirim pesan -->
            <div class="contact-form-wrap">
                <h2>Kirim Pesan</h2>
                <p class="lead">Silakan isi formulir di bawah dengan data Anda,<br>lalu tulis pesan yang ingin disampaikan kepada kami.</p>

                <div class="envelope-wrapper">
                    <div class="envelope" id="contactEnvelope">
                        <div class="back paper"></div>
                        <div class="content">
                            <form action="#" method="POST" class="contact-form" id="contactForm">
                                @csrf
                                <div class="top-wrapper">
                                    <div class="input">
                                        <label for="name">Nama lengkap</label>
                                        <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda" autocomplete="name" required>
                                    </div>
                                    <div class="input">
                                        <label for="address">Alamat</label>
                                        <input type="text" id="address" name="address" placeholder="Masukkan alamat Anda" autocomplete="street-address" required>
                                    </div>
                                </div>
                                <div class="bottom-wrapper">
                                    <div class="input">
                                        <label for="message">Pesan Anda</label>
                                        <textarea id="message" name="message" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                    </div>
                                    <div class="submit">
                                        <button type="submit" class="submit-card">Kirim Pesan <i class="fa-solid fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="front paper"></div>
                    </div>
                </div>
            </div>

            <!-- Kanan: info kontak, alamat, dan peta -->
            <div class="contact-info">
                <h2>Informasi lebih lanjut</h2>
                <p class="lead">Punya proyek yang ingin diwujudkan atau ingin berkonsultasi soal strategi digital? Tim kami siap membantu.</p>

                <div class="map">
                    <iframe
                        title="Lokasi PT Astabrata Teknologi"
                        src="https://www.google.com/maps?q=-7.4661805,110.2534664&output=embed"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <ul class="info-list">
                    <li>
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <div>
                            <strong>Telepon</strong>
                            <a href="tel:+6287762166795">+62 877-6216-6795</a>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fa-solid fa-envelope"></i></span>
                        <div>
                            <strong>Email</strong>
                            <a href="mailto:hello@astabrata.tech">hello@astabrata.tech</a>
                        </div>
                    </li>
                    <li>
                        <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                        <div>
                            <strong>Alamat</strong>
                            <span>Jl. Teknologi No. 88, Kawasan Digital Raya,<br>Jakarta Selatan, Indonesia 12345</span>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Popup notifikasi setelah pesan dikirim -->
    <div class="success-popup-overlay" id="successPopupOverlay" role="dialog" aria-modal="true" aria-labelledby="successPopupTitle">
        <div class="success-popup-box">
            <div class="success-icon"><i class="fa-solid fa-check"></i></div>
            <h3 id="successPopupTitle">Terhubung ke WhatsApp</h3>
            <p>Terima kasih telah menghubungi kami. Tim kami akan segera merespons, mari lanjutkan diskusinya di WhatsApp.</p>
            <a href="#" class="success-popup-wa" id="waFallback" target="_blank" rel="noopener" hidden>Buka WhatsApp</a>
            <button type="button" class="success-popup-close" id="successPopupClose">Tutup</button>
        </div>
    </div>
</div>

<!-- Sidebar ikon sosial media, mengambang di tepi kiri layar (bisa dibuka/tutup) -->
<div class="social-sidebar" id="socialSidebar">
    <a href="#" class="s-facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
    <a href="#" class="s-twitter" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
    <a href="#" class="s-linkedin" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
    <a href="#" class="s-instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
    <a href="#" id="socialClose" class="social-toggle" aria-label="Tutup menu sosial media">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
</div>
<a href="#" id="socialOpen" class="social-toggle social-open" aria-label="Buka menu sosial media">
    <i class="fa-solid fa-chevron-right"></i>
</a>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    .contact-page {
        /* Warna & font mudah diubah dari sini */
        --ink: #111418;
        --muted: #667085;
        --hero-bg: #F4F4F5;
        --line: #DDE1E6;
        --soft: #EDEEF0;
        --accent: #094356;
        --gutter: clamp(20px, 6vw, 110px); /* jarak isi dari tepi layar; card & pita abu-abu tetap full lebar */

        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: #FFFFFF;
        -webkit-font-smoothing: antialiased;
        overflow-x: hidden;
    }
    .contact-page *,
    .contact-page *::before,
    .contact-page *::after { box-sizing: border-box; }

    .contact-inner {
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ===== Header ===== */
    .contact-hero {
        position: relative;
        overflow: hidden;
        background: var(--hero-bg);
        padding: 120px var(--gutter) 56px;
    }
    .contact-hero .contact-inner { position: relative; z-index: 1; }

    /* Mode foto: aktif otomatis bila file public/images/contact-hero.jpg ada */
    .contact-hero.has-image {
        background-color: var(--hero-bg);
        background-image:
            linear-gradient(90deg, rgba(244,244,245,0.96) 0%, rgba(244,244,245,0.86) 45%, rgba(244,244,245,0.25) 100%),
            var(--hero-image);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* Animasi partikel (Particle Network) sebagai latar header */
    .hero-particles {
        position: absolute;
        inset: 0;
        z-index: 0;
        overflow: hidden;
        pointer-events: none;
        /* sisi kiri dibuat sedikit lebih samar agar judul tetap nyaman dibaca */
        -webkit-mask-image: linear-gradient(to right, rgba(0,0,0,0.4) 0%, #000 60%);
                mask-image: linear-gradient(to right, rgba(0,0,0,0.4) 0%, #000 60%);
    }
    .hero-particles #particle-canvas { width: 100%; height: 100%; }
    .hero-particles canvas { display: block; }
    .hero-sub {
        margin: 16px 0 0;
        max-width: 44ch;
        font-size: 1rem;
        line-height: 1.6;
        color: var(--muted);
    }
    .breadcrumb {
        display: flex;
        gap: 6px;
        font-size: 0.78rem;
        color: var(--muted);
        margin-bottom: 14px;
    }
    .breadcrumb a { color: var(--muted); text-decoration: none; }
    .breadcrumb a:hover { color: var(--ink); }
    .contact-hero h1 {
        margin: 0;
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }

    /* ===== Card gabungan (full lebar) ===== */
    .contact-card {
        background: #FFFFFF;
        padding: 64px var(--gutter) 88px;
    }
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: clamp(40px, 7vw, 110px);
        align-items: stretch;
    }
    .contact-page h2 {
        margin: 0 0 12px;
        font-size: clamp(1.4rem, 2.4vw, 1.75rem);
        font-weight: 600;
        letter-spacing: -0.02em;
        line-height: 1.25;
    }
    .contact-page .lead {
        margin: 0 0 32px;
        font-size: 0.9rem;
        line-height: 1.65;
        color: var(--muted);
        max-width: 46ch;
    }

    /* ===== Kanan: info + peta ===== */
    .contact-info { display: flex; flex-direction: column; }
    .info-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }
    .info-list li {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .info-list .icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--soft);
        color: var(--ink);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }
    .info-list strong {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 3px;
    }
    .info-list a,
    .info-list span:not(.icon) {
        font-size: 0.85rem;
        line-height: 1.55;
        color: var(--muted);
        text-decoration: none;
    }
    .info-list a:hover { color: var(--ink); }

    .map {
        flex: 1;
        min-height: 240px;
        margin-bottom: 32px;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid var(--line);
    }
    .map iframe {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 240px;
        border: 0;
    }

    /* ===== Kiri: form amplop ===== */
    .envelope-wrapper {
        width: 100%;
        display: flex;
        justify-content: flex-start;
        /* Container query: skala amplop mengikuti lebar kolom yang tersedia, bukan lebar layar */
        container-type: inline-size;
        container-name: envelope-ctx;
        min-width: 0;
    }
    .envelope {
        position: relative;
        display: block;
        width: 100%;
        max-width: 28em;
        margin: 0;
        overflow: hidden;
        border-radius: 0.4em;
        /* Semua ukuran di dalam amplop memakai em, jadi seluruh proporsinya
           ditentukan oleh font-size ini (ikut mengecil/membesar sesuai lebar kolom). */
        font-size: clamp(8px, 3.5cqw, 20px);
        transition: height 0.5s ease-in-out 1s, font-size 0.2s ease-out;
    }
    .envelope.measuring,
    .envelope.measuring .content,
    .envelope.measuring .bottom-wrapper {
        transition: none !important; /* dipakai sesaat untuk mengukur tinggi tanpa animasi */
    }
    .envelope.active .content { padding-top: 15em; }
    .envelope.active .paper.front,
    .envelope.active .paper.back {
        animation-duration: 1.5s;
        animation-direction: normal;
        animation-timing-function: ease-in-out;
        animation-fill-mode: forwards;
    }
    .envelope.active .paper.front { animation-name: envelope-front; }
    .envelope.active .paper.back { animation-name: envelope-back; }
    .envelope.active .paper.back:before {
        animation-duration: 0.5s;
        animation-direction: normal;
        animation-timing-function: ease-in-out;
        animation-fill-mode: forwards;
        animation-delay: 1.25s;
        animation-name: envelope-back-before;
    }
    .envelope.active .bottom-wrapper { transform: rotateX(180deg); }
    .envelope.active .bottom-wrapper:after { z-index: 0; opacity: 1; }
    .envelope .content {
        padding: 2em;
        position: relative;
        z-index: 9;
        transition: padding-top 0.5s ease-in-out 1s;
    }
    .envelope .top-wrapper,
    .envelope .bottom-wrapper {
        background: #094356;
        color: #FFFFFF;
    }
    .envelope .top-wrapper {
        padding: 2em 2em 0;
        border-top-left-radius: 0.4em;
        border-top-right-radius: 0.4em;
    }
    .envelope .bottom-wrapper {
        padding: 0 2em 2em;
        border-bottom-left-radius: 0.4em;
        border-bottom-right-radius: 0.4em;
        transition: all 0.5s ease-in-out;
        transform-origin: top;
        transform-style: preserve-3d;
        position: relative;
        overflow: hidden;
        margin-top: -1px;
    }
    .envelope .bottom-wrapper:after {
        position: absolute;
        content: '';
        display: block;
        opacity: 0;
        background: #094356;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }
    .envelope .contact-form .input { padding-bottom: 1em; }
    .envelope .contact-form label {
        display: block;
        padding-bottom: 0.4em;
        color: #FFFFFF;
        font-weight: 500;
        font-size: 0.75em;
        letter-spacing: 0.01em;
    }
    .envelope .contact-form input,
    .envelope .contact-form textarea {
        width: 100%;
        background: transparent;
        color: #FFFFFF;
        font-family: inherit;
        font-size: 0.85em;
    }
    .envelope .contact-form input {
        border-width: 0 0 0.1em;
        border-color: #7C9BA6;
        border-style: solid;
        padding: 0.4em 0.1em;
    }
    .envelope .contact-form input::placeholder,
    .envelope .contact-form textarea::placeholder { color: #B7C6CC; }
    .envelope .contact-form textarea {
        border: 0.1em solid #7C9BA6;
        border-radius: 0.25em;
        padding: 0.6em;
        resize: vertical;
        line-height: 1.6;
    }
    .envelope .contact-form input:focus,
    .envelope .contact-form textarea:focus {
        outline: none;
        border-color: #FFFFFF;
    }
    .envelope .contact-form .submit-card {
        background: #FFFFFF;
        color: #094356;
        text-align: center;
        padding: 0.7em;
        width: 100%;
        border: 0;
        border-radius: 0.25em;
        cursor: pointer;
        font-family: inherit;
        font-weight: 600;
        font-size: 0.85em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.3s ease, color 0.3s ease;
    }
    .envelope .contact-form .submit-card:hover { background: #7C9BA6; color: #FFFFFF; }
    .envelope .contact-form .submit-card:disabled { cursor: not-allowed; }
    .envelope .paper {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        border-bottom-left-radius: 0.4em;
        border-bottom-right-radius: 0.4em;
        overflow: hidden;
    }
    .envelope .paper.back { top: 0; }
    .envelope .paper.back:before {
        content: '';
        display: block;
        width: 0;
        height: 0;
        margin-bottom: -1px;
        border-style: solid;
        border-width: 0 14em 9.3em 14em;
        border-color: transparent transparent #E9DCC0 transparent;
        transform-origin: bottom;
        transform-style: preserve-3d;
        z-index: 0;
    }
    .envelope .paper.back:after {
        content: '';
        display: block;
        background-color: #E9DCC0;
        width: 28em;
        height: 18.6em;
    }
    .envelope .paper.front {
        top: 9.3em;
        box-shadow: 0.1em 0.5em 0.5em rgba(0, 0, 0, 0.25);
        z-index: 0;
    }
    .envelope .paper.front:before {
        content: '';
        display: block;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 9.3em 14em 0 14em;
        border-color: transparent #FBF3E7;
    }
    .envelope .paper.front:after {
        content: '';
        display: block;
        width: 28em;
        height: 9.3em;
        background: #FBF3E7;
        margin-top: -1px;
    }
    @keyframes envelope-front {
        0%   { top: 9.3em; z-index: 0; }
        50%  { top: 14em;  z-index: 9; }
        100% { top: 9.3em; z-index: 9; }
    }
    @keyframes envelope-back {
        0%   { top: 0; }
        50%  { top: 4.6em; }
        100% { top: 0; }
    }
    @keyframes envelope-back-before {
        0% {
            border-color: transparent transparent #E9DCC0 transparent;
            transform: rotateX(0deg);
            z-index: 0;
        }
        100% {
            border-color: transparent transparent #FBF3E7 transparent;
            transform: rotateX(180deg);
            z-index: 99;
            position: relative;
        }
    }

    /* ===== Popup ===== */
    .success-popup-overlay {
        position: fixed;
        inset: 0;
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(17, 20, 24, 0.55);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, visibility 0.25s ease;
    }
    .success-popup-overlay.active { opacity: 1; visibility: visible; }
    .success-popup-box {
        width: 100%;
        max-width: 380px;
        padding: 40px 32px 32px;
        text-align: center;
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.25);
        transform: translateY(10px);
        transition: transform 0.25s ease;
    }
    .success-popup-overlay.active .success-popup-box { transform: translateY(0); }
    .success-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: var(--accent);
        color: #FFFFFF;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .success-popup-box h3 {
        margin: 0 0 10px;
        font-size: 1.15rem;
        font-weight: 600;
        letter-spacing: -0.01em;
    }
    .success-popup-box p {
        margin: 0 0 24px;
        font-size: 0.9rem;
        line-height: 1.6;
        color: var(--muted);
    }
    .success-popup-close {
        padding: 11px 32px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        color: #FFFFFF;
        background: var(--accent);
        border: 0;
        border-radius: 999px;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .success-popup-close:hover { background: #0B5A73; }
    .success-popup-wa {
        display: block;
        margin: -8px 0 16px;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--accent);
    }
    .success-popup-wa[hidden] { display: none; }

    /* ===== Sidebar sosial media ===== */
    .social-sidebar {
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        z-index: 60;
        transition: left 0.3s ease-in-out;
    }
    .social-sidebar.collapsed { left: -46px; }
    .social-sidebar a {
        width: 46px;
        height: 46px;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        transition: width 0.2s ease-in-out;
    }
    .social-sidebar a:hover { width: 54px; }
    .s-facebook  { background-color: #1877F2; }
    .s-twitter   { background-color: #1DA1F2; }
    .s-linkedin  { background-color: #0A66C2; }
    .s-instagram { background: linear-gradient(45deg, #F09433 0%, #E6683C 25%, #DC2743 50%, #CC2366 75%, #BC1888 100%); }
    .social-sidebar .social-toggle { background: #094356; font-size: 0.8rem; }
    #socialOpen {
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 46px;
        background: #094356;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        z-index: 59;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out, width 0.2s ease-in-out;
    }
    #socialOpen.visible { opacity: 1; pointer-events: auto; }
    #socialOpen:hover { width: 30px; }

    /* ===== Responsive ===== */
    @media (max-width: 900px) {
        .contact-grid { grid-template-columns: 1fr; gap: 56px; }
        .contact-hero { padding-top: 100px; padding-bottom: 40px; }
        .contact-hero.has-image {
            background-image:
                linear-gradient(rgba(244,244,245,0.9), rgba(244,244,245,0.9)),
                var(--hero-image);
        }
        .contact-card { padding-top: 44px; padding-bottom: 64px; }
        .map { flex: none; height: 260px; }
    }
    @media (max-width: 900px) {
        .envelope-wrapper { justify-content: center; }
        .envelope { margin: 0 auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== Sidebar sosial media (buka/tutup) =====
        const socialSidebar = document.getElementById('socialSidebar');
        const socialClose = document.getElementById('socialClose');
        const socialOpen = document.getElementById('socialOpen');

        function closeSocialSidebar() {
            socialSidebar.classList.add('collapsed');
            socialOpen.classList.add('visible');
        }
        function openSocialSidebar() {
            socialSidebar.classList.remove('collapsed');
            socialOpen.classList.remove('visible');
        }

        if (socialSidebar && socialClose && socialOpen) {
            // Default: tertutup di layar sempit, terbuka di layar lebar
            window.innerWidth <= 768 ? closeSocialSidebar() : openSocialSidebar();

            socialClose.addEventListener('click', function (e) { e.preventDefault(); closeSocialSidebar(); });
            socialOpen.addEventListener('click', function (e) { e.preventDefault(); openSocialSidebar(); });
        }

        // ===== Form amplop -> WhatsApp =====
        const envelope = document.getElementById('contactEnvelope');
        const form = document.getElementById('contactForm');
        const overlay = document.getElementById('successPopupOverlay');
        const closeBtn = document.getElementById('successPopupClose');
        const waFallback = document.getElementById('waFallback');
        const submitBtn = form ? form.querySelector('.submit-card') : null;

        // Nomor WhatsApp tujuan (format internasional tanpa "+", spasi, atau tanda hubung)
        const WHATSAPP_NUMBER = '6287762166795';

        // Total durasi animasi amplop menutup (delay 1.25s + durasi 0.5s = 1.75s)
        const ENVELOPE_ANIMATION_MS = 1800;

        function buildWhatsAppMessage(name, address, message) {
            return [
                'Halo Tim *PT Astabrata Teknologi*,',
                '',
                'Saya ingin menyampaikan pesan melalui formulir kontak di website Anda, dengan rincian sebagai berikut:',
                '',
                '*Nama Lengkap :* ' + name,
                '*Alamat :* ' + address,
                '',
                '*Isi Pesan :*',
                message,
                '',
                'Mohon tanggapan dan informasi lebih lanjut dari tim Bapak/Ibu. Terima kasih atas perhatiannya.',
                '',
                'Salam hormat,',
                name
            ].join('\n');
        }

        function showPopup() {
            overlay.classList.add('active');
            if (closeBtn) closeBtn.focus();
        }

        function resetContactCard() {
            overlay.classList.remove('active');
            envelope.classList.remove('active');
            envelope.style.height = '';
            form.reset();
            if (submitBtn) submitBtn.disabled = false;
        }

        if (envelope && form && overlay) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }
                if (envelope.classList.contains('active')) return;
                if (submitBtn) submitBtn.disabled = true;

                // Simpan data sebelum form direset
                const name = form.elements['name'].value.trim();
                const waUrl = 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' +
                    encodeURIComponent(buildWhatsAppMessage(name, form.elements['address'].value.trim(), form.elements['message'].value.trim()));

                // 1) Kunci tinggi amplop saat form masih terbuka (titik awal animasi)
                envelope.classList.add('measuring');
                envelope.style.height = envelope.scrollHeight + 'px';
                void envelope.offsetHeight;
                envelope.classList.remove('measuring');

                // 2) Tinggi amplop tertutup = tinggi kertas amplop (paper.back)
                const backPaper = envelope.querySelector('.paper.back');
                const closedHeight = backPaper ? backPaper.offsetHeight : envelope.scrollHeight;

                // 3) Jalankan animasi menutup
                requestAnimationFrame(function () {
                    envelope.classList.add('active');
                    envelope.style.height = closedHeight + 'px';
                });

                // 4) Tunggu animasi amplop selesai menutup, baru buka WhatsApp + tampilkan popup
                setTimeout(function () {
                    const waWindow = window.open(waUrl, '_blank');
                    if (waWindow) waWindow.opener = null;
                    // Jika browser memblokir tab baru, tampilkan tautan manual di popup
                    if (waFallback) {
                        waFallback.href = waUrl;
                        waFallback.hidden = !!waWindow;
                    }
                    showPopup();
                }, ENVELOPE_ANIMATION_MS);
            });

            if (closeBtn) closeBtn.addEventListener('click', resetContactCard);
            overlay.addEventListener('click', function (e) { if (e.target === overlay) resetContactCard(); });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && overlay.classList.contains('active')) resetContactCard();
            });
        }
    });

    /* ===== Particle Network (latar header "Hubungi Kami") ===== */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){if(this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.background))this.l(this.k,{background:this.options.background});else{if(!/\.(gif|jpg|jpeg|tiff|png)$/i.test(this.options.background))return console.error("Please specify a valid background image or hexadecimal color"),!1;this.l(this.k,{background:'url("'+this.options.background+'") no-repeat center',"background-size":"cover"})}if(!/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.particleColor))return console.error("Please specify a valid particleColor hexadecimal color"),!1;this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.i,{position:"relative"}),this.l(this.canvas,{"z-index":"20",position:"relative"}),window.addEventListener("resize",function(){return this.i.offsetWidth===this.i.size.width&&this.i.offsetHeight===this.i.size.height?!1:(this.canvas.width=this.i.size.width=this.i.offsetWidth,this.canvas.height=this.i.size.height=this.i.offsetHeight,clearTimeout(this.m),void(this.m=setTimeout(function(){this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&this.o.push(this.p),requestAnimationFrame(this.update.bind(this))}.bind(this),500)))}.bind(this)),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&(this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p),this.canvas.addEventListener("mousemove",function(a){this.p.x=a.clientX-this.canvas.offsetLeft,this.p.y=a.clientY-this.canvas.offsetTop}.bind(this)),this.canvas.addEventListener("mouseup",function(a){this.p.velocity={x:(Math.random()-.5)*this.options.velocity,y:(Math.random()-.5)*this.options.velocity},this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p)}.bind(this))),requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height),this.g.globalAlpha=1;for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}0!==this.options.velocity&&requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:"none"===a?0:.66},b.prototype.j=function(a){return"high"===a?5e3:"low"===a?2e4:isNaN(parseInt(a,10))?1e4:a},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    document.addEventListener('DOMContentLoaded', function () {
        const canvasDiv = document.getElementById('particle-canvas');
        if (!canvasDiv || typeof ParticleNetwork === 'undefined') return;

        const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        new ParticleNetwork(canvasDiv, {
            particleColor: '#7C9BA6',
            background: '#F4F4F5',   // samakan dengan warna pita header
            interactive: false,
            speed: reduceMotion ? 'none' : 'medium',
            density: 'high'
        });
    });
</script>
@endpush
@endsection