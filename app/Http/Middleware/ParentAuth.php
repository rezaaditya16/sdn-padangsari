<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if parent is authenticated via session
        if (!session()->has('authenticated_student_id')) {
            return redirect()->route('parent.login');
        }

        return $next($request);
    }
}
