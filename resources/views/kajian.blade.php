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

                            @foreach ($dataKajian as $kajian)
                                <article class="blog_item">
                                    <div class="blog_item_img">
                                        <!-- Logika gambar: Cek apakah ada file, jika tidak pakai default -->
                                        <img class="card-img rounded-0"
                                            src="{{ !empty($kajian->poster) && Storage::disk('public')->exists('foto_kajian/' . $kajian->poster)
                                                ? asset('storage/foto_kajian/' . $kajian->poster)
                                                : asset('storage/foto_kajian/kajian-default.jpeg') }}"
                                            alt="{{ $kajian->tema ?? 'Default Tema' }}"
                                            style="width: 750px; height: 375px; object-fit: cover; display: block;">

                                        <a href="{{ route('kajian.detil', $kajian->id) }}" class="blog_item_date">
                                            <h3>{{ date('d', strtotime($kajian->created_at)) }}</h3>
                                            <p>{{ date('M', strtotime($kajian->created_at)) }}</p>
                                        </a>
                                    </div>

                                    <div class="blog_details">
                                        <a class="d-inline-block" href="{{ route('kajian.detil', $kajian->id) }}">
                                            <h2>{{ $kajian->tema }}</h2>
                                        </a>
                                        <!-- Memotong deskripsi menjadi 25 kata -->
                                        <p>{{ Str::words(strip_tags($kajian->deskripsi), 35, '...') }}...</p>

                                        <ul class="blog-info-link">
                                            <!-- Ganti menjadi Pemateri -->
                                            <li><a href="{{ route('kajian.detil', $kajian->id) }}"><i
                                                        class="fa fa-user"></i> {{ $kajian->pemateri }}</a>
                                            </li>
                                            <!-- Ganti menjadi Lokasi -->
                                            <li><a href="{{ route('kajian.detil', $kajian->id) }}"><i
                                                        class="fa fa-map-marker"></i> {{ $kajian->lokasi }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            @endforeach

                            <!-- Pagination -->
                            <nav class="blog-pagination justify-content-center d-flex">
                                {{ $dataKajian->links('vendor.pagination.custom') }}
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('berita') }}" method="GET">
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
                                            <!-- Link ke route berita dengan filter kategori -->
                                            <a href="{{ route('kajian', ['keyword' => $k->judul]) }}" class="d-flex">
                                                <p>{{ $k->judul }}</p>
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
                                            {{-- Link ke route berita dengan filter bulan dan tahun --}}
                                            <a href="{{ route('berita', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
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
                                            <img src="{{ !empty($post->poster) && Storage::disk('public')->exists('foto_kajian/' . $post->poster)
                                                ? asset('storage/foto_kajian/' . $post->poster)
                                                : asset('storage/foto_kajian/kajian-default.jpeg') }}"
                                                alt="post" style="width: 80px; height: 80px; object-fit: cover;">

                                            <div class="media-body">
                                                <a href="{{ route('kajian.detil', $kajian->id) }}">
                                                    <!-- Hapus margin pada h3 agar tidak mendorong teks ke bawah -->
                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->tema, 70) }}
                                                    </h3>
                                                </a>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ $post->updated_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <!-- Widget Baru: List Materi -->
                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Download Materi</h3>

                                <div class="materi-vertical-slider">
                                    @foreach ($materiPosts->take(10) as $post)
                                        <!-- Tambahkan d-flex dan align-items-center di sini -->
                                        <div class="media post_item"
                                            style="margin-bottom: 15px; display: flex; align-items: center;">

                                            <!-- Icon -->

                                            <!-- Body (Flex agar Judul dan Tombol sejajar) -->
                                            <div class="media-body"
                                                style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">

                                                <!-- Judul -->
                                                <h4 style="margin: 0; font-size: 14px; color: #444; flex: 1;">
                                                    {{ Str::limit($post->judul, 30) }}
                                                </h4>

                                                <!-- Tombol Download -->
                                                <a href="{{ asset('storage/file/' . $post->materi) }}" target="_blank">

                                                    <div
                                                        style="width: 40px; height: 40px; background: #eef5f5; display: flex; align-items: center; justify-content: center; margin-right: 15px; border-radius: 5px; flex-shrink: 0;">
                                                        <i class="ti-download" style="color: #008080;"></i>
                                                    </div>
                                                </a>
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
                                            <a href="{{ route('berita', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>

                            <aside class="single_sidebar_widget">
                                <h4 class="widget_title">Video Kajian</h4>
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
                                                    !empty($listKajian[$i]) && !empty($listKajian[$i]->link_yt)
                                                        ? $listKajian[$i]->link_yt
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
