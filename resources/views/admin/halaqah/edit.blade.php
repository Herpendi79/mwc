@extends('layouts.main')

@section('title', 'Edit Halaqah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Data Halaqah</h2>
                        <p class="text-gray-500">Perbarui data kegiatan halaqah pada formulir berikut.</p>
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

                    <form action="{{ route('admin.halaqah.update', $halaqah->id) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Baris 1: Judul, Tanggal & Lokasi --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mb-5 md:col-span-1">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Kegiatan</label>
                                <input type="text" name="judul" value="{{ old('judul', $halaqah->judul) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal"
                                    value="{{ old('tanggal', $halaqah->tanggal ? $halaqah->tanggal->format('Y-m-d') : '') }}"
                                    required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $halaqah->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Baris 2: Tema, Narasumber, Moderator --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema</label>
                                <input type="text" name="tema" value="{{ old('tema', $halaqah->tema) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Narasumber</label>
                                <input type="text" name="narsum" value="{{ old('narsum', $halaqah->narsum) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Moderator</label>
                                <input type="text" name="moderator" value="{{ old('moderator', $halaqah->moderator) }}"
                                    required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Baris 3: Deskripsi & Hasil --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $halaqah->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Hasil Kegiatan</label>
                            <textarea name="hasil" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('hasil', $halaqah->hasil) }}</textarea>
                        </div>

                        {{-- Upload Media --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Thumbnail (Biarkan kosong
                                    jika tidak diganti)</label>
                                @if ($halaqah->thumbnail && Storage::disk('public')->exists('foto_halaqah/' . $halaqah->thumbnail))
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/foto_halaqah/' . $halaqah->thumbnail) }}"
                                            class="w-24 h-24 object-cover rounded-xl border">
                                    </div>
                                @else
                                    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 italic">
                                        Tidak Thumbnail
                                    </div>
                                @endif
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Galeri Foto (Akan mengganti
                                    semua foto lama)</label>

                                {{-- Preview Foto Lama --}}
                                @php
                                    $hasPhoto = false;
                                    if ($halaqah->foto) {
                                        foreach (explode(';', $halaqah->foto) as $f) {
                                            $fileName = trim($f);
                                            if (
                                                !empty($fileName) &&
                                                Storage::disk('public')->exists('foto_halaqah/' . $fileName)
                                            ) {
                                                $hasPhoto = true;
                                                break;
                                            }
                                        }
                                    }
                                @endphp

                                @if ($hasPhoto)
                                    <div class="grid grid-cols-4 gap-2 mb-3">
                                        @foreach (explode(';', $halaqah->foto) as $f)
                                            @php $fileName = trim($f); @endphp
                                            @if (!empty($fileName) && Storage::disk('public')->exists('foto_halaqah/' . $fileName))
                                                <img src="{{ asset('storage/foto_halaqah/' . $fileName) }}"
                                                    class="w-full h-16 object-cover rounded-lg border dark:border-gray-700">
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mb-3 text-sm text-gray-500 dark:text-gray-400 italic">
                                        Tidak ada foto
                                    </div>
                                @endif

                                <input type="file" name="foto[]" multiple accept="image/*"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.halaqah.index') }}"
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
