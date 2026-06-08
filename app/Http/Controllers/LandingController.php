<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Tampilkan halaman landing utama.
     */
    public function index()
    {
        return view('landing.index');
    }

    public function layanan()
    {
        $categories = Category::with(['packages' => function ($q) {
            $q->whereNull('deleted_at')
            ->orderBy('name');
        }])->orderBy('nama_category')->get();

        return view('landing.layanan', compact('categories'));
    }

    public function pesanan()
    {
        return view('landing.pesanan');
    }

    public function tentang()
    {
        return view('landing.tentang');
    }

    public function kontak()
    {
        return view('landing.kontak');
    }

}