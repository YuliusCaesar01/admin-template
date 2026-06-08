{{-- resources/views/pages/pesanan.blade.php --}}
@extends('layouts.landing')

@section('title', 'Pesanan Saya')
@section('meta_description', 'Pantau status dan riwayat pesanan pengujian material Anda secara real-time.')

@push('styles')
<style>
    /* ── Layout ── */
    .orders-wrapper {
        min-height: calc(100vh - 62px);
        background: var(--page-bg);
    }

    /* ── Guest State ── */
    .guest-wall {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 62px - 80px);
        padding: 48px 24px;
    }

    .guest-card {
        width: 100%;
        max-width: 420px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 20px;
        padding: 48px 40px 40px;
        text-align: center;
        box-shadow: 0 4px 24px rgba(0,0,0,0.05);
    }

    .guest-icon-wrap {
        width: 72px;
        height: 72px;
        background: var(--orange-light);
        border: 1.5px solid var(--orange-border);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        font-size: 28px;
        color: var(--orange-primary);
    }

    .guest-card h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 10px;
    }

    .guest-card p {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0 0 28px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--orange-primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 24px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
        width: 100%;
        justify-content: center;
    }

    .btn-primary:hover { background: #C2410C; color: #fff; }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 24px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }

    .btn-ghost:hover {
        border-color: var(--orange-border);
        color: var(--orange-primary);
        background: var(--orange-light);
    }

    /* ── Orders Page ── */
    .orders-inner {
        max-width: 900px;
        margin: 0 auto;
        padding: 40px 24px 64px;
    }

    .orders-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .orders-header-left h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .orders-header-left p {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 0;
    }

    /* ── Filter Tabs ── */
    .filter-tabs {
        display: flex;
        gap: 4px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 4px;
        margin-bottom: 20px;
        overflow-x: auto;
    }

    .filter-tab {
        flex-shrink: 0;
        padding: 7px 16px;
        border-radius: 7px;
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.15s;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-tab.active {
        background: var(--orange-primary);
        color: #fff;
    }

    .filter-tab:not(.active):hover {
        background: var(--orange-light);
        color: var(--orange-primary);
    }

    .tab-count {
        background: rgba(255,255,255,0.25);
        border-radius: 20px;
        padding: 1px 7px;
        font-size: 10.5px;
        font-weight: 700;
    }

    .filter-tab:not(.active) .tab-count {
        background: var(--orange-badge);
        color: var(--orange-primary);
    }

    /* ── Order Card ── */
    .order-list { display: flex; flex-direction: column; gap: 12px; }

    .order-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow 0.15s, border-color 0.15s;
    }

    .order-card:hover {
        border-color: var(--orange-border);
        box-shadow: 0 4px 16px rgba(242,140,40,0.08);
    }

    .order-card-top {
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        border-bottom: 1px solid var(--divider);
    }

    .order-card-top-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .order-type-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .order-id { font-size: 11px; color: var(--text-muted); margin: 0 0 2px; font-family: monospace; }
    .order-title { font-size: 14px; font-weight: 600; color: var(--text-primary); margin: 0; }

    /* Status badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }

    .badge-pending   { background: #FEF3C7; color: #92400E; }
    .badge-pending .badge-dot   { background: #F59E0B; }
    .badge-process   { background: #EFF6FF; color: #1D4ED8; }
    .badge-process .badge-dot   { background: #3B82F6; }
    .badge-done      { background: #ECFDF5; color: #065F46; }
    .badge-done .badge-dot      { background: #10B981; }
    .badge-cancelled { background: #FEF2F2; color: #991B1B; }
    .badge-cancelled .badge-dot { background: #EF4444; }

    .order-card-body {
        padding: 14px 20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .order-meta-item .meta-label {
        font-size: 11px;
        color: var(--text-muted);
        margin-bottom: 3px;
    }

    .order-meta-item .meta-value {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .order-card-footer {
        padding: 12px 20px;
        background: var(--page-bg);
        border-top: 1px solid var(--divider);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .order-progress {
        display: flex;
        align-items: center;
        gap: 8px;
        flex: 1;
        min-width: 200px;
    }

    .progress-bar-wrap {
        flex: 1;
        height: 4px;
        background: var(--divider);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        background: var(--orange-primary);
        transition: width 0.4s ease;
    }

    .progress-label { font-size: 11px; color: var(--text-muted); white-space: nowrap; }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        color: var(--orange-primary);
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        text-decoration: none;
        transition: all 0.15s;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: var(--orange-primary);
        color: #fff;
        border-color: var(--orange-primary);
    }

    /* ── Summary Cards ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px;
    }

    .summary-card .s-num {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: 4px;
    }

    .summary-card .s-label {
        font-size: 11.5px;
        color: var(--text-secondary);
    }

    .summary-card.highlight { border-color: var(--orange-border); background: var(--orange-light); }
    .summary-card.highlight .s-num { color: var(--orange-primary); }

    /* ── Empty ── */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
    }

    .empty-icon {
        font-size: 40px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    .empty-state h3 { font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0 0 6px; }
    .empty-state p  { font-size: 13px; color: var(--text-secondary); margin: 0 0 24px; }

    @media (max-width: 700px) {
        .summary-grid { grid-template-columns: repeat(2, 1fr); }
        .order-card-body { grid-template-columns: repeat(2, 1fr); }
        .orders-header { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="orders-wrapper">

@guest
{{-- ════════════════════════════════
     GUEST STATE — Belum Login
════════════════════════════════ --}}
<div class="guest-wall">
    <div class="guest-card animate-in">
        <div class="guest-icon-wrap">
            <i class="ti ti-lock" aria-hidden="true"></i>
        </div>
        <h2>Login untuk Melihat Pesanan</h2>
        <p>
            Pantau status, unduh laporan, dan kelola semua pesanan pengujian Anda
            di satu tempat. Masuk terlebih dahulu untuk melanjutkan.
        </p>
        <a href="{{ route('login') }}" class="btn-primary">
            <i class="ti ti-login" aria-hidden="true"></i>
            Masuk ke Akun
        </a>
        <a href="{{ route('register') }}" class="btn-ghost">
            <i class="ti ti-user-plus" aria-hidden="true"></i>
            Buat Akun Baru
        </a>
        <p style="font-size:11.5px;color:var(--text-muted);margin:20px 0 0;">
            Belum punya akun? Daftar gratis dan mulai ajukan pengujian pertama Anda.
        </p>
    </div>
</div>

@else
{{-- ════════════════════════════════
     LOGGED-IN STATE — Pesanan Saya
════════════════════════════════ --}}

{{-- Data dummy --}}
@php
$orders = [
    [
        'id'         => 'ORD-2024-00312',
        'title'      => 'Kuat Tekan Beton',
        'type'       => 'beton',
        'icon'       => 'ti-cube',
        'status'     => 'done',
        'status_label' => 'Selesai',
        'tanggal'    => '12 Mei 2025',
        'estimasi'   => '14 Hari Kerja',
        'parameter'  => '3 Parameter',
        'biaya'      => 'Rp 450.000',
        'progress'   => 100,
        'progress_text' => 'Laporan tersedia',
    ],
    [
        'id'         => 'ORD-2025-00089',
        'title'      => 'Analisis Tanah Lengkap',
        'type'       => 'tanah',
        'icon'       => 'ti-layers-difference',
        'status'     => 'process',
        'status_label' => 'Dalam Pengujian',
        'tanggal'    => '28 Mei 2025',
        'estimasi'   => '3–5 Hari Kerja',
        'parameter'  => '5 Parameter',
        'biaya'      => 'Rp 780.000',
        'progress'   => 60,
        'progress_text' => 'Pengujian berjalan',
    ],
    [
        'id'         => 'ORD-2025-00104',
        'title'      => 'Uji Slump & Berat Jenis',
        'type'       => 'beton',
        'icon'       => 'ti-cube',
        'status'     => 'pending',
        'status_label' => 'Menunggu Sampel',
        'tanggal'    => '2 Jun 2025',
        'estimasi'   => '1–2 Hari Kerja',
        'parameter'  => '2 Parameter',
        'biaya'      => 'Rp 210.000',
        'progress'   => 15,
        'progress_text' => 'Menunggu sampel masuk',
    ],
    [
        'id'         => 'ORD-2025-00071',
        'title'      => 'Uji Tarik Baja',
        'type'       => 'baja',
        'icon'       => 'ti-bolt',
        'status'     => 'done',
        'status_label' => 'Selesai',
        'tanggal'    => '15 Apr 2025',
        'estimasi'   => '3–5 Hari Kerja',
        'parameter'  => '2 Parameter',
        'biaya'      => 'Rp 320.000',
        'progress'   => 100,
        'progress_text' => 'Laporan tersedia',
    ],
    [
        'id'         => 'ORD-2025-00055',
        'title'      => 'Analisis Aspal Marshall',
        'type'       => 'aspal',
        'icon'       => 'ti-road',
        'status'     => 'cancelled',
        'status_label' => 'Dibatalkan',
        'tanggal'    => '3 Mar 2025',
        'estimasi'   => '3–5 Hari Kerja',
        'parameter'  => '4 Parameter',
        'biaya'      => 'Rp 560.000',
        'progress'   => 0,
        'progress_text' => 'Pesanan dibatalkan',
    ],
];

$summary = [
    'total'   => count($orders),
    'proses'  => collect($orders)->where('status', 'process')->count(),
    'selesai' => collect($orders)->where('status', 'done')->count(),
    'pending' => collect($orders)->where('status', 'pending')->count(),
];
@endphp

<div class="orders-inner">

    {{-- Header --}}
    <div class="orders-header animate-in">
        <div class="orders-header-left">
            <h1>Pesanan Saya</h1>
            <p>Halo, <strong>{{ auth()->user()->name }}</strong> — berikut riwayat pengujian Anda.</p>
        </div>
        <a href="#" class="btn-primary" style="width:auto;padding:10px 20px;">
            <i class="ti ti-plus" aria-hidden="true"></i>
            Ajukan Pengujian Baru
        </a>
    </div>

    {{-- Summary --}}
    <div class="summary-grid animate-in delay-1">
        <div class="summary-card">
            <div class="s-num">{{ $summary['total'] }}</div>
            <div class="s-label">Total Pesanan</div>
        </div>
        <div class="summary-card highlight">
            <div class="s-num">{{ $summary['proses'] }}</div>
            <div class="s-label">Sedang Diproses</div>
        </div>
        <div class="summary-card">
            <div class="s-num">{{ $summary['selesai'] }}</div>
            <div class="s-label">Selesai</div>
        </div>
        <div class="summary-card">
            <div class="s-num">{{ $summary['pending'] }}</div>
            <div class="s-label">Menunggu Sampel</div>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="filter-tabs animate-in delay-2" x-data="{ active: 'semua' }">
        @php
        $tabs = [
            ['key' => 'semua',     'label' => 'Semua',          'count' => $summary['total']],
            ['key' => 'pending',   'label' => 'Menunggu Sampel','count' => $summary['pending']],
            ['key' => 'process',   'label' => 'Dalam Pengujian','count' => $summary['proses']],
            ['key' => 'done',      'label' => 'Selesai',        'count' => $summary['selesai']],
            ['key' => 'cancelled', 'label' => 'Dibatalkan',     'count' => collect($orders)->where('status','cancelled')->count()],
        ];
        @endphp

        @foreach ($tabs as $tab)
        <button
            class="filter-tab"
            :class="{ 'active': active === '{{ $tab['key'] }}' }"
            @click="active = '{{ $tab['key'] }}'"
        >
            {{ $tab['label'] }}
            <span class="tab-count">{{ $tab['count'] }}</span>
        </button>
        @endforeach

        {{-- Order List --}}
        <div class="order-list" style="display:contents;">
        </div>
    </div>

    {{-- Orders --}}
    <div class="order-list animate-in delay-3" x-data="{ active: 'semua' }">

        {{-- re-declare active in parent scope via shared component — simple approach: use window var --}}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('orderFilter', { active: 'semua' });
            });
        </script>

        @foreach ($orders as $i => $order)
        <div class="order-card"
             x-data
             x-show="
                $store.orderFilter.active === 'semua' ||
                $store.orderFilter.active === '{{ $order['status'] }}'
             "
             x-transition>

            <div class="order-card-top">
                <div class="order-card-top-left">
                    <div class="order-type-icon">
                        <i class="ti {{ $order['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p class="order-id">{{ $order['id'] }}</p>
                        <p class="order-title">{{ $order['title'] }}</p>
                    </div>
                </div>
                <span class="badge badge-{{ $order['status'] }}">
                    <span class="badge-dot"></span>
                    {{ $order['status_label'] }}
                </span>
            </div>

            <div class="order-card-body">
                <div class="order-meta-item">
                    <div class="meta-label">Tanggal Ajuan</div>
                    <div class="meta-value">{{ $order['tanggal'] }}</div>
                </div>
                <div class="order-meta-item">
                    <div class="meta-label">Estimasi Waktu</div>
                    <div class="meta-value">{{ $order['estimasi'] }}</div>
                </div>
                <div class="order-meta-item">
                    <div class="meta-label">Parameter Uji</div>
                    <div class="meta-value">{{ $order['parameter'] }}</div>
                </div>
                <div class="order-meta-item">
                    <div class="meta-label">Total Biaya</div>
                    <div class="meta-value">{{ $order['biaya'] }}</div>
                </div>
            </div>

            <div class="order-card-footer">
                <div class="order-progress">
                    <span class="progress-label">{{ $order['progress_text'] }}</span>
                    <div class="progress-bar-wrap">
                        <div class="progress-bar-fill" style="width: {{ $order['progress'] }}%"></div>
                    </div>
                    <span class="progress-label">{{ $order['progress'] }}%</span>
                </div>
                <a href="#" class="btn-detail">
                    @if ($order['status'] === 'done')
                        <i class="ti ti-download" aria-hidden="true"></i>
                        Unduh Laporan
                    @else
                        <i class="ti ti-eye" aria-hidden="true"></i>
                        Lihat Detail
                    @endif
                </a>
            </div>
        </div>
        @endforeach

    </div>

</div>

{{-- Sync filter tabs dengan order list via Alpine store --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.filter-tab').forEach(btn => {
            btn.addEventListener('click', () => {
                const keys = ['semua','pending','process','done','cancelled'];
                const idx = [...document.querySelectorAll('.filter-tab')].indexOf(btn);
                if (window.Alpine) Alpine.store('orderFilter').active = keys[idx];
            });
        });
    });
</script>

@endguest

</div>
@endsection