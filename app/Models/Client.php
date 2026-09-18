<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // Tambahkan 'gambar' ke dalam fillable
    protected $fillable = ['nama', 'project', 'deskripsi', 'gambar', 'tanggal_awal', 'deadline'];
}