@extends('layouts.main_free')

@section('title', 'Portal MWC NU Tugu')

@section('content')
<style>
        .relawan-vertical-active {
            max-height: 320px; /* Sesuaikan tinggi agar muat sekitar 3 item */
            overflow: hidden;
        }
        .relawan-vertical-active .post_item {
            margin-bottom: 15px !important;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }
        .relawan-vertical-active .post_item:last-child {
            border-bottom: none;
        }
    </style>
    <!-- Preloader Start -->
    <div id="preloader-active" style="background: white !important;">
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <img src="{{ asset('assets/images/MWC_TUGU.ico') }}" alt="Logo" width="100" height="100"
                style="border:0 !important;">
        </div>
    </div>
    <!-- Preloader Start -->
    @include('partials.header')
    <main>
        <!--================Blog Area =================-->
        <section class="blog_area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        @if ($errors->any())
                            <div
                                class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 p-4 rounded-2xl mb-6 border border-red-200 dark:border-red-800">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Menangkap session('error') dari controller --}}
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Menampilkan Pesan Sukses --}}
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="blog_left_sidebar">
                            <!-- Alpine.js state didefinisikan di sini mencakup id yang aktif -->
                            <div x-data="{ openModal: false, activeHalaqahId: null }">
                                @foreach ($dataHalaqah as $halaqah)
                                    <article class="blog_item">

                                        <div class="blog_details">

                                            <!-- Memotong deskripsi menjadi 35 kata -->
                                            <blockquote
                                                class="p-4 my-4 bg-gray-100 border-l-4 border-emerald-600 rounded-r-lg text-lg text-gray-800 italic">
                                                {!! html_entity_decode(htmlspecialchars_decode($halaqah->isi)) !!}
                                            </blockquote>

                                            <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                                <ul class="blog-info-link mb-0">
                                                    <!-- Ganti menjadi Pemateri -->
                                                    <li><a href="#"><i class="fa fa-user"></i>
                                                            {{ $halaqah->mubaligh }}</a>
                                                    </li>
                                                    <!-- Ganti menjadi Lokasi -->
                                                    <li><a href="#"><i class="fa fa-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($halaqah->tgl)->translatedFormat('d F Y') }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach

                                <!-- Pagination -->
                                <nav class="blog-pagination justify-content-center d-flex">
                                    {{ $dataHalaqah->links('vendor.pagination.custom') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('pesan_dakwah') }}" method="GET">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="keyword"
                                                placeholder='Search Keyword' value="{{ request('keyword') }}"
                                                onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Search Keyword'">
                                            <div class="input-group-append">
                                                <button class="btns" type="submit"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                        type="submit">Search</button>
                                </form>
                                </aside>

                                <aside class="single_sidebar_widget post_category_widget">
                                    <h4 class="widget_title">Archives</h4>
                                    <ul class="list cat-list">
                                        @foreach ($archives as $arc)
                                            <li>
                                                {{-- Link ke route halaqah_warga dengan filter bulan dan tahun --}}
                                                <a href="{{ route('pesan_dakwah', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
                                                    class="d-flex">
                                                    <p>
                                                        {{ \Carbon\Carbon::create($arc->year, $arc->month)->format('F Y') }}
                                                    </p>
                                                    <p>({{ $arc->total }})</p>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </aside>


                                <aside class="single_sidebar_widget popular_post_widget">
                                    <h3 class="widget_title">Recent Post</h3>

                                    <!-- Pastikan class ini sama dengan yang di-inisialisasi di script -->
                                    <div class="relawan-vertical-active">
                                        @foreach ($recentPosts as $post)
                                            <div class="media post_item">

                                                <div class="media-body">
                                                    <a href="#">
                                                        <!-- Hapus margin pada h3 agar tidak mendorong teks ke bawah -->
                                                        <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                            {{ Str::limit($post->mubaligh, 70) }}
                                                        </h3>
                                                    </a>
                                                    <p style="margin: 0; font-size: 12px;">
                                                        {{ \Carbon\Carbon::parse($post->tgl)->translatedFormat('d F Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </aside>

                                <aside class="single_sidebar_widget">
                                    <div class="banner_img">
                                        <a href="{{ route('bencana') }}">
                                            <img class="img-fluid" src="{{ asset('storage/foto_bencana/ayo.jpeg') }}"
                                                alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                        </a>
                                    </div>
                                </aside>
                                <aside class="single_sidebar_widget">
                                    <div class="banner_img">
                                        <a href="{{ route('mangrove') }}">
                                            <img class="img-fluid" src="{{ asset('storage/foto_mangrove/ayo.jpeg') }}"
                                                alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                        </a>
                                    </div>
                                </aside>
                                <aside class="single_sidebar_widget">
                                    <div class="banner_img">
                                        <a href="{{ route('sampah') }}">
                                            <img class="img-fluid" src="{{ asset('storage/foto_sampah/ayo.jpeg') }}"
                                                alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                        </a>
                                    </div>
                                </aside>
                                <aside class="single_sidebar_widget">
                                    <div class="banner_img">
                                        <a href="{{ route('register') }}">
                                            <img class="img-fluid" src="{{ asset('storage/foto_bahsul/gabung2.jpeg') }}"
                                                alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                        </a>
                                    </div>
                                </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================Blog Area =================-->
    </main>
    @include('partials.footer')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            function initVerticalSlider(selector) {
                if ($(selector).length && !$(selector).hasClass('slick-initialized')) {
                    $(selector).slick({
                        vertical: true,
                        verticalSwiping: true,
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay: true,
                        autoplaySpeed: 2500,
                        arrows: false,
                        dots: false,
                        infinite: true,
                        pauseOnHover: true
                    });
                }
            }

            // Panggil untuk widget Download Materi Anda
            initVerticalSlider('.materi-vertical-slider');

            // Panggil untuk yang lain
            initVerticalSlider('.relawan-vertical-active');
            initVerticalSlider('#roan-container');
        });
    </script>
@endsection
