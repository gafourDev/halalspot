<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user) {
                return $this->handleFailedLogin();
            }

            return $this->handleSuccessfulLogin($user);
        } catch (\Exception $e) {
            return $this->handleFailedLogin();
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Handle successful login and redirect based on role.
     */
    private function handleSuccessfulLogin($user): RedirectResponse
    {
        return match ($user->role_id) {
            Role::ADMIN => redirect()->intended(route('admin.dashboard')),
            Role::OWNER => redirect()->intended(route('owner.dashboard')),
            Role::USER => redirect()->intended(route('user.dashboard')),
            default => redirect()->intended(route('dashboard')),
        };
    }

    /**
     * Handle failed login attempt.
     */
    private function handleFailedLogin(): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withErrors(['email' => __('auth.failed')]);
    }
}
