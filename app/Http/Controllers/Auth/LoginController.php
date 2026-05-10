<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman Sign In.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan Anda memiliki view ini
    }

    /**
     * Proses Autentikasi.
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Percobaan Login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 3. Cek apakah email sudah diverifikasi
            if (!$user->hasVerifiedEmail()) {
                // Jika belum verifikasi, arahkan ke halaman instruksi verifikasi
                return redirect()->route('verification.notice');
            }

            // 4. Perbaikan: Redirect ke dashboard peserta (index.blade)
            $request->session()->regenerate();

            if ($user->email === 'reviewericpiphe@gmail.com') {
                return redirect()->intended('/reviewer')
                    ->with('success', 'Welcome back, Reviewer!');
            }

            // Mengarahkan ke route 'peserta.index' atau URL '/peserta'
            return redirect()->intended('/participants')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        // 5. Jika gagal login
        return redirect()->back()
            ->with('error', 'The provided credentials do not match our records.')
            ->withInput($request->only('email'));
    }

    /**
     * Proses Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}
