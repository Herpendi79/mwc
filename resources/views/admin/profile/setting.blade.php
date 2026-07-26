@extends('layouts.main')

@section('title', 'Edit Master Data')

@section('content')
    {{-- Tambahkan x-data di sini agar Alpine.js mengenali state modal sertifikat --}}
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ showSertifikatModal: false }">
        {{-- Memanggil Sidebar --}}
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                {{-- Menggunakan max-w-7xl untuk lebar maksimal standar dashboard --}}
                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 min-h-full flex flex-col">

                    <div class="flex-grow">{{-- Notifikasi Sukses --}}
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
                        {{-- Grid Wrapper dengan gap yang lebih lega --}}
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">

                            {{-- Kolom Kiri: Form Edit Akses --}}
                            <div>
                                <form action="{{ route('admin.profile.updateAkses') }}" method="POST"
                                    enctype="multipart/form-data"
                                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                                    @csrf @method('PUT')

                                    <h3 class="text-xl font-bold mb-6 dark:text-white">Edit Akses Akun</h3>

                                    <div class="mb-5">
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Akun</label>
                                        <input type="text" name="name" value="{{ $anggota->user->name }}"
                                            class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                        <input type="email" name="email" value="{{ $anggota->user->email }}"
                                            class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    </div>
                                    <div class="mb-5">
                                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Password Lama</label>
                                        <input type="password" name="old_password"
                                            class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="mb-5">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Password
                                                Baru</label>
                                            <input type="password" name="new_password"
                                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                        </div>
                                        <div class="mb-5">
                                            <label
                                                class="block text-sm font-bold mb-2 dark:text-gray-300">Konfirmasi</label>
                                            <input type="password" name="new_password_confirmation"
                                                class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            </div>

                            {{-- Kolom Kanan: Data Rekening --}}
                            <div>
                                <div
                                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                                    <h3 class="text-xl font-bold mb-6 dark:text-white">Data Rekening</h3>
                                    <form action="{{ route('admin.profile.updateRekening') }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Bank</label>
                                            <input type="text" name="bank" value="{{ $rekening['bank'] ?? '' }}"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nomor
                                                Rekening</label>
                                            <input type="number" name="no_rek" value="{{ $rekening['no_rek'] ?? '' }}"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                        </div>
                                        <div class="mb-6">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Atas Nama</label>
                                            <input type="text" name="an" value="{{ $rekening['an'] ?? '' }}"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                        </div>
                                        <button type="submit"
                                            class="w-full px-8 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">
                                            Simpan Data Rekening
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div> {{-- Penutup Grid Wrapper --}}
                    </div>
                    <br>
                    <div class="flex-grow">
                        {{-- Grid Wrapper dengan gap yang lebih lega --}}
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">

                            {{-- Kolom Kiri: Form Edit Akses --}}
                            @php
                                // Mencari file template sertifikat dengan ekstensi dinamis
                                $sertifikatFiles = glob(public_path('assets/images/sertifikat/Sertifikat.*'));
                                $sertifikatPath = 'assets/images/sertifikat/SertifikatBU.png'; // Default fallback

                                if (!empty($sertifikatFiles)) {
                                    $sertifikatPath = 'assets/images/sertifikat/' . basename($sertifikatFiles[0]);
                                }
                            @endphp

                            <div
                                class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                                <h3 class="text-xl font-bold mb-6 dark:text-white">Preview Sertifikat</h3>

                                <div class="w-full overflow-x-auto">
                                    <div class="relative w-full shadow-2xl rounded-xl overflow-hidden border border-gray-200"
                                        style="aspect-ratio: 842 / 595; background-image: url('{{ asset($sertifikatPath) }}'); background-size: cover; background-position: center;">

                                        {{-- Content 2 (No. Sertifikat) --}}
                                        <div class="absolute" style="top: 29.4%; left: 14.2%;">
                                            <p style="font-size: 0.5vw;" class="font-mono text-[#333]">No. MNG-20260712-001
                                            </p>
                                        </div>

                                        {{-- Content (Nama Donatur) --}}
                                        <div class="absolute w-full text-center" style="top: 42%;">
                                            <h2 style="font-size: 1.8vw;" class="font-bold text-[#333] tracking-wide">Gibran
                                                Raka</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">

                                <h3 class="text-xl font-bold mb-6 dark:text-white">Ganti Sertifikat (2000px X 1414px)</h3>
                                <div class="w-full overflow-x-auto mb-6">
                                    <div class="relative w-full shadow-2xl rounded-xl overflow-hidden border border-gray-200"
                                        style="aspect-ratio: 842 / 595; background-image: url('{{ asset($sertifikatPath) }}'); background-size: cover; background-position: center;">
                                    </div>
                                </div>

                                {{-- Tombol untuk memicu modal --}}
                                <button type="button" @click="showSertifikatModal = true"
                                    class="w-full px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                                    Update Sertifikat
                                </button>
                            </div>

                            {{-- MODAL UPLOAD SERTIFIKAT (Pastikan diletakkan di dalam container utama yang memiliki x-data) --}}
                            <div x-show="showSertifikatModal" style="display: none;"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                                <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 w-full max-w-md shadow-xl border dark:border-gray-800"
                                    @click.outside="showSertifikatModal = false">

                                    <h3 class="text-lg font-bold mb-2 dark:text-white">Ganti Template Sertifikat</h3>
                                    <p class="text-sm text-gray-500 mb-4">Pilih file gambar baru (Format: JPG, PNG, WEBP,
                                        maks. 2MB). Disarankan ukuran 2000px x 1414px.</p>

                                    <form action="{{ route('admin.mangrove.update_sertifikat_template') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf @method('POST')

                                        <div class="mb-4">
                                            <input type="file" name="sertifikat" accept="image/*" required
                                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border dark:border-gray-700 rounded-xl p-2">
                                            @error('sertifikat')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="flex justify-end gap-3">
                                            <button type="button" @click="showSertifikatModal = false"
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
                        </div>

                    </div> {{-- Penutup Grid Wrapper --}}
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
