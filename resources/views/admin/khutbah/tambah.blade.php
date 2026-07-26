@extends('layouts.main')

@section('title', 'Tambah Data Khutbah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Data Khutbah</h2>
                        <p class="text-gray-500">Input jadwal dan materi khutbah jumat baru.</p>
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

                    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm"
                        x-data="{ modeInput: 'lengkap' }">
                        <form action="{{ route('admin.khutbah.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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

                            {{-- JUDUL / NAMA FILE (Label berubah dinamis sesuai opsi) --}}
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300"
                                    x-text="modeInput === 'lengkap' ? 'Judul Khutbah' : 'Nama File'"></label>
                                <input type="text" name="judul" value="{{ old('judul') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                            </div>

                            {{-- KONTEN TAMBAHAN HANYA MUNCUL JIKA MEMILIH "ISI LENGKAP" --}}
                            <div x-show="modeInput === 'lengkap'" x-transition>
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema</label>
                                    <input type="text" name="tema" value="{{ old('tema') }}"
                                        :required="modeInput === 'lengkap'"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                    <div>
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Khatib</label>
                                        <input type="text" name="khatib" value="{{ old('khatib') }}"
                                            :required="modeInput === 'lengkap'"
                                            class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masjid</label>
                                        <input type="text" name="masjid" value="{{ old('masjid') }}"
                                            :required="modeInput === 'lengkap'"
                                            class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                        <input type="date" name="tgl" value="{{ old('tgl', date('Y-m-d')) }}"
                                            :required="modeInput === 'lengkap'"
                                            class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                    </div>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ringkasan</label>
                                    <textarea name="ringkasan" rows="2"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">{{ old('ringkasan') }}</textarea>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Lengkap
                                        Khutbah</label>
                                    <textarea name="isi" rows="6" :required="modeInput === 'lengkap'"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">{{ old('isi') }}</textarea>
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster (Gambar)</label>
                                    <input type="file" name="poster" accept="image/*"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                </div>
                            </div>

                            {{-- LAMPIRAN FILE (Selalu Muncul di Kedua Mode) --}}
                            <div class="mb-8">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran File
                                    (PDF/Doc)</label>
                                <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                    :required="modeInput === 'file'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>

                            <div class="flex gap-4 mt-6">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                                    Simpan Data
                                </button>
                                <a href="{{ route('admin.khutbah.index') }}"
                                    class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
