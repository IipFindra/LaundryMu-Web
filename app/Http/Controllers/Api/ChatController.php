<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages(Request $request)
    {
        $id_pelanggan = $request->query('id_pelanggan');

        if (empty($id_pelanggan)) {
            return response()->json(['success' => false, 'message' => 'ID tidak ditemukan'], 400);
        }

        $messages = DB::table('messages')
                    ->where('id_pelanggan', $id_pelanggan)
                    ->orderBy('created_at', 'asc')
                    ->get(['pesan', 'tipe', 'created_at']);

        return response()->json(['success' => true, 'data' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'id_pelanggan'  => 'required',
            'nama_pengirim' => 'required',
            'pesan'         => 'required',
        ]);

        DB::table('messages')->insert([
            'nama_pengirim'   => $request->nama_pengirim,
            'email_pengirim'  => '',
            'telepon_pengirim'=> '',
            'subjek'          => 'Chat Mobile',
            'pesan'           => $request->pesan,
            'tipe'            => 'chat_pelanggan',
            'id_pelanggan'    => $request->id_pelanggan,
            'id_admin'        => 1,
            'dibaca'          => false,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Pesan berhasil dikirim']);
    }
}
