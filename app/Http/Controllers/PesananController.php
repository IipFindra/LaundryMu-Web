<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pesanan;
use App\Models\TrackingLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyImage;

class PesananController extends Controller
{
    // ─── Daftar status tracking yang valid (sinkron dengan Flutter) ───
    const TRACKING_STEPS = [
        'Menunggu Konfirmasi',
        'Dijemput',
        'Dicuci',
        'Dikeringkan',
        'Diantar',
        'Selesai',
    ];

    const STATUS_KETERANGAN = [
        'Menunggu Konfirmasi' => 'Pesanan sedang menunggu konfirmasi dari admin',
        'Dijemput'            => 'Kurir sedang dalam perjalanan menjemput pakaian',
        'Dicuci'              => 'Pakaian sedang dalam proses pencucian',
        'Dikeringkan'         => 'Pakaian sedang dalam proses pengeringan',
        'Diantar'             => 'Kurir sedang mengantarkan pakaian ke alamat Anda',
        'Selesai'             => 'Pesanan telah selesai dan diterima pelanggan',
    ];

    // ─────────────────────────────────────────────────────────────
    //  INDEX  →  GET /pesanan
    // ─────────────────────────────────────────────────────────────
    public function index()
    {
        // Eager load pelanggan untuk tampilkan alamat tanpa N+1 query
        $pesanans = Pesanan::with('pelanggan')->orderBy('created_at', 'desc')->get();
        return view('pesanan', compact('pesanans'));
    }

    // ─────────────────────────────────────────────────────────────
    //  EDIT PESANAN (full edit)  →  GET /edit-pesanan/{id}
    // ─────────────────────────────────────────────────────────────
    public function editPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $trackingSteps = self::TRACKING_STEPS;
        return view('edit-pesanan', compact('pesanan', 'trackingSteps'));
    }

    // ─────────────────────────────────────────────────────────────
    //  UPDATE PESANAN (full edit)  →  POST /edit-pesanan/{id}
    // ─────────────────────────────────────────────────────────────
    public function updatePesanan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'tanggal'        => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'kategori'       => 'required|in:Cuci Kering,Cuci Setrika,Cuci Express',
            'berat'          => 'required|string|max:100',
            'harga'          => 'required|numeric|min:0',
            'status'         => 'required|string|max:255',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            if ($pesanan->foto) {
                Storage::disk('public')->delete($pesanan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pesanan', 'public');
        }

        $oldStatus = $pesanan->status;
        $pesanan->update($validated);

        // Jika status berubah → insert TrackingLog agar Flutter sinkron
        if ($oldStatus !== $validated['status']) {
            TrackingLog::create([
                'id_pesanan'   => $pesanan->id_pesanans,
                'status'       => $validated['status'],
                'keterangan'   => self::STATUS_KETERANGAN[$validated['status']] ?? 'Status diperbarui oleh admin',
                'waktu_update' => now(),
                'id_admin'     => auth()->id(),
            ]);
        }

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────────────────────
    //  UPDATE STATUS SAJA  →  POST /pesanan/{id}/update-status
    //  Khusus untuk sinkron tracking Flutter
    // ─────────────────────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:' . implode(',', self::TRACKING_STEPS),
        ]);

        $newStatus = $request->status;
        $oldStatus = $pesanan->status;

        // Update status di tabel pesanans
        $pesanan->update(['status' => $newStatus]);

        // Insert ke tracking_logs agar Flutter tracking realtime
        TrackingLog::create([
            'id_pesanan'   => $pesanan->id_pesanans,
            'status'       => $newStatus,
            'keterangan'   => self::STATUS_KETERANGAN[$newStatus] ?? 'Status diperbarui oleh admin',
            'waktu_update' => now(),
            'id_admin'     => auth()->id(),
        ]);

        return redirect()
            ->route('pesanan')
            ->with('success', "Status pesanan #" . $pesanan->id_pesanans . " berhasil diubah menjadi: {$newStatus}");
    }

    // ─────────────────────────────────────────────────────────────
    //  GENERATE STRUK
    // ─────────────────────────────────────────────────────────────
    public function generateStruk($id, $format = 'pdf')
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('struk', compact('pesanan'));
            return $pdf->download('struk_pesanan_' . $pesanan->id_pesanans . '.pdf');
        } elseif ($format === 'png') {
            try {
                $snappy = SnappyImage::loadView('struk', compact('pesanan'));
                return $snappy->download('struk_pesanan_' . $pesanan->id_pesanans . '.png');
            } catch (\Exception $e) {
                $pdf = Pdf::loadView('struk', compact('pesanan'));
                return $pdf->download('struk_pesanan_' . $pesanan->id_pesanans . '.pdf');
            }
        }

        abort(404);
    }
}
