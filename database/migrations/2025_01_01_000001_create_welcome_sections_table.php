<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('welcome_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('PT Astabrata Teknologi');
            $table->string('subtitle')->default('Solusi Digital Terpadu');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('welcome_sections');
    }
};
