<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Jika tidak ada role yang diperlukan, lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Check apakah user memiliki salah satu role yang diperlukan
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        // Jika tidak memiliki akses, redirect atau abort
        abort(403, 'Unauthorized. You do not have the required role.');
    }
}
