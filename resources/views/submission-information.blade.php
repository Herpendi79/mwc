@extends('layouts.main')

@section('title', 'Scientific Board Commitee')

@section('content')


    <div class="relative font-ibm">

        @include('partials.header.h-business')

        <!-- Banner section -->
        <section
            class="lg:py-70 py-40 lg:mx-7 mx-2 rounded-3xl bg-fixed bg-cover bg-center text-center text-white relative mt-5 md:mb-15 mb-10"
            style="background-image: url('{{ asset('assets/images/business/business-tm1.jpg') }}');">
            <div
                class="absolute bg-[radial-gradient(circle_at_left_bottom,transparent_20px,#fff_20px)] dark:bg-[radial-gradient(circle_at_left_bottom,transparent_20px,#000_20px)] size-7 2xl:-top-2 2xl:left-46 z-10 md:left-2 md:-top-1 -top-2 left-0">
            </div>
            <div
                class="absolute bg-[radial-gradient(circle_at_right_bottom,transparent_20px,#fff_20px)] dark:bg-[radial-gradient(circle_at_right_bottom,transparent_20px,#000_20px)] size-7 2xl:-top-2 2xl:right-46 z-10 md:right-2 md:-top-1 -top-2 right-0">
            </div>
            <div class="absolute inset-0 w-full h-full bg-black/30 rounded-3xl"></div>
            <div class="container relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="xl:text-7xl md:text-5xl leading-snug font-bold tracking-[1px] mb-4" data-sal="zoom-in"
                        data-sal-duration="800" data-sal-delay="200"> Submission Information</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">Give your attention for this section</p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Submission Information</p>
                    </div>
                </div>
            </div>
            <div class="absolute -bottom-22 left-1/2 -translate-x-1/2" data-sal="slide-up" data-sal-duration="800"
                data-sal-delay="200">
                <div id="scrollDownBtn"
                    class="relative w-40 h-40 flex items-center justify-center rounded-full bg-black dark:bg-white border-10 border-white dark:border-black cursor-pointer">
                    <img src="{{ asset('assets/images/event/icons8-arrow-down.gif') }}" alt="Scroll Down"
                        class="absolute w-10 h-10 invert dark:invert-0 z-10" />

                    <svg viewBox="0 0 100 100" class="w-full h-full absolute animate-[spin_12s_linear_infinite]">
                        <defs>
                            <path id="circlePath" d="M 50,50 m -36,0 a 36,36 0 1,1 72,0 a 36,36 0 1,1 -72,0" />
                        </defs>

                        <text font-size="6" font-weight="600" letter-spacing="2"
                            class="uppercase fill-white dark:fill-black">
                            <textPath href="#circlePath" startOffset="50%" text-anchor="middle" dominant-baseline="middle">
                                SCROLL DOWN • SCROLL DOWN • SCROLL DOWN •
                            </textPath>
                        </text>
                    </svg>
                </div>
            </div>

        </section>
        <!-- End Banner -->

        <!-- pricing section -->
        <section class="lg:py-30 py-20">
            <div class="container">
                <div class="max-w-3xl mx-auto text-center mb-15">
                    <p class="mb-2 font-medium uppercase tracking-[1px]" data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="100">// Submission Information</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                    </h2>
                </div>


                <div class="overflow-hidden rounded-3xl border border-gray-200 dark:border-white/10 shadow-xl bg-white dark:bg-zinc-900"
                    data-sal="slide-up" data-sal-duration="800">

                    <div class="p-8 md:p-10 text-center">
                        <!-- 1. Teks Informasi -->
                        <div class="max-w-3xl mx-auto mb-10">
                            <i class="ri-information-fill text-4xl text-[#c0f037] mb-4 inline-block"></i>
                            <p class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed font-medium">
                                "All papers will be peer reviewed. Paper length should be maximum seven pages including
                                figures, tables, references, and appendices. Please refer to authors guideline."
                            </p>
                        </div>

                        <!-- Container Tombol -->
                        <div class="flex flex-wrap justify-center gap-4">

                            <!-- 2. Button Upload (Register) -->
                            <a href="{{ url('/register') }}"
                                class="flex items-center gap-2 bg-[#c0f037] text-black font-bold py-4 px-8 rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-[#c0f037]/20 group">
                                <i
                                    class="ri-upload-cloud-2-line text-xl transition-transform group-hover:-translate-y-1"></i>
                                Upload Your File
                            </a>

                            <!-- 3. Button Download Template Abstract -->
                            <a href="https://drive.google.com/drive/folders/1LkQVSGcNTwWkOzgzBM46hxfB0R11uCVs?usp=sharing"
                                target="_blank"
                                class="flex items-center gap-2 bg-blue-600 text-white font-bold py-4 px-8 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">
                                <i class="ri-file-text-line text-xl"></i>
                                Abstract Template
                            </a>

                            <!-- 4. Button Download Template Full Paper -->
                            <a href="https://drive.google.com/drive/folders/1KVfdxxYWUJJBIb-f874R4DB4YmdNAIeg?usp=sharing"
                                target="_blank"
                                class="flex items-center gap-2 bg-red-500 text-white font-bold py-4 px-8 rounded-2xl hover:bg-red-600 transition-all shadow-lg shadow-red-500/20">
                                <i class="ri-file-pdf-line text-xl"></i>
                                Full Paper Template
                            </a>

                        </div>
                    </div>

                    <!-- Hiasan bawah (opsional) -->
                    <div class="h-2 bg-gradient-to-r from-[#c0f037] via-blue-600 to-red-500"></div>
                </div>
        </section>
        <!-- End pricing -->

        @include('partials.footer.f-business')

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/event-venue.js') }}" defer></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
