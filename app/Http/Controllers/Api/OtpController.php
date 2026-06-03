<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OtpController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    /**
     * Generate and send WhatsApp OTP.
     * POST /api/send-otp
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required_without:no_telepon|string',
            'no_telepon' => 'required_without:phone|string',
        ]);

        $phone = $request->input('phone') ?? $request->input('no_telepon');

        try {
            // Find or dynamically create customer (just like PelangganAuthController)
            $pelanggan = Pelanggan::where('no_telepon', $phone)->first();

            if (!$pelanggan) {
                $pelanggan = Pelanggan::create([
                    'nama_lengkap' => 'Pelanggan Baru',
                    'no_telepon' => $phone,
                    'alamat' => null,
                ]);
            }

            // Generate a secure 6-digit OTP
            $otpCode = (string) rand(100000, 999999);
            $otpExpiresAt = now()->addMinutes(5);

            // Save OTP to the customer model
            $pelanggan->otp_code = $otpCode;
            $pelanggan->otp_expires_at = $otpExpiresAt;
            $pelanggan->save();

            // Draft a friendly WhatsApp message
            $message = "*[LaundryMu]*\n\nKode OTP Anda adalah: *{$otpCode}*\n\nKode ini berlaku selama 5 menit. Harap menjaga kerahasiaan kode ini dan jangan membagikannya kepada siapa pun.";

            // Send via Fonnte
            $sendResult = $this->fonnteService->sendMessage($phone, $message);

            if (!$sendResult['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim OTP ke WhatsApp. ' . $sendResult['message'],
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim ke WhatsApp Anda.',
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error in sendOtp: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengirim OTP: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify WhatsApp OTP and establish session.
     * POST /api/verify-otp
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required_without:no_telepon|string',
            'no_telepon' => 'required_without:phone|string',
            'otp' => 'required_without:otp_code|string',
            'otp_code' => 'required_without:otp|string',
        ]);

        $phone = $request->input('phone') ?? $request->input('no_telepon');
        $otp = $request->input('otp') ?? $request->input('otp_code');

        try {
            $pelanggan = Pelanggan::where('no_telepon', $phone)->first();

            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggan tidak ditemukan.',
                ], 404);
            }

            // Verify OTP code match
            if ($pelanggan->otp_code !== $otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP tidak valid.',
                ], 400);
            }

            // Verify OTP expiration
            if (now()->greaterThan($pelanggan->otp_expires_at)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP telah kedaluwarsa. Silakan minta kode baru.',
                ], 400);
            }

            // Security: Clear OTP so it cannot be used again
            $pelanggan->otp_code = null;
            $pelanggan->otp_expires_at = null;
            $pelanggan->save();

            // Establish mobile token session (matches PelangganAuthController pattern)
            $token = 'mobile_' . $pelanggan->id_pelanggan . '_' . md5($pelanggan->no_telepon . now());
            $isNewUser = empty($pelanggan->alamat) || $pelanggan->nama_lengkap === 'Pelanggan Baru';

            return response()->json([
                'success' => true,
                'message' => 'Verifikasi OTP berhasil.',
                'access_token' => $token,
                'is_new_user' => $isNewUser,
                
                // Enriched keys for direct Flutter integration
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'nama' => $pelanggan->nama_lengkap,
                'telepon' => $pelanggan->no_telepon,
                'alamat' => $pelanggan->alamat,
                
                'data' => $pelanggan
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error in verifyOtp: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat memverifikasi OTP: ' . $e->getMessage(),
            ], 500);
        }
    }
}
