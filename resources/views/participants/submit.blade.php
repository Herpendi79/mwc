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

                            <div id="judul_artikel_field" class="hidden">
                                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Article
                                    Title</label>
                                <input type="text" name="judul" id="input_judul"
                                    placeholder="Enter your article title here..."
                                    class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white focus:ring-2 focus:ring-[#c0f037] outline-none transition-all">
                                <p class="text-[10px] text-gray-500 mt-2 italic">*Please ensure the title matches your
                                    abstract/full paper.</p>
                            </div>

                            <div id="international_field" class="hidden space-y-4">
                                <div
                                    class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl">
                                    <h5 class="text-sm font-bold text-blue-700 dark:text-blue-400 mb-2 italic">International
                                        Transfer Information:</h5>
                                    <p class="text-xs text-blue-600 dark:text-blue-300">
                                        Swift code / BIC: <b>JAGBIDJA</b><br>
                                        Bank Account: <b>100968716043</b><br>
                                        Name: <b>Herfia Rhomadhona</b>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Transfer
                                        Receipt (Evidence of Payment)</label>
                                    <input type="file" name="file_bukti_tf" id="input_bukti_tf"
                                        class="w-full bg-gray-50 dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl px-5 py-3 dark:text-white">
                                    <p class="text-[10px] text-gray-500 mt-2 italic">*Required for International categories.
                                        Format: JPG/PNG/PDF (Max 2MB)</p>
                                </div>
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
                                    Card</label>
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
            const judulField = document.getElementById('judul_artikel_field'); // Element Baru

            // Inputs
            const inputKp = document.getElementById('input_kp');
            const inputAbstract = document.getElementById('input_abstract');
            const inputPub = document.getElementById('id_pub');
            const inputJudul = document.getElementById('input_judul'); // Input Baru
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Mencegah event bubbling
                    profileDropdown.classList.toggle('hidden');
                });

                // Menutup dropdown jika klik di luar area profile
                window.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }

            selectKategori.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                // Ambil data-nama dan ubah ke huruf kecil semua untuk pengecekan
                const namaKategori = (selectedOption.getAttribute('data-nama') || '').toLowerCase();

                // Elemen baru
                const internationalField = document.getElementById('international_field');
                const inputBukti = document.getElementById('input_bukti_tf');

                // 1. Logika Student (Cek kata 'student' dalam huruf kecil)
                if (namaKategori.includes('student')) {
                    studentField.classList.remove('hidden');
                    inputKp.setAttribute('required', 'required');
                } else {
                    studentField.classList.add('hidden');
                    inputKp.removeAttribute('required');
                }

                // 2. Logika Presenter vs Participant
                if (namaKategori.includes('presenter')) {
                    pubField.classList.remove('hidden');
                    abstractField.classList.remove('hidden');
                    judulField.classList.remove('hidden'); // Munculkan field judul

                    inputAbstract.setAttribute('required', 'required');
                    inputJudul.setAttribute('required', 'required'); // Judul jadi wajib isi
                } else if (namaKategori.includes('participant')) {
                    pubField.classList.add('hidden');
                    abstractField.classList.add('hidden');
                    judulField.classList.add('hidden'); // Sembunyikan field judul

                    inputAbstract.removeAttribute('required');
                    inputPub.value = "";
                    inputJudul.value = "";
                } else {
                    // Jika belum pilih apa-apa, sembunyikan semua
                    pubField.classList.add('hidden');
                    abstractField.classList.add('hidden');
                }

                // 3. Logika International
                if (namaKategori.includes('international')) {
                    internationalField.classList.remove('hidden');
                    inputBukti.setAttribute('required', 'required');
                } else {
                    internationalField.classList.add('hidden');
                    inputBukti.removeAttribute('required');
                }
            });
        });
    </script>
@endsection
