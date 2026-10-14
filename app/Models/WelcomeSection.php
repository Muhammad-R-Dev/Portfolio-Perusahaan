<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
    ];

    /**
     * Ambil satu-satunya baris Welcome Section.
     * Kalau tabel masih kosong, buatkan dulu baris default-nya
     * supaya halaman admin & home tidak pernah menemukan data null.
     */
    public static function current(): self
    {
        return static::first() ?? static::create([
            'title'       => 'PT Astabrata Teknologi',
            'subtitle'    => 'Solusi Digital Terpadu',
            'description' => 'PT Astabrata Teknologi adalah perusahaan teknologi yang berfokus pada perancangan dan pengembangan solusi digital untuk membantu bisnis tumbuh di era yang serba terhubung. Kami memadukan strategi, desain, dan rekayasa perangkat lunak untuk menghadirkan produk digital yang berkesan bagi penggunanya.',
            'image'       => 'image/beranda.jpeg',
        ]);
    }
}
