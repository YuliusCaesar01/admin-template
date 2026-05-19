<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- ═══════════════════════════════════════
         PAGE HEADER
         ═══════════════════════════════════════ --}}
    <div class="mb-8">
        <h1 class="text-xl font-semibold text-slate-900">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h1>
    </div>

    </div>
</x-app-layout>
