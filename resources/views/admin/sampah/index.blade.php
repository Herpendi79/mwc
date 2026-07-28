@extends('layouts.main')

@section('title', 'Data Sedekah Sampah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Sedekah Sampah</h2>
                            <p class="text-gray-500">Kelola data para donatur sampah disini.</p>
                        </div>

                        <div class="flex items-center gap-4 w-full md:w-auto">
                            {{-- Live Search Input dengan Alpine.js --}}
                            <div class="relative w-full md:w-72" x-data="{ search: '{{ request('search') }}' }">
                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <i class="ri-search-line text-lg"></i>
                                </span>
                                <input type="text" x-model="search"
                                    @input.debounce.500ms="window.location.href = '{{ route('admin.sampah.index') }}?search=' + encodeURIComponent(search)"
                                    placeholder="Cari penyetor, jenis sampah, petugas..."
                                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-sm dark:text-white focus:outline-none focus:border-blue-500 transition">
                            </div>

                            <a href="{{ route('admin.sampah.tambah') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
                                + Tambah Donatur
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

                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-4 dark:text-gray-300">No</th>
                                    <th class="p-4 dark:text-gray-300">Penyetor</th>
                                    <th class="p-4 dark:text-gray-300">Jenis</th>
                                    <th class="p-4 dark:text-gray-300">Berat (Kg)</th>
                                    <th class="p-4 dark:text-gray-300">Nilai (Rp)</th>
                                    <th class="p-4 dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 dark:text-gray-300">Petugas</th>
                                    <th class="p-4 dark:text-gray-300">Keterangan</th>
                                    <th class="p-4 dark:text-gray-300">Preview</th>
                                    <th class="p-4 dark:text-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($sampahs as $index => $item)
                                    <tr class="dark:text-gray-400">
                                        {{-- No Urut (Menggunakan loop index + 1) --}}
                                        <td class="p-4">{{ $loop->iteration }}</td>
                                        <td class="p-4 font-bold">{{ $item->penyetor }}</td>
                                        <td class="p-4">{{ $item->jenis }}</td>
                                        <td class="p-4">{{ $item->berat }}</td>
                                        <td class="p-4">Rp {{ number_format($item->nilai, 0, ',', '.') }}</td>
                                        <td class="p-4">{{ \Carbon\Carbon::parse($item->tgl)->format('d M Y') }}</td>
                                        <td class="p-4">{{ $item->petugas }}</td>
                                        <td class="p-4">{{ $item->ket }}</td>

                                        {{-- Preview File (Buka di tab baru) --}}
                                        <td class="p-4">
                                            @if (!empty($item->foto))
                                                @if ($item->foto && Storage::disk('public')->exists('foto_sampah/' . $item->foto))
                                                    <a href="{{ asset('storage/foto_sampah/' . $item->foto) }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset('storage/foto_sampah/' . $item->foto) }}"
                                                            class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                                        target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                                            class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity">
                                                    </a>
                                                @endif
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.sampah.edit', $item->id_sm) }}"
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <i class="ri-edit-line text-xl"></i>
                                                </a>
                                                <form action="{{ route('admin.sampah.hapus', $item->id_sm) }}"
                                                    method="POST" onsubmit="return confirm('Yakin hapus?')">
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
                    <div class="mt-4">
                        {{ $sampahs->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
