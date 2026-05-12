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
                                <div class="p-6 border-b border-gray-100 dark:border-zinc-800" style="background: #f8fafc;">
                                    {{-- Container Utama dengan Grid --}}
                                    <div
                                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; align-items: end;">
                                        {{-- Card Search --}}
                                        <div
                                            style="background: white; padding: 12px; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; margin-left: 4px;">
                                                Search Participant
                                            </label>
                                            <div style="position: relative;">
                                                <i class="ri-search-line"
                                                    style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                                                <input type="text" id="searchInput" placeholder="Search by name..."
                                                    style="width: 100%; padding: 10px; padding-left: 36px; font-size: 12px; border: 1px solid #cbd5e1; border-radius: 10px; background: #f1f5f9; color: #334155; outline: none;">
                                            </div>
                                        </div>
                                        {{-- Card Filter Category --}}
                                        <div
                                            style="background: white; padding: 12px; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 6px; margin-left: 4px;">
                                                Category
                                            </label>
                                            <select id="filterCategory"
                                                style="width: 100%; padding: 10px; font-size: 12px; border: 1px solid #cbd5e1; border-radius: 10px; background: #f1f5f9; color: #334155; outline: none;">
                                                <option value="">All Categories</option>
                                                @foreach ($stats as $catName => $group)
                                                    <option value="{{ $catName }}">{{ $catName }}</option>
                                                @endforeach
                                            </select>
                                        </div>



                                        {{-- Card Export Buttons --}}
                                        <div
                                            style="background: white; padding: 12px; border-radius: 14px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; gap: 8px; justify-content: center;">
                                            {{-- Tombol Excel --}}
                                            <button onclick="exportExcel()"
                                                style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #10b981; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 12px; cursor: pointer; transition: background 0.2s;">
                                                <i class="ri-file-excel-line"></i> Excel
                                            </button>

                                            {{-- Tombol PDF --}}
                                            <button onclick="exportPdf()"
                                                style="flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 10px; background: #2563eb; color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 12px; cursor: pointer; transition: background 0.2s;">
                                                <i class="ri-file-pdf-line"></i> PDF
                                            </button>
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
