<?php
<<<<<<< HEAD

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Pelanggan extends Authenticatable
{
    use HasApiTokens;
=======
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;
>>>>>>> 584ea24f99ca75bbf9d2a854d25f910dd4583c5c

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';

<<<<<<< HEAD
    // Disable updated_at since it doesn't exist in the schema
    const UPDATED_AT = null;

=======
>>>>>>> 584ea24f99ca75bbf9d2a854d25f910dd4583c5c
    protected $fillable = [
        'nama_lengkap',
        'no_telepon',
        'alamat',
        'otp_code',
        'otp_expires_at',
    ];
<<<<<<< HEAD

    protected $hidden = [
        'otp_code',
    ];

    public function orders()
    {
        return $this->hasMany(Pesanan::class, 'nama_pelanggan', 'nama_lengkap');
    }
}
=======
    
    protected $hidden = [
        'otp_code',
    ];
}
>>>>>>> 584ea24f99ca75bbf9d2a854d25f910dd4583c5c
