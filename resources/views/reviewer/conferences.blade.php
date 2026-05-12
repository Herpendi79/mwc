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
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Conference Monitoring</h2>
                            <p class="text-gray-500">Select a conference to review participants and submissions.</p>
                        </div>

                        <div class="force-show" data-sal="slide-up" data-sal-duration="1000">
                            <div
                                class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                                <div class="p-6 border-b border-gray-100 dark:border-zinc-800">
                                    <h3 class="text-lg font-bold dark:text-white">All Conferences</h3>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 dark:bg-zinc-800/50">
                                                <th class="p-4 text-gray-500 font-semibold text-sm text-left">Conference
                                                    Name</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm text-center">Valid
                                                    Registrants
                                                </th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm text-center">Waiting for
                                                    Payment Validation
                                                </th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm text-center">Presenter
                                                </th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm text-center">Participant
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                                            @forelse($conferences as $conf)
                                                <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                                                    <td class="p-4">
                                                        <div class="font-bold dark:text-white">
                                                            {{ \Illuminate\Support\Str::limit($conf->nama_conf, 50, '...') }}
                                                        </div>
                                                        <div class="text-[10px] text-red-400">Deadline:
                                                            {{ $conf->deadline_subm->format('d M Y') }}</div>
                                                        <div class="text-[10px] text-green-400">Event Date:
                                                            {{ $conf->tgl_mulai->format('d M') }} -
                                                            {{ $conf->tgl_selesai->format('d M Y') }}</div>
                                                    </td>

                                                    {{-- Total All --}}
                                                    <td class="p-4 text-center">
                                                        <span
                                                            class="font-bold dark:text-white">{{ $conf->total_per_conf }}</span>
                                                    </td>

                                                    {{-- Payment validation --}}
                                                    <td class="p-4 text-center">
                                                        <div
                                                            class="inline-flex items-center px-2 py-1 bg-red-500/10 text-red-600 rounded-lg text-xs font-bold">
                                                            <i class="ri-book-line mr-1"></i>
                                                            {{ $conf->antrean_review }}
                                                        </div>
                                                        <a href="{{ route('reviewer.registrantwaitvalid.list', $conf->id_conf) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm"
                                                            style="font-size: 10px; background-color: #e20000; border: none;">
                                                            <i class="mdi mdi-download me-1"></i> View
                                                        </a>
                                                    </td>
                                                    {{-- Presenter --}}
                                                    <td class="p-4 text-center">
                                                        <div
                                                            class="inline-flex items-center px-2 py-1 bg-green-500/10 text-green-600 rounded-lg text-xs font-bold">
                                                            <i class="ri-mic-line mr-1"></i>
                                                            {{ $conf->total_presenter }}
                                                        </div>
                                                        <a href="{{ route('reviewer.presenters.list', $conf->id_conf) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm"
                                                            style="font-size: 10px; background-color: #246809; border: none;">
                                                            <i class="mdi mdi-download me-1"></i> View
                                                        </a>
                                                    </td>

                                                    {{-- Participant --}}
                                                    <td class="p-4 text-center">
                                                        <div
                                                            class="inline-flex items-center px-2 py-1 bg-blue-500/10 text-blue-600 rounded-lg text-xs font-bold">
                                                            <i class="ri-user-line mr-1"></i>
                                                            {{ $conf->total_participant }}
                                                        </div>
                                                        <a href="{{ route('reviewer.participants.list', $conf->id_conf) }}"
                                                            class="btn btn-sm btn-primary rounded-pill px-3 fw-bold text-white shadow-sm"
                                                            style="font-size: 10px; background-color: #0d6efd; border: none;">
                                                            <i class="mdi mdi-download me-1"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="p-12 text-center text-gray-400 italic">No
                                                        conferences found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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
