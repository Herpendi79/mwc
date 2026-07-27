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
                                    src="{{ !empty($dataBerita->foto) && file_exists(public_path('storage/foto_berita/' . $dataBerita->foto))
                                        ? asset('storage/foto_berita/' . $dataBerita->foto)
                                        : asset('storage/foto_berita/berita-default.jpeg') }}"
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
                        <div class="comments-area">
                            <h4>{{ $dataBerita->komentar->count() }} Comments</h4>

                            @forelse ($dataBerita->komentar as $komentar)
                                {{-- Komentar Utama Pengguna --}}
                                <div class="comment-list">
                                    <div class="single-comment justify-content-between d-flex">
                                        <div class="user justify-content-between d-flex">
                                            <div class="thumb">
                                                <img src="{{ asset('assets/img/comment/comment_1.png') }}" alt="User">
                                            </div>
                                            <div class="desc">
                                                <p class="comment">
                                                    {{ $komentar->isi }}
                                                </p>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <h5>
                                                            <a href="#">{{ $komentar->nama }}</a>
                                                            @if ($komentar->sosmed)
                                                                <span class="text-muted"
                                                                    style="font-size: 12px; margin-left: 5px;">({{ $komentar->sosmed }})</span>
                                                            @endif
                                                        </h5>
                                                        <p class="date">
                                                            {{ $komentar->created_at->format('F j, Y \a\t g:i a') }}</p>
                                                    </div>

                                                    {{-- Tombol Reply hanya muncul jika Admin sedang login --}}
                                                    @auth
                                                        <div class="reply-btn">
                                                            <button type="button"
                                                                class="btn-reply text-uppercase border-0 bg-transparent text-primary"
                                                                onclick="toggleReplyForm({{ $komentar->id_com }})">reply</button>
                                                        </div>
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Balasan Admin (Zigzag / Bergeser ke Kanan) jika sudah ada isinya --}}
                                @if (!empty($komentar->reply))
                                    <div class="comment-list"
                                        style="margin-left: 50px; background-color: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 3px solid #007bff;">
                                        <div class="single-comment justify-content-between d-flex">
                                            <div class="user justify-content-between d-flex">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/img/comment/comment_2.png') }}"
                                                        alt="Admin">
                                                </div>
                                                <div class="desc">
                                                    <p class="comment">
                                                        {{ $komentar->reply }}
                                                    </p>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <h5>
                                                                <a href="#" style="color: #007bff;">Admin MWC NU
                                                                    Tugu</a>
                                                            </h5>
                                                            <p class="date">Official Response</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Form Reply Tersembunyi (Hanya untuk Admin yang Login) --}}
                                @auth
                                    <div id="reply-form-wrapper-{{ $komentar->id_com }}"
                                        style="display: none; margin-left: 50px; margin-bottom: 20px;" class="comment-form">
                                        <form id="form-reply-{{ $komentar->id_com }}"
                                            onsubmit="submitReply(event, {{ $komentar->id_com }})">
                                            @csrf
                                            <div class="form-group">
                                                <textarea class="form-type w-100 form-control" name="reply" rows="3"
                                                    placeholder="Tulis balasan sebagai admin..." required>{{ $komentar->reply }}</textarea>
                                            </div>
                                            <button type="submit" class="button button-contactForm btn_1 boxed-btn"
                                                style="padding: 5px 15px; font-size: 12px;">Kirim Balasan</button>
                                        </form>
                                    </div>
                                @endauth
                            @empty
                                <p class="text-muted" id="no-comment-text">Belum ada komentar pada berita ini. Jadilah yang
                                    pertama berkomentar!</p>
                            @endforelse
                        </div>

                        {{-- Skrip JavaScript untuk Toggle & AJAX Submit --}}
                        <script>
                            function toggleReplyForm(id) {
                                const formWrapper = document.getElementById(`reply-form-wrapper-${id}`);
                                if (formWrapper.style.display === "none" || formWrapper.style.display === "") {
                                    formWrapper.style.display = "block";
                                    formWrapper.style.opacity = 0;
                                    // Efek fade-in smooth sederhana
                                    let opacity = 0;
                                    let timer = setInterval(function() {
                                        if (opacity >= 1) clearInterval(timer);
                                        formWrapper.style.opacity = opacity;
                                        opacity += 0.1;
                                    }, 20);
                                } else {
                                    formWrapper.style.display = "none";
                                }
                            }

                            function submitReply(event, idCom) {
                                event.preventDefault();

                                const form = document.getElementById(`form-reply-${idCom}`);
                                const formData = new FormData(form);
                                const actionUrl = "{{ url('/admin/berita/komentar/reply') }}/" + idCom;

                                // Disable tombol saat mengirim
                                const submitBtn = form.querySelector('button[type="submit"]');
                                submitBtn.disabled = true;
                                submitBtn.innerText = 'Mengirim...';

                                fetch(actionUrl, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        },
                                        body: formData
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Cek apakah kotak balasan admin sudah ada sebelumnya di DOM
                                            let replyContainer = document.getElementById(`admin-reply-container-${idCom}`);

                                            const adminReplyHTML = `
                    <div class="comment-list" id="admin-reply-container-${idCom}" style="margin-left: 50px; background-color: #f9f9f9; padding: 15px; border-radius: 5px; border-left: 3px solid #007bff; opacity: 0; transition: opacity 0.5s ease;">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="{{ asset('assets/img/comment/comment_2.png') }}" alt="Admin">
                                </div>
                                <div class="desc">
                                    <p class="comment">${data.reply}</p>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <h5><a href="#" style="color: #007bff;">Admin MWC NU Tugu</a></h5>
                                            <p class="date">Just now</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                                            if (replyContainer) {
                                                // Update teks jika balasan sudah ada sebelumnya
                                                replyContainer.outerHTML = adminReplyHTML;
                                            } else {
                                                // Sisipkan elemen balasan tepat di bawah form / komentar terkait secara smooth
                                                const formWrapper = document.getElementById(`reply-form-wrapper-${idCom}`);
                                                formWrapper.insertAdjacentHTML('beforebegin', adminReplyHTML);
                                            }

                                            // Efek smooth memunculkan balasan baru
                                            setTimeout(() => {
                                                const newContainer = document.getElementById(`admin-reply-container-${idCom}`);
                                                if (newContainer) newContainer.style.opacity = 1;
                                            }, 50);

                                            // Sembunyikan form dan reset
                                            toggleReplyForm(idCom);
                                            form.reset();
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Terjadi kesalahan saat mengirim balasan.');
                                    })
                                    .finally(() => {
                                        submitBtn.disabled = false;
                                        submitBtn.innerText = 'Kirim Balasan';
                                    });
                            }
                        </script>
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
                                            {{-- Link ke route berita dengan filter bulan dan tahun --}}
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

                                <!-- Pastikan class ini sama dengan yang di-inisialisasi di script -->
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        <div class="media post_item">
                                            <img src="{{ asset('storage/foto_berita/' . ($post->poster ?? 'berita-default.jpeg')) }}"
                                                alt="post" style="width: 80px; height: 80px; object-fit: cover;">

                                            <div class="media-body">
                                                <a href="#">
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
                                    @foreach ($beritaPosts->take(10) as $post)
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
                                                {{-- Mengirimkan kata kunci tag ke route pencarian berita --}}
                                                <a href="{{ route('berita', ['keyword' => $kata]) }}">
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
                            <aside class="single_sidebar_widget newsletter_widget">
                                <h4 class="widget_title">Newsletter</h4>
                                <form action="#">
                                    <div class="form-group">
                                        <input type="email" class="form-control" onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Enter email'" placeholder='Enter email' required>
                                    </div>
                                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                        type="submit">Subscribe</button>
                                </form>
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
                             <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('mangrove') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_mangrove/ayo.jpeg') }}"
                                            alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                    </a>
                                </div>
                            </aside>
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('sampah') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_sampah/ayo.jpeg') }}"
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

            // Panggil untuk widget Download Materi Anda
            initVerticalSlider('.materi-vertical-slider');

            // Panggil untuk yang lain
            initVerticalSlider('.relawan-vertical-active');
            initVerticalSlider('#roan-container');
        });
    </script>
@endsection
