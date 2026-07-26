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
        <!-- Trending Area Start -->
        <div class="trending-area fix pt-25 gray-bg">
            <div class="container">
                <div class="trending-main">
                    <div class="row">
                        <div class="col-lg-8">
                            <!-- Trending Top -->
                            <div class="slider-active">
                                @forelse ($dataBerita as $item)
                                    <!-- Single Slider Item -->
                                    <div class="single-slider">
                                        <div class="trending-top mb-30">
                                            <div class="trend-top-img img-large">
                                                <img src="{{ !empty($item->foto) && Storage::disk('public')->exists('foto_berita/' . $item->foto) ? asset('storage/foto_berita/' . $item->foto) : asset('storage/foto_berita/berita-default.jpeg') }}"
                                                    alt="{{ $item->judul }}">

                                                <div class="trend-top-cap">
                                                    <span class="bgr" data-animation="fadeInUp" data-delay=".2s"
                                                        data-duration="1000ms">
                                                        {{ $item->penulis }}
                                                    </span>

                                                    <h2>
                                                        <a href="{{ route('berita.detil', $item->id_br) }}"
                                                            data-animation="fadeInUp" data-delay=".4s"
                                                            data-duration="1000ms" target="_blank">
                                                            {{ $item->judul }}
                                                        </a>
                                                    </h2>

                                                    <p data-animation="fadeInUp" data-delay=".6s" data-duration="1000ms">
                                                        by Admin - {{ $item->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Jika data kosong -->
                                    <div class="single-slider">
                                        <div class="trending-top mb-30">
                                            <div class="trend-top-img img-large">
                                                <!-- Pastikan file 'kajian-default.jpeg' ada di public/assets/img/ -->
                                                <img src="{{ asset('storage/foto_berita/berita-default.jpeg') }}"
                                                    alt="Data belum tersedia">

                                                <div class="trend-top-cap">
                                                    <h2>
                                                        <a href="#" style="color: #ffffff !important;">Data Kegiatan
                                                            belum tersedia</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <!-- Right content -->
                        <div class="col-lg-4">
                            <!-- Trending Top -->
                            <div class="row">
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img img-medium">
                                            @if (isset($dataHalaqah) && $dataHalaqah->count() > 0)
                                                <!-- Mengambil data halaqah terbaru (index 0) -->
                                                <img src="{{ !empty($dataHalaqah[0]->thumbnail) && Storage::disk('public')->exists('foto_halaqah/' . $dataHalaqah[0]->thumbnail) ? asset('storage/foto_halaqah/' . $dataHalaqah[0]->thumbnail) : asset('storage/foto_halaqah/default-halaqah.jpeg') }}"
                                                    alt="{{ $dataHalaqah[0]->judul ?? 'No Data' }}">

                                                <div class="trend-top-cap trend-top-cap2">
                                                    <span class="bgb">Halaqah</span>

                                                    <h2>
                                                        <a href="{{ url('halaqah/' . $dataHalaqah[0]->id) }}">
                                                            {{ $dataHalaqah[0]->judul }}
                                                        </a>
                                                    </h2>

                                                    <p>by {{ $dataHalaqah[0]->moderator }} -
                                                        {{ $dataHalaqah[0]->tanggal->format('M d, Y') }}</p>
                                                </div>
                                            @else
                                                <!-- Fallback jika data kosong -->
                                                <img src="{{ !empty($dataHalaqah[0]->thumbnail) && Storage::disk('public')->exists('foto_halaqah/' . $dataHalaqah[0]->thumbnail) ? asset('storage/foto_halaqah/' . $dataHalaqah[0]->thumbnail) : asset('storage/foto_halaqah/default-halaqah.jpeg') }}"
                                                    alt="{{ $dataHalaqah[0]->judul ?? 'No Data' }}">
                                                <div class="trend-top-cap trend-top-cap2">
                                                    <span class="bgb">Halaqah</span>
                                                    <h2 style="color: #ffffff !important;">Data Halaqah belum tersedia</h2>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30">
                                        <div class="trend-top-img img-small">
                                            @if (isset($dataDakwah) && $dataDakwah->count() > 0)
                                                <!-- Gambar Dinamis -->
                                                <img src="{{ asset('storage/foto_dakwah/dakwah_bg.png') }}"
                                                    alt="{{ $dataDakwah->judul ?? 'No Data' }}">

                                                <div class="trend-top-cap trend-top-cap2">

                                                    <!-- Judul -->
                                                    <h2>
                                                        <a href="{{ url('dakwah/' . $dataDakwah->id) }}"
                                                            style="display: inline-block;
                                                            position: relative;
                                                            padding: 12px 20px 12px 45px;
                                                            background: rgba(0, 0, 0, 0.5);
                                                            border-left: 4px solid #28a745;
                                                            border-radius: 4px;
                                                            color: #ffffff !important;
                                                            text-decoration: none;">

                                                            <!-- Background Quote Icon (dibuat lebih jelas) -->
                                                            <span
                                                                style="position: absolute;
                                                                left: 15px;
                                                                top: 10px;
                                                                font-size: 30px;
                                                                color: rgba(10, 10, 10, 0.6);
                                                                font-family: Georgia, serif;
                                                                line-height: 1;
                                                                pointer-events: none;">“</span>

                                                            <!-- Isi Dakwah (Stroke dan Bayangan dipertebal agar lebih jelas) -->
                                                            <span
                                                                style="position: relative;
                                                                -webkit-text-stroke: 1.5px rgb(246, 241, 241);
                                                                font-weight: bold;">
                                                                {!! $dataDakwah->isi !!}
                                                            </span>
                                                        </a>
                                                    </h2>

                                                    <!-- Penulis dan Tanggal -->
                                                    <p>by {{ $dataDakwah->mubaligh }} -
                                                        {{ $dataDakwah->created_at->format('M d, Y') }}</p>
                                                </div>
                                            @else
                                                <!-- Fallback jika data kosong -->
                                                <img src="{{ asset('storage/foto_dakwah/dakwah-default.jpeg') }}"
                                                    alt="No Data">
                                                <div class="trend-top-cap trend-top-cap2">
                                                    <span class="bgg">Dakwah</span>
                                                    <h2 style="color: #ffffff !important;">Data Dakwah belum tersedia</h2>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Trending Area End -->
        <!-- Whats New Start -->
        <section class="whats-news-area pt-50 pb-20 gray-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="whats-news-wrapper">
                            <!-- Heading & Nav Button -->
                            <div class="row justify-content-between align-items-end mb-15">
                                <div class="col-xl-4">
                                    <div class="section-tittle mb-30">
                                        <h3>Terbaru!</h3>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-9">
                                    <div class="properties__button">
                                        <!--Nav Button  -->
                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                                    href="#nav-home" role="tab" aria-controls="nav-home"
                                                    aria-selected="true">Roan</a>
                                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                                    href="#nav-profile" role="tab" aria-controls="nav-profile"
                                                    aria-selected="false">Relawan</a>
                                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab"
                                                    href="#nav-contact" role="tab" aria-controls="nav-contact"
                                                    aria-selected="false">Sedekah Sampah</a>
                                                <a class="nav-item nav-link" id="nav-last-tab" data-toggle="tab"
                                                    href="#nav-last" role="tab" aria-controls="nav-contact"
                                                    aria-selected="false">Infaq Mangrove</a>
                                            </div>
                                        </nav>
                                        <!--End Nav Button  -->
                                    </div>
                                </div>
                            </div>
                            <!-- Tab content -->
                            <div class="row">
                                <div class="col-12">
                                    <!-- Nav Card -->
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- card one -->
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <div class="row">

                                                @if (isset($roans) && $roans->isNotEmpty())
                                                    <!-- Left Details Caption: 1 Data Terbaru -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        @php $latest = $roans->first(); @endphp
                                                        <div class="whats-news-single mb-40">
                                                            <div class="whates-img">
                                                                {{-- Cek jika poster ada dan bukan 'none' --}}
                                                                <img src="{{ $latest->poster && $latest->poster !== 'none' ? asset('storage/foto_roan/' . $latest->poster) : asset('storage/foto_roan/roan-default.jpeg') }}"
                                                                    alt="{{ $latest->tema }}"
                                                                    style="width: 360px; height: 245px; object-fit: cover;">
                                                            </div>
                                                            <div class="whates-caption">
                                                                <h4><a href="{{ route('roan.show', $latest->id) }}"
                                                                        target="_blank">Roan
                                                                        {{ $latest->tema }}</a></h4>
                                                                <span>by {{ $latest->pj }} -
                                                                    {{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                <p>{{ Str::words($latest->deskripsi, 19, '...') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right Details Caption: 4 Data Berikutnya -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="roan-wrapper" style="height:400px;overflow:hidden;">
                                                            <div id="roan-container" class="roan-vertical-active">

                                                                @foreach ($roans->slice(1, 4) as $item)
                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px">

                                                                            <img src="{{ $item->poster && $item->poster != 'none'
                                                                                ? asset('storage/foto_roan/' . $item->poster)
                                                                                : asset('storage/foto_roan/roan-default.jpeg') }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">

                                                                            <span class="colorb">
                                                                                Roan Bersih Pantai
                                                                            </span>

                                                                            <h4>
                                                                                <a href="{{ route('roan.show', $item->id) }}"
                                                                                    target="_blank">
                                                                                    {{ $item->tema }}
                                                                                </a>
                                                                            </h4>

                                                                            <p>
                                                                                {{ \Carbon\Carbon::parse($item->tgl)->format('M d, Y') }}
                                                                            </p>

                                                                        </div>

                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 text-center">
                                                        <p>Belum ada data kegiatan yang tersedia.</p>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <!-- Card two -->
                                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                            aria-labelledby="nav-profile-tab">
                                            <div class="row">
                                                @if (isset($relawans) && $relawans->isNotEmpty())
                                                    <!-- Left Details Caption -->
                                                    <div class="col-xl-6">
                                                        @php $latest = $relawans->first(); @endphp
                                                        <div class="whats-news-single mb-40">
                                                            <div class="whates-img">
                                                                <img src="{{ $latest->poster &&
                                                                $latest->poster !== 'none' &&
                                                                file_exists(public_path('storage/foto_relawan/' . $latest->poster))
                                                                    ? asset('storage/foto_relawan/' . $latest->poster)
                                                                    : asset('assets/img/gallery/relawan-default.jpeg') }}"
                                                                    alt="{{ $latest->judul }}"
                                                                    style="width: 360px; height: 245px; object-fit: cover;">
                                                            </div>
                                                            <div class="whates-caption">
                                                                <h4><a href="{{ route('relawan.show', $latest->id) }}"
                                                                        target="_blank">{{ $latest->judul }}</a></h4>
                                                                <span>by {{ $latest->koordinator }} -
                                                                    {{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                <p>{{ Str::words($latest->deskripsi, 19, '...') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right single caption -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <!-- Tambahkan class wrapper -->
                                                        <div class="relawan-wrapper"
                                                            style="height: 400px; overflow: hidden;">
                                                            <div class="relawan-vertical-active">
                                                                @foreach ($relawans->skip(1)->take(4) as $item)
                                                                    <!-- Berikan tinggi spesifik pada setiap item -->
                                                                    <div class="whats-right-single d-flex"
                                                                        style="height: 120px; align-items: center;">
                                                                        <div class="whats-right-img"
                                                                            style="min-width: 120px;">
                                                                            <img src="{{ $item->poster && file_exists(public_path('storage/foto_relawan/' . $item->poster))
                                                                                ? asset('storage/foto_relawan/' . $item->poster)
                                                                                : asset('storage/foto_relawan/relawan-default.jpeg') }}"
                                                                                style="width: 120px; height: 100px; object-fit: cover; border-radius: 4px;">
                                                                        </div>
                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Relawan</span>
                                                                            <h4>{{ $item->judul }}</h4>
                                                                            <p>{{ \Carbon\Carbon::parse($item->tgl)->format('M d, Y') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 text-center py-5">
                                                        <p>Belum ada data relawan yang tersedia.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- Card three -->
                                        <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                                            aria-labelledby="nav-contact-tab">
                                            <div class="row">
                                                @if (isset($sampahs) && $sampahs->isNotEmpty())
                                                    @php $latest = $sampahs->first(); @endphp

                                                    <!-- Left Details Caption -->
                                                    <div class="col-xl-6">
                                                        <div class="whats-news-single mb-40">
                                                            <div class="whates-img">
                                                                <img src="{{ $latest->foto && file_exists(public_path('storage/foto_sampah/' . $latest->foto))
                                                                    ? asset('storage/foto_sampah/' . $latest->foto)
                                                                    : asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                                                    alt="{{ $latest->penyetor }}"
                                                                    style="width: 360px; height: 245px; object-fit: cover;">
                                                            </div>
                                                            <div class="whates-caption">
                                                                <h4><a href="#">Penyetor:
                                                                        {{ $latest->penyetor }}</a></h4>
                                                                <span>{{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                <p>Nilai transaksi sampah ini adalah
                                                                    <strong>Rp{{ number_format($latest->nilai, 0, ',', '.') }}</strong>.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right single caption -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="sampah-wrapper" style="height:400px;overflow:hidden;">
                                                            <div class="sampah-vertical-active">

                                                                @foreach ($sampahs->skip(1)->take(4) as $item)
                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px;">
                                                                            <img src="{{ $item->foto && file_exists(public_path('storage/foto_sampah/' . $item->foto))
                                                                                ? asset('storage/foto_sampah/' . $item->foto)
                                                                                : asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Sedekah Sampah</span>
                                                                            <h4>{{ $item->penyetor }}</h4>
                                                                            <p>
                                                                                {{ \Carbon\Carbon::parse($item->tgl)->format('M d, Y') }}
                                                                                |
                                                                                Rp{{ number_format($item->nilai, 0, ',', '.') }}
                                                                            </p>
                                                                        </div>

                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 text-center py-5">
                                                        <p>Belum ada data sampah yang tersedia.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- card fure -->
                                        <div class="tab-pane fade" id="nav-last" role="tabpanel"
                                            aria-labelledby="nav-last-tab">
                                            <div class="row">
                                                @if (isset($mangroves) && $mangroves->isNotEmpty())
                                                    @php
                                                        $latest = $mangroves->first();
                                                        $fotoFolder = public_path('storage/foto_mangrove');
                                                        $files = file_exists($fotoFolder)
                                                            ? array_diff(scandir($fotoFolder), ['.', '..'])
                                                            : [];
                                                    @endphp

                                                    <!-- Left Details Caption -->
                                                    <div class="col-xl-6">
                                                        <div class="whats-news-single mb-40">
                                                            <div class="whates-img">
                                                                <img src="{{ asset('storage/foto_mangrove/mangrove-default.jpeg') }}"
                                                                    alt="{{ $latest->donatur }}"
                                                                    style="width: 360px; height: 245px; object-fit: cover;">
                                                            </div>
                                                            <div class="whates-caption">
                                                                <h4><a href="#">Donatur: {{ $latest->donatur }}</a>
                                                                </h4>
                                                                <span>{{ \Carbon\Carbon::parse($latest->tanggal)->format('M d, Y') }}</span>
                                                                <p>Telah berinfaq sebesar
                                                                    Rp{{ number_format($latest->jumlah_infaq, 0, ',', '.') }}
                                                                    untuk {{ $latest->jumlah_pohon }} pohon mangrove.</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Right single caption (Slideshow) -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="mangrove-wrapper"
                                                            style="height:400px;overflow:hidden;">
                                                            <div class="mangrove-vertical-active">

                                                                @foreach ($mangroves->skip(1)->take(4) as $item)
                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px;">

                                                                            <img src="{{ asset('storage/foto_mangrove/' . ($files[array_rand($files)] ?? 'model1.jpeg')) }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Infaq Mangrove</span>

                                                                            <h4>{{ $item->donatur }}</h4>

                                                                            <p>
                                                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('M d, Y') }}
                                                                                |
                                                                                {{ $item->jumlah_pohon }} Pohon
                                                                            </p>
                                                                        </div>

                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 text-center py-5">
                                                        <p>Belum ada data kegiatan mangrove.</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Nav Card -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Most Recent Area -->
                        <div class="most-recent-area">
                            <!-- Section Tittle -->
                            <div class="small-tittle mb-20">
                                <h4>Opini terbaru</h4>
                            </div>
                            <!-- Details -->
                            @if ($opinis->isNotEmpty())
                                {{-- Data Utama: Paksa 333x229px --}}
                                @php $utama = $opinis->first(); @endphp
                                <div class="most-recent mb-40">
                                    <div class="most-recent-img">
                                        <img src="{{ $utama->foto && $utama->foto !== 'none' ? asset('storage/foto_opini/' . $utama->foto) : asset('storage/foto_opini/opini-default.jpeg') }}"
                                            alt="{{ $utama->judul }}"
                                            style="width: 333px !important; height: 229px !important; object-fit: cover;">

                                        <div class="most-recent-cap">
                                            <span class="bgbeg">Opini</span>
                                            <h4><a href="{{ route('opini.show', $utama->id) }}"
                                                    target="_blank">{{ $utama->judul }}</a>
                                            </h4>
                                            <p>{{ $utama->penulis }} |
                                                {{ \Carbon\Carbon::parse($utama->updated_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Data Setelahnya (2 Item): Paksa 85x79px --}}
                                @foreach ($opinis->slice(1, 2) as $item)
                                    <div class="most-recent-single" style="display: flex; margin-bottom: 20px;">
                                        <div class="most-recent-images">
                                            <img src="{{ $item->foto && $item->foto !== 'none' ? asset('storage/foto_opini/' . $item->foto) : asset('storage/foto_opini/opini-default-sm.jpeg') }}"
                                                alt="{{ $item->judul }}"
                                                style="width: 85px !important; height: 79px !important; object-fit: cover;">
                                        </div>
                                        <div class="most-recent-capt" style="padding-left: 15px;">
                                            <h4><a href="{{ route('opini.show', $item->id) }}"
                                                    target="_blank">{{ $item->judul }}</a>
                                            </h4>
                                            <p>{{ $item->penulis }} |
                                                {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Whats New End -->
        <!--   Weekly2-News start -->
        <div class="weekly2-news-area pt-50 pb-30 gray-bg">
            <div class="container">
                <div class="weekly2-wrapper">
                    <div class="row">
                        <!-- Banner -->
                        <div class="col-lg-3">
                            <div class="home-banner2 d-none d-lg-block">
                                <a href="{{ route('register') }}" target="_blank">
                                    <img src="{{ asset('storage/foto/gabung.jpeg') }}" alt="Gabung Sekarang">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="slider-wrapper">
                                <!-- section Tittle -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="small-tittle mb-30">
                                            <h4>Khutbah Jumat</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- Slider -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="weekly2-news-active d-flex">
                                            @foreach ($khutbahs as $item)
                                                <div class="weekly2-single">
                                                    <div class="weekly2-img">
                                                        <img src="{{ $item->poster && $item->poster !== 'none' ? asset('storage/foto_khutbah/' . $item->poster) : asset('storage/foto_khutbah/khutbah-default.jpeg') }}"
                                                            alt="{{ $item->judul }}"
                                                            style="width: 235px; height: 155px; object-fit: cover;">
                                                    </div>
                                                    <div class="weekly2-caption">
                                                        <h4>
                                                            <a href="{{ route('khutbah.show', $item->id) }}"
                                                                target="_blank">{{ $item->judul }}</a>
                                                        </h4>
                                                        <p>{{ $item->khatib }} |
                                                            {{ \Carbon\Carbon::parse($item->tgl)->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Weekly-News -->
        <!--  Recent Articles start -->
        <div class="recent-articles pt-80 pb-80">
            <div class="container">
                <div class="recent-wrapper">
                    <!-- section Tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30">
                                <h3>Pengajian Terbaru</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="recent-active dot-style d-flex">
                                @foreach ($dataKajian as $item)
                                    <div class="single-recent"
                                        style="position: relative; overflow: hidden; width: 263px;">

                                        {{-- Bagian Gambar sebagai Background --}}
                                        <div class="what-img"
                                            style="
                                        background-image: url('{{ !empty($item->poster) && Storage::disk('public')->exists('foto_kajian/' . $item->poster) ? asset('storage/foto_kajian/' . $item->poster) : asset('storage/foto_kajian/kajian-default.jpeg') }}'); background-size: cover;
                                        background-position: center;
                                        height: 263px;
                                        width: 100%;">
                                        </div>

                                        {{-- Bagian Caption: Kita paksa agar menumpuk di atas gambar --}}
                                        <div class="what-cap"
                                            style="
                                        background: #fff;
                                        padding: 20px;
                                        margin: -110px 0px 0 0px; /* Margin negatif agar kartu 'naik' ke atas gambar */
                                        position: relative;
                                        z-index: 1;">

                                            <h4>
                                                <a href="{{ route('dakwah.show', $item->id) }}"
                                                    target="_blank">{{ $item->judul }}</a>
                                            </h4>
                                            <p>{{ \Carbon\Carbon::parse($item->tanggal)->format('M d, Y') }}</p>

                                            <a class="popup-video btn-icon" target="_blank"
                                                href="{{ $item->link_yt ? $item->link_yt : 'https://www.youtube.com/watch?v=s8Yf4VCirZQ' }}">
                                                <span class="flaticon-play-button"></span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Recent Articles End -->
        <!-- Start Video Area -->
        <div class="youtube-area video-padding d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="video-items-active">
                            @php
                                $hasLink = $kajian && !empty($kajian->link_yt);
                            @endphp

                            <div class="video-items text-center">
                                @php
                                    // Cek apakah data ada dan link tidak kosong
                                    $hasLink = $kajian && !empty($kajian->link_yt);
                                    $videoId = '';

                                    if ($hasLink) {
                                        // Regex ini mendukung format:
                                        // 1. https://www.youtube.com/watch?v=ID
                                        // 2. https://youtu.be/ID
                                        preg_match(
                                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                            $kajian->link_yt,
                                            $matches,
                                        );

                                        $videoId = $matches[1] ?? null;
                                    }
                                @endphp

                                @if ($videoId)
                                    {{-- Jika ID berhasil ditemukan dari link_yt --}}
                                    <iframe width="1170" height="630"
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                    </iframe>
                                @else
                                    {{-- Jika null atau format link_yt tidak dikenali, gunakan link statis --}}
                                    <iframe width="1170" height="630" src="https://www.youtube.com/embed/wQCLmF0YLHQ"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                    </iframe>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <br>
                <div class="video-info">
                    <div class="row">
                        <div class="col-12">
                            <div class="testmonial-nav text-center">
                                @php
                                    // Ambil 5 data terbaru, lewati data pertama (terbaru)
                                    $listKajian = \App\Models\KajianModel::latest()->skip(1)->take(5)->get();

                                    // Daftar link fallback jika link_yt kosong
                                    $fallbacks = [
                                        'https://www.youtube.com/watch?v=wQCLmF0YLHQ',
                                        'https://www.youtube.com/watch?v=NsoxvcuwMfQ',
                                        'https://www.youtube.com/watch?v=2o90JKsJjEU',
                                        'https://www.youtube.com/watch?v=17N1OrW2TbU',
                                        'https://www.youtube.com/watch?v=Bvve2GQfNIk',
                                    ];

                                    // Fungsi untuk ekstraksi ID dari URL
                                    $getVideoId = function ($url) {
                                        preg_match(
                                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                            $url,
                                            $matches,
                                        );
                                        return $matches[1] ?? 'wQCLmF0YLHQ'; // Default jika gagal parse
                                    };
                                @endphp

                                @for ($i = 0; $i < 5; $i++)
                                    <div class="single-video">
                                        <div class="video-items text-center">
                                            @php
                                                // Jika ada data di $listKajian, gunakan link-nya. Jika tidak, gunakan fallback.
                                                $url =
                                                    !empty($listKajian[$i]) && !empty($listKajian[$i]->link_yt)
                                                        ? $listKajian[$i]->link_yt
                                                        : $fallbacks[$i];
                                                $videoId = $getVideoId($url);
                                            @endphp

                                            <iframe width="290" height="160"
                                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                                title="YouTube video player" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Start Video area-->
        <!--   Weekly3-News start -->
        <div class="weekly3-news-area pt-80 pb-130">
            <div class="container">
                <div class="weekly3-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="slider-wrapper">
                                <!-- Slider -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="weekly3-news-active dot-style d-flex">
                                            @foreach ($dataOpini as $opini)
                                                <div class="weekly3-single">
                                                    <div class="weekly3-img">
                                                        {{-- Cek apakah foto ada, jika null/kosong gunakan default --}}
                                                        <img src="{{ !empty($opini->foto) && Storage::disk('public')->exists('foto_opini/' . $opini->foto) ? asset('storage/foto_opini/' . $opini->foto) : asset('storage/foto_opini/opini-default.jpeg') }}"
                                                            alt="{{ $opini->judul }}"
                                                            style="width: 235px; height: 155px; object-fit: cover; border-radius: 4px;">
                                                    </div>
                                                    <div class="weekly3-caption">
                                                        <h4>
                                                            <a href="{{ route('opini.detail_opini', $opini->id) }}">
                                                                {{ $opini->judul }}
                                                            </a>
                                                        </h4>
                                                        {{-- Format tanggal menggunakan Carbon yang otomatis tersedia di Laravel --}}
                                                        <p>{{ $opini->updated_at ? $opini->updated_at->format('d M Y') : '' }}
                                                            || Oleh {{ $opini->penulis }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Weekly-News -->
        <!-- banner-last Start -->
        <div class="banner-area gray-bg pt-90 pb-90">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-10">
                        <div class="banner-one">
                            <a href="{{ route('register') }}" target="_blank">
                                <img src="{{ asset('storage/foto/gabung3.jpeg') }}" alt="Gabung Sekarang">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- banner-last End -->
    </main>
    @include('partials.footer')
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            function initVerticalSlider(selector) {

                if ($(selector).hasClass('slick-initialized')) {
                    return;
                }

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

                    pauseOnHover: false

                });

            }

            initVerticalSlider('#roan-container');
            initVerticalSlider('.relawan-vertical-active');
            initVerticalSlider('.sampah-vertical-active');
            initVerticalSlider('.mangrove-vertical-active');

            $('a[data-toggle="tab"]').on('shown.bs.tab', function() {

                [
                    '#roan-container',
                    '.relawan-vertical-active',
                    '.sampah-vertical-active',
                    '.mangrove-vertical-active'
                ].forEach(function(selector) {

                    if ($(selector).hasClass('slick-initialized')) {
                        $(selector).slick('setPosition');
                        $(selector).slick('refresh');
                        $(selector).slick('slickPlay');
                    }

                });

            });

        });
    </script>
@endsection
