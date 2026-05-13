<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-mode="light">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'ADAKSI') | ICPIP-HE 2026</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="ICPIP-HE 2026" name="description">
    <meta content="SRBThemes" name="author">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="ADAKSI || ICPIP-HE 2026">
    <meta property="og:description"
        content="International Conference on Policy, Innovation, and Practice in Higher Education">

    <!-- 1. SCRIPT PENGUNCI ARAH (Harus paling atas) -->
    <script>
        (function() {
            const savedDir = localStorage.getItem('paxvent_direction') || 'ltr';
            document.documentElement.setAttribute('dir', savedDir);
        })();
    </script>

    <link rel="shortcut icon" href="{{ asset('assets/images/stempel.ico') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/sal.js/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}">

    <style>
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

    <!-- JS Assets (PERBAIKAN: sal.init.js sebagai MODULE) -->
    <script src="{{ asset('assets/js/header.js') }}" defer></script>
    <script src="{{ asset('assets/js/sal.init.js') }}" type="module"></script> <!-- Tambahkan type="module" -->
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>

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


    <!-- 2. SCRIPT PAKSA RTL/LTR (Bungkus dalam Try-Catch agar tidak mati karena error lain) -->
    <script>
        (function() {
            try {
                document.addEventListener('click', function(e) {
                    const target = e.target.closest(
                        '[data-tool="rtl-ltr"], .ltr-btn, .rtl-btn, #ltr-mode, #rtl-mode');
                    if (target) {
                        setTimeout(() => {
                            const currentDir = document.documentElement.getAttribute('dir');
                            localStorage.setItem('paxvent_direction', currentDir);
                            window.dispatchEvent(new Event('resize'));
                        }, 100);
                    }
                });

                window.addEventListener('load', function() {
                    const savedDir = localStorage.getItem('paxvent_direction');
                    if (savedDir) {
                        document.documentElement.setAttribute('dir', savedDir);
                        window.dispatchEvent(new Event('resize'));
                    }
                });
            } catch (err) {
                console.error("RTL Script Error:", err);
            }
        })();

        document.addEventListener("DOMContentLoaded", function() {

            // MOBILE SIDEBAR
            const mobileMenuBtn = document.getElementById("mobile-menu-btn");
            const mobileCloseBtn = document.getElementById("mobile-close-btn");
            const mobileSidebar = document.querySelector(".fixed.inset-y-0.left-0");

            if (mobileMenuBtn && mobileSidebar) {
                mobileMenuBtn.addEventListener("click", () => {
                    mobileSidebar.classList.remove("-translate-x-full");
                });
            }

            if (mobileCloseBtn && mobileSidebar) {
                mobileCloseBtn.addEventListener("click", () => {
                    mobileSidebar.classList.add("-translate-x-full");
                });
            }

            // MOBILE DROPDOWN
            const dropdownBtns = document.querySelectorAll(".mobile-dropdown-btn");

            dropdownBtns.forEach((btn) => {

                btn.addEventListener("click", function() {

                    const content = btn.nextElementSibling;

                    // cek apakah punya submenu
                    if (
                        content &&
                        content.classList.contains("mobile-dropdown-content")
                    ) {

                        const plusIcon = btn.querySelector(".ri-add-line");
                        const minusIcon = btn.querySelector(".ri-subtract-line");

                        // toggle submenu
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

    @vite(['resources/js/app.js'])
    @yield('scripts')

</body>

</html>
