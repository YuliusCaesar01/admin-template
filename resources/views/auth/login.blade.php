<x-guest-layout>
<x-slot name="title">Masuk</x-slot>

{{-- Judul --}}
<div class="mb-8">
    <h2 class="text-[22px] font-semibold text-slate-800">Selamat datang kembali</h2>
    <p class="mt-1 text-[13px] text-slate-400">Masuk ke akun Anda untuk melanjutkan.</p>
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
                <i class="ti ti-mail text-slate-400 text-[15px]" aria-hidden="true"></i>
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
                class="
                    w-full rounded-lg border border-slate-200 bg-white
                    py-2.5 pl-9 pr-3
                    text-[13px] text-slate-800 placeholder-slate-300
                    transition-colors duration-150
                    focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/30
                    @error('email') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror
                "
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
            <label for="password" class="text-[12.5px] font-medium text-slate-700">
                Kata Sandi
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-[12px] text-blue-600 hover:text-blue-700 transition-colors">
                    Lupa kata sandi?
                </a>
            @endif
        </div>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center">
                <i class="ti ti-lock text-slate-400 text-[15px]" aria-hidden="true"></i>
            </span>
            <input
                id="password"
                :type="showPassword ? 'text' : 'password'"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                class="
                    w-full rounded-lg border border-slate-200 bg-white
                    py-2.5 pl-9 pr-10
                    text-[13px] text-slate-800 placeholder-slate-300
                    transition-colors duration-150
                    focus:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400/30
                    @error('password') border-red-300 focus:border-red-400 focus:ring-red-400/30 @enderror
                "
            >
            <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600 transition-colors focus:outline-none"
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
                class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400/40 focus:ring-offset-0"
            >
            <span class="text-[13px] text-slate-500">Ingat saya di perangkat ini</span>
        </label>
    </div>

    {{-- Submit --}}
    <button
        type="submit"
        class="
            flex w-full items-center justify-center gap-2
            rounded-lg bg-[#1e3a5f] px-4 py-2.5
            text-[13.5px] font-medium text-white
            transition-colors duration-150
            hover:bg-[#162d4a]
            focus:outline-none focus:ring-2 focus:ring-blue-400/40 focus:ring-offset-1
        "
    >
        <i class="ti ti-login text-base" aria-hidden="true"></i>
        Masuk ke Dasbor
    </button>

</form>



</x-guest-layout>
