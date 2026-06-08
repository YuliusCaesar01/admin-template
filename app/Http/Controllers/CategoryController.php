<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('packages');

        if ($request->filled('search')) {
            $query->where('nama_category', 'like', '%' . $request->search . '%');
        }

        $categories = $query
            ->oldest()
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_category' => 'required|string|max:255',
        ], [
            'nama_category.required' => 'Nama category wajib diisi.',
        ]);

        // Ambil angka urutan terakhir dari category_id yang ada
        $last = Category::orderByRaw("CAST(SUBSTRING(category_id, 5) AS UNSIGNED) DESC")
            ->value('category_id');

        // Ekstrak nomor urut, lalu increment
        $nextNumber = $last ? ((int) substr($last, 4)) + 1 : 1;

        $validated['category_id'] = 'CAT-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Category berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->loadCount('packages');
        $category->load('packages');

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_category' => [
                'required',
                'string',
                'max:100',
                'unique:category,nama_category,' . $category->category_id . ',category_id',
            ],
        ], [
            'nama_category.required' => 'Nama kategori wajib diisi.',
            'nama_category.unique'   => 'Nama kategori sudah terdaftar.',
            'nama_category.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->packages()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki Packages terkait.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}