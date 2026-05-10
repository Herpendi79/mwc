<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Publikasi;
use App\Models\Conferences;
use App\Models\Kategori; // Pastikan Model Kategori di-import
use App\Models\MonitoringParticipant;
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
use App\Models\MonitoringPresenter;

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
    public function updateStatus(Request $request, $id)
    {
        $presenter = PesertaConferences::with(['peserta.user', 'kategori.conference'])->findOrFail($id);

        $status = $request->input('status');
        $comment = $request->input('comment');
        $user = $presenter->peserta->user;

        $nama_conference = $presenter->kategori->conference->nama_conf;

        if ($status === 'revision') {
            // 1. Hapus file abstract lama
            if ($presenter->file_abstract) {
                //$path = public_path('../../public_html/uploads/file/submissions' . $presenter->file_abstract);
                $path = config('path.submissions') . $presenter->file_abstract;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // 2. Update Database (Kosongkan file dan status agar bisa upload ulang)
            $presenter->update([
                'status_abstract' => null,
                'file_abstract'   => null,
                'keterangan'      => $comment,
            ]);

            $subject = "Revision Required: Abstract Submission - " . $nama_conference;
            $text = "Dear {$presenter->peserta->nama}, your abstract requires revision. Feedback: {$comment}";
        } else {
            // 1. Update Database ke Accepted
            $presenter->update([
                'status_abstract' => 'accepted',
            ]);

            $subject = "Accepted: Abstract Submission Notification - " . $nama_conference;
            $text = "Congratulations {$presenter->peserta->nama}, your abstract has been accepted. Please upload your full paper.";
        }

        // --- INTEGRASI EMAIL API SERVICE ---
        $html = view('emails.review_abstract', [
            'nama'    => $presenter->peserta->nama,
            'status'  => $status,
            'comment' => $comment,
        ])->render();

        try {
            EmailApiService::send($user->email, $subject, $text, $html);
            Log::info("Email notifikasi review ({$status}) berhasil dikirim ke: " . $user->email);

            return back()->with('success', 'Decision submitted and notification email has been sent.');
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email review: " . $e->getMessage());
            return back()->with('error', 'Status updated, but failed to send email notification.');
        }
    }

    //update status artikel (accepted atau revision)
    public function updateStatusArtikel(Request $request, $id)
    {
        $presenter = PesertaConferences::with(['peserta.user', 'kategori.conference'])->findOrFail($id);

        $status = $request->input('status');
        $comment = $request->input('comment');
        $user = $presenter->peserta->user;

        $nama_conference = $presenter->kategori->conference->nama_conf;

        if ($status === 'revision') {
            // 1. Hapus file abstract lama
            if ($presenter->file_artikel) {
                //$path = public_path('assets/file/submissions/' . $presenter->file_artikel);
                $path = config('path.submissions') . $presenter->file_artikel;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // 2. Update Database (Kosongkan file dan status agar bisa upload ulang)
            $presenter->update([
                'status_artikel' => null,
                'file_artikel'   => null,
                'keterangan'      => $comment,
            ]);

            $subject = "Revision Required: Full Paper Submission - " . $nama_conference;
            $text = "Dear {$presenter->peserta->nama}, your full paper requires revision. Feedback: {$comment}";
        } else {
            // 1. Update Database ke Accepted
            $presenter->update([
                'status_artikel' => 'accepted',
            ]);

            $subject = "Accepted: Full Paper Submission Notification - " . $nama_conference;
            $text = "Congratulations {$presenter->peserta->nama}, your Full Paper has been accepted. Please wait the next information.";
        }

        // --- INTEGRASI EMAIL API SERVICE ---
        $html = view('emails.review_artikel', [
            'nama'    => $presenter->peserta->nama,
            'status'  => $status,
            'comment' => $comment,
        ])->render();

        try {
            EmailApiService::send($user->email, $subject, $text, $html);
            Log::info("Email notifikasi review ({$status}) berhasil dikirim ke: " . $user->email);

            return back()->with('success', 'Decision submitted and notification email has been sent.');
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email review: " . $e->getMessage());
            return back()->with('error', 'Status updated, but failed to send email notification.');
        }
    }

    public function updateStatusPayment(Request $request, $id)
    {
        $pesertaConf = PesertaConferences::with(['peserta.user', 'kategori.conference'])->findOrFail($id);

        $status = $request->input('status');
        $comment = $request->input('comment');
        $user = $pesertaConf->peserta->user;
        $nama_conference = $pesertaConf->kategori->conference->nama_conf;

        // Ambil nama kategori untuk pengecekan pesan
        $nama_kategori = strtolower($pesertaConf->kategori->nama_ktg);
        $keterangan_tambahan = "";

        if ($status === 'success') {
            $pesertaConf->update(['payment' => 'success']);

            // Logika Pesan Berdasarkan Kategori
            if (str_contains($nama_kategori, 'presenter')) {
                $keterangan_tambahan = "The next process is the review of your abstract by the reviewer.";
            } else {
                $keterangan_tambahan = "Congratulations, your payment is valid. See you on the conference day!";
            }

            $subject = "Payment Verified: " . $nama_conference;
            $text = "Dear {$pesertaConf->peserta->nama}, your payment has been successfully verified. {$keterangan_tambahan}";
        } else if ($status === 'nonvalid') {
            // ... (Logika hapus file tetap sama)
            if ($pesertaConf->file_bukti_tf) {
               // $filePath = public_path('assets/file/submissions/' . $pesertaConf->file_bukti_tf);
                $filePath = config('path.submissions') . $pesertaConf->file_bukti_tf;
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $subject = "Payment Rejected: " . $nama_conference;
            $text = "Dear {$pesertaConf->peserta->nama}, your payment proof was rejected. Reason: {$comment}.";

            $recipientEmail = $user->email;
            $recipientName = $pesertaConf->peserta->nama;

            $html = view('emails.payment_status', [
                'nama' => $recipientName,
                'status' => $status,
                'comment' => $comment,
                'nama_conference' => $nama_conference,
                'keterangan_tambahan' => "" // Kosong untuk nonvalid
            ])->render();

            try {
                EmailApiService::send($recipientEmail, $subject, $text, $html);
                $pesertaConf->delete();
                return back()->with('success', 'Payment rejected, email sent, and data has been cleared.');
            } catch (\Exception $e) {
                Log::error("Gagal mengirim email rejection payment: " . $e->getMessage());
                return back()->with('error', 'Failed to send notification email.');
            }
        }

        // Render HTML untuk status Success
        $html = view('emails.payment_status', [
            'nama'    => $pesertaConf->peserta->nama,
            'status'  => $status,
            'comment' => $comment,
            'nama_conference' => $nama_conference,
            'keterangan_tambahan' => $keterangan_tambahan // Kirim variabel ini ke blade
        ])->render();

        try {
            EmailApiService::send($user->email, $subject, $text, $html);
            return back()->with('success', 'Payment status updated and email notification sent.');
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email payment: " . $e->getMessage());
            return back()->with('error', 'Status updated, but email failed to send.');
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
