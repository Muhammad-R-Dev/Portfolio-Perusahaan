<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ContactSettingController extends Controller
{
    /** Domain yang diizinkan per platform sosial media. */
    private const SOCIAL_DOMAINS = [
        'youtube'   => ['youtube.com', 'youtu.be'],
        'facebook'  => ['facebook.com', 'fb.com', 'fb.me', 'fb.watch'],
        'instagram' => ['instagram.com', 'instagr.am'],
        'linkedin'  => ['linkedin.com', 'lnkd.in'],
        'twitter'   => ['twitter.com', 'x.com'],
        'github'    => ['github.com'],
    ];

    public function edit()
    {
        $setting = SiteSetting::current();

        return view('admin.pages.setting-contact', compact('setting'));
    }

    public function update(Request $request)
    {
        $input = $request->all();

        // Link boleh diketik tanpa https:// -> ditambahkan otomatis
        $urlFields = ['map_link'];
        foreach (array_keys(self::SOCIAL_DOMAINS) as $key) {
            $urlFields[] = 'social_' . $key;
        }
        foreach ($urlFields as $field) {
            $v = trim((string) ($input[$field] ?? ''));
            // Kalau yang ditempel kode <iframe> dari Google Maps, ambil src-nya saja
            if ($field === 'map_link' && stripos($v, '<iframe') !== false && preg_match('/src\s*=\s*["\']([^"\']+)["\']/i', $v, $m)) {
                $v = html_entity_decode($m[1]);
            }
            if ($v !== '' && !preg_match('#^[a-z][a-z0-9+.-]*://#i', $v)) {
                $v = 'https://' . $v;
            }
            $input[$field] = $v;
        }

        // Nomor WA: angka saja, buang 0 / 62 di depan
        $input['wa_number'] = preg_replace('/^(62|0)+/', '', preg_replace('/\D/', '', (string) ($input['wa_number'] ?? '')));

        $rules = [
            'wa_number'    => ['nullable', 'digits_between:8,15'],
            'address_name' => ['nullable', 'string', 'max:255'],
            'address_full' => ['nullable', 'string', 'max:1000'],
            'map_link'     => ['nullable', 'string', 'max:1000', function ($attr, $value, $fail) {
                $host = $this->httpHost($value);
                if (!$host || !preg_match('/(^|\.)google\.[a-z.]+$|^(maps\.app\.)?goo\.gl$/i', $host)) {
                    $fail('Link Google Maps tidak valid.');
                }
            }],
        ];

        foreach (self::SOCIAL_DOMAINS as $key => $domains) {
            $rules['social_' . $key] = ['nullable', 'string', 'max:255', function ($attr, $value, $fail) use ($domains, $key) {
                $host = $this->httpHost($value);
                $ok = $host && collect($domains)->contains(fn ($d) => $host === $d || str_ends_with($host, '.' . $d));
                if (!$ok) {
                    $fail('Link ' . ucfirst($key) . ' tidak valid.');
                }
            }];
        }

        $data = Validator::make($input, $rules)->validate();

        // Link pendek (maps.app.goo.gl) diubah ke link lengkap agar petanya bisa ditampilkan
        if (!empty($data['map_link'])) {
            $data['map_link'] = $this->resolveShortMapLink($data['map_link']);
        }

        // string kosong -> null
        $data = array_map(fn ($v) => ($v === '' ? null : $v), $data);

        $setting = SiteSetting::current();
        $setting->fill($data)->save();

        return redirect()
            ->route('admin.setting.contact')
            ->with('success', 'Pengaturan kontak & lokasi berhasil disimpan.');
    }

    /** Ikuti redirect link pendek Google Maps sampai ketemu link lengkapnya. Gagal -> link asli. */
    private function resolveShortMapLink(string $url): string
    {
        $host = $this->httpHost($url);
        if (!$host || !preg_match('/^(maps\.app\.)?goo\.gl$/', $host)) {
            return $url;
        }

        try {
            $current = $url;
            for ($i = 0; $i < 6; $i++) {
                $res = Http::withoutRedirecting()
                    ->timeout(8)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->get($current);

                $next = $res->header('Location');
                if (!$res->redirect() || !$next) {
                    break;
                }

                // Halaman consent Google: link tujuan ada di parameter "continue"
                $nextHost = $this->httpHost($next);
                if ($nextHost && str_starts_with($nextHost, 'consent.')) {
                    parse_str(parse_url($next, PHP_URL_QUERY) ?? '', $q);
                    if (!empty($q['continue'])) {
                        $next = $q['continue'];
                    }
                }

                $current = $next;
                $h = $this->httpHost($current);
                if ($h && preg_match('/(^|\.)google\.[a-z.]+$/', $h) && str_contains((string) parse_url($current, PHP_URL_PATH), '/maps')) {
                    return $current;
                }
            }
        } catch (\Throwable $e) {
            // abaikan, pakai link asli
        }

        return $url;
    }

    /** Host dari URL http(s), atau null kalau bukan URL http(s) yang valid. */
    private function httpHost(string $url): ?string
    {
        $p = parse_url($url);
        if (!$p || !in_array(strtolower($p['scheme'] ?? ''), ['http', 'https'], true) || empty($p['host'])) {
            return null;
        }

        return strtolower($p['host']);
    }
}