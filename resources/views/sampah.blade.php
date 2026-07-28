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
                                <img class="img-fluid" src="{{ asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                    alt="{{ $dataBerita->judul ?? 'Infaq Mangrove' }}">
                            </div>
                            <div class="blog_details">
                                <h2>
                                    Sedekah Sampah untuk Lingkungan yang Sehat & Bumi Panjang Umur
                                </h2>
                                <ul class="blog-info-link mt-3 mb-4">
                                    <li><i class="fa fa-user"></i> Admin</li>
                                    <li><i class="fa fa-map-marker"></i> Semarang</li>
                                </ul>

                                <p class="excert" style="text-align: justify; line-height: 1.6;">
                                    <strong>Sampah yang dikelola dengan baik bukan lagi menjadi masalah, tetapi dapat
                                        menjadi
                                        ladang amal dan manfaat bagi lingkungan.</strong> Melalui kebiasaan memilah dan
                                    menyedekahkan sampah yang masih memiliki nilai ekonomi, kita turut mengurangi
                                    pencemaran,
                                    menjaga kebersihan lingkungan, menghemat sumber daya alam, serta mendukung proses daur
                                    ulang.
                                    Langkah sederhana ini menjadi bentuk kepedulian nyata terhadap bumi sekaligus
                                    menciptakan
                                    lingkungan yang sehat, nyaman, dan berkelanjutan bagi generasi mendatang.
                                    <br><br>
                                    <strong>MWC NU Tugu Semarang</strong> mengajak seluruh warga Nahdliyin, masyarakat,
                                    dan para dermawan untuk bersama-sama mengikuti program
                                    <strong>Sedekah Sampah</strong>. Sampah yang Anda sedekahkan akan dikelola secara
                                    bertanggung jawab, kemudian hasilnya dimanfaatkan untuk mendukung kegiatan sosial,
                                    keagamaan, pendidikan, dan pemberdayaan umat. Mari ubah kebiasaan membuang sampah
                                    menjadi budaya berbagi manfaat. Karena setiap botol plastik, kertas, kardus, atau
                                    barang bekas yang Anda sedekahkan bukan hanya membantu menjaga kebersihan lingkungan,
                                    tetapi juga menjadi amal kebaikan yang memberikan manfaat bagi sesama.
                                    <strong>Bersama MWC NU Tugu Semarang, mari jadikan sampah bernilai sedekah,
                                        lingkungan semakin bersih, dan keberkahan terus mengalir untuk umat.</strong>
                                </p>
                                <hr>
                                <div class="excert bg-emerald-800 dark:bg-emerald-950 border border-emerald-700 dark:border-emerald-900 p-6 rounded-2xl shadow-md"
                                    style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 8px;">

                                    <form action="{{ route('sampah.simpan') }}" method="POST" enctype="multipart/form-data"
                                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm w-full"
                                        x-data="{
                                            jenisSedekah: 'sampah',
                                            berat: {{ old('berat', 0) }},
                                            hargaPerKg: {{ old('harga_per_kg', 0) }},
                                            formatRupiah(num) {
                                                if (!num) return 'Rp 0';
                                                let numberString = num.toString().replace(/[^,\d]/g, '');
                                                let split = numberString.split(',');
                                                let sisa = split[0].length % 3;
                                                let rupiah = split[0].substr(0, sisa);
                                                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                                                if (ribuan) {
                                                    let separator = sisa ? '.' : '';
                                                    rupiah += separator + ribuan.join('.');
                                                }
                                                return 'Rp ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);
                                            },
                                            updateHarga(e) {
                                                // Ambil angka saja untuk disimpan ke variabel state
                                                let angkaBersih = e.target.value.replace(/[^0-9]/g, '');
                                                this.hargaPerKg = angkaBersih ? parseInt(angkaBersih) : 0;
                                                // Tampilkan kembali format Rupiah ke input teks
                                                e.target.value = this.formatRupiah(this.hargaPerKg);
                                            }
                                        }">
                                        @csrf

                                        {{-- Opsi Radio Button Jenis Sedekah --}}
                                        <div
                                            class="mb-6 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                                            <label class="block text-sm font-bold mb-3 dark:text-gray-300">Pilih Jenis
                                                Sedekah</label>
                                            <div class="flex gap-6">
                                                <label
                                                    class="flex items-center gap-2 cursor-pointer font-medium dark:text-gray-300">
                                                    <input type="radio" name="jenis_sedekah" value="sampah"
                                                        x-model="jenisSedekah"
                                                        class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                                                    Sampah
                                                </label>
                                                <label
                                                    class="flex items-center gap-2 cursor-pointer font-medium dark:text-gray-300">
                                                    <input type="radio" name="jenis_sedekah" value="pengelolaan"
                                                        x-model="jenisSedekah"
                                                        class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                                                    Pengelolaan
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Baris Penyetor & Jenis Sampah (Jenis Sampah hanya muncul jika opsi 'sampah') --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                            <div>
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama
                                                    Penyetor</label>
                                                <input type="text" name="penyetor" value="{{ old('penyetor') }}" required
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">
                                            </div>
                                            <div x-show="jenisSedekah === 'sampah'">
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jenis
                                                    Sampah</label>
                                                <input type="text" name="jenis" value="{{ old('jenis') }}"
                                                    :required="jenisSedekah === 'sampah'"
                                                    placeholder="Misal: Plastik, Kertas dll"
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">
                                            </div>
                                        </div>

                                        {{-- Baris Berat, Harga/Kg, Total Nilai (Hanya muncul jika opsi 'sampah') --}}
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5"
                                            x-show="jenisSedekah === 'sampah'">

                                            {{-- Berat (Kg) --}}
                                            <div>
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Berat
                                                    (Kg)</label>
                                                <input type="number" step="0.01" name="berat" x-model.number="berat"
                                                    :required="jenisSedekah === 'sampah'"
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">
                                            </div>

                                            {{-- Harga/Kg (Rp) - Diinput Manual dengan Format Rupiah Otomatis --}}
                                            <div>
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Harga/Kg
                                                    (Rp)</label>
                                                <input type="text" @input="updateHarga($event)"
                                                    :value="formatRupiah(hargaPerKg)"
                                                    :required="jenisSedekah === 'sampah'" placeholder="Rp 0"
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">

                                                {{-- Input tersembunyi untuk mengirim angka murni harga per kg ke controller --}}
                                                <input type="hidden" name="harga_per_kg" :value="hargaPerKg">
                                            </div>

                                            {{-- Setara Dengan (Rp) - Otomatis Menghitung Hasil Perkalian --}}
                                            <div>
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Setara Dengan
                                                    (Rp)</label>
                                                <input type="text" :value="formatRupiah(berat * hargaPerKg)" readonly
                                                    class="w-full p-3 rounded-xl border bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">

                                                {{-- Input tersembunyi untuk mengirim total nilai ke controller --}}
                                                <input type="hidden" name="nilai" :value="berat * hargaPerKg"
                                                    :disabled="jenisSedekah === 'pengelolaan'">
                                            </div>
                                        </div>

                                        {{-- Total Nilai Manual (Hanya muncul jika opsi 'pengelolaan') --}}
                                        <div class="mb-5" x-show="jenisSedekah === 'pengelolaan'">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Total Nilai
                                                (Rp)</label>

                                            {{-- Input yang tampil ke pengguna dengan format Rupiah --}}
                                            <input type="text" id="display_nilai_manual"
                                                :required="jenisSedekah === 'pengelolaan'" placeholder="Rp 0"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">

                                            {{-- Input tersembunyi untuk mengirim data angka asli ke controller --}}
                                            <input type="hidden" name="nilai" id="nilai_manual_hidden"
                                                :disabled="jenisSedekah === 'sampah'">
                                        </div>

                                        {{-- Baris Petugas & Tanggal --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                            <div>
                                                <label
                                                    class="block text-sm font-bold mb-2 dark:text-gray-300">Petugas</label>
                                                <input type="text" name="petugas" required
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email
                                                    Penyetor (Untuk Notifikasi)</label>
                                                <input type="email" name="email" required
                                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition">
                                            </div>
                                        </div>

                                        {{-- Foto & Keterangan --}}
                                        <div class="mb-5">
                                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto
                                                Bukti (Opsional)</label>
                                            <input type="file" name="foto" accept="image/*"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        </div>

                                        <div class="mb-8">
                                            <label
                                                class="block text-sm font-bold mb-2 dark:text-gray-300">Keterangan</label>
                                            <textarea name="ket" rows="3"
                                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/25 transition"></textarea>
                                        </div>

                                        {{-- Tombol Aksi --}}
                                        <div class="flex gap-4 mt-6">
                                            <button type="submit"
                                                class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 active:bg-emerald-800 transition shadow-lg shadow-emerald-600/20">
                                                Bismillah Sedekah
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
                                <h3 class="widget_title">Donatur Terbaru</h3>
                                <div class="relawan-vertical-active">
                                    @foreach ($recentPosts as $post)
                                        @php
                                            // Cek apakah kolom foto ada isinya dan filenya tidak kosong, jika tidak pakai default
                                            $fotoPoster = !empty($post->foto)
                                                ? asset('storage/foto_sampah/' . $post->foto)
                                                : asset('storage/foto_sampah/sampah-default.jpeg');
                                        @endphp

                                        <div class="media post_item">
                                            <img src="{{ $fotoPoster }}" alt="post"
                                                style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                            <div class="media-body">

                                                    <h3 style="margin: 0; font-size: 16px; line-height: 1.2;">
                                                        {{ Str::limit($post->penyetor, 70) }}
                                                    </h3>

                                                <p style="margin: 0; font-size: 12px; font-weight: bold; color: #059669;">
                                                    {{-- Format nilai menjadi Rupiah menggunakan NumberFormatter / helper bawaan --}}
                                                    Rp {{ number_format($post->nilai, 0, ',', '.') }}
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
                                        // 1. Ambil semua file dari disk public di dalam folder 'foto_sampah'
                                        // Pastikan Anda sudah menjalankan `php artisan storage:link`
                                        $semuaFile = \Illuminate\Support\Facades\Storage::disk('public')->files(
                                            'foto_sampah',
                                        );

                                        // 2. Filter hanya mengambil file berekstensi gambar
                                        $listFoto = array_filter($semuaFile, function ($file) {
                                            return preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file);
                                        });

                                        // 3. Acak urutan array gambar
                                        shuffle($listFoto);

                                        // 4. Ambil maksimal 9 gambar teratas setelah diacak
                                        $fotoRandom = array_slice($listFoto, 0, 9);
                                    @endphp

                                    {{-- Gunakan forelse agar ada pesan jika folder kosong --}}
                                    @forelse ($fotoRandom as $foto)
                                        @php
                                            // Hasil scan Storage menghasilkan format: 'foto_sampah/nama_file.jpg'
                                            $urlFoto = asset('storage/' . $foto);
                                        @endphp
                                        <li style="width: 90px; height: 90px;">
                                            <a href="{{ $urlFoto }}" target="_blank" rel="noopener noreferrer">
                                                <img src="{{ $urlFoto }}" alt="Foto Galeri"
                                                    style="width: 90px; height: 90px; object-fit: cover; border-radius: 4px; display: block;">
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

        // Fungsi pembantu format Rupiah
        function formatRupiah(angka) {
            if (!angka) return 'Rp 0';
            let numberString = angka.toString().replace(/[^,\d]/g, '');
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return 'Rp ' + (split[1] !== undefined ? rupiah + ',' + split[1] : rupiah);
        }

        // Logika Input Total Nilai Manual (Pengelolaan)
        const displayNilaiManual = document.getElementById('display_nilai_manual');
        const hiddenNilaiManual = document.getElementById('nilai_manual_hidden');

        if (displayNilaiManual) {
            // Gunakan event 'input' agar responsif saat diketik maupun dihapus
            displayNilaiManual.addEventListener('input', function(e) {
                this.value = formatRupiah(this.value);
                if (hiddenNilaiManual) {
                    // Menyimpan angka murni ke input hidden
                    hiddenNilaiManual.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        }
    </script>
@endsection
