@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ===== RESET & VARIABEL GLOBAL ===== */
*, *::before, *::after { padding: 0; margin: 0; box-sizing: border-box; }

:root {
  --ink: #0B1412; --forest: #10241C; --deep-teal: #0E3A3A;
  --primary: #145C4B; --primary-soft: #1A6B58;
  --mint: #9FD6B9; --mint-bright: #B8E6CE; --sage: #7BA892;
  --gold: #C4A574; --gold-soft: #D4BC8E;
  --cream: #F7F3EC; --cream-warm: #EFE8DC; --ivory: #FBFAF7; --stone: #E8E2D8;
  --muted: #6B736E; --text: #1C2421; --text-soft: rgba(28, 36, 33, 0.72);
  /* Jarak kiri & kanan halaman: dipakai hero, Tentang Kami, dan FAQ agar tepinya sejajar.
     5vw = sama dengan jarak logo di navbar; minimal 24px. Ubah di sini untuk mengatur semuanya sekaligus. */
  --side-gap: max(24px, 5vw);
  --font-sans: 'Google Sans Flex', 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
}

html { background-color: var(--ivory); scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }
body { font-family: var(--font-sans); color: var(--text); -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; text-rendering: optimizeLegibility; }
h1, h2, h3, h4, h5, h6 { font-family: var(--font-sans); letter-spacing: -0.01em; }
button, input, textarea, select { font-family: var(--font-sans); }

/* ===== LAYOUT & PENAHAN KONTEN (BIAR RATA TENGAH & SIMETRIS) ===== */
.container-global { width: 100%; max-width: 1140px; margin: 0 auto; }

/* ===== ANIMASI REVEAL (MUNCUL HALUS) ===== */
.reveal { opacity: 0; transform: translateY(38px); transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1); will-change: opacity, transform; }
.reveal.in-view { opacity: 1; transform: translateY(0); }
.reveal-scale { transform: translateY(24px) scale(0.94); }
.reveal-scale.in-view { transform: translateY(0) scale(1); }
.reveal-delay-1 { transition-delay: 0.08s; }
.reveal-delay-2 { transition-delay: 0.16s; }

@media (prefers-reduced-motion: reduce) {
  .reveal, .reveal-scale { transition: none !important; transform: none !important; opacity: 1 !important; }
}

/* ===== HERO SECTION ===== */
html #navHeader { opacity: 1; visibility: visible; pointer-events: auto; }
/* --hero-p = progres scroll hero (0 = penuh layar, 1 = sejajar dengan teks di bawahnya). Diisi oleh JS di bawah. */
.hero-frame { --hero-p: 0; padding: 0; background: #FFFFFF; position: relative; }
main.hero-bg { position: relative; width: 100%; height: clamp(440px, 78vh, 720px); min-height: 0; max-height: none; overflow: hidden; border-radius: 0; background: #0B1412;
  /* kiri-kanan dipotong (crop) seiring scroll sampai selebar konten di bawahnya, sudut ikut membulat */
  clip-path: inset(0 calc(var(--side-gap) * var(--hero-p)) round calc(var(--hero-p) * 10px)); }
.hero-bg__img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center 40%; z-index: 1; }
main.hero-bg .hero-gradient { z-index: 2; height: 70%; position: absolute; width: 100%; bottom: 0; left: 0; background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.28) 45%, rgba(0, 0, 0, 0.62) 100%); pointer-events: none; }
main.hero-bg .text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9; width: 100%; padding: 0 1rem; text-align: center; text-transform: uppercase; color: #FEFEFE; pointer-events: auto; }
main.hero-bg .text h1 { font-weight: 800; font-size: clamp(2.8rem, 7vw, 6.4rem); line-height: 0.95; letter-spacing: -0.01em; margin: 0; }
main.hero-bg .text h2 { font-weight: 300; font-size: clamp(2.1rem, 5.2vw, 4.8rem); line-height: 1; margin-top: 0.15em; letter-spacing: 0.02em; }
.scroll-hint { opacity: calc(1 - var(--hero-p) * 2.5); position: absolute; z-index: 998; bottom: 1rem; right: 1.5rem; color: rgba(255, 255, 255, 0.75); font-size: 0.7rem; letter-spacing: 0.05em; display: flex; flex-direction: column; align-items: center; gap: 0.4rem; }
.scroll-hint i { animation: bounce 1.8s infinite; }
@keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(6px); } }

/* Desktop & tablet: hero memenuhi satu layar penuh (tinggi layar dikurangi navbar + jarak atas) */
@media (min-width: 726px) {
  main.hero-bg { height: calc(100vh - var(--hero-top, 96px)); height: calc(100svh - var(--hero-top, 96px)); min-height: 440px; }
}

@media (max-width: 725px) {
  .hero-frame { padding: 14px 0 0; }
  main.hero-bg { height: auto; aspect-ratio: 16 / 9; min-height: 200px; }
  main.hero-bg .text h1 { font-size: clamp(1.9rem, 9vw, 2.6rem); }
  main.hero-bg .text h2 { font-size: clamp(1.4rem, 6.5vw, 1.9rem); }
  main.hero-bg .text { top: 50%; }
  .scroll-hint { display: none; }
}

/* ===== TENTANG KAMI ===== */
.tentang-kami-cloneable {
  padding: 0.8rem var(--side-gap) 5.5rem; /* jarak kiri-kanan sama dengan bingkai Hero */
  display: flex; flex-direction: column; align-items: center; justify-content: flex-start;
  position: relative; font-size: 1.1vw; background: #ffffff; color: #131313; overflow: hidden;
}

@supports (background: paint(something)) {
  .tentang-kami-cloneable {
    --ring-radius: 100; --ring-thickness: 600; --particle-count: 80; --particle-rows: 25;
    --particle-size: 2; --particle-color: #094356; --particle-min-alpha: 0.08;
    --particle-max-alpha: 0.9; --seed: 200; background-image: paint(ring-particles);
  }
}
@property --animation-tick { syntax: '<number>'; inherits: false; initial-value: 0; }
@property --ring-radius { syntax: '<number> | auto'; inherits: false; initial-value: auto; }
@property --ring-x { syntax: '<number>'; inherits: false; initial-value: 50; }
@property --ring-y { syntax: '<number>'; inherits: false; initial-value: 50; }
@property --ring-interactive { syntax: '<number>'; inherits: false; initial-value: 0; }
@keyframes tentang-ripple { 0% { --animation-tick: 0; } 100% { --animation-tick: 1; } }
@keyframes tentang-ring { 0% { --ring-radius: 150; } 100% { --ring-radius: 250; } }

.tentang-kami-cloneable { animation: tentang-ripple 6s linear infinite, tentang-ring 6s ease-in-out infinite alternate; transition: --ring-x 3s ease, --ring-y 3s ease; }
.tentang-kami-cloneable.interactive { transition-duration: 0.25s; }

.tab-layout { display: flex; flex-flow: row wrap; gap: 3em; width: 100%; position: relative; z-index: 1; }
.tentang-kami-top { width: 100%; margin-bottom: 1em; }
.tentang-kami-top .eyebrow { display: inline-flex; align-items: center; gap: 0.75em; font-size: 0.85em; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(9, 67, 86, 0.7); }
.tentang-kami-top .eyebrow::before { content: ""; width: 2.2em; height: 2px; background: #094356; }

.tab-layout-col { width: calc(50% - 1.5em); }
.tab-layout-col:first-child { display: flex; align-items: flex-start; }
/* max-width diubah menjadi none agar teks memanjang mentok kiri */
.tab-layout-container { width: 100%; max-width: none; padding-bottom: 1em; }
.tab-container { display: flex; flex-direction: column; gap: 1.5em; padding-right: 2.5em; }
.tab-container-top, .tab-container-bottom { display: flex; flex-direction: column; gap: 2em; }

.tab-layout-heading { margin: 0; font-size: 2.8em; font-weight: 700; line-height: 1.05; color: #094356; }
.tab-content-wrap { width: 100%; position: relative; }
.tab-content-item { display: none; flex-direction: column; gap: 1.25em; }
.tab-content-item.active { display: flex; }
.tab-content__heading { margin: 0; font-size: 1.6em; font-weight: 600; line-height: 1; color: #094356; letter-spacing: -.02em; }
.content-p { margin: 0; font-size: 1.1em; line-height: 1.65; color: rgba(19, 19, 19, 0.75); }

.tab-visual-wrap { border-radius: 8px; width: 100%; height: 100%; min-height: 24em; position: relative; overflow: hidden; }
.tab-visual-item { visibility: hidden; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: absolute; inset: 0; }
.tab-visual-item.active { visibility: visible; }
.tab-image { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }

@media (max-width: 991px) {
  .tentang-kami-cloneable { padding: 1.5em var(--side-gap) 3.5em; font-size: 14px; }
  .tab-layout { flex-direction: column; gap: 1.5em; }
  .tab-layout-col { width: 100%; }
  .tab-container { padding-right: 0; }
  .tab-layout-heading { font-size: 1.75em; line-height: 1.2; }
  .tab-content__heading { font-size: 1.25em; }
  .content-p { font-size: 0.95em; }
  .tab-visual-wrap { height: 16em; min-height: 16em; max-height: 40vh; }
}

/* ===== FAQ SECTION ===== */
.project { position: relative; z-index: 1; background: #FFFFFF; color: #111111; padding: 5rem var(--side-gap) 6.5rem; border-top: 1px solid rgba(0, 0, 0, 0.06); }
.project .container-global { max-width: none; }
.faq-layout { display: grid; grid-template-columns: minmax(0, 360px) minmax(0, 620px); grid-template-rows: auto 1fr; grid-template-areas: "text list" "cta list"; justify-content: space-between; align-items: start; column-gap: 3.5rem; row-gap: 2.25rem; }
.faq-text { grid-area: text; display: flex; flex-direction: column; }
.faq-eyebrow { display: inline-flex; align-items: center; gap: 0.5rem; width: fit-content; font-family: var(--font-sans); font-size: 0.72rem; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: #0a6b86; background: rgba(8, 75, 95, 0.06); border: 1px solid rgba(8, 75, 95, 0.18); padding: 0.4rem 0.9rem; border-radius: 999px; margin-bottom: 1rem; }
.faq-text h3 { margin-bottom: 1rem; color: #111111; font-size: 2.2rem; }
.faq-desc { margin-bottom: 0; color: rgba(17, 17, 17, 0.62); line-height: 1.7; }

.faq-cta { grid-area: cta; background: #FAFAFA; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 18px; padding: 1.75rem 1.75rem 2rem; }
.faq-cta h4 { font-family: var(--font-sans); font-size: 1.15rem; font-weight: 700; color: #111111; margin-bottom: 0.6rem; }
.faq-cta p { font-size: 0.88rem; line-height: 1.65; color: rgba(17, 17, 17, 0.6); margin-bottom: 1.4rem; }
.faq-cta-btn { display: inline-flex; align-items: center; justify-content: center; background: #084b5f; color: #FFFFFF; font-size: 0.88rem; font-weight: 700; text-decoration: none; padding: 0.85rem 1.5rem; border-radius: 999px; transition: 0.25s ease; }
.faq-cta-btn:hover { background: #0a6b86; transform: translateY(-2px); }

.faq-list { grid-area: list; display: flex; flex-direction: column; }
.faq-item { background: transparent; border-bottom: 1px solid rgba(0, 0, 0, 0.1); transition: border-color 0.25s ease; }
.faq-item:first-child { border-top: 1px solid rgba(0, 0, 0, 0.1); }
.faq-item.active { border-color: rgba(0, 0, 0, 0.1); }
.faq-question { width: 100%; display: flex; align-items: center; justify-content: space-between; gap: 1rem; background: none; border: none; cursor: pointer; text-align: left; padding: 1.35rem 3px 1.35rem 0; font-family: var(--font-sans); font-size: 1rem; font-weight: 500; color: #111111; transition: color 0.2s ease; }
.faq-item.active .faq-question, .faq-question:hover { color: #084b5f; }

.faq-icon { flex-shrink: 0; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid rgba(0, 0, 0, 0.15); color: #111111; transition: 0.3s ease; }
.faq-item.active .faq-icon { background: #084b5f; border-color: #084b5f; color: #FFFFFF; transform: rotate(-45deg) scale(1.1); }

.faq-answer { display: grid; grid-template-rows: 0fr; transition: grid-template-rows 0.35s ease; }
.faq-item.active .faq-answer { grid-template-rows: 1fr; }
.faq-answer-inner { overflow: hidden; }
.faq-answer p { padding: 0 2.4rem 1.5rem 0; font-size: 0.92rem; line-height: 1.7; color: rgba(17, 17, 17, 0.62); margin: 0; }

@media (max-width: 900px) {
  .faq-layout { grid-template-columns: 1fr; grid-template-areas: "text" "list" "cta"; row-gap: 2rem; }
  .faq-text h3 { font-size: 1.7rem; }
}
@media (min-width: 901px) { .faq-desc { font-size: 1.15rem; } }
@media (max-width: 500px) {
  .faq-question { padding: 1.1rem 3px 1.1rem 0; font-size: 0.92rem; }
  .faq-answer p { padding: 0 0 1.35rem; }
  .faq-cta { padding: 1.5rem 1.4rem 1.75rem; }
}

/* ===== DARK MODE ===== */
html, body { margin: 0; background-color: #FFFFFF; overflow-x: hidden; }
html[data-theme="dark"], html[data-theme="dark"] body { background-color: #0a0f1a; color: #e8eef0; }
html[data-theme="dark"] { color-scheme: dark; }

.hero-frame, .tentang-kami-cloneable, .project { transition: background-color 0.5s ease, color 0.5s ease; }

html[data-theme="dark"] .hero-frame { background: #0a0f1a; }
html[data-theme="dark"] .hero-bg__img { filter: brightness(0.72) saturate(0.95); }

html[data-theme="dark"] .tentang-kami-cloneable { background-color: #0a0f1a; color: #e8eef0; --particle-color: #8fd0bf; }
html[data-theme="dark"] .tab-layout-heading, html[data-theme="dark"] .tab-content__heading { color: #eef6f3; }
html[data-theme="dark"] .content-p { color: rgba(232, 238, 240, 0.74); }
html[data-theme="dark"] .tentang-kami-top .eyebrow { color: #8fd0bf; }
html[data-theme="dark"] .tentang-kami-top .eyebrow::before { background: #8fd0bf; }
html[data-theme="dark"] .tab-visual-wrap { box-shadow: 0 18px 40px rgba(0, 0, 0, 0.45); }

html[data-theme="dark"] .project { background: #0a0f1a; color: #e8eef0; border-top-color: rgba(255, 255, 255, 0.08); }
html[data-theme="dark"] .faq-eyebrow { color: #8fd0bf; background: rgba(143, 208, 191, 0.08); border-color: rgba(143, 208, 191, 0.28); }
html[data-theme="dark"] .faq-text h3 { color: #eef6f3; }
html[data-theme="dark"] .faq-desc { color: rgba(232, 238, 240, 0.65); }
html[data-theme="dark"] .faq-cta { background: #131a2c; border-color: rgba(255, 255, 255, 0.1); }
html[data-theme="dark"] .faq-cta h4 { color: #eef6f3; }
html[data-theme="dark"] .faq-cta p { color: rgba(232, 238, 240, 0.65); }
html[data-theme="dark"] .faq-cta-btn { background: #0d6f86; }
html[data-theme="dark"] .faq-cta-btn:hover { background: #128aa5; }
html[data-theme="dark"] .faq-item, html[data-theme="dark"] .faq-item:first-child { border-color: rgba(255, 255, 255, 0.12); }
html[data-theme="dark"] .faq-item.active { border-color: rgba(255, 255, 255, 0.12); }
html[data-theme="dark"] .faq-question { color: #e8eef0; }
html[data-theme="dark"] .faq-question:hover, html[data-theme="dark"] .faq-item.active .faq-question { color: #8fd0bf; }
html[data-theme="dark"] .faq-icon { border-color: rgba(255, 255, 255, 0.22); color: #e8eef0; }
html[data-theme="dark"] .faq-item.active .faq-icon { background: #0d6f86; border-color: #0d6f86; color: #ffffff; }
html[data-theme="dark"] .faq-answer p { color: rgba(232, 238, 240, 0.68); }
</style>
@endpush

@section('content')
@php $ps = \App\Models\PageSetting::for('beranda'); @endphp
<div class="hero-frame">
  <main class="hero-bg">
    <img src="{{ $ps->bgUrl() ?? asset('image/asta 3.jpg') }}" loading="eager" alt="" class="hero-bg__img">
    <div class="hero-gradient"></div>
    <div class="text">
      <h1>Astabrata </h1>
      <h2>Teknologi</h2>
    </div>
    <div class="scroll-hint">
      <span>Scroll</span>
      <i class="fa-solid fa-chevron-down"></i>
    </div>
  </main>
</div>

<section class="tentang-kami-cloneable">
  <!-- .container-global DIHAPUS KHUSUS DI SINI AGAR FULL-WIDTH -->
  <div class="tentang-kami-top">
    <span class="eyebrow reveal">Selamat Datang di </span>
  </div>
  <div data-tabs="wrapper" class="tab-layout">
    <!-- Deskripsi / Teks Tampil Pertama di Layar HP -->
    <div class="tab-layout-col">
      <div class="tab-layout-container">
        <div class="tab-container">
          <div class="tab-container-top">
            <h1 class="tab-layout-heading reveal reveal-delay-1">{{ $welcome->title ?? 'PT Astabrata Teknologi' }}</h1>
          </div>
          <div class="tab-container-bottom">
            <div data-tabs="content-wrap" class="tab-content-wrap">
              <div data-tabs="content-item" class="tab-content-item active">
                <h2 data-tabs-fade="" class="tab-content__heading reveal">{{ $welcome->subtitle ?? 'Solusi Digital Terpadu' }}</h2>
                <p data-tabs-fade="" class="content-p reveal reveal-delay-1">
                  {{ $welcome->description ?? 'PT Astabrata Teknologi adalah perusahaan teknologi yang berfokus pada perancangan dan pengembangan solusi digital untuk membantu bisnis tumbuh di era yang serba terhubung. Kami memadukan strategi, desain, dan rekayasa perangkat lunak untuk menghadirkan produk digital yang berkesan bagi penggunanya.' }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Gambar Tampil di Bawah Deskripsi pada Layar HP -->
    <div class="tab-layout-col">
      <div data-tabs="visual-wrap" class="tab-visual-wrap reveal reveal-scale reveal-delay-2">
        <div data-tabs="visual-item" class="tab-visual-item active">
          <img src="{{ isset($welcome) && $welcome->image ? (\Illuminate\Support\Str::startsWith($welcome->image, ['http://', 'https://']) ? $welcome->image : asset('storage/' . $welcome->image)) : asset('image/beranda.jpeg') }}" loading="lazy" alt="Tim PT Astabrata Teknologi berkolaborasi" class="tab-image">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="project" id="faq">
  <div class="container-global">
    <div class="faq-layout">
      <div class="faq-text">
        <span class="faq-eyebrow reveal">FAQ</span>
        @include('partials.page-style', ['ps' => $ps])
        <h3 class="reveal reveal-delay-1">{{ $ps->titleText() }}</h3>
        <p class="section-subtitle reveal reveal-delay-2 faq-desc">
          {{ $ps->descriptionText() }}
        </p>
      </div>

      <div class="faq-list">
        @forelse (($faqs ?? []) as $faq)
        <div class="faq-item {{ $loop->first ? 'active' : '' }} reveal">
          <button class="faq-question" type="button" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
            <span>{{ $faq->question }}</span>
            <span class="faq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>{{ $faq->answer }}</p>
            </div>
          </div>
        </div>
        @empty
        <div class="faq-item reveal">
          <div class="faq-answer-inner">
            <p>Belum ada FAQ yang ditambahkan.</p>
          </div>
        </div>
        @endforelse
      </div>

      <div class="faq-cta reveal">
        <h4>Masih punya pertanyaan?</h4>
        <p>Tidak menemukan jawaban yang Anda cari? Hubungi kami dan tim kami akan membalas secepat mungkin.</p>
        <a href="{{ url('/contact') }}" class="faq-cta-btn">Hubungi</a>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Flip.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/CustomEase.min.js'></script>
<script>
// ===== SCRIPT GABUNGAN: Partikel, GSAP, Reveal, dan FAQ =====
(function () {
  // 1. Navbar Lock & Hero Text Anim
  const nav = document.getElementById('navHeader');
  if (nav) {
    const lock = () => { if (!nav.classList.contains('scrolled')) nav.classList.add('scrolled'); };
    lock();
    new MutationObserver(lock).observe(nav, { attributes: true, attributeFilter: ['class'] });
    const frame = document.querySelector('.hero-frame');
    const pos = getComputedStyle(nav).position;
    if (frame && (pos === 'fixed' || pos === 'absolute')) {
      // Letakkan hero PERSIS di bawah navbar (desktop: menempel, mobile: jarak 14px).
      // Dihitung dari posisi asli di dokumen, jadi spasi/padding lain di atasnya (layout, dll.) ikut dikoreksi.
      const setPad = () => {
        const gap = window.innerWidth <= 725 ? 14 : 0;
        const navH = nav.getBoundingClientRect().height;
        frame.style.paddingTop = '0px';
        frame.style.marginTop = '0px';
        const offset = frame.getBoundingClientRect().top + window.scrollY; // posisi hero tanpa koreksi
        const need = navH + gap - offset;
        if (need >= 0) { frame.style.paddingTop = need + 'px'; }
        else { frame.style.marginTop = need + 'px'; }                      // ada spasi berlebih di atas: tarik naik
        frame.style.setProperty('--hero-top', (navH + gap) + 'px');        // dipakai CSS untuk tinggi hero satu layar
      };
      setPad();
      window.addEventListener('resize', setPad);
      window.addEventListener('load', setPad);
      nav.addEventListener('transitionend', setPad);                       // navbar mengecil saat 'scrolled' (ada transisi)
      if ('ResizeObserver' in window) new ResizeObserver(setPad).observe(nav);
    }
  }

  // Hero: full layar di awal, lalu di-crop kiri-kanan sampai sejajar dengan teks di bawahnya.
  //  - Desktop/tablet: scroll halaman DITAHAN dulu; gerakan scroll hanya menjalankan animasi crop.
  //    Setelah crop selesai, scroll ke bawah berjalan normal. Scroll naik di paling atas membalik animasinya.
  //  - Mobile: animasi crop mengikuti posisi scroll biasa.
  (function () {
    const frame = document.querySelector('.hero-frame');
    if (!frame) return;
    const desktop = window.matchMedia('(min-width: 726px)');
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)');
    const DIST = 420;                       // jumlah gerakan scroll (px) untuk satu animasi crop penuh
    const ease = (t) => t * t * (3 - 2 * t);
    let target = 0, shown = 0, raf = null, ticking = false;

    const locked = () => desktop.matches && !reduce.matches;
    const atTop = () => window.scrollY <= 0;
    const menuOpen = () => document.body.style.overflow === 'hidden';
    const render = (p) => frame.style.setProperty('--hero-p', p.toFixed(3));

    // --- Mode scroll biasa (mobile) ---
    const updateLinked = () => {
      ticking = false;
      if (reduce.matches) { render(0); return; }
      const dist = Math.max(220, frame.offsetHeight * 0.55);
      const t = Math.min(1, Math.max(0, window.scrollY / dist));
      render(ease(t));
    };

    // --- Mode tahan scroll (desktop) ---
    const step = () => {
      shown += (target - shown) * 0.14;
      if (Math.abs(target - shown) < 0.002) shown = target;
      render(ease(shown));
      raf = (shown !== target) ? requestAnimationFrame(step) : null;
    };
    const kick = () => { if (!raf) raf = requestAnimationFrame(step); };
    const canScrollDown = () => target < 1 || shown < 1;   // masih menunggu animasi crop selesai
    const canScrollUp = () => target > 0 || shown > 0;

    const nudge = (dy, e) => {
      if (dy > 0 && canScrollDown()) { e.preventDefault(); target = Math.min(1, target + dy / DIST); kick(); }
      else if (dy < 0 && canScrollUp()) { e.preventDefault(); target = Math.max(0, target + dy / DIST); kick(); }
    };

    window.addEventListener('wheel', (e) => {
      if (!locked() || !atTop() || menuOpen() || e.ctrlKey) return;
      if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;
      let dy = e.deltaY;
      if (e.deltaMode === 1) dy *= 16; else if (e.deltaMode === 2) dy *= window.innerHeight;
      nudge(dy, e);
    }, { passive: false });

    let touchY = null;
    window.addEventListener('touchstart', (e) => { touchY = e.touches[0].clientY; }, { passive: true });
    window.addEventListener('touchmove', (e) => {
      if (touchY === null || !locked() || !atTop() || menuOpen()) return;
      const y = e.touches[0].clientY;
      const dy = touchY - y;
      touchY = y;
      nudge(dy, e);
    }, { passive: false });

    window.addEventListener('keydown', (e) => {
      if (!locked() || !atTop() || menuOpen() || e.altKey || e.ctrlKey || e.metaKey) return;
      const tag = (e.target && e.target.tagName) || '';
      if (/^(INPUT|TEXTAREA|SELECT|BUTTON|A)$/.test(tag) || (e.target && e.target.isContentEditable)) return;
      const down = e.key === 'ArrowDown' || e.key === 'PageDown' || e.key === 'End' || (e.key === ' ' && !e.shiftKey);
      const up = e.key === 'ArrowUp' || e.key === 'PageUp' || e.key === 'Home' || (e.key === ' ' && e.shiftKey);
      if (down && canScrollDown()) { e.preventDefault(); target = 1; kick(); }
      else if (up && canScrollUp()) { e.preventDefault(); target = 0; kick(); }
    });

    const sync = () => {
      if (locked()) {
        // Kalau halaman sudah turun (mis. klik link #faq atau scroll lewat scrollbar), langsung selesaikan crop
        if (!atTop() && target < 1) { target = 1; kick(); }
      } else if (!ticking) {
        ticking = true; requestAnimationFrame(updateLinked);
      }
    };
    window.addEventListener('scroll', sync, { passive: true });

    const init = () => {
      if (locked()) { target = shown = atTop() ? 0 : 1; render(ease(shown)); }
      else updateLinked();
    };
    window.addEventListener('resize', init);
    init();
  })();

  if (typeof gsap !== "undefined") {
    gsap.from(".hero-bg .text h1", { y: 60, opacity: 0, duration: 1.2, ease: "power3.out" });
    gsap.from(".hero-bg .text h2", { y: -40, opacity: 0, duration: 1.2, delay: 0.2, ease: "power3.out" });
  }

  // 2. Efek Partikel Tentang Kami (Houdini)
  if ('paintWorklet' in CSS) {
    CSS.paintWorklet.addModule('https://unpkg.com/css-houdini-ringparticles/dist/ringparticles.js');
    // Posisi cincin partikel dikunci di tengah section (--ring-x/--ring-y = 50), tidak mengikuti kursor
  }

  // 3. Reveal Animation (Elemen Muncul Halus)
  try {
    const revealEls = document.querySelectorAll(".reveal");
    if (revealEls.length && !window.matchMedia("(prefers-reduced-motion: reduce)").matches && ("IntersectionObserver" in window)) {
      const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => entry.target.classList.toggle("in-view", entry.isIntersecting));
      }, { threshold: 0.15, rootMargin: "0px 0px -8% 0px" });
      revealEls.forEach(el => revealObserver.observe(el));
    } else {
      revealEls.forEach(el => el.classList.add("in-view"));
    }
  } catch (err) { document.querySelectorAll(".reveal").forEach(el => el.classList.add("in-view")); }

  // 4. FAQ Accordion Logic
  const faqItems = document.querySelectorAll('.faq-item');
  if (faqItems.length) {
    faqItems.forEach((item) => {
      const question = item.querySelector('.faq-question');
      if (!question) return;
      question.addEventListener('click', () => {
        const isActive = item.classList.contains('active');
        faqItems.forEach(other => {
          other.classList.remove('active');
          if(other.querySelector('.faq-question')) other.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
        });
        if (!isActive) { item.classList.add('active'); question.setAttribute('aria-expanded', 'true'); }
      });
    });
  }
})();
</script>
@endpush