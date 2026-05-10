@extends('layouts.main')

@section('title', 'Instruction')

@section('content')

    @php
        $faqs = [
            [
                'question' => 'General Information about the Conference',
                'answer' => '
                <ul class="list-disc ml-5 space-y-2">
                    <li>ICPIP-HE 2026 is held in the form of a virtual conference using the Zoom Application.</li>
                    <li>Each session consists of 1 host, 1 moderator (for keynote speech) or Session Leaders (for paper presentations), presenters, and attendees.</li>
                    <li>The host is in charge of facilitating the technology used.</li>
                    <li>The moderator or session leader is responsible for coordinating each session and facilitating the question and answer session.</li>
                    <li>All meeting IDs, passwords, and technical meeting schedules are sent to attendees’ emails.</li>
                    <li>Attendees can join the parallel sessions specified by the committee.</li>
                    <li>If an attendee joins before the session begins, he/she must wait until the moderator/session leader opens the session.</li>
                </ul>',
            ],
            [
                'question' => 'During the Conference',
                'answer' => '
                <ul class="list-disc ml-5 space-y-2">
                    <li>Participants must activate the video and use the virtual background provided by the committee at: <a href="https://drive.google.com/drive/folders/1gIDk4NxmQ2RtlCWjI9Mblr-1Z8wTRjYW?usp=sharing" class="text-blue-500 underline" target="_blank">Download Link</a>.</li>
                    <li>Presenters must present their articles in a live presentation.</li>
                    <li>The moderator/session leader will deactivate all attendees’ microphones during the presentation.</li>
                    <li>The presentation duration limit is 7 minutes, followed by a 10-minute Q&A session.</li>
                    <li>During the Q&A session, attendees can ask questions.</li>
                    <li>All attendees must obtain permission from the moderator if they need to leave the session.</li>
                    <li>Attendees are allowed to take a break, but must ensure Zoom remains active and the microphone is muted.</li>
                </ul>',
            ],
            [
                'question' => 'Instructions for Attendees',
                'answer' => '
                <ul class="list-disc ml-5 space-y-2">
                    <li>You are permitted to join any session of interest using the link provided on the ICPIP-HE 2026 website.</li>
                    <li>Please check if the room has reached its maximum capacity limit.</li>
                    <li>After the presentation, there is a brief Q&A session moderated by the Session Leader.</li>
                    <li>The Session Leader will offer attendees the chance to ask questions and will select which questions to address.</li>
                    <li>Due to time constraints, not all questions may be addressed. However, the Session Leader ensures key points are covered.</li>
                    <li>The committee may mute microphones if needed (Attendees can discuss with authors offline if time runs out).</li>
                    <li>You are not allowed to introduce yourself when joining or leaving a session to avoid disruption.</li>
                </ul>',
            ],
            [
                'question' => 'Paper Presentation Sessions Structure',
                'answer' => '
                <ol class="list-decimal ml-5 space-y-2">
                    <li><strong>10 minutes before:</strong> Host starts the session on Zoom.</li>
                    <li><strong>2 minutes before:</strong> Host starts recording.</li>
                    <li><strong>1 minute before:</strong> Session Leader opens the session.</li>
                    <li><strong>At the start:</strong> Moderator/Session Leader introduces presenters.</li>
                    <li><strong>Presentation:</strong> Presenters use the *.ppt/*pptx files sent to the committee.</li>
                    <li><strong>End of session:</strong> Session Leader draws conclusions, checks attendance, and the Host ends the session.</li>
                </ol>',
            ],
        ];
    @endphp

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
                        data-sal-duration="800" data-sal-delay="200">Virtual Conference Instruction</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">
                        For online participants, To ensure a smooth presentation and avoid common technical pitfalls, follow
                        these essential guidelines.
                    </p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Virtual Conference Instruction</p>
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

        <!-- Faq section -->
        <section class="lg:py-30 py-20">
            <div class="container">
                <div class="max-w-3xl mx-auto text-center mb-15">
                    <p class="mb-2 font-medium uppercase tracking-[1px]" data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="100">// Instruction</p>

                    <h2 class="font-bold md:text-5xl leading-snug " data-sal="zoom-in" data-sal-duration="800"
                        data-sal-delay="200">
                        Give more consideration to the following matters
                    </h2>
                </div>

                <div class="bg-[#f4f4f4] dark:bg-[#1F1F1F] md:p-10 p-5 rounded-2xl" data-sal="slide-up"
                    data-sal-duration="800" data-sal-delay="200">
                    <div class="space-y-5">
                        @foreach ($faqs as $faq)
                            <div
                                class="accordion-item border border-black/10 dark:border-white/10 rounded-2xl overflow-hidden transition-all">
                                <button
                                    class="accordion-header w-full flex items-center justify-between px-6 py-5 text-left group">
                                    <span class="md:text-2xl font-semibold">{{ $faq['question'] }}</span>
                                    <span
                                        class="icon shrink-0 size-11 rounded-full text-2xl flex items-center justify-center font-medium transition-all duration-300 group-hover:bg-black dark:group-hover:bg-white group-hover:text-white dark:group-hover:text-black">+</span>
                                </button>
                                <div class="accordion-body max-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                                    <div class="px-6 pb-6 text-gray-700 md:text-[20px] leading-relaxed">
                                        {!! $faq['answer'] !!} {{-- Gunakan {!! !!} agar tag HTML (ul/li) terbaca --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <!-- End Faq -->

        @include('partials.footer.f-business')

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/event-venue.js') }}" defer></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const item = this.parentElement;
                    const body = this.nextElementSibling;
                    const icon = this.querySelector('.icon');

                    // Tutup item lain (Opsional: hapus bagian ini jika ingin bisa buka banyak sekaligus)
                    document.querySelectorAll('.accordion-item').forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.querySelector('.accordion-body').style.maxHeight =
                                null;
                            otherItem.querySelector('.icon').textContent = '+';
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle item yang diklik
                    if (body.style.maxHeight) {
                        body.style.maxHeight = null;
                        icon.textContent = '+';
                        item.classList.remove('active');
                    } else {
                        // Mengatur max-height sesuai tinggi konten asli (scrollWidth)
                        body.style.maxHeight = body.scrollHeight + "px";
                        icon.textContent = '-';
                        item.classList.add('active');
                    }
                });
            });
        });
    </script>
@endsection
