@extends('layouts.main')

@section('title', 'Nearby Accommodation')

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
                        data-sal-duration="800" data-sal-delay="200"> Nearby Accommodation </h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">Here are several accommodation recommendations located near the conference
                        venue. Choose the best place to create the best moments during your stay in Jakarta and make the
                        conference experience more meaningful.</p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Nearby </p>
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
            <div class="container mx-auto px-4">

                <!-- Heading -->
                <div class="max-w-3xl mx-auto text-center mb-15">
                    <p class="mb-2 font-medium uppercase tracking-[1px]" data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="100">
                        // Nearby
                    </p>

                    <h2 class="font-bold md:text-5xl leading-snug" data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">

                        Choose Your Perfect Option for an Unforgettable Experience

                    </h2>
                </div>

                <!-- TABLE WRAPPER -->
                <div class="rounded-2xl border border-gray-200 dark:border-white/10 shadow-lg overflow-hidden"
                    data-sal="slide-up" data-sal-duration="800">

                    <!-- MOBILE INFO -->
                    <div class="md:hidden bg-[#065039] text-white text-center text-xs py-2">
                        Geser tabel ke kiri / kanan →
                    </div>

                    <!-- SCROLL AREA -->
                    <div class="overflow-x-auto w-full">

                        <table class="min-w-[1200px] w-full border-collapse bg-white dark:bg-[#1F1F1F] text-xs md:text-sm">

                            <!-- HEAD -->
                            <thead>
                                <tr class="bg-[#065039] text-white">

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        No
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Hotel Name
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Rating
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Address & Maps
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Distance to UI
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Phone Number
                                    </th>

                                    <th class="p-2 md:p-4 border border-white/20 text-center font-bold whitespace-nowrap">
                                        Est. Price
                                    </th>

                                </tr>
                            </thead>

                            <!-- BODY -->
                            <tbody class="text-gray-800 dark:text-gray-200">

                                <!-- ROW 1 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        1
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039] whitespace-nowrap">
                                        The Margo Hotel
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500 whitespace-nowrap">
                                        ★★★★
                                    </td>

                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">
                                        Margonda Raya St. No.358, Depok.
                                        <br>

                                        <a href="https://maps.app.goo.gl/9ZRE785k4C6YatX8A" target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">
                                            View on Maps
                                        </a>
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        1.2 KM
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        +62 21 29515888
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600 whitespace-nowrap">
                                        IDR 950.000++
                                    </td>

                                </tr>

                                <!-- ROW 2 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">

                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">
                                        2
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039] whitespace-nowrap">
                                        Hotel Santika Depok
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★
                                    </td>

                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">
                                        Margonda Raya St. Kav.88, Depok.
                                        <br>

                                        <a href="https://maps.app.goo.gl/9ZRE785k4C6YatX8A" target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">
                                            View on Maps
                                        </a>
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        3.0 KM
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        +62 21 77219291
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600 whitespace-nowrap">
                                        IDR 750.000++
                                    </td>

                                </tr>

                                <!-- ROW 3 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">

                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">
                                        3
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039] whitespace-nowrap">
                                        Savero Hotel Depok
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★
                                    </td>

                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">
                                        Margonda Raya St. No.230A, Depok.
                                        <br>

                                        <a href="https://maps.app.goo.gl/9ZRE785k4C6YatX8A" target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">
                                            View on Maps
                                        </a>
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        1.6 KM
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center whitespace-nowrap">
                                        +62 21 77802300
                                    </td>

                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600 whitespace-nowrap">
                                        IDR 650.000++
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>
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
