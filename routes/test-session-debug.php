<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Debug route to show session info after login
Route::get('/debug-session/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    
    Auth::login($user);
    
    $sessionInfo = [
        'auth_check' => Auth::check(),
        'auth_user' => Auth::user() ? [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'role' => Auth::user()->role,
        ] : null,
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'middleware_checks' => [
            'admin_role_middleware' => Auth::user() ? in_array(Auth::user()->role, ['super_admin', 'admin', 'guru_bk', 'wali_kelas', 'kepala_sekolah', 'guru_mapel', 'tenaga_pendidik']) : false,
            'teacher_route_check' => Auth::user() ? in_array(Auth::user()->role, ['super_admin', 'admin', 'kepala_sekolah']) : false
        ],
        'cookie_domain' => config('session.domain'),
        'cookie_path' => config('session.path'),
        'request_host' => request()->getHost(),
        'request_scheme' => request()->getScheme()
    ];
    
    return response()->json($sessionInfo, 200, [], JSON_PRETTY_PRINT);
});

// Direct access test with detailed debugging
Route::get('/debug-admin-access/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return 'User not found: ' . $email;
    }
    
    // Log in the user
    Auth::login($user);
    
    // Now try to access the teachers page directly
    $html = '<h1>Debug Admin Access</h1>';
    $html .= '<h2>User Info:</h2>';
    $html .= '<p>Name: ' . $user->name . '</p>';
    $html .= '<p>Email: ' . $user->email . '</p>';
    $html .= '<p>Role: ' . $user->role . '</p>';
    
    $html .= '<h2>Authentication:</h2>';
    $html .= '<p>Auth Check: ' . (Auth::check() ? 'TRUE' : 'FALSE') . '</p>';
    $html .= '<p>Session ID: ' . session()->getId() . '</p>';
    
    $html .= '<h2>Middleware Checks:</h2>';
    $html .= '<p>Admin Role Middleware: ' . (in_array($user->role, ['super_admin', 'admin', 'guru_bk', 'wali_kelas', 'kepala_sekolah', 'guru_mapel', 'tenaga_pendidik']) ? 'PASS' : 'FAIL') . '</p>';
    $html .= '<p>Teacher Route Check: ' . (in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah']) ? 'PASS' : 'FAIL') . '</p>';
    
    $html .= '<h2>Test Links:</h2>';
    $html .= '<p><a href="/admin/dashboard">Dashboard</a></p>';
    $html .= '<p><a href="/admin/teachers">Teachers</a></p>';
    $html .= '<p><a href="/admin/students">Students</a></p>';
    
    return $html;
});
