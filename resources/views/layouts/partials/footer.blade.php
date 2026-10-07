@php
    // Warna footer dari pengaturan admin (Settings > Header & Footer). Jika kosong/tidak valid, pakai warna bawaan.
    $__footSet = $siteSetting ?? null;
    if (class_exists(\App\Models\SiteSetting::class)) {
        try {
            $__footFresh = \App\Models\SiteSetting::first();
            if ($__footFresh) { $__footSet = $__footFresh; }
        } catch (\Throwable $e) {
            // abaikan, pakai $siteSetting bawaan
        }
    }
    $__footColor = function ($key, $default) use ($__footSet) {
        $v = $__footSet->{$key} ?? null;
        return (is_string($v) && preg_match('/^#[0-9a-fA-F]{6}$/', $v)) ? $v : $default;
    };
    $__footRgb = function ($hex) {
        $h = ltrim($hex, '#');
        return hexdec(substr($h, 0, 2)) . ', ' . hexdec(substr($h, 2, 2)) . ', ' . hexdec(substr($h, 4, 2));
    };
    $__ftBgL = $__footColor('footer_bg_light', '#094356');
    $__ftTxL = $__footColor('footer_text_light', '#ffffff');
    $__ftBgD = $__footColor('footer_bg_dark', '#1c2842');
    $__ftTxD = $__footColor('footer_text_dark', '#ffffff');
@endphp
<style>
    :root {
        --ft-bg: {{ $__ftBgL }};
        --ft-bg-rgb: {{ $__footRgb($__ftBgL) }};
        --ft-text: {{ $__ftTxL }};
        --ft-text-rgb: {{ $__footRgb($__ftTxL) }};
    }
    html[data-theme="dark"] {
        --ft-bg: {{ $__ftBgD }};
        --ft-bg-rgb: {{ $__footRgb($__ftBgD) }};
        --ft-text: {{ $__ftTxD }};
        --ft-text-rgb: {{ $__footRgb($__ftTxD) }};
    }
</style>
<style>
/* ============ FOOTER CTA BANNER ============ */
.footer-cta {
    position: relative;
    background-color: var(--ft-bg);
    background-image:
        linear-gradient(90deg,
            var(--ft-bg) 0%,
            var(--ft-bg) 32%,
            rgba(var(--ft-bg-rgb), 0.92) 45%,
            rgba(var(--ft-bg-rgb), 0.55) 62%,
            rgba(var(--ft-bg-rgb), 0.15) 80%,
            rgba(var(--ft-bg-rgb), 0) 100%
        ),
        url('https://images.unsplash.com/photo-1587702068694-a909ef4aa346?fm=jpg&q=80&w=1600&auto=format&fit=crop');
    background-repeat: no-repeat;
    background-position: right center;
    background-size: cover;
    padding: 3.5rem 2rem;
    font-family: 'Poppins', sans-serif;
}
.footer-cta-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}
.footer-cta-text h3 {
    font-family: 'Sora', sans-serif;
    color: var(--ft-text);
    font-size: 1.9rem;
    font-weight: 700;
    margin: 0 0 0.6rem;
}
.footer-cta-text p {
    color: rgba(var(--ft-text-rgb), 0.75);
    font-size: 1rem;
    margin: 0;
}
.footer-cta-actions {
    display: flex;
    align-items: center;
    gap: 1.8rem;
    flex-wrap: wrap;
}
.footer-cta-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: var(--ft-text);
    color: var(--ft-bg);
    font-weight: 600;
    font-size: 0.95rem;
    padding: 0.9rem 1.6rem;
    border-radius: 50px;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}
.footer-cta-btn:hover {
    background: #4FA8B5;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79, 168, 181, 0.3);
}
.footer-cta-phone {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    color: var(--ft-text);
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    white-space: nowrap;
}
.footer-cta-phone i {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(var(--ft-text-rgb), 0.15);
    color: var(--ft-text);
}

@media (max-width: 768px) {
    .footer-cta {
        background-image:
            linear-gradient(180deg,
                rgba(var(--ft-bg-rgb), 0.75) 0%,
                rgba(var(--ft-bg-rgb), 0.88) 40%,
                var(--ft-bg) 75%
            ),
            url('https://images.unsplash.com/photo-1587702068694-a909ef4aa346?fm=jpg&q=80&w=1600&auto=format&fit=crop');
        background-position: center center;
        background-size: cover;
        padding: 2.2rem 1.5rem;
    }
    .footer-cta-inner {
        flex-direction: column;
        align-items: flex-start;
        text-align: left;
        gap: 1.2rem;
    }
    .footer-cta-text h3 {
        font-size: 1.3rem;
    }
    .footer-cta-text p {
        font-size: 0.85rem;
    }
    .footer-cta-actions {
        gap: 1rem;
    }
    .footer-cta-btn {
        font-size: 0.85rem;
        padding: 0.7rem 1.3rem;
    }
    .footer-cta-phone {
        font-size: 0.85rem;
    }
    .footer-cta-phone i {
        width: 34px;
        height: 34px;
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .footer-cta {
        padding: 1.8rem 1.2rem;
    }
    .footer-cta-text h3 {
        font-size: 1.1rem;
    }
    .footer-cta-text p {
        font-size: 0.8rem;
    }
}

/* ============ FOOTER ============ */
.custom-footer {
    background-color: var(--ft-bg);
    color: rgba(var(--ft-text-rgb), 0.7);
    padding: 3rem 2rem 2rem;
    font-family: 'Poppins', sans-serif;
    border-top: 1px solid rgba(79, 168, 181, 0.08);
    position: relative;
    overflow: hidden;
}
.custom-footer::before {
    content: '';
    position: absolute;
    top: -150px;
    right: -150px;
    width: 400px;
    height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(159,214,185,0.06) 0%, transparent 70%);
    pointer-events: none;
}
.custom-footer::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(159,214,185,0.04) 0%, transparent 70%);
    pointer-events: none;
}
.footer-container {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
    position: relative;
    z-index: 1;
}
.footer-brand-logo {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 1.2rem;
}
.footer-brand-logo img {
    width: 42px;
    height: 42px;
    object-fit: contain;
    flex-shrink: 0;
}
.footer-brand h2 {
    font-family: 'Sora', sans-serif;
    color: var(--ft-text);
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
@media (max-width: 480px) {
    .footer-brand-logo img { width: 34px; height: 34px; }
}
.footer-brand p {
    font-size: 0.95rem;
    line-height: 1.8;
    margin-bottom: 1.8rem;
}
/* ===== SOSMED: sama persis dengan halaman About (lingkaran terisi warna brand, ikon putih) ===== */
.team-card-sosmed-wrapper {
    display: flex;
    gap: 6px;
    justify-content: flex-start;
    margin-top: 10px;
    flex-wrap: wrap;
}
.team-card-sosmed {
    --sm-bg: var(--ft-text);
    --sm-fg: var(--ft-bg);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 0;
    background: var(--sm-bg);
    color: var(--sm-fg);
    text-decoration: none;
}
.team-card-sosmed i { font-size: 17px; line-height: 1; color: inherit; }
.team-card-sosmed-x { display: block; }

.team-card-sosmed.brand-text-ig { --sm-fg: #fff; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); }
.team-card-sosmed.brand-text-fb { --sm-bg: #1877F2; --sm-fg: #fff; }
.team-card-sosmed.brand-text-in { --sm-bg: #0A66C2; --sm-fg: #fff; }
.team-card-sosmed.brand-text-gh { --sm-bg: #24292f; --sm-fg: #fff; }
.team-card-sosmed.brand-text-x  { --sm-bg: #000000; --sm-fg: #fff; }
.team-card-sosmed.brand-text-yt { --sm-bg: #FF0000; --sm-fg: #fff; }
.team-card-sosmed.brand-text-tt { --sm-bg: #000000; --sm-fg: #fff; }
.team-card-sosmed.brand-text-wa { --sm-bg: #25D366; --sm-fg: #fff; }
/* Link lain: ikut warna teks footer (otomatis cocok light/dark) */
.team-card-sosmed.brand-text-link { --sm-bg: var(--ft-text); --sm-fg: var(--ft-bg); }

/* Sosmed (dark mode): brand gelap dibalik jadi putih agar tetap terlihat */
html[data-theme="dark"] .team-card-sosmed.brand-text-gh,
html[data-theme="dark"] .team-card-sosmed.brand-text-x,
html[data-theme="dark"] .team-card-sosmed.brand-text-tt { --sm-bg: #f2f5f4; --sm-fg: #111; }
.footer-links h4, .footer-contact h4 {
    font-family: 'Sora', sans-serif;
    color: var(--ft-text);
    font-size: 1.1rem;
    margin-bottom: 1.4rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    position: relative;
    padding-bottom: 12px;
}
.footer-links h4::after, .footer-contact h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: #4FA8B5;
    border-radius: 2px;
}
.footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer-links li {
    margin-bottom: 1rem;
}
.footer-links a {
    color: rgba(var(--ft-text-rgb), 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    position: relative;
    padding-left: 0;
}
.footer-links a:hover {
    color: #4FA8B5;
    padding-left: 8px;
}
.footer-contact p {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    font-size: 0.95rem;
    margin-bottom: 1.2rem;
    line-height: 1.6;
}
.footer-contact i {
    color: var(--ft-text);
    margin-top: 4px;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.footer-divider {
    max-width: 1100px;
    margin: 0 auto;
    border: none;
    border-top: 1px solid rgba(var(--ft-text-rgb), 0.06);
}
.footer-bottom {
    max-width: 1100px;
    margin: 0 auto;
    padding-top: 1.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: rgba(var(--ft-text-rgb), 0.4);
    position: relative;
    z-index: 1;
}
.footer-bottom-links {
    display: flex;
    gap: 20px;
}
.footer-bottom-links a {
    color: rgba(var(--ft-text-rgb), 0.4);
    text-decoration: none;
    transition: color 0.3s ease;
}
.footer-bottom-links a:hover {
    color: #4FA8B5;
}

@media (max-width: 768px) {
    .custom-footer {
        padding: 2.5rem 1.5rem 1.5rem;
    }
    .footer-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .footer-brand h2 {
        font-size: 1.3rem;
    }
    .footer-brand p {
        font-size: 0.85rem;
    }
    .footer-links h4, .footer-contact h4 {
        font-size: 1rem;
    }
    .footer-links a {
        font-size: 0.85rem;
    }
    .footer-contact p {
        font-size: 0.85rem;
    }
    .footer-bottom {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        font-size: 0.8rem;
    }
}

/* Warna footer (terang/gelap) diatur dari admin lewat variabel --ft-* di atas. */
</style>

<!-- ============ CTA BANNER (with background photo + smooth gradient blend) ============ -->
<div class="footer-cta">
    <div class="footer-cta-inner">
        <div class="footer-cta-text">
            <h3>Siap Mewujudkan Ide Digital Anda?</h3>
            <p>Mari wujudkan tujuan bisnis Anda bersama kami.</p>
        </div>
        <div class="footer-cta-actions">
        </div>
    </div>
</div>

<footer class="custom-footer">
    <div class="footer-container">
        <div class="footer-brand">
            <div class="footer-brand-logo">
                @php
                    // Ambil pengaturan terbaru langsung dari database (menghindari data lama dari cache/share),
                    // lalu cadangkan ke $siteSetting jika model tidak ditemukan.
                    $__setting = $siteSetting ?? null;
                    if (class_exists(\App\Models\SiteSetting::class)) {
                        try {
                            $__fresh = \App\Models\SiteSetting::first();
                            if ($__fresh) { $__setting = $__fresh; }
                        } catch (\Throwable $e) {
                            // abaikan, pakai $siteSetting bawaan
                        }
                    }

                    // URL logo + parameter versi agar browser tidak memakai gambar lama dari cache
                    $__logoUrl = asset('img/logo asta.png');
                    if ($__setting && !empty($__setting->logo)) {
                        if (\Illuminate\Support\Str::startsWith($__setting->logo, ['http://', 'https://'])) {
                            $__logoUrl = $__setting->logo;
                        } else {
                            $__logoPath = 'storage/' . ltrim($__setting->logo, '/');
                            $__logoVer = file_exists(public_path($__logoPath))
                                ? filemtime(public_path($__logoPath))
                                : (optional($__setting->updated_at)->timestamp ?: time());
                            $__logoUrl = asset($__logoPath) . '?v=' . $__logoVer;
                        }
                    }
                @endphp
                <img src="{{ $__logoUrl }}" alt="Logo {{ $__setting->brand_name ?? 'Astabrata' }}">
                <h2>{{ $__setting->brand_name ?? 'Astabrata' }} {{ $__setting->brand_tagline ?? 'Teknologi' }}</h2>
            </div>
            <p>{{ $__setting->footer_description ?? 'Membawa inovasi digital untuk masa depan bisnis yang lebih baik melalui teknologi yang handal dan desain yang intuitif.' }}</p>
            @php
                $footerSocials = isset($__setting)
                    ? $__setting->socialLinks(['instagram', 'linkedin', 'github', 'twitter', 'facebook', 'youtube'])
                    : [];
            @endphp
            @if(count($footerSocials))
                <div class="team-card-sosmed-wrapper">
                    @php
                        // Ikon bawaan per brand (dipakai jika ikon dari setting kosong/tidak valid)
                        $__iconMap = [
                            'ig' => 'bxl-instagram', 'in' => 'bxl-linkedin-square', 'gh' => 'bxl-github',
                            'fb' => 'bxl-facebook-circle', 'x' => 'x-logo', 'yt' => 'bxl-youtube',
                            'tt' => 'bxl-tiktok', 'wa' => 'bxl-whatsapp', 'link' => 'bx-link',
                        ];
                        $__labelMap = [
                            'ig' => 'Instagram', 'in' => 'LinkedIn', 'gh' => 'GitHub', 'fb' => 'Facebook',
                            'x' => 'X', 'yt' => 'YouTube', 'tt' => 'TikTok', 'wa' => 'WhatsApp', 'link' => 'Link',
                        ];
                    @endphp
                    @foreach($footerSocials as $social)
                        @php
                            $__url = trim((string) ($social['url'] ?? ''));
                            if ($__url === '') { continue; }
                            // Deteksi brand dari URL / label / ikon untuk menentukan warna lingkaran
                            $__sk = strtolower($__url . ' ' . ($social['label'] ?? '') . ' ' . ($social['icon'] ?? ''));
                            $__sb = 'link';
                            if (str_contains($__sk, 'instagram')) { $__sb = 'ig'; }
                            elseif (str_contains($__sk, 'linkedin')) { $__sb = 'in'; }
                            elseif (str_contains($__sk, 'github')) { $__sb = 'gh'; }
                            elseif (str_contains($__sk, 'facebook')) { $__sb = 'fb'; }
                            elseif (str_contains($__sk, 'twitter') || str_contains($__sk, 'x.com') || preg_match('/\bx\b/', strtolower($social['label'] ?? ''))) { $__sb = 'x'; }
                            elseif (str_contains($__sk, 'youtube')) { $__sb = 'yt'; }
                            elseif (str_contains($__sk, 'tiktok')) { $__sb = 'tt'; }
                            elseif (str_contains($__sk, 'wa.me') || str_contains($__sk, 'whatsapp')) { $__sb = 'wa'; }

                            // Ikon: pakai ikon dari setting hanya jika berawalan "bx", selain itu pakai ikon bawaan brand
                            $__customIcon = trim((string) ($social['icon'] ?? ''));
                            $__icon = str_starts_with($__customIcon, 'bx') ? $__customIcon : ($__iconMap[$__sb] ?? 'bx-link');
                            $__label = trim((string) ($social['label'] ?? '')) ?: ($__labelMap[$__sb] ?? 'Link');
                        @endphp
                        <a class="team-card-sosmed brand-text-{{ $__sb }}" href="{{ $__url }}" target="_blank" rel="noopener noreferrer" title="{{ $__label }}" aria-label="{{ $__label }}">
                            @if($__icon === 'x-logo')
                                <svg class="team-card-sosmed-x" viewBox="0 0 24 24" width="15" height="15" fill="currentColor" aria-hidden="true"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                            @else
                                <i class="bx {{ $__icon }}"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="footer-links">
            <h4>Tautan Cepat</h4>
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/layanan') }}">Layanan</a></li>
                <li><a href="{{ url('/projects') }}">Project</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </div>
        
        <div class="footer-contact">
            <h4>Hubungi Kami</h4>
            <p><i class="fa-solid fa-location-dot"></i> <span>Jl.STPP karanglo, Area Sawah/Kebun, Glagahombo, Tegalrejo, Magelang, Jawa Tengah 56192</span></p>
            <p><i class="fa-solid fa-phone"></i> <span>+62 882 0066 44656</span></p>
            <p><i class="fa-solid fa-envelope"></i> <span>astabratamgl@gmail.com</span></p>
        </div>
    </div>
    
    <hr class="footer-divider">
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} PT Asta Brata Teknologi. All rights reserved.</p>
        <div class="footer-bottom-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>
    </div>
</footer>