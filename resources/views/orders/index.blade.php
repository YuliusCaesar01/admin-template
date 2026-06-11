<x-app-layout :title="'Data Order'">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold text-stone-800">Data Order</h1>
                <p class="text-sm text-stone-500 mt-0.5">Kelola seluruh order pengujian</p>
            </div>
            @can('order.create')
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#cf6d17] transition-colors">
                    <i class="ti ti-plus text-base"></i>
                    Tambah Order
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

        {{-- Card --}}
        <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">

            {{-- Toolbar --}}
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" action="{{ route('orders.index') }}" class="flex flex-wrap items-center gap-2">

                    {{-- Search --}}
                    <div class="relative">
                        <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-stone-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari kode order..."
                               class="w-52 rounded-lg border border-stone-200 bg-stone-50 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder-stone-400 focus:border-[#E67E22] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                    </div>

                    {{-- Filter Type --}}
                    <select name="type"
                            class="rounded-lg border border-stone-200 bg-stone-50 py-2 pl-3 pr-8 text-sm text-slate-700 focus:border-[#E67E22] focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                        <option value="">Semua Tipe</option>
                        <option value="internal" @selected(request('type') === 'internal')>Internal</option>
                        <option value="external" @selected(request('type') === 'external')>External</option>
                    </select>

                    {{-- Filter Status --}}
                    <select name="status"
                            class="rounded-lg border border-stone-200 bg-stone-50 py-2 pl-3 pr-8 text-sm text-slate-700 focus:border-[#E67E22] focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition">
                        <option value="">Semua Status</option>
                        <option value="draft"         @selected(request('status') === 'draft')>Draft</option>
                        <option value="submit"        @selected(request('status') === 'submit')>Submit</option>
                        <option value="offered"       @selected(request('status') === 'offered')>Offered</option>
                        <option value="rejected"      @selected(request('status') === 'rejected')>Rejected</option>
                        <option value="form_required" @selected(request('status') === 'form_required')>Form Required</option>
                        <option value="approved"      @selected(request('status') === 'approved')>Approved</option>
                        <option value="processing"    @selected(request('status') === 'processing')>Processing</option>
                        <option value="done"          @selected(request('status') === 'done')>Done</option>
                    </select>

                    <button type="submit"
                            class="rounded-lg border border-stone-200 bg-white px-3 py-2 text-sm text-slate-600 hover:bg-stone-50 transition">
                        Cari
                    </button>

                    @if(request('search') || request('type') || request('status'))
                        <a href="{{ route('orders.index') }}"
                           class="rounded-lg px-3 py-2 text-sm text-stone-400 hover:text-slate-600 transition">
                            Reset
                        </a>
                    @endif
                </form>

                <span class="text-xs text-stone-400">Total: {{ $orders->total() }} order</span>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">
                            <th class="px-5 py-3">Kode Order</th>
                            <th class="px-5 py-3">Tipe</th>
                            <th class="px-5 py-3">Customer</th>
                            <th class="px-5 py-3 text-center">Status</th>
                            <th class="px-5 py-3 text-center">Dibuat</th>
                            <th class="px-5 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-stone-50/60 transition-colors">

                                {{-- Kode Order --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#E67E22]/10">
                                            <i class="ti ti-file-description text-sm text-[#E67E22]"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-stone-800">{{ $order->order_code }}</p>
                                            <p class="text-xs text-stone-400 truncate max-w-[180px]">{{ $order->pic?->name ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Tipe --}}
                                <td class="px-5 py-3.5">
                                    <span @class([
                                        'inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium',
                                        'bg-blue-50 text-blue-600'   => $order->type === 'internal',
                                        'bg-purple-50 text-purple-600' => $order->type === 'external',
                                    ])>
                                        <i @class(['ti text-[10px]', 'ti-building' => $order->type === 'internal', 'ti-world' => $order->type === 'external'])></i>
                                        {{ ucfirst($order->type) }}
                                    </span>
                                </td>

                                {{-- Customer --}}
                                <td class="px-5 py-3.5 text-stone-500 text-sm">
                                    {{ $order->pic?->organization_name ?? '-' }}
                                </td>

                                {{-- Status --}}
                                <td class="px-5 py-3.5 text-center">
                                    @php
                                        $statusConfig = [
                                            'draft'         => ['bg-stone-100 text-stone-500',   'ti-pencil',        'Draft'],
                                            'submit'        => ['bg-blue-50 text-blue-600',       'ti-send',          'Submit'],
                                            'offered'       => ['bg-amber-50 text-amber-600',     'ti-tag',           'Offered'],
                                            'rejected'      => ['bg-red-50 text-red-500',         'ti-x',             'Rejected'],
                                            'form_required' => ['bg-orange-50 text-orange-500',   'ti-forms',         'Form Required'],
                                            'approved'      => ['bg-emerald-50 text-emerald-600', 'ti-circle-check',  'Approved'],
                                            'processing'    => ['bg-indigo-50 text-indigo-600',   'ti-loader',        'Processing'],
                                            'done'          => ['bg-teal-50 text-teal-600',        'ti-checks',        'Done'],
                                        ];
                                        [$cls, $icon, $label] = $statusConfig[$order->status] ?? ['bg-stone-100 text-stone-500', 'ti-question-mark', ucfirst($order->status)];
                                    @endphp
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cls }}">
                                        <i class="ti {{ $icon }} text-[10px]"></i>
                                        {{ $label }}
                                    </span>
                                </td>

                                {{-- Dibuat --}}
                                <td class="px-5 py-3.5 text-center text-stone-400">
                                    {{ $order->created_at->format('d M Y') }}
                                </td>

                                {{-- Aksi --}}
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-center gap-1">
                                        @can('order.view')
                                            <a href="{{ route('orders.show', $order) }}"
                                               class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-stone-500 hover:bg-slate-100 hover:text-slate-700 transition">
                                                <i class="ti ti-eye text-sm"></i> Detail
                                            </a>
                                        @endcan

                                        @can('order.edit')
                                            <a href="{{ route('orders.edit', $order) }}"
                                               class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-orange-600 hover:bg-orange-50 transition">
                                                <i class="ti ti-pencil text-sm"></i> Edit
                                            </a>
                                        @endcan

                                        @can('order.delete')
                                            @if ($order->status === 'draft')
                                                <form method="POST" action="{{ route('orders.destroy', $order) }}"
                                                      x-data
                                                      @submit.prevent="if(confirm('Yakin ingin menghapus order {{ addslashes($order->order_code) }}?')) $el.submit()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs text-red-500 hover:bg-red-50 transition">
                                                        <i class="ti ti-trash text-sm"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center">
                                    <div class="flex flex-col items-center gap-2 text-stone-400">
                                        <i class="ti ti-file-off text-4xl"></i>
                                        <p class="text-sm">Tidak ada data order ditemukan</p>
                                        @if(request('search') || request('type') || request('status'))
                                            <a href="{{ route('orders.index') }}" class="text-xs text-[#E67E22] hover:underline">Tampilkan semua</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $orders->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>