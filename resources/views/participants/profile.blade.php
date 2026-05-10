@extends('layouts.main')

@section('title', 'Profile Settings')

@section('content')
    <style>
        /* 1. Memastikan elemen tetap tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* 2. Sembunyikan berbagai kemungkinan selector button scroll up melalui CSS (Copy dari Index) */
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

        /* Paksa teks input agar terlihat jelas */
        .form-input-custom {
            color: #1a1a1a !important;
            background-color: #f9f9f9 !important;
        }

        .dark .form-input-custom {
            color: #ffffff !important;
            background-color: #27272a !important;
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">

        {{-- Memanggil Sidebar --}}
        @include('participants.partials._sidebar')

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Memanggil Navbar --}}
            @include('participants.partials._navbar')

            <!-- CONTENT -->
            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <!-- Header Section -->
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Profile Settings</h2>
                            <p class="text-gray-500">Update your personal information and account security.</p>
                        </div>

                        @if (session('success'))
                            <div
                                class="bg-[#c0f037]/20 border border-[#c0f037] text-[#065039] font-bold px-4 py-3 rounded-2xl mb-6 force-show">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div
                            class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 p-8 shadow-sm force-show">
                            <form action="{{ route('profile.update') }}" method="POST" id="profileForm" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Full
                                            Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                            class="w-full border border-gray-200 dark:border-zinc-700 rounded-xl px-4 py-3 form-input-custom shadow-sm outline-none focus:border-[#c0f037]">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                                            Email
                                        </label>
                                        <input type="text" name="email" value="{{ old('email', $user->email) }}"
                                            disabled
                                            class="w-full border border-gray-200 dark:border-zinc-700 rounded-xl px-4 py-3 
                                            shadow-sm outline-none cursor-not-allowed
                                            /* Warna untuk mode terang (Light Mode) */
                                            bg-gray-100 text-gray-500 
                                            /* Warna untuk mode gelap (Dark Mode) */
                                            dark:bg-zinc-800 dark:text-zinc-500">
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Country</label>
                                        <select id="countrySelect" name="country" required
                                            class="w-full border border-gray-200 dark:border-zinc-700 rounded-xl px-4 py-3 form-input-custom shadow-sm outline-none focus:border-[#c0f037] appearance-none cursor-pointer">
                                            <option value="" disabled>Loading countries...</option>
                                        </select>
                                    </div>

                                    <!-- WhatsApp -->
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">WhatsApp
                                            Number</label>
                                        <div
                                            class="flex border border-gray-200 dark:border-zinc-700 rounded-xl overflow-hidden focus-within:border-[#c0f037] transition-all shadow-sm">
                                            <span id="phoneCode"
                                                class="inline-flex items-center px-4 bg-gray-100 dark:bg-zinc-800 text-gray-500 font-bold border-r border-gray-200 dark:border-zinc-700">
                                                +..
                                            </span>
                                            <input type="number" name="whatsapp"
                                                value="{{ old('whatsapp', $user->peserta->no_wa) }}" required
                                                class="w-full px-4 py-3 form-input-custom outline-none focus:ring-0 border-none">
                                        </div>
                                    </div>


                                </div>

                                <hr class="border-gray-100 dark:border-zinc-800 my-4">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">New Password
                                            (Min. 8 characters)</label>
                                        <input type="password" name="password" id="password" placeholder="••••••••"
                                            class="w-full border border-gray-200 dark:border-zinc-700 rounded-xl px-4 py-3 form-input-custom shadow-sm outline-none">
                                        <p class="text-[10px] text-gray-400 mt-1 italic">*Leave blank to keep current
                                            password.</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Confirm New
                                            Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="••••••••"
                                            class="w-full border border-gray-200 dark:border-zinc-700 rounded-xl px-4 py-3 form-input-custom shadow-sm outline-none">
                                        <p id="password-error" class="text-red-500 text-[11px] mt-2 hidden">Passwords do not
                                            match!</p>
                                    </div>
                                </div>

                                <div class="pt-4 text-left">
                                    <button type="submit" id="submitBtn"
                                        class="bg-black dark:bg-white text-white dark:text-black font-bold px-10 py-4 rounded-2xl hover:scale-[1.02] transition-all shadow-lg">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
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
        // SCRIPT PENGHAPUS OTOMATIS (Force Removal - Copy dari Index)
        function removeScrollButton() {
            const selectors = [
                '.scroll-to-top', '#scroll-top', '.back-to-top', '.rn-backto-top',
                '.fixed.bottom-5.right-5', '.scroll-top'
            ];
            selectors.forEach(selector => {
                const element = document.querySelector(selector);
                if (element) {
                    element.remove();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // 1. Inisialisasi Removal
            removeScrollButton();
            setInterval(removeScrollButton, 500);

            // 2. Load Countries (REST API)
            const countrySelect = document.getElementById('countrySelect');
            const phoneCodeSpan = document.getElementById('phoneCode');
            const userCountry = "{{ $user->peserta->negara }}";

            fetch('https://restcountries.com/v3.1/all?fields=name,idd')
                .then(response => response.json())
                .then(data => {
                    const countries = data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                    countrySelect.innerHTML = '<option value="" disabled>Select Country</option>';

                    countries.forEach(country => {
                        const name = country.name.common;
                        const root = country.idd.root || '';
                        const suffix = (country.idd.suffixes && country.idd.suffixes.length > 0) ?
                            country.idd.suffixes[0] : '';
                        const code = root + suffix;

                        if (code) {
                            const option = document.createElement('option');
                            option.value = name;
                            option.setAttribute('data-code', code);
                            option.textContent = name;
                            option.className = "text-black";
                            if (name === userCountry) option.selected = true;
                            countrySelect.appendChild(option);
                        }
                    });
                    updatePhoneCode();
                });

            function updatePhoneCode() {
                const selectedOption = countrySelect.options[countrySelect.selectedIndex];
                if (selectedOption && selectedOption.getAttribute('data-code')) {
                    phoneCodeSpan.textContent = selectedOption.getAttribute('data-code');
                }
            }
            countrySelect.addEventListener('change', updatePhoneCode);

            // 3. Password Validation Logic
            const pwd = document.getElementById('password');
            const pwdConf = document.getElementById('password_confirmation');
            const errorMsg = document.getElementById('password-error');
            const submitBtn = document.getElementById('submitBtn');

            function checkPasswords() {
                if (pwdConf.value.length > 0 && pwd.value !== pwdConf.value) {
                    errorMsg.classList.remove('hidden');
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                } else {
                    errorMsg.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                }
            }
            pwd.addEventListener('keyup', checkPasswords);
            pwdConf.addEventListener('keyup', checkPasswords);
        });

        // Trigger on scroll just in case
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
