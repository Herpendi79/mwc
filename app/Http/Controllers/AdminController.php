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
use App\Models\RoanModel;
use App\Models\SampahModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
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

        return view('admin.index', compact('data'));
    }
    public function setting()
    {
        $anggota = AnggotaModel::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();

        $rekening = \Illuminate\Support\Facades\Storage::exists('rekening.txt')
            ? json_decode(\Illuminate\Support\Facades\Storage::get('rekening.txt'), true)
            : [];

        return view('admin.profile.setting', compact('anggota', 'rekening'));
    }

    public function updateRekening(Request $request)
    {
        $data = [
            'bank'   => $request->bank,
            'no_rek' => $request->no_rek,
            'an'     => $request->an,
        ];

        // Simpan sebagai JSON di dalam file txt
        \Illuminate\Support\Facades\Storage::put('rekening.txt', json_encode($data));

        return redirect()->back()->with('success', 'Data rekening berhasil diperbarui.');
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
        return view('admin.profile.kta', compact('anggota'));
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
        return view('admin.profile.index', compact('anggota'));
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

    public function anggota(Request $request)
    {
        $query = AnggotaModel::with('user');

        // Pencarian berdasarkan nama
        if ($request->has('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Urutkan berdasarkan nama user (dari relasi)
        $anggota = $query->join('users', 'anggota.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('anggota.*')
            ->paginate(10)
            ->withQueryString();

        return view('admin.anggota.index', compact('anggota'));
    }

    public function verifikasi(Request $request, $id)
    {
        $anggota = AnggotaModel::with('user')->findOrFail($id);
        $email = $anggota->user->email ?? null;
        $action = $request->action;
        $name = $anggota->user->name ?? 'Anggota';

        // Logika Database & Validasi Berdasarkan Action
        if ($action == 'setuju' || $action == 'aktivasi') {

            // Validasi khusus jika aksi 'setuju', pastikan no_anggota diisi dan unik
            if ($action == 'setuju') {
                $request->validate([
                    'no_anggota' => 'required|string|unique:anggota,no_anggota,' . $id . ',id_anggota',
                ], [
                    'no_anggota.required' => 'Nomor Anggota wajib diisi.',
                    'no_anggota.unique' => 'Nomor Anggota ini sudah terdaftar oleh anggota lain.',
                ]);

                // Update status aktif dan masukkan No Anggotanya
                $anggota->update([
                    'status' => 'aktif',
                    'no_anggota' => $request->no_anggota,
                ]);
            } else {
                // Untuk aktivasi ulang (jika tidak butuh input baru)
                $anggota->update(['status' => 'aktif']);
            }

            $message = ($action == 'setuju') ? "Anggota berhasil divalidasi dan disetujui." : "Anggota berhasil diaktifkan kembali.";
        } elseif ($action == 'tolak') {
            $user = $anggota->user;
            $anggota->delete();
            if ($user) {
                $user->delete();
            }
            $message = "Data anggota berhasil ditolak dan dihapus.";
        }

        // Kirim email notifikasi ke user (jika email tersedia)
        if ($email) {
            try {
                Mail::to($email)->send(new StatusAnggotaMail($action, $name));
            } catch (\Exception $e) {
                // Tangani jika pengiriman email gagal agar tidak memutus eksekusi database
            }
        }

        return redirect()->back()->with('success', $message);
    }

    public function create()
    {
        return view('admin.anggota.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_anggota' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'alamat' => 'required',
            'telpon' => 'required',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan ke User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'anggota', // Asumsi role untuk anggota
            ]);

            // 2. Simpan ke Anggota
            AnggotaModel::create([
                'user_id' => $user->id,
                'no_anggota' => $request->no_anggota,
                'alamat' => $request->alamat,
                'telpon' => $request->telpon,
                'status' => 'aktif',
                'keterangan' => $request->keterangan,
                'foto' => $request->hasFile('foto') ? basename($request->file('foto')->store('foto', 'public')) : null,
            ]);
        });

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }


    public function updateTemplate(Request $request)
    {
        // Validasi agar hanya menerima file bertipe gambar dengan ukuran maksimal 2MB
        $request->validate([
            'template' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('template');

        // Tentukan direktori tujuan: public/assets/images/template/
        $destinationPath = public_path('assets/images/template');

        // Pastikan folder tujuan ada
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Ambil ekstensi asli dari file yang di-upload (misal: png, jpg, jpeg, webp)
        $extension = $file->getClientOriginalExtension();

        // Cek apakah sudah ada file dengan nama utama 'Template.*' di folder tersebut
        // Kita gunakan glob untuk mendeteksi file berawalan "Template." terlepas dari ekstensinya
        $existingFiles = glob($destinationPath . '/Template.*');

        if (!empty($existingFiles)) {
            foreach ($existingFiles as $oldFile) {
                // Ambil ekstensi dari file lama yang ditemukan
                $oldExtension = pathinfo($oldFile, PATHINFO_EXTENSION);

                // Buat nama backup yang unik, tetap mempertahankan format "Template_backup_[timestamp]"
                $uniqueBackupName = 'Template_backup_' . time() . '_' . uniqid() . '.' . $oldExtension;
                $backupFilePath = $destinationPath . '/' . $uniqueBackupName;

                // Rename/pindahkan file lama ke nama unik cadangan
                File::move($oldFile, $backupFilePath);
            }
        }

        // Tentukan nama file baru dengan nama dasar 'Template' dan ekstensi dinamis
        $mainFileName = 'Template.' . $extension;

        // Pindahkan file baru yang di-upload ke folder tujuan
        $file->move($destinationPath, $mainFileName);

        return back()->with('success', 'Template KTA berhasil diperbarui.');
    }

   
}
