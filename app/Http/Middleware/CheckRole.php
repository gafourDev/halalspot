<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Map role names to IDs (ideally, fetch from DB or config)
        $roleMap = [
            'admin' => 1,
            'owner' => 2,
            'user'  => 3,
        ];

        $allowedRoleIds = array_map(fn($role) => $roleMap[$role] ?? null, $roles);

        if (!$user || !in_array($user->role_id, $allowedRoleIds, true)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
