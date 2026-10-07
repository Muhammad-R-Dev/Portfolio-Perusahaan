<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** kolom => warna bawaan */
    private array $columns = [
        'navbar_bg_light'   => '#094356',
        'navbar_text_light' => '#ffffff',
        'navbar_bg_dark'    => '#094356',
        'navbar_text_dark'  => '#ffffff',
        'footer_bg_light'   => '#094356',
        'footer_text_light' => '#ffffff',
        'footer_bg_dark'    => '#1c2842',
        'footer_text_dark'  => '#ffffff',
    ];

    public function up(): void
    {
        // Hanya menambah kolom yang belum ada (aman dijalankan di database yang sudah berisi data,
        // dan tidak bentrok kalau kolom sudah dibuat lewat migration create_site_settings_table).
        Schema::table('site_settings', function (Blueprint $table) {
            foreach ($this->columns as $name => $default) {
                if (!Schema::hasColumn('site_settings', $name)) {
                    $table->string($name, 7)->nullable()->default($default);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            array_keys($this->columns),
            fn ($name) => Schema::hasColumn('site_settings', $name)
        ));

        if ($existing) {
            Schema::table('site_settings', function (Blueprint $table) use ($existing) {
                $table->dropColumn($existing);
            });
        }
    }
};
