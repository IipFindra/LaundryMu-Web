<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'judul',
        'pesan',
        'tipe',
        'ikon',
        'warna',
        'link',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];
}
