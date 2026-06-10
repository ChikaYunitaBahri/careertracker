@extends('layouts.app')

@section('content')

<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#191C1F]">
                Lamaran Saya
            </h1>
            <p class="text-sm text-[#797586] mt-1">
                {{ $totalActive }} lamaran aktif
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-shrink-0">

            {{-- View Switcher: Board / List --}}
            <div class="flex border border-[#E1E2E6] rounded-lg overflow-hidden">
                <a href="{{ route('applications.index') }}"
                    @class([
                        'flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'           => request('view') !== 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]' => request('view') === 'list',
                    ])>
                    <i class="ri-layout-column-line text-sm"></i>
                    Board
                </a>
                <a href="{{ route('applications.index', ['view' => 'list']) }}"
                    @class([
                        'flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'           => request('view') === 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]' => request('view') !== 'list',
                    ])>
                    <i class="ri-list-unordered text-sm"></i>
                    List
                </a>
            </div>

            {{-- Tambah Lamaran --}}
            <a href="{{ route('applications.create') }}"
                class="flex items-center gap-1.5 bg-[#5E3BDB] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#4d31b8] transition-colors">
                <i class="ri-add-line text-base"></i>
                Tambah Lamaran
            </a>

        </div>

    </div>

    {{-- Filter Bar --}}
    <div x-data="filterBar()" class="space-y-2.5">

        <div class="flex items-center gap-3 flex-wrap">

            {{-- Search --}}
            <div class="relative flex-1 min-w-[200px] max-w-xs">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-[#ADADB8] text-sm pointer-events-none"></i>
                <input
                    type="text"
                    x-model="search"
                    @keyup.enter="submitForm()"
                    placeholder="Cari perusahaan atau posisi..."
                    class="w-full pl-8 pr-4 py-2 text-sm border border-[#E1E2E6] rounded-lg bg-white text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
            </div>

            {{-- Divider --}}
            <div class="hidden sm:block w-px h-5 bg-[#E1E2E6] flex-shrink-0"></div>

            {{-- Filter Tipe --}}
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-medium text-[#ADADB8] flex-shrink-0">Tipe</span>
                <div class="flex items-center gap-1.5 flex-wrap">
                    @foreach([
                        'full_time'  => 'Full-time',
                        'internship' => 'Internship',
                        'part_time'  => 'Part-time',
                        'contract'   => 'Contract',
                        'freelance'  => 'Freelance',
                    ] as $value => $label)
                        <button
                            type="button"
                            @click="toggleType('{{ $value }}')"
                            :class="activeTypes.includes('{{ $value }}')
                                ? 'bg-[#5E3BDB] border-[#5E3BDB] text-white'
                                : 'bg-white border-[#E1E2E6] text-[#797586] hover:border-[#b8a8f5] hover:text-[#5E3BDB] hover:bg-[#f5f3ff]'"
                            class="flex items-center gap-1 px-2.5 py-1 text-xs font-medium border rounded-full transition-all duration-150 cursor-pointer">
                            {{ $label }}
                            <i x-show="activeTypes.includes('{{ $value }}')" class="ri-close-line text-xs leading-none" style="display:none"></i>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Divider --}}
            <div class="hidden sm:block w-px h-5 bg-[#E1E2E6] flex-shrink-0"></div>

            {{-- Sort --}}
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-[#ADADB8] flex-shrink-0">Urutan</span>
                <div class="flex items-center gap-1.5">
                    @foreach([
                        'latest'   => 'Terbaru',
                        'oldest'   => 'Terlama',
                        'position' => 'A–Z',
                    ] as $value => $label)
                        <button
                            type="button"
                            @click="setSort('{{ $value }}')"
                            :class="activeSort === '{{ $value }}'
                                ? 'bg-[#5E3BDB] border-[#5E3BDB] text-white'
                                : 'bg-white border-[#E1E2E6] text-[#797586] hover:border-[#b8a8f5] hover:text-[#5E3BDB] hover:bg-[#f5f3ff]'"
                            class="px-2.5 py-1 text-xs font-medium border rounded-full transition-all duration-150 cursor-pointer">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Reset --}}
            <button
                type="button"
                x-show="hasActiveFilters"
                @click="resetAll"
                class="flex items-center gap-1 text-xs text-[#E74C3C] hover:bg-red-50 px-2 py-1 rounded-lg transition-colors"
                style="display:none">
                <i class="ri-close-line text-sm"></i>
                Reset
            </button>

        </div>

        {{-- Active Filter Tags --}}
        <div x-show="hasActiveFilterTags" class="flex items-center gap-2 flex-wrap" style="display:none">
            <template x-for="type in activeTypes" :key="type">
                <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-[#EDE9FB] text-[#5E3BDB] px-2.5 py-1 rounded-full">
                    <span x-text="typeLabels[type]"></span>
                    <button @click="toggleType(type)" class="ml-0.5 text-[#9b8fe8] hover:text-[#5E3BDB] leading-none">
                        <i class="ri-close-line text-xs"></i>
                    </button>
                </span>
            </template>
            <template x-if="activeSort !== 'latest'">
                <span class="inline-flex items-center gap-1 text-[11px] font-medium bg-[#EDE9FB] text-[#5E3BDB] px-2.5 py-1 rounded-full">
                    <i class="ri-arrow-up-down-line text-[11px]"></i>
                    <span x-text="sortLabels[activeSort]"></span>
                    <button @click="setSort('latest')" class="ml-0.5 text-[#9b8fe8] hover:text-[#5E3BDB] leading-none">
                        <i class="ri-close-line text-xs"></i>
                    </button>
                </span>
            </template>
            <span class="text-[11px] text-[#ADADB8]" x-text="filterCountText"></span>
        </div>

        {{-- Hidden form untuk submit filter ke server --}}
        <form id="filterForm" method="GET" action="{{ route('applications.index') }}" class="hidden">
            <input type="hidden" name="view" value="{{ request('view') }}">
            <input type="hidden" name="search" x-bind:value="search">
            <input type="hidden" name="job_type" x-bind:value="activeTypes.join(',')">
            <input type="hidden" name="sort" x-bind:value="activeSort">
        </form>

    </div>

    {{-- ============================================================ --}}
    {{-- TOAST NOTIFICATION (pojok kanan atas)                        --}}
    {{-- ============================================================ --}}
    @if(session('success') || session('error'))
        <div
            x-data="{
                show: true,
                type: '{{ session('success') ? 'success' : 'error' }}',
                message: '{{ session('success') ?? session('error') }}'
            }"
            x-init="setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-10"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-10"
            class="fixed top-6 right-6 z-50 flex items-start gap-3 px-4 py-3.5 rounded-xl shadow-lg border max-w-sm w-full"
            :class="type === 'success'
                ? 'bg-white border-green-200 text-green-800'
                : 'bg-white border-red-200 text-red-800'">

            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                :class="type === 'success' ? 'bg-green-100' : 'bg-red-100'">
                <i class="text-sm"
                    :class="type === 'success' ? 'ri-checkbox-circle-fill text-green-600' : 'ri-close-circle-fill text-red-600'"></i>
            </div>

            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-semibold" x-text="type === 'success' ? 'Berhasil' : 'Gagal'"></p>
                <p class="text-xs mt-0.5 opacity-80" x-text="message"></p>
            </div>

            <button @click="show = false"
                class="flex-shrink-0 p-1 rounded-lg hover:bg-gray-100 transition-colors mt-0.5"
                :class="type === 'success' ? 'text-green-500' : 'text-red-500'">
                <i class="ri-close-line text-sm"></i>
            </button>

        </div>
    @endif

    {{-- ============================================================ --}}
    {{-- DELETE CONFIRM MODAL (tengah layar)                          --}}
    {{-- ============================================================ --}}
    <div
        x-data="deleteModal()"
        @open-delete-modal.window="open($event.detail)"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="display:none">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]" @click="close()"></div>

        {{-- Modal Box --}}
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 z-10">

            {{-- Icon --}}
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-50 mx-auto mb-4">
                <i class="ri-delete-bin-line text-2xl text-red-500"></i>
            </div>

            {{-- Content --}}
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold text-[#191C1F]">Hapus Lamaran?</h3>
                <p class="text-sm text-[#797586] mt-1.5">
                    Lamaran
                    <span class="font-semibold text-[#191C1F]" x-text="positionName"></span>
                    di
                    <span class="font-semibold text-[#191C1F]" x-text="companyName"></span>
                    akan dihapus permanen dan tidak bisa dikembalikan.
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3">
                <button
                    @click="close()"
                    class="flex-1 px-4 py-2.5 text-sm font-medium text-[#797586] bg-[#F8F9FD] hover:bg-[#EAEBEF] rounded-xl transition-colors">
                    Batal
                </button>
                <form :action="formAction" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-xl transition-colors">
                        Ya, Hapus
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- LIST VIEW                                                     --}}
    {{-- ============================================================ --}}
    @if($viewMode === 'list')

        <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

            {{-- Table Header --}}
            @if($applications->isNotEmpty())
                <div class="grid grid-cols-[auto_1fr_140px_100px_110px_80px] items-center gap-4 px-4 py-2.5 bg-[#F8F9FD] border-b border-[#EAEBEF]">
                    <div class="w-8"></div>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide">Posisi & Perusahaan</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide">Status</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide hidden md:block">Tipe</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide hidden sm:block">Tanggal</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide ">Aksi</span>
                </div>
            @endif

            @forelse($applications as $application)
                @php
                    $jobTypeLabelMap = ['full_time'=>'Full-time','part_time'=>'Part-time','internship'=>'Internship','contract'=>'Contract','freelance'=>'Freelance'];
                    $jobTypeLabel = $jobTypeLabelMap[$application->job_type] ?? null;
                    $jobTypeBadge = match($application->job_type) {
                        'full_time'  => 'bg-violet-100 text-violet-600',
                        'part_time'  => 'bg-sky-100 text-sky-600',
                        'internship' => 'bg-emerald-100 text-emerald-600',
                        'contract'   => 'bg-amber-100 text-amber-600',
                        'freelance'  => 'bg-pink-100 text-pink-600',
                        default      => '',
                    };
                    $statusBadge = match($application->status->slug ?? '') {
                        'wishlist'  => 'bg-gray-100 text-gray-500',
                        'applied'   => 'bg-blue-100 text-blue-600',
                        'hr_screen' => 'bg-purple-100 text-purple-600',
                        'interview' => 'bg-amber-100 text-amber-600',
                        'offering'  => 'bg-teal-100 text-teal-600',
                        'accepted'  => 'bg-green-100 text-green-600',
                        'rejected'  => 'bg-red-100 text-red-500',
                        default     => 'bg-gray-100 text-gray-500',
                    };
                    $dotColor = match($application->status->slug ?? '') {
                        'wishlist'  => 'bg-gray-400',
                        'applied'   => 'bg-blue-500',
                        'hr_screen' => 'bg-purple-500',
                        'interview' => 'bg-amber-500',
                        'offering'  => 'bg-teal-500',
                        'accepted'  => 'bg-green-500',
                        'rejected'  => 'bg-red-500',
                        default     => 'bg-gray-400',
                    };
                @endphp

                <div class="grid grid-cols-[auto_1fr_140px_100px_110px_80px] items-center gap-4 px-4 py-3 border-b border-[#EAEBEF] last:border-0 hover:bg-[#FAFBFF] transition-colors group">

                    {{-- Avatar --}}
                    <div class="w-8 h-8 rounded-lg {{ $statusBadge }} flex items-center justify-center text-[11px] font-bold flex-shrink-0">
                        {{ strtoupper(substr($application->company_name, 0, 2)) }}
                    </div>

                    {{-- Posisi & Perusahaan --}}
                    <a href="{{ route('applications.show', $application) }}" class="min-w-0">
                        <p class="text-sm font-semibold text-[#191C1F] truncate leading-snug">{{ $application->position_name }}</p>
                        <p class="text-xs text-[#797586] truncate mt-0.5">{{ $application->company_name }}</p>
                    </a>

                    {{-- Status --}}
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotColor }}"></span>
                        <span class="text-xs font-medium text-[#191C1F] truncate">
                            {{ $application->status->label ?? '-' }}
                        </span>
                    </div>

                    {{-- Tipe --}}
                    <div class="hidden md:block">
                        @if($jobTypeLabel)
                            <span class="text-xs px-2 py-0.5 rounded-full {{ $jobTypeBadge }} font-medium">
                                {{ $jobTypeLabel }}
                            </span>
                        @else
                            <span class="text-xs text-[#D4D6DC]">—</span>
                        @endif
                    </div>

                    {{-- Tanggal --}}
                    <span class="text-xs text-[#ADADB8] hidden sm:flex items-center gap-1.5 flex-shrink-0">
                        <i class="ri-calendar-line text-xs"></i>
                        {{ $application->applied_date->format('d M Y') }}
                    </span>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('applications.show', $application) }}"
                            title="Lihat Detail"
                            class="p-1.5 rounded-lg text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">
                            <i class="ri-eye-line text-sm"></i>
                        </a>
                        <a href="{{ route('applications.edit', $application) }}"
                            title="Edit"
                            class="p-1.5 rounded-lg text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">
                            <i class="ri-edit-line text-sm"></i>
                        </a>
                        <button
                            type="button"
                            title="Hapus"
                            @click="$dispatch('open-delete-modal', {
                                action: '{{ route('applications.destroy', $application) }}',
                                position: '{{ addslashes($application->position_name) }}',
                                company: '{{ addslashes($application->company_name) }}'
                            })"
                            class="p-1.5 rounded-lg text-[#ADADB8] hover:text-red-500 hover:bg-red-50 transition-colors">
                            <i class="ri-delete-bin-line text-sm"></i>
                        </button>
                    </div>

                </div>

            @empty
                <div class="text-center py-16">
                    <i class="ri-inbox-line text-3xl text-[#D4D6DC]"></i>
                    <p class="text-sm text-[#C5C6CC] mt-2">Belum ada lamaran</p>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $applications->links() }}
        </div>

    @else
    {{-- ============================================================ --}}
    {{-- BOARD VIEW (Kanban)                                           --}}
    {{-- ============================================================ --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-7 gap-3 overflow-x-auto pb-2">

            @foreach($statuses as $status)

                @php
                    $cards = $grouped[$status->id] ?? collect();

                    $dotColor = match($status->slug) {
                        'wishlist'  => 'bg-[#95A5A6]',
                        'applied'   => 'bg-[#3498DB]',
                        'hr_screen' => 'bg-[#9B59B6]',
                        'interview' => 'bg-[#F39C12]',
                        'offering'  => 'bg-[#1ABC9C]',
                        'accepted'  => 'bg-[#27AE60]',
                        'rejected'  => 'bg-[#E74C3C]',
                        default     => 'bg-[#95A5A6]',
                    };

                    $badgeBg = match($status->slug) {
                        'wishlist'  => 'bg-gray-100 text-gray-500',
                        'applied'   => 'bg-blue-100 text-blue-600',
                        'hr_screen' => 'bg-purple-100 text-purple-600',
                        'interview' => 'bg-amber-100 text-amber-600',
                        'offering'  => 'bg-teal-100 text-teal-600',
                        'accepted'  => 'bg-green-100 text-green-600',
                        'rejected'  => 'bg-red-100 text-red-500',
                        default     => 'bg-gray-100 text-gray-500',
                    };

                    $avatarBg = match($status->slug) {
                        'wishlist'  => 'bg-gray-100 text-gray-500',
                        'applied'   => 'bg-blue-100 text-blue-600',
                        'hr_screen' => 'bg-purple-100 text-purple-600',
                        'interview' => 'bg-amber-100 text-amber-600',
                        'offering'  => 'bg-teal-100 text-teal-600',
                        'accepted'  => 'bg-green-100 text-green-600',
                        'rejected'  => 'bg-red-100 text-red-500',
                        default     => 'bg-gray-100 text-gray-500',
                    };
                @endphp

                <div class="xl:col-span-1 min-w-[160px] bg-[#F8F9FD] border border-[#EAEBEF] rounded-xl p-2.5 flex flex-col gap-2">

                    {{-- Column Header --}}
                    <div class="flex items-center justify-between px-1 py-0.5">
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $dotColor }}"></span>
                            <span class="text-xs font-semibold text-[#191C1F] leading-none">{{ $status->label }}</span>
                        </div>
                        <span class="text-[11px] font-medium px-1.5 py-0.5 rounded-full leading-none {{ $badgeBg }}">
                            {{ $cards->count() }}
                        </span>
                    </div>

                    {{-- Application Cards --}}
                    <div class="space-y-1.5 flex-1" id="col-{{ $status->slug }}">

                        @forelse($cards as $application)

                            @php
                                $jobTypeLabelMap = [
                                    'full_time'  => 'Full-time',
                                    'part_time'  => 'Part-time',
                                    'internship' => 'Internship',
                                    'contract'   => 'Contract',
                                    'freelance'  => 'Freelance',
                                ];
                                $jobTypeLabel = $jobTypeLabelMap[$application->job_type] ?? null;

                                $jobTypeBadge = match($application->job_type) {
                                    'full_time'  => 'bg-violet-100 text-violet-600',
                                    'part_time'  => 'bg-sky-100 text-sky-600',
                                    'internship' => 'bg-emerald-100 text-emerald-600',
                                    'contract'   => 'bg-amber-100 text-amber-600',
                                    'freelance'  => 'bg-pink-100 text-pink-600',
                                    default      => '',
                                };

                                $initials = strtoupper(substr($application->company_name, 0, 2));
                            @endphp

                            <div class="bg-white border border-[#EAEBEF] rounded-lg p-2.5 hover:border-[#5E3BDB]/40 hover:shadow-sm transition-all group cursor-pointer">

                                {{-- Card Top: Avatar + Dots Menu --}}
                                <div class="flex items-start justify-between mb-2">

                                    <div class="w-7 h-7 rounded-md {{ $avatarBg }} flex items-center justify-center text-[10px] font-bold flex-shrink-0">
                                        {{ $initials }}
                                    </div>

                                    {{-- Dots Menu --}}
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click.stop="open = !open"
                                            class="text-[#ADADB8] hover:text-[#191C1F] p-0.5 rounded hover:bg-[#F8F9FD] transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100">
                                            <i class="ri-more-2-line text-sm"></i>
                                        </button>
                                        <div x-show="open" @click.outside="open = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100"
                                            class="absolute right-0 top-6 bg-white border border-[#EAEBEF] rounded-xl shadow-lg z-20 w-40 py-1">
                                            <a href="{{ route('applications.show', $application) }}"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-[#191C1F] hover:bg-[#F8F9FD]">
                                                <i class="ri-eye-line text-sm text-[#797586]"></i> Lihat Detail
                                            </a>
                                            <a href="{{ route('applications.edit', $application) }}"
                                                class="flex items-center gap-2 px-3 py-2 text-xs text-[#191C1F] hover:bg-[#F8F9FD]">
                                                <i class="ri-edit-line text-sm text-[#797586]"></i> Edit
                                            </a>
                                            <div class="border-t border-[#EAEBEF] my-1"></div>
                                            <button
                                                type="button"
                                                @click="$dispatch('open-delete-modal', {
                                                    action: '{{ route('applications.destroy', $application) }}',
                                                    position: '{{ addslashes($application->position_name) }}',
                                                    company: '{{ addslashes($application->company_name) }}'
                                                })"
                                                class="w-full flex items-center gap-2 px-3 py-2 text-xs text-red-500 hover:bg-red-50">
                                                <i class="ri-delete-bin-line text-sm"></i> Hapus
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                {{-- Position & Company --}}
                                <a href="{{ route('applications.show', $application) }}" class="block">
                                    <p class="text-xs font-semibold text-[#191C1F] leading-snug mb-0.5 line-clamp-2">
                                        {{ $application->position_name }}
                                    </p>
                                    <p class="text-[11px] text-[#797586] mb-2.5">
                                        {{ $application->company_name }}
                                    </p>
                                </a>

                                {{-- Card Footer: Tanggal + Badge Tipe --}}
                                <div class="flex items-center justify-between gap-1">
                                    <span class="flex items-center gap-1 text-[11px] text-[#ADADB8]">
                                        <i class="ri-calendar-line text-[11px]"></i>
                                        {{ $application->applied_date->format('d M') }}
                                    </span>
                                    @if($jobTypeLabel)
                                        <span class="text-[10px] px-1.5 py-0.5 rounded-full leading-none {{ $jobTypeBadge }}">
                                            {{ $jobTypeLabel }}
                                        </span>
                                    @endif
                                </div>

                            </div>

                        @empty

                            {{-- Empty State per Kolom --}}
                            <div class="text-center py-5 px-2">
                                <i class="ri-inbox-line text-xl text-[#D4D6DC]"></i>
                                <p class="text-[11px] text-[#C5C6CC] mt-1">Belum ada</p>
                            </div>

                        @endforelse

                    </div>

                    {{-- Add Button per Kolom --}}
                    <a href="{{ route('applications.create', ['status' => $status->id]) }}"
                        class="flex items-center gap-1 text-[11px] text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-white px-2 py-1.5 rounded-lg transition-colors">
                        <i class="ri-add-line text-sm"></i>
                        Tambah
                    </a>

                </div>

            @endforeach

        </div>

    @endif

    {{-- Empty State global --}}
    @if($totalActive === 0 && !request()->hasAny(['search', 'job_type', 'sort']))
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#F0ECFE] mb-4">
                <i class="ri-send-plane-line text-3xl text-[#5E3BDB]"></i>
            </div>
            <h3 class="text-base font-semibold text-[#191C1F]">Belum ada lamaran</h3>
            <p class="text-sm text-[#797586] mt-1.5 mb-6">
                Mulai tambahkan lamaran pertamamu dan pantau progresnya di sini.
            </p>
            <a href="{{ route('applications.create') }}"
                class="inline-flex items-center gap-2 bg-[#5E3BDB] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#4d31b8] transition-colors">
                <i class="ri-add-line text-base"></i>
                Tambah Lamaran Pertama
            </a>
        </div>
    @endif

</div>

@push('scripts')
<script>
function filterBar() {
    const jobTypeParam = "{{ request('job_type', '') }}";
    const activeTypesArray = jobTypeParam ? jobTypeParam.split(',') : [];

    return {
        search: "{{ request('search', '') }}",
        activeTypes: activeTypesArray,
        activeSort: "{{ request('sort', 'latest') }}",
        typeLabels: {
            full_time:  'Full-time',
            internship: 'Internship',
            part_time:  'Part-time',
            contract:   'Contract',
            freelance:  'Freelance',
        },
        sortLabels: {
            latest:   'Terbaru',
            oldest:   'Terlama',
            position: 'A\u2013Z Posisi',
        },
        get hasActiveFilters() {
            return this.search || this.activeTypes.length > 0 || this.activeSort !== 'latest';
        },
        get hasActiveFilterTags() {
            return this.activeTypes.length > 0 || this.activeSort !== 'latest';
        },
        get filterCountText() {
            let count = 0;
            count += this.activeTypes.length;
            if (this.activeSort !== 'latest') count++;
            return count + ' filter aktif';
        },
        toggleType(value) {
            const idx = this.activeTypes.indexOf(value);
            if (idx === -1) this.activeTypes.push(value);
            else this.activeTypes.splice(idx, 1);
            this.submitForm();
        },
        setSort(value) {
            this.activeSort = value;
            this.submitForm();
        },
        resetAll() {
            this.search = '';
            this.activeTypes = [];
            this.activeSort = 'latest';
            this.submitForm();
        },
        submitForm() {
            this.$nextTick(() => document.getElementById('filterForm').submit());
        },
    }
}

function deleteModal() {
    return {
        isOpen: false,
        formAction: '',
        positionName: '',
        companyName: '',
        open(detail) {
            this.formAction   = detail.action;
            this.positionName = detail.position;
            this.companyName  = detail.company;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },
    }
}
</script>
@endpush

@endsection
