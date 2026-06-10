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

<div class="max-w-6xl mx-auto space-y-5">

    {{-- ── HEADER ─────────────────────────────────────────────────────── --}}
    <div class="flex items-center gap-3">
        <a href="{{ url()->previous() }}"
            class="p-1.5 rounded-lg text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">
            <i class="ri-arrow-left-line text-base"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#191C1F]">Edit Lamaran</h1>
            <p class="text-sm text-[#797586] mt-0.5">{{ $application->position_name }} · {{ $application->company_name }}</p>
        </div>
    </div>

    {{-- ── FORM ────────────────────────────────────────────────────────── --}}
    <form method="POST" action="{{ route('applications.update', $application) }}" class="space-y-5">
        @csrf
        @method('PATCH')

        {{-- SECTION: Posisi & Perusahaan --}}
        <div class="bg-white border border-[#EAEBEF] rounded-xl p-5 space-y-4">

            <h2 class="text-sm font-semibold text-[#191C1F]">Posisi & Perusahaan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">
                        Posisi <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="position_name"
                        value="{{ old('position_name', $application->position_name) }}"
                        required placeholder="Contoh: Product Designer"
                        class="w-full text-sm border @error('position_name') border-red-400 @else border-[#E1E2E6] @enderror rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                    @error('position_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">
                        Nama Perusahaan <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="company_name"
                        value="{{ old('company_name', $application->company_name) }}"
                        required placeholder="Contoh: Google"
                        class="w-full text-sm border @error('company_name') border-red-400 @else border-[#E1E2E6] @enderror rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                    @error('company_name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">
                        Tanggal Daftar <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="applied_date"
                        value="{{ old('applied_date', $application->applied_date->format('Y-m-d')) }}"
                        required
                        class="w-full text-sm border @error('applied_date') border-red-400 @else border-[#E1E2E6] @enderror rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                    @error('applied_date')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

        </div>

        {{-- SECTION: Status & Tipe --}}
        <div class="bg-white border border-[#EAEBEF] rounded-xl p-5 space-y-4">

            <h2 class="text-sm font-semibold text-[#191C1F]">Status & Tipe</h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Status</label>
                    <select name="status_id"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" @selected(old('status_id', $application->status_id) == $status->id)>
                                {{ $status->label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Tipe Pekerjaan</label>
                    <select name="job_type"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                        <option value="">– Pilih –</option>
                        @foreach(['full_time'=>'Full-time','part_time'=>'Part-time','internship'=>'Internship','contract'=>'Contract','freelance'=>'Freelance'] as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('job_type', $application->job_type) === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Lokasi Kerja</label>
                    <select name="work_location_type"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                        <option value="">– Pilih –</option>
                        @foreach(['onsite'=>'Onsite','remote'=>'Remote','hybrid'=>'Hybrid'] as $val => $lbl)
                            <option value="{{ $val }}" @selected(old('work_location_type', $application->work_location_type) === $val)>{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

        </div>

        {{-- SECTION: Detail Tambahan --}}
        <div class="bg-white border border-[#EAEBEF] rounded-xl p-5 space-y-4">

            <h2 class="text-sm font-semibold text-[#191C1F]">Detail Tambahan</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Lokasi Kota / Wilayah</label>
                    <input type="text" name="location"
                        value="{{ old('location', $application->location) }}"
                        placeholder="Contoh: Jakarta Selatan"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Sumber Lamaran</label>
                    <input type="text" name="source"
                        value="{{ old('source', $application->source) }}"
                        placeholder="LinkedIn, JobStreet, Referral..."
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Gaji Minimum (Rp)</label>
                    <input type="number" name="salary_min"
                        value="{{ old('salary_min', $application->salary_min) }}"
                        placeholder="5000000"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Gaji Maksimum (Rp)</label>
                    <input type="number" name="salary_max"
                        value="{{ old('salary_max', $application->salary_max) }}"
                        placeholder="8000000"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Kode Referral</label>
                    <input type="text" name="referral_code"
                        value="{{ old('referral_code', $application->referral_code) }}"
                        placeholder="REF-XXXX"
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white font-mono focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Link Lowongan</label>
                    <input type="url" name="job_post_url"
                        value="{{ old('job_post_url', $application->job_post_url) }}"
                        placeholder="https://linkedin.com/jobs/..."
                        class="w-full text-sm border @error('job_post_url') border-red-400 @else border-[#E1E2E6] @enderror rounded-lg px-3.5 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                    @error('job_post_url')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-[#797586] mb-1.5">Catatan Awal</label>
                    <textarea name="initial_notes" rows="4"
                        placeholder="Motivasi melamar, info penting, atau hal yang ingin diingat..."
                        class="w-full text-sm border border-[#E1E2E6] rounded-lg px-3.5 py-2.5 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">{{ old('initial_notes', $application->initial_notes) }}</textarea>
                </div>

            </div>

            {{-- Arsip toggle --}}
            <div class="flex items-center justify-between pt-1 border-t border-[#EAEBEF]">
                <div>
                    <p class="text-sm font-medium text-[#191C1F]">Arsipkan Lamaran</p>
                    <p class="text-xs text-[#ADADB8] mt-0.5">Lamaran yang diarsipkan tidak tampil di board/list utama</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_archived" value="0">
                    <input type="checkbox" name="is_archived" value="1" class="sr-only peer"
                        @checked(old('is_archived', $application->is_archived))>
                    <div class="w-10 h-6 bg-[#E1E2E6] peer-focus:ring-2 peer-focus:ring-[#5E3BDB]/20 rounded-full peer peer-checked:bg-[#5E3BDB] transition-colors"></div>
                    <div class="absolute left-0.5 top-0.5 bg-white w-5 h-5 rounded-full shadow transition-transform peer-checked:translate-x-4"></div>
                </label>
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
                Simpan Perusahaan
            </button>

    </form>

</div>

@endsection