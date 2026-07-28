@extends('layouts.main')

@section('title', 'Bahtsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ search: '' }">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Bahtsul Masail</h2>
                            <p class="text-gray-500">Daftar data Bahtsul Masail yang telah publish dan dari Anda.</p>
                        </div>
                    </div>

                    {{-- Input Pencarian --}}
                    <div class="mb-6 flex gap-3 items-center">
                        {{-- Input Search --}}
                        <input type="text" x-model="search" placeholder="Cari judul, masalah, atau putusan..."
                            class="flex-1 px-4 py-2 border rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">

                    </div>
                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel Data --}}
                    <div class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden"
                        x-data="{ openModal: false, selectedId: null }">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Kategori</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Pemohon</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Status</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Detail</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($bahsul as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50"
                                        x-show="search === '' ||
                        '{{ strtolower(addslashes($item->judul)) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower(addslashes($item->masalah)) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower(addslashes($item->putusan)) }}'.includes(search.toLowerCase())">

                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                        </td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->kategori }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->pemohon }}</td>

                                        {{-- Kolom Status --}}
                                        <td class="p-4">
                                            @if ($item->status === 'publish')
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-xs font-bold">
                                                    Publish
                                                </span>
                                            @elseif ($item->status === 'draft')
                                                <span
                                                    class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-xs font-bold">
                                                    Dalam Tahap Kajian
                                                </span>
                                            @else
                                                <span
                                                    class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-xs font-bold">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Tombol Pemicu Modal Detail --}}
                                        <td class="p-4">
                                            <button @click="selectedId = {{ $item->id_bs }}; openModal = true"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                                                {{ $item->peserta_count }} Peserta
                                            </button>
                                        </td>
                                        <td class="p-4 text-center">
                                            @if (\Carbon\Carbon::parse($item->tanggal)->isPast())
                                                <span
                                                    class="text-xs text-red-500 font-bold bg-red-100 px-2 py-1 rounded-full">Ditutup</span>
                                            @else
                                                <button type="button"
                                                    onclick="confirmDaftar('{{ route('anggota.bahsul.daftar', $item->id_bs) }}')"
                                                    title="Daftar" class="text-blue-600 hover:text-blue-800 relative z-10">
                                                    <i class="ri-add-line text-xl"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- MODAL TUNGGAL (Diletakkan di luar tabel, hanya merender data yang dipilih) --}}
                        {{-- MODAL TUNGGAL --}}
                        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                            x-cloak>
                            <div @click.away="openModal = false"
                                class="bg-white dark:bg-gray-900 p-8 rounded-3xl w-full max-w-4xl shadow-2xl relative max-h-[90vh] overflow-y-auto">

                                {{-- Tombol Tutup X --}}
                                <button @click="openModal = false"
                                    class="absolute top-4 right-4 p-2 text-gray-500 hover:text-black dark:hover:text-white transition-colors">
                                    <i class="ri-close-line text-2xl"></i>
                                </button>

                                @foreach ($bahsul as $item)
                                    <div x-show="selectedId === {{ $item->id_bs }}" class="space-y-6">
                                        <h3 class="font-bold text-lg mb-4 dark:text-white border-b pb-2">Detail:
                                            {{ $item->judul }}</h3>

                                        <div class="space-y-6 text-sm">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <strong class="block text-gray-700 dark:text-gray-300">Masalah:</strong>
                                                    <p
                                                        class="mt-1 text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                                        {{ $item->masalah }}</p>
                                                </div>
                                                <div>
                                                    <strong class="block text-gray-700 dark:text-gray-300">Putusan:</strong>
                                                    <p
                                                        class="mt-1 text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                                        {{ $item->putusan }}</p>
                                                </div>
                                            </div>
                                            <div>
                                                <strong class="block text-gray-700 dark:text-gray-300">Dasar Hukum:</strong>
                                                <p
                                                    class="mt-1 text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                                                    {{ $item->dasar_hukum }}</p>
                                            </div>
                                            <div>
                                                <strong class="block text-gray-700 dark:text-gray-300">Lokasi:</strong>
                                                <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $item->lokasi }}</p>
                                            </div>

                                            {{-- Bagian Daftar Peserta Bahsul --}}
                                            <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                                <strong class="block text-gray-700 dark:text-gray-300 mb-2">Daftar
                                                    Peserta:</strong>

                                                {{-- Sesuaikan nama relasi Eloquent Anda, misal: $item->peserta atau $item->bahsul_peserta --}}
                                                @if (isset($item->peserta) && $item->peserta->count() > 0)
                                                    <div
                                                        class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl max-h-40 overflow-y-auto">
                                                        <ul
                                                            class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                                                            @foreach ($item->peserta as $peserta)
                                                                <li>{{ $peserta->name ?? ($peserta->user->name ?? 'Peserta') }}
                                                                    ({{ $peserta->telpon }} - {{ $peserta->email }})
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic text-xs">Tidak ada data peserta untuk
                                                        Bahtsul Masail ini.</p>
                                                @endif
                                            </div>

                                            @if ($item->lampiran)
                                                <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                                    <a href="{{ asset('assets/file/' . $item->lampiran) }}" target="_blank"
                                                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors">
                                                        <i class="ri-file-download-line"></i> Download Lampiran
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                      <div class="mt-4">
                        {{ $bahsul->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDaftar(url) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Saya dengan sadar dan sukarela ingin mengikuti kegiatan ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Daftar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endsection
