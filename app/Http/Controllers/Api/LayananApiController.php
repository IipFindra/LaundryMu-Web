<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\JsonResponse;

class LayananApiController extends Controller
{
    /**
     * Menampilkan daftar layanan yang aktif untuk Flutter Mobile App
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $layanans = Layanan::select(
                'id_layanan',
                'nama',
                'tipe',
                'waktu',
                'harga',
                'deskripsi',
                'ikon',
                'warna_ikon',
                'warna_tipe'
            )
            ->where('status', 'Aktif')
            ->orderBy('id_layanan', 'asc')
            ->get()
            ->map(function ($layanan) {
                return [
                    'id_layanan' => $layanan->id_layanan,
                    'nama'       => $layanan->nama ?? '',
                    'tipe'       => $layanan->tipe ?? '',
                    'waktu'      => $layanan->waktu ?? '',
                    'harga'      => (int) ($layanan->harga ?? 0),
                    'deskripsi'  => $layanan->deskripsi ?? '',
                    'ikon'       => $layanan->ikon ?? 'local_laundry_service',
                    'warna_ikon' => $layanan->warna_ikon ?? 'bg-blue-100 text-blue-500',
                    'warna_tipe' => $layanan->warna_tipe ?? 'bg-blue-100 text-blue-700',
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengambil data layanan',
                'data'    => $layanans,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data layanan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
