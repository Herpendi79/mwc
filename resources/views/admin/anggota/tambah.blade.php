@extends('layouts.main')

@section('title', 'Tambah Anggota')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto max-w-2xl min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Tambah Anggota</h2>
                            <p class="text-gray-500">Isi formulir di bawah ini untuk menambahkan anggota baru ke sistem.</p>
                        </div>

                        {{-- Menampilkan Error Validasi --}}
                        @if ($errors->any())
                            <div
                                class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 p-4 rounded-2xl mb-6 border border-red-200 dark:border-red-800">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.anggota.simpan') }}" method="POST" enctype="multipart/form-data"
                            class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">ID Anggota</label>
                                    <input type="text" name="no_anggota" value="{{ old('no_anggora') }}" required
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Password</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter"
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Alamat</label>
                                <textarea name="alamat" rows="3" required
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nomor Telepon</label>
                                    <input type="tel" name="telpon" value="{{ old('telpon') }}" required
                                        pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                                </div>

                                <div class="mb-5">
                                    <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto Profil</label>
                                    <input type="file" name="foto" accept="image/*"
                                        class="w-full p-2 border border-gray-300 dark:border-gray-700 rounded-xl dark:bg-gray-800 dark:text-white">
                                </div>
                            </div>

                            <div class="mb-8">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Keterangan</label>
                                <textarea name="keterangan" rows="2"
                                    class="w-full p-3 rounded-xl border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">{{ old('keterangan') }}</textarea>
                            </div>
                            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-200">
                                <div class="flex gap-4 mt-6">
                                    <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                                        Simpan Data
                                    </button>
                                    <a href="{{ route('admin.anggota.index') }}"
                                        class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                        Batal
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    @include('admin.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
