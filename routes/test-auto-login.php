<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Test auto-login route
Route::get('/test-login-admin', function () {
    $user = User::where('email', 'admin@sdnpadangsari.sch.id')->first();
    
    if ($user) {
        Auth::login($user);
        return redirect()->route('admin.dashboard')->with('success', 'Auto login successful!');
    }
    
    return redirect()->route('admin.login')->with('error', 'Admin user not found');
});

// Test direct access to admin pages (for debugging)
Route::get('/test-direct/{page}', function ($page) {
    $user = User::where('email', 'admin@sdnpadangsari.sch.id')->first();
    if ($user) {
        Auth::login($user);
    }
    
    $routes = [
        'dashboard' => 'admin.dashboard',
        'teachers' => 'admin.teachers.index',
        'students' => 'admin.students.index',
        'gallery' => 'admin.gallery.index',
        'announcements' => 'admin.announcements.index',
        'categories' => 'admin.categories.index',
        'users' => 'admin.users.index',
        'pengaduan' => 'admin.pengaduan.index',
    ];
    
    if (isset($routes[$page])) {
        return redirect()->route($routes[$page]);
    }
    
    return response('Page not found', 404);
});
