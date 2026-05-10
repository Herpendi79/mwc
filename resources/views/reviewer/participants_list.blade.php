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
                                <span class="dark:text-gray-300">Participants List</span>
                            </nav>
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">{{ $conference->nama_conf }}</h2>
                            <p class="text-gray-500">Managing {{ $participants->count() }} registered participants for this
                                event.</p>
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

                            <div
                                class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                                <div
                                    class="p-6 border-b border-gray-100 dark:border-zinc-800 flex flex-col md:flex-row justify-between items-md-center gap-4">
                                    <h3 class="text-lg font-bold dark:text-white text-left">Registered Participants</h3>

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
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Source</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Registration Date</th>
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
                                                    <td class="p-4">
                                                        <span
                                                            class="px-2 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $p->sumber == 'ADAKSI' ? 'bg-blue-100 text-blue-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                            {{ $p->sumber }}
                                                        </span>
                                                    </td>
                                                    <td class="p-4 text-sm dark:text-gray-300">
                                                        {{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y, H:i') }}
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
