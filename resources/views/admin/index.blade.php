@extends('layouts.main')

@section('title', 'Admin Dashboard')

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
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Selamat Datang</h2>
                            <p class="text-gray-500">Berikut ringkasan data yang terdapat dalam sistem:</p>
                        </div>

                        @php
                            $cards = [
                                [
                                    'title' => 'Anggota',
                                    'count' => $data['total_anggota'],
                                    'icon' => 'ri-user-line',
                                    'color' => 'blue',
                                ],
                                [
                                    'title' => 'Bahtsul Masail',
                                    'count' => $data['total_bahsul'],
                                    'icon' => 'ri-book-line',
                                    'color' => 'indigo',
                                ],
                                [
                                    'title' => 'Halaqah',
                                    'count' => $data['total_halaqah'],
                                    'icon' => 'ri-group-line',
                                    'color' => 'purple',
                                ],
                                [
                                    'title' => 'Pengajian',
                                    'count' => $data['total_kajian'],
                                    'icon' => 'ri-mic-line',
                                    'color' => 'orange',
                                ],
                                [
                                    'title' => 'Peserta Relawan Banjir',
                                    'count' => $data['total_relawan'],
                                    'icon' => 'ri-hand-heart-line',
                                    'color' => 'rose',
                                ],
                                [
                                    'title' => 'Peserta Roan Pantai',
                                    'count' => $data['total_roan'],
                                    'icon' => 'ri-leaf-line',
                                    'color' => 'teal',
                                ],
                                [
                                    'title' => 'Lapor Bencana',
                                    'count' => $data['total_bencana'],
                                    'icon' => 'ri-alert-line',
                                    'color' => 'red',
                                ],
                                [
                                    'title' => 'Opini',
                                    'count' => $data['total_opini'],
                                    'icon' => 'ri-chat-quote-line',
                                    'color' => 'amber',
                                ],
                                [
                                    'title' => 'Pesan Dakwah',
                                    'count' => $data['total_dakwah'],
                                    'icon' => 'ri-message-3-line',
                                    'color' => 'sky',
                                ],
                                [
                                    'title' => 'Khutbah Jumat',
                                    'count' => $data['total_khutbah'],
                                    'icon' => 'ri-book-open-line',
                                    'color' => 'emerald',
                                ],
                                [
                                    'title' => 'Infaq Mangrove',
                                    'count' => 'Rp ' . number_format($data['total_mangrove'], 0, ',', '.'),
                                    'icon' => 'ri-seedling-line',
                                    'color' => 'green',
                                ],
                                [
                                    'title' => 'Sedekah Sampah',
                                    'count' => 'Rp ' . number_format($data['total_sampah'], 0, ',', '.'),
                                    'icon' => 'ri-recycle-line',
                                    'color' => 'yellow',
                                ],
                            ];
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            @foreach ($cards as $card)
                                <div class="col-span-1 force-show" data-sal="zoom-in"
                                    data-sal-delay="{{ $loop->iteration * 50 }}">
                                    <div
                                        class="bg-white dark:bg-zinc-900 p-6 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm hover:border-gray-300 dark:hover:border-zinc-700 transition-all">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="size-12 rounded-full bg-{{ $card['color'] }}-500/10 flex items-center justify-center text-{{ $card['color'] }}-500">
                                                <i class="{{ $card['icon'] }} text-2xl"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-gray-500 text-xs uppercase tracking-widest font-semibold">
                                                    {{ $card['title'] }}</h4>
                                                <p class="text-xl font-bold dark:text-white">{{ $card['count'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    {{-- Memanggil Footer --}}
                    @include('admin.partials._footer')
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
