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
        color: #2f6e4e;
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
      padding: 20px 5%;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      transition: all 0.4s ease;
      box-sizing: border-box;
    }

    .header.scrolled {
        background: rgba(255, 255, 255, 0.97);
        padding: 12px 5%;
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
      width: 35em;
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
      background-color: var(--color-primary, #9fd6b9);
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
      color: var(--color-primary, #2f6e4e);
      text-transform: uppercase;
      font-family: monospace;
      font-weight: 400;
      position: relative;
      margin: 0;
    }

    .menu-link-bg {
      z-index: 0;
      background-color: #2f6e4e;
      transform-origin: 50% 100%;
      transform-style: preserve-3d;
      transition: transform .55s cubic-bezier(.65, .05, 0, 1);
      position: absolute;
      inset: 0%;
      transform: scale3d(1, 0, 1);
    }

    .menu-details {
      padding-left: var(--menu-padding);
      grid-column-gap: 1.25em;
      grid-row-gap: 1.25em;
      flex-flow: column;
      justify-content: flex-start;
      align-items: flex-start;
      display: flex;
    }

    .p-small {
      font-size: .875em;
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      color: #131313;
    }

    .socials-row {
      grid-column-gap: 1em;
      grid-row-gap: 1em;
      flex-flow: row;
      align-items: center;
      display: flex;
    }

    /* ------- Social Media Icons ------- */
    .social-icon-link {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #FFFFFF;
      border: 1px solid rgba(11, 74, 86, 0.16);
      color: #093B45;
      box-shadow: 0 2px 10px rgba(9, 59, 69, 0.08);
      transition: background-color 0.3s ease, color 0.3s ease,
                  border-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
      flex-shrink: 0;
    }

    .social-icon-link svg {
      width: 19px;
      height: 19px;
      transition: transform 0.35s cubic-bezier(.65, .05, 0, 1);
    }

    @media (hover: hover) {
      .social-icon-link:hover {
        background-color: #0B4A56;
        border-color: #0B4A56;
        color: #FFFFFF;
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(9, 59, 69, 0.28);
      }

      .social-icon-link:hover svg {
        transform: scale(1.12);
      }
    }

    @media screen and (max-width: 768px) {
      .social-icon-link {
        width: 38px;
        height: 38px;
      }

      .social-icon-link svg {
        width: 16px;
        height: 16px;
      }
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
        background: var(--color-primary, #2f6e4e);
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
        width: 100%;
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

      .socials-row {
        grid-column-gap: 1em;
        grid-row-gap: 1em;
      }

      .p-large.text-link {
        font-size: 1em;
      }

      .nav-brand img { width: 32px; height: 32px; }
      .nav-brand-text { font-size: 1rem; }
      .nav-brand-text span { font-size: 0.6rem; }
    }

    @media screen and (max-width: 479px) {
      .menu {
        padding-top: calc(7 * var(--menu-padding));
        padding-bottom: calc(2 * var(--menu-padding));
      }
    }

    /* ------- Back Button ------- */
    .nav-left {
      display: flex;
      align-items: center;
      gap: 26px;
      pointer-events: auto;
    }

    .back-button {
      width: 42px;
      height: 42px;
      border-radius: 14px;
      border: 1px solid rgba(47, 110, 78, 0.18);
      background: linear-gradient(135deg, #eaf6ef 0%, #ffffff 100%);
      color: #2f6e4e;
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
      background: #2f6e4e;
      transform: translateY(100%);
      transition: transform 0.35s cubic-bezier(.65, .05, 0, 1);
    }
    .back-button:hover {
      color: #ffffff;
      border-color: #2f6e4e;
      box-shadow: 0 8px 20px rgba(47, 110, 78, 0.3);
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
        border-color: rgba(47, 110, 78, 0.12);
        box-shadow: none;
      }
      .back-button svg { width: 14px; height: 14px; }
      .back-button:hover { box-shadow: 0 4px 12px rgba(47, 110, 78, 0.25); }
    }
</style>

<div class="osmo-ui">
  <header class="header @unless (request()->routeIs('home')) header--pinned @endunless" id="navHeader">
      <nav class="nav-row">
        <div class="nav-left">
          @unless (request()->routeIs('home'))
            <button type="button" class="back-button" id="backButton" aria-label="Kembali">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5"></path>
                <path d="M12 19l-7-7 7-7"></path>
              </svg>
            </button>
          @endunless
          <a href="{{ url('/') }}" class="nav-brand nav-logo-row">
              <img src="{{ asset('img/logo asta.png') }}" alt="Logo Astabrata">
              <div class="nav-brand-text">
                  Astabrata
                  <span>Teknologi</span>
              </div>
          </a>
        </div>
        <div class="nav-row__right">
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
      <div class="bg-panel"></div>
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
          <a href="{{ url('/blog') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Blog</p>
            <p class="eyebrow">02</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/about') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">About</p>
            <p class="eyebrow">03</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="{{ url('/contact') }}" class="menu-link w-inline-block">
            <p class="menu-link-heading">Contact</p>
            <p class="eyebrow">04</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
        <li class="menu-list-item">
          <a href="javascript:void(0)" data-menu-toggle="" class="menu-link w-inline-block">
            <p class="menu-link-heading">Close</p>
            <p class="eyebrow">05</p>
            <div class="menu-link-bg"></div>
          </a>
        </li>
      </ul>
      <div class="menu-details">
        <p data-menu-fade="" class="p-small">Socials</p>
        <div class="socials-row">
          <a data-menu-fade="" href="#" class="social-icon-link" aria-label="Instagram" target="_blank" rel="noopener">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg>
          </a>
          <a data-menu-fade="" href="#" class="social-icon-link" aria-label="LinkedIn" target="_blank" rel="noopener">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.446-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.266 2.37 4.266 5.455v6.286zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.114 20.452H3.558V9h3.556v11.452z"></path>
            </svg>
          </a>
          <a data-menu-fade="" href="#" class="social-icon-link" aria-label="X / Twitter" target="_blank" rel="noopener">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
            </svg>
          </a>
        </div>
      </div>
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