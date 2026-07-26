<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SampahModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage; // Tambahkan ini di bagian atas
use App\Mail\SampahTerkirimMail;

class SampahController extends Controller
{
    public function index()
    {
        // Mengambil data sampah diurutkan dari yang terbaru
        $sampahs = SampahModel::latest()->paginate(10);
        return view('admin.sampah.index', compact('sampahs'));
    }

    public function index_anggota()
    {
        // Mengambil data sampah diurutkan dari yang terbaru
        $sampahs = SampahModel::latest()->paginate(10);
        return view('anggota.sampah.index', compact('sampahs'));
    }

    public function create()
    {
        return view('admin.sampah.tambah');
    }

    public function create_anggota()
    {
        return view('anggota.sampah.tambah');
    }

    public function storeSampah(Request $request)
    {
        // 1. Tentukan aturan validasi dasar
        $rules = [
            'jenis_sedekah' => 'required|in:sampah,pengelolaan',
            'nilai'         => 'required|numeric',
            'petugas'       => 'required|string',
            'tgl'           => 'required|date',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ket'           => 'nullable|string',
        ];

        // 2. Kondisi validasi berdasarkan opsi jenis sedekah
        // Jika opsi yang dipilih adalah sampah, maka jenis dan berat wajib diisi
        if ($request->input('jenis_sedekah') === 'sampah') {
            $rules['jenis'] = 'required|string';
            $rules['berat'] = 'required|numeric';
        } else {
            $rules['jenis'] = 'nullable|string';
            $rules['berat'] = 'nullable|numeric';
        }

        // 3. Eksekusi validasi
        $validated = $request->validate($rules);

        // 4. Penyesuaian data jika mode pengelolaan
        // Isi nilai jenis dengan string default dan berat dengan 0 agar database tidak error
        if ($request->input('jenis_sedekah') === 'pengelolaan') {
            $validated['jenis'] = 'Biaya Pengelolaan';
            $validated['berat'] = 0;
        }

        // 5. Override/Tambahkan nama penyetor mutlak dari user yang sedang login
        $validated['penyetor'] = Auth::user()->name;

        // 6. Handle File Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke storage/app/public/foto_sampah
            $file->storeAs('foto_sampah', $filename, 'public');

            // Simpan hanya nama filenya ke array validated
            $validated['foto'] = $filename;
        }

        // 7. Simpan ke database
        $sampah = SampahModel::create($validated);

        // 8. Kirim Email Konfirmasi
        // Pastikan Model User memiliki kolom 'email' dan mailer sudah dikonfigurasi
        Mail::to(Auth::user()->email)->send(new SampahTerkirimMail($validated));

        // 9. Redirect kembali ke halaman index anggota
        return redirect()->route('anggota.sampah.index')
            ->with('success', 'Data sampah berhasil disimpan dan email konfirmasi telah dikirim.');
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_sedekah' => 'required|in:sampah,pengelolaan',
            'nilai'         => 'required|numeric',
            'petugas'       => 'required|string',
            'penyetor'       => 'required|string',
            'tgl'           => 'required|date',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ket'           => 'nullable|string',
        ];

        // Jika opsi yang dipilih adalah sampah, maka jenis dan berat wajib diisi
        if ($request->input('jenis_sedekah') === 'sampah') {
            $rules['jenis'] = 'required|string';
            $rules['berat'] = 'required|numeric';
        } else {
            $rules['jenis'] = 'nullable|string';
            $rules['berat'] = 'nullable|numeric';
        }

        $validated = $request->validate($rules);

        // Jika mode pengelolaan, isi nilai jenis dengan tanda atau string kosong
        // agar tidak error "Column 'jenis' cannot be null" di database
        if ($request->input('jenis_sedekah') === 'pengelolaan') {
            $validated['jenis'] = 'Biaya Pengelolaan'; // atau '' sesuaikan kebutuhan database
            $validated['berat'] = 0;   // berikan default angka 0 untuk berat
        }

        // 2. Tambahkan nama penyetor dari user login
       // $validated['penyetor'] = Auth::user()->name;

        // 3. Handle File Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke storage/app/public/foto_sampah
            $file->storeAs('foto_sampah', $filename, 'public');

            // Simpan hanya nama filenya ke database
            $validated['foto'] = $filename;
        }

        // 4. Simpan ke database
        $sampah = SampahModel::create($validated);

        return redirect()->route('admin.sampah.index')->with('success', 'Data berhasil ditambah!');
    }

    public function edit($id_sm)
    {
        $sampah = SampahModel::findOrFail($id_sm);
        return view('admin.sampah.edit', compact('sampah'));
    }

    public function update(Request $request, $id_sm)
    {
        $sampah = SampahModel::findOrFail($id_sm);

        $validated = $request->validate([
            'penyetor' => 'required|string|max:255',
            'jenis'    => 'required|string|max:100',
            'berat'    => 'required|numeric',
            'nilai'    => 'required|numeric',
            'tgl'      => 'required|date',
            'petugas'  => 'required|string|max:255',
            'ket'      => 'nullable|string',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle update foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($sampah->foto) {
                Storage::disk('public')->delete('foto_sampah/' . $sampah->foto);
            }
            // Simpan foto baru
            $path = $request->file('foto')->store('foto_sampah', 'public');
            $validated['foto'] = basename($path);
        }

        $sampah->update($validated);

        return redirect()->route('admin.sampah.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id_sm)
    {
        // 1. Cari data berdasarkan ID
        $sampah = SampahModel::findOrFail($id_sm);

        // 2. Hapus file foto dari storage jika ada
        if ($sampah->foto) {
            // 'foto_sampah/' adalah folder tempat Anda menyimpan foto
            Storage::disk('public')->delete('foto_sampah/' . $sampah->foto);
        }

        // 3. Hapus data dari database
        $sampah->delete();

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.sampah.index')->with('success', 'Data sampah berhasil dihapus!');
    }
}
