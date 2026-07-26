@extends('layouts.main')

@section('title', 'Sign In')

@section('content')
    <style>
        /* Memastikan elemen tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Penyesuaian tinggi tombol khusus */
        .py-4-5 {
            padding-top: 1.125rem;
            padding-bottom: 1.125rem;
        }

        /* Perbaikan input auto-fill agar tetap transparan */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: white !important;
            -webkit-box-shadow: 0 0 0px 1000px rgba(255, 255, 255, 0.1) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="relative font-ibm">
        <section
            class="min-h-screen py-10 md:py-20 bg-cover bg-center relative flex items-start md:items-center justify-center"
            style="background-image: url('{{ asset('assets/images/event/back.jpeg') }}'); background-attachment: fixed;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <div class="container relative z-50 px-4 mb-10 force-show">
                <div class="text-center rounded-3xl md:p-12 p-6 bg-white/20 backdrop-blur-md text-white max-w-lg mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <a href="{{ url('/') }}" class="inline-block mb-6 md:mb-8">
                        <img src="{{ asset('assets/images/logo/logo.webp') }}" alt="Logo" class="h-30 md:h-42 mx-auto">
                    </a>

                    <h2 class="font-bold leading-snug mb-2 text-3xl md:text-4xl tracking-tight drop-shadow-md">
                        Sign In
                    </h2>
                    <p class="text-gray-200 mb-8 md:mb-10 text-base md:text-lg">Welcome backsss! Access your dashboard.</p>

                    <!-- Google Sign In -->
                    <a href="{{ route('auth.google') }}"
                        class="flex items-center justify-center gap-4 w-full bg-white text-black font-bold py-3.5 md:py-4 px-6 rounded-2xl mb-6 md:mb-8 hover:bg-gray-100 transition-all transform hover:scale-[1.02] shadow-lg text-base md:text-lg text-center">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                            class="w-5 h-5 md:w-6 md:h-6" alt="Google Logo">
                        Continue with Google
                    </a>

                    <div class="relative flex items-center justify-center mb-6 md:mb-8">
                        <div class="flex-grow border-t border-white/20"></div>
                        <span class="flex-shrink mx-4 text-gray-300 text-xs uppercase tracking-[3px]">Or</span>
                        <div class="flex-grow border-t border-white/20"></div>
                    </div>

                    <!-- Notifikasi Status / Umum (Pesan dari Resend Email) -->
                    @if (session('message'))
                        <div
                            class="bg-blue-500/20 border border-blue-500 text-blue-100 px-4 py-3 rounded-xl mb-6 flex items-center shadow-lg text-left">
                            <svg class="w-5 h-5 mr-3 text-blue-400 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0116 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ session('message') }}</span>
                        </div>
                    @endif

                    <!-- Notifikasi Sukses (Untuk Verifikasi Email Berhasil) -->
                    @if (session('success'))
                        <div
                            class="bg-[#c0f037]/20 border border-[#c0f037] text-[#c0f037] px-4 py-3 rounded-xl mb-6 flex items-center shadow-lg text-left">
                            <svg class="w-5 h-5 mr-3 text-[#c0f037] shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            <span class="text-sm font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Notifikasi Error (Session Error dari Controller) -->
                    @if (session('error'))
                        <div
                            class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded-xl mb-6 flex items-center shadow-lg text-left">
                            <svg class="w-5 h-5 mr-3 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Error Validasi (Input Kosong, Format Salah, dll) -->
                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded-xl mb-6 text-left">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-5 md:space-y-6 text-left">
                        @csrf

                        <!-- Email -->
                        <div class="group">
                            <label
                                class="block text-xs font-medium mb-2 ml-1 text-gray-200 uppercase tracking-wider text-left">Email / Telpon
                        </label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                placeholder="example@university.ac.id" required
                                class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 md:px-6 py-3.5 md:py-4 outline-none focus:border-[#c0f037] focus:bg-white/20 transition-all text-white text-base md:text-lg placeholder-gray-400">
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <div class="flex justify-between items-center mb-2">
                                <label
                                    class="block text-xs font-medium ml-1 text-gray-200 uppercase tracking-wider">Password</label>
                                <a href="{{ url('forgot-password') }}"
                                    class="text-xs text-[#c0f037] hover:underline">Lupa Password?</a>
                            </div>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 md:px-6 py-3.5 md:py-4 outline-none focus:border-[#c0f037] focus:bg-white/20 transition-all text-white text-base md:text-lg placeholder-gray-400">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 md:pt-6">
                            <button type="submit"
                                class="w-full bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-2xl shadow-xl transition-all transform hover:scale-[1.02] border border-white/10">
                                Sign In to Account
                            </button>
                        </div>
                    </form>

                    <!-- Links -->
                    <div class="mt-8 md:mt-10 space-y-3">
                        <p class="text-gray-300 text-sm md:text-base">
                            Don't have an account?
                            <a href="{{ url('/register') }}" class="text-[#c0f037] font-bold hover:underline ml-1">Register
                                here</a>
                        </p>
                        <p class="text-gray-300 text-sm md:text-base">
                            Back to Home?
                            <a href="{{ url('/') }}" class="text-[#c0f037] font-bold hover:underline ml-1">Click
                                here</a>
                        </p>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
