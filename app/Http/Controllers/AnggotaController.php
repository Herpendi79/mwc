<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnggotaModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusAnggotaMail;
use App\Models\BahsulModel;
use App\Models\BencanaModel;
use App\Models\DakwahModel;
use App\Models\HalaqahModel;
use App\Models\KajianModel;
use App\Models\KhutbahModel;
use App\Models\MangroveModel;
use App\Models\OpiniModel;
use App\Models\PesertaRelawanModel;
use App\Models\PesertaRoanModel;
use App\Models\RelawanModel;
use App\Models\SampahModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    public function index()
    {
        $data = [
            'total_anggota'    => AnggotaModel::count(),
            'total_bahsul'     => BahsulModel::count(),
            'total_halaqah'    => HalaqahModel::count(),
            'total_kajian'     => KajianModel::count(),
            'total_mangrove'   => MangroveModel::sum('jumlah_infaq'),
            'total_sampah'     => SampahModel::sum('nilai'),
            'total_relawan'      => PesertaRelawanModel::count(),
            'total_roan'         => PesertaRoanModel::count(),
            'total_bencana'      => BencanaModel::count(),
            'total_opini'        => OpiniModel::count(),
            'total_dakwah'       => DakwahModel::count(),
            'total_khutbah'      => KhutbahModel::count(),
        ];

        return view('anggota.index', compact('data'));
    }
    public function setting()
    {
        $anggota = AnggotaModel::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();

        return view('anggota.profile.setting', compact('anggota'));
    }

    public function updateAkses(Request $request)
    {
        // 1. Validasi input dasar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            // Password hanya divalidasi jika diisi
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // 2. Update data profil
        $user->name = $request->name;
        $user->email = $request->email;

        // 3. Update password jika user memasukkan password baru
        if ($request->filled('new_password')) {
            // Cek apakah password lama benar
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
            }

            $user->password = Hash::make($request->new_password);
        }

        /** @var \App\Models\User $user */
        $user->save();

        return redirect()->back()->with('success', 'Akses akun berhasil diperbarui.');
    }

    public function kta()
    {
        $anggota = AnggotaModel::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();

        // Kirim $anggota ke view. Jika null, view tetap menerima variabelnya (berisi null)
        return view('anggota.profile.kta', compact('anggota'));
    }


    public function downloadKta()
    {
        $anggota = Auth::user()->anggota;

        if ($anggota->status !== 'aktif') {
            return redirect()->back()->with('error', 'Kartu Tanda Anggota hanya dapat diunduh oleh anggota yang sudah aktif.');
        }
        return view('components.kartu_tanda_anggota', compact('anggota'));
    }

    public function profile()
    {
        $anggota = Auth::user()->anggota;
        return view('anggota.profile.index', compact('anggota'));
    }

    public function updateProfile(Request $request)
    {
        $anggota = Auth::user()->anggota;
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Validasi unik kecuali untuk user itu sendiri
            'alamat' => 'nullable|string',
            'telpon' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update Nama dan Email di tabel Users
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update data di tabel Anggota
        $anggota->update([
            'alamat' => $request->alamat,
            'telpon' => $request->telepon,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->hasFile('foto')) {
            if ($anggota->foto) {
                Storage::delete('public/foto/' . $anggota->foto);
            }
            $path = $request->file('foto')->store('foto', 'public');
            $anggota->foto = basename($path);
        }

        $anggota->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

}
