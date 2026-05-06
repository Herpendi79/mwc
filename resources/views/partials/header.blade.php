<!-- business header -->
<nav class="h-22 transition-all duration-500 ease-out absolute w-full top-0 left-0 z-50 border-b border-white/20">
    <div class="container flex items-center px-4 justify-between mx-auto h-full">
        <!-- Logo -->
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/images/business/business-logo-light.png') }}" alt="logo" class="md:h-10 h-8 object-cover w-auto">
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
                <a href="#!" class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Home
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>
                </a>

                <!-- MEGA MENU -->
                <div class="dropdown-menu absolute top-full ltr:-translate-x-1/5 rtl:translate-x-1/5 w-237.5 bg-white rounded-xl shadow-xl text-black opacity-0 invisible scale-y-0 origin-top group-hover:opacity-100 group-hover:visible group-hover:scale-y-100 transition-all duration-500 ease-out z-50">
                    <ul class="py-6 px-8">
                        <li>
                            <div class="grid grid-cols-12 gap-6">
                                <div class="col-span-12 sm:col-span-6 lg:col-span-4">
                                    <a href="{{ url('/') }}" class="block rounded-lg overflow-hidden h-40">
                                        <img src="{{ asset('assets/images/home-business.png') }}" class="w-full h-full object-cover rounded-lg transition-all duration-300 hover:scale-105" alt="">
                                    </a>
                                    <p class="mt-3 text-center">
                                        <a href="{{ url('/') }}" class="relative flex items-center gap-3 px-5 py-2 font-medium text-[18px] transition-all duration-300 hover:text-[#c0f037] group/underline hover:translate-x-2">
                                            <span class="before:content-[''] before:absolute before:left-3 before:top-1/2 before:h-0 before:w-0.75 before:bg-[#c0f037] before:-translate-y-1/2 before:rounded-full before:transition-all before:duration-300 group-hover/underline:before:h-5"></span>
                                            Business Forum
                                        </a>
                                    </p>
                                </div>
                                <!-- ... Other menu items ... -->
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- ==== Events ==== -->
            <li class="group relative">
                <a href="#!" class="flex items-center gap-1 h-22 text-white text-[18px] font-medium hover:text-[#c0f037] transition-all duration-300">
                    Events
                    <i class="ri-add-line text-sm transition-transform group-hover:hidden"></i>
                    <i class="ri-subtract-line text-sm hidden group-hover:inline-block"></i>
                </a>
                <!-- ... Dropdown ... -->
            </li>
            <!-- ... Other menu items ... -->
        </ul>

        <!-- Desktop CTA -->
        <div class="flex gap-3 items-center">
            <button id="openSearch" class="text-white hover:text-[#c0f037] transition-all duration-300">
                <i class="ri-search-line text-xl"></i>
            </button>

            <!-- Search Bar Overlay -->
            <div id="searchBar" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50 opacity-0 transition-all duration-500">
                <div id="searchBox" class="bg-white flex items-center gap-3 px-5 py-3 rounded-full shadow-lg w-[90%] max-w-xl scale-50 opacity-0 transition-all duration-500">
                    <i class="ri-search-line text-black text-2xl"></i>
                    <input type="text" placeholder="Search here..." class="w-full outline-none text-black text-lg" />
                    <button id="closeSearch" class="text-black text-xl">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>

            <div class="border border-white/50 h-8 hidden md:block"></div>

            <div class="md:flex gap-2 hidden">
                <a href="#!" class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-facebook-fill"></i>
                </a>
                <a href="#!" class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-instagram-line"></i>
                </a>
                <a href="#!" class="bg-white/20 backdrop-blur-sm size-10 text-lg flex items-center justify-center rounded-full text-white hover:bg-[#c0f037] hover:text-black transition-all duration-300">
                    <i class="ri-twitter-line"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Mobile Sidebar -->
    <!-- ... Mobile Menu Content ... -->
</nav>
