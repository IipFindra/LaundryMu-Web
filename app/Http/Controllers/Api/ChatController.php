<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChatController extends Controller
{
    /**
     * GET /api/chat/get?id_pelanggan={id}
     * Ambil seluruh pesan percakapan berdasarkan id_pelanggan
     */
    public function getMessages(Request $request)
    {
        $id_pelanggan = $request->query('id_pelanggan');

        $route = $request->route();
        $middlewares = $route ? $route->gatherMiddleware() : [];

        Log::info('CHAT GET REQUEST', [
            'id_pelanggan' => $id_pelanggan,
            'ip'           => $request->ip(),
            'middlewares'  => $middlewares,
        ]);

        if (empty($id_pelanggan)) {
            return response()->json([
                'success' => false,
                'message' => 'id_pelanggan tidak boleh kosong',
            ], 400);
        }

        try {
            $messages = DB::table('messages')
                ->where('id_pelanggan', $id_pelanggan)
                ->whereIn('tipe', ['chat_pelanggan', 'chat_admin'])
                ->orderBy('created_at', 'asc')
                ->get(['id', 'pesan', 'tipe', 'nama_pengirim', 'dibaca', 'created_at'])
                ->map(function ($msg) {
                    return [
                        'id'            => $msg->id,
                        'pesan'         => $msg->pesan,
                        'tipe'          => $msg->tipe,
                        'is_admin'      => $msg->tipe === 'chat_admin',
                        'nama_pengirim' => $msg->nama_pengirim,
                        'dibaca'        => (bool) $msg->dibaca,
                        'created_at'    => $msg->created_at,
                    ];
                });

            Log::info('CHAT GET SUCCESS', [
                'id_pelanggan' => $id_pelanggan,
                'total_pesan'  => count($messages),
            ]);

            return response()->json(['success' => true, 'data' => $messages]);

        } catch (\Exception $e) {
            Log::error('CHAT GET ERROR', [
                'id_pelanggan' => $id_pelanggan,
                'error'        => $e->getMessage(),
                'trace'        => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat pesan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * POST /api/chat/send
     * Simpan pesan dari pelanggan (Flutter)
     * Body (form-data / x-www-form-urlencoded): id_pelanggan, nama_pengirim, pesan
     */
    public function sendMessage(Request $request)
    {
        // ── LOG: catat seluruh request yang masuk beserta middleware yang dilalui ──
        $route = $request->route();
        $middlewares = $route ? $route->gatherMiddleware() : [];

        Log::info('CHAT SEND REQUEST', [
            'all_input'    => $request->all(),
            'content_type' => $request->header('Content-Type'),
            'method'       => $request->method(),
            'ip'           => $request->ip(),
            'middlewares'  => $middlewares,
        ]);

        try {
            // ── VALIDASI — dikembalikan sebagai JSON, bukan redirect HTML ──
            $validated = $request->validate([
                'id_pelanggan'  => 'required|string',
                'nama_pengirim' => 'required|string',
                'pesan'         => 'required|string',
            ]);

            Log::info('CHAT SEND VALIDATED', $validated);

            // ── INSERT ──
            $insertData = [
                'id_pelanggan'     => $validated['id_pelanggan'],
                'nama_pengirim'    => $validated['nama_pengirim'],
                'email_pengirim'   => '',
                'telepon_pengirim' => '',
                'subjek'           => 'Chat Mobile',
                'pesan'            => $validated['pesan'],
                'tipe'             => 'chat_pelanggan',
                'dibaca'           => false,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            Log::info('CHAT SEND INSERT DATA', $insertData);

            DB::table('messages')->insert($insertData);

            Log::info('CHAT SEND SUCCESS', [
                'id_pelanggan' => $validated['id_pelanggan'],
                'nama'         => $validated['nama_pengirim'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesan berhasil dikirim',
            ]);

        } catch (ValidationException $e) {
            // Validasi gagal → kembalikan JSON bukan 302 redirect
            Log::warning('CHAT SEND VALIDATION FAILED', [
                'errors' => $e->errors(),
                'input'  => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('CHAT SEND ERROR', [
                'error'  => $e->getMessage(),
                'input'  => $request->all(),
                'trace'  => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim pesan',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
