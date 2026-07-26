@extends('layouts.main')

@section('title', 'Edit Data Roan')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Data Roan</h2>
                        <p class="text-gray-500">Ubah informasi agenda kegiatan kerja bakti.</p>
                    </div>
                    @if ($errors->any())
                        <div class="bg-red-100 p-4 mb-4 text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.roan.update', $roan->id_ro) }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Judul & Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Kegiatan</label>
                                <input type="text" name="judul" value="{{ old('judul', $roan->judul) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tgl" value="{{ old('tgl', $roan->tgl) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penanggung Jawab (PJ)</label>
                                <input type="text" name="pj" value="{{ old('pj', $roan->pj) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                        </div>

                        {{-- Lokasi & Volume --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $roan->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Volume Sampah (m³)</label>
                                <input type="number" step="0.01" name="vol_sampah"
                                    value="{{ old('vol_sampah', $roan->vol_sampah) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                            </div>
                        </div>

                        {{-- Tema --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema Kegiatan</label>
                            <input type="text" name="tema" value="{{ old('tema', $roan->tema) }}" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                            {{-- Edit Poster --}}
                            <div class="mb-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster Utama</label>
                                @if ($roan->poster && $roan->poster !== 'none')
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Poster saat ini:</p>
                                        @if (Storage::disk('public')->exists('foto_roan/' . $roan->poster))
                                            <img src="{{ asset('storage/foto_roan/' . $roan->poster) }}"
                                                class="h-32 w-full object-cover rounded-lg border dark:border-gray-700">
                                        @else
                                            <img src="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
                                                class="h-32 w-full object-cover rounded-lg border dark:border-gray-700">
                                            <p class="text-xs text-red-500 mt-1 italic">File foto fisik tidak ditemukan di
                                                storage, menggunakan gambar default.</p>
                                        @endif
                                    </div>
                                @endif
                                <input type="file" name="poster" accept="image/*"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                <p class="text-xs text-gray-400 mt-1">Unggah file baru untuk mengganti poster utama.</p>
                            </div>

                            {{-- Edit Foto Dokumentasi --}}
                            <div class="mb-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Dokumentasi Foto</label>
                                @if ($roan->foto && $roan->foto !== 'none')
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                                        <div class="flex gap-2 flex-wrap">
                                            @php
                                                $fotoList = array_filter(
                                                    explode(';', $roan->foto),
                                                    fn($f) => trim($f) !== '',
                                                );
                                            @endphp

                                            @foreach ($fotoList as $f)
                                                @php
                                                    $fileName = trim($f);
                                                    $exists = Storage::disk('public')->exists('foto_roan/' . $fileName);
                                                @endphp

                                                @if ($exists)
                                                    <img src="{{ asset('storage/foto_roan/' . $fileName) }}"
                                                        class="h-16 w-16 object-cover rounded-lg border dark:border-gray-700">
                                                @else
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/foto_roan/roan-default.jpeg') }}"
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
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                <p class="text-xs text-gray-400 mt-1">Unggah file baru jika ingin menambahkan/mengganti foto
                                    dokumentasi.</p>
                            </div>

                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500 transition">{{ old('deskripsi', $roan->deskripsi) }}</textarea>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.roan.index') }}"
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
