@extends('layouts.main')

@section('title', 'Tambah Bahsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Bahsul Masail</h2>
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

                    <form action="{{ route('anggota.bahsul.simpan') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf

                        {{-- Baris 1: Judul & Kategori --}}
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                                <input type="text" name="judul" value="{{ old('judul') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                        </div>

                        {{-- Baris 2: Tanggal, Lokasi, Pemohon --}}
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
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Akhlaqiyyah" {{ old('kategori') == 'Akhlaqiyyah' ? 'selected' : '' }}>
                                        Akhlaqiyyah</option>
                                    <option value="Bi'iyyah" {{ old('kategori') == "Bi'iyyah" ? 'selected' : '' }}>Bi'iyyah
                                    </option>
                                    <option value="Fiqhiyyah" {{ old('kategori') == 'Fiqhiyyah' ? 'selected' : '' }}>
                                        Fiqhiyyah</option>
                                    <option value="I'tiqadiyyah" {{ old('kategori') == "I'tiqadiyyah" ? 'selected' : '' }}>
                                        I'tiqadiyyah</option>
                                    <option value="Ijtima'iyyah" {{ old('kategori') == "Ijtima'iyyah" ? 'selected' : '' }}>
                                        Ijtima'iyyah</option>
                                    <option value="Iqtishadiyyah"
                                        {{ old('kategori') == 'Iqtishadiyyah' ? 'selected' : '' }}>Iqtishadiyyah</option>
                                    <option value="Maudhu'iyyah" {{ old('kategori') == "Maudhu'iyyah" ? 'selected' : '' }}>
                                        Maudhu'iyyah</option>
                                    <option value="Qanuniyyah" {{ old('kategori') == 'Qanuniyyah' ? 'selected' : '' }}>
                                        Qanuniyyah</option>
                                    <option value="Siyasiyyah" {{ old('kategori') == 'Siyasiyyah' ? 'selected' : '' }}>
                                        Siyasiyyah</option>
                                    <option value="Tarbawiyyah" {{ old('kategori') == 'Tarbawiyyah' ? 'selected' : '' }}>
                                        Tarbawiyyah</option>
                                    <option value="Thibbiyyah" {{ old('kategori') == 'Thibbiyyah' ? 'selected' : '' }}>
                                        Thibbiyyah</option>
                                    <option value="Ushuliyyah / Manhajiyyah"
                                        {{ old('kategori') == 'Ushuliyyah / Manhajiyyah' ? 'selected' : '' }}>
                                        Ushuliyyah / Manhajiyyah
                                    </option>
                                    <option value="Waqi'iyyah" {{ old('kategori') == "Waqi'iyyah" ? 'selected' : '' }}>
                                        Waqi'iyyah
                                    </option>
                                </select>
                            </div>
                        </div>

                        {{-- Baris 3: Masalah, Putusan, Dasar Hukum --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masalah</label>
                            <textarea name="masalah" rows="3" required
                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-blue-500">{{ old('masalah') }}</textarea>
                        </div>



                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200">
                            <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                    Simpan Data
                                </button>
                                <a href="{{ route('anggota.bahsul.index') }}"
                                    class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
@endsection
