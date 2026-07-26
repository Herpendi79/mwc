@extends('layouts.main')

@section('title', 'Edit Data Relawan')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Data Relawan</h2>
                        <p class="text-gray-500">Ubah informasi aksi relawan.</p>
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

                    <form action="{{ route('admin.relawan.update', $relawan->id_re) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Judul & Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Kegiatan</label>
                                <input type="text" name="judul" value="{{ old('judul', $relawan->judul) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tgl" value="{{ old('tgl', $relawan->tgl) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Koordinator</label>
                                <input type="text" name="koordinator"
                                    value="{{ old('koordinator', $relawan->koordinator) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        {{-- Lokasi & Korban --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $relawan->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jumlah Korban</label>
                                <input type="number" name="jml_korban"
                                    value="{{ old('jml_korban', $relawan->jml_korban) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        {{-- Bantuan (Textarea) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Bantuan</label>
                            <textarea name="bantuan" rows="3" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('bantuan', $relawan->bantuan) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                            {{-- Edit Poster Utama --}}
                            <div class="mb-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster Utama</label>
                                @if ($relawan->poster && $relawan->poster !== 'none')
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Poster saat ini:</p>
                                        @if (Storage::disk('public')->exists('foto_relawan/' . $relawan->poster))
                                            <img src="{{ asset('storage/foto_relawan/' . $relawan->poster) }}"
                                                class="h-32 w-full object-cover rounded-lg border dark:border-gray-700">
                                        @else
                                            <div class="relative">
                                                <img src="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                                    class="h-32 w-full object-cover rounded-lg border dark:border-gray-700 opacity-75">
                                                <span
                                                    class="absolute bottom-2 left-2 text-[10px] bg-red-600 text-white px-2 py-0.5 rounded">File
                                                    fisik tidak ditemukan, menggunakan gambar default</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <input type="file" name="poster" accept="image/*"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                                <p class="text-xs text-gray-400 mt-1">Unggah file baru untuk mengganti poster.</p>
                            </div>

                            {{-- Edit Dokumentasi Foto --}}
                            <div class="mb-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Dokumentasi Foto</label>
                                @if ($relawan->foto && $relawan->foto !== 'none')
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                                        <div class="flex gap-2 flex-wrap">
                                            @php
                                                $fotoList = array_filter(
                                                    explode(';', $relawan->foto),
                                                    fn($f) => trim($f) !== '',
                                                );
                                            @endphp

                                            @foreach ($fotoList as $f)
                                                @php
                                                    $fileName = trim($f);
                                                    $exists = Storage::disk('public')->exists(
                                                        'foto_relawan/' . $fileName,
                                                    );
                                                @endphp

                                                @if ($exists)
                                                    <img src="{{ asset('storage/foto_relawan/' . $fileName) }}"
                                                        class="h-16 w-16 object-cover rounded-lg border dark:border-gray-700">
                                                @else
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                                            class="h-16 w-16 object-cover rounded-lg border dark:border-gray-700 opacity-75">
                                                        <span
                                                            class="absolute bottom-0 left-0 right-0 text-[9px] text-center bg-red-600 text-white px-0.5 rounded-b-lg">Tidak
                                                            ada</span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="foto[]" multiple accept="image/*"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                                <p class="text-xs text-gray-400 mt-1">Unggah file baru jika ingin mengganti/menambah foto.
                                </p>
                            </div>

                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('deskripsi', $relawan->deskripsi) }}</textarea>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.relawan.index') }}"
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
