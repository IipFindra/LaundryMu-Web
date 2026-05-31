<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileAdminController extends Controller
{
    // ─────────────────────────────────────────────
    //  GET /profile-admin  →  Tampilkan halaman profil
    // ─────────────────────────────────────────────
    public function index()
    {
        $admin = Auth::user();
        return view('profile-admin', compact('admin'));
    }

    // ─────────────────────────────────────────────
    //  POST /profile-admin/update  →  Update nama & email
    // ─────────────────────────────────────────────
    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin,email,' . $admin->id_admin . ',id_admin',
        ], [
            'name.required'  => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah digunakan admin lain.',
        ]);

        $admin->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success_profile', 'Profil berhasil diperbarui.');
    }

    // ─────────────────────────────────────────────
    //  POST /profile-admin/update-password  →  Ubah password
    // ─────────────────────────────────────────────
    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'password_lama'     => 'required|string',
            'password_baru'     => ['required', 'string', 'min:8', 'confirmed'],
            'password_baru_confirmation' => 'required|string',
        ], [
            'password_lama.required'     => 'Password lama tidak boleh kosong.',
            'password_baru.required'     => 'Password baru tidak boleh kosong.',
            'password_baru.min'          => 'Password baru minimal 8 karakter.',
            'password_baru.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password_baru_confirmation.required' => 'Konfirmasi password tidak boleh kosong.',
        ]);

        // Verifikasi password lama
        if (!Hash::check($request->password_lama, $admin->password)) {
            return back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                ->with('tab_aktif', 'password');
        }

        $admin->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success_password', 'Password berhasil diubah.');
    }

    // ─────────────────────────────────────────────
    //  POST /profile-admin/update-photo  →  Upload foto profil
    // ─────────────────────────────────────────────
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profile' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'foto_profile.required' => 'Pilih file foto terlebih dahulu.',
            'foto_profile.image'    => 'File harus berupa gambar.',
            'foto_profile.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto_profile.max'      => 'Ukuran foto maksimal 5 MB.',
        ]);

        $admin = Auth::user();

        // Hapus foto lama jika ada
        if ($admin->foto_profile && Storage::disk('public')->exists($admin->foto_profile)) {
            Storage::disk('public')->delete($admin->foto_profile);
        }

        // Simpan foto baru
        $path = $request->file('foto_profile')->store('profile-photos', 'public');

        $admin->update(['foto_profile' => $path]);

        return back()->with('success_photo', 'Foto profil berhasil diperbarui.');
    }
}
