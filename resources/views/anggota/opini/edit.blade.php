@extends('layouts.main')

@section('title', 'Edit Data Opini')

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
                        <h2 class="text-3xl font-bold dark:text-white">Edit Opini</h2>
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

                    <form action="{{ route('anggota.opini.update', $opini->id_op) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col flex-grow">
                        @csrf
                        @method('PUT')

                        {{-- Baris Input 1 --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-9">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Opini</label>
                                <input type="text" name="judul" value="{{ old('judul', $opini->judul) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                                <select name="kategori" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Fikih & Hukum Islam"
                                        {{ old('kategori', $opini->kategori) == 'Fikih & Hukum Islam' ? 'selected' : '' }}>
                                        Fikih & Hukum Islam
                                    </option>
                                    <option value="Keislaman & Aswaja"
                                        {{ old('kategori', $opini->kategori) == 'Keislaman & Aswaja' ? 'selected' : '' }}>
                                        Keislaman & Aswaja
                                    </option>
                                    <option value="Kebangsaan & Politik"
                                        {{ old('kategori', $opini->kategori) == 'Kebangsaan & Politik' ? 'selected' : '' }}>
                                        Kebangsaan &
                                        Politik</option>
                                    <option value="Pendidikan & Pesantren"
                                        {{ old('kategori', $opini->kategori) == 'Pendidikan & Pesantren' ? 'selected' : '' }}>
                                        Pendidikan &
                                        Pesantren</option>
                                    <option value="Sosial & Ekonomi"
                                        {{ old('kategori', $opini->kategori) == 'Sosial & Ekonomi' ? 'selected' : '' }}>
                                        Sosial & Ekonomi
                                    </option>
                                    <option value="Budaya & Tradisi"
                                        {{ old('kategori', $opini->kategori) == 'Budaya & Tradisi' ? 'selected' : '' }}>
                                        Budaya & Tradisi
                                    </option>
                                    <option value="Dunia Digital"
                                        {{ old('kategori', $opini->kategori) == 'Dunia Digital' ? 'selected' : '' }}>Dunia
                                        Digital</option>
                                </select>
                            </div>
                        </div>

                        {{-- Baris Input 2 (Penulis & File Preview) --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penulis</label>
                                <!-- Ubah name menjadi "penulis" -->
                                <input type="text" name="penulis" value="{{ old('penulis', Auth::user()->name) }}"
                                    readonly
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-500 dark:text-gray-500 outline-none cursor-not-allowed">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ganti Foto</label>
                                <input type="file" name="foto"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                @if ($opini->foto)
                                    <p class="text-xs text-blue-500 mt-1">File saat ini:</p>
                                    <a href="{{ asset('storage/foto_opini/' . $opini->foto) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_opini/' . $opini->foto) }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @endif

                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ganti Lampiran</label>
                                <input type="file" name="lampiran"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">

                                @if ($opini->lampiran)
                                    <a href="{{ asset('storage/file/' . $opini->lampiran) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <p class="text-xs text-blue-500 mt-1">File saat ini: <u>Klik Disini!</u></p>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Editor --}}
                        <div class="flex flex-col flex-grow mb-6">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Opini</label>
                            <div class="editor-container">
                                <textarea name="isi" id="editor" class="w-full flex-grow">{{ old('isi', $opini->isi) }}</textarea>
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
