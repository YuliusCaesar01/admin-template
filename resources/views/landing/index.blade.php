{{-- resources/views/home.blade.php --}}
@extends('layouts.landing')

@section('title', 'Pengujian Material Profesional & Terakreditasi')
@section('meta_description', 'Laboratorium pengujian material terpercaya. Uji beton, tanah, baja, aspal dengan standar SNI & ISO 17025. Hasil cepat, akurat, dan bersertifikat.')

@push('styles')
<style>
    /* ─── Hero ──────────────────────────────────────────── */
    .hero {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        overflow: hidden;
        position: relative;
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(var(--divider) 1px, transparent 1px),
            linear-gradient(90deg, var(--divider) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
        opacity: 0.6;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 120px;
        background: linear-gradient(to bottom, transparent, var(--white));
        pointer-events: none;
    }

    .hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 80px 24px 72px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 56px;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px 5px 8px;
        border-radius: 20px;
        background: var(--orange-badge);
        border: 1px solid var(--orange-border);
        font-size: 11px;
        font-weight: 600;
        color: #C2410C;
        margin-bottom: 18px;
    }

    .hero-badge .badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--orange-primary);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(0.85); }
    }

    .hero-title {
        font-size: clamp(28px, 4.5vw, 48px);
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.8px;
        line-height: 1.15;
        margin: 0 0 16px;
    }

    .hero-title .accent { color: var(--orange-primary); }

    .hero-desc {
        font-size: 14.5px;
        color: var(--text-secondary);
        line-height: 1.65;
        margin: 0 0 28px;
        max-width: 480px;
    }

    .hero-cta {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-primary-lg {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        font-family: var(--font-main);
        font-size: 13.5px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        border-radius: 10px;
        background: var(--orange-primary);
        border: 1px solid transparent;
        cursor: pointer;
        transition: background 0.15s, transform 0.1s;
    }

    .btn-primary-lg:hover { background: var(--orange-hover); transform: translateY(-1px); }

    .btn-outline-lg {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 20px;
        font-family: var(--font-main);
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        border-radius: 10px;
        border: 1px solid var(--border);
        background: transparent;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-outline-lg:hover {
        border-color: var(--orange-border);
        background: var(--orange-light);
        color: #C2410C;
    }

    .hero-trust {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid var(--divider);
        flex-wrap: wrap;
    }

    .trust-stat { display: flex; flex-direction: column; }
    .trust-stat strong {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.4px;
    }
    .trust-stat span { font-size: 11px; color: var(--text-muted); }
    .trust-divider { width: 1px; height: 32px; background: var(--border); }

    /* Hero Visual */
    .hero-visual { display: flex; flex-direction: column; gap: 12px; }

    .lab-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        transition: box-shadow 0.2s, transform 0.2s;
    }

    .lab-card:hover { box-shadow: 0 4px 20px rgba(242,140,40,0.1); transform: translateY(-2px); }

    .lab-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .lab-card-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }

    .status-badge.active { background: #ECFDF5; color: #065F46; }
    .status-badge.pending { background: var(--orange-badge); color: #92400E; }

    .status-badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .status-badge.active .status-badge-dot { background: #10B981; }
    .status-badge.pending .status-badge-dot { background: var(--orange-primary); }

    .progress-list { display: flex; flex-direction: column; gap: 10px; }

    .progress-item {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 6px 10px;
        align-items: center;
    }

    .progress-item span:first-child { font-size: 12px; color: var(--text-secondary); }
    .progress-item span:last-child { font-size: 11px; font-weight: 600; color: var(--text-primary); }

    .progress-bar-track {
        grid-column: 1 / -1;
        height: 5px;
        background: var(--divider);
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 10px;
        background: var(--orange-primary);
    }

    .result-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid var(--divider);
    }

    .result-row:last-child { border-bottom: none; }

    .result-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .result-label { flex: 1; font-size: 12px; color: var(--text-secondary); }
    .result-value { font-size: 12.5px; font-weight: 600; color: var(--text-primary); }

    .result-pass {
        font-size: 10px;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .result-pass.ok { background: #ECFDF5; color: #065F46; }
    .result-pass.warn { background: var(--orange-badge); color: #92400E; }

    /* ─── Stats Strip ───────────────────────────────────── */
    .stats-strip {
        background: var(--white);
        border-bottom: 1px solid var(--border);
    }

    .stats-grid {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .stat-item {
        padding: 28px 0;
        display: flex;
        align-items: center;
        gap: 14px;
        border-right: 1px solid var(--divider);
    }

    .stat-item:last-child { border-right: none; }

    .stat-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--orange-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: var(--orange-primary);
        flex-shrink: 0;
    }

    .stat-content strong {
        display: block;
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.5px;
        line-height: 1;
        margin-bottom: 3px;
    }

    .stat-content span { font-size: 12px; color: var(--text-muted); }

    /* ─── CTA Banner ────────────────────────────────────── */
    .cta-section { background: var(--white); padding: 72px 0; }

    .cta-banner { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

    .cta-inner {
        background: var(--orange-primary);
        border-radius: 20px;
        padding: 52px 56px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 32px;
        position: relative;
        overflow: hidden;
    }

    .cta-inner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    .cta-inner::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 40%;
        width: 280px; height: 280px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        pointer-events: none;
    }

    .cta-text h2 {
        font-size: clamp(20px, 3vw, 28px);
        font-weight: 700;
        color: #fff;
        margin: 0 0 8px;
        letter-spacing: -0.4px;
    }

    .cta-text p {
        font-size: 13.5px;
        color: rgba(255,255,255,0.8);
        margin: 0;
        line-height: 1.6;
        max-width: 460px;
    }

    .cta-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .btn-white {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        font-family: var(--font-main);
        font-size: 13.5px;
        font-weight: 600;
        color: var(--orange-primary);
        text-decoration: none;
        border-radius: 10px;
        background: #fff;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-white:hover { background: var(--orange-soft); }

    .btn-white-outline {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 20px;
        font-family: var(--font-main);
        font-size: 13.5px;
        font-weight: 500;
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        border-radius: 10px;
        background: transparent;
        border: 1px solid rgba(255,255,255,0.35);
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-white-outline:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.6);
    }

    /* ─── Responsive ─────────────────────────────────────── */
    @media (max-width: 900px) {
        .hero-inner { grid-template-columns: 1fr; }
        .hero-visual { display: none; }
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .stat-item { border-right: none; border-bottom: 1px solid var(--divider); padding: 20px 0; }
        .cta-inner { flex-direction: column; padding: 36px 28px; }
    }

    @media (max-width: 560px) {
        .hero-inner { padding: 48px 24px; }
        .stats-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

<!-- ══════════════════════════════════
     HERO
══════════════════════════════════ -->
<section class="hero">
    <div class="hero-inner">

        <div class="hero-copy animate-in">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                Laboratorium Aktif & Beroperasi
            </div>

            <h1 class="hero-title">
                Pengujian Material<br>
                <span class="accent">Tepat & Terpercaya</span>
            </h1>

            <p class="hero-desc">
                Kami menyediakan layanan pengujian material berstandar SNI dan ISO 17025
                untuk sektor konstruksi, infrastruktur, dan manufaktur. Hasil akurat,
                laporan resmi, dan waktu pengerjaan cepat.
            </p>

            <div class="hero-cta">
                <a href="{{ route('login') }}" class="btn-primary-lg">
                    <i class="ti ti-login" aria-hidden="true"></i>
                    Login
                </a>
                <a href="{{ route('layanan') }}" class="btn-outline-lg">
                    <i class="ti ti-list-search" aria-hidden="true"></i>
                    Lihat Layanan
                </a>
            </div>

            <div class="hero-trust">
                <div class="trust-stat">
                    <strong>12.500+</strong>
                    <span>Sampel Diuji</span>
                </div>
                <div class="trust-divider"></div>
                <div class="trust-stat">
                    <strong>98.7%</strong>
                    <span>Akurasi Hasil</span>
                </div>
                <div class="trust-divider"></div>
                <div class="trust-stat">
                    <strong>3–5 Hari</strong>
                    <span>Waktu Pengerjaan</span>
                </div>
            </div>
        </div>

        <!-- Hero Visual -->
        <div class="hero-visual animate-in delay-2">
            <div class="lab-card">
                <div class="lab-card-header">
                    <span class="lab-card-title">Pengujian Aktif Hari Ini</span>
                    <span class="status-badge active">
                        <span class="status-badge-dot"></span>
                        Live
                    </span>
                </div>
                <div class="progress-list">
                    <div class="progress-item">
                        <span>Kuat Tekan Beton</span>
                        <span>87%</span>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width:87%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <span>Uji CBR Tanah</span>
                        <span>62%</span>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width:62%"></div>
                        </div>
                    </div>
                    <div class="progress-item">
                        <span>Tarik Baja Tulangan</span>
                        <span>44%</span>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill" style="width:44%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lab-card">
                <div class="lab-card-header">
                    <span class="lab-card-title">Hasil Terbaru</span>
                    <span class="status-badge pending">
                        <span class="status-badge-dot"></span>
                        3 Baru
                    </span>
                </div>
                <div>
                    <div class="result-row">
                        <div class="result-icon"><i class="ti ti-box"></i></div>
                        <span class="result-label">Beton K-350, 28 hari</span>
                        <span class="result-value">378 kg/cm²</span>
                        <span class="result-pass ok">LULUS</span>
                    </div>
                    <div class="result-row">
                        <div class="result-icon"><i class="ti ti-layers"></i></div>
                        <span class="result-label">Aspal AC-WC Stabilitas</span>
                        <span class="result-value">1.240 kg</span>
                        <span class="result-pass ok">LULUS</span>
                    </div>
                    <div class="result-row">
                        <div class="result-icon"><i class="ti ti-bolt"></i></div>
                        <span class="result-label">Baja D16 fy min</span>
                        <span class="result-value">410 MPa</span>
                        <span class="result-pass warn">TINJAU</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- ══════════════════════════════════
     STATS STRIP
══════════════════════════════════ -->
<div class="stats-strip">
    <div class="stats-grid">
        <div class="stat-item animate-in">
            <div class="stat-icon-box"><i class="ti ti-flask"></i></div>
            <div class="stat-content">
                <strong>12.500+</strong>
                <span>Sampel Diuji</span>
            </div>
        </div>
        <div class="stat-item animate-in delay-1">
            <div class="stat-icon-box"><i class="ti ti-users"></i></div>
            <div class="stat-content">
                <strong>840+</strong>
                <span>Klien Terdaftar</span>
            </div>
        </div>
        <div class="stat-item animate-in delay-2">
            <div class="stat-icon-box"><i class="ti ti-certificate"></i></div>
            <div class="stat-content">
                <strong>24</strong>
                <span>Parameter Terakreditasi</span>
            </div>
        </div>
        <div class="stat-item animate-in delay-3">
            <div class="stat-icon-box"><i class="ti ti-clock"></i></div>
            <div class="stat-content">
                <strong>3–5 Hari</strong>
                <span>Rata-rata Selesai</span>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════
     CTA BANNER
══════════════════════════════════ -->
<div class="cta-section">
    <div class="cta-banner">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Siap Memulai Pengujian Material?</h2>
                <p>
                    Masuk ke portal dan ajukan permintaan pengujian langsung ke tim ahli kami.
                    Pengiriman sampel gratis untuk area Jabodetabek.
                </p>
            </div>
            <div class="cta-actions">
                <a href="{{ route('login') }}" class="btn-white">
                    <i class="ti ti-login" aria-hidden="true"></i>
                    Login
                </a>
                <a href="https://wa.me/628001234567" class="btn-white-outline" target="_blank" rel="noopener">
                    <i class="ti ti-brand-whatsapp" aria-hidden="true"></i>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</div>

@endsection