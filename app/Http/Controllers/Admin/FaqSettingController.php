<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqSettingController extends Controller
{
    public function index()
    {
        $faqs = Faq::ordered()->get();

        return view('admin.pages.setting-faq', compact('faqs'));
    }

    public function store(Request $request)
    {
        if (Faq::count() >= Faq::MAX_FAQ) {
            return response()->json([
                'message' => 'Batas maksimal 5 FAQ sudah tercapai.',
            ], 422);
        }

        $validated = $request->validate([
            'question' => ['required', 'string', 'max:150'],
            'answer'   => ['required', 'string', 'max:500'],
        ]);

        $faq = Faq::create([
            'question' => $validated['question'],
            'answer'   => $validated['answer'],
            'order'    => Faq::count(),
        ]);

        return response()->json([
            'message' => 'FAQ berhasil ditambahkan.',
            'faq'     => $faq,
        ]);
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:150'],
            'answer'   => ['required', 'string', 'max:500'],
        ]);

        $faq->update($validated);

        return response()->json([
            'message' => 'FAQ berhasil diperbarui.',
            'faq'     => $faq,
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'message' => 'FAQ berhasil dihapus.',
        ]);
    }
}