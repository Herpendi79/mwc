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
                        @if (session('success'))
                            <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="blog_left_sidebar">

                            @foreach ($dataOpini as $opini)
                                <article class="blog_item">
                                    <div class="blog_item_img">
                                        <!-- Logika gambar: Cek apakah ada file, jika tidak pakai default -->
                                        <img class="card-img rounded-0"
                                            src="{{ !empty($opini->foto) && Storage::disk('public')->exists('foto_opini/' . $opini->foto)
                                                ? asset('storage/foto_opini/' . $opini->foto)
                                                : asset('storage/foto_opini/opini-default.jpeg') }}"
                                            alt="{{ $opini->judul ?? 'Default Title' }}"
                                            style="width: 750px; height: 375px; object-fit: cover; display: block;">

                                        <a href="{{ route('opini.detil', $opini->id_op) }}" target="_blank"
                                            class="blog_item_date">
                                            <h3>{{ date('d', strtotime($opini->created_at)) }}</h3>
                                            <p>{{ date('M', strtotime($opini->created_at)) }}</p>
                                        </a>
                                    </div>

                                    <div class="blog_details">
                                        <a class="d-inline-block" href="{{ route('opini.detil', $opini->id_op) }}"
                                            target="_blank">
                                            <h2>{{ $opini->judul }}</h2>
                                        </a>
                                        <!-- Memotong deskripsi menjadi 25 kata -->
                                        <p>{{ Str::words(strip_tags($opini->isi), 35, '...') }}...</p>

                                        <ul class="blog-info-link">
                                            <!-- Ganti menjadi Pemateri -->
                                            <li><a href="{{ route('opini.detil', $opini->id_op) }}" target="_blank"><i
                                                        class="fa fa-user"></i> {{ $opini->penulis }}</a>
                                            </li>
                                            <!-- Ganti menjadi Lokasi -->
                                            <li><a href="{{ route('opini.detil', $opini->id_op) }}" target="_blank"><i
                                                        class="fa fa-book"></i> {{ $opini->kategori }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </article>
                            @endforeach

                            <!-- Pagination -->
                            <nav class="blog-pagination justify-content-center d-flex">
                                {{ $dataOpini->links('vendor.pagination.custom') }}
                            </nav>
                        </div>
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
                                <h4 class="widget_title">Category</h4>
                                <ul class="list cat-list">
                                    @foreach ($kategoriList as $k)
                                        <li>
                                            <!-- Link ke route opini_warga dengan filter kategori -->
                                            <a href="{{ route('opini_warga', ['keyword' => $k->kategori]) }}"
                                                class="d-flex">
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
                                            {{-- Link ke route opini_warga dengan filter bulan dan tahun --}}
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

                                <!-- Pastikan class ini sama dengan yang di-inisialisasi di script -->
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        <div class="media post_item">
                                            <img src="{{ !empty($post->foto) && Storage::disk('public')->exists('foto_opini/' . $post->foto)
                                                ? asset('storage/foto_opini/' . $post->foto)
                                                : asset('storage/foto_opini/opini-default-sm.jpeg') }}"
                                                alt="post" style="width: 80px; height: 80px; object-fit: cover;">

                                            <div class="media-body">
                                                <a href="{{ route('opini.detil', $opini->id_op) }}" target="_blank">
                                                    <!-- Hapus margin pada h3 agar tidak mendorong teks ke bawah -->
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
                                    @if (isset($tags) && $tags->count() > 0)
                                        @foreach ($tags as $kata => $jumlah)
                                            <li>
                                                {{-- Mengirimkan kata kunci tag ke route pencarian opini --}}
                                                <a href="{{ route('opini_warga', ['keyword' => $kata]) }}">
                                                    {{ $kata }}
                                                    {{-- Opsional: Menampilkan jumlah kemunculan tag jika diperlukan --}}
                                                    {{-- <span style="font-size: 11px; opacity: 0.7;">({{ $jumlah }})</span> --}}
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
