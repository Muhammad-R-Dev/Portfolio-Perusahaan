<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# Portfolio Perusahaan - Laravel Project

Proyek web portfolio perusahaan berbasis framework **Laravel**. Panduan ini berisi langkah-langkah untuk mengunduh (*clone*) dan menjalankan proyek ini di lingkungan lokal (*local machine*).

---

## 🚀 Panduan Installasi & Penyiapan Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di komputer lokal kamu:

### 1. Clone Repositori
Buka terminal / Git Bash, lalu jalankan perintah berikut untuk mengunduh proyek:

```bash
git clone https://github.com/Muhammad-R-Dev/Portfolio-Perusahaan.git
```

### 2. Masuk ke Folder Proyek
Pindah ke dalam direktori proyek hasil *clone*:

```bash
cd Portfolio-Perusahaan
```

---

## 🛠️ Langkah Penyiapan Laravel

Karena folder `vendor`, file `.env`, dan *symlink storage* tidak diikutsertakan dalam repositori, lakukan konfigurasi awal dengan urutan berikut:

### 1. Install Dependensi PHP (Folder `vendor`)
Unduh semua paket dan pustaka pendukung Laravel:

```bash
composer install
```

### 2. Buat File `.env`
Salin file templat konfigurasi `.env.example` menjadi `.env`:

* **Windows (PowerShell / CMD):**
  ```powershell
  copy .env.example .env
  ```
* **Linux / macOS / Git Bash:**
  ```bash
  cp .env.example .env
  ```

### 3. Generate Application Key
Buat enkripsi kunci aplikasi Laravel:

```bash
php artisan key:generate
```

### 4. Hubungkan Folder Storage (*Symlink*)
Hubungkan folder penyimpanan gambar `storage/app/public` ke folder `public/storage` agar aset gambar dapat diakses dari browser:

```bash
php artisan storage:link
```

### 5. Install & Build Dependency Frontend (Opsional/Jika Diperlukan)
Jika kamu menggunakan Vite/Mix untuk mengompilasi aset CSS dan JavaScript:

```bash
npm install
npm run dev
```

---

## 🏃‍♂️ Menjalankan Server Lokal

Setelah semua konfigurasi selesai, jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Akses aplikasi melalui browser di tautan berikut:  
`http://127.0.0.1:8000`

---

## 📝 Catatan Tambahan
* Pastikan kamu sudah menyalakan service **MySQL** (misalnya lewat XAMPP) dan menyesuaikan nama database pada file `.env` di baris `DB_DATABASE=nama_database_kamu`.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
