<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAccess
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        if (!$user || !$user->canAccessAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akses ditolak.'], 403);
            }
            abort(403, 'Akses ditolak. Anda tidak memiliki hak akses ke panel admin.');
        }

        // Eager-load role + permissions once per request so every
        // hasPermission() call in the layout reuses the cached result.
        if ($user->role_id && !$user->relationLoaded('role')) {
            $user->load('role.permissions');
        }

        return $next($request);
    }
}
