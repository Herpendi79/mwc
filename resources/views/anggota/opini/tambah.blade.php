@extends('layouts.main')

@section('title', 'Tambah Data Opini')

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
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-6xl h-full flex flex-col">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Opini</h2>
                        <p class="text-gray-500">Buat artikel opini baru Anda.</p>
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

                    <form action="{{ route('anggota.opini.store') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col flex-grow">
                        @csrf

                        <div class="grid grid-cols-12 gap-4 mb-6">
                            {{-- Judul --}}
                            <div class="col-span-12 md:col-span-9">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Opini</label>
                                <input type="text" name="judul" required value="{{ old('judul') }}"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                            </div>
                            {{-- Kategori --}}
                            <div class="col-span-12 md:col-span-3">
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-bold dark:text-gray-300">Kategori</label>
                                </div>

                                <select name="kategori" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    @php
                                        $kategoris = Storage::exists('kategori_opini.txt')
                                            ? array_filter(
                                                array_map('trim', explode("\n", Storage::get('kategori_opini.txt'))),
                                            )
                                            : [];

                                        sort($kategoris);

                                        // Pindahkan "Lainnya" ke urutan paling akhir jika ada
                                        if (($key = array_search('Lainnya', $kategoris)) !== false) {
                                            unset($kategoris[$key]);
                                            $kategoris[] = 'Lainnya';
                                        }
                                    @endphp

                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4 mb-6">
                            {{-- Penulis --}}
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penulis</label>
                                <!-- Ubah name menjadi "penulis" -->
                                <input type="text" name="penulis" value="{{ old('penulis', Auth::user()->name) }}"
                                    readonly
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-500 dark:text-gray-500 outline-none cursor-not-allowed">
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

                        {{-- Ringkasan --}}
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
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Opini Lengkap</label>
                            <div class="editor-container">
                                <textarea name="isi" id="editor" class="w-full flex-grow">{{ old('isi') }}</textarea>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                Simpan Data
                            </button>
                            <a href="{{ route('anggota.opini.index') }}"
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

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        window.onload = function() {
            ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
        };
    </script>
@endsection
