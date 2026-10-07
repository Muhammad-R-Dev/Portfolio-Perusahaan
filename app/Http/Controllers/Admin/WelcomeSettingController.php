<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WelcomeSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WelcomeSettingController extends Controller
{
    public function edit()
    {
        $welcome = WelcomeSection::current();

        return view('admin.pages.setting-welcome', compact('welcome'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'welcome_title'    => ['required', 'string', 'max:150'],
            'welcome_subtitle' => ['required', 'string', 'max:150'],
            'welcome_text'     => ['required', 'string', 'max:1000'],
            'welcome_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $welcome = WelcomeSection::current();
        $imagePath = $welcome->image;

        if ($request->hasFile('welcome_image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('welcome_image')->store('welcome', 'public');
        }

        $welcome->update([
            'title'       => $validated['welcome_title'],
            'subtitle'    => $validated['welcome_subtitle'],
            'description' => $validated['welcome_text'],
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.setting.welcome')
            ->with('success', 'Welcome section berhasil diperbarui.');
    }
}