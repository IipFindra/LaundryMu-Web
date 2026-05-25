<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk tabel tracking_status.
 * Diisi otomatis saat order dibuat dan saat admin update status.
 */
class TrackingLog extends Model
{
    protected $table    = 'tracking_status';
    public $timestamps  = false; // pakai waktu_update bukan created_at/updated_at

    protected $fillable = [
        'id_pesanan',
        'status',
        'keterangan',
        'waktu_update',
        'id_admin',
    ];

    protected $casts = [
        'waktu_update' => 'datetime',
    ];

    // ─── Relasi ke Pesanan ───
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanans');
    }
}
