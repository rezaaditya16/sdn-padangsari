<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Test direct access to teachers page with manual role check
Route::get('/test-direct-teachers/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    
    Auth::login($user);
    
    $response = [
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ],
        'auth_check' => Auth::check(),
        'middleware_check' => [
            'admin_role_allowed' => in_array($user->role, ['super_admin', 'admin', 'guru_bk', 'wali_kelas', 'kepala_sekolah', 'guru_mapel', 'tenaga_pendidik']),
            'teachers_route_allowed' => in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah'])
        ],
        'session_id' => session()->getId(),
        'csrf_token' => csrf_token()
    ];
    
    return response()->json($response, 200, [], JSON_PRETTY_PRINT);
});

// Test accessing teachers view directly
Route::get('/test-teachers-view/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return response('User not found', 404);
    }
    
    Auth::login($user);
    
    // Check all middleware conditions
    if (!Auth::check()) {
        return response('Not authenticated', 401);
    }
    
    if (!in_array($user->role, ['super_admin', 'admin', 'guru_bk', 'wali_kelas', 'kepala_sekolah', 'guru_mapel', 'tenaga_pendidik'])) {
        return response('Admin role middleware failed', 403);
    }
    
    if (!in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah'])) {
        return response('Teachers route role check failed', 403);
    }
    
    try {
        return view('admin.teachers.index');
    } catch (\Exception $e) {
        return response('View error: ' . $e->getMessage(), 500);
    }
});
