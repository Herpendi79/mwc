@extends('layouts.main')

@section('title', 'Conference Monitoring')

@section('content')

    <style>
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

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
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        {{-- Memanggil Sidebar --}}
        @include('reviewer.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('reviewer.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <nav class="flex mb-4 text-gray-500 text-sm">
                                <a href="{{ route('reviewer.index') }}"
                                    class="hover:text-primary transition-colors">Dashboard</a>
                                <span class="mx-2">/</span>
                                <a href="{{ route('reviewer.conferences') }}"
                                    class="hover:text-primary transition-colors">Conferences</a>
                                <span class="mx-2">/</span>
                                <span class="dark:text-gray-300">Participants List of {{ $conference->nama_conf }}</span>
                            </nav>
                            <h5>Managing {{ $participants->count() }} registered participants waiting
                                payment validation for this
                                event.</h5>
                        </div>

                        <div class="force-show" data-sal="slide-up" data-sal-duration="1000">

                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach ($stats as $nama_ktg => $group)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full border dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300 shadow-sm bg-white">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-tight mr-2 text-emerald-800 dark:text-emerald-400">
                                            {{ $nama_ktg ?? 'No Category' }}
                                        </span>
                                        <span
                                            class="text-xs font-black border-l border-gray-200 dark:border-zinc-700 pl-2 text-blue-600 dark:text-blue-400">
                                            {{ $group->count() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            @if (session('success'))
                                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="bg-[#c0f037]/20 border border-[#c0f037] text-[#065039] px-4 py-3 rounded-2xl mb-6 flex justify-between items-center force-show">

                                    <div class="flex items-center gap-2">
                                        <i class="ri-checkbox-circle-fill text-xl"></i>
                                        <span class="font-bold">{{ session('success') }}</span>
                                    </div>

                                    <button @click="show = false" class="hover:opacity-70 transition-opacity">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div x-data="{ show: true }" x-show="show"
                                    x-transition:leave="transition ease-in duration-300"
                                    class="bg-[#f03737]/20 border border-[#f03737] text-[#650505] px-4 py-3 rounded-2xl mb-6 flex justify-between items-center force-show">

                                    <div class="flex items-center gap-2">
                                        <i class="ri-error-warning-fill text-xl"></i>
                                        <span class="font-bold">{{ session('error') }}</span>
                                    </div>

                                    <button @click="show = false" class="hover:opacity-70 transition-opacity">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            @endif
                            <div
                                class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                                <div
                                    class="p-6 border-b border-gray-100 dark:border-zinc-800 flex flex-col md:flex-row justify-between items-md-center gap-4">
                                    <h3 class="text-lg font-bold dark:text-white text-left">Participants Waiting Validation
                                    </h3>

                                    <div class="relative">
                                        <i
                                            class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" id="searchInput" placeholder=""
                                            class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary/50 w-full md:w-64">
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 dark:bg-zinc-800/50">
                                                <th class="p-4 text-gray-500 font-semibold text-sm">No</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Participant Details</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Contact Info</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Category</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Registration</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Payment File</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                                            @forelse($participants as $p)
                                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                                    <td class="p-4 text-sm text-gray-500">{{ $loop->iteration }}</td>
                                                    <td class="p-4">
                                                        <div class="font-bold dark:text-white">{{ $p->nama_user }}</div>
                                                        <div class="text-[11px] text-gray-400">{{ $p->email_user }}</div>
                                                    </td>
                                                    <td class="p-4">
                                                        <div class="text-sm dark:text-gray-300"><i
                                                                class="ri-whatsapp-line mr-1 text-green-500"></i>{{ $p->no_telp ?? '-' }}
                                                        </div>
                                                        <div class="text-[11px] text-gray-400"><i
                                                                class="ri-global-line mr-1 text-blue-500"></i>{{ $p->negara ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td class="p-4 text-sm dark:text-gray-300">
                                                        {{ $p->kategori->nama_ktg }}
                                                    </td>
                                                    <td class="p-4 text-sm dark:text-gray-300">
                                                        {{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y, H:i') }}
                                                    </td>
                                                    <td class="p-4 text-sm dark:text-gray-300">
                                                        @if ($p->file_bukti_tf)
                                                            <!-- Tambahkan ID unik jika perlu, tapi Alpine x-data biasanya sudah cukup -->
                                                            <div x-data="{ open: false, decision: '' }">
                                                                <button @click.prevent.stop="open = true"
                                                                    class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                                                                    <i class="ri-search-eye-line text-lg"></i>
                                                                </button>

                                                                <!-- Modal Wrapper dengan x-cloak -->
                                                                <div x-show="open" x-cloak
                                                                    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 overflow-hidden"
                                                                    style="display: none;">
                                                                    <!-- Tambahan inline style sebagai backup -->

                                                                    <!-- Overlay Backdrop -->
                                                                    <div x-show="open" x-transition.opacity.duration.300ms
                                                                        @click="open = false"
                                                                        class="fixed inset-0 bg-black/70 backdrop-blur-sm">
                                                                    </div>

                                                                    <!-- Modal Box -->
                                                                    <div x-show="open"
                                                                        x-transition:enter="transition ease-out duration-300"
                                                                        x-transition:enter-start="opacity-0 scale-95"
                                                                        x-transition:enter-end="opacity-100 scale-100"
                                                                        class="relative bg-white dark:bg-zinc-900 rounded-[2rem] shadow-2xl z-[10001] w-full max-w-6xl h-[85vh] flex flex-col border border-gray-100 dark:border-zinc-800">

                                                                        <!-- Header -->
                                                                        <div
                                                                            class="px-6 py-4 border-b border-gray-100 dark:border-zinc-800 flex justify-between items-center bg-white dark:bg-zinc-900 rounded-t-[2rem]">
                                                                            <div>
                                                                                <h3
                                                                                    class="text-lg font-bold text-gray-800 dark:text-white">
                                                                                    Preview & Verification</h3>
                                                                                <p
                                                                                    class="text-[11px] text-gray-400 font-medium uppercase">
                                                                                    {{ $p->nama_user }} •
                                                                                    {{ $p->kategori->nama_ktg }} (<span
                                                                                        class="text-xs font-semibold">
                                                                                        @if (str_contains(strtolower($p->kategori->nama_ktg), 'domestic'))
                                                                                            IDR
                                                                                            {{ number_format($p->kategori->fee, 0, ',', '.') }}
                                                                                        @else
                                                                                            USD
                                                                                            {{ number_format($p->kategori->fee, 0, '.', ',') }}
                                                                                        @endif
                                                                                        )
                                                                                    </span>
                                                                            </div>
                                                                            <!-- Close Button Header -->
                                                                            <button type="button" @click="open = false"
                                                                                class="p-2 text-gray-400 hover:text-gray-600 rounded-full transition-all">
                                                                                <i class="ri-close-line text-2xl"></i>
                                                                            </button>
                                                                        </div>

                                                                        <div
                                                                            class="flex flex-1 overflow-hidden bg-gray-50 dark:bg-zinc-950">
                                                                            <!-- SISI KIRI: FILE PREVIEW -->
                                                                            <div
                                                                                class="flex-[3] relative bg-zinc-800 flex items-center justify-center border-r dark:border-zinc-800">
                                                                                @php

                                                                                    $baseUrl = config(
                                                                                        'path.submissions_url',
                                                                                    );

                                                                                    $filePath =
                                                                                        $baseUrl . $p->file_bukti_tf;

                                                                                    $extension = strtolower(
                                                                                        pathinfo(
                                                                                            $p->file_bukti_tf,
                                                                                            PATHINFO_EXTENSION,
                                                                                        ),
                                                                                    );
                                                                                @endphp

                                                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                                                    <img src="{{ $filePath }}"
                                                                                        class="max-w-full max-h-full object-contain p-4 shadow-2xl">
                                                                                @elseif($extension === 'pdf')
                                                                                    <object
                                                                                        data="{{ $filePath }}#toolbar=0"
                                                                                        type="application/pdf"
                                                                                        class="w-full h-full">
                                                                                        <iframe
                                                                                            src="{{ $filePath }}#toolbar=0"
                                                                                            class="w-full h-full border-none"></iframe>
                                                                                    </object>
                                                                                @else
                                                                                    <div
                                                                                        class="text-white flex flex-col items-center">
                                                                                        <i
                                                                                            class="ri-file-unknow-line text-4xl mb-2"></i>
                                                                                        <p class="text-xs">No Preview
                                                                                            Available</p>
                                                                                    </div>
                                                                                @endif
                                                                            </div>

                                                                            <!-- Action Area (Kanan) -->
                                                                            <div
                                                                                class="w-[350px] p-8 bg-white dark:bg-zinc-900 flex flex-col justify-between overflow-y-auto border-l dark:border-zinc-800">
                                                                                <div>
                                                                                    <h4
                                                                                        class="text-base font-bold dark:text-white mb-2">
                                                                                        Payment Status</h4>
                                                                                    <p
                                                                                        class="text-xs text-gray-500 mb-8 italic leading-relaxed">
                                                                                        "Please check the payment proof and
                                                                                        ensure the nominal amount is
                                                                                        accurate before verifying."
                                                                                    </p>

                                                                                    <form
                                                                                        action="{{ route('reviewer.updateStatusPayment', ['id' => $p->id_global, 'sumber' => $p->sumber]) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <!-- Pastikan x-model terhubung dengan variabel decision di x-data -->
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            x-model="decision">

                                                                                        <textarea name="comment" placeholder="Add a note for the rejection reason"
                                                                                            class="w-full h-24 p-3 mb-4 text-sm rounded-lg border border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary/50 resize-none"></textarea>

                                                                                        <div class="space-y-4">
                                                                                            <!-- Tombol Valid -->
                                                                                            <button type="submit"
                                                                                                @click="decision = 'success'"
                                                                                                class="w-full py-4 flex items-center justify-center gap-2 text-sm font-extrabold text-white bg-emerald-600 hover:bg-emerald-700 rounded-2xl shadow-lg shadow-emerald-500/30 transition-all active:scale-95 border-none">
                                                                                                <i
                                                                                                    class="ri-checkbox-circle-fill text-lg"></i>
                                                                                                SET AS VALID
                                                                                            </button>

                                                                                            <!-- Tombol Non Valid (Ubah type menjadi submit) -->
                                                                                            <button type="submit"
                                                                                                @click="decision = 'nonvalid'"
                                                                                                class="w-full py-4 flex items-center justify-center gap-2 text-sm font-extrabold text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-lg shadow-blue-500/30 transition-all active:scale-95 border-none">
                                                                                                <i
                                                                                                    class="ri-close-circle-fill text-lg"></i>
                                                                                                SET AS NON VALID
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>

                                                                                <!-- Footer Actions -->
                                                                                <div
                                                                                    class="mt-8 pt-6 border-t dark:border-zinc-800 flex flex-col gap-4">
                                                                                    <a href="{{ asset(config('path.submissions_url') . $p->file_bukti_tf) }}"
                                                                                        target="_blank"
                                                                                        class="flex items-center justify-center gap-1.5 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors uppercase tracking-tight">
                                                                                        <i
                                                                                            class="ri-external-link-line"></i>
                                                                                        Open Original File
                                                                                    </a>

                                                                                    <!-- Button Close dengan warna yang lebih kontras -->
                                                                                    <button type="button"
                                                                                        @click="open = false"
                                                                                        class="w-full py-3 text-xs font-bold text-gray-500 bg-gray-100 dark:bg-zinc-800 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-zinc-700 rounded-xl transition-all border-none">
                                                                                        CLOSE PREVIEW
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-gray-400 italic text-[11px]">No file</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="p-12 text-center text-gray-400 italic">No
                                                        participants found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    {{-- Paginasi --}}
                                    <div class="mt-4 px-6">{{ $participants->links() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Memanggil Footer --}}
                    @include('reviewer.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const btnOpen = document.getElementById('sidebar-open');
            const btnClose = document.getElementById('sidebar-close');
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                window.addEventListener('click', (e) => {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
            if (btnOpen) btnOpen.addEventListener('click', toggleSidebar);
            if (btnClose) btnClose.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('.searchable-row');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                rows.forEach(row => {
                    // Mengambil teks dari kolom Nama dan Negara
                    const name = row.querySelector('.participant-name').textContent.toLowerCase();
                    const country = row.querySelector('.participant-country').textContent
                        .toLowerCase();

                    if (name.includes(searchTerm) || country.includes(searchTerm)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection
