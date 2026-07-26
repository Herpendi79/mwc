@extends('layouts.main')

@section('title', 'Bahsul Masail')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    {{-- Header & Aksi --}}
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Bahsul Masail</h2>
                            <p class="text-gray-500">Daftar pembahasan masalah keagamaan</p>
                        </div>
                        <a href="{{ route('admin.bahsul.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Data
                        </a>
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
                    {{-- Tabel Data --}}
                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                       <div x-data="{ openModal: false, selectedRoan: null }">
    <table class="min-w-full">
        <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <tr>
                <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Kategori</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Detail</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Peserta</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Status</th>
                <th class="p-4 text-sm font-bold dark:text-gray-300">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @foreach ($bahsul as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                    <td class="p-4">{{ $index + 1 }}</td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td class="p-4 dark:text-white">{{ $item->judul }}</td>
                    <td class="p-4 dark:text-white">{{ $item->kategori }}</td>
                    <td class="p-4">
                        <button @click="selectedRoan = {{ $item->id_bs }}; openModal = true" class="text-gray-400 hover:text-blue-600">
                            <i class="ri-eye-line text-xl"></i>
                        </button>
                    </td>
                    {{-- Tombol Detail Peserta --}}
                    <td class="p-4 text-center">
                        <button @click="selectedRoan = {{ $item->id_bs }}; openModal = true"
                            class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full font-bold hover:bg-blue-200 transition">
                            {{ $item->peserta_count ?? $item->peserta->count() }} Peserta
                        </button>
                    </td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $item->status == 'draft'
                                ? 'bg-yellow-100 text-yellow-700'
                                : ($item->status == 'publish'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-blue-100 text-blue-700') }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-2">
                            @if ($item->status == 'draft')
                                <form action="{{ route('admin.bahsul.status', $item->id_bs) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin mempublikasikan data ini?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="publish">
                                    <button type="submit" class="text-green-600 hover:text-green-800" title="Publish">
                                        <i class="ri-check-line text-xl"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.bahsul.edit', $item->id_bs) }}"
                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="ri-edit-line text-xl"></i>
                                </a>

                                <form action="{{ route('admin.bahsul.hapus', $item->id_bs) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="ri-delete-bin-line text-xl"></i>
                                    </button>
                                </form>
                            @elseif($item->status == 'publish')
                                <a href="{{ route('admin.bahsul.edit', $item->id_bs) }}"
                                    class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <i class="ri-edit-line text-xl"></i>
                                </a>
                                <form action="{{ route('admin.bahsul.status', $item->id_bs) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan data ini?')">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="arsip">
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800" title="Arsipkan">
                                        <i class="ri-archive-line text-xl"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- MODAL TUNGGAL (Diletakkan di luar tabel, masih di dalam scope x-data) --}}
    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div @click.away="openModal = false"
            class="bg-white dark:bg-gray-900 p-6 rounded-2xl w-full max-w-2xl shadow-xl max-h-[90vh] overflow-y-auto">

            @foreach ($bahsul as $item)
                <div x-show="selectedRoan === {{ $item->id_bs }}">
                    <h3 class="font-bold text-lg mb-4 dark:text-white border-b pb-2">Detail:
                        {{ $item->judul }}</h3>

                    <div class="text-sm dark:text-gray-300 space-y-2 mb-6">
                        <p><strong>Tanggal:</strong> {{ $item->tanggal }}</p>
                        <p><strong>Kategori:</strong> {{ $item->kategori }}</p>
                        <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                        <p><strong>Masalah:</strong> {{ $item->masalah }}</p>
                        <p><strong>Putusan:</strong> {{ $item->putusan }}</p>
                    </div>

                    <h4 class="font-bold mb-3 dark:text-white">Daftar Peserta
                        ({{ $item->peserta->count() }})
                    </h4>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-4 mb-6 max-h-40 overflow-y-auto">
                        @forelse($item->peserta as $p)
                            <div class="flex justify-between items-center border-b dark:border-gray-700 py-2">
                                <span class="text-sm font-medium dark:text-gray-200">{{ $p->name }}</span>
                                <span class="text-xs text-gray-500">{{ $p->email ?? '-' }}</span>
                                <span class="text-xs text-gray-500">{{ $p->telpon ?? '-' }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 italic">Tidak ada peserta.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach

            <button @click="openModal = false"
                class="w-full bg-gray-100 dark:bg-gray-800 py-2 rounded-xl text-sm font-bold dark:text-white hover:bg-gray-200 transition">Tutup</button>
        </div>
    </div>
</div>
                    </div>

                </div>
            </main>
        </div>
    </div>
@endsection
