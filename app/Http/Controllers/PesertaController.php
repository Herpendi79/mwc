<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Publikasi;
use App\Models\Conferences;
use App\Models\Kategori; // Pastikan Model Kategori di-import
use App\Models\PesertaConferences;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Services\EmailApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Jobs\SendSubmissionEmail;

class PesertaController extends Controller
{
    public function index()
    {
        // Menghitung total data di tabel peserta
        $totalPeserta = Peserta::count();

        $user = Auth::user();

        // Ambil submission terbaru agar status yang muncul adalah yang paling update
        $latestSubmission = \App\Models\PesertaConferences::where('user_id', $user->id)
            ->latest()
            ->first();

        return view('participants.index', [
            'submission' => $latestSubmission,
            'totalPeserta' => $totalPeserta
        ]);
    }

    public function conferences()
    {
        $conferences = Conferences::orderBy('tgl_mulai', 'desc')->get();

        $today = \Carbon\Carbon::today();

        /** @var \App\Models\User $user */
        $user = Auth::user();


        $userSubmissions = PesertaConferences::where('user_id', $user->id)
            ->whereHas('kategori')
            ->with([
                'kategori',
                'publikasi'
            ])
            ->get()
            ->groupBy(function ($item) {
                return $item->kategori?->id_conf;
            });


        return view('participants.conferences', compact(
            'conferences',
            'today',
            'userSubmissions'
        ));
    }

    public function submitForm(int $id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);
        $today = \Carbon\Carbon::today();
        $deadline = \Carbon\Carbon::parse($conference->deadline_subm);
        $tglMulai = \Carbon\Carbon::parse($conference->tgl_mulai);

        // Proteksi: Jika sudah melewati tgl mulai, akses ditutup sepenuhnya
        if ($today->greaterThan($tglMulai)) {
            return redirect()->route('participants.conferences')->with('error', 'Submission period has ended.');
        }

        $user = Auth::user();
        $negaraPeserta = ($user && $user->peserta) ? $user->peserta->negara : 'Indonesia';

        $queryKategori = Kategori::where('id_conf', $id_conf);

        // Filter Khusus: Jika sudah lewat deadline, hanya boleh kategori dengan nama "Participant"
        if ($today->greaterThan($deadline)) {
            $queryKategori->where('nama_ktg', 'LIKE', '%Participant%')
                ->where(function ($q) {
                    $q->where('keterangan', 'NOT LIKE', '%Adaksi%')
                        ->orWhereNull('keterangan');
                });
        } else {
            // Logika normal sebelum deadline
            $queryKategori->where(function ($q) {
                $q->where('keterangan', 'NOT LIKE', '%Adaksi%')
                    ->orWhereNull('keterangan');
            });

            if (strtolower($negaraPeserta) !== 'indonesia') {
                $queryKategori->where('domisili', 'international');
            } else {
                $queryKategori->where('domisili', '!=', 'international');
            }
        }

        $kategoris = $queryKategori->get();
        $publikasis = Publikasi::all();

        return view('participants.submit', compact('conference', 'kategoris', 'publikasis'));
    }
    
    public function submitAddForm(int $id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);
        $today = \Carbon\Carbon::today();
        $deadline = \Carbon\Carbon::parse($conference->deadline_subm);
        $tglMulai = \Carbon\Carbon::parse($conference->tgl_mulai);

        // Proteksi: Jika sudah melewati tgl mulai, akses ditutup sepenuhnya
        if ($today->greaterThan($tglMulai)) {
            return redirect()->route('participants.conferences')->with('error', 'Submission period has ended.');
        }

        $user = Auth::user();
        $negaraPeserta = ($user && $user->peserta) ? $user->peserta->negara : 'Indonesia';

        $queryKategori = Kategori::where('id_conf', $id_conf);

        // Filter Khusus: Jika sudah lewat deadline, hanya boleh kategori dengan nama "Participant"
        if ($today->greaterThan($deadline)) {
            $queryKategori->where('nama_ktg', 'LIKE', '%Participant%')
                ->where(function ($q) {
                    $q->where('keterangan', 'NOT LIKE', '%Adaksi%')
                        ->orWhereNull('keterangan');
                });
        } else {
            // Logika normal sebelum deadline
            $queryKategori->where(function ($q) {
                $q->where('keterangan', 'NOT LIKE', '%Adaksi%')
                    ->orWhereNull('keterangan');
            });

            if (strtolower($negaraPeserta) !== 'indonesia') {
                $queryKategori->where('domisili', 'international');
            } else {
                $queryKategori->where('domisili', '!=', 'international');
            }
        }

        $kategoris = $queryKategori->get();
        $publikasis = Publikasi::all();

        return view('participants.submitAdd', compact('conference', 'kategoris', 'publikasis'));
    }

    public function resubmit($id_pc)
    {
        $submission = PesertaConferences::findOrFail($id_pc);
        $id_conf = $submission->kategori->id_conf;

        // 1. Hapus file-file fisik yang sudah diupload agar tidak memenuhi storage
        $files = [$submission->file_abstract, $submission->file_kp, $submission->file_bukti_tf];
        foreach ($files as $file) {
            if ($file) {
                $path = config('path.submissions') . $file;
                if (\Illuminate\Support\Facades\File::exists($path)) {
                    \Illuminate\Support\Facades\File::delete($path);
                }
            }
        }

        // 2. Hapus data dari database
        $submission->delete();

        // 3. Alihkan ke halaman submitForm dengan ID Conference sebelumnya
        return redirect()->route('participants.submit', $id_conf)
            ->with('info', 'Your previous pending session has been cleared. Please re-submit your data.');
    }

    public function storeSubmission(Request $request)
    {
        // 1. Ambil data kategori di awal untuk menentukan logika validasi
        $kategori = Kategori::with('conference')->findOrFail($request->id_ktg);
        $conference = $kategori->conference;
        $isInternational = Str::contains(strtolower($kategori->nama_ktg), 'international');
        $isPresenter = Str::contains(strtolower($kategori->nama_ktg), 'presenter');

        if (!$conference) {
            return redirect()->back()->with('error', 'Conference data not found for this category.');
        }

        // 2. Tentukan Aturan Validasi secara Dinamis
        $rules = [
            'id_ktg' => 'required|exists:kategori,id_ktg',
        ];

        // LOGIKA TAMBAHAN: Jika kategori adalah Presenter, id_pub wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Presenter')) {
            $rules['judul'] = 'required|string|max:500'; // Tambahkan validasi judul
            $rules['id_pub'] = 'required|exists:publikasi,id_pub';
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
        } else if (Str::contains($kategori->nama_ktg, 'Participant')) {
            $rules['file_abstract'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            $rules['judul'] = 'nullable|string|max:500'; // Participant boleh kosong
        } else {
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            $rules['judul'] = 'nullable|string|max:500'; // Kategori lain tidak wajib judul, tapi bisa diisi jika ingin submit artikel tanpa jadi presenter
        }

        // Jika kategori mengandung kata 'Student', kartu pelajar wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Student')) {
            $rules['file_kp'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        if ($isInternational) {
            $rules['file_bukti_tf'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $request->validate($rules);

        Log::info('Memulai proses storeSubmission untuk User ID: ' . Auth::id());
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $peserta = $user->peserta;
            $userId = Auth::id();

            // 3. Proses Folder & Upload File
            //$path = public_path('../public_html/file/');
            //$path = public_path('../../public_html/uploads/file/submissions');

            $path = config('path.submissions');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $fileAbstract = null;
            if ($request->hasFile('file_abstract')) {
                $fileAbstract = time() . '_abstract_' . $userId . '.' . $request->file_abstract->extension();
                $request->file_abstract->move($path, $fileAbstract);
            }

            $fileKP = null;
            if ($request->hasFile('file_kp')) {
                $fileKP = time() . '_kp_' . $userId . '.' . $request->file_kp->extension();
                $request->file_kp->move($path, $fileKP);
            }

            $fileBukti = null;
            if ($request->hasFile('file_bukti_tf')) {
                $fileBukti = time() . '_tf_' . $userId . '.' . $request->file_bukti_tf->extension();
                $request->file_bukti_tf->move($path, $fileBukti);
            }

            // 4. Logika Simpan Data
            $id_conf = $kategori->id_conf;
            $userId = Auth::id(); // Gunakan ID User langsung

            $submission = PesertaConferences::where('user_id', $userId)
                ->whereHas('kategori', function ($query) use ($id_conf) {
                    $query->where('id_conf', $id_conf);
                })->first();

            // TAMBAHKAN id_pub ke dalam array dataSave
            $dataSave = [
                'user_id'       => $userId,
                'id_ktg'        => $request->id_ktg,
                'id_pub'        => $request->id_pub, // Nilai ini akan null jika bukan presenter (sesuai input hidden/select)
                'judul'         => $request->judul, // <--- TAMBAHKAN INI
                'file_abstract' => $fileAbstract,
                'file_kp'       => $fileKP,
                'file_bukti_tf'    => $fileBukti,
                'payment'       => 'pending',
            ];

            if ($submission) {
                $submission->update($dataSave);
            } else {
                $submission = PesertaConferences::create($dataSave);
            }

            // 4. LOGIKA PERCABANGAN PEMBAYARAN
            if ($isInternational) {
                // KIRIM EMAIL WAITING VALIDATION
                $isPresenter = Str::contains($kategori->nama_ktg, 'Presenter');
                $viewEmail = $isPresenter ? 'emails.waiting_validation' : 'emails.waiting_validation_participant';

                $html = view($viewEmail, [
                    'nama' => $peserta->nama,
                    'kategori' => $peserta->kategori,
                    'nama_conference' => $conference->nama_conf
                ])->render();

                EmailApiService::send($user->email, "Payment Waiting Validation - " . $conference->nama_conf, "Please wait for admin validation.", $html);
                /*SendSubmissionEmail::dispatch([
                    'to'      => $user->email,
                    'subject' => "Payment Waiting Validation - " . $conference->nama_conf,
                    'text'    => "Please wait for admin validation.",
                    'html'    => $html
                ])->onQueue('conference'); */
                DB::commit();
                return redirect()->route('participants.conferences')->with('success', 'Registration successful. Please wait for admin to validate your payment.');
            }

            // 5. Konfigurasi Midtrans (Tetap sama)

            $namaKtg = strtolower($kategori->nama_ktg);
            $today = now()->format('Ymd');

            // 1. Tentukan Prefix Awal (Offline/Online)
            $mode = str_contains($namaKtg, 'online') ? 'ON' : 'OF';

            // 2. Tentukan Kode Peran (Student Presenter, Presenter, atau Participant)
            $role = '';
            if (str_contains($namaKtg, 'student presenter')) {
                $role = 'SP';
            } elseif (str_contains($namaKtg, 'presenter')) {
                $role = 'PR';
            } elseif (str_contains($namaKtg, 'participant')) {
                $role = 'PA';
            }

            // 3. Tentukan Region (Domestic/International)
            $region = str_contains($namaKtg, 'international') ? 'I' : 'D';

            // 4. Gabungkan menjadi Kode Invoice
            // ICPIP adalah kode statis Anda, mode+role+region digabung
            $typeCode = $mode . $role . $region;

            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $order_id = "INV-ICPIP-{$typeCode}-{$today}-{$randomNumber}";

            $durationInMinutes = 180;

            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $kategori->fee,
                ],
                'customer_details' => [
                    'first_name' => $peserta->nama,
                    'email' => $user->email,
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'minute',
                    'duration' => $durationInMinutes,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $submission->update([
                'snap' => $snapToken,
                'order_id' => $order_id
            ]);

            $urlPembayaran = route('payment', ['snapToken' => $snapToken]);

            // 6. Persiapan Email (Tetap sama)
            $subject = "Payment Required - " . $conference->nama_conf;
            $expiryDate = now()->addMinutes($durationInMinutes)->format('d M Y H:i');

            $html = view('emails.submit_payment', [
                'nama'            => $peserta->nama,
                'nama_conference' => $conference->nama_conf,
                'biaya'           => $kategori->fee,
                'order_id'        => $order_id,
                'expiry'          => $expiryDate,
                'urlPembayaran'   => $urlPembayaran,
            ])->render();

            /* SendSubmissionEmail::dispatch([
                'to'      => $user->email,
                'subject' => "Payment Required - " . $conference->nama_conf,
                'text'    => "Halo {$peserta->nama}, please complete your payment.",
                'html'    => $html
            ])->onQueue('conference'); */



            $text = "Halo {$peserta->nama}, please complete your payment for {$conference->nama_conf}. Link: {$urlPembayaran}";
            EmailApiService::send($user->email, $subject, $text, $html);

            DB::commit();
            Log::info('Email tagihan berhasil dikirim ke: ' . $user->email);

            return redirect()->route('payment', ['snapToken' => $snapToken]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Terjadi Error di storeSubmission: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to process submission: ' . $e->getMessage());
        }
    }

    public function storeAddSubmission(Request $request)
    {
        // 1. Ambil data kategori di awal untuk menentukan logika validasi
        $kategori = Kategori::with('conference')->findOrFail($request->id_ktg);
        $conference = $kategori->conference;
        $isInternational = Str::contains(strtolower($kategori->nama_ktg), 'international');
        $isPresenter = Str::contains(strtolower($kategori->nama_ktg), 'presenter');

        if (!$conference) {
            return redirect()->back()->with('error', 'Conference data not found for this category.');
        }

        // 2. Tentukan Aturan Validasi secara Dinamis
        $rules = [
            'id_ktg' => 'required|exists:kategori,id_ktg',
        ];

        // LOGIKA TAMBAHAN: Jika kategori adalah Presenter, id_pub wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Presenter')) {
            $rules['judul'] = 'required|string|max:500'; // Tambahkan validasi judul
            $rules['id_pub'] = 'required|exists:publikasi,id_pub';
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
        } else if (Str::contains($kategori->nama_ktg, 'Participant')) {
            $rules['file_abstract'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
            $rules['judul'] = 'nullable|string|max:500'; // Participant boleh kosong
        } else {
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
            $rules['judul'] = 'nullable|string|max:500'; // Kategori lain tidak wajib judul, tapi bisa diisi jika ingin submit artikel tanpa jadi presenter
        }

        // Jika kategori mengandung kata 'Student', kartu pelajar wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Student')) {
            $rules['file_kp'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        if ($isInternational) {
            $rules['file_bukti_tf'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $request->validate($rules);

        Log::info('Memulai proses storeSubmission untuk User ID: ' . Auth::id());
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $peserta = $user->peserta;
            $userId = Auth::id();

            $path = config('path.submissions');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $fileAbstract = null;
            if ($request->hasFile('file_abstract')) {
                $fileAbstract = time() . '_abstract_' . $userId . '.' . $request->file_abstract->extension();
                $request->file_abstract->move($path, $fileAbstract);
            }

            $fileKP = null;
            if ($request->hasFile('file_kp')) {
                $fileKP = time() . '_kp_' . $userId . '.' . $request->file_kp->extension();
                $request->file_kp->move($path, $fileKP);
            }

            $fileBukti = null;
            if ($request->hasFile('file_bukti_tf')) {
                $fileBukti = time() . '_tf_' . $userId . '.' . $request->file_bukti_tf->extension();
                $request->file_bukti_tf->move($path, $fileBukti);
            }

            // 4. Logika Simpan Data
            $id_conf = $kategori->id_conf;
            $userId = Auth::id(); // Gunakan ID User langsung


            // TAMBAHKAN id_pub ke dalam array dataSave
            $dataSave = [
                'user_id'       => $userId,
                'id_ktg'        => $request->id_ktg,
                'id_pub'        => $request->id_pub, // Nilai ini akan null jika bukan presenter (sesuai input hidden/select)
                'judul'         => $request->judul, // <--- TAMBAHKAN INI
                'file_abstract' => $fileAbstract,
                'file_kp'       => $fileKP,
                'file_bukti_tf'    => $fileBukti,
                'payment'       => 'pending',
            ];

            $submission = PesertaConferences::create($dataSave);


            // 4. LOGIKA PERCABANGAN PEMBAYARAN
            if ($isInternational) {
                // KIRIM EMAIL WAITING VALIDATION
                $isPresenter = Str::contains($kategori->nama_ktg, 'Presenter');
                $viewEmail = $isPresenter ? 'emails.waiting_validation' : 'emails.waiting_validation_participant';

                $html = view($viewEmail, [
                    'nama' => $peserta->nama,
                    'kategori' => $peserta->kategori,
                    'nama_conference' => $conference->nama_conf
                ])->render();

                EmailApiService::send($user->email, "Payment Waiting Validation - " . $conference->nama_conf, "Please wait for admin validation.", $html);

                DB::commit();
                return redirect()->route('participants.conferences')->with('success', 'Registration successful. Please wait for admin to validate your payment.');
            }

            // 5. Konfigurasi Midtrans (Tetap sama)

            $namaKtg = strtolower($kategori->nama_ktg);
            $today = now()->format('Ymd');

            // 1. Tentukan Prefix Awal (Offline/Online)
            $mode = str_contains($namaKtg, 'online') ? 'ON' : 'OF';

            // 2. Tentukan Kode Peran (Student Presenter, Presenter, atau Participant)
            $role = '';
            if (str_contains($namaKtg, 'student presenter')) {
                $role = 'SP';
            } elseif (str_contains($namaKtg, 'presenter')) {
                $role = 'PR';
            } elseif (str_contains($namaKtg, 'participant')) {
                $role = 'PA';
            }

            // 3. Tentukan Region (Domestic/International)
            $region = str_contains($namaKtg, 'international') ? 'I' : 'D';

            // 4. Gabungkan menjadi Kode Invoice
            // ICPIP adalah kode statis Anda, mode+role+region digabung
            $typeCode = $mode . $role . $region;

            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $order_id = "INV-ICPIP-{$typeCode}-{$today}-{$randomNumber}";

            $durationInMinutes = 180;

            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $kategori->fee,
                ],
                'customer_details' => [
                    'first_name' => $peserta->nama,
                    'email' => $user->email,
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'minute',
                    'duration' => $durationInMinutes,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $submission->update([
                'snap' => $snapToken,
                'order_id' => $order_id
            ]);

            $urlPembayaran = route('payment', ['snapToken' => $snapToken]);

            // 6. Persiapan Email (Tetap sama)
            $subject = "Payment Required - " . $conference->nama_conf;
            $expiryDate = now()->addMinutes($durationInMinutes)->format('d M Y H:i');

            $html = view('emails.submit_payment', [
                'nama'            => $peserta->nama,
                'nama_conference' => $conference->nama_conf,
                'biaya'           => $kategori->fee,
                'order_id'        => $order_id,
                'expiry'          => $expiryDate,
                'urlPembayaran'   => $urlPembayaran,
            ])->render();



            $text = "Halo {$peserta->nama}, please complete your payment for {$conference->nama_conf}. Link: {$urlPembayaran}";
            EmailApiService::send($user->email, $subject, $text, $html);

            DB::commit();
            Log::info('Email tagihan berhasil dikirim ke: ' . $user->email);

            return redirect()->route('payment', ['snapToken' => $snapToken]);
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Terjadi Error di storeSubmission: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to process submission: ' . $e->getMessage());
        }
    }

    public function storeSubmission_email_api_services(Request $request)
    {
        // 1. Ambil data kategori di awal untuk menentukan logika validasi
        $kategori = Kategori::with('conference')->findOrFail($request->id_ktg);
        $conference = $kategori->conference;
        $isInternational = Str::contains(strtolower($kategori->nama_ktg), 'international');

        if (!$conference) {
            return redirect()->back()->with('error', 'Conference data not found for this category.');
        }

        // 2. Tentukan Aturan Validasi secara Dinamis
        $rules = [
            'id_ktg' => 'required|exists:kategori,id_ktg',
        ];

        // LOGIKA TAMBAHAN: Jika kategori adalah Presenter, id_pub wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Presenter')) {
            $rules['id_pub'] = 'required|exists:publikasi,id_pub';
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
        } else if (Str::contains($kategori->nama_ktg, 'Participant')) {
            $rules['file_abstract'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
        } else {
            $rules['file_abstract'] = 'required|file|mimes:pdf,doc,docx|max:2048';
        }

        // Jika kategori mengandung kata 'Student', kartu pelajar wajib diisi
        if (Str::contains($kategori->nama_ktg, 'Student')) {
            $rules['file_kp'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        if ($isInternational) {
            $rules['file_bukti_tf'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:2048';
        }

        $request->validate($rules);

        Log::info('Memulai proses storeSubmission untuk User ID: ' . Auth::id());

        try {
            $user = Auth::user();
            $peserta = $user->peserta;
            $userId = Auth::id();

            // 3. Proses Folder & Upload File
            //$path = public_path('../public_html/file/');
            //$path = public_path('../../public_html/uploads/file/submissions');

            $path = config('path.submissions');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $fileAbstract = null;
            if ($request->hasFile('file_abstract')) {
                $fileAbstract = time() . '_abstract_' . $userId . '.' . $request->file_abstract->extension();
                $request->file_abstract->move($path, $fileAbstract);
            }

            $fileKP = null;
            if ($request->hasFile('file_kp')) {
                $fileKP = time() . '_kp_' . $userId . '.' . $request->file_kp->extension();
                $request->file_kp->move($path, $fileKP);
            }

            $fileBukti = null;
            if ($request->hasFile('file_bukti_tf')) {
                $fileBukti = time() . '_tf_' . $userId . '.' . $request->file_bukti_tf->extension();
                $request->file_bukti_tf->move($path, $fileBukti);
            }

            // 4. Logika Simpan Data
            $id_conf = $kategori->id_conf;
            $userId = Auth::id(); // Gunakan ID User langsung

            $submission = PesertaConferences::where('user_id', $userId)
                ->whereHas('kategori', function ($query) use ($id_conf) {
                    $query->where('id_conf', $id_conf);
                })->first();

            // TAMBAHKAN id_pub ke dalam array dataSave
            $dataSave = [
                'user_id'       => $userId,      // Pastikan menggunakan user_id
                'id_ktg'        => $request->id_ktg,
                'id_pub'        => $request->id_pub, // Nilai ini akan null jika bukan presenter (sesuai input hidden/select)
                'file_abstract' => $fileAbstract,
                'file_kp'       => $fileKP,
                'file_bukti_tf'    => $fileBukti,
                'payment'       => 'pending',
            ];

            if ($submission) {
                $submission->update($dataSave);
            } else {
                //$dataSave['id'] = $peserta->id;
                $submission = PesertaConferences::create($dataSave);
            }

            // 4. LOGIKA PERCABANGAN PEMBAYARAN
            if ($isInternational) {
                // KIRIM EMAIL WAITING VALIDATION
                $isPresenter = Str::contains($kategori->nama_ktg, 'Presenter');
                $viewEmail = $isPresenter ? 'emails.waiting_validation' : 'emails.waiting_validation_participant';

                $html = view($viewEmail, [
                    'nama' => $peserta->nama,
                    'kategori' => $peserta->kategori,
                    'nama_conference' => $conference->nama_conf
                ])->render();

                EmailApiService::send($user->email, "Payment Waiting Validation - " . $conference->nama_conf, "Please wait for admin validation.", $html);

                return redirect()->route('participants.conferences')->with('success', 'Registration successful. Please wait for admin to validate your payment.');
            }

            // 5. Konfigurasi Midtrans (Tetap sama)

            $namaKtg = strtolower($kategori->nama_ktg);
            $today = now()->format('Ymd');

            // 1. Tentukan Prefix Awal (Offline/Online)
            $mode = str_contains($namaKtg, 'online') ? 'ON' : 'OF';

            // 2. Tentukan Kode Peran (Student Presenter, Presenter, atau Participant)
            $role = '';
            if (str_contains($namaKtg, 'student presenter')) {
                $role = 'SP';
            } elseif (str_contains($namaKtg, 'presenter')) {
                $role = 'PR';
            } elseif (str_contains($namaKtg, 'participant')) {
                $role = 'PA';
            }

            // 3. Tentukan Region (Domestic/International)
            $region = str_contains($namaKtg, 'international') ? 'I' : 'D';

            // 4. Gabungkan menjadi Kode Invoice
            // ICPIP adalah kode statis Anda, mode+role+region digabung
            $typeCode = $mode . $role . $region;

            $randomNumber = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $order_id = "INV-ICPIP-{$typeCode}-{$today}-{$randomNumber}";

            $durationInMinutes = 180;

            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');

            $params = [
                'transaction_details' => [
                    'order_id' => $order_id,
                    'gross_amount' => $kategori->fee,
                ],
                'customer_details' => [
                    'first_name' => $peserta->nama,
                    'email' => $user->email,
                ],
                'expiry' => [
                    'start_time' => date("Y-m-d H:i:s O"),
                    'unit' => 'minute',
                    'duration' => $durationInMinutes,
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $submission->update([
                'snap' => $snapToken,
                'order_id' => $order_id
            ]);

            $urlPembayaran = route('payment', ['snapToken' => $snapToken]);

            // 6. Persiapan Email (Tetap sama)
            $subject = "Payment Required - " . $conference->nama_conf;
            $expiryDate = now()->addMinutes($durationInMinutes)->format('d M Y H:i');

            $html = view('emails.submit_payment', [
                'nama'            => $peserta->nama,
                'nama_conference' => $conference->nama_conf,
                'biaya'           => $kategori->fee,
                'order_id'        => $order_id,
                'expiry'          => $expiryDate,
                'urlPembayaran'   => $urlPembayaran,
            ])->render();

            $text = "Halo {$peserta->nama}, please complete your payment for {$conference->nama_conf}. Link: {$urlPembayaran}";
            EmailApiService::send($user->email, $subject, $text, $html);
            Log::info('Email tagihan berhasil dikirim ke: ' . $user->email);

            return redirect()->route('payment', ['snapToken' => $snapToken]);
        } catch (Exception $e) {
            Log::error('Terjadi Error di storeSubmission: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to process submission: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $payload = $request->all();
        $order_id = $payload['order_id'] ?? null;
        $status_code = $payload['status_code'] ?? null;
        $gross_amount = $payload['gross_amount'] ?? null;
        $signature_key = $payload['signature_key'] ?? null;
        $transaction_status = $payload['transaction_status'] ?? null;

        Log::info('Masuk notif Pembayaran', ['payload' => $payload]);

        $signature = hash(
            "sha512",
            $order_id . $status_code . $gross_amount . config('midtrans.serverKey')
        );

        if ($signature !== $signature_key) {
            Log::warning('Invalid signature', ['order_id' => $order_id]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $pendaftar = PesertaConferences::where('order_id', $order_id)->first();
        if (!$pendaftar) return response()->json(['message' => 'Data not found'], 404);

        if ($transaction_status === 'settlement') {

            // 1. Cek apakah user sudah punya data sertifikat/QR sebelumnya
            $existing = PesertaConferences::where('user_id', $pendaftar->user_id)
                ->where('id_ktg', $pendaftar->id_ktg)
                ->whereNotNull('no_sertifikat')
                ->where('id_pc', '!=', $pendaftar->id_pc)
                ->first();

            if ($existing) {
                // Gunakan data lama
                $pendaftar->qr_code = $existing->qr_code;
                $pendaftar->no_sertifikat = $existing->no_sertifikat;
            } else {
                // Generate baru jika belum ada
                $safeIdCard = preg_replace('/[^A-Za-z0-9]/', '', $pendaftar->peserta->nama_peserta ?? $pendaftar->user->name ?? 'presenter');
                $fileName = "{$safeIdCard}_" . Str::upper(Str::random(6)) . ".png";
                generateGoQrAndSave($fileName, $fileName);
                $pendaftar->qr_code = $fileName;

                $suffix = "/ICPIP-HE-I/CERTIF/VI/2026";
                $lastRecord = PesertaConferences::where('no_sertifikat', 'like', '%' . $suffix)->orderBy('no_sertifikat', 'desc')->first();
                $nextNumber = $lastRecord ? ((int)explode('/', $lastRecord->no_sertifikat)[0] + 1) : 1;
                $pendaftar->no_sertifikat = str_pad($nextNumber, 2, '0', STR_PAD_LEFT) . $suffix;
            }

            $pendaftar->payment = 'success';
            $pendaftar->status_abstract = Str::contains($pendaftar->kategori->nama_ktg, 'Presenter') ? 'waiting review' : null;
            $pendaftar->save();

            // 2. Generate PDF & Kirim Email
            $attachmentPath = null;
            try {
                $namaPeserta = $pendaftar->user->peserta->nama ?? $pendaftar->user->name ?? 'Participant';
                $no_invoice = sprintf("INV/%s/%02d/ICPIP-HE/%d", explode('/', $pendaftar->no_sertifikat)[0], date('n'), date('Y'));

                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.pdf_invoice_template', [
                    'no_invoice' => $no_invoice,
                    'nama' => $namaPeserta,
                    'email' => $pendaftar->user->email ?? '-',
                    'kategori' => $pendaftar->kategori->nama_ktg,
                    'nominal' => ((int)($gross_amount ?? $pendaftar->nominal ?? 0)) - 5000,
                    'tanggal' => now()->format('F d, Y'),
                ]);

                $tempDir = storage_path('app/public/temp');
                if (!File::isDirectory($tempDir)) File::makeDirectory($tempDir, 0777, true, true);
                $attachmentPath = $tempDir . '/Invoice_' . Str::slug($namaPeserta) . '_' . time() . '.pdf';
                $pdf->save($attachmentPath);
            } catch (\Exception $e) {
                Log::error("Gagal buat PDF: " . $e->getMessage());
            }

            try {
                $html = view('emails.notif_payment', [
                    'nama' => $pendaftar->user->peserta->nama ?? $pendaftar->user->name,
                    'nama_conference' => $pendaftar->kategori->conference->nama_conf,
                    'no_sertifikat' => $pendaftar->no_sertifikat,
                    'url' => config('app.url'),
                ])->render();

                EmailApiService::send(
                    $pendaftar->user->email,
                    'Payment Successful - Certificate Generated',
                    "Pembayaran sukses. Sertifikat: {$pendaftar->no_sertifikat}",
                    $html,
                    $attachmentPath
                );
            } catch (\Exception $e) {
                Log::error("Gagal kirim email: " . $e->getMessage());
            }
        } elseif (in_array(strtolower($transaction_status), ['expire', 'expired'])) {
            $pendaftar->update(['payment' => 'expired']);
            $pendaftar->delete();
            Log::info('Pendaftaran expired', ['order_id' => $order_id]);
        }

        return response()->json(['message' => 'success']);
    }

    public function updateRevision(Request $request, $id_pc)
    {
        $request->validate([
            'file_abstract' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        try {
            // Cari data pendaftaran berdasarkan Primary Key (id_pc)
            $submission = PesertaConferences::findOrFail($id_pc);

            // PERBAIKAN SECURITY CHECK: 
            // Langsung bandingkan user_id di tabel dengan ID user yang sedang login
            if ($submission->user_id != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized action. This is not your submission.');
            }

            $userId = Auth::id();
            $path = config('path.submissions');

            // Pastikan folder ada
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // 1. Hapus file lama jika ada untuk menjaga storage
            if ($submission->file_abstract) {
                $oldFile = $path . '/' . $submission->file_abstract; // Gunakan separator yang benar
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            // 2. Simpan file baru dengan prefix 'rev_'
            $fileName = time() . '_rev_' . $userId . '.' . $request->file_abstract->extension();
            $request->file_abstract->move($path, $fileName);

            // 3. Update database: Status kembali ke 'waiting review'
            $submission->update([
                'file_abstract' => $fileName,
                'status_abstract' => 'waiting review',
            ]);

            return redirect()->back()->with('success', 'Your revision has been submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Revision Upload Error for Submission ID ' . $id_pc . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong during the upload.');
        }
    }

    public function uploadArticle(Request $request, $id_pc)
    {
        $request->validate([
            'file_artikel' => 'required|file|mimes:doc,docx|max:10240',
        ], [
            'file_artikel.required' => 'Please select an article file.',
            'file_artikel.file' => 'Invalid file.',
            'file_artikel.mimes' => 'Only DOC and DOCX files are allowed.',
            'file_artikel.max' => 'Maximum file size is 10 MB.',
        ]);

        try {
            // Ambil data pendaftaran
            $submission = PesertaConferences::findOrFail($id_pc);

            // PERBAIKAN SECURITY CHECK: 
            // Langsung bandingkan user_id di tabel dengan ID user yang sedang login
            if ($submission->user_id != Auth::id()) {
                return redirect()->back()->with('error', 'Unauthorized action. This record does not belong to your account.');
            }

            $userId = Auth::id();
            $path = config('path.submissions');

            // Pastikan direktori tujuan tersedia
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            // 1. Hapus file artikel lama jika ada (Manajemen Storage)
            if ($submission->file_artikel) {
                $oldFile = $path . '/' . $submission->file_artikel;
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            // 2. Simpan file artikel baru dengan prefix 'article_'
            $fileName = time() . '_article_' . $userId . '.' . $request->file_artikel->extension();
            $request->file_artikel->move($path, $fileName);

            // 3. Update database: Status artikel menjadi 'waiting review'
            $submission->update([
                'file_artikel' => $fileName,
                'status_artikel' => 'waiting review',
            ]);

            return redirect()->back()->with('success', 'Full Article has been uploaded successfully. Current status: Waiting Review.');
        } catch (\Exception $e) {
            Log::error('Article Upload Error for ID ' . $id_pc . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload article. Please try again or contact support.');
        }
    }

    public function downloadCertificate($id_pc)
    {
        // 1. Load data
        $sub = PesertaConferences::with(['user.peserta', 'kategori.conference'])->findOrFail($id_pc);

        if ($sub->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // --- BAGIAN YANG DIUBAH ---

        // Ambil tahun dari kolom deadline_subm (format database biasanya YYYY-MM-DD)
        $deadline = $sub->kategori->conference->deadline_subm;
        $tahun = \Carbon\Carbon::parse($deadline)->format('Y');

        $isPresenter = \Illuminate\Support\Str::contains($sub->kategori->nama_ktg, 'Presenter');
        $roleSuffix = $isPresenter ? 'Presenter' : 'Participant';

        // Format nama file: NamaConference_Presenter_2026 atau NamaConference_Participant_2026
        $baseFileName = $sub->kategori->conference->nama_conf . '_' . $roleSuffix . '_' . $tahun;

        // --------------------------

        // 2. Cari File Background
        $path = config('path.sertifikat');
        $bgFile = null;
        $extension = null;

        foreach (['png', 'jpg', 'jpeg'] as $ext) {
            $fullPath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $baseFileName . '.' . $ext;
            if (file_exists($fullPath)) {
                $bgFile = $fullPath;
                $extension = $ext;
                break;
            }
        }

        if (!$bgFile) {
            return redirect()->back()->with('error', 'Certificate template for "' . $baseFileName . '" not found.');
        }

        // 3. Buat Objek Gambar
        $image = ($extension == 'png') ? imagecreatefrompng($bgFile) : imagecreatefromjpeg($bgFile);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        // 4. Konfigurasi Teks
        $color = imagecolorallocate($image, 0, 0, 0);
        $fontPath = public_path('assets/fonts/ARIALBD.TTF');

        $nama = $sub->user->peserta->nama ?? ($sub->user->name ?? 'PARTICIPANT');
        // $nama = strtoupper($namaRaw);
        $noSertif = "No: " . ($sub->no_sertifikat ?? '---');

        // 5. Fungsi Centering & Render
        $imageWidth = imagesx($image);
        $drawCenteredText = function ($img, $size, $y, $color, $font, $text) use ($imageWidth) {
            $type_space = imagettfbbox($size, 0, $font, $text);
            $text_width = abs($type_space[4] - $type_space[0]);
            $x = ($imageWidth - $text_width) / 2;
            imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
        };

        $drawCenteredText($image, 50, 1600, $color, $fontPath, $noSertif);
        $drawCenteredText($image, 180, 2060, $color, $fontPath, $nama);

        // 6. Output
        $safeName = \Illuminate\Support\Str::slug($nama, '_');
        $fileName = 'Sertifikat_' . $safeName . '.jpg';

        header('Content-Type: image/jpeg');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        imagejpeg($image, null, 90);
        imagedestroy($image);
        exit;
    }
}
