@extends('layouts.app')

@section('title', 'About Us - PT Astabrata Teknologi')

@section('content')
<div class="page-wrapper">
    <div class="particle-background" aria-hidden="true">
        <div id="particle-canvas"></div>
    </div>

    <div class="about-header reveal">
        <span class="eyebrow">Tentang Perusahaan</span>
        <h1>PT Astabrata Teknologi</h1>
        <p class="subtitle">Membangun inovasi masa depan melalui solusi teknologi yang andal, estetis, dan berdampak nyata bagi pertumbuhan bisnis Anda.</p>
    </div>

    <section class="about-section reveal">
        <div class="about-content">
            <div class="about-text">
                <h2>Siapa Kami?</h2>
                <p>PT Astabrata Teknologi adalah perusahaan penyedia layanan IT terkemuka yang berdedikasi untuk mentransformasi ide menjadi solusi digital tingkat tinggi. Kami percaya bahwa setiap masalah bisnis memiliki jawaban teknologi yang tepat. Dengan perpaduan keahlian rekayasa perangkat lunak dan desain UI/UX yang modern, kami hadir sebagai mitra strategis untuk akselerasi digital Anda.</p>
                <p>Filosofi "Astabrata" yang melambangkan 8 sifat alam semesta menjadi pedoman kami dalam berkarya: adaptif seperti air, kokoh seperti bumi, dan menerangi seperti matahari. Kami berkomitmen memberikan layanan terbaik dengan standar profesionalisme tertinggi.</p>
            </div>
            <div class="about-image">
                <img src="{{ asset('image/kantor.jpeg') }}" alt="Tentang Astabrata">
            </div>
        </div>
    </section>

    <section class="team-section reveal">
        <div class="th-card-wrapper">
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

    <section class="gallery-section reveal">
        <div class="section-heading text-center">
            <h2>Galeri Kegiatan</h2>
            <p>Momen-momen di balik layar tim Astabrata Teknologi.</p>
        </div>
        <div class="gallery-grid">
            @forelse($galleries as $gallery)
                <img src="{{ $gallery->foto_url }}" class="gallery-item" data-caption="{{ $gallery->judul }}" alt="{{ $gallery->judul }}">
            @empty
                <img src="{{ asset('image/asta1.png') }}" class="gallery-item" data-caption="Galeri Astabrata" alt="Galeri Astabrata">
            @endforelse
        </div>
    </section>
</div>

<div id="imageModal" class="custom-modal">
    <span class="close-modal">&times;</span>
    <button class="modal-nav-btn prev-btn" id="modalPrev" aria-label="Previous image">&#10094;</button>
    <button class="modal-nav-btn next-btn" id="modalNext" aria-label="Next image">&#10095;</button>
    
    <div class="modal-content-wrapper">
        <img class="modal-content" id="zoomedImage">
        <div id="modalCaption" class="modal-caption"></div>
    </div>
</div>

@push('styles')
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
        padding: 90px 5% 80px;
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        isolation: isolate;
        background:
            radial-gradient(circle at 8% 10%, rgba(126, 190, 207, 0.16) 0%, rgba(126, 190, 207, 0) 30%),
            radial-gradient(circle at 92% 24%, rgba(159, 214, 185, 0.12) 0%, rgba(159, 214, 185, 0) 28%),
            radial-gradient(circle at 48% 88%, rgba(113, 166, 190, 0.10) 0%, rgba(113, 166, 190, 0) 32%),
            linear-gradient(135deg, #f8fbfc 0%, #f2f6f7 48%, #f7f9f8 100%);
    }

    .page-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            linear-gradient(
                120deg,
                rgba(255, 255, 255, 0.48) 0%,
                rgba(255, 255, 255, 0.12) 42%,
                rgba(255, 255, 255, 0.34) 100%
            );
    }

    .page-wrapper > *:not(.particle-background) {
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
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 60px;
        padding: 20px 0;
        overflow: hidden;
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

    .about-content {
        position: relative;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 30px; /* Diperkecil agar tidak bocel ke kanan */
        max-width: 1200px;
        width: 100%;
        margin: 0 auto;
        padding: 48px 40px; /* Disesuaikan */
        box-sizing: border-box !important;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid rgba(9, 67, 86, 0.08);
        border-radius: 32px;
        box-shadow:
            0 24px 55px rgba(9, 67, 86, 0.10),
            0 4px 14px rgba(9, 67, 86, 0.04);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .about-text {
        flex: 1;
        position: relative;
        z-index: 5;
        font-family: 'Poppins', sans-serif;
    }

    .about-text::before {
        content: 'TENTANG KAMI';
        display: block;
        margin-bottom: 15px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.18em;
        color: #4d8b78;
    }

    .about-text h2 {
        font-family: 'Sora', sans-serif;
        font-size: 2.8rem;
        line-height: 1.15;
        margin-bottom: 25px;
        color: #094356;
        font-weight: 700;
        letter-spacing: -0.03em;
    }

    .about-text p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        line-height: 1.85;
        color: #53666d;
        margin-bottom: 20px;
    }

    .about-image {
        flex: 0 0 46%;
        position: relative;
        z-index: 5;
        overflow: hidden;
        border-radius: 22px;
        box-shadow: 0 18px 38px rgba(9, 67, 86, 0.16);
        border: 1px solid rgba(9, 67, 86, 0.08);
        background: #f5f8f8;
    }

    .about-image img {
        width: 100%;
        height: 100%;
        min-height: 390px;
        max-height: 470px;
        object-fit: cover;
        display: block;
    }

    /* ===== Tim Kami ===== */
    :root {
        --th-card-width: 240px;
    }

    .team-section {
        width: 100%;
        max-width: 100%;
        margin-left: 0;
        margin-right: 0;
        margin-bottom: 100px;
        position: relative;
        overflow: hidden; /* Mencegah slider tumpah ke kanan */
    }

    .th-card-wrapper .section-heading {
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
        padding: 0 12px;
    }

    .th-card-wrapper {
        position: relative;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        background: #FEFEFE;
        border-radius: 32px;
        box-shadow: 0 25px 60px rgba(9, 67, 86, 0.12);
        border: 1px solid rgba(9, 67, 86, 0.08);
        padding: 56px 20px 50px;
        overflow: hidden;
        box-sizing: border-box;
    }

    .th-slider-container {
        position: relative;
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
        background: #ffffff;
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
        border-radius: 6px 6px 0 0;
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

    .th-card-name {
        position: relative;
        z-index: 4;
        flex: 0 0 auto;
        padding: 14px 12px 16px;
        text-align: center;
        background-image:
            linear-gradient(rgba(255, 255, 255, 0.88), rgba(255, 255, 255, 0.88)),
            url('{{ asset('image/bg-batik.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        border-top: 1px solid rgba(9, 67, 86, 0.06);
        border-radius: 0 0 6px 6px;
    }

    .th-card-name h3 {
        margin: 0;
        color: #094356;
        font-family: 'Sora', sans-serif;
        font-size: clamp(13px, 2vw, 16px);
        line-height: 1.25;
        font-weight: 800;
        word-break: break-word;
        position: relative;
        z-index: 1;
    }

    .th-card-name p {
        margin: 4px 0 0;
        color: #668087;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(10px, 1.5vw, 12.5px);
        line-height: 1.3;
        font-weight: 500;
        word-break: break-word;
        position: relative;
        z-index: 1;
    }

    .th-card::before,
    .th-card::after {
        display: none !important;
    }

    .th-card-photo .th-hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
        border-radius: 6px 6px 0 0;
    }

    .th-card:hover .th-card-photo .th-hover-overlay {
        opacity: 1;
    }

    .th-card .th-hover-overlay span {
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
        max-width: 1200px;
        margin: 0 auto;
    }
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    .gallery-grid img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 15px;
        transition: transform 0.4s ease, filter 0.4s ease;
        cursor: pointer;
    }
    .gallery-grid img:hover {
        transform: scale(1.03);
        z-index: 10;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    /* ===== MOBILE RESPONSIVE TWEAKS ===== */
    @media (max-width: 768px) {
        .about-content { 
            flex-direction: column; 
            padding: 30px 20px; 
            border-radius: 22px; 
            gap: 20px;
        }
        .about-header h1 { font-size: 2.2rem; }
        .page-wrapper { padding-top: 70px; }

        .about-section {
            padding: 20px 5%;
        }

        .about-text h2 {
            font-size: 2rem;
        }

        .about-text p {
            font-size: 0.95rem;
        }

        .about-image {
            width: 100%;
            flex: 0 0 auto;
            border-radius: 18px;
        }

        .about-image img {
            min-height: 250px;
            max-height: 300px;
        }
        
        .th-card-wrapper {
            padding: 30px 15px;
            border-radius: 20px;
            width: calc(100% - 10px);
        }
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

    .modal-content-wrapper {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        animation: zoomIn 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .modal-content {
        max-width: 100%;
        max-height: 80vh;
        border-radius: 12px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
        object-fit: contain;
    }

    .modal-caption {
        position: absolute;
        bottom: 25px;
        left: 50%;
        transform: translateX(-50%);
        color: #ffffff;
        font-family: var(--font-body, 'Poppins', sans-serif);
        font-size: 0.95rem;
        font-weight: 600;
        text-align: center;
        background: rgba(30, 36, 44, 0.85);
        padding: 8px 24px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        z-index: 10;
        pointer-events: none;
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #ffffff;
        font-size: 40px;
        font-weight: 300;
        cursor: pointer;
        z-index: 10000;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .close-modal:hover {
        color: #ff6b35;
        transform: scale(1.1);
    }

    .modal-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff; 
        border: none;
        font-size: 2.5rem;
        padding: 15px 20px;
        cursor: pointer;
        border-radius: 12px;
        z-index: 10001;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-nav-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
        transform: translateY(-50%) scale(1.1);
    }

    .prev-btn { left: 4%; }
    .next-btn { right: 4%; }

    @media (max-width: 768px) {
        .modal-nav-btn { font-size: 1.8rem; padding: 10px 15px; }
        .prev-btn { left: 2%; }
        .next-btn { right: 2%; }
        .modal-caption { bottom: 15px; font-size: 0.85rem; padding: 6px 18px; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    /* ===== Reveal on scroll ===== */
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
                document.documentElement.style.setProperty('--th-card-width', `${BASE_CARD_WIDTH * this.scale}px`);
                this.container.style.perspective = `${Math.max(600, BASE_PERSPECTIVE * this.scale)}px`;
                this.track.style.height = `${MAX_BASE_HEIGHT * this.scale}px`;
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
                    transform: 'translateZ(0) rotateY(0deg)',
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
                this.startX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                this.dragDistance = 0;
            }

            handleDragMove(e) {
                if (!this.isDragging) return;
                e.preventDefault();
                const currentX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
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

    /* ===== LIGHTBOX MODAL JS (Dengan Fitur Slide) ===== */
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("zoomedImage");
        const captionText = document.getElementById("modalCaption");
        const closeBtn = document.querySelector(".close-modal");
        const prevBtn = document.getElementById("modalPrev");
        const nextBtn = document.getElementById("modalNext");
        
        // Ambil semua gambar galeri jadikan array
        const images = Array.from(document.querySelectorAll(".gallery-item"));
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
            modalImg.src = img.src;
            
            let caption = img.getAttribute("data-caption");
            captionText.innerHTML = caption ? caption : "Galeri PT Astabrata Teknologi";
        }

        // Fungsi Tombol Prev & Next
        function showPrev(e) {
            if (e) e.stopPropagation();
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateModalContent();
        }

        function showNext(e) {
            if (e) e.stopPropagation();
            currentIndex = (currentIndex + 1) % images.length;
            updateModalContent();
        }

        // Pasang event klik di semua gambar
        images.forEach((img, index) => {
            img.addEventListener("click", () => openModal(index));
        });

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
@endpush
@endsection