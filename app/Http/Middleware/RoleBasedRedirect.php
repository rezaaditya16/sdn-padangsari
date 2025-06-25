<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya redirect jika user mengakses /admin langsung (tanpa path spesifik)
        if ($request->is('admin') && Auth::check()) {
            $user = Auth::user();
            
            $redirectUrl = match($user->role) {
                'kepala_sekolah' => '/admin/kepala-sekolah',
                'guru_bk' => '/admin/guru-bk',
                'wali_kelas' => '/admin/wali-kelas',
                'guru_mapel' => '/admin/guru-mapel',
                'tenaga_pendidik' => '/admin/tenaga-pendidik',
                'admin' => '/admin/super-admin',
                default => '/admin/pengaduans'
            };
            
            return redirect($redirectUrl);
        }

        return $next($request);
    }
}
