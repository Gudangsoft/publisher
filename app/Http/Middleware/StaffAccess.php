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

        return $next($request);
    }
}
