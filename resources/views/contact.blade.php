@extends('layouts.main')

@section('title', 'Contact')

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
                        data-sal-duration="800" data-sal-delay="200"> Contact & Support</h2>
                    <p class="text-[20px] text-gray-200 max-w-2xl mx-auto" data-sal="slide-right" data-sal-duration="800"
                        data-sal-delay="200">Have questions or need assistance? Contact our team for information on
                        registration, sessions, or general inquiries. We're here to help make your experience smooth and
                        enjoyable.</p>
                    <div class="flex items-center justify-center gap-4 text-[22px] mt-6" data-sal="slide-left"
                        data-sal-duration="800" data-sal-delay="200">
                        <p><a href="{{ url('/') }}">Home</a></p>
                        <img src="{{ asset('assets/images/event/event-arrow-right.png') }}" alt="" class="invert">
                        <p>Contact</p>
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


        <!-- contact info section -->
        <section class="lg:py-30 py-20">
            <div class="container">
                <div class="grid grid-cols-12 gap-6">
                    <div class="col-span-12 lg:col-span-4">
                        <div class="text-center">
                            <div
                                class="size-19 rounded-full flex items-center justify-center bg-[#6C63FF] text-white mx-auto mb-5">
                                <i class="ri-map-pin-2-fill text-3xl"></i>
                            </div>
                            <h3 class="text-3xl mb-3">Event Venue</h3>
                            <p class="text-gray-600 text-xl dark:text-gray-400">
                                Science Techno Park Building,<br>
                                Universitas Indonesia
                            </p>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <div class="text-center">
                            <div
                                class="size-18 rounded-full flex items-center justify-center bg-[#FF6B6B] text-white mx-auto mb-5">
                                <i class="ri-phone-fill text-3xl"></i>
                            </div>
                            <h3 class="text-3xl mb-3">Registration Desk</h3>
                            <p class="text-gray-600 text-xl dark:text-gray-400">
                                For attendee queries or registration help<br>
                                <a href="https://wa.me/+6282365756299" class="hover:underline">+62 823-6575-6299 (Jonris Tampubolon)</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-span-12 lg:col-span-4">
                        <div class="text-center">
                            <div
                                class="size-19 rounded-full flex items-center justify-center bg-[#4CAF50] text-white mx-auto mb-5">
                                <i class="ri-mail-send-fill text-3xl"></i>
                            </div>
                            <h3 class="text-3xl mb-3">Email Support</h3>
                            <p class="text-gray-600 text-xl dark:text-gray-400">
                                For general inquiries, sponsorships, or media<br>
                                <a href="mailto:mail@conference.adaksi.org" class="hover:underline">mail@conference.adaksi.org</a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- end contact info section -->


        <!-- contact section -->
        
            <section class="lg:pb-30 pb-20">
            <div class="container">
                <div class="border rounded-xl md:p-10 p-2" data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
                    <div class="grid grid-cols-12 2xl:gap-15 gap-6">
                        <div class="col-span-12 lg:col-span-6">
                            <div class="rounded-xl overflow-hidden h-full w-full">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6908.329491368214!2d106.80990060967481!3d-6.352710461444265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed007963614b%3A0xffb6ae802bfe9db1!2sKantor%20Adaksi!5e1!3m2!1sid!2sid!4v1777620344573!5m2!1sid!2sid"
                                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-6">
                            <form action="#" method="post" class="space-y-6">
                                <div class="grid grid-cols-12 gap-6">
                                    <div class="col-span-12 md:col-span-6">
                                        <input type="text" placeholder="Your Name"
                                            class="w-full border border-black/20 dark:border-white/20 rounded-xl px-5 py-4 text-lg outline-none focus:border-black dark:focus:border-white"
                                            required>
                                    </div>

                                    <div class="col-span-12 md:col-span-6">
                                        <input type="email" placeholder="Your Email"
                                            class="w-full border border-black/20 dark:border-white/20 rounded-xl px-5 py-4 text-lg outline-none focus:border-black dark:focus:border-white"
                                            required>
                                    </div>
                                </div>
                                <div>
                                    <input type="tel" placeholder="Phone Number (optional)"
                                        class="w-full border border-black/20 dark:border-white/20 rounded-xl px-5 py-4 text-lg outline-none focus:border-black dark:focus:border-white">
                                </div>
                                <div>
                                    <input type="text" placeholder="Subject"
                                        class="w-full border border-black/20 dark:border-white/20 rounded-xl px-5 py-4 text-lg outline-none focus:border-black dark:focus:border-white"
                                        required>
                                </div>
                                <div>
                                    <textarea rows="6" placeholder="Write your message here..."
                                        class="w-full border border-black/20 dark:border-white/20 rounded-xl px-5 py-4 text-lg outline-none resize-none focus:border-black dark:focus:border-white"
                                        required></textarea>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="relative inline-block text-xl font-semibold bg-black dark:bg-white text-white dark:text-black w-full rounded-full px-7 py-4 overflow-hidden group hover:text-black">
                                        <span class="relative z-10">
                                            Send Message <i class="ri-arrow-right-line"></i>
                                        </span>
                                        <span
                                            class="absolute inset-0 bg-[#f2c944] -translate-x-full group-hover:translate-x-0 transition-transform duration-300 ease-out rounded-full"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end contact section -->

        @include('partials.footer.f-business')

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/event-venue.js') }}" defer></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
