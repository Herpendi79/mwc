<?php

namespace App\Http\Controllers;

use App\Mail\OpiniDipublikasikan;
use App\Mail\OpiniDiterima;
use App\Mail\OpiniDitolak;
use App\Models\OpiniModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OpiniController extends Controller
{
    public function index()
    {
        $opinis = OpiniModel::latest()->get();
        return view('admin.opini.index', compact('opinis'));
    }

    public function index_anggota()
    {
        $userName = Auth::user()->name;

        $opinis = OpiniModel::where('status', 'publish')
            ->orWhere(function ($query) use ($userName) {
                // Mencocokkan data penulis yang diawali dengan nama user, diikuti format kurung buka email
                $query->where('penulis', 'LIKE', $userName . ' (%)');
            })
            ->latest()
            ->get();

        return view('anggota.opini.index', compact('opinis'));
    }

    public function create()
    {
        return view('admin.opini.tambah');
    }

    public function create_anggota()
    {
        return view('anggota.opini.tambah');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'status' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'ringkasan' => 'nullable', // Diubah jadi nullable agar aman jika tag kosong
            'isi' => 'required',
            'foto' => 'nullable|image|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Jika ringkasan/tag kosong, beri tanda '-'
        if (empty($validated['ringkasan'])) {
            $validated['ringkasan'] = '-';
        }

        // Proses Foto
        if ($request->hasFile('foto')) {
            // Simpan ke storage dan ambil path-nya
            $pathFoto = $request->file('foto')->store('foto_opini', 'public');
            // Ambil hanya nama filenya saja (tanpa 'foto_opini/')
            $validated['foto'] = basename($pathFoto);
        }

        // Proses Lampiran
        if ($request->hasFile('lampiran')) {
            // Simpan ke storage dan ambil path-nya
            $pathLampiran = $request->file('lampiran')->store('file', 'public');
            // Ambil hanya nama filenya saja
            $validated['lampiran'] = basename($pathLampiran);
        }

        OpiniModel::create($validated);

        return redirect()->route('admin.opini.index')->with('success', 'Opini berhasil ditambahkan.');
    }

    public function store_anggota(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'ringkasan' => 'nullable', // Diubah menjadi nullable agar aman untuk tag
            'isi' => 'required',
            'foto' => 'nullable|image|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Format penulis menjadi "Nama (emailuser@gmail.com)"
        $validated['penulis'] = $request->penulis . ' (' . Auth::user()->email . ')';

        // Jika ringkasan/tag kosong, beri tanda '-'
        if (empty($validated['ringkasan'])) {
            $validated['ringkasan'] = '-';
        }

        // Proses File (Foto & Lampiran)
        if ($request->hasFile('foto')) {
            $validated['foto'] = basename($request->file('foto')->store('foto_opini', 'public'));
        }
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = basename($request->file('lampiran')->store('file', 'public'));
        }

        // Tambahkan status default jika ada
        $validated['status'] = 'draft';

        // Simpan data
        $opini = OpiniModel::create($validated);

        // Kirim Email ke penulis (menggunakan email user yang login)
        Mail::to(Auth::user()->email)->send(new OpiniDiterima($opini->judul, $opini->penulis));

        return redirect()->route('anggota.opini.index')->with('success', 'Opini berhasil ditambahkan dan notifikasi telah dikirim.');
    }

    public function updateStatus(Request $request, $id)
    {
        $opini = OpiniModel::findOrFail($id);

        // Ekstrak email dari dalam kurung di kolom 'penulis', misal: "herpendi (budi@gmail.com)" -> "budi@gmail.com"
        $emailTujuan = null;
        if (preg_match('/\((.*?)\)/', $opini->penulis, $match)) {
            $emailTujuan = $match[1];
        }

        // Fallback jika format email dalam kurung tidak ditemukan
        if (!$emailTujuan || !filter_var($emailTujuan, FILTER_VALIDATE_EMAIL)) {
            $emailTujuan = Auth::user()->email;
        }

        if ($request->status === 'publish') {
            $opini->update(['status' => 'publish']);

            // Kirim email publikasi ke email penulis yang terekstrak
            Mail::to($emailTujuan)->send(new OpiniDipublikasikan($opini));

            return back()->with('success', 'Opini berhasil dipublikasikan dan email notifikasi telah dikirim.');
        }

        if ($request->status === 'arsip') {
            $request->validate([
                'alasan_penolakan' => 'required|string|max:500'
            ]);

            $opini->update([
                'status' => 'arsip',
                'alasan' => $request->alasan_penolakan
            ]);

            // Kirim email penolakan beserta alasannya ke email penulis yang terekstrak
            Mail::to($emailTujuan)->send(new OpiniDitolak($opini, $request->alasan_penolakan));

            return back()->with('success', 'Opini ditolak/diarsipkan dan email alasan telah dikirim.');
        }

        return back()->with('error', 'Status tidak valid.');
    }

    public function destroy($id)
    {
        $opini = OpiniModel::findOrFail($id);
        if ($opini->foto) Storage::delete('public/' . $opini->foto);
        if ($opini->lampiran) Storage::delete('public/' . $opini->lampiran);
        $opini->delete();
        return back()->with('success', 'Opini dihapus.');
    }

    public function destroy_anggota($id)
    {
        $opini = OpiniModel::findOrFail($id);
        if ($opini->foto) Storage::delete('public/' . $opini->foto);
        if ($opini->lampiran) Storage::delete('public/' . $opini->lampiran);
        $opini->delete();
        return back()->with('success', 'Opini dihapus.');
    }

    public function edit($id_op)
    {
        // Mengambil data berdasarkan primary key yang Anda definisikan (id_op)
        $opini = OpiniModel::findOrFail($id_op);

        return view('admin.opini.edit', compact('opini'));
    }
    public function edit_anggota($id_op)
    {
        // Mengambil data berdasarkan primary key yang Anda definisikan (id_op)
        $opini = OpiniModel::findOrFail($id_op);

        return view('anggota.opini.edit', compact('opini'));
    }

    public function update(Request $request, $id_op)
    {
        $opini = OpiniModel::findOrFail($id_op);

        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'isi' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($opini->foto) {
                Storage::disk('public')->delete('foto_opini/' . $opini->foto);
            }
            $pathFoto = $request->file('foto')->store('foto_opini', 'public');
            $validated['foto'] = basename($pathFoto);
        }

        // Update Lampiran
        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($opini->lampiran) {
                Storage::disk('public')->delete('file/' . $opini->lampiran);
            }
            $pathLampiran = $request->file('lampiran')->store('file', 'public');
            $validated['lampiran'] = basename($pathLampiran);
        }

        $opini->update($validated);

        return redirect()->route('admin.opini.index')->with('success', 'Opini berhasil diupdate.');
    }

    public function update_anggota(Request $request, $id_op)
    {
        $opini = OpiniModel::findOrFail($id_op);

        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'isi' => 'required',
            'foto' => 'nullable|image|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($opini->foto) {
                Storage::disk('public')->delete('foto_opini/' . $opini->foto);
            }
            $pathFoto = $request->file('foto')->store('foto_opini', 'public');
            $validated['foto'] = basename($pathFoto);
        }

        // Update Lampiran
        if ($request->hasFile('lampiran')) {
            // Hapus file lama jika ada
            if ($opini->lampiran) {
                Storage::disk('public')->delete('file/' . $opini->lampiran);
            }
            $pathLampiran = $request->file('lampiran')->store('file', 'public');
            $validated['lampiran'] = basename($pathLampiran);
        }

        $opini->update($validated);

        return redirect()->route('anggota.opini.index')->with('success', 'Opini berhasil diupdate.');
    }

    public function storeKategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategoriBaru = trim($request->nama_kategori);

        // Tentukan path file di dalam storage/app/kategori.txt
        $filePath = 'kategori_opini.txt';

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
}
