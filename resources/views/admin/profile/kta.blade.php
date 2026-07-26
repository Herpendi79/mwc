@extends('layouts.main')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ showTemplateModal: false }">
        {{-- Memanggil Sidebar --}}
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col justify-between">

                    <div>
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Preview KTA</h2>
                        </div>

                        {{-- Alert Success --}}
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

                            {{-- Kartu KTA 1 (Hasil Preview Utama) --}}
                            <div>
                                {{-- Memberikan label kosong atau judul setara agar tinggi kolom sejajar --}}

                            <p class="text-gray-500 mb-2">Berikut adalah kartu anggota anda:</p>

                                @if ($anggota)
                                    @php
                                        // Mencari file dengan awalan "Template." di dalam folder public/assets/images/template/
                                        $templateFiles = glob(public_path('assets/images/template/Template.*'));

                                        // Default path jika file tidak ditemukan
                                        $templatePath = 'assets/images/template/TemplateBU.png';

                                        if (!empty($templateFiles)) {
                                            // Ambil nama file asli beserta ekstensinya (misal: Template.jpg atau Template.png)
                                            $templatePath = 'assets/images/template/' . basename($templateFiles[0]);
                                        }
                                    @endphp

                                    <div class="w-full max-w-sm aspect-[86/54] relative shadow-xl rounded-2xl overflow-hidden border border-gray-200"
                                        style="background-image: url('{{ asset($templatePath) }}'); background-size: cover; background-position: center;">

                                        <div
                                            class="absolute top-[30%] right-[7%] w-[35%] aspect-square rounded-full overflow-hidden border-4 border-yellow-500 shadow-lg">
                                            <img src="{{ $anggota->foto ? asset('storage/foto/' . $anggota->foto) : asset('assets/images/default-avatar.png') }}"
                                                alt="Foto" class="w-full h-full object-cover">
                                        </div>

                                        <div class="absolute top-[36.5%] left-[5%] w-[60%] flex flex-col text-white">
                                            <h3 class="text-[10px] font-bold uppercase tracking-widest text-yellow-300">MWC
                                                TUGU</h3>
                                            <p class="text-xl font-black mt-1">
                                                TG{{ str_pad($anggota->no_anggota, 4, '0', STR_PAD_LEFT) }}
                                            </p>
                                            <p class="text-sm font-bold mt-1">{{ auth()->user()->name }}</p>
                                            <p class="text-[9px] mt-2 text-white/80">
                                                Masa Aktif: {{ $anggota->created_at->format('d M Y') }} -
                                                {{ $anggota->created_at->addYear()->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-6">
                                        <a href="{{ route('admin.download_Kta') }}" target="_blank"
                                            class="inline-block px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                                            Download
                                        </a>
                                    </div>
                                @else
                                    <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-2xl text-yellow-800">
                                        Data anggota belum ditemukan. Silakan lengkapi profil anggota Anda terlebih dahulu.
                                    </div>
                                @endif
                            </div>

                            {{-- Kartu KTA 2 (Informasi Template & Tombol Ganti Template) --}}
                            <div>
                                <p class="text-gray-500 mb-2">Berikut adalah template KTA (1011px x 639px):</p>

                                @php
                                    // Mencari file dengan awalan "Template." di dalam folder public/assets/images/template/
                                    $templateFiles = glob(public_path('assets/images/template/Template.*'));

                                    // Default path jika file tidak ditemukan
                                    $templatePath = 'assets/images/template/Template.png';

                                    if (!empty($templateFiles)) {
                                        // Ambil nama file asli beserta ekstensinya (misal: Template.jpg atau Template.png)
                                        $templatePath = 'assets/images/template/' . basename($templateFiles[0]);
                                    }
                                @endphp

                                <div class="w-full max-w-sm aspect-[86/54] relative shadow-xl rounded-2xl overflow-hidden border border-gray-200"
                                    style="background-image: url('{{ asset($templatePath) }}'); background-size: cover; background-position: center;">
                                </div>

                                    <div class="mt-6">
                                        <button type="button" @click="showTemplateModal = true"
                                            class="inline-block px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">
                                            Ganti Template
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- MODAL UPLOAD TEMPLATE --}}
                        <div x-show="showTemplateModal" style="display: none;"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 w-full max-w-md shadow-xl border dark:border-gray-800"
                                @click.outside="showTemplateModal = false">

                                <h3 class="text-lg font-bold mb-2 dark:text-white">Ganti Template KTA</h3>
                                <p class="text-sm text-gray-500 mb-4">Pilih file gambar baru (Format: JPG, PNG, WEBP, maks.
                                    2MB). Disarankan ukuran 1011x639px.</p>

                                <form action="{{ route('admin.update_template') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf @method('POST')

                                    <div class="mb-4">
                                        <input type="file" name="template" accept="image/*" required
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border dark:border-gray-700 rounded-xl p-2">
                                        @error('template')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="showTemplateModal = false"
                                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition">
                                            Batal
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">
                                            Upload & Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Memanggil Footer --}}
                        @include('admin.partials._footer')
                    </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
