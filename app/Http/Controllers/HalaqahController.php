<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\PendaftaranHalaqahMail;
use App\Models\BahsulModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\StatusAnggotaMail;
use App\Models\HalaqahModel;
use App\Models\PesertaHalaqahModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class HalaqahController extends Controller
{

    public function index(Request $request)
    {
        $query = HalaqahModel::with('peserta')->withCount('peserta');

        // Filter pencarian live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('tema', 'like', '%' . $search . '%')
                    ->orWhere('narsum', 'like', '%' . $search . '%')
                    ->orWhere('moderator', 'like', '%' . $search . '%');
            });
        }

        $halaqah = $query->latest()->paginate(10)->withQueryString();

        return view('admin.halaqah.index', compact('halaqah'));
    }

    public function index_anggota()
    {
        $halaqah = HalaqahModel::where('status', 'publish')->latest()->get();
        return view('anggota.halaqah.index', compact('halaqah'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:publish,arsip,draft'
        ]);

        $halaqah = HalaqahModel::findOrFail($id);
        $halaqah->status = $request->status;
        $halaqah->save();

        return redirect()->back()->with('success', 'Status halaqah berhasil diubah menjadi ' . $request->status);
    }

    public function create()
    {
        return view('admin.halaqah.tambah');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'judul'     => 'required|string|max:255',
            'tema'      => 'required|string|max:255',
            'tanggal'   => 'required|date',
            'narsum'    => 'required|string|max:255',
            'moderator' => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'deskripsi' => 'required',
            'hasil'     => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto.*'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil semua input kecuali file
        $data = $request->except(['thumbnail', 'foto']);

        // Set status default ke 'draft'
        $data['status'] = 'draft';

        // 3. Upload Thumbnail (disimpan di storage/app/public/foto_halaqah)
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('foto_halaqah', 'public');
            $data['thumbnail'] = basename($thumbnailPath);
        }

        // 4. Upload Multiple Foto dan gabungkan dengan ';'
        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_halaqah', 'public');
                $fotoPaths[] = basename($path);
            }
            $data['foto'] = implode(';', $fotoPaths);
        }

        // 5. Simpan ke database
        HalaqahModel::create($data);

        return redirect()->route('admin.halaqah.index')->with('success', 'Data halaqah berhasil ditambah!');
    }

    public function edit($id)
    {
        $halaqah = HalaqahModel::findOrFail($id);
        return view('admin.halaqah.edit', compact('halaqah'));
    }

    public function update(Request $request, $id)
    {
        $halaqah = HalaqahModel::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'judul'     => 'required|string|max:255',
            'tema'      => 'required|string|max:255',
            'tanggal'   => 'required|date',
            'narsum'    => 'required|string|max:255',
            'moderator' => 'required|string|max:255',
            'lokasi'    => 'required|string|max:255',
            'deskripsi' => 'required',
            'hasil'     => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto.*'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil semua input kecuali file
        $data = $request->except(['thumbnail', 'foto']);

        // 3. Update Thumbnail jika ada file baru
        if ($request->hasFile('thumbnail')) {
            if ($halaqah->thumbnail) {
                // Kita targetkan disk 'public' secara eksplisit
                Storage::disk('public')->delete('foto_halaqah/' . $halaqah->thumbnail);
            }

            // Simpan ke storage/foto_halaqah (menggunakan root storage)
            $path = $request->file('thumbnail')->store('foto_halaqah', 'public');
            $data['thumbnail'] = basename($path);
        }

        if ($request->hasFile('foto')) {
            // 1. Hapus foto-foto lama dari disk 'public'
            if ($halaqah->foto) {
                $oldPhotos = explode(';', $halaqah->foto);
                foreach ($oldPhotos as $oldPhoto) {
                    // Menghapus dengan disk 'public' yang konsisten
                    Storage::disk('public')->delete('foto_halaqah/' . $oldPhoto);
                }
            }

            // 2. Simpan foto-foto baru ke disk 'public'
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                // Simpan ke storage/app/public/foto_halaqah
                $path = $file->store('foto_halaqah', 'public');
                $fotoPaths[] = basename($path);
            }
            $data['foto'] = implode(';', $fotoPaths);
        }

        // 5. Update data di database
        $halaqah->update($data);

        return redirect()->route('admin.halaqah.index')->with('success', 'Data halaqah berhasil diupdate!');
    }


    public function destroy($id)
    {
        $halaqah = HalaqahModel::findOrFail($id);

        // 1. Hapus Thumbnail jika ada
        if ($halaqah->thumbnail) {
            Storage::disk('public')->delete('foto_halaqah/' . $halaqah->thumbnail);
        }

        // 2. Hapus Galeri Foto jika ada
        if ($halaqah->foto) {
            $oldPhotos = explode(';', $halaqah->foto);
            foreach ($oldPhotos as $oldPhoto) {
                Storage::disk('public')->delete('foto_halaqah/' . $oldPhoto);
            }
        }

        // 3. Hapus data dari database
        $halaqah->delete();

        return redirect()->route('admin.halaqah.index')->with('success', 'Data halaqah beserta fotonya berhasil dihapus!');
    }

    public function daftar($id)
    {
        $user = Auth::user();
        $halaqah = HalaqahModel::findOrFail($id);
        $anggota = $user->anggota;

        if (!$anggota) {
            return redirect()->back()->with('error', 'Profil anggota tidak ditemukan.');
        }

        $sudahDaftar = PesertaHalaqahModel::where('id', $id)->where('email', $user->email)->exists();
        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar di kegiatan halaqah ini.');
        }

        PesertaHalaqahModel::create([
            'name'       => $user->name,
            'alamat'     => $anggota->alamat,
            'email'      => $user->email,
            'telpon'     => $anggota->telpon,
            'id' => $id,
        ]);

        // Ambil data admin / panitia
        $panitia = User::where('role', 'admin')->with('anggota')->first();

        // Kirim Email Menggunakan PendaftaranHalaqahMail dengan data panitia
        Mail::to($user->email)->send(new PendaftaranHalaqahMail([
            'name'           => $user->name,
            'judul'          => $halaqah->judul,
            'tgl'            => $halaqah->tanggal,
            'panitia_nama'   => $panitia->name ?? 'Panitia',
            'panitia_telpon' => optional($panitia->anggota)->telpon ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }
}
