<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Halaman daftar blog (resources/views/pages/blog/blog.blade.php).
     */
    public function index(): View
    {
        $blogs = Blog::where('status', 'publish')
            ->latest()
            ->get();

        return view('pages.blog', compact('blogs'));
    }

    /**
     * Halaman detail blog (resources/views/pages/blog/detail-blog.blade.php).
     * Route model binding otomatis mencari berdasarkan kolom "slug".
     */
    public function show(Blog $blog): View
    {
        abort_if($blog->status !== 'publish', 404);

        $blogLainnya = Blog::where('status', 'publish')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('pages.detail-blog', compact('blog', 'blogLainnya'));
    }
}
