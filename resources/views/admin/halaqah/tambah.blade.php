@extends('layouts.main')

@section('title', 'Tambah Halaqah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Halaqah</h2>
                        <p class="text-gray-500">Isi formulir berikut untuk menambahkan data kegiatan halaqah.</p>
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

                    <form action="{{ route('admin.halaqah.simpan') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf

                        {{-- Baris 1: Judul, Tanggal & Lokasi --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mb-5 md:col-span-1">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Kegiatan</label>
                                <input type="text" name="judul" value="{{ old('judul') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Baris 2: Tema, Narasumber, Moderator --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema</label>
                                <input type="text" name="tema" value="{{ old('tema') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Narasumber</label>
                                <input type="text" name="narsum" value="{{ old('narsum') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Moderator</label>
                                <input type="text" name="moderator" value="{{ old('moderator') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        {{-- Baris 3: Deskripsi & Hasil --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Hasil Kegiatan</label>
                            <textarea name="hasil" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('hasil') }}</textarea>
                        </div>

                        {{-- Upload Media --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Thumbnail</label>
                                <input type="file" name="thumbnail" accept="image/*"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Galeri Foto (Bisa > 1
                                    Foto)</label>
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
