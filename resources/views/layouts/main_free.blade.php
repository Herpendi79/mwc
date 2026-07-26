<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" data-mode="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Portal') | MWC NU TUGU</title>
    <style>
        /* CSS Dasar untuk semua trend-top-img agar rapi */
        .trend-top-img {
            position: relative !important;
            overflow: hidden !important;
        }

        .trend-top-img img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        /* Pengaturan Ukuran Spesifik */

        /* 1. Large: 750x645 */
        .img-large {
            width: 750px !important;
            height: 645px !important;
        }

        /* 2. Medium: 381x408 */
        .img-medium {
            width: 381px !important;
            height: 408px !important;
        }

        /* 3. Small: 381x226 */
        .img-small {
            width: 381px !important;
            height: 226px !important;
        }

        #roan-container,
        .relawan-vertical-active,
        .sampah-vertical-active,
        .mangrove-vertical-active {
            height: 400px;
            overflow: hidden;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video-items iframe {
            display: block !important;
            visibility: visible !important;
        }

        .footer-tittle .footer-pera {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }

        .info1 {
            font-size: 20px;
            font-weight: 600;
            /* Tebal */
            color: #ffffff;
            /* Putih agar kontras */
            margin-bottom: 10px;
            letter-spacing: 0.5px;
        }

        .info2 {
            font-size: 14px;
            font-weight: 300;
            /* Tipis agar elegan */
            color: #cccccc;
            /* Abu-abu terang agar tidak terlalu mencolok */
            margin-bottom: 5px;
        }

        /* Efek hover pada nomor telepon jika diinginkan */
        .info2:hover {
            color: #ffcc00;
            /* Berubah warna saat terkena mouse */
            transition: 0.3s;
        }

        /* Menerapkan font ke seluruh menu */
        #navigation li a {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            transition: all 0.3s ease-in-out;
        }

        /* Efek saat kursor diarahkan ke menu */
        #navigation li a:hover {
            color: #008080 !important;
            /* Contoh warna hijau NU */
        }

        /* Mempercantik submenu */
        .submenu li a {
            font-size: 13px !important;
            text-transform: capitalize !important;
        }

        /* Mengatur ukuran dan jarak sosial media */
        .header-social li a {
            font-size: 16px;
            color: #333;
        }

        /* Menghindari layout bergeser saat gambar belum load */
        .relawan-vertical-active {
            height: 360px;
            /* (80px tinggi gambar + margin/padding) * 3 slide */
            overflow: hidden;
        }

        /* Pastikan item memiliki jarak agar tidak dempet */
        .relawan-vertical-active .post_item {
            margin-bottom: 20px;
            display: flex;
        }

        /* Memastikan item dalam slider tetap flex dan rapi */
        .relawan-vertical-active .media.post_item {
            display: flex !important;
            /* Memaksa sejajar kiri-kanan */
            flex-direction: row !important;
            /* Baris */
            align-items: flex-start !important;
            /* Rata atas */
            margin-bottom: 15px !important;
        }

        /* Memberikan jarak antara gambar dan teks */
        .relawan-vertical-active .media.post_item img {
            margin-right: 15px !important;
            flex-shrink: 0;
            /* Agar gambar tidak menciut */
        }

        /* Memastikan media-body mengambil sisa ruang */
        .relawan-vertical-active .media-body {
            flex: 1;
            min-width: 0;
            /* Mencegah teks panjang merusak layout */
        }

        .tag_cloud_widget .list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            /* Jarak antar tag */
        }

        .tag_cloud_widget .list li a {
            display: block;
            padding: 5px 15px;
            background: #f9f9f9;
            border: 1px solid #eee;
            border-radius: 4px;
            color: #777;
            font-size: 14px;
            /* Ukuran dasar yang nyaman dibaca */
            text-transform: capitalize;
            transition: all 0.3s ease;
        }

        .tag_cloud_widget .list li a:hover {
            background: #008080;
            /* Warna khas NU */
            color: #fff;
            border-color: #008080;
        }

        /* 1. Reset dan Paksa Tampilan */
        .blog-pagination .pagination .page-item {
            float: none !important;
            display: inline-block !important;
            margin: 0 5px !important;
        }

        /* 2. Paksa Link agar terlihat */
        .blog-pagination .pagination .page-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            color: #333333 !important;
            /* Warna teks */
            background: #ffffff !important;
            /* Latar belakang putih */
            border: 1px solid #cccccc !important;
            /* Garis tepi agar kotak jelas */
            border-radius: 5px !important;
            text-decoration: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            z-index: 10 !important;
        }

        /* 3. Paksa Icon agar terlihat */
        .blog-pagination .pagination .page-link i {
            color: #333333 !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* 4. Tampilan saat aktif */
        .blog-pagination .pagination .page-item.active .page-link {
            background-color: #008080 !important;
            color: #ffffff !important;
            border-color: #008080 !important;
        }

        .materi-vertical-slider {
            height: 250px;
            overflow: hidden;
        }

        .materi-vertical-slider .post_item {
            /* Memastikan setiap item memiliki padding yang cukup */
            padding: 5px 0;
            border-bottom: 1px solid #f0f0f0;
            /* Opsional: garis pembatas antar materi */
        }

        /* Memastikan link/judul tidak terpotong */
        .materi-vertical-slider a {
            text-decoration: none;
        }

        select {
            display: block !important;
            background-image: none !important;
            padding: 0.75rem !important;
            /* Sesuaikan dengan p-3 tailwind */
        }

        /* Sembunyikan elemen buatan library JS jika ada */
        .nice-select,
        .select2-container {
            display: none !important;
        }
    </style>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/MWC_TUGU.ico') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Masukkan script Alpine.js ini jika belum ada di layout utama -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/ticker-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style3.css') }}">
</head>

<body class="font-body">

    @yield('content')

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>


    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('assets/js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- Date Picker -->
    <script src="{{ asset('assets/js/gijgo.min.js') }}"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/animated.headline.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.js') }}"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.sticky.js') }}"></script>

    <!-- contact js -->
    <script src="{{ asset('assets/js/contact.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/mail-script.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @yield('scripts')
</body>

</html>
