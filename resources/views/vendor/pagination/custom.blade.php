@if ($paginator->hasPages())
    <nav class="flex justify-center mt-6 select-none">
        <ul class="flex space-x-1">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 bg-gray-700 text-gray-400 rounded-lg cursor-not-allowed">‹</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-600">‹</a>
                </li>
            @endif


            {{-- Page Number Short Style --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $start = max(1, $current - 1);
                $end = min($last, $current + 1);
            @endphp

            {{-- Always show 1 --}}
            @if ($start > 1)
                <li><a href="{{ $paginator->url(1) }}"
                        class="px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-600">1</a></li>
            @endif

            {{-- Ellipsis left --}}
            @if ($start > 2)
                <li><span class="px-3 py-2 bg-gray-800 text-gray-400 rounded-lg">...</span></li>
            @endif

            {{-- Middle pages --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <li><span class="px-3 py-2 bg-purple-600 text-white rounded-lg">{{ $page }}</span></li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}"
                            class="px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-600">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Ellipsis right --}}
            @if ($end < $last - 1)
                <li><span class="px-3 py-2 bg-gray-800 text-gray-400 rounded-lg">...</span></li>
            @endif

            {{-- Always show last page --}}
            @if ($end < $last)
                <li>
                    <a href="{{ $paginator->url($last) }}"
                        class="px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-600">
                        {{ $last }}
                    </a>
                </li>
            @endif


            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-600">›</a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 bg-gray-700 text-gray-400 rounded-lg cursor-not-allowed">›</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
