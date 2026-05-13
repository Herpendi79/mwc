<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use App\Services\EmailApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Jobs\SendSubmissionEmail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // 1. Cari user di tabel users_iciphe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'We couldn\'t find a user with that email address.');
        }

        // 2. Generate Password 6 Digit yang Kuat (Kombinasi Angka, Huruf, Karakter)
        // Kita gunakan Str::random dan menambahkan karakter khusus secara manual
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $newPassword = substr(str_shuffle($chars), 0, 6);

        try {
            // 3. Update Password di Database
            $user->update([
                'password' => Hash::make($newPassword)
            ]);

            // 4. Ambil data peserta untuk nama
            $peserta = Peserta::where('user_id', $user->id)->first();
            $namaPeserta = $peserta ? $peserta->nama : $user->name;

            // 5. Siapkan Konten Email
            $html = view('emails.reset-password', [
                'nama' => $namaPeserta,
                'newPassword' => $newPassword,
                'email' => $user->email
            ])->render();

            $text = "Hello {$namaPeserta},\n\nYour password has been reset. Your new 6-digit password is: {$newPassword}\n\nPlease login and change your password immediately.\n\nRegards,\nICPIP-HE 2026 Team";

            // 6. Kirim via API Service
            /* EmailApiService::send(
                $user->email,
                'Your New Password - ICPIP-HE 2026',
                $text,
                $html
            ); */

            $emailData = [
                'to'      => $user->email,
                'subject' => 'Registration Email Verification for ICPIP-HE 2026',
                'text'    => $text,
                'html'    => $html,
            ];
            SendSubmissionEmail::dispatch($emailData)->onQueue('conference');
            Log::info("Dispatching Reset Password Job to Queue", [
                'email' => $user->email,
                'queue' => 'conference'
            ]);

            return back()->with('success', 'A new 6-digit password has been sent to your email. Please check your Inbox or Spam folder.');
        } catch (\Exception $e) {
            Log::error('Forgot Password Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to send new password. Please try again later.');
        }
    }
}
