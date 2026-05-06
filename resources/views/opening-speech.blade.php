@extends('layouts.main')

@section('title', 'Opening Speech')

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
                        data-sal-duration="800" data-sal-delay="200"> Our Inspiring Opening Speaker</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">
                        Get to know the visionary speakers who will lead our event with powerful ideas,
                        industry insights, and practical knowledge. Learn about their backgrounds,
                        session topics, and the perspectives they bring.
                    </p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Opening Speakers</p>
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

        <!-- speaker section -->
        <section class="lg:py-30 py-20">
            <div class="container">
                <div class="max-w-3xl mx-auto text-center mb-15">
                    <p class="mb-2 font-medium uppercase tracking-[1px]" data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="100">// Opening Speakers</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                        Meet Our Conference Opening Speakers
                    </h2>
                </div>
                <div class="flex justify-center">
                    <!-- Menggunakan lebar tetap w-72 (288px) agar konsisten di semua layar -->
                    <div class="mx-auto w-144">
                        <div class="overflow-hidden rounded-xl relative bg-[#9DD2CA] group" data-sal="slide-up"
                            data-sal-duration="800" data-sal-delay="200">
                            <img src="{{ asset('assets/images/speakers/rektorui.jpg') }}" alt="" class="w-full">
                            <div
                                class="bg-white dark:bg-black border rounded-lg p-4 overflow-hidden absolute bottom-5 left-1/2 transform -translate-x-1/2 w-[90%] h-23 group-hover:h-40 transition-all duration-500">
                                <h3 class=" font-bold hover:text-[#9DD2CA] transition-all duration-300">
                                    <a href="#!">Prof. Dr. Ir. Heri Hermansyah, S.T., M.Eng., IPU</a>
                                </h3>
                                <p class="text-gray-700 dark:text-gray-400">Rector of Universitas Indonesia (in confirmation)</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <a href="https://www.youtube.com/@herihermansyah_ui/featured" target="_blank"
                                        class="size-10 hover:bg-[#9DD2CA] border border-b-3 border-r-3 transition-all duration-300 rounded-full flex items-center justify-center">
                                        <i class="ri-youtube-fill"></i>
                                    </a>

                                    <a href="https://www.instagram.com/heri.hrmansyah/" target="_blank"
                                        class="size-10 hover:bg-[#F6A5C0] border border-b-3 border-r-3 transition-all duration-300 rounded-full flex items-center justify-center">
                                        <i class="ri-instagram-fill"></i>
                                    </a>

                                    <a href="https://www.linkedin.com/in/heri-hermansyah-7888a4a6/" target="_blank"
                                        class="size-10 hover:bg-[#D4B9FF] border border-b-3 border-r-3 transition-all duration-300 rounded-full flex items-center justify-center">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End speaker -->

        @include('partials.footer.f-business')

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/event-venue.js') }}" defer></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
