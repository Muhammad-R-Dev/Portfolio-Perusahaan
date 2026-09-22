<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\ClientExcelController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SettingController;

// ================= FRONTEND ROUTES =================
Route::get('/', [CompanyProfileController::class, 'index'])->name('home');
Route::get('/about', [CompanyProfileController::class, 'about'])->name('about');
Route::get('/contact', [CompanyProfileController::class, 'contact'])->name('contact');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

/*
|--------------------------------------------------------------------------
| GUEST ROUTES (Hanya boleh diakses kalau BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Semua route ini wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Route Logout (Ditaruh di luar prefix admin agar URL-nya tetap /logout)
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ADMIN GROUP ROUTES
    | Menggunakan prefix('admin') agar otomatis URL berawalan /admin
    | Menggunakan name('admin.') agar otomatis nama route berawalan admin.
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // 1. Mengarahkan jika user hanya mengetik http://127.0.0.1:8000/admin 
        // akan langsung masuk ke /admin/dashboard
        Route::redirect('/', '/admin/dashboard');

        // 2. Dashboard Admin
        Route::get('/dashboard', function () {
            // NOTE: sesuaikan nama Model di bawah ini (App\Models\...) jika nama
            // model Blog/Service/Gallery/Team di project kamu berbeda.
            $totalBlog    = \App\Models\Blog::count();
            $totalLayanan = \App\Models\Service::count();
            $totalGaleri  = \App\Models\Gallery::count();
            $totalTim     = \App\Models\Team::count();
            $totalDivisi  = \App\Models\Team::whereNotNull('divisi')->distinct('divisi')->count('divisi');

            $recentBlogs   = \App\Models\Blog::latest()->take(3)->get();
            $recentGaleri  = \App\Models\Gallery::latest()->take(4)->get();
            $recentLayanan = \App\Models\Service::latest()->take(4)->get();
            $recentTeam    = \App\Models\Team::latest()->take(4)->get();

            return view('admin.pages.dashboard', compact(
                'totalBlog', 'totalLayanan', 'totalGaleri', 'totalTim', 'totalDivisi',
                'recentBlogs', 'recentGaleri', 'recentLayanan', 'recentTeam'
            ));
        })->name('dashboard');

        // 2.1 Kelola Proyek (Client & Project)
        Route::get('/kelola-proyek', function () {
            return view('admin.pages.kelola-proyek');
        })->name('kelola-proyek');

        // ---> RUTE EXPORT & IMPORT PROYEK DITAMBAHKAN DI SINI <---
        Route::get('/kelola-proyek/export', [ClientExcelController::class, 'export'])->name('kelola-proyek.export');
        Route::post('/kelola-proyek/import', [ClientExcelController::class, 'import'])->name('kelola-proyek.import');

        // 3. Kelola Layanan
        Route::resource('kelola-layanan', \App\Http\Controllers\AdminServiceController::class)->names([
            'index'   => 'kelola-layanan.index',
            'create'  => 'kelola-layanan.create',
            'store'   => 'kelola-layanan.store',
            'show'    => 'kelola-layanan.show',
            'edit'    => 'kelola-layanan.edit',
            'update'  => 'kelola-layanan.update',
            'destroy' => 'kelola-layanan.destroy',
        ]);

        // 4. Kelola Blog (parameter binding by "id" seperti yang kamu jelaskan di komentar)
        Route::get('/kelola-blog', [AdminBlogController::class, 'index'])->name('kelola-blog.index');
        
        // ---> RUTE EXPORT CSV DITAMBAHKAN DI SINI <---
        Route::get('/kelola-blog/export', [AdminBlogController::class, 'export'])->name('kelola-blog.export');
        
        Route::post('/kelola-blog', [AdminBlogController::class, 'store'])->name('kelola-blog.store');
        Route::put('/kelola-blog/{blog:id}', [AdminBlogController::class, 'update'])->name('kelola-blog.update');
        Route::delete('/kelola-blog/{blog:id}', [AdminBlogController::class, 'destroy'])->name('kelola-blog.destroy');

        // 5. Kelola Tim
        Route::get('/kelola-tim', [TeamController::class, 'index'])->name('kelola-tim');
        Route::post('/kelola-tim', [TeamController::class, 'store'])->name('kelola-tim.store');
        Route::put('/kelola-tim/{tim}', [TeamController::class, 'update'])->name('kelola-tim.update');
        Route::delete('/kelola-tim/{tim}', [TeamController::class, 'destroy'])->name('kelola-tim.destroy');

        // 6. Kelola Galeri
        Route::get('/kelola-galeri', [GalleryController::class, 'index'])->name('kelola-galeri');
        Route::post('/kelola-galeri', [GalleryController::class, 'store'])->name('kelola-galeri.store');
        Route::put('/kelola-galeri/{galeri}', [GalleryController::class, 'update'])->name('kelola-galeri.update');
        Route::delete('/kelola-galeri/{galeri}', [GalleryController::class, 'destroy'])->name('kelola-galeri.destroy');

        // 7. Halaman Setting
        Route::get('/setting', function () {
            return view('admin.pages.setting');
        })->name('setting');

        // 8. Kelola Setting (Username & Password)
        Route::post('/setting/username', [SettingController::class, 'updateUsername'])->name('setting.username.update');
        Route::post('/setting/password', [SettingController::class, 'updatePassword'])->name('setting.password.update');


        // PENTING: route spesifik (bulk-delete, delete-all) HARUS didaftarkan
        // SEBELUM Route::resource('clients', ...), supaya tidak "ketangkep"
        // oleh route {client} milik resource (contoh: delete-all dikira id client).
        // Juga jangan tulis ulang '/admin/...' di sini karena sudah di dalam
        // Route::prefix('admin'), nanti URL-nya jadi dobel /admin/admin/...
        Route::post('clients/bulk-delete', [ClientController::class, 'bulkDestroy'])->name('clients.bulkDestroy');
        Route::delete('clients/delete-all', [ClientController::class, 'destroyAll'])->name('clients.destroyAll');
        Route::resource('clients', ClientController::class)->except(['create', 'edit', 'show']);
        Route::get('kelola-proyek/template', [ClientExcelController::class, 'template'])->name('kelola-proyek.template');
    });
});