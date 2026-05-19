@props(['title' => 'Dashboard'])

<header class="flex h-[62px] flex-shrink-0 items-center gap-4 border-b border-slate-200 bg-white px-6">
    <button @click="toggle()"
        class="flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-150 lg:hidden focus:outline-none focus:ring-2 focus:ring-blue-400/40"
        aria-label="Buka menu navigasi">
        <i class="ti ti-menu-2 text-xl" aria-hidden="true"></i>
    </button>

    {{-- <div class="flex items-center gap-1.5 text-[12px] text-slate-400">
        @if($title !== 'Dashboard')
            <i class="ti text-[10px]" aria-hidden="true"></i>
            <span class="text-blue-600 font-medium">{{ $title }}</span>
        @endif
    </div> --}}

    <div class="flex-1"></div>

    @if(isset($actions))
        <div class="flex items-center gap-2">{{ $actions }}</div>
    @endif

    {{-- <button class="flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40" aria-label="Cari">
        <i class="ti ti-search text-[14px]" aria-hidden="true"></i>
    </button> --}}

    {{-- <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="relative flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-slate-50 border border-slate-200 text-slate-500 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
            :aria-expanded="open" aria-label="Notifikasi">
            <i class="ti ti-bell text-[14px]" aria-hidden="true"></i>
            <span class="absolute right-1.5 top-1.5 h-1.5 w-1.5 rounded-full bg-blue-500" aria-label="Ada notifikasi baru"></span>
        </button>
    </div> --}}

    @php
        $topbarUser     = auth()->user();
        $topbarInitials = collect(explode(' ', $topbarUser->name ?? 'User'))
                            ->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');
    @endphp
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open"
            class="flex items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-blue-50 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
            :aria-expanded="open" aria-haspopup="true">
            <div class="flex h-[30px] w-[30px] flex-shrink-0 items-center justify-center rounded-full bg-[#1e3a5f] text-[11px] font-semibold text-blue-200 border-2 border-blue-100">
                {{ $topbarInitials }}
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-[12.5px] font-medium text-slate-800 leading-tight">{{ $topbarUser->name ?? 'Pengguna' }}</p>
                <p class="text-[11px] text-slate-400">{{ $topbarUser->roles?->first()?->name ?? 'Administrator' }}</p>
            </div>
            <i class="ti ti-chevron-down hidden sm:block text-xs text-slate-300 transition-transform duration-150"
               :class="open ? 'rotate-180' : ''" aria-hidden="true"></i>
        </button>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 scale-95"
             @click.outside="open = false"
             class="absolute right-0 top-full mt-1 w-48 rounded-xl bg-white border border-slate-200 shadow-lg shadow-slate-200/60 py-1 z-50"
             role="menu">
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2.5 px-3 py-2 text-[13px] text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-colors"
               role="menuitem">
                <i class="ti ti-user-circle text-blue-400" aria-hidden="true"></i> Profil Saya
            </a>
            <div class="my-1 mx-2 h-px bg-slate-100" role="separator"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex w-full items-center gap-2.5 px-3 py-2 text-[13px] text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors"
                        role="menuitem">
                    <i class="ti ti-logout" aria-hidden="true"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</header>
