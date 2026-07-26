@extends('layouts.main')

@section('title', 'Edit Data Sampah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm">
        @include('admin.partials._sidebar')

        <main class="flex-1 overflow-y-auto p-8">
            <div class="container mx-auto max-w-3xl">
                <h2 class="text-3xl font-bold mb-8 dark:text-white">Edit Data Sampah</h2>
                @if ($errors->any())
                    <div class="bg-red-100 p-4 mb-4 text-red-700">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.sampah.update', $sampah->id_sm) }}" method="POST" enctype="multipart/form-data"
                    class="bg-white dark:bg-gray-900 p-8 rounded-2xl border dark:border-gray-800 shadow-sm">
                    @csrf
                    @method('PUT')

                    {{-- Baris Penyetor & Jenis --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Penyetor</label>
                            <input type="text" name="penyetor" value="{{ old('penyetor', $sampah->penyetor) }}" required
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jenis Sampah</label>
                            <input type="text" name="jenis" value="{{ old('jenis', $sampah->jenis) }}" required
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        </div>
                    </div>

                    {{-- Baris Berat, Harga/Kg (Input Baru), Total Nilai --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Berat (Kg)</label>
                            <input type="number" step="0.01" name="berat" id="berat"
                                value="{{ old('berat', $sampah->berat) }}" required
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Harga/Kg (Rp)</label>
                            {{-- Kita beri nilai default 0 atau sesuaikan dengan logika bisnis Anda --}}
                            <input type="text" id="display_harga" value="Rp 0"
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                            <input type="hidden" id="harga_per_kg" value="0">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Total Nilai (Rp)</label>
                            <input type="text" id="display_nilai"
                                value="Rp {{ number_format($sampah->nilai, 0, ',', '.') }}" readonly
                                class="w-full p-3 rounded-xl border bg-gray-50 dark:bg-gray-800 dark:text-gray-400 outline-none">
                            <input type="hidden" name="nilai" id="nilai" value="{{ $sampah->nilai }}">
                        </div>
                    </div>

                    {{-- Baris Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                            <input type="date" name="tgl" value="{{ old('tgl', $sampah->tgl) }}" required
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Petugas</label>
                            <input type="text" name="petugas" value="{{ old('petugas', $sampah->petugas) }}" required
                                class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="mb-5">
                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto Bukti</label>
                        @if ($sampah->foto)
                            <div class="mb-2">
                                @if ($sampah->foto && Storage::disk('public')->exists('foto_sampah/' . $sampah->foto))
                                    <img src="{{ asset('storage/foto_sampah/' . $sampah->foto) }}"
                                        class="w-24 h-24 object-cover rounded-lg border">
                                @else
                                    <img src="{{ asset('storage/foto_sampah/sampah-default.jpeg') }}"
                                        class="w-24 h-24 object-cover rounded-lg border">
                                @endif
                            </div>
                        @endif
                        <input type="file" name="foto"
                            class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">
                        <small class="text-gray-500">Biarkan kosong jika tidak ingin mengubah foto.</small>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-8">
                        <label class="block text-sm font-bold mb-2 dark:text-gray-300">Keterangan</label>
                        <textarea name="ket" rows="3"
                            class="w-full p-3 rounded-xl border dark:bg-gray-800 dark:text-white outline-none">{{ old('ket', $sampah->ket) }}</textarea>
                    </div>

                    <div class="flex gap-4 mt-6">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold">
                            Simpan Data
                        </button>
                        <a href="{{ route('admin.sampah.index') }}"
                            class="flex-1 text-center bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
@section('scripts')
    <script>
        const inputBerat = document.getElementById('berat');
        const displayHarga = document.getElementById('display_harga');
        const hiddenHarga = document.getElementById('harga_per_kg');
        const displayNilai = document.getElementById('display_nilai');
        const hiddenNilai = document.getElementById('nilai');

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

        function hitungTotal() {
            const berat = parseFloat(inputBerat.value) || 0;
            const harga = parseInt(hiddenHarga.value) || 0;
            const total = berat * harga;

            hiddenNilai.value = total;
            displayNilai.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Event Listener
        displayHarga.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
            hiddenHarga.value = this.value.replace(/[^0-9]/g, '');
            hitungTotal();
        });

        inputBerat.addEventListener('input', hitungTotal);

        // Auto-calculate saat halaman dimuat (jika ada harga per kg di masa depan)
        window.onload = function() {
            console.log("Halaman dimuat, nilai awal: " + hiddenNilai.value);
        };
        inputBerat.addEventListener('input', hitungTotal);

        // Tambahan: Agar saat pertama kali user ketik harga, berat sudah ada
        displayHarga.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
            hiddenHarga.value = this.value.replace(/[^0-9]/g, '');

            // Jika harga diubah, hitung ulang
            hitungTotal();
        });
    </script>
@endsection
