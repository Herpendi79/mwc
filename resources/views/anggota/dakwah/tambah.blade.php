@extends('layouts.main')

@section('title', 'Tambah Data Dakwah')

@section('styles')
    <style>
        /* Memastikan form mengisi tinggi layar dengan baik */
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
                {{-- Diperlebar ke max-w-6xl --}}
                <div class="container mx-auto max-w-6xl h-full flex flex-col">

                    <div class="mb-6">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Pesan Dakwah</h2>
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

                    {{-- Form dibuat flex-grow agar mengisi sisa halaman --}}
                    <form action="{{ route('admin.dakwah.store') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col flex-grow">
                        @csrf

                        {{-- Baris Input Atas --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            {{-- Judul (Lebar: 6 Kolom) --}}
                            <div class="col-span-12 md:col-span-6">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Dakwah</label>
                                <input type="text" name="judul" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>

                            {{-- Kategori (Lebar: 3 Kolom) --}}
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                                <input type="text" name="kategori" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>

                            {{-- Status (Lebar: 3 Kolom) --}}
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Status</label>
                                <select name="status"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                    <option value="draft">Draft</option>
                                    <option value="publish">Publish</option>
                                </select>
                            </div>
                        </div>

                        {{-- Baris Input Kedua --}}
                        <div class="grid grid-cols-12 gap-4 mb-6">
                            {{-- Mubaligh (Lebar: 6 Kolom) --}}
                            <div class="col-span-12 md:col-span-4">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Mubaligh</label>
                                <input type="text" name="mubaligh" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>

                            {{-- Tanggal (Lebar: 2 Kolom) --}}
                            <div class="col-span-12 md:col-span-2">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tgl" value="{{ date('Y-m-d') }}"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            </div>

                            {{-- Poster (Lebar: 6 Kolom) --}}
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster Dakwah</label>
                                <input type="file" name="poster"
                                    class="w-full p-2.5 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition">
                            </div>
                            {{-- Link --}}
                            <div class="col-span-12 md:col-span-3">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Link Youtube</label>
                                <input type="text" name="link_yt"
                                    class="w-full p-2.5 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition">
                            </div>
                        </div>

                        {{-- Area Editor (Paling bawah & Full Sisa Halaman) --}}
                        <div class="flex flex-col flex-grow mb-6">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Dakwah</label>
                            <div class="editor-container">
                                <textarea name="isi" id="editor" class="w-full flex-grow"></textarea>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('admin.dakwah.index') }}"
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    window.onload = function() {
        ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
    };
</script>
