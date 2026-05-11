<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use App\Services\EmailApiService; // Pastikan namespace ini benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // Untuk mengatasi Undefined method 'login'
use App\Jobs\SendSubmissionEmail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki view ini
    }

    public function register(Request $request)
    {
        // 1. Validasi input (Tetap sama)
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'country'  => 'required|string|max:100',
            'whatsapp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Cek Member ADAKSI & User Existing (Tetap sama)
        $isAdaksiMember = \Illuminate\Support\Facades\DB::table('users')
            ->where('email', $request->email)
            ->exists();

        if ($isAdaksiMember) {
            return redirect()->back()
                ->with('error', 'You are registered as an ADAKSI member. Please continue your registration through your ADAKSI account at (www.adaksi.org)')
                ->withInput();
        }

        $existingConferenceUser = User::where('email', $request->email)->first();
        if ($existingConferenceUser) {
            return redirect()->route('login')
                ->with('error', 'This email is already registered for the conference. Please sign in to your account.');
        }

        DB::beginTransaction();
        try {
            // 4. Simpan User & Peserta
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $peserta = Peserta::create([
                'user_id'  => $user->id,
                'nama'     => $request->name,
                'negara'   => $request->country,
                'no_wa'    => $request->whatsapp,
                'status'   => 'waiting',
            ]);

            // 5. Generate Link Verifikasi
            $url = URL::temporarySignedRoute(
                'verification.verify',
                now()->addHours(24),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            // 6. Siapkan Data Email untuk Antrean
            $html = view('emails.aktivasi-peserta', compact('peserta', 'url'))->render();
            $text = "Hello {$peserta->nama}, please verify your email: {$url}";

            $emailData = [
                'to'      => $user->email,
                'subject' => 'Registration Email Verification for ICPIP-HE 2026',
                'text'    => $text,
                'html'    => $html,
            ];

            // DISPATCH KE QUEUE: Ini yang membuat proses jadi sangat cepat
            SendSubmissionEmail::dispatch($emailData)->onQueue('conference');
            // $html = view('emails.aktivasi-peserta', compact('peserta', 'url'))->render();
            //$text = "Hello {$peserta->nama}, Thank you for registering for ICPIP-HE 2026. Please verify your email by clicking the link below:\n\n{$url}";

            /*  \App\Services\EmailApiService::send(
                $user->email,
                'Registration Email Verification for ICPIP-HE 2026',
                $text,
                $html
            ); */


            DB::commit();

            Auth::login($user);

            return redirect()->route('verification.notice')
                ->with('success', 'Registration successful! Please check your email.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Register Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Something went wrong, please try again.')
                ->withInput();
        }
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        // 1. Jika user sudah verifikasi, arahkan ke halaman utama
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended('/login')->with('message', 'Your email is already verified. Please sign in.');
        }

        try {
            // 2. Generate ulang Signed URL (berlaku 24 jam)
            $url = URL::temporarySignedRoute(
                'verification.verify',
                now()->addHours(24),
                ['id' => $user->id, 'hash' => sha1($user->email)]
            );

            // 3. Ambil data peserta untuk kebutuhan variabel di view email
            $peserta = Peserta::where('user_id', $user->id)->first();

            // 4. Render konten email (Gunakan view aktivasi-peserta yang sudah kita buat)
            $html = view('emails.aktivasi-peserta', compact('peserta', 'url'))->render();
            $text = "Hello {$peserta->nama}, please verify your email by clicking this link: {$url}";


            // 6. Siapkan Data Email untuk Antrean
            // $html = view('emails.aktivasi-peserta', compact('peserta', 'url'))->render();
            // $text = "Hello {$peserta->nama}, please verify your email: {$url}";

            $emailData = [
                'to'      => $user->email,
                'subject' => 'Registration Email Verification for ICPIP-HE 2026',
                'text'    => $text,
                'html'    => $html,
            ];

            // DISPATCH KE QUEUE: Ini yang membuat proses jadi sangat cepat
            SendSubmissionEmail::dispatch($emailData)->onQueue('conference');
            // $html = view('emails.aktivasi-peserta', compact('peserta', 'url'))->render();
            //$text = "Hello {$peserta->nama}, Thank you for registering for ICPIP-HE 2026. Please verify your email by clicking the link below:\n\n{$url}";

            /*  \App\Services\EmailApiService::send(
                $user->email,
                'Registration Email Verification for ICPIP-HE 2026',
                $text,
                $html
            ); */

            return back()->with('message', 'Verification link sent!');
        } catch (\Exception $e) {
            Log::error('Resend Email Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to resend email. Please try again later.');
        }
    }
}
