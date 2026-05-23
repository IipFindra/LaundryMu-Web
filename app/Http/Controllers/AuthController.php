<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Handle login for both Web (session) and API (Sanctum token)
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba authenticate user
        if (!Auth::attempt($credentials)) {
            // ─── Response untuk API (Mobile Flutter) ───
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah',
                ], 401);
            }

            // ─── Response untuk Web (Browser) ───
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput();
        }

        $user = Auth::user();

        // ─── API RESPONSE (Mobile Flutter) ───
        if ($request->expectsJson() || $request->is('api/*')) {
            // Buat Sanctum token untuk mobile
            $token = $user->createToken('FlutterApp')->plainTextToken;

            Log::info('Login API berhasil', ['user_id' => $user->id]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]
            ], 200);
        }

        // ─── WEB RESPONSE (Browser) ───
        $request->session()->regenerate();

        Log::info('Login Web berhasil', ['user_id' => $user->id]);

        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Handle register for API / web
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->expectsJson() || $request->is('api/*')) {
            $token = $user->createToken('FlutterApp')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Register berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], 201);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Register berhasil!');
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

    /**
     * Handle logout for both Web and API
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // ─── API LOGOUT (Mobile Flutter) ───
        if ($request->expectsJson() || $request->is('api/*')) {
            $token = $user?->currentAccessToken();
            if ($token instanceof PersonalAccessToken) {
                // Hapus token yang sedang dipakai
                $token->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ], 200);
        }

        // ─── WEB LOGOUT (Browser) ───
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    /**
     * Get current authenticated user (untuk API)
     */
    public function me(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ]
        ], 200);
    }
}