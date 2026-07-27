<?php

namespace App\Http\Controllers;

use App\Mail\PendaftaranRoanMail;
use App\Models\PesertaRoanModel;
use App\Models\RoanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Pastikan model User di-import

class RoanController extends Controller
{
    // 1. Menampilkan Daftar Data
    public function index(Request $request)
    {
        $query = RoanModel::withCount('peserta')->with('peserta')->latest();

        // Filter pencarian live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%')
                    ->orWhere('pj', 'like', '%' . $search . '%')
                    ->orWhere('tema', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $roans = $query->paginate(10)->withQueryString();

        return view('admin.roan.index', compact('roans'));
    }

    public function index_anggota()
    {
        $roans = RoanModel::withCount('peserta')->get();
        return view('anggota.roan.index', compact('roans'));
    }


    public function daftar($id_ro)
    {
        $user = Auth::user();
        $roan = RoanModel::findOrFail($id_ro);
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Profil anggota tidak ditemukan.');
        }

        $sudahDaftar = PesertaRoanModel::where('id_ro', $id_ro)->where('email', $user->email)->exists();
        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kegiatan ini.');
        }

        PesertaRoanModel::create([
            'name'    => $user->name,
            'alamat'  => $anggota->alamat,
            'email'   => $user->email,
            'telpon'  => $anggota->telpon,
            'id_ro'   => $id_ro,
        ]);

        // Kirim Email dengan menyertakan data penanggung jawab secara langsung
        Mail::to($user->email)->send(new PendaftaranRoanMail([
            'name'     => $user->name,
            'judul'    => $roan->judul,
            'tgl'      => $roan->tgl,
            'kategori' => 'Roan',
            'pj'       => $roan->pj ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }
    // 2. Form Tambah
    public function create()
    {
        return view('admin.roan.tambah');
    }

    // 3. Simpan Data (Store)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'tema' => 'required',
            'tgl' => 'required|date',
            'lokasi' => 'required',
            'pj' => 'required',
            'vol_sampah' => 'required|numeric',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib diisi
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'  // Boleh kosong
        ]);

        // 1. Simpan Poster (Wajib karena divalidasi 'required')
        if ($request->hasFile('poster')) {
            $pathPoster = $request->file('poster')->store('foto_roan', 'public');
            $validated['poster'] = basename($pathPoster);
        }

        // 2. Simpan Banyak Foto (Opsional)
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_roan', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        } else {
            $validated['foto'] = 'none'; // Default jika user tidak upload foto tambahan
        }

        RoanModel::create($validated);

        return redirect()->route('admin.roan.index')->with('success', 'Data berhasil ditambah!');
    }

    // 4. Form Edit
    public function edit($id_ro)
    {
        $roan = RoanModel::findOrFail($id_ro);
        return view('admin.roan.edit', compact('roan'));
    }

    public function update(Request $request, $id_ro)
    {
        $roan = RoanModel::findOrFail($id_ro);

        $validated = $request->validate([
            'judul' => 'required',
            'tema' => 'required',
            'tgl' => 'required|date',
            'lokasi' => 'required',
            'pj' => 'required',
            'vol_sampah' => 'required|numeric',
            'deskripsi' => 'required',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional saat edit
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 1. Update Poster jika ada file baru
        if ($request->hasFile('poster')) {
            // Hapus poster lama (kecuali jika default 'none')
            if ($roan->poster && $roan->poster !== 'none') {
                Storage::disk('public')->delete('foto_roan/' . $roan->poster);
            }

            $pathPoster = $request->file('poster')->store('foto_roan', 'public');
            $validated['poster'] = basename($pathPoster);
        }

        // 2. Update Foto Dokumentasi jika ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($roan->foto && $roan->foto !== 'none') {
                foreach (explode(';', $roan->foto) as $f) {
                    Storage::disk('public')->delete('foto_roan/' . $f);
                }
            }

            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_roan', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        }

        $roan->update($validated);

        return redirect()->route('admin.roan.index')->with('success', 'Data berhasil diupdate!');
    }

    // 6. Hapus Data
    public function destroy($id_ro)
    {
        $roan = RoanModel::findOrFail($id_ro);
        if ($roan->foto) {
            foreach (explode(';', $roan->foto) as $f) Storage::disk('public')->delete('foto_roan/' . $f);
        }
        $roan->delete();
        return redirect()->route('admin.roan.index')->with('success', 'Data berhasil dihapus!');
    }
}
