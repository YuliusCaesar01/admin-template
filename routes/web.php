<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────
// Landing Page 
// ─────────────────────────────────────────────
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/layanan',    [LandingController::class, 'layanan'])->name('layanan');
Route::get('/pesanan',    [LandingController::class, 'pesanan'])->name('pesanan');
Route::get('/tentang',    [LandingController::class, 'tentang'])->name('tentang');
Route::get('/akreditasi', [LandingController::class, 'akreditasi'])->name('akreditasi');
Route::get('/kontak',     [LandingController::class, 'kontak'])->name('kontak');

// ─────────────────────────────────────────────
// Dashboard
// ─────────────────────────────────────────────
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
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
Route::middleware(['auth', 'permission:users.view'])->prefix('users')->name('users.')->group(function () {
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
Route::middleware(['auth', 'permission:roles.view'])->prefix('roles')->name('roles.')->group(function () {
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
Route::middleware(['auth', 'permission:permissions.view'])->prefix('permissions')->name('permissions.')->group(function () {
    Route::get('/',                [PermissionController::class, 'index'])->name('index');
    Route::post('/',               [PermissionController::class, 'store'])->name('store');
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
});


// ─────────────────────────────────────────────
// Categories
// ─────────────────────────────────────────────
Route::middleware(['auth', 'permission:categories.view'])->prefix('categories')->name('categories.')->group(function () {
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
Route::middleware(['auth', 'permission:packages.view'])->prefix('packages')->name('packages.')->group(function () {
    Route::get('/',        [PackageController::class, 'index'])->name('index');
    Route::get('/create',  [PackageController::class, 'create'])->name('create');
    Route::post('/',       [PackageController::class, 'store'])->name('store');

    Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('edit');
    Route::get('/{package}/show', [PackageController::class, 'show'])->name('show');
    Route::put('/{package}',      [PackageController::class, 'update'])->name('update');
    Route::delete('/{package}',   [PackageController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';