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
        <section class="blog_area single-post-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 posts-list">
                        <div class="single-post">
                            <div class="feature-img">
                                <img class="img-fluid"
                                    src="{{ !empty($dataBerita->foto) && file_exists(public_path('storage/foto_bahsul/' . $dataBerita->foto))
                                        ? asset('storage/foto_bahsul/' . $dataBerita->foto)
                                        : asset('storage/foto_bahsul/bahsul' . rand(1, 6) . '.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Berita' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    {{ $dataBerita->judul ?? 'Judul Tidak Tersedia' }}
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><a href="#"><i class="fa fa-user"></i>
                                            {{ $dataBerita->pemohon ?? 'Warga' }}</a></li>
                                    <li><a href="#"><i class="fa fa-book"></i>
                                            {{ $dataBerita->kategori ?? 'Bahsul' }}</a></li>
                                    <li><a href="#"><i class="fa fa-calendar"></i>
                                            {{ $dataBerita->tanggal ?? 'Tanggal' }}</a></li>
                                </ul>
                                <label style="font-weight: bold;">Permasalahan / Pertanyaan:</label>
                                <p class="excert">
                                    {!! $dataBerita->masalah !!}
                                </p>
                                <hr>
                                <label style="font-weight: bold;">Putusan :</label>
                                <p class="excert">
                                    {!! !empty($dataBerita->putusan) && trim($dataBerita->putusan) !== '-'
                                        ? $dataBerita->putusan
                                        : 'masih dalam kajian' !!}
                                </p>

                                <hr>

                                <label style="font-weight: bold;">Dasar Hukum:</label>
                                <p class="excert">
                                    {!! !empty($dataBerita->dasar_hukum) && trim($dataBerita->dasar_hukum) !== '-'
                                        ? $dataBerita->dasar_hukum
                                        : 'masih dalam kajian' !!}
                                </p>

                                <hr>

                                <label style="font-weight: bold;">Lampiran:</label>
                                @if (
                                    !empty($dataBerita->lampiran) &&
                                        trim($dataBerita->lampiran) !== '-' &&
                                        file_exists(public_path('storage/file/' . $dataBerita->lampiran)))
                                    <a href="{{ asset('storage/file/' . $dataBerita->lampiran) }}" target="_blank"
                                        style="display: flex; align-items: center; text-decoration: none; margin-top: 5px;">
                                        <div
                                            style="width: 40px; height: 40px; background: #eef5f5; display: flex; align-items: center; justify-content: center; margin-right: 15px; border-radius: 5px; flex-shrink: 0;">
                                            <i class="ti-download" style="color: #008080;"></i>
                                        </div>
                                        <span>Download Lampiran</span>
                                    </a>
                                @else
                                    <p class="excert">masih dalam kajian</p>
                                @endif
                            </div>
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
                                <h4 class="widget_title">Archives</h4>
                                <ul class="list cat-list">
                                    @foreach ($archives as $arc)
                                        <li>
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
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        <div class="media post_item">
                                            <img src="{{ !empty($post->poster) && file_exists(public_path('storage/foto_bahsul/' . $post->poster))
                                                ? asset('storage/foto_bahsul/' . $post->poster)
                                                : asset('storage/foto_bahsul/bahsul' . rand(1, 6) . '.jpeg') }}"
                                                alt="post" style="width: 80px; height: 80px; object-fit: cover;">
                                            <div class="media-body">
                                                <a href="#">
                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->judul, 70) }}
                                                    </h3>
                                                </a>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ $post->updated_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Download Materi</h3>
                                <div class="materi-vertical-slider">
                                    @foreach ($beritaPosts->take(10) as $post)
                                        <div class="media post_item"
                                            style="margin-bottom: 15px; display: flex; align-items: center;">
                                            <div class="media-body"
                                                style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                                <h4 style="margin: 0; font-size: 14px; color: #444; flex: 1;">
                                                    {{ Str::limit($post->judul, 30) }}
                                                </h4>
                                                <a href="{{ asset('storage/file/' . $post->lampiran) }}" target="_blank">
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
                                            <a href="{{ route('bahsul', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================ Blog Area end =================-->
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

            initVerticalSlider('.materi-vertical-slider');
            initVerticalSlider('.relawan-vertical-active');
            initVerticalSlider('#roan-container');
        });
    </script>
@endsection
