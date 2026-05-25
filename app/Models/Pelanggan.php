<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    // Disable updated_at jika kolom tidak ada di database
    const UPDATED_AT = null;

    protected $fillable = [
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'otp_code',
    ];
}
