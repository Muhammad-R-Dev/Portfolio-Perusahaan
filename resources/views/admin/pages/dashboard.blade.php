@extends('admin.layouts.app')

@section('title', 'AdminHub Admin Dashboard v2.1')
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

    /* ========== RINGKASAN (kartu kecil: Proyek, Blog, Layanan, Galeri, Tim) ========== */
    #content main .box-info-content { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); grid-gap: 16px; margin-top: 16px; }
    #content main .box-info-content .stat-card {
        padding: 14px 16px; background: #fff; border-radius: 14px; display: flex; align-items: center;
        grid-gap: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.02); text-decoration: none; transition: transform 0.2s, box-shadow 0.2s;
    }
    #content main .box-info-content a.stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(0,0,0,0.06); }
    #content main .box-info-content .stat-card .bx { width: 42px; height: 42px; border-radius: 10px; font-size: 19px; display: flex; justify-content: center; align-items: center; flex-shrink: 0; }
    #content main .box-info-content .stat-card .text h3 { font-size: 18px; font-weight: 700; color: #1e293b; line-height: 1.2; }
    #content main .box-info-content .stat-card .text p { color: #64748b; font-size: 11px; font-weight: 500; margin-top: 1px; white-space: nowrap; }
    #content main .box-info-content .stat-card .text span.sub-stat { display: block; color: #94a3b8; font-size: 10px; margin-top: 1px; }

    /* Varian warna ikon kartu ringkasan */
    .stat-icon-sky { background: #e0f2fe; color: #0284c7; }
    .stat-icon-yellow { background: #fef08a; color: #ca8a04; }
    .stat-icon-red { background: #fee2e2; color: #ef4444; }
    .stat-icon-purple { background: #ede9fe; color: #7c3aed; }
    .stat-icon-blue { background: #dbeafe; color: #2563eb; }
    .stat-icon-pink { background: #fce7f3; color: #db2777; }
    .stat-icon-green { background: #d1fae5; color: #059669; }

    #content main .section-heading { margin-top: 32px; margin-bottom: 4px; font-size: 16px; font-weight: 600; color: #1e293b; }
    #content main .section-heading:first-of-type { margin-top: 8px; }

    /* Grid 6 kolom:
       - Baris 1 : Layanan | Blog | Tim        (masing-masing 2 kolom)
       - Baris 2 : Proyek Terbaru | Galeri     (masing-masing 3 kolom, lebih besar) */
    #content main .content-preview-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); grid-gap: 24px; margin-top: 16px; width: 100%; align-items: stretch; }
    #content main .content-preview-grid > .preview-card { min-width: 0; border-radius: 18px; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; flex-direction: column; }

    /* 3 kartu atas (Layanan, Blog, Tim) - diperbesar */
    #content main .content-preview-grid > .preview-card--top { grid-column: span 2; padding: 24px 26px; }
    #content main .content-preview-grid > .preview-card--top .head h3 { font-size: 16px; }
    #content main .content-preview-grid > .preview-card--top .preview-card-body { max-height: 340px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-list { grid-gap: 16px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-item { grid-gap: 14px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-item .thumb,
    #content main .content-preview-grid > .preview-card--top .mini-preview-item .avatar { width: 52px; height: 52px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-item .avatar { font-size: 16px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-item .info p.judul { font-size: 14px; }
    #content main .content-preview-grid > .preview-card--top .mini-preview-item .info .sub { font-size: 12.5px; }

    /* 2 kartu bawah (Proyek & Galeri) - paling besar */
    #content main .content-preview-grid > .preview-card--wide { grid-column: span 3; padding: 28px 30px; }
    #content main .content-preview-grid > .preview-card--wide .head { margin-bottom: 18px; }
    #content main .content-preview-grid > .preview-card--wide .head h3 { font-size: 18px; }
    #content main .content-preview-grid > .preview-card--wide .head .btn-lihat-semua { font-size: 13px; }
    #content main .content-preview-grid > .preview-card--wide .preview-card-body { max-height: 460px; flex: 1; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-list { grid-gap: 18px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item { grid-gap: 16px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .thumb,
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .avatar { width: 60px; height: 60px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .avatar { font-size: 18px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .info p.judul { font-size: 15px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .info .sub { font-size: 13px; }
    #content main .content-preview-grid > .preview-card--wide .mini-preview-item .info .meta { margin-top: 6px; }
    #content main .content-preview-grid .head { display: flex; align-items: center; grid-gap: 12px; margin-bottom: 14px; flex-shrink: 0; }
    #content main .content-preview-grid .head h3 { margin-right: auto; font-size: 14px; font-weight: 600; color: #1e293b; }
    #content main .content-preview-grid .head .btn-lihat-semua {
        font-size: 12px; font-weight: 600; color: #3b82f6; text-decoration: none;
        display: flex; align-items: center; grid-gap: 4px; white-space: nowrap;
    }
    #content main .content-preview-grid .head .btn-lihat-semua:hover { color: #2563eb; text-decoration: underline; }

    /* Badan kartu preview: tinggi tetap + scroll vertikal jika datanya banyak */
    .preview-card-body { max-height: 260px; overflow-y: auto; padding-right: 4px; }
    .preview-card-body::-webkit-scrollbar { width: 5px; }
    .preview-card-body::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .preview-card-body::-webkit-scrollbar-track { background: transparent; }

    /* Daftar ringkas (dipakai Blog, Layanan, Tim, Proyek) */
    .mini-preview-list { display: flex; flex-direction: column; grid-gap: 12px; }
    .mini-preview-item { display: flex; align-items: center; grid-gap: 12px; }
    .mini-preview-item .thumb { width: 44px; height: 44px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: #f1f5f9; }
    .mini-preview-item .avatar {
        width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center;
        justify-content: center; font-size: 14px; font-weight: 700; color: #fff; background: #94a3b8; overflow: hidden;
    }
    .mini-preview-item .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .mini-preview-item .info { min-width: 0; flex: 1; }
    .mini-preview-item .info p.judul { font-size: 13px; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .mini-preview-item .info .sub { font-size: 12px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 1px; }
    .mini-preview-item .info .meta { display: flex; align-items: center; grid-gap: 6px; margin-top: 4px; flex-wrap: wrap; }
    .mini-preview-item .info .tag { font-size: 10px; font-weight: 600; padding: 2px 8px; border-radius: 10px; white-space: nowrap; }
    .mini-preview-item .info .tag-kategori { background: #ede9fe; color: #7c3aed; }
    .mini-preview-item .info .tag-divisi { background: #d1fae5; color: #059669; }
    .mini-preview-item .info .tanggal { font-size: 11px; color: #94a3b8; }
    .preview-empty { text-align: center; color: #94a3b8; font-size: 13px; padding: 20px 0; }

    /* Galeri terbaru: grid thumbnail */
    .galeri-preview-grid { display: grid; grid-template-columns: repeat(2, 1fr); grid-gap: 10px; }
    /* Kartu galeri lebar: thumbnail dibuat lebih besar, jumlah kolom menyesuaikan lebar kartu */
    .preview-card--wide .galeri-preview-grid { grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); grid-gap: 14px; }
    .preview-card--wide .galeri-preview-item { border-radius: 12px; }
    .preview-card--wide .galeri-preview-item .caption { padding: 8px 12px; font-size: 12.5px; }
    .galeri-preview-item { position: relative; border-radius: 10px; overflow: hidden; aspect-ratio: 4/3; background: #f1f5f9; }
    .galeri-preview-item img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .galeri-preview-item .caption {
        position: absolute; left: 0; right: 0; bottom: 0; padding: 5px 8px;
        background: linear-gradient(180deg, rgba(15,23,42,0) 0%, rgba(15,23,42,0.75) 100%);
        color: #fff; font-size: 11px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    /* Layar sedang: Layanan | Blog di atas, Tim selebar penuh, lalu Proyek | Galeri */
    @media screen and (max-width: 1200px) {
        #content main .content-preview-grid > .preview-card--top { grid-column: span 3; }
        #content main .content-preview-grid > .preview-card--top:nth-child(3) { grid-column: span 6; }
    }
    /* Layar kecil: semua kartu ditumpuk satu kolom */
    @media screen and (max-width: 768px) {
        #content main .content-preview-grid > .preview-card--top,
        #content main .content-preview-grid > .preview-card--top:nth-child(3),
        #content main .content-preview-grid > .preview-card--wide { grid-column: span 6; }
    }

    @media screen and (max-width: 768px) {
        #sidebar { width: 200px; }
        #content { width: calc(100% - 60px); left: 200px; }
        .galeri-preview-grid { grid-template-columns: repeat(2, 1fr); }
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
    <ul class="box-info-content">
        <li>
            <div class="stat-card">
                <i class='bx bxs-briefcase stat-icon-yellow'></i>
                <span class="text">
                    <h3 id="statProjectAktif">0</h3>
                    <p>Project Aktif</p>
                </span>
            </div>
        </li>
        <li>
            <a href="{{ route('admin.kelola-blog.index') }}" class="stat-card">
                <i class='bx bxs-news stat-icon-purple'></i>
                <span class="text">
                    <h3>{{ $totalBlog }}</h3>
                    <p>Total Blog</p>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-layanan.index') }}" class="stat-card">
                <i class='bx bxs-briefcase-alt-2 stat-icon-blue'></i>
                <span class="text">
                    <h3>{{ $totalLayanan }}</h3>
                    <p>Total Layanan</p>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-galeri') }}" class="stat-card">
                <i class='bx bxs-image stat-icon-pink'></i>
                <span class="text">
                    <h3>{{ $totalGaleri }}</h3>
                    <p>Total Foto Galeri</p>
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.kelola-tim') }}" class="stat-card">
                <i class='bx bxs-group stat-icon-green'></i>
                <span class="text">
                    <h3>{{ $totalTim }}</h3>
                    <p>Anggota Tim</p>
                </span>
            </a>
        </li>
    </ul>

    <div class="section-heading">Konten Terbaru</div>
    <div class="content-preview-grid">
        {{-- ---------- LAYANAN ---------- --}}
        <div class="preview-card preview-card--top">
            <div class="head">
                <h3>Layanan</h3>
                <a href="{{ route('admin.kelola-layanan.index') }}" class="btn-lihat-semua">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="preview-card-body">
                <div class="mini-preview-list">
                    @forelse($recentLayanan as $layanan)
                        <div class="mini-preview-item">
                            <img class="thumb" src="{{ $layanan->image ? asset('images/services/'.$layanan->image) : 'https://placehold.co/100x100/png' }}" alt="{{ $layanan->title }}">
                            <div class="info">
                                <p class="judul">{{ $layanan->title }}</p>
                                <div class="sub">{{ \Illuminate\Support\Str::limit($layanan->description, 40) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="preview-empty">Belum ada data layanan.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ---------- BLOG TERBARU ---------- --}}
        <div class="preview-card preview-card--top">
            <div class="head">
                <h3>Blog Terbaru</h3>
                <a href="{{ route('admin.kelola-blog.index') }}" class="btn-lihat-semua">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="preview-card-body">
                <div class="mini-preview-list">
                    @forelse($recentBlogs as $blog)
                        <div class="mini-preview-item">
                            <img class="thumb" src="{{ $blog->gambar ? asset('storage/'.$blog->gambar) : 'https://placehold.co/100x100/png' }}" alt="{{ $blog->judul }}">
                            <div class="info">
                                <p class="judul">{{ $blog->judul }}</p>
                                <div class="meta">
                                    <span class="tag tag-kategori">{{ $blog->kategori }}</span>
                                    <span class="tanggal">{{ $blog->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="preview-empty">Belum ada artikel blog.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ---------- TIM ---------- --}}
        <div class="preview-card preview-card--top">
            <div class="head">
                <h3>Tim</h3>
                <a href="{{ route('admin.kelola-tim') }}" class="btn-lihat-semua">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="preview-card-body">
                <div class="mini-preview-list">
                    @forelse($recentTeam as $team)
                        <div class="mini-preview-item">
                            <span class="avatar">
                                @if($team->foto_url)
                                    <img src="{{ $team->foto_url }}" alt="{{ $team->nama }}">
                                @else
                                    {{ strtoupper(substr($team->nama, 0, 1)) }}
                                @endif
                            </span>
                            <div class="info">
                                <p class="judul">{{ $team->nama }}</p>
                                <div class="meta">
                                    <span class="sub">{{ $team->jabatan }}</span>
                                    @if($team->divisi)
                                        <span class="tag tag-divisi">{{ $team->divisi }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="preview-empty">Belum ada anggota tim.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ---------- PROYEK TERBARU (diisi JS dari data client) ---------- --}}
        <div class="preview-card preview-card--wide">
            <div class="head">
                <h3>Proyek Terbaru</h3>
                <a href="{{ route('admin.kelola-proyek') }}" class="btn-lihat-semua">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="preview-card-body">
                <div class="mini-preview-list" id="dashProyekPreviewList">
                    {{-- Diisi JavaScript --}}
                </div>
            </div>
        </div>

        {{-- ---------- GALERI TERBARU ---------- --}}
        <div class="preview-card preview-card--wide">
            <div class="head">
                <h3>Galeri Terbaru</h3>
                <a href="{{ route('admin.kelola-galeri') }}" class="btn-lihat-semua">
                    Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="preview-card-body">
                <div class="galeri-preview-grid">
                    @forelse($recentGaleri as $galeri)
                        <div class="galeri-preview-item">
                            <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->judul }}">
                            <span class="caption">{{ $galeri->judul }}</span>
                        </div>
                    @empty
                        <div class="preview-empty">Belum ada foto galeri.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        dashFetchClients();
    });

    /* ============================================================
       RINGKASAN: ambil data client & tampilkan statistik + terbaru
       ============================================================ */
    async function dashFetchClients() {
        try {
            const res = await fetch('/admin/clients');
            const clients = await res.json();
            dashUpdateStats(clients);
            dashRenderRecent(clients);
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

    function dashFormatDate(dateStr) {
        if (!dateStr) return '-';
        const d = new Date(dateStr + 'T00:00:00');
        if (isNaN(d)) return dateStr;
        return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function dashEscape(str) {
        const div = document.createElement('div');
        div.textContent = str == null ? '' : str;
        return div.innerHTML;
    }

    function dashRenderRecent(clients) {
        const list = document.getElementById('dashProyekPreviewList');
        if (!list) return;
        list.innerHTML = '';

        const hariIni = new Date();
        hariIni.setHours(0, 0, 0, 0);

        // Urutkan berdasarkan id terbaru & ambil 5 teratas
        const recent = [...clients]
            .sort((a, b) => b.id - a.id)
            .slice(0, 5);

        if (recent.length === 0) {
            list.innerHTML = '<div class="preview-empty">Belum ada data proyek.</div>';
            return;
        }

        recent.forEach((client) => {
            let isLewat = false;
            if (client.deadline) {
                const dDate = new Date(client.deadline + 'T00:00:00');
                dDate.setHours(0, 0, 0, 0);
                if (dDate < hariIni) isLewat = true;
            }

            const badgeHtml = isLewat
                ? `<span class="badge-lewat">Lewat Deadline</span>`
                : `<span class="badge-aktif">Berjalan</span>`;

            const initial = client.nama ? client.nama.trim().charAt(0).toUpperCase() : '?';

            const item = document.createElement('div');
            item.className = 'mini-preview-item';
            item.innerHTML = `
                <span class="avatar">${initial}</span>
                <div class="info">
                    <p class="judul">${dashEscape(client.project)}</p>
                    <div class="meta">
                        <span class="sub">${dashEscape(client.nama)}</span>
                        ${badgeHtml}
                    </div>
                </div>
            `;
            list.appendChild(item);
        });
    }
</script>
@endpush