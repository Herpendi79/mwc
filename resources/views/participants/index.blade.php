@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <style>
        /* 1. Memastikan elemen tetap tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* 2. Sembunyikan berbagai kemungkinan selector button scroll up melalui CSS */
        .scroll-to-top,
        #scroll-top,
        .back-to-top,
        .scroll-top,
        .rn-backto-top,
        [id*="scroll"],
        [class*="backto"],
        [class*="scroll-top"],
        .fixed.bottom-5.right-5,
        .bg-primary.rounded-circle {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">

        {{-- Memanggil Sidebar --}}
        @include('participants.partials._sidebar')

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Memanggil Navbar --}}
            @include('participants.partials._navbar')

            <!-- DASHBOARD CONTENT -->
            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <!-- Welcome Section -->
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Welcome, {{ Auth::user()->name }}!</h2>
                            <p class="text-gray-500">Manage your participation in our conference here.</p>
                        </div>

                        <div class="grid grid-cols-12 gap-6">
                            <!-- Total Participants Card -->
                            <div class="col-span-12 md:col-span-4 force-show" data-sal="zoom-in" data-sal-delay="300">
                                <div
                                    class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                                    <!-- Ikon diganti menjadi Group/User Fill -->
                                    <div
                                        class="size-12 rounded-full bg-[#37bdf0]/20 flex items-center justify-center text-[#37bdf0] mb-4">
                                        <i class="ri-group-fill text-2xl"></i>
                                    </div>

                                    <h4 class="text-gray-500 text-sm uppercase tracking-widest mb-1 text-left">
                                        Total Registered
                                    </h4>

                                    <p class="text-2xl font-bold dark:text-white text-left">
                                        {{ number_format($totalPeserta) }} Participants
                                    </p>
                                </div>
                            </div>

                            <!-- Category Card -->
                            <!-- Abstract Status Card -->
                            <div class="col-span-12 md:col-span-4 force-show" data-sal="zoom-in" data-sal-delay="200">
                                <div
                                    class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                                    <div
                                        class="size-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 mb-4">
                                        <i class="ri-file-list-3-line text-2xl"></i>
                                    </div>
                                    <h4 class="text-gray-500 text-sm uppercase tracking-widest mb-1 text-left">Abstract
                                        Status</h4>
                                    <p class="text-xl font-bold dark:text-white text-left">
                                        @if ($submission && $submission->status_abstract)
                                            <span class="text-green-500">{{ ucwords($submission->status_abstract) }}</span>
                                        @else
                                            <span class="text-gray-400">No Submission</span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Article Status Card -->
                            <div class="col-span-12 md:col-span-4 force-show" data-sal="zoom-in" data-sal-delay="200">
                                <div
                                    class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                                    <div
                                        class="size-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500 mb-4">
                                        <i class="ri-article-line text-2xl"></i>
                                    </div>
                                    <h4 class="text-gray-500 text-sm uppercase tracking-widest mb-1 text-left">Article
                                        Status</h4>
                                    <p class="text-xl font-bold dark:text-white text-left">
                                        @if ($submission && $submission->status_artikel)
                                            <span class="text-yellow-500">{{ ucwords($submission->status_artikel) }}</span>
                                        @else
                                            <span class="text-gray-400">Not Uploaded</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Memanggil Footer --}}
                    @include('participants.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
    <script>
        // SCRIPT PENGHAPUS OTOMATIS (Force Removal)
        function removeScrollButton() {
            // Daftar selector yang sering digunakan tombol scroll up
            const selectors = [
                '.scroll-to-top', '#scroll-top', '.back-to-top', '.rn-backto-top',
                '.fixed.bottom-5.right-5', '.scroll-top'
            ];

            selectors.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.remove(); // Hapus permanen dari DOM
                }
            });
        }

        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', removeScrollButton);

        // Jalankan lagi setelah beberapa detik (antisipasi delay JS template)
        setTimeout(removeScrollButton, 1000);
        setTimeout(removeScrollButton, 3000);

        // Jalankan saat user melakukan scroll
        window.addEventListener('scroll', removeScrollButton);

        document.addEventListener('DOMContentLoaded', function() {

            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const btnOpen = document.getElementById('sidebar-open');
            const btnClose = document.getElementById('sidebar-close');
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Mencegah event bubbling
                    profileDropdown.classList.toggle('hidden');
                });

                // Menutup dropdown jika klik di luar area profile
                window.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                // Mencegah body scroll saat menu terbuka di mobile
                document.body.classList.toggle('overflow-hidden');
            }

            // Event Listeners
            if (btnOpen) btnOpen.addEventListener('click', toggleSidebar);
            if (btnClose) btnClose.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            // Otomatis tutup sidebar jika layar di-resize ke desktop
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) { // 1024px adalah breakpoint 'lg' Tailwind
                    sidebar.classList.add('-translate-x-full'); // Reset status mobile
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            });
        });
    </script>
@endsection
