<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Users
Route::middleware(['auth', 'permission:users.view'])->prefix('users')->name('users.')->group(function () {
    Route::get('/',        [UserController::class, 'index'])->name('index');
    Route::get('/create',  [UserController::class, 'create'])->name('create');
    Route::post('/',       [UserController::class, 'store'])->name('store');

    // Wildcard di bawah route statis
    Route::get('/{user}',               [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit',          [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}',               [UserController::class, 'update'])->name('update');
    Route::delete('/{user}',            [UserController::class, 'destroy'])->name('destroy');
    Route::put('/{user}/permissions',   [UserController::class, 'syncPermissions'])->name('permissions.sync');
});

// Roles
Route::middleware(['auth', 'permission:roles.view'])->prefix('roles')->name('roles.')->group(function () {
    Route::get('/',        [RoleController::class, 'index'])->name('index');
    Route::get('/create',  [RoleController::class, 'create'])->name('create');
    Route::post('/',       [RoleController::class, 'store'])->name('store');

    // Wildcard di bawah route statis
    Route::get('/{role}/edit',  [RoleController::class, 'edit'])->name('edit');
    Route::put('/{role}',       [RoleController::class, 'update'])->name('update');
    Route::delete('/{role}',    [RoleController::class, 'destroy'])->name('destroy');
});

// Permissions
Route::middleware(['auth', 'permission:permissions.view'])->prefix('permissions')->name('permissions.')->group(function () {
    Route::get('/',                  [PermissionController::class, 'index'])->name('index');
    Route::post('/',                 [PermissionController::class, 'store'])->name('store');
    Route::delete('/{permission}',   [PermissionController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';