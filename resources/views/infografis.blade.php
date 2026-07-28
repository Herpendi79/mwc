@extends('layouts.main_free')

@section('title', 'Portal MWC NU Tugu')

@section('content')
    <style>
        .relawan-vertical-active {
            max-height: 320px;
            /* Sesuaikan tinggi agar muat sekitar 3 item */
            overflow: hidden;
        }

        .relawan-vertical-active .post_item {
            margin-bottom: 15px !important;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eee;
        }

        .relawan-vertical-active .post_item:last-child {
            border-bottom: none;
        }
    </style>
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
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Peserta Bahtsul Masail</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:350px; width:100%">
                                            <canvas id="pesertaBahsulChart"></canvas>
                                        </div>
                                    </div>

                                    <ul class="blog-info-link">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-book"></i>Data Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Peserta Halaqah</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:300px; width:100%">
                                            <canvas id="pesertaHalaqahChart"></canvas>
                                        </div>
                                    </div>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Peserta Roan Bersih Pantai</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:300px; width:100%">
                                            <canvas id="pesertaRoanChart"></canvas>
                                        </div>
                                    </div>

                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Relawan Banjir</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:320px; width:100%">
                                            <canvas id="relawanBanjirChart"></canvas>
                                        </div>
                                    </div>

                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Lapor Bencana</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:320px; width:100%">
                                            <canvas id="laporBencanaChart"></canvas>
                                        </div>
                                    </div>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Donatur Mangrove</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:320px; width:100%">
                                            <canvas id="donaturMangroveChart"></canvas>
                                        </div>
                                    </div>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                        <div class="blog_left_sidebar">
                            <article class="blog_item">
                                <div class="blog_item_img">
                                    <a href="#" class="blog_item_date">
                                        <p>Donatur Sampah</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <div class="mb-4">
                                        <div style="position: relative; height:320px; width:100%">
                                            <canvas id="donaturSampahChart"></canvas>
                                        </div>
                                    </div>
                                    <ul class="blog-info-link">
                                        <li><a href="#"><i class="fa fa-book"></i> Update
                                                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</a></li>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="blog_right_sidebar">
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('bahsul') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_bahsul/ayo.jpeg') }}"
                                            alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                    </a>
                                </div>
                            </aside>
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('halaqah') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_halaqah/ayo.jpeg') }}"
                                            alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                    </a>
                                </div>
                            </aside>
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('roan') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_roan/ayo.jpeg') }}"
                                            alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                    </a>
                                </div>
                            </aside>
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('relawan') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_relawan/ayo.jpeg') }}"
                                            alt="Banner Klik" style="width: 100%; border-radius: 4px; display: block;">
                                    </a>
                                </div>
                            </aside>
                            <aside class="single_sidebar_widget">
                                <div class="banner_img">
                                    <a href="{{ route('bencana') }}" target="_blank">
                                        <img class="img-fluid" src="{{ asset('storage/foto_bencana/ayo.jpeg') }}"
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
                            <aside class="single_sidebar_widget" target="_blank">
                                <div class="banner_img">
                                    <a href="{{ route('register') }}">
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
        <!--================Blog Area =================-->
    </main>
    @include('partials.footer')
@endsection
@section('scripts')
    <!-- Sertakan Chart.js CDN jika belum ada di layout utama -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('pesertaBahsulChart').getContext('2d');

            // Mengambil data dari variabel PHP yang dikirim via Controller
            const rawData = @json($chartData);

            // Memisahkan Judul Bahtsul dan Total Peserta untuk Grafik
            const labels = rawData.map(item => item.judul);
            const dataCounts = rawData.map(item => item.peserta_count);

            new Chart(ctx, {
                type: 'bar', // Bisa diganti 'line', 'pie', dll.
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peserta',
                        data: dataCounts,
                        backgroundColor: 'rgba(5, 150, 105, 0.7)', // Warna Emerald konsisten dengan UI
                        borderColor: 'rgb(5, 150, 105)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        x: {
                            ticks: {
                                callback: function(val, index) {
                                    // Memotong teks judul yang terlalu panjang di sumbu X agar rapi
                                    let label = this.getLabelForValue(val);
                                    return label.length > 20 ? label.substr(0, 20) + '...' : label;
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxHalaqah = document.getElementById('pesertaHalaqahChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const halaqahData = @json($chartHalaqah);

            const labels = halaqahData.map(item => item.mubaligh || item.judul); // Sesuaikan kolom judul/pemateri
            const dataCounts = halaqahData.map(item => item.peserta_count);

            // Palet warna yang selaras dengan tema hijau/emerald
            const backgroundColors = [
                'rgba(5, 150, 105, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(52, 211, 153, 0.8)',
                'rgba(4, 120, 87, 0.8)',
                'rgba(6, 95, 70, 0.8)',
                'rgba(110, 231, 183, 0.8)'
            ];

            new Chart(ctxHalaqah, {
                type: 'doughnut', // Menggunakan Doughnut Chart sebagai variasi
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataCounts,
                        backgroundColor: backgroundColors,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxRoan = document.getElementById('pesertaRoanChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const roanData = @json($chartRoan);

            const labels = roanData.map(item => item.judul || item
                .lokasi); // Sesuaikan dengan kolom judul/lokasi kegiatan
            const dataCounts = roanData.map(item => item.peserta_count);

            // Palet warna yang berbeda (misalnya nuansa biru/teal laut)
            const pieColors = [
                'rgba(14, 165, 233, 0.8)',
                'rgba(2, 132, 199, 0.8)',
                'rgba(3, 105, 161, 0.8)',
                'rgba(56, 189, 248, 0.8)',
                'rgba(125, 211, 252, 0.8)'
            ];

            new Chart(ctxRoan, {
                type: 'pie', // Menggunakan Pie Chart sebagai variasi baru
                data: {
                    labels: labels,
                    datasets: [{
                        data: dataCounts,
                        backgroundColor: pieColors,
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxBanjir = document.getElementById('relawanBanjirChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const banjirData = @json($chartBanjir);

            const labels = banjirData.map(item => item.judul || item.lokasi); // Sesuaikan kolom judul/lokasi
            const dataCounts = banjirData.map(item => item.peserta_count);

            // Palet warna nuansa oranye/amber (karakteristik tanggap darurat/siaga)
            const barColors = [
                'rgba(245, 158, 11, 0.8)',
                'rgba(217, 119, 6, 0.8)',
                'rgba(249, 115, 22, 0.8)',
                'rgba(234, 88, 12, 0.8)',
                'rgba(194, 65, 12, 0.8)'
            ];

            new Chart(ctxBanjir, {
                type: 'bar', // Menggunakan bar dengan konfigurasi indexAxis 'y'
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Relawan',
                        data: dataCounts,
                        backgroundColor: barColors,
                        borderColor: 'rgb(217, 119, 6)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    indexAxis: 'y', // Membuat grafik batangnya menjadi mendatar (horizontal)
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxBencana = document.getElementById('laporBencanaChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const bencanaData = @json($chartBencana);

            // Memetakan label bulan dan total laporan
            const labels = bencanaData.map(item => item.label_bulan);
            const dataCounts = bencanaData.map(item => item.total_laporan);

            new Chart(ctxBencana, {
                type: 'line', // Menggunakan Line Chart untuk tren bulanan
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: dataCounts,
                        backgroundColor: 'rgba(239, 68, 68, 0.2)', // Nuansa merah siaga bencana
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3 // Membuat garis sedikit melengkung halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxMangrove = document.getElementById('donaturMangroveChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const mangroveData = @json($chartMangrove);

            // Memetakan tanggal (diformat agar rapi) dan total infaq
            const labels = mangroveData.map(item => {
                const date = new Date(item.tanggal);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            });
            const dataInfaq = mangroveData.map(item => item.total_infaq);

            new Chart(ctxMangrove, {
                type: 'bar', // Menggunakan Bar Chart untuk total finansial/infaq
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Infaq (Rp)',
                        data: dataInfaq,
                        backgroundColor: 'rgba(16, 185, 129, 0.75)', // Nuansa hijau alam/mangrove
                        borderColor: 'rgb(5, 150, 105)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Format angka pada sumbu Y menjadi format mata uang/ribuan
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw || 0;
                                    return ' Total Infaq: Rp ' + Number(value).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctxSampah = document.getElementById('donaturSampahChart').getContext('2d');

            // Mengambil data dari variabel PHP controller
            const sampahData = @json($chartSampah);

            // Memetakan tanggal dan total nilai
            const labels = sampahData.map(item => {
                const date = new Date(item.tgl);
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            });
            const dataNilai = sampahData.map(item => item.total_nilai);

            new Chart(ctxSampah, {
                type: 'line', // Menggunakan Line Chart dengan area terisi (fill)
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Nilai (Rp)',
                        data: dataNilai,
                        backgroundColor: 'rgba(14, 165, 233, 0.2)', // Nuansa biru kebersihan
                        borderColor: 'rgb(14, 165, 233)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgb(14, 165, 233)',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Format sumbu Y menjadi format mata uang Rupiah
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw || 0;
                                    return ' Total Nilai: Rp ' + Number(value).toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
