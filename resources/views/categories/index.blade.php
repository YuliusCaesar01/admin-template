<x-app-layout :title="'Data Kategori'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Data Kategori</h1>
                <p class="text-sm text-stone-500 mt-0.5">Kelola seluruh kategori Packages layanan</p>
            </div>
            @can('categories.create')
                <a href="{{ route('categories.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#D66B0D] transition-colors">
                    <i class="ti ti-plus text-base"></i>
                    Tambah Kategori
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
                <form method="GET" action="{{ route('categories.index') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari nama kategori..."
                               class="w-64 rounded-lg border border-stone-200 bg-stone-50 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder-stone-400 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                    </div>
                    <button type="submit"
                            class="rounded-lg border border-stone-200 bg-white px-3 py-2 text-sm text-slate-600 hover:bg-stone-50 transition">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('categories.index') }}"
                           class="rounded-lg px-3 py-2 text-sm text-stone-400 hover:text-slate-600 transition">
                            Reset
                        </a>
                    @endif
                </form>
                <span class="text-xs text-stone-400">Total: {{ $categories->total() }} kategori</span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">
                            <th class="px-5 py-3">Kode Kategori</th>
                            <th class="px-5 py-3">Nama Kategori</th>
                            <th class="px-5 py-3 text-center">Jumlah Packages</th>
                            @canany(['categories.show', 'categories.edit', 'categories.delete'])
                                <th class="px-5 py-3 text-center">Aksi</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $category)
                            <tr class="hover:bg-stone-50/60 transition-colors">

                                {{-- Kode Kategori --}}
                                <td class="px-5 py-3.5">
                                    <span class="font-medium text-stone-800">{{ $category->category_id }}</span>
                                </td>

                                {{-- Nama Kategori --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#E67E22]/10 text-xs font-semibold text-[#E67E22]">
                                            {{ strtoupper(substr($category->nama_category, 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-stone-800">{{ $category->nama_category }}</span>
                                    </div>
                                </td>

                                {{-- Jumlah Packages --}}
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600">
                                        <i class="ti ti-package text-[10px]"></i>
                                        {{ $category->packages_count }} Packages
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                @canany(['categories.show', 'categories.edit', 'categories.delete'])
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-center gap-1">
                                            @can('categories.show')
                                                <a href="{{ route('categories.show', $category) }}"
                                                   class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-stone-500 hover:bg-slate-100 hover:text-slate-700 transition">
                                                    <i class="ti ti-eye text-sm"></i> Detail
                                                </a>
                                            @endcan

                                            @can('categories.edit')
                                                <a href="{{ route('categories.edit', $category) }}"
                                                   class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-orange-600 hover:bg-orange-50 transition">
                                                    <i class="ti ti-pencil text-sm"></i> Edit
                                                </a>
                                            @endcan

                                            @can('categories.delete')
                                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                                      x-data
                                                      @submit.prevent="if(confirm('Yakin ingin menghapus kategori {{ addslashes($category->nama_category) }}?')) $el.submit()">
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
                                <td colspan="4" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-stone-400">
                                        <i class="ti ti-category-2 text-4xl"></i>
                                        <p class="text-sm">Tidak ada data kategori ditemukan</p>
                                        @if(request('search'))
                                            <a href="{{ route('categories.index') }}" class="text-xs text-[#E67E22] hover:underline">Tampilkan semua</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($categories->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $categories->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>