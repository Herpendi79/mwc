@extends('layouts.main')

@section('title', 'Data Relawan')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ openModal: false, selectedRelawan: null }">

        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Relawan</h2>
                            <p class="text-gray-500">Daftar aksi relawan dan detail bantuan</p>
                        </div>
                        <a href="{{ route('admin.relawan.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Data
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

                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Lokasi</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Korban</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Bantuan</th>
                                    <th class="p-4 text-center">Peserta</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($relawans as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->lokasi }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->jml_korban }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->bantuan }}</td>
                                        <td class="p-4 text-center">
                                            <button @click="selectedRelawan = {{ $item->id_re }}; openModal = true"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                                                {{ $item->peserta_count ?? 0 }} Peserta
                                            </button>
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.relawan.edit', $item->id_re) }}"
                                                    class="text-yellow-600 hover:text-yellow-800"><i
                                                        class="ri-edit-line text-xl"></i></a>
                                                <form action="{{ route('admin.relawan.hapus', $item->id_re) }}"
                                                    method="POST" onsubmit="return confirm('Yakin hapus?')">
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
                class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-2xl shadow-xl max-h-[90vh] overflow-y-auto">
                @foreach ($relawans as $item)
                    <div x-show="selectedRelawan === {{ $item->id_re }}">
                        <h3 class="font-bold text-lg mb-4 dark:text-white border-b pb-2">Detail: {{ $item->judul }}</h3>

                        <div class="text-sm dark:text-gray-300 space-y-2 mb-6">
                            <p><strong>Koordinator:</strong> {{ $item->koordinator }}</p>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($item->tgl)->format('d/m/Y') }}</p>
                            <p><strong>Deskripsi:</strong> {{ $item->deskripsi }}</p>
                        </div>
                        <h4 class="font-bold mb-3 dark:text-white">Poster</h4>
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            @if (!empty($item->poster) && Storage::disk('public')->exists('foto_relawan/' . $item->poster))
                                <a href="{{ asset('storage/foto_relawan/' . $item->poster) }}" target="_blank">
                                    <img src="{{ asset('storage/foto_relawan/' . $item->poster) }}"
                                        class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                </a>
                            @else
                                <a href="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}" target="_blank">
                                    <img src="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                        class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                </a>
                            @endif
                        </div>
                        <h4 class="font-bold mb-3 dark:text-white">Galeri Foto</h4>
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            @if (!empty($item->foto))
                                @php
                                    $fotoList = array_filter(explode(';', $item->foto), fn($f) => trim($f) !== '');
                                @endphp

                                @if (count($fotoList) > 0)
                                    @foreach ($fotoList as $f)
                                        @php
                                            $fileName = trim($f);
                                            $exists = Storage::disk('public')->exists('foto_relawan/' . $fileName);
                                        @endphp

                                        @if ($exists)
                                            <a href="{{ asset('storage/foto_relawan/' . $fileName) }}" target="_blank">
                                                <img src="{{ asset('storage/foto_relawan/' . $fileName) }}"
                                                    class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                            </a>
                                        @else
                                            <a href="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                                target="_blank">
                                                <img src="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                                    class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                            </a>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-400 italic col-span-3">Tidak ada foto.</p>
                                @endif
                            @else
                                <p class="text-sm text-gray-400 italic col-span-3">Tidak ada foto.</p>
                            @endif
                        </div>

                        <h4 class="font-bold mb-3 dark:text-white">Daftar Peserta</h4>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4">
                            @foreach ($item->peserta as $p)
                                <div class="flex justify-between border-b dark:border-gray-700 py-2">
                                    <span class="text-sm dark:text-gray-200">{{ $p->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $p->email }}</span>
                                    <span class="text-xs text-gray-500">{{ $p->telpon }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button @click="openModal = false"
                    class="mt-6 w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl text-sm font-bold dark:text-white hover:bg-gray-200">Tutup</button>
            </div>
        </div>
    </div>
@endsection
