<?php

namespace App\Http\Controllers;

use App\Mail\LaporanBencanaMail;
use App\Mail\OpiniDiterima;
use App\Models\BahsulModel;
use App\Models\BeritaCommentModel;
use App\Models\BeritaModel;
use App\Models\DakwahModel;
use App\Models\HalaqahModel;
use App\Models\KajianModel;
use App\Models\KhutbahModel;
use App\Models\MangroveModel;
use App\Models\OpiniModel;
use App\Models\PesertaBahsulModel;
use App\Models\RelawanModel;
use App\Models\RoanModel;
use App\Models\SampahModel;
use App\Mail\PendaftaranBahsulMail;
use App\Mail\PendaftaranHalaqahMail;
use App\Mail\PendaftaranRelawanMail;
use App\Mail\PendaftaranRoanMail;
use App\Mail\SampahTerkirimMail;
use App\Models\BencanaModel;
use App\Models\PesertaHalaqahModel;
use App\Models\PesertaRelawanModel;
use App\Models\PesertaRoanModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FreeUserController extends Controller
{
    public function index_free()
    {
        $dataBerita = BeritaModel::where('status', 'publish')->latest()->get();
        $dataKajian = KajianModel::where('status', 'publish')
            ->orderBy('tanggal', 'desc')
            ->get();
        $dataHalaqah = HalaqahModel::where('status', 'publish')->latest()->get();
        $dataDakwah = DakwahModel::where('status', 'publish')
            ->where('judul', 'LIKE', '%-%')
            ->where('kategori', 'LIKE', '%-%')
            ->where('poster', 'LIKE', '%-%')
            ->latest()
            ->first();

        $roans = RoanModel::withCount('peserta')->latest('tgl')->get();
        $relawans = RelawanModel::latest()->get();

        // Tambahkan data mangrove di sini
        $mangroves = MangroveModel::latest()->get();

        $sampahs = SampahModel::latest()->get();

        $opinis = OpiniModel::latest()->take(3)->get();

        $khutbahs = KhutbahModel::where('tema', '!=', '-')
            ->where('khatib', '!=', '-')
            ->where('masjid', '!=', '-')
            ->where('ringkasan', '!=', '-')
            ->where('isi', '!=', '-')
            ->latest()
            ->take(10)
            ->get();

        // Di dalam index_free()
        $dataDakwahfree = DakwahModel::where('status', 'publish')
            ->where('judul', '!=', '-')
            ->where('kategori', '!=', '-')
            ->where('poster', '!=', '-')
            ->latest()
            ->get();

        $kajian = KajianModel::latest()->first();

        $dataOpini = OpiniModel::latest()->take(6)->get();

        return view('index', compact(
            'dataKajian',
            'dataHalaqah',
            'dataDakwah',
            'dataDakwahfree',
            'roans',
            'relawans',
            'mangroves',
            'sampahs',
            'opinis',
            'khutbahs',
            'kajian',
            'dataOpini',
            'dataBerita',

        ));
    }

    public function sedekahSampah()
    {
        // Mengambil data terbaru dan melakukan pagination
        $sampahs = SampahModel::latest()->paginate(10);

        $recentPosts = SampahModel::latest()->take(4)->get();

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];
        $semuaJudul = SampahModel::pluck('penyetor');
        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        return view('sampah', compact('sampahs', 'recentPosts', 'tags'));
    }

    public function storeSampah(Request $request)
    {
        $rules = [
            'jenis_sedekah' => 'required|in:sampah,pengelolaan',
            'nilai'         => 'required|numeric',
            'petugas'       => 'required|string',
            'penyetor'      => 'required|string',
            'email'         => 'required|email', // Validasi email wajib untuk pengiriman pesan
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

        // Set otomatis tanggal menjadi hari ini (abaikan input tanggal dari luar jika ada)
        $validated['tgl'] = Carbon::today()->toDateString();

        // Jika mode pengelolaan, isi nilai jenis dengan keterangan dan berat default 0
        if ($request->input('jenis_sedekah') === 'pengelolaan') {
            $validated['jenis'] = 'Biaya Pengelolaan';
            $validated['berat'] = 0;
        }

        // Handle File Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke storage/app/public/foto_sampah
            $file->storeAs('foto_sampah', $filename, 'public');

            // Simpan hanya nama filenya ke database
            $validated['foto'] = $filename;
        }

        // Ambil nilai email untuk tujuan pengiriman, lalu hapus dari array $validated
        // agar tidak ikut tersimpan ke tabel database (karena kolom email tidak ada di tabel)
        $emailTujuan = $validated['email'];
        unset($validated['email']);

        // Simpan ke database tanpa kolom email
        $sampah = SampahModel::create($validated);

        // Kirim Email Konfirmasi ke email yang diinputkan
        Mail::to($emailTujuan)->send(new SampahTerkirimMail($validated));

        return redirect()->route('sampah')->with('success', 'Data berhasil ditambah dan email konfirmasi terkirim!');
    }

    public function infaqMangrove()
    {
        // Mengambil data terbaru dan melakukan pagination
        $mangroves = MangroveModel::latest()->paginate(10);
        $hargaMangrove = Storage::exists('harga_mangrove.txt') ? Storage::get('harga_mangrove.txt') : 0;

        $recentPosts = MangroveModel::latest()->take(4)->get();

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];
        $semuaJudul = MangroveModel::pluck('donatur');
        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        return view('mangrove', compact('mangroves', 'hargaMangrove', 'recentPosts', 'tags'));
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
        $tanggalInput = Carbon::parse($request->tanggal);
        $formatTanggal = $tanggalInput->format('Ymd');

        // Cari data terakhir di tanggal yang sama untuk mendapatkan urutan
        $lastRecord = MangroveModel::whereDate('tanggal', $tanggalInput->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord && $lastRecord->no_sertifikat) {
            // Ambil 3 digit terakhir dari no_sertifikat
            $lastNumber = (int) substr($lastRecord->no_sertifikat, -3);
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika belum ada record di tanggal tersebut, mulai dari 001
            $newNumber = '001';
        }

        $validated['no_sertifikat'] = 'MNG-' . $formatTanggal . '-' . $newNumber;

        // 3. Simpan ke Database
        $mangrove = MangroveModel::create($validated);

        // 4. Generate Sertifikat PDF untuk Lampiran Email
        try {
            $pdfData = [
                'mangrove' => $mangrove
            ];

            // Load view template sertifikat (misal: emails.sertifikat_pdf)
            $pdf = Pdf::loadView('emails.sertifikat_pdf', $pdfData)
                ->setPaper('a4', 'landscape');

            $tempPath = storage_path('app/public/temp');

            if (!File::isDirectory($tempPath)) {
                File::makeDirectory($tempPath, 0777, true, true);
            }

            $fileName = 'Sertifikat_Mangrove_' . $mangrove->no_sertifikat . '_' . Str::slug($mangrove->donatur) . '.pdf';
            $attachmentPath = $tempPath . '/' . $fileName;

            $pdf->save($attachmentPath);

            // 5. Kirim Email Notifikasi beserta Lampiran Sertifikat
            Mail::send('emails.infaq_sukses', ['mangrove' => $mangrove], function ($message) use ($mangrove, $attachmentPath) {
                $message->to($mangrove->email, $mangrove->donatur)
                    ->subject('Sertifikat Infaq Mangrove - MWC NU Tugu Semarang')
                    ->attach($attachmentPath, [
                        'as' => 'Sertifikat_Infaq_Mangrove.pdf',
                        'mime' => 'application/pdf',
                    ]);
            });

            // Hapus file temporary setelah email terkirim (opsional)
            if (file_exists($attachmentPath)) {
                @unlink($attachmentPath);
            }
        } catch (\Exception $e) {
            // Tangani error jika pengiriman email gagal, data infaq tetap tersimpan
            Log::error('Gagal kirim email sertifikat: ' . $e->getMessage());
        }

        // 6. Redirect dengan Pesan Sukses
        return redirect()->route('mangrove')
            ->with('success', 'Infaq berhasil disimpan, sertifikat telah dikirimkan ke email Anda.');
    }

    public function beritaKajian(Request $request)
    {
        $query = KajianModel::where('status', 'publish');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('tema', 'LIKE', "%{$keyword}%")
                    ->orWhere('pemateri', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('created_at', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI (sesuaikan kolom tanggal, misal: tanggal atau created_at) ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        $dataKajian = $query->latest()->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataKajian->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = KajianModel::select('judul', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('judul')
            ->get();

        $recentPosts = KajianModel::where('status', 'publish')->latest()->take(4)->get();

        $semuaJudul = KajianModel::where('status', 'publish')->pluck('tema');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        arsort($tags);
        $tags = array_slice($tags, 0, 15);

        $archives = KajianModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = KajianModel::latest()->take(6)->get();

        $materiPosts = KajianModel::whereNotNull('materi')->latest()->get();

        return view('kajian', compact('dataKajian', 'recentPosts', 'kategoriList', 'archives', 'tags', 'materiPosts', 'listKajian'));
    }

    public function beritaKegiatan(Request $request)
    {
        $query = BeritaModel::where('status', 'publish');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('kategori', 'LIKE', "%{$keyword}%")
                    ->orWhere('penulis', 'LIKE', "%{$keyword}%")
                    ->orWhere('isi', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun);
        }

        $dataBerita = $query->latest()->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataBerita->appends($request->only(['keyword', 'bulan', 'tahun']));

        // Di dalam method controller yang memuat view 'berita'
        $kategoriList = BeritaModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = BeritaModel::where('status', 'publish')->latest()->take(4)->get();

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

        $listBerita = BeritaModel::latest()->take(6)->get();

        $beritaPosts = BeritaModel::whereNotNull('judul')->latest()->get();

        return view('berita', compact('dataBerita', 'recentPosts', 'kategoriList', 'archives', 'tags', 'beritaPosts', 'listBerita'));
    }

    public function beritaKegiatanDetil($id)
    {
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

        return view('berita_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function opiniWargaDetil($id)
    {
        $dataBerita = OpiniModel::where('id_op', $id)->firstOrFail();

        $archives = OpiniModel::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $tags = OpiniModel::where('status', 'publish')
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


        $kategoriList = OpiniModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = OpiniModel::where('status', 'publish')->latest()->take(4)->get();
        $beritaPosts = OpiniModel::whereNotNull('judul')->latest()->get();

        return view('opini_detil', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function opiniCreate()
    {
        return view('opini_create');
    }

    public function opiniStoreFreeUser(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'email' => 'required|email', // Tambahkan validasi email dari form
            'ringkasan' => 'nullable',
            'isi' => 'required',
            'foto' => 'nullable|image|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Format penulis menjadi "Nama (email_dari_form)"
        $validated['penulis'] = $request->penulis . ' (' . $request->email . ')';

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

        // Simpan data ke database
        $opini = OpiniModel::create($validated);

        // Simpan ID opini yang baru ditambah dan email ke file penulis_opini.txt di storage/app/private
        $logData = "ID Opini: " . $opini->id_op . " | Email: " . $request->email . PHP_EOL;
        \Illuminate\Support\Facades\Storage::disk('local')->append('penulis_opini.txt', $logData);

        // Kirim Email ke email yang diinput dari form
        \Illuminate\Support\Facades\Mail::to($request->email)->send(new OpiniDiterima($opini->judul, $opini->penulis));

        return redirect()->route('opini_warga')->with('success', 'Opini berhasil ditambahkan dan notifikasi telah dikirim.');
    }

    public function storeKomentar(Request $request, $id)
    {
        // Validasi sesuai form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|string',
            'website' => 'nullable|string|max:255',
        ]);

        BeritaCommentModel::create([
            'id_br' => $id,
            'nama' => $request->name,
            'email' => $request->email,
            'isi' => $request->comment,
            'sosmed' => $request->website,
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
    public function opiniWarga(Request $request)
    {
        $query = OpiniModel::where('status', 'publish');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('kategori', 'LIKE', "%{$keyword}%")
                    ->orWhere('penulis', 'LIKE', "%{$keyword}%")
                    ->orWhere('ringkasan', 'LIKE', "%{$keyword}%")
                    ->orWhere('created_at', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun);
        }

        $dataOpini = $query->latest()->paginate(4);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataOpini->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = OpiniModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = OpiniModel::where('status', 'publish')->latest()->take(4)->get();

        $tags = OpiniModel::where('status', 'publish')
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

        $archives = OpiniModel::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $materiPosts = OpiniModel::whereNotNull('lampiran')->latest()->get();

        return view('opini', compact('dataOpini', 'recentPosts', 'kategoriList', 'archives', 'tags', 'materiPosts'));
    }

    public function programBencana(Request $request)
    {
        $query = BencanaModel::where('status', 'publish')->latest();

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('jenis_bencana', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('kebutuhan', 'LIKE', "%{$keyword}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$keyword}%"); // Pencarian tanggal
            });
        }

        $dataBahsul = $query->orderBy('tgl', 'desc')->paginate(5);

        // Mempertahankan query string saat berpindah halaman pagination
        $dataBahsul->appends(['keyword' => $request->keyword]);

        // Di dalam method controller yang memuat view 'berita'
        $kategoriList = BencanaModel::select('jenis_bencana', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('jenis_bencana')
            ->get();

        $recentPosts = BencanaModel::where('status', 'publish')->latest()->take(4)->get();

        $semuaJudul = BencanaModel::where('status', 'publish')->pluck('jenis_bencana');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        // Urutkan berdasarkan yang paling sering muncul
        arsort($tags);
        // Batasi hanya ambil 10-15 tag teratas
        $tags = array_slice($tags, 0, 15);

        $archives = BencanaModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = BencanaModel::latest()->take(6)->get();

        // $materiPosts = RoanModel::whereNotNull('lampiran')->latest()->get();

        return view('bencana', compact('dataBahsul', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listKajian'));
    }

    public function storeBencana(Request $request)
    {
        // 1. Validasi input termasuk pelapor dan email
        $validated = $request->validate([
            'pelapor'       => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'jenis_bencana' => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'tgl'           => 'required|date',
            'deskripsi'     => 'required|string',
            'kebutuhan'     => 'required|string',
            'jml_korban'    => 'required|integer',
            'foto.*'        => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // 2. Format ulang kolom pelapor menjadi: Nama Pelapor (email@domain.com)
        $validated['pelapor'] = $request->pelapor . ' (' . $request->email . ')';

        // 3. Proses upload banyak foto
        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $file) {
                $path = $file->store('foto_bencana', 'public');
                $fotoNames[] = basename($path);
            }
            $validated['foto'] = implode(';', $fotoNames);
        }

        // 4. Simpan ke database
        $bencana = BencanaModel::create($validated);

        // 5. Kirim Email Notifikasi menggunakan email dari inputan form
        try {
            Mail::to($request->email)->send(new LaporanBencanaMail([
                'name'          => $request->pelapor,
                'jenis_bencana' => $validated['jenis_bencana'],
                'jml_korban'    => $validated['jml_korban'],
                'lokasi'        => $validated['lokasi']
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email laporan bencana: " . $e->getMessage());
        }

        return redirect()->route('bencana')->with('success', 'Laporan bencana berhasil dikirim dan menunggu verifikasi Tim. Terima kasih atas laporan Anda.');
    }

    public function programRelawan(Request $request)
    {
        $query = RelawanModel::query();

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('koordinator', 'LIKE', "%{$keyword}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tgl', $request->bulan)
                ->whereYear('tgl', $request->tahun);
        }

        $dataBahsul = $query->orderBy('tgl', 'desc')->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataBahsul->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = RelawanModel::select('judul', DB::raw('count(*) as total'))
            ->groupBy('judul')
            ->get();

        $recentPosts = RelawanModel::latest()->take(4)->get();

        $semuaJudul = RelawanModel::pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        arsort($tags);
        $tags = array_slice($tags, 0, 15);

        $archives = RelawanModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = RelawanModel::latest()->take(6)->get();

        return view('relawan', compact('dataBahsul', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listKajian'));
    }

    public function programRelawanDaftar(Request $request, $id_re)
    {
        // 1. Validasi input dari form pendaftaran umum
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'alamat' => 'required|string',
            'telpon' => 'required|string|max:20',
        ]);

        // 2. Ambil data relawan utama
        $relawan = RelawanModel::findOrFail($id_re);

        // 3. Cek apakah email tersebut sudah terdaftar di kegiatan ini agar tidak duplikat
        $sudahDaftar = PesertaRelawanModel::where('id_re', $id_re)
            ->where('email', $validated['email'])
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Email ini sudah terdaftar di kegiatan relawan ini.');
        }

        // 4. Simpan ke tabel peserta
        PesertaRelawanModel::create([
            'name'   => $validated['name'],
            'alamat' => $validated['alamat'],
            'email'  => $validated['email'],
            'telpon' => $validated['telpon'],
            'id_re'  => $id_re,
        ]);

        // 5. Kirim Email Konfirmasi ke email yang diinputkan
        try {
            Mail::to($validated['email'])->send(new PendaftaranRelawanMail([
                'name'        => $validated['name'],
                'judul'       => $relawan->judul,
                'tgl'         => $relawan->tgl,
                'koordinator' => $relawan->koordinator ?? '-',
            ]));
        } catch (\Exception $e) {
            Log::error("Gagal kirim email pendaftaran: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Berhasil mendaftar aksi relawan! Email konfirmasi telah dikirim.');
    }

    public function programRelawanDetil($id)
    {
        $dataBerita = RelawanModel::where('id_re', $id)->firstOrFail();

        $archives = RelawanModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = RelawanModel::pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = RelawanModel::select('judul', DB::raw('count(*) as total'))
            ->groupBy('judul')
            ->get();

        $recentPosts = RelawanModel::latest()->take(4)->get();
        $beritaPosts = RelawanModel::whereNotNull('judul')->latest()->get();

        return view('relawan_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function programRoan(Request $request)
    {
        $query = RoanModel::query();

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('tema', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('pj', 'LIKE', "%{$keyword}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tgl', $request->bulan)
                ->whereYear('tgl', $request->tahun);
        }

        $dataBahsul = $query->orderBy('tgl', 'desc')->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataBahsul->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = RoanModel::select('judul', DB::raw('count(*) as total'))
            ->groupBy('judul')
            ->get();

        $recentPosts = RoanModel::latest()->take(4)->get();

        $semuaJudul = RoanModel::pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        arsort($tags);
        $tags = array_slice($tags, 0, 15);

        $archives = RoanModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = RoanModel::latest()->take(6)->get();

        return view('roan', compact('dataBahsul', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listKajian'));
    }

    public function programRoanDaftar(Request $request, $id)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'alamat' => 'required|string',
            'email'  => 'required|email',
            'telpon' => 'required|string|max:20',
        ]);

        // Karena primaryKey di BahsulModel sudah diset 'id_bs',
        // findOrFail otomatis mencari berdasarkan kolom 'id_bs'.
        $bahsul = RoanModel::findOrFail($id);

        // Cek apakah email tersebut sudah terdaftar pada kegiatan ini
        $sudahDaftar = PesertaRoanModel::where('e', $id)
            ->where('email', $validated['email'])
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Email ini sudah terdaftar di kegiatan Halaqah ini.');
        }

        // Simpan data pendaftaran peserta baru
        PesertaRoanModel::create([
            'name'   => $validated['name'],
            'alamat' => $validated['alamat'],
            'email'  => $validated['email'],
            'telpon' => $validated['telpon'],
            'id_ro'  => $id,
        ]);

        // Ambil data admin untuk kontak panitia di email
        $panitia = User::where('role', 'admin')->with('anggota')->first();

        // Kirim Email Konfirmasi ke email yang diinput pada form
        Mail::to($validated['email'])->send(new PendaftaranRoanMail([
            'name'           => $validated['name'],
            'judul'    => $bahsul->judul,
            'tgl'      => $bahsul->tgl,
            'kategori' => 'Roan',
            'pj'       => $bahsul->pj ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }

    public function programRoanDetil($id)
    {
        $dataBerita = RoanModel::where('id_ro', $id)->firstOrFail();

        $archives = RoanModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = RoanModel::pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = RoanModel::select('tema', DB::raw('count(*) as total'))
            ->groupBy('tema')
            ->get();

        $recentPosts = RoanModel::latest()->take(4)->get();
        $beritaPosts = RoanModel::whereNotNull('judul')->latest()->get();

        return view('roan_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function kegiatanHalaqah(Request $request)
    {
        $query = HalaqahModel::where('status', 'publish');

        // Jika ada keyword pencarian
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('tema', 'LIKE', "%{$keyword}%")
                    ->orWhere('narsum', 'LIKE', "%{$keyword}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$keyword}%")
                    ->orWhere('tanggal', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        $dataHalaqah = $query->orderBy('tanggal', 'desc')->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataHalaqah->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = HalaqahModel::select('judul', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('judul')
            ->get();

        $recentPosts = HalaqahModel::where('status', 'publish')->latest()->take(4)->get();

        $semuaJudul = HalaqahModel::where('status', 'publish')->pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        arsort($tags);
        $tags = array_slice($tags, 0, 15);

        $archives = HalaqahModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = HalaqahModel::latest()->take(6)->get();

        return view('halaqah', compact('dataHalaqah', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listKajian'));
    }

    public function kajianHalaqahDaftar(Request $request, $id)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'alamat' => 'required|string',
            'email'  => 'required|email',
            'telpon' => 'required|string|max:20',
        ]);

        // Karena primaryKey di BahsulModel sudah diset 'id_bs',
        // findOrFail otomatis mencari berdasarkan kolom 'id_bs'.
        $bahsul = HalaqahModel::findOrFail($id);

        // Cek apakah email tersebut sudah terdaftar pada kegiatan ini
        $sudahDaftar = PesertaHalaqahModel::where('id', $id)
            ->where('email', $validated['email'])
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Email ini sudah terdaftar di kegiatan Halaqah ini.');
        }

        // Simpan data pendaftaran peserta baru
        PesertaHalaqahModel::create([
            'name'   => $validated['name'],
            'alamat' => $validated['alamat'],
            'email'  => $validated['email'],
            'telpon' => $validated['telpon'],
            'id'  => $id,
        ]);

        // Ambil data admin untuk kontak panitia di email
        $panitia = User::where('role', 'admin')->with('anggota')->first();

        // Kirim Email Konfirmasi ke email yang diinput pada form
        Mail::to($validated['email'])->send(new PendaftaranHalaqahMail([
            'name'           => $validated['name'],
            'judul'          => $bahsul->judul,
            'tgl'            => $bahsul->tanggal,
            'panitia_nama'   => $panitia->name ?? 'Panitia',
            'panitia_telpon' => optional($panitia->anggota)->telpon ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }

    public function kajianBahsul(Request $request)
    {
        $query = BahsulModel::where('status', 'publish');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('kategori', 'LIKE', "%{$keyword}%")
                    ->orWhere('pemohon', 'LIKE', "%{$keyword}%")
                    ->orWhere('lokasi', 'LIKE', "%{$keyword}%")
                    ->orWhere('tanggal', 'LIKE', "%{$keyword}%");
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        $dataBahsul = $query->orderBy('tanggal', 'desc')->paginate(4);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataBahsul->appends($request->only(['keyword', 'bulan', 'tahun']));

        $kategoriList = BahsulModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = BahsulModel::where('status', 'publish')->latest()->take(4)->get();

        $semuaJudul = BahsulModel::where('status', 'publish')->pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        // Urutkan berdasarkan yang paling sering muncul
        arsort($tags);
        // Batasi hanya ambil 10-15 tag teratas
        $tags = array_slice($tags, 0, 15);

        $archives = BahsulModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $folderPath = public_path('storage/foto_bahsul');
        $bahsulPhotos = [];
        if (File::exists($folderPath)) {
            $files = File::files($folderPath);
            $bahsulPhotos = array_map(fn($file) => $file->getFilename(), $files);
        }

        $materiPosts = BahsulModel::whereNotNull('lampiran')->latest()->get();

        return view('bahsul', compact('dataBahsul', 'recentPosts', 'kategoriList', 'archives', 'tags', 'materiPosts', 'bahsulPhotos'));
    }

    public function kegiatanDakwah(Request $request)
    {
        $query = DakwahModel::where('status', 'publish');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('mubaligh', 'LIKE', "%{$keyword}%")
                    ->orWhere('kategori', 'LIKE', "%{$keyword}%")
                    ->orWhere('isi', 'LIKE', "%{$keyword}%")
                    ->orWhere('created_at', 'LIKE', "%{$keyword}%"); // Pencarian tanggal
            });
        }

        $dataDakwah = $query->latest()->paginate(5);

        // Mempertahankan query string saat berpindah halaman pagination
        $dataDakwah->appends(['keyword' => $request->keyword]);

        // Di dalam method controller yang memuat view 'berita'
        $kategoriList = DakwahModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = DakwahModel::where('status', 'publish')->latest()->take(4)->get();

        $semuaJudul = DakwahModel::where('status', 'publish')->pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        // Urutkan berdasarkan yang paling sering muncul
        arsort($tags);
        // Batasi hanya ambil 10-15 tag teratas
        $tags = array_slice($tags, 0, 15);

        $archives = DakwahModel::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();


        $listDakwah = DakwahModel::latest()->take(6)->get();

        return view('dakwah', compact('dataDakwah', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listDakwah'));
    }

    public function kajianBahsulDaftar(Request $request, $id)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'alamat' => 'required|string',
            'email'  => 'required|email',
            'telpon' => 'required|string|max:20',
        ]);

        // Karena primaryKey di BahsulModel sudah diset 'id_bs',
        // findOrFail otomatis mencari berdasarkan kolom 'id_bs'.
        $bahsul = BahsulModel::findOrFail($id);

        // Cek apakah email tersebut sudah terdaftar pada kegiatan ini
        $sudahDaftar = PesertaHalaqahModel::where('id_bs', $id)
            ->where('email', $validated['email'])
            ->exists();

        if ($sudahDaftar) {
            return redirect()->back()->with('error', 'Email ini sudah terdaftar di kegiatan Bahtsul Masail ini.');
        }

        // Simpan data pendaftaran peserta baru
        PesertaBahsulModel::create([
            'name'   => $validated['name'],
            'alamat' => $validated['alamat'],
            'email'  => $validated['email'],
            'telpon' => $validated['telpon'],
            'id_bs'  => $id,
        ]);

        // Ambil data admin untuk kontak panitia di email
        $panitia = User::where('role', 'admin')->with('anggota')->first();

        // Kirim Email Konfirmasi ke email yang diinput pada form
        Mail::to($validated['email'])->send(new PendaftaranBahsulMail([
            'name'           => $validated['name'],
            'judul'          => $bahsul->judul,
            'tgl'            => $bahsul->tanggal,
            'panitia_nama'   => $panitia->name ?? 'Panitia',
            'panitia_telpon' => optional($panitia->anggota)->telpon ?? '-',
        ]));

        return redirect()->back()->with('success', 'Berhasil mendaftar! Email konfirmasi telah dikirim.');
    }

    public function kajianBahsulDetil($id)
    {
        $dataBerita = BahsulModel::where('id_bs', $id)->firstOrFail();

        $archives = BahsulModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = BahsulModel::where('status', 'publish')->pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = BahsulModel::select('kategori', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('kategori')
            ->get();

        $recentPosts = BahsulModel::where('status', 'publish')->latest()->take(4)->get();
        $beritaPosts = BahsulModel::whereNotNull('judul')->latest()->get();

        return view('bahsul_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function kajianHalaqahDetil($id)
    {
        $dataBerita = HalaqahModel::where('id', $id)->firstOrFail();

        $archives = HalaqahModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = HalaqahModel::where('status', 'publish')->pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = HalaqahModel::select('tema', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('tema')
            ->get();

        $recentPosts = HalaqahModel::where('status', 'publish')->latest()->take(4)->get();
        $beritaPosts = HalaqahModel::whereNotNull('judul')->latest()->get();

        return view('halaqah_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function kajianPengajianDetil($id)
    {
        $dataBerita = KajianModel::where('id', $id)->firstOrFail();

        $archives = KajianModel::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, COUNT(*) as total')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = KajianModel::where('status', 'publish')->pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = KajianModel::select('tema', DB::raw('count(*) as total'))
            ->where('status', 'publish')
            ->groupBy('tema')
            ->get();

        $recentPosts = KajianModel::where('status', 'publish')->latest()->take(4)->get();
        $beritaPosts = KajianModel::whereNotNull('judul')->latest()->get();

        return view('kajian_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts'));
    }

    public function khutbahJumat(Request $request)
    {
        $query = KhutbahModel::query();

        // Terapkan filter wajib (bukan '-') terlebih dahulu agar konsisten
        $query->where('judul', '!=', '-')
            ->where('tema', '!=', '-')
            ->where('khatib', '!=', '-')
            ->where('masjid', '!=', '-')
            ->where('ringkasan', '!=', '-');

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'LIKE', "%{$keyword}%")
                    ->orWhere('tema', 'LIKE', "%{$keyword}%")
                    ->orWhere('khatib', 'LIKE', "%{$keyword}%")
                    ->orWhere('masjid', 'LIKE', "%{$keyword}%")
                    ->orWhere('tgl', 'LIKE', "%{$keyword}%"); // Pencarian tanggal
            });
        }

        // === TAMBAHKAN FILTER BULAN DAN TAHUN DI SINI ===
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tgl', $request->bulan)
                ->whereYear('tgl', $request->tahun);
        }

        // Ambil data dengan pagination (menggunakan $query yang sudah difilter)
        $dataHalaqah = $query->orderBy('tgl', 'desc')->paginate(5);

        // Mempertahankan query string (keyword, bulan, tahun) saat berpindah halaman pagination
        $dataHalaqah->appends($request->only(['keyword', 'bulan', 'tahun']));

        // Kategori List (dirapikan sedikit selectnya)
        $kategoriList = KhutbahModel::select('judul', DB::raw('count(*) as total'))
            ->where('judul', '!=', '-')
            ->groupBy('judul')
            ->get();

        $recentPosts = KhutbahModel::where('judul', '!=', '-')->latest()->take(4)->get();

        $semuaJudul = KhutbahModel::where('judul', '!=', '-')->pluck('judul');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        // Urutkan berdasarkan yang paling sering muncul
        arsort($tags);
        // Batasi hanya ambil 10-15 tag teratas
        $tags = array_slice($tags, 0, 15);

        $archives = KhutbahModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->where('tema', '!=', '-')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = KhutbahModel::latest()->take(6)->get();

        $materiPosts = KhutbahModel::whereNotNull('lampiran')->latest()->get();

        return view('khutbah', compact('dataHalaqah', 'recentPosts', 'kategoriList', 'archives', 'tags', 'listKajian', 'materiPosts'));
    }

    public function khutbahJumatDetil($id)
    {
        $dataBerita = KhutbahModel::where('id_kj', $id)->firstOrFail();

        $archives = KhutbahModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->where('tema', '!=', '-')
            ->where('khatib', '!=', '-')
            ->where('masjid', '!=', '-')
            ->where('ringkasan', '!=', '-')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $semuaJudul = KhutbahModel::pluck('judul');

        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }


        $kategoriList = KhutbahModel::select('judul', DB::raw('count(*) as total'))
            ->where('tema', '!=', '-')
            ->groupBy('judul')
            ->get();

        $recentPosts = KhutbahModel::where('tema', '!=', '-')->latest()->take(4)->get();
        $beritaPosts = KhutbahModel::whereNotNull('judul')->latest()->get();
        $materiPosts = KhutbahModel::whereNotNull('lampiran')->latest()->get();

        $latestBeritaWithFiles = KhutbahModel::whereNotNull('lampiran')
            ->where('lampiran', '!=', '')
            ->orderBy('tgl', 'desc')
            ->take(20)
            ->get();

        return view('khutbah_detil_user', compact('dataBerita', 'archives', 'tags', 'kategoriList', 'recentPosts', 'beritaPosts', 'materiPosts', 'latestBeritaWithFiles'));
    }

    public function pesanDakwah(Request $request)
    {
        $query = DakwahModel::where('status', 'publish')->latest();

        // Jika ada keyword, filter berdasarkan kolom yang diinginkan
        if ($request->has('keyword') && $request->keyword != '') {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('mubaligh', 'LIKE', "%{$keyword}%")
                    ->orWhere('isi', 'LIKE', "%{$keyword}%"); // Pencarian tanggal
            });
        }

        $dataHalaqah = $query->where('judul', '=', '-')
            ->where('status', 'publish')
            ->where('kategori', '=', '-')
            ->where('poster', '=', '-')
            ->orderBy('tgl', 'desc')
            ->paginate(5);

        // Mempertahankan query string saat berpindah halaman pagination
        $dataHalaqah->appends(['keyword' => $request->keyword]);

        $recentPosts = DakwahModel::where('judul', '=', '-')
            ->where('status', 'publish')
            ->latest()->take(4)->get();

        $semuaJudul = DakwahModel::where('judul', '=', '-')
            ->where('status', 'publish')
            ->pluck('isi');

        // Daftar kata sambung yang ingin diabaikan
        $kataSambung = ['dan', 'atau', 'di', 'ke', 'dari', 'yang', 'untuk', 'dengan', 'pada', 'dalam', 'ini', 'itu', 'adalah'];

        $tags = [];
        foreach ($semuaJudul as $judul) {
            // Pecah judul menjadi array kata dan bersihkan karakter khusus
            $kataKata = explode(' ', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $judul)));

            foreach ($kataKata as $kata) {
                // Abaikan kata sambung atau kata yang terlalu pendek (<= 3 huruf)
                if (!in_array($kata, $kataSambung) && strlen($kata) > 3) {
                    if (!isset($tags[$kata])) {
                        $tags[$kata] = 0;
                    }
                    $tags[$kata]++;
                }
            }
        }

        // Urutkan berdasarkan yang paling sering muncul
        arsort($tags);
        // Batasi hanya ambil 10-15 tag teratas
        $tags = array_slice($tags, 0, 15);

        $archives = DakwahModel::selectRaw('YEAR(tgl) as year, MONTH(tgl) as month, COUNT(*) as total')
            ->where('judul', '=', '-')
            ->where('status', 'publish')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $listKajian = DakwahModel::where('judul', '=', '-')->latest()->take(6)->get();

        return view('pesan_dakwah', compact('dataHalaqah', 'recentPosts', 'archives', 'tags', 'listKajian'));
    }

    public function infografisMWC(Request $request)
    {
        $chartData = BahsulModel::withCount('peserta')
            ->where('status', 'publish')
            ->get();

        $chartHalaqah = HalaqahModel::withCount('peserta')
            ->where('status', 'publish')
            ->get();

        $chartRoan = RoanModel::withCount('peserta')
            ->get();

        $chartBanjir = RelawanModel::withCount('peserta')
            ->get();

        $chartBencana = BencanaModel::select(
            DB::raw("DATE_FORMAT(tgl, '%Y-%m') as tahun_bulan"),
            DB::raw("DATE_FORMAT(tgl, '%M %Y') as label_bulan"),
            DB::raw("COUNT(*) as total_laporan")
        )
            ->groupBy('tahun_bulan', 'label_bulan')
            ->orderBy('tahun_bulan', 'ASC')
            ->get();

        $chartMangrove = MangroveModel::select(
            'tanggal',
            DB::raw("SUM(jumlah_infaq) as total_infaq"),
            DB::raw("SUM(jumlah_pohon) as total_pohon")
        )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'ASC')
            ->get();

        $chartSampah = SampahModel::select(
            'tgl',
            DB::raw("SUM(nilai) as total_nilai"),
            DB::raw("SUM(berat) as total_berat")
        )
            ->groupBy('tgl')
            ->orderBy('tgl', 'ASC')
            ->get();

        return view('infografis', compact('chartData', 'chartHalaqah', 'chartRoan', 'chartBanjir', 'chartBencana', 'chartMangrove', 'chartSampah'));
    }
}
