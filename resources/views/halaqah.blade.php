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
                                        <div class="blog_item_img">
                                            <!-- Logika gambar: Cek apakah ada file, jika tidak pakai default -->
                                            <img class="card-img rounded-0"
                                                src="{{ !empty($halaqah->thumbnail) && Storage::disk('public')->exists('foto_halaqah/' . $halaqah->thumbnail)
                                                    ? asset('storage/foto_halaqah/' . $halaqah->thumbnail)
                                                    : asset('storage/foto_halaqah/default-halaqah.jpeg') }}"
                                                alt="{{ $halaqah->judul ?? 'Default Title' }}"
                                                style="width: 750px; height: 375px; object-fit: cover; display: block;">

                                            <a href="{{ route('halaqah.detil', $halaqah->id) }}" target="_blank"
                                                class="blog_item_date">
                                                <h3>{{ date('d', strtotime($halaqah->tanggal)) }}</h3>
                                                <p>{{ date('M', strtotime($halaqah->tanggal)) }}</p>
                                            </a>
                                        </div>

                                        <div class="blog_details">
                                            <a class="d-inline-block" href="{{ route('halaqah.detil', $halaqah->id) }}"
                                                target="_blank">
                                                <h2>{{ $halaqah->judul }}</h2>
                                            </a>

                                            <!-- Memotong deskripsi menjadi 35 kata -->
                                            <p>{{ Str::words(strip_tags($halaqah->deskripsi), 35, '...') }}...</p>

                                            <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                                <ul class="blog-info-link mb-0">
                                                    <!-- Ganti menjadi Pemateri -->
                                                    <li><a href="{{ route('halaqah.detil', $halaqah->id) }}"
                                                            target="_blank"><i class="fa fa-user"></i>
                                                            {{ $halaqah->narsum }}</a>
                                                    </li>
                                                    <!-- Ganti menjadi Lokasi -->
                                                    <li><a href="{{ route('halaqah.detil', $halaqah->id) }}"
                                                            target="_blank"><i class="fa fa-map-marker"></i>
                                                            {{ $halaqah->lokasi }}</a></li>
                                                </ul>

                                                <div>
                                                    @if (\Carbon\Carbon::parse($halaqah->tanggal)->endOfDay()->isFuture())
                                                        <button type="button"
                                                            @click="openModal = true; activeHalaqahId = '{{ $halaqah->id }}'"
                                                            class="inline-block px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl transition-all shadow-sm">
                                                            Daftar Sekarang
                                                        </button>
                                                    @else
                                                        <span
                                                            class="inline-block px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-sm font-medium rounded-xl">
                                                            Kegiatan Telah Berakhir
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </article>

                                    {{-- KOMPONEN MODAL (Popup Form) --}}
                                    <div x-show="openModal && activeHalaqahId === '{{ $halaqah->id }}'"
                                        style="display: none;"
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

                                        <div @click.outside="openModal = false"
                                            class="bg-white dark:bg-gray-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl border border-gray-100 dark:border-gray-700">

                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Form Pendaftaran
                                                    Kegiatan</h3>
                                                <button @click="openModal = false"
                                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-white font-bold text-xl">&times;</button>
                                            </div>

                                            <form action="{{ route('halaqah.daftar', $halaqah->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" x-model="activeHalaqahId">

                                                <div class="mb-4">
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nama
                                                        Lengkap</label>
                                                    <input type="text" name="name" required
                                                        placeholder="Masukkan nama lengkap"
                                                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                                </div>

                                                <div class="mb-4">
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
                                                    <input type="text" name="alamat" required
                                                        placeholder="Masukkan alamat lengkap"
                                                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                                </div>

                                                <div class="mb-4">
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                                                    <input type="email" name="email" required
                                                        placeholder="nama@email.com"
                                                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                                </div>

                                                <div class="mb-6">
                                                    <label
                                                        class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor
                                                        Telepon / WhatsApp</label>
                                                    <input type="tel" name="telpon" required placeholder="08xxxxxxxxxx"
                                                        class="w-full px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-white focus:ring-2 focus:ring-emerald-500 outline-none">
                                                </div>

                                                <div class="flex justify-end gap-3">
                                                    <button type="button" @click="openModal = false"
                                                        class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit"
                                                        class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-medium hover:bg-emerald-700 transition shadow-sm">
                                                        Kirim Pendaftaran
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                                <form action="{{ route('halaqah') }}" method="GET">
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
                                            <!-- Link ke route halaqah_warga dengan filter kategori -->
                                            <a href="{{ route('halaqah', ['keyword' => $k->judul]) }}" class="d-flex">
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
                                            {{-- Link ke route halaqah_warga dengan filter bulan dan tahun --}}
                                            <a href="{{ route('halaqah', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
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
                                            <img src="{{ !empty($post->thumbnail) && Storage::disk('public')->exists('foto_halaqah/' . $post->thumbnail)
                                                ? asset('storage/foto_halaqah/' . $post->thumbnail)
                                                : asset('storage/foto_halaqah/default-halaqah.jpeg') }}"
                                                alt="post" style="width: 80px; height: 80px; object-fit: cover;">

                                            <div class="media-body">
                                                <a href="{{ route('halaqah.detil', $post->id) }}" target="_blank">
                                                    <!-- Hapus margin pada h3 agar tidak mendorong teks ke bawah -->
                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->judul, 70) }}
                                                    </h3>
                                                </a>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ $post->tanggal->diffForHumans() }}</p>
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
                                            <a href="{{ route('halaqah', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="single_sidebar_widget instagram_feeds">
                                <h4 class="widget_title">Galery Halaqah</h4>

                                {{-- Container diatur lebar 280px agar pas untuk 3 kolom (90px*3 + gap) --}}
                                <ul class="instagram_row"
                                    style="display: flex; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; gap: 5px; width: 280px;">

                                    @php
                                        $count = 0;
                                        $maxPhotos = 12;
                                    @endphp

                                    @foreach ($dataHalaqah as $item)
                                        @php
                                            $photos = !empty($item->foto)
                                                ? explode(';', $item->foto)
                                                : ['default-halaqah.jpeg'];
                                        @endphp

                                        @foreach ($photos as $foto)
                                            @if ($count < $maxPhotos)
                                                <li style="width: 90px; height: 90px;">
                                                    <a href="{{ route('halaqah.detil', $halaqah->id) }}" target="_blank">
                                                        <img class="img-fluid"
                                                            src="{{ asset('storage/foto_halaqah/' . trim($foto)) }}"
                                                            alt="Foto Halaqah"
                                                            style="width: 90px; height: 90px; object-fit: cover; border-radius: 4px; display: block;">
                                                    </a>
                                                </li>
                                                @php $count++; @endphp
                                            @endif
                                        @endforeach

                                        @if ($count >= $maxPhotos)
                                            @break
                                        @endif
                                    @endforeach
                                </ul>
                            </aside>

                            <aside class="single_sidebar_widget">
                                <h4 class="widget_title">Video Halaqah</h4>
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
