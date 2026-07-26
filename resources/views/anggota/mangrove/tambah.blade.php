@extends('layouts.main')

@section('title', 'Tambah Donasi Mangrove')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('anggota.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('anggota.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Infaq Mangrove</h2>
                        <p class="text-gray-500">Input jumlah pohon yang ingin anda donasikan.</p>
                    </div>
                    @if ($errors->any())
                        <div class="bg-red-100 p-4 mb-4 text-red-700">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('anggota.mangrove.simpan') }}" enctype="multipart/form-data" method="POST"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm"
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
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Donatur</label>
                                <input type="text" value="{{ auth()->user()->name }}" readonly
                                    class="w-full p-3 rounded-xl border bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" readonly
                                    class="w-full p-3 rounded-xl border bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">
                            </div>
                        </div>

                        {{-- Baris Harga, Jumlah, Total --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jumlah Pohon</label>
                                {{-- Tambahkan .number agar Alpine mengenali input sebagai angka --}}
                                <input type="number" name="jumlah_pohon" x-model.number="jumlah" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            {{-- HARGA DARI FILE (Tambahan Baru) --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Harga Per Pohon</label>
                                <div
                                    class="p-3 bg-gray-100 dark:bg-gray-800 rounded-xl border dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium">
                                    Rp {{ number_format($hargaMangrove ?? 0, 0, ',', '.') }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Total Infaq (Rp)</label>
                                <input type="text" :value="formatRupiah(harga * jumlah)" readonly
                                    class="w-full p-3 rounded-xl border bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">
                                <input type="hidden" name="jumlah_infaq" :value="harga * jumlah">
                            </div>
                        </div>

                        {{-- Baris Pembayaran --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Metode Pembayaran</label>
                                <select name="pembayaran" x-model="metode" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        {{-- Info Rekening & Upload Bukti --}}
                        <div x-show="metode === 'transfer'" x-cloak
                            class="mb-5 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-xl space-y-4">

                            {{-- Info Rekening --}}
                            <div>
                                <h4 class="font-bold text-blue-800 dark:text-blue-300 mb-2">Informasi Rekening Tujuan:</h4>
                                <div class="text-sm text-blue-700 dark:text-blue-400" x-show="rekening && rekening.bank">
                                    <p>Bank: <span class="font-bold" x-text="rekening.bank"></span></p>
                                    <p>No. Rekening: <span class="font-bold" x-text="rekening.no_rek"></span></p>
                                    <p>Atas Nama: <span class="font-bold" x-text="rekening.an"></span></p>
                                </div>
                                <p x-show="!rekening || !rekening.bank" class="text-red-500 text-sm">Data rekening tidak
                                    tersedia.</p>
                            </div>
                            <hr>

                            {{-- Input Bukti Transfer --}}
                            <div>
                                <label
                                    class="block text-sm font-bold mb-2 dark:text-gray-300 text-red-800 dark:text-red-300">
                                    Upload Bukti Transfer Disini (Max 2MB):
                                </label>
                                <input type="file" name="bukti_tf" accept="image/*" :required="metode === 'transfer'"
                                    class="w-full p-2 text-sm rounded-xl border border-red-200 dark:border-red-700 bg-white dark:bg-gray-800 dark:text-white outline-none">
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">* Wajib melampirkan bukti transfer.
                                </p>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                            Bismillah Infaq
                        </button>
                    </form>
                </div>
            </main>

        </div>
    </div>
@endsection
