@extends('layouts.main')

@section('title', 'Tambah Data Berita')

@section('styles')
    <style>
        .editor-container {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .ck-editor__editable_inline {
            min-height: 400px !important;
            flex-grow: 1;
        }

        .dark .ck.ck-content {
            background: #111827;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-6xl h-full flex flex-col">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Data Berita</h2>
                        <p class="text-gray-500">Buat artikel berita baru.</p>
                    </div>

                    @if ($errors->any())
                        <div class="bg-red-100 p-4 mb-4 text-red-700 rounded-xl">
                            <ul class="list-disc ml-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Bungkus menggunakan x-data agar state modal aktif --}}
                    <div x-data="{ showAddCategoryModal: false }" class="flex flex-col flex-grow">
                        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data"
                            class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col flex-grow">
                            @csrf

                            <div class="grid grid-cols-12 gap-4 mb-6">
                                {{-- Judul --}}
                                <div class="col-span-12 md:col-span-6">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Berita /
                                        Kegiatan</label>
                                    <input type="text" name="judul" required value="{{ old('judul') }}"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>
                                {{-- Kategori --}}
                                <div class="col-span-12 md:col-span-3">
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
                                            $kategoris = Storage::exists('kategori_berita.txt')
                                                ? array_filter(
                                                    array_map(
                                                        'trim',
                                                        explode("\n", Storage::get('kategori_berita.txt')),
                                                    ),
                                                )
                                                : [];

                                            // Mengurutkan array secara ascending (A - Z)
                                            sort($kategoris);
                                        @endphp

                                        @foreach ($kategoris as $kat)
                                            <option value="{{ $kat }}"
                                                {{ old('kategori') == $kat ? 'selected' : '' }}>
                                                {{ $kat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- Status --}}
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Status</label>
                                    <select name="status"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                        <option value="draft">Draft</option>
                                        <option value="publish">Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-12 gap-4 mb-6">
                                {{-- Penulis --}}
                                <div class="col-span-12 md:col-span-6">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penulis</label>
                                    <input type="text" name="penulis" required value="{{ old('penulis') }}"
                                        class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                </div>
                                {{-- Foto --}}
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto</label>
                                    <input type="file" name="foto" accept="image/*"
                                        class="w-full p-2.5 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                                {{-- Lampiran --}}
                                <div class="col-span-12 md:col-span-3">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran</label>
                                    <input type="file" name="lampiran" accept=".pdf,.doc,.docx"
                                        class="w-full p-2.5 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>

                            <div class="mb-6" x-data="{
                                tags: [],
                                textInput: '',
                                addTag(event) {
                                    let tag = this.textInput.trim().replace(/['$,]/g, '');
                                    if (tag.length > 1 && !this.tags.includes(tag)) {
                                        this.tags.push(tag);
                                    }
                                    this.textInput = '';
                                },
                                removeTag(index) {
                                    this.tags.splice(index, 1);
                                }
                            }">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tags (Tulis lalu tekan spasi
                                    atau Enter)</label>

                                {{-- Container Kotak Tag --}}
                                <div
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 flex flex-wrap items-center gap-2 focus-within:ring-2 focus-within:ring-green-500 transition">

                                    {{-- List Tag yang sudah dibuat --}}
                                    <template x-for="(tag, index) in tags" :key="index">
                                        <span
                                            class="bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-1.5">
                                            <span x-text="tag"></span>
                                            <button type="button" @click="removeTag(index)"
                                                class="hover:text-red-500 font-bold">&times;</button>
                                        </span>
                                    </template>

                                    {{-- Input Text untuk Mengetik Tag --}}
                                    <input type="text" x-model="textInput" @keydown.space.prevent="addTag($event)"
                                        @keydown.enter.prevent="addTag($event)"
                                        @keydown.backspace="if(textInput === '' && tags.length > 0) tags.pop()"
                                        placeholder="Ketik lalu tekan spasi..."
                                        class="flex-grow bg-transparent dark:text-white outline-none min-w-[150px]">
                                </div>

                                {{-- Hidden input agar data tags bisa terkirim ke Controller Laravel --}}
                                <input type="hidden" name="ringkasan" :value="tags.join(',')">
                                <p class="text-xs text-gray-400 mt-1">Contoh: Dakwah, Islam, Kajian (Tekan spasi atau Enter
                                    untuk menambah)</p>
                            </div>

                            {{-- Isi (CKEditor) --}}
                            <div class="flex flex-col flex-grow mb-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Berita Lengkap</label>
                                <div class="editor-container">
                                    <textarea name="isi" id="editor" class="w-full flex-grow">{{ old('isi') }}</textarea>
                                </div>
                            </div>

                            <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('admin.berita.index') }}"
                                    class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                    Batal
                                </a>
                            </div>
                        </form>

                        {{-- MODAL TAMBAH KATEGORI --}}
                        <div x-show="showAddCategoryModal" x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
                            <div @click.away="showAddCategoryModal = false"
                                class="bg-white dark:bg-zinc-900 rounded-2xl p-6 w-full max-w-md shadow-xl border border-gray-200 dark:border-zinc-800 space-y-4">

                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tambah Kategori Baru</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Masukkan nama kategori berita baru yang
                                    ingin ditambahkan.</p>

                                {{-- Sesuaikan route simpan kategori berita Anda --}}
                                <form action="{{ route('admin.berita.storeKategori') }}" method="POST"
                                    class="space-y-4">
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

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        window.onload = function() {
            ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
        };
    </script>
@endsection
