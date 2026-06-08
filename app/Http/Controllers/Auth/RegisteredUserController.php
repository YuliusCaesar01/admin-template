<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserCategory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $categories = UserCategory::orderBy('category_name')->get()
            ->groupBy('user_type'); // ['internal' => [...], 'external' => [...]]

        return view('auth.register', compact('categories'));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'phone'             => ['nullable', 'string', 'max:20'],
            'user_type'         => ['required', 'in:internal,external'],
            'user_category_id'  => ['required', 'exists:user_categories,id'],
            'organization_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'phone'             => $request->phone,
            'user_category_id'  => $request->user_category_id,
            'organization_name' => $request->organization_name,
        ]);

        $user->assignRole('user'); // 👈

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('landing', absolute: false));
    }
}