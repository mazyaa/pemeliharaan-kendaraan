@if ($paginator->hasPages() || true)
<div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-4 py-3 border-t border-gray-200">
    <div class="flex items-center gap-3">
        <span class="text-xs text-gray-500">Baris per halaman</span>
        <form method="GET" class="flex items-center gap-1" id="perPageForm">
            @php
                $params = request()->except('page');
            @endphp
            @foreach($params as $key => $value)
                @if(is_array($value))
                    @foreach($value as $v)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <select name="perPage" onchange="this.form.submit()" class="bg-gray-100 border border-gray-200 text-gray-800 text-xs rounded-lg px-2 py-1.5 focus:ring-emerald-500/30 focus:border-emerald-500 outline-none appearance-none cursor-pointer">
                <option class="text-black" value="5" {{ (request('perPage', 10) == 5) ? 'selected' : '' }}>5</option>
                <option class="text-black" value="10" {{ (request('perPage', 10) == 10) ? 'selected' : '' }}>10</option>
                <option class="text-black" value="25" {{ (request('perPage', 10) == 25) ? 'selected' : '' }}>25</option>
                <option class="text-black" value="50" {{ (request('perPage', 10) == 50) ? 'selected' : '' }}>50</option>
                <option class="text-black" value="100" {{ (request('perPage', 10) == 100) ? 'selected' : '' }}>100</option>
            </select>
        </form>
        <span class="text-xs text-gray-500">
            {{ $paginator->firstItem() ?? 0 }}-{{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }}
        </span>
    </div>

    <nav class="flex items-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-500 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-800 hover:bg-gray-100 hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-xs text-gray-500">...</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-emerald-500 border border-emerald-500 text-white text-xs font-bold shadow-lg shadow-emerald-500/20 ring-1 ring-emerald-400">
                            {{ $page }}
                        </a>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-800 hover:bg-gray-100 hover:scale-105 transition-all duration-200 text-xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-800 hover:bg-gray-100 hover:scale-105 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-200 text-gray-500 cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </nav>
</div>
@endif
