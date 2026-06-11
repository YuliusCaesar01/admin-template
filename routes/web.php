<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────
// Landing Page 
// ─────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/layanan',    [LandingController::class, 'layanan'])->name('layanan');
Route::get('/tentang',    [LandingController::class, 'tentang'])->name('tentang');
Route::get('/akreditasi', [LandingController::class, 'akreditasi'])->name('akreditasi');
Route::get('/kontak',     [LandingController::class, 'kontak'])->name('kontak');

// ─────────────────────────────────────────────
// Dashboard
// ─────────────────────────────────────────────
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('dashboard');

// ─────────────────────────────────────────────
// Profile (Breeze)
// ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─────────────────────────────────────────────
// Users
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', 'permission:users.view'])->prefix('users')->name('users.')->group(function () {
    Route::get('/',        [UserController::class, 'index'])->name('index');
    Route::get('/create',  [UserController::class, 'create'])->name('create');
    Route::post('/',       [UserController::class, 'store'])->name('store');

    Route::get('/{user}',             [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit',        [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}',             [UserController::class, 'update'])->name('update');
    Route::delete('/{user}',          [UserController::class, 'destroy'])->name('destroy');
    Route::put('/{user}/permissions', [UserController::class, 'syncPermissions'])->name('permissions.sync');
});

// ─────────────────────────────────────────────
// Roles
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', 'permission:roles.view'])->prefix('roles')->name('roles.')->group(function () {
    Route::get('/',        [RoleController::class, 'index'])->name('index');
    Route::get('/create',  [RoleController::class, 'create'])->name('create');
    Route::post('/',       [RoleController::class, 'store'])->name('store');

    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
    Route::put('/{role}',      [RoleController::class, 'update'])->name('update');
    Route::delete('/{role}',   [RoleController::class, 'destroy'])->name('destroy');
});

// ─────────────────────────────────────────────
// Permissions
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', 'permission:permissions.view'])->prefix('permissions')->name('permissions.')->group(function () {
    Route::get('/',                [PermissionController::class, 'index'])->name('index');
    Route::post('/',               [PermissionController::class, 'store'])->name('store');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
});

// ─────────────────────────────────────────────
// Categories
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', 'permission:categories.view'])->prefix('categories')->name('categories.')->group(function () {
    Route::get('/',        [CategoryController::class, 'index'])->name('index');
    Route::get('/create',  [CategoryController::class, 'create'])->name('create');
    Route::post('/',       [CategoryController::class, 'store'])->name('store');

    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::get('/{category}/show', [CategoryController::class, 'show'])->name('show');
    Route::put('/{category}',      [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}',   [CategoryController::class, 'destroy'])->name('destroy');
});

// ─────────────────────────────────────────────
// Packages
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', 'permission:packages.view'])->prefix('packages')->name('packages.')->group(function () {
    Route::get('/',        [PackageController::class, 'index'])->name('index');
    Route::get('/create',  [PackageController::class, 'create'])->name('create');
    Route::post('/',       [PackageController::class, 'store'])->name('store');

    Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('edit');
    Route::get('/{package}/show', [PackageController::class, 'show'])->name('show');
    Route::put('/{package}',      [PackageController::class, 'update'])->name('update');
    Route::delete('/{package}',   [PackageController::class, 'destroy'])->name('destroy');
});

// ─────────────────────────────────────────────
// Order
// ─────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('orders')->name('orders.')->group(function () {

    // ✅ Static routes DULU — sebelum ada {order}
    Route::middleware('permission:order.view')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
    });

    Route::middleware('permission:order.create')->group(function () {
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/',      [OrderController::class, 'store'])->name('store');
    });

    // ✅ Route dengan {order} parameter SETELAH static routes
    Route::middleware('permission:order.view')->group(function () {
        Route::get('/{order}/show',  [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/files', [OrderController::class, 'indexFiles'])->name('files.index');
    });

    Route::middleware('permission:order.edit')->group(function () {
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}',      [OrderController::class, 'update'])->name('update');
    });

    Route::middleware('permission:order.delete')->group(function () {
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('permission:order.submit')->group(function () {
        Route::post('/{order}/submit', [OrderController::class, 'submit'])->name('submit');
    });

    Route::middleware('permission:order.update-status')->group(function () {
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('status.update');
    });

    Route::middleware('permission:order.offer')->group(function () {
        Route::post('/{order}/offer',            [OrderController::class, 'storeOffer'])->name('offer.store');
        Route::post('/{order}/invoice',          [OrderController::class, 'uploadInvoice'])->name('invoice.store');
        Route::patch('/{order}/offer/file',      [OrderController::class, 'uploadOfferFile'])->name('offer.upload-file');
        Route::get('/{order}/offer/file',        [OrderController::class, 'streamOfferFile'])->name('offer.file');
    });

    Route::middleware('permission:order.files')->group(function () {
        Route::post('/{order}/files',          [OrderController::class, 'storeFile'])->name('files.store');
        Route::delete('/{order}/files/{file}', [OrderController::class, 'destroyFile'])->name('files.destroy');
    });
});

// ─────────────────────────────────────────────
// user Orders — Portal User
// ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan',                    [UserOrderController::class, 'index'])->name('user-orders.index');
    Route::get('/pesanan/create',             [UserOrderController::class, 'create'])->name('user-orders.create');
    Route::post('/pesanan',                   [UserOrderController::class, 'store'])->name('user-orders.store');
    Route::get('/pesanan/{order}',            [UserOrderController::class, 'show'])->name('user-orders.show');
    Route::post('/pesanan/{order}/submit',    [UserOrderController::class, 'submit'])->name('user-orders.submit');
});

// ─────────────────────────────────────────────
// Cart — Keranjang Pengujian (session-based)
// ─────────────────────────────────────────────
Route::prefix('keranjang')->name('cart.')->group(function () {
    Route::get('/',                [CartController::class, 'index'])->name('index');
    Route::post('/add',            [CartController::class, 'add'])->name('add');
    Route::post('/update',         [CartController::class, 'update'])->name('update');
    Route::post('/remove',         [CartController::class, 'remove'])->name('remove');
    Route::post('/clear',          [CartController::class, 'clear'])->name('clear');

    Route::post('/checkout',       [CartController::class, 'checkout'])
        ->middleware('auth')
        ->name('checkout');
});





require __DIR__.'/auth.php';