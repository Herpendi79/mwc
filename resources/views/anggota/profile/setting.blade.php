@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        {{-- Memanggil Sidebar --}}
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto max-w-2xl min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Edit Akses</h2>
                            <p class="text-gray-500">Perbarui data akses Anda di sini.</p>
                        </div>

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

                        <form action="{{ route('anggota.profile.updateAkses') }}" method="POST"
                            enctype="multipart/form-data"
                            class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                            @csrf @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Akun</label>
                                    <input type="text" name="name" value="{{ $anggota->user->name }}" readonly
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-900/50 text-gray-500 dark:text-gray-500 outline-none cursor-not-allowed">
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                    <input type="email" name="email" value="{{ $anggota->user->email }}"
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Password Lama</label>
                                    <input type="password" name="old_password" value=""
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Password Baru --}}
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Password Baru</label>
                                    <input type="password" name="new_password"
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>

                                {{-- Konfirmasi Password Baru --}}
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="new_password_confirmation"
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    {{-- Memanggil Footer --}}
                    @include('anggota.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
