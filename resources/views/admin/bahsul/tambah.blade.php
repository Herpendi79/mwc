@extends('layouts.main')

@section('title', 'Tambah Bahsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Bahtsul Masail</h2>
                        <p class="text-gray-500">Isi formulir berikut untuk menambahkan data pembahasan.</p>
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

                    <div x-data="{ showAddCategoryModal: false }" class="w-full">
                        <form action="{{ route('admin.bahsul.simpan') }}" method="POST" enctype="multipart/form-data"
                            class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                            @csrf

                            {{-- Baris 1: Judul & Kategori --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                                    <input type="text" name="judul" value="{{ old('judul') }}" required
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="mb-5">
                                    <div class="flex justify-between items-center mb-2">
                                        <label class="block text-sm font-bold dark:text-gray-300">Kategori</label>

                                        {{-- Tombol Kecil Tambah Kategori --}}
                                        <button type="button" @click="showAddCategoryModal = true"
                                            class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-950/50 dark:text-emerald-400 dark:hover:bg-emerald-900/50 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah Kategori
                                        </button>
                                    </div>

                                    <select name="kategori" required
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
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
                                                {{ old('kategori') == $kat ? 'selected' : '' }}>
                                                {{ $kat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Baris 2: Tanggal, Lokasi, Pemohon --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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

                            {{-- Baris 3: Masalah, Putusan, Dasar Hukum --}}
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masalah</label>
                                <textarea name="masalah" rows="3" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('masalah') }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Putusan</label>
                                <textarea name="putusan" rows="3"
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('putusan') }}</textarea>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Dasar Hukum</label>
                                <textarea name="dasar_hukum" rows="2"
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('dasar_hukum') }}</textarea>
                            </div>

                            {{-- Lampiran --}}
                            <div class="mb-8">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran
                                    (PDF/Dokumen)</label>
                                <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                    class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>

                            <div
                                class="bg-white dark:bg-gray-900 p-6 rounded-3xl shadow-sm border border-gray-200 dark:border-gray-800">
                                <div class="flex gap-4 mt-6">
                                    <button type="submit"
                                        class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition-all">
                                        Simpan Data
                                    </button>
                                    <a href="{{ route('admin.bahsul.index') }}"
                                        class="flex-1 text-center bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300 py-3 rounded-xl font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition-all">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </form>

                        {{-- MODAL TAMBAH KATEGORI (DIPINDAHKAN KELUAR DARI INPUT GRUP) --}}
                        <div x-show="showAddCategoryModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                            <div @click.away="showAddCategoryModal = false"
                                class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-full max-w-md shadow-xl border border-gray-200 dark:border-zinc-800 space-y-4">

                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Kategori Baru</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan nama kategori baru yang ingin
                                    ditambahkan ke daftar.</p>

                                <form action="{{ route('admin.bahsul.storeKategori') }}" method="POST" class="space-y-4">
                                    @csrf

                                    <div>
                                        <label
                                            class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 mb-1">Nama
                                            Kategori</label>
                                        <input type="text" name="nama_kategori" required autocomplete="off"
                                            placeholder="Contoh: Kategori Baru"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                    </div>

                                    <div class="flex justify-end gap-3 pt-2">
                                        <button type="button" @click="showAddCategoryModal = false"
                                            class="px-4 py-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-800 font-medium transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                                            Simpan Kategori
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
