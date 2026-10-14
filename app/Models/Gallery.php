<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'foto',
    ];

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return 'https://placehold.co/400x300/png';
    }

    public function getKategoriLabelAttribute(): string
    {
        return match ($this->kategori) {
            'kegiatan'  => 'Kegiatan',
            'fasilitas' => 'Fasilitas',
            'tim'       => 'Tim',
            'acara'     => 'Acara',
            default     => ucfirst($this->kategori),
        };
    }
}
