@extends('layouts.landing')

@section('title', 'Detail Pesanan — ' . $order->order_code)
@section('meta_description', 'Detail dan status pesanan pengujian ' . $order->order_code)

@push('styles')
<style>
    /* ── Layout ── */
    .show-wrapper {
        min-height: calc(100vh - 62px);
        background: var(--page-bg);
    }

    .show-inner {
        max-width: 960px;
        margin: 0 auto;
        padding: 36px 24px 72px;
    }

    /* ── Breadcrumb ── */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 24px;
    }

    .breadcrumb a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.15s;
    }

    .breadcrumb a:hover { color: var(--orange-primary); }
    .breadcrumb .sep { font-size: 10px; }
    .breadcrumb .current { color: var(--text-primary); font-weight: 500; }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 28px;
    }

    .page-header-left .order-code {
        font-size: 11.5px;
        font-family: monospace;
        color: var(--text-muted);
        margin: 0 0 4px;
    }

    .page-header-left h1 {
        font-size: 21px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 6px;
    }

    .page-header-left .header-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .page-header-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    /* ── Status / Badge ── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge-dot { width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

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

    /* ── Progress Stepper ── */
    .stepper-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .stepper-card h2 {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin: 0 0 20px;
    }

    .stepper {
        display: flex;
        align-items: flex-start;
        gap: 0;
        overflow-x: auto;
        padding-bottom: 4px;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        min-width: 72px;
        position: relative;
    }

    .step-node {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: var(--text-muted);
        z-index: 1;
        transition: all 0.2s;
        position: relative;
    }

    .step.done   .step-node  { background: var(--orange-primary); border-color: var(--orange-primary); color: #fff; }
    .step.active .step-node  { border-color: var(--orange-primary); color: var(--orange-primary); box-shadow: 0 0 0 4px var(--orange-badge); }
    .step.rejected-node .step-node { background: #FEF2F2; border-color: #EF4444; color: #EF4444; }

    .step-line {
        position: absolute;
        top: 15px;
        left: calc(50% + 16px);
        right: calc(-50% + 16px);
        height: 2px;
        background: var(--divider);
        z-index: 0;
    }

    .step.done .step-line { background: var(--orange-primary); }

    .step:last-child .step-line { display: none; }

    .step-label {
        margin-top: 8px;
        font-size: 10.5px;
        font-weight: 500;
        color: var(--text-muted);
        text-align: center;
        white-space: nowrap;
    }

    .step.done   .step-label  { color: var(--orange-primary); }
    .step.active .step-label  { color: var(--text-primary); font-weight: 600; }

    /* ── Grid Layout ── */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 20px;
        align-items: start;
    }

    /* ── Card ── */
    .info-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .info-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--divider);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .info-card-header h3 {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-card-header h3 i {
        color: var(--orange-primary);
        font-size: 15px;
    }

    .info-card-body { padding: 20px; }

    /* ── Info Row ── */
    .info-rows { display: flex; flex-direction: column; gap: 14px; }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .info-row-label {
        font-size: 12px;
        color: var(--text-muted);
        min-width: 150px;
        flex-shrink: 0;
        padding-top: 1px;
    }

    .info-row-value {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        flex: 1;
    }

    .info-divider {
        height: 1px;
        background: var(--divider);
        margin: 4px 0;
    }

    /* ── Alert / Notice ── */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        line-height: 1.5;
    }

    .alert i { font-size: 17px; flex-shrink: 0; margin-top: 1px; }

    .alert-warning { background: #FFFBEB; border: 1px solid #FDE68A; color: #92400E; }
    .alert-info    { background: #EFF6FF; border: 1px solid #BFDBFE; color: #1D4ED8; }
    .alert-danger  { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
    .alert-success { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; }

    /* ── Offer Detail Table ── */
    .offer-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }

    .offer-table th {
        padding: 9px 12px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid var(--divider);
        background: var(--page-bg);
    }

    .offer-table td {
        padding: 11px 12px;
        border-bottom: 1px solid var(--divider);
        color: var(--text-primary);
    }

    .offer-table tr:last-child td { border-bottom: none; }

    .offer-table .text-right { text-align: right; }

    .offer-total-row td {
        padding: 12px 12px;
        font-weight: 700;
        background: var(--orange-light);
        border-top: 1px solid var(--orange-border);
        color: var(--text-primary);
    }

    .offer-total-row td:last-child { color: var(--orange-primary); font-size: 14px; }

    /* ── File Attachment ── */
    .file-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--page-bg);
        margin-bottom: 8px;
        transition: border-color 0.15s;
    }

    .file-item:hover { border-color: var(--orange-border); }
    .file-item:last-child { margin-bottom: 0; }

    .file-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .file-name {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 2px;
    }

    .file-size {
        font-size: 11px;
        color: var(--text-muted);
        margin: 0;
    }

    .file-dl {
        margin-left: auto;
        font-size: 12px;
        color: var(--orange-primary);
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 7px;
        border: 1px solid var(--orange-border);
        background: var(--orange-light);
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s;
        flex-shrink: 0;
        font-weight: 500;
    }

    .file-dl:hover {
        background: var(--orange-primary);
        color: #fff;
        border-color: var(--orange-primary);
    }

    /* ── Sidebar Sticky ── */
    .sidebar-sticky { position: sticky; top: 80px; }

    /* ── Summary Sidebar ── */
    .sidebar-summary {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .sidebar-summary-header {
        padding: 14px 18px;
        border-bottom: 1px solid var(--divider);
        font-size: 12.5px;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .sidebar-summary-header i { color: var(--orange-primary); }

    .sidebar-rows { padding: 16px 18px; display: flex; flex-direction: column; gap: 12px; }

    .sidebar-row {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        font-size: 12.5px;
    }

    .sidebar-row .s-label { color: var(--text-muted); }
    .sidebar-row .s-value { font-weight: 600; color: var(--text-primary); text-align: right; }

    .sidebar-total {
        padding: 14px 18px;
        background: var(--orange-light);
        border-top: 1px solid var(--orange-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
    }

    .sidebar-total .t-label { font-size: 12.5px; font-weight: 600; color: var(--text-secondary); }
    .sidebar-total .t-value { font-size: 17px; font-weight: 800; color: var(--orange-primary); }

    /* ── Action Buttons ── */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--orange-primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .btn-primary:hover { background: #C2410C; color: #fff; }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
        white-space: nowrap;
    }

    .btn-ghost:hover {
        border-color: var(--orange-border);
        color: var(--orange-primary);
        background: var(--orange-light);
    }

    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #166534;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
    }

    .btn-success:hover { background: #14532D; color: #fff; }

    /* ── Review Section ── */
    .review-item {
        padding: 14px 0;
        border-bottom: 1px solid var(--divider);
    }

    .review-item:last-child { border-bottom: none; padding-bottom: 0; }

    .review-question {
        font-size: 12.5px;
        color: var(--text-secondary);
        margin-bottom: 8px;
    }

    .stars {
        display: flex;
        gap: 3px;
        margin-bottom: 6px;
    }

    .star { font-size: 16px; color: #D1D5DB; }
    .star.filled { color: #F59E0B; }

    .review-comment {
        font-size: 12.5px;
        color: var(--text-primary);
        font-style: italic;
        background: var(--page-bg);
        padding: 8px 12px;
        border-radius: 8px;
        margin-top: 6px;
    }

    /* ── Timeline ── */
    .timeline { display: flex; flex-direction: column; gap: 0; }

    .timeline-item {
        display: flex;
        gap: 14px;
        padding-bottom: 20px;
        position: relative;
    }

    .timeline-item:last-child { padding-bottom: 0; }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background: var(--divider);
    }

    .timeline-item:last-child::before { display: none; }

    .timeline-node {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: var(--text-muted);
        flex-shrink: 0;
        z-index: 1;
    }

    .timeline-node.active {
        background: var(--orange-primary);
        border-color: var(--orange-primary);
        color: #fff;
    }

    .timeline-content {
        padding-top: 4px;
        flex: 1;
    }

    .timeline-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 2px;
    }

    .timeline-time {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* ── Empty ── */
    .empty-inline {
        padding: 24px;
        text-align: center;
        color: var(--text-muted);
        font-size: 12.5px;
    }

    .empty-inline i { font-size: 28px; display: block; margin-bottom: 8px; color: var(--border); }

    @media (max-width: 740px) {
        .detail-grid { grid-template-columns: 1fr; }
        .sidebar-sticky { position: static; }
        .page-header { flex-direction: column; }
        .stepper { gap: 0; }
        .step-label { font-size: 9px; }
    }
</style>
@endpush

@section('content')

@php
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

$st = $statusMap[$order->status] ?? $statusMap['draft'];

// Stepper config — urutan alur normal
$steps = [
    ['key' => 'draft',         'label' => 'Draft',      'icon' => 'ti-pencil'],
    ['key' => 'submit',        'label' => 'Diajukan',   'icon' => 'ti-send'],
    ['key' => 'offered',       'label' => 'Penawaran',  'icon' => 'ti-file-invoice'],
    ['key' => 'approved',      'label' => 'Disetujui',  'icon' => 'ti-circle-check'],
    ['key' => 'processing',    'label' => 'Pengujian',  'icon' => 'ti-flask'],
    ['key' => 'done',          'label' => 'Selesai',    'icon' => 'ti-award'],
];

$stepOrder = array_column($steps, 'key');
$currentIdx = array_search($order->status, $stepOrder);
$isRejected = $order->status === 'rejected';
$isFormRequired = $order->status === 'form_required';

// Grand total
$grandTotal = 0;
if ($order->offer && $order->offer->details->isNotEmpty()) {
    $grandTotal = $order->offer->details->sum(fn($d) => $d->qty * $d->price);
}

// File pengajuan
$hasFile = !empty($order->file);

// Hasil uji files
$hasilFiles = $order->hasilUjiFiles ?? collect();

// Reviews
$reviews = $order->reviews ?? collect();
$isDone = $order->status === 'done';
$canSubmit = $order->status === 'draft';
$canReview = $isDone && $reviews->isEmpty();
@endphp

<div class="show-wrapper">
<div class="show-inner">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb animate-in">
        <a href="{{ route('user-orders.index') }}">
            <i class="ti ti-clipboard-list"></i> Pesanan Saya
        </a>
        <span class="sep"><i class="ti ti-chevron-right"></i></span>
        <span class="current">{{ $order->order_code }}</span>
    </nav>

    {{-- Page Header --}}
    <div class="page-header animate-in">
        <div class="page-header-left">
            <p class="order-code">{{ $order->order_code }}</p>
            <h1>{{ $order->tujuan_pengujian ?? 'Tanpa keterangan tujuan' }}</h1>
            <div class="header-meta">
                <span class="badge badge-{{ $st['badge'] }}">
                    <span class="badge-dot"></span>
                    {{ $st['label'] }}
                </span>
                <span style="font-size:12px;color:var(--text-muted);">
                    <i class="ti ti-calendar"></i>
                    {{ ($order->sent_at ?? $order->created_at)->translatedFormat('d F Y') }}
                </span>
                <span style="font-size:12px;color:var(--text-muted);">
                    <i class="ti ti-{{ $order->type === 'external' ? 'world' : 'building' }}"></i>
                    {{ ucfirst($order->type) }}
                </span>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('user-orders.index') }}" class="btn-ghost">
                <i class="ti ti-arrow-left"></i>
                Kembali
            </a>
            @if ($canSubmit)
            <form method="POST" action="{{ route('user-orders.submit', $order) }}"
                  onsubmit="return confirm('Yakin ingin mengajukan pesanan ini?')">
                @csrf
                <button type="submit" class="btn-success">
                    <i class="ti ti-send"></i>
                    Submit Pesanan
                </button>
            </form>
            @endif
            @if ($isDone)
            <a href="{{ route('user-orders.show', $order) }}#hasil" class="btn-primary">
                <i class="ti ti-download"></i>
                Unduh Laporan
            </a>
            @endif
        </div>
    </div>

    {{-- Alert Kontekstual --}}
    @if ($isRejected)
    <div class="alert alert-danger animate-in">
        <i class="ti ti-x-circle"></i>
        <div>
            <strong>Pesanan Ditolak</strong><br>
            Pesanan ini ditolak oleh admin. Silakan hubungi kami untuk informasi lebih lanjut atau ajukan pesanan baru.
        </div>
    </div>
    @elseif ($isFormRequired)
    <div class="alert alert-warning animate-in">
        <i class="ti ti-alert-triangle"></i>
        <div>
            <strong>Kelengkapan Dokumen Diperlukan</strong><br>
            Admin meminta Anda melengkapi data atau dokumen tambahan. Silakan periksa catatan pada pesanan dan segera tindak lanjuti.
        </div>
    </div>
    @elseif ($order->status === 'offered')
    <div class="alert alert-info animate-in">
        <i class="ti ti-file-invoice"></i>
        <div>
            <strong>Penawaran Tersedia</strong><br>
            Admin telah membuat penawaran untuk pesanan ini. Tinjau rincian biaya di bawah dan konfirmasi persetujuan Anda.
        </div>
    </div>
    @elseif ($isDone)
    <div class="alert alert-success animate-in">
        <i class="ti ti-circle-check"></i>
        <div>
            <strong>Pengujian Selesai</strong><br>
            Laporan hasil uji sudah tersedia. Unduh file di bawah atau berikan ulasan untuk membantu kami meningkatkan layanan.
        </div>
    </div>
    @endif

    {{-- Progress Stepper --}}
    @if (!$isRejected)
    <div class="stepper-card animate-in delay-1">
        <h2>Progress Pesanan</h2>
        <div class="stepper">
            @foreach ($steps as $i => $step)
            @php
                $isDoneStep   = ($currentIdx !== false) && $i < $currentIdx;
                $isActiveStep = ($currentIdx !== false) && $i === $currentIdx;
                $stepClass    = $isDoneStep ? 'done' : ($isActiveStep ? 'active' : '');
            @endphp
            <div class="step {{ $stepClass }}">
                <div class="step-node">
                    @if ($isDoneStep)
                        <i class="ti ti-check" style="font-size:13px;"></i>
                    @else
                        <i class="ti {{ $step['icon'] }}" style="font-size:13px;"></i>
                    @endif
                </div>
                @if (!$loop->last)
                    <div class="step-line"></div>
                @endif
                <span class="step-label">{{ $step['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Main Grid --}}
    <div class="detail-grid">

        {{-- ── LEFT COLUMN ── --}}
        <div>

            {{-- Informasi Umum --}}
            <div class="info-card animate-in delay-2">
                <div class="info-card-header">
                    <h3><i class="ti ti-info-circle"></i> Informasi Pesanan</h3>
                </div>
                <div class="info-card-body">
                    <div class="info-rows">
                        <div class="info-row">
                            <span class="info-row-label">Kode Pesanan</span>
                            <span class="info-row-value" style="font-family:monospace;">{{ $order->order_code }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-row-label">Status</span>
                            <span class="info-row-value">
                                <span class="badge badge-{{ $st['badge'] }}">
                                    <span class="badge-dot"></span>
                                    {{ $st['label'] }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-row-label">Tipe Pesanan</span>
                            <span class="info-row-value">{{ ucfirst($order->type) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-row-label">Tujuan Pengujian</span>
                            <span class="info-row-value">{{ $order->tujuan_pengujian ?? '—' }}</span>
                        </div>
                        <div class="info-divider"></div>
                        <div class="info-row">
                            <span class="info-row-label">Tanggal Dibuat</span>
                            <span class="info-row-value">{{ $order->created_at->translatedFormat('d F Y, H:i') }}</span>
                        </div>
                        @if ($order->waktu_diharapkan)
                        <div class="info-row">
                            <span class="info-row-label">Waktu Diharapkan</span>
                            <span class="info-row-value">
                                {{ \Carbon\Carbon::parse($order->waktu_diharapkan)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        @endif
                        @if ($order->keterangan_tambahan)
                        <div class="info-divider"></div>
                        <div class="info-row">
                            <span class="info-row-label">Keterangan Tambahan</span>
                            <span class="info-row-value" style="white-space:pre-line;">{{ $order->keterangan_tambahan }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Dokumen Pengajuan --}}
            @if ($hasFile)
            <div class="info-card animate-in delay-2">
                <div class="info-card-header">
                    <h3><i class="ti ti-paperclip"></i> Dokumen Pengajuan</h3>
                </div>
                <div class="info-card-body">
                    <div class="file-item">
                        <div class="file-icon"><i class="ti ti-file-type-pdf"></i></div>
                        <div>
                            <p class="file-name">{{ basename($order->file) }}</p>
                            <p class="file-size">Dokumen pengajuan</p>
                        </div>
                        <a href="{{ Storage::url($order->file) }}" target="_blank" class="file-dl">
                            <i class="ti ti-download"></i> Unduh
                        </a>
                    </div>
                </div>
            </div>
            @endif

            {{-- Detail Penawaran --}}
            @if ($order->offer && $order->offer->details->isNotEmpty())
            <div class="info-card animate-in delay-3">
                <div class="info-card-header">
                    <h3><i class="ti ti-file-invoice"></i> Rincian Penawaran</h3>
                    @if ($order->offer->created_at)
                    <span style="font-size:11.5px;color:var(--text-muted);">
                        {{ $order->offer->created_at->translatedFormat('d M Y') }}
                    </span>
                    @endif
                </div>
                <div style="overflow-x:auto;">
                    <table class="offer-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Parameter Uji</th>
                                <th class="text-right">Qty</th>

                                @if(in_array($order->status, ['offered', 'approved', 'processing', 'done']))
                                    <th class="text-right">Harga Satuan</th>
                                    <th class="text-right">Subtotal</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->offer->details as $i => $detail)
                            @php
                                $subtotal = $detail->qty * $detail->price;
                            @endphp
                            <tr>
                                <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                                <td>
                                    <div style="font-weight:600;">
                                        {{ $detail->package->name ?? $detail->name ?? '—' }}
                                    </div>

                                    @if (!empty($detail->note))
                                        <div style="font-size:11px;color:var(--text-muted);">
                                            {{ $detail->note }}
                                        </div>
                                    @endif
                                </td>

                                <td class="text-right">{{ $detail->qty }}</td>

                                @if(in_array($order->status, ['offered', 'approved', 'processing', 'done']))
                                    <td class="text-right">
                                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                                    </td>

                                    <td class="text-right" style="font-weight:600;">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        @if(in_array($order->status, ['offered', 'approved', 'processing', 'done']))
                        <tfoot>
                            <tr class="offer-total-row">
                                <td colspan="4" class="text-right">Total Biaya</td>
                                <td class="text-right">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Aksi jika masih offered --}}
                @if ($order->status === 'offered')
                <div style="padding:16px 20px;border-top:1px solid var(--divider);display:flex;gap:10px;justify-content:flex-end;">
                    <a href="#" class="btn-ghost">
                        <i class="ti ti-x"></i>
                        Tolak Penawaran
                    </a>
                    <a href="#" class="btn-primary">
                        <i class="ti ti-circle-check"></i>
                        Setujui Penawaran
                    </a>
                </div>
                @endif
            </div>
            @endif

            {{-- Hasil Uji --}}
            <div class="info-card animate-in delay-3" id="hasil">
                <div class="info-card-header">
                    <h3><i class="ti ti-report-analytics"></i> Hasil Pengujian</h3>
                </div>
                <div class="info-card-body">
                    @if ($hasilFiles->isNotEmpty())
                        @foreach ($hasilFiles as $file)
                        <div class="file-item">
                            <div class="file-icon"><i class="ti ti-file-type-pdf"></i></div>
                            <div>
                                <p class="file-name">{{ $file->original_name ?? basename($file->path) }}</p>
                                <p class="file-size">
                                    {{ $file->created_at->translatedFormat('d M Y') }}
                                </p>
                            </div>
                            <a href="{{ Storage::url($file->path) }}" target="_blank" class="file-dl">
                                <i class="ti ti-download"></i> Unduh
                            </a>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-inline">
                            <i class="ti ti-report-off"></i>
                            Hasil pengujian belum tersedia.<br>
                            @if (!$isDone)
                            File akan muncul di sini setelah pengujian selesai.
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Ulasan --}}
            @if ($isDone)
            <div class="info-card animate-in delay-4">
                <div class="info-card-header">
                    <h3><i class="ti ti-star"></i> Ulasan Layanan</h3>
                    @if ($canReview)
                    <a href="{{ route('user-orders.review', $order) }}" class="btn-ghost" style="padding:6px 12px;font-size:12px;">
                        <i class="ti ti-edit"></i>
                        Beri Ulasan
                    </a>
                    @endif
                </div>
                <div class="info-card-body">
                    @if ($reviews->isNotEmpty())
                        @foreach ($reviews as $review)
                        <div class="review-item">
                            <p class="review-question">{{ $review->reviewQuestion->question_text ?? 'Pertanyaan' }}</p>
                            <div class="stars">
                                @for ($s = 1; $s <= 5; $s++)
                                <span class="star {{ $s <= $review->rating->value ? 'filled' : '' }}">★</span>
                                @endfor
                            </div>
                            @if ($review->comment)
                            <div class="review-comment">"{{ $review->comment }}"</div>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <div class="empty-inline">
                            <i class="ti ti-star-off"></i>
                            Belum ada ulasan untuk pesanan ini.
                        </div>
                    @endif
                </div>
            </div>
            @endif

        </div>{{-- end left --}}

        {{-- ── RIGHT COLUMN (Sidebar) ── --}}
        <div class="sidebar-sticky">

            {{-- Ringkasan Biaya --}}
            @if(in_array($order->status, ['offered', 'approved', 'processing', 'done']))
            <div class="sidebar-summary animate-in delay-2">
                <div class="sidebar-summary-header">
                    <i class="ti ti-receipt"></i> Ringkasan Biaya
                </div>
                <div class="sidebar-rows">
                    <div class="sidebar-row">
                        <span class="s-label">Jumlah Parameter</span>
                        <span class="s-value">{{ $order->offer->details->count() }} item</span>
                    </div>
                    <div class="sidebar-row">
                        <span class="s-label">Subtotal</span>
                        <span class="s-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="sidebar-total">
                    <span class="t-label">Total</span>
                    <span class="t-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endif

            {{-- Status Timeline --}}
            <div class="info-card animate-in delay-3">
                <div class="info-card-header">
                    <h3><i class="ti ti-activity"></i> Riwayat Status</h3>
                </div>
                <div class="info-card-body" style="padding:16px 20px;">
                    <div class="timeline">

                        @if ($order->created_at)
                        <div class="timeline-item">
                            <div class="timeline-node active">
                                <i class="ti ti-pencil" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pesanan Dibuat</div>
                                <div class="timeline-time">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        @if ($order->sent_at)
                        <div class="timeline-item">
                            <div class="timeline-node active">
                                <i class="ti ti-send" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Penawaran Diajukan</div>
                                <div class="timeline-time">{{ $order->sent_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        @if ($order->offer && $order->offer->created_at)
                        <div class="timeline-item">
                            <div class="timeline-node active">
                                <i class="ti ti-file-invoice" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pesanan Diajukan</div>
                                <div class="timeline-time">{{ $order->offer->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        @if (in_array($order->status, ['approved', 'processing', 'done']) && $order->approved_at ?? false)
                        <div class="timeline-item">
                            <div class="timeline-node active">
                                <i class="ti ti-circle-check" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Penawaran Disetujui</div>
                                <div class="timeline-time">{{ $order->approved_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        @if ($isDone && $order->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-node active" style="background:#10B981;border-color:#10B981;">
                                <i class="ti ti-award" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Pengujian Selesai</div>
                                <div class="timeline-time">{{ $order->updated_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                        @if ($isRejected)
                        <div class="timeline-item">
                            <div class="timeline-node" style="background:#FEF2F2;border-color:#EF4444;color:#EF4444;">
                                <i class="ti ti-x" style="font-size:12px;"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title" style="color:#991B1B;">Pesanan Ditolak</div>
                                <div class="timeline-time">{{ $order->updated_at->translatedFormat('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Butuh Bantuan --}}
            <div class="info-card animate-in delay-4">
                <div class="info-card-header">
                    <h3><i class="ti ti-headset"></i> Butuh Bantuan?</h3>
                </div>
                <div class="info-card-body" style="font-size:12.5px;color:var(--text-secondary);line-height:1.6;">
                    <p style="margin:0 0 12px;">
                        Jika ada pertanyaan terkait pesanan ini, tim kami siap membantu.
                    </p>
                    <a href="mailto:admin@atmi.ac.id" class="btn-ghost" style="width:100%;justify-content:center;">
                        <i class="ti ti-mail"></i>
                        Hubungi Admin
                    </a>
                </div>
            </div>

        </div>{{-- end sidebar --}}

    </div>{{-- end detail-grid --}}

</div>{{-- end show-inner --}}
</div>{{-- end show-wrapper --}}

@endsection