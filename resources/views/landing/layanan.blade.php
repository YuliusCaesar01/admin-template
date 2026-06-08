{{-- resources/views/landing/layanan.blade.php --}}
@extends('layouts.landing')

@section('title', 'Layanan Pengujian Material')
@section('meta_description', 'Temukan layanan pengujian material lengkap kami — beton, tanah, baja, aspal, air, dan agregat. Berstandar SNI & ASTM, ditangani tenaga ahli bersertifikat.')

@push('styles')
<style>
    /* ─── CSS Variables ─────────────────────────────────── */
    :root {
        --orange-primary : #F28C28;
        --orange-hover   : #E67E22;
        --orange-active  : #D66B0D;
        --orange-light   : #FFF4E8;
        --orange-soft    : #FFF2E5;
        --orange-accent  : #FDBA74;
        --orange-border  : #FED7AA;
        --orange-badge   : #FFE7CC;
        --white          : #FFFFFF;
        --page-bg        : #FAFAF9;
        --border         : #E7E5E4;
        --divider        : #F5F5F4;
        --text-primary   : #292524;
        --text-secondary : #78716C;
        --text-muted     : #A8A29E;
        --text-hint      : #D6D3D1;
        --font-main      : 'DM Sans', sans-serif;
    }

    /* ─── Page Hero ─────────────────────────────────────── */
    .page-hero {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        padding: 40px 0 36px;
    }
    .page-hero-inner {
        max-width: 860px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .page-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }
    .page-breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color .15s;
    }
    .page-breadcrumb a:hover { color: var(--orange-primary); }
    .page-breadcrumb i { font-size: 11px; }
    .page-hero h1 {
        font-size: 26px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 10px;
        letter-spacing: -.4px;
    }
    .page-hero p {
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin: 0;
        max-width: 580px;
    }

    /* ─── Section ───────────────────────────────────────── */
    .section { padding: 48px 0 64px; }
    .section-inner {
        max-width: 1080px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .section-label {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--orange-primary);
        background: var(--orange-light);
        border: 1px solid var(--orange-border);
        padding: 4px 10px;
        border-radius: 20px;
        margin-bottom: 14px;
    }
    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 8px;
        letter-spacing: -.3px;
    }
    .section-subtitle {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin: 0;
        max-width: 560px;
    }

    /* ─── Tab + Slide Layout ────────────────────────────── */
    .layanan-wrapper {
        margin-top: 32px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }

    /* ── Tab Bar ── */
    .tab-bar {
        display: flex;
        align-items: stretch;
        background: var(--page-bg);
        border-bottom: 1px solid var(--border);
        overflow-x: auto;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
        gap: 0;
    }
    .tab-bar::-webkit-scrollbar { display: none; }

    .tab-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 13px 18px;
        font-family: var(--font-main);
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-secondary);
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        white-space: nowrap;
        transition: color .15s, border-color .15s, background .15s;
        position: relative;
        flex-shrink: 0;
        outline: none;
    }
    .tab-btn:hover {
        color: var(--orange-primary);
        background: var(--orange-light);
    }
    .tab-btn.active {
        color: var(--orange-active);
        border-bottom-color: var(--orange-primary);
        background: var(--white);
        font-weight: 600;
    }
    .tab-btn .tab-count {
        font-size: 10px;
        font-weight: 600;
        padding: 1px 6px;
        border-radius: 20px;
        background: var(--orange-badge);
        color: #C2410C;
        transition: background .15s;
    }
    .tab-btn.active .tab-count {
        background: var(--orange-primary);
        color: var(--white);
    }

    /* ── Slide Panels ── */
    .tab-panels { position: relative; }

    .tab-panel {
        display: none;
        padding: 24px;
        animation: fadeIn .22s ease both;
    }
    .tab-panel.active { display: block; }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Package Grid ── */
    .packages-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    /* ── Package Card ── */
    .package-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s, border-color .2s, transform .2s;
        position: relative;
    }
    .package-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: var(--orange-primary);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform .25s ease;
        border-radius: 14px 14px 0 0;
    }
    .package-card:hover::before { transform: scaleX(1); }
    .package-card:hover {
        box-shadow: 0 4px 24px rgba(242,140,40,.09);
        border-color: var(--orange-border);
        transform: translateY(-2px);
    }

    /* Card Image */
    .package-img-wrap {
        width: 100%;
        aspect-ratio: 16/9;
        background: var(--divider);
        overflow: hidden;
        flex-shrink: 0;
    }
    .package-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
        transition: transform .3s ease;
    }
    .package-card:hover .package-img-wrap img { transform: scale(1.04); }

    /* No-image placeholder */
    .package-img-placeholder {
        width: 100%;
        aspect-ratio: 16/9;
        background: var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .package-img-placeholder i {
        font-size: 28px;
        color: var(--orange-accent);
    }

    /* Card Body */
    .package-body {
        padding: 16px 16px 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .package-name {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 6px;
        letter-spacing: -.2px;
        line-height: 1.35;
    }
    .package-desc {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0 0 12px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Card Footer */
    .package-footer {
        border-top: 1px solid var(--divider);
        padding-top: 11px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-wrap: wrap;
    }
    .package-price-label {
        display: block;
        font-size: 10px;
        font-weight: 400;
        color: var(--text-muted);
        margin-bottom: 1px;
    }
    .package-price {
        font-size: 14px;
        font-weight: 600;
        color: var(--orange-active);
        letter-spacing: -.2px;
        white-space: nowrap;
    }
    .pkg-badge {
        font-size: 10px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .pkg-badge.active  { background: #D1FAE5; color: #065F46; }
    .pkg-badge.inactive{ background: var(--divider); color: var(--text-muted); }

    /* Unavailable card */
    .package-card.unavailable { opacity: .58; }

    /* ── Empty Panel ── */
    .panel-empty {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }
    .panel-empty i { font-size: 36px; margin-bottom: 10px; display: block; }
    .panel-empty p { font-size: 13px; margin: 0; }

    /* ── Slide nav arrows (mobile) ── */
    .slide-nav {
        display: none;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px 20px;
        gap: 8px;
    }
    .slide-arrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-family: var(--font-main);
        font-size: 12px;
        font-weight: 500;
        color: var(--text-secondary);
        background: var(--page-bg);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 7px 12px;
        cursor: pointer;
        transition: all .15s;
        outline: none;
    }
    .slide-arrow:hover:not(:disabled) {
        border-color: var(--orange-border);
        background: var(--orange-light);
        color: var(--orange-active);
    }
    .slide-arrow:disabled { opacity: .35; cursor: default; }
    .slide-indicator {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* ─── CTA Row ───────────────────────────────────────── */
    .cta-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-top: 40px;
        flex-wrap: wrap;
    }
    .btn-primary-lg {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 22px;
        font-family: var(--font-main); font-size: 13.5px; font-weight: 600;
        color: #fff; text-decoration: none;
        border-radius: 10px;
        background: var(--orange-primary);
        border: 1px solid transparent;
        transition: background .15s, transform .1s;
    }
    .btn-primary-lg:hover { background: var(--orange-hover); transform: translateY(-1px); }
    .btn-outline-lg {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 11px 20px;
        font-family: var(--font-main); font-size: 13.5px; font-weight: 500;
        color: var(--text-secondary); text-decoration: none;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: transparent;
        transition: all .15s;
    }
    .btn-outline-lg:hover {
        border-color: var(--orange-border);
        background: var(--orange-light);
        color: #C2410C;
    }

    /* ─── Responsive ─────────────────────────────────────── */
    @media (max-width: 900px) {
        .packages-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .packages-grid { grid-template-columns: 1fr; }
        .tab-btn { padding: 11px 14px; font-size: 12px; }
        .slide-nav { display: flex; }
        .page-hero h1 { font-size: 21px; }
    }
    @media (max-width: 420px) {
        .packages-grid { grid-template-columns: 1fr; }
        .tab-panel { padding: 16px; }
    }
</style>
@endpush

@section('content')

{{-- ── Page Hero ── --}}
<div class="page-hero">
    <div class="page-hero-inner">
        <div class="page-breadcrumb">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="ti ti-chevron-right"></i>
            <span>Layanan</span>
        </div>
        <h1>Layanan Pengujian Material</h1>
        <p>
            Laboratorium kami dilengkapi peralatan modern dan ditangani tenaga ahli
            bersertifikat untuk memastikan akurasi setiap pengujian material.
        </p>
    </div>
</div>

{{-- ── Main Content ── --}}
<section class="section" style="background:var(--page-bg);">
    <div class="section-inner">

        <div class="section-label" aria-hidden="true">
            <i class="ti ti-flask"></i>
            Paket Layanan
        </div>
        <h2 class="section-title">Pilih Layanan yang Anda Butuhkan</h2>
        <p class="section-subtitle">
            Kami menyediakan berbagai paket pengujian material. Klik kategori di bawah
            untuk melihat paket yang tersedia.
        </p>

        @if($categories->isEmpty())

            <div class="layanan-wrapper">
                <div class="panel-empty">
                    <i class="ti ti-mood-empty" aria-hidden="true"></i>
                    <p>Belum ada layanan yang tersedia saat ini.<br>Silakan hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            </div>

        @else

            @php
                // Filter hanya kategori yang punya paket
                $validCategories = $categories->filter(fn($c) => $c->packages->isNotEmpty())->values();
            @endphp

            @if($validCategories->isEmpty())

                <div class="layanan-wrapper">
                    <div class="panel-empty">
                        <i class="ti ti-mood-empty" aria-hidden="true"></i>
                        <p>Belum ada paket dalam kategori manapun.</p>
                    </div>
                </div>

            @else

                <div class="layanan-wrapper" id="layananWrapper">

                    {{-- ── Tab Bar ── --}}
                    <div class="tab-bar" role="tablist" aria-label="Kategori layanan">
                        @foreach($validCategories as $idx => $category)
                            <button
                                class="tab-btn {{ $idx === 0 ? 'active' : '' }}"
                                role="tab"
                                aria-selected="{{ $idx === 0 ? 'true' : 'false' }}"
                                aria-controls="panel-{{ $idx }}"
                                id="tab-{{ $idx }}"
                                data-tab="{{ $idx }}"
                                type="button"
                            >
                                {{ $category->nama_category }}
                                <span class="tab-count">{{ $category->packages->count() }}</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- ── Tab Panels ── --}}
                    <div class="tab-panels">

                        @foreach($validCategories as $idx => $category)
                            <div
                                class="tab-panel {{ $idx === 0 ? 'active' : '' }}"
                                id="panel-{{ $idx }}"
                                role="tabpanel"
                                aria-labelledby="tab-{{ $idx }}"
                            >
                                <div class="packages-grid">
                                    @foreach($category->packages as $i => $package)
                                        @php
                                            $isActive = $package->is_active;
                                        @endphp
                                        <article
                                            class="package-card {{ !$isActive ? 'unavailable' : '' }}"
                                            aria-label="{{ $package->name }}"
                                        >
                                            {{-- Image --}}
                                            @if($package->image_url)
                                                <div class="package-img-wrap">
                                                    <img
                                                        src="{{ $package->image_url }}"
                                                        alt="Ilustrasi {{ $package->name }}"
                                                        loading="lazy"
                                                    >
                                                </div>
                                            @else
                                                <div class="package-img-placeholder" aria-hidden="true">
                                                    <i class="ti ti-test-pipe"></i>
                                                </div>
                                            @endif

                                            {{-- Body --}}
                                            <div class="package-body">
                                                <h4 class="package-name">{{ $package->name }}</h4>

                                                @if($package->description)
                                                    <p class="package-desc">{{ $package->description }}</p>
                                                @else
                                                    <p class="package-desc" style="color:var(--text-hint);font-style:italic;">
                                                        Deskripsi belum tersedia.
                                                    </p>
                                                @endif

                                                <div class="package-footer">

                                                    @if($isActive)
                                                        <span class="pkg-badge active">
                                                            <i class="ti ti-check" aria-hidden="true"></i>
                                                            Tersedia
                                                        </span>
                                                    @else
                                                        <span class="pkg-badge inactive">
                                                            Tidak tersedia
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>{{-- /.packages-grid --}}
                            </div>{{-- /.tab-panel --}}
                        @endforeach

                    </div>{{-- /.tab-panels --}}

                    {{-- ── Mobile prev/next (shown via CSS on small screens) ── --}}
                    <div class="slide-nav" id="slideNav">
                        <button class="slide-arrow" id="btnPrev" type="button" disabled>
                            <i class="ti ti-chevron-left" aria-hidden="true"></i>
                            Sebelumnya
                        </button>
                        <span class="slide-indicator" id="slideIndicator" aria-live="polite">
                            1 / {{ $validCategories->count() }}
                        </span>
                        <button class="slide-arrow" id="btnNext" type="button">
                            Berikutnya
                            <i class="ti ti-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>{{-- /.layanan-wrapper --}}

            @endif
        @endif

        {{-- CTA --}}
        <div class="cta-row">
            <a href="{{ route('login') }}" class="btn-primary-lg">
                <i class="ti ti-login" aria-hidden="true"></i>
                Ajukan Pengujian Sekarang
            </a>
            <a href="{{ route('kontak') }}" class="btn-outline-lg">
                <i class="ti ti-message-circle" aria-hidden="true"></i>
                Konsultasi Dulu
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    const tabs    = document.querySelectorAll('.tab-btn');
    const panels  = document.querySelectorAll('.tab-panel');
    const btnPrev = document.getElementById('btnPrev');
    const btnNext = document.getElementById('btnNext');
    const indicator = document.getElementById('slideIndicator');
    const total   = tabs.length;
    let current   = 0;

    function goTo(idx) {
        // deactivate old
        tabs[current].classList.remove('active');
        tabs[current].setAttribute('aria-selected', 'false');
        panels[current].classList.remove('active');

        // activate new
        current = idx;
        tabs[current].classList.add('active');
        tabs[current].setAttribute('aria-selected', 'true');
        panels[current].classList.add('active');

        // scroll tab into view (mobile)
        tabs[current].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

        // update mobile nav
        if (btnPrev)   btnPrev.disabled   = current === 0;
        if (btnNext)   btnNext.disabled   = current === total - 1;
        if (indicator) indicator.textContent = (current + 1) + ' / ' + total;
    }

    // Tab click
    tabs.forEach(function (tab, idx) {
        tab.addEventListener('click', function () { goTo(idx); });
    });

    // Mobile arrows
    if (btnPrev) btnPrev.addEventListener('click', function () { if (current > 0) goTo(current - 1); });
    if (btnNext) btnNext.addEventListener('click', function () { if (current < total - 1) goTo(current + 1); });

    // Keyboard arrow navigation on tab bar
    tabs.forEach(function (tab, idx) {
        tab.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight' && idx < total - 1) { tabs[idx + 1].focus(); goTo(idx + 1); }
            if (e.key === 'ArrowLeft'  && idx > 0)         { tabs[idx - 1].focus(); goTo(idx - 1); }
        });
    });

    // Init state
    if (btnPrev) btnPrev.disabled = true;
    if (btnNext) btnNext.disabled = total <= 1;
})();
</script>
@endpush