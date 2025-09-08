@if ($paginator->hasPages())
    <nav class="mt-3" aria-label="Pagination Navigation">
        <ul class="pagination pagination-sm justify-content-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link rounded-pill">&lsaquo;</span>
                </li>
            @else
                <li class="page-item" aria-label="@lang('pagination.previous')">
                    <a class="page-link rounded-pill" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link rounded-pill">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link rounded-pill">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded-pill" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" aria-label="@lang('pagination.next')">
                    <a class="page-link rounded-pill" href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link rounded-pill">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
