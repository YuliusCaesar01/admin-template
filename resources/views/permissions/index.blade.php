<x-app-layout :title="'Manajemen Permission'">
    <div class="space-y-6 animate-fade-in-up">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-slate-800">Manajemen Permission</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola permission yang tersedia di sistem</p>
            </div>
        </div>

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <i class="ti ti-circle-check text-lg text-emerald-500"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-emerald-400 hover:text-emerald-600">
                    <i class="ti ti-x"></i>
                </button>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Form Tambah Permission --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm space-y-4">
                <h2 class="text-sm font-semibold text-slate-700">Tambah Permission Baru</h2>

                <form method="POST" action="{{ route('permissions.store') }}" class="space-y-3">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-slate-700">
                            Nama Permission <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <i class="ti ti-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   placeholder="contoh: products.view"
                                   class="w-full rounded-xl border py-2.5 pl-9 pr-4 text-sm text-slate-800 placeholder-slate-400 transition focus:outline-none focus:ring-2
                                          {{ $errors->has('name') ? 'border-red-300 bg-red-50 focus:ring-red-100' : 'border-slate-200 bg-slate-50 focus:border-[#1e3a5f] focus:ring-[#1e3a5f]/10' }}">
                        </div>
                        @error('name')
                            <p class="flex items-center gap-1.5 text-xs text-red-500">
                                <i class="ti ti-alert-circle"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-slate-400">Format: <span class="font-mono">module.action</span> — contoh: <span class="font-mono">products.view</span></p>
                    </div>

                    {{-- Quick fill buttons --}}
                    <div>
                        <p class="mb-1.5 text-xs text-slate-400">Generate otomatis:</p>
                        <div class="relative">
                            <i class="ti ti-box absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" id="module_name" placeholder="nama modul (contoh: products)"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2 pl-9 pr-4 text-sm placeholder-slate-400 focus:border-[#1e3a5f] focus:outline-none focus:ring-2 focus:ring-[#1e3a5f]/10">
                        </div>
                        <div class="mt-2 flex flex-wrap gap-1.5">
                            @foreach(['view','create','edit','delete'] as $action)
                                <button type="button"
                                        onclick="document.querySelector('[name=name]').value = document.getElementById('module_name').value + '.{{ $action }}'"
                                        class="rounded-lg border border-slate-200 px-2.5 py-1 text-xs text-slate-600 hover:bg-slate-100 transition">
                                    .{{ $action }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1e3a5f] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#16304f] transition">
                        <i class="ti ti-plus text-base"></i> Tambah Permission
                    </button>
                </form>
            </div>

            {{-- List Permission --}}
            <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-4">
                    <p class="text-sm font-semibold text-slate-700">Daftar Permission</p>
                    <p class="text-xs text-slate-400 mt-0.5">Total: {{ $permissions->flatten()->count() }} permission</p>
                </div>

                @if ($permissions->isEmpty())
                    <div class="flex flex-col items-center gap-2 py-16 text-slate-400">
                        <i class="ti ti-lock-off text-4xl"></i>
                        <p class="text-sm">Belum ada permission</p>
                    </div>
                @else
                    <div class="divide-y divide-slate-100">
                        @foreach ($permissions as $group => $groupPermissions)
                            <div class="px-5 py-4">
                                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-slate-400">{{ $group }}</p>
                                <div class="space-y-1.5">
                                    @foreach ($groupPermissions as $permission)
                                        <div class="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50 px-3 py-2">
                                            <div class="flex items-center gap-2.5">
                                                <i class="ti ti-lock text-slate-400 text-sm"></i>
                                                <span class="font-mono text-sm text-slate-700">{{ $permission->name }}</span>
                                            </div>
                                            <form method="POST" action="{{ route('permissions.destroy', $permission) }}"
                                                  x-data
                                                  @submit.prevent="if(confirm('Yakin hapus permission \'{{ $permission->name }}\'? Role yang memiliki permission ini akan terpengaruh.')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="rounded-lg p-1.5 text-red-400 hover:bg-red-50 hover:text-red-600 transition">
                                                    <i class="ti ti-trash text-sm"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>