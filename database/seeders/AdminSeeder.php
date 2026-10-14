<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Membuat / memperbarui akun admin default.
     * Username : admin
     * Password : 12345678
     *
     * updateOrCreate dipakai supaya seeder ini aman dijalankan berkali-kali
     * (tidak akan membuat data duplikat).
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@adminhub.com', // tetap diisi karena kolom email masih ada & unik
                'username' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
