@extends('layouts.main')

@section('title', 'ADAKSI')

@section('content')
    <div class="relative bg-[#032530]">

        @include('partials.header.h-business')

        <!-- Home section -->
        <section
            class="relative lg:pt-30 lg:pb-0 pb-10 pt-30 text-white bg-[url('{{ asset('assets/images/business/business-home-bg.jpg') }}')] bg-cover overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(100deg,#032530f2_26%,#0325306e_68%)]"></div>
            <img src="{{ asset('assets/images/business/business-home-shape.jpg') }}" alt=""
                class="absolute inset-0 opacity-60 hidden xl:block">

            <div class="lg:px-20 px-5 relative z-10">
                <div dir="ltr" class="swiper heroswiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-6 items-center">
                                <div class="col-span-12 2xl:col-span-8">
                                    <h1 class="xl:text-[clamp(60px,14vw,130px)] md:text-6xl md:mb-7 mb-4 leading-[100%] uppercase font-bold text-transparent [-webkit-text-stroke:2px_#fff]"
                                        data-sal="flip-up" data-sal-duration="1000" data-sal-delay="200">
                                        ICPIP-HE 2026
                                    </h1>

                                    <h2 class="lg:text-7xl md:text-5xl font-sail font-medium leading-[1.2]">
                                        International Conference on <span
                                            class="bg-white/20 backdrop-blur-sm md:px-5 px-4 md:p-1 inline-block border border-[#c0f037]">Policy,
                                            Innovation, and Practice</span> in Higher Education
                                    </h2>

                                    <div
                                        class="flex md:mt-10 mt-4 md:gap-10 gap-5 items-center mb-10 flex-wrap md:flex-nowrap text-white">
                                        <div class="text-center">
                                            <h3 class="lg:text-8xl md:text-6xl text-4xl font-bold" id="cd-days">00</h3>
                                            <p class="text-sm md:text-base font-medium opacity-80">Days</p>
                                        </div>

                                        <span class="lg:text-6xl md:text-4xl text-2xl font-bold mb-6">:</span>

                                        <div class="text-center">
                                            <h3 class="lg:text-8xl md:text-6xl text-4xl font-bold" id="cd-hours">00</h3>
                                            <p class="text-sm md:text-base font-medium opacity-80">Hour</p>
                                        </div>

                                        <span class="lg:text-6xl md:text-4xl text-2xl font-bold mb-6">:</span>

                                        <div class="text-center">
                                            <h3 class="lg:text-8xl md:text-6xl text-4xl font-bold" id="cd-minutes">00</h3>
                                            <p class="text-sm md:text-base font-medium opacity-80">Minute</p>
                                        </div>

                                        <span class="lg:text-6xl md:text-4xl text-2xl font-bold mb-6">:</span>

                                        <div class="text-center">
                                            <h3 class="lg:text-8xl md:text-6xl text-4xl font-bold" id="cd-seconds">00</h3>
                                            <p class="text-sm md:text-base font-medium opacity-80">Second</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center lg:gap-12 gap-5 ps-3 flex-wrap md:flex-nowrap">
                                        <a href="register"
                                            class="btn text-lg rounded-none group border hover:border-[#c0f037] hover:text-[#c0f037] text-black tracking-[1px] uppercase font-medium relative transition-all duration-300 bg-[#c0f037] hover:bg-transparent inline-block hover:rotate-2">
                                            Join Conference
                                            <span
                                                class="group-hover:bg-[#c0f037] size-3 rotate-45 block absolute ltr:-left-1 rtl:-right-1 -top-1 transition-all duration-300 group-hover:scale-125 bg-white"></span>
                                        </a>

                                        <div class="flex lg:gap-10 flex-wrap md:flex-nowrap gap-3">
                                            <p><i class="ri-calendar-check-fill me-1"></i> 26 June 2026</p>
                                            <div class="border border-white/50"></div>
                                            <p><i class="ri-map-pin-line me-1"></i> Best Western Senayan City Hotel,
                                                Jakarta,
                                                Indonesia</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-12 xl:col-span-4">
                                    <img src="{{ asset('assets/images/speakers/jon5.png') }}" alt=""
                                        class="w-full h-full object-cover 2xl:block hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end  home-->

        <!-- About section -->
        <section class="lg:py-30 lg:pb-45 py-20 text-white">
            <div class="container">
                <div class="grid grid-cols-12 gap-6 items-center">
                    <div class="col-span-12 xl:col-span-5" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                        <div class="relative z-10 inline-block xl:w-full xl:h-200 md:w-160 md:h-130 w-full h-full">
                            <img src="{{ asset('assets/images/about/business-about-person2.JPG') }}" alt=""
                                class="w-full object-cover rounded-lg h-full relative">
                            <div
                                class="absolute -bottom-15 ltr:-right-19 rtl:-left-19 border-13 border-[#032530] rounded-lg size-80 md:block hidden">
                                <img src="{{ asset('assets/images/about/business-about-person1.jpeg') }}" alt=""
                                    class="w-full h-full object-cover rounded-lg">
                            </div>
                            <img src="{{ asset('assets/images/business/business-about-circle.png') }}" alt=""
                                class="absolute -bottom-30 ltr:-left-30 rtl:-right-30 -z-10 xl:block hidden">
                        </div>
                    </div>
                    <div class="col-span-12 xl:col-span-6 xl:col-end-13" data-sal="slide-up" data-sal-duration="700"
                        data-sal-delay="100">
                        <p class="mb-2 text-[#c0f037] text-xs font-semibold uppercase tracking-wider">[ About ICPIP-HE 2026]
                        </p>

                        <h4 class="text-2xl font-medium leading-tight mb-4">
                            "Transforming Higher Education through Policy Reform, Innovative Practices, and Global
                            Collaboration"
                        </h4>

                        <!-- Scope 1 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 1 – Policy Reform in Higher Education</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Higher education policy and governance reform • Quality assurance and accreditation
                                systems • Inclusive and equitable access to higher education • Higher education financing
                                and sustainability • University autonomy and institutional accountability • Policy responses
                                to globalization and digital disruption • Leadership and strategic management in higher
                                education • Comparative higher education policies across countries
                            </p>
                        </div>

                        <!-- Scope 2 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 2 – Innovative Teaching and Learning
                                Practices</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Innovative pedagogical approaches in higher education • Artificial Intelligence (AI) in
                                teaching and learning • Blended learning and online education • Outcome-Based Education
                                (OBE) implementation • Project-based and experiential learning • Gamification and
                                interactive learning technologies • Student-centered learning environments • Assessment and
                                evaluation innovations • 21st-century skills and future-ready graduates
                            </p>
                        </div>

                        <!-- Scope 3 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 3 – Global Collaboration and
                                Internationalization</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • International academic partnerships and networking • Student and faculty mobility programs
                                • Collaborative international research initiatives • Internationalization of curriculum and
                                instruction • Cross-cultural communication in higher education • Global citizenship
                                education • Double degree and joint degree programs • Challenges and opportunities in higher
                                education internationalization
                            </p>
                        </div>

                        <!-- Scope 4 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 4 – Research, Innovation, and Knowledge
                                Transfer</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Research culture and productivity in universities • Interdisciplinary and
                                multidisciplinary research collaboration • Innovation ecosystems in higher education •
                                Knowledge transfer and commercialization of research • Research publication and academic
                                visibility • Open science and research ethics • University-industry collaboration • Emerging
                                technologies and innovation research
                            </p>
                        </div>

                        <!-- Scope 5 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 5 – Sustainability and Social Impact</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Higher education and Sustainable Development Goals (SDGs) • Green campus initiatives and
                                environmental sustainability • Community engagement and service learning • Inclusive
                                education and social justice • Education for sustainable development (ESD) • Universities’
                                role in addressing social challenges • Cultural sustainability and local wisdom in education
                                • Ethical leadership and social responsibility
                            </p>
                        </div>

                        <!-- Scope 6 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 6 – Digital Transformation in Higher
                                Education</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Digital transformation strategies in universities • Learning management systems and
                                educational platforms • Big data and learning analytics • Artificial Intelligence and
                                adaptive learning systems • Cybersecurity and digital ethics in education • Smart campus and
                                digital administration • Virtual reality (VR) and augmented reality (AR) in education •
                                Digital literacy for educators and students
                            </p>
                        </div>

                        <!-- Scope 7 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 7 – Professional Development and Academic
                                Leadership</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Faculty professional development and training • Academic leadership in the digital era •
                                Teacher identity and academic professionalism • Well-being and resilience among educators •
                                Leadership innovation in higher education institutions • Human resource development in
                                universities • Mentoring and coaching for academic staff • Change management and
                                institutional transformation
                            </p>
                        </div>

                        <!-- Scope 8 -->
                        <div class="mb-3">
                            <p class="text-white font-bold text-sm mb-0.5">Scope 8 – Multidisciplinary Perspectives in
                                Higher Education</p>
                            <p class="text-gray-400 text-xs leading-relaxed">
                                • Interdisciplinary curriculum development • Arts, humanities, science, and technology
                                integration • Multidisciplinary approaches to global issues • Innovation through
                                cross-disciplinary collaboration • Multilingual education and global communication
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- end about -->

        <!-- Sponsors -->
        <section class="bg-[#0B2C36] lg:py-30 py-20">
            <div class="container">
                <div class="max-w-3xl mx-auto text-center mb-15">
                    <p class="mb-3 text-[#c0f037]" data-sal="slide-up" data-sal-duration="1000" data-sal-delay="100"> [
                        Supported By ]</p>
                    <h2 class="text-white font-chivo font-medium md:text-5xl leading-[1.2]" data-sal="slide-up"
                        data-sal-duration="1000" data-sal-delay="200">Trusted by Growing Organizations
                    </h2>
                </div>
            </div>
            <div dir="ltr" class="swiper sponsorSwiper">
                <div class="swiper-wrapper ps-4">
                    @foreach ([1, 2, 3, 6, 7, 8, 9, 10] as $id)
                        <div class="swiper-slide">
                            <a href="register"
                                class="bg-white/15 backdrop-blur-sm w-full h-60 rounded-xl flex items-center justify-center">
                                <img src="{{ asset('assets/images/sponsor/freelancer-sponsor-' . $id . '.png') }}"
                                    alt="" class="invert mx-auto">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Speakers -->
        <section class="lg:py-30 py-20 text-white text-center">
            <div class="container">

                <!-- TITLE -->
                <div class="text-center max-w-3xl mx-auto mb-15">
                    <p class="mb-3 text-[#c0f037]">[ Meet the Experts ]</p>
                    <h2 class="md:text-5xl font-chivo font-medium leading-[1.2]">
                        To provide in-depth insights for participants
                    </h2>
                </div>

                <!-- CONTAINER UTAMA -->
                <!-- Menggunakan grid-cols-1 (HP), md:grid-cols-2 (Tablet), dan lg:grid-cols-3 (Desktop) -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-16 justify-items-center max-w-7xl mx-auto">

                    <!-- SPEAKER 1 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/brian2.jpg') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/byuliart/" target="_blank">Prof. Brian Yuliarto,
                                    S.T., M.Eng., Ph.D.</a>
                            </h3>
                            <p class="text-gray-400 mt-1">Minister of Higher Education, Scince and Technology</p>
                        </div>
                    </div>


                    <!-- SPEAKER 2 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/ahy2.jpeg') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/agus-harimurti-yudhoyono-455a89245/"
                                    target="_blank">Dr. Agus Harimurti Yudhoyono, M.Sc., M.P.A., M.A.</a>
                            </h3>
                            <p class="text-gray-400 mt-1">Coordinating Minister for Infrastructure and Teritorial
                                Development</p>
                        </div>
                    </div>

                    <!-- SPEAKER 3 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/tariq.png') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/tariq-zaman-21733413/">Prof. Dr. Tariq Zaman</a>
                            </h3>
                            <p class="text-gray-400 mt-1">University of Technology Sarawak, Malaysia</p>
                        </div>
                    </div>


                    <!-- SPEAKER 4 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/faslii.jpeg') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/fasli-jalal-ba607446/" target="_blank">Prof. Dr. H.
                                    Fasli Jalal, Ph.D</a>
                            </h3>
                            <p class="text-gray-400 mt-1">Former Vice Minister of Education</p>
                        </div>
                    </div>

                    <!-- SPEAKER 5 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/aziz2.jpg') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/mohamed-alkhuzamy-aziz/" target="_blank">Prof. Dr.
                                    Mohamed Alkhuzamy Aziz, B.A., M.Sc., PhD.Sc</a>
                            </h3>
                            <p class="text-gray-400 mt-1">Fayoum University, Egypt</p>
                        </div>
                    </div>

                    <!-- SPEAKER 6 -->
                    <div class="text-center group">
                        <div class="relative w-68 h-68 mx-auto">
                            <img src="{{ asset('assets/images/business/business-team-shape.png') }}"
                                class="absolute inset-0 w-full h-full object-contain scale-110 pointer-events-none transition-transform duration-500 group-hover:rotate-6">
                            <div
                                class="relative w-full h-full rounded-full border border-[#E6E8E7] overflow-hidden transition-transform duration-500 group-hover:-translate-y-2">
                                <img src="{{ asset('assets/images/speakers/faith.jpeg') }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-lg hover:text-[#c0f037] transition-colors">
                                <a href="https://www.linkedin.com/in/faithvalencia/" target="_blank">Dr. Faith Valencia-Forrester, Ph.D</a>
                            </h3>
                            <p class="text-gray-400 mt-1">Charles Sturt University, Australia</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- schedule section -->
        <section class="lg:py-30 py-20 relative text-white bg-[#0B2C36]">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-15">
                    <p class="mb-3 text-[#c0f037]" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">[
                        Important Dates ]</p>
                    <h2 class="md:text-5xl font-chivo font-medium leading-[1.2]" data-sal="slide-up"
                        data-sal-duration="700" data-sal-delay="200">Give more attention</h2>
                </div>

                <!-- Tabs -->
                <nav aria-label="Tabs">
                    <ul role="tablist" class="flex gap-6 justify-center flex-wrap" data-sal="slide-up"
                        data-sal-duration="800" data-sal-delay="300">
                        <li role="presentation">
                            <button role="tab" aria-selected="true" id="tab-1"
                                class="tab-btn px-16 py-5 bg-white/10 backdrop-blur-sm text-white rounded-lg font-medium transition-all">
                                <div class="flex items-center gap-4">
                                    <p class="mb-0 text-gray-500 line-through">June 15, 2026</p>
                                    <p class="mb-0 text-[#c0f037]">June 20, 2026</p>
                                </div>
                                <h4 class="text-3xl">Abstract deadline</h4>
                            </button>
                        </li>
                        <li role="presentation">
                            <button role="tab" aria-selected="false" id="tab-2"
                                class="tab-btn px-16 py-5 bg-white/10 backdrop-blur-sm text-white rounded-lg font-medium transition-all">
                                <p class="mb-2 text-[#c0f037]">June 22, 2026</p>
                                <h2 class="text-3xl">Acceptance notification</h2>
                            </button>
                        </li>
                        <li role="presentation">
                            <button role="tab" aria-selected="false" id="tab-3"
                                class="tab-btn px-16 py-5 bg-white/10 backdrop-blur-sm text-white rounded-lg font-medium transition-all">
                                <p class="mb-2 text-[#c0f037]">June 26, 2026</p>
                                <h2 class="text-3xl">Conference date</h2>
                            </button>
                        </li>
                        <li role="presentation">
                            <button role="tab" aria-selected="false" id="tab-4"
                                class="tab-btn px-16 py-5 bg-white/10 backdrop-blur-sm text-white rounded-lg font-medium transition-all">
                                <p class="mb-2 text-[#c0f037]">July 03, 2026</p>
                                <h2 class="text-3xl">Full paper submission</h2>
                            </button>
                        </li>
                    </ul>
                </nav>

                <!-- Tab Content -->
                <div class="lg:mt-20 mt-5">
                    <div id="panel-1" role="tabpanel" class="transition-all duration-500 opacity-0 translate-y-4"
                        aria-labelledby="tab-1">
                        <div class="relative z-10 lg:p-10 p-2" data-sal="slide-up" data-sal-duration="800"
                            data-sal-delay="200">
                            <div
                                class="before:content-[''] before:absolute before:top-0 ltr:before:left-47.5 rtl:before:left-0 ltr:before:right-0 rtl:before:right-47.5 before:bottom-0 before:border before:border-white/30 before:-z-10 hidden lg:block">
                            </div>
                            <div class="grid grid-cols-12 gap-6 items-center relative">
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="clip-shape-left md:h-90 overflow-hidden">
                                        <img src="{{ asset('assets/images/venue/stc.avif') }}" alt=""
                                            class="w-full h-full object-cover  transition-all duration-500 ease-out hover:scale-110 hover:rotate-2">
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-7 xl:col-span-6 xl:col-end-13">
                                    <div class="flex justify-between gap-5 flex-wrap md:flex-nowrap">
                                        <div>
                                            <span class="bg-white/10 backdrop-blur-sm p-3 px-5">Jakarta, Indonesia</span>
                                            <p class="text-gray-400 mt-8 mb-5">
                                                <i class="ri-timer-fill me-1 text-[#c0f037]"></i> 7:30 AM - 17:00 PM
                                            </p>
                                            <h2>
                                                <a href="https://maps.app.goo.gl/fiCiqSzmwxSK58rF7" target="_blank"
                                                    class="font-semibold leading-snug hover:text-[#c0f037] transition duration-300">
                                                    Best Western Senayan City Hotel, Jakarta, Indonesia
                                                </a>
                                            </h2>
                                            <p class="text-gray-400 mt-5 md:text-[20px]">
                                                Transforming Higher Education
                                                through Policy Reform, Innovative Practices, and Global Collaboration
                                            </p>
                                            <p
                                                class="uppercase tracking-widest bg-[#c0f037] inline-block p-2 px-5 text-black font-medium text-sm mt-5 [clip-path:polygon(100%_0%,0%_0%,5%_100%,100%_100%,95%_50%)]">
                                                ICPIP-HE 2026
                                            </p>
                                        </div>
                                        <div class="shrink-0 text-center">
                                            <a href="register" class="text-[#c0f037] block group">Join Now <i
                                                    class="ri-arrow-right-up-line group-hover:rotate-45 inline-block transition-all duration-300"></i></a>
                                            <div class="flex md:flex-col mt-6 gap-3 items-center flex-row">
                                                <a href="https://www.facebook.com/groups/9002604613166459" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                                <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/"
                                                    target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-instagram-fill"></i>
                                                </a>
                                                <a href="https://www.youtube.com/@adaksiTV" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-youtube-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-2" role="tabpanel" class="transition-all duration-500 opacity-0 translate-y-4"
                        aria-labelledby="tab-1">
                        <div class="relative z-10 lg:p-10 p-2" data-sal="slide-up" data-sal-duration="800"
                            data-sal-delay="200">
                            <div
                                class="before:content-[''] before:absolute before:top-0 ltr:before:left-47.5 rtl:before:left-0 ltr:before:right-0 rtl:before:right-47.5 before:bottom-0 before:border before:border-white/30 before:-z-10 hidden lg:block">
                            </div>
                            <div class="grid grid-cols-12 gap-6 items-center relative">
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="clip-shape-left md:h-90 overflow-hidden">
                                        <img src="{{ asset('assets/images/venue/stc.avif') }}" alt=""
                                            class="w-full h-full object-cover  transition-all duration-500 ease-out hover:scale-110 hover:rotate-2">
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-7 xl:col-span-6 xl:col-end-13">
                                    <div class="flex justify-between gap-5 flex-wrap md:flex-nowrap">
                                        <div>
                                            <span class="bg-white/10 backdrop-blur-sm p-3 px-5">Jakarta, Indonesia</span>
                                            <p class="text-gray-400 mt-8 mb-5">
                                                <i class="ri-timer-fill me-1 text-[#c0f037]"></i> 7:30 AM - 17:00 PM
                                            </p>
                                            <h2>
                                                <a href="https://maps.app.goo.gl/fiCiqSzmwxSK58rF7" target="_blank"
                                                    class="font-semibold leading-snug hover:text-[#c0f037] transition duration-300">
                                                    Best Western Senayan City Hotel, Jakarta, Indonesia
                                                </a>
                                            </h2>
                                            <p class="text-gray-400 mt-5 md:text-[20px]">
                                                Transforming Higher Education
                                                through Policy Reform, Innovative Practices, and Global Collaboration
                                            </p>
                                            <p
                                                class="uppercase tracking-widest bg-[#c0f037] inline-block p-2 px-5 text-black font-medium text-sm mt-5 [clip-path:polygon(100%_0%,0%_0%,5%_100%,100%_100%,95%_50%)]">
                                                ICPIP-HE 2026
                                            </p>
                                        </div>
                                        <div class="shrink-0 text-center">
                                            <a href="register" class="text-[#c0f037] block group">Join Now <i
                                                    class="ri-arrow-right-up-line group-hover:rotate-45 inline-block transition-all duration-300"></i></a>
                                            <div class="flex md:flex-col mt-6 gap-3 items-center flex-row">
                                                <a href="https://www.facebook.com/groups/9002604613166459" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                                <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/"
                                                    target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-instagram-fill"></i>
                                                </a>
                                                <a href="https://www.youtube.com/@adaksiTV" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-youtube-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-3" role="tabpanel" class="transition-all duration-500 opacity-0 translate-y-4"
                        aria-labelledby="tab-1">
                        <div class="relative z-10 lg:p-10 p-2" data-sal="slide-up" data-sal-duration="800"
                            data-sal-delay="200">
                            <div
                                class="before:content-[''] before:absolute before:top-0 ltr:before:left-47.5 rtl:before:left-0 ltr:before:right-0 rtl:before:right-47.5 before:bottom-0 before:border before:border-white/30 before:-z-10 hidden lg:block">
                            </div>
                            <div class="grid grid-cols-12 gap-6 items-center relative">
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="clip-shape-left md:h-90 overflow-hidden">
                                        <img src="{{ asset('assets/images/venue/stc.avif') }}" alt=""
                                            class="w-full h-full object-cover  transition-all duration-500 ease-out hover:scale-110 hover:rotate-2">
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-7 xl:col-span-6 xl:col-end-13">
                                    <div class="flex justify-between gap-5 flex-wrap md:flex-nowrap">
                                        <div>
                                            <span class="bg-white/10 backdrop-blur-sm p-3 px-5">Jakarta, Indonesia</span>
                                            <p class="text-gray-400 mt-8 mb-5">
                                                <i class="ri-timer-fill me-1 text-[#c0f037]"></i> 7:30 AM - 17:00 PM
                                            </p>
                                            <h2>
                                                <a href="https://maps.app.goo.gl/fiCiqSzmwxSK58rF7" target="_blank"
                                                    class="font-semibold leading-snug hover:text-[#c0f037] transition duration-300">
                                                    Best Western Senayan City Hotel, Jakarta, Indonesia
                                                </a>
                                            </h2>
                                            <p class="text-gray-400 mt-5 md:text-[20px]">
                                                Transforming Higher Education
                                                through Policy Reform, Innovative Practices, and Global Collaboration
                                            </p>
                                            <p
                                                class="uppercase tracking-widest bg-[#c0f037] inline-block p-2 px-5 text-black font-medium text-sm mt-5 [clip-path:polygon(100%_0%,0%_0%,5%_100%,100%_100%,95%_50%)]">
                                                ICPIP-HE 2026
                                            </p>
                                        </div>
                                        <div class="shrink-0 text-center">
                                            <a href="register" class="text-[#c0f037] block group">Join Now <i
                                                    class="ri-arrow-right-up-line group-hover:rotate-45 inline-block transition-all duration-300"></i></a>
                                            <div class="flex md:flex-col mt-6 gap-3 items-center flex-row">
                                                <a href="https://www.facebook.com/groups/9002604613166459" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                                <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/"
                                                    target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-instagram-fill"></i>
                                                </a>
                                                <a href="https://www.youtube.com/@adaksiTV" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-youtube-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="panel-4" role="tabpanel" class="transition-all duration-500 opacity-0 translate-y-4"
                        aria-labelledby="tab-1">
                        <div class="relative z-10 lg:p-10 p-2" data-sal="slide-up" data-sal-duration="800"
                            data-sal-delay="200">
                            <div
                                class="before:content-[''] before:absolute before:top-0 ltr:before:left-47.5 rtl:before:left-0 ltr:before:right-0 rtl:before:right-47.5 before:bottom-0 before:border before:border-white/30 before:-z-10 hidden lg:block">
                            </div>
                            <div class="grid grid-cols-12 gap-6 items-center relative">
                                <div class="col-span-12 lg:col-span-5">
                                    <div class="clip-shape-left md:h-90 overflow-hidden">
                                        <img src="{{ asset('assets/images/venue/stc.avif') }}" alt=""
                                            class="w-full h-full object-cover  transition-all duration-500 ease-out hover:scale-110 hover:rotate-2">
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-7 xl:col-span-6 xl:col-end-13">
                                    <div class="flex justify-between gap-5 flex-wrap md:flex-nowrap">
                                        <div>
                                            <span class="bg-white/10 backdrop-blur-sm p-3 px-5">Jakarta, Indonesia</span>
                                            <p class="text-gray-400 mt-8 mb-5">
                                                <i class="ri-timer-fill me-1 text-[#c0f037]"></i> 7:30 AM - 17:00 PM
                                            </p>
                                            <h2>
                                                <a href="https://maps.app.goo.gl/fiCiqSzmwxSK58rF7" target="_blank"
                                                    class="font-semibold leading-snug hover:text-[#c0f037] transition duration-300">
                                                    Best Western Senayan City Hotel, Jakarta, Indonesia
                                                </a>
                                            </h2>
                                            <p class="text-gray-400 mt-5 md:text-[20px]">
                                                Transforming Higher Education
                                                through Policy Reform, Innovative Practices, and Global Collaboration
                                            </p>
                                            <p
                                                class="uppercase tracking-widest bg-[#c0f037] inline-block p-2 px-5 text-black font-medium text-sm mt-5 [clip-path:polygon(100%_0%,0%_0%,5%_100%,100%_100%,95%_50%)]">
                                                ICPIP-HE 2026
                                            </p>
                                        </div>
                                        <div class="shrink-0 text-center">
                                            <a href="register" class="text-[#c0f037] block group">Join Now <i
                                                    class="ri-arrow-right-up-line group-hover:rotate-45 inline-block transition-all duration-300"></i></a>
                                            <div class="flex md:flex-col mt-6 gap-3 items-center flex-row">
                                                <a href="https://www.facebook.com/groups/9002604613166459" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-facebook-fill"></i>
                                                </a>
                                                <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/"
                                                    target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-instagram-fill"></i>
                                                </a>
                                                <a href="https://www.youtube.com/@adaksiTV" target="_blank"
                                                    class="size-10 bg-white/10 backdrop-blur-sm rounded-full text-white inline-flex items-center justify-center hover:bg-[#c0f037] hover:text-black transition duration-300">
                                                    <i class="ri-youtube-fill"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end schedule -->

        <!-- Gallery -->
        <section class="lg:py-30 py-10 text-white overflow-hidden"> <!-- Tambah overflow-hidden agar slider tidak pecah -->
            <div class="container text-center mb-10 md:mb-15">
                <p class="mb-3 text-[#c0f037]">[ ADAKSI Gallery ]</p>
                <h2 class="text-white font-chivo font-medium text-3xl md:text-5xl leading-[1.2]">
                    It will be a memorable moment at the forum
                </h2>
            </div>

            <!-- PENTING: Gunakan pembungkus div untuk SAL, jangan langsung di swiper-wrapper -->
            <div class="gallery-container px-4 md:px-0" data-sal="fade" data-sal-duration="800">
                <div dir="ltr" class="swiper galleryswiper">
                    <div class="swiper-wrapper">
                        @foreach ([['imgage' => '1', 'name' => '2025 National Working Meeting', 'subtitle' => 'Highlights'], ['imgage' => '2', 'name' => 'National Working Meeting', 'subtitle' => 'Highlights'], ['imgage' => '3', 'name' => 'National Working Meeting', 'subtitle' => 'Highlights'], ['imgage' => '4', 'name' => 'National Working Meeting', 'subtitle' => 'Highlights'], ['imgage' => '5', 'name' => 'National Working Meeting', 'subtitle' => 'Highlights'], ['imgage' => '6', 'name' => 'National Working Meeting', 'subtitle' => 'Highlights']] as $gallery)
                            <div class="swiper-slide">
                                <div
                                    class="relative block transition-all duration-500 ease-in-out z-1 hover:translate-y-2.5 group mb-10">
                                    <div
                                        class="absolute -top-2.5 -left-2.5 -right-2.5 bottom-22.5 bg-[#c0f037] rounded-[20px] origin-right scale-y-0 transition-transform duration-500 ease-in-out group-hover:scale-y-100 -z-1">
                                    </div>
                                    <div class="relative block">
                                        <!-- Ukuran Image disesuaikan untuk mobile agar tidak 'hilang' karena height 0 -->
                                        <div
                                            class="relative overflow-hidden rounded-[20px] h-[300px] md:h-[350px] shadow-lg">
                                            <img src="{{ asset('assets/images/gallery/business-gallery-' . $gallery['imgage'] . '.jpg') }}"
                                                class="w-full h-full object-cover block" alt="Gallery Image">
                                        </div>

                                        <!-- Card Info: Di mobile dibuat lebih kecil agar muat -->
                                        <div
                                            class="absolute bottom-0 right-0 bg-[#032530] w-[85%] md:w-70 text-white shadow-xl rounded-tr-[20px] pt-6 md:pt-8 px-5 md:px-7 pb-4 transition-all duration-500 ease-out translate-y-7.5 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 border-l-2 border-[#c0f037]">
                                            <div
                                                class="transition-all duration-500 ease-out delay-150 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100">
                                                <p
                                                    class="mb-1 text-[10px] md:text-sm tracking-wide text-[#c0f037] uppercase">
                                                    {{ $gallery['subtitle'] }}
                                                </p>
                                                <h4 class="font-medium text-sm md:text-base">
                                                    <a href="register">{{ $gallery['name'] }}</a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Tambahkan script ini di bawah atau di section scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi ulang Swiper untuk memastikan mobile terpantau
                new Swiper('.galleryswiper', {
                    slidesPerView: 1.2, // Tampilkan sedikit slide berikutnya agar user tahu bisa di-swipe
                    spaceBetween: 20,
                    centeredSlides: true,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            centeredSlides: false
                        },
                        1024: {
                            slidesPerView: 3,
                            centeredSlides: false
                        },
                    }
                });
            });
        </script>

        <!-- Pricing -->
        <section class="lg:py-30 py-20 bg-[#0B2C36] text-white">
            <div class="container">
                <div class="text-center max-w-3xl mx-auto mb-15">
                    <p class="mb-3 text-[#c0f037]" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">[
                        Pricing Plans ]</p>
                    <h2 class="md:text-5xl font-chivo font-medium leading-[1.2]" data-sal="slide-up"
                        data-sal-duration="700" data-sal-delay="200">Choose the Perfect Plan for Your Conference
                        Experience</h2>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    @foreach ([['name' => 'Offline Presenter', 'price' => '750K', 'desc' => 'Certificate, meetup, networking, indexed publication, food'], ['name' => 'Online Presenter', 'price' => '450K', 'desc' => 'Certificate + indexed publication + premium networking'], ['name' => 'Offline Participant', 'price' => '200K', 'desc' => 'Certificate, meetup, networking, food'], ['name' => 'Online Participant', 'price' => '100K', 'desc' => 'Certificate + premium networking'], ['name' => 'ADAKSI Member', 'price' => '20% OFF', 'desc' => 'Join on your ADAKSI account (www.adaksi.org) and get special offer'], ['name' => 'Student', 'price' => '20% OFF', 'desc' => 'Include Certificate, meetup, networking, food and get special offer (Get discount up to 20% as Presenter)']] as $plan)
                        <div class="col-span-12 xl:col-span-4 md:col-span-6">
                            <div
                                class="bg-white/10 backdrop-blur-sm p-9 rounded-4xl relative h-100 flex flex-col justify-between">

                                <div>
                                    <h3 class="mb-3 text-3xl">{{ $plan['name'] }}</h3>
                                    <p class="text-gray-400 text-xl">{{ $plan['desc'] }}</p>
                                </div>

                                <div>
                                    {{-- Kondisi khusus --}}
                                    @if (str_contains($plan['price'], 'OFF'))
                                        <h2 class="text-5xl mb-6 font-bold text-red-500 stroke-text">
                                            {{ $plan['price'] }}
                                        </h2>
                                    @else
                                        <h2 class="text-5xl mb-6 font-bold">
                                            IDR {{ $plan['price'] }}
                                        </h2>
                                    @endif

                                    <a href="https://www.adaksi.org/login" target="_blank"
                                        class="btn text-lg rounded-none group border border-[#c0f037] text-[#c0f037] tracking-[1px] uppercase font-medium relative transition-all duration-300 hover:bg-[#c0f037] hover:text-black inline-block hover:rotate-2">
                                        Book Now
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="lg:py-30 lg:pb-90 py-20 relative overflow-hidden text-white">
            <div
                class="before:content-[''] before:bg-[url('{{ asset('assets/images/business/business-map.png') }}')] before:bg-no-repeat before:bg-center before:opacity-50 before:absolute before:inset-0">
            </div>

            <!-- Avatar 1 -->
            <div class="size-14 absolute top-20 ltr:left-40 rtl:right-40 animate-float-rotate hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-02.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>

            <!-- Avatar 2 -->
            <div class="size-14 absolute top-60 ltr:right-32 rtl:left-32 animate-float-right hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-03.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>

            <!-- Avatar 3 -->
            <div class="size-14 absolute bottom-40 ltr:left-50 rtl:right-50 animate-float-rotate hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-04.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>

            <!-- Avatar 4 -->
            <div class="size-14 absolute bottom-30 ltr:right-60 rtl:left-60 animate-float-left hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-05.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>

            <!-- Avatar 5 -->
            <div class="size-14 absolute bottom-50 ltr:left-1/2 rtl:right-1/2 animate-float-rotate hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-06.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>

            <!-- Avatar 6 -->
            <div class="size-14 absolute top-90 ltr:left-1/3 rtl:right-1/3 animate-float-diagonal hidden 2xl:block">
                <img src="{{ asset('assets/images/testimoni/user-07.jpeg') }}" alt=""
                    class="w-full h-full object-cover rounded-full border-4 border-[#c0f03770] shadow-md">
            </div>
            <div class="container">
                <div class="text-center max-w-3xl mx-auto md:mb-40 mb-12 relative z-10">
                    <p class="mb-3 text-[#c0f037]" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">[
                        Testimonial ]</p>
                    <h2 class="md:text-5xl font-chivo font-medium leading-[1.2]" data-sal="slide-up"
                        data-sal-duration="700" data-sal-delay="200">What Attendees Said About the Conference</h2>
                </div>
                <div class="grid grid-cols-12 2xl:gap-17 gap-6 items-center">
                    <div class="col-span-12 lg:col-span-6">
                        <div class="relative" data-sal="slide-right" data-sal-duration="800" data-sal-delay="200">
                            <div
                                class="hidden md:block rotate-45 rounded-md overflow-hidden size-100 p-4 border border-white/30 md:mx-auto lg:mx-0">
                                <img src="{{ asset('assets/images/testimoni/KHOI0983 (1).JPG') }}" alt=""
                                    class="w-full h-full object-cover rounded-md shadow-md">
                            </div>
                            <div
                                class="hidden xl:block rotate-45 rounded-md overflow-hidden size-60 p-4 border border-white/30 -mt-7 ltr:ms-66 rtl:-ms-25">
                                <img src="{{ asset('assets/images/testimoni/KHOI0349 (1).JPG') }}" alt=""
                                    class="w-full h-full object-cover rounded-md shadow-md">
                            </div>
                            <div
                                class="hidden xl:block rotate-45 rounded-md overflow-hidden size-40 p-4 border border-white/30 absolute top-59 ltr:2xl:right-31 ltr:xl:right-4 rtl:2xl:-right-45 rtl:xl:-right-46">
                                <img src="{{ asset('assets/images/testimoni/KHOI1010 (1).JPG') }}" alt=""
                                    class="w-full h-full object-cover rounded-md shadow-md">
                            </div>
                            <div
                                class="hidden xl:block rounded-md overflow-hidden w-165 h-30 rotate-45 p-4 border border-white/30 ltr:-ms-58 rtl:-me-58 -mt-47">
                                <img src="{{ asset('assets/images/testimoni/business-tm11.jpg') }}" alt=""
                                    class="w-full h-full object-cover rounded-md shadow-md">
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-6">
                        <div dir="ltr" class="swiper reviwe-swiper relative">
                            <div class="swiper-wrapper">
                                @foreach ([['avatar' => 'user-022.jpg', 'author' => 'Eka WS', 'designation' => 'Lecturer', 'rating' => '5', 'desc' => 'I am very excited to attend the conference that will be held this coming June. This event is a valuable opportunity to meet experts and professionals in the field.'], ['avatar' => 'user-033.jpeg', 'author' => 'Antha', 'designation' => 'Lecturer', 'rating' => '5', 'desc' => 'My enthusiasm grows even stronger as the conference presents a variety of interesting and relevant topics. I believe this experience will provide new and valuable insights.'], ['avatar' => 'user-044.jpeg', 'author' => 'Rio Kurniawan', 'designation' => 'Lecturer', 'rating' => '5', 'desc' => 'I believe this conference will be a memorable and enriching experience. I truly cannot wait to be part of this major event in June.']] as $testimonial)
                                    <div class="swiper-slide">
                                        <div>
                                            <img src="{{ asset('assets/images/testimoni/business-quote.png') }}"
                                                alt="">
                                            <div class="mt-8 mb-6 flex items-center justify-between">
                                                <div>
                                                    <h3 class="mb-1">{{ $testimonial['author'] }}</h3>
                                                    <p class="text-gray-400">{{ $testimonial['designation'] }}</p>
                                                </div>
                                                <div class="size-20">
                                                    <img src="{{ asset('assets/images/testimoni/' . ($testimonial['avatar'] ?? 'default.jpg')) }}"
                                                        alt="{{ $testimonial['author'] }}"
                                                        class="w-full h-full object-cover rounded-full">
                                                </div>
                                            </div>
                                            <div class="mb-5 text-yellow-400">
                                                @php
                                                    $rating = floatval($testimonial['rating']);
                                                    $fullStars = floor($rating);
                                                    $halfStar = $rating - $fullStars >= 0.5;
                                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                                @endphp

                                                {{-- Full Stars --}}
                                                @for ($i = 0; $i < $fullStars; $i++)
                                                    <i class="ri-star-fill"></i>
                                                @endfor

                                                {{-- Half Star --}}
                                                @if ($halfStar)
                                                    <i class="ri-star-half-fill"></i>
                                                @endif

                                                {{-- Empty Stars --}}
                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                    <i class="ri-star-line"></i>
                                                @endfor
                                            </div>
                                            <p class="text-gray-400 md:text-[22px]">
                                                “{{ $testimonial['desc'] }}”
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-6 mt-10 pt-20 p-5 border-t border-white/40">
                                <button
                                    class="swiper-button-prev-custom border size-12 flex items-center justify-center text-[#c0f037] hover:bg-[#c0f037] hover:text-[#032530] transition duration-300 rotate-45 rounded-md">
                                    <i class="ri-arrow-left-double-fill text-xl -rotate-45"></i>
                                </button>
                                <button
                                    class="swiper-button-next-custom border size-12 flex items-center justify-center text-[#c0f037] hover:bg-[#c0f037] hover:text-[#032530] transition duration-300 rotate-45 rounded-md">
                                    <i class="ri-arrow-right-double-line text-xl -rotate-45"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="lg:-mb-30 -mb-8 relative z-10">
            <div class="container">
                <div class="rounded-lg bg-[#c0f037] p-10 text-center">
                    <h2 class="md:text-5xl font-chivo font-medium leading-[1.2] mb-10 text-black">Get Started Right Now!
                    </h2>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ url('/register') }}"
                            class="bg-[#032530] hover:bg-[#064254] text-white px-10 py-3 rounded-lg uppercase font-medium transition-all inline-block">
                            Join Now
                        </a>
                    </div>
                </div>
            </div>
        </section>



        @include('partials.footer.f-business')

    </div>

@endsection

@section('scripts')
    @vite(['resources/assets/js/search.js'])
@endsection
