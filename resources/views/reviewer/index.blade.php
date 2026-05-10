@extends('layouts.main')

@section('title', 'Conference Monitoring')

@section('content')
    <style>
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

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
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        {{-- Memanggil Sidebar --}}
        @include('reviewer.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('reviewer.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Conference Management</h2>
                            <p class="text-gray-500">Summary of our Conferences.</p>
                        </div>

                        <div class="grid grid-cols-12 gap-6 mb-8">

                            <div class="col-span-12 md:col-span-6 force-show" data-sal="zoom-in" data-sal-delay="300">
                                <div
                                    class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="size-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500 mb-4">
                                            <i class="ri-calendar-check-line text-2xl"></i>
                                        </div>
                                        {{-- Badge indikator kecil --}}
                                        <span
                                            class="bg-green-100 text-green-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Running</span>
                                    </div>
                                    <h4 class="text-gray-500 text-sm uppercase tracking-widest mb-1 text-left">Active
                                        Conferences</h4>
                                    <p class="text-2xl font-bold dark:text-white text-left">{{ $totalActive }} <span
                                            class="text-sm font-normal text-gray-400">Events</span></p>
                                </div>
                            </div>

                            <div class="col-span-12 md:col-span-6 force-show" data-sal="zoom-in" data-sal-delay="400">
                                <div
                                    class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div
                                            class="size-12 rounded-full bg-red-500/10 flex items-center justify-center text-red-500 mb-4">
                                            <i class="ri-history-line text-2xl"></i>
                                        </div>
                                        <span
                                            class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Finished</span>
                                    </div>
                                    <h4 class="text-gray-500 text-sm uppercase tracking-widest mb-1 text-left">Passed
                                        Conferences</h4>
                                    <p class="text-2xl font-bold dark:text-white text-left">{{ $totalPassed }} <span
                                            class="text-sm font-normal text-gray-400">Events</span></p>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Memanggil Footer --}}
                    @include('reviewer.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
    <script>
        function removeScrollButton() {
            const selectors = ['.scroll-to-top', '#scroll-top', '.back-to-top', '.rn-backto-top', '.fixed.bottom-5.right-5',
                '.scroll-top'
            ];
            selectors.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) element.remove();
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            removeScrollButton();
            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const btnOpen = document.getElementById('sidebar-open');
            const btnClose = document.getElementById('sidebar-close');
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                window.addEventListener('click', (e) => {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
            if (btnOpen) btnOpen.addEventListener('click', toggleSidebar);
            if (btnClose) btnClose.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
        window.addEventListener('scroll', removeScrollButton);
    </script>
@endsection
