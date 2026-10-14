@extends('layouts.auth')

@section('title', 'Masuk - PT Astabrata Teknologi')

@section('content')
<div class="login-page">
    <div class="login-shell reveal">
        <!-- Panel kiri: foto kantor full-bleed (disembunyikan di mobile) -->
        <div class="login-photo">
            @php
                // Background login bisa diganti dari Settings > Pengaturan Halaman > Login
                $loginBgRaw = \App\Models\PageSetting::for('login')->bgUrl();
                $loginBgSrc = $loginBgRaw ?: asset('image/kantor.jpeg');
            @endphp
            <img src="{{ $loginBgSrc }}" alt="Kantor PT Astabrata Teknologi" class="login-photo-img">
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

<!-- Pop up "Berhasil Masuk": muncul di tengah layar setelah login sukses, lalu auto redirect -->
<div class="login-success-overlay" id="loginSuccessOverlay" role="status" aria-live="polite">
    <div class="login-success-card">
        <div class="login-success-icon"><i class="fa-solid fa-circle-check"></i></div>
        <h3>Berhasil Masuk</h3>
        <p id="loginSuccessMessage">Selamat datang kembali! Mengalihkan Anda ke dashboard...</p>
        <div class="login-success-spinner"></div>
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

    /* ===== Pop up "Berhasil Masuk" (tengah layar, lalu auto redirect) ===== */
    .login-success-overlay {
        position: fixed;
        inset: 0;
        background: rgba(9, 67, 86, 0.38);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .login-success-overlay.show { display: flex; }
    .login-success-overlay.in { opacity: 1; }

    .login-success-card {
        background: #FFFFFF;
        width: 100%;
        max-width: 320px;
        border-radius: 20px;
        padding: 2.4rem 2.2rem 2rem;
        text-align: center;
        box-shadow: 0 25px 60px rgba(9, 67, 86, 0.25);
        transform: scale(0.85);
        opacity: 0;
        transition: transform 0.35s ease, opacity 0.35s ease;
    }
    .login-success-overlay.in .login-success-card { transform: scale(1); opacity: 1; }

    .login-success-icon { font-size: 3.2rem; color: #2f6e4e; margin-bottom: 0.9rem; }
    .login-success-card h3 {
        font-family: 'Sora', sans-serif;
        font-size: 1.15rem;
        font-weight: 600;
        color: #1F2933;
        margin-bottom: 0.5rem;
    }
    .login-success-card p {
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        color: #6B7A80;
        line-height: 1.6;
        margin-bottom: 1.3rem;
    }
    .login-success-spinner {
        width: 26px;
        height: 26px;
        border: 3px solid #E1E4E5;
        border-top-color: #094356;
        border-radius: 50%;
        margin: 0 auto;
        animation: loginSuccessSpin 0.7s linear infinite;
    }
    @keyframes loginSuccessSpin { to { transform: rotate(360deg); } }

    /* Tombol submit: state loading saat menunggu respons server */
    .login-submit[disabled] { opacity: 0.75; cursor: default; }
    .login-submit[disabled]:hover { background: #094356; transform: none; }
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

        /* ===== Submit login via AJAX: kalau sukses, tampilkan pop up
           "Berhasil Masuk" di tengah layar dulu, baru redirect ke dashboard ===== */
        const loginForm = document.querySelector('.login-form');
        const overlay = document.getElementById('loginSuccessOverlay');
        const overlayMessage = document.getElementById('loginSuccessMessage');

        if (loginForm && overlay) {
            const submitBtn = loginForm.querySelector('.login-submit');
            const submitDefaultText = submitBtn ? submitBtn.textContent : 'Masuk';

            function setLoading(isLoading) {
                if (!submitBtn) return;
                submitBtn.disabled = isLoading;
                submitBtn.textContent = isLoading ? 'Memproses...' : submitDefaultText;
            }

            function showFormError(message) {
                let alertBox = loginForm.parentElement.querySelector('.login-alert:not(.login-alert-success)');
                if (!alertBox) {
                    alertBox = document.createElement('div');
                    alertBox.className = 'login-alert';
                    alertBox.setAttribute('role', 'alert');
                    alertBox.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i><span></span>';
                    loginForm.parentElement.insertBefore(alertBox, loginForm);
                }
                alertBox.querySelector('span').textContent = message;
            }

            function showSuccessPopup(message, redirectUrl) {
                if (message && overlayMessage) overlayMessage.textContent = message;
                overlay.classList.add('show');
                requestAnimationFrame(function () {
                    requestAnimationFrame(function () { overlay.classList.add('in'); });
                });
                setTimeout(function () {
                    window.location.href = redirectUrl;
                }, 1800);
            }

            loginForm.addEventListener('submit', function (e) {
                e.preventDefault();
                setLoading(true);

                fetch(loginForm.getAttribute('action'), {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: new FormData(loginForm),
                })
                    .then(function (res) {
                        return res.json().then(function (data) {
                            return { ok: res.ok, data: data };
                        });
                    })
                    .then(function (result) {
                        if (result.ok && result.data && result.data.success) {
                            showSuccessPopup(result.data.message, result.data.redirect);
                            return;
                        }

                        setLoading(false);

                        let message = 'Username atau kata sandi yang Anda masukkan salah.';
                        if (result.data && result.data.errors) {
                            const firstField = Object.keys(result.data.errors)[0];
                            if (firstField) message = result.data.errors[firstField][0];
                        } else if (result.data && result.data.message) {
                            message = result.data.message;
                        }
                        showFormError(message);
                    })
                    .catch(function () {
                        setLoading(false);
                        // JS/jaringan bermasalah: jatuhkan ke submit biasa (fallback)
                        loginForm.submit();
                    });
            });
        }
    });
</script>
@endpush
@endsection