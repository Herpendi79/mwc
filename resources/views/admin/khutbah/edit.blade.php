@extends('layouts.main')

@section('title', 'Edit Data Khutbah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Data Khutbah</h2>
                        <p class="text-gray-500">Ubah detail materi khutbah jumat.</p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 p-4 mb-4 text-red-700 rounded-xl">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.khutbah.update', $khutbah->id_kj) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm"
                        x-data="{ modeInput: '{{ $khutbah->tema == '-' && $khutbah->isi == '-' ? 'file' : 'lengkap' }}' }">
                        @csrf
                        @method('PUT')

                        {{-- PILIHAN OPSI MODE INPUT --}}
                        <div
                            class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700">
                            <label class="block text-sm font-bold mb-3 dark:text-gray-300">Pilih Metode Input
                                Khutbah:</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="mode_input" value="lengkap" x-model="modeInput"
                                        class="text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium dark:text-white">Isi Lengkap (Teks + Detail)</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="mode_input" value="file" x-model="modeInput"
                                        class="text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm font-medium dark:text-white">Hanya Lampiran File Saja</span>
                                </label>
                            </div>
                        </div>

                        {{-- JUDUL / NAMA FILE --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300"
                                x-text="modeInput === 'lengkap' ? 'Judul Khutbah' : 'Nama File'"></label>
                            <input type="text" name="judul" value="{{ old('judul', $khutbah->judul) }}" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                        </div>

                        {{-- KONTEN TAMBAHAN HANYA MUNCUL JIKA MEMILIH "ISI LENGKAP" --}}
                        <div x-show="modeInput === 'lengkap'" x-transition>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema</label>
                                <input type="text" name="tema"
                                    value="{{ old('tema', $khutbah->tema != '-' ? $khutbah->tema : '') }}"
                                    :required="modeInput === 'lengkap'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Khatib</label>
                                    <input type="text" name="khatib"
                                        value="{{ old('khatib', $khutbah->khatib != '-' ? $khutbah->khatib : '') }}"
                                        :required="modeInput === 'lengkap'"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masjid</label>
                                    <input type="text" name="masjid"
                                        value="{{ old('masjid', $khutbah->masjid != '-' ? $khutbah->masjid : '') }}"
                                        :required="modeInput === 'lengkap'"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                    <input type="date" name="tgl" value="{{ old('tgl', $khutbah->tgl) }}"
                                        :required="modeInput === 'lengkap'"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ringkasan</label>
                                <textarea name="ringkasan" rows="2"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">{{ old('ringkasan', $khutbah->ringkasan != '-' ? $khutbah->ringkasan : '') }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Lengkap Khutbah</label>
                                <textarea name="isi" rows="6" :required="modeInput === 'lengkap'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">{{ old('isi', $khutbah->isi != '-' ? $khutbah->isi : '') }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster Baru (Gambar)</label>
                                <input type="file" name="poster" accept="image/*"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">

                                @if ($khutbah->poster && Storage::disk('public')->exists('foto_khutbah/' . $khutbah->poster))
                                    <p class="text-xs text-green-600 mt-2 italic">File saat ini: {{ $khutbah->poster }}</p>
                                    <a href="{{ asset('storage/foto_khutbah/' . $khutbah->poster) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_khutbah/' . $khutbah->poster) }}"
                                            class="mt-2 h-20 rounded-lg object-cover border dark:border-gray-700">
                                    </a>
                                @else
                                    <p class="text-xs text-red-500 mt-2 italic">File fisik saat ini tidak ditemukan,
                                        menggunakan gambar default:</p>
                                    <a href="{{ asset('storage/foto_khutbah/khutbah-default.jpeg') }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_khutbah/khutbah-default.jpeg') }}"
                                            class="mt-2 h-20 rounded-lg object-cover border dark:border-gray-700 opacity-75">
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- LAMPIRAN FILE (Selalu Muncul di Kedua Mode) --}}
                        <div class="mb-8">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran Baru (PDF/Doc)</label>
                            <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                :required="modeInput === 'file' && !{{ $khutbah->lampiran ? 'true' : 'false' }}"
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">

                            @if ($khutbah->lampiran && Storage::disk('public')->exists('file/' . $khutbah->lampiran))
                                <a href="{{ asset('storage/file/' . $khutbah->lampiran) }}" target="_blank"
                                    class="text-blue-600 font-bold hover:underline">
                                    <p class="text-xs text-green-600 mt-2 italic">File saat ini: {{ $khutbah->lampiran }}
                                    </p>
                                </a>
                            @else
                                <p class="text-xs text-gray-400 italic mt-2">Tidak ada file lampiran.</p>
                            @endif
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.khutbah.index') }}"
                                class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection
