@extends('layouts.main')

@section('title', 'Data Infaq Mangrove')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Data Infaq Mangrove</h2>
                            <p class="text-gray-500">Berikut data para donatur infaq mangrove.</p>
                        </div>
                        <a href="{{ route('anggota.mangrove.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Infaq
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
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Donatur</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Infaq</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Pohon</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Pembayaran</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-left">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-center">Sertifikat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($mangroves as $item)
                                    <tr class="dark:text-gray-400">
                                        <td class="p-4 dark:text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="p-4">
                                            <div class="font-bold">{{ $item->donatur }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->email }}</div>
                                        </td>
                                        <td class="p-4">Rp {{ number_format($item->jumlah_infaq, 0, ',', '.') }}</td>
                                        <td class="p-4">{{ $item->jumlah_pohon }}</td>
                                        <td class="p-4 uppercase">{{ $item->pembayaran }}</td>
                                        <td class="p-4">{{ $item->tanggal->format('d M Y') }}</td>
                                        <td class="p-4 align-middle text-center">
                                            @if (auth()->check() && $item->email === auth()->user()->email)
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('anggota.mangrove.download_Sertfikat', $item->id) }}"
                                                        target="_blank" class="text-blue-600 hover:text-blue-800">
                                                        <i class="ri-download-line text-xl"></i>
                                                    </a>
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $mangroves->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
