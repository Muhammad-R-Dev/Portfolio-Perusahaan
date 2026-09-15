@extends('layouts.auth')

@section('title', 'Masuk - PT Astabrata Teknologi')

@section('content')
<div class="login-page">
    <div class="login-shell reveal">
        <!-- Panel kiri: foto kantor full-bleed dengan teks overlay (disembunyikan di mobile) -->
        <div class="login-photo">
            <img src="{{ asset('image/kantor.jpeg') }}" alt="Kantor PT Astabrata Teknologi" class="login-photo-img">
            <div class="login-photo-overlay"></div>

            <div class="login-photo-content">
                <span class="login-welcome">Selamat Datang</span>
                <p class="login-photo-eyebrow">Portal Internal</p>
                <h1>Delapan Unsur,<br>Satu Arah Kerja.</h1>
            </div>
        </div>

        <!-- Panel kanan: form login -->
        <div class="login-form-panel">
            <div class="login-form-inner">
                <a href="{{ url('/') }}" class="login-logo">
                    <img src="{{ asset('img/logo asta.png') }}" alt="Logo Astabrata Teknologi">
                </a>

                <h2>Masuk ke Akun Anda</h2>
                <p class="login-subtitle">
                    <strong>Portal Internal.</strong> Masuk untuk mengelola proyek, konten, dan data klien PT Astabrata Teknologi dari satu tempat.
                </p>

                @if ($errors->any())
                    <div class="login-alert" role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('status'))
                    <div class="login-alert login-alert-success" role="status">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form" novalidate>
                    @csrf

                    <div class="input-group-line">
                        <label for="username">Username<span class="required">*</span></label>
                        <div class="input-line-wrap">
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username Anda"
                                autocomplete="username"
                                required
                                autofocus>
                        </div>
                        @error('username')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group-line">
                        <label for="password">Kata Sandi<span class="required">*</span></label>
                        <div class="input-line-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required>
                            <button type="button" class="toggle-password" data-toggle-password aria-label="Tampilkan kata sandi">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="login-options">
                        <label class="remember-check">
                            <input type="checkbox" name="remember" id="remember">
                            <span>Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="login-submit">Masuk</button>
                </form>

                <div class="login-note-inline">
                    <strong>Butuh Akses?</strong> Hubungi admin sistem jika Anda belum memiliki akun untuk masuk ke portal ini.
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .login-page {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #EDEDED;
        padding: 40px 5%;
        isolation: isolate;
    }

    /* Background pola batik dengan opacity rendah di belakang card */
    .login-page::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('image/bg batik.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        opacity: 0.5;
        z-index: 0;
    }

    .login-shell {
        position: relative;
        z-index: 1;
        display: flex;
        width: 100%;
        max-width: 1080px;
        min-height: 640px;
        border-radius: 20px;
        overflow: hidden;
        background: #FFFFFF;
        box-shadow: 0 25px 60px rgba(9, 67, 86, 0.18);
        opacity: 0;
        transform: translateY(24px);
        transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .login-shell.in-view { opacity: 1; transform: translateY(0); }

    /* ===== Panel kiri: foto full-bleed (diperlebar) ===== */
    .login-photo {
        flex: 1 1 62%;
        position: relative;
        overflow: hidden;
    }
    .login-photo-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .login-photo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(9, 67, 86, 0.15) 0%, rgba(9, 67, 86, 0.35) 55%, rgba(6, 32, 41, 0.92) 100%);
    }
    .login-photo-content {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 2.75rem 2.5rem;
        color: #FFFFFF;
    }
    .login-welcome {
        display: inline-block;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.75rem;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #7FD8C4;
        padding-bottom: 0.5rem;
        border-bottom: 1.5px solid #7FD8C4;
        margin-bottom: 1.1rem;
    }
    .login-photo-eyebrow {
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        font-weight: 400;
        color: rgba(255, 255, 255, 0.75);
        margin-bottom: 0.3rem;
    }
    .login-photo-content h1 {
        font-family: 'Sora', sans-serif;
        font-size: 1.75rem;
        font-weight: 600;
        line-height: 1.35;
        letter-spacing: -0.01em;
        color: #FFFFFF;
    }

    /* ===== Panel kanan: form (diperkecil) ===== */
    .login-form-panel {
        flex: 1 1 38%;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 2rem;
    }
    .login-form-inner {
        width: 100%;
        max-width: 320px;
    }

    .login-logo {
        display: flex;
        justify-content: center;
        margin-bottom: 1.3rem;
    }
    .login-logo img {
        height: 48px;
        width: auto;
        object-fit: contain;
    }

    .login-form-inner h2 {
        font-family: 'Sora', sans-serif;
        font-size: 1.2rem;
        font-weight: 600;
        letter-spacing: -0.01em;
        color: #1F2933;
        text-align: center;
        margin-bottom: 0.5rem;
    }
    .login-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 0.82rem;
        font-weight: 400;
        line-height: 1.6;
        color: #6B7A80;
        text-align: center;
        margin-bottom: 1.7rem;
    }
    .login-subtitle strong { color: #094356; font-weight: 600; }

    .login-alert {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        background: rgba(217, 83, 79, 0.08);
        border: 1px solid rgba(217, 83, 79, 0.25);
        color: #b3413d;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 1.4rem;
    }
    .login-alert i { margin-top: 2px; }
    .login-alert-success {
        background: rgba(47, 110, 78, 0.08);
        border-color: rgba(47, 110, 78, 0.25);
        color: #2f6e4e;
    }

    .login-form { display: flex; flex-direction: column; gap: 1.25rem; }

    /* Input bergaya underline, sesuai referensi */
    .input-group-line label {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: #3E4A50;
        margin-bottom: 0.6rem;
    }
    .input-group-line .required {
        color: #D9534F;
        margin-left: 2px;
    }
    .input-line-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-line-wrap input {
        width: 100%;
        font-family: 'Poppins', sans-serif;
        font-size: 0.92rem;
        font-weight: 400;
        color: #1F2933;
        background: transparent;
        border: none;
        border-bottom: 1.5px solid #E1E4E5;
        border-radius: 0;
        padding: 0.55rem 1.8rem 0.55rem 0;
        transition: border-color 0.25s ease;
    }
    .input-line-wrap input::placeholder { color: #9AA7AC; }
    .input-line-wrap input:focus {
        outline: none;
        border-bottom-color: #094356;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        background: none;
        border: none;
        color: #7C9BA6;
        cursor: pointer;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
    .toggle-password i { display: block; font-size: 0.95rem; pointer-events: none; }
    .toggle-password:hover { color: #094356; }
    .toggle-password:focus-visible {
        outline: 2px solid #094356;
        outline-offset: 2px;
        border-radius: 4px;
    }

    .field-error {
        display: block;
        margin-top: 0.45rem;
        font-size: 0.78rem;
        color: #b3413d;
    }

    .login-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Poppins', sans-serif;
        font-size: 0.83rem;
        font-weight: 400;
        margin-top: -0.4rem;
    }
    .remember-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6B7A80;
        cursor: pointer;
    }
    .remember-check input {
        width: 16px;
        height: 16px;
        accent-color: #094356;
        cursor: pointer;
    }
    .forgot-link {
        color: #094356;
        font-weight: 500;
        text-decoration: none;
    }
    .forgot-link:hover { text-decoration: underline; }

    .login-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        border: none;
        border-radius: 10px;
        background: #094356;
        color: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.95rem 1.5rem;
        cursor: pointer;
        transition: background 0.25s ease, transform 0.25s ease;
    }
    .login-submit:hover { background: #0b566e; transform: translateY(-2px); }
    .login-submit:active { transform: translateY(0); }

    .login-note-inline {
        font-family: 'Poppins', sans-serif;
        text-align: center;
        margin-top: 1.6rem;
        font-size: 0.8rem;
        font-weight: 400;
        line-height: 1.6;
        color: #8792A2;
    }
    .login-note-inline strong { color: #094356; font-weight: 500; }

    .login-back {
        font-family: 'Poppins', sans-serif;
        text-align: center;
        margin-top: 1.2rem;
        font-size: 0.83rem;
        font-weight: 400;
    }
    .login-back a {
        color: #4A5A61;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }
    .login-back a:hover { color: #094356; }

    /* ===== Mobile: panel foto disembunyikan total, langsung ke form ===== */
    @media (max-width: 860px) {
        .login-shell { flex-direction: column; min-height: auto; border-radius: 16px; }

        .login-photo { display: none; }

        .login-form-panel { padding: 2.5rem 1.5rem 2.5rem; }
    }
    @media (max-width: 420px) {
        .login-page { padding: 24px 5%; }
        .login-shell { border-radius: 16px; }
        .login-form-inner h2 { font-size: 1.3rem; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Reveal masuk saat halaman siap
        const shell = document.querySelector('.login-shell');
        if (shell) requestAnimationFrame(() => shell.classList.add('in-view'));

        // Tampil/sembunyikan kata sandi.
        // Pakai event delegation di document supaya tetap jalan
        // walau ada script lain / re-render yang menyentuh DOM setelahnya.
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('[data-toggle-password]');
            if (!btn) return;

            e.preventDefault();

            const wrapper = btn.closest('.input-line-wrap');
            const input = wrapper ? wrapper.querySelector('input') : null;
            const icon = btn.querySelector('i');
            if (!input || !icon) return;

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';

            icon.classList.toggle('fa-eye', !isHidden);
            icon.classList.toggle('fa-eye-slash', isHidden);

            btn.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    });
</script>
@endpush
@endsection