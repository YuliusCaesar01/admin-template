<x-app-layout :title="'Tambah Role'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('roles.index') }}"
               class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition shadow-sm">
                <i class="ti ti-arrow-left text-base"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Tambah Role</h1>
                <p class="text-sm text-slate-500 mt-0.5">Buat role baru beserta permission-nya</p>
            </div>
        </div>

        <form method="POST" action="{{ route('roles.store') }}"
              x-data="{
                  selectAll: false,
                  permissions: [],
                  toggleAll(all) {
                      this.permissions = this.selectAll
                          ? all.map(p => p)
                          : [];
                  }
              }">
            @csrf

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- Left: Role Name --}}
                <div class="space-y-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h2 class="mb-4 text-sm font-semibold text-slate-700">Informasi Role</h2>

                        <div class="space-y-1.5">
                            <label for="name" class="block text-sm font-medium text-slate-700">
                                Nama Role <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <i class="ti ti-shield absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       placeholder="contoh: editor, manager..."
                                       class="w-full rounded-xl border py-2.5 pl-9 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:outline-none focus:ring-2
                                              {{ $errors->has('name') ? 'border-red-300 bg-red-50 focus:border-red-400 focus:ring-red-100' : 'border-slate-200 bg-slate-50 focus:border-[#1e3a5f] focus:bg-white focus:ring-[#1e3a5f]/10' }}"
                                       autofocus>
                            </div>
                            @error('name')
                                <p class="flex items-center gap-1.5 text-xs text-red-500">
                                    <i class="ti ti-alert-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Summary --}}
                        <div class="mt-4 rounded-xl bg-slate-50 p-3">
                            <p class="text-xs text-slate-500">
                                Permission dipilih:
                                <span class="font-semibold text-[#1e3a5f]" x-text="permissions.length"></span>
                                dari {{ $permissions->count() }}
                            </p>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-2">
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1e3a5f] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#16304f] transition">
                            <i class="ti ti-shield-plus text-base"></i>
                            Simpan Role
                        </button>
                        <a href="{{ route('roles.index') }}"
                           class="inline-flex w-full items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                    </div>
                </div>

                {{-- Right: Permissions --}}
                <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">Pilih Permission</p>
                            <p class="text-xs text-slate-400 mt-0.5">Centang permission yang akan diberikan</p>
                        </div>
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" x-model="selectAll"
                                   @change="toggleAll({{ $permissions->pluck('name')->toJson() }})"
                                   class="h-4 w-4 rounded border-slate-300 text-[#1e3a5f] focus:ring-[#1e3a5f]/20">
                            Pilih Semua
                        </label>
                    </div>

                    @if ($permissions->isEmpty())
                        <div class="flex flex-col items-center gap-2 py-16 text-slate-400">
                            <i class="ti ti-lock-off text-3xl"></i>
                            <p class="text-sm">Belum ada permission tersedia</p>
                        </div>
                    @else
                        {{-- Group by prefix (e.g. "users.view" → group "users") --}}
                        @php
                            $grouped = $permissions->groupBy(fn($p) => explode('.', $p->name)[0] ?? 'general');
                        @endphp

                        <div class="divide-y divide-slate-100">
                            @foreach ($grouped as $group => $groupPermissions)
                                <div class="px-5 py-4">
                                    <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $group }}</p>
                                    <div class="grid gap-2 sm:grid-cols-2">
                                        @foreach ($groupPermissions as $permission)
                                            <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-transparent p-2.5 hover:border-slate-200 hover:bg-slate-50 transition"
                                                   :class="permissions.includes('{{ $permission->name }}') ? 'border-[#1e3a5f]/20 bg-[#1e3a5f]/5' : ''">
                                                <input type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ $permission->name }}"
                                                       x-model="permissions"
                                                       {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-slate-300 text-[#1e3a5f] focus:ring-[#1e3a5f]/20">
                                                <div>
                                                    <p class="text-sm font-medium text-slate-700">{{ $permission->name }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </form>

    </div>

</x-app-layout>