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

    // Disable updated_at karena kolom tidak ada
    const UPDATED_AT = null;

    protected $fillable = [
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'foto_profile',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'otp_code',
    ];

    public function orders()
    {
        return $this->hasMany(
            Pesanan::class,
            'nama_pelanggan',
            'nama_lengkap'
        );
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function getNamaAttribute()
    {
        return $this->nama_lengkap;
    }
}