@extends('layouts.main')

@section('title', 'Tambah Data Sampah')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ jenisSedekah: 'sampah' }">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold dark:text-white">Tambah Data Sampah</h2>
                        <p class="text-gray-500">Input detail penyetoran sampah baru.</p>
                    </div>
                    @if ($errors->any())
                        <div class="bg-red-100 p-4 mb-4 text-red-700 rounded-xl">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.sampah.store') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        @csrf

                        {{-- Opsi Radio Button Jenis Sedekah --}}
                        <div
                            class="mb-6 p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <label class="block text-sm font-bold mb-3 dark:text-gray-300">Pilih Jenis Sedekah</label>
                            <div class="flex gap-6">
                                <label class="flex items-center gap-2 cursor-pointer font-medium dark:text-gray-300">
                                    <input type="radio" name="jenis_sedekah" value="sampah" x-model="jenisSedekah"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    Sampah
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer font-medium dark:text-gray-300">
                                    <input type="radio" name="jenis_sedekah" value="pengelolaan" x-model="jenisSedekah"
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    Pengelolaan
                                </label>
                            </div>
                        </div>

                        {{-- Baris Penyetor & Jenis (Jenis Sampah hanya muncul jika opsi 'sampah') --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Nama Penyetor</label>
                                <input type="text" name="penyetor" value="{{ old('penyetor') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div x-show="jenisSedekah === 'sampah'">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Jenis Sampah</label>
                                <input type="text" name="jenis" value="{{ old('jenis') }}"
                                    :required="jenisSedekah === 'sampah'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        {{-- Baris Berat, Harga/Kg, Total Nilai (Hanya muncul jika opsi 'sampah') --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-5" x-show="jenisSedekah === 'sampah'">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Berat (Kg)</label>
                                <input type="number" step="0.01" name="berat" id="berat"
                                    value="{{ old('berat') }}" :required="jenisSedekah === 'sampah'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Harga/Kg (Rp)</label>
                                <input type="text" id="display_harga" value="Rp 0"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                <input type="hidden" id="harga_per_kg" value="0">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Setara Dengan (Rp)</label>
                                <input type="text" id="display_nilai" value="Rp 0" readonly
                                    class="w-full p-3 rounded-xl border bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 outline-none">
                                <input type="hidden" name="nilai" id="nilai">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            {{-- Total Nilai Manual (Hanya muncul jika opsi 'pengelolaan') --}}
                            <div class="mb-5" x-show="jenisSedekah === 'pengelolaan'">
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Total Nilai (Rp)</label>
                                <input type="text" id="display_nilai_manual" value="Rp 0" placeholder="Rp 0"
                                    :required="jenisSedekah === 'pengelolaan'"
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                                <input type="hidden" name="nilai" id="nilai_manual_hidden"
                                    :disabled="jenisSedekah === 'sampah'">
                            </div>
                        </div>

                        {{-- Baris Petugas & Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Petugas</label>
                                <input type="text" name="petugas" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 dark:text-gray-300">Tanggal</label>
                                <input type="date" name="tgl" value="{{ date('Y-m-d') }}" required
                                    class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                            </div>
                        </div>

                        {{-- Foto & Keterangan --}}
                        <div class="mb-5">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Foto Bukti</label>
                            <input type="file" name="foto"
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold mb-2 dark:text-gray-300">Keterangan</label>
                            <textarea name="ket" rows="3"
                                class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none"></textarea>
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
    </div>
@endsection

@section('scripts')
    <script>
        const inputBerat = document.getElementById('berat');
        const displayHarga = document.getElementById('display_harga');
        const hiddenHarga = document.getElementById('harga_per_kg');
        const displayNilai = document.getElementById('display_nilai');
        const hiddenNilai = document.getElementById('nilai');

        const displayNilaiManual = document.getElementById('display_nilai_manual');
        const hiddenNilaiManual = document.getElementById('nilai_manual_hidden');

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

        function hitungTotal() {
            if (!inputBerat) return;
            const berat = parseFloat(inputBerat.value) || 0;
            const harga = parseInt(hiddenHarga.value) || 0;
            const total = berat * harga;

            if (hiddenNilai) hiddenNilai.value = total;
            if (displayNilai) displayNilai.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        if (displayHarga) {
            displayHarga.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
                hiddenHarga.value = this.value.replace(/[^0-9]/g, '');
                hitungTotal();
            });
        }

        if (inputBerat) {
            inputBerat.addEventListener('input', hitungTotal);
        }

        if (displayNilaiManual) {
            displayNilaiManual.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
                if (hiddenNilaiManual) {
                    hiddenNilaiManual.value = this.value.replace(/[^0-9]/g, '');
                }
            });
        }
    </script>
@endsection
