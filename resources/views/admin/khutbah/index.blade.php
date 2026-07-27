@extends('layouts.main')

@section('title', 'Data Khutbah Jumat')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ openModal: false, selectedKhutbah: null }">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    {{-- Header --}}
                   <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold dark:text-white">Data Khutbah Jumat</h2>
        <p class="text-gray-500">Kelola konten khutbah mingguan</p>
    </div>

    <div class="flex items-center gap-4 w-full md:w-auto">
        {{-- Live Search Input dengan Alpine.js --}}
        <div class="relative w-full md:w-72" x-data="{ search: '{{ request('search') }}' }">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <i class="ri-search-line text-lg"></i>
            </span>
            <input type="text"
                x-model="search"
                @input.debounce.500ms="window.location.href = '{{ route('admin.khutbah.index') }}?search=' + encodeURIComponent(search)"
                placeholder="Cari judul, khatib, masjid..."
                class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl text-sm dark:text-white focus:outline-none focus:border-blue-500 transition">
        </div>

        <a href="{{ route('admin.khutbah.tambah') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
            + Tambah Data
        </a>
    </div>
</div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Khatib</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Masjid</th>
                                    <th class="p-4 text-center text-sm font-bold dark:text-gray-300">Detil</th>
                                    <th class="p-4 text-center text-sm font-bold dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($khutbahs as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        {{-- No Urut --}}
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>

                                        {{-- Tanggal --}}
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->tgl)->format('d M Y') }}
                                        </td>

                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->khatib }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->masjid }}</td>

                                        <td class="p-4 text-center">
                                            <button @click="selectedKhutbah = {{ $item->id_kj }}; openModal = true"
                                                class="text-gray-400 hover:text-blue-600"><i
                                                    class="ri-eye-line text-xl"></i></button>
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.khutbah.edit', $item->id_kj) }}"
                                                    class="text-blue-600 hover:text-blue-800"><i
                                                        class="ri-edit-line text-xl"></i></a>
                                                <form action="{{ route('admin.khutbah.hapus', $item->id_kj) }}"
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
                     <div class="mt-4">
                        {{ $khutbahs->links() }}
                    </div>
                </div>
            </main>
        </div>

        {{-- MODAL DETAIL --}}
        <div x-show="openModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
            <div @click.away="openModal = false"
                class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-4xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
                <div class="px-8 py-6 border-b dark:border-gray-800 flex-shrink-0">
                    <h3 class="font-bold text-2xl dark:text-white">Detail Khutbah</h3>
                </div>
                <div class="flex-1 overflow-y-auto px-8 py-6">
                    @foreach ($khutbahs as $item)
                        <div x-show="selectedKhutbah === {{ $item->id_kj }}">
                            <h3 class="font-bold text-2xl mb-2 dark:text-white">{{ $item->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-6 italic">{{ $item->ringkasan }}
                            </p>

                            <div class="space-y-6">
                                {{-- Poster --}}
                                @if (!empty($item->poster) && Storage::disk('public')->exists('foto_khutbah/' . $item->poster))
                                    <a href="{{ asset('storage/foto_khutbah/' . $item->poster) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_khutbah/' . $item->poster) }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/foto_khutbah/khutbah-default.jpeg') }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_khutbah/khutbah-default.jpeg') }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @endif
                                {{-- Isi --}}
                                <div
                                    class="prose dark:prose-invert max-w-none text-justify [&_blockquote]:border-l-4 [&_blockquote]:border-emerald-500 [&_blockquote]:pl-4 [&_blockquote]:italic [&_blockquote]:bg-gray-100 dark:[&_blockquote]:bg-gray-800">
                                    {!! $item->isi !!}
                                </div>

                                {{-- Lampiran --}}
                                @if (!empty($item->lampiran) && Storage::disk('public')->exists('file/' . $item->lampiran))
                                    <div
                                        class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-xl border dark:border-gray-700">
                                        <a href="{{ asset('storage/file/' . $item->lampiran) }}" target="_blank"
                                            class="text-blue-600 font-bold hover:underline">
                                            <i class="ri-download-2-line"></i> Download Lampiran
                                            ({{ strtoupper(pathinfo($item->lampiran, PATHINFO_EXTENSION)) }})
                                        </a>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 italic mt-4">Tidak ada lampiran.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-8 py-6 border-t dark:border-gray-800">
                    <button @click="openModal = false"
                        class="w-full bg-gray-100 dark:bg-gray-800 py-3 rounded-xl font-bold dark:text-white hover:bg-gray-200 transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
