<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama',
        'tipe',
        'waktu',
        'harga',
        'deskripsi',
        'status',
        'ikon',
        'warna_ikon',
        'warna_tipe'
    ];
}
