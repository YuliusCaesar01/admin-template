{{-- resources/views/layouts/landing.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name',) }} — @yield('title', 'Pengujian Material Profesional')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ─── Base ─────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --orange-primary: #F28C28;
            --orange-hover:   #E67E22;
            --orange-active:  #D66B0D;
            --orange-light:   #FFF4E8;
            --orange-soft:    #FFF2E5;
            --orange-accent:  #FDBA74;
            --orange-border:  #FED7AA;
            --orange-badge:   #FFE7CC;

            --white:          #FFFFFF;
            --page-bg:        #FAFAF9;
            --border:         #E7E5E4;
            --divider:        #F5F5F4;
            --text-primary:   #292524;
            --text-secondary: #78716C;
            --text-muted:     #A8A29E;
            --text-hint:      #D6D3D1;

            --font-main: 'DM Sans', sans-serif;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-main);
            background-color: var(--page-bg);
            color: var(--text-primary);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        main { flex: 1; }

        /* ─── Navbar ────────────────────────────────────── */
        .nav-wrapper {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }

        .navbar {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-logo-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border-radius: 0;
        }

        .nav-logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .nav-logo-text {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.2px;
        }

        .nav-logo-text span { color: var(--orange-primary); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            display: block;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: var(--orange-light);
            color: #C2410C;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--white);
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-ghost:hover {
            background: var(--orange-light);
            border-color: var(--orange-border);
            color: #C2410C;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid transparent;
            background: var(--orange-primary);
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-primary:hover  { background: var(--orange-hover); }
        .btn-primary:active { background: var(--orange-active); }

        .nav-mobile-toggle {
            display: none;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.15s;
        }

        .nav-mobile-toggle:hover {
            background: var(--orange-light);
            border-color: var(--orange-border);
            color: #C2410C;
        }

        /* ─── Mobile Menu ───────────────────────────────── */
        .mobile-menu {
            display: none;
            border-top: 1px solid var(--divider);
            background: #fff;
            padding: 8px 24px 16px;
        }

        .mobile-menu.open { display: block; }

        .mobile-menu .nav-links {
            flex-direction: column;
            align-items: stretch;
            gap: 2px;
        }

        .mobile-menu .nav-links a { padding: 9px 12px; }

        .mobile-menu-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid var(--divider);
        }

        .mobile-menu-actions .btn-ghost,
        .mobile-menu-actions .btn-primary {
            flex: 1;
            justify-content: center;
        }

        /* ─── Footer ────────────────────────────────────── */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            margin-top: auto;
        }

        .footer-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 48px 24px 32px;
            display: grid;
            grid-template-columns: 280px 1fr 1fr 1fr;
            gap: 40px;
        }

        .footer-brand p {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 10px 0 16px;
        }

        .footer-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 20px;
            background: var(--orange-badge);
            font-size: 10px;
            font-weight: 600;
            color: #C2410C;
        }

        .footer-col h4 {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin: 0 0 14px;
        }

        .footer-col ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-col a {
            font-size: 13px;
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.15s;
        }

        .footer-col a:hover { color: var(--orange-primary); }

        .footer-bottom {
            border-top: 1px solid var(--divider);
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .footer-bottom p {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        .footer-socials { display: flex; gap: 4px; }

        .social-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.15s;
            font-size: 14px;
        }

        .social-btn:hover {
            background: var(--orange-light);
            border-color: var(--orange-border);
            color: var(--orange-primary);
        }

        /* ─── Shared Sections ───────────────────────────── */
        .section { padding: 72px 0; }

        .section-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--orange-primary);
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(22px, 3.5vw, 32px);
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.4px;
            line-height: 1.25;
            margin: 0 0 12px;
        }

        .section-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 520px;
            margin: 0;
        }

        /* ─── Page Hero (inner pages) ───────────────────── */
        .page-hero {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 52px 0 48px;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--divider) 1px, transparent 1px),
                linear-gradient(90deg, var(--divider) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            opacity: 0.5;
        }

        .page-hero::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 80px;
            background: linear-gradient(to bottom, transparent, var(--white));
            pointer-events: none;
        }

        .page-hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            position: relative;
            z-index: 1;
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
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s;
        }

        .page-breadcrumb a:hover { color: var(--orange-primary); }
        .page-breadcrumb i { font-size: 10px; }

        .page-hero h1 {
            font-size: clamp(24px, 4vw, 40px);
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.6px;
            line-height: 1.2;
            margin: 0 0 12px;
        }

        .page-hero p {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0;
            max-width: 560px;
        }

        /* ─── Animations ────────────────────────────────── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-in { animation: fadeInUp 0.5s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

        /* ─── Responsive ─────────────────────────────────── */
        @media (max-width: 900px) {
            .nav-links { display: none; }
            .nav-mobile-toggle { display: flex; }
            .nav-actions .btn-ghost,
            .nav-actions .btn-primary { display: none; }

            .footer-main { grid-template-columns: 1fr 1fr; }
            .footer-brand { grid-column: 1 / -1; }
        }

        @media (max-width: 560px) {
            .footer-main { grid-template-columns: 1fr; }
            .footer-brand { grid-column: 1; }
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 0;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--orange-primary);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-arrow {
            font-size: 14px;
            color: #64748b;
        }

        .profile-menu {
            position: absolute;
            top: 42px;
            right: 0;
            width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,.08);
            border: 1px solid #e5e7eb;
            display: none;
            overflow: hidden;
            z-index: 1000;
        }

        .profile-menu.show {
            display: block;
        }

        .profile-header {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .profile-header strong {
            display: block;
            font-size: 14px;
            color: #0f172a;
        }

        .profile-header small {
            display: block;
            color: #64748b;
            margin-top: 2px;
            font-size: 12px;
        }

        .profile-menu a,
        .profile-menu button {
            width: 100%;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            background: none;
            border: none;
            color: #334155;
            cursor: pointer;
            font-size: 14px;
        }

        .profile-menu a:hover,
        .profile-menu button:hover {
            background: #f8fafc;
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>