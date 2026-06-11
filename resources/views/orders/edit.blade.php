<x-app-layout :title="'Edit Order ' . $order->order_code">

<style>
    .oc-wrap { max-width: 900px; }

    /* ── cards ── */
    .oc-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 14px;
        margin-bottom: 14px;
        overflow: hidden;
    }
    .oc-card-head {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-bottom: 1px solid #f5f5f4;
        background: #fafaf9;
    }
    .oc-card-head i    { font-size: 15px; color: #E67E22; }
    .oc-card-head span { font-size: 13px; font-weight: 600; color: #44403c; }
    .oc-card-body { padding: 16px; }

    /* ── form elements ── */
    .oc-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #78716c;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .oc-input {
        width: 100%;
        font-size: 13px;
        padding: 7px 10px;
        border: 1px solid #d6d3d1;
        border-radius: 8px;
        background: #fafaf9;
        color: #1c1917;
        outline: none;
        transition: border-color .15s, background .15s;
    }
    .oc-input:focus { border-color: #E67E22; background: #fff; }
    .oc-input.is-invalid { border-color: #f87171; }
    textarea.oc-input { resize: none; line-height: 1.55; }

    /* ── category pills ── */
    .oc-cat-pills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }
    .oc-cat-pill {
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 500;
        border: 1px solid #d6d3d1;
        background: #fafaf9;
        color: #78716c;
        cursor: pointer;
        transition: all .15s;
    }
    .oc-cat-pill:hover  { border-color: #E67E22; color: #E67E22; }
    .oc-cat-pill.active { background: #E67E22; border-color: #E67E22; color: #fff; }

    /* ── package grid ── */
    .oc-pkg-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 8px;
        margin-bottom: 14px;
    }
    .oc-pkg-item {
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 10px 12px;
        cursor: pointer;
        transition: border-color .15s, background .15s;
        background: #fafaf9;
        user-select: none;
    }
    .oc-pkg-item:hover    { border-color: #fdba74; }
    .oc-pkg-item.selected {
        border-color: #E67E22;
        background: #fff8f3;
    }
    .oc-pkg-top   { display: flex; justify-content: space-between; align-items: flex-start; gap: 6px; }
    .oc-pkg-name  { font-size: 12px; font-weight: 600; color: #1c1917; line-height: 1.4; }
    .oc-pkg-cat   { font-size: 10px; color: #a8a29e; margin-top: 2px; }
    .oc-pkg-price { font-size: 11px; color: #E67E22; font-weight: 600; margin-top: 5px; }
    .oc-check {
        width: 17px; height: 17px; border-radius: 50%;
        border: 1.5px solid #d6d3d1;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        background: #fff;
        transition: all .15s;
        margin-top: 1px;
    }
    .oc-pkg-item.selected .oc-check {
        background: #E67E22;
        border-color: #E67E22;
        color: #fff;
    }
    .oc-pkg-hidden { display: none !important; }

    /* badge on card header */
    .oc-badge {
        display: inline-flex; align-items: center; justify-content: center;
        background: #E67E22; color: #fff;
        border-radius: 99px; font-size: 10px; font-weight: 600;
        min-width: 18px; height: 18px; padding: 0 5px;
        margin-left: 4px;
    }

    /* ── detail table ── */
    .oc-tbl { width: 100%; border-collapse: collapse; font-size: 12px; }
    .oc-tbl th {
        font-size: 10px; font-weight: 600; text-transform: uppercase;
        letter-spacing: .05em; color: #a8a29e;
        padding: 6px 8px; text-align: left;
        border-bottom: 1px solid #f5f5f4;
    }
    .oc-tbl td {
        padding: 7px 8px;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
        color: #1c1917;
    }
    .oc-tbl tr:last-child td { border-bottom: none; }
    .oc-tbl-input {
        font-size: 12px; padding: 5px 8px;
        border: 1px solid #d6d3d1; border-radius: 6px;
        background: #fafaf9; color: #1c1917; outline: none;
        transition: border-color .15s;
    }
    .oc-tbl-input:focus { border-color: #E67E22; background: #fff; }
    .oc-price-wrap { position: relative; }
    .oc-price-wrap .prefix {
        position: absolute; left: 8px; top: 50%; transform: translateY(-50%);
        font-size: 11px; color: #a8a29e; pointer-events: none;
    }
    .oc-price-wrap input { padding-left: 28px !important; }
    .oc-remove {
        background: none; border: none; cursor: pointer;
        color: #d6d3d1; padding: 3px 5px; border-radius: 6px;
        font-size: 14px; transition: color .15s;
        line-height: 1;
    }
    .oc-remove:hover { color: #ef4444; }

    /* grand total */
    .oc-total-row {
        display: flex; justify-content: flex-end; align-items: center;
        gap: 12px; padding: 10px 8px 2px;
        border-top: 1px solid #f5f5f4; margin-top: 4px;
    }
    .oc-total-label { font-size: 12px; color: #78716c; }
    .oc-total-val   { font-size: 15px; font-weight: 700; color: #1c1917; }

    /* empty state */
    .oc-empty {
        text-align: center; padding: 18px;
        color: #a8a29e; font-size: 12px;
    }
    .oc-empty i { font-size: 26px; display: block; margin-bottom: 6px; color: #e7e5e4; }

    /* upload zone */
    .oc-upload {
        border: 1.5px dashed #d6d3d1;
        border-radius: 10px;
        padding: 18px 16px;
        text-align: center;
        cursor: pointer;
        transition: border-color .15s, background .15s;
    }
    .oc-upload:hover { border-color: #E67E22; background: #fff8f3; }
    .oc-file-existing {
        display: flex; align-items: center; gap: 8px;
        padding: 7px 10px;
        border: 1px solid #e7e5e4;
        border-radius: 8px;
        background: #fafaf9;
        margin-bottom: 8px;
        font-size: 12px;
    }
    .oc-file-existing a { color: #E67E22; text-decoration: none; flex: 1; min-width: 0; }
    .oc-file-existing a:hover { text-decoration: underline; }
    .oc-file-existing i { color: #a8a29e; flex-shrink: 0; }

    /* action bar */
    .oc-action-bar {
        display: flex; justify-content: flex-end;
        align-items: center; gap: 8px;
        padding: 12px 16px;
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 14px;
        position: sticky; bottom: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,.06);
    }
    .oc-btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        background: #E67E22; color: #fff; border: none;
        padding: 9px 20px; border-radius: 9px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        transition: background .15s;
    }
    .oc-btn-primary:hover    { background: #cf6d17; }
    .oc-btn-primary:disabled { opacity: .6; cursor: not-allowed; }
    .oc-btn-ghost {
        display: inline-flex; align-items: center; gap: 6px;
        background: none;
        border: 1px solid #d6d3d1;
        color: #78716c;
        padding: 9px 16px; border-radius: 9px;
        font-size: 13px; font-weight: 500; cursor: pointer;
        transition: all .15s; text-decoration: none;
    }
    .oc-btn-ghost:hover { background: #fafaf9; border-color: #a8a29e; }

    /* status badge */
    .oc-status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        border-radius: 99px; padding: 3px 10px;
        font-size: 11px; font-weight: 600;
    }

    /* error */
    .oc-error { font-size: 11px; color: #ef4444; margin-top: 3px; }

    /* grid helpers */
    .g2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .g3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
    .span2 { grid-column: 1 / -1; }
    @media(max-width: 600px) {
        .g2, .g3 { grid-template-columns: 1fr; }
        .span2    { grid-column: auto; }
        .oc-pkg-grid { grid-template-columns: 1fr 1fr; }
    }
</style>

<div class="space-y-1 animate-fade-in-up oc-wrap mx-auto">

    {{-- ── Breadcrumb + Judul ── --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2 text-sm text-stone-400">
            <a href="{{ route('orders.index') }}" class="hover:text-[#E67E22] transition">Order</a>
            <i class="ti ti-chevron-right text-xs"></i>
            <a href="{{ route('orders.show', $order) }}" class="hover:text-[#E67E22] transition">{{ $order->order_code }}</a>
            <i class="ti ti-chevron-right text-xs"></i>
            <span class="text-stone-600">Edit</span>
        </div>

        {{-- Status Badge --}}
        @php
            $statusConfig = [
                'draft'         => ['background:#f5f5f4;color:#78716c',   'ti-pencil',       'Draft'],
                'submit'        => ['background:#eff6ff;color:#2563eb',   'ti-send',         'Submit'],
                'offered'       => ['background:#fffbeb;color:#d97706',   'ti-tag',          'Offered'],
                'rejected'      => ['background:#fef2f2;color:#ef4444',   'ti-x',            'Rejected'],
                'form_required' => ['background:#fff7ed;color:#ea580c',   'ti-forms',        'Form Required'],
                'approved'      => ['background:#ecfdf5;color:#059669',   'ti-circle-check', 'Approved'],
                'processing'    => ['background:#eef2ff;color:#4f46e5',   'ti-loader',       'Processing'],
                'done'          => ['background:#f0fdfa;color:#0d9488',   'ti-checks',       'Done'],
            ];
            [$pillStyle, $pillIcon, $pillLabel] = $statusConfig[$order->status] ?? ['background:#f5f5f4;color:#78716c', 'ti-question-mark', ucfirst($order->status)];
        @endphp
        <span class="oc-status-pill" style="{{ $pillStyle }}">
            <i class="ti {{ $pillIcon }}" style="font-size:10px"></i>
            {{ $pillLabel }}
        </span>
    </div>

    {{-- ── FORM ── --}}
    @php
        $pkgJson = $categories->flatMap(fn($c) => $c->packages->map(fn($p) => [
            'id'       => $p->id,
            'name'     => $p->name,
            'cat_id'   => $c->id,
            'cat_name' => $c->nama_category,
            'price'    => (float) $p->base_price,
        ]))->values();

        $existingItems = [];
        if ($order->relationLoaded('offer') && $order->offer && $order->offer->details) {
            $existingItems = $order->offer->details->map(fn($d) => [
                'id'             => $d->package_id,
                'name'           => optional($d->package)->name ?? '-',
                'price'          => (float) $d->price,
                'qty'            => (int) $d->qty,
                'nama_mahasiswa' => $d->nama_mahasiswa ?? '',
            ])->values()->all();
        }
    @endphp

    <form
        method="POST"
        action="{{ route('orders.update', $order) }}"
        enctype="multipart/form-data"
        x-data="adminOrderForm()"
        @submit.prevent="submitForm"
        novalidate
    >
        @csrf
        @method('PUT')

        {{-- ─── 1. Informasi Order ─────────────────────────────── --}}
        <div class="oc-card">
            <div class="oc-card-head">
                <i class="ti ti-info-circle" aria-hidden="true"></i>
                <span>Informasi order</span>
            </div>
            <div class="oc-card-body">
                <div class="g2">

                    {{-- PIC --}}
                    <div>
                        <label for="pic_id" class="oc-label">PIC</label>
                        <select id="pic_id" name="pic_id"
                                class="oc-input @error('pic_id') is-invalid @enderror">
                            <option value="">-- Pilih PIC --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" @selected(old('pic_id', $order->pic_id) == $u->id)>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('pic_id')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Customer --}}
                    <div>
                        <label for="customer_id" class="oc-label">Customer</label>
                        <select id="customer_id" name="customer_id"
                                class="oc-input @error('customer_id') is-invalid @enderror">
                            <option value="">-- Pilih customer --</option>
                            @foreach ($customers as $c)
                                <option value="{{ $c->id }}" @selected(old('customer_id', $order->created_by) == $c->id)>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu Diharapkan --}}
                    <div>
                        <label for="waktu_diharapkan" class="oc-label">Waktu diharapkan</label>
                        <input type="date" id="waktu_diharapkan" name="waktu_diharapkan"
                               value="{{ old('waktu_diharapkan', $order->waktu_diharapkan ? \Carbon\Carbon::parse($order->waktu_diharapkan)->format('Y-m-d') : '') }}"
                               class="oc-input @error('waktu_diharapkan') is-invalid @enderror">
                        @error('waktu_diharapkan')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Waktu Pelaksanaan --}}
                    <div>
                        <label for="waktu_pelaksanaan" class="oc-label">Waktu pelaksanaan</label>
                        <input type="date" id="waktu_pelaksanaan" name="waktu_pelaksanaan"
                               value="{{ old('waktu_pelaksanaan', $order->waktu_pelaksanaan ? \Carbon\Carbon::parse($order->waktu_pelaksanaan)->format('Y-m-d') : '') }}"
                               class="oc-input @error('waktu_pelaksanaan') is-invalid @enderror">
                        @error('waktu_pelaksanaan')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label for="lokasi_pelaksanaan" class="oc-label">Lokasi pelaksanaan</label>
                        <input type="text" id="lokasi_pelaksanaan" name="lokasi_pelaksanaan"
                               value="{{ old('lokasi_pelaksanaan', $order->lokasi_pelaksanaan) }}"
                               placeholder="cth: Lab Gedung A Lt. 2"
                               class="oc-input @error('lokasi_pelaksanaan') is-invalid @enderror">
                        @error('lokasi_pelaksanaan')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Saran --}}
                    <div>
                        <label for="saran" class="oc-label">
                            Saran
                            <span style="font-weight:400;text-transform:none;color:#a8a29e">(opsional)</span>
                        </label>
                        <input type="text" id="saran" name="saran"
                               value="{{ old('saran', $order->saran) }}"
                               placeholder="Saran untuk order ini..."
                               class="oc-input @error('saran') is-invalid @enderror">
                        @error('saran')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tujuan Pengujian --}}
                    <div class="span2">
                        <label for="tujuan_pengujian" class="oc-label">Tujuan pengujian</label>
                        <input type="text" id="tujuan_pengujian" name="tujuan_pengujian"
                               value="{{ old('tujuan_pengujian', $order->tujuan_pengujian) }}"
                               placeholder="cth: Uji kuat tekan beton untuk proyek jembatan"
                               maxlength="500"
                               class="oc-input @error('tujuan_pengujian') is-invalid @enderror">
                        @error('tujuan_pengujian')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Keterangan Tambahan --}}
                    <div class="span2">
                        <label for="keterangan_tambahan" class="oc-label">
                            Keterangan tambahan
                            <span style="font-weight:400;text-transform:none;color:#a8a29e">(opsional)</span>
                        </label>
                        <textarea id="keterangan_tambahan" name="keterangan_tambahan"
                                  rows="2"
                                  placeholder="Instruksi khusus atau catatan untuk tim..."
                                  class="oc-input @error('keterangan_tambahan') is-invalid @enderror"
                        >{{ old('keterangan_tambahan', $order->keterangan_tambahan) }}</textarea>
                        @error('keterangan_tambahan')
                            <p class="oc-error">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── 2. Paket Pengujian ─────────────────────────────── --}}
        <div class="oc-card" x-data="packagePicker({{ $pkgJson }}, {{ json_encode($existingItems) }})">
            <div class="oc-card-head">
                <i class="ti ti-packages" aria-hidden="true"></i>
                <span>Paket pengujian</span>
                <span class="oc-badge" x-show="items.length > 0" x-text="items.length"></span>
            </div>
            <div class="oc-card-body">

                {{-- Filter kategori --}}
                <div class="oc-cat-pills">
                    <button type="button"
                            class="oc-cat-pill"
                            :class="{ active: activeCat === null }"
                            @click="activeCat = null">
                        Semua
                    </button>
                    @foreach ($categories as $cat)
                    <button type="button"
                            class="oc-cat-pill"
                            :class="{ active: activeCat === {{ $cat->id }} }"
                            @click="activeCat = {{ $cat->id }}">
                        {{ $cat->nama_category }}
                    </button>
                    @endforeach
                </div>

                {{-- Package grid --}}
                <div class="oc-pkg-grid">
                    @foreach ($categories as $cat)
                        @foreach ($cat->packages as $pkg)
                        <div
                            class="oc-pkg-item"
                            :class="{
                                selected: isSelected({{ $pkg->id }}),
                                'oc-pkg-hidden': activeCat !== null && activeCat !== {{ $cat->id }}
                            }"
                            @click="toggle({{ $pkg->id }}, '{{ addslashes($pkg->name) }}', {{ (float)$pkg->base_price }})">
                            <div class="oc-pkg-top">
                                <div style="flex:1;min-width:0">
                                    <p class="oc-pkg-name">{{ $pkg->name }}</p>
                                    <p class="oc-pkg-cat">{{ $cat->nama_category }}</p>
                                </div>
                                <div class="oc-check">
                                    <i class="ti ti-check" style="font-size:9px" aria-hidden="true"></i>
                                </div>
                            </div>
                            @if ($pkg->base_price > 0)
                            <p class="oc-pkg-price">Rp {{ number_format($pkg->base_price,0,',','.') }}</p>
                            @else
                            <p class="oc-pkg-price" style="color:#a8a29e">Harga belum ditetapkan</p>
                            @endif
                        </div>
                        @endforeach
                    @endforeach
                </div>

                @error('details')
                    <p class="oc-error" style="margin-bottom:10px">{{ $message }}</p>
                @enderror

                {{-- Detail tabel & hidden inputs --}}
                <template x-if="items.length > 0">
                    <div>
                        <p style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.05em;color:#a8a29e;margin-bottom:8px">
                            Detail paket dipilih
                        </p>

                        <div style="overflow-x:auto">
                            <table class="oc-tbl">
                                <thead>
                                    <tr>
                                        <th>Paket</th>
                                        <th style="width:70px">Qty</th>
                                        <th style="width:160px">Harga / item</th>
                                        <th style="width:130px">Subtotal</th>
                                        <th style="width:130px">Nama mahasiswa</th>
                                        <th style="width:32px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, idx) in items" :key="item.id">
                                        <tr>
                                            <td>
                                                <span style="font-weight:600;font-size:12px" x-text="item.name"></span>
                                                <input type="hidden" :name="'details['+idx+'][package_id]'" :value="item.id">
                                                <input type="hidden" :name="'details['+idx+'][qty]'"        :value="item.qty">
                                                <input type="hidden" :name="'details['+idx+'][price]'"      :value="item.price">
                                                <input type="hidden" :name="'details['+idx+'][nama_mahasiswa]'" :value="item.nama_mahasiswa">
                                            </td>

                                            {{-- Qty --}}
                                            <td>
                                                <input type="number"
                                                       x-model.number="item.qty"
                                                       min="1"
                                                       @input="item.qty = Math.max(1, parseInt($event.target.value)||1)"
                                                       class="oc-tbl-input"
                                                       style="width:58px">
                                            </td>

                                            {{-- Harga --}}
                                            <td>
                                                <div class="oc-price-wrap">
                                                    <span class="prefix">Rp</span>
                                                    <input type="text"
                                                           :value="fmtNum(item.price)"
                                                           @input="item.price = parseRp($event.target.value)"
                                                           @blur="$event.target.value = fmtNum(item.price)"
                                                           @focus="$event.target.value = item.price || ''"
                                                           class="oc-tbl-input"
                                                           style="width:138px"
                                                           inputmode="numeric">
                                                </div>
                                            </td>

                                            {{-- Subtotal --}}
                                            <td>
                                                <span style="font-weight:600;color:#E67E22"
                                                      x-text="'Rp '+fmtNum(item.price*item.qty)"></span>
                                            </td>

                                            {{-- Nama Mahasiswa --}}
                                            <td>
                                                <input type="text"
                                                       x-model="item.nama_mahasiswa"
                                                       placeholder="Opsional"
                                                       class="oc-tbl-input"
                                                       style="width:120px">
                                            </td>

                                            {{-- Remove --}}
                                            <td>
                                                <button type="button"
                                                        class="oc-remove"
                                                        @click="remove(item.id)"
                                                        aria-label="Hapus paket">
                                                    <i class="ti ti-trash" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        {{-- Grand Total --}}
                        <div class="oc-total-row">
                            <span class="oc-total-label">Grand total</span>
                            <span class="oc-total-val" x-text="'Rp ' + fmtNum(grandTotal)"></span>
                        </div>
                    </div>
                </template>

                {{-- Empty state --}}
                <template x-if="items.length === 0">
                    <div class="oc-empty">
                        <i class="ti ti-package-off" aria-hidden="true"></i>
                        Belum ada paket dipilih — klik paket di atas untuk menambahkan
                    </div>
                </template>

            </div>
        </div>

        {{-- ─── 3. Lampiran ─────────────────────────────── --}}
        <div class="oc-card">
            <div class="oc-card-head">
                <i class="ti ti-paperclip" aria-hidden="true"></i>
                <span>Lampiran</span>
            </div>
            <div class="oc-card-body">
                <div class="g2">

                    {{-- File Permohonan --}}
                    <div x-data="{ fileName: '', fileSize: '' }">
                        <label class="oc-label">File permohonan</label>

                        @if ($order->file)
                        <div class="oc-file-existing">
                            <i class="ti ti-paperclip" aria-hidden="true"></i>
                            <a href="{{ Storage::url($order->file) }}" target="_blank">
                                {{ basename($order->file) }}
                            </a>
                            <i class="ti ti-external-link" style="font-size:11px;color:#d6d3d1" aria-hidden="true"></i>
                        </div>
                        @endif

                        <div class="oc-upload"
                             @click="$refs.fileInput.click()"
                             :style="fileName ? 'border-color:#E67E22;background:#fff8f3' : ''">
                            <i class="ti ti-cloud-upload"
                               style="font-size:22px;color:#d6d3d1;display:block;margin-bottom:5px"
                               aria-hidden="true"></i>
                            <p style="font-size:12px;color:#78716c;font-weight:500"
                               x-text="fileName || '{{ $order->file ? 'Ganti file' : 'Upload file permohonan' }}'"></p>
                            <p style="font-size:11px;color:#a8a29e;margin-top:2px"
                               x-text="fileSize || 'PDF, DOC, DOCX — maks. 10 MB'"></p>
                            <input type="file" name="file" x-ref="fileInput"
                                   style="display:none" accept=".pdf,.doc,.docx"
                                   @change="
                                       const f = $event.target.files[0];
                                       if (f) {
                                           fileName = f.name;
                                           fileSize = (f.size/1024/1024).toFixed(2) + ' MB';
                                       }
                                   ">
                        </div>
                        @error('file')
                            <p class="oc-error" style="margin-top:5px">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bukti Bayar --}}
                    <div x-data="{ fileName: '', fileSize: '' }">
                        <label class="oc-label">Bukti bayar</label>

                        @if ($order->bukti_bayar)
                        <div class="oc-file-existing">
                            <i class="ti ti-receipt" aria-hidden="true"></i>
                            <a href="{{ Storage::url($order->bukti_bayar) }}" target="_blank">
                                {{ basename($order->bukti_bayar) }}
                            </a>
                            <i class="ti ti-external-link" style="font-size:11px;color:#d6d3d1" aria-hidden="true"></i>
                        </div>
                        @endif

                        <div class="oc-upload"
                             @click="$refs.buktiInput.click()"
                             :style="fileName ? 'border-color:#E67E22;background:#fff8f3' : ''">
                            <i class="ti ti-cloud-upload"
                               style="font-size:22px;color:#d6d3d1;display:block;margin-bottom:5px"
                               aria-hidden="true"></i>
                            <p style="font-size:12px;color:#78716c;font-weight:500"
                               x-text="fileName || '{{ $order->bukti_bayar ? 'Ganti bukti bayar' : 'Upload bukti bayar' }}'"></p>
                            <p style="font-size:11px;color:#a8a29e;margin-top:2px"
                               x-text="fileSize || 'PDF, JPG, PNG — maks. 5 MB'"></p>
                            <input type="file" name="bukti_bayar" x-ref="buktiInput"
                                   style="display:none" accept=".pdf,.jpg,.jpeg,.png"
                                   @change="
                                       const f = $event.target.files[0];
                                       if (f) {
                                           fileName = f.name;
                                           fileSize = (f.size/1024/1024).toFixed(2) + ' MB';
                                       }
                                   ">
                        </div>
                        @error('bukti_bayar')
                            <p class="oc-error" style="margin-top:5px">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── Action Bar (sticky bottom) ─────────────────────── --}}
        <div class="oc-action-bar">
            <span style="font-size:12px;color:#a8a29e;flex:1">
                Perubahan akan langsung tersimpan ke order <strong>{{ $order->order_code }}</strong>.
            </span>
            <a href="{{ route('orders.show', $order) }}" class="oc-btn-ghost">
                <i class="ti ti-arrow-left" aria-hidden="true"></i>
                Batal
            </a>
            <button type="submit" class="oc-btn-primary" :disabled="isSubmitting">
                <template x-if="!isSubmitting">
                    <i class="ti ti-device-floppy" aria-hidden="true"></i>
                </template>
                <template x-if="isSubmitting">
                    <i class="ti ti-loader-2" style="animation:spin 1s linear infinite" aria-hidden="true"></i>
                </template>
                <span x-text="isSubmitting ? 'Menyimpan…' : 'Simpan perubahan'">Simpan perubahan</span>
            </button>
        </div>

        <style>@keyframes spin{to{transform:rotate(360deg)}}</style>

    </form>
</div>

<script>
function packagePicker(packages, existingItems) {
    return {
        packages,
        activeCat: null,
        items: existingItems || [],

        isSelected(id) {
            return this.items.some(i => i.id === id);
        },

        toggle(id, name, price) {
            if (this.isSelected(id)) {
                this.remove(id);
            } else {
                this.items.push({ id, name, price, qty: 1, nama_mahasiswa: '' });
            }
        },

        remove(id) {
            this.items = this.items.filter(i => i.id !== id);
        },

        get grandTotal() {
            return this.items.reduce((s, i) => s + (i.price * i.qty), 0);
        },

        fmtNum(n) {
            return Math.round(n || 0).toLocaleString('id-ID');
        },

        parseRp(v) {
            return parseInt(String(v).replace(/\D/g, '')) || 0;
        },
    };
}

function adminOrderForm() {
    return {
        isSubmitting: false,

        submitForm(e) {
            this.isSubmitting = true;
            e.target.submit();
        },
    };
}
</script>

</x-app-layout>