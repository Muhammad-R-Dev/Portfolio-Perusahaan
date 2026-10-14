<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aman dijalankan walau table sudah ada (misal di environment lokal
        // yang table-nya sudah terlanjur ada lewat jalur lain).
        if (Schema::hasTable('teams')) {
            return;
        }

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('sosial_media')->nullable();
            $table->string('foto')->nullable();
            $table->string('status')->default('aktif');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
