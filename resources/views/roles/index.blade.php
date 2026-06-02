<x-app-layout :title="'Manajemen Role'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Manajemen Role</h1>
                <p class="text-sm text-stone-500 mt-0.5">Kelola role dan permission pengguna sistem</p>
            </div>
            @can('roles.create')
                <a href="{{ route('roles.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#E67E22] transition-colors">
                    <i class="ti ti-plus text-base"></i>
                    Tambah Role
                </a>
            @endcan
        </div>

        {{-- Flash Message --}}
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

        {{-- Role Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($roles as $role)
                <div class="group rounded-2xl border border-stone-200 bg-white p-5 shadow-sm hover:border-[#E67E22]/30 hover:shadow-md transition-all">

                    {{-- Role Header --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl
                                {{ $role->name === 'admin' ? 'bg-[#E67E22]/10 text-[#E67E22]' : 'bg-slate-100 text-stone-500' }}">
                                <i class="ti {{ $role->name === 'admin' ? 'ti-shield-half' : 'ti-user' }} text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-stone-800 capitalize">{{ $role->name }}</h3>
                                <p class="text-xs text-stone-400">{{ $role->permissions->count() }} permission</p>
                            </div>
                        </div>

                        {{-- Badge --}}
                        @if ($role->name === 'admin')
                            <span class="rounded-full bg-[#E67E22]/10 px-2.5 py-0.5 text-xs font-medium text-[#E67E22]">Admin</span>
                        @else
                            <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-stone-500">User</span>
                        @endif
                    </div>

                    {{-- Permissions --}}
                    <div class="mt-4 min-h-[60px]">
                        @if ($role->permissions->isEmpty())
                            <p class="text-xs text-stone-400 italic">Belum ada permission yang ditetapkan</p>
                        @else
                            <div class="flex flex-wrap gap-1.5">
                                @foreach ($role->permissions->take(5) as $permission)
                                    <span class="rounded-lg bg-slate-100 px-2 py-0.5 text-xs text-slate-600">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                                @if ($role->permissions->count() > 5)
                                    <span class="rounded-lg bg-slate-100 px-2 py-0.5 text-xs text-stone-400">
                                        +{{ $role->permissions->count() - 5 }} lainnya
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-4 flex items-center justify-end gap-2 border-t border-slate-100 pt-4">
                        @can('roles.edit')
                            <a href="{{ route('roles.edit', $role) }}"
                            class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-orange-600 hover:bg-orange-50 transition">
                                <i class="ti ti-pencil text-sm"></i> Edit
                            </a>
                        @endcan
                        @can('roles.delete')
                            <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                x-data
                                @submit.prevent="if(confirm('Yakin ingin menghapus role \'{{ $role->name }}\'?')) $el.submit()">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-medium text-red-500 hover:bg-red-50 transition">
                                    <i class="ti ti-trash text-sm"></i> Hapus
                                </button>
                            </form>
                        @endcan
                        
                    </div>
                </div>
            @empty
                <div class="col-span-3 flex flex-col items-center gap-3 rounded-2xl border border-dashed border-stone-300 bg-white py-16 text-center">
                    <i class="ti ti-shield-off text-4xl text-stone-300"></i>
                    <div>
                        <p class="text-sm font-medium text-stone-500">Belum ada role</p>
                        <p class="text-xs text-stone-400 mt-0.5">Mulai dengan membuat role baru</p>
                    </div>
                    <a href="{{ route('roles.create') }}"
                       class="mt-1 inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2 text-sm font-medium text-white hover:bg-[#E67E22] transition">
                        <i class="ti ti-plus text-base"></i> Tambah Role
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</x-app-layout>