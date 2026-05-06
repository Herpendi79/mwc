@extends('layouts.main')

@section('title', 'Forgot Password')

@section('content')
    <style>
        /* Memastikan elemen tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }
    </style>

    <div class="relative font-ibm">
        <!-- items-start di mobile agar bisa scroll, items-center di desktop -->
        <section
            class="min-h-screen py-10 md:py-20 bg-cover bg-center relative flex items-start md:items-center justify-center"
            style="background-image: url('{{ asset('assets/images/event/event-coming-soon.jpg') }}'); background-attachment: fixed;">

            <!-- Overlay diturunkan ke 40% agar background jelas -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <div class="container relative z-50 px-4 mb-10 force-show">
                <!-- max-w-lg konsisten dengan form sign-in -->
                <div class="text-center rounded-3xl md:p-12 p-6 bg-white/20 backdrop-blur-md text-white max-w-lg mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <a href="{{ url('/') }}" class="inline-block mb-6 md:mb-8">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="h-10 md:h-12 mx-auto">
                    </a>

                    <h2 class="font-bold leading-snug mb-3 text-3xl md:text-4xl tracking-tight drop-shadow-md text-white">
                        Reset Password
                    </h2>
                    <p class="text-gray-200 mb-8 md:mb-10 text-base md:text-lg">Enter your email and we will send you a link
                        to reset your password.</p>
                    <!-- Notifikasi Sukses (Berhasil Kirim Password Baru) -->
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

                    <!-- Notifikasi Error (Email Tidak Ditemukan / Gagal API) -->
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

                    <!-- Notifikasi Error Validasi Input -->
                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded-xl mb-6 text-left">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="#" method="POST" class="space-y-5 md:space-y-6 text-left">
                        @csrf

                        <!-- Email -->
                        <div class="group">
                            <label class="block text-xs font-medium mb-2 ml-1 text-gray-200 uppercase tracking-wider">Email
                                Address</label>
                            <input type="email" name="email" placeholder="example@university.ac.id" required
                                class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 md:px-6 py-3.5 md:py-4 outline-none focus:border-[#c0f037] focus:bg-white/20 transition-all text-white text-base md:text-lg placeholder-gray-400">
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2 md:pt-4">
                            <button type="submit"
                                class="w-full bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-2xl shadow-xl transition-all transform hover:scale-[1.02] border border-white/10">
                                Send Reset Link
                            </button>
                        </div>
                    </form>

                    <!-- Important Note -->
                    <div class="mt-8 p-4 bg-black/20 rounded-2xl border border-white/10 text-left">
                        <p class="text-xs md:text-sm text-gray-200 leading-relaxed">
                            <span class="text-[#c0f037] font-bold">Note:</span>
                            The confirmation link to get your new password will be sent to your email.
                            <span class="text-white font-semibold">Please check your Inbox or Spam folder.</span>
                        </p>
                    </div>

                    <!-- Back to Login Link -->
                    <p class="mt-8 md:mt-10 text-gray-300 text-sm md:text-base mb-4">
                        Remember your password?
                        <a href="{{ url('/login') }}" class="text-[#c0f037] font-bold hover:underline ml-1">Sign In here</a>
                    </p>

                </div>
            </div>
        </section>
    </div>
@endsection
