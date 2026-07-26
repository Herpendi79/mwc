@extends('layouts.main')

@section('title', 'Pengajian')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    {{-- Bagian Judul dan Sub Judul (Tidak Diubah) --}}
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Pengajian</h2>
                            <p class="text-gray-500">Data kajian, materi, dan dokumentasi foto</p>
                        </div>
                    </div>

                    {{-- Input Pencarian (Tambahan Baru) --}}
                    <div class="mb-6" x-data>
                        <input type="text" @input="$dispatch('search-kajian', $event.target.value)"
                            placeholder="Cari berdasarkan judul, tema, atau pemateri..."
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl dark:bg-gray-900 dark:border-gray-800 dark:text-white shadow-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- Notifikasi (Tetap) --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel Data Kajian (Menambahkan Logic Filtering) --}}
                    <div class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden"
                        x-data="{ search: '' }" @search-kajian.window="search = $event.detail">

                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Poster</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tema</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Pemateri</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Detail</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($kajian as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50" x-data="{ openModal: false }"
                                        x-show="search === '' ||
                                                '{{ strtolower(addslashes($item->judul)) }}'.includes(search.toLowerCase()) ||
                                                '{{ strtolower(addslashes($item->tema)) }}'.includes(search.toLowerCase()) ||
                                                '{{ strtolower(addslashes($item->pemateri)) }}'.includes(search.toLowerCase())">

                                        <td class="p-4 dark:text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4">
                                            @if (!empty($item->poster))
                                                <a href="{{ asset('storage/foto_kajian/' . $item->poster) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/foto_kajian/' . $item->poster) }}"
                                                        class="w-12 h-12 object-cover rounded-lg border">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->tema }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->pemateri }}</td>

                                        {{-- MODAL (Struktur Sama Persis dengan milik Anda) --}}
                                        <td class="p-4">
                                            <button @click="openModal = true" class="text-blue-600 hover:text-blue-800">
                                                <i class="ri-eye-line text-xl"></i>
                                            </button>

                                            <div x-show="openModal"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                                                x-cloak>
                                                <div @click.away="openModal = false"
                                                    class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-xl shadow-xl max-h-[90vh] overflow-y-auto">
                                                    <h3
                                                        class="font-bold text-xl mb-4 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                                                        Detail: {{ $item->judul }}</h3>
                                                    <div class="space-y-4 text-sm dark:text-gray-300">
                                                        <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                                                        <p><strong>Deskripsi:</strong><br><span
                                                                class="block bg-gray-50 dark:bg-gray-800 p-3 rounded-lg mt-1">{{ $item->deskripsi }}</span>
                                                        </p>
                                                        <p><strong>Materi:</strong>
                                                            @if ($item->materi)
                                                                <a href="{{ asset('assets/file/' . $item->materi) }}"
                                                                    target="_blank"
                                                                    class="text-blue-600 underline">Unduh</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                        <p><strong>Youtube:</strong>
                                                            @if ($item->link_yt)
                                                                <a href="{{ $item->link_yt }}" target="_blank"
                                                                    class="text-blue-600 underline">{{ $item->link_yt }}</a>
                                                            @else
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <button @click="openModal = false"
                                                        class="mt-6 w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl font-bold dark:text-white hover:bg-gray-200">Tutup</button>
                                                </div>
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
    </div>
@endsection
