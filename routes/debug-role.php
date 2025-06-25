<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Debug route untuk test role access
Route::get('/debug-role/{email}', function ($email) {
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
        'auth_user_role' => Auth::user() ? Auth::user()->role : null,
        'role_checks' => [
            'super_admin_access' => in_array($user->role, ['super_admin', 'admin']),
            'teacher_access' => in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah']),
            'student_access' => in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah', 'wali_kelas']),
            'announcement_access' => in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah', 'guru_bk']),
            'gallery_access' => in_array($user->role, ['super_admin', 'admin', 'kepala_sekolah', 'guru_bk', 'tenaga_pendidik']),
        ]
    ];
    
    return response()->json($response, 200, [], JSON_PRETTY_PRINT);
});
