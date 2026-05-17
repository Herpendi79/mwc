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

        // TAMBAHKAN 'publikasi' di dalam array with()
        $userSubmissions = PesertaConferences::where('user_id', $user->id)
            ->whereHas('kategori')
            ->with(['kategori', 'publikasi']) // Perbaikan di sini
            ->get()
            ->keyBy(function ($item) {
                return $item->kategori?->id_conf;
            });

        return view('participants.conferences', compact('conferences', 'today', 'userSubmissions'));
    }

    public function submitForm(int $id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);
        $today = \Carbon\Carbon::today();

        // Proteksi: Jika sudah melewati deadline, tidak bisa akses form
        if ($today->greaterThan(\Carbon\Carbon::parse($conference->deadline_subm))) {
            return redirect()->route('participants.conferences')->with('error', 'Submission deadline has passed.');
        }
        $user = Auth::user();
        $negaraPeserta = 'Indonesia'; // Default
        if ($user && $user->peserta) {
            $negaraPeserta = $user->peserta->negara;
        }

        $queryKategori = Kategori::where('id_conf', $id_conf);
        $queryKategori->where(function ($q) {
            $q->where('keterangan', 'NOT LIKE', '%Adaksi%')
                ->orWhereNull('keterangan');
        });

        if (strtolower($negaraPeserta) !== 'indonesia') {
            // Jika bukan orang Indonesia, hanya tampilkan kategori International
            $queryKategori->where('domisili', 'international');
        } else {
            // Jika orang Indonesia, tampilkan semua kategori (atau bisa difilter hanya domestic saja)
            // Umumnya domestik tetap bisa melihat international, tapi jika ingin eksklusif:
            $queryKategori->where('domisili', '!=', 'international');
        }

        $kategoris = $queryKategori->get();
        $publikasis = Publikasi::all();

        return view('participants.submit', compact('conference', 'kategoris', 'publikasis'));
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

        $order_id      = $payload['order_id'] ?? null;
        $status_code   = $payload['status_code'] ?? null;
        $gross_amount  = $payload['gross_amount'] ?? null;
        $signature_key = $payload['signature_key'] ?? null;
        $transaction_status = $payload['transaction_status'] ?? null;

        // Webinar NON ANGGOTA
        Log::info('masuk notif Pembayaran', ['payload' => $payload]);
        $signature = hash(
            "sha512",
            $order_id . $status_code . $gross_amount . config('midtrans.serverKey')
        );

        if ($signature !== $signature_key) {
            Log::warning('Invalid signature', [
                'expected' => $signature,
                'received' => $signature_key,
                'concat'   => $order_id . $status_code . $gross_amount . config('midtrans.serverKey'),
            ]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        //01/ICPIP-HE-I/ADAKSI/V/2026
        $pendaftar = PesertaConferences::where('order_id', $order_id)->first();

        if ($transaction_status === 'settlement') {

            $safeIdCard = preg_replace('/[^A-Za-z0-9]/', '', $pendaftar->peserta->nama_peserta ?? $pendaftar->user->name ?? 'presenter');
            $randomString = Str::upper(Str::random(6));
            $fileNameOnly = "{$safeIdCard}_{$randomString}";
            $fileName = "{$fileNameOnly}.png";

            // Isi QR adalah id_card + random
            $qrContent = $fileName;

            // Generate QR
            generateGoQrAndSave($qrContent, $fileName);
            $pendaftar->qr_code = $fileName;

            // 1. Tentukan pola string tetap (suffix)
            $suffix = "/ICPIP-HE-I/CERTIF/VI/2026";
            $lastRecord = PesertaConferences::where('no_sertifikat', 'like', '%' . $suffix)
                ->orderBy('no_sertifikat', 'desc')
                ->first();

            if ($lastRecord) {
                $parts = explode('/', $lastRecord->no_sertifikat);
                $lastNumber = (int)$parts[0];
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }
            $formattedNumber = str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
            $no_sertifikat = $formattedNumber . $suffix;

            $pendaftar->no_sertifikat = $no_sertifikat;
            $pendaftar->payment = 'success'; // Pastikan status pembayaran juga diperbarui
            $namaKategori = $pendaftar->kategori->nama_ktg;

            if (\Illuminate\Support\Str::contains($namaKategori, 'Presenter')) {
                $pendaftar->status_abstract = 'waiting review';
            } else {
                // Jika Participant, status_abstract bisa tetap null atau diisi 'not applicable'
                $pendaftar->status_abstract = null;
            }
            $pendaftar->save();

            Log::info("Sertifikat berhasil digenerate: " . $no_sertifikat . " untuk User ID: " . $pendaftar->id);

            // Kirim email notif via EmailApiService
            try {
                // 1. Ambil user langsung dari pendaftar (karena sudah relasi langsung)
                $user = $pendaftar->user;

                // 2. Ambil nama: prioritaskan nama dari tabel peserta, jika null ambil dari tabel user
                // (Gunakan null-safe operator ?-> untuk mencegah error jika data salah satu null)
                $namaPeserta = $pendaftar->user->peserta->nama ?? $user->name;

                $namaConference = $pendaftar->kategori->conference->nama_conf;

                $html = view('emails.notif_payment', [
                    'nama'            => $namaPeserta,
                    'nama_conference' => $namaConference,
                    'no_sertifikat'   => $no_sertifikat,
                    'url'             => config('app.url'),
                ])->render();

                $text = "Halo {$namaPeserta}, pembayaran Anda untuk {$namaConference} telah berhasil. Nomor Sertifikat Anda: {$no_sertifikat}.";

                // Pastikan $user tidak null sebelum kirim email
                if ($user && $user->email) {
                    EmailApiService::send(
                        $user->email,
                        'Payment Successful - Certificate Generated',
                        $text,
                        $html
                    );
                    Log::info("Email notifikasi sukses dikirim ke: " . $user->email);
                } else {
                    Log::warning("Gagal mengirim email: Data user atau email tidak ditemukan untuk ID Pendaftar: " . $pendaftar->id_pc);
                }
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email notifikasi: " . $e->getMessage());
            }
        } elseif (in_array(strtolower($transaction_status), ['expire', 'expired'])) {
            $pendaftar = PesertaConferences::where('order_id', $order_id)->first();
            $pendaftar->payment = 'expired'; // Pastikan status pembayaran juga diperbarui
            $pendaftar->delete();

            Log::info('Pendaftaran expired dan dihapus', ['order_id' => $order_id]);
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
            'file_artikel' => 'required|file|mimes:pdf,doc,docx|max:5120', // Max 5MB
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
        // 1. Load data dengan relasi baru: user (dan peserta jika ada) serta kategori
        $sub = PesertaConferences::with(['user.peserta', 'kategori.conference'])->findOrFail($id_pc);

        // SECURITY CHECK: Pastikan sertifikat ini milik user yang sedang login
        if ($sub->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $confName = $sub->kategori->conference->nama_conf;

        // 2. Cari File Background
        $path = config('path.sertifikat');
        $bgFile = null;
        $extension = null;

        foreach (['png', 'jpg', 'jpeg'] as $ext) {
            // Gunakan DIRECTORY_SEPARATOR agar kompatibel dengan MacBook/Linux/Hosting
            $fullPath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $confName . '.' . $ext;
            if (file_exists($fullPath)) {
                $bgFile = $fullPath;
                $extension = $ext;
                break;
            }
        }

        if (!$bgFile) {
            return redirect()->back()->with('error', 'Certificate template for "' . $confName . '" not found.');
        }

        // 3. Buat Objek Gambar
        $image = ($extension == 'png') ? imagecreatefrompng($bgFile) : imagecreatefromjpeg($bgFile);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        // 4. Konfigurasi Teks
        $color = imagecolorallocate($image, 0, 0, 0);
        $fontPath = public_path('assets/fonts/ARIAL.TTF');

        if (!file_exists($fontPath)) {
            return redirect()->back()->with('error', 'Font file not found.');
        }

        // PERBAIKAN PENGAMBILAN NAMA:
        // Prioritas: 1. Tabel Peserta, 2. Tabel User (name), 3. Default
        $namaRaw = $sub->user->peserta->nama ?? ($sub->user->name ?? 'PARTICIPANT');
        $nama = strtoupper($namaRaw);

        $noSertif = "No: " . ($sub->no_sertifikat ?? '---');
        $role = \Illuminate\Support\Str::contains($sub->kategori->nama_ktg, 'Presenter') ? "As Presenter" : "As Participant";

        // 5. Fungsi Centering
        $imageWidth = imagesx($image);
        $drawCenteredText = function ($img, $size, $y, $color, $font, $text) use ($imageWidth) {
            $type_space = imagettfbbox($size, 0, $font, $text);
            $text_width = abs($type_space[4] - $type_space[0]);
            $x = ($imageWidth - $text_width) / 2;
            imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
        };

        // Render Teks
        $drawCenteredText($image, 20, 450, $color, $fontPath, $noSertif);
        $drawCenteredText($image, 45, 600, $color, $fontPath, $nama);
        $drawCenteredText($image, 30, 750, $color, $fontPath, $role);

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
