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
                                <img class="img-fluid" src="{{ asset('storage/foto_mangrove/model9.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Infaq Mangrove' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    Tanam Mangrove untuk Masa Depan Ummat
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><i class="fa fa-user"></i>
                                        Admin</li>
                                    <li><i class="fa fa-map-marker"></i>
                                        Semarang</li>
                                </ul>
                                <p class="excert" style="text-align: justify; line-height: 1.6;">
                                    <strong>Mangrove adalah benteng alami yang menjaga keseimbangan lingkungan
                                        pesisir.</strong>
                                    Akar-akar mangrove mampu menahan abrasi, mengurangi dampak gelombang pasang, mencegah
                                    intrusi air laut, serta menjadi habitat bagi berbagai jenis ikan, kepiting, udang, dan
                                    burung. Selain itu, mangrove juga berperan penting dalam menyerap karbon sehingga
                                    membantu mengurangi dampak perubahan iklim. Menanam dan merawat mangrove bukan hanya
                                    menjaga alam hari ini, tetapi juga mewariskan lingkungan yang lebih sehat dan lestari
                                    bagi generasi mendatang.
                                    <br><br>
                                    <strong>MWC NU Tugu Semarang</strong> mengajak seluruh warga Nahdliyin, masyarakat, para
                                    dermawan,
                                    dan donatur untuk bersama-sama berkhidmat menjaga ciptaan Allah melalui program
                                    <strong>Infaq
                                        Mangrove</strong>. Setiap donasi yang diberikan akan diwujudkan menjadi bibit
                                    mangrove yang
                                    ditanam dan dirawat di kawasan pesisir sebagai bentuk sedekah jariyah yang manfaatnya
                                    terus mengalir bagi manusia dan alam. Mari menjadi bagian dari gerakan hijau NU, karena
                                    sekecil apa pun kontribusi yang kita berikan akan menjadi ikhtiar besar dalam menjaga
                                    bumi, melindungi pesisir, dan mewujudkan masa depan yang lebih lestari. Bersama MWC NU
                                    Tugu Semarang, <strong>satu donasi, satu harapan, sejuta manfaat untuk lingkungan dan
                                        umat.</strong>
                                </p>
                                <hr>
                                <div class="excert bg-emerald-800 dark:bg-emerald-950 border border-emerald-700 dark:border-emerald-900 p-6 rounded-2xl shadow-md"
                                    style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 8px;">
                                    <form action="{{ route('mangrove.simpan') }}" enctype="multipart/form-data"
                                        method="POST"
                                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-emerald-100 dark:border-emerald-900/50 shadow-sm w-full"
                                        x-data="{
                                            harga: {{ $hargaMangrove ?? 0 }},
                                            jumlah: 0,
                                            metode: 'tunai',
                                            rekening: {{ isset($rekening) ? json_encode($rekening) : '{}' }},
                                            formatRupiah(num) {
                                                return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                            }
                                        }">
                                        @csrf

                                        {{-- Baris Nama & Email --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Nama
                                                    Donatur</label>
                                                <input type="text" name="donatur" required
                                                    class="w-full p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:text-white outline-none transition">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Email</label>
                                                <input type="email" name="email" required
                                                    class="w-full p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:text-white outline-none transition">
                                            </div>
                                        </div>

                                        {{-- Baris Harga, Jumlah, Total --}}
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Jumlah
                                                    Pohon</label>
                                                <input type="number" name="jumlah_pohon" x-model.number="jumlah" required
                                                    class="w-full p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:text-white outline-none transition">
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Harga
                                                    Per Pohon</label>
                                                <div
                                                    class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                                    Rp {{ number_format($hargaMangrove ?? 0, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Total
                                                    Infaq (Rp)</label>
                                                <input type="text" :value="formatRupiah(harga * jumlah)" readonly
                                                    class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 outline-none">
                                                <input type="hidden" name="jumlah_infaq" :value="harga * jumlah">
                                            </div>
                                        </div>

                                        {{-- Baris Pembayaran --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Metode
                                                    Pembayaran</label>
                                                <select name="pembayaran" x-model="metode" required
                                                    class="w-full p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 dark:text-white outline-none transition">
                                                    <option value="tunai">Tunai</option>
                                                    <option value="transfer">Transfer</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Tanggal</label>
                                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" readonly
                                                    class="w-full p-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 cursor-not-allowed outline-none transition">
                                            </div>
                                        </div>

                                        {{-- Info Rekening & Upload Bukti --}}
                                        <div x-show="metode === 'transfer'" x-cloak
                                            class="mb-5 p-4 bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 rounded-xl space-y-4">

                                            <div x-data="{ rekening: @js(json_decode(Storage::get('rekening.txt'), true)) }">
                                                <div>
                                                    <h4 class="font-bold text-emerald-800 dark:text-emerald-300 mb-2">
                                                        Informasi Rekening Tujuan:</h4>
                                                    <div class="text-sm text-emerald-700 dark:text-emerald-400"
                                                        x-show="rekening && rekening.bank">
                                                        <label>Bank: <span class="font-bold" x-text="rekening.bank"></span></label><br>
                                                        <label>No. Rekening: <span class="font-bold"
                                                                x-text="rekening.no_rek"></span></label><br>
                                                        <label>Atas Nama: <span class="font-bold" x-text="rekening.an"></span>
                                                        </label>
                                                    </div>
                                                    <p x-show="!rekening || !rekening.bank" class="text-red-500 text-sm">
                                                        Data rekening tidak tersedia.</p>
                                                </div>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 text-emerald-900 dark:text-emerald-300">
                                                    Upload Bukti Transfer Disini (Max 2MB):
                                                </label>
                                                <input type="file" name="bukti_tf" accept="image/*"
                                                    :required="metode === 'transfer'"
                                                    class="w-full p-2 text-sm rounded-xl border border-emerald-200 dark:border-emerald-700 bg-white dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                                                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">* Wajib
                                                    melampirkan bukti transfer.</p>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 active:bg-emerald-800 transition shadow-lg shadow-emerald-600/20">
                                            Bismillah Infaq
                                        </button>
                                    </form>
                                </div>
                                <hr>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">

                            <aside class="single_sidebar_widget popular_post_widget">
                                <h3 class="widget_title">Donatur Terbaru</h3>
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        @php
                                            // Menghasilkan angka acak antara 1 sampai 9 untuk memilih file modelX.jpeg secara random
                                            $randomModel = 'model' . rand(1, 9) . '.jpeg';

                                            // Menentukan apakah menggunakan poster dari database atau foto random dari folder
                                            $fotoPoster = asset('storage/foto_mangrove/' . $randomModel);
                                        @endphp

                                        <div class="media post_item">
                                            <img src="{{ $fotoPoster }}" alt="post"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                            <div class="media-body">

                                                <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                    {{ Str::limit($post->donatur, 70) }}
                                                </h3>

                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ $post->jumlah_pohon }} Pohon
                                                </p>
                                                <p style="margin: 0; font-size: 12px;">
                                                    {{ \Carbon\Carbon::parse($post->created_at)->locale('id')->translatedFormat('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </aside>

                            <aside class="single_sidebar_widget tag_cloud_widget">
                                <h4 class="widget_title">Para Donatur</h4>
                                <ul class="list">
                                    @foreach ($tags as $kata => $jumlah)
                                        <li>
                                            <a href="#">
                                                {{ $kata }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="single_sidebar_widget instagram_feeds">
                                <h4 class="widget_title">Galery Donatur</h4>

                                {{-- Container diatur lebar 280px agar pas untuk 3 kolom (90px*3 + gap) --}}
                                <ul class="instagram_row"
                                    style="display: flex; flex-wrap: wrap; list-style: none; padding: 0; margin: 0; gap: 5px; width: 280px;">

                                    @php
                                        // Membuat array daftar foto dari model1.jpeg sampai model9.jpeg
                                        $listFoto = [];
                                        for ($i = 1; $i <= 9; $i++) {
                                            $listFoto[] = "model{$i}.jpeg";
                                        }

                                        // Mengacak urutan foto secara random setiap halaman dimuat
                                        shuffle($listFoto);
                                    @endphp

                                    @foreach ($listFoto as $foto)
                                        @php
                                            $urlFoto = asset('storage/foto_mangrove/' . $foto);
                                        @endphp
                                        <li style="width: 90px; height: 90px;">
                                            <a href="{{ $urlFoto }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $urlFoto }}" alt="Foto Galeri"
                                                    style="width: 90px; height: 90px; object-fit: cover; border-radius: 4px; display: block;">
                                            </a>
                                        </li>
                                    @endforeach
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
