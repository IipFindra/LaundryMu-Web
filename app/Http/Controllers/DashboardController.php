<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

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
            $chartMonths[] = $date->locale('id')->isoFormat('MMM');
            
            $revenue = Pesanan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('harga');
            $chartRevenue[] = (int) $revenue;
        }

        // Ambil data pendapatan 7 hari terakhir secara dinamis
        $chartDays = [];
        $chartRevenueDaily = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $chartDays[] = $date->locale('id')->isoFormat('D MMM');
            
            $revenue = Pesanan::whereDate('created_at', $date)->sum('harga');
            $chartRevenueDaily[] = (int) $revenue;
        }

        return view('dashboard', compact(
            'notifikasi', 'unreadNotif', 'pesan', 'unreadPesan',
            'totalPesananBaru', 'totalPelanggan', 'totalPendapatan', 'totalPesananSelesai',
            'pesananTerbaru', 'chartMonths', 'chartRevenue', 'chartDays', 'chartRevenueDaily'
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
        // Hanya tampilkan pesan DARI PELANGGAN di inbox admin
        $pesan = Message::where('tipe', 'chat_pelanggan')
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();
        $unread = Message::where('tipe', 'chat_pelanggan')
                    ->where('dibaca', false)
                    ->count();

        return response()->json(['pesan' => $pesan, 'unread' => $unread]);
    }

    /**
     * Get chat history with a customer (diakses oleh web admin)
     */
    public function getChatHistory($id_pelanggan)
    {
        $messages = Message::where('id_pelanggan', $id_pelanggan)
            ->whereIn('tipe', ['chat_pelanggan', 'chat_admin'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'id'       => $msg->id,
                    'sender'   => $msg->nama_pengirim,
                    'message'  => $msg->pesan,
                    'time'     => $msg->created_at->locale('id')->diffForHumans(),
                    'is_admin' => $msg->tipe === 'chat_admin',
                    'dibaca'   => (bool) $msg->dibaca,
                ];
            });

        // Tandai pesan DARI PELANGGAN sebagai terbaca saat admin buka chat
        Message::where('id_pelanggan', $id_pelanggan)
            ->where('tipe', 'chat_pelanggan')
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json($messages);
    }

    /**
     * Send a chat message to a customer (diakses oleh web admin)
     */
    public function sendChatMessage(Request $request)
    {
        try {
            Log::info('ADMIN CHAT REQUEST', $request->all());

            $request->validate([
                'id_pelanggan' => 'required',
                'message'      => 'required|string',
            ]);

            Log::info('ADMIN CHAT CREATE', [
                'id_pelanggan' => $request->id_pelanggan,
                'message' => $request->message,
            ]);

            $msgAdmin = Message::create([
                'id_pelanggan'  => $request->id_pelanggan,
                'id_admin'      => auth()->id() ?? 1,
                'nama_pengirim' => 'Admin',
                'subjek'        => 'Balasan Admin',
                'pesan'         => $request->message,
                'tipe'          => 'chat_admin',
                'dibaca'        => false,
            ]);

            Log::info('ADMIN CHAT SUCCESS', [
                'id' => $msgAdmin->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => [
                    'id'       => $msgAdmin->id,
                    'sender'   => 'Admin',
                    'message'  => $msgAdmin->pesan,
                    'time'     => 'Baru saja',
                    'is_admin' => true,
                    'dibaca'   => false,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('ADMIN CHAT ERROR', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Receive a chat message from a customer
     */
    public function receiveCustomerMessage(Request $request)
    {
        $request->validate([
            'nama_pengirim' => 'required|string',
            'pesan' => 'required|string',
        ]);

        $msgCustomer = Message::create([
            'nama_pengirim' => $request->nama_pengirim,
            'subjek' => 'Pesan dari ' . $request->nama_pengirim,
            'pesan' => $request->pesan,
            'tipe' => 'chat_pelanggan',
            'dibaca' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim ke Admin',
            'data' => $msgCustomer
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