@extends('layouts.app')

@section('content')

<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#191C1F]">
                Detail Perusahaan
            </h1>
            <p class="text-sm text-[#797586] mt-1">
                Informasi lengkap perusahaan
            </p>
        </div>
        
        <div class="flex items-center gap-2.5">
            <a href="{{ route('companies.edit', \) }}" class="flex items-center gap-1.5 bg-[#5E3BDB] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#4d31b8] transition-colors">
                <i class="ri-pencil-line"></i>
                Edit
            </a>
            <a href="{{ route('companies.index') }}" class="flex items-center gap-1.5 bg-[#F8F9FD] text-[#797586] text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#EAEBEF] transition-colors">
                <i class="ri-arrow-left-line"></i>
                Kembali
            </a>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Company Info --}}
        <div class="lg:col-span-2">

            {{-- Header Section --}}
            <div class="bg-white border border-[#E1E2E6] rounded-xl overflow-hidden">
                <div class="p-8 bg-gradient-to-r from-[#EDE9FB] to-[#F5F3FF] border-b border-[#E1E2E6]">
                    <div class="flex items-center gap-4">
                        @if(\->logo_url)
                            <img src="{{ \->logo_url }}" alt="{{ \->name }}" class="w-16 h-16 rounded-lg object-cover border border-[#E1E2E6]">
                        @else
                            <div class="w-16 h-16 rounded-lg bg-white flex items-center justify-center border border-[#E1E2E6]">
                                <i class="ri-building-line text-4xl text-[#5E3BDB]"></i>
                            </div>
                        @endif
                        
                        <div>
                            <h2 class="text-2xl font-bold text-[#191C1F]">{{ \->name }}</h2>
                            <p class="text-sm text-[#797586] mt-1">{{ \->industry ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Info Grid --}}
                <div class="p-8 grid grid-cols-2 gap-8">

                    {{-- Website --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Website</p>
                        @if(\->website)
                            <a href="{{ \->website }}" target="_blank" class="text-sm font-medium text-[#5E3BDB] hover:underline flex items-center gap-2">
                                {{ \->website }}
                                <i class="ri-external-link-line text-xs"></i>
                            </a>
                        @else
                            <p class="text-sm text-[#ADADB8]">-</p>
                        @endif
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Lokasi</p>
                        <p class="text-sm font-medium text-[#191C1F]">{{ \->location ?? '-' }}</p>
                    </div>

                    {{-- Ukuran --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Ukuran</p>
                        <p class="text-sm font-medium text-[#191C1F]">
                            @if(\->size)
                                @switch(\->size)
                                    @case('startup') Startup @break
                                    @case('small') Kecil @break
                                    @case('medium') Menengah @break
                                    @case('large') Besar @break
                                    @case('corporate') Korporat @break
                                    @default {{ \->size }}
                                @endswitch
                            @else
                                -
                            @endif
                        </p>
                    </div>

                    {{-- Rating --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Rating Pribadi</p>
                        <div class="flex items-center gap-1">
                            @if(\->personal_rating)
                                @for(\ = 1; \ <= 5; \++)
                                    <i class="text-lg {{ \ <= \->personal_rating ? 'ri-star-fill text-amber-400' : 'ri-star-line text-[#ADADB8]' }}"></i>
                                @endfor
                                <span class="text-sm font-medium text-[#191C1F] ml-2">{{ \->personal_rating }}/5</span>
                            @else
                                <p class="text-sm text-[#ADADB8]">-</p>
                            @endif
                        </div>
                    </div>

                    {{-- Ditambah --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Ditambahkan</p>
                        <p class="text-sm font-medium text-[#191C1F]">{{ \->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    {{-- Diperbarui --}}
                    <div>
                        <p class="text-xs font-medium text-[#ADADB8] uppercase tracking-wide mb-2">Diperbarui</p>
                        <p class="text-sm font-medium text-[#191C1F]">{{ \->updated_at->format('d M Y, H:i') }}</p>
                    </div>

                </div>

            </div>

            {{-- Description Section --}}
            @if(\->description)
                <div class="bg-white border border-[#E1E2E6] rounded-xl p-8 mt-6">
                    <h3 class="text-lg font-semibold text-[#191C1F] mb-4">Deskripsi</h3>
                    <p class="text-sm text-[#797586] leading-relaxed">{{ \->description }}</p>
                </div>
            @endif

            {{-- Culture Notes --}}
            @if(\->culture_notes)
                <div class="bg-white border border-[#E1E2E6] rounded-xl p-8 mt-6">
                    <h3 class="text-lg font-semibold text-[#191C1F] mb-4">Budaya Perusahaan</h3>
                    <p class="text-sm text-[#797586] leading-relaxed whitespace-pre-line">{{ \->culture_notes }}</p>
                </div>
            @endif

            {{-- Benefits Notes --}}
            @if(\->benefits_notes)
                <div class="bg-white border border-[#E1E2E6] rounded-xl p-8 mt-6">
                    <h3 class="text-lg font-semibold text-[#191C1F] mb-4">Benefit & Gaji</h3>
                    <p class="text-sm text-[#797586] leading-relaxed whitespace-pre-line">{{ \->benefits_notes }}</p>
                </div>
            @endif

        </div>

        {{-- Right Column: Statistics & Actions --}}
        <div class="lg:col-span-1">

            {{-- Statistics Card --}}
            <div class="bg-white border border-[#E1E2E6] rounded-xl p-6 mb-6">

                <h3 class="text-lg font-semibold text-[#191C1F] mb-6">Statistik</h3>

                <div class="space-y-6">

                    {{-- Total Applications --}}
                    <div class="text-center py-4">
                        <div class="w-12 h-12 rounded-xl bg-[#EDE9FB] flex items-center justify-center mx-auto mb-3">
                            <i class="ri-file-list-line text-2xl text-[#5E3BDB]"></i>
                        </div>
                        <p class="text-3xl font-bold text-[#191C1F]">{{ \->applications_count ?? 0 }}</p>
                        <p class="text-xs text-[#ADADB8] mt-1">Lamaran Terkait</p>
                    </div>

                    {{-- Total Contacts --}}
                    <div class="text-center py-4 border-t border-[#E1E2E6]">
                        <div class="w-12 h-12 rounded-xl bg-[#EDE9FB] flex items-center justify-center mx-auto mb-3">
                            <i class="ri-user-line text-2xl text-[#5E3BDB]"></i>
                        </div>
                        <p class="text-3xl font-bold text-[#191C1F]">{{ \->contacts_count ?? 0 }}</p>
                        <p class="text-xs text-[#ADADB8] mt-1">Kontak</p>
                    </div>

                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="space-y-2">
                @if(\->contacts_count > 0)
                    <a href="{{ route('companies.show', \) }}#contacts" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#5E3BDB] text-white text-sm font-medium rounded-lg hover:bg-[#4d31b8] transition-colors">
                        <i class="ri-user-line"></i>
                        Lihat Kontak
                    </a>
                @endif
                <a href="{{ route('companies.edit', \) }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#F8F9FD] text-[#5E3BDB] text-sm font-medium rounded-lg hover:bg-[#EDE9FB] transition-colors">
                    <i class="ri-pencil-line"></i>
                    Edit Informasi
                </a>
                <button type="button" @click="openDeleteModal('{{ route('companies.destroy', \) }}', '{{ \->name }}')" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-500 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors">
                    <i class="ri-delete-bin-line"></i>
                    Hapus
                </button>
            </div>

        </div>

    </div>

    {{-- Contacts Section (if any) --}}
    <div id="contacts" class="bg-white border border-[#E1E2E6] rounded-xl overflow-hidden">

        <div class="p-6 border-b border-[#E1E2E6] flex justify-between items-center">
            <h3 class="text-lg font-semibold text-[#191C1F]">Kontak Perusahaan</h3>
            <a href="{{ route('companies.contacts.create', \) }}" class="flex items-center gap-1.5 text-[#5E3BDB] font-medium hover:underline text-sm">
                <i class="ri-add-line"></i>
                Tambah Kontak
            </a>
        </div>

        @if(\->contacts->isNotEmpty())
            <div class="divide-y divide-[#E1E2E6]">
                @foreach(\->contacts as \)
                    <div class="p-6 hover:bg-[#F8F9FD] transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-medium text-[#191C1F]">{{ \->name }}</p>
                                <p class="text-sm text-[#5E3BDB]">{{ \->position ?? '-' }}</p>
                                @if(\->email)
                                    <a href="mailto:{{ \->email }}" class="text-xs text-[#797586] hover:text-[#5E3BDB] block mt-1">{{ \->email }}</a>
                                @endif
                                @if(\->phone)
                                    <a href="tel:{{ \->phone }}" class="text-xs text-[#797586] hover:text-[#5E3BDB] block mt-0.5">{{ \->phone }}</a>
                                @endif
                            </div>
                            <div class="flex gap-1 flex-shrink-0">
                                <a href="{{ route('companies.contacts.edit', [\, \]) }}" class="p-2 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors">
                                    <i class="ri-pencil-line text-sm"></i>
                                </a>
                                <button type="button" @click="openDeleteContactModal('{{ route('companies.contacts.destroy', [\, \]) }}', '{{ \->name }}')" class="p-2 text-[#797586] hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="ri-delete-bin-line text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <i class="ri-user-line text-4xl text-[#ADADB8] inline-block mb-3"></i>
                <p class="text-[#797586] font-medium">Tidak ada kontak</p>
                <p class="text-xs text-[#ADADB8] mt-1">Tambahkan kontak perusahaan untuk referensi Anda</p>
            </div>
        @endif

    </div>

</div>

{{-- Delete Modal --}}
<div
    x-data="deleteModal()"
    @open-delete-modal.window="open(\.detail)"
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
            <h3 class="text-lg font-bold text-[#191C1F]">Hapus Perusahaan?</h3>
            <p class="text-sm text-[#797586] mt-1.5">
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

<script>
    function deleteModal() {
        return {
            isOpen: false,
            formAction: '',
            companyName: '',
            
            open(data) {
                this.formAction = data.formAction;
                this.companyName = data.companyName;
                this.isOpen = true;
            },
            
            close() {
                this.isOpen = false;
            }
        };
    }

    function openDeleteModal(formAction, companyName) {
        window.dispatchEvent(new CustomEvent('open-delete-modal', {
            detail: { formAction, companyName }
        }));
    }
</script>

@endsection
