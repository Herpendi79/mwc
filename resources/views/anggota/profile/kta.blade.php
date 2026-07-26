@extends('layouts.main')

@section('title', 'Anggota Dashboard')

@section('content')

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        {{-- Memanggil Sidebar --}}
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-2 dark:text-white">Preview KTA</h2>
                            <p class="text-gray-500">Berikut adalah kartu anggota anda:</p>
                        </div>

                        @if ($anggota)
                            @php
                                // Mencari file dengan awalan "Template." di dalam folder public/assets/images/template/
                                $templateFiles = glob(public_path('assets/images/template/Template.*'));

                                // Default path jika file tidak ditemukan
                                $templatePath = 'assets/images/template/TemplateBU.png';

                                if (!empty($templateFiles)) {
                                    // Ambil nama file asli beserta ekstensinya (misal: Template.jpg atau Template.png)
                                    $templatePath = 'assets/images/template/' . basename($templateFiles[0]);
                                }
                            @endphp

                            <div class="w-full max-w-sm aspect-[86/54] relative shadow-xl rounded-2xl overflow-hidden border border-gray-200"
                                style="background-image: url('{{ asset($templatePath) }}'); background-size: cover; background-position: center;">

                                <div
                                    class="absolute top-[30%] right-[7%] w-[35%] aspect-square rounded-full overflow-hidden border-4 border-yellow-500 shadow-lg">
                                    <img src="{{ $anggota->foto ? asset('storage/foto/' . $anggota->foto) : asset('assets/images/default-avatar.png') }}"
                                        alt="Foto" class="w-full h-full object-cover">
                                </div>

                                <div class="absolute top-[36.5%] left-[5%] w-[60%] flex flex-col text-white">
                                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-yellow-300">MWC TUGU
                                    </h3>
                                    <p class="text-xl font-black mt-1">
                                        TG{{ str_pad($anggota->id_anggota, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                    <p class="text-sm font-bold mt-1">{{ auth()->user()->name }}</p>
                                    <p class="text-[9px] mt-2 text-white/80">
                                        Masa Aktif: {{ $anggota->created_at->format('d M Y') }} -
                                        {{ $anggota->created_at->addYear()->format('d M Y') }}
                                    </p>
                                </div>


                            </div>

                            <div class="mt-6">
                                <a href="{{ route('anggota.download_Kta') }}" target="_blank"
                                    class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition">
                                    Download
                                </a>
                            </div>
                        @else
                            <div class="p-6 bg-yellow-50 border border-yellow-200 rounded-2xl text-yellow-800">
                                Data anggota belum ditemukan. Silakan lengkapi profil anggota Anda terlebih dahulu.
                            </div>
                        @endif
                    </div>

                    {{-- Memanggil Footer --}}
                    @include('anggota.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
@endsection
