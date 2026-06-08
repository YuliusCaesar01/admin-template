<x-app-layout :title="'Detail Packages'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Detail Packages</h1>
                <p class="text-sm text-stone-500 mt-0.5">Informasi lengkap Packages layanan</p>
            </div>
            <div class="flex items-center gap-2">
                @can('packages.edit')
                    <a href="{{ route('packages.edit', $package) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-orange-600 shadow-sm hover:bg-orange-50 transition-colors">
                        <i class="ti ti-pencil text-base"></i>
                        Edit
                    </a>
                @endcan
                <a href="{{ route('packages.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-600 shadow-sm hover:bg-stone-50 transition-colors">
                    <i class="ti ti-arrow-left text-base"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

            {{-- Kolom Kiri --}}
            <div class="space-y-5 lg:col-span-1">

                {{-- Gambar & Info Singkat --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm overflow-hidden">

                    @if ($package->image_url)
                        <img src="{{ $package->image_url }}" alt="{{ $package->name }}"
                             class="h-48 w-full object-cover">
                    @else
                        <div class="flex h-48 w-full items-center justify-center bg-stone-50">
                            <div class="flex flex-col items-center gap-2 text-stone-300">
                                <i class="ti ti-photo text-5xl"></i>
                                <span class="text-xs">Tidak ada gambar</span>
                            </div>
                        </div>
                    @endif

                    <div class="px-6 py-5 space-y-3">
                        <div class="flex items-center justify-between">
                            @if ($package->is_active)
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-stone-100 px-3 py-1 text-xs font-medium text-stone-500">
                                    <span class="h-1.5 w-1.5 rounded-full bg-stone-400"></span>
                                    Non-aktif
                                </span>
                            @endif

                            @if ($package->category)
                                <span class="inline-flex items-center gap-1 rounded-full bg-[#E67E22]/10 px-2.5 py-0.5 text-xs font-medium text-[#E67E22]">
                                    <i class="ti ti-tag text-[10px]"></i>
                                    {{ $package->category->nama_category }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <h2 class="text-base font-semibold text-stone-800">{{ $package->name }}</h2>
                            @if ($package->description)
                                <p class="mt-1 text-sm text-stone-500 leading-relaxed">{{ $package->description }}</p>
                            @endif
                        </div>

                        <div class="border-t border-slate-100 pt-3">
                            <p class="text-xs text-stone-400">Harga Dasar</p>
                            <p class="text-xl font-semibold text-stone-800">
                                Rp {{ number_format($package->base_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Meta Info --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-6 py-4">
                        <h3 class="text-sm font-semibold text-stone-700">Informasi Sistem</h3>
                    </div>
                    <div class="px-6 py-5 space-y-3 text-sm">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Dibuat</span>
                            <span class="text-stone-600">{{ $package->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-stone-400">Diperbarui</span>
                            <span class="text-stone-600">{{ $package->updated_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Kalender Blackout --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm"
                     x-data="blackoutCalendar({{ $package->blackoutDates->pluck('date')->map(fn($d) => $d->format('Y-m-d'))->toJson() }}, {{ $package->blackoutDates->pluck('note', 'date')->mapWithKeys(fn($note, $date) => [is_string($date) ? $date : $date->format('Y-m-d') => $note])->toJson() }})">

                    {{-- Header Kalender --}}
                    <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-stone-700">Tanggal Blackout</h3>
                            <p class="text-xs text-stone-400 mt-0.5">Tanggal Packages tidak tersedia</p>
                        </div>
                        <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-semibold text-red-500">
                            {{ $package->blackoutDates->count() }} tanggal
                        </span>
                    </div>

                    {{-- Navigasi Bulan --}}
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                        <button @click="prevMonth()"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:bg-stone-50 hover:border-stone-300 transition">
                            <i class="ti ti-chevron-left text-sm"></i>
                        </button>

                        <h4 class="text-sm font-semibold text-stone-800" x-text="monthLabel"></h4>

                        <button @click="nextMonth()"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-stone-200 text-stone-500 hover:bg-stone-50 hover:border-stone-300 transition">
                            <i class="ti ti-chevron-right text-sm"></i>
                        </button>
                    </div>

                    {{-- Grid Kalender --}}
                    <div class="px-6 py-5">

                        {{-- Header Hari --}}
                        <div class="grid grid-cols-7 mb-2">
                            <template x-for="day in ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']">
                                <div class="text-center text-[10px] font-semibold uppercase tracking-wide text-stone-400 py-1"
                                     x-text="day"></div>
                            </template>
                        </div>

                        {{-- Hari --}}
                        <div class="grid grid-cols-7 gap-1">
                            {{-- Empty cells for offset --}}
                            <template x-for="_ in Array(startOffset).fill(null)">
                                <div></div>
                            </template>

                            {{-- Hari dalam bulan --}}
                            <template x-for="day in daysInMonth" :key="day">
                                <div @click="selectDay(day)"
                                     :class="getDayClass(day)"
                                     class="relative flex flex-col items-center justify-center rounded-xl py-2 text-xs font-medium cursor-pointer transition-all duration-150 select-none min-h-[44px]">

                                    <span x-text="day"></span>

                                    {{-- Dot indikator blackout --}}
                                    <template x-if="isBlackout(day)">
                                        <span class="absolute bottom-1 h-1 w-1 rounded-full bg-red-400"></span>
                                    </template>
                                </div>
                            </template>
                        </div>

                    </div>

                    {{-- Detail hari terpilih --}}
                    <div x-show="selectedDay !== null" x-transition
                         class="mx-6 mb-5 rounded-xl border p-4"
                         :class="isBlackout(selectedDay) ? 'border-red-200 bg-red-50' : 'border-stone-200 bg-stone-50'">

                        <template x-if="selectedDay !== null && isBlackout(selectedDay)">
                            <div class="flex items-start gap-3">
                                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-red-100">
                                    <i class="ti ti-calendar-off text-red-500 text-base"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-red-700" x-text="selectedDateLabel"></p>
                                    <p class="text-xs text-red-500 mt-0.5">
                                        <template x-if="getNote(selectedDay)">
                                            <span x-text="getNote(selectedDay)"></span>
                                        </template>
                                        <template x-if="!getNote(selectedDay)">
                                            <span class="italic">Tidak tersedia — tanpa catatan</span>
                                        </template>
                                    </p>
                                </div>
                                <span class="ml-auto flex-shrink-0 rounded-full bg-red-100 px-2 py-0.5 text-[10px] font-semibold text-red-600">
                                    Blackout
                                </span>
                            </div>
                        </template>

                        <template x-if="selectedDay !== null && !isBlackout(selectedDay)">
                            <div class="flex items-center gap-3">
                                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-100">
                                    <i class="ti ti-calendar-check text-emerald-500 text-base"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-emerald-700" x-text="selectedDateLabel"></p>
                                    <p class="text-xs text-emerald-500 mt-0.5">Packages tersedia di tanggal ini</p>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Legend --}}
                    <div class="flex items-center gap-4 border-t border-slate-100 px-6 py-3">
                        <div class="flex items-center gap-1.5 text-xs text-stone-400">
                            <span class="h-3 w-3 rounded bg-red-100 border border-red-200"></span>
                            Blackout
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-stone-400">
                            <span class="h-3 w-3 rounded bg-[#E67E22]/10 border border-[#E67E22]/30"></span>
                            Hari ini
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-stone-400">
                            <span class="h-3 w-3 rounded bg-stone-100 border border-stone-200"></span>
                            Tersedia
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script>
        function blackoutCalendar(blackoutDates, blackoutNotes) {
            const today = new Date();

            return {
                currentYear:  today.getFullYear(),
                currentMonth: today.getMonth(), // 0-indexed
                selectedDay:  null,
                blackoutDates,
                blackoutNotes,

                get monthLabel() {
                    return new Date(this.currentYear, this.currentMonth, 1)
                        .toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
                },

                get daysInMonth() {
                    return new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                },

                get startOffset() {
                    return new Date(this.currentYear, this.currentMonth, 1).getDay();
                },

                get selectedDateLabel() {
                    if (!this.selectedDay) return '';
                    return new Date(this.currentYear, this.currentMonth, this.selectedDay)
                        .toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                },

                currentDateKey(day) {
                    const m = String(this.currentMonth + 1).padStart(2, '0');
                    const d = String(day).padStart(2, '0');
                    return `${this.currentYear}-${m}-${d}`;
                },

                isBlackout(day) {
                    if (!day) return false;
                    return this.blackoutDates.includes(this.currentDateKey(day));
                },

                isToday(day) {
                    return this.currentYear  === today.getFullYear()
                        && this.currentMonth === today.getMonth()
                        && day               === today.getDate();
                },

                isSelected(day) {
                    return this.selectedDay === day;
                },

                getNote(day) {
                    return this.blackoutNotes[this.currentDateKey(day)] || null;
                },

                getDayClass(day) {
                    if (this.isBlackout(day)) {
                        return this.isSelected(day)
                            ? 'bg-red-500 text-white shadow-sm shadow-red-200'
                            : 'bg-red-100 text-red-700 hover:bg-red-200 border border-red-200';
                    }
                    if (this.isToday(day)) {
                        return this.isSelected(day)
                            ? 'bg-[#E67E22] text-white shadow-sm'
                            : 'bg-[#E67E22]/10 text-[#E67E22] font-bold border border-[#E67E22]/30 hover:bg-[#E67E22]/20';
                    }
                    if (this.isSelected(day)) {
                        return 'bg-stone-800 text-white shadow-sm';
                    }
                    return 'text-stone-600 hover:bg-stone-100';
                },

                selectDay(day) {
                    this.selectedDay = (this.selectedDay === day) ? null : day;
                },

                prevMonth() {
                    this.selectedDay = null;
                    if (this.currentMonth === 0) {
                        this.currentMonth = 11;
                        this.currentYear--;
                    } else {
                        this.currentMonth--;
                    }
                },

                nextMonth() {
                    this.selectedDay = null;
                    if (this.currentMonth === 11) {
                        this.currentMonth = 0;
                        this.currentYear++;
                    } else {
                        this.currentMonth++;
                    }
                },
            }
        }
    </script>

</x-app-layout>