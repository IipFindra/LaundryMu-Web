<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Layanan;
use App\Models\Pesanan;
use App\Models\TrackingLog;

class LaundryController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    //  GET SERVICES
    // ─────────────────────────────────────────────────────────────
    public function getServices()
    {
        $services = Layanan::all();
        return response()->json([
            'success' => true,
            'data'    => $services,
        ]);
    }

    // ─────────────────────────────────────────────────────────────
    //  CREATE ORDER  →  POST /api/orders
    // ─────────────────────────────────────────────────────────────
    public function createOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'tanggal'        => 'required|date',
                'nama_pelanggan' => 'required|string|max:255',
                'kategori'       => 'required|string|max:100',
                'berat'          => 'required|numeric|min:0.1',
                'harga'          => 'required|numeric|min:0',
                'status'         => 'nullable|string|max:100',
                'id_pelanggan'   => 'nullable',
                'id_layanan'     => 'nullable',
            ]);

            // Status default
            $validated['status'] = $validated['status'] ?? 'Menunggu Konfirmasi';

            // ✅ Simpan pesanan ke tabel pesanans
            $pesanan = Pesanan::create($validated);

            // ✅ Insert tracking awal ke tracking_status
            TrackingLog::create([
                'id_pesanan'   => $pesanan->id_pesanans,
                'status'       => 'Menunggu Konfirmasi',
                'keterangan'   => 'Pesanan berhasil dibuat dan menunggu konfirmasi',
                'waktu_update' => now(),
                'id_admin'     => null,
            ]);

            // ✅ Insert notifikasi untuk admin
            \App\Models\Notification::create([
                'judul' => 'Pesanan Baru',
                'isi' => 'Pesanan baru ' . $pesanan->kategori . ' dari ' . $pesanan->nama_pelanggan,
                'status_baca' => false,
                'id_pesanan' => $pesanan->id_pesanans,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data'    => $pesanan,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  GET TRACKING  →  GET /api/tracking/{id_pesanan}
    // ─────────────────────────────────────────────────────────────
    public function getTracking($id)
    {
        try {
            // Cari pesanan menggunakan primary key id_pesanans
            $pesanan = Pesanan::where('id_pesanans', $id)->first();

            if (!$pesanan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan',
                ], 404);
            }

            // Ambil histori tracking, urut waktu_update ASC
            $history = TrackingLog::where('id_pesanan', $id)
                ->orderBy('waktu_update', 'asc')
                ->get();

            // Status aktif dari tracking terbaru (atau dari pesanan.status)
            $latestLog     = $history->last();
            $currentStatus = $latestLog
                ? $latestLog->status
                : ($pesanan->status ?? 'Menunggu Konfirmasi');

            // ─── 7 Langkah tracking ───
            $allSteps = [
                ['index' => 0, 'label' => 'Menunggu Konfirmasi', 'description' => 'Pesanan Anda telah dibuat dan menunggu konfirmasi admin'],
                ['index' => 1, 'label' => 'Dijemput',            'description' => 'Kurir sedang dalam perjalanan menjemput pakaian Anda'],
                ['index' => 2, 'label' => 'Dicuci',              'description' => 'Pakaian Anda sedang dalam proses pencucian'],
                ['index' => 3, 'label' => 'Dikeringkan',         'description' => 'Pakaian Anda sedang dikeringkan'],
                ['index' => 4, 'label' => 'Disetrika',           'description' => 'Pakaian Anda sedang disetrika'],
                ['index' => 5, 'label' => 'Diantar',             'description' => 'Kurir sedang dalam perjalanan mengantarkan pakaian Anda'],
                ['index' => 6, 'label' => 'Selesai',             'description' => 'Pesanan Anda telah selesai dan diterima'],
            ];

            $statusMap = [
                'Menunggu Konfirmasi' => 0,
                'Dijemput'            => 1,
                'Dicuci'              => 2,
                'Dikeringkan'         => 3,
                'Disetrika'           => 4,
                'Diantar'             => 5,
                'Selesai'             => 6,
            ];

            $currentStep = $statusMap[$currentStatus] ?? 0;

            // Index histori berdasarkan status untuk lookup timestamp
            $historyByStatus = $history->keyBy('status');

            // ─── Bangun steps dengan data dari tracking_status ───
            $steps = array_map(function ($step) use ($currentStep, $historyByStatus) {
                $log = $historyByStatus->get($step['label']);

                $step['is_done']    = $step['index'] <= $currentStep;
                $step['is_active']  = $step['index'] === $currentStep;
                $step['time']       = $log ? optional($log->waktu_update)->format('Y-m-d H:i') : null;
                $step['keterangan'] = $log ? $log->keterangan : null;

                return $step;
            }, $allSteps);

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'             => $pesanan->id_pesanans,
                    'nomor_pesanan'  => 'INV-' . $pesanan->tanggal->format('Ymd') . '-' . str_pad($pesanan->id_pesanans, 4, '0', STR_PAD_LEFT),
                    'status'         => $currentStatus,
                    'current_step'   => $currentStep,
                    'steps'          => $steps,
                    'history'        => $history->map(fn ($h) => [
                        'status'       => $h->status,
                        'keterangan'   => $h->keterangan,
                        'waktu_update' => optional($h->waktu_update)->format('Y-m-d H:i'),
                    ]),
                    'pesanan' => [
                        'id'             => $pesanan->id_pesanans,
                        'nomor_pesanan'  => 'INV-' . $pesanan->tanggal->format('Ymd') . '-' . str_pad($pesanan->id_pesanans, 4, '0', STR_PAD_LEFT),
                        'kategori'       => $pesanan->kategori,
                        'berat'          => $pesanan->berat,
                        'harga'          => $pesanan->harga,
                        'nama_pelanggan' => $pesanan->nama_pelanggan,
                        'tanggal'        => optional($pesanan->tanggal)->format('Y-m-d'),
                        'status'         => $pesanan->status,
                    ],
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tracking: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  GET ORDERS BY PELANGGAN  →  GET /api/orders/pelanggan
    // ─────────────────────────────────────────────────────────────
    public function getOrdersByPelanggan(Request $request)
    {
        try {
            $idPelanggan = $request->query('id_pelanggan');

            if (!$idPelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'id_pelanggan is required',
                ], 400);
            }

            $orders = Pesanan::where('id_pelanggan', $idPelanggan)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($p) => [
                    'id_pesanans'    => $p->id_pesanans,
                    'nomor_pesanan'  => 'INV-' . $p->tanggal->format('Ymd') . '-' . str_pad($p->id_pesanans, 4, '0', STR_PAD_LEFT),
                    'tanggal'        => optional($p->tanggal)->format('Y-m-d'),
                    'nama_pelanggan' => $p->nama_pelanggan,
                    'kategori'       => $p->kategori,
                    'berat'          => $p->berat,
                    'harga'          => $p->harga,
                    'status'         => $p->status,
                    'id_pelanggan'   => $p->id_pelanggan,
                    'created_at'     => optional($p->created_at)->format('Y-m-d H:i'),
                ]);

            return response()->json([
                'success' => true,
                'data'    => $orders,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────
    //  GET ORDERS (Protected — untuk web admin)
    // ─────────────────────────────────────────────────────────────
    public function getOrders(Request $request)
    {
        $orders = $request->user()->orders()->with('layanan')->get();
        return response()->json([
            'success' => true,
            'data'    => $orders,
        ]);
    }
}
