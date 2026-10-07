<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page')->unique();          // beranda | layanan | blog | about | contact
            $table->string('title')->nullable();       // null = pakai teks bawaan halaman
            $table->text('description')->nullable();   // null = pakai teks bawaan halaman

            // Warna per mode. null = pakai warna bawaan website.
            foreach (['light_bg', 'light_title', 'light_desc', 'dark_bg', 'dark_title', 'dark_desc'] as $column) {
                $table->string($column, 7)->nullable();
            }

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_settings');
    }
};
