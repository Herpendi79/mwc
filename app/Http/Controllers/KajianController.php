<?php

namespace App\Http\Controllers;

use App\Models\KajianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KajianController extends Controller
{
    // Menampilkan daftar kajian
    public function index(Request $request)
    {
        $query = KajianModel::latest();

        // Filter pencarian live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('tema', 'like', '%' . $search . '%')
                    ->orWhere('pemateri', 'like', '%' . $search . '%')
                    ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }

        $kajian = $query->paginate(10)->withQueryString();

        return view('admin.kajian.index', compact('kajian'));
    }

    public function index_anggota()
    {
        $kajian = KajianModel::where('status', 'publish')->latest()->get();
        return view('anggota.kajian.index', compact('kajian'));
    }

    // Menampilkan form tambah kajian
    public function create()
    {
        return view('admin.kajian.tambah');
    }

    // Menyimpan data kajian baru
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'judul' => 'required',
            'tema' => 'required',
            'tanggal' => 'required|date',
            'pemateri' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'poster' => 'nullable|image',
            'materi' => 'nullable|file', // Validasi file materi
            'foto.*' => 'image',
        ]);

        $data = $request->except(['poster', 'materi', 'foto']);
        $data['status'] = 'draft';

        // Upload Poster
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('foto_kajian', 'public');
            $data['poster'] = basename($posterPath);
        }

        // Upload Materi
        if ($request->hasFile('materi')) {
            $file = $request->file('materi');

            // Buat nama file unik agar tidak tertimpa
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // Tentukan path tujuan: public/assets/file/
            $destinationPath = public_path('assets/file');

            // Pindahkan file
            $file->move($destinationPath, $namaFile);

            // Simpan path relatif ke database
            $data['materi'] = $namaFile;
        }

        // Upload Galeri Foto
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_kajian', 'public');
                $fotoNames[] = basename($path);
            }
            $data['foto'] = implode(';', $fotoNames);
        }

        KajianModel::create($data);

        return redirect()->route('admin.kajian.index')->with('success', 'Data Kajian berhasil disimpan!');
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $kajian = KajianModel::findOrFail($id);
        return view('admin.kajian.edit', compact('kajian'));
    }

    // Memperbarui data kajian
    public function update(Request $request, $id)
    {
        $kajian = KajianModel::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required',
            'tema' => 'required',
            'tanggal' => 'required|date',
            'pemateri' => 'required',
            'lokasi' => 'required',
            'deskripsi' => 'required',
            'poster' => 'nullable|image',
            'materi' => 'nullable|file',
            'foto.*' => 'image',
        ]);

        $data = $request->except(['poster', 'materi', 'foto']);



        // 2. Update Materi (Hapus lama, simpan baru di public/assets/file)
        if ($request->hasFile('materi')) {
            if ($kajian->materi && file_exists(public_path('assets/file/' . $kajian->materi))) {
                unlink(public_path('assets/file/' . $kajian->materi));
            }

            $file = $request->file('materi');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/file'), $namaFile);
            $data['materi'] = $namaFile;
        }

        // 1. Update Poster
        if ($request->hasFile('poster')) {
            if ($kajian->poster) {
                // Hapus file lama di folder foto_kajian
                Storage::disk('public')->delete('foto_kajian/' . $kajian->poster);
            }

            // Simpan file baru ke storage/app/public/foto_kajian
            $path = $request->file('poster')->store('foto_kajian', 'public');
            // Ambil hanya nama filenya saja
            $data['poster'] = basename($path);
        }

        // 2. Update Galeri Foto
        if ($request->hasFile('foto')) {
            // Hapus foto-foto lama
            if ($kajian->foto) {
                $oldPhotos = explode(';', $kajian->foto);
                foreach ($oldPhotos as $oldPhoto) {
                    Storage::disk('public')->delete('foto_kajian/' . $oldPhoto);
                }
            }

            // Simpan foto-foto baru
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                // Simpan ke storage/app/public/foto_kajian
                $path = $file->store('foto_kajian', 'public');
                // Simpan hanya nama filenya ke array
                $fotoPaths[] = basename($path);
            }
            // Gabungkan dengan ;
            $data['foto'] = implode(';', $fotoPaths);
        }

        $kajian->update($data);

        return redirect()->route('admin.kajian.index')->with('success', 'Data Kajian berhasil diupdate!');
    }

    // Menghapus data
    public function destroy($id)
    {
        $kajian = KajianModel::findOrFail($id);

        // 1. Hapus Poster (dari storage/app/public/foto_kajian)
        if ($kajian->poster && Storage::disk('public')->exists('foto_kajian/' . $kajian->poster)) {
            Storage::disk('public')->delete('foto_kajian/' . $kajian->poster);
        }

        // 2. Hapus Materi (dari public/assets/file/)
        if ($kajian->materi && file_exists(public_path('assets/file/' . $kajian->materi))) {
            unlink(public_path('assets/file/' . $kajian->materi));
        }

        // 3. Hapus Galeri Foto (dari storage/app/public/foto_kajian)
        if ($kajian->foto) {
            $oldPhotos = explode(';', $kajian->foto);
            foreach ($oldPhotos as $oldPhoto) {
                if (Storage::disk('public')->exists('foto_kajian/' . trim($oldPhoto))) {
                    Storage::disk('public')->delete('foto_kajian/' . trim($oldPhoto));
                }
            }
        }

        // 4. Hapus Record dari Database
        $kajian->delete();

        return redirect()->route('admin.kajian.index')->with('success', 'Data Kajian beserta file terkait berhasil dihapus!');
    }

    // Mengubah status (Sesuai gaya Halaqah)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,publish,arsip',
        ]);

        $kajian = KajianModel::findOrFail($id);
        $kajian->status = $request->status;
        $kajian->save();

        return redirect()->route('admin.kajian.index')
            ->with('success', 'Status berhasil diubah menjadi ' . ucfirst($request->status));
    }
}
