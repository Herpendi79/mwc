@extends('layouts.main')

@section('title', 'Data Bencana')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ openModal: false, selectedBencana: null, showModal: false, actionUrl: '' }">

        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Bencana</h2>
                            <p class="text-gray-500">Daftar laporan bencana dan kebutuhan mendesak</p>
                        </div>
                        <a href="{{ route('admin.bencana.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Data
                        </a>
                    </div>

                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Pelapor</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Jenis</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Lokasi</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Korban</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Status</th>
                                    <th class="p-4 text-center">Detail</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($bencana as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->pelapor }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->jenis_bencana }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->lokasi }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->jml_korban }} Orang</td>

                                        {{-- Kolom Status dengan Badge Warna --}}
                                        <td class="p-4">
                                            @if ($item->status === 'draft')
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-400">
                                                    Menunggu Validasi
                                                </span>
                                            @elseif ($item->status === 'publish')
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400">
                                                    Publish
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-gray-400">
                                                    {{ ucfirst($item->status) }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="p-4 text-center">
                                            <button @click="selectedBencana = {{ $item->id_lb }}; openModal = true"
                                                class="text-gray-400 hover:text-blue-600"><i
                                                    class="ri-eye-line text-xl"></i></button>
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="flex justify-center items-center gap-2">
                                                {{-- Tombol Verifikasi (Hanya muncul jika status draft) --}}
                                                @if ($item->status === 'draft')
                                                    <button type="button"
                                                        @click="showModal = true; actionUrl = '{{ route('admin.bencana.verifikasi', $item->id_lb) }}'"
                                                        title="Setujui"
                                                        class="text-green-600 hover:text-green-800 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                @endif

                                                {{-- Tombol Edit --}}
                                                <a href="{{ route('admin.bencana.edit', $item->id_lb) }}"
                                                    class="text-yellow-600 hover:text-yellow-800"><i
                                                        class="ri-edit-line text-xl"></i></a>

                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('admin.bencana.hapus', $item->id_lb) }}"
                                                    method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"><i
                                                            class="ri-delete-bin-line text-xl"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        {{-- MODAL DETAIL --}}
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div @click.away="openModal = false"
                class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-lg shadow-xl max-h-[90vh] overflow-y-auto">
                @foreach ($bencana as $item)
                    <div x-show="selectedBencana === {{ $item->id_lb }}">
                        <h3
                            class="font-bold text-lg mb-4 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Detail Laporan: {{ $item->jenis_bencana }}</h3>
                        <div class="text-sm dark:text-gray-300 space-y-3 mb-6">
                            <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($item->tgl)->format('d/m/Y H:i') }}</p>
                            <p><strong>Kebutuhan:</strong> {{ $item->kebutuhan }}</p>
                            <p><strong>Deskripsi:</strong> {{ $item->deskripsi }}</p>
                        </div>
                        <h4 class="font-bold mb-2 dark:text-white">Dokumentasi</h4>
                        @foreach (explode(';', $item->foto) as $f)
                            @if (trim($f))
                                <a href="{{ asset('storage/foto_bencana/' . trim($f)) }}" target="_blank">
                                    <img src="{{ asset('storage/foto_bencana/' . trim($f)) }}"
                                        class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition mb-2">
                                </a>
                            @endif
                        @endforeach
                        <button @click="openModal = false"
                            class="mt-6 w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl text-sm font-bold dark:text-white hover:bg-gray-200">Tutup</button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- MODAL VERIFIKASI / TOLAK --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
            <div @click.away="showModal = false"
                class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-sm shadow-xl">
                <h3 class="font-bold text-lg mb-2 dark:text-white">Konfirmasi Tindakan Laporan</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Silakan pilih tindakan untuk laporan bencana ini:</p>

                <form :action="actionUrl" method="POST" class="flex flex-col gap-3">
                    @csrf
                    {{-- @method('PATCH') Dihapus karena route menggunakan POST --}}

                    {{-- Tombol Setujui/Publish --}}
                    <button type="submit" name="aksi" value="publish"
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition">
                        Setujui & Publikasikan
                    </button>

                    {{-- Tombol Tolak & Hapus --}}
                    <button type="submit" name="aksi" value="tolak" onclick="return confirm('Yakin ingin menolak dan menghapus laporan ini?')"
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition">
                        Tolak & Hapus Laporan
                    </button>

                    <button type="button" @click="showModal = false"
                        class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-bold hover:bg-gray-200">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
