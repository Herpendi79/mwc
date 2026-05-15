@extends('layouts.main')

@section('title', 'Payment - ICPIP-HE 2026')

@section('content')
    <style>
        .force-show {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        /* Sembunyikan elemen scroll up */
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
                <div class="container mx-auto max-w-2xl">
                    <div class="mb-8">
                        <a href="{{ route('participants.conferences') }}"
                            class="text-gray-500 hover:text-black dark:hover:text-white transition-all inline-flex items-center">
                            <i class="ri-arrow-left-line mr-2"></i> Back to Dashboard
                        </a>
                        <h2 class="text-3xl font-bold mt-4 dark:text-white">Payment Detail</h2>
                    </div>

                    <div
                        class="bg-white dark:bg-zinc-900 rounded-3xl p-10 border border-gray-200 dark:border-zinc-800 shadow-xl text-center">

                        {{-- CASE 1: PAYMENT SUCCESS --}}
                        @if (!empty($snapToken) && $status_payment === 'success')
                            <div
                                class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-500/10 text-green-500 rounded-full">
                                <i class="ri-checkbox-circle-fill text-5xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold dark:text-white mb-2">Hello, {{ $nama }}!</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">
                                Your payment of <span class="font-bold text-black dark:text-white">IDR
                                    {{ number_format($biaya, 0, ',', '.') }}</span> has been successfully processed.
                            </p>
                            <div class="p-4 bg-gray-50 dark:bg-zinc-800/50 rounded-2xl mb-8">
                                <p class="text-sm dark:text-gray-300">You are officially registered for the <strong>ICPIP-HE
                                        2026</strong> event.</p>
                            </div>
                            <a href="{{ route('participants.conferences') }}"
                                class="inline-block w-full bg-black dark:bg-white text-white dark:text-black font-bold py-4 rounded-2xl hover:opacity-90 transition-all">
                                Back to Dashboard
                            </a>

                            {{-- CASE 2: PAYMENT PENDING --}}
                        @elseif (!empty($snapToken) && $status_payment === 'pending')
                            <div
                                class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-yellow-100 dark:bg-[#c0f037]/10 text-[#c0f037] rounded-full">
                                <i class="ri-wallet-3-line text-5xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold dark:text-white mb-2">Payment Required</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-2 italic text-sm">Hello, {{ $nama }}</p>
                            <h4 class="text-3xl font-black dark:text-white mb-6">
                                IDR {{ number_format($biaya, 0, ',', '.') }}
                            </h4>

                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-8 px-4">
                                You can also access the payment link sent to your <span
                                    class="text-black dark:text-white">email inbox/spam</span> if you accidentally close
                                this page.
                            </div>

                            <button type="submit" id="pay-button"
                                class="w-full bg-[#c0f037] text-black font-black py-4 rounded-2xl hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-[#c0f037]/30 text-lg uppercase tracking-wider">
                                <i class="ri-secure-payment-line mr-2"></i> Pay Now
                            </button>

                            {{-- CASE 3: EXPIRED / INVALID --}}
                        @else
                            <div
                                class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-red-100 dark:bg-red-500/10 text-red-500 rounded-full">
                                <i class="ri-error-warning-line text-5xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold dark:text-white mb-2">Invoice Expired</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-8 px-6">
                                This invoice is no longer valid. Please return to the dashboard and re-register for the
                                conference.
                            </p>
                            <a href="{{ route('participants.conferences') }}"
                                class="inline-block w-full border-2 border-gray-200 dark:border-zinc-700 text-gray-600 dark:text-gray-300 font-bold py-4 rounded-2xl hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all">
                                Return to Dashboard
                            </a>
                        @endif

                    </div>
                </div>
                @include('participants.partials._footer')
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Script Midtrans Snap --}}
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.clientKey') }}"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // --- Logika Dropdown Profile ---
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

            // --- Logika Midtrans Snap ---
            const payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.onclick = function() {
                    window.snap.pay('{{ $snapToken }}', {
                        onSuccess: function(result) {
                            window.location.href = "{{ route('participants.conferences') }}";
                        },
                        onPending: function(result) {
                            window.location.href = "{{ route('participants.conferences') }}";
                        },
                        onError: function(result) {
                            alert("Payment failed! Please try again.");
                        }
                    });
                };
            }
        });
    </script>
@endsection
