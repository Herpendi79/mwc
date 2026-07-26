@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <style>
        /* Memastikan elemen tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Perbaikan khusus untuk input number agar lebih bersih */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="relative font-ibm">
        <!-- Paksa items-start di mobile agar bisa di-scroll, items-center di desktop -->
        <section
            class="min-h-screen py-10 md:py-20 bg-cover bg-center relative flex items-start md:items-center justify-center"
            style="background-image: url('{{ asset('assets/images/event/back.jpeg') }}'); background-attachment: fixed;">

            <!-- Overlay diturunkan ke 40% (bg-black/40) agar background terlihat jelas -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <!-- Margin bottom ditambahkan agar tidak mentok di layar HP saat scroll -->
            <div class="container relative z-50 px-4 mb-10 force-show">

                <!-- Padding dan Gap disesuaikan untuk Mobile (p-6) dan Desktop (md:p-12) -->
                <div class="text-center rounded-3xl md:p-12 p-6 bg-white/20 backdrop-blur-md text-white max-w-3xl mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <a href="{{ url('/') }}" class="inline-block mb-6 md:mb-8">
                        <img src="{{ asset('assets/images/logo/logo.webp') }}" alt="Logo" class="h-30 md:h-42 mx-auto">
                    </a>

                    <h2 class="font-bold leading-snug mb-2 text-3xl md:text-5xl tracking-tight drop-shadow-md">
                        Buat Akun Anda
                    </h2>
                    <p class="text-gray-200 mb-8 md:mb-10 text-sm md:text-base">Mari Bergabung Bersama Kami. Isi Data Anda
                        di Bawah ini:</p>

                    <!-- Tambahkan ini di atas tag <form> -->
                        {{-- Notifikasi Sukses --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif
                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded-xl mb-6">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 border border-red-600 text-white px-4 py-3 rounded-xl mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('registerPeserta.post') }}" method="POST" enctype="multipart/form-data"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 text-left">
                        <!-- Full Name -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Nama Lengkap (Untuk KTA &
                                Sertifikat)</label>
                            <input type="text" name="name" placeholder="" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white placeholder-gray-400">
                        </div>

                        <!-- Email -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Email (Untuk
                                Notifikasi)</label>
                            <input type="email" name="email" placeholder="example@university.ac.id" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white placeholder-gray-400">
                        </div>



                        <!-- Country Dropdown -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Alamat</label>
                            <!-- Gunakan flex agar elemen berdampingan secara otomatis -->
                            <div
                                class="flex items-center bg-white/10 border border-white/30 rounded-xl overflow-hidden focus-within:border-[#c0f037] transition-all">
                                <input type="text" name="alamat" placeholder="" required
                                    class="w-full bg-transparent border-none px-4 py-3 md:py-3.5 outline-none focus:ring-0 text-white placeholder-gray-400 text-sm md:text-base">
                            </div>
                        </div>

                        <!-- WhatsApp Number -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Telpon</label>
                            <!-- Gunakan flex agar elemen berdampingan secara otomatis -->
                            <div
                                class="flex items-center bg-white/10 border border-white/30 rounded-xl overflow-hidden focus-within:border-[#c0f037] transition-all">
                                <input type="number" name="telpon" placeholder="" required
                                    class="w-full bg-transparent border-none px-4 py-3 md:py-3.5 outline-none focus:ring-0 text-white placeholder-gray-400 text-sm md:text-base">
                            </div>
                        </div>

                        <!-- WhatsApp Number -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Foto Profil (Untuk KTA)</label>
                            <div
                                class="flex items-center bg-white/10 border border-white/30 rounded-xl overflow-hidden focus-within:border-[#c0f037] transition-all">
                                <!-- Tambahkan accept="image/*" di bawah ini -->
                                <input type="file" name="foto" accept="image/*" required
                                    class="w-full bg-transparent border-none px-4 py-3 md:py-3.5 outline-none focus:ring-0 text-white placeholder-gray-400 text-sm md:text-base file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-white/20 file:text-white hover:file:bg-white/30 cursor-pointer">
                            </div>
                        </div>


                        <!-- Password -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white">
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="••••••••" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white">
                            <!-- Pesan Error Password -->
                            <p id="password-error" class="text-red-400 text-xs mt-2 hidden">Password tidak cocok!</p>
                        </div>
                        <p class="col-span-1 md:col-span-2">*Password minimal 8 karakter</p>

                        <!-- Submit Button -->
                        <div class="col-span-1 md:col-span-2 w-full flex justify-center mt-6 md:mt-8">
                            <button type="submit"
                                class="w-full md:w-3/4 lg:w-1/2 bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-xl shadow-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] border border-white/10">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>

                    <!-- Sign In Link - Ditambahkan mb-4 untuk ruang di mobile -->
                    <p class="mt-8 text-gray-300 text-sm md:text-base mb-4">
                        Sudah Punya Akun?
                        <a href="{{ url('/login') }}" class="text-[#c0f037] font-bold hover:underline">Login disini</a>
                    </p>

                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById('countrySelect');
            const phoneCodeSpan = document.getElementById('phoneCode');

            // API untuk data negara dan kode telepon
            fetch('https://restcountries.com/v3.1/all?fields=name,idd')
                .then(response => response.json())
                .then(data => {
                    const countries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));

                    countries.forEach(country => {
                        const name = country.name.common;
                        const root = country.idd.root || '';
                        const suffix = (country.idd.suffixes && country.idd.suffixes.length > 0) ?
                            country.idd.suffixes[0] : '';
                        const code = root + suffix;

                        if (code) {
                            const option = document.createElement('option');
                            // PERBAIKAN: value diisi nama negara agar tersimpan di DB sebagai nama negara
                            option.value = name;
                            // Simpan kode telepon di atribut data kustom agar bisa diambil oleh JS
                            option.setAttribute('data-code', code);
                            option.textContent = name;
                            option.className = "text-black";
                            countrySelect.appendChild(option);
                        }
                    });
                })
                .catch(error => console.error('Error fetching countries:', error));

            // Update kode telepon saat negara dipilih
            countrySelect.addEventListener('change', function() {
                // Ambil kode telepon dari atribut data-code milik option yang dipilih
                const selectedOption = this.options[this.selectedIndex];
                const countryCode = selectedOption.getAttribute('data-code');
                phoneCodeSpan.textContent = countryCode;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // ... Script API Country yang sudah ada ...

            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const errorMsg = document.getElementById('password-error');
            const submitBtn = document.querySelector('button[type="submit"]');

            function validatePassword() {
                if (confirmPassword.value.length > 0) {
                    if (password.value !== confirmPassword.value) {
                        errorMsg.classList.remove('hidden');
                        confirmPassword.classList.add('border-red-500');
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        errorMsg.classList.add('hidden');
                        confirmPassword.classList.remove('border-red-500');
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                } else {
                    errorMsg.classList.add('hidden');
                    confirmPassword.classList.remove('border-red-500');
                }
            }

            password.addEventListener('keyup', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);
        });
    </script>
@endsection
