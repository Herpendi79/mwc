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
use Illuminate\Support\Facades\Mail;
use App\Mail\AktivasiPesertaMail;
use App\Jobs\SendSubmissionEmail;
use App\Models\AnggotaModel;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki view ini
    }

    public function register(Request $request)
    {
        // 1. Validasi input dengan pesan kustom untuk email
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'foto'     => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'telpon'   => 'required|string|max:20',
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Handle Upload Foto ke storage/app/public/foto
            $filename = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                // Membuat nama unik file
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // Menyimpan menggunakan disk 'public' langsung ke folder 'foto'
                // Hasilnya akan masuk ke storage/app/public/foto/$filename
                $file->storeAs('foto', $filename, 'public');
            }

            // Simpan User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'role'     => 'anggota',
                'password' => Hash::make($request->password),
            ]);

            // Simpan Anggota (Menyimpan nama file murni, misal: 171123456_abc.jpg)
            $peserta = AnggotaModel::create([
                'user_id'  => $user->id,
                'alamat'   => $request->alamat,
                'foto'     => $filename,
                'telpon'   => $request->telpon,
                'status'   => 'menunggu validasi',
            ]);

            // Kirim Email Notifikasi
            Mail::to($user->email)->send(new AktivasiPesertaMail($user->name));

            DB::commit();

            Auth::login($user);
            return redirect()->route('register')
                ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk informasi selanjutnya.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Register Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Something went wrong, please try again.')
                ->withInput();
        }
    }
}
