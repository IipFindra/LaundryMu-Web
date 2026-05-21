<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Notification;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $notifikasi = Notification::orderBy('created_at', 'desc')->take(10)->get();
        // MENGGANTI 'dibaca' MENJADI 'status_baca'
        $unreadNotif = Notification::where('status_baca', false)->count();

        $pesan = Message::orderBy('created_at', 'desc')->take(10)->get();
        $unreadPesan = Message::where('dibaca', false)->count();

        return view('dashboard', compact('notifikasi', 'unreadNotif', 'pesan', 'unreadPesan'));
    }

    /**
     * Global Quick Search — mencari pesanan berdasarkan ID/nota, nama pelanggan, atau kategori
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $pesanan = Pesanan::where('nama_pelanggan', 'LIKE', "%{$query}%")
            ->orWhere('id', 'LIKE', "%{$query}%")
            ->orWhere('kategori', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'nota' => 'L-' . str_pad($p->id, 3, '0', STR_PAD_LEFT),
                    'nama_pelanggan' => $p->nama_pelanggan,
                    'kategori' => $p->kategori,
                    'status' => $p->status,
                    'harga' => 'Rp ' . number_format($p->harga, 0, ',', '.'),
                    'tanggal' => $p->tanggal ? $p->tanggal->format('d/m/Y') : '-', 
                ];
            });

        return response()->json($pesanan);
    }

    /**
     * Tandai notifikasi sebagai dibaca
     */
    public function markNotifRead(Request $request)
    {
        // MENGGANTI 'dibaca' MENJADI 'status_baca' DI SELURUH BLOK NOTIFIKASI
        if ($request->has('id')) {
            Notification::where('id', $request->id)->update(['status_baca' => true]);
        } else {
            Notification::where('status_baca', false)->update(['status_baca' => true]);
        }

        return response()->json(['success' => true, 'unread' => Notification::where('status_baca', false)->count()]);
    }

    /**
     * Tandai pesan sebagai dibaca
     */
    public function markMessageRead(Request $request)
    {
        if ($request->has('id')) {
            Message::where('id', $request->id)->update(['dibaca' => true]);
        } else {
            Message::where('dibaca', false)->update(['dibaca' => true]);
        }

        return response()->json(['success' => true, 'unread' => Message::where('dibaca', false)->count()]);
    }

    /**
     * Get notifikasi terbaru (untuk polling)
     */
    public function getNotifications()
    {
        $notifikasi = Notification::orderBy('created_at', 'desc')->take(10)->get();
        // MENGGANTI 'dibaca' MENJADI 'status_baca'
        $unread = Notification::where('status_baca', false)->count();

        return response()->json(['notifikasi' => $notifikasi, 'unread' => $unread]);
    }

    /**
     * Get pesan terbaru (untuk polling)
     */
    public function getMessages()
    {
        $pesan = Message::orderBy('created_at', 'desc')->take(10)->get();
        $unread = Message::where('dibaca', false)->count();

        return response()->json(['pesan' => $pesan, 'unread' => $unread]);
    }
}