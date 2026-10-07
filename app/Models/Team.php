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
        'sosial_media',
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

    /**
     * Ikon boxicons sesuai platform dari link sosial media.
     */
    public function getSosialMediaIconAttribute(): string
    {
        $host = $this->sosialMediaHost();

        return match (true) {
            str_contains($host, 'instagram')                     => 'bxl-instagram',
            str_contains($host, 'linkedin')                      => 'bxl-linkedin',
            str_contains($host, 'github')                        => 'bxl-github',
            str_contains($host, 'facebook'), $host === 'fb.com'  => 'bxl-facebook',
            str_contains($host, 'tiktok')                        => 'bxl-tiktok',
            str_contains($host, 'youtube'), $host === 'youtu.be' => 'bxl-youtube',
            str_contains($host, 'twitter'), $host === 'x.com'    => 'bxl-twitter',
            str_contains($host, 'wa.me'), str_contains($host, 'whatsapp') => 'bxl-whatsapp',
            default                                              => 'bx-link',
        };
    }

    /**
     * Label singkat untuk ditampilkan (nama platform / domain).
     */
    public function getSosialMediaLabelAttribute(): string
    {
        $host = $this->sosialMediaHost();

        return match (true) {
            str_contains($host, 'instagram')                     => 'Instagram',
            str_contains($host, 'linkedin')                      => 'LinkedIn',
            str_contains($host, 'github')                        => 'GitHub',
            str_contains($host, 'facebook'), $host === 'fb.com'  => 'Facebook',
            str_contains($host, 'tiktok')                        => 'TikTok',
            str_contains($host, 'youtube'), $host === 'youtu.be' => 'YouTube',
            str_contains($host, 'twitter'), $host === 'x.com'    => 'X',
            str_contains($host, 'wa.me'), str_contains($host, 'whatsapp') => 'WhatsApp',
            default                                              => $host ?: 'Sosial Media',
        };
    }

    private function sosialMediaHost(): string
    {
        $host = parse_url((string) $this->sosial_media, PHP_URL_HOST) ?: '';

        return strtolower(preg_replace('/^www\./', '', $host));
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}