<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Pelanggan extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

    // Disable updated_at since it doesn't exist in the schema
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

    public function orders()
    {
        return $this->hasMany(Pesanan::class, 'nama_pelanggan', 'nama_lengkap');
    }
}
