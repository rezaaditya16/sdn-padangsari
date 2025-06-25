<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Comprehensive test route that does login and redirect in one go
Route::get('/login-and-access/{email}/{target}', function ($email, $target) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    
    Auth::login($user);
    
    $routes = [
        'dashboard' => '/admin/dashboard',
        'teachers' => '/admin/teachers',
        'students' => '/admin/students',
        'gallery' => '/admin/gallery',
        'announcements' => '/admin/announcements',
        'categories' => '/admin/categories',
        'users' => '/admin/users',
    ];
    
    if (!isset($routes[$target])) {
        return response('Invalid target', 400);
    }
    
    $targetUrl = $routes[$target];
    
    // Create debug info
    $debugInfo = [
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ],
        'auth_check' => Auth::check(),
        'target_url' => $targetUrl,
        'session_id' => session()->getId(),
        'middleware_checks' => [
            'admin_role_middleware' => in_array($user->role, ['super_admin', 'admin', 'guru_bk', 'wali_kelas', 'kepala_sekolah', 'guru_mapel', 'tenaga_pendidik']),
            'teacher_route_check' => $target === 'teachers' ? in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah']) : null
        ]
    ];
    
    // Add debug info to session
    session(['debug_info' => $debugInfo]);
    
    return redirect($targetUrl);
});
