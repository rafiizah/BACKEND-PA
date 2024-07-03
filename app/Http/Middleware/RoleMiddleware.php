<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::user()->role()->where('name', $role)->exists()) {
            return response('Unauthorized.', 403);
        }

        return $next($request);
    }
}
