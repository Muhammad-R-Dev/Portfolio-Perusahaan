<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public const MAX_FAQ = 5;

    protected $fillable = [
        'question',
        'answer',
        'order',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
