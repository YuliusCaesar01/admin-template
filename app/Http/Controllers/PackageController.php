<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Machine;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Package::with(['category'])
            ->withCount('blackoutDates');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $packages   = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('nama_category')->get();

        return view('packages.index', compact('packages', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('nama_category')->get();

        return view('packages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => ['required', 'exists:category,category_id'],
            'name'             => ['required', 'string', 'max:150'],
            'description'      => ['nullable', 'string'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'base_price'       => ['required', 'numeric', 'min:0'],
            'is_active'        => ['boolean'],
        ], [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists'   => 'Kategori tidak ditemukan.',
            'name.required'        => 'Nama Packages wajib diisi.',
            'name.max'             => 'Nama Packages maksimal 150 karakter.',
            'base_price.required'  => 'Harga dasar wajib diisi.',
            'base_price.numeric'   => 'Harga dasar harus berupa angka.',
            'base_price.min'       => 'Harga dasar tidak boleh negatif.',
            'image.image'          => 'File harus berupa gambar.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('packages', 'private');
        }

        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Packages berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        $package->load(['category', 'blackoutDates' => fn($q) => $q->orderBy('date')]);

        return view('packages.show', compact('package'));
    }

    /**
     * Serve private package image.
     */
    public function image(Package $package)
    {
        abort_unless($package->image && Storage::disk('private')->exists($package->image), 404);

        return response()->file(Storage::disk('private')->path($package->image));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $categories = Category::orderBy('nama_category')->get();

        return view('packages.edit', compact('package', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'machine_id'       => ['required', 'exists:machines,id'],
            'pic_operator_id'  => ['nullable', 'exists:users,id'],
            'category_id'      => ['required', 'exists:category,category_id'],
            'name'             => ['required', 'string', 'max:150'],
            'description'      => ['nullable', 'string'],
            'image'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'base_price'       => ['required', 'numeric', 'min:0'],
            'is_active'        => ['boolean'],
        ], [
            'machine_id.required'  => 'Mesin wajib dipilih.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'name.required'        => 'Nama Packages wajib diisi.',
            'base_price.required'  => 'Harga dasar wajib diisi.',
            'base_price.numeric'   => 'Harga dasar harus berupa angka.',
            'image.image'          => 'File harus berupa gambar.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $validated['is_active'] = $request->boolean('is_active', $package->is_active);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($package->image) {
                Storage::disk('private')->delete($package->image);
            }
            $validated['image'] = $request->file('image')->store('packages', 'private');
        } elseif ($request->boolean('remove_image') && $package->image) {
            Storage::disk('private')->delete($package->image);
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Packages berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Packages berhasil dihapus.');
    }
}