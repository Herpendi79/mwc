@extends('layouts.main')

@section('title', 'Schedule')

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
                        data-sal-duration="800" data-sal-delay="200"> Schedule</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">
                        Give your attendance a boost with our event schedule! Plan your day around our exciting lineup of
                        speakers and networking opportunities. Don't miss out on the chance to connect, learn, and grow with
                        fellow attendees. Check out the schedule now and make the most of your event experience!</p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Schedule</p>
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
                        data-sal-delay="100">// Schedule</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                        Please review the schedule
                        carefully to ensure you do not miss any valuable moments or experiences.
                    </h2>
                </div>


                <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-white/10 shadow-lg"
                    data-sal="slide-up" data-sal-duration="800">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#065039] text-white">
                                    <th
                                        class="p-4 border border-white/20 text-center font-bold uppercase tracking-wider w-[25%]">
                                        Time (GMT+7)
                                    </th>
                                    <th class="p-4 border border-white/20 text-center font-bold uppercase tracking-wider">
                                        Activities
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-[#1F1F1F] text-gray-800 dark:text-gray-200">
                                <!-- Registration -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        07.30 - 08.30
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10">
                                        <ul class="list-disc ml-5">
                                            <li>Participant Registration</li>
                                            <li>Presenter Registration</li>
                                        </ul>
                                    </td>
                                </tr>
                                <!-- Opening -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        08.30 - 08.45
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10">
                                        <ul class="list-none">
                                            <li>- Opening Ceremony</li>
                                            <li>- Singing National Anthem "Indonesia Raya"</li>
                                        </ul>
                                    </td>
                                </tr>
                                <!-- Welcoming Speech -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        08.45 - 09.15
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10">
                                        <span class="font-bold">Welcoming Speeches:</span>
                                        <ul class="list-disc ml-8 mt-2">
                                            <li>Rector of Universitas Indonesia (UI)</li>
                                            <li>Chairman of ADAKSI</li>
                                            <li>Opening Prayer</li>
                                        </ul>
                                    </td>
                                </tr>
                                <!-- Keynote 1 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        09.15 - 10.00
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 1
                                    </td>
                                </tr>
                                <!-- Keynote 2 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        10.00 - 10.45
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 2
                                    </td>
                                </tr>
                                <!-- Keynote 3 -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        10.45 - 11.30
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 3
                                    </td>
                                </tr>
                                <!-- Souvenir -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        11.30 - 11.45
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10">
                                        Token of Appreciation Ceremony & Documentation
                                    </td>
                                </tr>
                                <!-- Break -->
                                <tr class="bg-gray-100 dark:bg-white/5 italic">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold">
                                        11.45 - 13.00
                                    </td>
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-bold tracking-widest uppercase">
                                        Rest and Lunch Break
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        13.00 - 13.45
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 4
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        13.45 - 14.15
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 5
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        14.15 - 15.00
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-medium">
                                        Keynote Speaker 6
                                    </td>
                                </tr>
                                <!-- Parallel Session -->
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td
                                        class="p-4 border border-gray-200 dark:border-white/10 text-center font-semibold bg-gray-50/50 dark:bg-white/5">
                                        15.00 - 18.00
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10">
                                        <span class="font-bold text-[#065039] dark:text-green-400">Parallel Sessions:</span>
                                        <div class="grid grid-cols-2 md:grid-cols-3 mt-2 gap-2">
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 1
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 2
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 3
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 4
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 5
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 6
                                            </div>
                                            <div class="flex items-center gap-2"><i class="ri-door-open-line"></i> Room 7
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
