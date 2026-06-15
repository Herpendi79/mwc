@extends('layouts.main')

@section('title', 'Available Conferences')

@section('content')
    <style>
        /* 1. Memastikan elemen tetap tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* 2. Sembunyikan berbagai kemungkinan selector button scroll up melalui CSS */
        .scroll-to-top,
        #scroll-top,
        .back-to-top,
        .scroll-top,
        .rn-backto-top,
        [id*="scroll"],
        [class*="backto"],
        [class*="scroll-top"],
        .fixed.bottom-5.right-5,
        .bg-primary.rounded-circle {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('participants.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('participants.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                @if (session('success'))
                    <div id="alert-success"
                        class="mb-6 flex items-center p-4 rounded-2xl bg-green-500/10 border border-green-500/20 text-green-500 force-show"
                        data-sal="slide-down">
                        <i class="ri-checkbox-circle-fill text-xl mr-3"></i>
                        <div class="text-sm font-bold">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="ml-auto" onclick="document.getElementById('alert-success').remove()">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div id="alert-error"
                        class="mb-6 flex items-center p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 force-show"
                        data-sal="slide-down">
                        <i class="ri-error-warning-fill text-xl mr-3"></i>
                        <div class="text-sm font-bold">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="ml-auto" onclick="document.getElementById('alert-error').remove()">
                            <i class="ri-close-line text-xl"></i>
                        </button>
                    </div>
                @endif
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Conference List</h2>
                            <p class="text-gray-500">Select a conference to participate and submit your work.</p>
                        </div>

                        <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden force-show"
                            data-sal="zoom-in" data-sal-duration="800">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr
                                            class="border-b border-gray-100 dark:border-zinc-800 bg-gray-50/50 dark:bg-zinc-800/50">
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                No</th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">
                                                Action</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Conference Name</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Event Date</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Deadline</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Category</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Publication</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Link</th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">
                                                Files</th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">
                                                Abstract Status</th>
                                            <th
                                                class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-center">
                                                Full Article Status</th>

                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Payment Note</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Certificate</th>
                                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">
                                                Attendance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                                        @forelse ($conferences as $index => $conf)
                                            @php
                                                $submissions = $userSubmissions[$conf->id_conf] ?? collect();
                                            @endphp
                                            @if ($submissions->count() > 0)
                                                @foreach ($submissions as $key => $submission)
                                                    <tr
                                                        class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">

                                                        @if ($key == 0)
                                                            <td rowspan="{{ $submissions->count() }}"
                                                                class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                                                {{ $index + 1 }}
                                                            </td>
                                                        @endif
                                                        {{-- Kolom Action --}}
                                                        @if ($key == 0)
                                                            <td rowspan="{{ $submissions->count() }}"
                                                                class="px-6 py-4 text-center">
                                                                @php
                                                                    // 1. Tentukan status deadline conference
                                                                    $isDeadlinePassed = \Carbon\Carbon::today()->greaterThan(
                                                                        \Carbon\Carbon::parse($conf->deadline_subm),
                                                                    );

                                                                    // 2. Logika expired 4 jam (Hanya untuk Domestic)
                                                                    $isPendingExpired = false;

                                                                    if (
                                                                        $submission &&
                                                                        $submission->payment == 'pending'
                                                                    ) {
                                                                        // Cek apakah kategori domestic (tidak mengandung kata 'international')
                                                                        $namaKategori = strtolower(
                                                                            $submission->kategori->nama_ktg ?? '',
                                                                        );
                                                                        $isDomestic = !str_contains(
                                                                            $namaKategori,
                                                                            'international',
                                                                        );

                                                                        if ($isDomestic) {
                                                                            // Aturan 4 jam hanya untuk Domestic
                                                                            $expiryTime = \Carbon\Carbon::parse(
                                                                                $submission->created_at,
                                                                                'Asia/Jakarta',
                                                                            )->addHours(4);
                                                                            $isPendingExpired = \Carbon\Carbon::now(
                                                                                'Asia/Jakarta',
                                                                            )->greaterThan($expiryTime);
                                                                        } else {
                                                                            // Untuk International, biasanya tidak di-auto-expire karena transfer manual butuh waktu lama
                                                                            $isPendingExpired = false;
                                                                        }
                                                                    }

                                                                    // 3. Tentukan apakah tombol submit/resubmit bisa muncul
                                                                    $canSubmit =
                                                                        !$isDeadlinePassed &&
                                                                        (!$submission || $isPendingExpired);
                                                                @endphp

                                                                @if ($canSubmit)
                                                                    @if ($isPendingExpired)
                                                                        <form
                                                                            action="{{ route('participants.resubmit', $submission->id_pc) }}"
                                                                            method="POST"
                                                                            onsubmit="return confirm('Your previous pending session has expired (Domestic 4-hour limit). Re-submit now?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit"
                                                                                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-xl text-xs shadow-sm transition-all">
                                                                                <i class="ri-refresh-line"></i> Resubmit
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <div class="flex flex-col gap-3 items-center">
                                                                            <a href="https://drive.google.com/drive/folders/1LkQVSGcNTwWkOzgzBM46hxfB0R11uCVs?usp=drive_link"
                                                                                target="_blank"
                                                                                style="background-color: #3b82f6;"
                                                                                class="inline-flex items-center justify-center hover:opacity-90 text-white font-bold py-2 px-4 rounded-xl text-[10px] shadow-sm transition-all w-full">
                                                                                <i
                                                                                    class="ri-file-download-line mr-1 text-sm"></i>
                                                                                TEMPLATE
                                                                            </a>

                                                                            <a href="{{ url('/participants/submit/' . $conf->id_conf) }}"
                                                                                class="inline-flex items-center justify-center bg-[#c0f037] hover:bg-[#b2e032] text-black font-bold py-2 px-4 rounded-xl text-[10px] shadow-sm transition-all w-full">
                                                                                <i
                                                                                    class="ri-send-plane-fill mr-1 text-sm"></i>
                                                                                SUBMIT

                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @elseif ($isDeadlinePassed)
                                                                    <button disabled
                                                                        class="bg-gray-100 text-gray-400 font-bold py-2 px-4 rounded-xl text-xs cursor-not-allowed">Closed</button>
                                                                @elseif ($submission && in_array($submission->payment, ['success', 'settlement', 'pending']))
                                                                    <div
                                                                        class="flex flex-col items-center justify-center text-center gap-3">

                                                                        @if (!empty($submission->qr_code))
                                                                            <a href="{{ config('path.qrcode_url') . $submission->qr_code }}"
                                                                                target="_blank"
                                                                                class="block group relative mx-auto">

                                                                                <img src="{{ config('path.qrcode_url') . $submission->qr_code }}"
                                                                                    alt="QR Code Pass"
                                                                                    class="w-20 h-20 rounded-xl border border-gray-200 p-1 shadow-sm transition-all group-hover:scale-105 group-hover:shadow-md">
                                                                            </a>
                                                                        @endif

                                                                        <button disabled
                                                                            class="bg-gray-100 text-gray-400 font-bold py-2 px-4 rounded-xl text-xs cursor-not-allowed dynamic-btn">
                                                                            @if ($submission->payment == 'pending')
                                                                                In Progress
                                                                            @else
                                                                                Registered
                                                                            @endif
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if ($key == 0)
                                                            <td rowspan="{{ $submissions->count() }}" class="px-6 py-4">
                                                                <div class="text-sm font-bold dark:text-white">
                                                                    {{ $conf->nama_conf }}
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($key == 0)
                                                            <td rowspan="{{ $submissions->count() }} class="px-6 py-4
                                                                text-sm text-gray-600 dark:text-gray-400">
                                                                <div class="text-xs">
                                                                    {{ \Carbon\Carbon::parse($conf->tgl_mulai)->format('d M') }}
                                                                    -
                                                                    {{ \Carbon\Carbon::parse($conf->tgl_selesai)->format('d M Y') }}
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($key == 0)
                                                            <td rowspan="{{ $submissions->count() }}"
                                                                class="px-6 py-4 text-sm text-center align-middle">

                                                                <div
                                                                    class="text-xs {{ \Carbon\Carbon::parse($conf->deadline_subm)->isPast() ? 'text-red-500' : 'text-orange-500' }}">
                                                                    {{ \Carbon\Carbon::parse($conf->deadline_subm)->format('d M Y') }}
                                                                </div>

                                                            </td>
                                                        @endif
                                                        {{-- Kolom Kategori --}}
                                                        <td class="px-6 py-4">
                                                            @if ($submission && $submission->kategori)
                                                                <div class="text-sm font-medium dark:text-gray-200">
                                                                    {{ $submission->kategori->nama_ktg }}
                                                                </div>
                                                                <div class="text-[10px] font-mono text-gray-500 mt-1">
                                                                    @if ($submission->kategori->domisili == 'international')
                                                                        <span
                                                                            class="bg-blue-500/10 text-blue-500 px-1 rounded">USD</span>
                                                                        ${{ number_format($submission->kategori->fee, 0, ',', '.') }}
                                                                    @else
                                                                        <span
                                                                            class="bg-green-500/10 text-green-500 px-1 rounded">IDR</span>
                                                                        {{ number_format($submission->kategori->fee, 0, ',', '.') }}
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <span class="text-gray-400 text-sm">-</span>
                                                            @endif
                                                        </td>

                                                        {{-- KOLOM BARU: Target Publication --}}
                                                        <td class="px-6 py-4">
                                                            @if ($submission && $submission->publikasi)
                                                                <div class="text-xs font-bold dark:text-gray-200">
                                                                    {{ $submission->publikasi->nama_pub }}</div>
                                                                <div class="text-[10px] text-blue-500 mt-1 uppercase">
                                                                    {{ $submission->publikasi->index }}</div>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>

                                                        {{-- KOLOM BARU: Template --}}
                                                        <td class="px-6 py-4 text-center">
                                                            @if ($submission && $submission->publikasi && $submission->publikasi->template)
                                                                <a href="{{ $submission->publikasi->template }}"
                                                                    target="_blank"
                                                                    class="inline-flex items-center gap-1 text-red-500 hover:text-red-700 transition-colors"
                                                                    title="Download Journal Template">
                                                                    <i class="ri-file-download-line text-xl"></i>
                                                                    <span
                                                                        class="text-[10px] font-bold uppercase">Template</span>
                                                                </a>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>

                                                        {{-- Kolom Files --}}
                                                        <td class="px-6 py-4 text-center">
                                                            @if ($submission)
                                                                <div class="flex flex-col items-center gap-2">
                                                                    <div class="flex justify-center gap-3">
                                                                        {{-- Ikon-ikon file yang sudah diupload --}}
                                                                        @if ($submission->file_kp)
                                                                            <a href="{{ asset(config('path.submissions_url') . $submission->file_kp) }}"
                                                                                target="_blank"><i
                                                                                    class="ri-file-user-line text-xl text-blue-500"></i></a>
                                                                        @endif
                                                                        @if ($submission->file_abstract)
                                                                            <a href="{{ asset(config('path.submissions_url') . $submission->file_abstract) }}"
                                                                                target="_blank"><i
                                                                                    class="ri-file-text-line text-xl text-orange-500"></i></a>
                                                                        @endif
                                                                        @if ($submission->file_artikel)
                                                                            <a href="{{ asset(config('path.submissions_url') . $submission->file_artikel) }}"
                                                                                target="_blank"><i
                                                                                    class="ri-file-pdf-line text-xl text-red-500"></i></a>
                                                                        @endif
                                                                    </div>

                                                                    {{-- LOGIKA TOMBOL UPLOAD ARTIKEL --}}
                                                                    @php
                                                                        // Gunakan null-safe operator dan trim untuk memastikan data bersih
                                                                        $absStatus = $submission->status_abstract
                                                                            ? strtolower($submission->status_abstract)
                                                                            : null;
                                                                        $artStatus = $submission->status_artikel
                                                                            ? strtolower($submission->status_artikel)
                                                                            : null;

                                                                        // Pastikan pengecekan kategori tidak case-sensitive
                                                                        $isPresenter = str_contains(
                                                                            strtolower(
                                                                                $submission->kategori->nama_ktg ?? '',
                                                                            ),
                                                                            'presenter',
                                                                        );
                                                                    @endphp

                                                                    {{-- LOGIKA TOMBOL --}}
                                                                    @if ($isPresenter)
                                                                        {{-- Jika status null ATAU string kosong ATAU 'waiting review' (opsional) ATAU 'revision required' --}}
                                                                        @if (empty($absStatus))
                                                                            <button
                                                                                onclick="openRevisionModal('{{ $submission->id_pc }}')"
                                                                                class="bg-orange-500 text-white text-[9px] px-2 py-1 rounded-md font-bold uppercase">
                                                                                {{ empty($absStatus) ? 'Submit Abstract' : 'Revision Abstract' }}
                                                                            </button>
                                                                        @elseif ($absStatus == 'accepted')
                                                                            {{-- Logika Upload Artikel --}}
                                                                            @if (empty($artStatus) || $artStatus == 'revision required')
                                                                                <button
                                                                                    onclick="openArticleModal('{{ $submission->id_pc }}')"
                                                                                    class="bg-red-500 text-white text-[9px] px-2 py-1 rounded-md font-bold uppercase hover:bg-red-600">
                                                                                    {{ $artStatus == 'revision required' ? 'Upload Revision Article' : 'Upload Full Article' }}
                                                                                </button>
                                                                            @elseif ($artStatus == 'accepted')
                                                                                <span
                                                                                    class="text-[9px] text-green-600 font-bold uppercase">
                                                                                    <i class="ri-checkbox-circle-line"></i>
                                                                                    Article
                                                                                    Accepted
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="text-[9px] text-blue-600 font-bold uppercase">Article
                                                                                    Under Review</span>
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        {{-- Jika bukan presenter (Participant), mungkin hanya muncul status --}}
                                                                        <span class="text-gray-400 text-[10px]">No Action
                                                                            Needed</span>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>

                                                        {{-- Kolom Abstract Status --}}
                                                        <td class="px-6 py-4 text-center">
                                                            @if ($submission && $submission->status_abstract)
                                                                @php $status = strtolower($submission->status_abstract); @endphp
                                                                @if ($status == 'waiting review')
                                                                    <span
                                                                        class="px-2 py-1 bg-yellow-500/10 text-yellow-600 text-[10px] font-bold rounded-full uppercase">Waiting
                                                                        Review</span>
                                                                @elseif($status == 'revision required')
                                                                    <span
                                                                        class="px-2 py-1 bg-orange-500/20 text-orange-600 border border-orange-200 text-[10px] font-bold rounded-full uppercase">Revision
                                                                        Required</span>
                                                                @elseif($status == 'accepted')
                                                                    <span
                                                                        class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-full uppercase">Accepted</span>
                                                                @endif
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>
                                                        {{-- Kolom Artikel Status --}}
                                                        <td class="px-6 py-4 text-center">
                                                            @if ($submission && $submission->status_artikel)
                                                                @php $status = strtolower($submission->status_artikel); @endphp
                                                                @if ($status == 'waiting review')
                                                                    <span
                                                                        class="px-2 py-1 bg-yellow-500/10 text-yellow-600 text-[10px] font-bold rounded-full uppercase">Waiting
                                                                        Review</span>
                                                                @elseif($status == 'revision required')
                                                                    <span
                                                                        class="px-2 py-1 bg-orange-500/20 text-orange-600 border border-orange-200 text-[10px] font-bold rounded-full uppercase">Revision
                                                                        Required</span>
                                                                @elseif($status == 'accepted')
                                                                    <span
                                                                        class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-full uppercase">Accepted</span>
                                                                @endif
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>

                                                        {{-- Kolom Payment Note --}}
                                                        <td class="px-6 py-4">
                                                            @if ($submission)
                                                                {{-- 1. Kondisi: Sudah Upload Bukti Manual (Menunggu Validasi) --}}
                                                                @if ($submission->file_bukti_tf != null && $submission->payment == 'pending')
                                                                    <div class="flex flex-col gap-2">
                                                                        <a href="{{ asset(config('path.submissions_url') . $submission->file_bukti_tf) }}"
                                                                            target="_blank"
                                                                            class="inline-flex items-center text-[10px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                                                            <i class="ri-file-search-line mr-1"></i> View
                                                                            Receipt
                                                                        </a>
                                                                        <div
                                                                            class="text-[10px] leading-tight text-orange-600 bg-orange-100 p-2 rounded-lg border border-orange-200">
                                                                            <i class="ri-time-line mr-1"></i> Waiting for
                                                                            validation.
                                                                        </div>
                                                                    </div>

                                                                    {{-- 2. Kondisi: Belum Bayar (Tampilkan Tombol Bayar Midtrans) --}}
                                                                @elseif ($submission->payment == 'pending')
                                                                    @php
                                                                        // Ambil waktu sekarang di Jakarta
                                                                        $now = \Carbon\Carbon::now('Asia/Jakarta');

                                                                        // Ambil waktu data dibuat dan set ke Jakarta (untuk memastikan perbandingan apel ke apel)
                                                                        $createdAt = \Carbon\Carbon::parse(
                                                                            $submission->created_at,
                                                                        )->setTimezone('Asia/Jakarta');

                                                                        // Tambahkan 3 jam
                                                                        $expiryTime = $createdAt->copy()->addHours(3);

                                                                        // Cek apakah sekarang sudah melewati waktu expired
                                                                        $isExpired = $now->greaterThan($expiryTime);
                                                                    @endphp

                                                                    @if ($isExpired)
                                                                        <div
                                                                            class="text-center p-2 bg-red-50 rounded-lg border border-red-100">
                                                                            <p
                                                                                class="text-[10px] text-red-600 font-medium mb-2">
                                                                                <i class="ri-error-warning-line mr-1"></i>
                                                                                Payment
                                                                                Expired
                                                                                ({{ $expiryTime->format('H:i') }} WIB)
                                                                            </p>
                                                                        </div>
                                                                    @else
                                                                        <a href="{{ url('submit/payment/' . $submission->snap) }}"
                                                                            class="bg-orange-500 ...">
                                                                            COMPLETE PAYMENT
                                                                        </a>
                                                                    @endif

                                                                    {{-- 3. Kondisi: Pembayaran Expired --}}
                                                                @elseif ($submission->payment == 'expired')
                                                                    <div
                                                                        class="text-[10px] leading-tight text-red-600 bg-red-100 p-2 rounded-lg border border-red-200">
                                                                        <i class="ri-error-warning-line mr-1"></i> Payment
                                                                        expired.
                                                                    </div>

                                                                    {{-- 4. Kondisi: Pembayaran Berhasil (Verified) --}}
                                                                @elseif (in_array($submission->payment, ['settlement', 'success', 'capture']))
                                                                    <span
                                                                        class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-full uppercase">
                                                                        <i class="ri-checkbox-circle-line mr-1"></i>
                                                                        Verified
                                                                    </span>

                                                                    {{-- 5. Kondisi Lain (Cancel/Deny) --}}
                                                                @else
                                                                    <span class="text-muted small">-</span>
                                                                @endif
                                                            @else
                                                                {{-- Jika tidak ada submission --}}
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>

                                                        </td>

                                                        {{-- Kolom Certificate --}}
                                                        <td class="text-center">
                                                            @if ($submission)
                                                                @php
                                                                    $namaKtg = strtolower(
                                                                        $submission->kategori->nama_ktg ?? '',
                                                                    );
                                                                    $isPresenter = str_contains($namaKtg, 'presenter');
                                                                    $isParticipant = str_contains(
                                                                        $namaKtg,
                                                                        'participant',
                                                                    );
                                                                    $paymentSuccess = in_array($submission->payment, [
                                                                        'success',
                                                                        'settlement',
                                                                        'capture',
                                                                    ]);

                                                                    // Cek Kehadiran
                                                                    $isHadir = !is_null($submission->kehadiran);

                                                                    // Syarat Download:
                                                                    $canDownload = false;
                                                                    if ($isHadir) {
                                                                        if (
                                                                            $isPresenter &&
                                                                            strtolower($submission->status_artikel) ==
                                                                                'accepted'
                                                                        ) {
                                                                            $canDownload = true;
                                                                        } elseif (
                                                                            $isParticipant &&
                                                                            $paymentSuccess &&
                                                                            $submission->no_sertifikat != null
                                                                        ) {
                                                                            $canDownload = true;
                                                                        }
                                                                    }

                                                                    // Cek fisik file template sertifikat
                                                                    $confName = $conf->nama_conf;
                                                                    $templatePath = config('path.sertifikat');
                                                                    $tahun = \Carbon\Carbon::parse(
                                                                        $conf->deadline_subm,
                                                                    )->format('Y');
                                                                    $roleSuffix = $isPresenter
                                                                        ? 'Presenter'
                                                                        : 'Participant';
                                                                    $fileNameBase =
                                                                        $confName . '_' . $roleSuffix . '_' . $tahun;

                                                                    $fileExist = false;
                                                                    foreach (['png', 'jpg', 'jpeg'] as $ext) {
                                                                        $fullPath =
                                                                            rtrim($templatePath, DIRECTORY_SEPARATOR) .
                                                                            DIRECTORY_SEPARATOR .
                                                                            $fileNameBase .
                                                                            '.' .
                                                                            $ext;
                                                                        if (file_exists($fullPath)) {
                                                                            $fileExist = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                @endphp

                                                                @if ($canDownload)
                                                                    @if ($fileExist)
                                                                        <a href="{{ route('participants.download', $submission->id_pc) }}"
                                                                            class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm"
                                                                            style="font-size: 10px; background-color: #0d6efd; border: none; display: inline-flex; align-items: center; gap: 4px;">
                                                                            <i class="ri-download-2-line"></i> Download
                                                                        </a>
                                                                    @else
                                                                        <span
                                                                            class="text-orange-500 small italic font-bold">Template
                                                                            Not Found</span>
                                                                    @endif
                                                                @else
                                                                    {{-- Pesan bantuan jika belum memenuhi syarat --}}
                                                                    @if (!$isHadir)
                                                                        <span
                                                                            class="text-red-500 text-[10px] italic">Attendance
                                                                            Required</span>
                                                                    @elseif ($isParticipant && $paymentSuccess && $submission->no_sertifikat == null)
                                                                        <span
                                                                            class="text-blue-500 text-[10px] italic">Generating...</span>
                                                                    @else
                                                                        <span class="text-muted small">-</span>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>
                                                        {{-- Kolom Attendance --}}
                                                        <td class="text-center">
                                                            @if ($submission && $submission->kehadiran)
                                                                @php
                                                                    // Mengambil string kehadiran (misal: "Hadir (11-06-2026 20:22:58)")
                                                                    $kehadiranRaw = $submission->kehadiran;

                                                                    // Mengambil teks di dalam kurung menggunakan Regex
                                                                    preg_match('/\((.*?)\)/', $kehadiranRaw, $matches);
                                                                    $waktu = isset($matches[1]) ? $matches[1] : '';
                                                                @endphp

                                                                <span
                                                                    class="px-2 py-1 bg-green-500/10 text-green-500 text-[10px] font-bold rounded-full">
                                                                    Present {{ $waktu ? '(' . $waktu . ')' : '' }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="px-2 py-1 bg-yellow-500/10 text-yellow-600 text-[10px] font-bold rounded-full uppercase">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">

                                                    <td class="px-6 py-4 text-sm text-gray-600">
                                                        {{ $index + 1 }}
                                                    </td>


                                                    <td class="px-6 py-4 text-center">

                                                        <div class="flex flex-col gap-3 items-center">

                                                            <a href="https://drive.google.com/drive/folders/1LkQVSGcNTwWkOzgzBM46hxfB0R11uCVs?usp=drive_link"
                                                                target="_blank"
                                                                class="inline-flex items-center justify-center bg-[#c0f037] text-black font-bold py-2 px-4 rounded-xl text-[10px]">

                                                                <i class="ri-file-download-line mr-1"></i>
                                                                TEMPLATE

                                                            </a>


                                                            <a href="{{ url('/participants/submit/' . $conf->id_conf) }}"
                                                                class="inline-flex items-center justify-center bg-[#c0f037] text-black font-bold py-2 px-4 rounded-xl text-[10px]">

                                                                <i class="ri-send-plane-fill mr-1"></i>
                                                                SUBMIT

                                                            </a>

                                                        </div>

                                                    </td>


                                                    <td class="px-6 py-4">

                                                        <div class="text-sm font-bold dark:text-white">
                                                            {{ $conf->nama_conf }}
                                                        </div>

                                                    </td>


                                                    <td class="px-6 py-4 text-sm">

                                                        {{ \Carbon\Carbon::parse($conf->tgl_mulai)->format('d M') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($conf->tgl_selesai)->format('d M Y') }}

                                                    </td>


                                                    <td class="px-6 py-4 text-center">

                                                        <div
                                                            class="text-xs 
        {{ \Carbon\Carbon::parse($conf->deadline_subm)->isPast() ? 'text-red-500' : 'text-orange-500' }}">

                                                            {{ \Carbon\Carbon::parse($conf->deadline_subm)->format('d M Y') }}

                                                        </div>

                                                    </td>


                                                    <td colspan="9"
                                                        class="px-6 py-4 text-center text-gray-400 text-sm">

                                                        Not Submitted Yet

                                                    </td>


                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                {{-- UPDATED COLSPAN: 11 --}}
                                                <td colspan="11" class="px-6 py-20 text-center text-gray-500">
                                                    No conferences available.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- Modal Revision Abstract -->
                                <div id="modal-revision" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
                                    <!-- Overlay -->
                                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>

                                    <div class="flex min-h-full items-center justify-center p-4">
                                        <div
                                            class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 p-8 shadow-2xl transition-all">
                                            <!-- Header -->
                                            <div class="mb-6 flex items-center justify-between">
                                                <h3 class="text-xl font-bold dark:text-white">Submit Revised Abstract</h3>
                                                <button onclick="closeRevisionModal()"
                                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                                    <i class="ri-close-line text-2xl"></i>
                                                </button>
                                            </div>

                                            <!-- Form -->
                                            <form id="form-revision" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="space-y-4">
                                                    <div>
                                                        <label
                                                            class="mb-2 block text-sm font-bold text-gray-700 dark:text-gray-300">New
                                                            Abstract File</label>
                                                        <input type="file" name="file_abstract" required
                                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-[#c0f037] dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                                        <p class="mt-2 text-[10px] text-gray-500">Format: PDF, DOC, or DOCX
                                                            (Max 2MB). Uploading a new file will replace your previous
                                                            abstract.</p>
                                                    </div>
                                                </div>

                                                <div class="mt-8 flex gap-3">
                                                    <button type="button" onclick="closeRevisionModal()"
                                                        class="flex-1 rounded-xl border border-gray-200 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50 dark:border-zinc-700 dark:text-gray-400 dark:hover:bg-zinc-800">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="flex-1 rounded-xl bg-[#c0f037] py-3 text-sm font-bold text-black shadow-lg shadow-[#c0f037]/20 hover:opacity-90">
                                                        <i class="ri-upload-cloud-2-line mr-1"></i> Submit Revision
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal full artikel -->
                                <div id="modal-article" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
                                    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
                                    <div class="flex min-h-full items-center justify-center p-4">
                                        <div
                                            class="relative w-full max-w-lg transform overflow-hidden rounded-3xl bg-white dark:bg-zinc-900 p-8 shadow-2xl transition-all">
                                            <div class="mb-6 flex items-center justify-between">
                                                <h3 class="text-xl font-bold dark:text-white">Upload Full Article</h3>
                                                <button onclick="closeArticleModal()"
                                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                                    <i class="ri-close-line text-2xl"></i>
                                                </button>
                                            </div>

                                            <form id="form-article" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="space-y-4">
                                                    <div
                                                        class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl mb-4">
                                                        <p
                                                            class="text-xs text-blue-600 dark:text-blue-400 leading-relaxed">
                                                            <i class="ri-information-line mr-1"></i>
                                                            Make sure your article follows the target journal template.
                                                            Status will change to <strong>Waiting Review</strong> after
                                                            upload.
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="mb-2 block text-sm font-bold text-gray-700 dark:text-gray-300">Full
                                                            Article File (PDF/DOCX Max 2MB)</label>
                                                        <input type="file" name="file_artikel" required
                                                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition-all focus:ring-2 focus:ring-[#c0f037] dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                                    </div>
                                                </div>

                                                <div class="mt-8 flex gap-3">
                                                    <button type="button" onclick="closeArticleModal()"
                                                        class="flex-1 rounded-xl border border-gray-200 py-3 text-sm font-bold text-gray-600 hover:bg-gray-50 dark:border-zinc-700 dark:text-gray-400 dark:hover:bg-zinc-800">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="flex-1 rounded-xl bg-red-500 py-3 text-sm font-bold text-white shadow-lg shadow-red-500/20 hover:bg-red-600">
                                                        <i class="ri-upload-cloud-2-line mr-1"></i> Submit Article
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer dipanggil di dalam container agar sejajar di bawah --}}
                    @include('participants.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
    <script>
        // 1. PINDAHKAN FUNGSI MODAL KE GLOBAL SCOPE (Di luar DOMContentLoaded)
        function openRevisionModal(id_pc) {
            const modal = document.getElementById('modal-revision');
            const form = document.getElementById('form-revision');

            if (modal && form) {
                // Set Action URL secara dinamis
                form.action = `/participants/revision-abstract/${id_pc}`;

                // Tampilkan Modal
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Matikan scroll background
            }
        }

        function closeRevisionModal() {
            const modal = document.getElementById('modal-revision');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
            }
        }

        function openArticleModal(id_pc) {
            const modal = document.getElementById('modal-article');
            const form = document.getElementById('form-article');
            form.action = `/participants/upload-article/${id_pc}`;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeArticleModal() {
            const modal = document.getElementById('modal-article');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Tambahkan listener klik luar untuk modal article
        window.addEventListener('click', function(event) {
            const modalArt = document.getElementById('modal-article');
            if (event.target === modalArt) {
                closeArticleModal();
            }
        });

        // Script Penghapus Otomatis Tombol Scroll
        function removeScrollButton() {
            const selectors = [
                '.scroll-to-top', '#scroll-top', '.back-to-top', '.rn-backto-top',
                '.fixed.bottom-5.right-5', '.scroll-top'
            ];

            selectors.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.remove();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Jalankan fungsi hapus scroll button
            removeScrollButton();
            setTimeout(removeScrollButton, 1000);
            window.addEventListener('scroll', removeScrollButton);

            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const btnOpen = document.getElementById('sidebar-open');
            const btnClose = document.getElementById('sidebar-close');
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            // Toggle Profile Dropdown
            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });

                window.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            // Sidebar Logic
            function toggleSidebar() {
                if (sidebar && overlay) {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                    document.body.classList.toggle('overflow-hidden');
                }
            }

            if (btnOpen) btnOpen.addEventListener('click', toggleSidebar);
            if (btnClose) btnClose.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            // Perbaikan Logika Klik di Luar Modal
            const modalRevision = document.getElementById('modal-revision');
            window.addEventListener('click', function(event) {
                // Jika yang diklik adalah area overlay (di luar box modal)
                if (event.target === modalRevision) {
                    closeRevisionModal();
                }
            });
        });
    </script>
@endsection
