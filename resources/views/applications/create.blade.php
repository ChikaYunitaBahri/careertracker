@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-[#797586]">
        <a href="{{ route('applications.index') }}" class="hover:text-[#191C1F] transition-colors">Lamaran</a>
        <i class="ri-arrow-right-s-line text-base"></i>
        <span class="text-[#191C1F] font-medium">Tambah Lamaran Baru</span>
    </nav>

    {{-- Page Header --}}
    <div>
        <h1 class="text-4xl font-bold tracking-tight text-[#191C1F]">
            Tambah Lamaran
        </h1>
        <p class="text-[#797586] mt-2">
            Isi detail lamaran yang sudah kamu kirimkan atau ingin kamu pantau.
        </p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center gap-2 text-red-700 font-medium text-sm mb-2">
                <i class="ri-error-warning-line text-base"></i>
                Mohon periksa kembali isian berikut:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('applications.store') }}" class="space-y-6">
        @csrf

        {{-- Section: Informasi Posisi --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 space-y-5">

            <h2 class="text-base font-semibold text-[#191C1F]">
                Informasi Posisi
            </h2>

            {{-- Nama Posisi --}}
            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Nama Posisi <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="position_name"
                    value="{{ old('position_name') }}"
                    placeholder="cth. Product Designer, Frontend Developer"
                    class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] @error('position_name') border-red-400 @enderror">
                @error('position_name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Perusahaan --}}
            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Nama Perusahaan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name') }}"
                    placeholder="cth. Google, Tokopedia, Gojek"
                    class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] @error('company_name') border-red-400 @enderror">
                @error('company_name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status & Tanggal Lamar (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Status Awal <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="status_id"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] @error('status_id') border-red-400 @enderror">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ old('status_id', request('status', $defaultStatusId)) == $status->id ? 'selected' : '' }}>
                                {{ $status->label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Tanggal Melamar <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="date"
                        name="applied_date"
                        value="{{ old('applied_date', now()->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] @error('applied_date') border-red-400 @enderror">
                    @error('applied_date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>

        {{-- Section: Detail Pekerjaan --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 space-y-5">

            <h2 class="text-base font-semibold text-[#191C1F]">
                Detail Pekerjaan
            </h2>

            {{-- Tipe & Lokasi Kerja (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Tipe Pekerjaan
                    </label>
                    <select
                        name="job_type"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                        <option value="">Pilih tipe</option>
                        <option value="full_time" {{ old('job_type') === 'full_time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part_time" {{ old('job_type') === 'part_time' ? 'selected' : '' }}>Part-time</option>
                        <option value="internship" {{ old('job_type') === 'internship' ? 'selected' : '' }}>Internship</option>
                        <option value="contract" {{ old('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="freelance" {{ old('job_type') === 'freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Tipe Lokasi
                    </label>
                    <select
                        name="work_location_type"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                        <option value="">Pilih lokasi</option>
                        <option value="onsite" {{ old('work_location_type') === 'onsite' ? 'selected' : '' }}>On-site</option>
                        <option value="remote" {{ old('work_location_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid" {{ old('work_location_type') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>

            </div>

            {{-- Kota --}}
            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Kota / Lokasi
                </label>
                <input
                    type="text"
                    name="location"
                    value="{{ old('location') }}"
                    placeholder="cth. Jakarta, Bandung, Remote"
                    class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
            </div>

            {{-- Estimasi Gaji (2 kolom) --}}
            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Estimasi Gaji (Rp)
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#797586]">Min</span>
                        <input
                            type="number"
                            name="salary_min"
                            value="{{ old('salary_min') }}"
                            placeholder="5000000"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-[#797586]">Maks</span>
                        <input
                            type="number"
                            name="salary_max"
                            value="{{ old('salary_max') }}"
                            placeholder="10000000"
                            class="w-full pl-12 pr-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                    </div>
                </div>
            </div>

            {{-- Sumber & Link Job Post (2 kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Sumber Lamaran
                    </label>
                    <input
                        type="text"
                        name="source"
                        value="{{ old('source') }}"
                        placeholder="cth. LinkedIn, Glints, Referral"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                        Kode Referral
                    </label>
                    <input
                        type="text"
                        name="referral_code"
                        value="{{ old('referral_code') }}"
                        placeholder="Opsional"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB]">
                </div>

            </div>

            {{-- Link Job Post --}}
            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Link Job Posting
                </label>
                <input
                    type="url"
                    name="job_post_url"
                    value="{{ old('job_post_url') }}"
                    placeholder="https://glints.com/id/opportunities/..."
                    class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] @error('job_post_url') border-red-400 @enderror">
                @error('job_post_url')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Section: Catatan Awal --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 space-y-4">

            <h2 class="text-base font-semibold text-[#191C1F]">
                Catatan Awal
            </h2>

            <div>
                <label class="block text-sm font-medium text-[#191C1F] mb-1.5">
                    Catatan <span class="text-[#797586] font-normal">(opsional)</span>
                </label>
                <textarea
                    name="initial_notes"
                    rows="4"
                    placeholder="Tulis hal penting yang ingin kamu ingat tentang lamaran ini..."
                    class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-xl bg-white text-[#191C1F] placeholder-[#C5C6CC] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/30 focus:border-[#5E3BDB] resize-none">{{ old('initial_notes') }}</textarea>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between gap-4 pt-2 pb-8">

            <a href="{{ route('applications.index') }}"
                class="flex items-center justify-center gap-2 bg-[#EFF1F5] text-sm text-[#797586] hover:text-[#191C1F] transition-colors px-6 py-3 border border-[#E1E2E6] rounded-xl hover:bg-[#EFF1F5] flex-1">
                Batal
            </a>

            <button type="submit"
                class="flex items-center justify-center gap-2 bg-[#5E3BDB] text-white text-sm font-medium px-6 py-3 rounded-xl hover:bg-[#4d31b8] transition-colors flex-[3]">
                <i class="ri-save-line text-base"></i>
                Simpan Lamaran
            </button>

        </div>

    </form>

</div>

@endsection