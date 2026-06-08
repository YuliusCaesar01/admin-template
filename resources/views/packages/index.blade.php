<x-app-layout :title="'Data Packages'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Data Packages</h1>
                <p class="text-sm text-stone-500 mt-0.5">Kelola seluruh Packages layanan mesin</p>
            </div>
            @can('packages.create')
                <a href="{{ route('packages.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#D66B0D] transition-colors">
                    <i class="ti ti-plus text-base"></i>
                    Tambah Packages
                </a>
            @endcan
        </div>

        {{-- Flash Messages --}}
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

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i class="ti ti-alert-circle text-lg text-red-500"></i>
                <span>{{ session('error') }}</span>
                <button @click="show = false" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="ti ti-x text-base"></i>
                </button>
            </div>
        @endif

        {{-- Card --}}
        <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" action="{{ route('packages.index') }}" class="flex flex-wrap items-center gap-2">

                    {{-- Search --}}
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama Packages..."
                               class="w-56 rounded-lg border border-stone-200 bg-stone-50 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder-stone-400 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                    </div>

                    {{-- Filter Kategori --}}
                    <select name="category"
                            class="rounded-lg border border-stone-200 bg-stone-50 py-2 pl-3 pr-8 text-sm text-slate-700 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->category_id }}" @selected(request('category') == $cat->category_id)>
                                {{ $cat->nama_category }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Filter Status --}}
                    <select name="status"
                            class="rounded-lg border border-stone-200 bg-stone-50 py-2 pl-3 pr-8 text-sm text-slate-700 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                        <option value="">Semua Status</option>
                        <option value="active"   @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Non-aktif</option>
                    </select>

                    <button type="submit"
                            class="rounded-lg border border-stone-200 bg-white px-3 py-2 text-sm text-slate-600 hover:bg-stone-50 transition">
                        Cari
                    </button>

                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('packages.index') }}"
                           class="rounded-lg px-3 py-2 text-sm text-stone-400 hover:text-slate-600 transition">
                            Reset
                        </a>
                    @endif
                </form>

                <span class="text-xs text-stone-400">Total: {{ $packages->total() }} Packages</span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">
                            <th class="px-5 py-3">Packages</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3 text-right">Harga Dasar</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            @canany(['packages.show', 'packages.edit', 'packages.delete'])
                                <th class="px-5 py-3 text-center">Aksi</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($packages as $package)
                            <tr class="hover:bg-stone-50/60 transition-colors">

                                {{-- Packages --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if ($package->image_url)
                                            <img src="{{ $package->image_url }}"
                                                 alt="{{ $package->name }}"
                                                 class="h-9 w-9 flex-shrink-0 rounded-lg object-cover border border-stone-200">
                                        @else
                                            <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-[#E67E22]/10">
                                                <i class="ti ti-package text-[#E67E22] text-base"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-stone-800">{{ $package->name }}</p>
                                            @if ($package->description)
                                                <p class="text-xs text-stone-400 line-clamp-1 max-w-[180px]">{{ $package->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="px-5 py-3.5">
                                    @if ($package->category)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                            <i class="ti ti-tag text-[10px]"></i>
                                            {{ $package->category->nama_category }}
                                        </span>
                                    @else
                                        <span class="text-xs italic text-stone-400">—</span>
                                    @endif
                                </td>

                                {{-- Harga --}}
                                <td class="px-5 py-3.5 text-right font-medium text-stone-800">
                                    Rp {{ number_format($package->base_price, 0, ',', '.') }}
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-3.5 text-center">
                                    @if ($package->is_active)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-stone-100 px-2.5 py-0.5 text-xs font-medium text-stone-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                            Non-aktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                @canany(['packages.show', 'packages.edit', 'packages.delete'])
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-center gap-1">
                                            @can('packages.show')
                                                <a href="{{ route('packages.show', $package) }}"
                                                   class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-stone-500 hover:bg-slate-100 hover:text-slate-700 transition">
                                                    <i class="ti ti-eye text-sm"></i> Detail
                                                </a>
                                            @endcan

                                            @can('packages.edit')
                                                <a href="{{ route('packages.edit', $package) }}"
                                                   class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-orange-600 hover:bg-orange-50 transition">
                                                    <i class="ti ti-pencil text-sm"></i> Edit
                                                </a>
                                            @endcan

                                            @can('packages.delete')
                                                <form method="POST" action="{{ route('packages.destroy', $package) }}"
                                                      x-data
                                                      @submit.prevent="if(confirm('Yakin ingin menghapus Packages {{ addslashes($package->name) }}?')) $el.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-red-500 hover:bg-red-50 transition">
                                                        <i class="ti ti-trash text-sm"></i> Hapus
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-stone-400">
                                        <i class="ti ti-package-off text-4xl"></i>
                                        <p class="text-sm">Tidak ada data Packages ditemukan</p>
                                        @if(request()->hasAny(['search', 'category', 'status']))
                                            <a href="{{ route('packages.index') }}" class="text-xs text-[#E67E22] hover:underline">Tampilkan semua</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($packages->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $packages->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>