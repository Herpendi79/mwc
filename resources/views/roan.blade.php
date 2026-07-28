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
                    <!-- Konten Utama (Kiri - 8 Kolom) -->
                    <div class="col-lg-8 mb-5 mb-lg-0">
                        {{-- Menampilkan Error Validasi Laravel --}}
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
                            @php
                                $folderPath = public_path('storage/foto_roan');
                                $files = File::exists($folderPath) ? File::files($folderPath) : [];
                                $bahsulPhotos = array_map(fn($file) => $file->getFilename(), $files);
                                $totalPhotos = count($bahsulPhotos);
                            @endphp

                            <div x-data="{ openModal: false, selectedBahsulId: null }">
                                @foreach ($dataBahsul as $index => $bahsul)
                                    <article class="blog_item mb-5">
                                        <div class="blog_item_img">
                                            @php
                                                $currentPhoto =
                                                    $totalPhotos > 0
                                                        ? $bahsulPhotos[$index % $totalPhotos]
                                                        : 'roan-default.jpeg';
                                            @endphp

                                            <img class="card-img rounded-0"
                                                src="{{ asset('storage/foto_roan/' . $currentPhoto) }}"
                                                alt="{{ $bahsul->tema }}"
                                                style="width: 100%; height: 375px; object-fit: cover; display: block;">

                                            <a href="{{ route('roan.detil', $bahsul->id_ro) }}" target="_blank"
                                                class="blog_item_date">
                                                <h3>{{ date('d', strtotime($bahsul->tgl)) }}</h3>
                                                <p>{{ date('M', strtotime($bahsul->tgl)) }}</p>
                                            </a>
                                        </div>

                                        <div class="blog_details">
                                            <a class="d-inline-block" href="{{ route('roan.detil', $bahsul->id_ro) }}"
                                                target="_blank">
                                                <h2>{{ $bahsul->judul }}</h2>
                                            </a>
                                            <p>{{ Str::words(strip_tags($bahsul->deskripsi), 35, '...') }}...</p>

                                            <div class="flex flex-wrap items-center justify-between gap-4 mt-4">
                                                <ul class="blog-info-link mb-0">
                                                    <li><a href="{{ route('roan.detil', $bahsul->id_ro) }}"
                                                            target="_blank"><i class="fa fa-user"></i>
                                                            {{ $bahsul->pj }}</a></li>
                                                    <li><a href="{{ route('roan.detil', $bahsul->id_ro) }}"
                                                            target="_blank"><i class="fa fa-map-marker"></i>
                                                            {{ $bahsul->lokasi }}</a></li>
                                                </ul>

                                                <div>
                                                    @if (\Carbon\Carbon::parse($bahsul->tgl)->endOfDay()->isFuture())
                                                        <button type="button"
                                                            @click="openModal = true; selectedBahsulId = '{{ $bahsul->id_ro }}'"
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
                                    <div x-show="openModal && selectedBahsulId === '{{ $bahsul->id_ro }}'"
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

                                            <form action="{{ route('roan.daftar', $bahsul->id_ro) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id_ro" x-model="selectedBahsulId">

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
                                                        class="px-5 py-2 rounded-xl bg-blue-600 text-white font-medium hover:bg-blue-700 transition shadow-sm">
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
                            </div>

                            <!-- Pagination -->
                            <nav class="blog-pagination justify-content-center d-flex mt-4">
                                {{ $dataBahsul->links('vendor.pagination.custom') }}
                            </nav>
                        </div>
                    </div>

                    <!-- Sidebar Kanan (Kanan - 4 Kolom) -->
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <!-- Search Widget -->
                            <aside class="single_sidebar_widget search_widget">
                                <form action="{{ route('relawan') }}" method="GET">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="keyword"
                                                placeholder='Search Keyword' value="{{ request('keyword') }}">
                                            <div class="input-group-append">
                                                <button class="btns" type="submit"><i class="ti-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                        type="submit">Search</button>
                                </form>
                            </aside>

                            <!-- Category Widget -->
                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title">Category</h4>
                                <ul class="list cat-list">
                                    @foreach ($kategoriList as $k)
                                        <li>
                                            <a href="{{ route('roan', ['keyword' => $k->judul]) }}" class="d-flex">
                                                <p>{{ $k->judul }}</p>
                                                <p>({{ $k->total }})</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>

                            <!-- Archives Widget -->
                            <aside class="single_sidebar_widget post_category_widget">
                                <h4 class="widget_title">Archives</h4>
                                <ul class="list cat-list">
                                    @foreach ($archives as $arc)
                                        <li>
                                            <a href="{{ route('roan', ['bulan' => $arc->month, 'tahun' => $arc->year]) }}"
                                                class="d-flex">
                                                <p>{{ \Carbon\Carbon::create($arc->year, $arc->month)->format('F Y') }}</p>
                                                <p>({{ $arc->total }})</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>

                            <!-- Recent Post Widget -->
                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Recent Post</h3>
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $index => $post)
                                        <div class="media post_item"
                                            style="display: flex; align-items: center; margin-bottom: 15px;">
                                            @php
                                                $photoName =
                                                    $totalPhotos > 0 ? $bahsulPhotos[$index % $totalPhotos] : null;
                                                $pathFisik = 'foto_roan/' . $photoName;

                                                // Validasi menggunakan Storage disk public agar konsisten
                                                $photoTersedia =
                                                    !empty($photoName) &&
                                                    $photoName !== 'none' &&
                                                    Storage::disk('public')->exists($pathFisik);

                                                $urlPhoto = $photoTersedia
                                                    ? asset('storage/' . $pathFisik)
                                                    : asset('storage/foto_roan/roan-default.jpeg');
                                            @endphp

                                            <img src="{{ $urlPhoto }}" alt="post"
                                                style="width: 80px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 4px;">

                                            <div class="media-body">
                                                <a href="{{ route('roan.detil', $bahsul->id_ro) }}" target="_blank">
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


                            <!-- Tag Clouds Widget -->
                            <aside class="single_sidebar_widget tag_cloud_widget">
                                <h4 class="widget_title">Tag Clouds</h4>
                                <ul class="list">
                                    @foreach ($tags as $kata => $jumlah)
                                        <li>
                                            <a href="{{ route('roan', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>


                            <aside class="single_sidebar_widget instagram_feeds">
                                <h4 class="widget_title">Galery Roan</h4>

                                {{-- Container diatur lebar 280px agar pas untuk 3 kolom (90px*3 + gap) --}}
                                <ul class="instagram_row"
                                    style="display: flex; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; gap: 5px; width: 280px;">

                                    @php
                                        $count = 0;
                                        $maxPhotos = 12;
                                    @endphp

                                    @foreach ($dataBahsul as $item)
                                        @php
                                            $photos =
                                                !empty($item->foto) && $item->foto !== 'none'
                                                    ? explode(';', $item->foto)
                                                    : ['roan-default.jpeg'];
                                        @endphp

                                        @foreach ($photos as $foto)
                                            @if ($count < $maxPhotos)
                                                @php
                                                    $fotoName = trim($foto);
                                                    $pathFisik = 'foto_roan/' . $fotoName;

                                                    // Validasi menggunakan Storage disk public agar konsisten
                                                    $fotoTersedia =
                                                        !empty($fotoName) &&
                                                        $fotoName !== 'none' &&
                                                        Storage::disk('public')->exists($pathFisik);

                                                    $urlFoto = $fotoTersedia
                                                        ? asset('storage/' . $pathFisik)
                                                        : asset('storage/foto_roan/roan-default.jpeg');
                                                @endphp

                                                <li style="width: 90px; height: 90px;">
                                                    <a href="{{ route('roan.detil', $item->id ?? ($bahsul->id_ro ?? 1)) }}"
                                                        target="_blank">
                                                        <img class="img-fluid" src="{{ $urlFoto }}" alt="Foto Roan"
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


                            <!-- Banner Widget -->
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('register') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto/gabung2.jpeg') }}"
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

            initVerticalSlider('.materi-vertical-slider');
            initVerticalSlider('.relawan-vertical-active');
            initVerticalSlider('#roan-container');
        });
    </script>
@endsection
