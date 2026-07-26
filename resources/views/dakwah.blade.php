@extends('layouts.main_free')

@section('title', 'Portal MWC NU Tugu')

@section('content')
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
                        <div class="blog_left_sidebar">

                            @foreach ($dataDakwah as $dakwah)
                                <article class="blog_item">
                                    <div class="blog_item_img">
                                        @php
                                            $fileName = !empty($dakwah->poster)
                                                ? $dakwah->poster
                                                : 'dakwah-default.jpeg';
                                            $path = public_path('storage/foto_dakwah/' . $fileName);

                                            // 3. Verifikasi apakah file benar-benar ada
                                            $finalImage = file_exists($path) ? $fileName : 'dakwah-default.jpeg';
                                        @endphp

                                        <img class="card-img rounded-0"
                                            src="{{ asset('storage/foto_dakwah/' . $finalImage) }}"
                                            alt="{{ $dakwah->judul }}"
                                            style="width: 750px; height: 375px; object-fit: cover; display: block;">

                                        <a href="#" class="blog_item_date">
                                            <h3>{{ date('d', strtotime($dakwah->created_at)) }}</h3>
                                            <p>{{ date('M', strtotime($dakwah->created_at)) }}</p>
                                        </a>
                                    </div>

                                    <div class="blog_details">
                                        <a class="d-inline-block" href="#">
                                            <h2>{{ $dakwah->judul }}</h2>
                                        </a>
                                        <!-- Memotong deskripsi menjadi 25 kata -->
                                        <p>{{ Str::words(strip_tags($dakwah->isi), 35, '...') }}...</p>

                                        <ul class="blog-info-link">
                                            <!-- Ganti menjadi Pemateri -->
                                            <li><a href="#"><i class="fa fa-user"></i> {{ $dakwah->mubaligh }}</a>
                                            </li>
                                            <!-- Ganti menjadi Lokasi -->
                                            <li><a href="#"><i class="fa fa-book"></i> {{ $dakwah->kategori }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            @endforeach

                            <!-- Pagination -->
                            <nav class="blog-pagination justify-content-center d-flex">
                                {{ $dataDakwah->links('vendor.pagination.custom') }}
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('dakwah') }}" method="GET">
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
                                <h4 class="widget_title">Category</h4>
                                <ul class="list cat-list">
                                    @foreach ($kategoriList as $k)
                                        <li>
                                            <!-- Link ke route dakwah dengan filter kategori -->
                                            <a href="{{ route('dakwah', ['keyword' => $k->kategori]) }}" class="d-flex">
                                                <p>{{ $k->kategori }}</p>
                                                <p>({{ $k->total }})</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>

                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title">Archives</h4>
                                <ul class="list cat-list">
                                    @foreach ($archives as $arc)
                                        <li>
                                            {{-- Link ke route dakwah dengan filter bulan dan tahun --}}
                                            <a href="{{ route('dakwah', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
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
                                        <div class="media post_item"
                                            style="display: flex; align-items: center; margin-bottom: 15px;">
                                            @php
                                                // 1. Tentukan nama file, jika null/kosong pakai default
                                                $fileName = !empty($post->poster)
                                                    ? trim($post->poster)
                                                    : 'dakwah.jpeg';

                                                // 2. Cek keberadaan file di folder fisik
                                                $path = public_path('storage/foto_dakwah/' . $fileName);
                                                $finalImage = file_exists($path) ? $fileName : 'dakwah.jpeg';
                                            @endphp

                                            <img src="{{ asset('storage/foto_dakwah/' . $finalImage) }}" alt="post"
                                                style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 4px;">

                                            <div class="media-body">
                                                <a href="#">
                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->judul, 70) }}
                                                    </h3>
                                                </a>
                                                <p style="margin: 0; font-size: 12px; color: #888;">
                                                    {{ $post->updated_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <aside class="single_sidebar_widget tag_cloud_widget">
                                <h4 class="widget_title">Tag Clouds</h4>
                                <ul class="list">
                                    @foreach ($tags as $kata => $jumlah)
                                        <li>
                                            {{-- Menggunakan route pencarian yang sudah Anda buat --}}
                                            <a href="{{ route('dakwah', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>

                            <aside class="single_sidebar_widget">
                                <h4 class="widget_title">Video dakwah</h4>
                                <div class="video-gallery">
                                    @php
                                        $fallbacks = [
                                            'https://www.youtube.com/watch?v=wQCLmF0YLHQ',
                                            'https://www.youtube.com/watch?v=NsoxvcuwMfQ',
                                            'https://www.youtube.com/watch?v=2o90JKsJjEU',
                                            'https://www.youtube.com/watch?v=17N1OrW2TbU',
                                            'https://www.youtube.com/watch?v=Bvve2GQfNIk',
                                        ];

                                        // Fungsi helper untuk ID YouTube
                                        $getVideoId = function ($url) {
                                            preg_match(
                                                '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                                $url,
                                                $matches,
                                            );
                                            return $matches[1] ?? 'wQCLmF0YLHQ';
                                        };
                                    @endphp

                                    @for ($i = 0; $i < 5; $i++)
                                        <div class="single-video" style="margin-bottom: 15px;">
                                            @php
                                                // Ambil dari DB jika ada, jika tidak pakai fallback berdasarkan index
                                                $url =
                                                    !empty($listdakwah[$i]) && !empty($listdakwah[$i]->link_yt)
                                                        ? $listdakwah[$i]->link_yt
                                                        : $fallbacks[$i];
                                                $videoId = $getVideoId($url);
                                            @endphp

                                            <iframe width="100%" height="160"
                                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @endfor
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
