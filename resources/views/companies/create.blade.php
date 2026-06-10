@extends('layouts.app')

@section('content')

<div class="space-y-5">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-[#797586]">
        <a href="{{ route('companies.index') }}" class="hover:text-[#191C1F] transition-colors">Perusahaan</a>
        <i class="ri-arrow-right-s-line text-base"></i>
        <span class="text-[#191C1F] font-medium">Tambah Perusahaan Baru</span>
    </nav>

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#191C1F]">
                Tambah Perusahaan
            </h1>
            <p class="text-sm text-[#797586] mt-1">
                Masukkan informasi lengkap perusahaan baru
            </p>
        </div>
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

    {{-- Form Container --}}

        <form method="POST" action="{{ route('companies.store') }}" class="space-y-6">
            @csrf

            {{-- Two Column Layout --}}
            <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 space-y-5">
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
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                                placeholder="PT. Nama Perusahaan">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Startup" {{ old('industry') == 'Startup' ? 'selected' : '' }}>Startup</option>
                                <option value="Enterprise" {{ old('industry') == 'Enterprise' ? 'selected' : '' }}>Enterprise</option>
                                <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Lainnya" {{ old('industry') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('industry')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                <option value="startup" {{ old('size') == 'startup' ? 'selected' : '' }}>Startup</option>
                                <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Kecil</option>
                                <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>Menengah</option>
                                <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>Besar</option>
                                <option value="corporate" {{ old('size') == 'corporate' ? 'selected' : '' }}>Korporat</option>
                            </select>
                            @error('size')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                value="{{ old('website') }}"
                                class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                                placeholder="https://example.com">
                            @error('website')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                value="{{ old('location') }}"
                                class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                                placeholder="Jakarta, Indonesia">
                            @error('location')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                value="{{ old('logo_url') }}"
                                class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                                placeholder="https://example.com/logo.png">
                            @error('logo_url')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                value="{{ old('personal_rating') }}"
                                class="w-full px-4 py-2.5 text-sm border border-[#E1E2E6] rounded-lg text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors"
                                placeholder="Berikan rating 1-5">
                            @error('personal_rating')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                                placeholder="Deskripsi singkat tentang perusahaan...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                            placeholder="Tuliskan catatan tentang budaya perusahaan...">{{ old('culture_notes') }}</textarea>
                        @error('culture_notes')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
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
                            placeholder="Tuliskan catatan tentang benefit dan gaji...">{{ old('benefits_notes') }}</textarea>
                        @error('benefits_notes')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

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
