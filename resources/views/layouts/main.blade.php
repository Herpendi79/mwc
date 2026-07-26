<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-mode="light">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Portal') | MWC NU TUGU</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="ICPIP-HE 2026" name="description">
    <meta content="SRBThemes" name="author">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Portal || MWC TUGU">
    <meta property="og:description"
        content="International Conference on Policy, Innovation, and Practice in Higher Education">

    <!-- 1. SCRIPT PENGUNCI ARAH (Harus paling atas) -->
    <script>
        (function() {
            const savedDir = localStorage.getItem('paxvent_direction') || 'ltr';
            document.documentElement.setAttribute('dir', savedDir);
        })();
    </script>

    <link rel="shortcut icon" href="{{ asset('assets/images/MWC_TUGU.ico') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sal.js/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">

    <!-- VITE DIPINDAHKAN KE HEAD AGAR AUTO-REFRESH BERJALAN -->
    @vite(['resources/js/app.js'])

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

        [x-cloak] {
            display: none !important;
        }

        /* Sidebar lebih smooth */
        #main-sidebar {
            backface-visibility: hidden;
            transform: translateZ(0);
            will-change: transform;
        }

        /* Scrollbar */
        #main-sidebar nav::-webkit-scrollbar {
            width: 6px;
        }

        #main-sidebar nav::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 9999px;
        }

        .dark #main-sidebar nav::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }

        /* Hover */
        #main-sidebar a,
        #main-sidebar button {
            transition:
                background-color .25s ease,
                color .25s ease,
                transform .15s ease;
        }

        #main-sidebar a:hover,
        #main-sidebar button:hover {
            transform: translateX(3px);
        }

        /* Active submenu */
        #main-sidebar .font-extrabold {
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .no-fouc {
            visibility: hidden;
            opacity: 0;
        }

        [dir="rtl"] .ml-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }

        [dir="rtl"] .mr-auto {
            margin-left: auto !important;
            margin-right: 0 !important;
        }
    </style>

    <script>
        document.documentElement.className += ' no-fouc';
        window.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.remove('no-fouc');
        });
    </script>

    @yield('styles')
</head>

<body class="font-body">

    @yield('content')

    <!-- Scroll To Top -->
    <button id="scrollTopBtn"
        class="fixed bottom-20 right-6 z-[9999] bg-[#c0f037]/90 text-black p-3 rounded-full shadow-lg">
        <i class="ri-arrow-up-line text-xl"></i>
    </button>

    @include('partials.direction')

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    @yield('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- 1. DROPDOWN PROFIL ---
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            // --- 2. MOBILE SIDEBAR (Sinkron dengan ID baru) ---
            const mobileMenuBtn = document.getElementById("mobile-menu-btn");
            const mobileSidebar = document.getElementById("main-sidebar");
            const mobileCloseBtn = document.getElementById("sidebar-close");

            if (mobileMenuBtn && mobileSidebar) {
                mobileMenuBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    mobileSidebar.classList.remove("-translate-x-full");
                });
            }

            if (mobileCloseBtn && mobileSidebar) {
                mobileCloseBtn.addEventListener("click", () => {
                    mobileSidebar.classList.add("-translate-x-full");
                });
            }

            // --- 3. MOBILE DROPDOWN ---
            const dropdownBtns = document.querySelectorAll(".mobile-dropdown-btn");
            dropdownBtns.forEach((btn) => {
                btn.addEventListener("click", function() {
                    const content = btn.nextElementSibling;
                    if (content && content.classList.contains("mobile-dropdown-content")) {
                        const plusIcon = btn.querySelector(".ri-add-line");
                        const minusIcon = btn.querySelector(".ri-subtract-line");

                        if (content.style.maxHeight) {
                            content.style.maxHeight = null;
                            if (plusIcon) plusIcon.classList.remove("hidden");
                            if (minusIcon) minusIcon.classList.add("hidden");
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                            if (plusIcon) plusIcon.classList.add("hidden");
                            if (minusIcon) minusIcon.classList.remove("hidden");
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>
