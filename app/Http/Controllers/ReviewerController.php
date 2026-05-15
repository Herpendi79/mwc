<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Publikasi;
use App\Models\Conferences;
use App\Models\PesertaConferences;
use App\Models\Scope;
use App\Models\UserAdaksi;
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
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; // Pastikan ini di-import
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

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

        // Tentukan batas waktu (4 jam yang lalu)
        $fourHoursAgo = now()->subHours(4);

        $baseQuery = MonitoringParticipant::with('kategori')
            ->where('id_conf', $id_conf)
            ->where('payment', 'pending')
            ->whereNotNull('file_bukti_tf')
            // FILTER 1: Hanya tampilkan selain anggota ADAKSI
            ->where('sumber', '!=', 'ADAKSI')
            // FILTER 2: Hanya tampilkan jika pendaftaran dilakukan dalam 4 jam terakhir
            ->where('tanggal_daftar', '>=', $fourHoursAgo);

        $participants = $baseQuery
            ->orderBy('tanggal_daftar', 'desc')
            ->paginate(10)
            ->withQueryString();

        $allParticipants = (clone $baseQuery)->get();

        // Statistik berdasarkan kategori
        $stats = $allParticipants->groupBy('kategori.nama_ktg');
        $totalCount = $allParticipants->count();

        return view('reviewer.registrant_wait_valid_list', compact(
            'conference',
            'participants',
            'stats',
            'totalCount'
        ));
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
        $baseQuery = MonitoringPresenter::with(['kategori', 'scope'])
            ->where('id_conf', $id_conf)
            ->whereHas('kategori', function ($query) {
                $query->where('nama_ktg', 'like', '%presenter%');
            });

        // 2. Ambil statistik dari klon baseQuery agar tidak mengganggu query utama
        $allPresenters = (clone $baseQuery)->get();
        $stats = $allPresenters->groupBy('kategori.nama_ktg');
        $statsSC = $allPresenters->groupBy(function ($item) {
            // Ambil nama_sc dari relasi scope, jika null beri label 'No Scope'
            return $item->scope->nama_sc ?? 'No Scope';
        });
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

        $scopes = Scope::where('id_conf', $id_conf)
            ->orderBy('nama_sc', 'asc')
            ->get();

        return view('reviewer.presenters_list', compact('conference', 'presenters', 'stats', 'totalCount', 'scopes', 'statsSC'));
    }

    public function exportPresentersPdf(Request $request)
    {
        $id_conf = $request->id_conf;

        // 1. Jalankan Query Dasar
        $query = MonitoringPresenter::with(['kategori', 'scope', 'user.peserta'])
            ->where('id_conf', $id_conf)
            ->whereHas('kategori', function ($q) {
                $q->where('nama_ktg', 'like', '%presenter%');
            });

        // 2. Filter Dinamis
        if ($request->filled('category')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_ktg', $request->category);
            });
        }

        if ($request->filled('scope')) {
            $query->whereHas('scope', function ($q) use ($request) {
                $q->where('nama_sc', $request->scope);
            });
        }

        if ($request->filled('search')) {
            $query->where('nama_user', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'abs_waiting') {
                $query->where('status_abstract', 'waiting review');
            } elseif ($status === 'abs_accepted') {
                $query->where('status_abstract', 'accepted');
            } elseif ($status === 'art_waiting') {
                $query->where('status_artikel', 'waiting review');
            } elseif ($status === 'art_accepted') {
                $query->where('status_artikel', 'accepted');
            }
        }

        $data = $query->orderBy('nama_user', 'asc')->get();

        // 3. Mapping Data WA & Negara
        $adaksiEmails = $data->where('sumber', 'ADAKSI')->pluck('email_user')->unique()->toArray();
        $adaksiData = \App\Models\UserAdaksi::whereIn('email', $adaksiEmails)->get()->keyBy('email');

        // Ambil semua data peserta sekali jalan untuk optimasi fallback
        $allPeserta = DB::table('peserta')->get();

        foreach ($data as $item) {
            if ($item->sumber === 'ADAKSI') {
                $uAdaksi = $adaksiData->get($item->email_user);
                $item->whatsapp_final = $uAdaksi ? $uAdaksi->no_hp : '-';
                $item->negara_final = 'Indonesia';
            } else {
                // Logika untuk Non-ADAKSI (Seperti Anna)
                $whatsapp = '-';
                $negara = '-';

                // Cek via Relasi Eloquent
                if ($item->user && $item->user->peserta) {
                    $p = $item->user->peserta;
                    $whatsapp = $p->no_wa ?: ($p->hp ?: ($p->no_hp ?: '-'));
                    $negara = $p->negara ?: '-';
                }

                // Fallback: Jika relasi gagal, cari manual berdasarkan user_id atau email
                if ($whatsapp === '-' || $negara === '-') {
                    // Cari berdasarkan user_id (karena di screenshot Anna id-nya 3)
                    $manual = $allPeserta->where('user_id', $item->user_id)->first();

                    // Jika user_id di view bermasalah, cari berdasarkan nama (pencocokan string)
                    if (!$manual) {
                        $manual = $allPeserta->where('nama', $item->nama_user)->first();
                    }

                    if ($manual) {
                        $whatsapp = $manual->no_wa ?: ($manual->hp ?: ($manual->no_hp ?: '-'));
                        $negara = $manual->negara ?: '-';
                    }
                }

                $item->whatsapp_final = $whatsapp;
                $item->negara_final = $negara;
            }
        }

        $conference = Conferences::findOrFail($id_conf);

        // 4. Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.presenters_report', [
            'data' => $data,
            'conference' => $conference,
            'date' => now()->format('d M Y H:i')
        ])->setPaper('a4', 'landscape');

        // Hapus baris return pluck debug jika sudah oke
        // return $data->pluck('whatsapp_final', 'nama_user');

        return $pdf->download('Presenters_Report_' . \Illuminate\Support\Str::slug($conference->nama_conf) . '.pdf');
    }
    public function exportPresentersExcel(Request $request)
    {
        $id_conf = $request->id_conf;
        $conference = Conferences::findOrFail($id_conf);

        // 1. Jalankan Query dengan Filter yang sama persis dengan PDF
        $query = MonitoringPresenter::with(['kategori', 'scope', 'user.peserta'])
            ->where('id_conf', $id_conf)
            ->whereHas('kategori', function ($q) {
                $q->where('nama_ktg', 'like', '%presenter%');
            });

        // Terapkan Filter Dinamis
        if ($request->filled('category')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_ktg', $request->category);
            });
        }
        if ($request->filled('scope')) {
            $query->whereHas('scope', function ($q) use ($request) {
                $q->where('nama_sc', $request->scope);
            });
        }
        if ($request->filled('search')) {
            $query->where('nama_user', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'abs_waiting') $query->where('status_abstract', 'waiting review');
            elseif ($status === 'abs_accepted') $query->where('status_abstract', 'accepted');
            elseif ($status === 'art_waiting') $query->where('status_artikel', 'waiting review');
            elseif ($status === 'art_accepted') $query->where('status_artikel', 'accepted');
        }

        $data = $query->orderBy('nama_user', 'asc')->get();

        // 2. Mapping Data (ADAKSI & Non-ADAKSI)
        $adaksiEmails = $data->where('sumber', 'ADAKSI')->pluck('email_user')->unique()->toArray();
        $adaksiData = UserAdaksi::whereIn('email', $adaksiEmails)->get()->keyBy('email');
        $allPeserta = DB::table('peserta')->get();

        $exportData = [];
        foreach ($data as $index => $item) {
            $whatsapp = '-';
            $negara = '-';

            if ($item->sumber === 'ADAKSI') {
                $uAdaksi = $adaksiData->get($item->email_user);
                $whatsapp = $uAdaksi ? $uAdaksi->no_hp : '-';
                $negara = 'Indonesia';
            } else {
                $manual = $allPeserta->where('user_id', $item->user_id)->first();
                if (!$manual) {
                    $manual = $allPeserta->where('nama', $item->nama_user)->first();
                }
                if ($manual) {
                    $whatsapp = $manual->no_wa ?: ($manual->hp ?: '-');
                    $negara = $manual->negara ?: '-';
                }
            }

            $exportData[] = [
                'No' => $index + 1,
                'Name' => $item->nama_user,
                'WhatsApp' => $whatsapp,
                'Email' => $item->email_user,
                'Country' => $negara,
                'Category' => $item->kategori->nama_ktg ?? '-',
                'Scope' => $item->scope->nama_sc ?? '-',
                'Abstract Status' => $item->status_abstract ?? 'Pending',
                'Article Status' => $item->status_artikel ?? 'Pending',
                'Source' => $item->sumber,
                'Registered At' => date('d/m/Y H:i', strtotime($item->created_at)),
            ];
        }

        // 3. Eksekusi Export dengan Styling (Judul & Border)
        return Excel::download(new class($exportData, $conference->nama_conf) implements FromCollection, WithHeadings, WithStyles, WithEvents {
            private $data;
            private $title;

            public function __construct($data, $title)
            {
                $this->data = collect($data);
                $this->title = $title;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    [$this->title], // Baris 1: Judul
                    ['List of Registered Presenters'], // Baris 2: Sub-judul
                    ['Export Date: ' . now()->format('d M Y H:i')], // Baris 3: Tanggal
                    [], // Baris 4: Kosong
                    ["No", "Name", "WhatsApp", "Email", "Country", "Category", "Scope", "Abstract Status", "Article Status", "Source", "Registered At"] // Baris 5: Header Tabel
                ];
            }

            public function styles(Worksheet $sheet)
            {
                // Judul besar
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');
                return [
                    1 => ['font' => ['bold' => true, 'size' => 14]],
                    5 => ['font' => ['bold' => true]], // Header Tabel
                ];
            }

            public function registerEvents(): array
            {
                return [
                    AfterSheet::class => function (AfterSheet $event) {
                        $lastRow = count($this->data) + 5; // +5 karena ada baris judul
                        $range = 'A5:K' . $lastRow;

                        // Set Border Hitam Tipis
                        $event->sheet->getStyle($range)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => Border::BORDER_THIN,
                                    'color' => ['rgb' => '000000'],
                                ],
                            ],
                        ]);

                        // Auto size kolom
                        foreach (range('A', 'K') as $col) {
                            $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                        }
                    },
                ];
            }
        }, 'Presenters_Report.xlsx');
    }

    public function exportParticipantsPdf(Request $request)
    {
        $id_conf = $request->id_conf;
        $conference = Conferences::findOrFail($id_conf);

        // 1. Jalankan Query Dasar (Sama persis dengan participantsList Anda)
        $query = MonitoringParticipant::with(['kategori', 'user.peserta'])
            ->where('id_conf', $id_conf)
            ->where('payment', 'success') // Filter Pembayaran Sukses
            ->whereHas('kategori', function ($q) {
                $q->where('nama_ktg', 'like', '%participant%'); // Filter hanya kategori Participant
            });

        // 2. Terapkan Filter Dinamis dari Request (Search & Dropdown)
        if ($request->filled('category')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_ktg', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where('nama_user', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('nama_user', 'asc')->get();

        // 3. Mapping Data WA & Negara (Logika Fallback agar Anna & ADAKSI Tampil)
        $adaksiEmails = $data->where('sumber', 'ADAKSI')->pluck('email_user')->unique()->toArray();
        $adaksiData = \App\Models\UserAdaksi::whereIn('email', $adaksiEmails)->get()->keyBy('email');
        $allPeserta = DB::table('peserta')->get();

        foreach ($data as $item) {
            if ($item->sumber === 'ADAKSI') {
                $uAdaksi = $adaksiData->get($item->email_user);
                $item->whatsapp_final = $uAdaksi ? $uAdaksi->no_hp : '-';
                $item->negara_final = 'Indonesia';
            } else {
                // Logika Fallback Non-ADAKSI
                $manual = $allPeserta->where('user_id', $item->user_id)->first();
                if (!$manual) {
                    $manual = $allPeserta->where('nama', $item->nama_user)->first();
                }

                if ($manual) {
                    $item->whatsapp_final = $manual->no_wa ?: ($manual->hp ?: '-');
                    $item->negara_final = $manual->negara ?: '-';
                } else {
                    $item->whatsapp_final = '-';
                    $item->negara_final = '-';
                }
            }
        }

        // 4. Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.participants_report', [
            'data' => $data,
            'conference' => $conference,
            'date' => now()->format('d M Y H:i') // Variabel date dikirim ke sini
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Participants_Report_' . \Illuminate\Support\Str::slug($conference->nama_conf) . '.pdf');
    }

    public function exportParticipantsExcel(Request $request)
    {
        $id_conf = $request->id_conf;
        $conference = Conferences::findOrFail($id_conf);

        // 1. Base Query (Sesuai dengan view participantsList)
        $query = MonitoringParticipant::with(['kategori', 'user.peserta'])
            ->where('id_conf', $id_conf)
            ->where('payment', 'success')
            ->whereHas('kategori', function ($q) {
                $q->where('nama_ktg', 'like', '%participant%');
            });

        // 2. Filter Dinamis
        if ($request->filled('category')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_ktg', $request->category);
            });
        }

        if ($request->filled('search')) {
            $query->where('nama_user', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('nama_user', 'asc')->get();

        // 3. Mapping Data (ADAKSI & Non-ADAKSI)
        $adaksiEmails = $data->where('sumber', 'ADAKSI')->pluck('email_user')->unique()->toArray();
        $adaksiData = UserAdaksi::whereIn('email', $adaksiEmails)->get()->keyBy('email');
        $allPeserta = DB::table('peserta')->get();

        $exportData = [];
        foreach ($data as $index => $item) {
            $whatsapp = '-';
            $negara = '-';

            if ($item->sumber === 'ADAKSI') {
                $uAdaksi = $adaksiData->get($item->email_user);
                $whatsapp = $uAdaksi ? $uAdaksi->no_hp : '-';
                $negara = 'Indonesia';
            } else {
                $manual = $allPeserta->where('user_id', $item->user_id)->first();
                if (!$manual) {
                    $manual = $allPeserta->where('nama', $item->nama_user)->first();
                }
                if ($manual) {
                    $whatsapp = $manual->no_wa ?: ($manual->hp ?: '-');
                    $negara = $manual->negara ?: '-';
                }
            }

            $exportData[] = [
                'No' => $index + 1,
                'Name' => $item->nama_user,
                'WhatsApp' => $whatsapp,
                'Email' => $item->email_user,
                'Country' => $negara,
                'Category' => $item->kategori->nama_ktg ?? '-',
                'Source' => $item->sumber,
                'Registered At' => date('d/m/Y H:i', strtotime($item->created_at)),
            ];
        }

        // 4. Return Excel::download (Perhatikan penutup kurung dan titik koma)
        return \Maatwebsite\Excel\Facades\Excel::download(new class($exportData, $conference->nama_conf) implements
            \Maatwebsite\Excel\Concerns\FromCollection,
            \Maatwebsite\Excel\Concerns\WithHeadings,
            \Maatwebsite\Excel\Concerns\WithStyles,
            \Maatwebsite\Excel\Concerns\WithEvents {

            private $data;
            private $title;

            public function __construct($data, $title)
            {
                $this->data = collect($data);
                $this->title = $title;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    [$this->title],
                    ['Participant List Report (Payment Success)'],
                    ['Export Date: ' . now()->format('d M Y H:i')],
                    [],
                    ["No", "Name", "WhatsApp", "Email", "Country", "Category", "Source", "Registered At"]
                ];
            }

            public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
            {
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                return [
                    1 => ['font' => ['bold' => true, 'size' => 14]],
                    5 => ['font' => ['bold' => true]],
                ];
            }

            public function registerEvents(): array
            {
                return [
                    \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                        $lastRow = count($this->data) + 5;
                        $event->sheet->getStyle('A5:H' . $lastRow)->applyFromArray([
                            'borders' => [
                                'allBorders' => [
                                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['rgb' => '000000']
                                ]
                            ]
                        ]);
                        foreach (range('A', 'H') as $col) {
                            $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                        }
                    },
                ];
            } // Tutup fungsi registerEvents
        }, 'Participants_List.xlsx'); // Tutup Excel::download
    } // Tutup method exportParticipantsExcel


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

            // Tentukan batas waktu 4 jam yang lalu
            $fourHoursAgo = now()->subHours(4);

            $conf->antrean_review = MonitoringParticipant::where('id_conf', $conf->id_conf)
                ->where('payment', 'pending')
                ->whereNotNull('file_bukti_tf')
                // FILTER 1: Selain anggota ADAKSI
                ->where('sumber', '!=', 'ADAKSI')
                // FILTER 2: Hanya yang mendaftar dalam rentang 4 jam terakhir
                ->where('tanggal_daftar', '>=', $fourHoursAgo)
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
        // Validasi Dasar
        $request->validate([
            'status' => 'required|in:accepted,revision',
            'id_sc'  => 'required_if:status,accepted|exists:scope,id_sc',
            'comment' => 'required_if:status,revision',
        ]);

        if ($sumber === 'ADAKSI') {
            $presenter = \App\Models\PesertaConferencesAdaksi::with(['user.anggota', 'kategori.conference'])
                ->where('id_pca', $id)
                ->firstOrFail();
            $user = $presenter->user;
            $nama_peserta = $user->anggota->nama_anggota ?? 'Participant';
        } else {
            $presenter = PesertaConferences::with(['user.peserta', 'kategori.conference'])
                ->where('id_pc', $id)
                ->firstOrFail();
            $user = $presenter->user;
            $nama_peserta = $user->peserta->nama ?? ($user->name ?? 'Participant');
        }

        if (!$user || !$user->email) {
            return back()->with('error', 'User email not found.');
        }

        $status = $request->input('status');
        $comment = $request->input('comment');
        $id_sc = $request->input('id_sc'); // Ambil id_sc dari input
        $nama_conference = $presenter->kategori->conference->nama_conf;

        DB::beginTransaction();
        try {
            if ($status === 'revision') {
                // Logika Hapus File
                if ($presenter->file_abstract) {
                    $path = rtrim(config('path.submissions'), '/') . '/' . $presenter->file_abstract;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                $presenter->update([
                    'status_abstract' => 'revision required',
                    'file_abstract'   => null,
                    'keterangan'      => $comment,
                    'id_sc'           => null, // Reset scope jika revisi
                ]);

                $subject = "Revision Required: Abstract - " . $nama_conference;
                $text = "Dear {$nama_peserta}, your abstract requires revision. Feedback: {$comment}";
            } else {
                // Logika Accepted + Simpan Scope
                $presenter->update([
                    'status_abstract' => 'accepted',
                    'id_sc'           => $id_sc, // Simpan ID Scope ke tabel (PC atau PCA)
                ]);

                $subject = "Accepted: Abstract - " . $nama_conference;
                $text = "Congratulations {$nama_peserta}, your abstract has been accepted.";
            }

            // Kirim Email Queue
            $html = view('emails.review_abstract', [
                'nama'    => $nama_peserta,
                'status'  => $status,
                'comment' => $comment,
                'nama_conference' => $nama_conference
            ])->render();

            EmailApiService::send($user->email, $subject, $text, $html);

            /*SendSubmissionEmail::dispatch([
                'to'      => $user->email,
                'subject' => $subject,
                'text'    => $text,
                'html'    => $html,
            ])->onQueue('conference'); */

            DB::commit();
            return back()->with('success', 'Decision submitted and Scope assigned successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Gagal update status review: " . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
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
            // PERBAIKAN: Gunakan relasi 'user.peserta' karena PC langsung punya user_id
            $presenter = \App\Models\PesertaConferences::with(['user.peserta', 'kategori.conference'])
                ->where('id_pc', $id)
                ->firstOrFail();

            // Langsung ambil dari relasi user
            $user = $presenter->user;

            // Ambil nama dari profil peserta, jika tidak ada gunakan nama di tabel user
            $nama_peserta = $user->peserta->nama ?? ($user->name ?? 'Participant');
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
                    // Gunakan separator path yang aman
                    $path = rtrim(config('path.submissions'), '/') . '/' . $presenter->file_artikel;
                    if (\Illuminate\Support\Facades\File::exists($path)) {
                        \Illuminate\Support\Facades\File::delete($path);
                    }
                }

                // Update Database (Set ke 'revision required' agar sinkron dengan logika tombol di Blade)
                $presenter->update([
                    'status_artikel' => 'revision required',
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

            EmailApiService::send($user->email, $subject, $text, $html);


            // 4. Kirim ke Queue (Jalur Conference)
            /*SendSubmissionEmail::dispatch([
                'to'      => $user->email,
                'subject' => $subject,
                'text'    => $text,
                'html'    => $html,
            ])->onQueue('conference'); */

            DB::commit();
            Log::info("Email notifikasi review ({$status}) berhasil dikirim ke: " . $user->email);

            return back()->with('success', 'Full Paper decision submitted.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Gagal update status artikel: " . $e->getMessage());
            return back()->with('error', 'An error occurred while processing the decision.');
        }
    }

    public function updateStatusPayment(Request $request, $id)
    {
        // 1. Load data dengan relasi baru: user.peserta
        $pesertaConf = PesertaConferences::with(['user.peserta', 'kategori.conference'])->findOrFail($id);

        $status = $request->input('status');
        $comment = $request->input('comment');

        // Perbaikan pengambilan user dan nama
        $user = $pesertaConf->user;
        $nama_peserta = $user->peserta->nama ?? ($user->name ?? 'Participant');

        $nama_conference = $pesertaConf->kategori->conference->nama_conf;
        $nama_kategori = strtolower($pesertaConf->kategori->nama_ktg ?? '');

        $keterangan_tambahan = "";
        $recipientEmail = $user->email;

        // 2. Mulai Transaksi
        DB::beginTransaction();
        try {
            if ($status === 'success') {
                // Logika Penomoran Sertifikat
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

                // Tentukan status selanjutnya berdasarkan kategori
                if (str_contains($nama_kategori, 'presenter')) {
                    $updateData['status_abstract'] = 'waiting review';
                    $keterangan_tambahan = "The next process is the review of your abstract by our team.";
                } else {
                    $keterangan_tambahan = "Congratulations, your payment is valid. See you on the conference day! You can download your certificate after the conference ends.";
                }

                $pesertaConf->update($updateData);

                $subject = "Payment Verified: " . $nama_conference;
                $text = "Dear {$nama_peserta}, your payment has been successfully verified. {$keterangan_tambahan}";
            } else if ($status === 'nonvalid') {
                // Hapus file bukti transfer jika ada
                if ($pesertaConf->file_bukti_tf) {
                    $filePath = rtrim(config('path.submissions'), '/') . '/' . $pesertaConf->file_bukti_tf;
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                    }
                }

                $subject = "Payment Rejected: " . $nama_conference;
                $text = "Dear {$nama_peserta}, your payment proof was rejected. Reason: {$comment}.";

                // Hapus pendaftaran jika data dianggap tidak valid (opsional, tergantung kebijakan Anda)
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
            Log::error("Gagal update status payment untuk User ID {$user->id}: " . $e->getMessage());
            return back()->with('error', 'Failed to process payment update: ' . $e->getMessage());
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
