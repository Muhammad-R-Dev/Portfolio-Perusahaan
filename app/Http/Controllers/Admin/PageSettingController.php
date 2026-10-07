<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSetting;
use App\Models\WelcomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageSettingController extends Controller
{
    public function edit()
    {
        $defaults = PageSetting::defaults();

        $settings = [];
        foreach (array_keys($defaults) as $key) {
            $settings[$key] = PageSetting::for($key);
        }

        // Data "Tentang Kami" (Welcome) yang tampil di tab Beranda
        $welcome = WelcomeSection::current();

        return view('admin.pages.setting-pages', compact('defaults', 'settings', 'welcome'));
    }

    public function update(Request $request)
    {
        $defaults = PageSetting::defaults();

        // ----- Validasi -----
        $hex   = ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'];
        $rules = [
            'pages'                => ['required', 'array'],
            'welcome_title'        => ['required', 'string', 'max:150'],
            'welcome_subtitle'     => ['required', 'string', 'max:150'],
            'welcome_text'         => ['required', 'string', 'max:1000'],
            'welcome_image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_welcome_image' => ['nullable', 'boolean'],
            'bg_image.beranda'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'bg_image.blog'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'bg_image.about'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'bg_image.about_desc'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'bg_image.login'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'remove_bg_image.beranda'   => ['nullable', 'boolean'],
            'remove_bg_image.blog'      => ['nullable', 'boolean'],
            'remove_bg_image.about'     => ['nullable', 'boolean'],
            'remove_bg_image.about_desc' => ['nullable', 'boolean'],
            'remove_bg_image.login'     => ['nullable', 'boolean'],
        ];

        foreach (array_keys($defaults) as $key) {
            $rules["pages.$key.title"]       = ['nullable', 'string', 'max:120'];
            $rules["pages.$key.description"] = ['nullable', 'string', 'max:1000'];
            $rules["pages.$key.caption"]     = ['nullable', 'string', 'max:1000'];
            foreach (PageSetting::COLOR_FIELDS as $field) {
                $rules["pages.$key.$field"] = $hex;
            }
        }

        $data = $request->validate($rules, [
            'pages.*.*.regex'           => 'Format warna harus berupa kode hex, contoh #FFFFFF.',
            'welcome_title.required'    => 'Judul "Tentang Kami" wajib diisi.',
            'welcome_subtitle.required' => 'Subjudul "Tentang Kami" wajib diisi.',
            'welcome_text.required'     => 'Teks "Tentang Kami" wajib diisi.',
            'welcome_text.max'          => 'Teks "Tentang Kami" maksimal 1000 karakter.',
            'welcome_image.image'       => 'File harus berupa gambar.',
            'welcome_image.mimes'       => 'Format gambar harus JPG, PNG, atau WEBP.',
            'welcome_image.max'         => 'Ukuran gambar maksimal 3MB.',
            'welcome_image.uploaded'    => 'Gambar gagal diunggah. Pastikan ukurannya maksimal 3MB.',
            'bg_image.beranda.image'         => 'Background Beranda harus berupa gambar.',
            'bg_image.beranda.mimes'         => 'Format background Beranda harus JPG, PNG, atau WEBP.',
            'bg_image.beranda.max'           => 'Ukuran background Beranda maksimal 3MB.',
            'bg_image.blog.image'            => 'Background Blog harus berupa gambar.',
            'bg_image.blog.mimes'            => 'Format background Blog harus JPG, PNG, atau WEBP.',
            'bg_image.blog.max'              => 'Ukuran background Blog maksimal 3MB.',
            'bg_image.about.image'           => 'Background About harus berupa gambar.',
            'bg_image.about.mimes'           => 'Format background About harus JPG, PNG, atau WEBP.',
            'bg_image.about.max'             => 'Ukuran background About maksimal 3MB.',
            'bg_image.about_desc.image'      => 'Background Deskripsi harus berupa gambar.',
            'bg_image.about_desc.mimes'      => 'Format background Deskripsi harus JPG, PNG, atau WEBP.',
            'bg_image.about_desc.max'        => 'Ukuran background Deskripsi maksimal 3MB.',
            'bg_image.login.image'           => 'Background Login harus berupa gambar.',
            'bg_image.login.mimes'           => 'Format background Login harus JPG, PNG, atau WEBP.',
            'bg_image.login.max'             => 'Ukuran background Login maksimal 3MB.',
        ]);

        // ----- Simpan "Tentang Kami" (Welcome) -----
        $welcome   = WelcomeSection::current();
        $imagePath = $welcome->image;

        if ($request->hasFile('welcome_image')) {
            $this->deleteWelcomeImage($imagePath);
            $imagePath = $request->file('welcome_image')->store('welcome', 'public');
        } elseif ($request->boolean('remove_welcome_image')) {
            $this->deleteWelcomeImage($imagePath);
            $imagePath = null;
        }

        $welcome->update([
            'title'       => trim($data['welcome_title']),
            'subtitle'    => trim($data['welcome_subtitle']),
            'description' => trim($data['welcome_text']),
            'image'       => $imagePath,
        ]);

        // ----- Simpan pengaturan tiap halaman -----
        foreach ($defaults as $key => $def) {
            $in = $data['pages'][$key] ?? [];

            $title   = trim((string) ($in['title'] ?? ''));
            $desc    = trim(str_replace("\r\n", "\n", (string) ($in['description'] ?? '')));
            $caption = trim(str_replace("\r\n", "\n", (string) ($in['caption'] ?? '')));

            // Teks yang sama dengan bawaan disimpan sebagai null, supaya tampilan asli halaman tetap dipakai.
            $row = [
                'title'       => ($title === '' || $title === $def['title']) ? null : $title,
                'description' => ($desc === '' || $desc === str_replace("\r\n", "\n", $def['description'])) ? null : $desc,
                'caption'     => ($caption === '' || $caption === ($def['caption'] ?? null)) ? null : $caption,
            ];

            foreach (['light', 'dark'] as $mode) {
                $custom = $request->boolean("pages.$key.{$mode}_custom");
                foreach (['bg', 'title', 'desc', 'canvas'] as $part) {
                    $field = "{$mode}_{$part}";
                    $row[$field] = $custom ? ($in[$field] ?? null) : null;
                }
            }

            $ps = PageSetting::updateOrCreate(['page' => $key], $row);

            // Gambar background (khusus Beranda, Blog, About, & Login)
            if (in_array($key, ['beranda', 'blog', 'about', 'login'], true)) {
                $this->saveBackground($request, $ps, $key);
            }
        }

        // ----- Simpan background Deskripsi About (about_desc) -----
        $psAboutDesc = PageSetting::firstOrNew(['page' => 'about_desc']);
        $this->saveBackground($request, $psAboutDesc, 'about_desc');

        return redirect()
            ->route('admin.setting.pages')
            ->with('success', 'Pengaturan halaman berhasil disimpan.');
    }

    /** Simpan / hapus gambar background sebuah halaman. */
    protected function saveBackground(Request $request, PageSetting $ps, string $key): void
    {
        $newFile = $request->file("bg_image.$key");
        $remove  = $request->boolean("remove_bg_image.$key");

        if ($newFile) {
            $this->deleteWelcomeImage($ps->bg_image);
            // Jika record belum ada di DB (firstOrNew), simpan dulu sebelum update.
            if (! $ps->exists) {
                $ps->save();
            }
            $ps->update(['bg_image' => $newFile->store('page-backgrounds', 'public')]);
        } elseif ($remove && $ps->bg_image) {
            $this->deleteWelcomeImage($ps->bg_image);
            $ps->update(['bg_image' => null]);
        }
    }

    /** Hapus gambar lama dari storage (gambar berupa URL luar tidak disentuh). */
    protected function deleteWelcomeImage(?string $path): void
    {
        if ($path && ! Str::startsWith($path, ['http://', 'https://']) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}