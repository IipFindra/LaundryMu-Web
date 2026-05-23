<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
