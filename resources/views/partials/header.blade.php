    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-bottom header-sticky">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-9 col-md-8">
                                <!-- sticky -->
                                <!-- Perbaikan pada bagian sticky-logo -->
                                <div class="sticky-logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('assets/images/logo/logomwc_mobile.png') }}"
                                            alt="Logo MWC NU Tugu" style="max-height: 50px; width: auto;">
                                    </a>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{ route('index') }}">Home</a></li>
                                            <li><a href="{{ route('berita') }}" target="_blank">Berita</a>
                                            </li>
                                            <li><a href="{{ route('opini_warga') }}" target="_blank">Opini</a>
                                            </li>
                                            <li><a href="#">Kajian ></a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('bahsul') }}" target="_blank">Bahtsul
                                                            Masail</a></li>
                                                    <li><a href="{{ route('halaqah') }}" target="_blank">Halaqah</a>
                                                    </li>
                                                    <li><a href="{{ route('kajian') }}" target="_blank">Pengajian</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Program > </a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('mangrove') }}" target="_blank">Infaq
                                                            Mangrove</a></li>
                                                    <li><a href="{{ route('sampah') }}" target="_blank">Sedekah
                                                            Sampah</a></li>
                                                    <li><a href="{{ route('roan') }}" target="_blank">Roan Bersih
                                                            Pantai</a></li>
                                                    <li><a href="{{ route('relawan') }}" target="_blank">Relawan
                                                            Banjir</a></li>
                                                    <li><a href="{{ route('bencana') }}" target="_blank">Lapor
                                                            Bencana</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Download > </a>
                                                <ul class="submenu">
                                                    <li><a href="{{ route('khutbah') }}" target="_blank">Khutbah Jumat</a></li>
                                                    <li><a href="{{ route('pesan_dakwah') }}" target="_blank">Pesan Dakwah</a></li>
                                                    <li><a href="{{ route('infografis') }}" target="_blank">Infografis</a></li>
                                                </ul>
                                            </li>

                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <div class="header-right f-right d-none d-lg-block">
                                    <!-- Heder social -->
                                    <ul class="header-social">
                                        <!-- Facebook -->
                                        <li><a href="https://www.facebook.com/mwcnutugu" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a></li>

                                        <!-- Instagram -->
                                        <li><a href="https://www.instagram.com/mwcnutugu" target="_blank"><i
                                                    class="fab fa-instagram"></i></a></li>

                                        <!-- YouTube -->
                                        <li><a href="https://www.youtube.com/@mwcnutugu" target="_blank"><i
                                                    class="fab fa-youtube"></i></a></li>

                                        <!-- Twitter/X (Opsional) -->
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-md-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
