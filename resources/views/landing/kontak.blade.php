@extends('layouts.landing')

@section('title', 'Kontak')

@push('styles')
<style>
    /* ── Hero ──────────────────────────────────────── */
    .contact-hero {
        background: var(--white);
        border-bottom: 1px solid var(--border);
        padding: 56px 0 52px;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(var(--divider) 1px, transparent 1px),
            linear-gradient(90deg, var(--divider) 1px, transparent 1px);
        background-size: 40px 40px;
        opacity: 0.55;
        pointer-events: none;
    }

    .contact-hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 80px;
        background: linear-gradient(to bottom, transparent, var(--white));
        pointer-events: none;
    }

    .contact-hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        position: relative;
        z-index: 1;
    }

    /* ── Main Content ────────────────────────────────── */
    .contact-section {
        padding: 64px 0 80px;
    }

    .contact-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 48px;
        align-items: start;
    }

    /* ── Info Cards ─────────────────────────────────── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    .info-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .info-card:hover {
        border-color: var(--orange-border);
        box-shadow: 0 4px 16px rgba(242,140,40,0.08);
    }

    .info-card-icon {
        width: 36px;
        height: 36px;
        background: var(--orange-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
        color: var(--orange-primary);
        font-size: 17px;
    }

    .info-card-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    .info-card-value {
        font-size: 13.5px;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.5;
    }

    .info-card-value a {
        color: inherit;
        text-decoration: none;
        transition: color 0.15s;
    }

    .info-card-value a:hover { color: var(--orange-primary); }

    .info-card-sub {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 3px;
    }

    /* Social card spans full width */
    .info-card-full {
        grid-column: 1 / -1;
    }

    .social-links {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }

    .social-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        border-radius: 8px;
        border: 1px solid var(--border);
        background: var(--white);
        font-size: 12.5px;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.15s;
    }

    .social-link:hover {
        background: var(--orange-light);
        border-color: var(--orange-border);
        color: #C2410C;
    }

    .social-link i { font-size: 15px; }

    /* ── Map ────────────────────────────────────────── */
    .map-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    .map-card iframe {
        width: 100%;
        height: 220px;
        display: block;
        border: 0;
        filter: grayscale(15%);
    }

    .map-card-footer {
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-top: 1px solid var(--divider);
    }

    .map-card-footer p {
        font-size: 12px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }

    .map-card-footer a {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
        color: var(--orange-primary);
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
        transition: color 0.15s;
    }

    .map-card-footer a:hover { color: #C2410C; }

    /* ── Contact Form ────────────────────────────────── */
    .form-card {
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        position: sticky;
        top: 80px;
    }

    .form-card-header {
        margin-bottom: 22px;
    }

    .form-card-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .form-card-header p {
        font-size: 12.5px;
        color: var(--text-muted);
        margin: 0;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 500;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-input {
        width: 100%;
        border: 1px solid var(--border);
        border-radius: 8px;
        background: var(--white);
        padding: 9px 12px 9px 36px;
        font-size: 13px;
        color: var(--text-primary);
        font-family: var(--font-main);
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
        box-sizing: border-box;
    }

    .form-input:focus {
        border-color: #fb923c;
        box-shadow: 0 0 0 3px rgba(251,146,60,0.18);
    }

    .form-input::placeholder { color: var(--text-hint); }

    .form-input-wrap {
        position: relative;
    }

    .form-input-wrap .form-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 14px;
        pointer-events: none;
    }

    .form-input-wrap.textarea-wrap .form-icon {
        top: 11px;
        transform: none;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 110px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .form-input-no-icon {
        padding-left: 12px;
    }

    .btn-submit {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        background: var(--orange-primary);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: var(--font-main);
        cursor: pointer;
        transition: background 0.15s;
        margin-top: 18px;
    }

    .btn-submit:hover { background: var(--orange-hover); }
    .btn-submit:active { background: var(--orange-active); }

    /* ── Facilities strip ───────────────────────────── */
    .facilities-strip {
        background: var(--white);
        border-top: 1px solid var(--border);
        padding: 28px 0;
    }

    .facilities-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .facilities-label {
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: var(--text-muted);
        margin-right: 4px;
        flex-shrink: 0;
    }

    .facility-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 20px;
        background: var(--divider);
        font-size: 12px;
        font-weight: 500;
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.15s;
        border: 1px solid var(--border);
    }

    .facility-link:hover {
        background: var(--orange-light);
        border-color: var(--orange-border);
        color: #C2410C;
    }

    /* ── Responsive ─────────────────────────────────── */
    @media (max-width: 900px) {
        .contact-inner {
            grid-template-columns: 1fr;
        }

        .form-card {
            position: static;
        }
    }

    @media (max-width: 560px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-card-full {
            grid-column: 1;
        }

        .social-links {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="contact-hero">
    <div class="contact-hero-inner">
        <nav class="page-breadcrumb animate-in">
            <a href="{{ url('/') }}">Beranda</a>
            <i class="ti ti-chevron-right"></i>
            <span>Kontak</span>
        </nav>

        <div class="animate-in delay-1">
            <div class="section-label">
                <i class="ti ti-map-pin" aria-hidden="true"></i>
                Hubungi Kami
            </div>
            <h1 style="font-size: clamp(24px, 4vw, 38px); font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px; margin: 0 0 10px;">
                Program Studi<br><span style="color: var(--orange-primary);">Perancangan Manufaktur</span>
            </h1>
            <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin: 0; max-width: 500px;">
                Politeknik ATMI Surakarta — kami siap menjawab pertanyaan Anda seputar akademik, fasilitas, maupun informasi umum lainnya.
            </p>
        </div>
    </div>
</section>

{{-- ── Main ── --}}
<section class="contact-section">
    <div class="contact-inner">

        {{-- Left: Info + Map --}}
        <div>

            {{-- Info Cards --}}
            <div class="info-grid animate-in delay-1">

                {{-- Alamat --}}
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="ti ti-building" aria-hidden="true"></i>
                    </div>
                    <div class="info-card-label">Alamat</div>
                    <div class="info-card-value">
                        Jl. Adisucipto (Mojo) No. 01<br>
                        Karangasem, Laweyan<br>
                        Surakarta 57145
                    </div>
                </div>

                {{-- Telepon & Fax --}}
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="ti ti-phone" aria-hidden="true"></i>
                    </div>
                    <div class="info-card-label">Telepon & Fax</div>
                    <div class="info-card-value">
                        <a href="tel:+62271714466">+62 271-714466</a>
                    </div>
                    <div class="info-card-sub">FAX: +62 271-714390</div>
                </div>

                {{-- Email Prodi --}}
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="ti ti-mail" aria-hidden="true"></i>
                    </div>
                    <div class="info-card-label">Email Prodi</div>
                    <div class="info-card-value">
                        <a href="mailto:pm@atmi.ac.id">pm@atmi.ac.id</a>
                    </div>
                    <div class="info-card-sub">Respons dalam 1–2 hari kerja</div>
                </div>

                {{-- Email Institusi --}}
                <div class="info-card">
                    <div class="info-card-icon">
                        <i class="ti ti-mail-forward" aria-hidden="true"></i>
                    </div>
                    <div class="info-card-label">Email Institusi</div>
                    <div class="info-card-value">
                        <a href="mailto:politeknik@atmi.ac.id">politeknik@atmi.ac.id</a>
                    </div>
                    <div class="info-card-sub">Politeknik ATMI Surakarta</div>
                </div>

                {{-- Sosial Media --}}
                <div class="info-card info-card-full">
                    <div class="info-card-icon">
                        <i class="ti ti-share" aria-hidden="true"></i>
                    </div>
                    <div class="info-card-label">Media Sosial</div>
                    <div class="social-links">
                        <a href="https://www.instagram.com/pm.atmi/" target="_blank" rel="noopener" class="social-link">
                            <i class="ti ti-brand-instagram" aria-hidden="true"></i>
                            pm.atmi
                        </a>
                        <a href="https://www.youtube.com/@putppoliteknikatmi6379" target="_blank" rel="noopener" class="social-link">
                            <i class="ti ti-brand-youtube" aria-hidden="true"></i>
                            @putppoliteknikatmi6379
                        </a>
                        <a href="https://www.atmi.ac.id/" target="_blank" rel="noopener" class="social-link">
                            <i class="ti ti-world" aria-hidden="true"></i>
                            atmi.ac.id
                        </a>
                    </div>
                </div>

            </div>

            {{-- Map --}}
            <div class="map-card animate-in delay-2">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.220361535265!2d110.77483477688854!3d-7.550933460150057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a144254bc1eff%3A0xb295c0465d87755b!2sPoliteknik%20ATMI%20Surakarta%20(Kampus%201)!5e0!3m2!1sen!2sid!4v1780535512106!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div class="map-card-footer">
                    <p>Jl. Adisucipto (Mojo) No. 01, Karangasem, Laweyan, Surakarta 57145</p>
                    <a href="https://maps.google.com/maps?q=Politeknik+ATMI+Surakarta" target="_blank" rel="noopener">
                        <i class="ti ti-external-link" aria-hidden="true"></i>
                        Buka Maps
                    </a>
                </div>
            </div>

        </div>

        {{-- Right: Form --}}
        <div class="animate-in delay-2">
            <div class="form-card">
                <div class="form-card-header">
                    <h3>Kirim Pesan</h3>
                    <p>Kami akan membalas pesan Anda secepatnya.</p>
                </div>

                <form method="POST" action="#" novalidate>
                    @csrf

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="form-label" for="contact_name">Nama Lengkap</label>
                        <div class="form-input-wrap">
                            <i class="ti ti-user form-icon" aria-hidden="true"></i>
                            <input
                                id="contact_name"
                                type="text"
                                name="name"
                                class="form-input"
                                placeholder="Nama lengkap Anda"
                                required
                            >
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="contact_email">Alamat Email</label>
                        <div class="form-input-wrap">
                            <i class="ti ti-mail form-icon" aria-hidden="true"></i>
                            <input
                                id="contact_email"
                                type="email"
                                name="email"
                                class="form-input"
                                placeholder="nama@email.com"
                                required
                            >
                        </div>
                    </div>

                    {{-- Subjek --}}
                    <div class="form-group">
                        <label class="form-label" for="contact_subject">Subjek</label>
                        <div class="form-input-wrap">
                            <i class="ti ti-tag form-icon" aria-hidden="true"></i>
                            <input
                                id="contact_subject"
                                type="text"
                                name="subject"
                                class="form-input"
                                placeholder="Subjek pesan"
                                required
                            >
                        </div>
                    </div>

                    {{-- Pesan --}}
                    <div class="form-group">
                        <label class="form-label" for="contact_message">Pesan</label>
                        <div class="form-input-wrap textarea-wrap">
                            <i class="ti ti-message form-icon" aria-hidden="true"></i>
                            <textarea
                                id="contact_message"
                                name="message"
                                class="form-input"
                                placeholder="Tuliskan pesan atau pertanyaan Anda di sini…"
                                required
                            ></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="ti ti-send" aria-hidden="true"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>



@endsection