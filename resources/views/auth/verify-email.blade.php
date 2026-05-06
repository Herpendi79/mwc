@extends('layouts.main')

@section('title', 'Verify Email')

@section('content')
    <style>
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }
    </style>

    <div class="relative font-ibm">
        <section
            class="min-h-screen py-10 md:py-20 bg-cover bg-center relative flex items-start md:items-center justify-center"
            style="background-image: url('{{ asset('assets/images/event/event-coming-soon.jpg') }}'); background-attachment: fixed;">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <div class="container relative z-50 px-4 mb-10 force-show">
                <div class="text-center rounded-3xl md:p-12 p-8 bg-white/20 backdrop-blur-md text-white max-w-2xl mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="inline-block mb-6 md:mb-8">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="h-10 md:h-12 mx-auto">
                    </a>

                    <!-- Icon Envelope -->
                    <div class="mb-6 flex justify-center">
                        <div class="w-20 h-20 bg-[#c0f037]/20 rounded-full flex items-center justify-center border border-[#c0f037]/30">
                            <svg class="w-10 h-10 text-[#c0f037]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>

                    <h2 class="font-bold leading-snug mb-4 text-3xl md:text-4xl tracking-tight drop-shadow-md">
                        Verify Your Email
                    </h2>
                    
                    <p class="text-gray-200 mb-8 text-sm md:text-base leading-relaxed">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you (inbox/spam)? If you didn't receive the email, we will gladly send you another.
                    </p>

                    <!-- Status Success Message -->
                    @if (session('message') == 'Verification link sent!')
                        <div class="bg-[#c0f037]/20 border border-[#c0f037] text-[#c0f037] px-4 py-3 rounded-xl mb-8 text-sm font-semibold">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                        <!-- Form Resend Verification -->
                        <form method="POST" action="{{ route('verification.send') }}" class="w-full md:w-auto">
                            @csrf
                            <button type="submit"
                                class="w-full md:px-8 bg-[#065039] hover:bg-[#086347] text-white font-bold py-3.5 rounded-xl shadow-lg transition-all transform hover:scale-[1.02] active:scale-[0.98] border border-white/10">
                                Resend Verification Email
                            </button>
                        </form>

                        <!-- Form Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                            @csrf
                            <button type="submit"
                                class="w-full md:px-8 bg-white/10 hover:bg-white/20 text-white font-bold py-3.5 rounded-xl border border-white/30 transition-all">
                                Log Out
                            </button>
                        </form>
                    </div>

                    <p class="mt-10 text-xs text-gray-400">
                        &copy; 2026 ICPIP-HE ADAKSI. <br class="md:hidden"> Politeknik Negeri Tanah Laut.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection