<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pelanggan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $hariIni = Carbon::today();
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Laporan Pesanan
        $pesananHariIni = Pesanan::whereDate('created_at', $hariIni)->count();
        $pesananSelesai = Pesanan::where('status', 'Selesai')->count();
        $pesananDiproses = Pesanan::where('status', '!=', 'Selesai')->where('status', '!=', 'Menunggu Konfirmasi')->count();

        // Laporan Pelanggan
        $pelangganBaru = Pelanggan::whereMonth('created_at', $bulanIni)
                                  ->whereYear('created_at', $tahunIni)
                                  ->count();
        $pelangganAktif = Pelanggan::has('pesanans')->count(); // Assuming 'pesanans' relation exists in Pelanggan model, but we can do distinct count from pesanan
        // Alternatively, using distinct id_pelanggan in pesanans table
        $pelangganAktif = Pesanan::distinct('id_pelanggan')->count('id_pelanggan');

        $totalPelanggan = Pelanggan::count();
        $retensi = $totalPelanggan > 0 ? round(($pelangganAktif / $totalPelanggan) * 100) : 0;

        // Laporan Pendapatan
        $pendapatanHariIni = Pesanan::whereDate('created_at', $hariIni)->sum('harga');
        $pendapatanBulanIni = Pesanan::whereMonth('created_at', $bulanIni)
                                     ->whereYear('created_at', $tahunIni)
                                     ->sum('harga');
        
        $totalPendapatan = Pesanan::sum('harga');
        $totalTransaksi = Pesanan::count();
        $rataRataTransaksi = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Laporan Layanan
        // Assuming 'kategori' holds the service name or 'id_layanan'
        $layananPopulerRecord = Pesanan::select('kategori', DB::raw('count(*) as total'))
                                       ->groupBy('kategori')
                                       ->orderByDesc('total')
                                       ->first();
        
        $layananPopuler = $layananPopulerRecord ? $layananPopulerRecord->kategori : '-';
        $permintaanTertinggi = $layananPopulerRecord ? $layananPopulerRecord->total : 0;
        $rasioPesanan = $totalTransaksi > 0 ? round(($permintaanTertinggi / $totalTransaksi) * 100) : 0;

        return view('laporan', compact(
            'pesananHariIni',
            'pesananSelesai',
            'pesananDiproses',
            'pelangganBaru',
            'pelangganAktif',
            'retensi',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'rataRataTransaksi',
            'layananPopuler',
            'permintaanTertinggi',
            'rasioPesanan'
        ));
    }
}
