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
        color: #094356;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* container classes removed to avoid conflicts */

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
      padding-right: 28px; /* tombol menu mojok kanan, tetap ada jarak dari tepi */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      overflow: hidden;
      transition: all 0.4s ease;
      box-sizing: border-box;
    }

    .header.scrolled {
        background: rgba(255, 255, 255, 0.97);
        padding: 12px 5%;
        padding-right: 28px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06);
        backdrop-filter: blur(10px);
    }

    /* Saat menu dibuka, background navbar jadi transparan (override .scrolled) */
    .header.menu-open {
        background: transparent !important;
        box-shadow: none !important;
        backdrop-filter: none !important;
    }

    /* Halaman selain Beranda (About, Blog, Contact, dll): navbar putih solid dari atas,
       tidak transparan, tampilannya sama seperti kondisi sudah discroll */
    .header.header--pinned {
        background: rgba(255, 255, 255, 0.97);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06);
        backdrop-filter: blur(10px);
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
      width: 23em;
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
    }

    .bg-panel {
      z-index: 0;
      background-color: var(--color-neutral-300, #e0e0e0);
      border-top-left-radius: 1.25em;
      border-bottom-left-radius: 1.25em;
      position: absolute;
      inset: 0%;
    }

    .bg-panel.first {
      background-color: var(--color-primary, #4FA8B5);
    }

    .bg-panel.second {
      background-color: var(--color-neutral-100, #ffffff);
    }

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
      overflow: hidden;
    }

    .menu-link {
      padding-top: .75em;
      padding-bottom: .75em;
      padding-left: var(--menu-padding);
      grid-column-gap: .75em;
      grid-row-gap: .75em;
      width: 100%;
      text-decoration: none;
      display: flex;
      color: inherit;
      box-sizing: border-box;
    }

    .menu-link-heading {
      z-index: 1;
      text-transform: uppercase;
      font-family: 'PP Neue Corp Tight', Arial, sans-serif;
      font-size: 5.625em;
      font-weight: 700;
      line-height: .75;
      transition: transform .55s cubic-bezier(.65, .05, 0, 1);
      position: relative;
      text-shadow: 0px 1em 0px var(--color-neutral-200, #cccccc);
      margin: 0;
      color: #131313;
    }

    .eyebrow {
      z-index: 1;
      color: var(--color-primary, #094356);
      text-transform: uppercase;
      font-family: monospace;
      font-weight: 400;
      position: relative;
      margin: 0;
    }

    .menu-link-bg {
      z-index: 0;
      background-color: #094356;
      transform-origin: 50% 100%;
      transform-style: preserve-3d;
      transition: transform .55s cubic-bezier(.65, .05, 0, 1);
      position: absolute;
      inset: 0%;
      transform: scale3d(1, 0, 1);
    }

    .p-small {
      font-size: .875em;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      color: #131313;
    }

    .p-large {
      font-size: 1.125em;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      color: #131313;
    }

    .text-link {
      text-decoration: none;
      color: inherit;
      position: relative;
    }

    /* ------- Menu Button ------- */
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
      width: 1em;
      height: 1em;
      color: #14211b;
    }

    .menu-button-text {
      flex-flow: column;
      justify-content: flex-start;
      align-items: flex-end;
      height: 1.125em;
      display: flex;
      overflow: hidden;
    }

    .icon-wrap {
      transition: transform .4s cubic-bezier(.65, .05, 0, 1);
    }

    /* ------- Hover Effects ------- */
    @media (hover: hover) {
      .menu-button:hover .icon-wrap {
        transform: rotate(90deg);
      }

      .menu-link:hover .menu-link-heading {
        transform: translate(0px, -1em);
        transition-delay: 0.1s;
      }
      
      .menu-link:hover .menu-link-heading {
        text-shadow: 0px 1em 0px #ffffff;
      }
      .menu-link:hover .eyebrow {
        color: #ffffff;
      }

      .menu-link:hover .menu-link-bg {
        transform: scale(1, 1);
      }

      .text-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px;
        background: var(--color-primary, #094356);
        transform-origin: right center;
        transform: scale(0, 1);
        transition: transform 0.4s cubic-bezier(.65, .05, 0, 1);
      }

      .text-link:hover::after {
        transform-origin: left center;
        transform: scale(1, 1);
      }
    }

    /* ------- Responsive Styles ------- */
    @media screen and (max-width: 768px) {
      .header,
      .header.scrolled { padding-right: 18px; }

      .nav {
        --menu-padding: 1em;
      }

      .nav-logo-row {
        grid-column-gap: 2.5em;
        grid-row-gap: 2.5em;
        width: auto;
      }

      .nav-row__right {
        grid-column-gap: 0rem;
        grid-row-gap: 0rem;
      }

      .menu {
        padding-top: calc(6 * var(--menu-padding));
        padding-bottom: calc(3 * var(--menu-padding));
        width: 60%;
      }


      .bg-panel {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
      }

      .menu-list-item {
        height: 4.5em;
      }

      .menu-link-heading {
        font-size: 4em;
      }


      .p-large.text-link {
        font-size: 1em;
      }

      .nav-brand { gap: 9px; }
      .nav-brand img { width: 32px; height: 32px; }
      .nav-brand-text { font-size: 1rem; margin-left: -2px; }
      .nav-brand-text span { font-size: 0.6rem; }
    }

    @media screen and (max-width: 479px) {
      .menu {
        padding-top: calc(7 * var(--menu-padding));
        padding-bottom: calc(4 * var(--menu-padding));
      }
    }

    /* ------- Back Button ------- */
    .nav-left {
      display: flex;
      align-items: center;
      gap: 26px;
      pointer-events: auto;
    }

    /* Logo + nama hilang saat sidebar menu terbuka */
    .nav-left {
      transition: opacity 0.35s ease, visibility 0.35s ease;
    }
    .header.menu-open .nav-left {
      opacity: 0;
      visibility: hidden;
      pointer-events: none;
    }

    .back-button {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      border: 1px solid rgba(9, 67, 86, 0.18);
      background: linear-gradient(135deg, #eaf6ef 0%, #ffffff 100%);
      color: #094356;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 3px 12px rgba(20, 33, 27, 0.07);
      transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease,
                  box-shadow 0.3s ease, transform 0.2s ease;
      flex-shrink: 0;
      position: relative;
      overflow: hidden;
    }
    .back-button svg {
      position: relative;
      z-index: 1;
      transition: transform 0.35s cubic-bezier(.65, .05, 0, 1);
    }
    .back-button::before {
      content: '';
      position: absolute;
      inset: 0;
      background: #094356;
      transform: translateY(100%);
      transition: transform 0.35s cubic-bezier(.65, .05, 0, 1);
    }
    .back-button:hover {
      color: #ffffff;
      border-color: #094356;
      box-shadow: 0 8px 20px rgba(9, 67, 86, 0.3);
    }
    .back-button:hover::before { transform: translateY(0); }
    .back-button:hover svg { transform: translateX(-3px); }
    .back-button:active { transform: scale(0.9); }
    .back-button svg { width: 18px; height: 18px; }

    @media screen and (max-width: 768px) {
      .nav-left { gap: 12px; }
      .back-button {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.55);
        backdrop-filter: blur(6px);
        border-color: rgba(9, 67, 86, 0.12);
        box-shadow: none;
      }
      .back-button svg { width: 14px; height: 14px; }
      .back-button:hover { box-shadow: 0 4px 12px rgba(9, 67, 86, 0.25); }
    }
    /* ------- Tombol Dark / Light Mode: HANYA matahari & bulan (ringkas) ------- */
    /* Dibuat 100x100px (font-size 10px, satuan em) lalu diperkecil dengan scale. */
    .theme-toggle-wrap {
      --tt-scale: 0.28;
      position: relative;
      z-index: 2; /* di atas .nav-sky, tidak pernah ketutup background */
      flex-shrink: 0;
      width: calc(100px * var(--tt-scale));
      height: calc(100px * var(--tt-scale));
      margin-right: 0.9rem;
    }
    .theme-toggle {
      position: absolute;
      top: 0;
      left: 0;
      width: 10em;
      height: 10em;
      font-size: 10px;
      padding: 0;
      border: 0;
      border-radius: 50%;
      background: transparent;
      overflow: visible;
      isolation: isolate;
      cursor: pointer;
      transform: scale(var(--tt-scale));
      transform-origin: 0 0;
      -webkit-tap-highlight-color: transparent;
      --tt-ease: cubic-bezier(.65, .05, 0, 1);
      transition: background 0.6s var(--tt-ease);
    }
    .theme-toggle *, .theme-toggle *::before, .theme-toggle *::after { box-sizing: border-box; }
    .theme-toggle:focus-visible { outline: 3px solid #094356; outline-offset: 5px; }
    /* bayangan cekung di dalam, seperti tombol aslinya */
    .theme-toggle:active .tt-sun,
    .theme-toggle:active .tt-moon { filter: brightness(0.92); }

    /* Matahari & bulan: satu-satunya isi tombol, saling berganti dengan memutar + memudar */
    .tt-sun, .tt-moon {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 6.4em;
      height: 6.4em;
      margin: -3.2em 0 0 -3.2em;
      border-radius: 50%;
      transition: transform 0.6s var(--tt-ease), opacity 0.45s ease;
      z-index: 2;
    }
    .tt-sun {
      background: #fbc72d;
      box-shadow: inset 0.2em 0.2em 0.4em rgba(255, 255, 255, 0.5),
                  inset -0.3em -0.3em 0.5em rgba(0, 0, 0, 0.2);
    }
    /* Sinar matahari: bintang bergerigi 12 sinar di belakang lingkaran matahari */
    .tt-rays {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 9em;
      height: 9em;
      margin: -4.5em 0 0 -4.5em;
      z-index: 1;
      transition: transform 0.6s var(--tt-ease), opacity 0.45s ease;
    }
    .tt-rays::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(145deg, #ffd84d 0%, #f9b81c 100%);
      -webkit-clip-path: polygon(50.00% 0.00%, 59.84% 13.29%, 75.00% 6.70%, 76.87% 23.13%, 93.30% 25.00%, 86.71% 40.16%, 100.00% 50.00%, 86.71% 59.84%, 93.30% 75.00%, 76.87% 76.87%, 75.00% 93.30%, 59.84% 86.71%, 50.00% 100.00%, 40.16% 86.71%, 25.00% 93.30%, 23.13% 76.87%, 6.70% 75.00%, 13.29% 59.84%, 0.00% 50.00%, 13.29% 40.16%, 6.70% 25.00%, 23.13% 23.13%, 25.00% 6.70%, 40.16% 13.29%);
      clip-path: polygon(50.00% 0.00%, 59.84% 13.29%, 75.00% 6.70%, 76.87% 23.13%, 93.30% 25.00%, 86.71% 40.16%, 100.00% 50.00%, 86.71% 59.84%, 93.30% 75.00%, 76.87% 76.87%, 75.00% 93.30%, 59.84% 86.71%, 50.00% 100.00%, 40.16% 86.71%, 25.00% 93.30%, 23.13% 76.87%, 6.70% 75.00%, 13.29% 59.84%, 0.00% 50.00%, 13.29% 40.16%, 6.70% 25.00%, 23.13% 23.13%, 25.00% 6.70%, 40.16% 13.29%);
    }
    .theme-toggle[data-theme="dark"] .tt-rays { opacity: 0; transform: rotate(120deg) scale(0.3); }
    .tt-moon {
      background: #cccfd9;
      box-shadow: inset 0.2em 0.2em 0.4em rgba(255, 255, 255, 0.55), inset -0.3em -0.3em 0.5em rgba(0, 0, 0, 0.3);
      opacity: 0;
      transform: rotate(-120deg) scale(0.3);
    }
    .theme-toggle[data-theme="dark"] .tt-sun { opacity: 0; transform: rotate(120deg) scale(0.3); }
    .theme-toggle[data-theme="dark"] .tt-moon { opacity: 1; transform: rotate(0) scale(1); }
    /* Kawah bulan: tetap bagian dari "bulan", bukan elemen langit terpisah */
    .tt-dot {
      position: absolute;
      border-radius: 50%;
      background: #9da8bc;
    }
    /* Detail di dalam matahari (bintik hangat, seperti kawah di bulan) */
    .tt-spot {
      position: absolute;
      border-radius: 50%;
      background: #f2a516;
      box-shadow: inset 0.08em 0.08em 0.15em rgba(0, 0, 0, 0.18);
    }
    .tt-spot1 { width: 1.1em; height: 1.1em; top: 1.1em; left: 2.7em; }
    .tt-spot2 { width: 1.7em; height: 1.7em; top: 3.1em; left: 1.1em; }
    .tt-spot3 { width: 1.2em; height: 1.2em; top: 3.8em; left: 3.9em; }
    .tt-dot1 { width: 1.1em; height: 1.1em; top: 1.1em; left: 2.7em; }
    .tt-dot2 { width: 1.7em; height: 1.7em; top: 3.1em; left: 1.1em; }
    .tt-dot3 { width: 1.2em; height: 1.2em; top: 3.8em; left: 3.9em; }

    @media (prefers-reduced-motion: reduce) {
      .tt-sun, .tt-moon, .tt-rays { transition-duration: 0.01s; }
    }
    @media screen and (max-width: 768px) {
      .theme-toggle-wrap { --tt-scale: 0.26; margin-right: 0.7rem; }
    }

    /* ------- Background langit di navbar: awan + langit biru (terang), bintang (gelap) -------
       Lapisan ini murni dekoratif, diletakkan paling belakang di dalam .header (z-index 0),
       sedangkan logo & tombol-tombol ada di .nav-row (z-index 1) sehingga tidak pernah
       tertutup / mengganggu tombol menu maupun tombol dark-light. Otomatis disembunyikan
       saat navbar sudah solid (scrolled/pinned/menu dibuka) supaya tidak dobel dengan background putih/gelap. ------- */
    .nav-row {
      position: relative;
      z-index: 1;
    }
    .header { --sky-w: 270px; } /* lebar langit di sisi kanan (mencakup ikon matahari/bulan + tombol menu) */
    .nav-sky {
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      width: var(--sky-w);
      /* sisi kiri memudar halus jadi transparan (bukan potongan melengkung) */
      -webkit-mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.55) 18%, #000 45%);
      mask-image: linear-gradient(to right, transparent 0%, rgba(0,0,0,0.55) 18%, #000 45%);
      z-index: 0;
      overflow: hidden;
      pointer-events: none;
      opacity: 1;
      background: linear-gradient(180deg, #bfe0f7 0%, #eef7fd 100%);
      transition: background 0.6s ease, opacity 0.4s ease;
    }
    html[data-theme="dark"] .nav-sky {
      background: linear-gradient(180deg, #171b2e 0%, #0f1222 100%);
    }
    .header.menu-open .nav-sky {
      opacity: 0;
    }
    .nav-sky-clouds {
      position: absolute;
      inset: 0;
      transition: opacity 0.5s ease, transform 0.6s cubic-bezier(.65, .05, 0, 1);
    }
    .nav-sky-clouds span {
      position: absolute;
      bottom: -1.8rem;
      aspect-ratio: 1;
      width: 2.8rem;
      border-radius: 50%;
      background: #ffffff;
      opacity: 0.95;
      animation: nsky-drift 22s ease-in-out infinite;
    }
    .nav-sky-clouds span::before {
      content: '';
      position: absolute;
      width: 75%;
      aspect-ratio: 1;
      border-radius: 50%;
      background: #ffffff;
      left: 55%;
      top: 22%;
    }
    .nav-sky-clouds span:nth-child(1) { left: 4%;  bottom: -1.9rem; animation-delay: 0s; }
    .nav-sky-clouds span:nth-child(2) { left: 24%; bottom: -1.7rem; width: 2.3rem; animation-delay: 3s; animation-duration: 18s; }
    .nav-sky-clouds span:nth-child(3) { left: 46%; bottom: -1.8rem; width: 2.9rem; animation-delay: 1.5s; }
    .nav-sky-clouds span:nth-child(4) { left: 68%; bottom: -1.6rem; width: 2.2rem; animation-delay: 4s; animation-duration: 20s; }
    .nav-sky-clouds span:nth-child(5) { left: 86%; bottom: -1.7rem; width: 2.4rem; animation-delay: 2s; }
    @keyframes nsky-drift {
      0%, 100% { transform: translateX(-0.8rem); }
      50% { transform: translateX(0.8rem); }
    }
    .nav-sky-stars {
      position: absolute;
      inset: 0;
      opacity: 0;
      transform: scale(0.95);
      transition: opacity 0.6s ease 0.1s, transform 0.6s cubic-bezier(.65, .05, 0, 1);
    }
    .nav-sky-star {
      position: absolute;
      left: var(--x);
      top: var(--y);
      width: 0.5rem;
      height: 0.5rem;
      background: #f8fcff;
      clip-path: polygon(50% 0, 65% 35%, 100% 50%, 65% 65%, 50% 100%, 35% 65%, 0 50%, 35% 35%);
      transform: scale(var(--s));
      animation: nsky-twinkle 3s ease-in-out var(--d) infinite;
    }
    @keyframes nsky-twinkle {
      0%, 100% { opacity: 0.3; }
      50% { opacity: 1; }
    }
    html[data-theme="dark"] .nav-sky-clouds { opacity: 0; }
    html[data-theme="dark"] .nav-sky-stars { opacity: 1; transform: scale(1); }
    @media (prefers-reduced-motion: reduce) {
      .nav-sky-clouds span, .nav-sky-star { animation: none; }
    }
    @media screen and (max-width: 768px) {
      .header { --sky-w: 240px; }
    }

    /* ------- Tema gelap untuk navbar (aktif via html[data-theme="dark"]) ------- */
    /* Navbar sengaja dibuat lebih terang (slate kebiruan) dari latar halaman (#0a0f1a) supaya terlihat terpisah */
    html[data-theme="dark"] .header.scrolled,
    html[data-theme="dark"] .header.header--pinned {
      background: rgba(28, 40, 66, 0.94);
      border-bottom: 1px solid rgba(143, 208, 191, 0.16);
      box-shadow: 0 6px 28px rgba(0, 0, 0, 0.55);
    }
    html[data-theme="dark"] .header .nav-brand-text,
    html[data-theme="dark"] .header .menu-button .p-large,
    html[data-theme="dark"] .header .menu-button-icon {
      color: #e8f1ee;
    }
    html[data-theme="dark"] .header .nav-brand-text span {
      color: #8fd0bf;
    }

    /* ------- Sidebar (panel menu): langit berawan saat terang, langit berbintang saat gelap ------- */
    .bg-panel--sky {
      overflow: hidden;
      background: linear-gradient(180deg, #cfe6f8 0%, #e9f4fb 60%, #f4f9fd 100%);
      transition: background 0.6s ease;
    }
    .menu-sky { position: absolute; inset: 0; pointer-events: none; }

    /* Awan (mode terang) */
    .ms-clouds { position: absolute; inset: 0; transition: opacity 0.6s ease, transform 0.6s cubic-bezier(.65, .05, 0, 1); }
    .ms-layer { position: absolute; left: -4rem; right: -4rem; bottom: 0; height: 0; }
    .ms-layer span { position: absolute; aspect-ratio: 1; border-radius: 50%; }
    .ms-layer--back { animation: ms-drift 26s ease-in-out infinite; }
    .ms-layer--front { animation: ms-drift 19s ease-in-out infinite reverse; }
    .ms-layer--back span { background: #bcd9ef; }
    .ms-layer--front span { background: #ffffff; box-shadow: 0 -0.4rem 1.4rem rgba(120, 165, 205, 0.25); }
    .ms-layer--back span:nth-child(1) { width: 36%; left: -4%; bottom: -5rem; }
    .ms-layer--back span:nth-child(2) { width: 40%; left: 16%; bottom: -7rem; }
    .ms-layer--back span:nth-child(3) { width: 38%; left: 38%; bottom: -4.5rem; }
    .ms-layer--back span:nth-child(4) { width: 42%; left: 58%; bottom: -7rem; }
    .ms-layer--back span:nth-child(5) { width: 36%; left: 80%; bottom: -5rem; }
    .ms-layer--front span:nth-child(1) { width: 30%; left: 2%; bottom: -8rem; }
    .ms-layer--front span:nth-child(2) { width: 36%; left: 20%; bottom: -10rem; }
    .ms-layer--front span:nth-child(3) { width: 32%; left: 42%; bottom: -7.5rem; }
    .ms-layer--front span:nth-child(4) { width: 38%; left: 60%; bottom: -10rem; }
    .ms-layer--front span:nth-child(5) { width: 30%; left: 84%; bottom: -8rem; }
    @keyframes ms-drift {
      0%, 100% { transform: translateX(-1.5rem); }
      50% { transform: translateX(1.5rem); }
    }

    /* Bintang (mode gelap) */
    .ms-stars { position: absolute; inset: 0; opacity: 0; transform: scale(0.96); transition: opacity 0.6s ease 0.1s, transform 0.6s cubic-bezier(.65, .05, 0, 1); }
    .ms-star {
      position: absolute;
      left: var(--x);
      top: var(--y);
      width: 1.6rem;
      height: 1.6rem;
      background: #f8fcff;
      -webkit-clip-path: polygon(50% 0, 65% 35%, 100% 50%, 65% 65%, 50% 100%, 35% 65%, 0 50%, 35% 35%);
      clip-path: polygon(50% 0, 65% 35%, 100% 50%, 65% 65%, 50% 100%, 35% 65%, 0 50%, 35% 35%);
      transform: scale(var(--s));
      animation: ms-twinkle 3.2s ease-in-out var(--d) infinite;
    }
    @keyframes ms-twinkle {
      0%, 100% { opacity: 0.35; }
      50% { opacity: 1; }
    }

    html[data-theme="dark"] .bg-panel--sky { background: linear-gradient(180deg, #1f2234 0%, #191c2d 55%, #14172a 100%); }
    html[data-theme="dark"] .bg-panel.first { background-color: #0d4257; }
    html[data-theme="dark"] .bg-panel.second { background-color: #171b2e; }
    html[data-theme="dark"] .ms-clouds { opacity: 0; transform: scale(0.9); }
    html[data-theme="dark"] .ms-stars { opacity: 1; transform: scale(1); }
    html[data-theme="dark"] .overlay { background-color: #000000aa; }

    /* Teks & ikon di dalam sidebar saat gelap */
    html[data-theme="dark"] .menu-link-heading { color: #eef3f1; text-shadow: 0px 1em 0px #2c3352; }
    html[data-theme="dark"] .menu .eyebrow { color: #8fd0bf; }
    html[data-theme="dark"] .menu .p-small,
    html[data-theme="dark"] .menu .p-large { color: #c9d4d1; }
    @media (hover: hover) {
      html[data-theme="dark"] .menu-link:hover .menu-link-heading { text-shadow: 0px 1em 0px #ffffff; }
    }
    @media (prefers-reduced-motion: reduce) {
      .ms-layer, .ms-star { animation: none; }
    }

    /* ============================================================
       TEMA GLOBAL: latar penuh sampai pojok kiri & kanan layar
       Terang  = putih  (#ffffff)
       Gelap   = hitam  (#0a0f1a)
       Berganti lewat tombol di navbar (html[data-theme]).
       ============================================================ */
    :root {
      --site-bg: #ffffff;
      --site-fg: #14211b;
      color-scheme: light;
    }
    html[data-theme="dark"] {
      --site-bg: #0a0f1a;
      --site-fg: #e8f1ee;
      color-scheme: dark;
    }
    html,
    html body {
      margin: 0;
      width: 100%;
      min-height: 100%;
      background-color: var(--site-bg) !important;
      transition: background-color 0.4s ease;
    }
    html[data-theme="dark"] body { color: var(--site-fg); }
    @media (prefers-reduced-motion: reduce) {
      html, html body { transition: none; }
    }
</style>

<script>
  // Terapkan tema tersimpan sedini mungkin supaya halaman tidak "berkedip"
  (function () {
    try {
      var t = localStorage.getItem('theme');
      if (t === 'dark' || t === 'light') document.documentElement.setAttribute('data-theme', t);
    } catch (e) {}
  })();
</script>

<div class="osmo-ui">
  <header class="header @unless (request()->routeIs('home')) header--pinned @endunless" id="navHeader">
      <div class="nav-sky" aria-hidden="true">
        <div class="nav-sky-clouds">
          <span></span><span></span><span></span><span></span><span></span>
        </div>
        <div class="nav-sky-stars">
          <span class="nav-sky-star" style="--x:6%;--y:30%;--s:0.8;--d:0.0s"></span>
          <span class="nav-sky-star" style="--x:18%;--y:55%;--s:0.6;--d:0.5s"></span>
          <span class="nav-sky-star" style="--x:34%;--y:20%;--s:0.9;--d:1.0s"></span>
          <span class="nav-sky-star" style="--x:50%;--y:60%;--s:0.5;--d:1.5s"></span>
          <span class="nav-sky-star" style="--x:66%;--y:25%;--s:0.7;--d:2.0s"></span>
          <span class="nav-sky-star" style="--x:80%;--y:50%;--s:0.6;--d:0.3s"></span>
          <span class="nav-sky-star" style="--x:92%;--y:30%;--s:0.8;--d:0.8s"></span>
        </div>
      </div>
      <nav class="nav-row">
        <div class="nav-left">
          <a href="{{ url('/') }}" class="nav-brand nav-logo-row">
              <img src="{{ asset('img/logo asta.png') }}" alt="Logo Astabrata">
              <div class="nav-brand-text">
                  Astabrata
                  <span>Teknologi</span>
              </div>
          </a>
        </div>
        <div class="nav-row__right">
          <div class="theme-toggle-wrap">
            <button type="button" id="themeToggle" class="theme-toggle" role="switch" aria-checked="false" aria-label="Ganti mode gelap / terang" data-theme="light">
              <span class="tt-rays"></span>
              <span class="tt-sun">
                <span class="tt-spot tt-spot1"></span>
                <span class="tt-spot tt-spot2"></span>
                <span class="tt-spot tt-spot3"></span>
              </span>
              <span class="tt-moon">
                <span class="tt-dot tt-dot1"></span>
                <span class="tt-dot tt-dot2"></span>
                <span class="tt-dot tt-dot3"></span>
              </span>
            </button>
          </div>
          <button role="button" data-menu-toggle="" class="menu-button">
            <div class="menu-button-text">
              <p class="p-large">Menu</p>
              <p class="p-large">Close</p>
            </div>
            <div class="icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" width="100%" viewBox="0 0 16 16" fill="none" class="menu-button-icon">
                <path d="M7.33333 16L7.33333 -3.2055e-07L8.66667 -3.78832e-07L8.66667 16L7.33333 16Z" fill="currentColor"></path>
                <path d="M16 8.66667L-2.62269e-07 8.66667L-3.78832e-07 7.33333L16 7.33333L16 8.66667Z" fill="currentColor"></path>
                <path d="M6 7.33333L7.33333 7.33333L7.33333 6C7.33333 6.73637 6.73638 7.33333 6 7.33333Z" fill="currentColor"></path>
                <path d="M10 7.33333L8.66667 7.33333L8.66667 6C8.66667 6.73638 9.26362 7.33333 10 7.33333Z" fill="currentColor"></path>
                <path d="M6 8.66667L7.33333 8.66667L7.33333 10C7.33333 9.26362 6.73638 8.66667 6 8.66667Z" fill="currentColor"></path>
                <path d="M10 8.66667L8.66667 8.66667L8.66667 10C8.66667 9.26362 9.26362 8.66667 10 8.66667Z" fill="currentColor"></path>
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
      <div class="bg-panel bg-panel--sky">
        <div class="menu-sky" aria-hidden="true">
          <div class="ms-stars">
          <span class="ms-star" style="--x:8%;--y:6%;--s:1;--d:0.00s"></span>
          <span class="ms-star" style="--x:22%;--y:14%;--s:0.6;--d:0.45s"></span>
          <span class="ms-star" style="--x:40%;--y:5%;--s:0.8;--d:0.90s"></span>
          <span class="ms-star" style="--x:63%;--y:10%;--s:1.1;--d:1.35s"></span>
          <span class="ms-star" style="--x:84%;--y:7%;--s:0.7;--d:1.80s"></span>
          <span class="ms-star" style="--x:12%;--y:28%;--s:0.7;--d:2.25s"></span>
          <span class="ms-star" style="--x:33%;--y:34%;--s:0.5;--d:2.70s"></span>
          <span class="ms-star" style="--x:55%;--y:26%;--s:0.6;--d:0.15s"></span>
          <span class="ms-star" style="--x:76%;--y:31%;--s:1;--d:0.60s"></span>
          <span class="ms-star" style="--x:92%;--y:24%;--s:0.5;--d:1.05s"></span>
          <span class="ms-star" style="--x:6%;--y:52%;--s:0.5;--d:1.50s"></span>
          <span class="ms-star" style="--x:28%;--y:60%;--s:0.7;--d:1.95s"></span>
          <span class="ms-star" style="--x:88%;--y:48%;--s:0.6;--d:2.40s"></span>
          <span class="ms-star" style="--x:70%;--y:55%;--s:0.5;--d:2.85s"></span>
          </div>
          <div class="ms-clouds">
            <div class="ms-layer ms-layer--back">
              <span></span><span></span><span></span><span></span><span></span>
            </div>
            <div class="ms-layer ms-layer--front">
              <span></span><span></span><span></span><span></span><span></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-inner">
      <ul class="menu-list">
        <li class="menu-list-item">
          <a href="{{ url('/') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Beranda</p>
            <p class="eyebrow">01</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/layanan') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Layanan</p>
            <p class="eyebrow">02</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/blog') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Blog</p>
            <p class="eyebrow">03</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/about') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">About</p>
            <p class="eyebrow">04</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/contact') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Contact</p>
            <p class="eyebrow">05</p>
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
            let menuToggles = document.querySelectorAll("[data-menu-toggle]");
            let menuLinks = navWrap.querySelectorAll(".menu-link");
            let fadeTargets = navWrap.querySelectorAll("[data-menu-fade]");
            let menuButton = document.querySelector(".menu-button");
            let menuButtonTexts = menuButton.querySelectorAll("p");
            let menuButtonIcon = menuButton.querySelector(".menu-button-icon");
            let navHeader = document.getElementById("navHeader");

            let tl = gsap.timeline();

            const openNav = () => {
                navWrap.setAttribute("data-nav", "open");
                document.body.style.overflow = 'hidden';
                navHeader.classList.add('menu-open');

                tl.clear()
                .set(navWrap, { display: "block" })
                .set(menu, { xPercent: 0 }, "<")
                .fromTo(menuButtonTexts, { yPercent: 0 }, { yPercent: -100, stagger: 0.2 })
                .fromTo(menuButtonIcon, { rotate: 0 }, { rotate: 315 }, "<")
                .fromTo(overlay, { autoAlpha: 0 }, { autoAlpha: 1 }, "<")
                .fromTo(bgPanels, { xPercent: 101 }, { xPercent: 0, stagger: 0.12, duration: 0.575 }, "<")
                .fromTo(menuLinks, { yPercent: 140, rotate: 10 }, { yPercent: 0, rotate: 0, stagger: 0.05 }, "<+=0.35")
                .fromTo(fadeTargets, { autoAlpha: 0, yPercent: 50 }, { autoAlpha: 1, yPercent: 0, stagger: 0.04 }, "<+=0.2");
            };

            const closeNav = () => {
                navWrap.setAttribute("data-nav", "closed");
                document.body.style.overflow = '';
                navHeader.classList.remove('menu-open');

                tl.clear()
                .to(overlay, { autoAlpha: 0 })
                .to(menu, { xPercent: 120 }, "<")
                .to(menuButtonTexts, { yPercent: 0 }, "<")
                .to(menuButtonIcon, { rotate: 0 }, "<")
                .set(navWrap, { display: "none" });
            };

            // Toggle menu open / close
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

            // Escape key handler
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape" && navWrap.getAttribute("data-nav") === "open") {
                    closeNav();
                }
            });

            // Scroll: transparent → white
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navHeader.classList.add('scrolled');
                } else {
                    navHeader.classList.remove('scrolled');
                }
            });
        }

        initMenu();

        // Tombol Dark / Light Mode
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

        // Tombol Back: kembali ke halaman sebelumnya kalau ada riwayatnya
        // dari situs ini, kalau tidak (misal dibuka langsung dari link luar) balik ke Beranda
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