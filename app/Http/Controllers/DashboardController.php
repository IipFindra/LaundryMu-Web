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

        // Statistik Dinamis
        $totalPesananBaru = Pesanan::where('status', '!=', 'Selesai')->count();
        $totalPelanggan = Pesanan::distinct('nama_pelanggan')->count('nama_pelanggan');
        $totalPendapatan = Pesanan::sum('harga');
        $totalPesananSelesai = Pesanan::where('status', 'Selesai')->count();

        // Pesanan Terbaru (ambil 5 pesanan terakhir)
        $pesananTerbaru = Pesanan::orderBy('created_at', 'desc')->take(5)->get();

        // Ambil data pendapatan 7 bulan terakhir secara dinamis
        $chartMonths = [];
        $chartRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $chartMonths[] = $date->locale('id')->isoFormat('MMMM');
            
            $revenue = Pesanan::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->sum('harga');
            $chartRevenue[] = (int) $revenue;
        }

        return view('dashboard', compact(
            'notifikasi', 'unreadNotif', 'pesan', 'unreadPesan',
            'totalPesananBaru', 'totalPelanggan', 'totalPendapatan', 'totalPesananSelesai',
            'pesananTerbaru', 'chartMonths', 'chartRevenue'
        ));
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

    /**
     * Get chat history with a customer
     */
    public function getChatHistory($customerName)
    {
        $messages = Message::where('tipe', 'chat_pelanggan')
            ->where(function($query) use ($customerName) {
                $query->where('nama_pengirim', $customerName)
                      ->orWhere('subjek', $customerName);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->nama_pengirim,
                    'message' => $msg->pesan,
                    'time' => $msg->created_at->locale('id')->diffForHumans(),
                    'is_admin' => $msg->nama_pengirim === 'Admin',
                    'dibaca' => (bool) $msg->dibaca,
                ];
            });

        // Mark unread messages from this customer as read
        Message::where('tipe', 'chat_pelanggan')
            ->where('nama_pengirim', $customerName)
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json($messages);
    }

    /**
     * Send a chat message to a customer
     */
    public function sendChatMessage(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'message' => 'required|string',
        ]);

        $msgAdmin = Message::create([
            'nama_pengirim' => 'Admin',
            'subjek' => $request->customer_name,
            'pesan' => $request->message,
            'tipe' => 'chat_pelanggan',
            'dibaca' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msgAdmin->id,
                'sender' => 'Admin',
                'message' => $msgAdmin->pesan,
                'time' => 'Baru saja',
                'is_admin' => true,
                'dibaca' => false,
            ]
        ]);
    }

    /**
     * Edit a chat message
     */
    public function updateChatMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $msg = Message::findOrFail($id);
        
        // Ensure only admin messages can be edited (optional, depending on business logic)
        if ($msg->nama_pengirim === 'Admin') {
            $msg->update(['pesan' => $request->message]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }

    /**
     * Delete a chat message
     */
    public function deleteChatMessage($id)
    {
        $msg = Message::findOrFail($id);
        
        if ($msg->nama_pengirim === 'Admin') {
            $msg->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    }
}