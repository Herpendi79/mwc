@extends('layouts.main_free')

@section('title', 'Portal MWC NU Tugu')

@section('content')
    <!-- Preloader Start -->
    <div id="preloader-active" style="background: white !important;">
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <img src="{{ asset('assets/images/MWC_TUGU.ico') }}" alt="Logo" width="100" height="100"
                style="border:0 !important;">
        </div>
    </div>

    @include('partials.header')

    <main class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6 dark:text-white">Kirim Permohonan Bahtsul Masail</h2>
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error (Pesan Manual) --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Notifikasi Error Validasi Form --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anggota.bahsul.simpan.freeuser') }}" method="POST" enctype="multipart/form-data"
                class="bg-emerald-100 dark:bg-emerald-900/40 p-8 rounded-2xl border border-emerald-300 dark:border-emerald-700 shadow-sm">
                @csrf

                <div class="form-wrapper">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                        {{-- Judul --}}
                        <div class="mb-5 md:col-span-3">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all block">
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-5 md:col-span-1">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                            <select name="kategori" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all block">
                                <option value="">-- Pilih --</option>
                                @foreach (['Akhlaqiyyah', "Bi'iyyah", 'Fiqhiyyah', "I'tiqadiyyah", "Ijtima'iyyah", 'Iqtishadiyyah', "Maudhu'iyyah", 'Qanuniyyah', 'Siyasiyyah', 'Tarbawiyyah', 'Thibbiyyah', 'Ushuliyyah / Manhajiyyah', "Waqi'iyyah"] as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                        {{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris Tanggal, Pemohon, Email, Lokasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                        {{-- Tanggal (Tetap abu-abu karena readonly) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                            <input type="text" value="{{ date('d/m/Y') }}" readonly
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-gray-100 dark:bg-gray-800/30 dark:text-gray-500 cursor-not-allowed outline-none">
                        </div>

                        {{-- Pemohon (Putih) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Pemohon</label>
                            <input type="text" name="pemohon" value="{{ old('pemohon') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>

                        {{-- Email (Putih) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email (untuk notifikasi)</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all"
                                placeholder="contoh@email.com">
                        </div>

                        {{-- Lokasi (Putih) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lokasi (Kota/Kabupaten)</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Masalah / Textarea (Putih) --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Masalah (Bahtsul Masail)</label>
                        <textarea name="masalah"
                            class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white outline-none">{{ old('masalah') }}</textarea>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex gap-4">
                    {{-- Tombol Simpan (Hijau) --}}
                    <button type="submit"
                        style="flex: 1; background-color: #088839 !important; color: white !important; width: 50%; padding: 12px; border-radius: 12px; border: none; font-weight: bold; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#066d2d !important'"
                        onmouseout="this.style.backgroundColor='#088839 !important'">
                        Kirim Permohonan
                    </button>

                    {{-- Tombol Batal (Biru) --}}
                    <a href="{{ route('bahsul') }}"
                        style="flex: 1; display: block; background-color: #2563eb !important; color: white !important; padding: 12px; border-radius: 12px; text-align: center; font-weight: bold; text-decoration: none !important;"
                        onmouseover="this.style.backgroundColor='#1d4ed8 !important'"
                        onmouseout="this.style.backgroundColor='#2563eb !important'">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

    @include('partials.footer')

@endsection
@section('scripts')
@endsection
