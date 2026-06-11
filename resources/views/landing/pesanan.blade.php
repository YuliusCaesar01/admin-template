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

    .order-id    { font-size: 11px; color: var(--text-muted); margin: 0 0 2px; font-family: monospace; }
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

    .badge-draft         { background: #F3F4F6; color: #374151; }
    .badge-draft .badge-dot         { background: #9CA3AF; }
    .badge-submit        { background: #FEF3C7; color: #92400E; }
    .badge-submit .badge-dot        { background: #F59E0B; }
    .badge-offered       { background: #EFF6FF; color: #1D4ED8; }
    .badge-offered .badge-dot       { background: #3B82F6; }
    .badge-form_required { background: #FFF7ED; color: #9A3412; }
    .badge-form_required .badge-dot { background: #F97316; }
    .badge-approved      { background: #F0FDF4; color: #166534; }
    .badge-approved .badge-dot      { background: #22C55E; }
    .badge-processing    { background: #EFF6FF; color: #1D4ED8; }
    .badge-processing .badge-dot    { background: #3B82F6; }
    .badge-done          { background: #ECFDF5; color: #065F46; }
    .badge-done .badge-dot          { background: #10B981; }
    .badge-rejected      { background: #FEF2F2; color: #991B1B; }
    .badge-rejected .badge-dot      { background: #EF4444; }

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

    .empty-icon { font-size: 40px; color: var(--text-muted); margin-bottom: 16px; }
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

@php
/**
 * Helper: mapping status Order model → badge CSS class, label, progress, teks progres
 * Sesuai konstanta di Order::STATUS_*
 */
$statusMap = [
    'draft'         => ['badge' => 'draft',         'label' => 'Draft',             'progress' => 5,   'text' => 'Belum disubmit'],
    'submit'        => ['badge' => 'submit',         'label' => 'Menunggu Review',   'progress' => 20,  'text' => 'Menunggu konfirmasi admin'],
    'offered'       => ['badge' => 'offered',        'label' => 'Ada Penawaran',     'progress' => 35,  'text' => 'Silakan tinjau penawaran'],
    'form_required' => ['badge' => 'form_required',  'label' => 'Perlu Kelengkapan', 'progress' => 30,  'text' => 'Lengkapi data yang diminta'],
    'approved'      => ['badge' => 'approved',       'label' => 'Disetujui',         'progress' => 55,  'text' => 'Menunggu jadwal pengujian'],
    'processing'    => ['badge' => 'processing',     'label' => 'Dalam Pengujian',   'progress' => 75,  'text' => 'Pengujian sedang berjalan'],
    'done'          => ['badge' => 'done',           'label' => 'Selesai',           'progress' => 100, 'text' => 'Laporan tersedia'],
    'rejected'      => ['badge' => 'rejected',       'label' => 'Ditolak',           'progress' => 0,   'text' => 'Pesanan ditolak'],
];

/**
 * Helper: icon berdasarkan tipe order
 */
$typeIcon = [
    'internal' => 'ti-building',
    'external' => 'ti-world',
];

/**
 * Hitung summary dari koleksi $orders (sudah dipass dari UserOrderController)
 * $orders = LengthAwarePaginator — gunakan ->getCollection() untuk iterasi
 */
$collection = $orders->getCollection();

$summary = [
    'total'      => $orders->total(),
    'processing' => $collection->whereIn('status', ['approved', 'processing'])->count(),
    'done'       => $collection->where('status', 'done')->count(),
    'pending'    => $collection->whereIn('status', ['draft', 'submit', 'offered', 'form_required'])->count(),
];

/**
 * Tab filter — key harus cocok dengan nilai status di DB
 * 'semua' adalah kasus khusus (tidak difilter)
 */
$tabs = [
    ['key' => 'semua',      'label' => 'Semua',           'count' => $orders->total()],
    ['key' => 'draft',      'label' => 'Draft',           'count' => $collection->where('status','draft')->count()],
    ['key' => 'submit',     'label' => 'Menunggu Review', 'count' => $collection->where('status','submit')->count()],
    ['key' => 'processing', 'label' => 'Dalam Pengujian', 'count' => $collection->where('status','processing')->count()],
    ['key' => 'done',       'label' => 'Selesai',         'count' => $collection->where('status','done')->count()],
    ['key' => 'rejected',   'label' => 'Ditolak',         'count' => $collection->where('status','rejected')->count()],
];
@endphp

<div class="orders-inner">

    {{-- Header --}}
    <div class="orders-header animate-in">
        <div class="orders-header-left">
            <h1>Pesanan Saya</h1>
            <p>Halo, <strong>{{ auth()->user()->name }}</strong> — berikut riwayat pengujian Anda.</p>
        </div>
        <a href="{{ route('user-orders.create') }}" class="btn-primary" style="width:auto;padding:10px 20px;">
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
            <div class="s-num">{{ $summary['processing'] }}</div>
            <div class="s-label">Sedang Diproses</div>
        </div>
        <div class="summary-card">
            <div class="s-num">{{ $summary['done'] }}</div>
            <div class="s-label">Selesai</div>
        </div>
        <div class="summary-card">
            <div class="s-num">{{ $summary['pending'] }}</div>
            <div class="s-label">Menunggu Tindak Lanjut</div>
        </div>
    </div>

    {{-- Filter Tabs + Order List (Alpine shared store) --}}
    <div x-data x-init="$store.orderFilter.active = '{{ request('status', 'semua') }}'">

        <div class="filter-tabs animate-in delay-2">
            @foreach ($tabs as $tab)
            <button
                class="filter-tab"
                :class="{ 'active': $store.orderFilter.active === '{{ $tab['key'] }}' }"
                @click="$store.orderFilter.active = '{{ $tab['key'] }}'"
                type="button"
            >
                {{ $tab['label'] }}
                <span class="tab-count">{{ $tab['count'] }}</span>
            </button>
            @endforeach
        </div>

        {{-- Order List --}}
        <div class="order-list animate-in delay-3">

            @forelse ($orders as $order)
            @php
                $st      = $statusMap[$order->status] ?? $statusMap['draft'];
                $icon    = $typeIcon[$order->type]    ?? 'ti-file';
                $isDone  = $order->status === 'done';
                $canSubmit = $order->status === 'draft';

                // Grand total dari offer
                $total = $order->relationLoaded('offer') && $order->offer
                    ? $order->offer->details->sum(fn($d) => $d->qty * $d->price)
                    : 0;

                // Tanggal pengajuan
                $tanggal = $order->sent_at
                    ? $order->sent_at->translatedFormat('d M Y')
                    : $order->created_at->translatedFormat('d M Y');

                // Jumlah parameter (detail offer)
                $paramCount = ($order->relationLoaded('offer') && $order->offer)
                    ? $order->offer->details->count()
                    : 0;
            @endphp

            <div class="order-card"
                 x-show="
                    $store.orderFilter.active === 'semua' ||
                    $store.orderFilter.active === '{{ $order->status }}'
                 "
                 x-transition>

                {{-- Top --}}
                <div class="order-card-top">
                    <div class="order-card-top-left">
                        <div class="order-type-icon">
                            <i class="ti {{ $icon }}" aria-hidden="true"></i>
                        </div>
                        <div>
                            <p class="order-id">{{ $order->order_code }}</p>
                            <p class="order-title">
                                {{ $order->tujuan_pengujian ?? 'Tanpa keterangan tujuan' }}
                            </p>
                        </div>
                    </div>
                    <span class="badge badge-{{ $st['badge'] }}">
                        <span class="badge-dot"></span>
                        {{ $st['label'] }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="order-card-body">
                    <div class="order-meta-item">
                        <div class="meta-label">Tanggal Ajuan</div>
                        <div class="meta-value">{{ $tanggal }}</div>
                    </div>
                    <div class="order-meta-item">
                        <div class="meta-label">Tipe Order</div>
                        <div class="meta-value">{{ ucfirst($order->type) }}</div>
                    </div>
                    <div class="order-meta-item">
                        <div class="meta-label">Parameter Uji</div>
                        <div class="meta-value">
                            {{ $paramCount > 0 ? $paramCount . ' Parameter' : '—' }}
                        </div>
                    </div>
                    <div class="order-meta-item">
                        <div class="meta-label">Total Biaya</div>
                        <div class="meta-value">
                            {{ $total > 0 ? 'Rp ' . number_format($total, 0, ',', '.') : '—' }}
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="order-card-footer">
                    <div class="order-progress">
                        <span class="progress-label">{{ $st['text'] }}</span>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width: {{ $st['progress'] }}%"></div>
                        </div>
                        <span class="progress-label">{{ $st['progress'] }}%</span>
                    </div>

                    <div style="display:flex;gap:8px;align-items:center;">
                        {{-- Submit jika masih draft --}}
                        @if ($canSubmit)
                        <form method="POST" action="{{ route('user-orders.submit', $order) }}"
                              onsubmit="return confirm('Yakin ingin mengajukan pesanan ini?')">
                            @csrf
                            <button type="submit" class="btn-detail" style="color:#166534;background:#F0FDF4;border-color:#86EFAC;">
                                <i class="ti ti-send" aria-hidden="true"></i>
                                Submit
                            </button>
                        </form>
                        @endif

                        {{-- Tombol utama --}}
                        <a href="{{ route('user-orders.show', $order) }}" class="btn-detail">
                            @if ($isDone)
                                <i class="ti ti-download" aria-hidden="true"></i>
                                Unduh Laporan
                            @else
                                <i class="ti ti-eye" aria-hidden="true"></i>
                                Lihat Detail
                            @endif
                        </a>
                    </div>
                </div>

            </div>
            @empty

            {{-- Empty State --}}
            <div class="empty-state" x-show="$store.orderFilter.active === 'semua'">
                <div class="empty-icon"><i class="ti ti-clipboard-x" aria-hidden="true"></i></div>
                <h3>Belum Ada Pesanan</h3>
                <p>Anda belum pernah mengajukan pesanan pengujian. Mulai ajukan sekarang.</p>
                <a href="{{ route('user-orders.create') }}" class="btn-primary" style="width:auto;display:inline-flex;">
                    <i class="ti ti-plus" aria-hidden="true"></i>
                    Ajukan Pengujian Pertama
                </a>
            </div>

            @endforelse

        </div>

        {{-- Pagination --}}
        @if ($orders->hasPages())
        <div style="margin-top:24px;">
            {{ $orders->links() }}
        </div>
        @endif

    </div>{{-- end x-data --}}

</div>{{-- end orders-inner --}}

@endguest
</div>

{{-- Alpine Store --}}
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('orderFilter', { active: 'semua' });
    });
</script>
@endpush

@endsection