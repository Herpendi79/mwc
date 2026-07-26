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
                                    src="{{ !empty($dataBerita->poster) && file_exists(public_path('storage/foto_relawan/' . $dataBerita->poster))
                                        ? asset('storage/foto_relawan/' . $dataBerita->poster)
                                        : asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Berita' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    {{ $dataBerita->judul ?? 'Judul Tidak Tersedia' }}
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><a href="#"><i class="fa fa-user"></i>
                                            {{ $dataBerita->koordinator ?? 'Admin' }}</a></li>
                                    <li><a href="#"><i class="fa fa-map-marker"></i>
                                            {{ $dataBerita->lokasi ?? 'Jakarta' }}</a></li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-calendar"></i>
                                            {{ isset($dataBerita->tgl) ? \Carbon\Carbon::parse($dataBerita->tanggal)->locale('id')->translatedFormat('d F Y') : '-' }}
                                        </a>
                                    </li>
                                </ul>

                                <label style="font-weight: bold;">Deskripsi:</label>
                                <p class="excert">
                                    {!! $dataBerita->deskripsi !!}
                                </p>
                                <hr>
                                <label style="font-weight: bold;">Jumlah Korban:</label>
                                <p class="excert">
                                    {!! $dataBerita->jml_korban !!} Jiwa
                                </p>
                                <hr>
                                <label style="font-weight: bold;">Kebutuhan Mendesak:</label>
                                <p class="excert">
                                    {!! $dataBerita->bantuan !!}
                                </p>
                                <hr>
                                <label style="font-weight: bold;">Galeri Foto:</label>
                                <div class="excert" style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 8px;">
                                    @if (!empty($dataBerita->foto))
                                        @php
                                            // Memecah string berdasarkan tanda titik koma (;) menjadi array
                                            $listFoto = explode(';', $dataBerita->foto);
                                            $hasValidPhoto = false;
                                        @endphp

                                        @foreach ($listFoto as $foto)
                                            @php
                                                $trimmedFoto = trim($foto);
                                            @endphp

                                            {{-- Validasi: Pastikan nama file tidak kosong DAN file fisiknya ada di storage --}}
                                            @if ($trimmedFoto !== '' && Storage::disk('public')->exists('foto_relawan/' . $trimmedFoto))
                                                @php
                                                    $urlFoto = asset('storage/foto_relawan/' . $trimmedFoto);
                                                    $hasValidPhoto = true;
                                                @endphp
                                                <div style="width: 200px; height: 200px;">
                                                    <a href="{{ $urlFoto }}" target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ $urlFoto }}" alt="Foto Galeri"
                                                            style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; display: block; transition: transform 0.2s;"
                                                            onmouseover="this.style.transform='scale(1.03)'"
                                                            onmouseout="this.style.transform='scale(1)'">
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach

                                        {{-- Jika di database ada string foto, tapi satupun file fisiknya tidak ditemukan di storage --}}
                                        @if (!$hasValidPhoto)
                                            <p class="text-muted">Belum ada foto galeri.</p>
                                        @endif
                                    @else
                                        <p class="text-muted">Belum ada foto galeri.</p>
                                    @endif
                                </div>
                                <hr>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('relawan') }}" method="GET">
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
                                            <a href="{{ route('relawan', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
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
                                            <img src="{{ !empty($post->poster) && file_exists(public_path('storage/foto_relawan/' . $post->poster))
                                                ? asset('storage/foto_relawan/' . $post->poster)
                                                : asset('storage/foto_relawan/relawan-default.jpeg') }}"
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

                            <aside class="single_sidebar_widget tag_cloud_widget">
                                <h4 class="widget_title">Tag Clouds</h4>
                                <ul class="list">
                                    @foreach ($tags as $kata => $jumlah)
                                        <li>
                                            <a href="{{ route('relawan', ['keyword' => $kata]) }}">
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
