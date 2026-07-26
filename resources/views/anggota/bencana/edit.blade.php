@extends('layouts.main')

@section('title', 'Edit Data Bencana')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Data Bencana</h2>
                        <p class="text-gray-500">Perbarui informasi laporan bencana.</p>
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

                    <form action="{{ route('admin.bencana.update', $bencana->id_lb) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Pelapor, Jenis Bencana & Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Pelapor</label>
                                <input type="text" name="pelapor" value="{{ old('pelapor', $bencana->pelapor) }}"
                                    required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jenis Bencana</label>
                                <input type="text" name="jenis_bencana"
                                    value="{{ old('jenis_bencana', $bencana->jenis_bencana) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tgl"
                                    value="{{ old('tgl', \Carbon\Carbon::parse($bencana->tgl)->format('Y-m-d')) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        {{-- Lokasi & Jumlah Korban --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $bencana->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jumlah Korban</label>
                                <input type="number" name="jml_korban"
                                    value="{{ old('jml_korban', $bencana->jml_korban) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>
                        </div>

                        {{-- Kebutuhan & Deskripsi --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kebutuhan Mendesak</label>
                            <textarea name="kebutuhan" rows="2" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('kebutuhan', $bencana->kebutuhan) }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" rows="3" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('deskripsi', $bencana->deskripsi) }}</textarea>
                        </div>

                        {{-- Foto --}}
                        <div class="mb-8" x-data="{ previewImages: [] }">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Dokumentasi Foto</label>

                            {{-- Tampilan Foto Lama --}}
                            @if ($bencana->foto)
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 mb-2">Foto Saat Ini:</p>
                                    <div class="flex gap-2">
                                        @foreach (explode(';', $bencana->foto) as $f)
                                            <img src="{{ asset('storage/foto_bencana/' . trim($f)) }}"
                                                class="w-20 h-20 object-cover rounded-lg border">
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Input & Preview Baru --}}
                            <input type="file" name="foto[]" multiple accept="image/*"
                                @change="previewImages = Array.from($event.target.files).map(file => URL.createObjectURL(file))"
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">

                            <div class="flex gap-2 mt-4" x-show="previewImages.length > 0">
                                <template x-for="src in previewImages">
                                    <img :src="src"
                                        class="w-20 h-20 object-cover rounded-lg border border-emerald-500">
                                </template>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">Memilih foto baru akan menggantikan seluruh foto lama.</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('admin.bencana.index') }}"
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
