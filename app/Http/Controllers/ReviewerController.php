<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Publikasi;
use App\Models\Conferences;
use App\Models\PesertaConferences;
use App\Models\PesertaConferencesAdaksi;
use App\Models\Kategori; // Pastikan Model Kategori di-import
use App\Models\MonitoringParticipant;
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
use App\Models\MonitoringPresenter;
use App\Jobs\SendSubmissionEmail;

class ReviewerController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 1. Ambil data conference dengan rincian pendaftar
        $conferences = Conferences::withCount([
            'pendaftar as total_pendaftar',
            'pendaftar as total_presenter' => function ($query) {
                $query->whereHas('kategori', function ($q) {
                    $q->where('nama_ktg', 'like', '%Presenter%');
                });
            },
            'pendaftar as total_participant' => function ($query) {
                $query->whereHas('kategori', function ($q) {
                    $q->where('nama_ktg', 'like', '%Participant%');
                });
            }
        ])
            ->orderBy('tgl_mulai', 'desc')
            ->get();

        // 2. Logika: Aktif (tgl_selesai >= hari ini)
        $totalActive = Conferences::where('tgl_selesai', '>=', $today)->count();

        // 3. Logika: Berlalu (tgl_selesai < hari ini)
        $totalPassed = Conferences::where('tgl_selesai', '<', $today)->count();

        return view('reviewer.index', compact(
            'conferences',
            'totalActive',
            'totalPassed'
        ));
    }

    public function registrantWaitValidList($id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);


        $baseQuery = MonitoringParticipant::with('kategori')
            ->where('id_conf', $id_conf)
            ->where('payment', 'pending')
            ->where('file_bukti_tf', '!=', null);

        $participants = $baseQuery
            ->orderBy('tanggal_daftar', 'desc')
            ->paginate(10)
            ->withQueryString();

        //dd($participants->first()->toArray());

        $allParticipants = (clone $baseQuery)->get();
        $stats = $allParticipants->groupBy('kategori.nama_ktg');
        $totalCount = $allParticipants->count();

        return view('reviewer.registrant_wait_valid_list', compact('conference', 'participants', 'stats', 'totalCount'));
    }

    public function participantsList($id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);


        $baseQuery = MonitoringParticipant::with('kategori')
            ->where('id_conf', $id_conf)
            ->where('payment', 'success')
            ->whereHas('kategori', function ($query) {
                $query->where('nama_ktg', 'like', '%participant%');
            });

        $participants = $baseQuery
            ->orderBy('tanggal_daftar', 'desc')
            ->paginate(10)
            ->withQueryString();

        //dd($participants->first()->toArray());

        $allParticipants = (clone $baseQuery)->get();
        $stats = $allParticipants->groupBy('kategori.nama_ktg');
        $totalCount = $allParticipants->count();

        return view('reviewer.participants_list', compact('conference', 'participants', 'stats', 'totalCount'));
    }

    public function presentersList($id_conf)
    {
        $conference = Conferences::findOrFail($id_conf);

        // 1. Definisikan Base Query (Filter Utama)
        $baseQuery = MonitoringPresenter::with('kategori')
            ->where('id_conf', $id_conf)
            ->whereHas('kategori', function ($query) {
                $query->where('nama_ktg', 'like', '%presenter%');
            });

        // 2. Ambil statistik dari klon baseQuery agar tidak mengganggu query utama
        $allPresenters = (clone $baseQuery)->get();
        $stats = $allPresenters->groupBy('kategori.nama_ktg');
        $totalCount = $allPresenters->count();

        // 3. Gunakan baseQuery yang sama untuk Paginasi & Sorting
        $presenters = $baseQuery
            ->orderByRaw("
            CASE 
                WHEN LOWER(status_abstract) = 'waiting review' THEN 1
                WHEN LOWER(status_artikel) = 'waiting review' THEN 2
                WHEN LOWER(status_abstract) = 'accepted' AND LOWER(status_artikel) = 'accepted' THEN 5
                WHEN LOWER(status_abstract) = 'accepted' OR LOWER(status_artikel) = 'accepted' THEN 4
                ELSE 3
            END ASC
        ")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('reviewer.presenters_list', compact('conference', 'presenters', 'stats', 'totalCount'));
    }

    public function conferences()
    {
        // Ambil semua data conference
        $conferences = Conferences::all();
        $totalAll = 0; // Variabel untuk akumulasi total seluruh conference

        // Tambahkan hitungan jumlah presenter & participant untuk setiap conference
        foreach ($conferences as $conf) {
            // Hitung Presenter (payment success & kategori presenter)
            $conf->total_presenter = MonitoringPresenter::where('id_conf', $conf->id_conf)
                ->where('payment', 'success')
                ->whereHas('kategori', function ($query) {
                    $query->where('nama_ktg', 'like', '%presenter%');
                })->count();

            // Hitung Participant (payment success & kategori participant)
            $conf->total_participant = MonitoringParticipant::where('id_conf', $conf->id_conf)
                ->where('payment', 'success')
                ->whereHas('kategori', function ($query) {
                    $query->where('nama_ktg', 'like', '%participant%');
                })->count();

            $conf->antrean_review = MonitoringParticipant::where('id_conf', $conf->id_conf)
                ->where('payment', 'pending')
                ->whereNotNull('file_bukti_tf')
                ->count();

            $conf->total_per_conf = $conf->total_presenter + $conf->total_participant;

            // Akumulasi untuk total seluruh conference
            $totalAll += $conf->total_per_conf;
        }

        return view('reviewer.conferences', compact('conferences', 'totalAll'));
    }

    // Fungsi untuk update status abstract (revision atau accepted)
    public function updateStatus(Request $request, $id, $sumber)
    {
        // 1. Fetch data berdasarkan sumber (ADAKSI atau Umum)
        if ($sumber === 'ADAKSI') {
            $presenter = \App\Models\PesertaConferencesAdaksi::with(['user.anggota', 'kategori.conference'])
                ->where('id_pca', $id)
                ->firstOrFail();

            $user = $presenter->user;
            $nama_peserta = $user->anggota->nama_anggota ?? 'Participant';
        } else {
            $presenter = PesertaConferences::with(['peserta.user', 'kategori.conference'])
                ->where('id_pc', $id)
                ->firstOrFail();

            $user = $presenter->peserta->user ?? null;
            $nama_peserta = $presenter->peserta->nama ?? 'Participant';
        }

        if (!$user || !$user->email) {
            Log::error("User atau Email tidak ditemukan untuk ID: {$id} pada sumber: {$sumber}");
            return back()->with('error', 'User email not found. Status updated in database, but notification failed.');
        }

        $status = $request->input('status');
        $comment = $request->input('comment');
        $nama_conference = $presenter->kategori->conference->nama_conf;

        // Mulai Transaksi Database
        DB::beginTransaction();
        try {
            if ($status === 'revision') {
                // 2. Logika Revision: Hapus file lama dan kosongkan status
                if ($presenter->file_abstract) {
                    $path = config('path.submissions') . $presenter->file_abstract;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                $presenter->update([
                    'status_abstract' => null,
                    'file_abstract'   => null,
                    'keterangan'      => $comment,
                ]);

                $subject = "Revision Required: Abstract Submission - " . $nama_conference;
                $text = "Dear {$nama_peserta}, your abstract requires revision. Feedback: {$comment}";
            } else {
                // 3. Logika Accepted
                $presenter->update([
                    'status_abstract' => 'accepted',
                ]);

                $subject = "Accepted: Abstract Submission Notification - " . $nama_conference;
                $text = "Congratulations {$nama_peserta}, your abstract has been accepted.";
            }

            // 4. Siapkan View Email
            $html = view('emails.review_abstract', [
                'nama'    => $nama_peserta,
                'status'  => $status,
                'comment' => $comment,
                'nama_conference' => $nama_conference
            ])->render();

            // 5. Masukkan ke Queue (Antrean)
            SendSubmissionEmail::dispatch([
                'to'      => $user->email,
                'subject' => $subject,
                'text'    => $text,
                'html'    => $html,
            ])->onQueue('conference'); // Jalur khusus agar tidak bentrok dengan adaksi.org

            DB::commit();
            Log::info("Status abstract updated & job dispatched for: " . $user->email);

            return back()->with('success', 'Decision submitted and notification email is being processed in background.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Gagal update status review: " . $e->getMessage());
            return back()->with('error', 'Something went wrong. Database rolled back.');
        }
    }

    //update status artikel (accepted atau revision)
    public function updateStatusArtikel(Request $request, $id, $sumber)
    {
        // 1. Identifikasi Sumber Data (ADAKSI atau UMUM)
        if ($sumber === 'ADAKSI') {
            $presenter = \App\Models\PesertaConferencesAdaksi::with(['user.anggota', 'kategori.conference'])
                ->where('id_pca', $id)
                ->firstOrFail();

            $user = $presenter->user;
            $nama_peserta = $user->anggota->nama_anggota ?? 'Participant';
        } else {
            $presenter = \App\Models\PesertaConferences::with(['peserta.user', 'kategori.conference'])
                ->where('id_pc', $id)
                ->firstOrFail();

            $user = $presenter->peserta->user ?? null;
            $nama_peserta = $presenter->peserta->nama ?? 'Participant';
        }

        if (!$user || !$user->email) {
            Log::error("User/Email tidak ditemukan untuk ID: {$id} ({$sumber})");
            return back()->with('error', 'User email not found. Notification failed.');
        }

        $status = $request->input('status');
        $comment = $request->input('comment');
        $nama_conference = $presenter->kategori->conference->nama_conf;

        // 2. Mulai Transaksi Database
        DB::beginTransaction();
        try {
            if ($status === 'revision') {
                // Hapus file artikel lama jika ada revisi
                if ($presenter->file_artikel) {
                    $path = config('path.submissions') . $presenter->file_artikel;
                    if (\Illuminate\Support\Facades\File::exists($path)) {
                        \Illuminate\Support\Facades\File::delete($path);
                    }
                }

                // Update Database (Kosongkan file agar user bisa upload ulang)
                $presenter->update([
                    'status_artikel' => null,
                    'file_artikel'   => null,
                    'keterangan'      => $comment,
                ]);

                $subject = "Revision Required: Full Paper Submission - " . $nama_conference;
                $text = "Dear {$nama_peserta}, your full paper requires revision. Feedback: {$comment}";
            } else {
                // Update Database ke Accepted
                $presenter->update([
                    'status_artikel' => 'accepted',
                ]);

                $subject = "Accepted: Full Paper Submission Notification - " . $nama_conference;
                $text = "Congratulations {$nama_peserta}, your Full Paper has been accepted.";
            }

            // 3. Render HTML untuk Email
            $html = view('emails.review_artikel', [
                'nama'    => $nama_peserta,
                'status'  => $status,
                'comment' => $comment,
                'nama_conference' => $nama_conference
            ])->render();

            // 4. Kirim ke Queue (Jalur Conference)
            SendSubmissionEmail::dispatch([
                'to'      => $user->email,
                'subject' => $subject,
                'text'    => $text,
                'html'    => $html,
            ])->onQueue('conference');

            DB::commit();
            Log::info("Full Paper review processed for: " . $user->email);

            return back()->with('success', 'Full Paper decision submitted. Notification email is being sent in background.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Gagal update status artikel: " . $e->getMessage());
            return back()->with('error', 'An error occurred while processing the decision.');
        }
    }

    public function updateStatusPayment(Request $request, $id)
    {
        // 1. Load data
        $pesertaConf = PesertaConferences::with(['peserta.user', 'kategori.conference'])->findOrFail($id);

        $status = $request->input('status');
        $comment = $request->input('comment');
        $user = $pesertaConf->peserta->user;
        $nama_peserta = $pesertaConf->peserta->nama ?? 'Participant';
        $nama_conference = $pesertaConf->kategori->conference->nama_conf;
        $nama_kategori = strtolower($pesertaConf->kategori->nama_ktg);

        $keterangan_tambahan = "";
        $recipientEmail = $user->email;

        // 2. Mulai Transaksi
        DB::beginTransaction();
        try {
            if ($status === 'success') {
                // Logika Sertifikat
                $suffix = "/ICPIP-HE-I/CERTIF/VI/2026";
                $lastRecord = PesertaConferences::where('no_sertifikat', 'like', '%' . $suffix)
                    ->orderBy('no_sertifikat', 'desc')
                    ->first();

                $nextNumber = $lastRecord ? (int)explode('/', $lastRecord->no_sertifikat)[0] + 1 : 1;
                $no_sertifikat = str_pad($nextNumber, 2, '0', STR_PAD_LEFT) . $suffix;

                $updateData = [
                    'payment' => 'success',
                    'no_sertifikat' => $no_sertifikat
                ];

                if (str_contains($nama_kategori, 'presenter')) {
                    $updateData['status_abstract'] = 'waiting review';
                    $keterangan_tambahan = "The next process is the review of your abstract by the reviewer.";
                } else {
                    $keterangan_tambahan = "Congratulations, your payment is valid. See you on the conference day! You can download your certificate after the conference ends.";
                }

                $pesertaConf->update($updateData);
                $subject = "Payment Verified: " . $nama_conference;
                $text = "Dear {$nama_peserta}, your payment has been successfully verified. {$keterangan_tambahan}";
            } else if ($status === 'nonvalid') {
                // Hapus file bukti transfer
                if ($pesertaConf->file_bukti_tf) {
                    $filePath = config('path.submissions') . $pesertaConf->file_bukti_tf;
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                $subject = "Payment Rejected: " . $nama_conference;
                $text = "Dear {$nama_peserta}, your payment proof was rejected. Reason: {$comment}.";

                // Simpan info ke variabel sebelum data dihapus
                $htmlData = [
                    'nama' => $nama_peserta,
                    'status' => $status,
                    'comment' => $comment,
                    'nama_conference' => $nama_conference,
                    'keterangan_tambahan' => ""
                ];

                // Hapus data (jika ini memang alur yang diinginkan untuk nonvalid)
                $pesertaConf->delete();
            }

            // 3. Render HTML Email
            $html = view('emails.payment_status', [
                'nama'    => $nama_peserta,
                'status'  => $status,
                'comment' => $comment,
                'nama_conference' => $nama_conference,
                'keterangan_tambahan' => $keterangan_tambahan
            ])->render();

            // 4. Masukkan ke Queue
            SendSubmissionEmail::dispatch([
                'to'      => $recipientEmail,
                'subject' => $subject,
                'text'    => $text,
                'html'    => $html,
            ])->onQueue('conference');

            DB::commit();
            return back()->with('success', 'Payment status updated and notification is being sent.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Gagal update status payment: " . $e->getMessage());
            return back()->with('error', 'Failed to process payment update.');
        }
    }

    public function allPresenters(Request $request)
    {
        $query = MonitoringPresenter::with('kategori');

        // Logic Search Server-Side
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_user', 'like', "%$search%")
                    ->orWhere('email_user', 'like', "%$search%");
            });
        }

        $presenters = $query->orderByRaw("
            CASE 
                WHEN LOWER(status_abstract) = 'waiting review' THEN 1
                WHEN LOWER(status_artikel) = 'waiting review' THEN 2
                ELSE 3 
            END ASC
        ")
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Menjaga parameter search tetap ada saat pindah halaman

        return view('reviewer.all_presenters', compact('presenters'));
    }
}
