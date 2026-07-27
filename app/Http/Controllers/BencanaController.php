<?php

namespace App\Http\Controllers;

use App\Mail\BencanaDitolakMail;
use App\Mail\BencanaPublishedMail;
use App\Mail\LaporanBencanaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BencanaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BencanaController extends Controller
{
    public function index()
    {
        $bencana = BencanaModel::orderBy('tgl', 'desc')->get();
        return view('admin.bencana.index', compact('bencana'));
    }
    public function index_anggota()
    {
        // Menampilkan data kecuali yang berstatus 'arsip'
        $bencana = BencanaModel::where('status', '!=', 'arsip')->get();

        return view('anggota.bencana.index', compact('bencana'));
    }
    public function create_bencana()
    {
        return view('anggota.bencana.tambah');
    }
    public function storeBencana(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'jenis_bencana' => 'required',
            'lokasi'        => 'required',
            'tgl'           => 'required|date',
            'deskripsi'     => 'required',
            'kebutuhan'     => 'required',
            'jml_korban'    => 'required|integer',
            'foto.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Gabungkan nama dan email user yang sedang login untuk kolom pelapor
        $validated['pelapor'] = $user->name . ' (' . $user->email . ')';

        // Simpan juga user_id jika relasi ke model User diperlukan nantinya
       // $validated['user_id'] = $user->id;

        // 2. Proses upload banyak foto
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_bencana', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        }

        // 3. Simpan ke database
        $bencana = \App\Models\BencanaModel::create($validated);

        // 4. Kirim Email Notifikasi
        try {
            Mail::to($user->email)->send(new LaporanBencanaMail([
                'name'          => $user->name,
                'jenis_bencana' => $validated['jenis_bencana'],
                'jml_korban'    => $validated['jml_korban'],
                'lokasi'        => $validated['lokasi']
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email laporan bencana: " . $e->getMessage());
        }

        return redirect()->route('anggota.bencana.index')->with('success', 'Data bencana berhasil ditambah. Terima kasih atas laporan Anda.');
    }

    public function create()
    {
        return view('admin.bencana.tambah');
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'pelapor'       => 'required',
            'jenis_bencana' => 'required',
            'lokasi'        => 'required',
            'tgl'           => 'required|date',
            'deskripsi'     => 'required',
            'kebutuhan'     => 'required',
            'jml_korban'    => 'required|integer',
            'foto.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi untuk setiap file
        ]);

        // 2. Proses upload banyak foto
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                // Menyimpan ke folder 'foto_bencana' di disk 'public'
                $path = $file->store('foto_bencana', 'public');
                // Mengambil hanya nama file saja
                $fotoNames[] = basename($path);
            }
            // Menggabungkan nama file dengan titik koma
            $validated['foto'] = implode(';', $fotoNames);
        }

        // 3. Tambahkan status publish
        // Menggunakan $request->status jika inputnya ada dari form, atau 'publish' secara default
        $validated['status'] = $request->input('status', 'publish');

        // 4. Simpan ke database
        \App\Models\BencanaModel::create($validated);

        return redirect()->route('admin.bencana.index')->with('success', 'Data bencana berhasil ditambah');
    }

    public function edit($id)
    {
        $bencana = BencanaModel::findOrFail($id);
        return view('admin.bencana.edit', compact('bencana'));
    }

    // 2. Memproses update data
    public function update(Request $request, $id)
    {
        // Validasi
        $validated = $request->validate([
            'pelapor'       => 'required',
            'jenis_bencana' => 'required',
            'tgl'           => 'required|date',
            'lokasi'        => 'required',
            'jml_korban'    => 'required|integer',
            'kebutuhan'     => 'required',
            'deskripsi'     => 'required',
            'foto.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $bencana = BencanaModel::findOrFail($id);

        // Handle update foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($bencana->foto) {
                foreach (explode(';', $bencana->foto) as $f) {
                    Storage::disk('public')->delete('foto_bencana/' . $f);
                }
            }

            // Upload foto baru
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_bencana', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        }

        $bencana->update($validated);

        return redirect()->route('admin.bencana.index')->with('success', 'Data bencana berhasil diperbarui!');
    }

    // 3. Menghapus data
    public function destroy($id)
    {
        $bencana = BencanaModel::findOrFail($id);

        // Hapus file fisik dari storage
        if ($bencana->foto) {
            foreach (explode(';', $bencana->foto) as $f) {
                Storage::disk('public')->delete('foto_bencana/' . $f);
            }
        }

        // Hapus data dari database
        $bencana->delete();

        return redirect()->route('admin.bencana.index')->with('success', 'Data bencana berhasil dihapus!');
    }

    public function verifikasi(Request $request, $id)
    {
        $bencana = BencanaModel::findOrFail($id);

        // Ekstrak email dari kolom pelapor (Format: Nama (email@domain.com))
        $emailPelapor = null;
        $namaPelapor = $bencana->pelapor;

        if (preg_match('/\((.*?)\)/', $bencana->pelapor, $match)) {
            $emailPelapor = $match[1];
            // Ambil nama saja (teks sebelum tanda kurung)
            $namaPelapor = trim(explode('(', $bencana->pelapor)[0]);
        }

        $aksi = $request->input('aksi'); // 'publish' atau 'tolak'

        if ($aksi === 'publish') {
            // 1. Ubah status menjadi publish
            $bencana->status = 'publish';
            $bencana->save();

            // 2. Kirim Email Ucapan Terima Kasih / Publikasi
            if ($emailPelapor) {
                try {
                    Mail::to($emailPelapor)->send(new BencanaPublishedMail([
                        'name'          => $namaPelapor,
                        'jenis_bencana' => $bencana->jenis_bencana,
                        'lokasi'        => $bencana->lokasi,
                        'tgl'           => $bencana->tgl,
                    ]));
                } catch (\Exception $e) {
                    Log::error("Gagal kirim email publikasi bencana: " . $e->getMessage());
                }
            }

            return redirect()->back()->with('success', 'Laporan berhasil disetujui dan dipublikasikan.');
        } elseif ($aksi === 'tolak') {
            // 1. Kirim Email Pemberitahuan Penolakan Sebelum Data Dihapus
            if ($emailPelapor) {
                try {
                    Mail::to($emailPelapor)->send(new BencanaDitolakMail([
                        'name'          => $namaPelapor,
                        'jenis_bencana' => $bencana->jenis_bencana,
                        'lokasi'        => $bencana->lokasi,
                    ]));
                } catch (\Exception $e) {
                    Log::error("Gagal kirim email penolakan bencana: " . $e->getMessage());
                }
            }

            // 2. Hapus data karena tidak valid
            $bencana->delete();

            return redirect()->back()->with('success', 'Laporan ditolak dan data telah dihapus.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }

}
