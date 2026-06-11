@extends('layouts.landing')

@section('title', 'Ajukan Pengujian Baru')
@section('meta_description', 'Ajukan permintaan pengujian material baru secara online.')

<style>
    /* ══════════════════════════════════════
       Layout & Wrapper
    ══════════════════════════════════════ */
    .create-wrapper {
        min-height: calc(100vh - 62px);
        background: var(--page-bg);
        padding: 40px 24px 80px;
    }

    .create-inner {
        max-width: 760px;
        margin: 0 auto;
    }

    /* ══════════════════════════════════════
       Breadcrumb
    ══════════════════════════════════════ */
    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12.5px;
        color: var(--text-muted);
        margin-bottom: 28px;
    }

    .breadcrumb a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.15s;
    }

    .breadcrumb a:hover { color: var(--orange-primary); }
    .breadcrumb .sep    { font-size: 10px; }
    .breadcrumb .cur    { color: var(--text-secondary); font-weight: 500; }

    /* ══════════════════════════════════════
       Page Header
    ══════════════════════════════════════ */
    .create-header {
        margin-bottom: 32px;
    }

    .create-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 6px;
    }

    .create-header p {
        font-size: 13px;
        color: var(--text-secondary);
        margin: 0;
    }

    /* ══════════════════════════════════════
       Step Indicator
    ══════════════════════════════════════ */
    .steps-bar {
        display: flex;
        align-items: center;
        gap: 0;
        margin-bottom: 28px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 20px;
        overflow-x: auto;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        cursor: default;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
        transition: all 0.2s;
        border: 2px solid var(--border);
        background: var(--white);
        color: var(--text-muted);
    }

    .step-circle.active {
        background: var(--orange-primary);
        border-color: var(--orange-primary);
        color: #fff;
        box-shadow: 0 0 0 4px rgba(242,140,40,0.15);
    }

    .step-circle.done {
        background: #F0FDF4;
        border-color: #86EFAC;
        color: #166534;
    }

    .step-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-muted);
        transition: color 0.2s;
    }

    .step-label.active { color: var(--orange-primary); font-weight: 600; }
    .step-label.done   { color: #166534; }

    .step-connector {
        flex: 1;
        height: 2px;
        background: var(--divider);
        margin: 0 12px;
        min-width: 20px;
        border-radius: 2px;
        transition: background 0.3s;
    }

    .step-connector.done { background: #86EFAC; }

    /* ══════════════════════════════════════
       Card / Panel
    ══════════════════════════════════════ */
    .form-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 16px;
    }

    .form-card-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--divider);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-card-icon {
        width: 36px;
        height: 36px;
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

    .form-card-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 2px;
    }

    .form-card-subtitle {
        font-size: 11.5px;
        color: var(--text-secondary);
        margin: 0;
    }

    .form-card-body { padding: 24px; }

    /* ══════════════════════════════════════
       Form Elements
    ══════════════════════════════════════ */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-row.full { grid-template-columns: 1fr; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }

    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-label .req { color: #EF4444; }

    .form-control {
        width: 100%;
        padding: 10px 13px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-primary);
        background: var(--white);
        outline: none;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: var(--orange-primary);
        box-shadow: 0 0 0 3px rgba(242,140,40,0.10);
    }

    .form-control::placeholder { color: var(--text-muted); }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
        line-height: 1.6;
    }

    .form-hint {
        font-size: 11.5px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Error */
    .is-invalid { border-color: #EF4444 !important; }
    .invalid-feedback { font-size: 11.5px; color: #EF4444; }

    /* ══════════════════════════════════════
       Type Selector (Radio Cards)
    ══════════════════════════════════════ */
    .type-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .type-card {
        position: relative;
        cursor: pointer;
    }

    .type-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .type-card-inner {
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 18px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: all 0.15s;
        background: var(--white);
    }

    .type-card input:checked + .type-card-inner {
        border-color: var(--orange-primary);
        background: var(--orange-light);
        box-shadow: 0 0 0 3px rgba(242,140,40,0.10);
    }

    .type-card:hover .type-card-inner {
        border-color: var(--orange-border);
        background: var(--orange-light);
    }

    .type-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .type-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--orange-primary);
    }

    .type-card input:checked + .type-card-inner .type-icon {
        background: var(--orange-primary);
        color: #fff;
        border-color: var(--orange-primary);
    }

    .type-radio-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
    }

    .type-card input:checked + .type-card-inner .type-radio-dot {
        border-color: var(--orange-primary);
        background: var(--orange-primary);
    }

    .type-card input:checked + .type-card-inner .type-radio-dot::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #fff;
    }

    .type-card-name {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .type-card-desc {
        font-size: 11.5px;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
    }

    /* ══════════════════════════════════════
       File Upload Zone
    ══════════════════════════════════════ */
    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 28px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: var(--page-bg);
        position: relative;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: var(--orange-primary);
        background: var(--orange-light);
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon {
        font-size: 28px;
        color: var(--text-muted);
        margin-bottom: 10px;
    }

    .upload-zone:hover .upload-icon,
    .upload-zone.dragover .upload-icon {
        color: var(--orange-primary);
    }

    .upload-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .upload-sub {
        font-size: 11.5px;
        color: var(--text-muted);
        margin: 0;
    }

    .upload-preview {
        display: none;
        align-items: center;
        gap: 12px;
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 12px;
        text-align: left;
    }

    .upload-preview.show { display: flex; }

    .upload-preview-icon {
        font-size: 20px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .upload-preview-name {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-primary);
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .upload-preview-size {
        font-size: 11px;
        color: var(--text-muted);
    }

    .upload-preview-remove {
        cursor: pointer;
        color: var(--text-muted);
        font-size: 14px;
        padding: 2px;
        transition: color 0.15s;
        background: none;
        border: none;
    }

    .upload-preview-remove:hover { color: #EF4444; }

    /* ══════════════════════════════════════
       Cart Items (from session)
    ══════════════════════════════════════ */
    .cart-notice {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }

    .cart-notice-icon { font-size: 16px; color: #3B82F6; flex-shrink: 0; margin-top: 1px; }

    .cart-notice-text {
        font-size: 12.5px;
        color: #1D4ED8;
        line-height: 1.5;
    }

    .cart-notice-text strong { font-weight: 700; }

    .cart-items-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 10px;
    }

    .cart-item-row {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 10px 14px;
    }

    .cart-item-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--orange-primary);
        flex-shrink: 0;
    }

    .cart-item-name {
        flex: 1;
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-primary);
    }

    .cart-item-qty {
        font-size: 11.5px;
        color: var(--text-muted);
        background: var(--page-bg);
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid var(--divider);
    }

    /* ══════════════════════════════════════
       Action Bar
    ══════════════════════════════════════ */
    .action-bar {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        position: sticky;
        bottom: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    }

    .action-bar-left {
        font-size: 12.5px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .action-bar-left strong {
        color: var(--text-primary);
        display: block;
        font-size: 13px;
    }

    .action-bar-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--orange-primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 11px 22px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s;
    }

    .btn-primary:hover { background: #C2410C; color: #fff; }
    .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

    .btn-ghost {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-ghost:hover {
        border-color: var(--orange-border);
        color: var(--orange-primary);
        background: var(--orange-light);
    }

    /* ══════════════════════════════════════
       Alert (validation)
    ══════════════════════════════════════ */
    .alert-error {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
    }

    .alert-error-icon { font-size: 15px; color: #EF4444; flex-shrink: 0; }

    .alert-error-body { flex: 1; }

    .alert-error-title {
        font-size: 13px;
        font-weight: 700;
        color: #991B1B;
        margin: 0 0 6px;
    }

    .alert-error-body ul {
        margin: 0;
        padding-left: 16px;
        font-size: 12px;
        color: #B91C1C;
        line-height: 1.8;
    }

    /* ══════════════════════════════════════
       Responsive
    ══════════════════════════════════════ */
    @media (max-width: 640px) {
        .form-row         { grid-template-columns: 1fr; }
        .type-grid        { grid-template-columns: 1fr; }
        .steps-bar        { padding: 12px 16px; gap: 0; }
        .step-label       { display: none; }
        .action-bar       { flex-direction: column; align-items: stretch; }
        .action-bar-right { flex-direction: column; }
        .action-bar-right .btn-primary,
        .action-bar-right .btn-ghost { justify-content: center; }
    }

    /* Category Tabs */
    .category-tabs {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .cat-tab {
        padding: 6px 16px;
        border-radius: 999px;
        border: 1.5px solid var(--border-color, #e2e8f0);
        background: transparent;
        font-size: 13px;
        cursor: pointer;
        transition: all .2s;
        color: var(--text-muted, #64748b);
    }
    .cat-tab.active,
    .cat-tab:hover {
        background: var(--orange-primary);
        border-color: var(--orange-primary);
        color: #fff;
    }

    /* Package Grid */
    .package-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }
    .pkg-card {
        position: relative;
        border: 2px solid var(--border-color, #e2e8f0);
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        transition: border-color .2s, box-shadow .2s, transform .15s;
        background: var(--card-bg, #fff);
    }
    .pkg-card:hover {
        border-color: var(--orange-primary);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,.08);
    }
    .pkg-card.selected {
        border-color: var(--orange-primary);
        background: color-mix(in srgb, var(--orange-primary) 5%, transparent);
    }
    .pkg-check {
        position: absolute;
        top: 10px; right: 10px;
        width: 22px; height: 22px;
        border-radius: 50%;
        background: var(--orange-primary);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px;
        opacity: 0;
        transform: scale(.7);
        transition: opacity .2s, transform .2s;
    }
    .pkg-card.selected .pkg-check {
        opacity: 1;
        transform: scale(1);
    }
    .pkg-img {
        width: 100%; height: 130px;
        object-fit: cover;
    }
    .pkg-img-placeholder {
        width: 100%; height: 100px;
        display: flex; align-items: center; justify-content: center;
        background: var(--surface-muted, #f8fafc);
        font-size: 28px;
        color: var(--text-muted, #94a3b8);
    }
    .pkg-info { padding: 12px; }
    .pkg-category {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: var(--orange-primary);
        font-weight: 600;
    }
    .pkg-name {
        font-size: 14px;
        font-weight: 600;
        margin: 4px 0;
        color: var(--text-primary, #1e293b);
        line-height: 1.3;
    }
    .pkg-desc {
        font-size: 12px;
        color: var(--text-muted, #64748b);
        margin-bottom: 8px;
        line-height: 1.5;
    }
    .pkg-price {
        font-size: 13px;
        font-weight: 700;
        color: var(--orange-primary);
    }

    /* Selected Summary */
    .selected-summary {
        margin-top: 14px;
        padding: 10px 16px;
        background: color-mix(in srgb, var(--orange-primary) 10%, transparent);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: var(--orange-primary);
    }
</style>

@section('content')
<div class="create-wrapper">
<div class="create-inner">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb animate-in" aria-label="breadcrumb">
        <a href="{{ route('landing') }}">
            <i class="ti ti-home-2" aria-hidden="true"></i>
        </a>
        <span class="sep"><i class="ti ti-chevron-right"></i></span>
        <a href="{{ route('user-orders.index') }}">Pesanan Saya</a>
        <span class="sep"><i class="ti ti-chevron-right"></i></span>
        <span class="cur">Ajukan Pengujian Baru</span>
    </nav>

    {{-- Page Header --}}
    <div class="create-header animate-in delay-1">
        <h1>Ajukan Pengujian Baru</h1>
        <p>Isi formulir di bawah untuk memulai permintaan pengujian material Anda.</p>
    </div>

    {{-- Step Indicator --}}
    <div class="steps-bar animate-in delay-2">
        <div class="step-item">
            <div class="step-circle active">1</div>
            <span class="step-label active">Informasi Dasar</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle">2</div>
            <span class="step-label">Review Admin</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle">3</div>
            <span class="step-label">Persetujuan</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle">4</div>
            <span class="step-label">Pengujian</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-circle">5</div>
            <span class="step-label">Laporan</span>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
    <div class="alert-error animate-in" role="alert">
        <i class="ti ti-alert-circle alert-error-icon" aria-hidden="true"></i>
        <div class="alert-error-body">
            <p class="alert-error-title">Mohon periksa kembali isian Anda:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Cart Notice --}}
    @if (!empty($cartItems))
    <div class="cart-notice animate-in delay-2">
        <i class="ti ti-shopping-cart cart-notice-icon" aria-hidden="true"></i>
        <div class="cart-notice-text">
            <strong>{{ count($cartItems) }} item dari keranjang Anda</strong> akan diikatkan ke pesanan ini setelah disubmit oleh admin.
            <div class="cart-items-list">
                @foreach ($cartItems as $item)
                <div class="cart-item-row">
                    <div class="cart-item-dot"></div>
                    <span class="cart-item-name">{{ $item['name'] ?? 'Paket Pengujian' }}</span>
                    <span class="cart-item-qty">× {{ $item['qty'] ?? 1 }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('user-orders.store') }}"
        enctype="multipart/form-data"
        x-data="orderForm()"
        @submit="isSubmitting = true"
        novalidate
        >
        @csrf

        {{-- ─── Card 1: Pilih Paket (hanya jika tidak dari keranjang) ─── --}}
        @if (empty($cartItems))
        <div class="form-card animate-in delay-2" x-data="packagePicker()">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="ti ti-package" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="form-card-title">Pilih Paket Pengujian</p>
                    <p class="form-card-subtitle">Pilih satu atau lebih paket yang ingin diajukan</p>
                </div>
            </div>
            <div class="form-card-body">

                {{-- Filter Category --}}
                <div class="category-tabs">
                    <button type="button"
                        class="cat-tab"
                        :class="{ active: activeCategory === null }"
                        @click="activeCategory = null">
                        Semua
                    </button>
                    @foreach ($categories as $category)
                    <button type="button"
                        class="cat-tab"
                        :class="{ active: activeCategory === {{ $category->id }} }"
                        @click="activeCategory = {{ $category->id }}">
                        {{ $category->nama_category }}
                    </button>
                    @endforeach
                </div>

                {{-- Package Grid --}}
                <div class="package-grid">
                    @foreach ($categories as $category)
                        @foreach ($category->packages as $pkg)
                        <div class="pkg-card"
                            x-show="activeCategory === null || activeCategory === {{ $category->id }}"
                            :class="{ selected: isSelected({{ $pkg->id }}) }"
                            @click="togglePackage({{ $pkg->id }}, '{{ addslashes($pkg->name) }}')">
                            
                            <input type="checkbox"
                                name="package_ids[]"
                                value="{{ $pkg->id }}"
                                :checked="isSelected({{ $pkg->id }})"
                                style="display:none;">

                            <div class="pkg-check">
                                <i class="ti ti-check" aria-hidden="true"></i>
                            </div>

                            @if ($pkg->image)
                            <img src="{{ $pkg->imageUrl }}" alt="{{ $pkg->name }}" class="pkg-img">
                            @else
                            <div class="pkg-img-placeholder">
                                <i class="ti ti-flask" aria-hidden="true"></i>
                            </div>
                            @endif

                            <div class="pkg-info">
                                <span class="pkg-category">{{ $category->nama_category }}</span>
                                <p class="pkg-name">{{ $pkg->name }}</p>
                                @if ($pkg->description)
                                <p class="pkg-desc">{{ Str::limit($pkg->description, 80) }}</p>
                                @endif
                                @if ($pkg->base_price > 0)
                                <p class="pkg-price">Rp {{ number_format($pkg->base_price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>

                {{-- Selected Summary --}}
                <div class="selected-summary" x-show="selected.length > 0" style="display:none;">
                    <i class="ti ti-shopping-cart" aria-hidden="true"></i>
                    <span x-text="selected.length + ' paket dipilih'"></span>
                </div>

                @error('package_ids')
                    <p class="invalid-feedback" style="margin-top:8px;">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @endif

        {{-- ─── Card 2: Detail Pengujian ─── --}}
        <div class="form-card animate-in delay-3">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="ti ti-clipboard-text" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="form-card-title">Detail Pengujian</p>
                    <p class="form-card-subtitle">Informasi tentang tujuan dan jadwal pengujian</p>
                </div>
            </div>
            <div class="form-card-body">

                {{-- Tujuan Pengujian --}}
                <div class="form-row full" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label for="tujuan_pengujian" class="form-label">
                            Tujuan Pengujian
                            <span class="req" aria-hidden="true"> *</span>
                        </label>
                        <input
                            type="text"
                            id="tujuan_pengujian"
                            name="tujuan_pengujian"
                            class="form-control @error('tujuan_pengujian') is-invalid @enderror"
                            placeholder="cth: Uji kuat tekan beton untuk proyek jembatan"
                            value="{{ old('tujuan_pengujian') }}"
                            maxlength="500"
                            required
                        >
                        @error('tujuan_pengujian')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @else
                            <p class="form-hint">Jelaskan tujuan pengujian secara singkat namun jelas (maks. 500 karakter).</p>
                        @enderror
                    </div>
                </div>

                {{-- Waktu Diharapkan --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="waktu_diharapkan" class="form-label">Waktu Penyelesaian Diharapkan</label>
                        <input
                            type="date"
                            id="waktu_diharapkan"
                            name="waktu_diharapkan"
                            class="form-control @error('waktu_diharapkan') is-invalid @enderror"
                            value="{{ old('waktu_diharapkan') }}"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                        >
                        @error('waktu_diharapkan')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @else
                            <p class="form-hint">Opsional — biarkan kosong jika fleksibel.</p>
                        @enderror
                    </div>

                    {{-- Placeholder kolom kanan — bisa diisi field lain di masa depan --}}
                    <div></div>
                </div>

            </div>
        </div>

        {{-- ─── Card 3: Keterangan & Lampiran ─── --}}
        <div class="form-card animate-in delay-3">
            <div class="form-card-header">
                <div class="form-card-icon">
                    <i class="ti ti-notes" aria-hidden="true"></i>
                </div>
                <div>
                    <p class="form-card-title">Keterangan Tambahan & Lampiran</p>
                    <p class="form-card-subtitle">Informasi pelengkap dan dokumen pendukung (opsional)</p>
                </div>
            </div>
            <div class="form-card-body">

                {{-- Keterangan --}}
                <div class="form-row full" style="margin-bottom:20px;">
                    <div class="form-group">
                        <label for="keterangan_tambahan" class="form-label">Keterangan Tambahan</label>
                        <textarea
                            id="keterangan_tambahan"
                            name="keterangan_tambahan"
                            class="form-control @error('keterangan_tambahan') is-invalid @enderror"
                            placeholder="Tulis keterangan, instruksi khusus, atau informasi tambahan yang perlu diketahui admin…"
                            rows="4"
                        >{{ old('keterangan_tambahan') }}</textarea>
                        @error('keterangan_tambahan')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- File Upload --}}
                <div class="form-group">
                    <label class="form-label">Lampiran Dokumen</label>
                    <div
                        class="upload-zone"
                        :class="{ 'dragover': isDragging }"
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)"
                    >
                        <input
                            type="file"
                            id="file"
                            name="file"
                            accept=".pdf,.doc,.docx"
                            @change="handleFileChange($event)"
                        >
                        <div x-show="!fileName">
                            <div class="upload-icon">
                                <i class="ti ti-cloud-upload" aria-hidden="true"></i>
                            </div>
                            <p class="upload-title">Klik atau seret file ke sini</p>
                            <p class="upload-sub">PDF, DOC, DOCX — Maks. 10 MB</p>
                        </div>
                        <div x-show="fileName" style="display:none;">
                            <div class="upload-icon">
                                <i class="ti ti-file-check" style="color:var(--orange-primary);" aria-hidden="true"></i>
                            </div>
                            <p class="upload-title" x-text="fileName">—</p>
                            <p class="upload-sub" x-text="fileSize">—</p>
                        </div>
                    </div>

                    {{-- File Preview --}}
                    <div class="upload-preview" :class="{ 'show': fileName }">
                        <i class="ti ti-file-text upload-preview-icon" aria-hidden="true"></i>
                        <span class="upload-preview-name" x-text="fileName">—</span>
                        <span class="upload-preview-size" x-text="fileSize">—</span>
                        <button
                            type="button"
                            class="upload-preview-remove"
                            @click="clearFile()"
                            aria-label="Hapus file"
                        >
                            <i class="ti ti-x" aria-hidden="true"></i>
                        </button>
                    </div>

                    @error('file')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @else
                        <p class="form-hint">Lampirkan dokumen spesifikasi, surat pengantar, atau referensi terkait (opsional).</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- ─── Action Bar (Sticky) ─── --}}
        <div class="action-bar animate-in delay-3">
            <div class="action-bar-left">
                <strong>Siap mengajukan?</strong>
                Pesanan akan tersimpan sebagai draft dan bisa disubmit kapan saja.
            </div>
            <div class="action-bar-right">
                <a href="{{ route('user-orders.index') }}" class="btn-ghost">
                    <i class="ti ti-arrow-left" aria-hidden="true"></i>
                    Batal
                </a>
                <button type="submit" class="btn-primary" :disabled="isSubmitting">
                    <i class="ti ti-device-floppy" aria-hidden="true" x-show="!isSubmitting"></i>
                    <i class="ti ti-loader-2" aria-hidden="true" x-show="isSubmitting" style="animation:spin 1s linear infinite;"></i>
                    <span x-text="isSubmitting ? 'Menyimpan…' : 'Simpan Pesanan'">Simpan Pesanan</span>
                </button>
            </div>
        </div>

    </form>

</div>
</div>

{{-- Alpine Component --}}
<script>
function orderForm() {
    return {
        type: '{{ old('type', 'internal') }}',
        fileName: '',
        fileSize: '',
        isDragging: false,
        isSubmitting: false,

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) this.setFile(file);
        },

        handleDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                // Inject into the actual input
                const input = document.getElementById('file');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
                this.setFile(file);
            }
        },

        setFile(file) {
            const allowed = ['application/pdf', 'application/msword',
                             'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

            if (!allowed.includes(file.type)) {
                alert('Format tidak didukung. Gunakan PDF, DOC, atau DOCX.');
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file melebihi batas 10 MB.');
                return;
            }

            this.fileName = file.name;
            this.fileSize = this.formatBytes(file.size);
        },

        clearFile() {
            const input = document.getElementById('file');
            input.value = '';
            this.fileName = '';
            this.fileSize = '';
        },

        formatBytes(bytes) {
            if (bytes < 1024)       return bytes + ' B';
            if (bytes < 1048576)    return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / 1048576).toFixed(1) + ' MB';
        },
    };
}

function packagePicker() {
    return {
        activeCategory: null,
        selected: [],
        isSelected(id) { return this.selected.includes(id); },
        togglePackage(id, name) {
            const idx = this.selected.indexOf(id);
            if (idx === -1) this.selected.push(id);
            else this.selected.splice(idx, 1);
        },
    };
}
</script>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

@endsection