@extends('layouts.app')

@section('title', 'Contact Us - PT Astabrata Teknologi')

@section('content')
<div class="page-wrapper">
    <!-- Full-page Particle Technology Background -->
    <div class="particle-background" aria-hidden="true">
        <div id="particle-canvas"></div>
    </div>

    <div class="contact-header reveal">
        <span class="eyebrow">Hubungi Kami</span>
        <h1>Mari Berkolaborasi</h1>
        <p class="subtitle">Punya proyek luar biasa yang ingin diwujudkan? Atau sekadar ingin berkonsultasi mengenai strategi digital Anda? Tim kami siap membantu.</p>
    </div>

    <div class="contact-container reveal">
        <!-- Left column: message form -->
        <div class="contact-left">
            <div class="message-card">
                <h2>Kirim Pesan</h2>
                <div class="envelope-wrapper">
                    <div class="envelope" id="contactEnvelope">
                        <div class="back paper"></div>
                        <div class="content">
                            <form action="#" method="POST" class="contact-form" id="contactForm">
                                @csrf
                                <div class="top-wrapper">
                                    <div class="input">
                                        <label for="name">Nama Lengkap</label>
                                        <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>
                                    </div>
                                    <div class="input">
                                        <label for="address">Alamat</label>
                                        <input type="text" id="address" name="address" placeholder="Masukkan alamat Anda" required>
                                    </div>
                                </div>
                                <div class="bottom-wrapper">
                                    <div class="input">
                                        <label for="message">Pesan Anda</label>
                                        <textarea id="message" name="message" rows="5" placeholder="Ceritakan detail proyek atau pertanyaan Anda..." required></textarea>
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
        </div>

        <!-- Right column: map + contact info (digabung dalam satu kartu) -->
        <div class="contact-right">
            <div class="location-card">
                <div class="map-card">
                    <iframe
                        src="https://www.google.com/maps?q=-7.4661805,110.2534664&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="info-card">
                    <div class="info-row">
                        <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="details">
                            <p>Jl. Teknologi No. 88, Kawasan Digital Raya<br>Jakarta Selatan, Indonesia 12345</p>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="details">
                            <p>hello@astabrata.tech</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popup notifikasi: muncul setelah animasi amplop menutup selesai -->
<div class="success-popup-overlay" id="successPopupOverlay">
    <div class="success-popup-box">
        <div class="success-icon"><i class="fa-solid fa-check"></i></div>
        <h3>Terhubung Ke WhatsApp</h3>
        <p>Terima kasih telah menghubungi kami.Tim kami akan segera merespons, mari lanjutkan diskusinya di WhatsApp."</p>
        <button type="button" class="success-popup-close" id="successPopupClose">Tutup</button>
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
<style>
    .page-wrapper {
        position: relative;
        padding: 90px 5% 100px;
        background-color: #EDEDED;
        min-height: 100vh;
        overflow-x: hidden; /* jaring pengaman ekstra agar tidak ada elemen yang memicu scroll horizontal di layar sempit */
        isolation: isolate;
    }

    /* Particle Technology — membentang sepanjang halaman, mengikuti palet navy/teal contact */
    .particle-background {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
        opacity: 0.6;
        background:
            radial-gradient(
                circle at 14% 16%,
                rgba(9, 67, 86, 0.10) 0%,
                rgba(9, 67, 86, 0) 30%
            ),
            radial-gradient(
                circle at 88% 30%,
                rgba(124, 155, 166, 0.14) 0%,
                rgba(124, 155, 166, 0) 30%
            ),
            radial-gradient(
                circle at 46% 88%,
                rgba(9, 67, 86, 0.08) 0%,
                rgba(9, 67, 86, 0) 32%
            );
    }

    .particle-background #particle-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        opacity: 1;
    }

    .page-wrapper > *:not(.particle-background) {
        position: relative;
        z-index: 1;
    }

    .contact-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .contact-header .eyebrow {
        font-family: 'Poppins', sans-serif;
        color: #094356;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-size: 1rem;
        display: block;
        margin-bottom: 15px;
    }
    .contact-header h1 {
        font-family: 'Sora', sans-serif;
        font-size: 4rem;
        color: #094356;
        margin-bottom: 20px;
        font-weight: 800;
    }
    .contact-header .subtitle {
        color: #4A5A61;
        font-size: 1.2rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Two-column layout */
    .contact-container {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 0; /* card kiri & kanan dibuat menempel langsung, tanpa jarak */
        max-width: 1300px;
        margin: 0 auto;
        align-items: stretch;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* shadow dipindah ke wrapper gabungan */
        border-radius: 16px; /* sudut agak melengkung di seluruh card gabungan */
        overflow: hidden; /* biar isi di dalamnya ikut kepotong mengikuti lengkungan sudut */
    }

    .contact-left {
        display: flex;
    }

    /* ===== Left: message form card ===== */
    .message-card {
        background: #FEFEFE;
        padding: 45px;
        border-radius: 0;
        width: 100%;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .message-card h2 {
        align-self: flex-start;
        font-family: 'Sora', sans-serif;
        font-size: 1.7rem;
        color: #094356;
        font-weight: 700;
        margin-bottom: 30px;
    }
    /* ===== Envelope-style animated contact form ===== */
    .envelope-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        flex: 1;
        /* Container query context: memungkinkan .envelope mengukur lebar
           ruang yang benar-benar tersedia (bukan lebar viewport), supaya
           skalanya presisi di semua ukuran layar */
        container-type: inline-size;
        container-name: envelope-ctx;
        min-width: 0; /* jaga agar flex child boleh menyusut di bawah konten */
    }
    .envelope {
        position: relative;
        display: block;
        width: 100%;
        max-width: 28em;
        margin: 0 auto;
        overflow: hidden;
        border-radius: 0.4em;
        box-sizing: border-box;
        /* Semua ukuran di dalam amplop (paper, input, label, dst) memakai
           satuan em, jadi seluruh proporsi amplop ditentukan oleh font-size
           di baris berikut. Dengan container query units (cqw), font-size
           ini otomatis mengecil/membesar mengikuti lebar ruang yang benar-benar
           tersedia (bukan lebar viewport), sehingga amplop selalu utuh dan
           tidak ada bagian form yang "melewati" bentuk amplopnya di layar
           manapun -- persis proporsional dengan versi web, hanya diperkecil. */
        font-size: clamp(8px, 3.5cqw, 16px);
        transition: height 0.5s ease-in-out 1s, font-size 0.2s ease-out; /* tinggi amplop ikut membesar bersamaan form turun (1s-1.5s), disetel via JS */
    }
    .envelope.measuring,
    .envelope.measuring .content,
    .envelope.measuring .bottom-wrapper {
        transition: none !important; /* dipakai sesaat untuk mengukur tinggi tanpa animasi berjalan */
    }
    .envelope.active .content {
        padding-top: 15em;
    }
    .envelope.active .paper.front,
    .envelope.active .paper.back {
        animation-duration: 1.5s;
        animation-direction: normal;
        animation-timing-function: ease-in-out;
        animation-fill-mode: forwards;
    }
    .envelope.active .paper.front {
        animation-name: envelope-front;
    }
    .envelope.active .paper.back {
        animation-name: envelope-back;
    }
    .envelope.active .paper.back:before {
        animation-duration: 0.5s;
        animation-direction: normal;
        animation-timing-function: ease-in-out;
        animation-fill-mode: forwards;
        animation-delay: 1.25s;
        animation-name: envelope-back-before;
    }
    .envelope.active .bottom-wrapper {
        transform: rotateX(180deg);
    }
    .envelope.active .bottom-wrapper:after {
        z-index: 0;
        opacity: 1;
    }
    .envelope .content {
        padding: 2em;
        box-sizing: border-box;
        position: relative;
        z-index: 9;
        transition: padding-top 0.5s ease-in-out 1s;
    }
    .envelope .top-wrapper,
    .envelope .bottom-wrapper {
        box-sizing: border-box;
        background: #094356;
        color: #FEFEFE;
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
    .envelope .contact-form label {
        display: block;
        padding-bottom: 0.4em;
        color: #FEFEFE;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.7em;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .envelope .contact-form input,
    .envelope .contact-form textarea {
        width: 100%;
        box-sizing: border-box;
        background: transparent;
        color: #FEFEFE;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85em;
    }
    .envelope .contact-form input {
        border-width: 0 0 0.1em;
        border-color: #7C9BA6;
        border-style: solid;
        padding: 0.4em 0.1em;
    }
    .envelope .contact-form input::placeholder,
    .envelope .contact-form textarea::placeholder {
        color: #B7C6CC;
    }
    .envelope .contact-form textarea {
        border: 0.1em solid #7C9BA6;
        border-radius: 0.25em;
        padding: 0.6em;
        resize: vertical;
    }
    .envelope .contact-form input:focus,
    .envelope .contact-form textarea:focus {
        outline: none;
        border-color: #FEFEFE;
    }
    .envelope .contact-form .input {
        padding-bottom: 1em;
    }
    .envelope .contact-form .submit-card {
        background: #FEFEFE;
        color: #094356;
        text-align: center;
        padding: 0.7em;
        box-sizing: border-box;
        width: 100%;
        border: 0;
        border-radius: 0.25em;
        cursor: pointer;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 0.85em;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.3s ease, color 0.3s ease;
    }
    .envelope .contact-form .submit-card:hover {
        background: #7C9BA6;
        color: #FEFEFE;
    }
    .envelope .paper {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        border-bottom-left-radius: 0.4em;
        border-bottom-right-radius: 0.4em;
        overflow: hidden;
    }
    .envelope .paper.back {
        top: 0;
    }
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
        box-shadow: 0.1em 0.5em 0.5em rgba(0,0,0,0.25);
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
        0% { top: 9.3em; z-index: 0; }
        50% { top: 14em; z-index: 9; }
        100% { top: 9.3em; z-index: 9; }
    }
    @keyframes envelope-back {
        0% { top: 0; }
        50% { top: 4.6em; }
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
    /* ===== Right: contact info + map ===== */
    .contact-right {
        display: flex;
        flex-direction: column;
        gap: 25px;
        height: 100%;
    }

    /* Kartu gabungan: peta di atas, info kontak (alamat, email, telepon) di bawahnya */
    .location-card {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
        border-radius: 0;
        overflow: hidden;
        box-sizing: border-box;
        padding: 14px; /* jarak supaya peta & info tidak mepet ke tepi card */
        gap: 14px; /* jarak antara peta dan blok info alamat */
        background: #FEFEFE;
    }

    .info-card {
        background: #094356;
        color: #EDEDED;
        padding: 20px 28px;
        border-radius: 10px;
        flex: 1;
        min-height: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .info-card h2 {
        font-family: 'Sora', sans-serif;
        font-size: 1.1rem;
        color: #FEFEFE;
        font-weight: 700;
        margin-bottom: 14px;
    }
    .info-card .info-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    .info-card .info-row:last-child {
        margin-bottom: 0;
    }
    .info-card .info-row .icon {
        width: 34px;
        height: 34px;
        background: #7C9BA6;
        color: #094356;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .info-card .info-row p {
        color: #D8E3E7;
        line-height: 1.5;
        font-size: 0.85rem;
    }

    /* Sidebar ikon sosial media: mengambang di tepi kiri layar, bisa dibuka/tutup.
       Tanpa kartu/kotak pembatas -- tiap ikon berdiri sendiri memakai warna asli platformnya. */
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
    .social-sidebar.collapsed {
        left: -46px;
    }
    .social-sidebar a {
        width: 46px;
        height: 46px;
        color: #FEFEFE;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        transition: width 0.2s ease-in-out;
    }
    .social-sidebar a:hover {
        width: 54px;
    }
    .s-facebook  { background-color: #1877F2; }
    .s-twitter   { background-color: #1DA1F2; }
    .s-linkedin  { background-color: #0A66C2; }
    .s-instagram {
        background: linear-gradient(45deg, #F09433 0%, #E6683C 25%, #DC2743 50%, #CC2366 75%, #BC1888 100%);
    }
    .social-sidebar .social-toggle {
        background: #094356;
        font-size: 0.8rem;
    }
    /* Tombol buka sidebar, muncul saat sidebar dalam keadaan tertutup */
    #socialOpen {
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 46px;
        background: #094356;
        color: #FEFEFE;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        z-index: 59;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out, width 0.2s ease-in-out;
    }
    #socialOpen.visible {
        opacity: 1;
        pointer-events: auto;
    }
    #socialOpen:hover {
        width: 30px;
    }

    .map-card {
        width: 100%;
        flex: 4; /* peta dibuat jauh lebih luas, sekitar 80% tinggi card */
        min-height: 180px;
        border-radius: 10px;
        overflow: hidden;
    }
    .map-card iframe {
        display: block;
    }

    /* ===== Popup notifikasi "Pesan Terkirim" ===== */
    /* Ditampilkan lewat JS setelah animasi amplop menutup selesai (bukan langsung saat klik Kirim) */
    .success-popup-overlay {
        position: fixed;
        inset: 0;
        background: rgba(9, 67, 86, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 200;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        padding: 20px;
        box-sizing: border-box;
    }
    .success-popup-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .success-popup-box {
        background: #FEFEFE;
        border-radius: 14px;
        padding: 42px 34px;
        max-width: 360px;
        width: 100%;
        text-align: center;
        box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        transform: scale(0.85) translateY(12px);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .success-popup-overlay.active .success-popup-box {
        transform: scale(1) translateY(0);
    }
    .success-icon {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: #094356;
        color: #FEFEFE;
        font-size: 1.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transform: scale(0);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s;
    }
    .success-popup-overlay.active .success-icon {
        transform: scale(1);
    }
    .success-popup-box h3 {
        font-family: 'Sora', sans-serif;
        color: #094356;
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0 0 10px;
    }
    .success-popup-box p {
        color: #4A5A61;
        font-size: 0.92rem;
        line-height: 1.6;
        margin: 0 0 24px;
    }
    .success-popup-close {
        background: #094356;
        color: #FEFEFE;
        border: 0;
        padding: 10px 30px;
        border-radius: 6px;
        font-family: 'Sora', sans-serif;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .success-popup-close:hover {
        background: #7C9BA6;
    }

    @media (max-width: 992px) {
        .contact-container { grid-template-columns: 1fr; gap: 25px; box-shadow: none; border-radius: 0; overflow: visible; }
        .message-card { box-shadow: 0 10px 30px rgba(0,0,0,0.08); border-radius: 16px; }

        /* Kartu peta + info (alamat, email) di mobile: dari "flex + height:100%"
           yang mengikuti tinggi kolom desktop, diubah ke tinggi natural mengikuti
           konten, supaya peta & blok info tidak ikut menyusut/gepeng. */
        .contact-right { height: auto; }
        .location-card {
            height: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-radius: 16px;
        }
        .map-card { flex: none; height: 220px; }
        .info-card {
            flex: none;
            justify-content: flex-start;
            padding: 22px 22px;
        }
    }
    @media (max-width: 600px) {
        .contact-header h1 { font-size: 2.6rem; }
        .page-wrapper { padding-top: 70px; }
        .message-card { padding: 30px 20px; }

        /* Rapikan baris alamat & email: ikon sejajar-tengah dengan teks
           (bukan nempel ke baris pertama saja saat teks wrap 2 baris),
           dan beri jarak antar baris yang lebih lega. */
        .info-card { padding: 20px 18px; }
        .info-card h2 { font-size: 1rem; margin-bottom: 12px; }
        .info-card .info-row {
            align-items: center;
            gap: 14px;
            margin-bottom: 14px;
        }
        .info-card .info-row .icon {
            width: 38px;
            height: 38px;
            font-size: 0.9rem;
        }
        .info-card .info-row p {
            font-size: 0.88rem;
            line-height: 1.45;
            word-break: break-word;
        }
        .map-card { height: 190px; }
    }
    @media (max-width: 380px) {
        .message-card { padding: 24px 14px; }

        .info-card { padding: 18px 14px; }
        .info-card .info-row { gap: 10px; }
        .info-card .info-row .icon {
            width: 32px;
            height: 32px;
            font-size: 0.8rem;
        }
        .info-card .info-row p { font-size: 0.82rem; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Sidebar ikon sosial media (buka/tutup) =====
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
            // Default: tertutup di layar sempit (mobile), terbuka di layar lebar (desktop)
            if (window.innerWidth <= 768) {
                closeSocialSidebar();
            } else {
                openSocialSidebar();
            }

            socialClose.addEventListener('click', function(e) {
                e.preventDefault();
                closeSocialSidebar();
            });
            socialOpen.addEventListener('click', function(e) {
                e.preventDefault();
                openSocialSidebar();
            });
        }

        // Scroll reveal
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

        // Envelope close animation, only triggered after the form is filled and submitted
        const envelope = document.getElementById('contactEnvelope');
        const contactForm = document.getElementById('contactForm');
        const successPopupOverlay = document.getElementById('successPopupOverlay');
        const successPopupClose = document.getElementById('successPopupClose');

        // Total durasi animasi amplop menutup (delay + duration terpanjang dari semua bagian animasi
        // di CSS, yaitu paper.back:before: delay 1.25s + duration 0.5s = 1.75s). Popup baru muncul
        // setelah waktu ini lewat, supaya user benar-benar melihat amplopnya selesai menutup dulu.
        const ENVELOPE_ANIMATION_MS = 1800;

        function showSuccessPopup() {
            if (successPopupOverlay) {
                successPopupOverlay.classList.add('active');
            }
        }

        function resetContactCard() {
            if (successPopupOverlay) {
                successPopupOverlay.classList.remove('active');
            }
            if (envelope) {
                envelope.classList.remove('active');
                envelope.style.height = '';
            }
            if (contactForm) {
                contactForm.reset();
            }
        }

        if (successPopupClose) {
            successPopupClose.addEventListener('click', function() {
                resetContactCard();
                const submitBtn = contactForm ? contactForm.querySelector('.submit-card') : null;
                if (submitBtn) {
                    submitBtn.disabled = false;
                }
            });
        }

        // Nomor WhatsApp tujuan (format internasional tanpa "+", spasi, atau tanda hubung)
        const WHATSAPP_NUMBER = '6287762166795';

        // Menyusun template pesan WhatsApp yang rapi & profesional dari data form
        function buildWhatsAppMessage(name, address, message) {
            const lines = [
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
            ];
            return lines.join('\n');
        }

        if (envelope && contactForm) {
            const submitBtn = contactForm.querySelector('.submit-card');

            contactForm.addEventListener('submit', function(e) {
                // Stop the normal submit first so we can play the animation
                e.preventDefault();

                // Make sure required fields are filled before "sealing" the envelope
                if (!contactForm.checkValidity()) {
                    contactForm.reportValidity();
                    return;
                }

                // Avoid double submit while the animation is playing
                if (envelope.classList.contains('active')) {
                    return;
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                }

                // Ambil & simpan data yang diisi user sebelum form direset nantinya
                const nameValue = document.getElementById('name').value.trim();
                const addressValue = document.getElementById('address').value.trim();
                const messageValue = document.getElementById('message').value.trim();

                // 1) Kunci tinggi amplop saat form masih terbuka, sebagai titik awal animasi
                //    (dibutuhkan karena height belum di-set secara eksplisit / masih "auto")
                envelope.classList.add('measuring');
                envelope.style.height = envelope.scrollHeight + 'px';
                void envelope.offsetHeight;
                envelope.classList.remove('measuring');

                // 2) Hitung tinggi amplop dalam kondisi TERTUTUP: cukup setinggi bentuk kertas
                //    amplop itu sendiri (paper.back), bukan tinggi form. Dengan begitu amplop
                //    akan mengecil ke ukuran itu dan seluruh bagian form (yang lebih tinggi)
                //    otomatis tersembunyi/tertutup penuh oleh kertas amplop (overflow: hidden).
                const backPaper = envelope.querySelector('.paper.back');
                const closedHeight = backPaper ? backPaper.offsetHeight : envelope.scrollHeight;

                // 3) Jalankan animasi sesungguhnya: amplop mengecil menutup ke tinggi tertutup,
                //    bersamaan dengan form terlipat & kertas amplop bergerak menyegel bagian atas.
                requestAnimationFrame(() => {
                    envelope.classList.add('active');
                    envelope.style.height = closedHeight + 'px';
                });

                // 4) Setelah animasi amplop menutup selesai: buka WhatsApp dengan pesan yang
                //    sudah terisi otomatis (nama, alamat, isi pesan), lalu tampilkan popup
                //    "Pesan Terkirim" di halaman.
                setTimeout(function() {
                    const waMessage = buildWhatsAppMessage(nameValue, addressValue, messageValue);
                    const waUrl = 'https://wa.me/' + WHATSAPP_NUMBER + '?text=' + encodeURIComponent(waMessage);
                    window.open(waUrl, '_blank');
                    showSuccessPopup();
                }, ENVELOPE_ANIMATION_MS);
            });
        }
    });

    /* ===== Particle Technology Background ===== */
    !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){if(this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.background))this.l(this.k,{background:this.options.background});else{if(!/\.(gif|jpg|jpeg|tiff|png)$/i.test(this.options.background))return console.error("Please specify a valid background image or hexadecimal color"),!1;this.l(this.k,{background:'url("'+this.options.background+'") no-repeat center',"background-size":"cover"})}if(!/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.particleColor))return console.error("Please specify a valid particleColor hexadecimal color"),!1;this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.i,{position:"relative"}),this.l(this.canvas,{"z-index":"20",position:"relative"}),window.addEventListener("resize",function(){return this.i.offsetWidth===this.i.size.width&&this.i.offsetHeight===this.i.size.height?!1:(this.canvas.width=this.i.size.width=this.i.offsetWidth,this.canvas.height=this.i.size.height=this.i.offsetHeight,clearTimeout(this.m),void(this.m=setTimeout(function(){this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&this.o.push(this.p),requestAnimationFrame(this.update.bind(this))}.bind(this),500)))}.bind(this)),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&(this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p),this.canvas.addEventListener("mousemove",function(a){this.p.x=a.clientX-this.canvas.offsetLeft,this.p.y=a.clientY-this.canvas.offsetTop}.bind(this)),this.canvas.addEventListener("mouseup",function(a){this.p.velocity={x:(Math.random()-.5)*this.options.velocity,y:(Math.random()-.5)*this.options.velocity},this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p)}.bind(this))),requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height),this.g.globalAlpha=1;for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}0!==this.options.velocity&&requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:"none"===a?0:.66},b.prototype.j=function(a){return"high"===a?5e3:"low"===a?2e4:isNaN(parseInt(a,10))?1e4:a},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

    document.addEventListener('DOMContentLoaded', function() {
        const canvasDiv = document.getElementById('particle-canvas');

        if (canvasDiv) {
            const options = {
                particleColor: '#7C9BA6',
                background: '#EDEDED',
                interactive: true,
                speed: 'medium',
                density: 'high'
            };

            new ParticleNetwork(canvasDiv, options);
        }
    });
</script>
@endpush
@endsection