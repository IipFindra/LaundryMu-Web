<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pesanan;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pesanan::create([
            'tanggal' => '2026-04-02',
            'nama_pelanggan' => 'Yuski Ramadhan',
            'kategori' => 'Cuci Setrika',
            'berat' => '2 KG',
            'harga' => 10000,
            'status' => 'Sedang dalam proses',
        ]);

        Pesanan::create([
            'tanggal' => '2026-04-02',
            'nama_pelanggan' => 'Fahmi Syahdan',
            'kategori' => 'Cuci Kering',
            'berat' => '4 KG',
            'harga' => 16000,
            'status' => 'Proses',
        ]);

        Pesanan::create([
            'tanggal' => '2026-03-28',
            'nama_pelanggan' => 'Zubaeri Romzi',
            'kategori' => 'Cuci Kering',
            'berat' => '1 KG',
            'harga' => 4000,
            'status' => 'Kurir dalam perjalanan',
        ]);

        Pesanan::create([
            'tanggal' => '2026-03-28',
            'nama_pelanggan' => 'Zubaeri Romzi',
            'kategori' => 'Cuci Express',
            'berat' => '3 Satuan',
            'harga' => 12000,
            'status' => 'Kurir dalam perjalanan',
        ]);

        Pesanan::create([
            'tanggal' => '2026-03-28',
            'nama_pelanggan' => 'Nadhiefa',
            'kategori' => 'Cuci Setrika',
            'berat' => '5 KG',
            'harga' => 20000,
            'status' => 'Proses',
        ]);

        Pesanan::create([
            'tanggal' => '2026-03-23',
            'nama_pelanggan' => 'Nadhiefa',
            'kategori' => 'Cuci Kering',
            'berat' => '1 KG',
            'harga' => 4000,
            'status' => 'Sedang dalam proses',
        ]);
    }
}
