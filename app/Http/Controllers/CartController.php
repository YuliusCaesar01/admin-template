<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Struktur session cart:
    | 'cart' => [
    |     package_id => [
    |         'id'    => int,
    |         'name'  => string,
    |         'price' => float,
    |         'qty'   => int,
    |     ],
    |     ...
    | ]
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ADD — tambah package ke keranjang
    |--------------------------------------------------------------------------
    */

    public function add(Request $request)
    {
        $request->validate([
            'package_id' => ['required', 'exists:packages,id'],
            'qty'        => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $package = Package::findOrFail($request->package_id);
        $cart    = session()->get('cart', []);

        if (isset($cart[$package->id])) {
            // Sudah ada — tambah qty
            $cart[$package->id]['qty'] += (int) $request->qty;
        } else {
            // Baru — tambah item
            $cart[$package->id] = [
                'id'    => $package->id,
                'name'  => $package->name,
                'price' => (float) $package->price,
                'qty'   => (int) $request->qty,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('cart_success', "\"{$package->name}\" ditambahkan ke keranjang.");
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — ubah qty item di keranjang
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $request->validate([
            'package_id' => ['required'],
            'qty'        => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->package_id])) {
            $cart[$request->package_id]['qty'] = (int) $request->qty;
            session()->put('cart', $cart);
        }

        return back()->with('cart_success', 'Jumlah berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE — hapus satu item dari keranjang
    |--------------------------------------------------------------------------
    */

    public function remove(Request $request)
    {
        $request->validate([
            'package_id' => ['required'],
        ]);

        $cart = session()->get('cart', []);
        unset($cart[$request->package_id]);
        session()->put('cart', $cart);

        return back()->with('cart_success', 'Item berhasil dihapus dari keranjang.');
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR — kosongkan seluruh keranjang
    |--------------------------------------------------------------------------
    */

    public function clear()
    {
        session()->forget('cart');

        return back()->with('cart_success', 'Keranjang berhasil dikosongkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX — halaman keranjang
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);

        return view('landing.cart', compact('cart', 'total'));
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT — pindah ke form create order
    | Hanya bisa diakses jika sudah login (middleware 'auth' di route)
    | Data cart diteruskan ke session 'order_cart' lalu dibaca di create()
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('cart_error', 'Keranjang masih kosong.');
        }

        // Simpan ke session sementara agar bisa dibaca di UserOrderController@create
        session()->put('order_cart', $cart);

        return redirect()->route('user-orders.create');
    }
}