@extends('layouts.main')

@section('title', 'Edit Donasi Mangrove')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Edit Donasi Mangrove</h2>
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

                    <form action="{{ route('admin.mangrove.update', $mangrove->id) }}" method="POST"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf
                        @method('PUT')

                        {{-- Baris Nama & Email --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Donatur</label>
                                <input type="text" name="donatur" value="{{ old('donatur', $mangrove->donatur) }}"
                                    required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Email</label>
                                <input type="email" name="email" value="{{ old('email', $mangrove->email) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        {{-- Baris Harga, Jumlah, Total --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Harga/Pohon (Rp)</label>
                                {{-- Harga diambil dari Infaq / Jumlah, atau set default --}}
                                @php $hargaPerPohon = $mangrove->jumlah_pohon > 0 ? ($mangrove->jumlah_infaq / $mangrove->jumlah_pohon) : 5000; @endphp
                                <input type="text" id="display_harga"
                                    value="Rp {{ number_format($hargaPerPohon, 0, ',', '.') }}"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                <input type="hidden" name="harga_pohon" id="harga_pohon" value="{{ $hargaPerPohon }}">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jumlah Pohon</label>
                                <input type="number" name="jumlah_pohon" id="jumlah_pohon"
                                    value="{{ old('jumlah_pohon', $mangrove->jumlah_pohon) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Total Infaq (Rp)</label>
                                <input type="text" id="display_infaq"
                                    value="Rp {{ number_format($mangrove->jumlah_infaq, 0, ',', '.') }}" readonly
                                    class="w-full p-3 rounded-xl border bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">
                                <input type="hidden" name="jumlah_infaq" id="jumlah_infaq"
                                    value="{{ $mangrove->jumlah_infaq }}">
                            </div>
                        </div>

                        {{-- Metode & Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Metode Pembayaran</label>
                                <select name="pembayaran" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                    <option value="tunai" {{ $mangrove->pembayaran == 'tunai' ? 'selected' : '' }}>Tunai
                                    </option>
                                    <option value="transfer" {{ $mangrove->pembayaran == 'transfer' ? 'selected' : '' }}>
                                        Transfer</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tanggal"
                                    value="{{ old('tanggal', $mangrove->tanggal->format('Y-m-d')) }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
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
        </div>
    </div>
@endsection

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
