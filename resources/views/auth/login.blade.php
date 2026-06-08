@extends('layouts.landing')

@section('title', 'Masuk')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 62px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 48px 24px;
        background: var(--page-bg);
        position: relative;
        overflow: hidden;
    }

    .auth-wrapper::before {
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

    .auth-wrapper::after {
        content: '';
        position: absolute;
        top: -200px;
        right: -200px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(242,140,40,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .auth-card {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 420px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 36px 32px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
    }

    .auth-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 28px;
    }

    .auth-logo-icon {
        width: 36px;
        height: 36px;
        background: var(--orange-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
        flex-shrink: 0;
    }

    .auth-logo-text {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        letter-spacing: -0.2px;
    }

    .auth-logo-text span { color: var(--orange-primary); }

    .auth-divider {
        width: 1px;
        height: 20px;
        background: var(--border);
    }

    .auth-footer-link {
        margin-top: 20px;
        text-align: center;
        font-size: 12.5px;
        color: var(--text-muted);
    }

    .auth-footer-link a {
        color: var(--orange-primary);
        font-weight: 500;
        text-decoration: none;
        transition: color 0.15s;
    }

    .auth-footer-link a:hover { color: #C2410C; }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card animate-in">

        {{-- Logo --}}
        <div class="auth-logo">
            <div class="auth-logo-icon">
                <i class="ti ti-flask" aria-hidden="true"></i>
            </div>
            <div class="auth-divider"></div>
            <span class="auth-logo-text">{{ config('app.name') }}</span>
        </div>

        {{-- Judul --}}
        <div class="mb-8">
            <h2 class="text-[22px] font-semibold text-stone-800">Selamat datang kembali</h2>
            <p class="mt-1 text-[13px] text-stone-400">Masuk ke akun Anda untuk melanjutkan.</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="mb-5 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-[13px] text-emerald-700">
                <i class="ti ti-circle-check flex-shrink-0 text-base text-emerald-500" aria-hidden="true"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                    Alamat Email
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <i class="ti ti-mail text-stone-400 text-[15px]" aria-hidden="true"></i>
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror"
                    >
                </div>
                @error('email')
                    <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                        <i class="ti ti-alert-circle text-[13px]" aria-hidden="true"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-5">
                <div class="mb-1.5 flex items-center justify-between">
                    <label for="password" class="text-[12.5px] font-medium text-slate-700">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[12px] text-orange-600 hover:text-orange-700 transition-colors">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <i class="ti ti-lock text-stone-400 text-[15px]" aria-hidden="true"></i>
                    </span>
                    <input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-10 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('password') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror"
                    >
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-3 flex items-center text-stone-400 hover:text-slate-600 transition-colors focus:outline-none"
                        :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                    >
                        <i :class="showPassword ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-[15px]" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                        <i class="ti ti-alert-circle text-[13px]" aria-hidden="true"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="mb-6">
                <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2.5">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="h-4 w-4 rounded border-stone-300 text-orange-600 focus:ring-orange-400/40 focus:ring-offset-0"
                    >
                    <span class="text-[13px] text-stone-500">Ingat saya di perangkat ini</span>
                </label>
            </div>

            {{-- Submit --}}
            <button
                type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-2.5 text-[13.5px] font-medium text-white transition-colors duration-150 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-400/40 focus:ring-offset-1"
            >
                <i class="ti ti-login text-base" aria-hidden="true"></i>
                Login
            </button>
        </form>

        <div class="auth-footer-link">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>

    </div>
</div>
@endsection