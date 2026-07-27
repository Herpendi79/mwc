@extends('layouts.main')

@section('title', 'Data Opini')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden" x-data="{ openModal: false, selectedOpini: null, showRejectModal: false, selectedRejectId: null, showPublishModal: false, selectedPublishId: null }">
        @include('admin.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('admin.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold dark:text-white">Opini</h2>
                            <p class="text-gray-500">Kelola artikel dan opini publik</p>
                        </div>
                        <a href="{{ route('admin.opini.tambah') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                            + Tambah Data
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div
                        class="overflow-x-auto w-full bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <tr>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">No</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Tanggal</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Judul</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Penulis</th>
                                    <th class="p-4 text-center">Detil</th>
                                    <th class="p-4 text-sm font-bold dark:text-gray-300">Status</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                @foreach ($opinis as $index => $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 dark:text-gray-300">{{ $index + 1 }}</td>
                                        <td class="p-4 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="p-4 dark:text-white font-medium">{{ $item->judul }}</td>
                                        <td class="p-4 dark:text-gray-300">{{ $item->penulis }}</td>
                                        <td class="p-4 text-center">
                                            <button @click="selectedOpini = {{ $item->id_op }}; openModal = true"
                                                class="text-gray-400 hover:text-blue-600"><i
                                                    class="ri-eye-line text-xl"></i></button>
                                        </td>
                                        <td class="p-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $item->status == 'draft'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : ($item->status == 'publish'
                                                        ? 'bg-green-100 text-green-700'
                                                        : 'bg-blue-100 text-blue-700') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-2 items-center">
                                                @if ($item->status == 'draft')
                                                    {{-- Tombol Publish (Memicu Modal Konfirmasi) --}}
                                                    <button type="button"
                                                        @click="showPublishModal = true; selectedPublishId = '{{ $item->id_op }}'"
                                                        class="text-green-600 hover:text-green-800" title="Publish">
                                                        <i class="ri-check-line text-xl"></i>
                                                    </button>

                                                    {{-- Tombol Tolak (Memicu Modal Alasan) --}}
                                                    <button type="button"
                                                        @click="showRejectModal = true; selectedRejectId = '{{ $item->id_op }}'"
                                                        class="text-red-600 hover:text-red-800" title="Tolak">
                                                        <i class="ri-close-line text-xl"></i>
                                                    </button>

                                                    <a href="{{ route('admin.opini.edit', $item->id_op) }}"
                                                        class="text-blue-600 hover:text-blue-800" title="Edit"><i
                                                            class="ri-edit-line text-xl"></i></a>

                                                    <form action="{{ route('admin.opini.hapus', $item->id_op) }}"
                                                        method="POST" onsubmit="return confirm('Yakin hapus?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800"
                                                            title="Hapus"><i
                                                                class="ri-delete-bin-line text-xl"></i></button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('admin.opini.edit', $item->id_op) }}"
                                                        class="text-blue-600 hover:text-blue-800" title="Edit"><i
                                                            class="ri-edit-line text-xl"></i></a>
                                                    <form action="{{ route('admin.opini.updateStatus', $item->id_op) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="arsip">
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800"
                                                            title="Arsipkan"><i
                                                                class="ri-archive-line text-xl"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>

        {{-- MODAL KONFIRMASI PUBLISH --}}
        <div x-show="showPublishModal" style="display: none;"
            class="fixed inset-0 z-[110] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 w-full max-w-md shadow-xl border dark:border-gray-800"
                @click.outside="showPublishModal = false">

                <h3 class="text-lg font-bold mb-2 dark:text-white">Konfirmasi Publikasi</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin mempublikasikan opini ini?</p>

                <form :action="'{{ url('admin/opini/update-status') }}/' + selectedPublishId" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="publish">

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showPublishModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                            Ya, Publikasikan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL INPUT ALASAN PENOLAKAN --}}
        <div x-show="showRejectModal" style="display: none;"
            class="fixed inset-0 z-[110] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 w-full max-w-md shadow-xl border dark:border-gray-800"
                @click.outside="showRejectModal = false">

                <h3 class="text-lg font-bold mb-4 dark:text-white">Alasan Penolakan Opini</h3>

                <form :action="'{{ url('admin/opini/update-status') }}/' + selectedRejectId" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="arsip">

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 dark:text-gray-300">Tuliskan Alasan Penolakan:</label>
                        <textarea name="alasan_penolakan" rows="4" required
                            class="w-full p-3 rounded-xl border dark:border-gray-700 dark:bg-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-red-500"
                            placeholder="Contoh: Konten kurang sesuai dengan pedoman..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showRejectModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl font-medium hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition">
                            Kirim & Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL DETAIL --}}
        <div x-show="openModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>
            <div @click.away="openModal = false"
                class="bg-white dark:bg-gray-900 rounded-2xl w-full max-w-4xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
                <div class="px-8 py-6 border-b dark:border-gray-800 flex-shrink-0">
                    <h3 class="font-bold text-2xl dark:text-white">Detail Opini</h3>
                </div>
                <div class="flex-1 overflow-y-auto px-8 py-6">
                    @foreach ($opinis as $item)
                        <div x-show="selectedOpini === {{ $item->id_op }}">
                            <h3 class="font-bold text-2xl mb-2 dark:text-white">{{ $item->judul }}</h3>
                            <p class="text-sm text-gray-500 mb-6 italic">
                                @foreach (explode(',', $item->ringkasan) as $tag)
                                    @if (trim($tag) !== '')
                                        <span class="inline-block mr-2">#{{ trim($tag) }}</span>
                                    @endif
                                @endforeach
                            </p>

                            <div class="space-y-6">
                                @if (!empty($item->foto) && Storage::disk('public')->exists('foto_opini/' . $item->foto))
                                    <a href="{{ asset('storage/foto_opini/' . $item->foto) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_opini/' . $item->foto) }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/foto_opini/opini-default.jpeg') }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <img src="{{ asset('storage/foto_opini/opini-default.jpeg') }}"
                                            class="w-full h-auto max-h-96 object-cover rounded-xl border dark:border-gray-700 shadow-sm">
                                    </a>
                                @endif

                                <div
                                    class="prose dark:prose-invert max-w-none text-md dark:text-gray-300 leading-relaxed text-justify">
                                    {!! $item->isi !!}
                                </div>

                                @if (!empty($item->lampiran) && Storage::disk('public')->exists('file/' . $item->lampiran))
                                    <a href="{{ asset('storage/file/' . $item->lampiran) }}" target="_blank"
                                        class="inline-block bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                                        <i class="ri-download-line mr-2"></i> Download Lampiran
                                    </a>
                                @else
                                    <p class="text-sm text-gray-400 italic">Tidak ada lampiran.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="px-8 py-6 border-t dark:border-gray-800 flex-shrink-0">
                    <button @click="openModal = false"
                        class="w-full bg-gray-100 dark:bg-gray-800 py-3 rounded-xl font-bold dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
