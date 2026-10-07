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
        <div class="ly-inner">
            <div class="ly-section-head">
                <h2>{{ $pageSetting->titleText() }}</h2>
                <p>{{ $pageSetting->descriptionText() }}</p>
            </div>

            <div class="ly-grid">
                @forelse($slides as $slide)
                    <div class="ly-card">
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

    .ly-inner { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 24px; }
    .text-center { text-align: center; }

    /* ===== SERVICES GRID ===== */

    .ly-services {
        position: relative;
        padding: 72px 0 90px;
        background: var(--color-bg-light);
    }

    @media (max-width: 768px) {
        /* Beri ruang dari navbar fixed agar judul tidak tertutup */
        .ly-services { padding: 76px 0 56px; }
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
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .ly-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 34px -14px rgba(9, 67, 86, 0.25);
        border-color: rgba(9, 67, 86, 0.2);
    }

    .ly-card-img-wrapper {
        position: relative; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; cursor: pointer; background: var(--color-bg-light);
    }
    .ly-card-img-wrapper img {
        width: 100%; height: 100%; object-fit: cover; display: block;
        transition: transform 0.5s ease;
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

        /* Grid ikut lebar .ly-inner yang sudah punya gutter, jadi card otomatis lebih kecil */
        .ly-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow: visible;
        }

        .ly-card {
            width: 100%;
            min-width: 0;
            max-width: none;
            margin: 0;
            border-radius: 12px;
            box-sizing: border-box;
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
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) closeModal();
        });
    });
</script>
@endpush