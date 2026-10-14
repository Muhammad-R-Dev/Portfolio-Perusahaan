<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $fillable = [
        'image',
        'title',
        'description',
    ];

    /**
     * URL gambar layanan. Mengembalikan placeholder kalau file
     * tidak ada di disk (mis. hilang karena redeploy), sama seperti
     * pola yang dipakai di Gallery::getFotoUrlAttribute().
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::url($this->image);
        }

        return 'https://placehold.co/400x300/png';
    }
}