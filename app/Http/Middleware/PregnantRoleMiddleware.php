<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PregnantRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role == 'pregnant') {
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'Unauthorized. Only users with role pregnant can access this resource.'
        ], 403);
    }
}
