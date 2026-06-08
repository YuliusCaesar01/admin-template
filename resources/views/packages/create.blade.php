<x-app-layout :title="'Tambah Packages'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Tambah Packages</h1>
                <p class="text-sm text-stone-500 mt-0.5">Buat Packages layanan mesin baru</p>
            </div>
            <a href="{{ route('packages.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 shadow-sm hover:bg-stone-50 transition-colors">
                <i class="ti ti-arrow-left text-base"></i>
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('packages.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                {{-- Kolom Kiri: Informasi Utama --}}
                <div class="space-y-5 lg:col-span-2">

                    {{-- Info Dasar --}}
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <h2 class="text-sm font-semibold text-stone-700">Informasi Packages</h2>
                            <p class="text-xs text-stone-400 mt-0.5">Data utama Packages layanan</p>
                        </div>
                        <div class="px-6 py-5 space-y-4">

                            {{-- Nama Packages --}}
                            <div class="space-y-1.5">
                                <label for="name" class="block text-sm font-medium text-stone-700">
                                    Nama Packages <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       placeholder="Masukkan nama Packages..."
                                       class="w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400
                                              focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition
                                              @error('name') border-red-400 bg-red-50 @enderror"
                                       autofocus>
                                @error('name')
                                    <p class="flex items-center gap-1.5 text-xs text-red-500">
                                        <i class="ti ti-alert-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="space-y-1.5">
                                <label for="description" class="block text-sm font-medium text-stone-700">Deskripsi</label>
                                <textarea id="description" name="description" rows="4"
                                          placeholder="Deskripsi singkat Packages layanan..."
                                          class="w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-2.5 text-sm text-stone-800 placeholder-stone-400
                                                 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition resize-none
                                                 @error('description') border-red-400 bg-red-50 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="flex items-center gap-1.5 text-xs text-red-500">
                                        <i class="ti ti-alert-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Harga Dasar --}}
                            <div class="space-y-1.5">
                                <label for="base_price" class="block text-sm font-medium text-stone-700">
                                    Harga Dasar <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-medium text-stone-400">Rp</span>
                                    <input type="number" id="base_price" name="base_price" value="{{ old('base_price') }}"
                                           placeholder="0"
                                           min="0" step="1000"
                                           class="w-full rounded-xl border border-stone-200 bg-stone-50 py-2.5 pl-10 pr-4 text-sm text-stone-800 placeholder-stone-400
                                                  focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition
                                                  @error('base_price') border-red-400 bg-red-50 @enderror">
                                </div>
                                @error('base_price')
                                    <p class="flex items-center gap-1.5 text-xs text-red-500">
                                        <i class="ti ti-alert-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Relasi --}}
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <h2 class="text-sm font-semibold text-stone-700">Relasi</h2>
                            <p class="text-xs text-stone-400 mt-0.5">Hubungkan Packages dengan mesin dan kategori</p>
                        </div>
                        <div class="px-6 py-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                            {{-- Kategori --}}
                            <div class="space-y-1.5">
                                <label for="category_id" class="block text-sm font-medium text-stone-700">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" name="category_id"
                                        class="w-full rounded-xl border border-stone-200 bg-stone-50 px-4 py-2.5 text-sm text-stone-700
                                               focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition
                                               @error('category_id') border-red-400 bg-red-50 @enderror">
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->category_id }}" @selected(old('category_id') == $cat->category_id)>
                                            {{ $cat->nama_category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="flex items-center gap-1.5 text-xs text-red-500">
                                        <i class="ti ti-alert-circle text-sm"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan: Gambar & Status --}}
                <div class="space-y-5">

                    {{-- Gambar --}}
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <h2 class="text-sm font-semibold text-stone-700">Gambar Packages</h2>
                            <p class="text-xs text-stone-400 mt-0.5">JPG, PNG, WebP • Maks 2MB</p>
                        </div>
                        <div class="px-6 py-5" x-data="imagePreview()">

                            {{-- Preview --}}
                            <div class="mb-3 flex items-center justify-center">
                                <div class="relative h-36 w-full overflow-hidden rounded-xl border border-stone-200 bg-stone-50">
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl" class="h-full w-full object-cover" alt="Preview">
                                    </template>
                                    <template x-if="!previewUrl">
                                        <div class="flex h-full w-full flex-col items-center justify-center gap-1.5 text-stone-300">
                                            <i class="ti ti-photo text-3xl"></i>
                                            <span class="text-xs">Belum ada gambar</span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <label for="image"
                                   class="flex cursor-pointer items-center justify-center gap-2 rounded-xl border border-dashed border-stone-300 bg-stone-50 py-2.5 text-sm text-stone-500 hover:border-[#E67E22] hover:text-[#E67E22] transition">
                                <i class="ti ti-upload text-base"></i>
                                <span>Pilih Gambar</span>
                            </label>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden"
                                   @change="handleFile($event)">

                            @error('image')
                                <p class="mt-2 flex items-center gap-1.5 text-xs text-red-500">
                                    <i class="ti ti-alert-circle text-sm"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-slate-100 px-6 py-4">
                            <h2 class="text-sm font-semibold text-stone-700">Status Packages</h2>
                        </div>
                        <div class="px-6 py-5">
                            <label class="flex cursor-pointer items-center justify-between gap-3">
                                <div>
                                    <p class="text-sm font-medium text-stone-700">Aktifkan Packages</p>
                                    <p class="text-xs text-stone-400">Packages dapat dipilih oleh pelanggan</p>
                                </div>
                                <div x-data="{ on: {{ old('is_active', true) ? 'true' : 'false' }} }"
                                     class="relative">
                                    <input type="hidden" name="is_active" :value="on ? '1' : '0'">
                                    <button type="button" @click="on = !on"
                                            :class="on ? 'bg-[#E67E22]' : 'bg-stone-200'"
                                            class="relative h-6 w-11 rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#E67E22]/20">
                                        <span :class="on ? 'translate-x-5' : 'translate-x-0.5'"
                                              class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                                    </button>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-2">
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#E67E22] px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#D66B0D] transition-colors">
                            <i class="ti ti-check text-base"></i>
                            Simpan Packages
                        </button>
                        <a href="{{ route('packages.index') }}"
                           class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-stone-200 bg-white px-5 py-2.5 text-sm font-medium text-stone-600 hover:bg-stone-50 transition-colors">
                            Batal
                        </a>
                    </div>

                </div>

            </div>
        </form>

    </div>

    <script>
        function imagePreview() {
            return {
                previewUrl: null,
                handleFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = (e) => this.previewUrl = e.target.result;
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>

</x-app-layout>