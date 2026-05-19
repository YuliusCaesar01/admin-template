<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    {{-- ═══════════════════════════════════════
         PAGE HEADER
         ═══════════════════════════════════════ --}}
    <div class="mb-8">
        <h1 class="text-xl font-semibold text-slate-100">
            Selamat datang, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Berikut ringkasan aktivitas sistem hari ini.
        </p>
    </div>

    {{-- ═══════════════════════════════════════
         STAT CARDS
         ═══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">

        @php $stats = [
            ['label' => 'Total Pengguna',  'value' => '2,847', 'change' => '+12%', 'positive' => true,  'icon' => 'ti-users'],
            ['label' => 'Pendapatan',      'value' => 'Rp 48M', 'change' => '+8.4%','positive' => true, 'icon' => 'ti-currency-dollar'],
            ['label' => 'Tiket Aktif',     'value' => '134',   'change' => '-3',    'positive' => false, 'icon' => 'ti-ticket'],
            ['label' => 'Server Uptime',   'value' => '99.9%', 'change' => 'Stabil','positive' => true,  'icon' => 'ti-server'],
        ]; @endphp

        @foreach($stats as $stat)
            <div class="rounded-xl border border-blue-900/20 bg-navy-800 p-5 animate-fade-in-up">
                <div class="mb-3 flex items-center justify-between">
                    <span class="text-xs font-medium uppercase tracking-wider text-slate-500">
                        {{ $stat['label'] }}
                    </span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-900/30">
                        <i class="ti {{ $stat['icon'] }} text-blue-400 text-base" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="text-2xl font-semibold text-slate-100">{{ $stat['value'] }}</div>
                <div class="mt-1 text-xs {{ $stat['positive'] ? 'text-emerald-400' : 'text-amber-400' }}">
                    {{ $stat['change'] }} dari bulan lalu
                </div>
            </div>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════
         CONTENT GRID
         ═══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">

        {{-- Recent Activity --}}
        <div class="lg:col-span-2 rounded-xl border border-blue-900/20 bg-navy-800 p-5">
            <h2 class="mb-4 text-sm font-semibold text-slate-200">Aktivitas Terbaru</h2>
            <div class="space-y-3">
                @php $activities = [
                    ['user' => 'Ahmad N.',    'action' => 'menambahkan produk baru',       'time' => '5 menit lalu',   'icon' => 'ti-plus',     'color' => 'text-blue-400'],
                    ['user' => 'Siti R.',     'action' => 'memperbarui profil pengguna',   'time' => '23 menit lalu',  'icon' => 'ti-edit',     'color' => 'text-emerald-400'],
                    ['user' => 'Budi S.',     'action' => 'mengekspor laporan bulanan',    'time' => '1 jam lalu',     'icon' => 'ti-download', 'color' => 'text-amber-400'],
                    ['user' => 'Dewi M.',     'action' => 'mengubah pengaturan keamanan',  'time' => '3 jam lalu',     'icon' => 'ti-shield',   'color' => 'text-blue-400'],
                ]; @endphp

                @foreach($activities as $activity)
                    <div class="flex items-start gap-3 rounded-lg px-3 py-2.5 hover:bg-blue-900/15 transition-colors">
                        <div class="mt-0.5 flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-full bg-blue-900/30">
                            <i class="ti {{ $activity['icon'] }} {{ $activity['color'] }} text-sm" aria-hidden="true"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-slate-300">
                                <span class="font-medium text-slate-200">{{ $activity['user'] }}</span>
                                {{ $activity['action'] }}
                            </p>
                            <p class="text-xs text-slate-600">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="rounded-xl border border-blue-900/20 bg-navy-800 p-5">
            <h2 class="mb-4 text-sm font-semibold text-slate-200">Akses Cepat</h2>
            <div class="grid grid-cols-2 gap-2">
                @php $links = [
                    ['label' => 'Pengguna',   'icon' => 'ti-users',          'url' => '#'],
                    ['label' => 'Laporan',    'icon' => 'ti-chart-bar',      'url' => '#'],
                    ['label' => 'Produk',     'icon' => 'ti-shopping-cart',  'url' => '#'],
                    ['label' => 'Pengaturan', 'icon' => 'ti-settings',       'url' => '#'],
                ]; @endphp

                @foreach($links as $link)
                    <a
                        href="{{ $link['url'] }}"
                        class="
                            flex flex-col items-center gap-2 rounded-lg p-3
                            border border-blue-900/20 bg-navy-900/50
                            hover:border-blue-700/40 hover:bg-blue-900/20
                            transition-all duration-150 group
                        "
                    >
                        <i class="ti {{ $link['icon'] }} text-blue-500 text-xl group-hover:text-blue-400 transition-colors" aria-hidden="true"></i>
                        <span class="text-xs font-medium text-slate-400 group-hover:text-slate-300 transition-colors">
                            {{ $link['label'] }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
