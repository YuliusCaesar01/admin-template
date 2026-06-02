<x-app-layout :title="'Detail User'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center justify-center h-9 w-9 rounded-xl border border-stone-200 bg-white text-stone-500 hover:bg-stone-50 hover:text-slate-700 transition shadow-sm">
                <i class="ti ti-arrow-left text-base"></i>
            </a>
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Detail User</h1>
                <p class="text-sm text-stone-500 mt-0.5">Informasi lengkap akun pengguna</p>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <i class="ti ti-circle-check text-lg text-emerald-500"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
                    <i class="ti ti-x text-base"></i>
                </button>
            </div>
        @endif

        @php
            $rolePermissionNames = $user->getPermissionsViaRoles()->pluck('name');
            $directPermissionNames = $user->getDirectPermissions()->pluck('name')->toArray();
        @endphp

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- ===== KOLOM KIRI ===== --}}
            <div class="space-y-4">

                {{-- Profile Card --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm p-6 flex flex-col items-center text-center gap-3">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-[#E67E22]/10 text-3xl font-bold text-[#E67E22]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-stone-800">{{ $user->name }}</h2>
                        <p class="text-sm text-stone-500">{{ $user->email }}</p>
                    </div>

                    {{-- Role Badge --}}
                    <div class="flex flex-wrap justify-center gap-2">
                        @forelse ($user->roles as $role)
                            <span @class([
                                'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium',
                                'bg-[#E67E22]/10 text-[#E67E22]' => $role->name === 'admin',
                                'bg-slate-100 text-slate-600'     => $role->name !== 'admin',
                            ])>
                                <i @class(['ti', 'ti-shield-half' => $role->name === 'admin', 'ti-user' => $role->name !== 'admin'])></i>
                                {{ ucfirst($role->name) }}
                            </span>
                        @empty
                            <span class="text-xs text-stone-400 italic">Tidak ada role</span>
                        @endforelse
                    </div>

                    <div class="w-full border-t border-slate-100 pt-4 mt-1 space-y-2">
                        @can('users.edit')
                            <a href="{{ route('users.edit', $user) }}"
                               class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#E67E22] transition">
                                <i class="ti ti-pencil text-base"></i> Edit User
                            </a>
                        @endcan
                        @can('users.delete')
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  x-data
                                  @submit.prevent="if(confirm('Yakin ingin menghapus user ini?')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-red-200 px-4 py-2.5 text-sm font-medium text-red-500 hover:bg-red-50 transition">
                                    <i class="ti ti-trash text-base"></i> Hapus User
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>

                {{-- Info Akun --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <p class="text-sm font-medium text-slate-700">Informasi Akun</p>
                    </div>
                    <dl class="divide-y divide-slate-100">
                        <div class="grid grid-cols-3 gap-2 px-5 py-3">
                            <dt class="flex items-center gap-1.5 text-xs text-stone-500">
                                <i class="ti ti-id text-stone-400"></i> ID
                            </dt>
                            <dd class="col-span-2 font-mono text-xs text-slate-600 break-all">
                                {{ substr($user->id, 0, 8) }}...
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2 px-5 py-3">
                            <dt class="flex items-center gap-1.5 text-xs text-stone-500">
                                <i class="ti ti-shield-check text-stone-400"></i> Verified
                            </dt>
                            <dd class="col-span-2">
                                @if ($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs text-emerald-600">
                                        <i class="ti ti-check"></i> Ya
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-xs text-amber-600">
                                        <i class="ti ti-clock"></i> Belum
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2 px-5 py-3">
                            <dt class="flex items-center gap-1.5 text-xs text-stone-500">
                                <i class="ti ti-calendar text-stone-400"></i> Dibuat
                            </dt>
                            <dd class="col-span-2 text-xs text-slate-600">
                                {{ $user->created_at->format('d M Y') }}
                                <span class="block text-stone-400">{{ $user->created_at->diffForHumans() }}</span>
                            </dd>
                        </div>
                        <div class="grid grid-cols-3 gap-2 px-5 py-3">
                            <dt class="flex items-center gap-1.5 text-xs text-stone-500">
                                <i class="ti ti-calendar-check text-stone-400"></i> Diperbarui
                            </dt>
                            <dd class="col-span-2 text-xs text-slate-600">
                                {{ $user->updated_at->format('d M Y') }}
                                <span class="block text-stone-400">{{ $user->updated_at->diffForHumans() }}</span>
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>

            {{-- ===== KOLOM KANAN ===== --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Permission dari Role (read-only) --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <p class="text-sm font-semibold text-slate-700">Permission dari Role</p>
                        <p class="text-xs text-stone-400 mt-0.5">Diperoleh otomatis — ubah melalui halaman
                            @if($user->roles->first())
                                <a href="{{ route('roles.edit', $user->roles->first()) }}" class="text-[#E67E22] hover:underline">Role</a>
                            @else
                                Role
                            @endif
                        </p>
                    </div>
                    <div class="p-5">
                        @php
                            $groupedRolePerms = $user->getPermissionsViaRoles()->groupBy(fn($p) => explode('.', $p->name)[0]);
                        @endphp

                        @if ($groupedRolePerms->isEmpty())
                            <div class="flex flex-col items-center gap-2 py-6 text-stone-400">
                                <i class="ti ti-lock-off text-3xl"></i>
                                <p class="text-sm">Tidak ada permission dari role</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($groupedRolePerms as $group => $perms)
                                    <div>
                                        <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-stone-400">{{ $group }}</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($perms as $perm)
                                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                                    <i class="ti ti-shield-half text-[10px]"></i> {{ $perm->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Direct Permission (editable) --}}
                <form method="POST" action="{{ route('users.permissions.sync', $user) }}"
                      x-data="{
                          selected: {{ json_encode($directPermissionNames) }},
                          rolePerms: {{ $rolePermissionNames->toJson() }},
                          allPermissions: {{ $allPermissions->flatten()->pluck('name')->toJson() }},
                          selectAll: false,
                          init() {
                              this.selectAll = this.selected.length === this.allPermissions.filter(p => !this.rolePerms.includes(p)).length;
                          },
                          toggleAll() {
                              const nonRolePerms = this.allPermissions.filter(p => !this.rolePerms.includes(p));
                              this.selected = this.selectAll ? [...nonRolePerms] : [];
                          },
                          isFromRole(perm) {
                              return this.rolePerms.includes(perm);
                          }
                      }">
                    @csrf
                    @method('PUT')

                    <div class="rounded-2xl border border-[#E67E22]/20 bg-white shadow-sm">

                        {{-- Header --}}
                        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                            <div>
                                <p class="text-sm font-semibold text-slate-700">Permission Langsung (Direct)</p>
                                <p class="text-xs text-stone-400 mt-0.5">
                                    Permission tambahan di luar role —
                                    dipilih: <span class="font-semibold text-[#E67E22]" x-text="selected.length"></span>
                                </p>
                            </div>
                            <label class="flex cursor-pointer items-center gap-2 text-sm text-slate-600">
                                <input type="checkbox" x-model="selectAll" @change="toggleAll()"
                                       class="h-4 w-4 rounded border-stone-300 text-[#E67E22] focus:ring-[#E67E22]/20">
                                Pilih Semua
                            </label>
                        </div>

                        {{-- Permission List --}}
                        @if ($allPermissions->isEmpty())
                            <div class="flex flex-col items-center gap-2 py-10 text-stone-400">
                                <i class="ti ti-lock-off text-3xl"></i>
                                <p class="text-sm">Belum ada permission tersedia</p>
                            </div>
                        @else
                            @php $rolePermNamesPhp = $rolePermissionNames->toArray(); @endphp

                            <div class="divide-y divide-slate-100">
                                @foreach ($allPermissions as $group => $groupPermissions)
                                    <div class="px-5 py-4">
                                        <div class="mb-3 flex items-center justify-between">
                                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-400">{{ $group }}</p>
                                            <button type="button"
                                                    @click="
                                                        const group = {{ $groupPermissions->pluck('name')->toJson() }};
                                                        const nonRole = group.filter(p => !rolePerms.includes(p));
                                                        const allIn = nonRole.every(p => selected.includes(p));
                                                        selected = allIn
                                                            ? selected.filter(p => !nonRole.includes(p))
                                                            : [...new Set([...selected, ...nonRole])];
                                                    "
                                                    class="text-xs text-[#E67E22] hover:underline">
                                                Pilih grup ini
                                            </button>
                                        </div>

                                        <div class="grid gap-2 sm:grid-cols-2">
                                            @foreach ($groupPermissions as $permission)
                                                @php $fromRole = in_array($permission->name, $rolePermNamesPhp); @endphp

                                                <label @class([
                                                    'flex items-center gap-3 rounded-xl border p-2.5 transition',
                                                    'border-[#E67E22]/20 bg-[#E67E22]/5 cursor-not-allowed' => $fromRole,
                                                    'border-transparent hover:border-stone-200 hover:bg-stone-50 cursor-pointer' => !$fromRole,
                                                ])
                                                @if(!$fromRole)
                                                    :class="selected.includes('{{ $permission->name }}') ? 'border-[#E67E22]/20 bg-[#E67E22]/5' : ''"
                                                @endif>

                                                    @if ($fromRole)
                                                        {{-- Centang disabled dari role --}}
                                                        <input type="checkbox" checked disabled
                                                               class="h-4 w-4 rounded border-stone-300 text-[#E67E22] opacity-50 cursor-not-allowed flex-shrink-0">
                                                        <input type="hidden" name="permissions[]" value="{{ $permission->name }}">
                                                    @else
                                                        {{-- Checkbox normal --}}
                                                        <input type="checkbox"
                                                               name="permissions[]"
                                                               value="{{ $permission->name }}"
                                                               x-model="selected"
                                                               class="h-4 w-4 rounded border-stone-300 text-[#E67E22] focus:ring-[#E67E22]/20 flex-shrink-0">
                                                    @endif

                                                    <div class="flex-1 min-w-0">
                                                        <p @class([
                                                            'text-sm font-medium',
                                                            'text-stone-400' => $fromRole,
                                                            'text-slate-700' => !$fromRole,
                                                        ])>{{ $permission->name }}</p>
                                                        @if ($fromRole)
                                                            <p class="text-xs text-[#E67E22]/50">Dari role — tidak dapat diubah</p>
                                                        @endif
                                                    </div>
                                                </label>

                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer --}}
                        <div class="flex justify-end border-t border-slate-100 px-5 py-4">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-5 py-2.5 text-sm font-medium text-white hover:bg-[#E67E22] transition">
                                <i class="ti ti-device-floppy"></i> Simpan Permission
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

    </div>

</x-app-layout>