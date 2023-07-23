@if($paginator->hasPages())
    <div
        class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
        <span class="flex items-center col-span-3">
            {!! __('Showing') !!}
            @if($paginator->firstItem())
                {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }}
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!} {{ $paginator->total() }} {!! __('results') !!}
        </span>
        <span class="col-span-2"></span>
        <!-- Pagination -->
        <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
            <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">
                <ul class="inline-flex items-center">
                    <li>
                        {{-- Previous Page Link --}}
                        @if($paginator->onFirstPage())
                            <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                <button
                                    class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Previous">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </span>
                        @else
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                aria-label="{{ __('pagination.previous') }}">
                                <button
                                    class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Previous">
                                    <svg aria-hidden="true" class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </a>
                        @endif
                    </li>

                    {{-- Pagination Elements --}}
                    @foreach($elements as $element)
                        <li>
                            {{-- "Three Dots" Separator --}}
                            @if(is_string($element))
                                <span aria-disabled="true">
                                    <span class="px-3 py-1">{{ $element }}</span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if(is_array($element))
                                @foreach($element as $page => $url)

                                    @if($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <button
                                                class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">
                                                {{ $page }}
                                            </button>

                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                            <button
                                                class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">
                                                {{ $page }}
                                            </button>
                                        </a>
                                    @endif

                                @endforeach
                            @endif
                        </li>
                    @endforeach
                    <li>
                        {{-- Next Page Link --}}
                        @if($paginator->hasMorePages())
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                                aria-label="{{ __('pagination.next') }}">
                                <button
                                    class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Next">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                        <path
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </a>
                        @else
                            <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                <button
                                    class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                                    aria-label="Next">
                                    <svg class="w-4 h-4 fill-current" aria-hidden="true" viewBox="0 0 20 20">
                                        <path
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" fill-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </li>
                </ul>
            </nav>
        </span>
    </div>
@endif
