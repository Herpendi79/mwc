<!-- Sidebar Overlay (Hanya muncul di mobile saat menu terbuka) -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity"></div>

<!-- SIDEBAR -->
<aside id="main-sidebar"
    class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-zinc-900 border-r border-gray-200 dark:border-zinc-800 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:flex flex-col">
    <div class="p-6 flex items-center justify-between">
        <a href="{{ url('/') }}">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="h-10">
        </a>
        <!-- Tombol Close (Hanya muncul di mobile) -->
        <button id="sidebar-close" class="lg:hidden text-2xl dark:text-white">
            <i class="ri-close-line"></i>
        </button>
    </div>

    <nav class="flex-1 px-4 space-y-2 overflow-y-auto mt-4">
        <a href="{{ route('participants.index') }}"
            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('participants.index') ? 'text-white bg-black dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-xl font-semibold transition-all">
            <i class="ri-dashboard-fill text-xl"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('participants.conferences') }}"
            class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('participants.conferences') ? 'text-white bg-black dark:bg-white dark:text-black' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800' }} rounded-xl font-semibold transition-all">
            <i class="ri-presentation-fill text-xl"></i>
            <span>Conference</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
        <p class="text-xs text-gray-400 text-center uppercase tracking-widest font-bold">ICPIP-HE 2026</p>
    </div>
</aside>
