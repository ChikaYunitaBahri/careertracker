@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex flex-1 items-center justify-between gap-4 sm:hidden">
            {{-- Mobile: Previous --}}
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#ADADB8] bg-[#F8F9FD] rounded-lg cursor-not-allowed">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#5E3BDB] bg-white border border-[#E1E2E6] rounded-lg hover:bg-[#F8F9FD] transition-colors">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            {{-- Mobile: Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#5E3BDB] bg-white border border-[#E1E2E6] rounded-lg hover:bg-[#F8F9FD] transition-colors">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#ADADB8] bg-[#F8F9FD] rounded-lg cursor-not-allowed">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-[#ADADB8]">
                    {!! __('Showing') !!}
                    <span class="font-semibold text-[#191C1F]">{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span class="font-semibold text-[#191C1F]">{{ $paginator->lastItem() }}</span>
                    {!! __('of') !!}
                    <span class="font-semibold text-[#191C1F]">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex gap-1 rounded-lg shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#ADADB8] bg-[#F8F9FD] rounded-lg cursor-not-allowed" aria-hidden="true">
                                <i class="ri-arrow-left-s-line"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#5E3BDB] bg-white border border-[#E1E2E6] rounded-lg hover:bg-[#F8F9FD] transition-colors">
                            <i class="ri-arrow-left-s-line"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#ADADB8] bg-[#F8F9FD] rounded-lg">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-white bg-[#5E3BDB] rounded-lg">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-[#191C1F] bg-white border border-[#E1E2E6] rounded-lg hover:bg-[#F8F9FD] transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#5E3BDB] bg-white border border-[#E1E2E6] rounded-lg hover:bg-[#F8F9FD] transition-colors">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-[#ADADB8] bg-[#F8F9FD] rounded-lg cursor-not-allowed" aria-hidden="true">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
