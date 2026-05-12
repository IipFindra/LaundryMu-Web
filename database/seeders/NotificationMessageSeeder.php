<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\Message;

class NotificationMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Notifications
        $notifications = [
            [
                'judul' => 'Pesanan Baru Masuk',
                'pesan' => 'Pesanan baru dari pelanggan Yuski Ramadhan - Cuci Setrika 5kg',
                'tipe' => 'pesanan_baru',
                'ikon' => 'shopping_cart',
                'warna' => 'blue',
                'link' => '/pesanan',
                'dibaca' => false,
                'created_at' => now()->subMinutes(5),
            ],
            [
                'judul' => 'Deadline Mendekat!',
                'pesan' => 'Pesanan #L-003 harus selesai dalam 2 jam lagi (Cuci Express)',
                'tipe' => 'deadline',
                'ikon' => 'schedule',
                'warna' => 'yellow',
                'link' => '/pesanan',
                'dibaca' => false,
                'created_at' => now()->subMinutes(15),
            ],
            [
                'judul' => 'Stok Deterjen Menipis',
                'pesan' => 'Stok deterjen cair tinggal 2 botol. Segera lakukan restok!',
                'tipe' => 'stok_menipis',
                'ikon' => 'inventory',
                'warna' => 'red',
                'link' => null,
                'dibaca' => false,
                'created_at' => now()->subMinutes(30),
            ],
            [
                'judul' => 'Komplain Pelanggan',
                'pesan' => 'Fahmi Syahdan memberikan ulasan bintang 2 - "Cucian masih bau"',
                'tipe' => 'komplain',
                'ikon' => 'report_problem',
                'warna' => 'orange',
                'link' => null,
                'dibaca' => false,
                'created_at' => now()->subHours(1),
            ],
            [
                'judul' => 'Pesanan Baru Masuk',
                'pesan' => 'Pesanan baru dari pelanggan Nadhiefa - Cuci Kering 3kg',
                'tipe' => 'pesanan_baru',
                'ikon' => 'shopping_cart',
                'warna' => 'blue',
                'link' => '/pesanan',
                'dibaca' => true,
                'created_at' => now()->subHours(3),
            ],
            [
                'judul' => 'Stok Parfum Menipis',
                'pesan' => 'Stok parfum laundry tinggal 1 botol. Segera restok!',
                'tipe' => 'stok_menipis',
                'ikon' => 'inventory',
                'warna' => 'red',
                'link' => null,
                'dibaca' => true,
                'created_at' => now()->subHours(5),
            ],
            [
                'judul' => 'Deadline Mendekat!',
                'pesan' => 'Pesanan #L-007 dari Zubaeri Romzi deadline besok pagi',
                'tipe' => 'deadline',
                'ikon' => 'schedule',
                'warna' => 'yellow',
                'link' => '/pesanan',
                'dibaca' => true,
                'created_at' => now()->subHours(8),
            ],
        ];

        foreach ($notifications as $notif) {
            Notification::create($notif);
        }

        // Seed Messages
        $messages = [
            [
                'nama_pengirim' => 'Yuski Ramadhan',
                'email_pengirim' => 'yuski@gmail.com',
                'telepon_pengirim' => '081234567890',
                'subjek' => 'Status Cucian',
                'pesan' => 'Min, cucian saya sudah selesai belum ya? Kemarin baru antar.',
                'tipe' => 'chat_pelanggan',
                'dibaca' => false,
                'created_at' => now()->subMinutes(10),
            ],
            [
                'nama_pengirim' => 'Fahmi Syahdan',
                'email_pengirim' => 'fahmi.s@gmail.com',
                'telepon_pengirim' => '082345678901',
                'subjek' => 'Komplain Baju Luntur',
                'pesan' => 'Baju putih saya jadi kekuningan setelah dicuci. Mohon ditanggapi.',
                'tipe' => 'chat_pelanggan',
                'dibaca' => false,
                'created_at' => now()->subMinutes(25),
            ],
            [
                'nama_pengirim' => 'Sistem',
                'email_pengirim' => null,
                'telepon_pengirim' => null,
                'subjek' => 'Laporan Harian',
                'pesan' => 'Laporan pendapatan harian sudah siap. Total hari ini: Rp 350.000',
                'tipe' => 'sistem',
                'dibaca' => false,
                'created_at' => now()->subHours(1),
            ],
            [
                'nama_pengirim' => 'Nadhiefa',
                'email_pengirim' => 'nadhiefa@gmail.com',
                'telepon_pengirim' => '083456789012',
                'subjek' => 'Tanya Harga Express',
                'pesan' => 'Kak, harga cuci express berapa ya per kilo? Ada promo gak?',
                'tipe' => 'chat_pelanggan',
                'dibaca' => true,
                'created_at' => now()->subHours(4),
            ],
            [
                'nama_pengirim' => 'Zubaeri Romzi',
                'email_pengirim' => 'zubaeri@gmail.com',
                'telepon_pengirim' => '084567890123',
                'subjek' => 'Jadwal Ambil',
                'pesan' => 'Saya mau ambil cucian besok sore ya. Tolong siapkan.',
                'tipe' => 'chat_pelanggan',
                'dibaca' => true,
                'created_at' => now()->subHours(6),
            ],
        ];

        foreach ($messages as $msg) {
            Message::create($msg);
        }
    }
}
