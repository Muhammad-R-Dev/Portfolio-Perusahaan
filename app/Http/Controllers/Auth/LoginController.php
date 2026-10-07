<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login.
     * Kalau user sudah login, langsung lempar ke dashboard
     * (tidak perlu login ulang).
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('pages.login');
    }

    /**
     * Proses login menggunakan username & password.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Cegah session fixation
            $request->session()->regenerate();

            // Kalau sebelumnya user coba akses halaman admin lain tanpa login,
            // dia akan diarahkan balik ke halaman itu. Kalau tidak ada, ke dashboard.
            $redirectUrl = $request->session()->pull('url.intended', route('admin.dashboard'));

            // Request dari JS (fetch) di halaman login minta JSON, supaya bisa
            // menampilkan pop up "Berhasil Masuk" dulu sebelum redirect.
            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Berhasil masuk. Selamat datang kembali!',
                    'redirect' => $redirectUrl,
                ]);
            }

            // Fallback kalau JS tidak jalan: tetap redirect seperti biasa.
            return redirect($redirectUrl);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau kata sandi yang Anda masukkan salah.',
            ], 422);
        }

        return back()
            ->withErrors([
                'username' => 'Username atau kata sandi yang Anda masukkan salah.',
            ])
            ->onlyInput('username');
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}