@extends('layouts.main')

@section('title', 'Edit Bahtsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Bahtsul Masail Anda</h2>
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

                    <form action="{{ route('anggota.bahsul.update', $bahsul->id_bs) }}" method="POST"
                        enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul', $bahsul->judul) }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Pemohon</label>
                                <input type="text" name="pemohon" value="{{ old('pemohon', Auth::user()->name) }}"
                                    readonly
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-500 dark:text-gray-500 outline-none cursor-not-allowed">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                                <select name="kategori" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    @foreach (['Akhlaqiyyah', 'Bi\'iyyah', 'Fiqhiyyah', 'I\'tiqadiyyah', 'Ijtima\'iyyah', 'Iqtishadiyyah', 'Maudhu\'iyyah', 'Qanuniyyah', 'Siyasiyyah', 'Tarbawiyyah', 'Thibbiyyah', 'Ushuliyyah / Manhajiyyah', 'Waqi\'iyyah'] as $kat)
                                        <option value="{{ $kat }}"
                                            {{ old('kategori', $bahsul->kategori) == $kat ? 'selected' : '' }}>
                                            {{ $kat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masalah</label>
                            <textarea name="masalah" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">{{ old('masalah', $bahsul->masalah) }}</textarea>
                        </div>

                        <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('anggota.bahsul.index') }}"
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
