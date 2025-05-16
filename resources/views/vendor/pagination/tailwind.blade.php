@if ($paginator->hasPages())
    <nav class="flex justify-center my-8" aria-label="Pagination">
        <ul class="flex items-center gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span
                        class="flex items-center px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="flex items-center px-3 py-2 text-sm text-gray-700 bg-white rounded-lg
                               hover:bg-gray-100 hover:text-gray-900
                               focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
                               transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span
                            class="flex items-center justify-center w-10 h-10 text-sm text-gray-400
                                   bg-gray-200 rounded-lg cursor-not-allowed">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span
                                    class="flex items-center justify-center w-10 h-10 text-sm font-medium
                                           text-white bg-gray-800 rounded-lg shadow-sm transform scale-105 transition-transform duration-200">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="flex items-center justify-center w-10 h-10 text-sm text-gray-700
                                           bg-white rounded-lg
                                           hover:bg-gray-100 hover:text-gray-900
                                           focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
                                           transition-all duration-200 hover:scale-105">
                                    {{ $page }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="flex items-center px-3 py-2 text-sm text-gray-700 bg-white rounded-lg
                               hover:bg-gray-100 hover:text-gray-900
                               focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2
                               transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            @else
                <li>
                    <span
                        class="flex items-center px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
