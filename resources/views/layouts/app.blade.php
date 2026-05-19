@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @isset($title)
            {{ $title }} -
        @endisset
        {{ config('app.name', 'AdminPro') }}
    </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 font-sans antialiased">

<div x-data="sidebarApp()" x-init="init()" class="flex h-screen overflow-hidden">

    {{-- Mobile Overlay --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileOpen = false"
         class="fixed inset-0 z-20 bg-slate-900/40 backdrop-blur-sm lg:hidden"
         aria-hidden="true"></div>

    <x-sidebar />

    <div class="flex flex-1 flex-col overflow-hidden">
        <x-topbar :title="$title ?? 'Dashboard'" />
        <main class="flex-1 overflow-y-auto bg-slate-50 p-6">
            {{ $slot }}
        </main>
    </div>
</div>

<script>
function sidebarApp() {
    return {
        collapsed: false,
        mobileOpen: false,
        init() {
            const stored = localStorage.getItem('sidebar_collapsed');
            if (stored !== null) this.collapsed = stored === 'true';
            this.$watch('collapsed', val => localStorage.setItem('sidebar_collapsed', val));
        },
        toggle() {
            if (window.innerWidth < 1024) this.mobileOpen = !this.mobileOpen;
            else this.collapsed = !this.collapsed;
        }
    }
}
</script>
</body>
</html>
