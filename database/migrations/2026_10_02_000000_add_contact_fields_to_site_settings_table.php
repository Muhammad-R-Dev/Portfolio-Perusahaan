<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('wa_number', 20)->nullable();
            $table->string('map_link', 1000)->nullable();
            $table->text('address_full')->nullable();
            $table->string('address_name')->nullable();

            $table->string('social_youtube')->nullable();
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_github')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'wa_number', 'map_link', 'address_full', 'address_name',
                'social_youtube', 'social_facebook', 'social_instagram',
                'social_linkedin', 'social_twitter', 'social_github',
            ]);
        });
    }
};
