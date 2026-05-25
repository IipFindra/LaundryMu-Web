<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganAuthController extends Controller
{
    public function loginMobile(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'nullable|string',
        ]);

        $phone = $request->input('phone');

        // Find or create customer
        $pelanggan = Pelanggan::where('no_telepon', $phone)->first();
        
        $isNewUser = false;
        if (!$pelanggan) {
            $isNewUser = true;
            // Create a new customer with a placeholder name
            $pelanggan = Pelanggan::create([
                'nama_lengkap' => 'Pelanggan Baru',
                'no_telepon' => $phone,
                'alamat' => null,
            ]);
        } else {
            // If the name is still 'Pelanggan Baru' or address is empty, consider them as new user to complete data
            if (empty($pelanggan->alamat) || $pelanggan->nama_lengkap === 'Pelanggan Baru') {
                $isNewUser = true;
            }
        }

        // Token sederhana tanpa Sanctum (flow OTP Firebase)
        $token = 'mobile_' . $pelanggan->id_pelanggan . '_' . md5($pelanggan->no_telepon . now());

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'is_new_user' => $isNewUser,
            'data' => $pelanggan
        ]);
    }

    public function completeProfile(Request $request)
    {
        $request->validate([
            'no_telepon' => 'required|string',
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $phone = $request->input('no_telepon');
        $name = $request->input('nama_lengkap');
        $address = $request->input('alamat');

        $pelanggan = Pelanggan::where('no_telepon', $phone)->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        $pelanggan->update([
            'nama_lengkap' => $name,
            'alamat' => $address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $pelanggan
        ]);
    }
}
