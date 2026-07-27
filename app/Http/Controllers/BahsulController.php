<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\BahsulMasailMail;
use App\Mail\PendaftaranBahsulMail;
use App\Models\BahsulModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusAnggotaMail;
use App\Models\PesertaBahsulModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class BahsulController extends Controller
{

    public function index(Request $request)
    {
        $query = BahsulModel::withCount('peserta');

        // Pencarian berdasarkan judul atau kategori
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('kategori', 'like', '%' . $request->search . '%');
            });
        }

        $bahsul = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bahsul.index', compact('bahsul'));
    }

    public function index_anggota()
    {
        $userName = Auth::user()->name;

        $bahsul = BahsulModel::with('peserta')
            ->withCount('peserta')
            ->where(function ($query) use ($userName) {
                $query->where('status', 'publish')
                    ->orWhere('pemohon', $userName);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('anggota.bahsul.index', compact('bahsul'));
    }

    public function create()
    {
        return view('admin.bahsul.tambah');
    }
    public function create_anggota()
    {
        return view('anggota.bahsul.tambah');
    }

    public function store_anggota(Request $request)
    {
        // Validasi (perbaikan pada status: gunakan default value, bukan di validasi)
        $data = $request->validate([
            'judul'       => 'required',
            'kategori'    => 'required',
            'pemohon'     => 'required',
            'masalah'     => 'required',
            'lampiran'    => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);
        $data['tanggal'] = date('Y-m-d');
        $data['status'] = 'draft';
        $data['lokasi'] = '-';
        $data['putusan'] = '-';
        $data['dasar_hukum'] = '-';

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/file'), $namaFile);
            $data['lampiran'] = $namaFile;
        }

        $bahsul = BahsulModel::create($data);

        // Kirim Email Notifikasi
        try {
            Mail::to(Auth::user()->email)->send(new BahsulMasailMail([
                'name'  => Auth::user()->name,
                'judul' => $data['judul']
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email: " . $e->getMessage());
        }

        return redirect()->route('anggota.bahsul.index')->with('success', 'Data berhasil ditambah');
    }

    public function store_free_user(Request $request)
    {
        // 1. Tambahkan validasi untuk field baru: email dan lokasi
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|string',
            'pemohon'   => 'required|string|max:255',
            'email'     => 'required|email', // Validasi format email
            'lokasi'    => 'required|string|max:255',
            'masalah'   => 'required',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        // 2. Isi field default
        $data['tanggal'] = date('Y-m-d');
        $data['status']  = 'draft';
        $data['putusan'] = '-';
        $data['dasar_hukum'] = '-';

        // 3. Proses upload file jika ada
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/file'), $namaFile);
            $data['lampiran'] = $namaFile;
        }

        // 4. Simpan ke database
        $bahsul = BahsulModel::create($data);

        // 5. Kirim Email Notifikasi ke email yang diinput di form
        try {
            Mail::to($data['email'])->send(new BahsulMasailMail([
                'name'  => $data['pemohon'], // Menggunakan nama pemohon dari form
                'judul' => $data['judul']
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email ke " . $data['email'] . ": " . $e->getMessage());
        }

        return redirect()->route('kirim')->with('success', 'Data berhasil dikirim dan periksa email Anda');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'pemohon' => 'nullable',
            'masalah' => 'required',
            'putusan' => 'nullable',
            'dasar_hukum' => 'nullable',
            'status' => 'draft',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        $data['pemohon'] = $request->filled('pemohon') ? $request->pemohon : 'Masyarakat Umum';
        $data['putusan'] = $request->filled('putusan') ? $request->putusan : '-';
        $data['dasar_hukum'] = $request->filled('dasar_hukum') ? $request->dasar_hukum : '-';

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            // Buat nama file unik agar tidak tertimpa
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Tentukan path tujuan: public/assets/file/
            $destinationPath = public_path('assets/file');

            // Pindahkan file
            $file->move($destinationPath, $namaFile);

            // Simpan path relatif ke database
            $data['lampiran'] = $namaFile;
        }

        BahsulModel::create($data);

        return redirect()->route('admin.bahsul.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit($id)
    {
        $bahsul = BahsulModel::findOrFail($id);
        return view('admin.bahsul.edit', compact('bahsul'));
    }
    public function edit_anggota($id)
    {
        $bahsul = BahsulModel::findOrFail($id);
        return view('anggota.bahsul.edit', compact('bahsul'));
    }
    public function update_anggota(Request $request, $id)
    {
        $bahsul = BahsulModel::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'masalah' => 'required',
        ]);

        $bahsul->update($data);

        return redirect()->route('anggota.bahsul.index')->with('success', 'Data berhasil diperbarui');
    }

    public function update(Request $request, $id)
    {
        $bahsul = BahsulModel::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'tanggal' => 'required|date',
            'lokasi' => 'required',
            'pemohon' => 'required',
            'masalah' => 'required',
            'putusan' => 'required',
            'dasar_hukum' => 'required',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:2048'
        ]);

        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($bahsul->lampiran && file_exists(public_path($bahsul->lampiran))) {
                unlink(public_path($bahsul->lampiran));
            }

            $file = $request->file('lampiran');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/file'), $namaFile);
            $data['lampiran'] = $namaFile;
        }

        $bahsul->update($data);

        return redirect()->route('admin.bahsul.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy_anggota($id): RedirectResponse
    {
        try {
            $bahsul = BahsulModel::findOrFail($id);
            $bahsul->delete();

            return redirect()
                ->route('anggota.bahsul.index')
                ->with('success', 'Data Bahsul Masail berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('anggota.bahsul.index')
                ->with('error', 'Data Bahsul Masail gagal dihapus.');
        }
    }
    public function destroy($id): RedirectResponse
    {
        try {
            $bahsul = BahsulModel::findOrFail($id);
            $bahsul->delete();

            return redirect()
                ->route('admin.bahsul.index')
                ->with('success', 'Data Bahsul Masail berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.bahsul.index')
                ->with('error', 'Data Bahsul Masail gagal dihapus.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        // 1. Validasi input agar status yang masuk hanya yang diizinkan
        $request->validate([
            'status' => 'required|in:draft,publish,arsip'
        ]);

        // 2. Cari data berdasarkan ID
        $basaul = \App\Models\BahsulModel::findOrFail($id);

        // 3. Update status
        $basaul->status = $request->status;
        $basaul->save();

        // 4. Berikan feedback ke user
        return redirect()->back()->with('success', 'Status berhasil diubah menjadi ' . ucfirst($request->status));
    }

    public function storeKategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategoriBaru = trim($request->nama_kategori);

        // Tentukan path file di dalam storage/app/kategori.txt
        $filePath = 'kategori.txt';

        // Periksa apakah file sudah ada, jika belum buat kosong atau langsung append
        $existingContent = Storage::exists($filePath) ? Storage::get($filePath) : '';

        // Cek apakah kategori sudah ada di dalam file untuk menghindari duplikasi (opsional)
        $lines = array_map('trim', explode("\n", $existingContent));
        if (in_array($kategoriBaru, $lines)) {
            return redirect()->back()->with('error', 'Kategori tersebut sudah ada.');
        }

        // Tambahkan kategori baru ke baris baru
        $updatedContent = $existingContent ? $existingContent . PHP_EOL . $kategoriBaru : $kategoriBaru;

        // Simpan kembali ke storage/app/kategori.txt
        Storage::put($filePath, $updatedContent);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }


    public function daftar($id_bs)
    {
        $user = Auth::user();
        $bahsul = BahsulModel::findOrFail($id_bs);
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Profil anggota tidak ditemukan.');
        }

        $sudahDaftar = PesertaBahsulModel::where('id_bs', $id_bs)->where('email', $user->email)->exists();
        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kegiatan Bahsul Masail ini.');
        }

        PesertaBahsulModel::create([
            'name'     => $user->name,
            'alamat'   => $anggota->alamat,
            'email'    => $user->email,
            'telpon'   => $anggota->telpon,
            'id_bs'    => $id_bs,
        ]);

        // Ambil data admin (misalnya ambil admin pertama yang memiliki relasi anggota)
        // Sesuaikan kondisi role jika di database Anda menggunakan kolom role atau relasi role
        $panitia = User::where('role', 'admin')->with('anggota')->first();

        // Kirim Email Menggunakan PendaftaranBahsulMail dengan data panitia
        Mail::to($user->email)->send(new PendaftaranBahsulMail([
            'name'          => $user->name,
            'judul'         => $bahsul->judul,
            'tgl'           => $bahsul->tanggal,
            'panitia_nama'  => $panitia->name ?? 'Panitia',
            'panitia_telpon' => optional($panitia->anggota)->telpon ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }
}
