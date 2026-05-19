{{-- x-sidebar — Light Theme (putih dominan, aksen biru tua) --}}
@props(['navItems' => []])

@php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

$defaultNavItems = [
    ['label' => 'Menu', 'items' => array_values(array_filter([
        $user->can('dashboard.view') ? ['label' => 'Dashboard', 'icon' => 'ti-layout-dashboard', 'route' => 'dashboard', 'url' => route('dashboard')] : null,
    ]))],
    ['label' => 'Manajemen User', 'items' => [
        $user->canAny(['users.view', 'roles.view','permissions.view']) ? [
            'label'    => 'Manage User',
            'icon'     => 'ti-users',
            'children' => array_values(array_filter([
                $user->can('users.view') ? [
                'label'        => 'Daftar Pengguna',
                'route'        => 'users.index',
                'url'          => route('users.index'),
                'activeRoutes' => ['users.index', 'users.create', 'users.edit', 'users.show'],
            ] : null,
                            $user->can('roles.view') ? [
                'label'        => 'Role & Permission',
                'route'        => 'roles.index',
                'url'          => route('roles.index'),
                'activeRoutes' => ['roles.index', 'roles.create', 'roles.edit'],
            ] : null,
                            $user->can('permissions.view') ? [
                'label'        => 'Permission',
                'route'        => 'permissions.index',
                'url'          => route('permissions.index'),
                'activeRoutes' => ['permissions.index'],
            ] : null,
            ])),
        ] : null,
    ]],
];

$menu     = $navItems ?: $defaultNavItems;
$initials = collect(explode(' ', $user->name ?? 'User'))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');
@endphp

<aside
    :class="{ 'w-60': !collapsed, 'w-[60px]': collapsed, 'translate-x-0': mobileOpen, '-translate-x-full lg:translate-x-0': !mobileOpen }"
    class="fixed inset-y-0 left-0 z-30 flex flex-col bg-white border-r border-slate-200 transition-all duration-250 ease-in-out lg:static lg:inset-auto lg:translate-x-0"
    aria-label="Navigasi utama"
>
    {{-- LOGO --}}
    <div class="relative flex h-[62px] items-center border-b border-slate-200 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-[#1e3a5f]">
                <x-application-logo class="h-5 w-5 fill-current text-blue-300" />
            </div>
            <span class="whitespace-nowrap text-[15px] font-semibold text-[#1e3a5f] transition-all duration-200"
                :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
                Admin<span class="text-blue-600">Template</span>
            </span>
        </a>
        <button @click="toggle()" :title="collapsed ? 'Perluas' : 'Persempit'"
            class="absolute -right-[11px] top-1/2 -translate-y-1/2 hidden lg:flex h-[22px] w-[22px] items-center justify-center rounded-full bg-white border border-slate-200 text-blue-600 text-xs hover:bg-blue-50 hover:border-blue-300 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
            aria-label="Toggle sidebar">
            <i class="ti ti-chevron-left transition-transform duration-250" :class="collapsed ? 'rotate-180' : ''" aria-hidden="true"></i>
        </button>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-3 px-2 scrollbar-hide" role="navigation">
        @foreach($menu as $section)
            <div class="mb-1 px-2 pt-3 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-400 transition-all duration-150"
                 :class="collapsed ? 'opacity-0 h-0 overflow-hidden pt-0 pb-0' : 'opacity-100'" aria-hidden="true">
                {{ $section['label'] }}
            </div>
            @foreach($section['items'] as $item)
                @if(isset($item['children']))
                    <x-sidebar.dropdown :item="$item" />
                @else
                    <x-sidebar.nav-link :item="$item" />
                @endif
            @endforeach
            @if(!$loop->last)
                <div class="my-2 mx-2 h-px bg-slate-100" role="separator"></div>
            @endif
        @endforeach
    </nav>

    {{-- USER PROFILE --}}
    <div class="border-t border-slate-200 px-2 py-3">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 hover:bg-blue-50 transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                :aria-expanded="open">
                <div class="flex h-[30px] w-[30px] flex-shrink-0 items-center justify-center rounded-full bg-[#1e3a5f] text-[11px] font-semibold text-blue-200 border-2 border-blue-100">
                    {{ $initials }}
                </div>
                <div class="flex-1 min-w-0 text-left transition-all duration-150"
                     :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'">
                    <p class="truncate text-[12.5px] font-medium text-slate-800 leading-tight">{{ $user->name ?? 'Pengguna' }}</p>
                    <p class="truncate text-[11px] text-slate-400">{{ $user->roles?->first()?->name ?? 'Administrator' }}</p>
                </div>
                <i class="ti ti-dots-vertical flex-shrink-0 text-sm text-slate-300 transition-all duration-150"
                   :class="collapsed ? 'opacity-0 w-0 overflow-hidden' : 'opacity-100'" aria-hidden="true"></i>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="open = false"
                 class="absolute bottom-full left-0 right-0 mb-1 rounded-xl bg-white border border-slate-200 shadow-lg shadow-slate-200/60 py-1"
                 role="menu">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-3 py-2 text-[13px] text-slate-600 hover:bg-blue-50 hover:text-blue-700 transition-colors" role="menuitem">
                    <i class="ti ti-user-circle text-blue-400" aria-hidden="true"></i> Profil Saya
                </a>
                <div class="my-1 mx-2 h-px bg-slate-100" role="separator"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-[13px] text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors" role="menuitem">
                        <i class="ti ti-logout" aria-hidden="true"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
