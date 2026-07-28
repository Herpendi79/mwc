@extends('layouts.main')

@section('title', 'Roan Bersih Pantai')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    {{-- Header & Aksi --}}
                    {{-- Header & Aksi --}}
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Roan Bersih Pantai</h2>
                            <p class="text-gray-500">Daftar kegiatan kerja bakti dan galeri foto</p>
                        </div>

                        <div class="flex items-center gap-4 w-full md:w-auto">
                            {{-- Live Search Input dengan Alpine.js --}}
                            <div class="relative w-full md:w-72" x-data="{ search: '{{ request('search') }}' }">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="ri-search-line text-lg"></i>
                                </span>
                                <input type="text" x-model="search"
                                    @input.debounce.500ms="window.location.href = '{{ route('admin.roan.index') }}?search=' + encodeURIComponent(search)"
                                    placeholder="Cari kegiatan, lokasi, PJ..."
                                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-sm dark:text-white focus:outline-none focus:border-blue-500 transition">
                            </div>

                            <a href="{{ route('admin.roan.tambah') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
                                + Tambah Data
                            </a>
                        </div>
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

                    {{-- Tabel Data --}}
                    {{-- Tabel Data --}}
                    <div x-data="{ openModal: false, selectedRoan: null }"
                        class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">

                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Lokasi</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Vol</th>
                                    <th class="p-4 text-center">Detil</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($roans as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->tgl)->format('d/m/Y') }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->lokasi }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->vol_sampah }} m³</td>

                                        {{-- Tombol Detail Peserta --}}
                                        <td class="p-4 text-center">
                                            <button @click="selectedRoan = {{ $item->id_ro }}; openModal = true"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                                                {{ $item->peserta_count }} Peserta
                                            </button>
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.roan.edit', $item->id_ro) }}"
                                                    class="text-yellow-600 hover:text-yellow-800"><i
                                                        class="ri-edit-line text-xl"></i></a>
                                                <form action="{{ route('admin.roan.hapus', $item->id_ro) }}" method="POST"
                                                    onsubmit="return confirm('Yakin hapus?')">
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

                        {{-- MODAL TUNGGAL (Diletakkan di luar foreach) --}}
                        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                            x-cloak>
                            <div @click.away="openModal = false"
                                class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-2xl shadow-xl max-h-[90vh] overflow-y-auto">
                                @foreach ($roans as $item)
                                    <div x-show="selectedRoan === {{ $item->id_ro }}">
                                        <h3 class="font-bold text-lg mb-4 dark:text-white border-b pb-2">Detail:
                                            {{ $item->judul }}</h3>

                                        <div class="text-sm dark:text-gray-300 space-y-2 mb-6">
                                            <p><strong>PJ:</strong> {{ $item->pj }}</p>
                                            <p><strong>Tema:</strong> {{ $item->tema }}</p>
                                            <p><strong>Deskripsi:</strong> {{ $item->deskripsi }}</p>
                                        </div>

                                        <h4 class="font-bold mb-3 dark:text-white">Poster</h4>
                                        <div class="grid grid-cols-3 gap-3 mb-6">
                                            @if (!empty($item->poster) && Storage::disk('public')->exists('foto_roan/' . $item->poster))
                                                <a href="{{ asset('storage/foto_roan/' . $item->poster) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/foto_roan/' . $item->poster) }}"
                                                        class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                                </a>
                                            @else
                                                <a href="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
                                                        class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                                </a>
                                            @endif
                                        </div>

                                        <h4 class="font-bold mb-3 dark:text-white">Galeri Foto</h4>
                                        <div class="grid grid-cols-3 gap-3 mb-6">
                                            @if (!empty($item->foto))
                                                @php
                                                    $fotoList = array_filter(
                                                        explode(';', $item->foto),
                                                        fn($f) => trim($f) !== '',
                                                    );
                                                @endphp

                                                @if (count($fotoList) > 0)
                                                    @foreach ($fotoList as $f)
                                                        @php
                                                            $fileName = trim($f);
                                                            $exists = Storage::disk('public')->exists(
                                                                'foto_roan/' . $fileName,
                                                            );
                                                        @endphp

                                                        @if ($exists)
                                                            <a href="{{ asset('storage/foto_roan/' . $fileName) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/foto_roan/' . $fileName) }}"
                                                                    class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                                            </a>
                                                        @else
                                                            <a href="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
                                                                    class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <p class="text-sm text-gray-400 italic">Tidak ada foto.</p>
                                                @endif
                                            @else
                                                <p class="text-sm text-gray-400 italic">Tidak ada foto.</p>
                                            @endif
                                        </div>

                                        <h4 class="font-bold mb-3 dark:text-white">Daftar Peserta
                                            ({{ $item->peserta_count }})</h4>
                                        <div
                                            class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 mb-6 max-h-40 overflow-y-auto">
                                            @forelse($item->peserta as $p)
                                                <div class="flex justify-between border-b dark:border-gray-700 py-2">
                                                    <span class="text-sm dark:text-gray-200">{{ $p->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $p->email }}</span>
                                                    <span class="text-xs text-gray-500">{{ $p->telpon }}</span>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-400">Tidak ada peserta.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach

                                <button @click="openModal = false"
                                    class="w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl text-sm font-bold dark:text-white hover:bg-gray-200 transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        {{ $roans->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
