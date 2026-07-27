@extends('layouts.main')

@section('title', 'Pesan Dakwah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ openModal: false, selectedDakwah: null }">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Pesan Dakwah</h2>
                            <p class="text-gray-500">Kelola konten dakwah dan tausiyah</p>
                        </div>
                        <a href="{{ route('admin.dakwah.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Data
                        </a>
                    </div>

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
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Penulis</th>
                                    <th class="p-4 text-center">Detil</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($dakwahs as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300 text-center"">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-white font-medium text-center">
                                            {{ \Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="p-4 dark:text-gray-300 text-center"">{{ $item->mubaligh }}</td>
                                        <td class="p-4 text-center">
                                            <button @click="selectedDakwah = {{ $item->id_pd }}; openModal = true"
                                                class="text-gray-400 hover:text-blue-600"><i
                                                    class="ri-eye-line text-xl"></i></button>
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">

                                                {{-- Tombol Edit & Arsip --}}
                                                <a href="{{ route('admin.dakwah.edit', $item->id_pd) }}"
                                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                                    <i class="ri-edit-line text-xl"></i>
                                                </a>
                                                <form action="{{ route('admin.dakwah.hapus', $item->id_pd) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        title="Hapus">
                                                        <i class="ri-delete-bin-line text-xl"></i>
                                                    </button>
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
        {{-- MODAL DETAIL --}}
        <div x-show="openModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>

            {{-- Container Modal --}}
            <div @click.away="openModal = false"
                class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-4xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">

                {{-- Header --}}
                <div class="px-8 py-6 border-b dark:border-gray-800 flex-shrink-0">
                    <h3 class="font-bold text-2xl dark:text-white">Detail Pesan Dakwah</h3>
                </div>

                {{-- Konten Scrollable --}}
                <div class="flex-1 overflow-y-auto px-8 py-6">
                    @foreach ($dakwahs as $item)
                        <div x-show="selectedDakwah === {{ $item->id_pd }}">
                            <p class="text-sm text-gray-500 mb-6 italic">Oleh:
                                {{ $item->mubaligh }}</p>

                            {{-- Struktur 1 Kolom (Stacking) --}}
                            <div class="space-y-8">


                                {{-- Bawah: Isi Teks --}}
                                <div class="w-full">
                                    <div
                                        class="prose dark:prose-invert max-w-none text-md dark:text-gray-300 leading-relaxed text-justify
                                         [&_blockquote]:border-l-4 [&_blockquote]:border-emerald-500 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:bg-gray-100 dark:[&_blockquote]:bg-gray-800 [&_blockquote]:py-2 [&_blockquote]:my-4">
                                        {!! $item->isi !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Footer --}}
                <div class="px-8 py-6 border-t dark:border-gray-800 flex-shrink-0">
                    <button @click="openModal = false"
                        class="w-full bg-gray-100 dark:bg-gray-800 py-3 rounded-xl font-bold dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
