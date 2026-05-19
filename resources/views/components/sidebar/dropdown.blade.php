{{-- x-sidebar.dropdown — Light Theme --}}
@props(['item'])
@php
    $childRoutes = collect($item['children'] ?? [])->flatMap(function($child) {
        return $child['activeRoutes'] ?? (isset($child['route']) ? [$child['route']] : []);
    })->filter()->all();

    $isAnyChildActive = !empty($childRoutes) && request()->routeIs($childRoutes);
@endphp

<div x-data="{ open: {{ $isAnyChildActive ? 'true' : 'false' }} }" class="mb-px">
    <button @click="open = !open"
        class="group relative flex w-full items-center gap-2.5 rounded-lg px-2.5 py-[9px] text-[13px] font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40
               {{ $isAnyChildActive ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-700' }}"
        :aria-expanded="open">

        @if($isAnyChildActive)
            <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] rounded-r-full bg-blue-600" aria-hidden="true"></span>
        @endif

        <i class="ti {{ $item['icon'] }} flex-shrink-0 text-lg leading-none
                   {{ $isAnyChildActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }}" aria-hidden="true"></i>

        <span class="flex-1 whitespace-nowrap text-left transition-all duration-200"
              :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
            {{ $item['label'] }}
        </span>

        <i class="ti ti-chevron-down flex-shrink-0 text-xs text-slate-300 transition-all duration-200"
           :class="[ open ? 'rotate-180' : '', collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100' ]"
           aria-hidden="true"></i>

        <span class="pointer-events-none absolute left-full ml-2 z-50 whitespace-nowrap rounded-md bg-[#1e3a5f] px-2.5 py-1 text-xs font-medium text-white opacity-0 group-hover:opacity-100 transition-opacity duration-150"
              :class="collapsed ? 'block' : 'hidden'" role="tooltip">
            {{ $item['label'] }}
        </span>
    </button>

    <div x-show="open && !collapsed" x-collapse class="overflow-hidden">
        <div class="ml-4 mt-0.5 border-l border-slate-200 pl-3 pb-1">
            @foreach($item['children'] as $child)
                @php
                    $childActiveRoutes = $child['activeRoutes'] ?? (isset($child['route']) ? [$child['route']] : []);
                    $childActive       = !empty($childActiveRoutes) && request()->routeIs($childActiveRoutes);
                @endphp
                <a href="{{ $child['url'] ?? '#' }}"
                   class="flex items-center gap-2 rounded-md px-2.5 py-2 mb-px text-[12px] font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40
                          {{ $childActive ? 'text-blue-600' : 'text-slate-400 hover:text-blue-600 hover:bg-blue-50' }}"
                   @if($childActive) aria-current="page" @endif>
                    <span class="h-1.5 w-1.5 flex-shrink-0 rounded-full {{ $childActive ? 'bg-blue-500' : 'bg-slate-300' }}" aria-hidden="true"></span>
                    {{ $child['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>