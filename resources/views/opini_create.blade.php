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
            <h2 class="text-2xl font-bold mb-6 dark:text-white">Tulis Opini Terbaik Anda!</h2>
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

            <form action="{{ route('opini.simpan.freeuser') }}" method="POST" enctype="multipart/form-data"
                class="bg-emerald-100 dark:bg-emerald-900/40 p-8 rounded-2xl border border-emerald-300 dark:border-emerald-700 shadow-sm">
                @csrf

                <div class="form-wrapper">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                        {{-- Judul --}}
                        <div class="mb-5 md:col-span-3">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Judul Opini</label>
                            <input type="text" name="judul" value="{{ old('judul') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all block">
                        </div>

                        {{-- Kategori --}}
                        <div class="mb-5 md:col-span-1">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Kategori</label>
                            <select name="kategori" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all block">
                                <option value="">-- Pilih Kategori --</option>
                                @php
                                    $kategoris = Storage::exists('kategori_opini.txt')
                                        ? array_filter(
                                            array_map('trim', explode("\n", Storage::get('kategori_opini.txt'))),
                                        )
                                        : [];
                                @endphp

                                @foreach ($kategoris as $kat)
                                    <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>
                                        {{ $kat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris Tanggal, penulis, Email, Lokasi --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                        {{-- Tanggal (Tetap abu-abu karena readonly) --}}


                        {{-- Pemohon (Putih) --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penulis</label>
                            <input type="text" name="penulis" value="{{ old('penulis') }}" required
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
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto (Wajib Ada)</label>
                            <input type="file" name="foto" accept="image/*" name="foto"
                                value="{{ old('foto') }}" required
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Lampiran</label>
                            <input type="file" name="lampiran" accept=".pdf,.doc,.docx" value="{{ old('lampiran') }}"

                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="mb-6" x-data="{
                        tags: [],
                        textInput: '',
                        addTag(event) {
                            event.preventDefault();
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
                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tags (Tulis lalu tekan spasi atau
                            Enter)</label>

                        {{-- Container Kotak Tag --}}
                        <div
                            class="w-full p-3 rounded-xl border border-emerald-200 dark:border-gray-700 bg-white dark:bg-gray-800 flex flex-wrap items-center gap-2 focus-within:ring-2 focus-within:ring-green-500 transition">

                            {{-- List Tag --}}
                            <template x-for="(tag, index) in tags" :key="index">
                                <span
                                    class="bg-emerald-100 dark:bg-emerald-900/50 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-lg text-sm font-medium flex items-center gap-1.5">
                                    <span x-text="tag"></span>
                                    <button type="button" @click="removeTag(index)"
                                        class="hover:text-red-500 font-bold">&times;</button>
                                </span>
                            </template>

                            {{-- Input Text --}}
                            <input type="text" x-model="textInput" @keydown.space.prevent="addTag($event)"
                                @keydown.enter.prevent="addTag($event)"
                                @keydown.backspace="if(textInput === '' && tags.length > 0) tags.pop()"
                                placeholder="Ketik lalu tekan spasi..."
                                class="flex-grow bg-transparent dark:text-white outline-none min-w-[150px]">
                        </div>

                        {{-- Ubah ke join(',') agar tersimpan sebagai teks dipisah koma (contoh: islam,haji,umrah) --}}
                        <input type="hidden" name="ringkasan" :value="tags.join(',')">

                        <p class="text-xs text-gray-400 mt-1">Contoh: Dakwah, Islam, Kajian (Tekan spasi atau Enter untuk
                            menambah)</p>
                    </div>

                    {{-- Masalah / Textarea (Putih) --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Isi Opini</label>
                        <div class="editor-container">
                            <textarea name="isi" id="editor" rows="10"
                                class="w-full p-3 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-white dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none transition-all">{{ old('isi') }}</textarea>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex gap-4">
                        {{-- Tombol Simpan (Hijau) --}}
                        <button type="submit"
                            style="flex: 1; background-color: #088839 !important; color: white !important; width: 50%; padding: 12px; border-radius: 12px; border: none; font-weight: bold; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#066d2d !important'"
                            onmouseout="this.style.backgroundColor='#088839 !important'">
                            Kirim Opini
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
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        window.onload = function() {
            ClassicEditor.create(document.querySelector('#editor'))
                .then(editor => {
                    // Memaksa tinggi area ketik editor menjadi 400px secara langsung
                    editor.ui.getEditableElement().style.minHeight = '400px';
                })
                .catch(error => {
                    console.error(error);
                });
        };
    </script>
@endsection
