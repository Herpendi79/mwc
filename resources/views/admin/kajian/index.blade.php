@extends('layouts.main')

@section('title', 'Pengajian')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Pengajian</h2>
                            <p class="text-gray-500">Kelola jadwal kajian, materi, dan dokumentasi foto</p>
                        </div>
                        <a href="{{ route('admin.kajian.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Pengajian
                        </a>
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
                    {{-- Tabel Data Kajian --}}
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Poster</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tema</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Pemateri</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Detail</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Status</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($kajian as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50" x-data="{ openModal: false }">
                                        <td class="p-4 dark:text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->tanggal->format('d/m/Y') }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        {{-- Preview Poster --}}
                                        <td class="p-4">
                                            @if (!empty($item->poster))
                                                <a href="{{ $item->poster && Storage::disk('public')->exists('foto_kajian/' . $item->poster) ? asset('storage/foto_kajian/' . $item->poster) : asset('storage/foto_kajian/kajian-default.jpeg') }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ $item->poster && Storage::disk('public')->exists('foto_kajian/' . $item->poster) ? asset('storage/foto_kajian/' . $item->poster) : asset('storage/foto_kajian/kajian-default.jpeg') }}"
                                                        class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->tema }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->pemateri }}</td>

                                        {{-- Tombol Buka Modal Detail --}}
                                        <td class="p-4">
                                            <button @click="openModal = true" class="text-blue-600 hover:text-blue-800">
                                                <i class="ri-eye-line text-xl"></i>
                                            </button>

                                            {{-- MODAL LENGKAP --}}
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
                                                                    target="_blank" class="text-blue-600 underline">Unduh
                                                                    File Materi</a>
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

                                                        <p class="font-bold">Galeri Foto:</p>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            @if ($item->foto)
                                                                @foreach (explode(';', $item->foto) as $f)
                                                                    @php $fileName = trim($f); @endphp
                                                                    @if (!empty($fileName))
                                                                        @php
                                                                            $exists = Storage::disk('public')->exists(
                                                                                'foto_kajian/' . $fileName,
                                                                            );
                                                                            $fileUrl = $exists
                                                                                ? asset(
                                                                                    'storage/foto_kajian/' . $fileName,
                                                                                )
                                                                                : asset(
                                                                                    'storage/foto_kajian/kajian-default.jpeg',
                                                                                );
                                                                        @endphp
                                                                        <a href="{{ $fileUrl }}" target="_blank"
                                                                            rel="noopener noreferrer">
                                                                            <img src="{{ $fileUrl }}"
                                                                                class="w-full h-20 object-cover rounded-lg border dark:border-gray-700 hover:opacity-80 transition-opacity">
                                                                        </a>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <button @click="openModal = false"
                                                        class="mt-6 w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl font-bold dark:text-white hover:bg-gray-200">Tutup</button>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="p-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $item->status == 'draft'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : ($item->status == 'publish'
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-blue-100 text-blue-700') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                @if ($item->status == 'draft')
                                                    <form action="{{ route('admin.kajian.updateStatus', $item->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="publish">
                                                        <button type="submit" class="text-green-600 hover:text-green-800"
                                                            title="Publish"><i class="ri-check-line text-xl"></i></button>
                                                    </form>

                                                    <a href="{{ route('admin.kajian.edit', $item->id) }}"
                                                        class="text-blue-600 hover:text-blue-800"><i
                                                            class="ri-edit-line text-xl"></i></a>

                                                    {{-- Tombol Hapus --}}
                                                    <form action="{{ route('admin.kajian.hapus', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                                            title="Hapus">
                                                            <i class="ri-delete-bin-line text-xl"></i>
                                                        </button>
                                                    </form>
                                                @elseif ($item->status == 'publish')
                                                    <a href="{{ route('admin.kajian.edit', $item->id) }}"
                                                        class="text-blue-600 hover:text-blue-800"><i
                                                            class="ri-edit-line text-xl"></i></a>
                                                    <form action="{{ route('admin.kajian.updateStatus', $item->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="arsip">
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800"
                                                            title="Arsipkan"><i
                                                                class="ri-archive-line text-xl"></i></button>
                                                    </form>
                                                @else
                                                @endif

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
