@if ($paginator->hasPages())
<div class="flex items-center justify-between py-3">
    {{-- Info --}}
    <div class="text-sm text-gray-500">
        Showing
        <span class="font-medium text-gray-700">{{ $paginator->firstItem() }}</span>
        to
        <span class="font-medium text-gray-700">{{ $paginator->lastItem() }}</span>
        of
        <span class="font-medium text-gray-700">{{ $paginator->total() }}</span>
        results
    </div>

    {{-- Pagination --}}
    <nav class="inline-flex items-center rounded-lg border border-gray-200 overflow-hidden shadow-sm">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span
                class="px-3 py-2 text-gray-400 bg-gray-50 cursor-not-allowed">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 bg-white text-gray-600 hover:bg-gray-100">
                ‹
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="px-4 py-2 text-white bg-indigo-600 font-semibold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 bg-white text-gray-600 hover:bg-gray-100">
                ›
            </a>
        @else
            <span
                class="px-3 py-2 text-gray-400 bg-gray-50 cursor-not-allowed">
                ›
            </span>
        @endif
    </nav>
</div>
@endif
