<!-- Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity duration-300"></div>

<!-- SIDEBAR -->
<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 z-50 transform -translate-x-full transition-all duration-300 ease-out will-change-transform lg:relative lg:translate-x-0 lg:flex flex-col">
    <div class="p-6 flex items-center justify-between shrink-0">
        <a href="{{ url('/admin') }}">
            <img src="{{ asset('assets/images/logo/logomwc.png') }}" class="h-10" alt="Logo">
        </a>
        <button id="sidebar-close" class="lg:hidden text-2xl dark:text-white">
            <i class="ri-close-line"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 pb-5 space-y-2">

        <a href="{{ route('admin.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.index') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-dashboard-fill text-xl"></i>
            <span>Dashboard</span>
        </a>

        <!-- Profil Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('admin.profile.index', 'admin.profile.kta') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.profile.index', 'admin.profile.kta') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-user-settings-line text-xl"></i>
                    <span>Profil</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-cloak x-collapse.duration.250ms x-transition.opacity class="pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.profile.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profile.index') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Identitas
                </a>

                <a href="{{ route('admin.profile.kta') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profile.kta') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Download KTA
                </a>
            </div>
        </div>

        <a href="{{ route('admin.anggota.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.anggota.index', 'admin.anggota.tambah') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-checkbox-circle-fill text-xl"></i>
            <span>Verifikasi Anggota</span>
        </a>
        <a href="{{ route('admin.berita.index') }}"
    class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.berita.index', 'admin.berita.tambah', 'admin.berita.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
    <i class="ri-book-line text-xl"></i>
    <span>Berita</span>
</a>

        <!-- Kegiatan Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('admin.bahsul.index', 'admin.bahsul.tambah', 'admin.bahsul.edit', 'admin.halaqah.index', 'admin.halaqah.tambah', 'admin.halaqah.edit', 'admin.kajian.index', 'admin.kajian.tambah', 'admin.kajian.edit') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.bahsul.index', 'admin.bahsul.tambah', 'admin.bahsul.edit', 'admin.halaqah.index', 'admin.halaqah.tambah', 'admin.halaqah.edit', 'admin.kajian.index', 'admin.kajian.tambah', 'admin.kajian.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-calendar-event-line text-xl"></i>
                    <span>Kegiatan</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-cloak x-collapse.duration.250ms x-transition.opacity class="pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.bahsul.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bahsul.index', 'admin.bahsul.tambah', 'admin.bahsul.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Bahsul Masail
                </a>

                <a href="{{ route('admin.halaqah.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.halaqah.index', 'admin.halaqah.tambah', 'admin.halaqah.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Halaqah
                </a>

                <a href="{{ route('admin.kajian.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.kajian.index', 'admin.kajian.tambah', 'admin.kajian.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Pengajian
                </a>
            </div>
        </div>

        <!-- Program Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('admin.mangrove.index', 'admin.mangrove.tambah', 'admin.mangrove.edit', 'admin.sampah.index', 'admin.sampah.tambah', 'admin.sampah.edit', 'admin.roan.index', 'admin.roan.tambah', 'admin.roan.edit', 'admin.relawan.index', 'admin.relawan.tambah', 'admin.relawan.edit', 'admin.bencana.index', 'admin.bencana.tambah', 'admin.bencana.edit') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.mangrove.index', 'admin.mangrove.edit', 'admin.mangrove.tambah', 'admin.sampah.index', 'admin.sampah.tambah', 'admin.sampah.edit', 'admin.roan.index', 'admin.roan.tambah', 'admin.roan.edit', 'admin.relawan.index', 'admin.relawan.tambah', 'admin.relawan.edit', 'admin.bencana.index', 'admin.bencana.tambah', 'admin.bencana.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-hand-heart-line text-xl"></i>
                    <span>Program</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-cloak x-collapse.duration.250ms x-transition.opacity class="pl-8 mt-1 space-y-1">
                <a href="{{ route('admin.mangrove.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.mangrove.index', 'admin.mangrove.edit', 'admin.mangrove.tambah') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Infaq Mangrove
                </a>

                <a href="{{ route('admin.sampah.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.sampah.index', 'admin.sampah.tambah', 'admin.sampah.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Sedekah Sampah
                </a>

                <a href="{{ route('admin.roan.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.roan.index', 'admin.roan.tambah', 'admin.roan.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Roan Bersih Pantai
                </a>

                <a href="{{ route('admin.relawan.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.relawan.index', 'admin.relawan.tambah', 'admin.relawan.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Relawan Banjir
                </a>

                <a href="{{ route('admin.bencana.index') }}"
                    class="block px-4 py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bencana.index', 'admin.bencana.tambah', 'admin.bencana.edit') ? 'bg-gray-100 dark:bg-zinc-800 text-black dark:text-white font-semibold' : 'text-gray-600 dark:text-gray-400 font-normal hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-black dark:hover:text-white' }}">
                    Lapor Bencana
                </a>
            </div>
        </div>

        <a href="{{ route('admin.dakwah.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.dakwah.index', 'admin.dakwah.tambah', 'admin.dakwah.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-message-3-line text-xl"></i>
            <span>Pesan Dakwah</span>
        </a>

        <a href="{{ route('admin.khutbah.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.khutbah.index', 'admin.khutbah.tambah', 'admin.khutbah.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-book-open-line text-xl"></i>
            <span>Khutbah Jumat</span>
        </a>

        <a href="{{ route('admin.opini.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.opini.index', 'admin.opini.tambah', 'admin.opini.edit') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-chat-quote-line text-xl"></i>
            <span>Opini</span>
        </a>

        <a href="{{ route('admin.profile.setting') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('admin.profile.setting') ? 'bg-black text-white dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }}">
            <i class="ri-settings-3-line text-xl"></i>
            <span>Setting</span>
        </a>

    </nav>

    <div class="border-t border-gray-200 dark:border-zinc-800 p-5 shrink-0">
        <div class="text-center">
            <p class="font-bold text-sm dark:text-white">MWC TUGU</p>
            <p class="text-xs text-gray-500 mt-1">Administrator Panel</p>
        </div>
    </div>
</aside>
