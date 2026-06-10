@extends('layouts.app')

@section('content')

<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-[#191C1F]">Perusahaan</h1>
            <p class="text-[#797586] mt-2">Kelola data perusahaan tempat Anda melamar</p>
        </div>

        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- View Switcher --}}
            <div class="flex border border-[#E1E2E6] rounded-lg overflow-hidden">
                <a href="{{ route('companies.index', array_merge(request()->except('view'), [])) }}"
                    @class([
                        'flex items-center gap-1.5 px-3 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'            => request('view') !== 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]'  => request('view') === 'list',
                    ])>
                    <i class="ri-layout-column-line text-sm"></i>
                    <span class="hidden sm:inline">Board</span>
                </a>
                <a href="{{ route('companies.index', array_merge(request()->except('view'), ['view' => 'list'])) }}"
                    @class([
                        'flex items-center gap-1.5 px-3 py-2 text-sm font-medium transition-colors',
                        'bg-[#7A5BF8] text-white'            => request('view') === 'list',
                        'text-[#797586] hover:bg-[#F8F9FD]'  => request('view') !== 'list',
                    ])>
                    <i class="ri-list-unordered text-sm"></i>
                    <span class="hidden sm:inline">List</span>
                </a>
            </div>

            <a href="{{ route('companies.create') }}"
                class="flex items-center gap-1.5 bg-[#5E3BDB] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#4d31b8] transition-colors shadow-sm">
                <i class="ri-add-line text-base"></i>
                <span class="hidden sm:inline">Tambah Perusahaan</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div x-data="filterBar()" class="space-y-2">

        <div class="flex items-center gap-2.5 flex-wrap">

            {{-- Search --}}
            <div class="relative flex-1 min-w-[180px] max-w-xs">
                <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-[#ADADB8] text-sm pointer-events-none"></i>
                <input
                    type="text"
                    x-model="search"
                    @keyup.enter="submitForm()"
                    placeholder="Cari perusahaan..."
                    class="w-full pl-8 pr-4 py-2 text-sm border border-[#E1E2E6] rounded-lg bg-white text-[#191C1F] placeholder-[#ADADB8] focus:outline-none focus:ring-2 focus:ring-[#5E3BDB]/20 focus:border-[#5E3BDB] transition-colors">
            </div>

            <div class="hidden sm:block w-px h-4 bg-[#E1E2E6] flex-shrink-0"></div>

            {{-- Filter Controls --}}
            <div class="flex items-center gap-2 flex-wrap">

                {{-- INDUSTRY DROPDOWN --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 text-sm bg-white border border-[#E1E2E6] rounded-lg text-[#484555] hover:border-[#C9C4D7] transition-colors">
                        <i class="ri-building-line"></i>
                        <span>Industri</span>
                        <span
                            x-show="activeIndustries.length"
                            x-text="activeIndustries.length"
                            class="flex items-center justify-center w-5 h-5 text-[11px] rounded-full bg-[#EDE9FB] text-[#5E3BDB]"
                            style="display:none">
                        </span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute z-20 mt-2 w-64 bg-white border border-[#E1E2E6] rounded-xl shadow-lg p-2">

                        @foreach([
                            'Technology',
                            'Finance',
                            'Startup',
                            'Enterprise',
                            'Healthcare',
                            'Education',
                            'Government',
                            'E-Commerce'
                        ] as $industry)
                            <button
                                type="button"
                                @click="toggleIndustry('{{ $industry }}')"
                                class="w-full flex items-center justify-between px-3 py-2 text-sm rounded-lg hover:bg-[#F8F9FD]">
                                <span>{{ $industry }}</span>
                                <i
                                    x-show="activeIndustries.includes('{{ $industry }}')"
                                    class="ri-check-line text-[#5E3BDB]"
                                    style="display:none">
                                </i>
                            </button>
                        @endforeach

                    </div>
                </div>

                {{-- SORT DROPDOWN --}}
                <div class="relative" x-data="{ open: false }">
                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center gap-2 px-3 py-2 text-sm bg-white border border-[#E1E2E6] rounded-lg text-[#484555] hover:border-[#C9C4D7] transition-colors">
                        <i class="ri-sort-desc"></i>
                        <span>
                            <template x-if="activeSort === 'latest'"><span>Terbaru</span></template>
                            <template x-if="activeSort === 'oldest'"><span>Terlama</span></template>
                            <template x-if="activeSort === 'name'"><span>A-Z</span></template>
                        </span>
                        <i class="ri-arrow-down-s-line"></i>
                    </button>

                    <div
                        x-show="open"
                        @click.away="open = false"
                        x-transition
                        class="absolute z-20 mt-2 w-48 bg-white border border-[#E1E2E6] rounded-xl shadow-lg p-2">
                        <button type="button" @click="setSort('latest')" class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#F8F9FD]">Terbaru</button>
                        <button type="button" @click="setSort('oldest')" class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#F8F9FD]">Terlama</button>
                        <button type="button" @click="setSort('name')"   class="w-full text-left px-3 py-2 rounded-lg hover:bg-[#F8F9FD]">A-Z</button>
                    </div>
                </div>

                {{-- RESET --}}
                <button
                    type="button"
                    x-show="hasActiveFilters"
                    @click="resetAll"
                    class="px-3 py-2 text-sm text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                    style="display:none">
                    <i class="ri-refresh-line"></i>
                    Reset
                </button>

            </div>
        </div>

        {{-- Hidden form untuk submit filter --}}
        <form id="filterForm" method="GET" action="{{ route('companies.index') }}" class="hidden">
            <input type="hidden" name="view"     :value="'{{ request('view') }}'">
            <input type="hidden" name="search"   x-bind:value="search">
            <input type="hidden" name="industry" x-bind:value="activeIndustries.join(',')">
            <input type="hidden" name="sort"     x-bind:value="activeSort">
        </form>

        {{-- Active filter summary --}}
        <div x-show="hasActiveFilters" class="flex flex-wrap gap-2" style="display:none">
            <template x-for="industry in activeIndustries" :key="industry">
                <button
                    @click="toggleIndustry(industry)"
                    class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-[#F2F3F7] text-[#484555] hover:bg-[#E7E8EC]">
                    <span x-text="industry"></span>
                    <i class="ri-close-line"></i>
                </button>
            </template>
            <span
                x-show="search"
                class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-[#F2F3F7] text-[#484555]"
                style="display:none">
                "<span x-text="search"></span>"
            </span>
        </div>

    </div>

    {{-- =============================================
         TOAST NOTIFICATION
         FIX: Struktur x-data bersih, tidak bercampur dengan modal
         ============================================= --}}
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
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-5 right-5 z-50 flex items-start gap-3 px-4 py-3.5 rounded-xl shadow-xl border max-w-sm w-full"
            :class="type === 'success' ? 'bg-white border-green-200' : 'bg-white border-red-200'">

            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center"
                :class="type === 'success' ? 'bg-green-100' : 'bg-red-100'">
                <i :class="type === 'success' ? 'ri-checkbox-circle-fill text-green-600' : 'ri-close-circle-fill text-red-600'" class="text-sm"></i>
            </div>

            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-semibold text-[#191C1F]" x-text="type === 'success' ? 'Berhasil' : 'Gagal'"></p>
                <p class="text-xs mt-0.5 text-[#797586]" x-text="message"></p>
            </div>

            <button @click="show = false" class="flex-shrink-0 p-1 rounded-lg hover:bg-gray-100 transition-colors text-[#ADADB8] hover:text-[#797586]">
                <i class="ri-close-line text-sm"></i>
            </button>
        </div>
    @endif

    {{-- DELETE MODAL --}}
    <div id="deleteModal"
        style="display:none; position:fixed; inset:0; z-index:50; align-items:center; justify-content:center; padding:1rem; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px);">

        <div style="background:white; border-radius:1rem; box-shadow:0 20px 60px rgba(0,0,0,0.15); width:100%; max-width:24rem; padding:1.5rem; position:relative;">

            <div style="width:3.5rem; height:3.5rem; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <i class="ri-delete-bin-line" style="font-size:1.5rem; color:#ef4444;"></i>
            </div>

            <div style="text-align:center; margin-bottom:1.5rem;">
                <h3 style="font-size:1.125rem; font-weight:700; color:#191C1F; margin:0 0 0.375rem;">Hapus Perusahaan?</h3>
                <p style="font-size:0.875rem; color:#797586; margin:0;">
                    <span id="deleteModalName" style="font-weight:600; color:#191C1F;"></span>
                    akan dihapus permanen dan tidak bisa dikembalikan.
                </p>
            </div>

            <div style="display:flex; gap:0.75rem;">
                <button
                    onclick="document.getElementById('deleteModal').style.display='none'"
                    style="flex:1; padding:0.625rem 1rem; font-size:0.875rem; font-weight:500; color:#797586; background:#F8F9FD; border:none; border-radius:0.75rem; cursor:pointer;">
                    Batal
                </button>
                <form id="deleteModalForm" method="POST" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteModalAction" name="_action_target">
                    <button type="submit"
                        style="width:100%; padding:0.625rem 1rem; font-size:0.875rem; font-weight:500; color:white; background:#ef4444; border:none; border-radius:0.75rem; cursor:pointer;">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===================== LIST VIEW ===================== --}}
    @if($viewMode === 'list')

        <div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden shadow-sm">

            @if($companies->isNotEmpty())
                <div class="grid grid-cols-[auto_1fr_160px_120px_100px] items-center gap-4 px-5 py-3 bg-[#F8F9FD] border-b border-[#EAEBEF]">
                    <div class="w-9"></div>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wider">Perusahaan</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wider hidden md:block">Lokasi</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wider hidden sm:block">Ditambahkan</span>
                    <span class="text-[11px] font-semibold text-[#ADADB8] uppercase tracking-wider text-right">Aksi</span>
                </div>
            @endif

            @forelse($companies as $company)
                <div class="grid grid-cols-[auto_1fr_160px_120px_100px] items-center gap-4 px-5 py-3.5 border-b border-[#F0F1F5] last:border-0 hover:bg-[#FAFBFF] transition-colors group">

                    {{-- Logo --}}
                    <div class="flex-shrink-0">
                        @if($company->logo_url)
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-9 h-9 rounded-lg object-cover border border-[#E1E2E6]">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-[#EDE9FB] to-[#DDD5FB] flex items-center justify-center">
                                <i class="ri-building-2-line text-[#5E3BDB] text-sm"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Nama & Industri --}}
                    <div class="min-w-0">
                        <a href="{{ route('companies.show', $company) }}" class="font-semibold text-[#191C1F] truncate hover:text-[#5E3BDB] transition-colors block">
                            {{ $company->name }}
                        </a>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            @if($company->industry)
                                <span class="inline-flex items-center text-[10px] font-medium bg-[#F2F3F7] text-[#484555] px-2 py-0.5 rounded-full">
                                    {{ $company->industry }}
                                </span>
                            @endif
                            @if($company->personal_rating)
                                <span class="inline-flex items-center gap-0.5 text-[10px] text-amber-600">
                                    <i class="ri-star-fill text-amber-400 text-xs"></i>
                                    {{ $company->personal_rating }}/5
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    <div class="text-sm text-[#797586] hidden md:flex items-center gap-1.5 truncate">
                        @if($company->location)
                            <i class="ri-map-pin-2-line text-[#ADADB8] text-xs flex-shrink-0"></i>
                            <span class="truncate">{{ $company->location }}</span>
                        @else
                            <span class="text-[#ADADB8]">—</span>
                        @endif
                    </div>

                    {{-- Tanggal --}}
                    <div class="text-xs text-[#ADADB8] hidden sm:block">
                        {{ $company->created_at->format('d M Y') }}
                    </div>

                    {{-- Aksi --}}
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('companies.show', $company) }}"
                            class="p-1.5 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors"
                            title="Lihat Detail">
                            <i class="ri-eye-line text-sm"></i>
                        </a>
                        <a href="{{ route('companies.edit', $company) }}"
                            class="p-1.5 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors"
                            title="Edit">
                            <i class="ri-pencil-line text-sm"></i>
                        </a>
                        <button
                            type="button"
                            onclick="openDeleteModal('{{ route('companies.destroy', $company) }}', '{{ addslashes($company->name) }}')"
                            class="p-1.5 text-[#797586] hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                            title="Hapus">
                            <i class="ri-delete-bin-line text-sm"></i>
                        </button>
                    </div>

                </div>
            @empty
                <div class="px-4 py-16 text-center">
                    <div class="w-16 h-16 bg-[#F8F9FD] rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ri-building-line text-3xl text-[#ADADB8]"></i>
                    </div>
                    <p class="text-[#191C1F] font-semibold">Belum ada perusahaan</p>
                    <p class="text-sm text-[#ADADB8] mt-1">Mulai dengan menambahkan perusahaan baru</p>
                    <a href="{{ route('companies.create') }}"
                        class="inline-flex items-center gap-1.5 mt-4 bg-[#5E3BDB] text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-[#4d31b8] transition-colors">
                        <i class="ri-add-line"></i> Tambah Perusahaan
                    </a>
                </div>
            @endforelse

        </div>

        @if($companies->hasPages())
            <div class="mt-4">{{ $companies->links() }}</div>
        @endif

    {{-- ===================== BOARD VIEW ===================== --}}
    @else

        @if($companies->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
                @foreach($companies as $company)
                    <div class="group bg-white border border-[#E1E2E6] rounded-xl overflow-hidden hover:border-[#5E3BDB] hover:shadow-md transition-all duration-200">

                        {{-- Card Top --}}
                        <div class="px-4 pt-4 pb-3 flex items-start justify-between gap-2">
                            <div class="flex items-center gap-3">
                                @if($company->logo_url)
                                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" class="w-10 h-10 rounded-lg object-cover border border-[#E1E2E6] flex-shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-[#EDE9FB] to-[#DDD5FB] flex items-center justify-center flex-shrink-0">
                                        <i class="ri-building-2-line text-[#5E3BDB]"></i>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-[#191C1F] truncate text-sm leading-tight">{{ $company->name }}</h3>
                                    @if($company->industry)
                                        <span class="text-[10px] font-medium text-[#5E3BDB] bg-[#EDE9FB] px-1.5 py-0.5 rounded-full inline-block mt-0.5">
                                            {{ $company->industry }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Action icons (visible on hover) --}}
                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                                <a href="{{ route('companies.edit', $company) }}"
                                    class="p-1.5 text-[#797586] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] rounded-lg transition-colors"
                                    title="Edit">
                                    <i class="ri-pencil-line text-sm"></i>
                                </a>
                                <button
                                    type="button"
                                    onclick="openDeleteModal('{{ route('companies.destroy', $company) }}', '{{ addslashes($company->name) }}')"
                                    class="p-1.5 text-[#797586] hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                    title="Hapus">
                                    <i class="ri-delete-bin-line text-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="mx-4 border-t border-[#F0F1F5]"></div>

                        {{-- Card Body --}}
                        <div class="px-4 py-3 space-y-2">
                            @if($company->location)
                                <div class="flex items-center gap-2 text-xs text-[#797586]">
                                    <i class="ri-map-pin-2-line text-[#ADADB8] flex-shrink-0"></i>
                                    <span class="truncate">{{ $company->location }}</span>
                                </div>
                            @endif

                            @if($company->website)
                                <div class="flex items-center gap-2 text-xs">
                                    <i class="ri-links-line text-[#ADADB8] flex-shrink-0"></i>
                                    <a href="{{ $company->website }}" target="_blank" rel="noopener"
                                        class="text-[#5E3BDB] hover:underline truncate">
                                        {{ parse_url($company->website, PHP_URL_HOST) ?? $company->website }}
                                    </a>
                                </div>
                            @endif

                            @if($company->personal_rating)
                                <div class="flex items-center gap-1.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $company->personal_rating ? 'ri-star-fill text-amber-400' : 'ri-star-line text-[#E1E2E6]' }} text-sm"></i>
                                    @endfor
                                    <span class="text-xs text-[#797586] ml-0.5">{{ $company->personal_rating }}/5</span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Footer --}}
                        <div class="px-4 py-3 border-t border-[#F0F1F5] flex items-center justify-between">
                            <span class="text-[11px] text-[#ADADB8]">{{ $company->created_at->format('d M Y') }}</span>
                            <a href="{{ route('companies.show', $company) }}"
                                class="inline-flex items-center gap-1 text-xs font-medium text-[#5E3BDB] hover:text-white hover:bg-[#5E3BDB] bg-[#EDE9FB] px-3 py-1.5 rounded-lg transition-colors">
                                <i class="ri-eye-line text-xs"></i>
                                Lihat Detail
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            @if($companies->hasPages())
                <div class="mt-4">{{ $companies->links() }}</div>
            @endif

        @else
            <div class="bg-white border border-[#EAEBEF] rounded-xl py-20 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-[#EDE9FB] to-[#F5F3FF] rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i class="ri-building-line text-4xl text-[#5E3BDB]"></i>
                </div>
                <p class="text-[#191C1F] font-semibold text-lg">Belum ada perusahaan</p>
                <p class="text-sm text-[#ADADB8] mt-1">Mulai tambahkan perusahaan yang ingin Anda lamar</p>
                <a href="{{ route('companies.create') }}"
                    class="inline-flex items-center gap-1.5 mt-5 bg-[#5E3BDB] text-white text-sm font-medium px-5 py-2.5 rounded-xl hover:bg-[#4d31b8] transition-colors shadow-sm">
                    <i class="ri-add-line"></i> Tambah Perusahaan
                </a>
            </div>
        @endif

    @endif

</div>

{{-- =================================================
     SCRIPTS
     ================================================= --}}
<script>
    function filterBar() {
        return {
            search: @js(request('search', '')),
            activeIndustries: @js(array_filter(explode(',', request('industry', '')))),
            activeSort: @js(request('sort', 'latest')),

            get hasActiveFilters() {
                return this.search.trim() !== ''
                    || this.activeIndustries.length > 0
                    || this.activeSort !== 'latest';
            },

            toggleIndustry(industry) {
                const idx = this.activeIndustries.indexOf(industry);
                idx > -1
                    ? this.activeIndustries.splice(idx, 1)
                    : this.activeIndustries.push(industry);
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
                const form = document.getElementById('filterForm');
                form.querySelector('[name="search"]').value   = this.search;
                form.querySelector('[name="industry"]').value = this.activeIndustries.join(',');
                form.querySelector('[name="sort"]').value     = this.activeSort;
                form.submit();
            }
        };
    }

    window.openDeleteModal = function(action, name) {
        document.getElementById('deleteModalForm').action = action;
        document.getElementById('deleteModalName').textContent = name;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) this.style.display = 'none';
    });
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

@endsection