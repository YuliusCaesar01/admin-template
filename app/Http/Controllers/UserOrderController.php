<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderOffer;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserOrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Guard — pastikan order milik user yang sedang login
    |--------------------------------------------------------------------------
    */

    private function authorizeOrder(Order $order): void
    {
        abort_unless($order->created_by === Auth::id(), 403);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX — list pesanan milik sendiri
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where('created_by', Auth::id())
            ->with([
                'offer.details', // untuk grand total & jumlah parameter
            ])
            ->latest()
            ->paginate(10);

        return view('landing.pesanan', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $cartItems = session()->get('order_cart', []);

        $categories = collect();
        if (empty($cartItems)) {
            $categories = Category::with(['packages' => function ($q) {
                $q->where('is_active', true)->orderBy('name');
            }])->whereHas('packages', fn($q) => $q->where('is_active', true))
            ->get();
        }

        return view('user-order.create', compact('cartItems', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tujuan_pengujian'    => ['nullable', 'string', 'max:500'],
            'waktu_diharapkan'    => ['nullable', 'date'],
            'keterangan_tambahan' => ['nullable', 'string'],
            'file'                => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'package_ids'         => ['nullable', 'array'],
            'package_ids.*'       => ['integer', 'exists:packages,id'],
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('orders/files', 'public');
        }

        $user = Auth::user();

        $validated['type']       = $user->isInternal() ? 'internal' : 'external';
        $validated['created_by'] = $user->id;
        $validated['status']     = Order::STATUS_SUBMIT;

        // Ambil package_ids — dari form langsung atau dari cart session
        $cartItems  = session()->get('order_cart', []);
        $packageIds = $validated['package_ids'] ?? array_keys($cartItems);

        DB::transaction(function () use ($validated, $packageIds, $cartItems, &$order) {
            // Bersihkan package_ids agar tidak masuk kolom orders
            $orderData = collect($validated)->except('package_ids')->toArray();
            $order = Order::create($orderData);

            if (!empty($packageIds)) {
                $offer = OrderOffer::create(['order_id' => $order->id]);

                foreach ($packageIds as $packageId) {
                    $package = Package::find($packageId);
                    if (!$package) continue;

                    // Jika dari cart, ambil qty & nama_mahasiswa; jika dari form, default qty=1
                    $qty            = $cartItems[$packageId]['qty'] ?? 1;
                    $namaMahasiswa  = $cartItems[$packageId]['nama_mahasiswa'] ?? null;

                    $offer->details()->create([
                        'package_id'     => $packageId,
                        'qty'            => $qty,
                        'price'          => $package->base_price ?? $package->harga ?? 0,
                        'nama_mahasiswa' => $namaMahasiswa,
                    ]);
                }
            }
        });

        session()->forget(['cart', 'order_cart']);

        return redirect()
            ->route('user-orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — detail pesanan milik sendiri
    |--------------------------------------------------------------------------
    */

    public function show(Order $order)
    {
        $this->authorizeOrder($order);

        $order->load([
            'offer.details.package',
            'hasilUjiFiles',
            'reviews',
        ]);

        return view('user-order.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT — draft → submit
    |--------------------------------------------------------------------------
    */

    public function submit(Order $order)
    {
        $this->authorizeOrder($order);

        abort_unless(
            $order->status === Order::STATUS_DRAFT,
            422,
            'Hanya pesanan berstatus draft yang dapat disubmit.'
        );

        $order->update([
            'status'  => Order::STATUS_SUBMIT,
            'sent_at' => now(),
        ]);

        return redirect()
            ->route('user-orders.show', $order)
            ->with('success', 'Pesanan berhasil diajukan.');
    }
}