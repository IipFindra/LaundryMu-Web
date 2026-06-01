<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'foto_profile' => $pelanggan->foto_profile,
            'foto_profile_url' => $pelanggan->foto_profile ? asset('storage/' . $pelanggan->foto_profile) : null,

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
            'foto_profile' => $pelanggan->foto_profile,
            'foto_profile_url' => $pelanggan->foto_profile ? asset('storage/' . $pelanggan->foto_profile) : null,

            'data' => $pelanggan
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    // UNTUK EDIT PROFIL DARI FLUTTER
    // ═══════════════════════════════════════════════════════════════

    public function updateProfil(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string',
            'nama'    => 'nullable|string|min:2|max:100',
            'alamat'  => 'nullable|string',
            'foto_profile' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $userId = $request->input('user_id');

        // Cari berdasarkan primary key "id_pelanggan"
        $pelanggan = Pelanggan::where('id_pelanggan', $userId)->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        // Update nama dan alamat jika ada
        if ($request->filled('nama')) {
            $pelanggan->nama_lengkap = $request->input('nama');
        }
        if ($request->filled('alamat')) {
            $pelanggan->alamat = $request->input('alamat');
        }

        // Update foto jika ada
        if ($request->hasFile('foto_profile')) {
            // Hapus foto lama jika ada
            if ($pelanggan->foto_profile && Storage::disk('public')->exists($pelanggan->foto_profile)) {
                Storage::disk('public')->delete($pelanggan->foto_profile);
            }
            // Simpan foto baru
            $pelanggan->foto_profile = $request->file('foto_profile')->store('profile-photos', 'public');
        }

        $pelanggan->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $pelanggan,
            'foto_profile_url' => $pelanggan->foto_profile ? asset('storage/' . $pelanggan->foto_profile) : null,
        ]);
    }
}
