<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    // 1. Beritahu Laravel nama tabel asli di Supabase
    protected $table = 'layanans';

    // 2. Beritahu Laravel nama kolom Primary Key aslinya
    protected $primaryKey = 'id_layanan';

    // 3. Izinkan mass-assignment untuk kolom-kolom ini
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

    /**
     * 4. JEMBATAN PENGAMAN (Accessor)
     * Mengubah panggilan '$layanan->id' di file Blade secara otomatis
     * menjadi mengambil data dari kolom 'id_layanans'.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id_layanan'] ?? null;
    }
}