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
            style="background-image: url('{{ asset('assets/images/event/event-coming-soon.jpg') }}'); background-attachment: fixed;">

            <!-- Overlay diturunkan ke 40% (bg-black/40) agar background terlihat jelas -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <!-- Margin bottom ditambahkan agar tidak mentok di layar HP saat scroll -->
            <div class="container relative z-50 px-4 mb-10 force-show">

                <!-- Padding dan Gap disesuaikan untuk Mobile (p-6) dan Desktop (md:p-12) -->
                <div class="text-center rounded-3xl md:p-12 p-6 bg-white/20 backdrop-blur-md text-white max-w-3xl mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <a href="{{ url('/') }}" class="inline-block mb-4 md:mb-6">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="h-10 md:h-12 mx-auto">
                    </a>

                    <h2 class="font-bold leading-snug mb-2 text-3xl md:text-5xl tracking-tight drop-shadow-md">
                        Create Account
                    </h2>
                    <p class="text-gray-200 mb-8 md:mb-10 text-sm md:text-base">Join our international community. Please
                        fill out the form below.</p>

                    <!-- Tambahkan ini di atas tag <form> -->
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

                    <form action="{{ route('registerPeserta.post') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 text-left">
                        @csrf
                        <!-- Full Name -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Full Name (for
                                certificate)</label>
                            <input type="text" name="name" placeholder="Enter your full name" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white placeholder-gray-400">
                        </div>

                        <!-- Email -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Email Address</label>
                            <input type="email" name="email" placeholder="example@university.ac.id" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white placeholder-gray-400">
                        </div>

                        

                        <!-- Country Dropdown -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Country</label>
                            <div class="relative">
                                <select id="countrySelect" name="country" required
                                    class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white appearance-none cursor-pointer">
                                    <option value="" class="text-black" disabled selected>Select Country</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-white">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Number -->
                        <div class="col-span-1">
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">WhatsApp Number</label>
                            <!-- Gunakan flex agar elemen berdampingan secara otomatis -->
                            <div
                                class="flex items-center bg-white/10 border border-white/30 rounded-xl overflow-hidden focus-within:border-[#c0f037] transition-all">
                                <!-- Bagian Kode Negara -->
                                <div class="pl-4 pr-2 border-r border-white/20 flex items-center justify-center">
                                    <span id="phoneCode"
                                        class="text-[#c0f037] font-bold text-sm md:text-base whitespace-nowrap">+..</span>
                                </div>

                                <!-- Bagian Input Angka (Hapus padding-left raksasa) -->
                                <input type="number" id="whatsappInput" name="whatsapp" placeholder="812xxxx" required
                                    class="w-full bg-transparent border-none px-4 py-3 md:py-3.5 outline-none focus:ring-0 text-white placeholder-gray-400 text-sm md:text-base">
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
                            <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="••••••••" required
                                class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white">
                            <!-- Pesan Error Password -->
                            <p id="password-error" class="text-red-400 text-xs mt-2 hidden">Passwords do not match!</p>
                        </div>
                        <p class="col-span-1 md:col-span-2">*The password field must be at least 8
                            characters.</p>

                        <!-- Submit Button -->
                        <div class="col-span-1 md:col-span-2 w-full flex justify-center mt-6 md:mt-8">
                            <button type="submit"
                                class="w-full md:w-3/4 lg:w-1/2 bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-xl shadow-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] border border-white/10">
                                Register Now
                            </button>
                        </div>
                    </form>

                    <!-- Sign In Link - Ditambahkan mb-4 untuk ruang di mobile -->
                    <p class="mt-8 text-gray-300 text-sm md:text-base mb-4">
                        Already have an account?
                        <a href="{{ url('/login') }}" class="text-[#c0f037] font-bold hover:underline">Sign In here</a>
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
