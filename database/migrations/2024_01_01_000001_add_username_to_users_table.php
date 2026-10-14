<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom "username" (unik) ke tabel users bawaan Laravel.
     * Kolom "email" TIDAK dihapus (tetap ada di tabel), hanya sudah
     * tidak dipakai untuk proses login. Ini supaya migration bawaan
     * Laravel lain yang masih mereferensikan kolom email tidak rusak.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
        });
    }
};
