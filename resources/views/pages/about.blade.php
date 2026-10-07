@extends('layouts.app')

@section('title', 'About Us - PT Astabrata Teknologi')

@section('content')
@php
    $aboutBgUrl = \App\Models\PageSetting::for('about')->bgUrl();
    $aboutDescBgUrl = \App\Models\PageSetting::for('about_desc')->bgUrl();
@endphp
<div class="page-wrapper">
    <section class="hero" id="home" aria-label="Hero">
      <div class="hero__wrapper">
        <div class="hero__row" @if($aboutBgUrl) style="--hero-bg: url('{{ $aboutBgUrl }}')" @endif>

          <div class="hero__stage">
            <!-- Video background utama -->
            <video id="next-video" class="hero__next-video" loop muted playsinline preload="auto"></video>
            <video id="bg-video" class="hero__bg" autoplay muted playsinline loop preload="auto"></video>
          </div>

          <!-- Preview video di tengah, tetap dipertahankan -->
          <div class="hero__mini">
            <div class="hero__mini-inner" id="mini-click" title="Watch next">
              <video id="current-video" class="hero__mini-video" loop muted playsinline preload="auto"></video>
            </div>
          </div>

          <div class="hero__container">
            <div class="hero__content" id="video-frame">
              <div class="hero__copy">
            <h2 class="hero__label hero__label--top">Astabrata</h2>
            <p class="hero__tech">TEKNOLOGI</p>
          </div>
        </div>
          </div><!-- /.hero__container -->
        </div><!-- /.hero__row -->

        <!-- Layer ke-2 (hitam): di luar .hero__row supaya tidak ikut terpotong,
             jadi kelihatan di area yang ter-crop saat scroll -->
        <h2 class="hero__label hero__label--inside">Astabrata</h2>
        <p class="hero__tech hero__tech--inside">TEKNOLOGI</p>
      </div><!-- /.hero__wrapper -->
    </section>

    <section class="zn-about" id="about-content">
        <div class="zn-about__container">
            <p class="zn-about__eyebrow">Tentang Kami</p>
            @php $ps = \App\Models\PageSetting::for('about'); @endphp
            @include('partials.page-style', ['ps' => $ps])
            <h3 class="zn-about__title">{{ $ps->titleText() }}</h3>

            <div class="zn-about__subtext">
                @foreach($ps->descriptionLines() as $descLine)
                    <p>{{ $descLine }}</p>
                @endforeach
            </div>
        </div>

        <div class="zn-about__viewport" id="znClip" aria-label="Zentry shared adventure artwork">
            <div class="zn-about__image" id="znMask">
                <img class="zn-about__img" src="{{ $aboutDescBgUrl ?: asset('image/kantor.jpeg') }}" alt="Background">
            </div>

            <!-- Muncul saat gambar sudah membesar penuh (scroll sampai paling bawah) -->
            <div class="zn-about__shade" id="znShade" aria-hidden="true"></div>
            <div class="zn-about__caption" id="znCaption">
                <h3 class="zn-about__caption-title">{{ $ps->titleText() }}</h3>
                <p class="zn-about__caption-text">{{ $ps->captionText() }}</p>
            </div>
        </div>
    </section>

    <!-- ===== TIM KAMI ===== -->
    <section class="team-section reveal" id="tim-kami">
        <div class="th-card-wrapper">
            <div class="particle-background" aria-hidden="true">
                <div id="particle-canvas"></div>
            </div>

            <div class="section-heading text-center">
                <h2>Tim Kami</h2>
            </div>

            <div class="team-grid">
                @forelse($teams as $team)
                    @php
                        $sosmedData = [];
                        if (is_array($team->sosial_media)) {
                            $sosmedData = $team->sosial_media;
                        } elseif (!empty($team->sosial_media) && $team->sosial_media !== 'null') {
                            $decoded = json_decode($team->sosial_media, true);
                            $sosmedData = is_array($decoded) ? $decoded : [$team->sosial_media];
                        }
                        $sosmedData = array_slice($sosmedData, 0, 3);
                    @endphp

                    <article class="team-card">
                        <div class="team-card-image-content">
                            <span class="team-card-overlay" aria-hidden="true"></span>

                            <div class="team-card-image">
                                <img src="{{ $team->foto_url }}" alt="{{ $team->nama }}" class="team-card-img" loading="lazy">
                            </div>
                        </div>

                        <div class="team-card-content">
                            <h3 class="team-card-name">{{ $team->nama }}</h3>
                            <p class="team-card-role">{{ $team->jabatan }}</p>

                            @if(count($sosmedData) > 0)
                                <div class="team-card-sosmed-wrapper" aria-label="Sosial media {{ $team->nama }}">
                                    @foreach($sosmedData as $link)
                                        @php
                                            $iconClass = 'bx-link';
                                            $textClass = 'brand-text-link';
                                            $label = 'Link';
                                            $lLink = strtolower($link);

                                            if (str_contains($lLink, 'instagram.com')) { $iconClass = 'bxl-instagram'; $textClass = 'brand-text-ig'; $label = 'Instagram'; }
                                            elseif (str_contains($lLink, 'linkedin.com')) { $iconClass = 'bxl-linkedin-square'; $textClass = 'brand-text-in'; $label = 'LinkedIn'; }
                                            elseif (str_contains($lLink, 'github.com')) { $iconClass = 'bxl-github'; $textClass = 'brand-text-gh'; $label = 'GitHub'; }
                                            elseif (str_contains($lLink, 'facebook.com')) { $iconClass = 'bxl-facebook-circle'; $textClass = 'brand-text-fb'; $label = 'Facebook'; }
                                            elseif (str_contains($lLink, 'twitter.com') || str_contains($lLink, 'x.com')) { $iconClass = 'x-logo'; $textClass = 'brand-text-x'; $label = 'X'; }
                                            elseif (str_contains($lLink, 'youtube.com')) { $iconClass = 'bxl-youtube'; $textClass = 'brand-text-yt'; $label = 'YouTube'; }
                                            elseif (str_contains($lLink, 'tiktok.com')) { $iconClass = 'bxl-tiktok'; $textClass = 'brand-text-tt'; $label = 'TikTok'; }
                                            elseif (str_contains($lLink, 'wa.me') || str_contains($lLink, 'whatsapp')) { $iconClass = 'bxl-whatsapp'; $textClass = 'brand-text-wa'; $label = 'WhatsApp'; }
                                        @endphp

                                        <a class="team-card-sosmed {{ $textClass }}"
                                           href="{{ $link }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           title="{{ $label }}"
                                           aria-label="{{ $label }} {{ $team->nama }}">
                                            @if($iconClass === 'x-logo')
                                                <svg class="team-card-sosmed-x" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true">
                                                    <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>
                                                </svg>
                                            @else
                                                <i class='bx {{ $iconClass }}'></i>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <article class="team-card">
                        <div class="team-card-image-content">
                            <span class="team-card-overlay" aria-hidden="true"></span>
                            <div class="team-card-image">
                                <img src="{{ asset('image/profile.png') }}" alt="Tim Astabrata" class="team-card-img">
                            </div>
                        </div>
                        <div class="team-card-content">
                            <h3 class="team-card-name">Tim Astabrata</h3>
                            <p class="team-card-role">Segera hadir</p>
                        </div>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    @php
        // Data untuk filter galeri
        $galleryList = collect($galleries ?? []);
        $galleryCategories = $galleryList
            ->map(fn ($g) => trim((string) ($g->kategori ?? '')))
            ->filter()
            ->unique()
            ->values();
        $hasCategories = $galleryCategories->isNotEmpty();
        $hasUncategorized = $hasCategories && $galleryList->contains(fn ($g) => trim((string) ($g->kategori ?? '')) === '');
    @endphp

    <section class="gallery-section reveal">
        <div class="gallery-particles" id="galleryParticles" aria-hidden="true"></div>
        <div class="gallery-inner">
            <div class="section-heading text-center">
                <h2>Galeri Kegiatan</h2>
            </div>

            @if($galleryList->count() > 1)
            <div class="gallery-filter" role="group" aria-label="Filter galeri">
                <div class="gallery-filter-track">
                    <button type="button" class="gallery-filter-btn is-active" data-type="all" data-filter="all" aria-pressed="true">Semua</button>
                    @if($hasCategories)
                        @foreach($galleryCategories as $galleryCat)
                            <button type="button" class="gallery-filter-btn" data-type="category" data-filter="{{ \Illuminate\Support\Str::slug($galleryCat) }}" aria-pressed="false">{{ $galleryCat }}</button>
                        @endforeach
                        @if($hasUncategorized)
                            <button type="button" class="gallery-filter-btn" data-type="category" data-filter="lainnya" aria-pressed="false">Lainnya</button>
                        @endif
                    @else
                        {{-- Belum ada kolom "kategori" di data galeri: filter berdasarkan bentuk foto --}}
                        <button type="button" class="gallery-filter-btn" data-type="orientation" data-filter="landscape" aria-pressed="false">Lanskap</button>
                        <button type="button" class="gallery-filter-btn" data-type="orientation" data-filter="portrait" aria-pressed="false">Potret</button>
                    @endif
                </div>
            </div>
            @endif

            <div class="gallery-grid" id="galleryGrid">
                @forelse($galleries as $gallery)
                    @php
                        $itemCat = trim((string) ($gallery->kategori ?? ''));
                        $itemCatSlug = $hasCategories ? ($itemCat !== '' ? \Illuminate\Support\Str::slug($itemCat) : 'lainnya') : '';
                        $itemTitle = trim((string) ($gallery->judul ?? ''));
                    @endphp
                    <figure class="gallery-card" data-category="{{ $itemCatSlug }}" tabindex="0" role="button" aria-label="Lihat foto{{ $itemTitle !== '' ? ': ' . $itemTitle : '' }}">
                        <img src="{{ $gallery->foto_url }}" class="gallery-item" data-caption="{{ $itemTitle }}" data-category-label="{{ $itemCat }}" alt="{{ $itemTitle !== '' ? $itemTitle : 'Foto galeri' }}" decoding="async" @if($hasCategories) loading="lazy" @endif>
                        @if($itemCat !== '' || $itemTitle !== '')
                            <figcaption class="gallery-overlay">
                                @if($itemTitle !== '')<span class="gallery-title">{{ $itemTitle }}</span>@endif
                                @if($itemCat !== '')<span class="gallery-cat">{{ $itemCat }}</span>@endif
                            </figcaption>
                        @endif
                        <span class="gallery-zoom" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                        </span>
                    </figure>
                @empty
                    <figure class="gallery-card" data-category="" tabindex="0" role="button" aria-label="Lihat foto: Galeri Astabrata">
                        <img src="{{ asset('image/asta1.png') }}" class="gallery-item" data-caption="Galeri Astabrata" alt="Galeri Astabrata" decoding="async">
                        <figcaption class="gallery-overlay">
                            <span class="gallery-title">Galeri Astabrata</span>
                        </figcaption>
                        <span class="gallery-zoom" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M11 8v6M8 11h6"/></svg>
                        </span>
                    </figure>
                @endforelse
            </div>

            <p class="gallery-empty" id="galleryEmpty" hidden>Belum ada foto pada kategori ini.</p>
        </div>
    </section>
</div>

<div id="imageModal" class="custom-modal">
    <div class="modal-content-wrapper">
        <div class="modal-photo">
            <img class="modal-content" id="zoomedImage" alt="">

            <div class="modal-info" id="modalInfo" hidden>
                <h3 class="modal-info-title" id="modalTitle"></h3>
                <p class="modal-info-cat" id="modalCategory"></p>
            </div>

            <button type="button" class="close-modal" aria-label="Tutup">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/></svg>
            </button>
        </div>

        <button type="button" class="modal-nav-btn prev-btn" id="modalPrev" aria-label="Foto sebelumnya">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 5l-7 7 7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button type="button" class="modal-nav-btn next-btn" id="modalNext" aria-label="Foto berikutnya">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M9 5l7 7-7 7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>
</div>

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:wght@100..900&family=Roboto:wght@400;500;600;700&family=Sora:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<style>
/* ===== HERO REDEFINE (dipindahkan dari hero HTML) ===== */
.hero,.hero__row,.hero__wrapper{position:relative}
.hero{min-height:100dvh}
.hero__wrapper{
  left:50%;
  margin-left:-50vw;
  margin-right:-50vw;
  width:100vw;
}
.hero__row{
  border-radius:0 0 40% 10%;
  height:100dvh;
  isolation:isolate;
  left:50%;
  margin-left:-50vw;
  margin-right:-50vw;
  max-width:none;
  overflow:clip;
  right:50%;
  width:100vw;
  z-index:10;
  background-image:
    linear-gradient(180deg,rgba(0,0,0,.35) 0%,rgba(0,0,0,.15) 35%,rgba(0,0,0,.65) 100%),
    var(--hero-bg, url("https://images.unsplash.com/photo-1718220216044-006f43e3a9b1?fm=jpg&q=80&w=2400&auto=format&fit=crop"));
  background-size:cover;
  background-position:center;
}
.hero__stage{
  height:100%;
  left:50%;
  position:absolute;
  top:0;
  transform:translateX(-50%);
  width:100vw;
  z-index:0;
}
.hero__bg,.hero__next-video{
  height:100%;
  left:0;
  object-fit:cover;
  position:absolute;
  top:0;
  width:100%;
}
.hero__next-video{opacity:0}
.hero__container{
  height:100dvh;
  position:relative;
}
.hero__content{
  align-items:start;
  background:transparent;
  display:grid;
  grid-template-columns:repeat(2,1fr);
  grid-template-rows:repeat(2,1fr);
  height:100%;
  position:static;
  row-gap:20px;
}
.hero__copy{
  align-items:start;
  display:flex;
  flex-direction:column;
  grid-column:span 2;
  justify-content:flex-end;
  padding:0 24px 30px;
  row-gap:15px;
  z-index:3;
}
.hero__label{
  color:#fff;
  font-family:zentry,Impact,Arial Black,sans-serif;
  font-weight:900;
  font-size:clamp(34px,6.5vw,96px);
  line-height:.85;
  margin:0;
  text-transform:uppercase;
  letter-spacing:-.02em;
}
.hero__subtitle{
  color:#fff;
  font-family:robert,Arial,sans-serif;
  font-size:clamp(11px,1vw,14px);
  line-height:1.3;
  max-width:220px;
  margin:0;
  position:absolute;
  left:50%;
  top:68%;
  transform:translateX(-50%);
  text-align:center;
}
.hero__tech{
  position:absolute;
  right:24px;
  bottom:7%;
  margin:0;
  color:#fff;
  font-family:"Poppins","Roboto",ui-sans-serif,sans-serif;
  font-size:clamp(11px,1.1vw,15px);
  font-weight:300;
  letter-spacing:.42em;
  text-transform:uppercase;
  text-align:right;
  z-index:3;
  pointer-events:none;
}
.hero__tech--inside{
  color:var(--title-color,#094356) !important;
  z-index:0;
}
.hero__label--top,
.hero__label--inside{
  bottom:11%;
  display:block;
  pointer-events:none;
  position:absolute;
  right:24px;
  margin:0;
}
.hero__label--top{
  color:#fff !important;
  z-index:3;
}
.hero__label--inside{
  color:var(--title-color,#094356) !important;
  z-index:0;
}
.hero__btn{
  align-items:center;
  background:#edff66;
  border-radius:30px;
  color:#fff;
  display:inline-flex;
  justify-content:center;
  padding:12px 25px;
  text-transform:uppercase;
  transition:transform .3s cubic-bezier(.22,.61,.36,1);
  will-change:transform;
}
.hero__btn:hover{transform:scale(1.04)}
.hero__btn .btn__label{
  align-items:center;
  display:inline-grid;
  justify-items:center;
  line-height:1;
  overflow:hidden;
}
.hero__btn .btn__alt,
.hero__btn .btn__main{
  grid-area:1/1;
  transition:transform .45s cubic-bezier(.22,.61,.36,1);
  white-space:nowrap;
  will-change:transform;
}
.hero__btn .btn__main{transform:translateY(0)}
.hero__btn .btn__alt{transform:translateY(120%)}
.hero__btn:hover .btn__main{transform:translateY(-120%)}
.hero__btn:hover .btn__alt{transform:translateY(0)}
.hero__mini{
  position:absolute;
  left:50%;
  top:50%;
  transform:translate(-50%,-50%);
  z-index:10;
}
.hero__mini-inner{
  transform:scale(.5);
  transition:transform .5s ease;
}
.hero__mini-video{
  aspect-ratio:1;
  border-radius:16px;
  cursor:pointer;
  height:100%;
  max-height:256px;
  max-width:256px;
  object-fit:cover;
  overflow:hidden;
  transform:scale(1.5);
  width:100%;
}
.hero__mini:hover .hero__mini-inner{transform:scale(.56)}
@media (max-width: 991px) {
  .hero__mini { display: none; }
  .hero__copy { padding-top: 90px; }
  .hero__label { font-size: clamp(32px,8vw,60px); }
}
@media (max-width: 600px) {
  .hero { min-height: 52dvh; }
  .hero__row {
    height: 52dvh;
    min-height: 340px;
    border-radius: 0 0 25% 7%;
    background-position: center 100%;
  }
  .hero__stage,
  .hero__container { height: 52dvh; min-height: 340px; }
  .hero__bg,
  .hero__next-video { object-position: center 92%; }
  .hero__copy { padding: 72px 18px 22px; }
  .hero__label { font-size: clamp(28px, 8vw, 46px); }
  .hero__label--top,
  .hero__label--inside {
    right: 18px;
    bottom: 13%;
  }
  .hero__tech { right: 18px; bottom: 8%; }
  .hero__subtitle { max-width: 200px; top: 62%; }
}

/* ===== DESKTOP: TEKNOLOGI lebih besar & Astabrata Teknologi digeser ke atas ===== */
@media (min-width: 992px) {
  .hero { min-height: 86dvh; }
  .hero__row {
    height: 86dvh;
    background-position: center top;
  }
  .hero__container { height: 100%; }
  .hero__bg,
  .hero__next-video { object-position: center top; }

  .hero {
    --tech-size: clamp(16px, 1.6vw, 24px);
    --tech-gap: 20px;
  }
  .hero__label--top,
  .hero__label--inside { bottom: calc(5% + var(--tech-size) + var(--tech-gap)); }
  .hero__tech {
    bottom: 5%;
    font-size: var(--tech-size);
    line-height: 1;
  }
}

/* ===== ZENTRY ABOUT ===== */
.zn-about{
  position:relative;
  z-index:5;
  width:calc(100% + 10vw);
  margin-left:-5vw;
  margin-right:-5vw;
  background:#fff;
  color:#094356;
  padding-top:80px;
}
.zn-about__container{
  align-items:center;
  display:flex;
  flex-direction:column;
  position:relative;
  text-align:center;
  padding:0 20px 30px;
  gap:20px;
}
.zn-about__eyebrow{
  color:var(--title-color,#094356);
  font-family:'Google Sans Flex', robert,Arial,sans-serif;
  font-size:16px;
  letter-spacing:.08em;
  margin:0;
  opacity:.8;
  text-transform:uppercase;
}
.zn-about__title{
  color:#094356;
  font-family:'Google Sans Flex', 'Sora','Poppins',sans-serif;
  font-weight:700;
  font-size:clamp(32px,5.2vw,72px);
  letter-spacing:-.03em;
  line-height:1.1;
  margin:0;
  max-width:1100px;
  text-transform:none;
}
.zn-about__subtext{
  color:#094356;
  display:grid;
  font-family:'Google Sans Flex', 'Poppins',sans-serif;
  font-size:clamp(15px,1.4vw,18px);
  font-weight:400;
  gap:6px;
  line-height:1.6;
  opacity:.9;
  text-align:center;
  margin:0;
}
.zn-about__subtext p{margin:0}
.zn-about__viewport{
  height:100dvh;
  overflow:hidden;
  position:relative;
}
.zn-about__image{
  border-radius:24px;
  left:50%;
  overflow:hidden;
  pointer-events:none;
  position:absolute;
  top:0;
  transform:translateX(-50%);
  will-change:width,height,border-radius;
  height:600px;
  width:520px;
}
.zn-about__img{
  height:100%;
  inset:0;
  object-fit:cover;
  position:absolute;
  width:100%;
}
.zn-about__shade{
  background:linear-gradient(to top,rgba(0,0,0,.88) 0%,rgba(0,0,0,.62) 30%,rgba(0,0,0,.28) 58%,rgba(0,0,0,0) 85%);
  inset:0;
  opacity:0;
  pointer-events:none;
  position:absolute;
  visibility:hidden;
  z-index:1;
}
.zn-about__caption{
  bottom:0;
  color:#fff;
  display:flex;
  flex-direction:column;
  gap:14px;
  left:0;
  max-width:760px;
  padding:0 6vw 9vh;
  pointer-events:none;
  position:absolute;
  z-index:2;
}
.zn-about__caption > *{margin:0;opacity:0;visibility:hidden}
.zn-about__caption-eyebrow{
  font-family:'Google Sans Flex', robert,Arial,sans-serif;
  font-size:14px;
  font-weight:700;
  letter-spacing:.12em;
  text-transform:uppercase;
  opacity:.85;
}
.zn-about__caption-title{
  color:#fff;
  font-family:'Google Sans Flex', 'Sora','Poppins',sans-serif;
  font-weight:700;
  font-size:clamp(26px,3.6vw,52px);
  letter-spacing:-.03em;
  line-height:1.1;
  text-transform:none;
}
.zn-about__caption-text{
  font-family:'Google Sans Flex', 'Poppins',sans-serif;
  font-size:clamp(14px,1.3vw,17px);
  font-weight:400;
  line-height:1.65;
  color:rgba(255,255,255,.9);
}
@media (max-width:600px){
  .zn-about__caption{padding:0 20px 8vh;gap:10px}
  .zn-about__caption-eyebrow{font-size:11px}
  .zn-about{padding-top:50px}
  .zn-about__title{font-size:30px}
  .zn-about__eyebrow{font-size:12px}
  .zn-about__image{height:400px;width:290px}
}

    /* RESET PENTING */
    html, body {
        width: 100% !important;
        max-width: 100vw !important;
        overflow-x: hidden !important;
        margin: 0;
        padding: 0;
    }

    *, *::before, *::after {
        box-sizing: border-box;
    }

    .page-wrapper {
        position: relative;
        padding: 90px 5% 0;
        min-height: 100vh;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        isolation: isolate;
        background: #ffffff;
    }

    .page-wrapper > * {
        position: relative;
        z-index: 5;
    }

    @media (min-width: 992px) {
        .page-wrapper { padding-top: 64px; }
    }
    
    .about-header {
        text-align: center;
        margin-bottom: 60px;
    }
    .about-header .eyebrow {
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        color: #094356;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        font-size: 1rem;
        display: block;
        margin-bottom: 15px;
    }
    .about-header h1 {
        font-family: 'Google Sans Flex', 'Sora', sans-serif;
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
        font-family: 'Google Sans Flex', 'Sora', 'Poppins', sans-serif;
        font-weight: 700;
        font-size: clamp(1.7rem, 3.2vw, 2.4rem);
        letter-spacing: -0.03em;
        line-height: 1.15;
        text-transform: none;
        color: #094356;
        margin-bottom: 10px;
    }
    .section-heading p {
        font-family: 'Google Sans Flex', robert, Arial, sans-serif;
        font-weight: 700;
        line-height: 1.25;
        color: #094356;
        font-size: 1.1rem;
    }
    .text-center { text-align: center; }

    /* About Section */
    .about-section {
        position: relative;
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
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

    #tim-kami { scroll-margin-top: 90px; }

    /* ===== Tim Kami: card biasa, maksimal 3 kolom ===== */
    .team-section {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0;
        position: relative;
    }

    .th-card-wrapper .section-heading {
        position: relative;
        z-index: 5;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 40px;
        padding: 0 12px;
    }

    .th-card-wrapper {
        position: relative;
        width: calc(100% + 10vw);
        max-width: none;
        margin-left: -5vw;
        margin-right: -5vw;
        background: transparent;
        padding: 56px 20px 72px;
        overflow: hidden;
        box-sizing: border-box;
    }

    .team-grid {
        position: relative;
        z-index: 5;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 300px));
        justify-content: center;
        gap: 24px;
        max-width: 972px;
        margin: 0 auto;
    }

    /* ===== Tim Kami - gaya Card 3 ===== */
    .team-card {
        --tc-bg: #ffffff;
        --tc-ink: #333333;
        --tc-muted: #707070;
        --tc-accent: var(--title-color, #094356);
        position: relative;
        overflow: hidden;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        min-height: 382px;
        text-align: center;
        border-radius: 25px;
        background: var(--tc-bg);
        box-shadow: 0 8px 24px rgba(9, 67, 86, 0.10);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 18px 35px rgba(9, 67, 86, 0.18);
    }

    .team-card-image-content {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 0;
        row-gap: 5px;
        overflow: hidden;
    }

    .team-card-overlay {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        background: var(--tc-accent);
        border-radius: 25px 25px 0 25px;
    }

    .team-card-overlay::before,
    .team-card-overlay::after {
        content: '';
        position: absolute;
        right: 0;
        bottom: -40px;
        width: 40px;
        height: 40px;
        background: var(--tc-accent);
    }

    .team-card-overlay::after {
        border-radius: 0 25px 0 0;
        background: var(--tc-bg);
    }

    .team-card-image {
        position: relative;
        z-index: 2;
        width: 150px;
        height: 150px;
        padding: 3px;
        border-radius: 50%;
        background: var(--tc-bg);
    }

    .team-card-img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        border-radius: 50%;
        border: 4px solid var(--tc-accent);
    }

    .team-card-content {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 172px;
        padding: 18px 14px;
        background: var(--tc-bg);
    }

    .team-card-name {
        margin: 0;
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: 18px;
        font-weight: 500;
        line-height: 1.35;
        color: var(--tc-ink);
        text-align: center;
        overflow-wrap: anywhere;
    }

    .team-card-role {
        margin: 7px 0 0;
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: var(--tc-muted);
        text-align: center;
        overflow-wrap: anywhere;
    }

    .team-card-sosmed-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 9px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .team-card-sosmed {
        --sm-bg: var(--tc-accent);
        --sm-fg: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border-radius: 50%;
        border: none;
        background: var(--sm-bg);
        color: var(--sm-fg);
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.10);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .team-card-sosmed:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 14px rgba(0, 0, 0, 0.16);
    }

    .team-card-sosmed i {
        font-size: 18px;
        line-height: 1;
        color: inherit;
    }

    .team-card-sosmed.brand-text-ig { --sm-fg: #fff; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); }
    .team-card-sosmed.brand-text-fb { --sm-bg: #1877F2; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-in { --sm-bg: #0A66C2; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-gh { --sm-bg: #24292f; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-x  { --sm-bg: #000000; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-yt { --sm-bg: #FF0000; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-tt { --sm-bg: #000000; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-wa { --sm-bg: #25D366; --sm-fg: #fff; }
    .team-card-sosmed.brand-text-link { --sm-bg: var(--tc-accent); --sm-fg: #fff; }

    @media (max-width: 1000px) {
        .team-grid {
            grid-template-columns: repeat(2, minmax(0, 300px));
            max-width: 624px;
        }
    }

    @media (max-width: 560px) {
        .team-grid {
            grid-template-columns: 1fr;
            max-width: 330px;
            gap: 20px;
        }

        .team-card {
            width: 100%;
            min-height: 370px;
        }

        .team-card-image {
            width: 124px;
            height: 124px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .team-card,
        .team-card:hover,
        .team-card-sosmed,
        .team-card-sosmed:hover {
            transition: none;
            transform: none;
        }
    }

    /* Gallery Section */
    .gallery-section {
        position: relative;
        width: calc(100% + 10vw);
        max-width: none;
        margin: 0 -5vw;
        padding: 40px 5vw 80px;
        box-sizing: border-box;
        background: #ffffff;
        isolation: isolate; 
    }
    .gallery-section .section-heading p {
        color: #094356;
    }
    .gallery-inner {
        position: relative;
        z-index: 1; 
        max-width: 1200px;
        margin: 0 auto;
    }

    .gallery-particles {
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
    }

    @supports (background: paint(something)) {
        @property --animation-tick { syntax: '<number>'; inherits: false; initial-value: 0; }
        @property --ring-radius { syntax: '<number> | auto'; inherits: false; initial-value: auto; }
        @property --ring-x { syntax: '<number>'; inherits: false; initial-value: 50; }
        @property --ring-y { syntax: '<number>'; inherits: false; initial-value: 50; }

        @keyframes galleryRipple { 0% { --animation-tick: 0; } 100% { --animation-tick: 1; } }
        @keyframes galleryRing { 0% { --ring-radius: 150; } 100% { --ring-radius: 250; } }

        .gallery-particles {
            --ring-x: 50;
            --ring-y: 50;
            --ring-radius: 100;
            --ring-thickness: 600;
            --particle-count: 80;
            --particle-rows: 25;
            --particle-size: 2;
            --particle-color: navy;
            --particle-min-alpha: 0.1;
            --particle-max-alpha: 1.0;
            --seed: 200;

            background-image: paint(ring-particles);
            animation: galleryRipple 6s linear infinite, galleryRing 6s ease-in-out infinite alternate;
        }

        @media (prefers-reduced-motion: reduce) {
            .gallery-particles { animation: none; }
        }
    }
    
    .gallery-section .section-heading { margin-bottom: 28px; }

    .gallery-filter {
        --gf-text: var(--title-color, #094356);
        --gf-accent: var(--title-color, #094356);
        display: flex;
        justify-content: center;
        margin: 0 auto 40px;
    }

    .gallery-filter-track {
        display: flex;
        gap: 2.5rem;
        max-width: 100%;
        padding: 4px 4px 0;
        overflow-x: auto;
        background: none;
        border: 0;
        border-radius: 0;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .gallery-filter-track::-webkit-scrollbar { display: none; }

    .gallery-filter-btn {
        position: relative;
        flex: 0 0 auto;
        padding: 8px 2px 14px;
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 0.01em;
        line-height: 1.25;
        white-space: nowrap;
        color: var(--gf-text);
        background: none;
        border: 0;
        border-radius: 0;
        box-shadow: none;
        cursor: pointer;
        transition: color 0.25s ease;
    }

    .gallery-filter-btn::after {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        border-radius: 2px;
        background: var(--gf-accent);
        transform: scaleX(0);
        opacity: 1;
        transform-origin: center;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .gallery-filter-btn:hover::after {
        transform: scaleX(1);
        opacity: 0.35;
    }

    .gallery-filter-btn.is-active {
        color: var(--gf-accent);
        background: none;
        box-shadow: none;
    }

    .gallery-filter-btn.is-active::after {
        transform: scaleX(1);
        opacity: 1;
    }

    .gallery-filter-btn:focus-visible {
        outline: 2px solid var(--gf-accent);
        outline-offset: 2px;
        border-radius: 4px;
    }

    .gallery-grid {
        --g-gap: 12px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        grid-auto-rows: 4px;
        column-gap: var(--g-gap);
        row-gap: 0;
    }

    @media (min-width: 640px) {
        .gallery-grid {
            --g-gap: 16px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 1100px) {
        .gallery-grid {
            --g-gap: 18px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    .gallery-card {
        position: relative;
        align-self: start;
        min-width: 0;
        height: 240px; 
        margin: 0;
        overflow: hidden;
        border-radius: 16px;
        background: #e6eef0;
        box-shadow: 0 6px 18px rgba(9, 67, 86, 0.08);
        cursor: pointer;
        transition: box-shadow 0.35s ease;
    }

    .gallery-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(110deg, #e6eef0 30%, #f4f9fa 50%, #e6eef0 70%);
        background-size: 200% 100%;
        animation: galleryShimmer 1.4s linear infinite;
    }

    .gallery-card.is-loaded::before { display: none; }

    .gallery-card:hover { box-shadow: 0 16px 34px rgba(9, 67, 86, 0.2); }

    .gallery-card:focus-visible {
        outline: 3px solid #4d8b78;
        outline-offset: 3px;
    }

    .gallery-card .gallery-item {
        position: absolute;
        inset: 0;
        z-index: 1;
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .gallery-card:hover .gallery-item { transform: scale(1.06); }

    .gallery-overlay {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 3px;
        padding: 44px 16px 14px;
        background: linear-gradient(to top, rgba(6, 40, 52, 0.88) 0%, rgba(6, 40, 52, 0.5) 55%, transparent 100%);
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }

    .gallery-card:hover .gallery-overlay,
    .gallery-card:focus-visible .gallery-overlay {
        opacity: 1;
        transform: none;
    }

    .gallery-title {
        font-family: 'Google Sans Flex', 'Sora', sans-serif;
        font-size: 1rem;
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
    }

    .gallery-cat {
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        line-height: 1.4;
        color: rgba(255, 255, 255, 0.85);
    }

    .gallery-zoom {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        color: #094356;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 50%;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transform: scale(0.85);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }

    .gallery-card:hover .gallery-zoom {
        opacity: 1;
        transform: none;
    }

    @media (hover: none) {
        .gallery-overlay { opacity: 1; transform: none; padding-top: 36px; }
        .gallery-zoom { display: none; }
    }

    .gallery-card.is-hidden { display: none !important; }

    .gallery-card.is-entering {
        animation: galleryCardIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) backwards;
    }

    .gallery-empty {
        padding: 40px 0 10px;
        text-align: center;
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        color: #57676D;
    }

    @keyframes galleryShimmer {
        from { background-position: 200% 0; }
        to   { background-position: -200% 0; }
    }

    @keyframes galleryCardIn {
        from { opacity: 0; transform: translateY(16px) scale(0.97); }
        to   { opacity: 1; transform: none; }
    }

    @media (max-width: 480px) {
        .gallery-filter-track { gap: 1.5rem; }
        .gallery-filter-btn { padding: 8px 2px 12px; font-size: 0.85rem; }
        .gallery-card { border-radius: 12px; }
        .gallery-title { font-size: 0.85rem; }
        .gallery-cat { font-size: 0.72rem; }
    }

    @media (prefers-reduced-motion: reduce) {
        .gallery-card,
        .gallery-card .gallery-item,
        .gallery-overlay,
        .gallery-zoom,
        .gallery-filter-btn,
        .gallery-filter-btn::after { transition: none; }
        .gallery-card::before,
        .gallery-card.is-entering { animation: none; }
    }

    @media (max-width: 768px) {
        .about-content {
            padding: 4rem 5vw 3.5rem;
        }
        .about-header h1 { font-size: 2.2rem; }
        .page-wrapper { padding-top: 70px; }

        .th-card-wrapper {
            width: calc(100% + 10vw);
            max-width: none;
            margin-left: -5vw;
            margin-right: -5vw;
            padding: 30px 15px 12px;
            border-radius: 0;
        }
        .th-card-wrapper .section-heading { margin-bottom: 18px; }

        .gallery-section { padding: 28px 5vw 56px; }
        .gallery-section .section-heading { margin-bottom: 20px; }
        .gallery-filter { margin-bottom: 24px; }
    }

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
        display: block;
        animation: zoomIn 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .modal-photo {
        position: relative;
        overflow: hidden;
        line-height: 0;
        background: #0b0f19;
        border-radius: 14px;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        display: block;
        width: auto;
        height: auto;
        max-width: calc(100vw - 170px); 
        max-height: 84vh;
        object-fit: contain;
    }

    .modal-info {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 4px;
        padding: 56px 22px 20px;
        text-align: left;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.55) 55%, transparent 100%);
        pointer-events: none;
    }

    .modal-info-title {
        margin: 0;
        font-family: 'Google Sans Flex', 'Sora', sans-serif;
        font-size: clamp(18px, 4vw, 26px);
        font-weight: 800;
        line-height: 1.25;
        color: #ffffff;
    }

    .modal-info-cat {
        margin: 0;
        font-family: 'Google Sans Flex', 'Poppins', sans-serif;
        font-size: clamp(12px, 2.5vw, 15px);
        font-weight: 500;
        line-height: 1.5;
        color: #f0f0f0;
    }

    .modal-info[hidden],
    .modal-info-title[hidden],
    .modal-info-cat[hidden],
    .modal-nav-btn[hidden] { display: none; }

    .close-modal {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        padding: 0;
        color: #e53935;
        background: rgba(255, 255, 255, 0.92);
        border: 0;
        border-radius: 50%;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }

    .close-modal svg { width: 18px; height: 18px; }

    .close-modal:hover {
        color: #ffffff;
        background: #e53935;
        transform: rotate(90deg) scale(1.08);
    }

    .modal-nav-btn {
        position: absolute;
        top: 50%;
        z-index: 3;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        padding: 0;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 50%;
        backdrop-filter: blur(4px);
        cursor: pointer;
        transform: translateY(-50%);
        transition: background-color 0.25s ease, transform 0.25s ease;
    }

    .modal-nav-btn svg { width: 22px; height: 22px; }

    .modal-nav-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.08);
    }

    .prev-btn { left: -60px; }
    .next-btn { right: -60px; }

    @media (max-width: 768px) {
        .modal-content { max-width: calc(100vw - 24px); max-height: 78vh; }
        .modal-info { padding: 44px 16px 16px; }
        .close-modal { top: 10px; right: 10px; width: 36px; height: 36px; }
        .close-modal svg { width: 16px; height: 16px; }
        .modal-nav-btn {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.45);
            border-color: rgba(255, 255, 255, 0.25);
        }
        .modal-nav-btn svg { width: 18px; height: 18px; }
        .prev-btn { left: 8px; }
        .next-btn { right: 8px; }
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    /* DARK MODE */
    html[data-theme="dark"] .page-wrapper,
    html[data-theme="dark"] .zn-about,
    html[data-theme="dark"] .gallery-section,
    html[data-theme="dark"] .team-section { background: #0a0f1a; }

    html[data-theme="dark"] .zn-about,
    html[data-theme="dark"] .zn-about__title,
    html[data-theme="dark"] .zn-about__subtext,
    html[data-theme="dark"] .about-header .eyebrow,
    html[data-theme="dark"] .about-header h1,
    html[data-theme="dark"] .section-heading h2,
    html[data-theme="dark"] .section-heading p,
    html[data-theme="dark"] .gallery-section .section-heading p { color: #8fd0bf; }

    html[data-theme="dark"] .subtitle,
    html[data-theme="dark"] .gallery-empty { color: #aab8b4; }

    html[data-theme="dark"] .gallery-filter { --gf-text: #c9d4d1; --gf-accent: #8fd0bf; }
    html[data-theme="dark"] .gallery-particles { --particle-color: #4FA8B5; }

    html[data-theme="dark"] .gallery-card { background: #151c2c; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.45); }
    html[data-theme="dark"] .gallery-card::before {
        background: linear-gradient(110deg, #151c2c 30%, #1f2940 50%, #151c2c 70%);
        background-size: 200% 100%;
    }

    html[data-theme="dark"] .particle-background #particle-canvas > div { background: #0a0f1a !important; }

    /* Tim Kami (dark mode) */
    html[data-theme="dark"] .team-card {
        --tc-bg: #151c2c;
        --tc-ink: #e8f1ee;
        --tc-muted: #9aa8a4;
        --tc-accent: #0d6078;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.48);
    }
    html[data-theme="dark"] .team-card:hover { box-shadow: 0 18px 36px rgba(0, 0, 0, 0.62); }
    html[data-theme="dark"] .team-card-overlay,
    html[data-theme="dark"] .team-card-overlay::before { background: var(--tc-accent); }
    html[data-theme="dark"] .team-card-overlay::after { background: var(--tc-bg); }

    /* Sosmed (dark mode): brand gelap dibalik jadi putih agar tetap terlihat */
    html[data-theme="dark"] .team-card-sosmed.brand-text-gh,
    html[data-theme="dark"] .team-card-sosmed.brand-text-x,
    html[data-theme="dark"] .team-card-sosmed.brand-text-tt { --sm-bg: #f2f5f4; --sm-fg: #111; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script>
(() => {
  if (typeof gsap === "undefined" || typeof ScrollTrigger === "undefined") return;
  gsap.registerPlugin(ScrollTrigger);

  const bgVideo = document.querySelector("#bg-video");
  const currentVideo = document.querySelector("#current-video");
  const nextVideo = document.querySelector("#next-video");
  const miniClick = document.querySelector("#mini-click");
  const heroRow = document.querySelector(".hero__row");
  const clip = document.querySelector("#clip");
  const mask = document.querySelector(".mask-clip-path");

  const videos = [
    @json(asset('files/hero-1.mp4')),
    @json(asset('files/hero-2.mp4')),
    @json(asset('files/hero-3.mp4')),
    @json(asset('files/hero-4.mp4'))
  ];

  let currentIndex = 0;
  let isAnimating = false;

  const setVideo = (el, src) => {
    if (!el) return;
    if (el.src !== new URL(src, window.location.href).href) {
      el.src = src;
      el.load();
    }
    el.muted = true;
    el.defaultMuted = true;
    el.autoplay = true;
    el.playsInline = true;
    el.setAttribute("muted", "");
    el.setAttribute("playsinline", "");
    el.setAttribute("autoplay", "");
    el.preload = "auto";
  };

  const playVideo = (el) => {
    if (!el) return;
    const run = () => el.play().catch(() => {});
    run();
    el.addEventListener("loadeddata", run, {once:true});
    el.addEventListener("canplay", run, {once:true});
  };

  setVideo(bgVideo, videos[0]);
  setVideo(currentVideo, videos[1]);
  setVideo(nextVideo, videos[0]);

  playVideo(bgVideo);
  playVideo(currentVideo);

  miniClick?.addEventListener("click", (event) => {
    event.preventDefault();
    if (isAnimating || window.matchMedia("(pointer: coarse)").matches) return;

    isAnimating = true;
    const nextIndex = (currentIndex + 1) % videos.length;
    const previewSrc = videos[nextIndex];

    setVideo(nextVideo, previewSrc);
    playVideo(nextVideo);

    gsap.timeline({
      defaults: {ease:"power1.inOut"},
      onComplete: () => {
        currentIndex = nextIndex;

        setVideo(currentVideo, videos[(currentIndex + 1) % videos.length]);
        setVideo(bgVideo, videos[currentIndex]);
        playVideo(currentVideo);
        playVideo(bgVideo);

        gsap.set(nextVideo, {
          clearProps:"all",
          opacity:0
        });

        isAnimating = false;
      }
    })
    .set(nextVideo, {
      opacity:1,
      position:"absolute",
      left:"50%",
      top:"50%",
      width:"16rem",
      height:"16rem",
      xPercent:-50,
      yPercent:-50,
      zIndex:2
    })
    .to(nextVideo, {
      width:"100%",
      height:"100%",
      left:0,
      top:0,
      xPercent:0,
      yPercent:0,
      duration:1
    })
    .from(currentVideo, {
      transformOrigin:"center center",
      scale:0,
      duration:1.2
    }, 0);
  });

  if (heroRow) {
    gsap.set(heroRow, {
      clipPath:"polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)",
      borderRadius:"0 0 0 0"
    });

    const isMobile = window.matchMedia("(max-width: 600px)");

    gsap.to(heroRow, {
      clipPath:"polygon(14% 0%, 72% 0%, 90% 90%, 0% 100%)",
      borderRadius:"0 0 40% 10%",
      ease:"power1.inOut",
      scrollTrigger:{
        trigger:heroRow,
        start: () => isMobile.matches ? "top top" : "center center",
        end: () => isMobile.matches ? "bottom 20%" : "bottom center",
        scrub:true,
        invalidateOnRefresh:true
      }
    });
  }

  if (clip && mask) {
    gsap.timeline({
      scrollTrigger:{
        trigger:"#clip",
        start:"top top",
        scrub:0.5,
        pin:true,
        pinSpacing:true
      }
    }).to(mask, {
      width:"100vw",
      height:"100vh",
      borderRadius:0,
      ease:"none"
    });
  }

  gsap.set(".hero__label", { y:60, opacity:0, scale:.98 });
  gsap.set(".hero__btn", { y:18, opacity:0, scale:0 });

  const heroIntro = gsap.timeline({
    defaults:{ease:"power2.out"},
    scrollTrigger:{ trigger:".hero", start:"top 85%", once:true }
  });

  heroIntro
    .to(".hero__label", { y:0, opacity:1, scale:1, duration:.45, stagger:.09 }, 0)
    .to(".hero__btn", { y:0, opacity:1, scale:1, duration:.38, ease:"back.out(1.5)" }, ">-0.13");

  const znClip = document.querySelector("#znClip");
  const znMask = document.querySelector("#znMask");
  const znShade = document.querySelector("#znShade");
  const znCaptionItems = document.querySelectorAll("#znCaption > *");
  
  if (znClip && znMask) {
    const znTl = gsap.timeline({
      scrollTrigger:{
        trigger:znClip,
        start:"top top",
        end:"+=150%",
        scrub:0.5,
        pin:true,
        pinSpacing:true
      }
    });

    znTl.to(znMask, { width:"100vw", height:"100vh", borderRadius:0, ease:"none", duration:2 });

    if (znShade) znTl.fromTo(znShade, { autoAlpha:0 }, { autoAlpha:1, ease:"none", duration:1 });
    if (znCaptionItems.length) znTl.fromTo(znCaptionItems,
      { autoAlpha:0, y:40 },
      { autoAlpha:1, y:0, ease:"power2.out", duration:0.7, stagger:0.25 },
      "<"
    );
  }
})();
</script>
<script>
    /* Sinkronkan warna: eyebrow "Tentang Kami", filter galeri, dan teks hero layer ke-2
       mengikuti warna judul (.zn-about__title), termasuk saat warnanya diubah. */
    (function () {
        var title = document.querySelector('.zn-about__title');
        if (!title) return;
        var root = document.documentElement;
        function sync() {
            var c = getComputedStyle(title).color;
            if (c && root.style.getPropertyValue('--title-color') !== c) {
                root.style.setProperty('--title-color', c);
            }
        }
        sync();
        window.addEventListener('load', sync);
        document.addEventListener('DOMContentLoaded', sync);
        var mo = new MutationObserver(sync);
        mo.observe(title, { attributes: true, attributeFilter: ['style', 'class'] });
        mo.observe(document.head, { childList: true, subtree: true, characterData: true });
        if (document.documentElement) {
            mo.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme', 'class'] });
        }
        setInterval(sync, 1000);
    })();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof gsap === 'undefined') return;
        gsap.registerPlugin(typeof ScrollTrigger !== 'undefined' ? ScrollTrigger : {});

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const hasST = typeof ScrollTrigger !== 'undefined';

        if (prefersReduced || !hasST) {
            document.querySelectorAll('.reveal, .about-header .eyebrow, .about-header h1, .subtitle, .about-text p, .about-image, .about-social a, .section-heading h2, .section-heading p, .gallery-filter-btn, .gallery-card').forEach(el => {
                el.style.opacity = 1;
                el.style.transform = 'none';
            });
            return;
        }

        function splitWords(el) {
            if (!el || el.dataset.split === '1') return [];
            const text = el.textContent.trim();
            el.textContent = '';
            el.dataset.split = '1';
            const words = text.split(/\s+/).filter(Boolean);
            return words.map((word, i) => {
                const outer = document.createElement('span');
                outer.style.cssText = 'display:inline-block;overflow:hidden;vertical-align:top;padding-bottom:0.18em;margin-bottom:-0.18em;';
                const inner = document.createElement('span');
                inner.style.display = 'inline-block';
                inner.textContent = word + (i < words.length - 1 ? '\u00A0' : '');
                outer.appendChild(inner);
                el.appendChild(outer);
                return inner;
            });
        }

        const TOGGLE = 'restart reverse restart reverse';

        const heroEyebrow = document.querySelector('.about-header .eyebrow');
        const heroTitle = document.querySelector('.about-header h1');
        const heroSubtitle = document.querySelector('.about-header .subtitle');

        if (heroTitle) {
            const words = splitWords(heroTitle);
            gsap.timeline({
                scrollTrigger: {
                    trigger: '.about-header',
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: TOGGLE
                }
            })
                .fromTo(heroEyebrow, { autoAlpha: 0, y: 22 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'power3.out' })
                .fromTo(words, { yPercent: 130, rotate: 7, transformOrigin: '0% 100%' }, { yPercent: 0, rotate: 0, duration: 1, ease: 'power4.out', stagger: 0.09 }, '-=0.3')
                .fromTo(heroSubtitle, { autoAlpha: 0, y: 22 }, { autoAlpha: 1, y: 0, duration: 0.7, ease: 'power3.out' }, '-=0.55');
        }

        const aboutSection = document.querySelector('.about-section');
        if (aboutSection) {
            const paras = aboutSection.querySelectorAll('.about-text p');
            const aboutImg = aboutSection.querySelector('.about-image');
            const socialLinks = aboutSection.querySelectorAll('.about-social a');

            const aboutTl = gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: {
                    trigger: aboutSection,
                    start: 'top 78%',
                    end: 'bottom 20%',
                    toggleActions: TOGGLE
                }
            });
            aboutTl.fromTo(paras, { autoAlpha: 0, y: 45 }, { autoAlpha: 1, y: 0, duration: 0.75, stagger: 0.18 });
            if (aboutImg) aboutTl.fromTo(aboutImg, { autoAlpha: 0, scale: 1.18, clipPath: 'inset(8%)' }, { autoAlpha: 1, scale: 1, clipPath: 'inset(0%)', duration: 1.1, ease: 'power4.out' }, '-=0.5');
            aboutTl.fromTo(socialLinks, { autoAlpha: 0, y: 18, scale: 0.5 }, { autoAlpha: 1, y: 0, scale: 1, duration: 0.5, stagger: 0.08, ease: 'back.out(2.2)' }, '-=0.4');
        }

        const teamSection = document.querySelector('.team-section');
        if (teamSection) {
            const teamHeading = teamSection.querySelectorAll('.section-heading h2, .section-heading p');
            const teamSlider = teamSection.querySelector('.team-grid');

            gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: { trigger: teamSection, start: 'top 80%', end: 'bottom 20%', toggleActions: TOGGLE }
            })
                .fromTo(teamHeading, { autoAlpha: 0, y: 30 }, { autoAlpha: 1, y: 0, duration: 0.7, stagger: 0.12 })
                .fromTo(teamSlider, { autoAlpha: 0, y: 40 }, { autoAlpha: 1, y: 0, duration: 0.8 }, '-=0.35');
        }

        const gallerySection = document.querySelector('.gallery-section');
        if (gallerySection) {
            const galHeading = gallerySection.querySelectorAll('.section-heading h2, .section-heading p');
            const filterBtns = gallerySection.querySelectorAll('.gallery-filter-btn');
            const galCards = gallerySection.querySelectorAll('.gallery-card');

            gsap.timeline({
                defaults: { ease: 'power3.out' },
                scrollTrigger: { trigger: gallerySection, start: 'top 82%', end: 'bottom 20%', toggleActions: TOGGLE }
            })
                .fromTo(galHeading, { autoAlpha: 0, y: 30 }, { autoAlpha: 1, y: 0, duration: 0.7, stagger: 0.12 })
                .fromTo(filterBtns, { autoAlpha: 0, y: 16 }, { autoAlpha: 1, y: 0, duration: 0.5, stagger: 0.05 }, '-=0.35');

            let galBatch = [];
            window.__galleryReveal = function () {
                galBatch.forEach((t) => t.kill());
                galBatch = [];

                const allCards = Array.from(gallerySection.querySelectorAll('.gallery-card'));
                const visibleCards = allCards.filter((c) => !c.classList.contains('is-hidden'));

                gsap.killTweensOf(allCards);
                gsap.set(allCards, { clearProps: 'opacity,visibility,transform' });
                gsap.set(visibleCards, { autoAlpha: 0, y: 42, scale: 0.92 });

                galBatch = ScrollTrigger.batch(visibleCards, {
                    start: 'top 92%',
                    end: 'bottom 8%',
                    onEnter: (batch) => gsap.to(batch, { autoAlpha: 1, y: 0, scale: 1, duration: 0.65, stagger: 0.08, ease: 'power3.out', overwrite: true }),
                    onEnterBack: (batch) => gsap.to(batch, { autoAlpha: 1, y: 0, scale: 1, duration: 0.65, stagger: 0.08, ease: 'power3.out', overwrite: true }),
                    onLeave: (batch) => gsap.to(batch, { autoAlpha: 0, y: -35, scale: 0.94, duration: 0.4, stagger: 0.04, ease: 'power2.in', overwrite: true }),
                    onLeaveBack: (batch) => gsap.to(batch, { autoAlpha: 0, y: 35, scale: 0.94, duration: 0.4, stagger: 0.04, ease: 'power2.in', overwrite: true })
                });
                ScrollTrigger.refresh();
            };
            window.__galleryReveal();
        }

        window.addEventListener('load', () => ScrollTrigger.refresh());
        setTimeout(() => ScrollTrigger.refresh(), 800);
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

    /* ===== Galeri: filter + masonry ===== */
    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('galleryGrid');
        if (!grid) return;

        const cards = Array.from(grid.querySelectorAll('.gallery-card'));
        const buttons = Array.from(document.querySelectorAll('.gallery-filter-btn'));
        const emptyEl = document.getElementById('galleryEmpty');
        let active = { type: 'all', value: 'all' };
        let rafId = null;

        function layout() {
            const cs = getComputedStyle(grid);
            const rowH = parseFloat(cs.gridAutoRows) || 4;
            const gap = parseFloat(cs.columnGap) || 0;

            cards.forEach((card) => {
                if (card.classList.contains('is-hidden')) return;
                const w = card.offsetWidth;
                if (!w) return;
                const ratio = parseFloat(card.dataset.ratio) || 0.75;
                const span = Math.max(1, Math.round((w * ratio + gap) / rowH));
                card.style.gridRowEnd = 'span ' + span;
                card.style.height = (span * rowH - gap) + 'px';
            });
        }

        function scheduleLayout() {
            if (rafId) cancelAnimationFrame(rafId);
            rafId = requestAnimationFrame(function () {
                rafId = null;
                layout();
            });
        }

        function matches(card) {
            if (active.type === 'category') return card.dataset.category === active.value;
            if (active.type === 'orientation') return card.dataset.orientation === active.value;
            return true;
        }

        function applyFilter(animate) {
            let shown = 0;

            cards.forEach((card) => {
                const ok = matches(card);
                card.classList.toggle('is-hidden', !ok);
                card.classList.remove('is-entering');

                if (ok) {
                    if (animate && !window.__galleryReveal) {
                        void card.offsetWidth; 
                        card.style.animationDelay = Math.min(shown, 12) * 35 + 'ms';
                        card.classList.add('is-entering');
                    }
                    shown++;
                }
            });

            if (emptyEl) emptyEl.hidden = shown !== 0;
            layout();

            if (animate && window.__galleryReveal) {
                requestAnimationFrame(window.__galleryReveal);
            }
        }

        function onImageReady(card, img) {
            if (img.naturalWidth && img.naturalHeight) {
                const raw = img.naturalHeight / img.naturalWidth;
                card.dataset.ratio = Math.min(1.6, Math.max(0.55, raw)).toFixed(4);
                card.dataset.orientation = raw > 1.05 ? 'portrait' : 'landscape';
            }
            card.classList.add('is-loaded');

            if (active.type === 'orientation') applyFilter(false);
            else scheduleLayout();
        }

        cards.forEach((card) => {
            const img = card.querySelector('.gallery-item');
            if (!img) return;

            if (img.complete && img.naturalWidth) {
                onImageReady(card, img);
            } else {
                img.addEventListener('load', () => onImageReady(card, img), { once: true });
                img.addEventListener('error', () => {
                    card.classList.add('is-loaded');
                    scheduleLayout();
                }, { once: true });
            }
        });

        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                active = { type: btn.dataset.type, value: btn.dataset.filter };

                buttons.forEach((b) => {
                    const on = b === btn;
                    b.classList.toggle('is-active', on);
                    b.setAttribute('aria-pressed', on ? 'true' : 'false');
                });

                const track = btn.parentElement;
                if (track) {
                    const bR = btn.getBoundingClientRect();
                    const tR = track.getBoundingClientRect();
                    track.scrollTo({
                        left: track.scrollLeft + (bR.left - tR.left) - (track.clientWidth - btn.offsetWidth) / 2,
                        behavior: 'smooth'
                    });
                }
                applyFilter(true);
            });
        });

        window.addEventListener('resize', scheduleLayout);
        window.addEventListener('load', scheduleLayout);

        applyFilter(false);
    });

    /* ===== LIGHTBOX MODAL JS ===== */
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("zoomedImage");
        const modalInfo = document.getElementById("modalInfo");
        const modalTitle = document.getElementById("modalTitle");
        const modalCat = document.getElementById("modalCategory");
        const closeBtn = document.querySelector(".close-modal");
        const prevBtn = document.getElementById("modalPrev");
        const nextBtn = document.getElementById("modalNext");
        
        function getImages() {
            return Array.from(document.querySelectorAll(".gallery-card"))
                .filter((card) => !card.classList.contains("is-hidden"))
                .map((card) => card.querySelector(".gallery-item"))
                .filter(Boolean);
        }

        let images = [];
        let currentIndex = 0;

        function openModal(index) {
            currentIndex = index;
            updateModalContent();
            modal.classList.add("show");
        }

        function updateModalContent() {
            const img = images[currentIndex];
            if (!img) return;
            modalImg.src = img.currentSrc || img.src;
            modalImg.alt = img.alt || "";

            const title = (img.getAttribute("data-caption") || "").trim();
            const cat = (img.getAttribute("data-category-label") || "").trim();
            modalTitle.textContent = title;
            modalTitle.hidden = !title;
            modalCat.textContent = cat;
            modalCat.hidden = !cat;
            modalInfo.hidden = !title && !cat;

            const single = images.length < 2;
            if (prevBtn) prevBtn.hidden = single;
            if (nextBtn) nextBtn.hidden = single;
        }

        function showPrev(e) {
            if (e) e.stopPropagation();
            if (!images.length) return;
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateModalContent();
        }

        function showNext(e) {
            if (e) e.stopPropagation();
            if (!images.length) return;
            currentIndex = (currentIndex + 1) % images.length;
            updateModalContent();
        }

        const galleryGrid = document.getElementById("galleryGrid");
        if (galleryGrid) {
            const openFromCard = (card) => {
                images = getImages();
                const idx = images.indexOf(card.querySelector(".gallery-item"));
                if (idx > -1) openModal(idx);
            };

            galleryGrid.addEventListener("click", (e) => {
                const card = e.target.closest(".gallery-card");
                if (card) openFromCard(card);
            });

            galleryGrid.addEventListener("keydown", (e) => {
                if (e.key !== "Enter" && e.key !== " ") return;
                const card = e.target.closest(".gallery-card");
                if (!card) return;
                e.preventDefault();
                openFromCard(card);
            });
        }

        if (prevBtn) prevBtn.addEventListener("click", showPrev);
        if (nextBtn) nextBtn.addEventListener("click", showNext);
        if (closeBtn) closeBtn.addEventListener("click", () => modal.classList.remove("show"));

        if (modal) {
            modal.addEventListener("click", function(e) {
                if (e.target === modal || e.target.classList.contains('modal-content-wrapper')) {
                    modal.classList.remove("show");
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (!modal.classList.contains('show')) return;
            
            if (e.key === 'Escape') modal.classList.remove("show");
            if (e.key === 'ArrowLeft') showPrev();
            if (e.key === 'ArrowRight') showNext();
        });
    });
</script>

<script>
    (function () {
        if (!('paintWorklet' in CSS)) return;

        CSS.paintWorklet
            .addModule('https://unpkg.com/css-houdini-ringparticles/dist/ringparticles.js')
            .catch(function () {});
    })();
</script>
@endpush
@endsection