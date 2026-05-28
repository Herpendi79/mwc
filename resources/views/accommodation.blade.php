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
                        Swipe left / right →
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
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Hotel Mulia Senayan</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Asia Afrika, Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Hotel+Mulia+Senayan"
                                            target="_blank" class="text-blue-600 hover:underline italic font-semibold">View
                                            on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.5 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        5747777</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 2.500.000++</td>
                                </tr>

                                <!-- ROW 2 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">2</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Fairmont Jakarta</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Asia Afrika No.8, Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Fairmont+Jakarta"
                                            target="_blank" class="text-blue-600 hover:underline italic font-semibold">View
                                            on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.6 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        29703333</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 3.200.000++</td>
                                </tr>

                                <!-- ROW 3 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">3</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        The Ritz-Carlton Pacific Place</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">SCBD,
                                        Jl. Jend. Sudirman.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Ritz+Carlton+Pacific+Place"
                                            target="_blank" class="text-blue-600 hover:underline italic font-semibold">View
                                            on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.5 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        25501888</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 3.500.000++</td>
                                </tr>

                                <!-- ROW 4 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">4</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Alila SCBD Jakarta</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">SCBD
                                        Lot 11, Jl. Jend. Sudirman.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Alila+SCBD+Jakarta"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.2 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        50808777</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 2.800.000++</td>
                                </tr>

                                <!-- ROW 5 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">5</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Century Park Hotel</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Pintu Satu Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Century+Park+Hotel+Senayan"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.2 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        5712041</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 1.200.000++</td>
                                </tr>

                                <!-- ROW 6 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">6</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Harris Suites fX Sudirman</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">fX
                                        Sudirman, Jl. Jend. Sudirman.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Harris+Suites+fX+Sudirman"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.8 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        25554333</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 1.100.000++</td>
                                </tr>

                                <!-- ROW 7 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">7</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        The Sultan Hotel & Residence</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Gatot Subroto, Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=The+Sultan+Hotel+Jakarta"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.0 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        5703600</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 1.400.000++</td>
                                </tr>

                                <!-- ROW 8 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">8</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Hotel Atlet Century Park</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Pintu Satu Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Hotel+Atlet+Century+Park"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.3 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">-</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 1.050.000++</td>
                                </tr>

                                <!-- ROW 9 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">9</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        AYANA Midplaza Jakarta</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Jend. Sudirman Kav 10-11.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=AYANA+Midplaza+Jakarta"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">2.0 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        2510888</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 2.100.000++</td>
                                </tr>

                                <!-- ROW 10 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">10</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        The Langham, Jakarta</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">
                                        District 8, SCBD.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=The+Langham+Jakarta"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.7 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        27087888</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 4.000.000++</td>
                                </tr>

                                <!-- ROW 11 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">11</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Hotel Senayan (eLo)</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Tentara Pelajar, Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Hotel+Senayan+Jakarta"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.5 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">-</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 700.000++</td>
                                </tr>

                                <!-- ROW 12 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">12</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        favehotel Gatot Subroto</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Gatot Subroto.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=favehotel+Gatot+Subroto"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">2.5 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">+62 21
                                        29419444</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 550.000++</td>
                                </tr>

                                <!-- ROW 13 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">13</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Hotel 88 Grogol (Senayan Area)</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Area
                                        Slipi/Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Hotel+88+Senayan"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">2.8 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">-</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 450.000++</td>
                                </tr>

                                <!-- ROW 14 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">14</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        Artotel Gelora Senayan</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        ★★★</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Jl.
                                        Gelora, Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=Artotel+Gelora+Senayan"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">0.4 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">-</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 900.000++</td>
                                </tr>

                                <!-- ROW 15 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">15</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 font-bold text-[#065039]">
                                        RedDoorz near Senayan City</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center text-yellow-500">
                                        GH</td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 min-w-[280px]">Area
                                        Permata Hijau/Senayan.<br>
                                        <a href="https://www.google.com/maps/search/?api=1&query=RedDoorz+near+Senayan+City"
                                            target="_blank"
                                            class="text-blue-600 hover:underline italic font-semibold">View on Maps</a>
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">1.9 KM
                                    </td>
                                    <td class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center">-</td>
                                    <td
                                        class="p-2 md:p-3 border border-gray-200 dark:border-white/10 text-center font-bold text-green-600">
                                        IDR 300.000++</td>
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
