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
        // 1. Validasi Input (Ubah label agar sesuai bahwa field ini bisa email atau telepon)
        $validator = Validator::make($request->all(), [
            'email'    => 'required', // Bisa berupa email atau nomor telepon
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loginInput = $request->input('email'); // Input dari form bernama 'email'
        $password   = $request->input('password');
        $credentials = $request->only('email', 'password');

        // 2. Cari user berdasarkan Email (di tabel users) ATAU Telepon (di tabel anggota melalui relasi)
        $user = \App\Models\User::where('email', $loginInput)
            ->orWhereHas('anggota', function ($query) use ($loginInput) {
                $query->where('telpon', $loginInput);
            })
            ->first();

        if ($user->anggota && $user->anggota->status === 'menunggu validasi') {
            return redirect()->back()
                ->with('error', 'Akun Anda sedang menunggu verifikasi dari Admin. Mohon tunggu informasi selanjutnya.')
                ->withInput($request->only('email'));
        }

        if ($user->anggota && $user->anggota->status === 'non aktif') {
            return redirect()->back()
                ->with('error', 'Akun Anda sedang dinonaktifkan Admin. Mohon segera hubungi Admin.')
                ->withInput($request->only('email'));
        }

        // 3. Cek apakah user ditemukan dan passwordnya cocok
        if ($user && \Illuminate\Support\Facades\Hash::check($password, $user->password)) {

            // Cek apakah email/akun sudah diverifikasi oleh admin
            if (!$user->email_verified_at) {
                return redirect()->back()
                    ->with('error', 'Akun Anda sedang menunggu verifikasi dari Admin. Mohon tunggu informasi selanjutnya.')
                    ->withInput($request->only('email'));
            }

            // Lakukan login manual menggunakan instance user yang ditemukan
            Auth::login($user, $request->filled('remember'));

            // 4. Proses Redirect setelah sukses
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                return redirect()->intended('/admin')
                    ->with('success', 'Welcome back, Admin!');
            }

            return redirect()->intended('/anggota')
                ->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Mengembalikan user ke halaman terakhir yang ingin diakses
            return redirect()->intended('/admin/dashboard');
        }

        // 5. Jika gagal login (kredensial salah)
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
