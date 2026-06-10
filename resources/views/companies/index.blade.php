@extends('layouts.app')

@section('content')

<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#191C1F]">
                Perusahaan
            </h1>
            <p class="text-sm text-[#797586] mt-1">
                Kelola data perusahaan tempat Anda melamar
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-shrink-0">

            {{-- View Switcher: Board / List --}}
            <div class="flex border border-[#E1E2E6] rounded-lg overflow-hidden">
                <a href="{{ route('companies.index') }}"
                    @class([
                        'flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'           => request('view') !== 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]' => request('view') === 'list',
                    ])>
                    <i class="ri-layout-column-line text-sm"></i>
                    Board
                </a>
                <a href="{{ route('companies.index', ['view' => 'list']) }}"
                    @class([
                        'flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'           => request('view') === 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]' => request('view') !== 'list',
                    ])>
                    <i class="ri-list-unordered text-sm"></i>
                    List
                </a>
            </div>

            {{-- Tambah Perusahaan --}}
            <a href="{{ route('companies.create') }}"
                class="flex items-center gap-1.5 bg-[#5E3BDB] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#4d31b8] transition-colors">
                <i class="ri-add-line text-base"></i>
                Tambah Perusahaan
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
                    placeholder="Cari nama perusahaan..."
                    class="w-full pl-8 pr-4 py-2 text-sm border border-[#E1E2E6] rounded-lg bg-white text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/15 focus:border-[#5E3BDB] transition-colors">
            </div>

            {{-- Divider --}}
            <div class="hidden sm:block w-px h-5 bg-[#E1E2E6] flex-shrink-0"></div>

            {{-- Filter Industri --}}
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-medium text-[#ADADB8] flex-shrink-0">Industri</span>
                <div class="flex items-center gap-1.5 flex-wrap">
                    @foreach(['Technology' => 'Technology', 'Finance' => 'Finance', 'Startup' => 'Startup', 'Enterprise' => 'Enterprise'] as  => )
                        <button
                            type="button"
                            @click="toggleIndustry('{{ \ }}')"
                            :class="activeIndustries.includes('{{ \ }}')
                                ? 'bg-[#5E3BDB] border-[#5E3BDB] text-white'
                                : 'bg-white border-[#E1E2E6] text-[#797586] hover:border-[#b8a8f5] hover:text-[#5E3BDB] hover:bg-[#f5f3ff]'"
                            class="flex items-center gap-1 px-2.5 py-1 text-xs font-medium border rounded-full transition-all duration-150 cursor-pointer">
                            {{ \ }}
                            <i x-show="activeIndustries.includes('{{ \ }}')" class="ri-close-line text-xs leading-none" style="display:none"></i>
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
                    @foreach(['latest' => 'Terbaru', 'oldest' => 'Terlama', 'name' => 'AZ'] as  => )
                        <button
                            type="button"
                            @click="setSort('{{ \ }}')"
                            :class="activeSort === '{{ \ }}'
                                ? 'bg-[#5E3BDB] border-[#5E3BDB] text-white'
                                : 'bg-white border-[#E1E2E6] text-[#797586] hover:border-[#b8a8f5] hover:text-[#5E3BDB] hover:bg-[#f5f3ff]'"
                            class="px-2.5 py-1 text-xs font-medium border rounded-full transition-all duration-150 cursor-pointer">
                            {{ \ }}
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

        {{-- Hidden form untuk submit filter ke server --}}
        <form id="filterForm" method="GET" action="{{ route('companies.index') }}" class="hidden">
            <input type="hidden" name="view" value="{{ request('view') }}">
            <input type="hidden" name="search" x-bind:value="search">
            <input type="hidden" name="industry" x-bind:value="activeIndustries.join(',')">
            <input type="hidden" name="sort" x-bind:value="activeSort">
        </form>

    </div>

    {{-- Toast Notification --}}
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

    {{-- LIST VIEW --}}
    @if(\ === 'list')

        <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

            {{-- Table Header --}}
            @if(\->isNotEmpty())
                <div class="grid grid-cols-[auto_1fr_150px_120px_80px] items-center gap-4 px-4 py-2.5 bg-[#F8F9FD] border-b border-[#EAEBEF]">
                    <div class="w-8"></div>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide">Nama & Industri</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide hidden md:block">Lokasi</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide hidden sm:block">Ditambah</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wide">Aksi</span>
                </div>
            @endif

            @forelse(\ as \)
                <div class="grid grid-cols-[auto_1fr_150px_120px_80px] items-center gap-4 px-4 py-3 border-t border-[#EAEBEF] hover:bg-[#F8F9FD] transition-colors">
                    
                    {{-- Logo --}}
                    <div class="flex-shrink-0">
                        @if(\->logo_url)
                            <img src="{{ \->logo_url }}" alt="{{ \->name }}" class="w-8 h-8 rounded-lg object-cover">
                        @else
                            <div class="w-8 h-8 rounded-lg bg-[#EDE9FB] flex items-center justify-center">
                                <i class="ri-building-line text-[#5E3BDB] text-sm"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Nama & Industri --}}
                    <div class="min-w-0">
                        <div class="font-medium text-[#191C1F] truncate">{{ \->name }}</div>
                        <div class="text-xs text-[#797586] truncate">{{ \->industry ?? '-' }}</div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="text-sm text-[#797586] hidden md:block truncate">
                        {{ \->location ?? '-' }}
                    </div>

                    {{-- Tanggal Ditambah --}}
                    <div class="text-sm text-[#797586] hidden sm:block">
                        {{ \->created_at->format('d M Y') }}
                    </div>

                    {{-- Aksi --}}
                    <div class="flex items-center justify-end gap-1 flex-shrink-0">
                        <a href="{{ route('companies.show', \) }}" class="p-2 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors" title="Lihat">
                            <i class="ri-eye-line text-sm"></i>
                        </a>
                        <a href="{{ route('companies.edit', \) }}" class="p-2 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors" title="Edit">
                            <i class="ri-pencil-line text-sm"></i>
                        </a>
                        <button type="button" @click="openDeleteModal('{{ route('companies.destroy', \) }}', '{{ \->name }}')" class="p-2 text-[#797586] hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                            <i class="ri-delete-bin-line text-sm"></i>
                        </button>
                    </div>

                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <div class="mb-3">
                        <i class="ri-building-line text-5xl text-[#ADADB8]"></i>
                    </div>
                    <p class="text-[#797586] font-medium">Tidak ada data perusahaan</p>
                    <p class="text-xs text-[#ADADB8] mt-1">Mulai dengan menambahkan perusahaan baru</p>
                </div>
            @endforelse

        </div>

    {{-- BOARD VIEW --}}
    @else

        @if(\->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
                @foreach(\ as \)
                    <div class="group bg-white border border-[#E1E2E6] rounded-xl overflow-hidden hover:border-[#5E3BDB] hover:shadow-lg transition-all duration-300">

                        {{-- Card Header --}}
                        <div class="p-4 bg-gradient-to-r from-[#EDE9FB] to-[#F5F3FF] border-b border-[#E1E2E6] relative">
                            @if(\->logo_url)
                                <img src="{{ \->logo_url }}" alt="{{ \->name }}" class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center border border-[#E1E2E6]">
                                    <i class="ri-building-line text-2xl text-[#5E3BDB]"></i>
                                </div>
                            @endif
                            
                            {{-- Action Menu --}}
                            <div class="absolute top-4 right-4 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('companies.edit', \) }}" class="p-2 bg-white text-[#5E3BDB] hover:bg-[#5E3BDB] hover:text-white rounded-lg shadow-sm transition-colors" title="Edit">
                                    <i class="ri-pencil-line text-sm"></i>
                                </a>
                                <button type="button" @click="openDeleteModal('{{ route('companies.destroy', \) }}', '{{ \->name }}')" class="p-2 bg-white text-red-500 hover:bg-red-500 hover:text-white rounded-lg shadow-sm transition-colors" title="Hapus">
                                    <i class="ri-delete-bin-line text-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-[#191C1F] truncate mb-1">{{ \->name }}</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-start gap-2">
                                    <i class="ri-building-line text-[#5E3BDB] text-sm flex-shrink-0 mt-0.5"></i>
                                    <span class="text-xs text-[#797586]">{{ \->industry ?? '-' }}</span>
                                </div>
                                
                                @if(\->website)
                                    <div class="flex items-start gap-2">
                                        <i class="ri-links-line text-[#5E3BDB] text-sm flex-shrink-0 mt-0.5"></i>
                                        <a href="{{ \->website }}" target="_blank" class="text-xs text-[#5E3BDB] hover:underline truncate">{{ \->website }}</a>
                                    </div>
                                @endif
                                
                                @if(\->location)
                                    <div class="flex items-start gap-2">
                                        <i class="ri-map-pin-line text-[#5E3BDB] text-sm flex-shrink-0 mt-0.5"></i>
                                        <span class="text-xs text-[#797586]">{{ \->location }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Footer --}}
                            <div class="pt-3 border-t border-[#E1E2E6] flex items-center justify-between">
                                <span class="text-xs text-[#ADADB8]">{{ \->created_at->format('d M Y') }}</span>
                                <a href="{{ route('companies.show', \) }}" class="px-2.5 py-1 text-xs font-medium text-[#5E3BDB] bg-[#EDE9FB] hover:bg-[#5E3BDB] hover:text-white rounded-lg transition-colors">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-[#EAEBEF] rounded-xl p-12 text-center">
                <div class="mb-4">
                    <i class="ri-building-line text-6xl text-[#ADADB8] inline-block"></i>
                </div>
                <p class="text-[#797586] font-medium text-lg">Tidak ada data perusahaan</p>
                <p class="text-sm text-[#ADADB8] mt-1">Mulai dengan menambahkan perusahaan baru</p>
            </div>
        @endif

    @endif

</div>

<script>
    function filterBar() {
        return {
            search: '{{ request('search') }}',
            activeIndustries: '{{ request('industry') }}'.split(',').filter(x => x),
            activeSort: '{{ request('sort', 'latest') }}',
            
            get hasActiveFilters() {
                return this.search || this.activeIndustries.length > 0 || this.activeSort !== 'latest';
            },
            
            get hasActiveFilterTags() {
                return this.search || this.activeIndustries.length > 0 || this.activeSort !== 'latest';
            },
            
            get filterCountText() {
                const count = this.activeIndustries.length + (this.search ? 1 : 0) + (this.activeSort !== 'latest' ? 1 : 0);
                return count > 0 ? \Filter aktif: \\ : '';
            },
            
            toggleIndustry(industry) {
                const index = this.activeIndustries.indexOf(industry);
                if (index > -1) {
                    this.activeIndustries.splice(index, 1);
                } else {
                    this.activeIndustries.push(industry);
                }
                this.submitForm();
            },
            
            setSort(sort) {
                this.activeSort = sort;
                this.submitForm();
            },
            
            resetAll() {
                this.search = '';
                this.activeIndustries = [];
                this.activeSort = 'latest';
                this.submitForm();
            },
            
            submitForm() {
                document.getElementById('filterForm').submit();
            }
        };
    }

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
