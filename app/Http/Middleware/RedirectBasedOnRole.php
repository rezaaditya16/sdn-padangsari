<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Jika guru login, redirect ke halaman absensi
            if ($user->role === 'guru') {
                if ($request->is('admin*')) {
                    return redirect()->route('attendance.index');
                }
            }
            
            // Admin dan Super Admin dapat mengakses semua halaman admin
            if (in_array($user->role, ['admin', 'super_admin'])) {
                return $next($request);
            }
            
            // Role lain hanya bisa mengakses pengaduan
            if ($request->is('admin') || $request->is('admin/')) {
                return redirect('/admin/pengaduan');
            }
            
            // Jika bukan admin dan mencoba mengakses selain pengaduan, redirect ke pengaduan
            if (!$request->is('admin/pengaduan*') && !$request->is('admin/logout')) {
                return redirect('/admin/pengaduan')->with('warning', 'Anda hanya dapat mengakses menu Pengaduan.');
            }
        }
        
        return $next($request);
    }
}
