@extends('layouts.app')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,
*::before,
*::after {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

:root {
  --ink: #0B1412;
  --forest: #10241C;
  --deep-teal: #0E3A3A;
  --primary: #145C4B;
  --primary-soft: #1A6B58;
  --mint: #9FD6B9;
  --mint-bright: #B8E6CE;
  --sage: #7BA892;
  --gold: #C4A574;
  --gold-soft: #D4BC8E;
  --cream: #F7F3EC;
  --cream-warm: #EFE8DC;
  --ivory: #FBFAF7;
  --stone: #E8E2D8;
  --muted: #6B736E;
  --text: #1C2421;
  --text-soft: rgba(28, 36, 33, 0.72);
  --glass: rgba(255, 255, 255, 0.08);
  --glass-border: rgba(255, 255, 255, 0.14);
  --shadow-soft: 0 20px 50px rgba(11, 20, 18, 0.08);
  --shadow-lift: 0 28px 60px rgba(11, 20, 18, 0.14);
  --radius-lg: 28px;
  --radius-md: 18px;
  --radius-sm: 12px;
  /* Satu keluarga font untuk seluruh halaman: simple & modern */
  --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
  --font-display: var(--font-sans);
  --font-heading: var(--font-sans);
  --font-body: var(--font-sans);
}

html {
  background-color: var(--ivory);
  scroll-behavior: smooth;
  -webkit-text-size-adjust: 100%;
}

body {
  font-family: var(--font-sans);
  color: var(--text);
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-rendering: optimizeLegibility;
}

/* Heading memakai font yang sama dengan body, dibedakan lewat ukuran & ketebalan */
h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-sans);
  letter-spacing: -0.01em;
}

/* Tombol & form tidak otomatis mewarisi font, jadi dipaksa ikut */
button, input, textarea, select {
  font-family: var(--font-sans);
}


/* ===== Hero frame: bingkai terang di sekeliling gambar hero + efek inverted border-radius ===== */
.hero-frame {
  position: relative;
  padding: 22px;
  background: #FFFFFF;
}

/* logo di pojok kiri atas, menyatu dengan gambar lewat lengkungan cekung (teknik circle + box-shadow) */
.brand-badge {
  position: absolute;
  z-index: 160;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  gap: 0.6rem;
  background: #FFFFFF;
  color: #094356;
  padding: 16px 22px 16px 16px;
  border-radius: 26px 0 26px 0;
}
.brand-badge::before,
.brand-badge::after {
  content: "";
  position: absolute;
  width: 26px;
  height: 26px;
  background: transparent;
  border-radius: 50%;
}
.brand-badge::before {
  top: 0;
  right: -26px;
  box-shadow: -12px -12px 0 0 #FFFFFF;
}
.brand-badge::after {
  bottom: -26px;
  left: 0;
  box-shadow: -12px -12px 0 0 #FFFFFF;
}
.brand-badge__icon {
  flex-shrink: 0;
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: #094356;
  color: #7C9BA6;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.05rem;
}
.brand-badge__text {
  font-family: var(--font-sans);
  font-weight: 700;
  font-size: 0.92rem;
  line-height: 1.25;
  letter-spacing: 0.03em;
  text-transform: uppercase;
  color: #094356;
}

/* tombol menu di pojok kanan atas, mengambang di atas warna frame */
.menu-btn {
  position: absolute;
  z-index: 200;
  top: 20px;
  right: 20px;
  width: 44px;
  height: 44px;
  border: none;
  border-radius: 50%;
  background: #094356;
  color: #EDEDED;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  cursor: pointer;
}

/* kartu kepercayaan di pojok kanan bawah, menyatu dengan gambar lewat lengkungan cekung yang sama */
.trust-badge {
  position: absolute;
  z-index: 160;
  bottom: 0;
  right: 0;
  max-width: 270px;
  background: #FFFFFF;
  color: #094356;
  padding: 22px 26px;
  border-radius: 26px 0 26px 0;
}
.trust-badge::before,
.trust-badge::after {
  content: "";
  position: absolute;
  width: 26px;
  height: 26px;
  background: transparent;
  border-radius: 50%;
}
.trust-badge::before {
  top: -26px;
  right: 0;
  box-shadow: 12px 12px 0 0 #FFFFFF;
}
.trust-badge::after {
  bottom: 0;
  left: -26px;
  box-shadow: 12px 12px 0 0 #FFFFFF;
}
.trust-badge h4 {
  font-family: var(--font-sans);
  font-size: 0.98rem;
  font-weight: 700;
  letter-spacing: 0.02em;
  text-transform: uppercase;
  color: #094356;
  margin-bottom: 0.5rem;
}
.trust-badge p {
  font-size: 0.82rem;
  line-height: 1.55;
  font-weight: 400;
  color: rgba(9, 67, 86, 0.75);
  margin-bottom: 0.9rem;
}
.trust-rating {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  flex-wrap: wrap;
}
.trust-rating .stars {
  color: #094356;
  font-size: 0.85rem;
  letter-spacing: 0.15rem;
}
.trust-rating b { color: #094356; font-weight: 700; }
.trust-rating .count { font-size: 0.78rem; color: rgba(9, 67, 86, 0.7); }

main {
  position: relative;
  height: calc(100vh - 44px);
  width: 100%;
  overflow: hidden;
  touch-action: pan-y;
  border-radius: 34px;
}


.parallax {
  pointer-events: none;
  transition: 0.45s cubic-bezier(.2, .49, .32, .99);
  will-change: transform;
}
.bg-img { position: absolute; width: 194.44%; top: 1.86%; left: 50.69%; z-index: 1; }
.fog-7 { z-index: 2; position: absolute; width: 132%; top: 37.7%; left: 70.8%; }
.mountain-10 { z-index: 3; position: absolute; width: 71.52%; top: 63.58%; left: 67.84%; }
.fog-6 { z-index: 4; position: absolute; width: 127.50%; top: 61.73%; left: 50.49%; }
.mountain-9 { z-index: 5; position: absolute; width: 32.15%; top: calc(50% + 14.69%); left: calc(50% - 31.74%); }
.mountain-8 { z-index: 6; position: absolute; width: 54.58%; top: calc(50% + 11.85%); left: calc(50% - 14.03%); }
.fog-5 { z-index: 7; position: absolute; width: 31.18%; top: calc(50% + 21.11%); left: calc(50% + 2.01%); }
.mountain-7 { z-index: 8; position: absolute; width: 31.18%; top: calc(50% + 21.11%); left: calc(50% + 2.01%); }

.text {
  position: absolute;
  z-index: 9;
  top: calc(50% - 16.05%);
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  text-transform: uppercase;
  color: #FEFEFE;
  pointer-events: auto;
}
.text h2 { font-weight: 300; font-size: 6.5rem; line-height: 0.88; letter-spacing: 0.02em; }
.text h1 { font-weight: 800; font-size: 8rem; line-height: 0.88; letter-spacing: -0.01em; }

.mountain-6 { z-index: 10; position: absolute; width: 26.68%; top: calc(50% + 10.68%); left: calc(50% + 40.97%); }
.fog-4 { z-index: 11; position: absolute; width: 37.71%; top: calc(50% + 29.88%); left: calc(50% - 4.44%); }
.mountain-5 { z-index: 12; position: absolute; width: 37.36%; top: calc(50% + 33.09%); left: calc(50% + 9.03%); }
.fog-3 { z-index: 13; position: absolute; width: 99.65%; top: calc(50% + 18.43%); left: calc(50% - 1.94%); }
.mountain-4 { z-index: 14; position: absolute; width: 49.79%; top: calc(50% + 27.28%); left: calc(50% - 26.45%); }
.mountain-3 { z-index: 15; position: absolute; top: 61.35%; left: 101.11%; width: 32.22%; }
.fog-2 { z-index: 16; position: absolute; top: 68.14%; left: 48%; width: 108.33%; }
.mountain-2 { z-index: 17; position: absolute; top: 69.01%; left: 78.61%; width: 47.91%; }
.mountain-1 { position: absolute; z-index: 18; top: 52%; left: 8.27%; width: 37.15%; }
.sun-rays { position: absolute; z-index: 19; top: 0; right: 0; width: 595px; pointer-events: none; }
.black-shadow { position: absolute; z-index: 20; bottom: 0; right: 0; width: 100%; pointer-events: none; }
.fog-1 { z-index: 21; position: absolute; top: 59.26%; left: 50.69%; width: 111.8%; }

.vignette {
  position: absolute;
  z-index: 100;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
  background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0) 65%, rgba(0, 0, 0, 0.7));
}

/* tombol izin giroskop untuk iOS */
.gyro-btn {
  position: absolute;
  z-index: 998;
  bottom: 1.5rem;
  left: 50%;
  transform: translateX(-50%);
  padding: 0.6rem 1.2rem;
  border-radius: 999px;
  border: 1px solid rgba(255, 255, 255, 0.4);
  background: rgba(0, 0, 0, 0.35);
  backdrop-filter: blur(6px);
  color: #FEFEFE;
  font-family: var(--font-sans);
  font-size: 0.75rem;
  letter-spacing: 0.03em;
  cursor: pointer;
  display: none;
}
.gyro-btn.show { display: block; }

.scroll-hint {
  position: absolute;
  z-index: 998;
  bottom: 1.5rem;
  right: 2rem;
  color: rgba(255, 255, 255, 0.75);
  font-size: 0.7rem;
  letter-spacing: 0.05em;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.4rem;
}
.scroll-hint i { animation: bounce 1.8s infinite; }
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(6px); }
}

/* section penjelasan di bawah */
.info {
  position: relative;
  z-index: 1;
  background: #ededed;
  color: #2b2b2b;
  min-height: 100vh;
  display: flex;
  align-items: center;
  padding: 5rem 1.5rem;
}
.info-inner {
  max-width: 1180px;
  margin: 0 auto;
  display: flex;
  align-items: center;
  gap: 3.5rem;
  width: 100%;
}
.info-text {
  flex: 1 1 55%;
  min-width: 0;
}
.info-image {
  flex: 1 1 40%;
  align-self: stretch;
}
.info-image img {
  width: 100%;
  height: 100%;
  min-height: 320px;
  object-fit: cover;
  border-radius: 20px;
  box-shadow: 0 20px 45px rgba(0, 0, 0, 0.28);
  display: block;
}
@media (max-width: 900px) {
  .info-inner { gap: 2rem; }
  .info-image img { min-height: 260px; }
}
.info h3 {
  font-family: var(--font-sans);
  font-size: 2.2rem;
  font-weight: 700;
  letter-spacing: -0.01em;
  margin-bottom: 1rem;
  color: #094356;
}
.info .eyebrow {
  display: block;
  font-family: var(--font-sans);
  font-size: 0.78rem;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: #094356;
  opacity: 0.85;
  margin-bottom: 0.7rem;
}
.info p {
  font-size: 1rem;
  line-height: 1.75;
  font-weight: 300;
  color: rgba(9, 67, 86, 0.75);
  margin-bottom: 1.3rem;
  max-width: 68ch;
}
.info .reveal {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}
.info .reveal.in-view {
  opacity: 1;
  transform: translateY(0);
}
.info .steps {
  display: grid;
  gap: 1.1rem;
  margin-top: 2.2rem;
}
.info .step {
  border-left: 2px solid #7C9BA6;
  padding-left: 1rem;
}
.info .step b {
  display: block;
  font-family: var(--font-sans);
  color: #094356;
  font-weight: 600;
  margin-bottom: 0.2rem;
}
.info .step span {
  font-size: 0.9rem;
  color: rgba(9, 67, 86, 0.65);
  font-weight: 300;
}

/* section Layanan */
.layanan {
  position: relative;
  z-index: 1;
  background: #094356;
  color: #EDEDED;
  padding: 5rem 1.5rem 6rem;
  border-top: 1px solid rgba(124, 155, 166, 0.08);
}
.layanan-inner,
.project-inner {
  max-width: 1080px;
  margin: 0 auto;
}
.layanan h3,
.project h3 {
  font-family: var(--font-sans);
  font-size: 2.2rem;
  font-weight: 700;
  letter-spacing: -0.01em;
  margin-bottom: 0.75rem;
  color: #7C9BA6;
}
.section-subtitle {
  font-size: 1rem;
  font-weight: 300;
  line-height: 1.7;
  color: rgba(237, 237, 237, 0.7);
  max-width: 62ch;
  margin-bottom: 2.75rem;
}
.layanan-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
  gap: 1.5rem;
}
.layanan-card {
  background: rgba(124, 155, 166, 0.04);
  border: 1px solid rgba(124, 155, 166, 0.14);
  border-radius: 14px;
  padding: 1.9rem 1.6rem;
  transition: transform 0.3s ease, border-color 0.3s ease, background 0.3s ease;
}
.layanan-card:hover {
  transform: translateY(-6px);
  border-color: #7C9BA6;
  background: rgba(124, 155, 166, 0.08);
}
.layanan-card i {
  font-size: 1.5rem;
  color: #7C9BA6;
  margin-bottom: 1.1rem;
  display: inline-block;
}
.layanan-card h4 {
  font-family: var(--font-sans);
  font-size: 1.05rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #EDEDED;
}
.layanan-card p {
  font-size: 0.88rem;
  line-height: 1.65;
  font-weight: 300;
  color: rgba(237, 237, 237, 0.68);
  margin: 0;
}

/* section FAQ (Pertanyaan Umum) */
.project {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  color: #111111;
  padding: 5rem 1.5rem 6.5rem;
  border-top: 1px solid rgba(0, 0, 0, 0.06);
}
/* ===== FAQ (Pertanyaan Umum): teks + CTA di kiri, accordion di kanan =====
   Desktop : [teks]  [accordion]
             [CTA ]  [accordion]
   Mobile  : teks -> accordion -> CTA ("Masih punya pertanyaan?" di bawah daftar pertanyaan) */
.faq-layout {
  display: grid;
  grid-template-columns: minmax(0, 360px) minmax(0, 620px);
  grid-template-rows: auto 1fr;
  grid-template-areas:
    "text list"
    "cta  list";
  justify-content: space-between;
  align-items: start;
  column-gap: 3.5rem;
  row-gap: 2.25rem;
}
.faq-text {
  grid-area: text;
  min-width: 0;
  display: flex;
  flex-direction: column;
}
.faq-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  width: fit-content;
  font-family: var(--font-sans);
  font-size: 0.72rem;
  font-weight: 600;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: #0a6b86;
  background: rgba(8, 75, 95, 0.06);
  border: 1px solid rgba(8, 75, 95, 0.18);
  padding: 0.4rem 0.9rem;
  border-radius: 999px;
  margin-bottom: 1rem;
}
.faq-text h3 { margin-bottom: 1rem; color: #111111; }
.faq-desc { margin-bottom: 0; color: rgba(17, 17, 17, 0.62); }

.faq-cta {
  grid-area: cta;
  background: #FAFAFA;
  border: 1px solid rgba(0, 0, 0, 0.08);
  border-radius: 18px;
  padding: 1.75rem 1.75rem 2rem;
}
.faq-cta h4 {
  font-family: var(--font-sans);
  font-size: 1.15rem;
  font-weight: 700;
  color: #111111;
  margin-bottom: 0.6rem;
}
.faq-cta p {
  font-size: 0.88rem;
  line-height: 1.65;
  font-weight: 400;
  color: rgba(17, 17, 17, 0.6);
  margin-bottom: 1.4rem;
}
.faq-cta-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  background: #084b5f;
  color: #FFFFFF;
  font-family: var(--font-sans);
  font-size: 0.88rem;
  font-weight: 700;
  letter-spacing: 0.01em;
  text-decoration: none;
  padding: 0.85rem 1.5rem;
  border-radius: 999px;
  transition: transform 0.25s ease, background 0.25s ease;
}
.faq-cta-btn:hover {
  background: #0a6b86;
  transform: translateY(-2px);
}

.faq-list {
  grid-area: list;
  min-width: 0;
  display: flex;
  flex-direction: column;
}
.faq-item {
  background: transparent;
  border: none;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 0;
  /* overflow: hidden dihapus: ikon yang membesar (scale 1.1) saat aktif jadi terpotong di sisi kanan.
     Animasi buka-tutup jawaban sudah ditangani oleh .faq-answer-inner { overflow: hidden } */
  transition: border-color 0.25s ease;
}
.faq-item:first-child {
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.faq-item.active {
  background: transparent;
  border-color: rgba(0, 0, 0, 0.1);
}
.faq-item.active .faq-question {
  color: #084b5f;
}
.faq-question {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  background: none;
  border: none;
  cursor: pointer;
  text-align: left;
  /* ruang kecil di kanan supaya ikon yang membesar tidak keluar dari garis pemisah */
  padding: 1.35rem 3px 1.35rem 0;
  font-family: var(--font-sans);
  font-size: 1rem;
  font-weight: 500;
  color: #111111;
  transition: color 0.2s ease;
}
.faq-question:hover {
  color: #084b5f;
}

/* Modifikasi Ikon FAQ menjadi Ikon SVG Pesawat Kertas */
.faq-icon svg { display: block; overflow: visible; }
.faq-icon {
  flex-shrink: 0;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  background: transparent;
  border: 1px solid rgba(0, 0, 0, 0.15);
  color: #111111;
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}

/* Animasi Pesawat Kertas saat aktif */
.faq-item.active .faq-icon {
  background: #084b5f;
  border-color: #084b5f;
  color: #FFFFFF;
  /* Pesawat menukik tajam ke arah atas */
  transform: rotate(-45deg) scale(1.1); 
}

.faq-answer {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 0.35s ease;
}
.faq-item.active .faq-answer {
  grid-template-rows: 1fr;
}
.faq-answer-inner {
  overflow: hidden;
}
.faq-answer p {
  padding: 0 2.4rem 1.5rem 0;
  font-size: 0.92rem;
  line-height: 1.7;
  font-weight: 400;
  color: rgba(17, 17, 17, 0.62);
  margin: 0;
}

@media (max-width: 900px) {
  .faq-layout {
    grid-template-columns: minmax(0, 1fr);
    grid-template-rows: auto;
    grid-template-areas:
      "text"
      "list"
      "cta";
    justify-content: stretch;
    row-gap: 2rem;
  }
}

@media (min-width: 901px) {
  .faq-desc { font-size: 1.15rem; }
}

@media (max-width: 500px) {
  .faq-question { padding: 1.1rem 3px 1.1rem 0; font-size: 0.92rem; }
  .faq-answer p { padding: 0 0 1.35rem; }
  .faq-cta { padding: 1.5rem 1.4rem 1.75rem; }
}

/* media queries */
@media (max-width: 1100px) {
  .text h1 { font-size: 5.8rem; }
  .text h2 { font-size: 4.7rem; }
}
@media (max-width: 725px) {
  .text h1 { font-size: 5rem; line-height: 1.1; }
  .text h2 { font-size: 4.1rem; line-height: 1.1; }

  .hero-frame { padding: 14px; }
  main { height: calc(100vh - 28px); border-radius: 24px; }
  .brand-badge { padding: 12px 16px 12px 12px; border-radius: 18px 0 18px 0; gap: 0.5rem; }
  .brand-badge::before, .brand-badge::after { width: 18px; height: 18px; }
  .brand-badge::before { right: -18px; box-shadow: -9px -9px 0 0 #FFFFFF; }
  .brand-badge::after { bottom: -18px; box-shadow: -9px -9px 0 0 #FFFFFF; }
  .brand-badge__icon { width: 34px; height: 34px; border-radius: 10px; font-size: 0.85rem; }
  .brand-badge__text { font-size: 0.68rem; }
  .menu-btn { top: 14px; right: 14px; width: 38px; height: 38px; font-size: 0.88rem; }
  .trust-badge { max-width: 220px; padding: 16px 18px; border-radius: 18px 0 18px 0; }
  .trust-badge::before, .trust-badge::after { width: 18px; height: 18px; }
  .trust-badge::before { top: -18px; box-shadow: 9px 9px 0 0 #FFFFFF; }
  .trust-badge::after { left: -18px; box-shadow: 9px 9px 0 0 #FFFFFF; }
  .trust-badge h4 { font-size: 0.82rem; }
  .trust-badge p { font-size: 0.72rem; }

  .bg-img { width: initial; height: 311.104%; }
  .fog-7 { width: initial; height: 211.2%; }
  .mountain-10 { width: initial; height: 114.432%; }
  .fog-6 { width: initial; height: 204%; }
  .mountain-9 { width: initial; height: 51.44%; }
  .mountain-8 { width: initial; height: 87.328%; }
  .mountain-7 { width: initial; height: 49.888%; }
  .mountain-6 { width: initial; height: 42.688%; }
  .mountain-5 { width: initial; height: 59.776%; }
  .mountain-4 { width: initial; height: 79.664%; }
  .mountain-3 { width: initial; height: 51.552%; }
  .fog-5 { width: initial; height: 49.888%; }
  .fog-4 { width: initial; height: 60.336%; }
  .fog-3 { width: initial; height: 159.44%; }
  .fog-2 { width: initial; height: 173.32%; }
  .mountain-2 { width: initial; height: 76.656%; }
  .mountain-1 { width: initial; height: 109.44%; }
  .fog-1 { width: initial; height: 178.88%; }

  .info { padding: 3.5rem 1.25rem 4rem; min-height: auto; }
  .info h3 { font-size: 1.7rem; }
  .info-inner {
    flex-direction: column;
    gap: 1.75rem;
  }
  .info-text,
  .info-image {
    flex: 1 1 auto;
    width: 100%;
  }
  .info-image {
    order: -1;
  }
  .info-image img {
    min-height: 220px;
    max-height: 260px;
  }
  .layanan, .project { padding: 3.5rem 1.25rem 4rem; }
  .layanan h3, .project h3 { font-size: 1.7rem; }
}
@media (max-width: 520px) {
  .text h1 { font-size: 3.3rem; }
  .text h2 { font-size: 2.6rem; }
}
.hero-frame {
  padding-top: 22px;
}

/* ===== Sembunyikan header dari navbar.blade.php di halaman home ===== */
/* Home sudah punya navbar sendiri di hero (brand-badge-home & menu-btn-home),
   jadi header global (#navHeader) disembunyikan dulu supaya tidak dobel.
   Header ini baru muncul lagi setelah discroll (class .scrolled ditambahkan
   otomatis oleh script navbar.blade.php saat scrollY > 50). */
html #navHeader {
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: opacity 0.4s ease, visibility 0.4s ease;
}
html #navHeader.scrolled {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

/* Brand badge overlay styles */
.brand-badge-home {
  position: absolute;
  z-index: 160;
  top: 0;
  left: 0;
  display: flex;
  align-items: center;
  gap: 12px;
  background: #FFFFFF;
  color: #094356;
  padding: 14px 22px 14px 16px;
  border-radius: 26px 0 26px 0;
  text-decoration: none;
}
.brand-badge-home::before,
.brand-badge-home::after {
  content: "";
  position: absolute;
  width: 26px;
  height: 26px;
  background: transparent;
  border-radius: 50%;
}
.brand-badge-home::before {
  top: 0;
  right: -26px;
  box-shadow: -12px -12px 0 0 #FFFFFF;
}
.brand-badge-home::after {
  bottom: -26px;
  left: 0;
  box-shadow: -12px -12px 0 0 #FFFFFF;
}
.brand-badge-home img {
  width: 38px;
  height: 38px;
  object-fit: contain;
  flex-shrink: 0;
}
.brand-badge-home .brand-text {
  font-family: var(--font-sans);
  font-weight: 700;
  font-size: 1rem;
  line-height: 1.2;
  color: #094356;
}
.brand-badge-home .brand-text span {
  display: block;
  font-size: 0.65rem;
  font-weight: 400;
  color: #2f6e4e;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}
/* Menu button overlay styles */
.menu-btn-home {
  position: absolute;
  z-index: 200;
  top: 18px;
  right: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 8px 12px;
  font-family: var(--font-sans);
}
.menu-btn-home .mbh-text {
  font-size: 0.95rem;
  font-weight: 500;
  color: #EDEDED;
  height: 1.125em;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}
.menu-btn-home .mbh-icon {
  width: 1em;
  height: 1em;
  color: #EDEDED;
  transition: transform 0.4s cubic-bezier(.65,.05,0,1);
}
.menu-btn-home:hover .mbh-icon {
  transform: rotate(90deg);
}
@media (max-width: 725px) {
  .brand-badge-home { padding: 10px 16px 10px 12px; border-radius: 18px 0 18px 0; gap: 8px; }
  .brand-badge-home::before, .brand-badge-home::after { width: 18px; height: 18px; }
  .brand-badge-home::before { right: -18px; box-shadow: -9px -9px 0 0 #FFFFFF; }
  .brand-badge-home::after { bottom: -18px; box-shadow: -9px -9px 0 0 #FFFFFF; }
  .brand-badge-home img { width: 30px; height: 30px; }
  .brand-badge-home .brand-text { font-size: 0.85rem; }
  .menu-btn-home { top: 12px; right: 14px; }
}
</style>
@endpush

@section('content')
<div class="hero-frame">

<main>
  <div class="vignette"></div>
  <img src="img/bg.webp" loading="eager" data-speedx="0.3" data-distance="-200" data-rotation="0" data-speedy="0.38" data-speedz="0" alt="" class="parallax bg-img">
  <img src="img/fo_7.png" loading="lazy" data-speedx="0.27" data-distance="850" data-rotation="0" data-speedz="0" data-speedy="0.32" alt="" class="parallax fog-7">
  <img src="img/g10v2.webp" data-speedx="0.195" data-distance="1100" data-rotation="0" data-speedz="0" data-speedy="0.305" alt="" class="parallax mountain-10">
  <img src="img/fo_6.png" data-speedx="0.25" data-distance="1400" data-rotation="0" data-speedz="0" data-speedy="0.28" alt="" class="parallax fog-6">
  <img src="img/g9v2.webp" data-speedx="0.125" data-distance="1700" data-rotation="0.02" data-speedz="0.15" data-speedy="0.155" alt="" class="parallax mountain-9">
  <img src="img/g8v3.webp" data-speedx="0.1" data-distance="1800" data-rotation="0.02" data-speedz="0" data-speedy="0.11" alt="" class="parallax mountain-8">
  <img src="img/fo_5.png" data-speedx="0.16" data-distance="1900" data-rotation="0" data-speedz="0" data-speedy="0.105" alt="" class="parallax fog-5">
  <div class="text parallax" data-speedx="0.07" data-rotation="0.11" data-speedz="0" data-speedy="0.07">
    <h1>Astabrata </h1>
    <h2>Teknologi</h2>
  </div>
  <img src="img/sun_rays.webp" alt="" class="sun-rays">
  <img src="img/black_shadow.png" alt="" class="black-shadow">
  <img src="img/fo_1.png" data-speedx="0.12" data-distance="4200" data-rotation="0" data-speedz="0" data-speedy="0.01" alt="" class="parallax fog-1">

  <a href="{{ url('/') }}" class="brand-badge-home">
    <img src="img/logo asta.png" alt="Logo Astabrata">
    <div class="brand-text">
      Astabrata
      <span>Teknologi</span>
    </div>
  </a>

  <button class="menu-btn-home" data-menu-toggle="" role="button" aria-label="Buka menu">
    <div class="mbh-text">
      <span>Menu</span>
    </div>
    <div class="mbh-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 16 16" fill="none">
        <path d="M7.33333 16L7.33333 -3.2055e-07L8.66667 -3.78832e-07L8.66667 16L7.33333 16Z" fill="currentColor"></path>
        <path d="M16 8.66667L-2.62269e-07 8.66667L-3.78832e-07 7.33333L16 7.33333L16 8.66667Z" fill="currentColor"></path>
        <path d="M6 7.33333L7.33333 7.33333L7.33333 6C7.33333 6.73637 6.73638 7.33333 6 7.33333Z" fill="currentColor"></path>
        <path d="M10 7.33333L8.66667 7.33333L8.66667 6C8.66667 6.73638 9.26362 7.33333 10 7.33333Z" fill="currentColor"></path>
        <path d="M6 8.66667L7.33333 8.66667L7.33333 10C7.33333 9.26362 6.73638 8.66667 6 8.66667Z" fill="currentColor"></path>
        <path d="M10 8.66667L8.66667 8.66667L8.66667 10C8.66667 9.26362 9.26362 8.66667 10 8.66667Z" fill="currentColor"></path>
      </svg>
    </div>
  </button>

  <div class="trust-badge hide">
    <h4>Teruji &amp; Terpercaya</h4>
    <p>Solusi teknologi modern yang telah dipercaya banyak klien di berbagai industri.</p>
    <div class="trust-rating">
      <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
      <span><b>4,6/5</b> <span class="count">(200+ Klien)</span></span>
    </div>
  </div>

  <div class="scroll-hint">
    <span>Scroll</span>
    <i class="fa-solid fa-chevron-down"></i>
  </div>
</main>
</div>

@push('styles')
<style>
  /* ===== Tentang Kami: Interactive Tab System (dari home.html) ===== */
  .tentang-kami-cloneable {
    padding: 4rem 1.5rem;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    min-height: 100vh;
    display: flex;
    position: relative;
    font-size: 1.1vw;
    background: #ffffff;
    color: #131313;
    overflow: hidden;
  }

  /* ===== Efek partikel mengikuti kursor (CSS Houdini Paint Worklet) ===== */
  @supports (background: paint(something)) {
    .tentang-kami-cloneable {
      --ring-radius: 100;
      --ring-thickness: 600;
      --particle-count: 80;
      --particle-rows: 25;
      --particle-size: 2;
      --particle-color: #094356;

      --particle-min-alpha: 0.08;
      --particle-max-alpha: 0.9;

      --seed: 200;

      background-image: paint(ring-particles);
    }
  }

  @property --animation-tick {
    syntax: '<number>';
    inherits: false;
    initial-value: 0;
  }
  @property --ring-radius {
    syntax: '<number> | auto';
    inherits: false;
    initial-value: auto;
  }
  @keyframes tentang-ripple {
    0% { --animation-tick: 0; }
    100% { --animation-tick: 1; }
  }
  @keyframes tentang-ring {
    0% { --ring-radius: 150; }
    100% { --ring-radius: 250; }
  }
  .tentang-kami-cloneable {
    animation: tentang-ripple 6s linear infinite, tentang-ring 6s ease-in-out infinite alternate;
  }

  @property --ring-x {
    syntax: '<number>';
    inherits: false;
    initial-value: 50;
  }
  @property --ring-y {
    syntax: '<number>';
    inherits: false;
    initial-value: 50;
  }
  @property --ring-interactive {
    syntax: '<number>';
    inherits: false;
    initial-value: 0;
  }
  .tentang-kami-cloneable {
    /* @NOTE: Butuh bantuan JS sampai CSSWG menyelesaikan https://github.com/w3c/csswg-drafts/issues/6733 */
    transition: --ring-x 3s ease, --ring-y 3s ease;
  }
  .tentang-kami-cloneable.interactive {
    transition-duration: 0.25s;
  }

  .tentang-kami-cloneable a,
  .tentang-kami-cloneable button {
    cursor: pointer;
  }

  .tab-layout {
    z-index: 1;
    grid-row-gap: 3em;
    flex-flow: row wrap;
    align-items: stretch;
    width: 100%;
    max-width: 1180px;
    margin: 0 auto;
    display: flex;
    position: relative;
  }

  /* Label "Tentang Kami" dipisah dari kolom teks supaya tidak ikut dihitung
     saat foto disejajarkan tinggi dengan judul & tombol di bawahnya */
  .tentang-kami-top {
    width: 100%;
    max-width: 1180px;
    margin: 0 auto 1.5em;
  }

  .tab-layout-col {
    width: 50%;
  }

  .tab-container {
    grid-column-gap: 3em;
    grid-row-gap: 3em;
    flex-flow: column;
    justify-content: space-between;
    align-items: flex-start;
    min-height: 100%;
    padding-top: 0;
    padding-bottom: 0;
    padding-right: 2.5em;
    display: flex;
  }

  .tab-layout-container {
    width: 100%;
    max-width: 36em;
    height: 100%;
    margin-left: auto;
    margin-right: 0;
    padding-top: 1em;
    padding-bottom: 2em;
  }

  .tab-container-bottom,
  .tab-container-top {
    grid-column-gap: 2em;
    grid-row-gap: 2em;
    flex-flow: column;
    justify-content: flex-start;
    align-items: flex-start;
    display: flex;
  }

  .tab-content-wrap {
    width: 100%;
    min-width: 24em;
    position: relative;
    min-height: 0;
  }

  .content-button__bg {
    z-index: -1;
    background-color: #094356;
    border-radius: .25em;
    position: absolute;
    inset: 0%;
  }

  .content-p {
    margin: 0;
    font-size: 1.25em;
    line-height: 1.4;
  }

  .tab-button__bg {
    z-index: 0;
    background-color: #1313130d;
    border: 1px solid #1313131a;
    border-radius: .25em;
    width: 100%;
    height: 100%;
    position: absolute;
    inset: 0%;
  }

  .tab-content-item {
    z-index: 1;
    grid-column-gap: 1.25em;
    grid-row-gap: 1.25em;
    flex-flow: column;
    display: none;
    position: static;
  }

  .tab-content-item.active {
    display: flex;
  }

  .tab-visual-wrap {
    border-radius: .5em;
    width: 100%;
    height: 100%;
    position: relative;
    overflow: hidden;
  }

  .tab-visual-item {
    visibility: hidden;
    justify-content: flex-start;
    align-items: center;
    width: 100%;
    height: 100%;
    display: flex;
    position: absolute;
  }

  .tab-visual-item.active {
    visibility: visible;
  }

  .tab-image {
    object-fit: cover;
    border-radius: .5em;
    width: 100%;
    max-width: none;
    height: 100%;
  }

  .tab-content__heading {
    letter-spacing: -.02em;
    margin-top: 0;
    margin-bottom: 0;
    font-size: 1.75em;
    font-weight: 500;
    line-height: 1;
    color: #094356;
  }

  .tab-layout-heading {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 3em;
    font-weight: 500;
    line-height: 1;
    color: #094356;
  }

  .tab-content__button {
    color: #ffffff;
    justify-content: center;
    align-items: center;
    height: 4em;
    padding-left: 1.5em;
    padding-right: 1.5em;
    text-decoration: none;
    display: flex;
    position: relative;
  }

  @media (max-width: 991px) {
    .tentang-kami-cloneable {
      padding: 1.5em 1em;
      font-size: 14px;
      min-height: auto;
    }

    .tab-layout {
      flex-direction: column;
      min-height: auto;
      gap: 1.5em;
    }

    .tab-layout-col {
      width: 100%;
    }

    .tab-layout-container {
      max-width: 100%;
      padding-top: 0;
      padding-bottom: 0;
    }

    .tab-container {
      padding-right: 0;
      gap: 1.5em;
    }

    .tab-container-top,
    .tab-container-bottom {
      gap: 1.25em;
      width: 100%;
    }

    .tab-layout-heading {
      font-size: 1.75em;
      line-height: 1.2;
    }

    .tab-content-wrap {
      min-width: 100%;
      min-height: 5em;
    }

    .tab-content__heading {
      font-size: 1.25em;
    }

    .content-p {
      font-size: 0.95em;
      line-height: 1.35;
    }

    .tab-content__button {
      height: 3em;
      width: 100%;
      box-sizing: border-box;
    }

    .tab-visual-wrap {
      height: 18em;
      max-height: 40vh;
      border-radius: 0.5em;
    }

    /* Redundan dgn fix desktop di atas (sudah static + display toggle),
       dipertahankan agar tampilan mobile 100% sama seperti sebelumnya */
    .tab-content-wrap {
      min-height: 0;
    }

    .tab-content-item {
      position: static;
      display: none;
      inset: auto;
    }

    .tab-content-item.active {
      display: flex;
    }
  }
</style>
@endpush

<section class="tentang-kami-cloneable">
  <div class="tentang-kami-top">
    <span class="eyebrow reveal">Selamat Datang di </span>
  </div>
  <div data-tabs="wrapper" class="tab-layout">
    <!-- Deskripsi / Teks Tampil Pertama di Layar HP -->
    <div class="tab-layout-col">
      <div class="tab-layout-container">
        <div class="tab-container">
          <div class="tab-container-top">
            <h1 class="tab-layout-heading reveal">PT Astabrata Teknologi</h1>
          </div>
          <div class="tab-container-bottom">
            <div data-tabs="content-wrap" class="tab-content-wrap">
              <div data-tabs="content-item" class="tab-content-item active">
                <h2 data-tabs-fade="" class="tab-content__heading">Solusi Digital Terpadu</h2>
                <p data-tabs-fade="" class="content-p">
                  PT Astabrata Teknologi adalah perusahaan teknologi yang berfokus pada perancangan dan
                  pengembangan solusi digital untuk membantu bisnis tumbuh di era yang serba terhubung.
                  Kami memadukan strategi, desain, dan rekayasa perangkat lunak untuk menghadirkan produk
                  digital yang berkesan bagi penggunanya.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Gambar Tampil di Bawah Deskripsi pada Layar HP -->
    <div class="tab-layout-col">
      <div data-tabs="visual-wrap" class="tab-visual-wrap">
      <div data-tabs="visual-item" class="tab-visual-item active">
    <img src="{{ asset('image/beranda.jpeg') }}" loading="lazy" alt="Tim PT Astabrata Teknologi berkolaborasi" class="tab-image">
</div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
// Efek partikel (ring particles) mengikuti kursor di section "Tentang Kami"
if ('paintWorklet' in CSS) {
  CSS.paintWorklet.addModule(
    'https://unpkg.com/css-houdini-ringparticles/dist/ringparticles.js'
  );

  let tentangKamiInteractive = false;
  const $tentangKami = document.querySelector('.tentang-kami-cloneable');

  if ($tentangKami) {
    $tentangKami.addEventListener('pointermove', (e) => {
      const rect = $tentangKami.getBoundingClientRect();
      if (!tentangKamiInteractive) {
        $tentangKami.classList.add('interactive');
        tentangKamiInteractive = true;
      }
      $tentangKami.style.setProperty('--ring-x', ((e.clientX - rect.left) / rect.width) * 100);
      $tentangKami.style.setProperty('--ring-y', ((e.clientY - rect.top) / rect.height) * 100);
      $tentangKami.style.setProperty('--ring-interactive', 1);
    });

    $tentangKami.addEventListener('pointerleave', () => {
      $tentangKami.classList.remove('interactive');
      tentangKamiInteractive = false;
      $tentangKami.style.setProperty('--ring-x', 50);
      $tentangKami.style.setProperty('--ring-y', 50);
      $tentangKami.style.setProperty('--ring-interactive', 0);
    });
  }
}
</script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Flip.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/CustomEase.min.js'></script>
<script>
(function () {
  gsap.registerPlugin(CustomEase, Flip);

  if (!CustomEase.get || !CustomEase.get("osmo-ease")) {
    CustomEase.create("osmo-ease", "0.625, 0.05, 0, 1");
  }

  gsap.defaults({
    ease: "osmo-ease",
    duration: 0.8,
  });

  function initFlipButtons() {
    let wrappers = document.querySelectorAll('[data-flip-button="wrap"]');

    wrappers.forEach((wrapper) => {
      let buttons = wrapper.querySelectorAll('[data-flip-button="button"]');
      let bg = wrapper.querySelector('[data-flip-button="bg"]');

      buttons.forEach(function (button) {
        button.addEventListener("mouseenter", function () {
          const state = Flip.getState(bg);
          this.appendChild(bg);
          Flip.from(state, { duration: 0.4 });
        });

        button.addEventListener("focus", function () {
          const state = Flip.getState(bg);
          this.appendChild(bg);
          Flip.from(state, { duration: 0.4 });
        });

        button.addEventListener("mouseleave", function () {
          const state = Flip.getState(bg);
          const activeLink = wrapper.querySelector(".active");
          activeLink.appendChild(bg);
          Flip.from(state, { duration: 0.4 });
        });

        button.addEventListener("blur", function () {
          const state = Flip.getState(bg);
          const activeLink = wrapper.querySelector(".active");
          activeLink.appendChild(bg);
          Flip.from(state, { duration: 0.4 });
        });
      });
    });
  }

  function initTabSystem() {
    let wrappers = document.querySelectorAll('[data-tabs="wrapper"]');

    wrappers.forEach((wrapper) => {
      let nav = wrapper.querySelector('[data-tabs="nav"]');
      let buttons = nav ? nav.querySelectorAll('[data-tabs="button"]') : [];
      let contentWrap = wrapper.querySelector('[data-tabs="content-wrap"]');
      let contentItems = contentWrap.querySelectorAll('[data-tabs="content-item"]');
      let visualWrap = wrapper.querySelector('[data-tabs="visual-wrap"]');
      let visualItems = visualWrap.querySelectorAll('[data-tabs="visual-item"]');

      // Tidak ada tombol navigasi (card/filter-bar sudah dihapus): cukup
      // tampilkan konten & visual pertama tanpa sistem switch tab.
      if (!buttons.length) {
        contentItems.forEach((item) => item.classList.remove("active"));
        visualItems.forEach((item) => item.classList.remove("active"));
        contentItems[0] && contentItems[0].classList.add("active");
        visualItems[0] && visualItems[0].classList.add("active");
        return;
      }

      let activeButton = buttons[0];
      let activeContent = contentItems[0];
      let activeVisual = visualItems[0];
      let isAnimating = false;

      function switchTab(index, initial = false) {
        if (!initial && (isAnimating || buttons[index] === activeButton)) return;
        isAnimating = true;

        const outgoingContent = activeContent;
        const incomingContent = contentItems[index];
        const outgoingVisual = activeVisual;
        const incomingVisual = visualItems[index];

        let outgoingLines = outgoingContent.querySelectorAll("[data-tabs-fade]") || [];
        let incomingLines = incomingContent.querySelectorAll("[data-tabs-fade]");

        const tl = gsap.timeline({
          defaults: { ease: "power3.inOut" },
          onComplete: () => {
            if (!initial) {
              outgoingContent && outgoingContent.classList.remove("active");
              outgoingVisual && outgoingVisual.classList.remove("active");
            }
            activeContent = incomingContent;
            activeVisual = incomingVisual;
            isAnimating = false;
          },
        });

        incomingContent.classList.add("active");
        incomingVisual.classList.add("active");

        tl
          .to(outgoingLines, { y: "-2em", autoAlpha: 0 }, 0)
          .to(outgoingVisual, { autoAlpha: 0, xPercent: 3 }, 0)
          .fromTo(incomingLines, { y: "2em", autoAlpha: 0 }, { y: "0em", autoAlpha: 1, stagger: 0.075 }, 0.4)
          .fromTo(incomingVisual, { autoAlpha: 0, xPercent: 3 }, { autoAlpha: 1, xPercent: 0 }, "<");

        activeButton && activeButton.classList.remove("active");
        buttons[index].classList.add("active");
        activeButton = buttons[index];
      }

      switchTab(0, true);

      buttons.forEach((button, i) => {
        button.addEventListener("click", () => switchTab(i));
      });

      contentItems[0].classList.add("active");
      visualItems[0].classList.add("active");
      buttons[0].classList.add("active");
    });
  }

  document.addEventListener("DOMContentLoaded", () => {
    initTabSystem();
    initFlipButtons();
  });
})();
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.css">
<style>
    /* Layanan Container and Card */
    .layanan-container {
        background-color: #f2f3f3;
        padding: 80px 1.2% 100px;
        max-width: 1700px;
        margin: 0 auto;
    }
    .layanan-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .layanan-header .eyebrow {
        font-family: var(--font-sans);
        color: #094356;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 10px;
    }
    .layanan-header h3 {
        font-family: var(--font-sans);
        font-size: 2.8rem;
        color: #094356;
        margin-bottom: 20px;
    }
    .layanan-header .section-subtitle {
        color: #4A5A61;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ===== Slider Layanan (Swiper) - sama seperti kode layanan.html ===== */
    .section__slider {
        width: 100%;
        height: auto;
        background-color: #f2f3f3;
    }
    .section__slider .container__center {
        width: 100%;
        position: relative;
        margin-left: auto;
        margin-right: auto;
    }
    @media (min-width: 992px) {
        .section__slider .container__center {
            max-width: 1070px;
            width: 100%;
        }
        .section__slider .container__center:after {
            content: "";
            display: block;
            width: 100%;
            height: 50px;
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 2;
            background: linear-gradient(to top, #f2f3f3, rgba(242, 243, 243, 0));
        }
    }
    .swiper-container {
        width: 100%;
        height: auto;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        cursor: -webkit-grab;
        cursor: grab;
    }
    @media (min-width: 1200px) {
        .swiper-container { height: 550px; }
    }
    .swiper-button-next, .swiper-button-prev {
        width: 50px;
        height: 50px;
        background-image: none;
        background-color: #e4e4e4;
        z-index: 2;
        cursor: pointer;
    }
    .swiper-button-next i, .swiper-button-prev i {
        position: relative;
        left: 50%;
        top: 50%;
        color: #21272b;
        transform: translate(-50%, -50%);
        transition: all 0.3s ease-in-out;
    }
    @keyframes arrowRight {
        0% { transform: translate(0, -50%); }
        50% { transform: translate(-10px, -50%); }
        100% { transform: translate(0, -50%); }
    }
    .swiper-button-next:hover i, .swiper-button-prev:hover i {
        animation: arrowRight 1s infinite;
    }
    .swiper-button-next {
        position: absolute;
        top: 0;
        right: 0;
        margin-top: 0;
    }
    @media (min-width: 1200px) {
        .swiper-button-next { right: 300px; background-color: #f2f3f3; }
    }
    .swiper-button-prev {
        position: absolute;
        top: auto;
        bottom: 0;
        left: 0;
    }
    @media (min-width: 1200px) {
        .swiper-button-prev { bottom: 74px; background-color: #f2f3f3; }
    }
    .swiper-slide {
        text-align: center;
        font-size: 18px;
        width: 100%;
        display: flex;
    }
    .swiper-slide__block {
        width: 100%;
        margin: 0 auto;
        height: 100%;
        text-align: left;
    }
    .swiper-slide__block .swiper-slide__block__img {
        width: 100%;
        height: 220px;
        overflow: hidden;
        border-radius: 16px;
    }
    .swiper-slide__block .swiper-slide__block__img a {
        display: block;
        width: 100%;
        height: 100%;
    }
    @media (min-width: 480px) {
        .swiper-slide__block .swiper-slide__block__img { height: 260px; }
    }
    @media (min-width: 768px) {
        .swiper-slide__block .swiper-slide__block__img { height: 340px; }
    }
    @media (min-width: 1200px) {
        .swiper-slide__block .swiper-slide__block__img {
            width: 65%;
            max-height: 476px;
            height: 476px;
            max-width: 735px;
            overflow: hidden;
            position: relative;
            border-radius: 0;
        }
    }
    .swiper-slide__block .swiper-slide__block__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: all 0.3s ease-in-out;
    }
    @media (min-width: 1200px) {
        .swiper-slide__block .swiper-slide__block__img img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    }
    .swiper-slide__block .swiper-slide__block__img:hover img {
        transform: scale(1.1);
        filter: brightness(0.5);
    }
    .swiper-slide__block .swiper-slide__block__text {
        width: 85%;
        height: auto;
        min-height: 190px;
        margin: 0 auto;
        margin-top: 50px;
        position: relative;
    }
    @media (min-width: 480px) {
        .swiper-slide__block .swiper-slide__block__text { min-height: 200px; }
    }
    @media (min-width: 768px) {
        .swiper-slide__block .swiper-slide__block__text { margin-top: 100px; min-height: 220px; }
    }
    @media (min-width: 1200px) {
        .swiper-slide__block .swiper-slide__block__text {
            width: 40%;
            height: 100%;
            max-height: 476px;
            max-width: 400px;
            position: absolute;
            background-color: transparent;
            top: 0;
            right: 0;
            margin-top: 0;
            padding: 0;
        }
        .swiper-slide__block .swiper-slide__block__text:before {
            content: "";
            display: block;
            width: 200px;
            max-width: 408px;
            height: 100%;
            background-color: #e4e4e4;
            position: absolute;
            left: -100px;
        }
    }
    .swiper-slide__block .main__title {
        color: #f2f3f3;
        text-transform: uppercase;
        font-family: var(--font-sans);
        font-weight: 800;
        font-size: 2.6em;
        letter-spacing: 1px;
        margin: 0;
        text-shadow: 7px 7px 16px #d2d2d2;
        overflow: hidden;
        line-height: 1.05;
        height: 68px;
        word-break: break-word;
    }
    .swiper-slide__block .main__title span { color: #ff2d71; }
    @media (min-width: 768px) {
        .swiper-slide__block .main__title { font-size: 3em; height: 78px; }
    }
    @media (min-width: 1200px) {
        .swiper-slide__block .main__title { margin-top: 100px; height: 90px; }
    }
    .swiper-slide__block .main__subtitle {
        margin: 2px 0;
        font-weight: 700;
        font-family: var(--font-sans);
        font-size: 0.9em;
        color: #f2f3f3;
    }
    .swiper-slide__block .main__subtitle span {
        font-family: var(--font-sans);
        font-style: normal;
        color: #00a8af;
        letter-spacing: 1px;
    }
    .swiper-slide__block .main__subtitle,
    .swiper-slide__block .main__title,
    .swiper-slide__block .paragraphe {
        color: #21272b;
        z-index: 2;
        position: relative;
    }
    .swiper-slide__block .paragraphe {
        max-width: 413px;
        text-shadow: 7px 7px 16px #d2d2d2;
        margin-top: 24px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        line-height: 1.6;
        height: calc(1.6em * 3);
    }
    @media screen and (max-width: 1199px) {
        .swiper-slide__block .paragraphe {
            margin-top: 8px;
        }
    }
    .swiper-slide__block .number {
        font-family: var(--font-sans);
        font-size: 12em;
        font-weight: 800;
        width: 100%;
        display: block;
        color: rgba(16, 47, 65, 0.04);
        position: relative;
        bottom: 100px;
        z-index: 1;
        text-align: right;
        margin: 0;
        line-height: 120px;
    }
    @media (min-width: 1200px) {
        .swiper-slide__block .number { margin-top: 100px; font-size: 15em; }
    }
    .swiper-slide__block .link {
        display: inline-block;
        width: auto;
        position: relative;
        text-decoration: none;
        font-family: var(--font-sans);
        font-size: 0.7em;
        font-weight: 400;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #00a8af !important;
        transition: all 0.3s ease-in-out;
    }
    .swiper-slide__block .link:hover { letter-spacing: 2px; }

    @media screen and (max-width: 900px) {
        .layanan-container { padding: 60px 3% 80px; }
        .layanan-header h3 { font-size: 1.7rem; }
    }

    /* ===== Rapikan tampilan slider Layanan di mobile & tablet ===== */
    @media screen and (max-width: 1199px) {
        /* Susun ulang: gambar -> teks -> tombol navigasi, mengikuti urutan konten */
        .swiper-container {
            display: flex;
            flex-direction: column;
        }

        /* Wadah tombol next/prev: sejajar berdampingan, diletakkan di bawah deskripsi */
        .swiper-slider-nav {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 14px;
            margin: 28px auto 0;
            width: 85%;
        }

        /* Lepaskan posisi absolute bawaan supaya tombol ikut alur konten, bukan menumpuk di pojok gambar */
        .swiper-slider-nav .swiper-button-next,
        .swiper-slider-nav .swiper-button-prev {
            position: static;
            top: auto;
            right: auto;
            bottom: auto;
            left: auto;
            margin: 0;
            border-radius: 50%;
        }

        /* Angka dekoratif besar terlalu besar untuk layar kecil, jadi penyebab utama layout berantakan */
        .swiper-slide__block .number {
            font-size: 4.5em;
            bottom: 10px;
            line-height: 1;
        }
    }

    @media screen and (max-width: 480px) {
        .swiper-slider-nav {
            gap: 10px;
        }
        .swiper-button-next, .swiper-button-prev {
            width: 44px;
            height: 44px;
        }
        .swiper-slide__block .number {
            font-size: 3.2em;
        }
    }

    /* Judul layanan: ukuran dasar diatur di sini, penyesuaian otomatis dilakukan lewat JS (auto-fit sesuai panjang teks) */
    .swiper-slide__block .main__title {
        transition: font-size 0.2s ease;
    }
</style>
@endpush

<section class="layanan-container">
    <div class="layanan-header reveal">
        <span class="eyebrow">Apa yang Kami Kerjakan</span>
        <h3>Layanan Kami</h3>
        <p class="section-subtitle">
            Dari perencanaan hingga peluncuran, kami menyediakan layanan teknologi yang menyeluruh
            untuk mendukung transformasi digital bisnis Anda.
        </p>
    </div>

    <div class="section__slider reveal">
      <div class="container__center">
        <div class="swiper-container">
          <div class="swiper-wrapper">

            @forelse($services as $index => $service)
            <div class="swiper-slide">
              <div class="swiper-slide__block">
                <div class="swiper-slide__block__img" data-swiper-parallax-y="70%">
                  @if($service->image)
                    <img src="{{ asset('images/services/' . $service->image) }}" alt="{{ $service->title }}">
                  @else
                    <img src="https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=1351&q=60" alt="">
                  @endif
                </div>
                <div class="swiper-slide__block__text">
                  <h2 data-swiper-parallax-x="-60%" class="main__title">{{ $service->title }} <span>.</span></h2>
                  <p data-swiper-parallax-x="-40%" class="paragraphe">{{ $service->description }}</p>
                  <span data-swiper-parallax-y="60%" class="number">{{ $index + 1 }}</span>
                </div>
              </div>
            </div>
            @empty
            <div class="swiper-slide">
              <div class="swiper-slide__block">
                <div class="swiper-slide__block__img" data-swiper-parallax-y="70%">
                  <img src="https://images.unsplash.com/photo-1456518563096-0ff5ee08204e?auto=format&fit=crop&w=1351&q=60" alt="">
                </div>
                <div class="swiper-slide__block__text">
                  <h2 data-swiper-parallax-x="-60%" class="main__title">Layanan Kami <span>.</span></h2>
                  <p data-swiper-parallax-x="-40%" class="paragraphe">Belum ada layanan. Tambahkan layanan melalui halaman admin.</p>
                  <span data-swiper-parallax-y="60%" class="number">1</span>
                </div>
              </div>
            </div>
            @endforelse
          </div>
          <div class="swiper-slider-nav">
            <div class="swiper-button-prev">
              <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i>
            </div>
            <div class="swiper-button-next">
              <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (!document.querySelector('.swiper-container')) return;

        var layananSwiper;

        if (window.innerWidth < 1200) {
            layananSwiper = new Swiper(".swiper-container", {
                direction: "horizontal",
                slidesPerView: 1,
                nextButton: ".swiper-button-next",
                prevButton: ".swiper-button-prev",
                paginationClickable: true,
                spaceBetween: 0,
                autoplay: 2500,
                autoplayDisableOnInteraction: false, // usap boleh mengontrol, tapi slider tetap jalan otomatis lagi setelahnya
                loop: true
            });
        } else {
            layananSwiper = new Swiper(".swiper-container", {
                direction: "horizontal",
                slidesPerView: 1,
                parallax: true,
                nextButton: ".swiper-button-next",
                prevButton: ".swiper-button-prev",
                paginationClickable: true,
                spaceBetween: 0,
                speed: 1500,
                autoplay: 2500,
                autoplayDisableOnInteraction: false,
                loop: true
            });
        }

        // ===== Auto-fit ukuran font judul layanan: ukur tinggi asli teks, lalu kecilkan font sampai benar-benar muat (tidak dipotong) =====
        function autoFitLayananTitles() {
            var minFontSizePx = 14; // batas paling kecil supaya tetap terbaca

            document.querySelectorAll('.swiper-slide__block .main__title').forEach(function (el) {
                // Reset dulu ke ukuran default dari CSS sebelum mengukur ulang
                el.style.fontSize = '';

                var maxHeight = el.clientHeight; // tinggi kotak judul yang sudah tetap (diatur lewat CSS per breakpoint)
                if (!maxHeight) return;

                var fontSize = parseFloat(window.getComputedStyle(el).fontSize);
                el.style.fontSize = fontSize + 'px';

                var guard = 60; // pengaman supaya loop tidak berjalan tanpa henti
                while (el.scrollHeight > maxHeight && fontSize > minFontSizePx && guard > 0) {
                    fontSize -= 1;
                    el.style.fontSize = fontSize + 'px';
                    guard--;
                }
            });
        }

        autoFitLayananTitles();

        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(autoFitLayananTitles, 150);
        });
    });
</script>
@endpush

<section class="project" id="faq">
  <div class="project-inner">
    <div class="faq-layout">
      <div class="faq-text">
        <span class="faq-eyebrow reveal">FAQ</span>
        <h3 class="reveal">Pertanyaan Umum</h3>
        <p class="section-subtitle reveal faq-desc">
          Beberapa hal yang paling sering ditanyakan calon klien sebelum memulai proyek bersama kami.
        </p>
      </div>

      <div class="faq-list reveal">
        <div class="faq-item active">
          <button class="faq-question" type="button" aria-expanded="true">
            <span>Berapa lama estimasi waktu pengerjaan proyek?</span>
            <span class="faq-icon">
              <!-- SVG Pesawat Kertas Pengganti (+) -->
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>Tergantung kompleksitas dan scope pekerjaan, umumnya proyek website atau aplikasi selesai dalam 2–6 minggu. Kami akan memberikan timeline yang jelas setelah kebutuhan Anda dibahas di awal.</p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button" aria-expanded="false">
            <span>Bagaimana sistem pembayarannya?</span>
            <span class="faq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>Pembayaran dilakukan secara bertahap, biasanya 50% di awal sebagai DP untuk memulai pengerjaan dan 50% sisanya setelah proyek selesai dan disetujui. Untuk proyek besar, tahapan pembayaran bisa disesuaikan.</p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button" aria-expanded="false">
            <span>Apakah tersedia revisi setelah pengerjaan?</span>
            <span class="faq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>Ya, setiap paket sudah termasuk sejumlah revisi gratis selama masa pengerjaan agar hasil akhir sesuai dengan kebutuhan Anda. Revisi tambahan di luar ketentuan dapat didiskusikan lebih lanjut.</p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button" aria-expanded="false">
            <span>Apakah ada garansi atau dukungan setelah proyek selesai?</span>
            <span class="faq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>Tentu. Kami menyediakan dukungan purna jual untuk perbaikan bug dan pendampingan setelah website atau aplikasi Anda live, sehingga Anda tidak dibiarkan berjalan sendiri.</p>
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question" type="button" aria-expanded="false">
            <span>Bagaimana cara memulai proyek dengan kami?</span>
            <span class="faq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
              </svg>
            </span>
          </button>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              <p>Cukup hubungi kami melalui email atau form kontak dengan kebutuhan proyek Anda. Tim kami akan menjadwalkan diskusi awal untuk memahami kebutuhan dan memberikan penawaran yang sesuai.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="faq-cta reveal">
        <h4>Masih punya pertanyaan?</h4>
        <p>Tidak menemukan jawaban yang Anda cari? Hubungi kami dan tim kami akan membalas secepat mungkin.</p>
        <a href="{{ url('/contact') }}" class="faq-cta-btn">Hubungi</a>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
(function () {
  const faqItems = document.querySelectorAll('.faq-item');
  if (!faqItems.length) return;

  faqItems.forEach((item) => {
    const question = item.querySelector('.faq-question');
    if (!question) return;

    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      faqItems.forEach((other) => {
        other.classList.remove('active');
        const otherBtn = other.querySelector('.faq-question');
        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
      });

      if (!isActive) {
        item.classList.add('active');
        question.setAttribute('aria-expanded', 'true');
      }
    });
  });
})();
</script>
@endpush


@push('scripts')
<script>
(function () {
  const parallax_el = document.querySelectorAll(".parallax");
  const main = document.querySelector("main");
  const gyroBtn = document.getElementById("gyroBtn");

  let xValue = 0,
      yValue = 0;
  let rotateDegree = 0;

  function update(cursorPosition) {
    parallax_el.forEach(el => {
      let speedx = el.dataset.speedx;
      let speedy = el.dataset.speedy;
      let speedz = el.dataset.speedz;
      let rotateSpeed = el.dataset.rotation;

      let isInLeft = parseFloat(getComputedStyle(el).left) < window.innerWidth / 2 ? 1 : -1;
      let zValue = (cursorPosition - parseFloat(getComputedStyle(el).left)) * isInLeft * 0.1;
      el.style.transform = `perspective(2300px) translateX(calc(-50% + ${-xValue * speedx}px)) translateY(calc(-50% + ${yValue * speedy}px)) rotateY(${rotateDegree * rotateSpeed}deg) translateZ(${zValue * speedz}px)`;
    });
  }

  update(0);

  function isAnimating() {
    return typeof timeline !== "undefined" && timeline.isActive();
  }

  // --- Desktop: mouse ---
  main.addEventListener("mousemove", (e) => {
    if (isAnimating()) return;
    xValue = e.clientX - window.innerWidth / 2;
    yValue = e.clientY - window.innerHeight / 2;
    rotateDegree = (xValue / (window.innerWidth / 2)) * 20;
    update(e.clientX);
  });

  // --- Mobile: sentuh & geser (touch drag) ---
  let touchActive = false;

  main.addEventListener("touchstart", (e) => {
    touchActive = true;
  }, { passive: true });

  main.addEventListener("touchmove", (e) => {
    if (isAnimating() || !touchActive) return;
    const touch = e.touches[0];
    xValue = touch.clientX - window.innerWidth / 2;
    yValue = touch.clientY - window.innerHeight / 2;
    rotateDegree = (xValue / (window.innerWidth / 2)) * 20;
    update(touch.clientX);
  }, { passive: true });

  main.addEventListener("touchend", () => {
    touchActive = false;
  });

  // --- Mobile: giroskop (device orientation) ---
  function handleOrientation(e) {
    if (isAnimating()) return;
    // gamma: kiri-kanan (-90 to 90), beta: depan-belakang (-180 to 180)
    const gamma = e.gamma || 0;
    const beta = e.beta || 0;

    xValue = Math.max(-1, Math.min(1, gamma / 30)) * (window.innerWidth / 2);
    yValue = Math.max(-1, Math.min(1, (beta - 45) / 30)) * (window.innerHeight / 2);
    rotateDegree = (xValue / (window.innerWidth / 2)) * 20;

    const cursorPos = window.innerWidth / 2 + xValue;
    update(cursorPos);
  }

  function enableGyro() {
    window.addEventListener("deviceorientation", handleOrientation);
    gyroBtn.classList.remove("show");
  }

  const supportsGyro = typeof DeviceOrientationEvent !== "undefined";
  const needsPermission = supportsGyro && typeof DeviceOrientationEvent.requestPermission === "function";
  const isTouchDevice = "ontouchstart" in window || navigator.maxTouchPoints > 0;

  if (isTouchDevice && supportsGyro) {
    if (needsPermission) {
      gyroBtn.classList.add("show");
      gyroBtn.addEventListener("click", () => {
        DeviceOrientationEvent.requestPermission()
          .then(state => {
            if (state === "granted") enableGyro();
          })
          .catch(() => {});
      });
    } else {
      enableGyro();
    }
  }

  // --- Ukuran tinggi main sesuai lebar layar ---
  if (window.innerWidth >= 725) {
    main.style.maxHeight = `${window.innerWidth * 0.45}px`;
  } else {
    main.style.maxHeight = `${window.innerWidth * 1.6}px`;
  }

  // --- Animasi masuk (GSAP) ---
  window.timeline = gsap.timeline();

  Array.from(parallax_el).filter(el => !el.classList.contains("text")).forEach(el => {
    timeline.from(el, {
      top: `${el.offsetHeight / 2 + +el.dataset.distance}px`,
      duration: 3.5,
      ease: "power3.out"
    }, "1");
  });

  timeline.from(".text h1", {
    y: window.innerHeight - document.querySelector(".text h1").getBoundingClientRect().top + 200,
    duration: 2,
  }, "2.5")
  .from(".text h2", {
    y: -150,
    opacity: 0,
    duration: 1.5
  }, "3")
  .from(".hide", {
    opacity: 0,
    duration: 1.5
  }, "3");

  // --- Reveal saat discroll (section penjelasan) ---
  const revealEls = document.querySelectorAll(".reveal");
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("in-view");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  revealEls.forEach(el => observer.observe(el));
})();
</script>
@endpush

@endsection