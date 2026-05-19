@props(['item'])
@php
    $activeRoutes = $item['activeRoutes'] ?? (isset($item['route']) ? [$item['route']] : []);
    $isActive     = !empty($activeRoutes) && request()->routeIs($activeRoutes);
@endphp

<a href="{{ $item['url'] ?? '#' }}"
   class="group relative flex items-center gap-2.5 rounded-lg px-2.5 py-[9px] mb-px text-[13px] font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40
          {{ $isActive ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-blue-50 hover:text-blue-700' }}"
   @if($isActive) aria-current="page" @endif>

    @if($isActive)
        <span class="absolute left-0 top-1/2 -translate-y-1/2 h-5 w-[3px] rounded-r-full bg-blue-600" aria-hidden="true"></span>
    @endif

    <i class="ti {{ $item['icon'] }} flex-shrink-0 text-lg leading-none
               {{ $isActive ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-500' }}" aria-hidden="true"></i>

    <span class="flex-1 whitespace-nowrap transition-all duration-200" :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
        {{ $item['label'] }}
    </span>

    @if(!empty($item['badge']))
        <span class="flex-shrink-0 rounded-full bg-blue-100 px-1.5 py-px text-[10px] font-semibold text-blue-700 transition-all duration-200"
              :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'"
              aria-label="{{ $item['badge'] }} notifikasi">
            {{ $item['badge'] }}
        </span>
    @endif

    {{-- Tooltip (collapsed) --}}
    <span class="pointer-events-none absolute left-full ml-2 z-50 whitespace-nowrap rounded-md bg-[#1e3a5f] px-2.5 py-1 text-xs font-medium text-white opacity-0 group-hover:opacity-100 transition-opacity duration-150"
          :class="collapsed ? 'block' : 'hidden'" role="tooltip">
        {{ $item['label'] }}
        @if(!empty($item['badge']))
            <span class="ml-1 rounded-full bg-blue-500/40 px-1.5 text-blue-200">{{ $item['badge'] }}</span>
        @endif
    </span>
</a>
