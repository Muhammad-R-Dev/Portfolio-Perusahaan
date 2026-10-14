<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('teams', 'sosial_media')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->string('sosial_media')->nullable()->after('jabatan');
            });
        }

        if (Schema::hasColumn('teams', 'divisi')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropColumn('divisi');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('teams', 'divisi')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->string('divisi', 100)->default('')->after('jabatan');
            });
        }

        if (Schema::hasColumn('teams', 'sosial_media')) {
            Schema::table('teams', function (Blueprint $table) {
                $table->dropColumn('sosial_media');
            });
        }
    }
};