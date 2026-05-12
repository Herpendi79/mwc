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
                            <h5>Managing {{ $participants->count() }} registered participants for this
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

                            <div
                                class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                                <div class="p-6 border-b border-gray-100 dark:border-zinc-800">
                                    <div class="flex flex-col lg:flex-row items-end justify-between gap-4">

                                        {{-- Grup Filter & Search (Kiri) --}}
                                        <div class="flex flex-wrap items-end gap-3 flex-grow">


                                            {{-- Filter Kategori --}}
                                            <div class="w-full md:w-64">
                                                <label
                                                    class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Category</label>
                                                <select id="filterCategory"
                                                    class="w-full p-2 rounded-xl border border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800 dark:text-white text-xs outline-none focus:ring-2 focus:ring-blue-500">
                                                    <option value="">All Categories</option>
                                                    @foreach ($stats as $catName => $group)
                                                        <option value="{{ $catName }}">{{ $catName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- Grup Tombol Export (Kanan) --}}
                                            <div class="flex items-center gap-2">
                                                {{-- Tombol Excel --}}
                                                <button onclick="exportExcel()"
                                                    class="flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-all font-bold text-xs shadow-lg shadow-emerald-500/20 whitespace-nowrap">
                                                    <i class="ri-file-excel-line"></i> Excel
                                                </button>

                                                {{-- Tombol PDF --}}
                                                <button onclick="exportPdf()"
                                                    class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-bold text-xs shadow-lg shadow-blue-500/20 whitespace-nowrap">
                                                    <i class="ri-file-pdf-line"></i> PDF
                                                </button>
                                            </div>

                                        </div>

                                        {{-- Search Input --}}
                                        <div class="w-full md:w-48">
                                            <label
                                                class="block text-[10px] font-bold text-gray-400 uppercase mb-1 ml-1">Search</label>
                                            <div class="relative">
                                                <i
                                                    class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                                <input type="text" id="searchInput" placeholder="Name..."
                                                    class="pl-9 pr-4 py-2 w-full rounded-xl border border-gray-200 dark:border-zinc-800 bg-gray-50 dark:bg-zinc-800 dark:text-white text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>

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
                                                {{-- Tambahkan class 'searchable-row' di sini --}}
                                                <tr class="searchable-row hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors"
                                                    data-name="{{ strtolower($p->nama_user) }}"
                                                    data-email="{{ strtolower($p->email_user) }}"
                                                    data-category="{{ $p->kategori->nama_ktg }}">

                                                    <td class="p-4 text-sm text-gray-500">
                                                        {{ ($participants->currentPage() - 1) * $participants->perPage() + $loop->iteration }}
                                                    </td>

                                                    <td class="p-4">
                                                        <div class="font-bold dark:text-white">{{ $p->nama_user }}</div>
                                                        <div class="text-[11px] text-gray-400">{{ $p->email_user }}</div>
                                                    </td>

                                                    <td class="p-4">
                                                        {{-- Gunakan data mapping jika ada, atau data asli jika tidak --}}
                                                        <div class="text-sm dark:text-gray-300">
                                                            <i class="ri-whatsapp-line mr-1 text-green-500"></i>
                                                            {{ $p->whatsapp_final ?? ($p->no_telp ?? '-') }}
                                                        </div>
                                                        <div class="text-[11px] text-gray-400">
                                                            <i class="ri-global-line mr-1 text-blue-500"></i>
                                                            {{ $p->negara_final ?? ($p->negara ?? '-') }}
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
        // Pastikan fungsi ini di luar DOMContentLoaded agar terbaca oleh onclick
        function exportPdf() {
            const id_conf = "{{ $conference->id_conf }}";
            const category = document.getElementById('filterCategory')?.value || '';
            const search = document.getElementById('searchInput')?.value || '';

            const params = new URLSearchParams({
                id_conf,
                category,
                search
            }).toString();
            window.location.href = `{{ route('reviewer.exportParticipantsPdf') }}?${params}`;
        }

        function exportExcel() {
            const id_conf = "{{ $conference->id_conf }}";
            const category = document.getElementById('filterCategory')?.value || '';
            const search = document.getElementById('searchInput')?.value || '';

            const params = new URLSearchParams({
                id_conf,
                category,
                search
            }).toString();
            window.location.href = `{{ route('reviewer.exportParticipantsExcel') }}?${params}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterCategory = document.getElementById('filterCategory');
            const rows = document.querySelectorAll('.searchable-row');

            function filterTable() {
                if (!rows.length) return;
                const searchTerm = searchInput.value.toLowerCase();
                const categoryTerm = filterCategory.value;

                rows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const email = row.getAttribute('data-email') || '';
                    const category = row.getAttribute('data-category') || '';

                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesCategory = categoryTerm === "" || category === categoryTerm;

                    row.style.display = (matchesSearch && matchesCategory) ? "" : "none";
                });
            }

            if (searchInput) searchInput.addEventListener('input', filterTable);
            if (filterCategory) filterCategory.addEventListener('change', filterTable);
        });
    </script>
@endsection
