@if ($paginator->hasPages())
<nav class="flex justify-center mt-10">
    <ul class="inline-flex items-center space-x-1 text-sm">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="px-3 py-2 text-gray-400 bg-gray-800 rounded cursor-not-allowed">
                ‹
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition">
                    ‹
                </a>
            </li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)

            {{-- Dots --}}
            @if (is_string($element))
                <li class="px-3 py-2 text-gray-400">{{ $element }}</li>
            @endif

            {{-- Page Numbers --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="px-4 py-2 bg-blue-600 text-white rounded font-semibold">
                            {{ $page }}
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}"
                               class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 transition">
                    ›
                </a>
            </li>
        @else
            <li class="px-3 py-2 text-gray-400 bg-gray-800 rounded cursor-not-allowed">
                ›
            </li>
        @endif

    </ul>
</nav>
@endif
