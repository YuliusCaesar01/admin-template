<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with('roles')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%")->orWhere('email', 'like', "%$s%"))
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = Role::all();
        $userCategories = \App\Models\UserCategory::all();
        return view('users.create', compact('roles', 'userCategories'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $userCategories = \App\Models\UserCategory::all();
        return view('users.edit', compact('user', 'roles', 'userCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $isAdmin = $request->role === 'admin';

        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'         => ['required', 'confirmed', Password::defaults()],
            'role'             => ['required', 'string', 'exists:roles,name'],
            'phone'            => $isAdmin ? ['nullable'] : ['nullable', 'string', 'max:20'],
            'user_category_id' => $isAdmin ? ['nullable'] : ['required', 'exists:user_categories,id'],
            'organization_name'=> ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create($request->only('name', 'email', 'password', 'phone', 'user_category_id', 'organization_name'));
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }

    // update() — sama
    public function update(Request $request, User $user): RedirectResponse
    {
        $isAdmin = $request->role === 'admin';

        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'         => ['nullable', 'confirmed', Password::defaults()],
            'role'             => ['required', 'string', 'exists:roles,name'],
            'phone'            => $isAdmin ? ['nullable'] : ['nullable', 'string', 'max:20'],
            'user_category_id' => $isAdmin ? ['nullable'] : ['required', 'exists:user_categories,id'],
            'organization_name'=> ['nullable', 'string', 'max:255'],
        ]);

        $data = $request->only('name', 'email', 'phone', 'organization_name');
        $data['user_category_id'] = $isAdmin ? null : $request->user_category_id;

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function show(User $user): View
    {
        $user->load('roles', 'category');

        $allPermissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('users.show', compact('user', 'allPermissions'));
    }

    

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function syncPermissions(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // Hanya sync direct permission, tidak menyentuh role
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.show', $user)->with('success', 'Permission user berhasil diperbarui.');
    }
}