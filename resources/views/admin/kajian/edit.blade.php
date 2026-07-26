@extends('layouts.main')

@section('title', 'Edit Kajian')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Pengajian</h2>
                        <p class="text-gray-500">Ubah detail data kegiatan pengajian.</p>
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

                    <form action="{{ route('admin.kajian.update', $kajian->id) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Baris Input --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul', $kajian->judul) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tema</label>
                                <input type="text" name="tema" value="{{ old('tema', $kajian->tema) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal"
                                    value="{{ old('tanggal', $kajian->tanggal ? $kajian->tanggal->format('Y-m-d') : '') }}"
                                    required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Pemateri</label>
                                <input type="text" name="pemateri" value="{{ old('pemateri', $kajian->pemateri) }}"
                                    required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $kajian->lokasi) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Link YouTube</label>
                                <input type="url" name="link_yt" value="{{ old('link_yt', $kajian->link_yt) }}"
                                    placeholder="https://youtube.com/..."
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>
                        {{-- File Uploads dengan Preview --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">

                            {{-- Poster Preview --}}
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Poster</label>
                                @if ($kajian->poster)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/foto_kajian/' . $kajian->poster) }}"
                                            class="w-full h-32 object-cover rounded-xl border border-gray-200 dark:border-gray-700">
                                    </div>
                                @endif
                                <input type="file" name="poster" accept="image/*"
                                    class="w-full p-2 border dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>


                            {{-- Galeri Foto Preview --}}
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Galeri Foto</label>
                                <div class="grid grid-cols-3 gap-2 mb-2">
                                    @foreach (explode(';', $kajian->foto) as $f)
                                        @if (!empty(trim($f)))
                                            <img src="{{ asset('storage/foto_kajian/' . trim($f)) }}"
                                                class="w-full h-16 object-cover rounded-lg border dark:border-gray-700">
                                        @endif
                                    @endforeach
                                </div>
                                <input type="file" name="foto[]" multiple accept="image/*"
                                    class="w-full p-2 border dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>


                            {{-- Materi --}}
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Materi (File)</label>
                                <input type="file" name="materi"
                                    class="w-full p-2 border dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                            </div>

                        </div>

                        <div class="mt-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Deskripsi</label>
                            <textarea name="deskripsi" rows="4" required
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">{{ old('deskripsi', $kajian->deskripsi) }}</textarea>
                        </div>

                        <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('admin.kajian.index') }}"
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
