@extends('layouts.app')

@section('content')

{{-- TOAST --}}
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

        <div
            class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
            :class="type === 'success' ? 'bg-green-100' : 'bg-red-100'">

            <i class="text-sm"
                :class="type === 'success'
                    ? 'ri-checkbox-circle-fill text-green-600'
                    : 'ri-close-circle-fill text-red-600'">
            </i>
        </div>

        <div class="flex-1 min-w-0 pt-0.5">
            <p class="text-sm font-semibold"
                x-text="type === 'success' ? 'Berhasil' : 'Gagal'">
            </p>

            <p class="text-xs mt-0.5 opacity-80"
                x-text="message">
            </p>
        </div>

        <button
            @click="show = false"
            class="flex-shrink-0 p-1 rounded-lg hover:bg-gray-100 transition-colors mt-0.5">

            <i class="ri-close-line text-sm"></i>
        </button>
    </div>
@endif

{{-- DELETE MODAL --}}
<div
    x-data="deleteModal()"
    @open-delete-modal.window="open($event.detail)"
    x-show="isOpen"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display:none">

    <div class="absolute inset-0 bg-black/40" @click="close()"></div>

    <div
        x-show="isOpen"
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 z-10">

        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
            <i class="ri-delete-bin-line text-xl text-red-500"></i>
        </div>

        <div class="text-center mb-5">
            <h3 class="text-base font-bold text-[#191C1F]" x-text="title"></h3>
            <p class="text-sm text-[#797586] mt-1" x-text="description"></p>
        </div>

        <div class="flex gap-3">
            <button
                @click="close()"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-[#797586] bg-[#F8F9FD] rounded-xl">
                Batal
            </button>

            <form :action="formAction" method="POST" class="flex-1">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="w-full px-4 py-2.5 text-sm font-medium text-white bg-red-500 rounded-xl">
                    Ya, Hapus
                </button>
            </form>
        </div>

    </div>
</div>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-start justify-between gap-4">

        <div class="flex items-start gap-3">

            <a href="{{ route('companies.index') }}"
                class="mt-0.5 p-1.5 rounded-lg text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors">

                <i class="ri-arrow-left-line text-base"></i>
            </a>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-[#191C1F]">
                    {{ $company->name }}
                </h1>

                <p class="text-sm text-[#797586] mt-0.5">
                    {{ $company->industry ?? 'Perusahaan' }}
                </p>
            </div>

        </div>

        <div class="flex items-center gap-2">

            <a href="{{ route('companies.edit', $company) }}"
                class="flex items-center gap-1.5 text-sm font-medium text-[#5E3BDB] bg-[#EDE9FB] px-3.5 py-2 rounded-lg hover:bg-[#ddd5f8]">

                <i class="ri-edit-line text-sm"></i>
                Edit
            </a>

            <button
                type="button"
                @click="$dispatch('open-delete-modal',{
                    formAction:'{{ route('companies.destroy',$company) }}',
                    title:'Hapus Perusahaan?',
                    description:'Perusahaan {{ addslashes($company->name) }} akan dihapus permanen.'
                })"

                class="flex items-center gap-1.5 text-sm font-medium text-red-500 bg-red-50 px-3.5 py-2 rounded-lg hover:bg-red-100">

                <i class="ri-delete-bin-line text-sm"></i>
                Hapus
            </button>

        </div>

    </div>

    {{-- MAIN GRID --}}
    <div class="space-y-5">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-stretch">

            @php
                $sizeLabel = match($company->size) {
                    'startup' => 'Startup',
                    'small' => 'Kecil',
                    'medium' => 'Menengah',
                    'large' => 'Besar',
                    'corporate' => 'Korporat',
                    default => $company->size ?? '-',
                };
            @endphp

            {{-- COMPANY INFO --}}
            <div class="lg:col-span-2">

                <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden h-full flex flex-col">

                    <div class="p-5 border-b border-[#EAEBEF]">

                        <div class="flex items-center gap-4">

                            <div class="w-14 h-14 rounded-xl bg-[#F0ECFE] flex items-center justify-center">
                                <i class="ri-building-2-line text-2xl text-[#5E3BDB]"></i>
                            </div>

                            <div>
                                <h2 class="text-xl font-bold text-[#191C1F]">
                                    {{ $company->name }}
                                </h2>

                                <p class="text-sm text-[#797586]">
                                    {{ $company->industry ?? '-' }}
                                </p>
                            </div>

                        </div>

                    </div>

                    <div class="p-5">

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-4">

                            {{-- Website --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Website
                                </p>

                                @if($company->website)
                                    <a href="{{ $company->website }}"
                                    target="_blank"
                                    class="text-sm text-[#5E3BDB] hover:underline break-all">
                                        {{ parse_url($company->website, PHP_URL_HOST) ?? $company->website }}
                                    </a>
                                @else
                                    <p class="text-sm text-[#ADADB8]">-</p>
                                @endif
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Lokasi
                                </p>

                                <p class="text-sm text-[#191C1F]">
                                    {{ $company->location ?? '-' }}
                                </p>
                            </div>

                            {{-- Ukuran --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Ukuran
                                </p>

                                <p class="text-sm text-[#191C1F]">
                                    {{ $sizeLabel }}
                                </p>
                            </div>

                            {{-- Rating --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Rating Pribadi
                                </p>

                                <div class="flex items-center gap-1">

                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= ($company->personal_rating ?? 0)
                                            ? 'ri-star-fill text-amber-400'
                                            : 'ri-star-line text-[#D1D5DB]' }}"></i>
                                    @endfor

                                    <span class="text-xs text-[#797586] ml-1">
                                        {{ $company->personal_rating ?? 0 }}/5
                                    </span>

                                </div>
                            </div>

                            {{-- Created --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Ditambahkan
                                </p>

                                <p class="text-sm text-[#191C1F]">
                                    {{ $company->created_at->format('d M Y') }}
                                </p>
                            </div>

                            {{-- Updated --}}
                            <div>
                                <p class="text-[11px] font-medium text-[#ADADB8] uppercase mb-1">
                                    Diperbarui
                                </p>

                                <p class="text-sm text-[#191C1F]">
                                    {{ $company->updated_at->format('d M Y') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- STATISTIK --}}
            <div>

                <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

                    <div class="px-5 py-3.5 border-b border-[#EAEBEF]">
                        <h2 class="text-sm font-semibold text-[#191C1F]">
                            Statistik
                        </h2>
                    </div>

                    <div class="divide-y divide-[#EAEBEF] flex-1 flex flex-col">

                        <div class="flex items-center justify-between px-5 py-4 flex-1">

                            <div class="flex items-center gap-3">

                                <div class="w-9 h-9 rounded-lg bg-[#F0ECFE] flex items-center justify-center">
                                    <i class="ri-file-list-line text-[#5E3BDB]"></i>
                                </div>

                                <span class="text-sm text-[#191C1F]">
                                    Lamaran
                                </span>

                            </div>

                            <span class="text-2xl font-bold text-[#191C1F]">
                                {{ $company->applications_count ?? 0 }}
                            </span>

                        </div>

                        <div class="flex items-center justify-between px-5 py-4 flex-1">

                            <div class="flex items-center gap-3">

                                <div class="w-9 h-9 rounded-lg bg-[#F0ECFE] flex items-center justify-center">
                                    <i class="ri-user-line text-[#5E3BDB]"></i>
                                </div>

                                <span class="text-sm text-[#191C1F]">
                                    Kontak
                                </span>

                            </div>

                            <span class="text-2xl font-bold text-[#191C1F]">
                                {{ $company->contacts_count ?? 0 }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        {{-- DESKRIPSI --}}
        @if($company->description)
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-5">
                <h2 class="text-sm font-semibold text-[#191C1F] mb-3">
                    Deskripsi
                </h2>

                <p class="text-sm text-[#797586] leading-relaxed">
                    {{ $company->description }}
                </p>
            </div>
        @endif

        {{-- BUDAYA --}}
        @if($company->culture_notes)
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-5">
                <h2 class="text-sm font-semibold text-[#191C1F] mb-3">
                    Budaya Perusahaan
                </h2>

                <p class="text-sm text-[#797586] whitespace-pre-line">
                    {{ $company->culture_notes }}
                </p>
            </div>
        @endif

        {{-- BENEFIT --}}
        @if($company->benefits_notes)
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-5">
                <h2 class="text-sm font-semibold text-[#191C1F] mb-3">
                    Benefit & Gaji
                </h2>

                <p class="text-sm text-[#797586] whitespace-pre-line">
                    {{ $company->benefits_notes }}
                </p>
            </div>
        @endif

        {{-- CONTACTS --}}
        @include('companies.partials.contacts')

    </div>

</div>

@push('scripts')
<script>
function deleteModal() {
    return {
        isOpen:false,
        formAction:'',
        title:'',
        description:'',

        open(detail){
            this.formAction=detail.formAction;
            this.title=detail.title;
            this.description=detail.description;
            this.isOpen=true;
        },

        close(){
            this.isOpen=false;
        }
    }
}
</script>
@endpush

@endsection