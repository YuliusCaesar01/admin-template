@extends('layouts.landing')

@section('title', 'Daftar')

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
        max-width: 640px;
        background: var(--white);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 40px 40px;
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
            <h2 class="text-[22px] font-semibold text-stone-800">Buat akun baru</h2>
            <p class="mt-1 text-[13px] text-stone-400">Isi formulir di bawah untuk mendaftar.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" 
            x-data="{
                showPassword: false,
                showConfirm: false,
                userType: '{{ old('user_type') }}',
                categories: {
                    internal: {{ $categories->get('internal', collect())->map(fn($c) => ['id' => $c->id, 'name' => $c->category_name])->values()->toJson() }},
                    external: {{ $categories->get('external', collect())->map(fn($c) => ['id' => $c->id, 'name' => $c->category_name])->values()->toJson() }}
                },
                get filteredCategories() {
                    return this.userType ? (this.categories[this.userType] ?? []) : []
                }
            }">
            @csrf

            {{-- Baris 1: Nama + Telepon --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-user text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                            required autofocus autocomplete="name" placeholder="Nama lengkap Anda"
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('name') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                    </div>
                    @error('name')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="phone" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Nomor Telepon <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-phone text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                            autocomplete="tel" placeholder="+62 812 3456 7890"
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('phone') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                    </div>
                    @error('phone')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris 2: Email (full width) --}}
            <div class="mb-4">
                <label for="email" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                    Alamat Email
                </label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                        <i class="ti ti-mail text-stone-400 text-[15px]" aria-hidden="true"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        required autocomplete="username" placeholder="nama@email.com"
                        class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                </div>
                @error('email')
                    <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                        <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Tipe Pengguna --}}
            <div class="mb-4">
                <label class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                    Tipe Pengguna
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label
                        class="flex cursor-pointer items-center gap-2.5 rounded-lg border px-3.5 py-2.5 transition-colors duration-150"
                        :class="userType === 'internal'
                            ? 'border-orange-400 bg-orange-50 text-orange-700'
                            : 'border-stone-200 bg-white text-stone-600 hover:border-stone-300'"
                    >
                        <input type="radio" name="user_type" value="internal" x-model="userType"
                            class="hidden" required>
                        <i class="ti ti-building-community text-[15px]" aria-hidden="true"></i>
                        <span class="text-[13px] font-medium">Internal</span>
                    </label>
                    <label
                        class="flex cursor-pointer items-center gap-2.5 rounded-lg border px-3.5 py-2.5 transition-colors duration-150"
                        :class="userType === 'external'
                            ? 'border-orange-400 bg-orange-50 text-orange-700'
                            : 'border-stone-200 bg-white text-stone-600 hover:border-stone-300'"
                    >
                        <input type="radio" name="user_type" value="external" x-model="userType"
                            class="hidden" required>
                        <i class="ti ti-users text-[15px]" aria-hidden="true"></i>
                        <span class="text-[13px] font-medium">Eksternal</span>
                    </label>
                </div>
                @error('user_type')
                    <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                        <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Baris 3: Kategori + Organisasi --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                {{-- Kategori Pengguna --}}
                <div>
                    <label for="user_category_id" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Kategori Pengguna
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-category text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <select id="user_category_id" name="user_category_id" required
                            :disabled="!userType"
                            class="w-full appearance-none rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-8 text-[13px] text-stone-800 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 disabled:cursor-not-allowed disabled:opacity-50 @error('user_category_id') border-red-300 @enderror">
                            <option value="" disabled selected>
                                <span x-text="userType ? 'Pilih kategori...' : 'Pilih tipe pengguna dulu'"></span>
                            </option>
                            <template x-for="cat in filteredCategories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name"
                                    :selected="cat.id === '{{ old('user_category_id') }}'">
                                </option>
                            </template>
                        </select>
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <i class="ti ti-chevron-down text-stone-400 text-[13px]"></i>
                        </span>
                    </div>
                    @error('user_category_id')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Nama Organisasi --}}
                <div>
                    <label for="organization_name" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Nama Instansi / Organisasi <span class="text-stone-400 font-normal">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-building text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <input id="organization_name" type="text" name="organization_name"
                            value="{{ old('organization_name') }}" placeholder="Nama instansi Anda"
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('organization_name') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                    </div>
                    @error('organization_name')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Baris 4: Password + Konfirmasi --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                {{-- Kata Sandi --}}
                <div>
                    <label for="password" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-lock text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                            required autocomplete="new-password" placeholder="••••••••"
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-10 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('password') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-3 flex items-center text-stone-400 hover:text-slate-600 transition-colors focus:outline-none"
                            :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                            <i :class="showPassword ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-[15px]"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Konfirmasi Kata Sandi --}}
                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-[12.5px] font-medium text-slate-700">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                            <i class="ti ti-lock-check text-stone-400 text-[15px]" aria-hidden="true"></i>
                        </span>
                        <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                            class="w-full rounded-lg border border-stone-200 bg-white py-2.5 pl-9 pr-10 text-[13px] text-stone-800 placeholder-stone-300 transition-colors duration-150 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/30 @error('password_confirmation') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror">
                        <button type="button" @click="showConfirm = !showConfirm"
                            class="absolute inset-y-0 right-3 flex items-center text-stone-400 hover:text-slate-600 transition-colors focus:outline-none"
                            :aria-label="showConfirm ? 'Sembunyikan konfirmasi' : 'Tampilkan konfirmasi'">
                            <i :class="showConfirm ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-[15px]"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1.5 flex items-center gap-1.5 text-[12px] text-red-500">
                            <i class="ti ti-alert-circle text-[13px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-lg bg-orange-600 px-4 py-2.5 text-[13.5px] font-medium text-white transition-colors duration-150 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-400/40 focus:ring-offset-1">
                <i class="ti ti-user-plus text-base" aria-hidden="true"></i>
                Buat Akun
            </button>
        </form>

        <div class="auth-footer-link">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection