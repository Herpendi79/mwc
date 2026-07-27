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
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

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

                    <form action="{{ route('admin.opini.update', $opini->id_op) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col flex-grow">
                        @csrf
                        @method('PUT')

                        {{-- Baris Input 1 --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Opini</label>
                                <input type="text" name="judul" value="{{ old('judul', $opini->judul) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>

                                <select name="kategori" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-green-500 transition">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @php
                                        $kategoris = Storage::exists('kategori_opini.txt')
                                            ? array_filter(
                                                array_map('trim', explode("\n", Storage::get('kategori_opini.txt'))),
                                            )
                                            : [];
                                    @endphp

                                    @foreach ($kategoris as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori', $opini->kategori ?? '') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Status</label>
                                <select name="status"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    <option value="arsip" {{ $opini->status == 'arsip' ? 'selected' : '' }}>Arsip</option>
                                    <option value="draft" {{ $opini->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="publish" {{ $opini->status == 'publish' ? 'selected' : '' }}>Publish
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Baris Input 2 (Penulis & File Preview) --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penulis</label>
                                <input type="text" name="penulis" value="{{ old('penulis', $opini->penulis) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ganti Foto</label>
                                <input type="file" name="foto"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                @if (!empty($opini->foto) && Storage::disk('public')->exists('foto_opini/' . $opini->foto))
                                    <p class="text-xs text-blue-500 mt-1">File saat ini:</p>
                                    <a href="{{ asset('storage/foto_opini/' . $opini->foto) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_opini/' . $opini->foto) }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @else
                                    <p class="text-xs text-red-500 mt-1">File fisik saat ini tidak ditemukan, menggunakan
                                        gambar default:</p>
                                    <a href="{{ asset('storage/foto_opini/opini-default.jpeg') }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_opini/opini-default.jpeg') }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm opacity-75">
                                    </a>
                                @endif

                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Ganti Lampiran</label>
                                <input type="file" name="lampiran"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">

                                @if (!empty($opini->lampiran) && Storage::disk('public')->exists('file/' . $opini->lampiran))
                                    <a href="{{ asset('storage/file/' . $opini->lampiran) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <p class="text-xs text-blue-500 mt-1">File saat ini: <u>Klik Disini!</u></p>
                                    </a>
                                @else
                                    <p class="text-xs text-gray-400 italic mt-1">Tidak ada lampiran.</p>
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
                            <a href="{{ route('admin.opini.index') }}"
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
