<?php

namespace App\Http\Controllers;

use App\Mail\PendaftaranRoanMail;
use Illuminate\Support\Facades\Auth;
use App\Models\PesertaRelawanModel;
use App\Models\RelawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Pastikan model User di-import
use App\Mail\PendaftaranRelawanMail; // Gunakan mail baru untuk relawan

class RelawanController extends Controller
{
    public function index(Request $request)
    {
        $query = RelawanModel::with('peserta')->withCount('peserta')->latest();

        // Filter pencarian live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%')
                    ->orWhere('bantuan', 'like', '%' . $search . '%')
                    ->orWhere('koordinator', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $relawans = $query->paginate(10)->withQueryString();

        return view('admin.relawan.index', compact('relawans'));
    }

    public function index_anggota()
    {
        // Ambil semua relawan, sertakan relasi 'peserta', dan hitung jumlahnya
        $relawans = RelawanModel::with('peserta')->withCount('peserta')->paginate(10);

        return view('anggota.relawan.index', compact('relawans'));
    }


    public function daftar($id_re)
    {
        $user = Auth::user();

        // Ambil data relawan utama
        $relawan = RelawanModel::findOrFail($id_re);

        // Pastikan user memiliki profil anggota
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Profil anggota tidak ditemukan.');
        }

        // Cek apakah sudah daftar agar tidak duplikat
        $sudahDaftar = PesertaRelawanModel::where('id_re', $id_re)
            ->where('email', $user->email)
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kegiatan ini.');
        }

        // Simpan ke tabel peserta
        PesertaRelawanModel::create([
            'name'    => $user->name,
            'alamat'  => $anggota->alamat,
            'email'   => $user->email,
            'telpon'  => $anggota->telpon,
            'id_re'   => $id_re,
        ]);

        // Kirim Email Konfirmasi dengan data koordinator langsung
        try {
            Mail::to($user->email)->send(new PendaftaranRelawanMail([
                'name'        => $user->name,
                'judul'       => $relawan->judul,
                'tgl'         => $relawan->tgl,
                'koordinator' => $relawan->koordinator ?? '-',
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email pendaftaran: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mendaftar aksi relawan! Email konfirmasi telah dikirim.');
    }

    public function create()
    {
        return view('admin.relawan.tambah');
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'judul' => 'required',
            'lokasi' => 'required',
            'tgl' => 'required|date',
            'koordinator' => 'required',
            'jml_korban' => 'required|integer',
            'bantuan' => 'required',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib ada
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Opsional
        ]);

        // 2. Proses upload Poster (Single File)
        if ($request->hasFile('poster')) {
            $pathPoster = $request->file('poster')->store('foto_relawan', 'public');
            $validated['poster'] = basename($pathPoster);
        }

        // 3. Proses upload Dokumentasi Foto (Multiple Files)
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_relawan', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        } else {
            // Jika tidak ada foto dokumentasi, isi dengan 'none' agar konsisten
            $validated['foto'] = 'none';
        }

        // 4. Simpan ke database
        RelawanModel::create($validated);

        return redirect()->route('admin.relawan.index')->with('success', 'Data berhasil ditambah');
    }

    // 6. Hapus Data
    public function destroy($id_re)
    {
        $relawan = RelawanModel::findOrFail($id_re);

        // Hapus file foto dari folder public/foto_relawan
        if ($relawan->foto) {
            foreach (explode(';', $relawan->foto) as $f) {
                // Memastikan file tidak kosong sebelum menghapus
                if (!empty($f)) {
                    Storage::disk('public')->delete('foto_relawan/' . $f);
                }
            }
        }

        // Hapus data dari database
        $relawan->delete();

        return redirect()->route('admin.relawan.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id_re)
    {
        $relawan = RelawanModel::findOrFail($id_re);
        return view('admin.relawan.edit', compact('relawan'));
    }

    public function update(Request $request, $id_re)
    {
        // 1. Validasi data
        $request->validate([
            'judul' => 'required',
            'lokasi' => 'required',
            'tgl' => 'required|date',
            'koordinator' => 'required',
            'jml_korban' => 'required|integer',
            'bantuan' => 'required',
            'deskripsi' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi poster
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $relawan = RelawanModel::findOrFail($id_re);
        // Kecualikan 'poster' dan 'foto' agar tidak masuk ke array $validated secara langsung
        $validated = $request->except(['poster', 'foto']);

        // 2. Handle update poster (Single file)
        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada dan bukan 'none'
            if ($relawan->poster && $relawan->poster !== 'none') {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('foto_relawan/' . $relawan->poster);
            }

            // Upload poster baru
            $pathPoster = $request->file('poster')->store('foto_relawan', 'public');
            $validated['poster'] = basename($pathPoster);
        }

        // 3. Handle update foto (Multiple files)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada dan bukan 'none'
            if ($relawan->foto && $relawan->foto !== 'none') {
                foreach (explode(';', $relawan->foto) as $f) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete('foto_relawan/' . $f);
                }
            }

            // Upload foto baru
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_relawan', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        }

        // 4. Update data
        $relawan->update($validated);

        return redirect()->route('admin.relawan.index')->with('success', 'Data berhasil diperbarui!');
    }
}
