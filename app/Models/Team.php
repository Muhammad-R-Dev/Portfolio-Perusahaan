<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'divisi',
        'foto',
        'status',
        'urutan',
    ];

    /**
     * URL foto anggota tim.
     * Kalau belum upload foto, otomatis fallback ke image/profile.png (asset bawaan).
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::url($this->foto);
        }

        return asset('image/profile.png');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
