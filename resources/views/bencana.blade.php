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
                        <div class="single-post">
                            <div class="feature-img">
                                <img class="img-fluid" src="{{ asset('storage/foto_bencana/bencana-default.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Infaq Mangrove' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    Lapor Bencana
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><a href="#"><i class="fa fa-user"></i>
                                            Admin</a></li>
                                    <li><a href="#"><i class="fa fa-map-marker"></i>
                                            Semarang</a></li>
                                </ul>
                                <p class="excert" style="text-align: justify; line-height: 1.6;">
                                    <strong>Kanal Lapor Bencana MWC NU Tugu Semarang</strong> merupakan media pelaporan
                                    cepat bagi masyarakat untuk
                                    menyampaikan informasi terkait kejadian bencana alam maupun keadaan darurat di wilayah
                                    sekitar. Setiap laporan yang
                                    Anda kirimkan akan menjadi informasi awal yang sangat penting bagi tim relawan dalam
                                    melakukan verifikasi,
                                    koordinasi, dan penanganan di lapangan secara lebih cepat dan tepat sasaran.
                                    <br><br>
                                    <strong>Laporan Anda sangat berharga untuk menyelamatkan korban bencana.</strong>
                                    Informasi mengenai lokasi
                                    kejadian, jenis bencana, kondisi korban, serta kebutuhan mendesak akan membantu
                                    mempercepat proses evakuasi,
                                    penyaluran bantuan, dan mobilisasi relawan. Semakin cepat informasi diterima, semakin
                                    besar peluang untuk
                                    memberikan pertolongan kepada masyarakat yang terdampak.
                                    <br><br>
                                    <strong>MWC NU Tugu Semarang</strong> mengajak seluruh masyarakat untuk berpartisipasi
                                    dalam gerakan kemanusiaan
                                    ini dengan melaporkan setiap kejadian bencana secara jujur, jelas, dan bertanggung
                                    jawab. Bersama kita wujudkan
                                    kepedulian terhadap sesama, karena <strong>satu laporan yang Anda kirimkan dapat menjadi
                                        langkah awal
                                        penyelamatan banyak nyawa.</strong>
                                </p>
                                <hr>
                                <div class="excert bg-emerald-800 dark:bg-emerald-950 border border-emerald-700 dark:border-emerald-900 p-3 sm:p-6 rounded-2xl shadow-md"
                                    style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 8px;">

                                    <form action="{{ route('bencana.simpan') }}" method="POST"
                                        enctype="multipart/form-data"
                                        class="bg-white dark:bg-gray-900 p-4 sm:p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm w-full">
                                        @csrf

                                        {{-- Baris Nama Pelapor & Email --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-4 sm:mb-5">
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Nama
                                                    Pelapor</label>
                                                <input type="text" name="pelapor" value="{{ old('pelapor') }}" required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Email</label>
                                                <input type="email" name="email" value="{{ old('email') }}" required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                        </div>

                                        {{-- Jenis Bencana & Tanggal --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-4 sm:mb-5">
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Jenis
                                                    Bencana</label>
                                                <input type="text" name="jenis_bencana"
                                                    value="{{ old('jenis_bencana') }}" required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Tanggal
                                                    Kejadian</label>
                                                <input type="date" name="tgl"
                                                    value="{{ old('tgl', date('Y-m-d')) }}" required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                        </div>

                                        {{-- Lokasi & Jumlah Korban --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5 mb-4 sm:mb-5">
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Lokasi</label>
                                                <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Jumlah
                                                    Korban</label>
                                                <input type="number" name="jml_korban" value="{{ old('jml_korban') }}"
                                                    required
                                                    class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">
                                            </div>
                                        </div>

                                        {{-- Kebutuhan Mendesak --}}
                                        <div class="mb-4 sm:mb-5">
                                            <label
                                                class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Kebutuhan
                                                Mendesak</label>
                                            <textarea name="kebutuhan" rows="2" required
                                                class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('kebutuhan') }}</textarea>
                                        </div>

                                        {{-- Deskripsi Kejadian --}}
                                        <div class="mb-4 sm:mb-5">
                                            <label
                                                class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Deskripsi
                                                Kejadian</label>
                                            <textarea name="deskripsi" rows="3" required
                                                class="w-full p-2.5 sm:p-3 text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('deskripsi') }}</textarea>
                                        </div>

                                        {{-- Foto --}}
                                        <div class="mb-6 sm:mb-8">
                                            <label
                                                class="block text-xs sm:text-sm font-bold mb-1.5 sm:mb-2 dark:text-gray-300">Dokumentasi
                                                Foto</label>
                                            <input type="file" name="foto[]" multiple accept="image/*" required
                                                class="w-full p-2 sm:p-3 text-xs sm:text-sm rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                                            <p class="text-[11px] sm:text-xs text-gray-400 mt-1">Anda dapat memilih lebih
                                                dari satu foto.</p>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div class="flex gap-4 mt-4 sm:mt-6">
                                            <button type="submit"
                                                class="flex-1 bg-emerald-600 text-white py-2.5 sm:py-3 text-sm sm:text-base rounded-xl font-bold hover:bg-emerald-700 transition">
                                                Laporkan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <hr>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">

                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Laporan Terbaru</h3>
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        @php
                                            // Cek apakah data foto di database ada dan file fisiknya benar-benar tersimpan di disk public
                                            $pathFile = 'foto_bencana/' . $post->foto;

                                            $fotoPoster =
                                                !empty($post->foto) &&
                                                \Illuminate\Support\Facades\Storage::disk('public')->exists($pathFile)
                                                    ? asset('storage/' . $pathFile)
                                                    : asset('storage/foto_bencana/bencana-default-sm.jpeg');
                                        @endphp

                                        <div class="media post_item">
                                            <img src="{{ $fotoPoster }}" alt="post"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                            <div class="media-body">
                                                <a href="#">
                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->lokasi, 70) }}
                                                    </h3>
                                                </a>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ $post->jml_korban }} Korban
                                                </p>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ \Carbon\Carbon::parse($post->tgl)->locale('id')->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <aside class="single_sidebar_widget tag_cloud_widget">
                                <h4 class="widget_title">Jenis Bencana</h4>
                                <ul class="list">
                                    @foreach ($tags as $kata => $jumlah)
                                        <li>
                                            <a href="{{ route('bencana', ['keyword' => $kata]) }}">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="single_sidebar_widget instagram_feeds">
                                <h4 class="widget_title">Riwayat Bencana</h4>

                                {{-- Container diatur lebar 280px agar pas untuk 3 kolom (90px*3 + gap) --}}
                                <ul class="instagram_row"
                                    style="display: flex; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; gap: 5px; width: 280px;">

                                    @php
                                        // 1. Ambil semua file dari disk public di dalam folder 'foto_bencana'
                                        $semuaFile = \Illuminate\Support\Facades\Storage::disk('public')->files(
                                            'foto_bencana',
                                        );

                                        // 2. Filter hanya mengambil file yang berekstensi gambar (jpg, jpeg, png, webp, gif)
                                        $listFoto = array_filter($semuaFile, function ($file) {
                                            return preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file);
                                        });

                                        // 3. Acak urutan array gambar
                                        shuffle($listFoto);

                                        // 4. Ambil maksimal 9 (jika file kurang dari 9, otomatis ambil berapapun sisanya)
                                        $fotoRandom = array_slice($listFoto, 0, 9);
                                    @endphp

                                    @forelse ($fotoRandom as $foto)
                                        @php
                                            // $foto sudah mengandung path 'foto_bencana/nama_file.jpeg' dari fungsi Storage::files
                                            $urlFoto = asset('storage/' . $foto);
                                        @endphp
                                        <li style="width: 90px; height: 90px;">
                                            <a href="{{ $urlFoto }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $urlFoto }}" alt="Foto Galeri Bencana"
                                                    style="width: 90px; height: 90px; object-fit: cover; border-radius: 4px; display: block;"
                                                    onerror="this.onerror=null; this.src='{{ asset('storage/foto_bencana/bencana-default.jpeg') }}';">
                                            </a>
                                        </li>
                                    @empty
                                        <li
                                            style="width: 100%; text-align: center; font-size: 12px; color: #999; padding: 10px 0;">
                                            Belum ada galeri foto.
                                        </li>
                                    @endforelse

                                </ul>
                            </aside>
                            <!-- Banner Widget -->
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('register') }}" target="_blank">
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
