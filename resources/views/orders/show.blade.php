<x-app-layout :title="'Detail Order ' . $order->order_code">

    <div class="space-y-6 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-400 mb-1">
                    <a href="{{ route('orders.index') }}" class="hover:text-[#E67E22] transition">Order</a>
                    <i class="ti ti-chevron-right text-xs"></i>
                    <span class="text-stone-600">{{ $order->order_code }}</span>
                </div>
                <h1 class="text-xl font-semibold text-stone-800">Detail Order</h1>
                <p class="text-sm text-stone-500 mt-0.5">Informasi lengkap order pengujian</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                @can('order.edit')
                    <a href="{{ route('orders.edit', $order) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-stone-200 bg-white px-4 py-2.5 text-sm font-medium text-stone-700 shadow-sm hover:bg-stone-50 transition-colors">
                        <i class="ti ti-pencil text-base"></i>
                        Edit
                    </a>
                @endcan

                @can('order.submit')
                    @if ($order->status === 'draft')
                        <form method="POST" action="{{ route('orders.submit', $order) }}"
                              x-data
                              @submit.prevent="if(confirm('Yakin ingin submit order ini?')) $el.submit()">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#E67E22] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#cf6d17] transition-colors">
                                <i class="ti ti-send text-base"></i>
                                Submit Order
                            </button>
                        </form>
                    @endif
                @endcan
            </div>
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

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- Kolom Kiri (detail utama) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Informasi Umum --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-stone-100 px-5 py-4 flex items-center gap-2">
                        <i class="ti ti-info-circle text-[#E67E22]"></i>
                        <h2 class="font-semibold text-stone-700 text-sm">Informasi Umum</h2>
                    </div>
                    <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Kode Order</p>
                            <p class="text-sm font-semibold text-stone-800">{{ $order->order_code }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Tipe</p>
                            @php
                                $typeClass = $order->type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600';
                                $typeIcon  = $order->type === 'internal' ? 'ti-building' : 'ti-world';
                            @endphp
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $typeClass }}">
                                <i class="ti {{ $typeIcon }} text-[10px]"></i>
                                {{ ucfirst($order->type) }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Status</p>
                            @php
                                $statusConfig = [
                                    'draft'         => ['bg-stone-100 text-stone-500',   'ti-pencil',       'Draft'],
                                    'submit'        => ['bg-blue-50 text-blue-600',       'ti-send',         'Submit'],
                                    'offered'       => ['bg-amber-50 text-amber-600',     'ti-tag',          'Offered'],
                                    'rejected'      => ['bg-red-50 text-red-500',         'ti-x',            'Rejected'],
                                    'form_required' => ['bg-orange-50 text-orange-500',   'ti-forms',        'Form Required'],
                                    'approved'      => ['bg-emerald-50 text-emerald-600', 'ti-circle-check', 'Approved'],
                                    'processing'    => ['bg-indigo-50 text-indigo-600',   'ti-loader',       'Processing'],
                                    'done'          => ['bg-teal-50 text-teal-600',        'ti-checks',       'Done'],
                                ];
                                [$cls, $icon, $label] = $statusConfig[$order->status] ?? ['bg-stone-100 text-stone-500', 'ti-question-mark', ucfirst($order->status)];
                            @endphp
                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cls }}">
                                <i class="ti {{ $icon }} text-[10px]"></i>
                                {{ $label }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">PIC</p>
                            <p class="text-sm text-stone-700">{{ $order->pic?->name ?? '-' }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs text-stone-400 mb-2">Customer</p>
                        
                            @if ($order->creator)
                                @php $c = $order->creator; @endphp
                                <div class="rounded-xl border border-stone-100 bg-stone-50 px-4 py-3 flex flex-col sm:flex-row sm:items-start gap-3">
                        
                                    {{-- Avatar inisial --}}
                                    <div class="flex-shrink-0 w-9 h-9 rounded-full bg-[#E67E22]/15 flex items-center justify-center">
                                        <span class="text-sm font-bold text-[#E67E22]">
                                            {{ strtoupper(substr($c->name, 0, 1)) }}
                                        </span>
                                    </div>
                        
                                    {{-- Info --}}
                                    <div class="flex-1 min-w-0 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5">
                        
                                        {{-- Nama --}}
                                        <div>
                                            <p class="text-[10px] text-stone-400 uppercase tracking-wide">Nama</p>
                                            <p class="text-sm font-semibold text-stone-800 truncate">{{ $c->name }}</p>
                                        </div>
                        
                                        {{-- Kategori User --}}
                                        <div>
                                            <p class="text-[10px] text-stone-400 uppercase tracking-wide">Kategori</p>
                                            @if ($order->creator?->category)
                                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-medium
                                                    {{ $order->creator->category->user_type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                                    <i class="ti {{ $order->creator->category->user_type === 'internal' ? 'ti-building' : 'ti-world' }} text-[9px]"></i>
                                                    {{ $order->creator->category->category_name }}
                                                </span>
                                            @else
                                                <p class="text-sm text-stone-500">-</p>
                                            @endif
                                        </div>
                        
                                        {{-- Email --}}
                                        <div>
                                            <p class="text-[10px] text-stone-400 uppercase tracking-wide">Email</p>
                                            @if ($c->email)
                                                <a href="mailto:{{ $c->email }}"
                                                class="text-sm text-[#E67E22] hover:underline truncate block">
                                                    {{ $c->email }}
                                                </a>
                                            @else
                                                <p class="text-sm text-stone-400">-</p>
                                            @endif
                                        </div>
                        
                                        {{-- Telepon --}}
                                        <div>
                                            <p class="text-[10px] text-stone-400 uppercase tracking-wide">Telepon</p>
                                            @if ($c->phone)
                                                <a href="tel:{{ $c->phone }}"
                                                class="text-sm text-stone-700 hover:text-[#E67E22] transition">
                                                    {{ $c->phone }}
                                                </a>
                                            @else
                                                <p class="text-sm text-stone-400">-</p>
                                            @endif
                                        </div>
                        
                                        {{-- Organisasi / Instansi --}}
                                        @if ($c->organization_name)
                                        <div class="sm:col-span-2">
                                            <p class="text-[10px] text-stone-400 uppercase tracking-wide">Organisasi / Instansi</p>
                                            <p class="text-sm text-stone-700">{{ $c->organization_name }}</p>
                                        </div>
                                        @endif
                        
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-stone-400">-</p>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Tanggal Dibuat</p>
                            <p class="text-sm text-stone-700">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        @if ($order->sent_at)
                            <div>
                                <p class="text-xs text-stone-400 mb-0.5">Tanggal Submit</p>
                                <p class="text-sm text-stone-700">{{ \Carbon\Carbon::parse($order->sent_at)->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Waktu Diharapkan</p>
                            <p class="text-sm text-stone-700">{{ $order->waktu_diharapkan ? \Carbon\Carbon::parse($order->waktu_diharapkan)->format('d M Y') : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-stone-400 mb-0.5">Waktu Pelaksanaan</p>
                            <p class="text-sm text-stone-700">{{ $order->waktu_pelaksanaan ? \Carbon\Carbon::parse($order->waktu_pelaksanaan)->format('d M Y') : '-' }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs text-stone-400 mb-0.5">Lokasi Pelaksanaan</p>
                            <p class="text-sm text-stone-700">{{ $order->lokasi_pelaksanaan ?? '-' }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs text-stone-400 mb-0.5">Tujuan Pengujian</p>
                            <p class="text-sm text-stone-700 whitespace-pre-line">{{ $order->tujuan_pengujian ?? '-' }}</p>
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-xs text-stone-400 mb-0.5">Keterangan Tambahan</p>
                            <p class="text-sm text-stone-700 whitespace-pre-line">{{ $order->keterangan_tambahan ?? '-' }}</p>
                        </div>

                        @if ($order->saran)
                            <div class="sm:col-span-2">
                                <p class="text-xs text-stone-400 mb-0.5">Saran</p>
                                <p class="text-sm text-stone-700 whitespace-pre-line">{{ $order->saran }}</p>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Penawaran --}}
                @if ($order->offer)
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-stone-100 px-5 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="ti ti-tag text-[#E67E22]"></i>
                                <h2 class="font-semibold text-stone-700 text-sm">Penawaran Harga</h2>
                            </div>
                            <span class="text-sm font-semibold text-stone-800">
                                Grand Total: <span class="text-[#E67E22]">Rp {{ number_format($grand_total, 0, ',', '.') }}</span>
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-stone-50 text-xs font-semibold uppercase tracking-wide text-stone-500">
                                        <th class="px-5 py-3 text-left">Paket</th>
                                        <th class="px-5 py-3 text-center">Qty</th>
                                        <th class="px-5 py-3 text-right">Harga</th>
                                        <th class="px-5 py-3 text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($order->offer->details as $detail)
                                        <tr class="hover:bg-stone-50/60">
                                            <td class="px-5 py-3">
                                                <p class="font-medium text-stone-800">{{ $detail->package?->name ?? '-' }}</p>
                                                @if ($detail->nama_mahasiswa)
                                                    <p class="text-xs text-stone-400">{{ $detail->nama_mahasiswa }}</p>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3 text-center text-stone-600">{{ $detail->qty }}</td>
                                            <td class="px-5 py-3 text-right text-stone-600">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td class="px-5 py-3 text-right font-medium text-stone-800">Rp {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($order->offer->notes || $order->offer->terms)
                            <div class="px-5 py-4 border-t border-stone-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if ($order->offer->notes)
                                    <div>
                                        <p class="text-xs text-stone-400 mb-1">Catatan</p>
                                        <p class="text-sm text-stone-700 whitespace-pre-line">{{ $order->offer->notes }}</p>
                                    </div>
                                @endif
                                @if ($order->offer->terms)
                                    <div>
                                        <p class="text-xs text-stone-400 mb-1">Syarat & Ketentuan</p>
                                        <p class="text-sm text-stone-700 whitespace-pre-line">{{ $order->offer->terms }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Hasil Uji Files --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-stone-100 px-5 py-4 flex items-center gap-2">
                        <i class="ti ti-files text-[#E67E22]"></i>
                        <h2 class="font-semibold text-stone-700 text-sm">File Hasil Uji</h2>
                    </div>
                    <div class="px-5 py-4">
                        @forelse ($order->hasilUjiFiles as $file)
                            <div class="flex items-center justify-between py-2 border-b border-stone-100 last:border-0">
                                <div class="flex items-center gap-3">
                                    <i class="ti ti-paperclip text-stone-400"></i>
                                    <div>
                                        <p class="text-sm text-stone-700">{{ $file->file_name ?? basename($file->hasil_uji_file ?? $file->link_url ?? '-') }}</p>
                                        @if ($file->link_label)
                                            <p class="text-xs text-stone-400">{{ $file->link_label }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($file->hasil_uji_file)
                                        <a href="{{ Storage::url($file->hasil_uji_file) }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-xs text-[#E67E22] hover:underline">
                                            <i class="ti ti-download text-sm"></i> Unduh
                                        </a>
                                    @elseif ($file->link_url)
                                        <a href="{{ $file->link_url }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-xs text-blue-500 hover:underline">
                                            <i class="ti ti-external-link text-sm"></i> Buka
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-stone-400 text-center py-4">Belum ada file hasil uji.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan (sidebar) --}}
            <div class="space-y-6">

                {{-- Dokumen & Akses --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-stone-100 px-5 py-4 flex items-center gap-2">
                        <i class="ti ti-file-check text-[#E67E22]"></i>
                        <h2 class="font-semibold text-stone-700 text-sm">Dokumen</h2>
                    </div>
                    <div class="px-5 py-4 space-y-2">

                        @php
                            $docs = [
                                ['label' => 'Surat Permohonan',    'can' => $permissions['can_open_permohonan_pdf'],       'icon' => 'ti-file-text'],
                                ['label' => 'MOU Kesanggupan',     'can' => $permissions['can_open_mou_kesanggupan_pdf'],  'icon' => 'ti-file-certificate'],
                                ['label' => 'BAP',                 'can' => $permissions['can_open_bap_pdf'],             'icon' => 'ti-file-analytics'],
                                ['label' => 'Bukti Bayar',         'can' => $permissions['can_open_bukti_bayar'],         'icon' => 'ti-receipt'],
                                ['label' => 'Laporan Kegiatan',    'can' => $permissions['can_open_laporan_kegiatan_pdf'], 'icon' => 'ti-report'],
                            ];
                        @endphp

                        @foreach ($docs as $doc)
                            <div class="flex items-center justify-between rounded-lg px-3 py-2.5 {{ $doc['can'] ? 'bg-stone-50 hover:bg-stone-100' : 'bg-stone-50/50 opacity-50' }} transition">
                                <div class="flex items-center gap-2">
                                    <i class="ti {{ $doc['icon'] }} text-stone-400 text-sm"></i>
                                    <span class="text-sm text-stone-700">{{ $doc['label'] }}</span>
                                </div>
                                @if ($doc['can'])
                                    <i class="ti ti-lock-open text-emerald-500 text-xs"></i>
                                @else
                                    <i class="ti ti-lock text-stone-300 text-xs"></i>
                                @endif
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- Berkas Lampiran --}}
                <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="border-b border-stone-100 px-5 py-4 flex items-center gap-2">
                        <i class="ti ti-paperclip text-[#E67E22]"></i>
                        <h2 class="font-semibold text-stone-700 text-sm">Berkas Lampiran</h2>
                    </div>
                    <div class="px-5 py-4 space-y-2">

                        {{-- File Permohonan --}}
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-stone-500">File Permohonan</span>
                            @if ($order->file)
                                <a href="{{ Storage::url($order->file) }}" target="_blank"
                                   class="text-xs text-[#E67E22] inline-flex items-center gap-1 hover:underline">
                                    <i class="ti ti-download"></i> Unduh
                                </a>
                            @else
                                <span class="text-xs text-stone-300">-</span>
                            @endif
                        </div>

                        {{-- Bukti Bayar --}}
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-stone-500">Bukti Bayar</span>
                            @if ($order->bukti_bayar)
                                <a href="{{ Storage::url($order->bukti_bayar) }}" target="_blank"
                                   class="text-xs text-[#E67E22] inline-flex items-center gap-1 hover:underline">
                                    <i class="ti ti-download"></i> Unduh
                                </a>
                            @else
                                <span class="text-xs text-stone-300">-</span>
                            @endif
                        </div>

                        {{-- Invoice --}}
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-stone-500">Invoice</span>
                            @if ($order->offer?->invoice_file_path)
                                <a href="{{ Storage::url($order->offer->invoice_file_path) }}" target="_blank"
                                   class="text-xs text-[#E67E22] inline-flex items-center gap-1 hover:underline">
                                    <i class="ti ti-download"></i> Unduh
                                </a>
                            @else
                                <span class="text-xs text-stone-300">-</span>
                            @endif
                        </div>

                        {{-- Offer File --}}
                        <div class="flex items-center justify-between" x-data="{ editing: false }">
                            <span class="text-sm text-stone-500">File Penawaran</span>

                            @if ($order->offer)
                                <div class="flex items-center gap-2">

                                    {{-- Tampilan normal (tidak sedang edit) --}}
                                    <template x-if="!editing">
                                        <div class="flex items-center gap-2">
                                            @if ($order->offer->offer_file_path)
                                                <a href="{{ route('orders.offer.file', $order) }}" target="_blank"
                                                    class="text-xs text-[#E67E22] inline-flex items-center gap-1 hover:underline">
                                                        <i class="ti ti-file-type-pdf text-[13px]"></i> Lihat PDF
                                                </a>
                                                <span class="text-stone-200 text-xs">|</span>
                                            @endif
                                            <button type="button" @click="editing = true"
                                                class="text-xs inline-flex items-center gap-1 rounded-md border border-dashed
                                                    {{ $order->offer->offer_file_path ? 'border-stone-300 bg-stone-50 text-stone-400 hover:border-orange-300 hover:bg-orange-50 hover:text-orange-500' : 'border-orange-300 bg-orange-50 text-orange-500 hover:bg-orange-100 hover:border-orange-400' }}
                                                    px-2.5 py-1 transition-colors duration-150">
                                                <i class="ti ti-{{ $order->offer->offer_file_path ? 'pencil' : 'upload' }} text-[13px]"></i>
                                                {{ $order->offer->offer_file_path ? 'Ganti' : 'Upload' }}
                                            </button>
                                        </div>
                                    </template>

                                    {{-- Tampilan saat edit --}}
                                    <template x-if="editing">
                                        <form action="{{ route('orders.offer.upload-file', $order) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="flex items-center gap-1.5">
                                            @csrf
                                            @method('PATCH')

                                            <label class="relative flex items-center">
                                                <input type="file"
                                                    name="offer_file"
                                                    accept=".pdf,application/pdf"
                                                    required
                                                    class="block w-[160px] text-[11px] text-stone-500 cursor-pointer
                                                            file:mr-2 file:py-1 file:px-2.5
                                                            file:rounded file:border-0
                                                            file:text-[11px] file:font-medium
                                                            file:bg-orange-50 file:text-orange-600
                                                            hover:file:bg-orange-100
                                                            focus:outline-none">
                                            </label>

                                            <button type="submit"
                                                class="text-xs inline-flex items-center gap-1 rounded-md bg-orange-500 px-2.5 py-1 text-white hover:bg-orange-600 transition-colors duration-150">
                                                <i class="ti ti-check text-[13px]"></i> Simpan
                                            </button>

                                            <button type="button" @click="editing = false"
                                                class="text-xs inline-flex items-center gap-1 rounded-md bg-stone-100 px-2.5 py-1 text-stone-500 hover:bg-stone-200 transition-colors duration-150">
                                                <i class="ti ti-x text-[13px]"></i>
                                            </button>
                                        </form>
                                    </template>

                                </div>
                            @else
                                <span class="text-xs text-stone-300">-</span>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Update Status (Admin) --}}
                @can('order.update-status')
                    <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                        <div class="border-b border-stone-100 px-5 py-4 flex items-center gap-2">
                            <i class="ti ti-adjustments text-[#E67E22]"></i>
                            <h2 class="font-semibold text-stone-700 text-sm">Update Status</h2>
                        </div>
                        <div class="px-5 py-4">
                            <form method="POST" action="{{ route('orders.status.update', $order) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                        class="w-full rounded-lg border border-stone-200 bg-stone-50 py-2 pl-3 pr-8 text-sm text-slate-700 focus:border-[#E67E22] focus:outline-none focus:ring-2 focus:ring-[#E67E22]/10 transition mb-3">
                                    <option value="offered"       @selected($order->status === 'offered')>Offered</option>
                                    <option value="rejected"      @selected($order->status === 'rejected')>Rejected</option>
                                    <option value="form_required" @selected($order->status === 'form_required')>Form Required</option>
                                    <option value="approved"      @selected($order->status === 'approved')>Approved</option>
                                    <option value="processing"    @selected($order->status === 'processing')>Processing</option>
                                    <option value="done"          @selected($order->status === 'done')>Done</option>
                                </select>
                                <button type="submit"
                                        class="w-full rounded-lg bg-[#E67E22] py-2 text-sm font-medium text-white hover:bg-[#cf6d17] transition">
                                    Simpan Status
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>

</x-app-layout>