<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Only allow users with role 'admin' to proceed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            // If the user is not an admin, deny access.
            // For security, just abort with 403 instead of redirecting.
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}


