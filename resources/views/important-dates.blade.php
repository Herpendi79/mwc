@extends('layouts.main')

@section('title', 'Important Dates')

@section('content')


    <div class="relative font-ibm">

        @include('partials.header.h-business')

        <!-- Banner section -->
        <section
            class="lg:py-70 py-40 lg:mx-7 mx-2 rounded-3xl bg-fixed bg-cover bg-center text-center text-white relative mt-5 md:mb-15 mb-10"
            style="background-image: url('{{ asset('assets/images/business/business-tm1.jpg') }}');">
            <div
                class="absolute bg-[radial-gradient(circle_at_left_bottom,transparent_20px,#fff_20px)]  dark:bg-[radial-gradient(circle_at_left_bottom,transparent_20px,#000_20px)] size-7 2xl:-top-2 2xl:left-46 z-10 md:left-2 md:-top-1 -top-2 left-0">
            </div>
            <div
                class="absolute bg-[radial-gradient(circle_at_right_bottom,transparent_20px,#fff_20px)] dark:bg-[radial-gradient(circle_at_right_bottom,transparent_20px,#000_20px)] size-7 2xl:-top-2 2xl:right-46 z-10 md:right-2 md:-top-1 -top-2 right-0">
            </div>
            <div class="absolute inset-0 w-full h-full bg-black/30 rounded-3xl"></div>
            <div class="container relative">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="xl:text-7xl md:text-5xl leading-snug font-bold tracking-[1px] mb-4" data-sal="zoom-in"
                        data-sal-duration="800" data-sal-delay="200">Important Dates</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">
                        Explore our full important dates to plan your day! Your innovative ideas and research can foster
                        collaborations and lead to phenomenal breakthroughs.
                    </p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ '/' }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Important Dates</p>
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

        <!-- Schedule section -->
        <section class="lg:py-30 py-20 overflow-hidden">
            <div class="container">
                    <div class="max-w-3xl mx-auto text-center mb-15">
                        <p class="mb-2 font-medium uppercase tracking-[1px]" data-sal="slide-right" data-sal-duration="800"
                            data-sal-delay="200">// Important Dates Highlights</p>
                        <h2 class="font-bold md:text-5xl leading-snug " data-sal="slide-right" data-sal-duration="800"
                            data-sal-delay="200">
                            Key dates in the Conference Journey
                        </h2>
                    </div>
                <!-- Tab Contents Container -->
                <div class="lg:mt-20 mt-5 space-y-10">

                    <!-- PANEL 1: June 15 - Abstract Deadline (Text Left, Image Right) -->
                    <div id="panel-1" class="tab-panel transition-all duration-500">
                        <div class="grid grid-cols-12 gap-6 border border-black/40 dark:border-white/40 rounded-2xl overflow-hidden"
                            data-sal="slide-right" data-sal-duration="800" data-sal-delay="200">
                            <div class="col-span-12 lg:col-span-7 p-7">
                                <p class="text-4xl font-bold mb-6">01</p>
                                <h3 class="md:text-4xl mb-4">Abstract Submission Deadline</h3>
                                <p class="md:text-[22px] text-gray-700 mb-6 dark:text-gray-400">
                                    Submit your research summary. Your innovative ideas can foster collaborations and lead
                                    to phenomenal breakthroughs.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <p class="bg-[#F8EBFF] rounded-full px-4 py-2 text-black"><i class="ri-time-line"></i>
                                        June 15, 2026</p>
                                    <a href="https://drive.google.com/drive/folders/1LkQVSGcNTwWkOzgzBM46hxfB0R11uCVs?usp=sharing"
                                        target="_blank" rel="noopener noreferrer"
                                        class="bg-[#FFFAD6] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#fce99a] transition-all duration-300">
                                        <i class="ri-download-2-line"></i>
                                        Download Template
                                    </a>
                                    <a href="register" target="_blank" rel="noopener noreferrer"
                                        class="bg-[#ADDBFF] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#fce99a] transition-all duration-300">
                                        <i class="ri-book-2-line"></i>
                                        Submite Abstract
                                    </a>
                                </div>
                            </div>
                            <div class="col-span-12 lg:col-span-5 h-80 lg:h-auto">
                                <img src="{{ asset('assets/images/important-dates/template.jpeg') }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- PANEL 2: June 22 - Acceptance Notification (Image Left, Text Right) -->
                    <div id="panel-2" class="tab-panel transition-all duration-500">
                        <div class="grid grid-cols-12 gap-6 border border-black/40 dark:border-white/40 rounded-2xl overflow-hidden"
                            data-sal="slide-left" data-sal-duration="800" data-sal-delay="200">
                            <div class="col-span-12 lg:col-span-5 h-80 lg:h-auto">
                                <img src="{{ asset('assets/images/important-dates/email.jpeg') }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="col-span-12 lg:col-span-7 p-7">
                                <p class="text-4xl font-bold mb-6">02</p>
                                <h3 class="md:text-4xl mb-4">Review Results & Acceptance</h3>
                                <p class="md:text-[22px] text-gray-700 mb-6 dark:text-gray-400">
                                    Official notification regarding your submission. Check your adaksi.org dashboard for
                                    reviewer feedback and status updates.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <p class="bg-[#F8EBFF] rounded-full px-4 py-2 text-black"><i class="ri-time-line"></i>
                                        June 22, 2026</p>
                                    <a href="https://mail.google.com" target="_blank" rel="noopener noreferrer"
                                        class="bg-[#FFFAD6] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#82CAFF] transition-all duration-300 w-fit">
                                        <i class="ri-mail-line"></i>
                                        Check Your Email
                                    </a>
                                    <a href="register" target="_blank" rel="noopener noreferrer"
                                        class="bg-[#ADDBFF] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#fce99a] transition-all duration-300">
                                        <i class="ri-user-2-line"></i>
                                        Login Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PANEL 3: June 26 - Conference Date (Samakan dengan Panel 1: Text Left, Image Right) -->
                    <div id="panel-3" class="tab-panel transition-all duration-500">
                        <div class="grid grid-cols-12 gap-6 border border-black/40 dark:border-white/40 rounded-2xl overflow-hidden"
                            data-sal="slide-right" data-sal-duration="800" data-sal-delay="200">
                            <div class="col-span-12 lg:col-span-7 p-7">
                                <p class="text-4xl font-bold mb-6">03</p>
                                <h3 class="md:text-4xl mb-4">Main Event: ICPIP-HE 2026</h3>
                                <p class="md:text-[22px] text-gray-700 mb-6 dark:text-gray-400">
                                    Join the grand conference at Best Western Senayan City Indonesia. A
                                    memorable experience wrapping up global insights.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <p class="bg-[#F8EBFF] rounded-full px-4 py-2 text-black"><i class="ri-time-line"></i>
                                        June 26, 2026</p>
                                    <a href="https://maps.app.goo.gl/fiCiqSzmwxSK58rF7" target="_blank" rel="noopener noreferrer"
                                        class="bg-[#FFFAD6] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#82CAFF] transition-all duration-300 w-fit">
                                        <i class="ri-map-pin-line"></i>
                                       Best Western Senayan City Hotel, Jakarta, Indonesia
                                    </a>
                                </div>
                            </div>
                            <div class="col-span-12 lg:col-span-5 h-80 lg:h-auto">
                                <!-- Menggunakan image yang serupa dengan style panel 1 -->
                                <img src="{{ asset('assets/images/important-dates/stc.avif') }}"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- PANEL 4: July 03 - Full Paper Submission (Samakan dengan Panel 2: Image Left, Text Right) -->
                    <div id="panel-4" class="tab-panel transition-all duration-500">
                        <div class="grid grid-cols-12 gap-6 border border-black/40 dark:border-white/40 rounded-2xl overflow-hidden"
                            data-sal="slide-left" data-sal-duration="800" data-sal-delay="200">
                            <div class="col-span-12 lg:col-span-5 h-80 lg:h-auto">
                                <img src="{{ asset('assets/images/important-dates/template2.jpeg') }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="col-span-12 lg:col-span-7 p-7">
                                <p class="text-4xl font-bold mb-6">04</p>
                                <h3 class="md:text-4xl mb-4">Final Full Paper Submission Deadline</h3>
                                <p class="md:text-[22px] text-gray-700 mb-6 dark:text-gray-400">
                                    Final step to refine your research into a phenomenal full paper for publication in our
                                    affiliated journals.
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    <p class="bg-[#F8EBFF] rounded-full px-4 py-2 text-black"><i class="ri-time-line"></i>
                                        July 03, 2026</p>
                                    <a href="register" target="_blank" rel="noopener noreferrer"
                                        class="bg-[#ADDBFF] rounded-full px-4 py-2 text-black flex items-center gap-2 hover:bg-[#fce99a] transition-all duration-300">
                                        <i class="ri-book-2-line"></i>
                                        Submite Full Paper
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    </div>
    </div>
    </div>
    </section>
    <!-- End Schedule -->

    @include('partials.footer.f-business')

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/event-venue.js') }}" defer></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection