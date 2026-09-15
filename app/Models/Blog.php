<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'kategori',
        'deskripsi',
        'konten',
        'status',
    ];

    // Laravel akan mencari kolom "slug" saat route model binding, contoh:
    // Route::get('/blog/{blog:slug}', ...)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Buat slug unik otomatis dari judul setiap kali blog dibuat/di-update judulnya.
     */
    public static function generateUniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($judul);
        $slug = $baseSlug;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
