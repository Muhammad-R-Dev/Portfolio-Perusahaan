@extends('layouts.app')

@section('title', 'Layanan - PT Astabrata Teknologi')

@section('content')
<div class="layanan-page">

    <!-- HERO SECTION: Background Slideshow dari Gambar Project/Layanan -->
    <header class="ly-hero">
        <div class="hero-slideshow" id="heroSlideshow">
            @foreach($services as $service)
                @if($service->image)
                    <div class="hero-slide" style="background-image: url('{{ $service->image_url }}');"></div>
                @endif
            @endforeach
            <div class="hero-slide" style="background-image: url('https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=1920&q=80');"></div>
        </div>
        
        <div class="hero-overlay"></div>
        
        <div class="ly-inner ly-hero-content">
            <h1>Kami yang membangun sistemnya, Anda fokus ke bisnisnya.</h1>
            <p>Dari website sederhana sampai aplikasi yang menjalankan operasional harian. Ceritakan kebutuhan Anda, kami bantu dari rancangan sampai sistem berjalan.</p>
            <div class="ly-hero-actions">
                <a class="ly-btn ly-btn--primary" href="https://wa.me/62882006644656" target="_blank" rel="noopener">
                    <i class="fa-brands fa-whatsapp"></i> Konsultasi via WhatsApp
                </a>
                <a class="ly-btn ly-btn--outline" href="#daftar-layanan">
                    Lihat Layanan
                </a>
            </div>
        </div>
    </header>

    <!-- SECTION LAYANAN -->
    <section class="ly-services" id="daftar-layanan">
        <div class="bg-particles" aria-hidden="true">
            <div id="particle-canvas"></div>
        </div>

        <div class="ly-inner" style="position: relative; z-index: 10;">
            <div class="ly-section-header text-center">
                <h2>Ekspertise Kami</h2>
                <p>Solusi teknologi yang dirancang khusus untuk mempercepat pertumbuhan bisnis Anda.</p>
            </div>

            <div class="ly-grid">
                @forelse($services as $service)
                <article class="ly-card">
                    <!-- GAMBAR BISA DIKLIK (Memicu Modal Popup) -->
                    <div class="ly-card-img-wrapper ly-btn-detail" role="button" tabindex="0"
                        data-title="{{ $service->title }}" 
                        data-desc="{{ $service->description }}" 
                        data-image="{{ $service->image ? $service->image_url : 'https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=800&q=60' }}"
                        data-wa="https://wa.me/62882006644656?text={{ rawurlencode('Halo, saya tertarik dengan layanan '.$service->title) }}">
                        
                        <!-- Overlay Animasi Mata Smooth -->
                        <div class="img-zoom-overlay">
                            <div class="zoom-icon-circle">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                        </div>
                        
                        @if($service->image)
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}" loading="lazy">
                        @else
                            <img src="https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=800&q=60" alt="Placeholder" loading="lazy">
                        @endif
                    </div>
                    
                    <div class="ly-card-content">
                        <h3>{{ $service->title }}</h3>
                        <p class="ly-card-desc">{{ $service->description }}</p>
                        
                        <!-- TOMBOL AKSI DI BAWAH KARTU -->
                        <div class="ly-card-actions">
                            <a href="https://wa.me/62882006644656?text={{ rawurlencode('Halo, saya tertarik dengan layanan '.$service->title) }}" class="ly-card-wa" target="_blank" rel="noopener">
                                <i class="fa-brands fa-whatsapp"></i> Tanya via WA
                            </a>
                            
                            <button type="button" class="ly-card-detail ly-btn-detail" 
                                data-title="{{ $service->title }}" 
                                data-desc="{{ $service->description }}" 
                                data-image="{{ $service->image ? $service->image_url : 'https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=800&q=60' }}"
                                data-wa="https://wa.me/62882006644656?text={{ rawurlencode('Halo, saya tertarik dengan layanan '.$service->title) }}">
                                Detail <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </div>
                </article>
                @empty
                <div class="ly-empty">
                    <i class="fa-solid fa-box-open"></i>
                    <p>Belum ada layanan yang ditambahkan. Silakan kelola melalui dashboard admin.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SECTION CARA KERJA -->
    <section class="ly-process">
        <div class="ly-inner">
            <div class="ly-section-header text-center">
                <h2>Cara Kerja Kami</h2>
                <p>Proses terstruktur untuk memastikan hasil yang tepat waktu dan sesuai target.</p>
            </div>
            
            <ol class="ly-steps">
                <li>
                    <div class="ly-step-icon">1</div>
                    <h3>Diskusi Kebutuhan</h3>
                    <p>Kami dengar masalah dan target Anda. Konsultasi awal sepenuhnya gratis.</p>
                </li>
                <li>
                    <div class="ly-step-icon">2</div>
                    <h3>Rancangan & Penawaran</h3>
                    <p>Anda menerima rancangan teknis, jadwal, dan transparansi biaya sebelum kami mulai.</p>
                </li>
                <li>
                    <span class="ly-step-icon">3</span>
                    <h3>Pengembangan Sistem</h3>
                    <p>Pengerjaan dilakukan secara bertahap dengan laporan progres secara berkala.</p>
                </li>
                <li>
                    <span class="ly-step-icon">4</span>
                    <h3>Rilis & Dukungan</h3>
                    <p>Setelah sistem berjalan, kami siap sedia mendampingi jika terjadi kendala teknis.</p>
                </li>
            </ol>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- MODAL POPUP PREVIEW (Disembunyikan di awal) -->
    <!-- ========================================== -->
    <div class="ly-modal-overlay" id="serviceModal">
        <div class="ly-modal-box">
            <button class="ly-modal-close" id="closeModal" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="ly-modal-img-wrap">
                <img id="modalImage" src="" alt="Layanan Preview">
            </div>
            
            <div class="ly-modal-body">
                <h3 id="modalTitle">Judul Layanan</h3>
                <div class="ly-modal-desc" id="modalDesc">
                    Deskripsi lengkap layanan...
                </div>
                
                <div class="ly-modal-footer">
                    <a href="#" id="modalWaBtn" class="ly-btn ly-btn--primary" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i> Diskusikan Proyek Ini
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    /* ===== VARIABEL GLOBAL ===== */
    .layanan-page {
        --color-brand: #094356;
        --color-brand-light: #106682;
        --color-surface: #FFFFFF;
        --color-bg-light: #EDEEF0;
        --color-text-main: #0F172A;
        --color-text-muted: #64748B;
        --color-border: #E2E8F0;
        
        font-family: 'Inter', system-ui, sans-serif;
        background: var(--color-surface);
        color: var(--color-text-main);
        overflow-x: hidden;
    }

    h1, h2, h3, h4 { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; color: var(--color-text-main); }
    p { margin: 0; }
    a { text-decoration: none; }
    
    .ly-inner { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .text-center { text-align: center; }

    /* ===== HERO SECTION ===== */
    .ly-hero { position: relative; padding: 160px 0 100px; overflow: hidden; background-color: var(--color-brand); }
    .hero-slideshow { position: absolute; inset: 0; z-index: 0; }
    .hero-slide { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transition: opacity 1.5s ease-in-out; }
    .hero-slide.active { opacity: 1; }
    .hero-overlay { position: absolute; inset: 0; z-index: 1; background: linear-gradient(180deg, rgba(9, 67, 86, 0.85) 0%, rgba(9, 67, 86, 0.95) 100%); }
    .ly-hero-content { position: relative; z-index: 2; text-align: center; display: flex; flex-direction: column; align-items: center; }
    .ly-hero h1 { font-size: clamp(2.5rem, 5vw, 3.8rem); font-weight: 800; line-height: 1.15; letter-spacing: -0.02em; color: #FFFFFF; max-width: 900px; margin-bottom: 24px; }
    .ly-hero p { font-size: 1.125rem; line-height: 1.6; color: rgba(255, 255, 255, 0.85); max-width: 600px; margin-bottom: 40px; }
    .ly-hero-actions { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
    .ly-btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 50px; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; cursor: pointer; border: none; }
    .ly-btn--primary { background: #FFFFFF; color: var(--color-brand); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); }
    .ly-btn--primary:hover { background: #F1F5F9; transform: translateY(-2px); }
    .ly-btn--outline { background: transparent; color: #FFFFFF; border: 1px solid rgba(255, 255, 255, 0.4); }
    .ly-btn--outline:hover { background: rgba(255, 255, 255, 0.1); border-color: #FFFFFF; }

    /* ===== SERVICES GRID ===== */
    .ly-section-header { margin-bottom: 56px; position: relative; z-index: 10; }
    .ly-section-header h2 { font-size: clamp(2rem, 3vw, 2.5rem); font-weight: 700; letter-spacing: -0.02em; margin-bottom: 16px; }
    .ly-section-header p { font-size: 1.1rem; color: var(--color-text-muted); }

    .ly-services { position: relative; background: var(--color-bg-light); padding: 100px 0; overflow: hidden; }
    .bg-particles {
        position: absolute; inset: 0; z-index: 0; pointer-events: none;
        -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,0) 0%, #000 15%, #000 85%, rgba(0,0,0,0) 100%);
        mask-image: linear-gradient(to bottom, rgba(0,0,0,0) 0%, #000 15%, #000 85%, rgba(0,0,0,0) 100%);
    }
    .bg-particles #particle-canvas { width: 100%; height: 100%; }
    .bg-particles canvas { display: block; }

    .ly-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 32px; }

    .ly-card {
        background: rgba(255, 255, 255, 0.6); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.8); border-radius: 24px; padding: 20px;
        display: flex; flex-direction: column; box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04);
        transition: transform 0.4s ease, box-shadow 0.4s ease, background 0.4s ease;
    }
    .ly-card:hover {
        transform: translateY(-8px); box-shadow: 0 20px 40px -10px rgba(9, 67, 86, 0.15);
        background: rgba(255, 255, 255, 0.9); border-color: rgba(9, 67, 86, 0.15);
    }
    
    /* MODIFIKASI GAMBAR & ANIMASI MATA (ZOOM) */
    .ly-card-img-wrapper {
        background: rgba(255, 255, 255, 0.5); border-radius: 16px; height: 220px;
        display: flex; align-items: center; justify-content: center; padding: 24px; margin-bottom: 24px; 
        overflow: hidden; position: relative; cursor: pointer;
    }
    
    /* Overlay Kaca Buram Netral (Bukan Hijau) */
    .img-zoom-overlay {
        position: absolute; inset: 0; 
        background: rgba(15, 23, 42, 0.35); /* Warna biru gelap sangat netral / elegan */
        backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: all 0.4s ease; z-index: 5;
    }
    
    /* Lingkaran Putih untuk Ikon Mata */
    .zoom-icon-circle {
        width: 64px; height: 64px; border-radius: 50%;
        background: #ffffff; color: var(--color-brand);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        /* Animasi Bouncy (Memantul dari bawah) */
        transform: translateY(30px) scale(0.5);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); 
    }

    .ly-card-img-wrapper:hover .img-zoom-overlay { opacity: 1; }
    .ly-card-img-wrapper:hover .zoom-icon-circle {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
    
    .ly-card-img-wrapper img { width: 100%; height: 100%; object-fit: contain; transition: transform 0.6s ease; position: relative; z-index: 2; }
    .ly-card:hover .ly-card-img-wrapper img { transform: scale(1.05); }

    .ly-card-content { display: flex; flex-direction: column; flex: 1; padding: 0 8px 12px; }
    .ly-card-content h3 { font-size: 1.35rem; font-weight: 700; margin-bottom: 12px; }
    .ly-card-desc {
        color: var(--color-text-muted); font-family: 'Poppins', sans-serif; font-size: 0.95rem; line-height: 1.6; margin-bottom: 24px;
        display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; flex: 1;
    }
    
    .ly-card-actions {
        margin-top: auto; display: flex; align-items: center; justify-content: space-between;
        padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.06);
    }
    .ly-card-wa {
        display: inline-flex; align-items: center; gap: 6px;
        color: #128C7E; font-weight: 600; font-size: 0.9rem; transition: color 0.2s, transform 0.2s;
    }
    .ly-card-wa i { font-size: 1.15rem; color: #25D366; }
    .ly-card-wa:hover { color: #075E54; transform: scale(1.03); }
    
    .ly-card-detail {
        display: inline-flex; align-items: center; gap: 6px; color: var(--color-brand); font-weight: 600; font-size: 0.9rem;
        background: none; border: none; padding: 0; cursor: pointer; transition: gap 0.3s, color 0.3s; font-family: inherit;
    }
    .ly-card-detail i { transition: transform 0.3s; }
    .ly-card-detail:hover { gap: 10px; color: var(--color-brand-light); }

    .ly-empty { grid-column: 1 / -1; text-align: center; padding: 60px 0; color: var(--color-text-muted); }
    .ly-empty i { font-size: 3rem; margin-bottom: 16px; opacity: 0.5; }

    /* ===== PROCESS SECTION ===== */
    .ly-process { padding: 100px 0; background: var(--color-surface); }
    .ly-steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px; list-style: none; padding: 0; margin: 0; }
    .ly-steps li { position: relative; }
    .ly-steps li:not(:last-child)::after { content: ''; position: absolute; top: 24px; left: 60px; right: -20px; border-top: 2px dashed var(--color-border); }
    .ly-step-icon {
        width: 48px; height: 48px; background: var(--color-brand); color: #FFF; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; position: relative; z-index: 2;
    }
    .ly-steps h3 { font-size: 1.15rem; margin-bottom: 12px; }
    .ly-steps p { font-family: 'Poppins', sans-serif; font-size: 0.92rem; color: var(--color-text-muted); line-height: 1.6; }

    /* ===== MODAL POPUP (PREVIEW LAYANAN) ===== */
    .ly-modal-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        padding: 20px; opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .ly-modal-overlay.active { opacity: 1; visibility: visible; }
    
    .ly-modal-box {
        background: var(--color-surface); width: 100%; max-width: 650px; max-height: 90vh;
        border-radius: 24px; overflow-y: auto; position: relative;
        transform: translateY(30px) scale(0.95); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .ly-modal-overlay.active .ly-modal-box { transform: translateY(0) scale(1); }
    
    .ly-modal-close {
        position: absolute; top: 16px; right: 16px; z-index: 10;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(0,0,0,0.1); border: none; color: var(--color-text-main);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background 0.2s; font-size: 1.1rem;
    }
    .ly-modal-close:hover { background: rgba(0,0,0,0.2); }
    
    .ly-modal-img-wrap {
        width: 100%; height: 260px; background: var(--color-bg-light);
        display: flex; align-items: center; justify-content: center; padding: 32px;
    }
    .ly-modal-img-wrap img { max-width: 100%; max-height: 100%; object-fit: contain; }
    
    .ly-modal-body { padding: 32px; }
    .ly-modal-body h3 { font-size: 1.7rem; margin-bottom: 16px; color: var(--color-brand); }
    .ly-modal-desc { 
        font-size: 1rem; line-height: 1.7; color: var(--color-text-muted); 
        margin-bottom: 32px; white-space: pre-wrap; font-family: 'Poppins', sans-serif;
    }
    .ly-modal-footer { display: flex; justify-content: flex-end; padding-top: 24px; border-top: 1px solid var(--color-border); }


    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
        .ly-steps { grid-template-columns: repeat(2, 1fr); gap: 40px 32px; }
        .ly-steps li:nth-child(2)::after { display: none; }
        .ly-steps li:nth-child(1)::after, .ly-steps li:nth-child(3)::after { right: -16px; }
    }
    @media (max-width: 768px) {
        .ly-hero { padding: 120px 0 80px; }
        .ly-hero h1 { font-size: 2.2rem; }
        .ly-grid { grid-template-columns: 1fr; }
        .ly-steps { grid-template-columns: 1fr; gap: 40px; }
        .ly-steps li::after { display: none; }
        .ly-modal-body { padding: 24px; }
    }

    /* ===== DARK MODE ===== */
    html[data-theme="dark"] .layanan-page {
        --color-surface: #0F172A;
        --color-bg-light: #0B1120;
        --color-text-main: #F8FAFC;
        --color-text-muted: #94A3B8;
        --color-border: #1E293B;
    }
    html[data-theme="dark"] .hero-overlay { background: linear-gradient(180deg, rgba(2, 6, 23, 0.85) 0%, rgba(15, 23, 42, 0.95) 100%); }
    html[data-theme="dark"] .ly-btn--outline { border-color: rgba(255,255,255,0.15); }
    
    html[data-theme="dark"] .ly-card { background: rgba(30, 41, 59, 0.45); border-color: rgba(255,255,255,0.05); }
    html[data-theme="dark"] .ly-card:hover { background: rgba(30, 41, 59, 0.8); border-color: rgba(255,255,255,0.15); box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5); }
    html[data-theme="dark"] .ly-card-img-wrapper { background: rgba(15, 23, 42, 0.5); }
    html[data-theme="dark"] .ly-card-actions { border-top-color: rgba(255,255,255,0.05); }
    html[data-theme="dark"] .ly-card-detail { color: #38BDF8; }
    html[data-theme="dark"] .ly-card-detail:hover { color: #bae6fd; }
    html[data-theme="dark"] .ly-card-wa { color: #25D366; }
    html[data-theme="dark"] .ly-card-wa:hover { color: #128C7E; }
    
    /* Dark Mode: Overlay Ikon Mata */
    html[data-theme="dark"] .img-zoom-overlay { background: rgba(15, 23, 42, 0.6); }
    html[data-theme="dark"] .zoom-icon-circle { background: #1E293B; color: #38BDF8; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
    
    html[data-theme="dark"] .ly-step-icon { background: #38BDF8; color: #0F172A; }
    
    /* Dark Mode Modal */
    html[data-theme="dark"] .ly-modal-box { background: #1E293B; border: 1px solid #334155; }
    html[data-theme="dark"] .ly-modal-close { background: rgba(255,255,255,0.1); color: #F8FAFC; }
    html[data-theme="dark"] .ly-modal-close:hover { background: rgba(255,255,255,0.2); }
    html[data-theme="dark"] .ly-modal-img-wrap { background: #0F172A; }
    html[data-theme="dark"] .ly-modal-body h3 { color: #38BDF8; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        /* ===== 1. SLIDESHOW HERO ===== */
        const slides = document.querySelectorAll('#heroSlideshow .hero-slide');
        if (slides.length > 0) {
            slides[0].classList.add('active');
            if (slides.length > 1) {
                let currentSlide = 0;
                setInterval(() => {
                    slides[currentSlide].classList.remove('active');
                    currentSlide = (currentSlide + 1) % slides.length;
                    slides[currentSlide].classList.add('active');
                }, 4000); 
            }
        }

        /* ===== 2. LOGIKA MODAL POPUP ===== */
        const modal = document.getElementById('serviceModal');
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalWa = document.getElementById('modalWaBtn');
        const closeBtn = document.getElementById('closeModal');
        
        // Memilih tombol Detail DAN area gambar untuk memicu popup
        const detailTriggers = document.querySelectorAll('.ly-btn-detail');

        detailTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                modalTitle.textContent = trigger.dataset.title;
                modalDesc.textContent = trigger.dataset.desc;
                modalImg.src = trigger.dataset.image;
                modalWa.href = trigger.dataset.wa;
                
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });

        // Fungsi tutup modal
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = ''; 
        };

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) closeModal();
        });

        /* ===== 3. ANIMASI PARTIKEL NETWORK ===== */
        !function(a){var b="object"==typeof self&&self.self===self&&self||"object"==typeof global&&global.global===global&&global;"function"==typeof define&&define.amd?define(["exports"],function(c){b.ParticleNetwork=a(b,c)}):"object"==typeof module&&module.exports?module.exports=a(b,{}):b.ParticleNetwork=a(b,{})}(function(a,b){var c=function(a){this.canvas=a.canvas,this.g=a.g,this.particleColor=a.options.particleColor,this.x=Math.random()*this.canvas.width,this.y=Math.random()*this.canvas.height,this.velocity={x:(Math.random()-.5)*a.options.velocity,y:(Math.random()-.5)*a.options.velocity}};return c.prototype.update=function(){(this.x>this.canvas.width+20||this.x<-20)&&(this.velocity.x=-this.velocity.x),(this.y>this.canvas.height+20||this.y<-20)&&(this.velocity.y=-this.velocity.y),this.x+=this.velocity.x,this.y+=this.velocity.y},c.prototype.h=function(){this.g.beginPath(),this.g.fillStyle=this.particleColor,this.g.globalAlpha=.7,this.g.arc(this.x,this.y,1.5,0,2*Math.PI),this.g.fill()},b=function(a,b){this.i=a,this.i.size={width:this.i.offsetWidth,height:this.i.offsetHeight},b=void 0!==b?b:{},this.options={particleColor:void 0!==b.particleColor?b.particleColor:"#fff",background:void 0!==b.background?b.background:"#1a252f",interactive:void 0!==b.interactive?b.interactive:!0,velocity:this.setVelocity(b.speed),density:this.j(b.density)},this.init()},b.prototype.init=function(){if(this.k=document.createElement("div"),this.i.appendChild(this.k),this.l(this.k,{position:"absolute",top:0,left:0,bottom:0,right:0,"z-index":1}),/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.background))this.l(this.k,{background:this.options.background});else{if(!/\.(gif|jpg|jpeg|tiff|png)$/i.test(this.options.background))return console.error("Please specify a valid background image or hexadecimal color"),!1;this.l(this.k,{background:'url("'+this.options.background+'") no-repeat center',"background-size":"cover"})}if(!/(^#[0-9A-F]{6}$)|(^#[0-9A-F]{3}$)/i.test(this.options.particleColor))return console.error("Please specify a valid particleColor hexadecimal color"),!1;this.canvas=document.createElement("canvas"),this.i.appendChild(this.canvas),this.g=this.canvas.getContext("2d"),this.canvas.width=this.i.size.width,this.canvas.height=this.i.size.height,this.l(this.i,{position:"relative"}),this.l(this.canvas,{"z-index":"20",position:"relative"}),window.addEventListener("resize",function(){return this.i.offsetWidth===this.i.size.width&&this.i.offsetHeight===this.i.size.height?!1:(this.canvas.width=this.i.size.width=this.i.offsetWidth,this.canvas.height=this.i.size.height=this.i.offsetHeight,clearTimeout(this.m),void(this.m=setTimeout(function(){this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&this.o.push(this.p),requestAnimationFrame(this.update.bind(this))}.bind(this),500)))}.bind(this)),this.o=[];for(var a=0;a<this.canvas.width*this.canvas.height/this.options.density;a++)this.o.push(new c(this));this.options.interactive&&(this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p),this.canvas.addEventListener("mousemove",function(a){this.p.x=a.clientX-this.canvas.offsetLeft,this.p.y=a.clientY-this.canvas.offsetTop}.bind(this)),this.canvas.addEventListener("mouseup",function(a){this.p.velocity={x:(Math.random()-.5)*this.options.velocity,y:(Math.random()-.5)*this.options.velocity},this.p=new c(this),this.p.velocity={x:0,y:0},this.o.push(this.p)}.bind(this))),requestAnimationFrame(this.update.bind(this))},b.prototype.update=function(){this.g.clearRect(0,0,this.canvas.width,this.canvas.height),this.g.globalAlpha=1;for(var a=0;a<this.o.length;a++){this.o[a].update(),this.o[a].h();for(var b=this.o.length-1;b>a;b--){var c=Math.sqrt(Math.pow(this.o[a].x-this.o[b].x,2)+Math.pow(this.o[a].y-this.o[b].y,2));c>120||(this.g.beginPath(),this.g.strokeStyle=this.options.particleColor,this.g.globalAlpha=(120-c)/120,this.g.lineWidth=.7,this.g.moveTo(this.o[a].x,this.o[a].y),this.g.lineTo(this.o[b].x,this.o[b].y),this.g.stroke())}}0!==this.options.velocity&&requestAnimationFrame(this.update.bind(this))},b.prototype.setVelocity=function(a){return"fast"===a?1:"slow"===a?.33:"none"===a?0:.66},b.prototype.j=function(a){return"high"===a?5e3:"low"===a?2e4:isNaN(parseInt(a,10))?1e4:a},b.prototype.l=function(a,b){for(var c in b)a.style[c]=b[c]},b});

        const canvasDiv = document.getElementById('particle-canvas');
        if (canvasDiv && typeof ParticleNetwork !== 'undefined') {
            const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            new ParticleNetwork(canvasDiv, {
                particleColor: '#094356', 
                background: 'transparent',
                interactive: true,
                speed: reduceMotion ? 'none' : 'medium',
                density: 'high'
            });
        }
    });
</script>
@endpush