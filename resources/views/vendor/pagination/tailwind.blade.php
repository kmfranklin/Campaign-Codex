@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="mt-10">
        <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">

            {{-- Info --}}
            <div class="text-sm text-gray-600">
                @if ($paginator->firstItem())
                    Showing <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                    to <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                    of <span class="font-semibold">{{ $paginator->total() }}</span> items
                @else
                    Showing <span class="font-semibold">{{ $paginator->count() }}</span> items
                @endif
            </div>

            {{-- Pagination Buttons --}}
            <ul class="inline-flex space-x-1 text-sm font-medium">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed">&laquo;</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-2 text-green-800 bg-white border border-green-700 rounded-md hover:bg-green-100 transition">&laquo;</a>
                    </li>
                @endif

                {{-- Page Numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="px-3 py-2 text-gray-500 bg-white border border-gray-300 rounded-md">{{ $element }}</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span class="px-3 py-2 text-white bg-green-800 border border-green-800 rounded-md">{{ $page }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}" class="px-3 py-2 text-green-800 bg-white border border-green-700 rounded-md hover:bg-green-100 transition">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-2 text-green-800 bg-white border border-green-700 rounded-md hover:bg-green-100 transition">&raquo;</a>
                    </li>
                @else
                    <li>
                        <span class="px-3 py-2 text-gray-400 bg-white border border-gray-300 rounded-md cursor-not-allowed">&raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
