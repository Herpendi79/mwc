<?php

namespace App\Http\Controllers;

use App\Mail\DonasiBerhasilMail;
use Illuminate\Http\Request;
use App\Models\MangroveModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MangroveController extends Controller
{
    public function index()
    {
        // Mengambil data terbaru dan melakukan pagination
        $mangroves = MangroveModel::latest()->paginate(10);
        $hargaMangrove = Storage::exists('harga_mangrove.txt') ? Storage::get('harga_mangrove.txt') : 0;
        return view('admin.mangrove.index', compact('mangroves', 'hargaMangrove'));
    }

    public function updateHarga(Request $request)
    {
        $request->validate(['harga' => 'required|numeric']);

        // Simpan harga ke file txt di storage/app/harga_mangrove.txt
        Storage::put('harga_mangrove.txt', $request->harga);

        return redirect()->back()->with('success', 'Harga mangrove berhasil diperbarui.');
    }

    public function index_anggota()
    {
        // Mengambil data terbaru dan melakukan pagination
        $mangroves = MangroveModel::latest()->paginate(10);
        return view('anggota.mangrove.index', compact('mangroves'));
    }

    public function create()
    {
        return view('admin.mangrove.tambah');
    }

    public function create_anggota()
    {
        $hargaMangrove = Storage::exists('harga_mangrove.txt') ? Storage::get('harga_mangrove.txt') : 5000;

        // Ambil data rekening
        $rekening = Storage::exists('rekening.txt')
            ? json_decode(Storage::get('rekening.txt'), true)
            : ['bank' => '-', 'no_rek' => '-', 'an' => '-'];

        return view('anggota.mangrove.tambah', compact('hargaMangrove', 'rekening'));
    }

    public function storeInfaq(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'jumlah_pohon' => 'required|integer|min:1',
            'jumlah_infaq' => 'required|numeric',
            'pembayaran'   => 'required|in:tunai,transfer',
            'tanggal'      => 'required|date',
            'bukti_tf'     => 'required_if:pembayaran,transfer|image|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // 2. Siapkan data dasar
        $user = Auth::user();
        $data = [
            'donatur'      => $user->name,
            'email'        => $user->email,
            'jumlah_pohon' => $request->jumlah_pohon,
            'jumlah_infaq' => $request->jumlah_infaq,
            'pembayaran'   => $request->pembayaran,
            'tanggal'      => $request->tanggal,
        ];

        // 3. Generate Nomor Sertifikat
        $tanggalInput = \Carbon\Carbon::parse($request->tanggal);
        $formatTanggal = $tanggalInput->format('Ymd');

        $lastRecord = MangroveModel::whereDate('tanggal', $tanggalInput->toDateString())
            ->orderBy('id', 'desc')->first();

        $newNumber = $lastRecord ? str_pad((int) substr($lastRecord->no_sertifikat, -3) + 1, 3, '0', STR_PAD_LEFT) : '001';
        $data['no_sertifikat'] = 'MNG-' . $formatTanggal . '-' . $newNumber;

        // 4. Proses Upload Bukti Transfer
        if ($request->hasFile('bukti_tf')) {
            $file = $request->file('bukti_tf');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke storage/app/public/bukti_tf
            $file->storeAs('bukti_tf', $filename, 'public');

            // Simpan hanya nama filenya
            $data['bukti_tf'] = $filename;
        }

        // 5. Simpan ke database
        $donasi = MangroveModel::create($data);

        // 6. Kirim Email Ucapan Terima Kasih
        Mail::to($user->email)->send(new DonasiBerhasilMail($user->name, $data['no_sertifikat']));

        // 7. Redirect dengan pesan sukses
        return redirect()->route('anggota.mangrove.index')
            ->with('success', 'Infaq Mangrove berhasil disimpan dan email konfirmasi telah dikirim.');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $validated = $request->validate([
            'donatur'       => 'required|string|max:255',
            'email'         => 'required|email',
            'jumlah_infaq'  => 'required|numeric',
            'jumlah_pohon'  => 'required|integer',
            'pembayaran'    => 'required|in:tunai,transfer',
            'tanggal'       => 'required|date',
        ]);

        // 2. Generate Nomor Sertifikat Otomatis
        $tanggalInput = \Carbon\Carbon::parse($request->tanggal);
        $formatTanggal = $tanggalInput->format('Ymd');

        // Cari data terakhir di tanggal yang sama untuk mendapatkan urutan
        $lastRecord = MangroveModel::whereDate('tanggal', $tanggalInput->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->no_sertifikat) {
            // Ambil 3 digit terakhir dari no_sertifikat (misal: ...-001 jadi 001)
            $lastNumber = (int) substr($lastRecord->no_sertifikat, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada record di tanggal tersebut, mulai dari 001
            $newNumber = '001';
        }

        $validated['no_sertifikat'] = 'MNG-' . $formatTanggal . '-' . $newNumber;

        // 3. Simpan ke Database
        MangroveModel::create($validated);

        // 4. Redirect
        return redirect()->route('admin.mangrove.index')
            ->with('success', 'Data donasi berhasil disimpan dengan No. Sertifikat: ' . $validated['no_sertifikat']);
    }



    public function edit($id)
    {
        $mangrove = MangroveModel::findOrFail($id);
        return view('admin.mangrove.edit', compact('mangrove'));
    }

    public function update(Request $request, $id)
    {
        $mangrove = MangroveModel::findOrFail($id);

        $validated = $request->validate([
            'donatur' => 'required|string|max:255',
            'email'   => 'required|email',
            'jumlah_infaq' => 'required|numeric',
            'jumlah_pohon' => 'required|integer',
            'pembayaran'   => 'required|in:tunai,transfer',
            'tanggal'      => 'required|date',
        ]);

        $mangrove->update($validated);

        return redirect()->route('admin.mangrove.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $mangrove = MangroveModel::findOrFail($id);
        $mangrove->delete();

        return redirect()->route('admin.mangrove.index')->with('success', 'Data berhasil dihapus!');
    }

    public function downloadSertifikat($id)
    {
        $mangrove = MangroveModel::findOrFail($id);
        return view('components.sertifikat_mangrove', compact('mangrove'));
    }

    public function updateSertifikat(Request $request)
    {
        // Validasi agar hanya menerima file bertipe gambar dengan ukuran maksimal 2MB
        $request->validate([
            'sertifikat' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $file = $request->file('sertifikat');

        // Tentukan direktori tujuan: public/assets/images/sertifikat/
        $destinationPath = public_path('assets/images/sertifikat');

        // Pastikan folder tujuan ada
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Ambil ekstensi asli dari file yang di-upload (misal: png, jpg, jpeg, webp)
        $extension = $file->getClientOriginalExtension();

        // Cek apakah sudah ada file dengan nama utama 'Sertifikat.*' di folder tersebut
        $existingFiles = glob($destinationPath . '/Sertifikat.*');

        if (!empty($existingFiles)) {
            foreach ($existingFiles as $oldFile) {
                // Ambil ekstensi dari file lama yang ditemukan
                $oldExtension = pathinfo($oldFile, PATHINFO_EXTENSION);

                // Buat nama backup yang unik dengan format "Sertifikat_backup_[timestamp]"
                $uniqueBackupName = 'Sertifikat_backup_' . time() . '_' . uniqid() . '.' . $oldExtension;
                $backupFilePath = $destinationPath . '/' . $uniqueBackupName;

                // Rename/pindahkan file lama ke nama unik cadangan
                File::move($oldFile, $backupFilePath);
            }
        }

        // Tentukan nama file baru dengan nama dasar 'Sertifikat' dan ekstensi dinamis
        $mainFileName = 'Sertifikat.' . $extension;

        // Pindahkan file baru yang di-upload ke folder tujuan
        $file->move($destinationPath, $mainFileName);

        return back()->with('success', 'Template sertifikat berhasil diperbarui.');
    }
}
