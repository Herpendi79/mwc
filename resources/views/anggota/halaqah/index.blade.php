@extends('layouts.main')

@section('title', 'Halaqah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ search: '', openModal: false, selectedId: null }">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    {{-- Header & Aksi --}}
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Halaqah</h2>
                            <p class="text-gray-500">Daftar kegiatan halaqah dan galeri foto</p>
                        </div>
                    </div>

                    {{-- Input Pencarian --}}
                    <div class="mb-6">
                        <input type="text" x-model="search" placeholder="Cari judul, tema, atau narasumber..."
                            class="w-full px-4 py-2 border rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Tabel Data --}}
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tema</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Narsum</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Moderator</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Thumbnail</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Peserta</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-center">Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($halaqah as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50"
                                        x-show="search === '' ||
                                                '{{ strtolower(addslashes($item->judul)) }}'.includes(search.toLowerCase()) ||
                                                '{{ strtolower(addslashes($item->tema)) }}'.includes(search.toLowerCase()) ||
                                                '{{ strtolower(addslashes($item->narsum)) }}'.includes(search.toLowerCase())">

                                        <td class="p-4 dark:text-gray-300">
                                            {{ $halaqah->firstItem() ? $halaqah->firstItem() + $index : $index + 1 }}</td>
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->tema }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->narsum }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->moderator }}</td>

                                        <td class="p-4">
                                            @if (!empty($item->thumbnail))
                                                @php
                                                    $thumbExists = Storage::disk('public')->exists(
                                                        'foto_halaqah/' . $item->thumbnail,
                                                    );
                                                    $thumbUrl = $thumbExists
                                                        ? asset('storage/foto_halaqah/' . $item->thumbnail)
                                                        : asset('storage/foto_halaqah/default-halaqah-pro.jpeg');
                                                @endphp
                                                <a href="{{ $thumbUrl }}" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ $thumbUrl }}"
                                                        class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>

                                        {{-- Tombol Pemicu Modal Detail (Jumlah Peserta) --}}
                                        <td class="p-4">
                                            <button @click="selectedId = {{ $item->id }}; openModal = true"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                                                {{ $item->peserta_count ?? (isset($item->peserta) ? $item->peserta->count() : 0) }}
                                                Peserta
                                            </button>
                                        </td>

                                        {{-- Tombol Daftar / Aksi Tambah Peserta --}}
                                        <td class="p-4 text-center">
                                            @if (\Carbon\Carbon::parse($item->tanggal)->isPast())
                                                <span
                                                    class="text-xs text-red-500 font-bold bg-red-100 px-2 py-1 rounded-full">Ditutup</span>
                                            @else
                                                <button type="button"
                                                    onclick="confirmDaftar('{{ route('anggota.halaqah.daftar', $item->id) }}')"
                                                    title="Daftar"
                                                    class="text-blue-600 hover:text-blue-800 relative z-10 p-2">
                                                    <i class="ri-add-line text-xl"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- MODAL TUNGGAL (Diletakkan di luar baris tabel agar valid) --}}
                        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                            x-cloak style="display: none;">
                            <div @click.away="openModal = false"
                                class="bg-white dark:bg-gray-900 p-8 rounded-3xl w-full max-w-4xl shadow-2xl relative max-h-[90vh] overflow-y-auto text-left">

                                {{-- Tombol Tutup X --}}
                                <button @click="openModal = false"
                                    class="absolute top-4 right-4 p-2 text-gray-500 hover:text-black dark:hover:text-white transition-colors">
                                    <i class="ri-close-line text-2xl"></i>
                                </button>

                                @foreach ($halaqah as $item)
                                    <div x-show="selectedId === {{ $item->id }}" class="space-y-6"
                                        style="display: none;">
                                        <h3
                                            class="font-bold text-lg mb-4 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 pr-8">
                                            Detail: {{ $item->judul }}
                                        </h3>

                                        <div class="space-y-4 text-sm dark:text-gray-300">
                                            <div>
                                                <strong class="block text-gray-700 dark:text-gray-300">Deskripsi:</strong>
                                                <p
                                                    class="mt-1 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-gray-600 dark:text-gray-400">
                                                    {{ $item->deskripsi }}
                                                </p>
                                            </div>
                                            <div>
                                                <strong class="block text-gray-700 dark:text-gray-300">Hasil /
                                                    Ringkasan:</strong>
                                                <p
                                                    class="mt-1 bg-gray-50 dark:bg-gray-800 p-3 rounded-lg text-gray-600 dark:text-gray-400">
                                                    {{ $item->hasil }}
                                                </p>
                                            </div>
                                            <div>
                                                <p><strong>Youtube:</strong>
                                                    @if ($item->link_yt)
                                                        <a href="{{ $item->link_yt }}" target="_blank"
                                                            class="text-blue-600 underline break-all">{{ $item->link_yt }}</a>
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            {{-- Bagian Daftar Peserta Halaqah --}}
                                            <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                                <strong class="block text-gray-700 dark:text-gray-300 mb-2">Daftar
                                                    Peserta:</strong>

                                                @if (isset($item->peserta) && $item->peserta->count() > 0)
                                                    <div
                                                        class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl max-h-40 overflow-y-auto">
                                                        <ul
                                                            class="list-disc list-inside space-y-1 text-gray-600 dark:text-gray-400">
                                                            @foreach ($item->peserta as $peserta)
                                                                <li>
                                                                    {{ $peserta->name ?? ($peserta->user->name ?? 'Peserta') }}
                                                                    ({{ $peserta->telpon ?? '-' }} -
                                                                    {{ $peserta->email ?? '-' }})
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="text-gray-500 italic text-xs">Tidak ada data peserta untuk
                                                        halaqah ini.</p>
                                                @endif
                                            </div>

                                            {{-- Galeri Foto --}}
                                            <h4 class="font-bold mb-3 dark:text-white pt-2">Galeri Foto</h4>
                                            <div class="grid grid-cols-3 gap-3 mb-6">
                                                @if (!empty($item->foto))
                                                    @foreach (explode(';', $item->foto) as $f)
                                                        @php
                                                            $fileName = basename(trim($f));
                                                            $fotoExists =
                                                                !empty($fileName) &&
                                                                Storage::disk('public')->exists(
                                                                    'foto_halaqah/' . $fileName,
                                                                );
                                                            $fotoUrl = $fotoExists
                                                                ? asset('storage/foto_halaqah/' . $fileName)
                                                                : asset(
                                                                    'storage/foto_halaqah/default-halaqah-pro.jpeg',
                                                                );
                                                        @endphp
                                                        @if (!empty($fileName))
                                                            <a href="{{ $fotoUrl }}" target="_blank"
                                                                rel="noopener noreferrer">
                                                                <img src="{{ $fotoUrl }}"
                                                                    class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-80 transition-opacity">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <p class="text-gray-400 text-xs col-span-3">Tidak ada galeri foto.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $halaqah->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- SweetAlert2 untuk Konfirmasi Pendaftaran --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDaftar(url) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Saya dengan sadar dan sukarela ingin mengikuti kegiatan halaqah ini.",
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
