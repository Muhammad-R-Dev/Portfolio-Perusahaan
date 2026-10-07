@extends('admin.layouts.app')

@section('title', 'Admin Astabrata Teknologi')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* ========== DASBOR RINGKASAN ========== */
    #content main {
        font-family: var(--poppins), sans-serif;
    }
    #content main .head-title .btn-download {
        height: 36px;
        padding: 0 16px;
        border-radius: 36px;
        background: #3b82f6;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        grid-gap: 10px;
        font-weight: 500;
        font-family: var(--poppins), sans-serif;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        text-decoration: none;
    }
    #content main .head-title .btn-download:hover { background: #2563eb; transform: translateY(-2px); color: #fff; }

    /* ========== INDIKATOR DEADLINE ========== */
    .status-lewat { border-left: 4px solid #ef4444 !important; padding-left: 8px !important; }
    .status-aktif { border-left: 4px solid #22c55e !important; padding-left: 8px !important; }

    .badge-lewat {
        display: inline-block; margin-top: 4px; font-size: 11px;
        background: #fee2e2; color: #ef4444; padding: 2px 8px; border-radius: 12px; font-weight: 600;
    }
    .badge-aktif {
        display: inline-block; margin-top: 4px; font-size: 11px;
        background: #dcfce7; color: #22c55e; padding: 2px 8px; border-radius: 12px; font-weight: 600;
    }

    /* ========== RINGKASAN (kartu folder: Proyek, Blog, Layanan, Galeri, Tim) ==========
       Ikon folder dibuat 1:1 mengikuti kode asli (folder.html) — semua ukuran,
       radius, shadow, dan animasi hover persis sama; hanya dibungkus & diskalakan
       dengan transform:scale() supaya proporsinya tidak berubah / tidak rusak. */
    #content main .ringkasan-folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        grid-gap: 18px;
        margin-top: 16px;
    }
    #content main .ringkasan-folder-grid > li { list-style: none; }

    #content main .folder-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        text-decoration: none;
        background: #fff;
        border-radius: 16px;
        padding: 18px 10px 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    #content main .folder-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.06);
    }

    /* Panggung folder: ukuran tampil di kartu (hasil folder asli x skala 0.42).
       overflow dibuat visible + jarak ekstra di atas supaya saat folder
       terangkat ketika di-hover, bagian atasnya tidak terpotong batas kartu. */
    #content main .folder-outer {
        width: 143px;
        height: 114px;
        margin: 10px auto 14px;
        overflow: visible;
    }
    /* Panggung asli: identik dengan folder.html (340 x 270), lalu diskalakan */
    #content main .folder-stage {
        position: relative;
        width: 340px;
        height: 270px;
        transform: scale(0.42);
        transform-origin: top left;
    }

    /* ===== Kode folder persis dari folder.html, hanya top/left disesuaikan
       agar pas di dalam .folder-stage (bukan di tengah halaman).
       Tanpa perspective/rotateX supaya bentuknya sejajar/lurus, tidak melengkung. ===== */
    #content main .folder {
        width: 340px;
        height: 140px;
        background: var(--folder-front, tomato);
        position: absolute;
        top: 20px;
        left: 0;
        border-top-right-radius: 5px;
        cursor: pointer;
        transition: all 400ms ease;
    }
    #content main .folder::before {
        width: 80px;
        height: 20px;
        content: '';
        background: var(--folder-front, tomato);
        position: absolute;
        top: -20px;
        left: 0;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    #content main .folder::after {
        width: 340px;
        height: 210px;
        position: absolute;
        content: '';
        background: var(--folder-back, #ff4523);
        top: 40px;
        left: 0;
        box-shadow: 0 0 20px 2px rgba(0, 0, 0, 0.3);
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        transition: all 400ms ease;
    }
    #content main .folder-inside {
        width: 320px;
        height: 200px;
        position: absolute;
        background: #fff;
        top: 20px;
        left: 10px;
        box-shadow: 0 0 5px 5px rgba(0, 0, 0, 0.05);
        transform: rotate(-1deg);
        border: 1px solid #ddd;
        transition: all 200ms ease;
    }
    #content main .folder-inside::before {
        content: '';
        background: repeating-linear-gradient(0deg, #fff, #fff 10px, #333 10px, #333 20px);
        position: absolute;
        top: -37px;
        left: 65px;
        width: 200px;
        height: 290px;
        color: #343434;
        font-size: 60px;
        line-height: 30px;
        transform: rotate(-90deg);
        opacity: 0.15;
    }
    #content main .folder-card:hover .folder { transform: translateY(-6px); }
    #content main .folder-card:hover .folder::after { transform: translateY(-3px); }
    #content main .folder-card:hover .folder-inside { transform: rotate(-7deg) translateY(-15%); }

    /* Varian warna folder per kategori (default tomato = warna asli folder.html) */
    .folder-tomato { --folder-front: tomato; --folder-back: #ff4523; }
    .folder-blue   { --folder-front: #60a5fa; --folder-back: #2563eb; }
    .folder-purple { --folder-front: #c4b5fd; --folder-back: #7c3aed; }
    .folder-green  { --folder-front: #6ee7b7; --folder-back: #059669; }
    .folder-pink   { --folder-front: #f9a8d4; --folder-back: #db2777; }

    #content main .folder-card .folder-label h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
        margin: 0;
    }
    #content main .folder-card .folder-label p {
        color: #64748b;
        font-size: 11px;
        font-weight: 500;
        margin-top: 2px;
        white-space: nowrap;
    }

    #content main .section-heading { margin-top: 32px; margin-bottom: 4px; font-size: 16px; font-weight: 600; color: #1e293b; }
    #content main .section-heading:first-of-type { margin-top: 8px; }

    @media screen and (max-width: 768px) {
        #sidebar { width: 200px; }
        #content { width: calc(100% - 60px); left: 200px; }
        #content main .ringkasan-folder-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); grid-gap: 12px; }
    }

    /* ============================================================
       DARK MODE / THEME COMPATIBILITY
       Warna disamakan persis dengan palet halaman KELOLA BLOG
       (kelola-blog.blade.php), yang juga dipakai di Kelola Proyek:
         halaman #1b2538  <  kartu #25324a  <  input/hover #34456a  (dark)
         halaman #e9eef5  <  kartu putih                             (light)
       ============================================================ */
    body.dark #content,
    body.dark #content main {
        --light: #25324a;          /* kartu */
        --grey: #34456a;           /* input, hover, border */
        --dark: #eef2f9;           /* teks utama */
        --dark-grey: #a9b8d2;      /* teks sekunder */
        --light-blue: #2f4a7a;     /* baris/ikon terpilih */
        --light-orange: #4d3b33;
        --blue: #4f8ef7;
        --red: #ef5a5a;
    }
    body.dark #content {
        background: #1b2538 !important;
    }
    body:not(.dark) #content,
    body:not(.dark) #content main {
        --light: #ffffff;          /* kartu */
        --grey: #e2e8f0;           /* input, border */
        --dark: #1e293b;           /* teks utama */
        --dark-grey: #64748b;      /* teks sekunder */
        --light-blue: #dbeafe;     /* baris/ikon terpilih */
        --light-orange: #fee2e2;
    }
    body:not(.dark) #content {
        background: #e9eef5 !important;
    }

    #content main .folder-card {
        background: var(--light) !important;
        color: var(--dark) !important;
    }

    #content main .section-heading,
    #content main .folder-card .folder-label h3 {
        color: var(--dark) !important;
    }

    #content main .folder-card .folder-label p {
        color: var(--dark-grey) !important;
    }

</style>
@endpush

@section('content')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li><a class="active" href="#">Home</a></li>
            </ul>
        </div>
    </div>

    {{-- ===================== RINGKASAN (kartu kecil) ===================== --}}
    <div class="section-heading">Ringkasan</div>
    <ul class="ringkasan-folder-grid">
        <li>
            <div class="folder-card folder-tomato">
                <div class="folder-outer">
                    <div class="folder-stage">
                        <div class="folder">
                            <div class="folder-inside"></div>
                        </div>
                    </div>
                </div>
                <div class="folder-label">
                    <h3 id="statProjectAktif">0</h3>
                    <p>Project Aktif</p>
                </div>
            </div>
        </li>
        <li>
            <a href="{{ route('admin.kelola-blog.index') }}" class="folder-card folder-purple">
                <div class="folder-outer">
                    <div class="folder-stage">
                        <div class="folder">
                            <div class="folder-inside"></div>
                        </div>
                    </div>
                </div>
                <div class="folder-label">
                    <h3>{{ $totalBlog }}</h3>
                    <p>Total Blog</p>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-layanan.index') }}" class="folder-card folder-blue">
                <div class="folder-outer">
                    <div class="folder-stage">
                        <div class="folder">
                            <div class="folder-inside"></div>
                        </div>
                    </div>
                </div>
                <div class="folder-label">
                    <h3>{{ $totalLayanan }}</h3>
                    <p>Total Layanan</p>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-galeri') }}" class="folder-card folder-pink">
                <div class="folder-outer">
                    <div class="folder-stage">
                        <div class="folder">
                            <div class="folder-inside"></div>
                        </div>
                    </div>
                </div>
                <div class="folder-label">
                    <h3>{{ $totalGaleri }}</h3>
                    <p>Total Foto Galeri</p>
                </div>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-tim') }}" class="folder-card folder-green">
                <div class="folder-outer">
                    <div class="folder-stage">
                        <div class="folder">
                            <div class="folder-inside"></div>
                        </div>
                    </div>
                </div>
                <div class="folder-label">
                    <h3>{{ $totalTim }}</h3>
                    <p>Anggota Tim</p>
                </div>
            </a>
        </li>
    </ul>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        dashFetchClients();
    });

    /* ============================================================
       RINGKASAN: ambil data client & tampilkan statistik folder
       ============================================================ */
    async function dashFetchClients() {
        try {
            const res = await fetch('/admin/clients');
            const clients = await res.json();
            dashUpdateStats(clients);
        } catch (err) {
            console.error(err);
        }
    }

    function dashUpdateStats(clients) {
        let projectAktif = 0;

        const hariIni = new Date();
        hariIni.setHours(0, 0, 0, 0);

        clients.forEach(client => {
            if (client.deadline) {
                const deadlineDate = new Date(client.deadline + 'T00:00:00');
                deadlineDate.setHours(0, 0, 0, 0);
                if (deadlineDate >= hariIni) {
                    projectAktif++;
                }
            } else {
                projectAktif++;
            }
        });

        const statEl = document.getElementById('statProjectAktif');
        if (statEl) statEl.textContent = projectAktif;
    }
</script>
@endpush