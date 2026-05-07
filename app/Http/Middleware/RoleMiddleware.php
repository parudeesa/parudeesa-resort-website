<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();

        if ($user->status === 'inactive') {
            auth()->logout();
            return redirect('login')->with('error', 'Your account has been deactivated. Please contact the super admin.');
        }

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
            if ($role === 'superadmin' && $user->is_super_admin) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
