@extends('layouts.main')

@section('title', 'Data Sedekah Sampah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Sedekah Sampah</h2>
                            <p class="text-gray-500">Data donasi para donatur sampah tampil disini.</p>
                        </div>
                        <a href="{{ route('anggota.sampah.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Donasi
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
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-4 dark:text-gray-300">No</th>
                                    <th class="p-4 dark:text-gray-300">Penyetor</th>
                                    <th class="p-4 dark:text-gray-300">Jenis</th>
                                    <th class="p-4 dark:text-gray-300">Berat (Kg)</th>
                                    <th class="p-4 dark:text-gray-300">Nilai (Rp)</th>
                                    <th class="p-4 dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 dark:text-gray-300">Petugas</th>
                                    <th class="p-4 dark:text-gray-300">Preview</th>
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
