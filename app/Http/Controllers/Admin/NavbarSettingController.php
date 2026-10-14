<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NavbarSettingController extends Controller
{
    /** Kolom warna header & footer di tabel site_settings */
    private const COLOR_FIELDS = [
        'navbar_bg_light', 'navbar_text_light', 'navbar_bg_dark', 'navbar_text_dark',
        'footer_bg_light', 'footer_text_light', 'footer_bg_dark', 'footer_text_dark',
    ];

    public function edit()
    {
        $setting = SiteSetting::current();

        return view('admin.pages.setting-navbar', compact('setting'));
    }

    public function update(Request $request)
    {
        $rules = [
            'brand_name'          => ['required', 'string', 'max:100'],
            'brand_tagline'       => ['nullable', 'string', 'max:100'],
            'footer_description'  => ['nullable', 'string', 'max:500'],
            'media'                => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];

        // Warna header & footer (mode terang / gelap), format hex 6 digit mis. #094356
        foreach (self::COLOR_FIELDS as $field) {
            $rules[$field] = ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'];
        }

        $validated = $request->validate($rules, [
            'regex' => 'Kode warna harus berformat hex 6 digit, contoh: #094356.',
        ]);

        $setting = SiteSetting::current();
        $logoPath = $setting->logo;

        if ($request->hasFile('media')) {
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('media')->store('logo', 'public');
        }

        $data = [
            'brand_name'          => $validated['brand_name'],
            'brand_tagline'       => $validated['brand_tagline'] ?? null,
            'footer_description'  => $validated['footer_description'] ?? null,
            'logo'                => $logoPath,
        ];

        // Simpan warna hanya yang dikirim form (huruf kecil agar seragam)
        foreach (self::COLOR_FIELDS as $field) {
            if (!empty($validated[$field])) {
                $data[$field] = strtolower($validated[$field]);
            }
        }

        $setting->update($data);

        return redirect()
            ->route('admin.setting.navbar')
            ->with('success', 'Pengaturan Header & Footer berhasil diperbarui.');
    }
}