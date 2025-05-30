<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Only allow role_id 2 (Owner) or 3 (User)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|in:2,3',
        ]);

        $user = User::create([
            'role_id' => $validated['role_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));
        if($validated['role_id'] == Role::OWNER) {
            $user->assignRole(Role::OWNER);
        } else {
            $user->assignRole(Role::USER);
        }
        // Automatically log in the user after registration
        Auth::login($user);

        // Redirect to the appropriate dashboard based on the role
        if ($user->isOwner()) {
            return to_route('owner.dashboard');
        }
        if ($user->isUser()) {
            return to_route('user.dashboard');
        }
        // Default fallback (just in case)
        return redirect()->route('login');
    }
}
