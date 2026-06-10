@extends('layouts.app')

@section('content')

{{-- ============================================================ --}}
{{-- TOAST NOTIFICATION                                           --}}
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
        :class="type === 'success' ? 'bg-white border-green-200 text-green-800' : 'bg-white border-red-200 text-red-800'">
        <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
            :class="type === 'success' ? 'bg-green-100' : 'bg-red-100'">
            <i class="text-sm" :class="type === 'success' ? 'ri-checkbox-circle-fill text-green-600' : 'ri-close-circle-fill text-red-600'"></i>
        </div>
        <div class="flex-1 min-w-0 pt-0.5">
            <p class="text-sm font-semibold" x-text="type === 'success' ? 'Berhasil' : 'Gagal'"></p>
            <p class="text-xs mt-0.5 opacity-80" x-text="message"></p>
        </div>
        <button @click="show = false" class="flex-shrink-0 p-1 rounded-lg hover:bg-gray-100 transition-colors mt-0.5"
            :class="type === 'success' ? 'text-green-500' : 'text-red-500'">
            <i class="ri-close-line text-sm"></i>
        </button>
    </div>
@endif

{{-- ============================================================ --}}
{{-- DELETE NOTE MODAL                                            --}}
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
    <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]" @click="close()"></div>
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
            <i class="ri-delete-bin-line text-xl text-red-500"></i>
        </div>
        <div class="text-center mb-5">
            <h3 class="text-base font-bold text-[#191C1F]" x-text="title"></h3>
            <p class="text-sm text-[#797586] mt-1" x-text="description"></p>
        </div>
        <div class="flex gap-3">
            <button @click="close()"
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

@php
    $statusBadge = match($application->status->slug ?? '') {
        'wishlist'  => 'bg-gray-100 text-gray-500 border-gray-200',
        'applied'   => 'bg-blue-50 text-blue-600 border-blue-200',
        'hr_screen' => 'bg-purple-50 text-purple-600 border-purple-200',
        'interview' => 'bg-amber-50 text-amber-600 border-amber-200',
        'offering'  => 'bg-teal-50 text-teal-600 border-teal-200',
        'accepted'  => 'bg-green-50 text-green-600 border-green-200',
        'rejected'  => 'bg-red-50 text-red-500 border-red-200',
        default     => 'bg-gray-100 text-gray-500 border-gray-200',
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
    $avatarBg = match($application->status->slug ?? '') {
        'wishlist'  => 'bg-gray-100 text-gray-500',
        'applied'   => 'bg-blue-100 text-blue-600',
        'hr_screen' => 'bg-purple-100 text-purple-600',
        'interview' => 'bg-amber-100 text-amber-600',
        'offering'  => 'bg-teal-100 text-teal-600',
        'accepted'  => 'bg-green-100 text-green-600',
        'rejected'  => 'bg-red-100 text-red-500',
        default     => 'bg-gray-100 text-gray-500',
    };
    $jobTypeLabelMap = ['full_time'=>'Full-time','part_time'=>'Part-time','internship'=>'Internship','contract'=>'Contract','freelance'=>'Freelance'];
    $jobTypeLabel = $jobTypeLabelMap[$application->job_type] ?? null;
    $jobTypeBadge = match($application->job_type) {
        'full_time'  => 'bg-violet-100 text-violet-600',
        'part_time'  => 'bg-sky-100 text-sky-600',
        'internship' => 'bg-emerald-100 text-emerald-600',
        'contract'   => 'bg-amber-100 text-amber-600',
        'freelance'  => 'bg-pink-100 text-pink-600',
        default      => 'bg-gray-100 text-gray-500',
    };
    $workLocationMap = ['onsite'=>'Onsite','remote'=>'Remote','hybrid'=>'Hybrid'];
    $workLocationLabel = $workLocationMap[$application->work_location_type] ?? null;
    $noteTypeMap = ['hr_interview'=>'HR Interview','user_interview'=>'User Interview','psikotest'=>'Psikotest','general'=>'Umum'];
    $noteTypeBadge = fn($type) => match($type) {
        'hr_interview'   => 'bg-purple-100 text-purple-600',
        'user_interview' => 'bg-blue-100 text-blue-600',
        'psikotest'      => 'bg-amber-100 text-amber-600',
        'general'        => 'bg-gray-100 text-gray-500',
        default          => 'bg-gray-100 text-gray-500',
    };
    $docTypeMap = ['cv'=>'CV / Resume','cover_letter'=>'Cover Letter','portfolio'=>'Portfolio','other'=>'Lainnya'];
    $docTypeBadge = fn($type) => match($type) {
        'cv'           => 'bg-violet-100 text-violet-600',
        'cover_letter' => 'bg-sky-100 text-sky-600',
        'portfolio'    => 'bg-emerald-100 text-emerald-600',
        'other'        => 'bg-gray-100 text-gray-500',
        default        => 'bg-gray-100 text-gray-500',
    };
@endphp

<div x-data class="space-y-6">

    {{-- ── HEADER ─────────────────────────────────────────────────────── --}}
    <div class="flex items-start justify-between gap-4">

        {{-- Back + Title --}}
        <div class="flex items-start gap-3">
            <a href="{{ route('applications.index') }}"
                class="mt-0.5 p-1.5 rounded-lg text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors flex-shrink-0">
                <i class="ri-arrow-left-line text-base"></i>
            </a>
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-2xl font-bold tracking-tight text-[#191C1F]">
                        {{ $application->position_name }}
                    </h1>
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full border {{ $statusBadge }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                        {{ $application->status->label ?? '-' }}
                    </span>
                </div>
                <p class="text-sm text-[#797586] mt-0.5">{{ $application->company_name }}</p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="{{ route('applications.edit', $application) }}"
                class="flex items-center gap-1.5 text-sm font-medium text-[#5E3BDB] bg-[#EDE9FB] px-3.5 py-2 rounded-lg hover:bg-[#ddd5f8] transition-colors">
                <i class="ri-edit-line text-sm"></i>
                Edit
            </a>
            <button
                type="button"
                @click="$dispatch('open-delete-modal', {
                    action: '{{ route('applications.destroy', $application) }}',
                    title: 'Hapus Lamaran?',
                    description: 'Lamaran {{ addslashes($application->position_name) }} di {{ addslashes($application->company_name) }} akan dihapus permanen.'
                })"
                class="flex items-center gap-1.5 text-sm font-medium text-red-500 bg-red-50 px-3.5 py-2 rounded-lg hover:bg-red-100 transition-colors">
                <i class="ri-delete-bin-line text-sm"></i>
                Hapus
            </button>
        </div>

    </div>

    {{-- ── MAIN GRID ───────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ── LEFT COLUMN (2/3) ──────────────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- INFO UTAMA --}}
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-5">

                <h2 class="text-sm font-semibold text-[#191C1F] mb-4">Informasi Lamaran</h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4">

                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Tanggal Daftar</p>
                        <p class="text-sm text-[#191C1F] font-medium">{{ $application->applied_date->format('d M Y') }}</p>
                    </div>

                    @if($jobTypeLabel)
                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Tipe Pekerjaan</p>
                        <span class="inline-flex text-xs font-medium px-2 py-0.5 rounded-full {{ $jobTypeBadge }}">{{ $jobTypeLabel }}</span>
                    </div>
                    @endif

                    @if($workLocationLabel)
                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Lokasi Kerja</p>
                        <p class="text-sm text-[#191C1F]">{{ $workLocationLabel }}</p>
                    </div>
                    @endif

                    @if($application->location)
                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Lokasi</p>
                        <p class="text-sm text-[#191C1F]">{{ $application->location }}</p>
                    </div>
                    @endif

                    @if($application->source)
                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Sumber</p>
                        <p class="text-sm text-[#191C1F]">{{ $application->source }}</p>
                    </div>
                    @endif

                    @if($application->referral_code)
                    <div>
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Kode Referral</p>
                        <p class="text-sm text-[#191C1F] font-mono">{{ $application->referral_code }}</p>
                    </div>
                    @endif

                    @if($application->salary_min || $application->salary_max)
                    <div class="col-span-2 sm:col-span-3">
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Ekspektasi Gaji</p>
                        <p class="text-sm text-[#191C1F] font-medium">
                            @if($application->salary_min && $application->salary_max)
                                Rp {{ number_format($application->salary_min, 0, ',', '.') }} – Rp {{ number_format($application->salary_max, 0, ',', '.') }}
                            @elseif($application->salary_min)
                                Min. Rp {{ number_format($application->salary_min, 0, ',', '.') }}
                            @else
                                Maks. Rp {{ number_format($application->salary_max, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                    @endif

                    @if($application->job_post_url)
                    <div class="col-span-2 sm:col-span-3">
                        <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">Link Lowongan</p>
                        <a href="{{ $application->job_post_url }}" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-1.5 text-sm text-[#5E3BDB] hover:underline">
                            <i class="ri-external-link-line text-xs"></i>
                            {{ Str::limit($application->job_post_url, 60) }}
                        </a>
                    </div>
                    @endif

                </div>

                @if($application->initial_notes)
                <div class="mt-4 pt-4 border-t border-[#EAEBEF]">
                    <p class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1.5">Catatan Awal</p>
                    <p class="text-sm text-[#191C1F] leading-relaxed whitespace-pre-line">{{ $application->initial_notes }}</p>
                </div>
                @endif

            </div>

            {{-- ── CATATAN / NOTES ──────────────────────────────────── --}}
            <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-3.5 border-b border-[#EAEBEF]">
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-semibold text-[#191C1F]">Catatan</h2>
                        <span class="text-[11px] font-medium bg-[#EDE9FB] text-[#5E3BDB] px-1.5 py-0.5 rounded-full">
                            {{ $application->notes->count() }}
                        </span>
                    </div>
                    <button
                        x-data
                        @click="$dispatch('open-add-note')"
                        class="flex items-center gap-1 text-xs font-medium text-[#5E3BDB] hover:bg-[#EDE9FB] px-2.5 py-1.5 rounded-lg transition-colors">
                        <i class="ri-add-line text-sm"></i>
                        Tambah Catatan
                    </button>
                </div>

                {{-- Add Note Form (collapsible) --}}
                <div
                    x-data="{ open: false }"
                    @open-add-note.window="open = true; $nextTick(() => $el.querySelector('textarea')?.focus())"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="border-b border-[#EAEBEF] bg-[#FAFBFF]"
                    style="display:none">
                    <form method="POST" action="{{ route('applications.notes.store', $application) }}" class="p-5 space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-[#797586] mb-1">Tipe Catatan</label>
                                <select name="note_type"
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                                    <option value="general">Umum</option>
                                    <option value="hr_interview">HR Interview</option>
                                    <option value="user_interview">User Interview</option>
                                    <option value="psikotest">Psikotest</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-[#797586] mb-1">Tanggal Interview <span class="text-[#ADADB8]">(opsional)</span></label>
                                <input type="datetime-local" name="interview_date"
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-medium text-[#797586] mb-1">Nama Pewawancara <span class="text-[#ADADB8]">(opsional)</span></label>
                                <input type="text" name="interviewer_name" placeholder="Nama pewawancara..."
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#797586] mb-1">Isi Catatan</label>
                            <textarea name="content" rows="4" required placeholder="Tulis catatanmu di sini..."
                                class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2.5 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#797586] mb-1">Kesan <span class="text-[#ADADB8]">(opsional)</span></label>
                            <textarea name="impression" rows="2" placeholder="Kesan atau perasaanmu setelah sesi ini..."
                                class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2.5 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]"></textarea>
                        </div>
                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="open = false"
                                class="text-sm text-[#797586] hover:text-[#191C1F] px-3 py-1.5 rounded-lg hover:bg-[#F0F1F5] transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="text-sm font-medium bg-[#5E3BDB] text-white px-4 py-1.5 rounded-lg hover:bg-[#4d31b8] transition-colors">
                                Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Notes List --}}
                @forelse($application->notes as $note)
                    <div class="px-5 py-4 border-b border-[#EAEBEF] last:border-0 group" x-data="{ editing: false }">

                        {{-- Note Header --}}
                        <div class="flex items-start justify-between gap-3 mb-2.5">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[11px] font-medium px-2 py-0.5 rounded-full {{ $noteTypeBadge($note->note_type) }}">
                                    {{ $noteTypeMap[$note->note_type] ?? $note->note_type }}
                                </span>
                                @if($note->interview_date)
                                    <span class="flex items-center gap-1 text-[11px] text-[#ADADB8]">
                                        <i class="ri-calendar-event-line text-[11px]"></i>
                                        {{ $note->interview_date->format('d M Y, H:i') }}
                                    </span>
                                @endif
                                @if($note->interviewer_name)
                                    <span class="flex items-center gap-1 text-[11px] text-[#ADADB8]">
                                        <i class="ri-user-line text-[11px]"></i>
                                        {{ $note->interviewer_name }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                                <button @click="editing = !editing"
                                    class="p-1.5 rounded-lg text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">
                                    <i class="ri-edit-line text-sm"></i>
                                </button>
                                <button
                                    type="button"
                                    @click="$dispatch('open-delete-modal', {
                                        action: '{{ route('applications.notes.destroy', [$application, $note]) }}',
                                        title: 'Hapus Catatan?',
                                        description: 'Catatan ini akan dihapus permanen dan tidak bisa dikembalikan.'
                                    })"
                                    class="p-1.5 rounded-lg text-[#ADADB8] hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="ri-delete-bin-line text-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- View mode --}}
                        <div x-show="!editing">
                            <p class="text-sm text-[#191C1F] leading-relaxed whitespace-pre-line">{{ $note->content }}</p>
                            @if($note->impression)
                                <div class="mt-2.5 pt-2.5 border-t border-dashed border-[#EAEBEF]">
                                    <p class="text-[11px] font-medium text-[#ADADB8] mb-1">Kesan</p>
                                    <p class="text-xs text-[#797586] italic leading-relaxed">{{ $note->impression }}</p>
                                </div>
                            @endif
                            <p class="text-[11px] text-[#ADADB8] mt-2">{{ $note->created_at->diffForHumans() }}</p>
                        </div>

                        {{-- Edit mode --}}
                        <div x-show="editing" style="display:none">
                            <form method="POST" action="{{ route('applications.notes.update', [$application, $note]) }}" class="space-y-3">
                                @csrf @method('PATCH')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-[#797586] mb-1">Tipe</label>
                                        <select name="note_type" class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                                            @foreach(['general'=>'Umum','hr_interview'=>'HR Interview','user_interview'=>'User Interview','psikotest'=>'Psikotest'] as $val => $lbl)
                                                <option value="{{ $val }}" @selected($note->note_type === $val)>{{ $lbl }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-[#797586] mb-1">Tanggal Interview</label>
                                        <input type="datetime-local" name="interview_date"
                                            value="{{ $note->interview_date?->format('Y-m-d\TH:i') }}"
                                            class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-xs font-medium text-[#797586] mb-1">Pewawancara</label>
                                        <input type="text" name="interviewer_name" value="{{ $note->interviewer_name }}"
                                            class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                                    </div>
                                </div>
                                <textarea name="content" rows="4" required
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2.5 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">{{ $note->content }}</textarea>
                                <textarea name="impression" rows="2" placeholder="Kesan..."
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2.5 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">{{ $note->impression }}</textarea>
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="editing = false"
                                        class="text-sm text-[#797586] hover:text-[#191C1F] px-3 py-1.5 rounded-lg hover:bg-[#F0F1F5] transition-colors">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="text-sm font-medium bg-[#5E3BDB] text-white px-4 py-1.5 rounded-lg hover:bg-[#4d31b8] transition-colors">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-10">
                        <i class="ri-sticky-note-line text-2xl text-[#D4D6DC]"></i>
                        <p class="text-sm text-[#C5C6CC] mt-1.5">Belum ada catatan</p>
                    </div>
                @endforelse

            </div>

            {{-- ── DOKUMEN ─────────────────────────────────────────── --}}
            <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

                <div class="flex items-center justify-between px-5 py-3.5 border-b border-[#EAEBEF]">
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-semibold text-[#191C1F]">Dokumen</h2>
                        <span class="text-[11px] font-medium bg-[#EDE9FB] text-[#5E3BDB] px-1.5 py-0.5 rounded-full">
                            {{ $application->documents->count() }}
                        </span>
                    </div>
                    <button
                        x-data
                        @click="$dispatch('open-upload-doc')"
                        class="flex items-center gap-1 text-xs font-medium text-[#5E3BDB] hover:bg-[#EDE9FB] px-2.5 py-1.5 rounded-lg transition-colors">
                        <i class="ri-upload-2-line text-sm"></i>
                        Upload
                    </button>
                </div>

                {{-- Upload Form --}}
                <div
                    x-data="{ open: false }"
                    @open-upload-doc.window="open = true"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="border-b border-[#EAEBEF] bg-[#FAFBFF]"
                    style="display:none">
                    <form method="POST" action="{{ route('applications.documents.store', $application) }}"
                        enctype="multipart/form-data" class="p-5 space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-[#797586] mb-1">Tipe Dokumen</label>
                                <select name="document_type"
                                    class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB]">
                                    <option value="cv">CV / Resume</option>
                                    <option value="cover_letter">Cover Letter</option>
                                    <option value="portfolio">Portfolio</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-[#797586] mb-1">File</label>
                                <input type="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.png,.zip"
                                    class="w-full text-sm text-[#797586] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[#EDE9FB] file:text-[#5E3BDB] hover:file:bg-[#ddd5f8]">
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="open = false"
                                class="text-sm text-[#797586] hover:text-[#191C1F] px-3 py-1.5 rounded-lg hover:bg-[#F0F1F5] transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="text-sm font-medium bg-[#5E3BDB] text-white px-4 py-1.5 rounded-lg hover:bg-[#4d31b8] transition-colors">
                                Upload
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Documents List --}}
                @forelse($application->documents as $doc)
                    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-[#EAEBEF] last:border-0 group hover:bg-[#FAFBFF] transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-[#F0ECFE] flex items-center justify-center flex-shrink-0">
                            <i class="ri-file-text-line text-[#5E3BDB] text-base"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-[#191C1F] truncate">{{ $doc->file_name }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[11px] font-medium px-1.5 py-0.5 rounded-full {{ $docTypeBadge($doc->document_type) }}">
                                    {{ $docTypeMap[$doc->document_type] ?? $doc->document_type }}
                                </span>
                                @if($doc->file_size)
                                    <span class="text-[11px] text-[#ADADB8]">{{ round($doc->file_size / 1024) }} KB</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('applications.documents.download', [$application, $doc]) }}"
                                class="p-1.5 rounded-lg text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors"
                                title="Download">
                                <i class="ri-download-line text-sm"></i>
                            </a>
                            <button
                                type="button"
                                @click="$dispatch('open-delete-modal', {
                                    action: '{{ route('applications.documents.destroy', [$application, $doc]) }}',
                                    title: 'Hapus Dokumen?',
                                    description: 'File {{ addslashes($doc->file_name) }} akan dihapus permanen.'
                                })"
                                class="p-1.5 rounded-lg text-[#ADADB8] hover:text-red-500 hover:bg-red-50 transition-colors"
                                title="Hapus">
                                <i class="ri-delete-bin-line text-sm"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <i class="ri-folder-line text-2xl text-[#D4D6DC]"></i>
                        <p class="text-sm text-[#C5C6CC] mt-1.5">Belum ada dokumen</p>
                    </div>
                @endforelse

            </div>

        </div>

        {{-- ── RIGHT COLUMN (1/3) ─────────────────────────────────────── --}}
        <div class="space-y-5">

            {{-- STATUS TRACKER --}}
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-5">
                <h2 class="text-sm font-semibold text-[#191C1F] mb-4">Status Lamaran</h2>
                @php
                    $statusFlow = ['wishlist','applied','hr_screen','interview','offering','accepted'];
                    $currentSlug = $application->status->slug ?? '';
                    $isRejected = $currentSlug === 'rejected';
                    $currentIdx = array_search($currentSlug, $statusFlow);
                    $statusLabels = ['wishlist'=>'Wishlist','applied'=>'Applied','hr_screen'=>'HR Screen','interview'=>'Interview','offering'=>'Offering','accepted'=>'Accepted'];
                @endphp
                <div class="space-y-2">
                    @foreach($statusFlow as $idx => $slug)
                        @php
                            $isPast    = !$isRejected && $currentIdx !== false && $idx < $currentIdx;
                            $isCurrent = $currentSlug === $slug;
                            $isFuture  = !$isPast && !$isCurrent;
                        @endphp
                        <div class="flex items-center gap-2.5">
                            <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0
                                {{ $isCurrent ? 'bg-[#5E3BDB] ring-4 ring-[#5E3BDB]/15' : ($isPast ? 'bg-[#5E3BDB]' : 'bg-[#E1E2E6]') }}">
                                @if($isPast)
                                    <i class="ri-check-line text-[10px] text-white"></i>
                                @elseif($isCurrent)
                                    <span class="w-2 h-2 rounded-full bg-white"></span>
                                @endif
                            </div>
                            <span class="text-xs {{ $isCurrent ? 'font-semibold text-[#5E3BDB]' : ($isPast ? 'text-[#191C1F]' : 'text-[#ADADB8]') }}">
                                {{ $statusLabels[$slug] }}
                            </span>
                        </div>
                        @if(!$loop->last)
                            <div class="ml-2 w-px h-3 {{ $isPast ? 'bg-[#5E3BDB]' : 'bg-[#E1E2E6]' }} ml-[9px]"></div>
                        @endif
                    @endforeach

                    @if($isRejected)
                        <div class="mt-2 flex items-center gap-2 bg-red-50 border border-red-200 rounded-lg px-3 py-2">
                            <i class="ri-close-circle-line text-red-500 text-sm"></i>
                            <span class="text-xs font-medium text-red-600">Lamaran Ditolak</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- AKTIVITAS TERBARU --}}
            <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">
                <div class="px-5 py-3.5 border-b border-[#EAEBEF]">
                    <h2 class="text-sm font-semibold text-[#191C1F]">Aktivitas</h2>
                </div>
                @forelse($application->activities->take(8) as $activity)
                    <div class="flex gap-3 px-5 py-3 border-b border-[#EAEBEF] last:border-0">
                        <div class="w-6 h-6 rounded-full bg-[#F0ECFE] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="ri-history-line text-[10px] text-[#5E3BDB]"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-[#191C1F] leading-snug">{{ $activity->description }}</p>
                            <p class="text-[11px] text-[#ADADB8] mt-0.5">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="ri-history-line text-2xl text-[#D4D6DC]"></i>
                        <p class="text-xs text-[#C5C6CC] mt-1.5">Belum ada aktivitas</p>
                    </div>
                @endforelse
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
function deleteModal() {
    return {
        isOpen: false,
        formAction: '',
        title: '',
        description: '',
        open(detail) {
            this.formAction  = detail.action;
            this.title       = detail.title;
            this.description = detail.description;
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
