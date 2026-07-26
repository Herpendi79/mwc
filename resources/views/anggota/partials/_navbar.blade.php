<header
    class="h-20 bg-white dark:bg-zinc-900 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between px-8 z-40">
    <div class="flex items-center gap-4">
        <!-- Tombol Hamburger untuk Mobile -->
        <button id="mobile-menu-btn"
            class="lg:hidden text-2xl dark:text-white transition-transform active:scale-90 z-50 relative">
            <i class="ri-menu-2-line"></i>
        </button>
        <h1 class="text-xl font-bold dark:text-white hidden sm:block">Anggota Dashboard</h1>
    </div>

    <div class="flex items-center gap-6">
        <!-- Profile Dropdown -->
        <!-- Navbar: Bagian Profile Dropdown -->
        <div class="relative"> <!-- Hapus class 'group' di sini -->
            <button id="profile-menu-button" class="flex items-center gap-3 focus:outline-none cursor-pointer">
                <div class="text-right hidden md:block">
                    @auth
                        <p class="text-sm font-bold dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    @else
                        <p class="text-sm font-bold dark:text-white">Guest User</p>
                        <a href="{{ route('login') }}" class="text-xs text-[#c0f037]">Please Login</a>
                    @endauth
                </div>
                <div
                    class="size-10 rounded-full bg-black dark:bg-white flex items-center justify-center text-white dark:text-black font-bold">
                    {{ strtoupper(substr(optional(Auth::user())->name ?? 'G', 0, 1)) }}
                </div>
            </button>

            <!-- Dropdown Menu: Tambahkan ID dan class 'hidden' -->
            <div id="profile-dropdown"
                class="absolute right-0 mt-2 w-56 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-2xl shadow-xl hidden transition-all duration-300 z-50">
                <div class="p-2">
                    <!-- LINK PROFILE SETTINGS -->
                    <a href="{{ route('anggota.profile.setting') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700 rounded-xl transition-all {{ request()->routeIs('profile.edit') ? 'bg-gray-100 dark:bg-zinc-700' : '' }}">
                        <i class="ri-user-settings-line text-lg text-[#6C63FF]"></i>
                        <span class="font-semibold">Profile Settings</span>
                    </a>

                    <hr class="my-1 border-gray-100 dark:border-zinc-700">

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center gap-3 px-4 py-3 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all">
                            <i class="ri-logout-box-line text-lg"></i>
                            <span class="font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
