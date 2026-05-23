<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // =========================
    // LOGIN ADMIN WEB
    // =========================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()
                ->route('dashboard')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // =========================
    // LOGIN MOBILE FLUTTER
    // =========================
   public function loginMobile(Request $request)
    {
        $nomor = $request->no_telepon ?? $request->phone;

        if (!$nomor) {
            return response()->json([
                'success' => false,
                'message' => 'no_telepon is required'
            ], 400);
        }

        // CEK PELANGGAN
        $pelanggan = DB::table('pelanggan')
            ->where('no_telepon', $nomor)
            ->first();

        // JIKA SUDAH ADA
        if ($pelanggan) {
            return response()->json([
                'success' => true,
                'is_new_user' => false,
                'access_token' => 'dummy_token',
                'data' => $pelanggan,
            ]);
        }

        // JIKA BELUM ADA
        $id = DB::table('pelanggan')
            ->insertGetId([
                'nama_lengkap' => '',
                'no_telepon' => $nomor,
                'alamat' => '',
                'otp_code' => null,
                'otp_expires_at' => null,
                'created_at' => now(),
            ], 'id_pelanggan');

        $pelangganBaru = DB::table('pelanggan')
            ->where('id_pelanggan', $id)
            ->first();

        return response()->json([
            'success' => true,
            'is_new_user' => true,
            'access_token' => 'dummy_token',
            'data' => $pelangganBaru,
        ]);
    }

    // =========================
    // COMPLETE PROFILE FLUTTER
    // =========================
    public function completeProfile(Request $request)
    {
        $nomor = $request->no_telepon ?? $request->phone;

        if (!$nomor) {
            return response()->json([
                'success' => false,
                'message' => 'no_telepon is required'
            ], 400);
        }

        $pelanggan = DB::table('pelanggan')
            ->where('no_telepon', $nomor)
            ->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Pelanggan tidak ditemukan'
            ], 404);
        }

        $namaLengkap = $request->input('nama_lengkap', '');
        $alamat = $request->input('alamat', '');

        DB::table('pelanggan')
            ->where('no_telepon', $nomor)
            ->update([
                'nama_lengkap' => $namaLengkap,
                'alamat' => $alamat,
            ]);

        $updatedPelanggan = DB::table('pelanggan')
            ->where('no_telepon', $nomor)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $updatedPelanggan,
        ]);
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}