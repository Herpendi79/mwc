<?php

namespace App\Http\Controllers;

use App\Models\BeritaCommentModel;
use App\Models\BeritaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = BeritaModel::with('komentar');

        // Pencarian berdasarkan judul berita
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $berita = $query->latest()->paginate(10)->withQueryString();

        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.tambah');
    }

    public function storeKategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategoriBaru = trim($request->nama_kategori);

        // Tentukan path file di dalam storage/app/kategori.txt
        $filePath = 'kategori_berita.txt';

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
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
            $pathFoto = $request->file('foto')->store('foto_berita', 'public');
            // Ambil hanya nama filenya saja (tanpa 'foto_opini/')
            $validated['foto'] = basename($pathFoto);
        }

        // Proses Lampiran
        if ($request->hasFile('lampiran')) {
            // Simpan ke storage dan ambil path-nya
            $pathLampiran = $request->file('lampiran')->store('file', 'public');
            // Ambil hanya nama filenya saja (tanpa 'file_opini/')
            $validated['lampiran'] = basename($pathLampiran);
        }

        BeritaModel::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id_op)
    {
        // Mengambil data berdasarkan primary key yang Anda definisikan (id_op)
        $opini = BeritaModel::findOrFail($id_op);

        return view('admin.berita.edit', compact('opini'));
    }

    public function update(Request $request, $id_op)
    {
        $opini = BeritaModel::findOrFail($id_op);

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
                Storage::disk('public')->delete('foto_berita/' . $opini->foto);
            }
            $pathFoto = $request->file('foto')->store('foto_berita', 'public');
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

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function updateStatus(Request $request, $id)
    {
        $opini = BeritaModel::findOrFail($id);
        $opini->update(['status' => $request->status]);
        return back()->with('success', 'Status berhasil diupdate.');
    }

    public function destroy($id)
    {
        $opini = BeritaModel::findOrFail($id);
        if ($opini->foto) Storage::delete('public/' . $opini->foto);
        if ($opini->lampiran) Storage::delete('public/' . $opini->lampiran);
        $opini->delete();
        return back()->with('success', 'Berita dihapus.');
    }

    public function beritaKegiatanDetil($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $dataBerita = BeritaModel::where('id_br', $id)->firstOrFail();

        $archives = BeritaModel::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $tags = BeritaModel::where('status', 'publish')
            ->pluck('ringkasan')
            ->flatMap(function ($ringkasan) {
                return array_map('trim', explode(',', $ringkasan));
            })
            ->filter(function ($tag) {
                return !empty($tag) && $tag !== '-';
            })
            ->countBy()
            ->sortDesc()
            ->take(10);


        $kategoriList = BeritaModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = BeritaModel::where('status', 'publish')->latest()->take(4)->get();
        $beritaPosts = BeritaModel::whereNotNull('judul')->latest()->get();

        return view('admin.berita.berita_detil', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function replyKomentar(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $komentar = BeritaCommentModel::findOrFail($id);
        $komentar->update([
            'reply' => $request->reply,
        ]);

        // Jika request dari AJAX, kembalikan response JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Balasan berhasil dikirim.',
                'reply' => $komentar->reply,
                'id_com' => $komentar->id_com
            ]);
        }

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
}
