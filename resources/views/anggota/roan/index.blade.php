@extends('layouts.main')

@section('title', 'Roan Bersih Pantai')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Roan Bersih Pantai</h2>
                            <p class="text-gray-500">Daftar kegiatan kerja bakti yang dapat Anda ikuti.</p>
                        </div>
                    </div>

                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6">
                            {{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6">{{ session('error') }}
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div x-data="{ openModal: false, selectedRoan: null }"
                        class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Lokasi</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Vol</th>
                                    <th class="p-4 text-center">Detil</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300 text-center">Daftar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($roans as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->tgl)->format('d/m/Y') }}
                                            <br>
                                            @php
                                                $tglAcara = \Carbon\Carbon::parse($item->tgl);
                                                $hariIni = \Carbon\Carbon::today();
                                                $sisaHari = $hariIni->diffInDays($tglAcara, false);
                                            @endphp

                                            @if ($sisaHari > 0)
                                                <span class="text-[10px] text-blue-500 font-semibold italic">
                                                    {{ $sisaHari }} hari lagi
                                                </span>
                                            @elseif ($sisaHari == 0)
                                                <span class="text-[10px] text-green-500 font-semibold italic">
                                                    Hari H
                                                </span>
                                            @else
                                                <span class="text-[10px] text-gray-400 font-semibold italic">
                                                    Sudah lewat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->lokasi }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->vol_sampah }} m³</td>
                                        <td class="p-4 text-center">
                                            <button type="button"
                                                @click="selectedRoan = {{ $item->id_ro }}; openModal = true"
                                                class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                                                {{ $item->peserta_count }} Peserta
                                            </button>
                                        </td>
                                        <td class="p-4 text-center">
                                            @if (\Carbon\Carbon::parse($item->tgl)->isPast())
                                                <span
                                                    class="text-xs text-red-500 font-bold bg-red-100 px-2 py-1 rounded-full">Ditutup</span>
                                            @else
                                                <button type="button"
                                                    onclick="confirmDaftar('{{ route('anggota.roan.daftar', $item->id_ro) }}')"
                                                    title="Daftar" class="text-blue-600 hover:text-blue-800 relative z-10">
                                                    <i class="ri-add-line text-xl"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Modal Lengkap --}}
                        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                            x-cloak>
                            <div @click.away="openModal = false"
                                class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-2xl shadow-xl max-h-[90vh] overflow-y-auto">
                                @foreach ($roans as $item)
                                    <div x-show="selectedRoan === {{ $item->id_ro }}">
                                        <h3 class="font-bold text-lg mb-4 dark:text-white border-b pb-2">Detail:
                                            {{ $item->judul }}</h3>
                                        <div class="text-sm dark:text-gray-300 space-y-2 mb-6">
                                            <p><strong>PJ:</strong> {{ $item->pj }}</p>
                                            <p><strong>Tema:</strong> {{ $item->tema }}</p>
                                            <p><strong>Deskripsi:</strong> {{ $item->deskripsi }}</p>
                                        </div>

                                        <h4 class="font-bold mb-3 dark:text-white">Galeri Foto</h4>
                                        <div class="grid grid-cols-3 gap-3 mb-6">
                                            @if (!empty($item->foto))
                                                @foreach (explode(';', $item->foto) as $f)
                                                    @if (trim($f) !== '')
                                                        <a href="{{ asset('storage/foto_roan/' . trim($f)) }}"
                                                            target="_blank">
                                                            <img src="{{ asset('storage/foto_roan/' . trim($f)) }}"
                                                                class="w-full h-24 object-cover rounded-lg border dark:border-gray-700 hover:opacity-75 transition">
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                <p class="text-sm text-gray-400 italic">Tidak ada foto.</p>
                                            @endif
                                        </div>

                                        <h4 class="font-bold mb-3 dark:text-white">Daftar Peserta
                                            ({{ $item->peserta_count }})</h4>
                                        <div
                                            class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 mb-6 max-h-40 overflow-y-auto">
                                            @forelse($item->peserta as $p)
                                                <div class="flex justify-between border-b dark:border-gray-700 py-2">
                                                    <span class="text-sm dark:text-gray-200">{{ $p->name }}</span>
                                                    <span class="text-xs text-gray-500">{{ $p->email }} |
                                                        {{ $p->telpon }}</span>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-400">Tidak ada peserta.</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" @click="openModal = false"
                                    class="w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl text-sm font-bold dark:text-white hover:bg-gray-200 transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDaftar(url) {
            Swal.fire({
                title: 'Konfirmasi',
                text: "Saya dengan sadar dan sukarela ingin mengikuti kegiatan ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Daftar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        }
    </script>
@endsection
