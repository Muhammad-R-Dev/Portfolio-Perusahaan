<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom kategori sebelumnya ENUM (di SQLite jadi CHECK constraint).
     * Diubah jadi string supaya kategori bisa diketik sendiri. Data lama tetap aman.
     * Laravel 11+ mendukung ->change() langsung (SQLite/MySQL), tanpa doctrine/dbal.
     */
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('kategori', 50)->default('kegiatan')->change();
        });
    }

    public function down(): void
    {
        // Sengaja kosong: mengembalikan ke ENUM akan menolak kategori buatan sendiri.
    }
};
