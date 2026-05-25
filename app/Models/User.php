<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // ✅ 1. TAMBAHKAN IMPORT INI

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    // ✅ 2. TAMBAHKAN HasApiTokens DI SINI
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Beritahu Laravel untuk membaca tabel 'admin' (atau 'admins') di Supabase,
     * bukan mencari tabel 'users'.
     */
    protected $table = 'admin'; // <--- TAMBAHKAN BARIS INI (Sesuaikan jika nama tabel Anda 'admins')
    protected $primaryKey = 'id_admin';


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}