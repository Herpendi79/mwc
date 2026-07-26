<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use App\Services\EmailApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Jobs\SendSubmissionEmail;
use App\Mail\ResetPasswordMail;
use App\Models\AnggotaModel;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => 'Kolom email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // 1. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Kami tidak menemukan email Anda.');
        }

        try {
            // 2. Ambil data peserta / anggota untuk pengecekan status
            $peserta = AnggotaModel::where('user_id', $user->id)->first();

            if ($peserta) {
                // Cek jika status masih menunggu validasi
                if ($peserta->status === 'menunggu validasi') {
                    return back()->with('error', 'Akun Anda sedang dalam proses moderasi.');
                }

                // Cek jika status non aktif / tidak aktif
                if ($peserta->status === 'non aktif' || $peserta->status === 'tidak aktif') {
                    return back()->with('error', 'Akun Anda sedang dinonaktifkan, segera hubungi admin.');
                }
            }

            // 3. Generate Password 6 Digit Baru
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            $newPassword = substr(str_shuffle($chars), 0, 6);

            // 4. Update Password di Database
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            $namaPeserta = $peserta && !empty($peserta->nama) ? $peserta->nama : $user->name;

            // 5. Kirim Email menggunakan Mailable bawaan (seperti cara sebelumnya yang berhasil)
            // Pastikan Anda sudah membuat Mailable class (misal: ResetPasswordMail atau disesuaikan dengan Mailable yang ada)
            Mail::to($user->email)->send(new ResetPasswordMail($namaPeserta, $newPassword, $user->email));

            Log::info("Email Reset Password Terkirim ke: " . $user->email);

            return back()->with('success', 'Password 6-digit yang baru telah dikirim ke email Anda. Silakan periksa Kotak Masuk (Inbox) atau folder Spam Anda.');
        } catch (\Exception $e) {
            Log::error('Forgot Password Error: ' . $e->getMessage() . ' on line ' . $e->getLine());
            return back()->with('error', 'Gagal mengirimkan password baru. Silakan coba lagi.');
        }
    }
}
