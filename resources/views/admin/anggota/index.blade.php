@extends('layouts.main')

@section('title', 'Data Anggota')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Daftar Anggota</h2>
                            <p class="text-gray-500">Seluruh anggota terdaftar di dalam sistem</p>
                        </div>
                        <div class="flex justify-between items-center mb-8">

                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.anggota.tambah') }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
                                    + Tambah Anggota
                                </a>

                                <form id="filterForm" action="{{ route('admin.anggota.index') }}" method="GET"
                                    class="flex gap-2">
                                    <select name="status" onchange="this.form.submit()"
                                        class="p-2 rounded-xl border border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                        <option value="">Semua Status</option>
                                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="non aktif" {{ request('status') == 'non aktif' ? 'selected' : '' }}>
                                            Non Aktif</option>
                                        <option value="menunggu validasi"
                                            {{ request('status') == 'menunggu validasi' ? 'selected' : '' }}>Menunggu
                                            Validasi</option>
                                    </select>

                                    <input type="text" name="search" id="searchBox" placeholder="Cari nama..."
                                        value="{{ request('search') }}"
                                        class="p-2 rounded-xl border border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </form>
                            </div>
                        </div>

                    @section('scripts')
                        <script>
                            let timeout = null;
                            const searchBox = document.getElementById('searchBox');
                            const form = document.getElementById('filterForm');

                            searchBox.addEventListener('keyup', function() {
                                // Debounce: Tunggu 500ms setelah user berhenti mengetik agar tidak terlalu sering mengirim request
                                clearTimeout(timeout);
                                timeout = setTimeout(function() {
                                    form.submit();
                                }, 500);
                            });
                        </script>
                    @endsection
                </div>
                {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Notifikasi Error (Pesan Manual) --}}
                @if (session('error'))
                    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Notifikasi Error Validasi Form --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div x-data="{ showModal: false, actionUrl: '' }">
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm">
                                <tr>
                                    <th class="p-4">#</th>
                                    <th class="p-4">ID Anggota</th>
                                    <th class="p-4">Nama</th>
                                    <th class="p-4">Alamat</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Keterangan</th>
                                    <th class="p-4">Status</th>
                                    <th class="p-4">Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 dark:text-white text-sm">
                                @foreach ($anggota as $index => $item)
                                    <tr>
                                        <td class="p-4">{{ $anggota->firstItem() + $index }}</td>
                                        <td class="p-4 truncate max-w-[150px]">{{ $item->id_anggota ?? '-' }}</td>
                                        <td class="p-4 flex items-center gap-3">
                                            <img src="{{ $item->foto && Storage::disk('public')->exists('foto/' . $item->foto) ? asset('storage/foto/' . $item->foto) : asset('assets/images/default-avatar.png') }}"
                                                class="w-10 h-10 rounded-full object-cover">
                                            {{ $item->user->name ?? '-' }}
                                        </td>
                                        <td class="p-4 truncate max-w-[150px]">{{ $item->alamat ?? '-' }}</td>
                                        <td class="p-4 truncate max-w-[150px]">{{ $item->user->email ?? '-' }}</td>
                                        <td class="p-4 truncate max-w-[150px]">{{ $item->keterangan ?? '-' }}</td>
                                        <td class="p-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-bold
                                @if ($item->status == 'aktif') bg-green-100 text-green-700
                                @elseif($item->status == 'non aktif') bg-red-100 text-red-700
                                @else bg-yellow-100 text-yellow-700 @endif">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center gap-3">
                                                @if ($item->status == 'menunggu validasi')
                                                    <!-- Tombol Pemicu Modal Setuju -->
                                                    <button type="button"
                                                        @click="showModal = true; actionUrl = '{{ route('admin.anggota.verifikasi', $item->id_anggota) }}'"
                                                        title="Setujui"
                                                        class="text-green-600 hover:text-green-800 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>

                                                    <!-- Tombol Tolak (Form Terpisah) -->
                                                    <form
                                                        action="{{ route('admin.anggota.verifikasi', $item->id_anggota) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menolak dan menghapus data anggota ini?')">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="action" value="tolak">
                                                        <button type="submit" title="Tolak"
                                                            class="text-red-600 hover:text-red-800 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @elseif($item->status == 'non aktif')
                                                    <form action="{{ route('admin.anggota.verifikasi', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin mengaktifkan kembali anggota ini?')">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="action" value="aktivasi">
                                                        <button type="submit" title="Aktivasi"
                                                            class="uploader text-blue-600 hover:text-blue-800 transition">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- SATU MODAL GLOBAL DI LUAR TABEL (Tidak bentrok dengan loop) -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
                        <div @click.away="showModal = false"
                            class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-full max-w-md shadow-xl border border-gray-200 dark:border-zinc-800 space-y-4">

                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Masukkan ID Anggota</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Silakan masukkan nomor/ID anggota resmi
                                sebelum menyetujui.</p>

                            <form :action="actionUrl" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="setuju">

                                <div>
                                    <label
                                        class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 mb-1">ID
                                        Anggota</label>
                                    <input type="text" name="no_anggota" required
                                        placeholder="Contoh: MWC/2026/001"
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                                </div>

                                <div class="flex justify-end gap-3 pt-2">
                                    <button type="button" @click="showModal = false"
                                        class="px-4 py-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 font-medium transition">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold transition">
                                        Simpan & Setujui
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    {{ $anggota->appends(['search' => request('search')])->links() }}
                </div>
            </div>
            @include('admin.partials._footer')
        </main>
    </div>
</div>
@endsection
