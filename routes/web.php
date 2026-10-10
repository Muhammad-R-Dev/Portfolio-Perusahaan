<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\ClientExcelController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FaqSettingController;
use App\Http\Controllers\Admin\NavbarSettingController;
use App\Http\Controllers\Admin\ContactSettingController;
use App\Http\Controllers\Admin\PageSettingController;

// ================= FRONTEND ROUTES =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/layanan', function () {
    // NOTE: samakan query/urutan ini dengan yang dipakai di HomeController@index (halaman home)
    $services = \App\Models\Service::latest()->get();
    return view('pages.layanan', compact('services'));
})->name('layanan');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
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

            $recentBlogs   = \App\Models\Blog::latest()->take(3)->get();
            $recentGaleri  = \App\Models\Gallery::latest()->take(4)->get();
            $recentLayanan = \App\Models\Service::latest()->take(4)->get();
            $recentTeam    = \App\Models\Team::latest()->take(4)->get();

            return view('admin.pages.dashboard', compact(
                'totalBlog', 'totalLayanan', 'totalGaleri', 'totalTim',
                'recentBlogs', 'recentGaleri', 'recentLayanan', 'recentTeam'
            ));
        })->name('dashboard');

        // 2.1 Kelola Proyek (Client & Project)
        Route::get('/kelola-proyek', function () {
            return view('admin.pages.kelola-proyek');
        })->name('kelola-proyek');

        // ---> RUTE EXPORT, IMPORT, & TEMPLATE PROYEK <---
        Route::get('/kelola-proyek/export', [ClientExcelController::class, 'export'])->name('kelola-proyek.export');
        Route::post('/kelola-proyek/import', [ClientExcelController::class, 'import'])->name('kelola-proyek.import');
        Route::get('/kelola-proyek/template', [ClientExcelController::class, 'template'])->name('kelola-proyek.template');

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

        // 4. Kelola Blog
        Route::get('/kelola-blog', [AdminBlogController::class, 'index'])->name('kelola-blog.index');
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

        // 7. Halaman Setting (menu + sub halaman)
        Route::prefix('setting')->name('setting.')->group(function () {

            // 7.1 Menu utama Settings (grid pilihan)
            Route::get('/', function () {
                return view('admin.pages.setting');
            })->name('index');

            // 7.2 Edit Akun (username & password)
            Route::get('/account', function () {
                return view('admin.pages.setting-account');
            })->name('account');

            // 7.3 Pengaturan Navbar & Header (CRUD asli: logo + nama perusahaan + deskripsi footer)
            Route::get('/navbar', [NavbarSettingController::class, 'edit'])->name('navbar');
            Route::put('/navbar', [NavbarSettingController::class, 'update'])->name('navbar.update');

            // 7.4 Edit FAQ (CRUD asli, lihat FaqSettingController di bawah grup setting ini)
            Route::get('/faq', [FaqSettingController::class, 'index'])->name('faq');
            Route::post('/faq', [FaqSettingController::class, 'store'])->name('faq.store');
            Route::put('/faq/{faq}', [FaqSettingController::class, 'update'])->name('faq.update');
            Route::delete('/faq/{faq}', [FaqSettingController::class, 'destroy'])->name('faq.destroy');

            // 7.5 Welcome sekarang digabung ke Pengaturan Halaman (tab Beranda). URL lama diarahkan ke sana.
            Route::redirect('/welcome', '/admin/setting/pages')->name('welcome');

          // 7.5.2 Pengaturan Kontak & Lokasi (sosial media + alamat)
            Route::get('/contact', [ContactSettingController::class, 'edit'])->name('contact');
            Route::put('/contact', [ContactSettingController::class, 'update'])->name('contact.update');

            // 7.6 Banner
            Route::get('/banner', function () {
                return view('admin.pages.setting-banner');
            })->name('banner');

            // 7.7 Pengaturan Halaman (judul, deskripsi, warna background & teks per halaman)
            Route::get('/pages', [PageSettingController::class, 'edit'])->name('pages');
            Route::put('/pages', [PageSettingController::class, 'update'])->name('pages.update');

            // 7.6 Kelola Setting (Username & Password) - proses submit form Edit Akun
            Route::post('/username', [SettingController::class, 'updateUsername'])->name('username.update');
            Route::post('/password', [SettingController::class, 'updatePassword'])->name('password.update');

            // 7.8 Background halaman login (diatur dari Edit Akun)

        });

        // PENTING: route spesifik (bulk-delete, delete-all) HARUS didaftarkan
        // SEBELUM Route::resource('clients', ...), supaya tidak "ketangkep"
        Route::post('clients/bulk-delete', [ClientController::class, 'bulkDestroy'])->name('clients.bulkDestroy');
        Route::delete('clients/delete-all', [ClientController::class, 'destroyAll'])->name('clients.destroyAll');
        Route::resource('clients', ClientController::class)->except(['create', 'edit', 'show']);
    });

});