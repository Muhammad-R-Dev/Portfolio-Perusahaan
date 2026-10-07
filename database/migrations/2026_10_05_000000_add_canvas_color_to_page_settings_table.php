<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Sesuaikan nama tabel 'page_settings' dengan migration yang sudah ada.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            $table->string('light_canvas', 7)->nullable()->after('light_desc');
            $table->string('dark_canvas', 7)->nullable()->after('dark_desc');
        });
    }

    public function down(): void
    {
        Schema::table('page_settings', function (Blueprint $table) {
            $table->dropColumn(['light_canvas', 'dark_canvas']);
        });
    }
};
