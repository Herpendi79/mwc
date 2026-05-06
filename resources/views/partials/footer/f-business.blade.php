<!-- Business Footer section -->
<footer class="relative bg-[#0B2C36] text-white overflow-hidden">
    <div class="container">
        <div class="py-16 gap-y-6 md:py-24 lg:py-20 lg:pt-50">
            <div class="grid grid-cols-12 gap-6 2xl:gap-10 items-start">
                <div class="col-span-12 xl:col-span-3 lg:col-span-6">
                    <h3 class="mb-5 text-3xl font-semibold">About Event</h3>
                    <p class="text-[20px] text-gray-400 leading-relaxed">
                        To foster collaboration and innovation in transforming higher education through policy reform, digital advancement, and global partnerships.
                    </p>

                    <div class="flex items-center mt-8 gap-3">
                        <a href="https://www.facebook.com/groups/9002604613166459" target="_blank" class="size-11 rounded-full border border-white/20 bg-white/10 backdrop-blur flex items-center justify-center transition-all duration-300 hover:bg-[#c0f037] hover:text-black">
                            <i class="ri-facebook-fill text-xl"></i>
                        </a>
                        <a href="https://x.com/tukin_dosenASN" target="_blank" class="size-11 rounded-full border border-white/20 bg-white/10 backdrop-blur flex items-center justify-center transition-all duration-300 hover:bg-[#c0f037] hover:text-black">
                            <i class="ri-twitter-x-line text-xl"></i>
                        </a>
                        <a href="https://www.youtube.com/@adaksiTV" target="_blank" class="size-11 rounded-full border border-white/20 bg-white/10 backdrop-blur flex items-center justify-center transition-all duration-300 hover:bg-[#c0f037] hover:text-black">
                            <i class="ri-youtube-fill text-xl"></i>
                        </a>
                        <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/" target="_blank" class="size-11 rounded-full border border-white/20 bg-white/10 backdrop-blur flex items-center justify-center transition-all duration-300 hover:bg-[#c0f037] hover:text-black">
                            <i class="ri-instagram-line text-xl"></i>
                        </a>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-6 lg:col-span-6">
                    <div class="md:text-center">
                        <a href="{{ url('/') }}" class="inline-block">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Business Conference Logo" class="h-10 mx-auto">
                        </a>
    
                        <ul class="flex flex-wrap md:justify-center gap-6 mt-16">
                            <li class="text-xl border-r border-white/20 pr-5 last:border-0 last:pr-0">
                                <a href="{{ url('/') }}" class="hover:text-[#c0f037] transition">Home</a>
                            </li>
                            <li class="text-xl border-r border-white/20 pr-5 last:border-0 last:pr-0">
                                <a href="speaker" class="hover:text-[#c0f037] transition">Speaker</a>
                            </li>
                            <li class="text-xl border-r border-white/20 pr-5 last:border-0 last:pr-0">
                                <a href="important-dates" class="hover:text-[#c0f037] transition">Important Dates</a>
                            </li>
                            <li class="text-xl border-r border-white/20 pr-5 last:border-0 last:pr-0">
                                <a href="schedule" class="hover:text-[#c0f037] transition">Schedule</a>
                            </li>
                            <li class="text-xl border-r border-white/20 pr-5 last:border-0 last:pr-0">
                                <a href="https://drive.google.com/drive/folders/1UoTcEgNxZI-6_oMj_mENlJNw9aJ1SFYq?usp=sharing" class="hover:text-[#c0f037] transition">Poster</a>
                            </li>
                            <li class="text-xl">
                                <a href="register" target="_blank" class="hover:text-[#c0f037] transition">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-3 lg:col-span-6">
                    <h3 class="mb-5 text-3xl font-semibold">Contact Us</h3>
                    <ul class="space-y-4 text-lg">
                        <li class="flex gap-3 text-[20px]">
                            <span class="shrink-0 font-medium">Email :</span>
                            <a href="mailto:mail@conference.adaksi.org" class="text-gray-400 hover:text-[#c0f037] transition">
                                mail@conference.adaksi.org
                            </a>
                        </li>
                        <li class="flex gap-3 text-[20px]">
                            <span class="shrink-0 font-medium">Phone 1:</span>
                            <a href="https://wa.me/+6282365756299" class="text-gray-400 hover:text-[#c0f037] transition">
                                +62 823-6575-6299 (Jon)
                            </a>
                        </li>
                        <li class="flex gap-3 text-[20px]">
                            <span class="shrink-0 font-medium">Phone 2:</span>
                            <a href="https://wa.me/+6282365756299" class="text-gray-400 hover:text-[#c0f037] transition">
                                +62 857-3561-7107 (Rio)
                            </a>
                        </li>
                        <li class="flex gap-3 text-[20px]">
                            <span class="shrink-0 font-medium">Address :</span>
                            <span class="text-gray-400">
                                25 Srengseng Sawah Street, RT.1/RW.7, Srengseng Sawah, Jagakarsa District, Jakarta, Indonesia 12640

                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white/10 py-6">
            <div class="text-center text-gray-400 text-[20px]">
                <span>&copy; {{ date('Y') }} ICPIP-HE. Crafted & Designed by <a href="https://adaksi.org" target="_blank" class="hover:text-white">ADAKSI</a></span>
            </div>
        </div>
    </div>
</footer>
