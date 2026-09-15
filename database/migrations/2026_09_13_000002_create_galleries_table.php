<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->enum('kategori', ['kegiatan', 'fasilitas', 'tim', 'acara'])->default('kegiatan');
            // path relatif di disk 'public', mis: galeri/xxxx.jpg
            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
