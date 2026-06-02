{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AdminPro') }} — {{ $title ?? 'Masuk' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-stone-50 text-stone-800">

    <div class="flex min-h-screen">

        {{-- ── Sisi Kiri — Branding Panel ────────────────── --}}
        <div class="hidden lg:flex lg:w-[42%] flex-col justify-between bg-[#E67E22] px-12 py-10">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                    <i class="ti ti-bolt text-orange-300 text-xl" aria-hidden="true"></i>
                </div>
                <span class="text-[17px] font-semibold text-white">
                    Admin<span class="text-orange-300">Template</span>
                </span>
            </div>

            {{-- Tengah — Tagline --}}
            <div>
                {{-- <p class="mb-4 text-[11px] font-semibold uppercase tracking-widest text-orange-400">
                    Template Admin Dashboard
                </p> --}}
                <h1 class="text-[32px] font-semibold leading-tight text-white">
                    Template Admin Dashboard
                </h1>
                {{-- <p class="mt-4 text-[14px] leading-relaxed text-[#FFEAD8]/70">
                    Pantau pengguna, laporan, dan operasional sistem secara efisien dalam satu tampilan yang bersih.
                </p> --}}

                {{-- Feature list --}}
                <ul class="mt-8 space-y-3">
                    @foreach([
                        ['icon' => 'ti-chart-bar',    'text' => 'Laporan & analitik real-time'],
                        ['icon' => 'ti-users',         'text' => 'Manajemen pengguna & peran'],
                        ['icon' => 'ti-shield-check',  'text' => 'Keamanan & kontrol akses'],
                    ] as $f)
                    <li class="flex items-center gap-3 text-[13px] text-blue-100/80">
                        <span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-white/8">
                            <i class="ti {{ $f['icon'] }} text-orange-300 text-base" aria-hidden="true"></i>
                        </span>
                        {{ $f['text'] }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Bawah — Credit --}}
            <p class="text-[11px] text-orange-400/50">
                &copy; {{ date('Y') }} Admin Template. All rights reserved.
            </p>
        </div>

        {{-- ── Sisi Kanan — Form Panel ────────────────────── --}}
        <div class="flex flex-1 flex-col items-center justify-center px-6 py-12 sm:px-12">

            {{-- Logo mobile (hanya muncul di layar kecil) --}}
            <div class="mb-8 flex items-center gap-3 lg:hidden">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#E67E22]">
                    <i class="ti ti-bolt text-orange-300 text-xl" aria-hidden="true"></i>
                </div>
                <span class="text-[17px] font-semibold text-[#E67E22]">
                    Admin<span class="text-orange-600">Template</span>
                </span>
            </div>

            <div class="w-full max-w-[380px]">
                {{ $slot }}
            </div>
        </div>

    </div>

</body>
</html>
