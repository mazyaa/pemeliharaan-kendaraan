<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif');
        }

        if (!empty($roles) && !in_array(auth()->user()->role?->name, $roles)) {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
