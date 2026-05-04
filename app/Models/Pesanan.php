<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_pelanggan',
        'kategori',
        'berat',
        'harga',
        'status',
        'foto',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
