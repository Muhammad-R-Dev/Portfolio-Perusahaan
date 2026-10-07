@php
    // Tentukan page yang aktif berdasarkan URL.
    $__activePage = 'beranda';
    if (request()->is('layanan*')) $__activePage = 'layanan';
    elseif (request()->is('blog*')) $__activePage = 'blog';
    elseif (request()->is('about*')) $__activePage = 'about';
    elseif (request()->is('contact*')) $__activePage = 'contact';

    // Warna header diambil dari Settings > Header & Footer (tabel SiteSetting):
    // navbar_bg_light, navbar_text_light, navbar_bg_dark, navbar_text_dark
    $__navSetting = null;
    try {
        if (class_exists(\App\Models\SiteSetting::class)) {
            $__navSetting = \App\Models\SiteSetting::first();
        }
    } catch (\Throwable $e) {}

    // $type: 'bg' atau 'title' (title = warna teks)
    $__navColor = function ($mode, $type, $default) use ($__navSetting) {
        $key = 'navbar_' . ($type === 'bg' ? 'bg' : 'text') . '_' . $mode;
        $v = $__navSetting->{$key} ?? null;
        return (is_string($v) && preg_match('/^#[0-9a-fA-F]{6}$/', $v)) ? $v : $default;
    };
@endphp
<style>
    :root {
        --nav-bg: {{ $__navColor('light', 'bg', '#094356') }};
        --nav-text: {{ $__navColor('light', 'title', '#ffffff') }};
        /* Warna untuk penanda menu aktif (Active State) */
        --nav-active: var(--nav-bg);
    }
    html[data-theme="dark"] {
        --nav-bg: {{ $__navColor('dark', 'bg', '#094356') }};
        --nav-text: {{ $__navColor('dark', 'title', '#ffffff') }};
        --nav-active: #8fd0bf; 
    }
</style>
<style>
    /* ------- Fonts ------- */
    @font-face {
      font-family: 'PP Neue Corp Tight';
      src: url('https://cdn.prod.website-files.com/673af51dea86ab95d124c3ee/673b0f5784f7060c0ac05534_PPNeueCorp-TightUltrabold.otf') format('opentype');
      font-weight: 700;
      font-style: normal;
      font-display: swap;
    }

    @font-face {
      font-family: 'PP Neue Montreal';
      src: url('https://cdn.prod.website-files.com/6819ed8312518f61b84824df/6819ed8312518f61b84825ba_PPNeueMontreal-Medium.woff2') format('woff2');
      font-weight: 500;
      font-style: normal;
      font-display: swap;
    }

    /* ------- Layout Structure ------- */
    .osmo-ui {
      z-index: 2001;
      pointer-events: none;
      flex-flow: column;
      justify-content: space-between;
      align-items: stretch;
    }

    .nav-row {
      justify-content: space-between;
      align-items: center;
      width: 100%;
      display: flex;
      position: relative;
      z-index: 1;
    }

    .nav-logo-row {
      pointer-events: auto;
      justify-content: space-between;
      align-items: center;
      display: flex;
      text-decoration: none;
    }

    /* Logo + Brand Name */
    .nav-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .nav-brand img {
        width: 40px;
        height: 40px;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .nav-brand:hover img {
        transform: scale(1.05);
    }

    .nav-brand-text {
        font-family: 'Sora', sans-serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #14211b;
        letter-spacing: 0.02em;
        line-height: 1.2;
    }

    .nav-brand-text span {
        display: block;
        font-size: 0.7rem;
        font-weight: 400;
        color: var(--nav-text);
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .nav-row__right {
      grid-column-gap: .625rem;
      grid-row-gap: .625rem;
      pointer-events: auto;
      justify-content: flex-end;
      align-items: center;
      display: flex;
    }

    .header {
      z-index: 2001;
      padding: 20px 5% 20px 5%;
      padding-right: 28px; 
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      transition: all 0.4s ease;
      box-sizing: border-box;
    }

    /* ===== GLASSMORPHISM PADA NAVBAR (warna ikut pengaturan admin) ===== */
    .header.scrolled,
    .header.header--pinned {
        /* Warna solid sesuai Settings > Header & Footer, tidak transparan */
        background: var(--nav-bg) !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.35);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.12);
        padding: 12px 5%;
        padding-right: 28px;
    }

    .header.menu-open {
        background: transparent !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        border-bottom: none !important;
    }

    /* ------- Side Navigation Menu ------- */
    .nav {
      z-index: 2000;
      width: 100%;
      height: 100vh;
      margin-left: auto;
      margin-right: auto;
      display: none;
      position: fixed;
      inset: 0%;
      --menu-padding: 2em;
    }

    .overlay {
      z-index: 0;
      cursor: pointer;
      background-color: #13131366;
      width: 100%;
      height: 100%;
      position: absolute;
      inset: 0%;
    }

    .menu {
      padding-bottom: var(--menu-padding);
      grid-column-gap: 5em;
      grid-row-gap: 5em;
      padding-top: calc(3 * var(--menu-padding));
      flex-flow: column;
      justify-content: space-between;
      align-items: flex-start;
      width: 25em; /* Sedikit diperlebar untuk ruang efek kaca */
      height: 100%;
      margin-left: auto;
      position: relative;
      overflow: auto;
      box-sizing: border-box;
    }

    .menu-bg {
      z-index: 0;
      position: absolute;
      inset: 0%;
    }

    .menu-inner {
      z-index: 1;
      grid-column-gap: 5em;
      grid-row-gap: 5em;
      flex-flow: column;
      justify-content: space-between;
      align-items: flex-start;
      height: 100%;
      display: flex;
      position: relative;
      overflow: auto;
      padding: 0 1em; /* Jarak agar kotak kaca tidak nabrak tepi */
    }

    .bg-panel {
      z-index: 0;
      background-color: var(--color-neutral-300, #e0e0e0);
      border-top-left-radius: 1.25em;
      border-bottom-left-radius: 1.25em;
      position: absolute;
      inset: 0%;
    }

    .bg-panel.first { background-color: var(--nav-bg); }
    .bg-panel.second { background-color: var(--color-neutral-100, #ffffff); }

    /* ===== LAYER KE-3: CLEAR GLASS (seperti gambar referensi) ===== */
    .bg-panel--sky {
      border-top-left-radius: 1.75em;
      border-bottom-left-radius: 1.75em;
      /* isi kaca bening + gradasi pantulan */
      background: linear-gradient(135deg,
          rgba(255, 255, 255, 0.42) 0%,
          rgba(255, 255, 255, 0.14) 45%,
          rgba(255, 255, 255, 0.26) 100%);
      backdrop-filter: blur(18px) saturate(170%);
      -webkit-backdrop-filter: blur(18px) saturate(170%);
      box-shadow:
        inset 0 0 0 1px rgba(255, 255, 255, 0.35),
        inset 0 0 24px rgba(255, 255, 255, 0.28),
        -10px 0 40px rgba(0, 0, 0, 0.18);
    }

    /* garis tepi putih bercahaya (terang di pojok kiri-atas & kanan-bawah) */
    .bg-panel--sky::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      padding: 2px;
      background: linear-gradient(135deg,
          rgba(255, 255, 255, 1) 0%,
          rgba(255, 255, 255, 0.15) 35%,
          rgba(255, 255, 255, 0.1) 65%,
          rgba(255, 255, 255, 0.85) 100%);
      -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      filter: drop-shadow(0 0 4px rgba(255, 255, 255, 0.9));
      pointer-events: none;
    }

    /* kilau cahaya di pojok kiri-atas */
    .bg-panel--sky::after {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: inherit;
      background: radial-gradient(120% 60% at 0% 0%, rgba(255, 255, 255, 0.35), transparent 60%);
      pointer-events: none;
    }

    html[data-theme="dark"] .bg-panel--sky {
      background: linear-gradient(135deg,
          rgba(255, 255, 255, 0.14) 0%,
          rgba(255, 255, 255, 0.04) 45%,
          rgba(255, 255, 255, 0.09) 100%);
      box-shadow:
        inset 0 0 0 1px rgba(255, 255, 255, 0.12),
        inset 0 0 24px rgba(255, 255, 255, 0.08),
        -10px 0 40px rgba(0, 0, 0, 0.45);
    }
    html[data-theme="dark"] .bg-panel--sky::before { opacity: 0.7; }

    .menu-list {
      flex-flow: column;
      width: 100%;
      margin-bottom: 0;
      padding-left: 0;
      list-style: none;
      display: flex;
    }

    .menu-list-item {
      position: relative;
      overflow: hidden; /* Penting untuk animasi rolling text */
    }

    .menu-link {
      padding-top: .75em;
      padding-bottom: .75em;
      padding-left: var(--menu-padding);
      padding-right: var(--menu-padding);
      grid-column-gap: .75em;
      grid-row-gap: .75em;
      width: 100%;
      text-decoration: none;
      display: flex;
      color: inherit;
      box-sizing: border-box;
      border-radius: 16px;
      transition: all 0.4s ease;
    }

    .menu-link-heading {
      z-index: 1;
      text-transform: uppercase;
      font-family: 'PP Neue Corp Tight', Arial, sans-serif;
      font-size: 5.625em;
      font-weight: 700;
      line-height: .75;
      transition: transform .55s cubic-bezier(.65, .05, 0, 1), color 0.3s ease;
      position: relative;
      text-shadow: 0px 1em 0px var(--color-neutral-200, #cccccc);
      margin: 0;
      color: #131313;
    }
    
    html[data-theme="dark"] .menu-link-heading {
      color: #ffffff;
      text-shadow: 0px 1em 0px #333333;
    }

    .eyebrow {
      z-index: 1;
      color: var(--color-primary, #094356);
      text-transform: uppercase;
      font-family: monospace;
      font-weight: 400;
      position: relative;
      margin: 0;
      transition: color 0.3s ease;
    }
    
    html[data-theme="dark"] .eyebrow {
      color: #8fd0bf;
    }

    /* ===== GLASSMORPHISM PADA ITEM MENU AKTIF ===== */
    .menu-link.active {
        /* Kaca bening dengan pantulan cahaya putih */
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.5) 0%, rgba(255, 255, 255, 0.12) 100%);
        /* Garis tepi putih bercahaya (inset shadow agar tinggi layout tidak berubah) */
        box-shadow:
            inset 0 0 0 1.5px rgba(255, 255, 255, 0.85),
            inset 0 0 18px rgba(255, 255, 255, 0.35),
            0 0 14px rgba(255, 255, 255, 0.35);
    }
    
    html[data-theme="dark"] .menu-link.active {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 100%);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3), inset 0 0 0 1px rgba(255, 255, 255, 0.15);
    }

    /* Hilangkan background solid bawaan hover JIKA item sedang aktif */
    .menu-link.active .menu-link-bg {
        display: none !important;
    }

    /* Atur warna Teks dan Shadow agar saat hover, animasi gulung tetap sempurna */
    .menu-link.active .menu-link-heading {
        color: var(--nav-active);
        text-shadow: 0px 1em 0px var(--nav-active); 
    }
    html[data-theme="dark"] .menu-link.active .menu-link-heading {
        color: var(--nav-active);
        text-shadow: 0px 1em 0px var(--nav-active);
    }

    .menu-link.active .eyebrow {
        color: var(--nav-active);
    }

    .menu-link-bg {
      z-index: 0;
      /* warna ikut pengaturan admin (Settings > Header & Footer) */
      background: linear-gradient(135deg,
          color-mix(in srgb, var(--nav-bg) 82%, transparent) 0%,
          color-mix(in srgb, var(--nav-bg) 55%, transparent) 100%);
      box-shadow:
        inset 0 0 0 1.5px rgba(255, 255, 255, 0.55),
        inset 0 0 18px rgba(255, 255, 255, 0.18);
      transform-origin: 50% 100%;
      transform-style: preserve-3d;
      transition: transform .55s cubic-bezier(.65, .05, 0, 1);
      position: absolute;
      inset: 0%;
      transform: scale3d(1, 0, 1);
      border-radius: 16px;
    }

    /* Kotak hover mode gelap: kaca tipis hijau-teal dengan tepi putih bercahaya */
    html[data-theme="dark"] .menu-link-bg {
      background: linear-gradient(135deg,
          color-mix(in srgb, var(--nav-bg) 70%, transparent) 0%,
          color-mix(in srgb, var(--nav-bg) 35%, transparent) 100%);
      box-shadow:
        inset 0 0 0 1.5px rgba(255, 255, 255, 0.4),
        inset 0 0 18px rgba(255, 255, 255, 0.15);
    }

    .p-small { font-size: .875em; font-family: Arial, Helvetica, sans-serif; margin: 0; color: #131313; }
    .p-large { font-size: 1.125em; font-family: Arial, Helvetica, sans-serif; margin: 0; color: #131313; }
    html[data-theme="dark"] .p-large { color: #ffffff; }

    .text-link { text-decoration: none; color: inherit; position: relative; }

    /* ------- Menu Button (hamburger <-> X) ------- */
    .menu-button {
      grid-column-gap: .625em;
      grid-row-gap: .625em;
      background-color: transparent;
      justify-content: flex-end;
      align-items: center;
      margin: -1em;
      padding: 1em;
      display: flex;
      border: none;
      cursor: pointer;
    }

    .menu-button-icon {
      display: block;
      width: 26px;
      height: 26px;
      overflow: visible;
      color: var(--nav-text);
    }

    .mb-line {
      transform-box: fill-box;
      transform-origin: center;
      transition: transform .45s cubic-bezier(.65, .05, 0, 1), opacity .25s ease;
    }

    .menu-button.is-open .mb-line--top { transform: translateY(5px) rotate(45deg); }
    .menu-button.is-open .mb-line--mid { opacity: 0; transform: scaleX(0); }
    .menu-button.is-open .mb-line--bot { transform: translateY(-5px) rotate(-45deg); }

    .menu-button-text {
      flex-flow: column;
      justify-content: flex-start;
      align-items: flex-end;
      height: 1.125em;
      display: flex;
      overflow: hidden;
    }

    .icon-wrap {
      display: flex;
      transition: transform .4s cubic-bezier(.65, .05, 0, 1);
    }

    /* ------- Hover Effects ------- */
    @media (hover: hover) {
      .menu-button:hover .icon-wrap { transform: scale(1.08); }

      .menu-link:hover .menu-link-heading {
        transform: translate(0px, -1em);
        transition-delay: 0.1s;
      }

      .menu-link:hover .menu-link-heading { text-shadow: 0px 1em 0px #ffffff; }
      html[data-theme="dark"] .menu-link:hover .menu-link-heading { text-shadow: 0px 1em 0px #ffffff; }
      
      .menu-link:hover .eyebrow { color: #ffffff; }

      .menu-link:hover .menu-link-bg { transform: scale(1, 1); }

      /* Memastikan warna shadow di item aktif tetap senada dengan brand saat di-hover */
      .menu-link.active:hover .menu-link-heading {
          text-shadow: 0px 1em 0px var(--nav-active);
      }
      html[data-theme="dark"] .menu-link.active:hover .menu-link-heading {
          text-shadow: 0px 1em 0px var(--nav-active);
      }

      .text-link::after {
        content: ''; position: absolute; left: 0; bottom: 0; width: 100%; height: 1px;
        background: var(--color-primary, #094356); transform-origin: right center;
        transform: scale(0, 1); transition: transform 0.4s cubic-bezier(.65, .05, 0, 1);
      }

      .text-link:hover::after { transform-origin: left center; transform: scale(1, 1); }
    }

    /* ------- Responsive Styles ------- */
    @media screen and (max-width: 768px) {
      .header, .header.scrolled { padding-right: 18px; }
      .nav { --menu-padding: 1em; }
      .nav-logo-row { grid-column-gap: 2.5em; grid-row-gap: 2.5em; width: auto; }
      .nav-row__right { grid-column-gap: 0rem; grid-row-gap: 0rem; }
      .menu { padding-top: calc(6 * var(--menu-padding)); padding-bottom: calc(3 * var(--menu-padding)); width: 75%; }
      .bg-panel { border-top-left-radius: 0; border-bottom-left-radius: 0; }
      .menu-list-item { height: auto; }
      .menu-link-heading { font-size: 3.5em; }
      .p-large.text-link { font-size: 1em; }
      .menu-button-icon { width: 24px; height: 24px; }
      .nav-brand { gap: 9px; }
      .nav-brand img { width: 32px; height: 32px; }
      .nav-brand-text { font-size: 1rem; margin-left: -2px; }
      .nav-brand-text span { font-size: 0.6rem; }
    }

    @media screen and (max-width: 479px) {
      .menu { padding-top: calc(7 * var(--menu-padding)); padding-bottom: calc(4 * var(--menu-padding)); width: 85%; }
      .menu-link-heading { font-size: 2.8em; }
    }

    /* ------- Back Button ------- */
    .nav-left { display: flex; align-items: center; gap: 26px; pointer-events: auto; transition: opacity 0.35s ease, visibility 0.35s ease; }
    .header.menu-open .nav-left { opacity: 0; visibility: hidden; pointer-events: none; }
    
    .back-button {
      width: 42px; height: 42px; border-radius: 14px; border: 1px solid color-mix(in srgb, var(--nav-bg) 18%, transparent);
      background: linear-gradient(135deg, #eaf6ef 0%, #ffffff 100%); color: var(--nav-bg);
      display: flex; align-items: center; justify-content: center; cursor: pointer;
      box-shadow: 0 3px 12px rgba(20, 33, 27, 0.07); transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
      flex-shrink: 0; position: relative; overflow: hidden;
    }
    .back-button svg { position: relative; z-index: 1; transition: transform 0.35s cubic-bezier(.65, .05, 0, 1); }
    .back-button::before {
      content: ''; position: absolute; inset: 0; background: var(--nav-bg);
      transform: translateY(100%); transition: transform 0.35s cubic-bezier(.65, .05, 0, 1);
    }
    .back-button:hover { color: var(--nav-text); border-color: var(--nav-bg); box-shadow: 0 8px 20px color-mix(in srgb, var(--nav-bg) 30%, transparent); }
    .back-button:hover::before { transform: translateY(0); }
    .back-button:hover svg { transform: translateX(-3px); }
    .back-button:active { transform: scale(0.9); }
    .back-button svg { width: 18px; height: 18px; }

    @media screen and (max-width: 768px) {
      .nav-left { gap: 12px; }
      .back-button { width: 32px; height: 32px; border-radius: 10px; background: rgba(255, 255, 255, 0.55); backdrop-filter: blur(6px); border-color: rgba(9, 67, 86, 0.12); box-shadow: none; }
      .back-button svg { width: 14px; height: 14px; }
      .back-button:hover { box-shadow: 0 4px 12px rgba(9, 67, 86, 0.25); }
    }

    /* ------- Tombol Dark / Light Mode ------- */
    .theme-toggle-wrap { position: relative; z-index: 2; flex-shrink: 0; margin-right: 1.1rem; }
    .theme-toggle {
      position: relative; width: 34px; height: 34px; padding: 0; border: none; background: transparent;
      color: var(--nav-text); cursor: pointer; -webkit-tap-highlight-color: transparent; transition: transform 0.25s ease, opacity 0.25s ease;
    }
    .header.menu-open .theme-toggle-wrap, #navHeader.menu-open .theme-toggle-wrap, .menu-open .theme-toggle-wrap { display: none !important; }
    .theme-toggle:hover { transform: scale(1.08); }
    .theme-toggle:active { transform: scale(0.94); }
    .theme-toggle:focus-visible { outline: 2px solid var(--nav-text); outline-offset: 4px; border-radius: 6px; }
    .tt-icon {
      position: absolute; top: 50%; left: 50%; width: 24px; height: 24px; margin: -12px 0 0 -12px;
      transition: transform 0.5s cubic-bezier(.65, .05, 0, 1), opacity 0.35s ease;
    }
    .tt-icon--moon { opacity: 0; transform: rotate(-90deg) scale(0.5); }
    .theme-toggle[data-theme="dark"] .tt-icon--sun { opacity: 0; transform: rotate(90deg) scale(0.5); }
    .theme-toggle[data-theme="dark"] .tt-icon--moon { opacity: 1; transform: rotate(0) scale(1); }

    @media (prefers-reduced-motion: reduce) { .tt-icon, .theme-toggle { transition-duration: 0.01s; } }
    @media screen and (max-width: 768px) {
      .theme-toggle-wrap { margin-right: 0.6rem; }
      .theme-toggle { width: 30px; height: 30px; }
      .tt-icon { width: 20px; height: 20px; margin: -10px 0 0 -10px; }
    }

    .header:not(.menu-open) { background: var(--nav-bg); }
    .header .nav-brand-text, .header .menu-button .p-large, .header .menu-button-icon { color: var(--nav-text); }
    .header .nav-brand-text span { color: var(--nav-text); opacity: 0.75; }
    .header.menu-open .menu-button .p-large, .header.menu-open .menu-button-icon { color: #131313; }
    html[data-theme="dark"] .header.menu-open .menu-button .p-large, html[data-theme="dark"] .header.menu-open .menu-button-icon { color: #ffffff; }

    /* ============================================================
       TEMA GLOBAL
       ============================================================ */
    :root { --site-bg: #ffffff; --site-fg: #14211b; color-scheme: light; }
    html[data-theme="dark"] { --site-bg: #0a0f1a; --site-fg: #e8f1ee; color-scheme: dark; }
    html, html body { margin: 0; width: 100%; min-height: 100%; background-color: var(--site-bg) !important; transition: background-color 0.4s ease; }
    html[data-theme="dark"] body { color: var(--site-fg); }
    @media (prefers-reduced-motion: reduce) { html, html body { transition: none; } }
</style>

<script>
  (function () {
    try {
      var t = localStorage.getItem('theme');
      if (t === 'dark' || t === 'light') document.documentElement.setAttribute('data-theme', t);
    } catch (e) {}
  })();
</script>

<div class="osmo-ui">
  <header class="header @unless (request()->routeIs('home')) header--pinned @endunless" id="navHeader">
      <nav class="nav-row">
        <div class="nav-left">
          <a href="{{ url('/') }}" class="nav-brand nav-logo-row">
              @php
                  $__setting = $siteSetting ?? null;
                  if (class_exists(\App\Models\SiteSetting::class)) {
                      try {
                          $__fresh = \App\Models\SiteSetting::first();
                          if ($__fresh) { $__setting = $__fresh; }
                      } catch (\Throwable $e) {}
                  }

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
              <div class="nav-brand-text">
                  {{ $__setting->brand_name ?? 'Astabrata' }}
                  @if (!empty($__setting->brand_tagline ?? 'Teknologi'))
                      <span>{{ $__setting->brand_tagline ?? 'Teknologi' }}</span>
                  @endif
              </div>
          </a>
        </div>
        <div class="nav-row__right">
          <div class="theme-toggle-wrap">
            <button type="button" id="themeToggle" class="theme-toggle" role="switch" aria-checked="false" aria-label="Ganti mode gelap / terang" data-theme="light">
              <svg class="tt-icon tt-icon--sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2.5v2.2M12 19.3v2.2M4.9 4.9l1.6 1.6M17.5 17.5l1.6 1.6M2.5 12h2.2M19.3 12h2.2M4.9 19.1l1.6-1.6M17.5 6.5l1.6-1.6"/>
              </svg>
              <svg class="tt-icon tt-icon--moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true">
                <path d="M20.5 14.2A8.5 8.5 0 0 1 9.8 3.5a8.5 8.5 0 1 0 10.7 10.7z"/>
              </svg>
            </button>
          </div>
          <button role="button" data-menu-toggle="" class="menu-button" aria-label="Buka menu">
            <div class="menu-button-text">
              <p class="p-large">Menu</p>
              <p class="p-large">Close</p>
            </div>
            <div class="icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" class="menu-button-icon" aria-hidden="true">
                <line class="mb-line mb-line--top" x1="4" y1="7" x2="20" y2="7"></line>
                <line class="mb-line mb-line--mid" x1="4" y1="12" x2="20" y2="12"></line>
                <line class="mb-line mb-line--bot" x1="4" y1="17" x2="20" y2="17"></line>
              </svg>
            </div>
          </button>
        </div>
      </nav>
  </header>
</div>

<div data-nav="closed" class="nav">
  <div data-menu-toggle="" class="overlay"></div>
  <nav class="menu">
    <div class="menu-bg">
      <div class="bg-panel first"></div>
      <div class="bg-panel second"></div>
      <div class="bg-panel bg-panel--sky"></div>
    </div>
    <div class="menu-inner">
      <ul class="menu-list">
        <li class="menu-list-item">
          <a href="{{ url('/') }}" class="menu-link w-inline-block {{ request()->is('/') ? 'active' : '' }}">
            <p class="menu-link-heading">Beranda</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/layanan') }}" class="menu-link w-inline-block {{ request()->is('layanan*') ? 'active' : '' }}">
            <p class="menu-link-heading">Layanan</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/blog') }}" class="menu-link w-inline-block {{ request()->is('blog*') ? 'active' : '' }}">
            <p class="menu-link-heading">Blog</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/about') }}" class="menu-link w-inline-block {{ request()->is('about*') ? 'active' : '' }}">
            <p class="menu-link-heading">About</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/contact') }}" class="menu-link w-inline-block {{ request()->is('contact*') ? 'active' : '' }}">
            <p class="menu-link-heading">Contact</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/CustomEase.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.registerPlugin(CustomEase);

        CustomEase.create("main", "0.65, 0.01, 0.05, 0.99");

        gsap.defaults({
            ease: "main",
            duration: 0.7
        });

        function initMenu() {
            let navWrap = document.querySelector(".nav");
            let state = navWrap.getAttribute("data-nav");
            let overlay = navWrap.querySelector(".overlay");
            let menu = navWrap.querySelector(".menu");
            let bgPanels = navWrap.querySelectorAll(".bg-panel");
            // Panel solid (teal & putih) disembunyikan setelah animasi masuk supaya panel kaca terlihat bening
            let solidPanels = navWrap.querySelectorAll(".bg-panel.first, .bg-panel.second");
            let menuToggles = document.querySelectorAll("[data-menu-toggle]");
            let menuLinks = navWrap.querySelectorAll(".menu-link");
            let fadeTargets = navWrap.querySelectorAll("[data-menu-fade]");
            let menuButton = document.querySelector(".menu-button");
            let menuButtonTexts = menuButton.querySelectorAll("p");
            let navHeader = document.getElementById("navHeader");

            let tl = gsap.timeline();

            const openNav = () => {
                navWrap.setAttribute("data-nav", "open");
                document.body.style.overflow = 'hidden';
                navHeader.classList.add('menu-open');
                document.querySelectorAll('.theme-toggle-wrap').forEach(el => el.style.display = 'none');
                menuButton.classList.add('is-open');
                menuButton.setAttribute('aria-label', 'Tutup menu');

                tl.clear()
                .set(navWrap, { display: "block" })
                .set(menu, { xPercent: 0 }, "<")
                .set(solidPanels, { autoAlpha: 1 }, "<")
                .fromTo(menuButtonTexts, { yPercent: 0 }, { yPercent: -100, stagger: 0.2 })
                .fromTo(overlay, { autoAlpha: 0 }, { autoAlpha: 1 }, "<")
                .fromTo(bgPanels, { xPercent: 101 }, { xPercent: 0, stagger: 0.12, duration: 0.575 }, "<")
                .fromTo(menuLinks, { yPercent: 140, rotate: 10 }, { yPercent: 0, rotate: 0, stagger: 0.05 }, "<+=0.35")
                .fromTo(fadeTargets, { autoAlpha: 0, yPercent: 50 }, { autoAlpha: 1, yPercent: 0, stagger: 0.04 }, "<+=0.2")
                .to(solidPanels, { autoAlpha: 0, duration: 0.3 }, 0.9);
            };

            const closeNav = () => {
                navWrap.setAttribute("data-nav", "closed");
                document.body.style.overflow = '';
                navHeader.classList.remove('menu-open');
                document.querySelectorAll('.theme-toggle-wrap').forEach(el => el.style.display = '');
                menuButton.classList.remove('is-open');
                menuButton.setAttribute('aria-label', 'Buka menu');

                tl.clear()
                .to(overlay, { autoAlpha: 0 })
                .to(menu, { xPercent: 120 }, "<")
                .to(menuButtonTexts, { yPercent: 0 }, "<")
                .set(navWrap, { display: "none" });
            };

            menuToggles.forEach((toggle) => {
                toggle.addEventListener("click", () => {
                    state = navWrap.getAttribute("data-nav");
                    if (state === "open") {
                        closeNav();
                    } else {
                        openNav();
                    }
                });
            });

            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && navWrap.getAttribute("data-nav") === "open") {
                    closeNav();
                }
            });

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navHeader.classList.add('scrolled');
                } else {
                    navHeader.classList.remove('scrolled');
                }
            });
        }

        initMenu();

        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            const applyTheme = (theme) => {
                document.documentElement.setAttribute('data-theme', theme);
                themeToggle.setAttribute('data-theme', theme);
                themeToggle.setAttribute('aria-checked', theme === 'dark' ? 'true' : 'false');
                document.dispatchEvent(new CustomEvent('themechange', { detail: { theme } }));
            };
            let saved = 'light';
            try { saved = localStorage.getItem('theme') === 'dark' ? 'dark' : 'light'; } catch (e) {}
            applyTheme(saved);

            themeToggle.addEventListener('click', () => {
                const next = themeToggle.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                applyTheme(next);
                try { localStorage.setItem('theme', next); } catch (e) {}
            });
        }

        const backButton = document.getElementById('backButton');
        if (backButton) {
            backButton.addEventListener('click', () => {
                if (document.referrer && document.referrer.includes(window.location.host) && window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = "{{ url('/') }}";
                }
            });
        }
    });
</script>
@endpush