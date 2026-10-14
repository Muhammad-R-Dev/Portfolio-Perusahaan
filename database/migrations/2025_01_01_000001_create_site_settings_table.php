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
        if (Schema::hasTable('site_settings')) {
            return;
        }

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();

            // Branding
            $table->string('brand_name')->nullable();
            $table->string('brand_tagline')->nullable();
            $table->string('logo')->nullable();
            $table->text('footer_description')->nullable();

            // Navbar & footer colours
            $table->string('navbar_bg_light', 7)->nullable();
            $table->string('navbar_text_light', 7)->nullable();
            $table->string('navbar_bg_dark', 7)->nullable();
            $table->string('navbar_text_dark', 7)->nullable();
            $table->string('footer_bg_light', 7)->nullable();
            $table->string('footer_text_light', 7)->nullable();
            $table->string('footer_bg_dark', 7)->nullable();
            $table->string('footer_text_dark', 7)->nullable();

            // Contact / map
            $table->string('wa_number')->nullable();
            $table->string('email')->nullable();
            $table->string('map_link')->nullable();
            $table->string('address_full')->nullable();
            $table->string('address_name')->nullable();

            // Social links
            $table->string('social_instagram')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_github')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_youtube')->nullable();

            // Page-level (per-halaman: beranda, layanan, blog, about, contact, dst)
            $table->string('page')->nullable()->unique();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('caption')->nullable();
            $table->string('bg_image')->nullable();

            // Warna per-halaman (light/dark)
            $table->string('light_bg', 7)->nullable();
            $table->string('light_title', 7)->nullable();
            $table->string('light_desc', 7)->nullable();
            $table->string('light_canvas', 7)->nullable();
            $table->string('dark_bg', 7)->nullable();
            $table->string('dark_title', 7)->nullable();
            $table->string('dark_desc', 7)->nullable();
            $table->string('dark_canvas', 7)->nullable();

            // Login background
            $table->string('login_bg')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};