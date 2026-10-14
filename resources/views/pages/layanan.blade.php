@extends('layouts.app')

@section('title', 'Layanan - PT Astabrata Teknologi')

@section('content')
<div class="layanan-page">

    @php
        // Judul, deskripsi, & warna bagian "Pilih Layanan Yang Anda Butuhkan" (diatur dari Admin > Pengaturan Halaman > Layanan)
        $pageSetting = $pageSetting ?? \App\Models\PageSetting::for('layanan');

        // Nomor WhatsApp tujuan: sama dengan halaman Contact (SiteSetting->wa_number, format internasional tanpa "+")
        $siteSetting = $siteSetting ?? \App\Models\SiteSetting::first();
        $waNumber = !empty($siteSetting->wa_number)
            ? '62' . ltrim(preg_replace('/\D/', '', $siteSetting->wa_number), '0')
            : '6287762166795'; // fallback nomor lama bila belum diisi

        $exPlaceholder = 'https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=1200&q=70';
        $slides = [];
        foreach ($services as $service) {
            $slides[] = [
                'title' => $service->title,
                'desc'  => $service->description,
                'image' => $service->image ? $service->image_url : $exPlaceholder,
                'wa'    => 'https://wa.me/' . $waNumber . '?text=' . rawurlencode('Halo, saya tertarik dengan layanan ' . $service->title),
            ];
        }
    @endphp

    <!-- ========================================== -->
    <!-- GRID CARD LAYANAN -->
    <!-- ========================================== -->
    <section class="ly-services" id="daftar-layanan">
        <!-- Background Aurora (pure CSS, tanpa teks) -->
        <div class="ly-aurora-bg" aria-hidden="true">
            <div class="ly-aurora"></div>
        </div>

        <div class="ly-inner">
            <div class="ly-section-head">
                <h2>{{ $pageSetting->titleText() }}</h2>
                <p>{{ $pageSetting->descriptionText() }}</p>
            </div>

            <div class="ly-grid" id="lyGrid">
                @forelse($slides as $slide)
                    <div class="ly-card" data-index="{{ $loop->index }}">
                        <div class="ly-card-img-wrapper">
                            <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" loading="lazy">
                        </div>

                        <div class="ly-card-content">
                            <h3>{{ $slide['title'] }}</h3>
                            <p class="ly-card-desc">{{ $slide['desc'] }}</p>

                            <div class="ly-card-actions">
                                <a href="{{ $slide['wa'] }}" class="ly-card-wa" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <span>Konsultasi</span>
                                </a>
                                <button type="button"
                                        class="ly-card-detail ly-btn-detail"
                                        data-title="{{ $slide['title'] }}"
                                        data-desc="{{ $slide['desc'] }}"
                                        data-image="{{ $slide['image'] }}"
                                        data-wa="{{ $slide['wa'] }}">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ly-empty">
                        <i class="fa-solid fa-box-open"></i>
                        <p>Belum ada layanan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Keterangan nomor card, hanya tampil & aktif di versi mobile (scroll ke samping) --}}
            @if(count($slides) > 1)
                <div class="ly-grid-nav" id="lyGridNav" role="tablist" aria-label="Pilih layanan">
                    @foreach($slides as $slide)
                        <button type="button"
                                class="ly-grid-dot @if($loop->first) is-active @endif"
                                data-index="{{ $loop->index }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                aria-label="Layanan nomor {{ $loop->iteration }}: {{ $slide['title'] }}">
                            {{ $loop->iteration }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- ========================================== -->
    <!-- MODAL POPUP DETAIL LAYANAN (disembunyikan di awal) -->
    <!-- ========================================== -->
    <div class="ly-modal-overlay" id="serviceModal">
        <div class="ly-modal-box" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <button class="ly-modal-close" id="closeModal" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>

            <div class="ly-modal-img-wrap">
                <img id="modalImage" src="" alt="Foto layanan">
            </div>

            <div class="ly-modal-body">
                <h3 id="modalTitle">Judul Layanan</h3>
                <div class="ly-modal-divider"></div>
                <div class="ly-modal-desc" id="modalDesc">
                    Deskripsi lengkap layanan...
                </div>

                <div class="ly-modal-footer">
                    <a href="#" id="modalWaBtn" class="ly-modal-wa" target="_blank" rel="noopener">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>Hubungi via WhatsApp</span>
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
<link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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

        font-family: 'Google Sans Flex', 'Inter', system-ui, sans-serif;
        background: var(--color-surface);
        color: var(--color-text-main);
        overflow-x: hidden;
    }

    h1, h2, h3, h4 { font-family: 'Google Sans Flex', 'Plus Jakarta Sans', sans-serif; margin: 0; color: var(--color-text-main); }
    p { margin: 0; }
    a { text-decoration: none; }

    .ly-inner { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 1; }
    .text-center { text-align: center; }

    /* ===== SERVICES GRID ===== */

    .ly-services {
        position: relative;
        padding: 72px 0 90px;
        background: var(--color-bg-light);
        overflow: hidden;
        isolation: isolate;
    }

    @media (max-width: 768px) {
        /* Beri ruang dari navbar fixed agar judul tidak tertutup */
        .ly-services { padding: 76px 0 56px; }
    }

    /* ===== BACKGROUND AURORA (pure CSS, tanpa teks, adaptasi dari CSS Aurora Boreal) ===== */
    .ly-aurora-bg {
        position: absolute;
        inset: 0;
        overflow: hidden;
        z-index: 0;
        pointer-events: none;
    }

    .ly-aurora {
        --stripes: repeating-linear-gradient(
            100deg,
            #fff 0%,
            #fff 7%,
            transparent 10%,
            transparent 12%,
            #fff 16%
        );
        --stripesDark: repeating-linear-gradient(
            100deg,
            #000 0%,
            #000 7%,
            transparent 10%,
            transparent 12%,
            #000 16%
        );
        --rainbow: repeating-linear-gradient(
            100deg,
            #60a5fa 10%,
            #e879f9 15%,
            #60a5fa 20%,
            #5eead4 25%,
            #60a5fa 30%
        );

        position: absolute;
        inset: -10px;
        opacity: 0.5;

        background-image: var(--stripes), var(--rainbow);
        background-size: 300%, 200%;
        background-position: 50% 50%, 50% 50%;

        filter: blur(10px) invert(100%);

        mask-image: radial-gradient(ellipse at 100% 0%, black 40%, transparent 70%);
        -webkit-mask-image: radial-gradient(ellipse at 100% 0%, black 40%, transparent 70%);

        pointer-events: none;
    }

    .ly-aurora::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: var(--stripes), var(--rainbow);
        background-size: 200%, 100%;
        animation: ly-aurora-shift 60s linear infinite;
        background-attachment: fixed;
        mix-blend-mode: difference;
    }

    @keyframes ly-aurora-shift {
        from {
            background-position: 50% 50%, 50% 50%;
        }
        to {
            background-position: 350% 50%, 350% 50%;
        }
    }

    /* Mode terang/gelap mengikuti atribut data-theme yang sudah dipakai halaman ini */
    html[data-theme="dark"] .ly-aurora {
        background-image: var(--stripesDark), var(--rainbow);
        filter: blur(10px) opacity(50%) saturate(200%);
    }
    html[data-theme="dark"] .ly-aurora::after {
        background-image: var(--stripesDark), var(--rainbow);
    }

    /* Hormati preferensi pengguna yang mengurangi gerakan */
    @media (prefers-reduced-motion: reduce) {
        .ly-aurora::after { animation: none; }
    }


    .ly-section-head {
        text-align: center; max-width: 620px; margin: 28px auto 56px;
        display: flex; flex-direction: column; align-items: center;
    }
    .ly-section-head h2 { font-size: clamp(1.8rem, 3.2vw, 2.4rem); font-weight: 800; letter-spacing: -0.01em; margin-bottom: 14px; text-align: center; }
    .ly-section-head p { font-family: 'Google Sans Flex', 'Poppins', sans-serif; font-size: 1rem; line-height: 1.7; color: var(--color-text-muted); text-align: center; }

    .ly-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 28px; }

    /* ===== CARD: foto full-bleed, sudut sedikit lancip tapi tetap melengkung ===== */
    .ly-card {
        background: var(--color-surface);
        border: 1px solid var(--color-border);
        border-radius: 14px;
        overflow: hidden;
        display: flex; flex-direction: column;
        box-shadow: 0 2px 10px -4px rgba(15, 23, 42, 0.08);
        cursor: pointer;
        will-change: transform;
        transition: transform 0.45s cubic-bezier(0.22, 1, 0.36, 1),
                    box-shadow 0.45s cubic-bezier(0.22, 1, 0.36, 1),
                    border-color 0.45s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .ly-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 40px -14px rgba(9, 67, 86, 0.28);
        border-color: rgba(9, 67, 86, 0.2);
    }
    .ly-card:active {
        transform: translateY(-4px);
        transition-duration: 0.15s;
    }

    .ly-card-img-wrapper {
        position: relative; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; cursor: pointer; background: var(--color-bg-light);
    }
    .ly-card-img-wrapper img {
        width: 100%; height: 100%; object-fit: cover; display: block;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }
    .ly-card:hover .ly-card-img-wrapper img { transform: scale(1.06); }

    .ly-card-content { display: flex; flex-direction: column; flex: 1; padding: 22px; }

    /* Judul & deskripsi diberi jarak ekstra dari atas agar posisinya sedikit turun di dalam card */
    .ly-card-content h3 {
        font-size: clamp(1rem, 0.85rem + 0.9vw, 1.25rem);
        font-weight: 700;
        margin-top: 10px;
        margin-bottom: 10px;
        line-height: 1.35;
    }
    .ly-card-desc {
        color: var(--color-text-muted); font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: clamp(0.82rem, 0.74rem + 0.4vw, 0.92rem);
        line-height: 1.6; margin-bottom: 20px;
        display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3; overflow: hidden; flex: 1;
    }

    .ly-card-actions {
        margin-top: auto; display: flex; align-items: center; justify-content: space-between;
        padding-top: 16px; border-top: 1px solid var(--color-border);
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

    @media (max-width: 768px) {
        .ly-services {
            padding: 76px 0 56px;
            overflow-x: hidden;
        }

        /* Beri jarak kiri-kanan dari tepi layar (gutter) */
        .ly-inner {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0 18px;
            box-sizing: border-box;
        }

        .ly-section-head {
            width: 100%;
            max-width: none;
            margin: 10px 0 26px;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
            align-items: center;
        }

        .ly-section-head h2,
        .ly-section-head p {
            width: 100%;
            max-width: none;
            margin-left: 0;
            margin-right: 0;
            box-sizing: border-box;
            overflow-wrap: anywhere;
        }

        .ly-section-head h2 {
            margin-top: 6px;
            margin-bottom: 10px;
            font-size: 1.32rem;
            line-height: 1.35;
            text-align: center;
        }

        .ly-section-head p {
            font-size: 0.86rem;
            line-height: 1.6;
            text-align: center;
        }

        /* Grid jadi baris yang bisa digeser ke kanan/kiri (1 card per layar, peek sedikit) */
        .ly-grid {
            display: flex;
            flex-wrap: nowrap;
            align-items: stretch;
            gap: 16px;
            width: 100%;
            max-width: none;
            margin: 0 -18px;
            padding: 4px 18px 10px;
            box-sizing: border-box;
            overflow-x: auto;
            overflow-y: hidden;
            overscroll-behavior-x: contain;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            touch-action: pan-x;
            -webkit-user-select: none;
            user-select: none;
            scrollbar-width: none;
        }

        .ly-grid::-webkit-scrollbar { display: none; }

        .ly-card {
            flex: 0 0 86%;
            width: 86%;
            min-width: 0;
            max-width: 360px;
            margin: 0;
            border-radius: 12px;
            box-sizing: border-box;
            scroll-snap-align: center;
            scroll-snap-stop: always;
        }

        /* Gambar dipersingkat sedikit supaya card terasa lebih kecil/ringkas */
        .ly-card-img-wrapper {
            aspect-ratio: 16 / 10;
        }

        .ly-card-content {
            padding: 14px;
            min-width: 0;
        }

        .ly-card-content h3 {
            margin-top: 14px;
            overflow-wrap: anywhere;
        }

        .ly-card-desc {
            margin-bottom: 12px;
            overflow-wrap: anywhere;
            word-break: normal;
            -webkit-line-clamp: 2;
        }

        .ly-card-actions {
            padding-top: 12px;
        }

        /* ===== Keterangan nomor card (indikator di bawah grid) ===== */
        .ly-grid-nav {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 18px auto 0;
            max-width: 100%;
        }

        /* Mode terang: lingkaran hitam, tulisan putih. Mode gelap: kebalikannya (diatur di blok dark mode). */
        .ly-grid-dot {
            flex: 0 0 auto;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #000000;
            background: #000000;
            color: #FFFFFF;
            font-family: 'Google Sans Flex', 'Inter', system-ui, sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            opacity: 0.45;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        .ly-grid-dot:hover {
            opacity: 0.7;
        }

        .ly-grid-dot.is-active {
            opacity: 1;
            transform: scale(1.1);
        }
    }

    /* Nomor indikator hanya untuk mobile; di layar lebar grid-nya grid biasa, jadi sembunyikan */
    @media (min-width: 769px) {
        .ly-grid-nav { display: none; }
    }
    /* ===== POPUP DETAIL LAYANAN (modal dipindah ke <body> oleh JS, jadi variabel warna didefinisikan di sini) ===== */
    .ly-modal-overlay {
        position: fixed; inset: 0; z-index: 99999;
        --color-surface: #FFFFFF; --color-bg-light: #EDEEF0; --color-text-main: #0F172A;
        --color-text-muted: #64748B; --color-border: #E2E8F0;
        --color-brand: #094356; --color-brand-light: #106682;
        background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
        display: flex; align-items: center; justify-content: center;
        padding: 20px; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .ly-modal-overlay.active { opacity: 1; visibility: visible; }
    html[data-theme="dark"] .ly-modal-overlay {
        --color-surface: #1E293B; --color-bg-light: #0F172A; --color-text-main: #F8FAFC;
        --color-text-muted: #94A3B8; --color-border: #334155;
        --color-brand: #38BDF8; --color-brand-light: #7DD3FC;
    }

    .ly-modal-box, .ly-modal-box * { box-sizing: border-box; }
    .ly-modal-box {
        background: var(--color-surface); width: 100%; max-width: 560px; max-height: 90vh;
        border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; position: relative;
        border: 1px solid var(--color-border);
        box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.35);
        transform: translateY(24px) scale(0.96); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ly-modal-overlay.active .ly-modal-box { transform: none; }

    .ly-modal-close {
        position: absolute; top: 14px; right: 14px; z-index: 10;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(255, 255, 255, 0.92); border: none; color: #0F172A;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background 0.2s, transform 0.2s; font-size: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .ly-modal-close:hover { background: #FFFFFF; transform: rotate(90deg); }

    .ly-modal-img-wrap { position: relative; flex: none; height: 240px; background: var(--color-bg-light); overflow: hidden; }
    .ly-modal-img-wrap::after {
        content: ""; position: absolute; inset: 0; pointer-events: none;
        background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.25));
    }
    .ly-modal-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .ly-modal-body { padding: 28px 32px; overflow-y: auto; overflow-x: hidden; flex: 1 1 auto; min-height: 0; -webkit-overflow-scrolling: touch; }
    .ly-modal-tag {
        display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--color-brand-light); background: rgba(16, 102, 130, 0.1); padding: 5px 12px; border-radius: 99px; margin-bottom: 12px;
    }
    .ly-modal-body h3 {
        font-family: 'Google Sans Flex', 'Inter', system-ui, sans-serif; font-size: 1.5rem; font-weight: 600; letter-spacing: -0.01em; line-height: 1.3;
        color: var(--color-brand); margin: 0 0 14px;
    }
    .ly-modal-divider { width: 44px; height: 3px; border-radius: 3px; background: var(--color-brand-light); margin-bottom: 18px; }
    .ly-modal-desc {
        font-family: 'Google Sans Flex', 'Inter', system-ui, sans-serif; font-size: 0.95rem; line-height: 1.7; color: var(--color-text-muted);
        white-space: pre-wrap; word-break: break-word; margin-bottom: 28px;
    }
    .ly-modal-footer { padding-top: 22px; border-top: 1px solid var(--color-border); }
    .ly-modal-wa {
        display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; box-sizing: border-box;
        padding: 15px 24px; border-radius: 12px; background: #25D366; color: #FFFFFF;
        font-family: 'Google Sans Flex', 'Inter', system-ui, sans-serif; font-weight: 600; font-size: 0.95rem; box-shadow: 0 10px 22px -8px rgba(37, 211, 102, 0.55);
        transition: transform 0.2s, background 0.2s, box-shadow 0.2s;
    }
    .ly-modal-wa i { font-size: 1.25rem; }
    .ly-modal-wa:hover { background: #1EBE5A; color: #FFFFFF; transform: translateY(-2px); box-shadow: 0 14px 26px -8px rgba(37, 211, 102, 0.6); }

    @media (max-width: 820px) {
        .ly-modal-overlay { padding: 16px; }
        .ly-modal-box { max-height: 86vh; max-height: 86svh; border-radius: 18px; }
        .ly-modal-img-wrap { height: 200px; }
        .ly-modal-body { padding: 22px 20px; }
        .ly-modal-body h3 { font-size: 1.3rem; }
    }

    /* ===== DARK MODE ===== */
    html[data-theme="dark"] .layanan-page {
        --color-surface: #0F172A;
        --color-bg-light: #0B1120;
        --color-text-main: #F8FAFC;
        --color-text-muted: #94A3B8;
        --color-border: #1E293B;
    }

    html[data-theme="dark"] .ly-card { background: #1E293B; border-color: rgba(255,255,255,0.08); }
    html[data-theme="dark"] .ly-card:hover { border-color: rgba(125, 211, 252, 0.3); box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5); }
    html[data-theme="dark"] .ly-card-img-wrapper { background: #0B1120; }
    html[data-theme="dark"] .ly-card-actions { border-top-color: rgba(255,255,255,0.08); }
    html[data-theme="dark"] .ly-card-detail { color: #38BDF8; }
    html[data-theme="dark"] .ly-card-detail:hover { color: #bae6fd; }
    html[data-theme="dark"] .ly-card-wa { color: #25D366; }
    html[data-theme="dark"] .ly-card-wa:hover { color: #128C7E; }

    /* Dark mode: kebalikan dari light mode -> lingkaran putih, tulisan hitam */
    html[data-theme="dark"] .ly-grid-dot {
        background: #FFFFFF;
        border-color: #FFFFFF;
        color: #000000;
    }

    /* Dark Mode Modal */
    html[data-theme="dark"] .ly-modal-close { background: rgba(15, 23, 42, 0.7); color: #F8FAFC; }
    html[data-theme="dark"] .ly-modal-close:hover { background: rgba(15, 23, 42, 0.9); }
    html[data-theme="dark"] .ly-modal-tag { background: rgba(56, 189, 248, 0.12); color: #7DD3FC; }
    html[data-theme="dark"] .ly-modal-img-wrap { background: #0F172A; }
</style>
{{-- Warna kustom dari Admin > Pengaturan Halaman > Layanan (kosong bila belum diatur / masih bawaan) --}}
<style>{!! $pageSetting->css() !!}</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ===== 1. LOGIKA MODAL POPUP ===== */
        const modal = document.getElementById('serviceModal');
        document.body.appendChild(modal); // lepas dari induk agar popup selalu tampil di tengah layar
        const modalImg = document.getElementById('modalImage');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalWa = document.getElementById('modalWaBtn');
        const closeBtn = document.getElementById('closeModal');

        // Memilih semua tombol Detail di tiap card untuk memicu popup
        const detailTriggers = document.querySelectorAll('.ly-btn-detail');

        const openServiceModal = (trigger) => {
            modalTitle.textContent = trigger.dataset.title;
            modalDesc.textContent = trigger.dataset.desc;
            modalImg.src = trigger.dataset.image;
            modalWa.href = trigger.dataset.wa;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        detailTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                openServiceModal(trigger);
            });
        });

        // Klik di mana saja pada card (selain tombol WhatsApp) -> buka modal detail yang sama
        document.querySelectorAll('.ly-card').forEach(card => {
            card.addEventListener('click', (e) => {
                // Biarkan tombol WhatsApp & tombol Detail bekerja seperti biasa (tidak ditimpa)
                if (e.target.closest('.ly-card-wa') || e.target.closest('.ly-btn-detail')) return;

                e.preventDefault();
                const detailBtn = card.querySelector('.ly-btn-detail');
                if (detailBtn) openServiceModal(detailBtn);
            });
        });

        // Fungsi tutup modal
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) closeModal();
        });

        /* ===== 2. KETERANGAN NOMOR CARD (sinkron dengan scroll kartu di mobile) ===== */
        const lyGrid = document.getElementById('lyGrid');
        const lyGridNav = document.getElementById('lyGridNav');

        if (lyGrid && lyGridNav) {
            const lyCards = Array.from(lyGrid.querySelectorAll('.ly-card'));
            const lyDots = Array.from(lyGridNav.querySelectorAll('.ly-grid-dot'));

            const setActiveDot = (index) => {
                lyDots.forEach((dot) => {
                    const isActive = Number(dot.dataset.index) === index;
                    dot.classList.toggle('is-active', isActive);
                    dot.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });
            };

            // Tap nomor -> geser ke kartu yang sesuai
            lyDots.forEach((dot) => {
                dot.addEventListener('click', () => {
                    const idx = Number(dot.dataset.index);
                    const target = lyCards[idx];
                    if (!target) return;
                    target.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    setActiveDot(idx);
                });
            });

            // Geser kartu -> nomor yang aktif ikut berubah
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    let best = null;
                    entries.forEach((entry) => {
                        if (entry.isIntersecting && (!best || entry.intersectionRatio > best.intersectionRatio)) {
                            best = entry;
                        }
                    });
                    if (best) {
                        setActiveDot(Number(best.target.dataset.index));
                    }
                }, {
                    root: lyGrid,
                    threshold: [0.5, 0.75, 1]
                });

                lyCards.forEach((card) => observer.observe(card));
            } else {
                // Fallback sederhana tanpa IntersectionObserver
                let scrollTimeout;
                lyGrid.addEventListener('scroll', () => {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        const gridCenter = lyGrid.scrollLeft + lyGrid.clientWidth / 2;
                        let closest = 0;
                        let closestDist = Infinity;
                        lyCards.forEach((card, i) => {
                            const cardCenter = card.offsetLeft + card.offsetWidth / 2;
                            const dist = Math.abs(cardCenter - gridCenter);
                            if (dist < closestDist) {
                                closestDist = dist;
                                closest = i;
                            }
                        });
                        setActiveDot(closest);
                    }, 100);
                }, { passive: true });
            }
        }
    });
</script>
@endpush