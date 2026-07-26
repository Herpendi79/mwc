@extends('layouts.main')

@section('title', 'Edit Bahsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Bahtsul Masail</h2>
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

                    <form action="{{ route('admin.bahsul.update', $bahsul->id_bs) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul', $bahsul->judul) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                                <select name="kategori" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    <option value="">-- Pilih Kategori --</option>
                                    @php
                                        $kategoris = Storage::exists('kategori.txt')
                                            ? array_filter(
                                                array_map('trim', explode("\n", Storage::get('kategori.txt'))),
                                            )
                                            : [];
                                    @endphp

                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori', $bahsul->kategori ?? '') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ old('tanggal', $bahsul->tanggal) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $bahsul->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Pemohon</label>
                                <input type="text" name="pemohon" value="{{ old('pemohon', $bahsul->pemohon) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masalah</label>
                            <textarea name="masalah" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">{{ old('masalah', $bahsul->masalah) }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Putusan</label>
                            <textarea name="putusan" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">{{ old('putusan', $bahsul->putusan) }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Dasar Hukum</label>
                            <textarea name="dasar_hukum" rows="2" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">{{ old('dasar_hukum', $bahsul->dasar_hukum) }}</textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran Baru (Opsional)</label>
                            @if ($bahsul->lampiran)
                                <p class="text-xs text-blue-500 mb-2">File saat ini: {{ basename($bahsul->lampiran) }}</p>
                            @endif
                            <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.bahsul.index') }}"
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
