@extends('layouts.main')

@section('title', 'Conference Monitoring')

@section('content')
    <style>
        [x-cloak] {
            display: none !important;
        }

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
        .fixed.bottom-5.right-5,
        .bg-primary.rounded-circle {
            display: none !important;
        }
    </style>

    <div class="flex h-screen bg-gray-50 dark:bg-black font-ibm overflow-hidden">
        {{-- Memanggil Sidebar --}}
        @include('reviewer.partials._sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Memanggil Navbar --}}
            @include('reviewer.partials._navbar')

            <main class="flex-1 overflow-y-auto p-8 bg-gray-50 dark:bg-black">
                <div class="container mx-auto min-h-full flex flex-col">

                    <div class="flex-grow">
                        <div class="mb-8 force-show" data-sal="slide-up" data-sal-duration="800">
                            <nav class="flex mb-4 text-gray-500 text-sm">
                                <a href="{{ route('reviewer.index') }}"
                                    class="hover:text-primary transition-colors">Dashboard</a>
                                <span class="mx-2">/</span>
                                <a href="{{ route('reviewer.conferences') }}"
                                    class="hover:text-primary transition-colors">Conferences</a>
                                <span class="mx-2">/</span>
                                <span class="dark:text-gray-300">Presenters List of {{ $conference->nama_conf }}</span>
                            </nav>
                            <h5>Managing {{ $totalCount }} registered presenters for this
                                event</h5>
                        </div>
                        <hr class="mb-6 border-gray-200 dark:border-zinc-800">
                        <div class="force-show" data-sal="slide-up" data-sal-duration="1000">
                            {{-- Statistik Badge --}}
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach ($stats as $nama_ktg => $group)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full border dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300 shadow-sm bg-white">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-tight mr-2 text-emerald-800 dark:text-emerald-400">
                                            {{ $nama_ktg ?? 'No Category' }}
                                        </span>
                                        <span
                                            class="text-xs font-black border-l border-gray-200 dark:border-zinc-700 pl-2 text-blue-600 dark:text-blue-400">
                                            {{ $group->count() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="mb-6 border-gray-200 dark:border-zinc-800">
                            {{-- Statistik Scope --}}
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach ($statsSC as $nama_sc => $group)
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full border dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300 shadow-sm bg-white">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-tight mr-2 text-emerald-600 dark:text-emerald-400">
                                            {{ $nama_sc ?? 'No Scope' }}
                                        </span>
                                        <span
                                            class="text-xs font-black border-l border-gray-200 dark:border-zinc-700 pl-2 text-blue-600 dark:text-blue-400">
                                            {{ $group->count() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="mb-6 border-gray-200 dark:border-zinc-800">
                            @if (session('success'))
                                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                                    x-transition:leave="transition ease-in duration-300"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-95"
                                    class="bg-[#c0f037]/20 border border-[#c0f037] text-[#065039] px-4 py-3 rounded-2xl mb-6 flex justify-between items-center force-show">

                                    <div class="flex items-center gap-2">
                                        <i class="ri-checkbox-circle-fill text-xl"></i>
                                        <span class="font-bold">{{ session('success') }}</span>
                                    </div>

                                    <button @click="show = false" class="hover:opacity-70 transition-opacity">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div x-data="{ show: true }" x-show="show"
                                    x-transition:leave="transition ease-in duration-300"
                                    class="bg-[#f03737]/20 border border-[#f03737] text-[#650505] px-4 py-3 rounded-2xl mb-6 flex justify-between items-center force-show">

                                    <div class="flex items-center gap-2">
                                        <i class="ri-error-warning-fill text-xl"></i>
                                        <span class="font-bold">{{ session('error') }}</span>
                                    </div>

                                    <button @click="show = false" class="hover:opacity-70 transition-opacity">
                                        <i class="ri-close-line text-xl"></i>
                                    </button>
                                </div>
                            @endif
                            <div
                                class="bg-white dark:bg-zinc-900 rounded-3xl border border-gray-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                                <div class="p-6 border-b border-gray-100 dark:border-zinc-800" style="background: #fdfdfd;">
                                    {{-- Grid 6 kolom yang dipaksa sejajar --}}
                                    <div
                                        style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; align-items: end;">

                                        {{-- Search --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #eee;">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px;">Search</label>
                                            <div style="position: relative;">
                                                <input type="text" id="searchInput" placeholder="Name/Email..."
                                                    value="{{ request('search') }}"
                                                    onkeypress="if(event.key==='Enter') applyFilters()"
                                                    style="width: 100%; padding: 8px; padding-left: 30px; font-size: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                                <i class="ri-search-line"
                                                    style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                                            </div>
                                        </div>

                                        {{-- Status --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #eee;">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px;">Status</label>
                                            <select id="filterStatus" onchange="applyFilters()"
                                                style="width: 100%; padding: 8px; font-size: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                                <option value="">All Status</option>
                                                <option value="abs_waiting"
                                                    {{ request('status') == 'abs_waiting' ? 'selected' : '' }}>Abstract: Waiting
                                                </option>
                                                <option value="abs_accepted"
                                                    {{ request('status') == 'abs_accepted' ? 'selected' : '' }}>Abstract:
                                                    Accepted</option>
                                                <option value="art_waiting"
                                                    {{ request('status') == 'art_waiting' ? 'selected' : '' }}>Article: Waiting
                                                </option>
                                                <option value="art_accepted"
                                                    {{ request('status') == 'art_accepted' ? 'selected' : '' }}>Article:
                                                    Accepted</option>
                                            </select>
                                        </div>

                                        {{-- Publikasi --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #eee;">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px;">Publication</label>
                                            <select id="filterPublication" onchange="applyFilters()"
                                                style="width: 100%; padding: 8px; font-size: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                                <option value="">All Publication</option>
                                                @foreach ($publikasi as $pub)
                                                    <option value="{{ $pub->nama_pub }}"
                                                        {{ request('pub') == $pub->nama_pub ? 'selected' : '' }}>
                                                        {{ $pub->nama_pub }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Category --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #eee;">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px;">Category</label>
                                            <select id="filterCategory" onchange="applyFilters()"
                                                style="width: 100%; padding: 8px; font-size: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                                <option value="">All Categories</option>
                                                @foreach ($stats as $catName => $group)
                                                    <option value="{{ $catName }}"
                                                        {{ request('category') == $catName ? 'selected' : '' }}>
                                                        {{ $catName }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Scope --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #eee;">
                                            <label
                                                style="display: block; font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px;">Scope</label>
                                            <select id="filterScope" onchange="applyFilters()"
                                                style="width: 100%; padding: 8px; font-size: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa;">
                                                <option value="">All Scopes</option>
                                                @foreach ($scopes as $sc)
                                                    <option value="{{ $sc->nama_sc }}"
                                                        {{ request('scope') == $sc->nama_sc ? 'selected' : '' }}>
                                                        {{ $sc->nama_sc }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Actions --}}
                                        <div
                                            style="background: white; padding: 10px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; gap: 5px; justify-content: center; align-items: end; padding-bottom: 8px;">
                                            <button onclick="exportExcel()" class="bg-emerald-600"
                                                style="padding: 8px 12px; color: white; border-radius: 8px; font-weight: bold; font-size: 11px; border: none; cursor: pointer;">Excel</button>
                                            <button onclick="exportPdf()" class="bg-blue-600"
                                                style="padding: 8px 12px; color: white; border-radius: 8px; font-weight: bold; font-size: 11px; border: none; cursor: pointer;">PDF</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 dark:bg-zinc-800/50">
                                                <th class="p-4 text-gray-500 font-semibold text-sm">No</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Name</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Category</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Publication</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Title</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Scope</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Abstract & Status</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Review Abstract</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Article & Status</th>
                                                <th class="p-4 text-gray-500 font-semibold text-sm">Review Article</th>
                                            </tr>
                                        </thead>
                                        <tbody id="presenterTableBody"
                                            class="divide-y divide-gray-100 dark:divide-zinc-800">
                                            @forelse($presenters as $p)
                                                <tr class="searchable-row hover:bg-gray-50/50 dark:hover:bg-zinc-800/30 transition-colors"
                                                    data-name="{{ strtolower($p->nama_user) }}"
                                                    data-pub="{{ $p->nama_publikasi ?? '' }}"
                                                    data-category="{{ $p->kategori->nama_ktg }}"
                                                    data-scope="{{ $p->scope->nama_sc ?? '' }}"
                                                    data-abs-status="{{ strtolower($p->status_abstract) }}"
                                                    data-art-status="{{ strtolower($p->status_artikel) }}">
                                                    <td class="p-4 text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td class="p-4">
                                                        <div class="font-bold dark:text-white presenters-name">
                                                            {{ $p->nama_user }}</div>
                                                        <div class="text-xs text-gray-400 presenters-email">
                                                            {{ $p->email_user }}</div>
                                                        <span
                                                            class="text-[9px] px-1.5 py-0.5 rounded border {{ $p->sumber == 'ADAKSI' ? 'border-blue-200 text-blue-500' : 'border-emerald-200 text-emerald-500' }}">
                                                            {{ $p->sumber }}
                                                        </span>
                                                    </td>
                                                    <td class="p-4">
                                                        <span
                                                            class="text-sm dark:text-gray-300">{{ $p->kategori->nama_ktg }}</span><br>
                                                        @if ($p->file_kp)
                                                            <a href="{{ asset(config('path.submissions_url') . $p->file_kp) }}"
                                                                target="_blank"
                                                                class="p-2 bg-orange-500/10 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition-all shadow-sm"
                                                                title="View Student Card">
                                                                <i class="ri-file-pdf-line text-lg"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-gray-400 italic text-xs">Not Student</span>
                                                        @endif
                                                    </td>
                                                    <td class="p-4">
                                                        <span class="text-sm dark:text-gray-300">
                                                            {{ $p->nama_publikasi ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="p-4">
                                                        <span class="text-sm dark:text-gray-300">
                                                            {{ $p->judul ?? '-' }}
                                                        </span>
                                                    </td>
                                                    </td>
                                                    <td class="p-4">
                                                        <span class="text-sm dark:text-gray-300">
                                                            {{ $p->scope?->nama_sc ?? '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="p-4">
                                                        @php
                                                            // Gunakan trim() untuk menghapus spasi di awal/akhir dan strtolower agar seragam
                                                            $absStatus = strtolower(
                                                                trim($p->status_abstract ?? 'pending'),
                                                            );

                                                            $absClass =
                                                                $absStatus == 'accepted'
                                                                    ? 'bg-green-500/10 text-green-500'
                                                                    : (str_contains($absStatus, 'waiting')
                                                                        ? 'bg-yellow-500/10 text-yellow-600'
                                                                        : 'bg-gray-500/10 text-gray-500');
                                                        @endphp

                                                        {{-- Gunakan str_contains agar lebih fleksibel jika ada perbedaan spasi --}}
                                                        @if ((str_contains($absStatus, 'waiting') || $absStatus == 'accepted') && $p->file_abstract)
                                                            <a href="{{ config('path.submissions_url') . $p->file_abstract }}"
                                                                target="_blank"
                                                                class="p-2 bg-orange-500/10 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition-all shadow-sm"
                                                                title="View Abstract">
                                                                <i class="ri-file-pdf-line text-lg"></i>
                                                            </a>
                                                        @endif

                                                        <span
                                                            class="px-3 py-1 {{ $absClass }} text-[10px] font-bold rounded-full uppercase">
                                                            {{ $p->status_abstract ?? 'Pending' }}
                                                        </span>
                                                    </td>
                                                    <td class="p-4">
                                                        {{-- Cek apakah status abstract adalah 'waiting review' (case-insensitive) --}}
                                                        @if (strtolower($p->status_abstract) == 'waiting review')
                                                            <div x-data="{ open: false, decision: 'accepted' }">
                                                                <button @click="open = true"
                                                                    class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-all shadow-sm"
                                                                    title="Review Now">
                                                                    <i class="ri-edit-box-line text-lg"></i>
                                                                </button>

                                                                <template x-teleport="body">
                                                                    <div x-show="open" x-cloak
                                                                        class="fixed inset-0 z-[9999] flex items-center justify-center p-4">

                                                                        <div x-show="open"
                                                                            x-transition:enter="ease-out duration-300"
                                                                            x-transition:enter-start="opacity-0"
                                                                            x-transition:enter-end="opacity-100"
                                                                            @click="open = false"
                                                                            class="fixed inset-0 bg-black/60 backdrop-blur-sm">
                                                                        </div>

                                                                        <div x-show="open"
                                                                            x-transition:enter="ease-out duration-300"
                                                                            x-transition:enter-start="opacity-0 scale-95"
                                                                            x-transition:enter-end="opacity-100 scale-100"
                                                                            class="relative bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-zinc-800 z-10"
                                                                            style="width: 100% !important; max-width: 350px !important; margin: auto !important; position: relative !important;">

                                                                            <div class="p-6">
                                                                                <div class="text-center mb-6">
                                                                                    <h3
                                                                                        class="text-lg font-bold dark:text-white">
                                                                                        Review Abstract
                                                                                        ({{ $p->sumber }})
                                                                                    </h3>
                                                                                    <p
                                                                                        class="text-[11px] text-gray-500 mt-1">
                                                                                        Select the final decision for this
                                                                                        abstract.</p>
                                                                                </div>

                                                                                <form
                                                                                    action="{{ route('reviewer.updateStatus', ['id' => $p->id_global, 'sumber' => $p->sumber]) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <div class="space-y-3"
                                                                                        x-data="{ decision: '' }">
                                                                                        {{-- Radio Revision --}}
                                                                                        <label
                                                                                            class="flex items-center p-3 border rounded-2xl cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors border-gray-100 dark:border-zinc-800">
                                                                                            <input type="radio"
                                                                                                name="status"
                                                                                                value="revision"
                                                                                                x-model="decision"
                                                                                                class="w-4 h-4 text-blue-600"
                                                                                                required>
                                                                                            <span
                                                                                                class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Revision
                                                                                                Required</span>
                                                                                        </label>

                                                                                        {{-- Radio Accepted --}}
                                                                                        <label
                                                                                            class="flex items-center p-3 border rounded-2xl cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-colors border-gray-100 dark:border-zinc-800">
                                                                                            <input type="radio"
                                                                                                name="status"
                                                                                                value="accepted"
                                                                                                x-model="decision"
                                                                                                class="w-4 h-4 text-emerald-600">
                                                                                            <span
                                                                                                class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Accepted</span>
                                                                                        </label>

                                                                                        {{-- Dropdown Scope (Muncul jika Accepted) --}}
                                                                                        <div x-show="decision === 'accepted'"
                                                                                            x-transition x-cloak
                                                                                            class="pt-2">
                                                                                            <label
                                                                                                class="block mb-2 text-[10px] font-bold text-gray-500 uppercase ml-1">Select
                                                                                                Conference Scope</label>
                                                                                            <select name="id_sc"
                                                                                                x-bind:required="decision === 'accepted'"
                                                                                                class="w-full p-3 rounded-2xl border border-gray-200 dark:border-zinc-800 dark:bg-zinc-800 dark:text-white text-xs outline-none focus:ring-2 focus:ring-emerald-500">
                                                                                                <option value="">--
                                                                                                    Choose Scope --</option>
                                                                                                @foreach ($scopes as $sc)
                                                                                                    <option
                                                                                                        value="{{ $sc->id_sc }}">
                                                                                                        {{ $sc->nama_sc }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>

                                                                                        {{-- Textarea Revision (Muncul jika Revision) --}}
                                                                                        <div x-show="decision === 'revision'"
                                                                                            x-transition x-cloak
                                                                                            class="pt-2">
                                                                                            <textarea name="comment" x-bind:required="decision === 'revision'"
                                                                                                class="w-full p-4 rounded-2xl border border-gray-200 dark:border-zinc-800 dark:bg-zinc-800 dark:text-white text-xs outline-none focus:ring-2 focus:ring-blue-500 min-h-[100px] resize-none"
                                                                                                placeholder="Write revision notes here..."></textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mt-6 flex flex-col gap-2">
                                                                                        <button type="submit"
                                                                                            class="w-full py-3 text-sm font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-lg transition-all active:scale-95">
                                                                                            Submit Decision
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="open = false"
                                                                                            class="w-full py-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                                                                            Cancel
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        @elseif(strtolower($p->status_abstract) == null)
                                                            {{-- Tampilan jika sudah direview atau belum ada file --}}
                                                            <span class="text-gray-400 italic text-xs"> -
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                                <i class="ri-checkbox-circle-line"></i>Done
                                                        @endif
                                                    </td>
                                                    <td class="p-4">
                                                        @php
                                                            $artStatus = strtolower($p->status_artikel);
                                                            $artClass =
                                                                $artStatus == 'accepted'
                                                                    ? 'bg-green-500/10 text-green-500'
                                                                    : ($artStatus == 'waiting review'
                                                                        ? 'bg-yellow-500/10 text-yellow-600'
                                                                        : 'bg-gray-500/10 text-gray-500');
                                                        @endphp

                                                        {{-- Tombol View File hanya tampil jika status 'waiting review' atau 'accepted' --}}
                                                        @if (in_array($artStatus, ['waiting review', 'accepted']) && $p->file_artikel)
                                                            <a href="{{ config('path.submissions_url') . $p->file_artikel }}"
                                                                target="_blank"
                                                                class="p-2 bg-orange-500/10 text-orange-500 rounded-lg hover:bg-orange-500 hover:text-white transition-all shadow-sm"
                                                                title="View Artikel">
                                                                <i class="ri-file-pdf-line text-lg"></i>
                                                            </a>
                                                        @endif

                                                        <span
                                                            class="px-3 py-1 {{ $artClass }} text-[10px] font-bold rounded-full uppercase">
                                                            {{ $p->status_artikel ?? 'Not Uploaded' }}
                                                        </span>
                                                    </td>

                                                    <td class="p-4">
                                                        {{-- Tombol hanya muncul jika status artikel BELUM 'Accepted' --}}
                                                        @if (strtolower($p->status_artikel) == 'waiting review')
                                                            <div x-data="{ open: false, decision: 'accepted' }">
                                                                <button @click="open = true"
                                                                    class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-all shadow-sm"
                                                                    title="Review Article">
                                                                    <i class="ri-edit-box-line text-lg"></i>
                                                                </button>

                                                                <template x-teleport="body">
                                                                    <div x-show="open" x-cloak
                                                                        class="fixed inset-0 z-[9999] flex items-center justify-center p-4">

                                                                        <div x-show="open"
                                                                            x-transition:enter="ease-out duration-300"
                                                                            x-transition:enter-start="opacity-0"
                                                                            x-transition:enter-end="opacity-100"
                                                                            @click="open = false"
                                                                            class="fixed inset-0 bg-black/60 backdrop-blur-sm">
                                                                        </div>

                                                                        <div x-show="open"
                                                                            x-transition:enter="ease-out duration-300"
                                                                            x-transition:enter-start="opacity-0 scale-95"
                                                                            x-transition:enter-end="opacity-100 scale-100"
                                                                            class="relative bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-zinc-800 z-10"
                                                                            style="width: 100% !important; max-width: 350px !important; margin: auto !important; position: relative !important;">

                                                                            <div class="p-6">
                                                                                <div class="text-center mb-6">
                                                                                    <h3
                                                                                        class="text-lg font-bold dark:text-white">
                                                                                        Review Article</h3>
                                                                                    <p
                                                                                        class="text-[11px] text-gray-500 mt-1">
                                                                                        Final decision for this full paper.
                                                                                    </p>
                                                                                </div>

                                                                                {{-- Form Action disesuaikan untuk Artikel jika routenya berbeda --}}
                                                                                <form
                                                                                    action="{{ route('reviewer.updateStatusArtikel', ['id' => $p->id_global, 'sumber' => $p->sumber]) }}"
                                                                                    method="POST">
                                                                                    @csrf
                                                                                    <div class="space-y-3">
                                                                                        <label
                                                                                            class="flex items-center p-3 border rounded-2xl cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors border-gray-100 dark:border-zinc-800">
                                                                                            <input type="radio"
                                                                                                name="status"
                                                                                                value="revision"
                                                                                                x-model="decision"
                                                                                                class="w-4 h-4 text-blue-600"
                                                                                                required>
                                                                                            <span
                                                                                                class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Revision
                                                                                                Required</span>
                                                                                        </label>

                                                                                        <label
                                                                                            class="flex items-center p-3 border rounded-2xl cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-colors border-gray-100 dark:border-zinc-800">
                                                                                            <input type="radio"
                                                                                                name="status"
                                                                                                value="accepted"
                                                                                                x-model="decision"
                                                                                                class="w-4 h-4 text-emerald-600">
                                                                                            <span
                                                                                                class="ml-3 text-sm font-semibold text-gray-700 dark:text-gray-300">Accepted</span>
                                                                                        </label>

                                                                                        <div x-show="decision === 'revision'"
                                                                                            x-transition x-cloak
                                                                                            class="pt-2">
                                                                                            <textarea name="comment" x-bind:required="decision === 'revision'"
                                                                                                class="w-full p-4 rounded-2xl border border-gray-200 dark:border-zinc-800 dark:bg-zinc-800 dark:text-white text-xs outline-none focus:ring-2 focus:ring-blue-500 min-h-[100px] resize-none"
                                                                                                placeholder="Write article revision notes here..."></textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="mt-6 flex flex-col gap-2">
                                                                                        <button type="submit"
                                                                                            class="w-full py-3 text-sm font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-lg transition-all active:scale-95">
                                                                                            Submit Decision
                                                                                        </button>
                                                                                        <button type="button"
                                                                                            @click="open = false"
                                                                                            class="w-full py-2 text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                                                                            Cancel
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        @elseif(strtolower($p->status_artikel) == null || strtolower($p->status_artikel) == 'not uploaded')
                                                            {{-- Tampilan jika sudah direview atau belum ada file --}}
                                                            <span class="text-gray-400 italic text-xs"> -
                                                            </span>
                                                        @else
                                                            {{-- Jika sudah Accepted, tampilkan badge atau icon saja --}}
                                                            <div>
                                                                <span
                                                                    class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-lg text-[10px] font-bold uppercase">
                                                                    <i class="ri-checkbox-circle-line"></i> Done
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr id="emptyRow">
                                                    <td colspan="7" class="p-12 text-center text-gray-400 italic">
                                                        No presenters registered yet for this conference.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <div class="px-6 py-4 border-t border-gray-100 dark:border-zinc-800">
                                        {{ $presenters->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('reviewer.partials._footer')
                </div>
            </main>
        </div>
    </div>
@endsection

@section('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/dark-mode.js') }}" defer></script>
    <script>
        // Fungsi utama untuk menerapkan filter dan reload halaman
        function applyFilters() {
            const params = new URLSearchParams({
                search: document.getElementById('searchInput').value,
                status: document.getElementById('filterStatus').value,
                pub: document.getElementById('filterPublication').value,
                category: document.getElementById('filterCategory').value,
                scope: document.getElementById('filterScope').value
            });

            // Redirect ke URL dengan parameter query baru
            window.location.href = "{{ url()->current() }}?" + params.toString();
        }

        // Fungsi Export (menggunakan parameter yang sama)
        function exportPdf() {
            const url = "{{ route('reviewer.exportPresentersPdf') }}?" + new URLSearchParams({
                id_conf: "{{ $conference->id_conf }}",
                status: document.getElementById('filterStatus').value,
                category: document.getElementById('filterCategory').value,
                scope: document.getElementById('filterScope').value,
                search: document.getElementById('searchInput').value,
                pub: document.getElementById('filterPublication').value
            }).toString();
            window.location.href = url;
        }

        function exportExcel() {
            const url = "{{ route('reviewer.exportPresentersExcel') }}?" + new URLSearchParams({
                id_conf: "{{ $conference->id_conf }}",
                status: document.getElementById('filterStatus').value,
                category: document.getElementById('filterCategory').value,
                scope: document.getElementById('filterScope').value,
                search: document.getElementById('searchInput').value,
                pub: document.getElementById('filterPublication').value
            }).toString();
            window.location.href = url;
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Event Listeners untuk dropdown (Trigger reload)
            document.querySelectorAll('select').forEach(el => el.addEventListener('change', applyFilters));

            // Trigger Search saat menekan Enter
            document.getElementById('searchInput').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') applyFilters();
            });

            // Sidebar & Profile Logic tetap sama...
            const profileBtn = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-dropdown');
            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });
                window.addEventListener('click', (e) => {
                    if (!profileBtn.contains(e.target)) profileDropdown.classList.add('hidden');
                });
            }
        });
    </script>
@endsection
