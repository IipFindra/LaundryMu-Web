<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'id_pelanggan',
        'id_admin',
        'nama_pengirim',
        'email_pengirim',
        'telepon_pengirim',
        'subjek',
        'pesan',
        'tipe',
        'dibaca',
    ];

    protected $casts = [
        'dibaca' => 'boolean',
    ];
}
