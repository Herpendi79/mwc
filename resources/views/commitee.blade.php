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
                        data-sal-duration="800" data-sal-delay="200"> Scientific Board Commitee</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">Our Scientific Board Commitee and their affiliate</p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>SBC</p>
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
                        data-sal-delay="100">// Scientific Board Commitee</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                    </h2>
                </div>


                <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-white/10 shadow-lg"
                    data-sal="slide-up" data-sal-duration="800">
                    <div class="overflow-x-auto">
                        <table
                            class="w-full text-left border-collapse overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-white/10">
                            <thead>
                                <tr class="bg-[#065039] text-white">
                                    <th class="p-4 border border-white/20 font-bold uppercase tracking-wider text-sm">
                                        Name
                                    </th>
                                    <th class="p-4 border border-white/20 font-bold uppercase tracking-wider text-sm">
                                        Affiliate
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-[#1F1F1F] text-gray-800 dark:text-gray-200">

                                {{-- Row 2 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Professor M. Anshari
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Universiti Brunei Darussalam, Brunei
                                    </td>
                                </tr>

                                {{-- Row 3 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Professor Dr. Tien-Chin Wang
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Professor in the Department of International Business, National Kaohsiung University
                                        of Science and Technology, Taiwan.
                                    </td>
                                </tr>

                                {{-- Row 4 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Professor Lee-Anne C Johennesse
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Southern Taiwan University of Science and Technology, Taiwan
                                    </td>
                                </tr>
                                {{-- Row 1 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Emmanuel Kyei, M.A., Ph.D
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Akenten Appiah-Menka University, Cameroon
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Dr. Wenny Hawariyuni
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Buraimi University, Oman
                                    </td>
                                </tr>



                                {{-- Row 5 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Dean Khan
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        National Kaohsiung University of Science and Technology (NKUST), Taiwan
                                    </td>
                                </tr>

                                {{-- Row 6 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Dustin T. Loreno
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Western Philippines University, Palawan, Philippines
                                    </td>
                                </tr>

                                {{-- Row 7 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Chingwen Kao (Angel)
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        CEO Lascus Art Studio, Tainan, Taiwan
                                    </td>
                                </tr>

                                {{-- Row 8 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Shabir Hussain Malik
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        National Chung Cheng University (CCU), Taiwan
                                    </td>
                                </tr>
                                {{-- Row 9 --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Dr. Anang Kadarsah. S.Si M.Si.
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Lambung Mangkurat University, Indonesia
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="p-4 border border-gray-200 dark:border-white/10 font-bold">
                                        Dr. Ir. Pandi Barita Nauli Simangunsong, S.Kom., M.Kom
                                    </td>
                                    <td class="p-4 border border-gray-200 dark:border-white/10 text-sm italic">
                                        Saint Thomas Catholic University, Indonesia
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
