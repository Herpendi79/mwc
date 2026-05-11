<!-- business header -->
<nav class="h-22 transition-all duration-500 ease-out absolute w-full top-0 left-0 z-50 border-b border-white/10">
    <div class="container flex items-center px-4 justify-between mx-auto h-full">
        <!-- Logo -->
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo" class="md:h-10 h-8 object-cover w-auto">
        </a>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="xl:hidden text-white">
            <i class="ri-menu-2-line text-xl"></i>
        </button>

        <!-- Desktop Menu -->
        <ul class="hidden items-center gap-12 font-medium xl:flex">

            <!-- ==== Home ==== -->
            <li class="group relative">
                <!-- Menu Link -->
                <a href="{{ url('/') }}"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Home
                </a>

            </li>

            <!-- ==== Events ==== -->
            <li class="group relative">
                <a href="#!"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Speakers
                    <!-- PLUS icon  -->
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>

                    <!-- MINUS icon -->
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>

                </a>
                <div
                    class="dropdown-menu absolute top-full rounded-lg text-black w-48 bg-white  opacity-0  invisible group-hover:opacity-100 group-hover:scale-y-100 group-hover:visible scale-y-0 origin-top transition-all duration-500 ease-out z-50 ">
                    <ul class="py-3 transition duration-300 ease-linear block text-15">
                        <li>
                            <a href="opening-speech" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Opening Speech
                            </a>
                        </li>
                        <li>
                            <a href="speaker" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Keynote Speech
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="group relative">
                <a href="commitee" 
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Commitee</a>
            </li>

            <!-- ==== Speakers ==== -->
            <li class="group relative">
                <a href="#!"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    For Presenters
                    <!-- PLUS icon  -->
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>

                    <!-- MINUS icon -->
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>

                </a>
                <div
                    class="dropdown-menu absolute top-full rounded-lg text-black w-48 bg-white  opacity-0  invisible group-hover:opacity-100 group-hover:scale-y-100 group-hover:visible scale-y-0 origin-top transition-all duration-500 ease-out z-50 ">
                    <ul class="py-3 transition duration-300 ease-linear block text-15">
                        <li>
                            <a href="important-dates" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Important Dates
                            </a>
                        </li>
                        <li>
                            <a href="submission-information" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Submission Information
                            </a>
                        </li>
                        <li>
                            <a href="virtual-conference-instruction" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Virtual Conference Instruction
                            </a>
                        </li>
                        <li>
                            <a href="registration-fee" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Registration Fee
                            </a>
                        </li>
                        <li>
                            <a href="accommodation" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Nearby Accommodation
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- ==== Blog ==== -->
            <li class="group relative">
                <a href="#!"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Events
                    <!-- PLUS icon  -->
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>

                    <!-- MINUS icon -->
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>

                </a>
                <div
                    class="dropdown-menu absolute top-full rounded-lg text-black w-48 bg-white  opacity-0  invisible group-hover:opacity-100 group-hover:scale-y-100 group-hover:visible scale-y-0 origin-top transition-all duration-500 ease-out z-50 ">
                    <ul class="py-3 transition duration-300 ease-linear block text-15">
                        <li>
                            <a href="schedule" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Schedule
                            </a>
                        </li>
                        <li>
                            <a href="venue" 
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Venue
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="group relative">
                <a href="#!"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Download
                    <!-- PLUS icon  -->
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>

                    <!-- MINUS icon -->
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>

                </a>
                <div
                    class="dropdown-menu absolute top-full rounded-lg text-black w-48 bg-white  opacity-0  invisible group-hover:opacity-100 group-hover:scale-y-100 group-hover:visible scale-y-0 origin-top transition-all duration-500 ease-out z-50 ">
                    <ul class="py-3 transition duration-300 ease-linear block text-15">
                        <li>
                            <a href="https://drive.google.com/drive/folders/1UoTcEgNxZI-6_oMj_mENlJNw9aJ1SFYq?usp=sharing"
                                
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Poster
                            </a>
                        </li>
                        <li>
                            <a href="https://drive.google.com/drive/folders/1gIDk4NxmQ2RtlCWjI9Mblr-1Z8wTRjYW?usp=sharing"
                                
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Virtual Background
                            </a>
                        </li>
                        <li>
                            <a href="https://drive.google.com/drive/folders/1ziNHG5ZMc8rOAwbLmeoZWsRVK6z42X6Q?usp=sharing"
                                
                                class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                <span
                                    class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                Best Presenter
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="group relative">
                <a href="contact" 
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Contact</a>
            </li>
            <li class="group relative">
                <a href="register" target="_blank"
                    class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Register</a>
            </li>
        </ul>

        <!-- Desktop CTA -->
        <div class="flex gap-3 items-center">


            <div class="border border-white/50 h-8 hidden md:block"></div>

            <div class="md:flex gap-2 hidden">
                <a href="https://www.facebook.com/groups/9002604613166459" target="_blank"
                    class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-facebook-fill"></i>
                </a>

                <a href="https://www.instagram.com/aliansidosenasnkemdiktisaintek/" target="_blank"
                    class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-instagram-line"></i>
                </a>

                <a href="https://www.youtube.com/@adaksiTV" target="_blank"
                    class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-youtube-line"></i>
                </a>
            </div>
        </div>

    </div>
    <!-- Mobile Sidebar -->
    <div
        class="fixed inset-y-0 left-0  z-50 w-80 bg-white transition-transform duration-300 ease-in-out -translate-x-full xl:hidden">
        <div class="flex h-full flex-col">

            <!-- Header -->
            <div class="flex items-center justify-between border-b border-gray-200 p-5">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/business/logo.png') }}" alt="logo"
                        class="md:h-10 h-8 object-cover w-auto">
                </a>
                <button id="mobile-close-btn">
                    <i class="ri-close-line text-xl"></i>
                </button>
            </div>

            <!-- Nav -->
            <nav class="flex-1 overflow-y-auto py-6">
                <ul class="space-y-2 px-6">

                    <!-- ==== Home ==== -->
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            <a href="{{ url('/') }}">Home</a>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>

                    </li>
                    <!-- ==== Events ==== -->
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            Speakers
                            <i class="ri-add-line text-md transition-transform"></i>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>

                        <ul
                            class="mobile-dropdown-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out pl-4 pt-2 space-y-1">
                            <li>
                                <a href="opening-speech"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Opening Speech
                                </a>
                            </li>
                            <li>
                                <a href="speaker"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Keynote Speech
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            <a href="commitee">commitee</a>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>
                    </li>

                    <!-- ==== Speakers ==== -->
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            For Presenters
                            <i class="ri-add-line text-md transition-transform"></i>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>

                        <ul
                            class="mobile-dropdown-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out pl-4 pt-2 space-y-1">
                            <li>
                                <a href="important-dates"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Important Dates
                                </a>
                            </li>
                            <li>
                                <a href="submission-information"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Submission Information
                                </a>
                            </li>
                            <li>
                                <a href="virtual-conference-instruction"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Virtual Conference Instruction
                                </a>
                            </li>
                            <li>
                                <a href="registration-fee"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Registration Fee
                                </a>
                            </li>
                            <li>
                                <a href="accommodation"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Nearby Accommodation 
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- ==== Blog ==== -->
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            Events
                            <i class="ri-add-line text-md transition-transform"></i>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>

                        <ul
                            class="mobile-dropdown-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out pl-4 pt-2 space-y-1">
                            <li>
                                <a href="schedule"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Schedule
                                </a>
                            </li>
                            <li>
                                <a href="venue"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Venue
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- ==== Download ==== -->
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            Download
                            <i class="ri-add-line text-md transition-transform"></i>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>

                        <ul
                            class="mobile-dropdown-content max-h-0 overflow-hidden transition-all duration-500 ease-in-out pl-4 pt-2 space-y-1">
                            <li>
                                <a href="https://drive.google.com/drive/folders/1UoTcEgNxZI-6_oMj_mENlJNw9aJ1SFYq?usp=sharing"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Poster
                                </a>
                            </li>
                            <li>
                                <a href="https://drive.google.com/drive/folders/1gIDk4NxmQ2RtlCWjI9Mblr-1Z8wTRjYW?usp=sharing"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Virtual Background
                                </a>
                            </li>
                            <li>
                                <a href="https://drive.google.com/drive/folders/1ziNHG5ZMc8rOAwbLmeoZWsRVK6z42X6Q?usp=sharing"
                                    class="block relative px-4 py-2 text-gray-600 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                    <span
                                        class="before:content-[''] before:absolute before:left-2 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                    Best Presenter
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            <a href="contact">Contact</a>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>
                    </li>
                    <li>
                        <button
                            class="mobile-dropdown-btn flex w-full items-center justify-between rounded-lg px-4 py-3 font-medium hover:text-[#c0f037] transition-all duration-300">
                            <a href="register">Register</a>
                            <i class="ri-subtract-line text-md hidden"></i>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</nav>
