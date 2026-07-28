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
                                        <div class="trending-top mb-30"
                                            style="width: 100% !important; max-width: 100% !important; overflow: hidden !important; height: auto !important;">
                                            <div class="trend-top-img img-large"
                                                style="position: relative !important; width: 100% !important; max-width: 100% !important; height: auto !important; min-height: 0 !important; overflow: hidden !important;">
                                                <img src="{{ !empty($item->foto) && Storage::disk('public')->exists('foto_berita/' . $item->foto) ? asset('storage/foto_berita/' . $item->foto) : asset('storage/foto_berita/berita-default-pro.jpeg') }}"
                                                    alt="{{ $item->judul }}"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">

                                                <div class="trend-top-cap"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 12px 15px !important; overflow: hidden !important; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%) !important;">
                                                    <span class="bgr" data-animation="fadeInUp" data-delay=".2s"
                                                        data-duration="1000ms"
                                                        style="display: inline-block !important; max-width: 100% !important; white-space: normal !important; margin-bottom: 5px !important;">
                                                        {{ $item->penulis }}
                                                    </span>

                                                    <h2
                                                        style="width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; margin-bottom: 5px !important;">
                                                        <a href="{{ route('berita.detil', $item->id_br) }}"
                                                            data-animation="fadeInUp" data-delay=".4s"
                                                            data-duration="1000ms" target="_blank"
                                                            style="display: block !important; width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; font-size: clamp(15px, 3.8vw, 22px) !important; line-height: 1.25 !important;">
                                                            {{ $item->judul }}
                                                        </a>
                                                    </h2>

                                                    <p data-animation="fadeInUp" data-delay=".6s" data-duration="1000ms"
                                                        style="word-break: break-word !important; margin: 0 !important; font-size: 12px !important;">
                                                        by Admin - {{ $item->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <!-- Jika data kosong -->
                                    <div class="single-slider">
                                        <div class="trending-top mb-30"
                                            style="width: 100% !important; max-width: 100% !important; overflow: hidden !important; height: auto !important;">
                                            <div class="trend-top-img img-large"
                                                style="position: relative !important; width: 100% !important; max-width: 100% !important; height: auto !important; min-height: 0 !important; overflow: hidden !important;">
                                                <img src="{{ asset('storage/foto_berita/berita-default-pro.jpeg') }}"
                                                    alt="Data belum tersedia"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">

                                                <div class="trend-top-cap"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 15px !important; overflow: hidden !important;">
                                                    <h2
                                                        style="width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important;">
                                                        <a href="#"
                                                            style="color: #ffffff !important; display: block !important; width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important;">Data
                                                            Kegiatan belum tersedia</a>
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
                                <!-- Item 1: Halaqah -->
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30"
                                        style="width: 100% !important; max-width: 100% !important; overflow: hidden !important; height: auto !important;">
                                        <div class="trend-top-img img-medium"
                                            style="position: relative !important; width: 100% !important; max-width: 100% !important; height: auto !important; min-height: 0 !important; overflow: hidden !important;">
                                            @if (isset($dataHalaqah) && $dataHalaqah->count() > 0)
                                                <!-- Mengambil data halaqah terbaru (index 0) -->
                                                <img src="{{ !empty($dataHalaqah[0]->thumbnail) && Storage::disk('public')->exists('foto_halaqah/' . $dataHalaqah[0]->thumbnail) ? asset('storage/foto_halaqah/' . $dataHalaqah[0]->thumbnail) : asset('storage/foto_halaqah/default-halaqah-pro.jpeg') }}"
                                                    alt="{{ $dataHalaqah[0]->judul ?? 'No Data' }}"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">

                                                <div class="trend-top-cap trend-top-cap2"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 12px 15px !important; overflow: hidden !important; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%) !important;">
                                                    <span class="bgb"
                                                        style="display: inline-block !important; max-width: 100% !important; white-space: normal !important; margin-bottom: 5px !important;">Halaqah</span>

                                                    <h2
                                                        style="width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; margin-bottom: 5px !important;">
                                                        <a href="{{ url('kajian-halaqah/detil/' . $dataHalaqah[0]->id) }}"
                                                            target="_blank"
                                                            style="display: block !important; width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; font-size: clamp(15px, 3.8vw, 20px) !important; line-height: 1.25 !important;">
                                                            {{ $dataHalaqah[0]->judul }}
                                                        </a>
                                                    </h2>

                                                    <p
                                                        style="word-break: break-word !important; margin: 0 !important; font-size: 12px !important;">
                                                        by {{ $dataHalaqah[0]->moderator }} -
                                                        {{ $dataHalaqah[0]->tanggal->format('M d, Y') }}</p>
                                                </div>
                                            @else
                                                <!-- Fallback jika data kosong -->
                                                <img src="{{ asset('storage/foto_halaqah/default-halaqah-pro.jpeg') }}"
                                                    alt="No Data"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">
                                                <div class="trend-top-cap trend-top-cap2"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 15px !important; overflow: hidden !important;">
                                                    <span class="bgb">Halaqah</span>
                                                    <h2
                                                        style="color: #ffffff !important; word-break: break-word !important; font-size: clamp(15px, 3.8vw, 20px) !important;">
                                                        Data Halaqah belum tersedia</h2>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 2: Dakwah -->
                                <div class="col-lg-12 col-md-6 col-sm-6">
                                    <div class="trending-top mb-30"
                                        style="width: 100% !important; max-width: 100% !important; overflow: hidden !important; height: auto !important;">
                                        <div class="trend-top-img img-small"
                                            style="position: relative !important; width: 100% !important; max-width: 100% !important; height: auto !important; min-height: 0 !important; overflow: hidden !important;">
                                            @if (isset($dataDakwah) && $dataDakwah->count() > 0)
                                                @php
                                                    $pathBgFisik = 'foto_dakwah/dakwah_bg.png';
                                                    $bgTersedia = Storage::disk('public')->exists($pathBgFisik);

                                                    $urlBgDakwah = $bgTersedia
                                                        ? asset('storage/' . $pathBgFisik)
                                                        : asset('storage/foto_dakwah/dakwah-default.jpeg');
                                                @endphp

                                                <!-- Gambar Dinamis dengan Validasi Fisik -->
                                                <img src="{{ $urlBgDakwah }}" alt="{{ $dataDakwah->judul ?? 'No Data' }}"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">

                                                <div class="trend-top-cap trend-top-cap2"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 12px 15px !important; overflow: hidden !important; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%) !important;">

                                                    <!-- Judul -->
                                                    <h2
                                                        style="width: 100% !important; max-width: 100% !important; word-break: break-word !important; overflow-wrap: break-word !important; white-space: normal !important; margin-bottom: 5px !important;">
                                                        <a href="{{ url('pesan-dakwah/') }}" target="_blank"
                                                            style="display: block !important;
                                    width: 100% !important;
                                    max-width: 100% !important;
                                    position: relative;
                                    padding: 10px 15px 10px 35px !important;
                                    background: rgba(0, 0, 0, 0.75);
                                    border-left: 5px solid #28a745;
                                    border-radius: 6px;
                                    color: #ffffff !important;
                                    text-decoration: none;
                                    word-break: break-word !important;
                                    overflow-wrap: break-word !important;
                                    white-space: normal !important;
                                    font-size: clamp(14px, 3.5vw, 16px) !important;
                                    line-height: 1.4 !important;">

                                                            <!-- Background Quote Icon -->
                                                            <span
                                                                style="position: absolute;
                                        left: 10px;
                                        top: 8px;
                                        font-size: 24px;
                                        color: rgba(40, 167, 69, 0.8);
                                        font-family: Georgia, serif;
                                        line-height: 1;
                                        pointer-events: none;">“</span>

                                                            <!-- Isi Dakwah -->
                                                            <span
                                                                style="position: relative;
                                        font-weight: 800;
                                        color: #ffffff;
                                        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.9);
                                        letter-spacing: 0.3px;">
                                                                {!! $dataDakwah->isi !!}
                                                            </span>
                                                        </a>
                                                    </h2>

                                                    <!-- Penulis dan Tanggal -->
                                                    <p
                                                        style="word-break: break-word !important; margin: 0 !important; font-size: 12px !important;">
                                                        by {{ $dataDakwah->mubaligh }} -
                                                        {{ $dataDakwah->created_at->format('M d, Y') }}</p>
                                                </div>
                                            @else
                                                <!-- Fallback jika data kosong -->
                                                <img src="{{ asset('storage/foto_dakwah/dakwah-default.jpeg') }}"
                                                    alt="No Data"
                                                    style="width: 100% !important; height: auto !important; display: block !important;">
                                                <div class="trend-top-cap trend-top-cap2"
                                                    style="position: absolute !important; bottom: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; max-width: 100% !important; box-sizing: border-box !important; padding: 15px !important; overflow: hidden !important;">
                                                    <span class="bgg">Dakwah</span>
                                                    <h2
                                                        style="color: #ffffff !important; word-break: break-word !important; font-size: clamp(15px, 3.8vw, 20px) !important;">
                                                        Data Dakwah belum tersedia</h2>
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
                                                        @if ($latest)
                                                            <div class="whats-news-single mb-40">
                                                                <div class="whates-img">
                                                                    @php
                                                                        $posterName = $latest->poster;
                                                                        $pathFisik = 'foto_roan/' . $posterName;

                                                                        // Cek apakah poster ada di database, bukan 'none', dan file fisiknya benar-benar ada di storage disk public
                                                                        $posterTersedia =
                                                                            !empty($posterName) &&
                                                                            $posterName !== 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlPoster = $posterTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_roan/roan-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    {{-- Gambar dengan Validasi Fisik Storage --}}
                                                                    <img src="{{ $urlPoster }}"
                                                                        alt="{{ $latest->tema }}"
                                                                        style="width: 360px; height: 245px; object-fit: cover;">
                                                                </div>
                                                                <div class="whates-caption">
                                                                    <h4><a href="{{ route('roan.detil', $latest->id_ro) }}"
                                                                            target="_blank">Roan
                                                                            {{ $latest->tema }}</a></h4>
                                                                    <span>by {{ $latest->pj }} -
                                                                        {{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                    <p>{{ Str::words($latest->deskripsi, 19, '...') }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Right Details Caption: 4 Data Berikutnya -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="roan-wrapper" style="height:400px;overflow:hidden;">
                                                            <div id="roan-container" class="roan-vertical-active">

                                                                @foreach ($roans->slice(1, 4) as $item)
                                                                    @php
                                                                        $posterName = $item->poster;
                                                                        $pathFisik = 'foto_roan/' . $posterName;

                                                                        // Validasi apakah poster terisi, bukan 'none', dan file fisiknya benar-benar ada di disk public
                                                                        $posterTersedia =
                                                                            !empty($posterName) &&
                                                                            $posterName != 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlPoster = $posterTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_roan/roan-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px">

                                                                            <img src="{{ $urlPoster }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">

                                                                            <span class="colorb">
                                                                                Roan Bersih Pantai
                                                                            </span>

                                                                            <h4>
                                                                                <a href="{{ route('roan.detil', $item->id_ro) }}"
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
                                                        @if ($latest)
                                                            <div class="whats-news-single mb-40">
                                                                <div class="whates-img">
                                                                    @php
                                                                        $posterName = $latest->poster;
                                                                        $pathFisik = 'foto_relawan/' . $posterName;

                                                                        // Validasi menggunakan Storage facade disk public agar konsisten
                                                                        $posterTersedia =
                                                                            !empty($posterName) &&
                                                                            $posterName !== 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlPoster = $posterTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_relawan/relawan-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <img src="{{ $urlPoster }}"
                                                                        alt="{{ $latest->judul }}"
                                                                        style="width: 360px; height: 245px; object-fit: cover;">
                                                                </div>
                                                                <div class="whates-caption">
                                                                    <h4><a href="{{ route('relawan.detil', $latest->id_re) }}"
                                                                            target="_blank">{{ $latest->judul }}</a></h4>
                                                                    <span>by {{ $latest->koordinator }} -
                                                                        {{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                    <p>{{ Str::words($latest->deskripsi, 19, '...') }}</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Right single caption -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <!-- Tambahkan class wrapper -->
                                                        <div class="relawan-wrapper"
                                                            style="height: 400px; overflow: hidden;">
                                                            <div class="relawan-vertical-active">
                                                                @foreach ($relawans->skip(1)->take(4) as $item)
                                                                    <!-- Berikan tinggi spesifik pada setiap item -->
                                                                    @php
                                                                        $posterName = $item->poster;
                                                                        $pathFisik = 'foto_relawan/' . $posterName;

                                                                        // Validasi menggunakan Storage disk public agar konsisten dengan modul lainnya
                                                                        $posterTersedia =
                                                                            !empty($posterName) &&
                                                                            $posterName !== 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlPoster = $posterTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_relawan/relawan-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <div class="whats-right-single d-flex"
                                                                        style="height: 120px; align-items: center;">
                                                                        <div class="whats-right-img"
                                                                            style="min-width: 120px;">
                                                                            <img src="{{ $urlPoster }}"
                                                                                style="width: 120px; height: 100px; object-fit: cover; border-radius: 4px;"
                                                                                alt="{{ $item->judul }}">
                                                                        </div>
                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Relawan</span>
                                                                            <h4>
                                                                                <a href="{{ route('relawan.detil', $item->id_re) }}"
                                                                                    target="_blank">
                                                                                    {{ $item->judul }}
                                                                                </a>
                                                                            </h4>
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
                                                        @php $latest = $sampahs->first(); @endphp
                                                        @if ($latest)
                                                            <div class="whats-news-single mb-40">
                                                                <div class="whates-img">
                                                                    @php
                                                                        $fotoName = $latest->foto;
                                                                        $pathFisik = 'foto_sampah/' . $fotoName;

                                                                        // Validasi menggunakan Storage disk public agar konsisten
                                                                        $fotoTersedia =
                                                                            !empty($fotoName) &&
                                                                            $fotoName !== 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlFoto = $fotoTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_sampah/sampah-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <img src="{{ $urlFoto }}"
                                                                        alt="{{ $latest->penyetor }}"
                                                                        style="width: 360px; height: 245px; object-fit: cover;">
                                                                </div>
                                                                <div class="whates-caption">
                                                                    <h4><a href="{{ route('sampah') }}"
                                                                            target="_blank">Penyetor:
                                                                            {{ $latest->penyetor }}</a></h4>
                                                                    <span>{{ \Carbon\Carbon::parse($latest->tgl)->format('M d, Y') }}</span>
                                                                    <p>Nilai transaksi sampah ini adalah
                                                                        <strong>Rp{{ number_format($latest->nilai, 0, ',', '.') }}</strong>.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Right single caption -->
                                                    <div class="col-xl-6 col-lg-12">
                                                        <div class="sampah-wrapper" style="height:400px;overflow:hidden;">
                                                            <div class="sampah-vertical-active">

                                                                @foreach ($sampahs->skip(1)->take(4) as $item)
                                                                    @php
                                                                        $fotoName = $item->foto;
                                                                        $pathFisik = 'foto_sampah/' . $fotoName;

                                                                        // Validasi menggunakan Storage disk public agar konsisten
                                                                        $fotoTersedia =
                                                                            !empty($fotoName) &&
                                                                            $fotoName !== 'none' &&
                                                                            Storage::disk('public')->exists($pathFisik);

                                                                        $urlFoto = $fotoTersedia
                                                                            ? asset('storage/' . $pathFisik)
                                                                            : asset(
                                                                                'storage/foto_sampah/sampah-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px;">
                                                                            <img src="{{ $urlFoto }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;"
                                                                                alt="{{ $item->penyetor }}">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Sedekah Sampah</span>
                                                                            <h4><a href="{{ route('sampah') }}"
                                                                                    target="_blank">Penyetor:
                                                                                    {{ $latest->penyetor }}</a></h4>
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

                                                        // Validasi foto untuk item pertama ($latest)
                                                        $latestFotoName = $latest->foto ?? null; // Sesuaikan nama kolom jika berbeda, misal $latest->poster
                                                        $latestPathFisik = 'foto_mangrove/' . $latestFotoName;
                                                        $latestFotoTersedia =
                                                            !empty($latestFotoName) &&
                                                            $latestFotoName !== 'none' &&
                                                            Storage::disk('public')->exists($latestPathFisik);

                                                        $latestUrlFoto = $latestFotoTersedia
                                                            ? asset('storage/' . $latestPathFisik)
                                                            : asset('storage/foto_mangrove/mangrove-default.jpeg');
                                                    @endphp

                                                    <!-- Left Details Caption -->
                                                    <div class="col-xl-6">
                                                        <div class="whats-news-single mb-40">
                                                            <div class="whates-img">
                                                                <img src="{{ $latestUrlFoto }}"
                                                                    alt="{{ $latest->donatur }}"
                                                                    style="width: 360px; height: 245px; object-fit: cover;">
                                                            </div>
                                                            <div class="whates-caption">
                                                                <h4><a href="{{ route('mangrove') }}"
                                                                        target="_blank">Donatur:
                                                                        {{ $latest->donatur }}</a>
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
                                                                    @php
                                                                        // Validasi foto untuk item loop ($item)
                                                                        $itemFotoName = $item->foto ?? null; // Sesuaikan nama kolom jika berbeda, misal $item->poster
                                                                        $itemPathFisik =
                                                                            'foto_mangrove/' . $itemFotoName;
                                                                        $itemFotoTersedia =
                                                                            !empty($itemFotoName) &&
                                                                            $itemFotoName !== 'none' &&
                                                                            Storage::disk('public')->exists(
                                                                                $itemPathFisik,
                                                                            );

                                                                        $itemUrlFoto = $itemFotoTersedia
                                                                            ? asset('storage/' . $itemPathFisik)
                                                                            : asset(
                                                                                'storage/foto_mangrove/mangrove-default.jpeg',
                                                                            );
                                                                    @endphp

                                                                    <div class="whats-right-single d-flex"
                                                                        style="height:120px;align-items:center;">

                                                                        <div class="whats-right-img"
                                                                            style="min-width:120px;">
                                                                            <img src="{{ $itemUrlFoto }}"
                                                                                style="width:120px;height:100px;object-fit:cover;border-radius:4px;"
                                                                                alt="{{ $item->donatur }}">
                                                                        </div>

                                                                        <div class="whats-right-cap ml-15">
                                                                            <span class="colorb">Infaq Mangrove</span>

                                                                            <h4><a href="{{ route('mangrove') }}"
                                                                                    target="_blank">Donatur:
                                                                                    {{ $item->donatur }}</a></h4>

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
                                        @php
                                            $fotoName = $utama->foto ?? null;
                                            $pathFisik = 'foto_opini/' . $fotoName;

                                            // Validasi menggunakan Storage disk public secara konsisten
                                            $fotoTersedia =
                                                !empty($fotoName) &&
                                                $fotoName !== 'none' &&
                                                Storage::disk('public')->exists($pathFisik);

                                            $urlFoto = $fotoTersedia
                                                ? asset('storage/' . $pathFisik)
                                                : asset('storage/foto_opini/opini-default.jpeg');
                                        @endphp

                                        <img src="{{ $urlFoto }}" alt="{{ $utama->judul }}"
                                            style="width: 333px !important; height: 229px !important; object-fit: cover;">

                                        <div class="most-recent-cap">
                                            <span class="bgbeg">Opini</span>
                                            <h4><a href="{{ route('opini.detil', $utama->id_op) }}"
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
                                            <h4><a href="{{ route('opini.detil', $item->id_op) }}"
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
                                                        <img src="{{ !empty($item->poster) && $item->poster !== 'none' && Storage::disk('public')->exists('foto_khutbah/' . $item->poster) ? asset('storage/foto_khutbah/' . $item->poster) : asset('storage/foto_khutbah/khutbah-default.jpeg') }}"
                                                            alt="{{ $item->judul }}"
                                                            style="width: 235px; height: 155px; object-fit: cover;">
                                                    </div>
                                                    <div class="weekly2-caption">
                                                        <h4>
                                                            <a href="{{ route('khutbah.detil', $item->id_kj) }}"
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
                                                <a href="{{ route('kajian.detil', $item->id) }}"
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
                                                            <a href="{{ route('opini.detil', $opini->id_op) }}"
                                                                target="_blank">
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
                            <a "{{ route('register') }}" target="_blank">
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
