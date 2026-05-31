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
        // BUKTI: Kunci utamanya adalah id_pelanggan, bukan id
        $token = 'mobile_' . $pelanggan->id_pelanggan . '_' . md5($pelanggan->no_telepon . now());

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'is_new_user' => $isNewUser,

            // PERBAIKAN SEBENARNYA: Pakai id_pelanggan, BUKAN id
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'nama'         => $pelanggan->nama_lengkap,
            'telepon'      => $pelanggan->no_telepon,
            'alamat'       => $pelanggan->alamat,

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

        // Update data pelanggan
        $pelanggan->nama_lengkap = $name;
        $pelanggan->alamat = $address;
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',

            // PERBAIKAN SEBENARNYA: Pakai id_pelanggan, BUKAN id
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'nama'         => $pelanggan->nama_lengkap,
            'telepon'      => $pelanggan->no_telepon,
            'alamat'       => $pelanggan->alamat,

            'data' => $pelanggan
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // UNTUK EDIT NAMA DARI FLUTTER
    // ═══════════════════════════════════════════════════════════════

    public function updateNama(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'nama'    => 'required|string|min:2|max:100',
        ]);

        $userId = $request->input('user_id');
        $nama   = $request->input('nama');

        // Cari berdasarkan primary key "id_pelanggan"
        $pelanggan = Pelanggan::where('id_pelanggan', $userId)->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        // Update nama
        $pelanggan->nama_lengkap = $nama;
        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Nama berhasil diubah',
            'data' => [
                'id'   => $pelanggan->id_pelanggan,
                'nama' => $pelanggan->nama_lengkap,
            ]
        ]);
    }
}
