<!-- Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity duration-300"></div>

<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-emerald-700 border-r border-emerald-600 z-50 transform -translate-x-full transition-all duration-300 ease-out lg:relative lg:translate-x-0 lg:flex flex-col">

    <div class="p-6 flex items-center justify-between shrink-0 border-b border-emerald-600/50">
        <a href="{{ url('/anggota') }}">
            <img src="{{ asset('assets/images/logo/logomwc.png') }}" class="h-10 logo-stroke" alt="Logo">
        </a>

        <style>
            .logo-stroke {
                filter:
                    drop-shadow(1px 0 0 #fff) drop-shadow(-1px 0 0 #fff) drop-shadow(0 1px 0 #fff) drop-shadow(0 -1px 0 #fff) drop-shadow(1px 1px 0 #fff) drop-shadow(-1px -1px 0 #fff) drop-shadow(1px -1px 0 #fff) drop-shadow(-1px 1px 0 #fff);
            }
        </style>
        <button id="sidebar-close" class="lg:hidden text-2xl text-white">
            <i class="ri-close-line"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 pb-5 space-y-2 mt-4">

        <!-- Dashboard -->
        <a href="{{ route('anggota.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all
            {{ request()->routeIs('anggota.index') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800 hover:text-black' }}">
            <i class="ri-dashboard-fill text-xl"></i>
            <span>Dashboard</span>
        </a>

        <!-- Profil Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('anggota.profile.index', 'anggota.profile.kta') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all
                {{ request()->routeIs('anggota.profile.index', 'anggota.profile.kta') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-user-settings-line text-xl"></i>
                    <span>Profil</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="pl-8 mt-1 space-y-1">
                <a href="{{ route('anggota.profile.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.profile.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Identitas</a>
                <a href="{{ route('anggota.profile.kta') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.profile.kta') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Download
                    KTA</a>
            </div>
        </div>

        <!-- Kegiatan Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('anggota.bahsul.index','anggota.bahsul.tambah', 'anggota.halaqah.index', 'anggota.kajian.index') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all
                {{ request()->routeIs('anggota.bahsul.index','anggota.bahsul.tambah', 'anggota.halaqah.index', 'anggota.kajian.index') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-calendar-event-line text-xl"></i>
                    <span>Kajian</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="pl-8 mt-1 space-y-1">
                <a href="{{ route('anggota.bahsul.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.bahsul.index','anggota.bahsul.tambah') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Bahtsul
                    Masail</a>
                <a href="{{ route('anggota.halaqah.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.halaqah.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Halaqah</a>
                <a href="{{ route('anggota.kajian.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.kajian.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Pengajian</a>
            </div>
        </div>

        <!-- Program Dropdown -->
        <div x-data="{ open: {{ request()->routeIs('anggota.mangrove.index','anggota.mangrove.tambah', 'anggota.sampah.index', 'anggota.roan.index', 'anggota.relawan.index', 'anggota.bencana.index','anggota.bencana.tambah') ? 'true' : 'false' }} }" class="space-y-1">
            <button type="button" @click.stop="open=!open"
                class="flex items-center justify-between w-full px-4 py-3 rounded-xl font-semibold transition-all
                {{ request()->routeIs('anggota.mangrove.index','anggota.mangrove.tambah', 'anggota.sampah.index', 'anggota.sampah.tambah', 'anggota.roan.index', 'anggota.relawan.index', 'anggota.bencana.index','anggota.bencana.tambah') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800' }}">
                <div class="flex items-center gap-3">
                    <i class="ri-hand-heart-line text-xl"></i>
                    <span>Program</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="pl-8 mt-1 space-y-1">
                <a href="{{ route('anggota.mangrove.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.mangrove.index','anggota.mangrove.tambah',) ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Infaq
                    Mangrove</a>
                <a href="{{ route('anggota.sampah.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.sampah.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Sedekah
                    Sampah</a>
                <a href="{{ route('anggota.roan.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.roan.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Roan
                    Bersih Pantai</a>
                <a href="{{ route('anggota.relawan.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.relawan.index') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Relawan
                    Banjir</a>
                <a href="{{ route('anggota.bencana.index') }}"
                    class="block px-4 py-2 rounded-xl {{ request()->routeIs('anggota.bencana.index','anggota.bencana.tambah') ? 'bg-white text-black font-semibold' : 'text-emerald-50 hover:bg-emerald-800 hover:text-black' }}">Lapor
                    Bencana</a>
            </div>
        </div>

        <!-- Lain-lain -->
        <a href="{{ route('anggota.opini.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('anggota.opini.index','anggota.opini.tambah','anggota.opini.edit') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800 hover:text-black' }}"><i
                class="ri-chat-quote-line text-xl"></i><span>Opini</span></a>
        <a href="{{ route('anggota.profile.setting') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all {{ request()->routeIs('anggota.profile.setting') ? 'bg-white text-black' : 'text-white hover:bg-emerald-800 hover:text-black' }}"><i
                class="ri-settings-3-line text-xl"></i><span>Setting</span></a>
    </nav>

    <!-- Footer -->
    <div class="border-t border-emerald-600 p-5 shrink-0">
        <div class="text-center">
            <p class="font-bold text-sm text-white">MWC TUGU</p>
            <p class="text-xs text-emerald-200 mt-1">Area Anggota</p>
        </div>
    </div>
</aside>
