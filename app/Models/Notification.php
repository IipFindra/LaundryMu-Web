<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Notification extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'pelanggan_id', 'id_pesanan', 'judul', 'isi', 'status_baca', 'id_admin'
    ];

    protected $casts = [
        'status_baca' => 'boolean',
    ];

    /**
     * Memaksa Query SQL 'dibaca' beralih ke 'status_baca'
     */
    protected static function booted()
    {
        static::addGlobalScope('translateDibacaColumn', function (Builder $builder) {
            $query = $builder->getQuery();
            if (isset($query->wheres)) {
                foreach ($query->wheres as &$where) {
                    if (isset($where['column']) && $where['column'] === 'dibaca') {
                        $where['column'] = 'status_baca';
                    }
                }
            }
        });
    }
}