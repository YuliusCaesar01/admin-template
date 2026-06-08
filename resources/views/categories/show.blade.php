<x-app-layout :title="'Detail Kategori'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Detail Kategori</h1>
                <p class="text-sm text-stone-500 mt-0.5">Informasi lengkap kategori Packages</p>
            </div>
            <div class="flex items-center gap-2">
                @can('categories.edit')
                    <a href="{{ route('categories.edit', $category) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-orange-600 shadow-sm hover:bg-orange-50 transition-colors">
                        <i class="ti ti-pencil text-base"></i>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 shadow-sm hover:bg-stone-50 transition-colors">
                    <i class="ti ti-arrow-left text-base"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

            {{-- Info Card --}}
            <div class="rounded-2xl border border-stone-200 bg-white shadow-sm lg:col-span-1">
                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-sm font-semibold text-stone-700">Informasi Kategori</h2>
                </div>
                <div class="px-6 py-5 space-y-4">

                    {{-- Avatar --}}
                    <div class="flex justify-center py-2">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-[#E67E22]/10 text-2xl font-bold text-[#E67E22]">
                            {{ strtoupper(substr($category->nama_category, 0, 1)) }}
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Nama Kategori</span>
                            <span class="font-medium text-stone-800">{{ $category->nama_category }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Jumlah Packages</span>
                            <span class="font-medium text-stone-800">{{ $category->packages_count }} Packages</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Dibuat</span>
                            <span class="text-stone-600">{{ $category->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Diperbarui</span>
                            <span class="text-stone-600">{{ $category->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Packages List --}}
            <div class="rounded-2xl border border-stone-200 bg-white shadow-sm lg:col-span-2">
                <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-stone-700">Daftar Packages</h2>
                    <span class="rounded-full bg-[#E67E22]/10 px-2.5 py-0.5 text-xs font-semibold text-[#E67E22]">
                        {{ $category->packages_count }} Packages
                    </span>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse ($category->packages as $package)
                        <div class="flex items-center justify-between px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-slate-100">
                                    <i class="ti ti-package text-slate-500 text-sm"></i>
                                </div>
                                <span class="text-sm font-medium text-stone-800">{{ $package->nama_package ?? $package->name ?? '-' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center gap-2 px-6 py-12 text-stone-400">
                            <i class="ti ti-package-off text-3xl"></i>
                            <p class="text-sm">Belum ada Packages dalam kategori ini</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</x-app-layout>