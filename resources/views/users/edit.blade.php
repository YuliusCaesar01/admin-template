<x-app-layout :title="'Edit User'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-stone-200 bg-white text-stone-500 hover:bg-stone-50 hover:text-slate-700 transition shadow-sm">
                <i class="ti ti-arrow-left text-base"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Edit User</h1>
                <p class="text-sm text-stone-500 mt-0.5">Perbarui data <span class="font-medium text-slate-600">{{ $user->name }}</span></p>
            </div>
        </div>

        <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-4">
                <p class="text-sm font-medium text-slate-700">Informasi Akun</p>
            </div>

            {{-- Form PUT: mencakup semua field + tombol Simpan --}}
            <form method="POST" action="{{ route('users.update', $user) }}" class="p-6 space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="space-y-1.5">
                    <label for="name" class="block text-sm font-medium text-slate-700">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-user absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full rounded-xl border py-2.5 pl-9 pr-4 text-sm text-stone-800 placeholder-stone-400 transition focus:outline-none focus:ring-2
                                      {{ $errors->has('name') ? 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-100' : 'border-stone-200 bg-stone-50 focus:border-[#E67E22] focus:bg-white focus:ring-[#E67E22]/10' }}"
                               autofocus>
                    </div>
                    @error('name')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <i class="ti ti-alert-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-slate-700">
                        Alamat Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-mail absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               placeholder="contoh@email.com"
                               class="w-full rounded-xl border py-2.5 pl-9 pr-4 text-sm text-stone-800 placeholder-stone-400 transition focus:outline-none focus:ring-2
                                      {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-100' : 'border-stone-200 bg-stone-50 focus:border-[#E67E22] focus:bg-white focus:ring-[#E67E22]/10' }}">
                    </div>
                    @error('email')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <i class="ti ti-alert-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-1.5">
                    <label for="role" class="block text-sm font-medium text-slate-700">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ti ti-shield absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <select id="role" name="role"
                                class="w-full appearance-none rounded-xl border py-2.5 pl-9 pr-9 text-sm text-stone-800 transition focus:outline-none focus:ring-2
                                       {{ $errors->has('role') ? 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-100' : 'border-stone-200 bg-stone-50 focus:border-[#E67E22] focus:bg-white focus:ring-[#E67E22]/10' }}">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $user->getRoleNames()->first()) === $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <i class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none"></i>
                    </div>
                    @error('role')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <i class="ti ti-alert-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Divider password --}}
                <div class="flex items-center gap-3 py-1">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <p class="text-xs text-stone-400">Ubah password (opsional)</p>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                {{-- Password --}}
                <div class="space-y-1.5" x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-slate-700">Password Baru</label>
                    <div class="relative">
                        <i class="ti ti-lock absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input :type="show ? 'text' : 'password'" id="password" name="password"
                               placeholder="Kosongkan jika tidak ingin mengubah"
                               class="w-full rounded-xl border py-2.5 pl-9 pr-10 text-sm text-stone-800 placeholder-stone-400 transition focus:outline-none focus:ring-2
                                      {{ $errors->has('password') ? 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-100' : 'border-stone-200 bg-stone-50 focus:border-[#E67E22] focus:bg-white focus:ring-[#E67E22]/10' }}">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-slate-600 transition">
                            <i :class="show ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-base"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <i class="ti ti-alert-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="space-y-1.5" x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <i class="ti ti-lock-check absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input :type="show ? 'text' : 'password'" id="password_confirmation" name="password_confirmation"
                               placeholder="Ulangi password baru"
                               class="w-full rounded-xl border border-stone-200 bg-stone-50 py-2.5 pl-9 pr-10 text-sm text-stone-800 placeholder-stone-400 transition focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10">
                        <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-slate-600 transition">
                            <i :class="show ? 'ti ti-eye-off' : 'ti ti-eye'" class="text-base"></i>
                        </button>
                    </div>
                </div>

                {{-- Actions — di dalam form PUT agar tombol Simpan berfungsi --}}
                <div class="flex items-center justify-end border-t border-slate-100 pt-5">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('users.index') }}"
                           class="rounded-xl border border-stone-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-stone-50 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#E67E22] transition">
                            <i class="ti ti-device-floppy text-base"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
            {{-- ↑ Form PUT ditutup di sini --}}

            {{-- Form DELETE terpisah, di luar form PUT --}}
            <div class="flex items-center border-t border-slate-100 px-6 pb-5 pt-4">
                <form method="POST" action="{{ route('users.destroy', $user) }}"
                      x-data
                      @submit.prevent="if(confirm('Yakin ingin menghapus user ini secara permanen?')) $el.submit()">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl border border-red-200 px-4 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 transition">
                        <i class="ti ti-trash text-base"></i> Hapus User
                    </button>
                </form>
            </div>

        </div>

    </div>

</x-app-layout>