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
                                    src="{{ !empty($dataBerita->foto) && file_exists(public_path('storage/foto_opini/' . $dataBerita->foto))
                                        ? asset('storage/foto_opini/' . $dataBerita->foto)
                                        : asset('storage/foto_opini/opini-default.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Berita' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    {{ $dataBerita->judul ?? 'Judul Tidak Tersedia' }}
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><a href="#"><i class="fa fa-user"></i>
                                            {{ $dataBerita->penulis ?? 'Admin' }}</a></li>
                                    <li><a href="#"><i class="fa fa-book"></i>
                                            {{ $dataBerita->kategori ?? 'Berita' }}</a></li>
                                </ul>

                                <p class="excert">
                                    @php
                                        $pisah = explode(',', $dataBerita->ringkasan);
                                    @endphp

                                    @foreach ($pisah as $pisahkan)
                                        @if (trim($pisahkan) !== '')
                                            #{{ trim($pisahkan) }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endif
                                    @endforeach
                                </p>
                                <hr>
                                <p class="excert">
                                    {!! $dataBerita->isi !!}
                                </p>
                                <hr>
                                <p class="excert">
                                    @if (!empty($dataBerita->lampiran) && Storage::disk('public')->exists('file/' . $dataBerita->lampiran))
                                        <a href="{{ asset('storage/file/' . $dataBerita->lampiran) }}" target="_blank">
                                            <button type="button"
                                                class="inline-block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-all shadow-lg shadow-emerald-900/40">
                                                Download File Lampiran
                                            </button>
                                        </a>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 italic">Lampiran tidak tersedia</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Notifikasi Sukses --}}
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Notifikasi Error (Pesan Manual) --}}
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Notifikasi Error Validasi Form --}}
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('opini_warga') }}" method="GET">
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
                                            <a href="{{ route('opini_warga', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
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
                                            <img src="{{ !empty($post->foto) && Storage::disk('public')->exists('foto_opini/' . $post->foto)
                                                ? asset('storage/foto_opini/' . $post->foto)
                                                : asset('storage/foto_opini/opini-default-sm.jpeg') }}"
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
                                    @if (isset($tags) && $tags->count() > 0)
                                        @foreach ($tags as $kata => $jumlah)
                                            <li>
                                                <a href="{{ route('opini_warga', ['keyword' => $kata]) }}">
                                                    {{ $kata }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <span class="text-muted" style="padding: 5px 0; display: block;">Belum ada tag
                                                tersedia</span>
                                        </li>
                                    @endif
                                </ul>
                            </aside>
                        </div>
                    </div>
                    <div class="banner-area white-bg pt-90 pb-90">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-md-10">
                                    <div class="banner-one">
                                        <a href="{{ route('opini.create') }}" target="_blank">
                                            <img src="{{ asset('storage/foto/ayoopini.jpeg') }}" alt="Gabung Sekarang">
                                        </a>
                                    </div>
                                </div>
                            </div>
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
