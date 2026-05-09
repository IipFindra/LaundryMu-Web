<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::all();
        return view('layanan', compact('layanans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'kategori_ikon' => 'required|string',
        ]);

        $this->mapIcon($validated, $request->input('kategori_ikon'));

        Layanan::create($validated);

        return redirect()->route('layanan')->with('success', 'Layanan berhasil ditambahkan.');
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
            'status' => 'required|string|in:Aktif,Tidak Aktif',
            'kategori_ikon' => 'required|string',
        ]);

        $this->mapIcon($validated, $request->input('kategori_ikon'));

        $layanan->update($validated);

        return redirect()->route('layanan')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layanan = Layanan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan')->with('success', 'Layanan berhasil dihapus.');
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
        } else {
            // Default: Cuci Kering / Biasa
            $validated['ikon'] = 'local_laundry_service';
            $validated['warna_ikon'] = 'bg-[#eaf4fb] text-[#2d3e90] border-2 border-blue-100';
            $validated['warna_tipe'] = 'bg-[#eaf4fb] text-[#2d3e90]';
        }
    }
}
