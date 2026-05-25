<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    // ─── Schema: tabel pesanans, PK = id_pesanans ───
    protected $table      = 'pesanans';
    protected $primaryKey = 'id_pesanans';
    public    $incrementing = true;
    protected $keyType    = 'int';

    protected $fillable = [
        'tanggal',
        'nama_pelanggan',
        'kategori',
        'berat',
        'harga',
        'status',
        'foto',
        'id_pelanggan',
        'id_layanan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // ─── Relasi ke Layanan ───
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'kategori', 'nama');
    }

    // ─── Relasi ke Pelanggan (untuk ambil alamat) ───
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // ─── Relasi ke histori tracking ───
    public function trackingHistory()
    {
        return $this->hasMany(TrackingLog::class, 'id_pesanan', 'id_pesanans')
                    ->orderBy('waktu_update', 'asc');
    }
}
