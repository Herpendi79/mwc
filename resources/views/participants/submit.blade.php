@extends('layouts.main')

@section('title', 'Submit to ' . $conference->nama_conf)

@section('content')
    {{-- Style tetap sama --}}
    <style>
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        .scroll-to-top,
        #scroll-top,
        .back-to-top,
        .scroll-top,
        .rn-backto-top,
        [id*="scroll"],
        [class*="backto"],
        [class*="scroll-top"],
        .fixed.bottom-5.right-5 {
            display: none !important;
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        @include('participants.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('participants.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto max-w-3xl">
                    <div class="mb-8">
                        <a href="{{ route('participants.conferences') }}"
                            class="text-gray-500 hover:text-black dark:hover:text-white transition-all">
                            <i class="ri-arrow-left-line"></i> Back to List
                        </a>
                        <h2 class="text-3xl font-bold mt-4 dark:text-white">Submission Form</h2>
                        <p class="text-gray-500">{{ $conference->nama_conf }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-500 text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div
                        class="bg-white dark:bg-zinc-900 rounded-3xl p-8 border border-gray-200 dark:border-zinc-800 shadow-sm">
                        <form action="{{ route('participants.submit.store') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf
                            <input type="hidden" name="id_conf" value="{{ $conference->id_conf }}">

                            <!-- Kategori -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                                <select name="id_ktg" id="kategori_select" required
                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white focus:ring-2 focus:ring-[#c0f037] outline-none transition-all">
                                    <option value="">Select Category</option>
                                    @foreach ($kategoris as $ktg)
                                        <option value="{{ $ktg->id_ktg }}" data-nama="{{ $ktg->nama_ktg }}">
                                            {{ $ktg->nama_ktg }} -
                                            {{ $ktg->domisili == 'international' ? 'USD $' : 'IDR Rp' }}{{ number_format($ktg->fee, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Target Publication (KONDISIONAL: Muncul jika Presenter) -->
                            <div id="publication_field" class="hidden">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Target
                                    Publication (paid after the full article is accepted)</label>
                                <select name="id_pub" id="id_pub"
                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white focus:ring-2 focus:ring-[#c0f037] outline-none transition-all">
                                    <option value="">-- Select Target Journal/Proceeding --</option>
                                    @foreach ($publikasis as $pub)
                                        <option value="{{ $pub->id_pub }}">
                                            {{ $pub->nama_pub }} ({{ $pub->index }})
                                            @if ($pub->apc > 0)
                                                - APC: IDR {{ number_format($pub->apc, 0, ',', '.') }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-[10px] text-gray-500 mt-2 italic">*Optional: Select your preferred
                                    publication output for this conference.</p>
                            </div>

                            <!-- Upload KP (Conditional for Students) -->
                            <div id="student_card_field" class="hidden">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Upload Student
                                    Card (KP)</label>
                                <input type="file" name="file_kp" id="input_kp"
                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white">
                                <p class="text-xs text-gray-500 mt-2">Required for student categories. (PDF/JPG/PNG, Max
                                    2MB)</p>
                            </div>

                            <!-- Upload Abstract (Hidden for Participants) -->
                            <div id="abstract_field">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Upload
                                    Abstract</label>
                                <input type="file" name="file_abstract" id="input_abstract" required
                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white">
                                <p class="text-xs text-gray-500 mt-2">Format: PDF, DOC, or DOCX (Max 2MB)</p>
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full bg-[#c0f037] text-black font-bold py-4 rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-[#c0f037]/20">
                                    <i class="ri-send-plane-fill mr-2"></i> Submit Registration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @include('participants.partials._footer')
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectKategori = document.getElementById('kategori_select');

            // Elements
            const studentField = document.getElementById('student_card_field');
            const abstractField = document.getElementById('abstract_field');
            const pubField = document.getElementById('publication_field');

            // Inputs
            const inputKp = document.getElementById('input_kp');
            const inputAbstract = document.getElementById('input_abstract');
            const inputPub = document.getElementById('id_pub');

            selectKategori.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const namaKategori = selectedOption.getAttribute('data-nama') || '';

                // 1. Logika Student
                if (namaKategori.includes('Student')) {
                    studentField.classList.remove('hidden');
                    inputKp.setAttribute('required', 'required');
                } else {
                    studentField.classList.add('hidden');
                    inputKp.removeAttribute('required');
                }

                // 2. Logika Presenter vs Participant
                if (namaKategori.includes('Presenter')) {
                    // Tampilkan field publikasi & abstrak
                    pubField.classList.remove('hidden');
                    abstractField.classList.remove('hidden');

                    inputAbstract.setAttribute('required', 'required');
                } else if (namaKategori.includes('Participant')) {
                    // Sembunyikan field publikasi & abstrak
                    pubField.classList.add('hidden');
                    abstractField.classList.add('hidden');

                    inputAbstract.removeAttribute('required');
                    inputPub.value = ""; // Reset pilihan publikasi
                }
            });
        });
    </script>
@endsection
