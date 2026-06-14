@extends('layouts.main')

@section('title', 'Attendance')

@section('content')
    <style>
        /* Memastikan elemen tampil meskipun library animasi (SAL) belum termuat */
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Perbaikan khusus untuk input number agar lebih bersih */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="relative font-ibm">
        <!-- Paksa items-start di mobile agar bisa di-scroll, items-center di desktop -->
        <section
            class="min-h-screen py-10 md:py-20 bg-cover bg-center relative flex items-start md:items-center justify-center"
            style="background-image: url('{{ asset('assets/images/event/event-coming-soon.jpg') }}'); background-attachment: fixed;">

            <!-- Overlay diturunkan ke 40% (bg-black/40) agar background terlihat jelas -->
            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <!-- Margin bottom ditambahkan agar tidak mentok di layar HP saat scroll -->
            <div class="container relative z-50 px-4 mb-10 force-show">

                <!-- Padding dan Gap disesuaikan untuk Mobile (p-6) dan Desktop (md:p-12) -->
                <div class="text-center rounded-3xl md:p-30 p-6 bg-white/20 backdrop-blur-md text-white max-w-3xl mx-auto border border-white/30 shadow-2xl force-show"
                    data-sal="zoom-in" data-sal-duration="800">

                    <a href="{{ url('/') }}" class="inline-block mb-4 md:mb-6">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" class="h-10 md:h-12 mx-auto">
                    </a>

                    <h2 class="font-bold leading-snug mb-2 text-3xl md:text-5xl tracking-tight drop-shadow-md">
                        Attendance
                    </h2>
                    <p class="text-gray-200 mb-8 md:mb-10 text-sm md:text-base">Welcome and enjoy our Conference</p>

                    <!-- Tambahkan ini di atas tag <form> -->
                    @if ($errors->any())
                        <div class="bg-red-500/20 border border-red-500 text-white px-4 py-3 rounded-xl mb-6">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-500 border border-red-600 text-white px-4 py-3 rounded-xl mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div
                            class="bg-green-500/20 border border-green-500 text-green-100 px-4 py-3 rounded-xl mb-6 text-center font-bold">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (!isset($data))
                        <form action="{{ route('attendance.search') }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-6 text-left">
                            @csrf
                            <!-- Full Name -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium mb-2 ml-1 text-gray-200">Enter your registered email

                                </label>
                                <input type="email" name="email" placeholder="Enter your registered email in this system" required
                                    class="w-full bg-white/10 border border-white/30 rounded-xl px-5 py-3 md:py-3.5 outline-none focus:border-[#c0f037] transition-all text-white placeholder-gray-400">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-span-1 md:col-span-2 w-full flex justify-center mt-6 md:mt-8">
                                <button type="submit"
                                    class="w-full md:w-3/4 lg:w-1/2 bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-xl shadow-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] border border-white/10">
                                    Search
                                </button>
                            </div>
                        </form>
                    @else
                        <div
                            class="bg-white/10 backdrop-blur-md text-white p-6 rounded-2xl text-left space-y-4 border border-white/20">
                            <p>
                                <strong>Name:</strong>
                                @if ($type === 'adaksi')
                                    {{-- Mengakses relasi anggota yang didefinisikan di UserAdaksi --}}
                                    {{ $data->user->anggota->nama_anggota ?? 'Name not found' }}
                                @else
                                    {{-- Mengakses kolom name di tabel users untuk ICPIPHE --}}
                                    {{ $data->user->name ?? 'Name not found' }}
                                @endif
                            </p>
                            <p><strong>Email:</strong> {{ $email }}</p>
                            <p><strong>Status:</strong> {{ $data->kategori->nama_ktg ?? 'N/A' }}</p>

                            {{-- Cek apakah kehadiran sudah ada --}}
                            @if (!is_null($data->kehadiran))
                                <div
                                    class="bg-green-500/20 border border-green-500 text-green-100 p-3 rounded-lg text-center font-bold">
                                    Your attendance has been recorded. Thank you!
                                </div>
                            @endif
                        </div>

                        {{-- Tampilkan tombol hanya jika kehadiran masih null --}}
                        @if (is_null($data->kehadiran))
                            <form action="{{ route('attendance.confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="col-span-1 md:col-span-2 w-full flex justify-center mt-6 md:mt-8">
                                    <button type="submit"
                                        class="w-full md:w-3/4 lg:w-1/2 bg-[#065039] hover:bg-[#086347] text-white text-lg md:text-xl font-bold py-3.5 md:py-4 rounded-xl shadow-2xl transition-all transform hover:scale-[1.02] active:scale-[0.98] border border-white/10">
                                        Confirm Attendance
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif

                </div>
            </div>
        </section>
    </div>
@endsection
