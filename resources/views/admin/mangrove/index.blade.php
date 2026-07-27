@extends('layouts.main')

@section('title', 'Data Infaq Mangrove')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
    <div>
        <h2 class="text-3xl font-bold dark:text-white">Data Infaq Mangrove</h2>
        <p class="text-gray-500">Kelola data para donatur infaq mangrove disini.</p>
    </div>

    <div class="flex flex-wrap items-center gap-4">
        {{-- Live Search Input dengan Alpine.js --}}
        <div class="relative w-full md:w-64" x-data="{ search: '{{ request('search') }}' }">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                <i class="ri-search-line text-lg"></i>
            </span>
            <input type="text"
                x-model="search"
                @input.debounce.500ms="window.location.href = '{{ route('admin.mangrove.index') }}?search=' + encodeURIComponent(search)"
                placeholder="Cari donatur, email..."
                class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
        </div>

        {{-- Form Update Harga --}}
        <form action="{{ route('admin.mangrove.update-harga') }}" method="POST"
            class="flex items-center gap-2" x-data="{
                harga: '{{ $hargaMangrove }}',
                formatRupiah(value) {
                    let number = value.replace(/[^0-9]/g, '');
                    return number ? 'Rp ' + number.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
                }
            }">
            @csrf

            {{-- Input Tersembunyi untuk dikirim ke Controller (angka murni) --}}
            <input type="hidden" name="harga" :value="harga.replace(/[^0-9]/g, '')">

            {{-- Input Tampilan (Format Rp) --}}
            <input type="text" :value="formatRupiah(harga)" @input="harga = $event.target.value"
                placeholder="Rp 0"
                class="px-3 py-2 border rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:text-white w-40 focus:ring-2 focus:ring-blue-500 outline-none">

            <button type="submit"
                class="text-xs bg-gray-200 dark:bg-gray-700 px-3 py-2 rounded-lg hover:bg-gray-300 transition dark:text-white whitespace-nowrap">
                Set Harga
            </button>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.mangrove.tambah') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
            + Tambah Donatur
        </a>
    </div>
</div>
                    {{-- Notifikasi Sukses --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Notifikasi Error (Pesan Manual) --}}
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Notifikasi Error Validasi Form --}}
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- Tabel Data Kajian --}}
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 dark:text-gray-300">Donatur</th>
                                    <th class="p-4 dark:text-gray-300">Infaq</th>
                                    <th class="p-4 dark:text-gray-300">Pohon</th>
                                    <th class="p-4 dark:text-gray-300">Pembayaran</th>
                                    <th class="p-4 dark:text-gray-300">Bukti TF</th>
                                    <th class="p-4 dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 dark:text-gray-300 text-center">Sertifikat</th>
                                    <th class="p-4 dark:text-gray-300 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($mangroves as $item)
                                    <tr class="dark:text-gray-400">
                                        <td class="p-4 dark:text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="p-4">
                                            <div class="font-bold">{{ $item->donatur }}</div>
                                            <div class="text-xs text-gray-500">{{ $item->email }}</div>
                                        </td>
                                        <td class="p-4">Rp {{ number_format($item->jumlah_infaq, 0, ',', '.') }}</td>
                                        <td class="p-4">{{ $item->jumlah_pohon }}</td>
                                        <td class="p-4 uppercase">{{ $item->pembayaran }}</td>
                                        <td class="p-4">
                                            @if (!empty($item->bukti_tf) && Storage::disk('public')->exists('bukti_tf/' . $item->bukti_tf))
                                                <a href="{{ asset('storage/bukti_tf/' . $item->bukti_tf) }}"
                                                    target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ asset('storage/bukti_tf/' . $item->bukti_tf) }}"
                                                        class="w-12 h-12 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity">
                                                </a>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="p-4">{{ $item->tanggal->format('d M Y') }}</td>
                                        <td class="p-4 align-middle text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.mangrove.download_Sertfikat', $item->id) }}"
                                                    target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    <i class="ri-download-line text-xl"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.mangrove.edit', $item->id) }}"
                                                    class="text-blue-600 hover:text-blue-800"><i
                                                        class="ri-edit-line text-xl"></i></a>
                                                <form action="{{ route('admin.mangrove.hapus', $item->id) }}"
                                                    method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800"
                                                        title="Hapus">
                                                        <i class="ri-delete-bin-line text-xl"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $mangroves->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
