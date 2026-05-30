<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $layanans = Layanan::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->get();

        $totalLayanan = Layanan::count();

        $layananAktif = Layanan::where('status', 'Aktif')->count();

        $rataHarga = Layanan::avg('harga');

        $layananPremium = Layanan::where('ikon', 'workspace_premium')->count();

        // Ambil 5 aktivitas terbaru berdasarkan updated_at
        $aktivitas = Layanan::orderBy('updated_at', 'desc')->take(5)->get();

        // Ambil 3 layanan terpopuler berdasarkan data pesanan
        $kategoriPopuler = \App\Models\Pesanan::selectRaw('kategori, count(*) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->take(3)
            ->get();
            
        $layananPopuler = collect();
        foreach ($kategoriPopuler as $kp) {
            $layanan = Layanan::where('nama', $kp->kategori)->first();
            if ($layanan) {
                $layanan->total_pesanan = $kp->total;
                $layananPopuler->push($layanan);
            }
        }

        // Fallback jika kurang dari 3
        if ($layananPopuler->count() < 3) {
             $existingNames = $layananPopuler->pluck('nama')->toArray();
             $tambah = Layanan::whereNotIn('nama', $existingNames)->take(3 - $layananPopuler->count())->get();
             foreach ($tambah as $t) {
                 $t->total_pesanan = 0;
                 $layananPopuler->push($t);
             }
        }

        return view('layanan', compact(
            'layanans',
            'totalLayanan',
            'layananAktif',
            'rataHarga',
            'layananPremium',
            'aktivitas',
            'layananPopuler'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Segera Hadir',
            'kategori_ikon' => 'required|string',
        ]);

        $this->mapIcon($validated, $request->input('kategori_ikon'));

        $layanan = Layanan::create($validated);

        return redirect()->route('layanan')->with('success', 'Layanan berhasil ditambahkan.')
            ->with('aktivitas_baru', 'Layanan "' . $layanan->nama . '" berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Aktif,Tidak Aktif,Segera Hadir',
            'kategori_ikon' => 'required|string',
        ]);

        $this->mapIcon($validated, $request->input('kategori_ikon'));

        $layanan->update($validated);

        return redirect()->route('layanan')->with('success', 'Layanan berhasil diperbarui.')
            ->with('aktivitas_baru', 'Layanan "' . $layanan->nama . '" berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $namaLayanan = $layanan->nama;
        $layanan->delete();

        return redirect()->route('layanan')->with('success', 'Layanan berhasil dihapus.')
            ->with('aktivitas_baru', 'Layanan "' . $namaLayanan . '" berhasil dihapus.');
    }

    private function mapIcon(&$validated, $kategori)
    {
        if($kategori == 'Cuci + Setrika') {
            $validated['ikon'] = 'checkroom';
            $validated['warna_ikon'] = 'bg-green-100 text-green-500 border-2 border-green-200';
            $validated['warna_tipe'] = 'bg-green-100 text-green-700';
        } elseif($kategori == 'Cuci Express') {
            $validated['ikon'] = 'bolt';
            $validated['warna_ikon'] = 'bg-orange-100 text-orange-500 border-2 border-orange-200';
            $validated['warna_tipe'] = 'bg-orange-100 text-orange-700';
        } elseif($kategori == 'Premium') {
            $validated['ikon'] = 'workspace_premium';
            $validated['warna_ikon'] = 'bg-purple-100 text-purple-500 border-2 border-purple-200';
            $validated['warna_tipe'] = 'bg-purple-100 text-purple-700';
        } elseif($kategori == 'Setrika Saja') {
            $validated['ikon'] = 'iron';
            $validated['warna_ikon'] = 'bg-pink-100 text-pink-500 border-2 border-pink-200';
            $validated['warna_tipe'] = 'bg-pink-100 text-pink-700';
        } elseif($kategori == 'Cuci Super Fast') {
            $validated['ikon'] = 'rocket_launch';
            $validated['warna_ikon'] = 'bg-red-100 text-red-500 border-2 border-red-200';
            $validated['warna_tipe'] = 'bg-red-100 text-red-700';
        } elseif($kategori == 'Cuci Sensitif') {
            $validated['ikon'] = 'child_care';
            $validated['warna_ikon'] = 'bg-teal-100 text-teal-500 border-2 border-teal-200';
            $validated['warna_tipe'] = 'bg-teal-100 text-teal-700';
        } else {
            // Default: Cuci Kering / Biasa
            $validated['ikon'] = 'local_laundry_service';
            $validated['warna_ikon'] = 'bg-[#eaf4fb] text-[#2d3e90] border-2 border-blue-100';
            $validated['warna_tipe'] = 'bg-[#eaf4fb] text-[#2d3e90]';
        }
    }
}
