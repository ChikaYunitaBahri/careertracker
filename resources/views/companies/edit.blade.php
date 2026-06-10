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

    {{-- Page Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ url()->previous() }}"
            class="p-1.5 rounded-lg text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">
            <i class="ri-arrow-left-line text-base"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-[#191C1F]">Edit Perusahaan</h1>
            <p class="text-sm text-[#797586] mt-0.5">{{ $company->name }}</p>
        </div>
    </div>

    {{-- Form Container --}}
    <form method="POST" action="{{ route('companies.update', $company) }}" class="space-y-4">
        @csrf
        @method('PATCH')
        
        <div class="bg-white border border-[#EAEBEF] rounded-xl p-5 space-y-4">

            {{-- Two Column Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Left Column --}}
                <div class="space-y-6">

                    {{-- Company Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $company->name) }}"
                            required
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                            placeholder="PT. Nama Perusahaan">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('name') }}</p>
                        @enderror
                    </div>

                    {{-- Industry --}}
                    <div>
                        <label for="industry" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Industri
                        </label>
                        <select
                            id="industry"
                            name="industry"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                            <option value="">Pilih Industri</option>
                            <option value="Technology" {{ old('industry', $company->industry) == 'Technology' ? 'selected' : '' }}>Technology</option>
                            <option value="Finance" {{ old('industry', $company->industry) == 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Startup" {{ old('industry', $company->industry) == 'Startup' ? 'selected' : '' }}>Startup</option>
                            <option value="Enterprise" {{ old('industry', $company->industry) == 'Enterprise' ? 'selected' : '' }}>Enterprise</option>
                            <option value="Retail" {{ old('industry', $company->industry) == 'Retail' ? 'selected' : '' }}>Retail</option>
                            <option value="Healthcare" {{ old('industry', $company->industry) == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                            <option value="Education" {{ old('industry', $company->industry) == 'Education' ? 'selected' : '' }}>Education</option>
                            <option value="Lainnya" {{ old('industry', $company->industry) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('industry')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('industry') }}</p>
                        @enderror
                    </div>

                    {{-- Size --}}
                    <div>
                        <label for="size" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Ukuran Perusahaan
                        </label>
                        <select
                            id="size"
                            name="size"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
                            <option value="">Pilih Ukuran</option>
                            <option value="startup" {{ old('size', $company->size) == 'startup' ? 'selected' : '' }}>Startup</option>
                            <option value="small" {{ old('size', $company->size) == 'small' ? 'selected' : '' }}>Kecil</option>
                            <option value="medium" {{ old('size', $company->size) == 'medium' ? 'selected' : '' }}>Menengah</option>
                            <option value="large" {{ old('size', $company->size) == 'large' ? 'selected' : '' }}>Besar</option>
                            <option value="corporate" {{ old('size', $company->size) == 'corporate' ? 'selected' : '' }}>Korporat</option>
                        </select>
                        @error('size')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('size') }}</p>
                        @enderror
                    </div>

                    {{-- Website --}}
                    <div>
                        <label for="website" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Website
                        </label>
                        <input
                            type="url"
                            id="website"
                            name="website"
                            value="{{ old('website', $company->website) }}"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                            placeholder="https://example.com">
                        @error('website')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('website') }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Right Column --}}
                <div class="space-y-6">

                    {{-- Location --}}
                    <div>
                        <label for="location" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Lokasi
                        </label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            value="{{ old('location', $company->location) }}"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                            placeholder="Jakarta, Indonesia">
                        @error('location')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('location') }}</p>
                        @enderror
                    </div>

                    {{-- Logo URL --}}
                    <div>
                        <label for="logo_url" class="block text-sm font-medium text-[#191C1F] mb-2">
                            URL Logo Perusahaan
                        </label>
                        <input
                            type="url"
                            id="logo_url"
                            name="logo_url"
                            value="{{ old('logo_url', $company->logo_url) }}"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                            placeholder="https://example.com/logo.png">
                        @error('logo_url')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('logo_url') }}</p>
                        @enderror
                    </div>

                    {{-- Personal Rating --}}
                    <div>
                        <label for="personal_rating" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Rating Pribadi (1-5)
                        </label>
                        <input
                            type="number"
                            id="personal_rating"
                            name="personal_rating"
                            min="1"
                            max="5"
                            value="{{ old('personal_rating', $company->personal_rating) }}"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                            placeholder="Berikan rating 1-5">
                        @error('personal_rating')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('personal_rating') }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-[#191C1F] mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors resize-none"
                            placeholder="Deskripsi singkat tentang perusahaan...">{{ old('description', $company->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('description') }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            {{-- Additional Fields --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8 pt-8 border-t border-[#E1E2E6]">

                {{-- Culture Notes --}}
                <div>
                    <label for="culture_notes" class="block text-sm font-medium text-[#191C1F] mb-2">
                        Catatan Budaya Perusahaan
                    </label>
                    <textarea
                        id="culture_notes"
                        name="culture_notes"
                        rows="3"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors resize-none"
                        placeholder="Tuliskan catatan tentang budaya perusahaan...">{{ old('culture_notes', $company->culture_notes) }}</textarea>
                    @error('culture_notes')
                        <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('culture_notes') }}</p>
                    @enderror
                </div>

                {{-- Benefits Notes --}}
                <div>
                    <label for="benefits_notes" class="block text-sm font-medium text-[#191C1F] mb-2">
                        Catatan Benefit & Gaji
                    </label>
                    <textarea
                        id="benefits_notes"
                        name="benefits_notes"
                        rows="3"
                        class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors resize-none"
                        placeholder="Tuliskan catatan tentang benefit dan gaji...">{{ old('benefits_notes', $company->benefits_notes) }}</textarea>
                    @error('benefits_notes')
                        <p class="text-xs text-red-500 mt-1.5">{{ $errors->first('benefits_notes') }}</p>
                    @enderror
                </div>

            </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-between gap-4 pt-2 pb-8">

            <a href="{{ route('companies.index') }}"
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

