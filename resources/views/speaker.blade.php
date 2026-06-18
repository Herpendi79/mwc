@extends('layouts.main')

@section('title', 'Speakers')

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
                        data-sal-duration="800" data-sal-delay="200"> Our Inspiring Speakers</h2>
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
                        <p>Speakers</p>
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
                        data-sal-delay="100">// Speakers</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                        Meet Our Conference Speakers Lineup
                    </h2>
                </div>
                <!-- Grid Container: 1 kolom (HP), 2 kolom (Tablet), 3 kolom (Desktop) -->
                <!-- Container Utama: Diberi max-w-5xl (sekitar 1024px) agar merapat ke tengah -->
                <div class="max-w-5xl mx-auto px-4 py-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">

                        <!-- Speaker 1: Prof. Stella Christie -->
                        <div class="w-full max-w-[280px]"> <!-- Lebar kartu diperkecil sedikit ke 280px agar lebih rapat -->
                            <div class="overflow-hidden rounded-2xl relative bg-[#9DD2CA] group" data-sal="slide-up"
                                data-sal-duration="800">
                                <img src="{{ asset('assets/images/speakers/brian.jpg') }}"
                                    alt="Prof. Brian Yuliarto, S.T., M.Eng., Ph.D." class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#9DD2CA] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Prof. Brian Yuliarto, S.T., M.Eng., Ph.D.</a>
                                    </h3>

                                    <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <!-- space-y-1 memberikan jarak antar baris -->
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Higher Education Policy
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Nanomaterials and Nanotechnology
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Advanced Materials Engineering
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Materials for Environmental and Health Applications
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Speaker 2 (Baris 1) -->
                        <div class="w-full max-w-[280px]">
                            <div class="overflow-hidden rounded-2xl relative bg-[#6AC3FF] group" data-sal="slide-up"
                                data-sal-duration="800" data-sal-delay="200">
                                <img src="{{ asset('assets/images/speakers/ahy.jpeg') }}"
                                    alt="Dr. Agus Harimurti Yudhoyono, M.Sc., M.P.A., M.A."
                                    class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#6AC3FF] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Dr. Agus Harimurti Yudhoyono, M.Sc., M.P.A., M.A.</a>
                                    </h3>

                                    <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Strategic Leadership
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Public Policy and Government Administration
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                International Relations and Diplomacy
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Crisis Management and Conflict Resolution
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                National Security and Defense
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Speaker 3: Prof. Dr. Tariq Zaman -->
                        <div class="w-full max-w-[280px]">
                            <div class="overflow-hidden rounded-2xl relative bg-[#FFBC51] group" data-sal="slide-up"
                                data-sal-duration="800" data-sal-delay="100">
                                <img src="{{ asset('assets/images/speakers/tariq.png') }}" alt="Prof. Dr. Tariq Zaman"
                                    class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#FFBC51] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Prof. Dr. Tariq Zaman, Ph.D.</a>
                                    </h3>
                                    <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                ICT for Development (ICT4D)
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Community-Based Co-Design
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Indigenous Knowledge Management
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Service Learning
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Internet Governance
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Speaker 4: Prof. Dr. H. Fasli Jalal Ph.D -->
                        <div class="w-full max-w-[280px]">
                            <div class="overflow-hidden rounded-2xl relative bg-[#6AC3FF] group" data-sal="slide-up"
                                data-sal-duration="800" data-sal-delay="200">
                                <img src="{{ asset('assets/images/speakers/Gemini_Generated_Image_d9k26qd9k26qd9k.jpeg') }}" alt="Prof. Dr. H. Fasli Jalal"
                                    class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#6AC3FF] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Prof. Dr. H. Fasli Jalal, Ph.D</a>
                                    </h3>
                                    <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Education Policy
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Human Resource Development
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Higher Education Management
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Educational Development Planning
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Economics of Education
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Speaker 5 (Baris 2) -->
                        <div class="w-full max-w-[280px]">
                            <div class="overflow-hidden rounded-2xl relative bg-[#6AC3FF] group" data-sal="slide-up"
                                data-sal-duration="800" data-sal-delay="200">
                                <img src="{{ asset('assets/images/speakers/aziz3.jpg') }}" alt="Prof. Aziz"
                                    class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#6AC3FF] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Prof. Dr. Mohamed Alkhuzamy Aziz, B.A., M.Sc., PhD.Sc</a>
                                    </h3>
                                   <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Cartography and spatial analysis
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Teaching and mentoring students
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                               Leadership and management abilities
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                               Research and analytical skills
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Speaker 6 (Baris 2) -->
                        <div class="w-full max-w-[280px]">
                            <div class="overflow-hidden rounded-2xl relative bg-[#6AC3FF] group" data-sal="slide-up"
                                data-sal-duration="800" data-sal-delay="200">
                                <img src="{{ asset('assets/images/speakers/ChatGPTImage19Jun202606.34.0.jpeg') }}"
                                    alt="Amy)"
                                    class="w-full h-auto object-cover">
                                <div
                                    class="bg-white dark:bg-black border rounded-xl p-4 overflow-hidden absolute bottom-4 left-1/2 transform -translate-x-1/2 w-[92%] h-24 group-hover:h-44 transition-all duration-500 shadow-lg">
                                    <h3
                                        class="font-bold hover:text-[#6AC3FF] transition-all duration-300 text-sm leading-tight">
                                        <a href="#!">Dr. Faith Valencia-Forrester, Ph.D</a>
                                    </h3>
                                    <div class="mt-4 text-left"> <!-- Menghapus flex agar list bisa turun ke bawah -->
                                        <p class="text-gray-700 dark:text-gray-400 text-[10px] font-bold">
                                            Expertise:
                                        </p>
                                        <ul class="list-disc ml-5 mt-1 space-y-1">
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Strategic Partnerships
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Work-integrated Learning Specialist
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Social Impact Projects
                                            </li>
                                            <li
                                                class="text-gray-700 dark:text-gray-400 text-[10px] font-medium leading-tight">
                                                Lawyer & Advocate
                                            </li>

                                        </ul>
                                    </div>
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
