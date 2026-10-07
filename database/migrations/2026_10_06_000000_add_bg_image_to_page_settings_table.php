<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Dicek dulu supaya aman bila kolom sudah ada (misalnya migration terjalan dua kali)
        if (! Schema::hasColumn('page_settings', 'bg_image')) {
            Schema::table('page_settings', function (Blueprint $table) {
                $table->string('bg_image')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('page_settings', 'bg_image')) {
            Schema::table('page_settings', function (Blueprint $table) {
                $table->dropColumn('bg_image');
            });
        }
    }
};