<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Peserta; // Sesuaikan dengan model peserta Anda
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menangani callback dari Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Jika user ada tapi belum punya google_id, update datanya
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }

                Auth::login($user);
                return redirect()->intended('participants'); // Arahkan ke dashboard peserta

            } else {
                // Logic jika user belum terdaftar (Registrasi Otomatis)
                // Catatan: Anda mungkin ingin mengarahkan ke halaman lengkapi data 
                // karena pendaftaran ICPIP-HE membutuhkan "Kategori" peserta.

                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)), // Password acak
                    'email_verified_at' => now(),
                ]);

                // Opsional: Buat record di tabel Peserta jika diperlukan
                Peserta::create([
                    'user_id' => $newUser->id,
                    'nama' => $googleUser->name,
                    'status' => 'waiting', // Status default
                ]);

                Auth::login($newUser);
                return redirect()->route('participants.index')->with('success', 'Logged in with Google successfully!');
            }
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Something went wrong or login canceled.');
        }
    }
}
