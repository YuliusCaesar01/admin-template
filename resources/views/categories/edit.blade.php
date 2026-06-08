<x-app-layout :title="'Edit Kategori'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Edit Kategori</h1>
                <p class="text-sm text-stone-500 mt-0.5">Perbarui informasi kategori <span class="font-medium text-[#E67E22]">{{ $category->nama_category }}</span></p>
            </div>
            <a href="{{ route('categories.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 shadow-sm hover:bg-stone-50 transition-colors">
                <i class="ti ti-arrow-left text-base"></i>
                Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="text-sm font-semibold text-stone-700">Informasi Kategori</h2>
                <p class="text-xs text-stone-400 mt-0.5">Ubah data kategori di bawah ini</p>
            </div>

            <form method="POST" action="{{ route('categories.update', $category) }}" class="px-6 py-5 space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Kategori --}}
                <div class="space-y-1.5">
                    <label for="nama_category" class="block text-sm font-medium text-stone-700">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nama_category"
                        name="nama_category"
                        value="{{ old('nama_category', $category->nama_category) }}"
                        placeholder="Masukkan nama kategori..."
                        class="w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400
                               focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition
                               @error('nama_category') border-red-400 bg-red-50 focus:border-red-400 focus:ring-red-400/10 @enderror"
                        autofocus
                    >
                    @error('nama_category')
                        <p class="flex items-center gap-1.5 text-xs text-red-500">
                            <i class="ti ti-alert-circle text-sm"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                    <a href="{{ route('categories.index') }}"
                       class="rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#D66B0D] transition-colors">
                        <i class="ti ti-device-floppy text-base"></i>
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>

</x-app-layout>