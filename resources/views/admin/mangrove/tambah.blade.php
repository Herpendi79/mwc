@extends('layouts.main')

@section('title', 'Tambah Donasi Mangrove')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Donasi Mangrove</h2>
                        <p class="text-gray-500">Input data donatur dan jumlah pohon yang didonasikan.</p>
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

                    <form action="{{ route('admin.mangrove.simpan') }}" enctype="multipart/form-data" method="POST"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm"
                        x-data="{
                            harga: {{ $hargaMangrove ?? 0 }},
                            jumlah: {{ old('jumlah_pohon', 0) }},
                            metode: '{{ old('pembayaran', 'tunai') }}',
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
                                <input type="text" name="donatur" value="{{ old('donatur') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        {{-- Baris Harga, Jumlah, Total --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jumlah Pohon</label>
                                <input type="number" name="jumlah_pohon" x-model.number="jumlah" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
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

                        {{-- Baris Pembayaran & Tanggal --}}
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
                            <hr class="border-blue-200 dark:border-blue-800">
                            <div>
                                <label class="block text-sm font-bold mb-2 text-red-800 dark:text-red-300">
                                    Upload Bukti Transfer Disini (Max 2MB):
                                </label>
                                <input type="file" name="bukti_tf" accept="image/*" :required="metode === 'transfer'"
                                    class="w-full p-2 text-sm rounded-xl border border-red-200 dark:border-red-700 bg-white dark:bg-gray-800 dark:text-white outline-none">
                                <p class="text-xs text-red-600 dark:text-red-400 mt-1">* Wajib melampirkan bukti transfer.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <button type="submit"
                                class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                                Simpan Data
                            </button>
                            <a href="{{ route('admin.mangrove.index') }}"
                                class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </main>

        @section('scripts')
            <script>
                const displayHarga = document.getElementById('display_harga');
                const hiddenHarga = document.getElementById('harga_pohon');
                const jumlahPohon = document.getElementById('jumlah_pohon');
                const displayInfaq = document.getElementById('display_infaq');
                const hiddenInfaq = document.getElementById('jumlah_infaq');

                // Fungsi format Rupiah
                function formatRupiah(angka) {
                    let numberString = angka.replace(/[^,\d]/g, '').toString();
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

                // Event saat Harga Pohon diketik
                displayHarga.addEventListener('keyup', function(e) {
                    this.value = formatRupiah(this.value);
                    // Simpan angka asli ke hidden input
                    hiddenHarga.value = this.value.replace(/[^0-9]/g, '');

                    // Update Total Infaq otomatis saat harga berubah
                    hitungTotal();
                });

                // Event saat Jumlah Pohon diketik
                jumlahPohon.addEventListener('input', hitungTotal);

                function hitungTotal() {
                    const harga = parseInt(hiddenHarga.value) || 0;
                    const jumlah = parseInt(jumlahPohon.value) || 0;
                    const total = harga * jumlah;

                    hiddenInfaq.value = total;
                    displayInfaq.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                }
            </script>
        @endsection
    </div>
</div>
@endsection
