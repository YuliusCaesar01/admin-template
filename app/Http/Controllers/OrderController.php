<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderFile;
use App\Models\OrderOffer;
use App\Models\OrderOfferDetail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;


class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Order::with(['pic', 'creator'])
            ->when($request->type, fn($q, $v) => $q->where('type', $v))
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->when($request->search, function ($q, $v) {
                $q->where('order_code', 'like', "%{$v}%");
            })
            ->latest();

        $orders = $query->paginate($request->per_page ?? 15);

        if ($request->expectsJson()) {
            return response()->json($orders);
        }

        return view('orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — tampilkan form buat order baru
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $users      = User::orderBy('name')->get();
        $customers  = User::role('user')->orderBy('name')->get();
        $categories = Category::with(['packages' => fn($q) => $q->where('is_active', true)])
                        ->orderBy('nama_category')
                        ->get();

        return view('orders.create', compact('users', 'customers', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'                => ['required', Rule::in([Order::TYPE_INTERNAL, Order::TYPE_EXTERNAL])],
            'pic_id'              => ['nullable', 'exists:users,id'],
            'customer_id'         => ['nullable', 'exists:users,id'],
            'tujuan_pengujian'    => ['nullable', 'string'],
            'waktu_diharapkan'    => ['nullable', 'date'],
            'keterangan_tambahan' => ['nullable', 'string'],
            'lokasi_pelaksanaan'  => ['nullable', 'string'],
            'file'                => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'details'             => ['nullable', 'array'],
            'details.*.package_id'     => ['required', 'exists:packages,id'],
            'details.*.qty'            => ['required', 'integer', 'min:1'],
            'details.*.price'          => ['required', 'numeric', 'min:0'],
            'details.*.nama_mahasiswa' => ['nullable', 'string', 'max:255'],
        ]);

        $order = null; // ← deklarasi di luar

        DB::transaction(function () use ($request, $validated, &$order) { // ← &$order

            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('orders/files', 'public');
            }

            $order = Order::create([
                'type'                => $validated['type'],
                'pic_id'              => $validated['pic_id'] ?? null,
                'created_by'          => $validated['customer_id'] ?? Auth::id(),
                'tujuan_pengujian'    => $validated['tujuan_pengujian'] ?? null,
                'waktu_diharapkan'    => $validated['waktu_diharapkan'] ?? null,
                'keterangan_tambahan' => $validated['keterangan_tambahan'] ?? null,
                'lokasi_pelaksanaan'  => $validated['lokasi_pelaksanaan'] ?? null,
                'file'                => $filePath,
            ]);

            if (!empty($validated['details'])) {
                $offer = $order->offer()->create([
                    'notes' => null,
                    'terms' => null,
                ]);

                $detailRows = array_map(fn($d) => [
                    'order_offer_id' => $offer->id,
                    'package_id'     => $d['package_id'],
                    'qty'            => $d['qty'],
                    'price'          => $d['price'],
                    'nama_mahasiswa' => $d['nama_mahasiswa'] ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ], $validated['details']);

                OrderOfferDetail::insert($detailRows);
            }
        });

        return redirect()
            ->route('orders.show', $order) // ← sekarang $order sudah ter-assign
            ->with('success', 'Order berhasil dibuat.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        
        $order->load([
            'creator.category',
            'creator',
            'offer.details.package',
            'hasilUjiFiles',
            'reviews',
        ]);

        $grand_total = $order->grand_total;

        $permissions = [
            'can_open_permohonan_pdf'       => $order->canOpenPermohonanPdf(),
            'can_open_mou_kesanggupan_pdf'  => $order->canOpenMouKesanggupanPdf(),
            'can_open_bap_pdf'              => $order->canOpenBapPdf(),
            'can_open_bukti_bayar'          => $order->canOpenBuktiBayar(),
            'can_open_laporan_kegiatan_pdf' => $order->canOpenLaporanKegiatanPdf(),
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'data'        => $order,
                'grand_total' => $grand_total,
                'permissions' => $permissions,
            ]);
        }

        return view('orders.show', compact('order', 'grand_total', 'permissions'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT — tampilkan form edit order
    |--------------------------------------------------------------------------
    */

    public function edit(Order $order)
    {
        $order->load('offer.details.package');
        $users      = User::orderBy('name')->get();
        $customers  = User::role('user')->orderBy('name')->get();
        $categories = Category::with('packages')->orderBy('nama_category')->get();

        return view('orders.edit', compact('order', 'users', 'customers', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'company_id'          => ['nullable', 'exists:companies,id'],
            'contact_id'          => ['nullable', 'exists:contacts,id'],
            'pic_id'              => ['nullable', 'exists:users,id'],
            'tujuan_pengujian'    => ['nullable', 'string'],
            'waktu_diharapkan'    => ['nullable', 'date'],
            'keterangan_tambahan' => ['nullable', 'string'],
            'waktu_pelaksanaan'   => ['nullable', 'date'],
            'lokasi_pelaksanaan'  => ['nullable', 'string'],
            'saran'               => ['nullable', 'string'],
            'file'                => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'bukti_bayar'         => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'customer_id'         => ['nullable', 'exists:users,id'],
        ]);

        if ($request->hasFile('file')) {
            if ($order->file) {
                Storage::disk('public')->delete($order->file);
            }
            $validated['file'] = $request->file('file')->store('orders/files', 'public');
        }

        if ($request->hasFile('bukti_bayar')) {
            if ($order->bukti_bayar) {
                Storage::disk('public')->delete($order->bukti_bayar);
            }
            $validated['bukti_bayar'] = $request->file('bukti_bayar')->store('orders/bukti-bayar', 'public');
        }

        $order->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Order berhasil diperbarui.',
                'data'    => $order->fresh(['company', 'contact', 'pic', 'creator']),
            ]);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Order berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Request $request, Order $order)
    {
        if ($order->status !== Order::STATUS_DRAFT) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Hanya order berstatus draft yang dapat dihapus.',
                ], 422);
            }

            return back()->with('error', 'Hanya order berstatus draft yang dapat dihapus.');
        }

        $order->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Order berhasil dihapus.']);
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT — ubah status draft → submit
    |--------------------------------------------------------------------------
    */

    public function submit(Request $request, Order $order)
    {
        if ($order->status !== Order::STATUS_DRAFT) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Order tidak dalam status draft.'], 422);
            }

            return back()->with('error', 'Order tidak dalam status draft.');
        }

        $order->update([
            'status'  => Order::STATUS_SUBMIT,
            'sent_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Order berhasil disubmit.',
                'data'    => $order,
            ]);
        }

        return back()->with('success', 'Order berhasil disubmit.');
    }

    /*
    |--------------------------------------------------------------------------
    | Menambahkan file penawaran
    |--------------------------------------------------------------------------
    */

    public function uploadOfferFile(Request $request, Order $order)
    {
        $request->validate([
            'offer_file' => ['required', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        abort_unless($order->offer, 404, 'Offer belum dibuat.');

        if ($order->offer->offer_file_path) {
            Storage::delete($order->offer->offer_file_path);
        }

        $path = $request->file('offer_file')->storeAs(
            "order/{$order->order_code}/penawaran",
            'penawaran_' . now()->format('Ymd_His') . '.pdf'
        );

        $order->offer->update(['offer_file_path' => $path]);

        return back()->with('success', 'File penawaran berhasil diunggah.');
    }

    public function streamOfferFile(Order $order)
    {
        abort_unless($order->offer?->offer_file_path, 404);
        abort_unless(Storage::exists($order->offer->offer_file_path), 404);

        return Storage::response(
            $order->offer->offer_file_path,
            'penawaran_' . $order->order_code . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS (oleh admin / PIC)
    |--------------------------------------------------------------------------
    */

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                Order::STATUS_OFFERED,
                Order::STATUS_REJECTED,
                Order::STATUS_FORM_REQUIRED,
                Order::STATUS_APPROVED,
                Order::STATUS_PROCESSING,
                Order::STATUS_DONE,
            ])],
        ]);

        $order->update(['status' => $validated['status']]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Status order berhasil diperbarui.',
                'data'    => $order,
            ]);
        }

        return back()->with('success', 'Status order berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | OFFER — kelola penawaran harga
    |--------------------------------------------------------------------------
    */

    public function storeOffer(Request $request, Order $order)
    {
        $validated = $request->validate([
            'notes'                        => ['nullable', 'string'],
            'terms'                        => ['nullable', 'string'],
            'offer_file'                   => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'details'                      => ['required', 'array', 'min:1'],
            'details.*.package_id'         => ['required', 'exists:packages,id'],
            'details.*.qty'                => ['required', 'integer', 'min:1'],
            'details.*.price'              => ['required', 'numeric', 'min:0'],
            'details.*.nama_mahasiswa'     => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($order, $validated, $request) {
            $offerData = [
                'order_id' => $order->id,
                'notes'    => $validated['notes'] ?? null,
                'terms'    => $validated['terms'] ?? null,
            ];

            if ($request->hasFile('offer_file')) {
                $offerData['offer_file_path'] = $request->file('offer_file')
                    ->store('orders/offers', 'public');
            }

            $offer = $order->offer
                ? tap($order->offer)->update($offerData)
                : OrderOffer::create($offerData);

            $offer->details()->delete();

            foreach ($validated['details'] as $detail) {
                $offer->details()->create($detail);
            }

            $order->update(['status' => Order::STATUS_OFFERED]);
        });

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Penawaran berhasil disimpan.',
                'data'    => $order->load('offer.details.package'),
            ]);
        }

        return back()->with('success', 'Penawaran berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | HASIL UJI FILES — upload / list / delete
    |--------------------------------------------------------------------------
    */

    public function indexFiles(Request $request, Order $order)
    {
        $files = $order->hasilUjiFiles()->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $files]);
        }

        // fallback: redirect ke show jika diakses via browser
        return redirect()->route('orders.show', $order);
    }

    public function storeFile(Request $request, Order $order)
    {
        $validated = $request->validate([
            'hasil_uji_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,xlsx,xls,doc,docx', 'max:20480'],
            'file_name'      => ['nullable', 'string', 'max:255'],
            'link_url'       => ['nullable', 'url', 'max:2048'],
            'link_label'     => ['nullable', 'string', 'max:255'],
        ]);

        $fileData = [
            'order_id'   => $order->id,
            'file_name'  => $validated['file_name'] ?? null,
            'link_url'   => $validated['link_url'] ?? null,
            'link_label' => $validated['link_label'] ?? null,
        ];

        if ($request->hasFile('hasil_uji_file')) {
            $fileData['hasil_uji_file'] = $request->file('hasil_uji_file')
                ->store('orders/hasil-uji', 'public');
        }

        $orderFile = OrderFile::create($fileData);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'File berhasil diupload.',
                'data'    => $orderFile,
            ], 201);
        }

        return back()->with('success', 'File berhasil diupload.');
    }

    public function destroyFile(Request $request, Order $order, OrderFile $file)
    {
        if ($file->order_id !== $order->id) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'File tidak ditemukan pada order ini.'], 404);
            }

            return back()->with('error', 'File tidak ditemukan pada order ini.');
        }

        if ($file->hasil_uji_file) {
            Storage::disk('public')->delete($file->hasil_uji_file);
        }

        $file->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'File berhasil dihapus.']);
        }

        return back()->with('success', 'File berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | INVOICE — simpan path invoice ke offer
    |--------------------------------------------------------------------------
    */

    public function uploadInvoice(Request $request, Order $order)
    {
        $request->validate([
            'invoice_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if (!$order->offer) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Order belum memiliki penawaran.'], 422);
            }

            return back()->with('error', 'Order belum memiliki penawaran.');
        }

        if ($order->offer->invoice_file_path) {
            Storage::disk('public')->delete($order->offer->invoice_file_path);
        }

        $path = $request->file('invoice_file')->store('orders/invoices', 'public');

        $order->offer->update(['invoice_file_path' => $path]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Invoice berhasil diupload.',
                'data'    => $order->offer,
            ]);
        }

        return back()->with('success', 'Invoice berhasil diupload.');
    }
}