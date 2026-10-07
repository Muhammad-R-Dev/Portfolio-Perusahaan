<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PageSetting extends Model
{
    public const COLOR_FIELDS = [
        'light_bg', 'light_title', 'light_desc', 'light_canvas',
        'dark_bg', 'dark_title', 'dark_desc', 'dark_canvas',
    ];

    protected $fillable = [
        'page', 'title', 'description', 'caption', 'bg_image',
        'light_bg', 'light_title', 'light_desc', 'light_canvas',
        'dark_bg', 'dark_title', 'dark_desc', 'dark_canvas',
    ];

    /**
     * Teks bawaan + warna saran untuk tiap halaman.
     * - title       : judul halaman
     * - description : moto / visi & misi (tiap baris jadi satu paragraf)
     * - caption     : deskripsi (caption di bawah gambar, khusus About)
     */
    public static function defaults(): array
    {
        return [
            'beranda' => [
                'label'       => 'Beranda',
                'hint'        => 'Atur bagian "Tentang Kami" (Welcome) dan bagian FAQ. Warna di bawah berlaku untuk seluruh beranda.',
                'title'       => 'Pertanyaan Umum',
                'description' => 'Beberapa hal yang paling sering ditanyakan calon klien sebelum memulai proyek bersama kami.',
                'colors'      => [
                    'light_bg' => '#FFFFFF', 'light_title' => '#111111', 'light_desc' => '#5F5F5F',
                    'dark_bg'  => '#0A0F1A', 'dark_title'  => '#EEF6F3', 'dark_desc'  => '#A9B3B8',
                ],
            ],
            'layanan' => [
                'label'       => 'Layanan',
                'hint'        => 'Judul & deskripsi mengubah bagian "Pilih Layanan Yang Anda Butuhkan" di atas daftar kartu layanan. Warna berlaku untuk bagian tersebut. Daftar layanan (kartu) diatur dari menu Kelola Layanan.',
                'title'       => 'Pilih Layanan Yang Anda Butuhkan',
                'description' => 'Setiap layanan dapat disesuaikan dengan kebutuhan spesifik bisnis Anda. Klik detail untuk informasi lengkap.',
                'colors'      => [
                    'light_bg' => '#094356', 'light_title' => '#0F172A', 'light_desc' => '#64748B', 'light_canvas' => '#ECEEF1',
                    'dark_bg'  => '#0F172A', 'dark_title'  => '#F8FAFC', 'dark_desc'  => '#94A3B8', 'dark_canvas'  => '#0B1120',
                ],
            ],
            'blog' => [
                'label'       => 'Blog',
                'hint'        => 'Judul & deskripsi mengubah header halaman Blog. Warna background berlaku untuk area artikel dan bar pencarian.',
                'title'       => 'Wawasan Kami',
                'description' => 'Kumpulan artikel, tips, dan cerita seputar teknologi yang kami bagikan untuk Anda.',
                'colors'      => [
                    'light_bg' => '#FAFAFA', 'light_title' => '#FFFFFF', 'light_desc' => '#D9E2E5',
                    'dark_bg'  => '#0A0F1A', 'dark_title'  => '#FFFFFF', 'dark_desc'  => '#D9E2E5',
                ],
            ],
            'about' => [
                'label'       => 'About',
                'hint'        => 'Judul dan moto mengubah bagian "Tentang Kami". Deskripsi tampil sebagai caption di bawah gambar. Warna berlaku untuk seluruh halaman setelah hero.',
                'title'       => 'PT Astabrata Teknologi',
                'description' => 'Membangun inovasi masa depan melalui solusi teknologi',
                'caption'     => 'PT Astabrata Teknologi adalah perusahaan penyedia layanan IT terkemuka yang berdedikasi',
                'colors'      => [
                    'light_bg' => '#FFFFFF', 'light_title' => '#094356', 'light_desc' => '#094356',
                    'dark_bg'  => '#0A0F1A', 'dark_title'  => '#8FD0BF', 'dark_desc'  => '#8FD0BF',
                ],
            ],
            'contact' => [
                'label'       => 'Contact',
                'hint'        => 'Judul & deskripsi mengubah header "Hubungi Kami". Warna berlaku untuk seluruh halaman kontak.',
                'title'       => 'Hubungi Kami',
                'description' => 'Ceritakan kebutuhan Anda, tim kami akan membalas langsung lewat WhatsApp.',
                'colors'      => [
                    'light_bg' => '#F4F4F5', 'light_title' => '#111418', 'light_desc' => '#667085',
                    'dark_bg'  => '#0F1626', 'dark_title'  => '#E8F1EE', 'dark_desc'  => '#9AA8A4',
                ],
            ],
            'login' => [
                'label'       => 'Login',
                'hint'        => 'Atur gambar background yang akan tampil di halaman login.',
                'title'       => '',
                'description' => '',
                'colors'      => [
                    'light_bg' => '#FFFFFF', 'light_title' => '#000000', 'light_desc' => '#000000',
                    'dark_bg'  => '#000000', 'dark_title'  => '#FFFFFF', 'dark_desc'  => '#FFFFFF',
                ],
            ],
        ];
    }

    /**
     * Elemen yang dikenai warna di tiap halaman (selector CSS).
     */
    protected static function targets(): array
    {
        return [
            'beranda' => [
                'bg'    => ['.hero-frame', '.tentang-kami-cloneable', '.project'],
                'title' => ['.tab-layout-heading', '.tab-content__heading', '.faq-text h3', '.faq-question'],
                'desc'  => ['.content-p', '.faq-desc', '.faq-answer p'],
            ],
            'layanan' => [
                // Bagian "Pilih Layanan Yang Anda Butuhkan" di atas grid kartu layanan.
                'canvas' => ['.ly-services'],
                'title'  => ['.ly-section-head h2'],
                'desc'   => ['.ly-section-head p'],
            ],
            'blog' => [
                'bg'    => ['.page-wrapper', '.content-area'],
                'title' => ['.page-header-text h1', '.page-header-text h1 em', '.project-card .card-text-content h3'],
                'desc'  => ['.page-header-text .subtitle', '.project-card .card-text-content p'],
                // Bar pencarian punya lekukan di sudutnya; warnanya harus ikut berubah (khusus desktop).
                'extra' => static function (string $p, array $c): string {
                    if (! $c['bg']) {
                        return '';
                    }
                    $b = $c['bg'];

                    return '@media (min-width:769px){'
                        . $p . ' .page-header-inner{background-color:' . $b . ' !important}'
                        . $p . ' .page-header-inner::before{background-image:radial-gradient(circle at top left,transparent 70%,' . $b . ' 70%) !important}'
                        . $p . ' .page-header-inner::after{background-image:radial-gradient(circle at top right,transparent 70%,' . $b . ' 70%) !important}'
                        . '}';
                },
            ],
            'about' => [
                'bg'    => ['.page-wrapper', '.zn-about', '.gallery-section', '.team-section', '.particle-background #particle-canvas > div'],
                'title' => ['.zn-about__title', '.section-heading h2'],
                'desc'  => ['.zn-about__subtext', '.zn-about__subtext p', '.section-heading p', '.gallery-section .section-heading p'],
            ],
            'contact' => [
                'bg'    => ['.contact-page', '.contact-hero', '.contact-card', '.hero-particles #particle-canvas > div'],
                'title' => ['.contact-hero h1', '.contact-page h2'],
                'desc'  => ['.contact-hero .hero-sub', '.contact-page .lead'],
                // Teks lain di halaman kontak memakai variabel --ink / --muted.
                'extra' => static function (string $p, array $c): string {
                    $v = '';
                    if ($c['title']) {
                        $v .= '--ink:' . $c['title'] . ';';
                    }
                    if ($c['desc']) {
                        $v .= '--muted:' . $c['desc'] . ';';
                    }

                    return $v === '' ? '' : $p . ' .contact-page{' . $v . '}';
                },
            ],
        ];
    }

    public static function keys(): array
    {
        return array_keys(static::defaults());
    }

    /**
     * Ambil pengaturan satu halaman. Aman dipakai walau tabel belum dimigrasi.
     */
    public static function for(string $page): self
    {
        static $cache = [];

        if (isset($cache[$page])) {
            return $cache[$page];
        }

        try {
            $row = static::where('page', $page)->first();
        } catch (\Throwable $e) {
            $row = null;
        }

        return $cache[$page] = $row ?: new static(['page' => $page]);
    }

    /** URL gambar background (null bila belum diatur). */
    public function bgUrl(): ?string
    {
        if (! $this->bg_image) {
            return null;
        }

        return Str::startsWith($this->bg_image, ['http://', 'https://'])
            ? $this->bg_image
            : asset('storage/' . $this->bg_image);
    }

    public function titleText(): string
    {
        return $this->title ?: (static::defaults()[$this->page]['title'] ?? '');
    }

    public function descriptionText(): string
    {
        return $this->description ?: (static::defaults()[$this->page]['description'] ?? '');
    }

    /** Deskripsi dipecah per baris (dipakai halaman yang menampilkan beberapa paragraf). */
    public function descriptionLines(): array
    {
        $lines = preg_split('/\R/', $this->descriptionText()) ?: [];

        return array_values(array_filter(array_map('trim', $lines), fn ($l) => $l !== ''));
    }

    public function captionText(): string
    {
        return $this->caption ?: (static::defaults()[$this->page]['caption'] ?? '');
    }

    public function colorValue(string $field): string
    {
        $v = $this->{$field};

        return (is_string($v) && $v !== '')
            ? $v
            : (static::defaults()[$this->page]['colors'][$field] ?? '#000000');
    }

    public function isCustom(string $mode): bool
    {
        return (bool) ($this->{$mode . '_bg'} || $this->{$mode . '_canvas'} || $this->{$mode . '_title'} || $this->{$mode . '_desc'});
    }

    /** CSS override untuk halaman ini (kosong bila tidak ada warna kustom). */
    public function css(): string
    {
        $t = static::targets()[$this->page] ?? null;
        if (! $t) {
            return '';
        }

        $prefixes = [
            'light' => 'html:not([data-theme="dark"]) body',
            'dark'  => 'html[data-theme="dark"] body',
        ];

        $css = '';
        foreach ($prefixes as $mode => $prefix) {
            $c = [];
            foreach (['bg', 'canvas', 'title', 'desc'] as $k) {
                $v = $this->{$mode . '_' . $k};
                // Hanya terima format #RRGGBB agar aman disisipkan ke CSS.
                $c[$k] = (is_string($v) && preg_match('/^#[0-9a-fA-F]{6}$/', $v)) ? $v : null;
            }

            if ($c['bg']) {
                $css .= static::scope($prefix, $t['bg'], 'background-color:' . $c['bg'] . ' !important');
            }
            if ($c['canvas'] && isset($t['canvas'])) {
                $css .= static::scope($prefix, $t['canvas'], 'background-color:' . $c['canvas'] . ' !important');
            }
            if ($c['title']) {
                $css .= static::scope($prefix, $t['title'], 'color:' . $c['title'] . ' !important');
            }
            if ($c['desc']) {
                $css .= static::scope($prefix, $t['desc'], 'color:' . $c['desc'] . ' !important');
            }
            if (isset($t['extra'])) {
                $css .= ($t['extra'])($prefix, $c);
            }
        }

        return $css;
    }

    protected static function scope(string $prefix, array $selectors, string $declaration): string
    {
        $list = implode(',', array_map(fn ($s) => $prefix . ' ' . $s, $selectors));

        return $list . '{' . $declaration . '}';
    }
}