<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyImage;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all();
        return view('pesanan', compact('pesanans'));
    }

    public function editPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('edit-pesanan', compact('pesanan'));
    }

    public function updatePesanan(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_pelanggan' => 'required|string|max:255',
            'kategori' => 'required|in:Cuci Kering,Cuci Setrika,Cuci Express',
            'berat' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            if ($pesanan->foto) {
                Storage::disk('public')->delete($pesanan->foto);
            }

            $validated['foto'] = $request->file('foto')->store('pesanan', 'public');
        }

        $pesanan->update($validated);

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil diperbarui.');
    }

    public function generateStruk($id, $format = 'pdf')
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('struk', compact('pesanan'));
            return $pdf->download('struk_pesanan_' . $pesanan->id . '.pdf');
        } elseif ($format === 'png') {
            try {
                $snappy = SnappyImage::loadView('struk', compact('pesanan'));
                return $snappy->download('struk_pesanan_' . $pesanan->id . '.png');
            } catch (\Exception $e) {
                // Fallback to PDF if PNG fails
                $pdf = Pdf::loadView('struk', compact('pesanan'));
                return $pdf->download('struk_pesanan_' . $pesanan->id . '.pdf');
            }
        }

        abort(404);
    }
}
