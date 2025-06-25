<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Test routes for different roles
Route::get('/test-login/{role}', function ($role) {
    $emailMap = [
        'guru-bk' => 'bk@sdnpadangsari.sch.id',
        'kepsek' => 'kepsek@sdnpadangsari.sch.id', 
        'wali-kelas' => 'walikelas@sdnpadangsari.sch.id',
        'guru-mapel' => 'gurumapel@sdnpadangsari.sch.id',
        'tendik' => 'tendik@sdnpadangsari.sch.id',
        'super-admin' => 'admin@sdnpadangsari.sch.id'
    ];
    
    if (!isset($emailMap[$role])) {
        return response('Role not found', 404);
    }
    
    $user = User::where('email', $emailMap[$role])->first();
    
    if ($user) {
        Auth::login($user);
        return redirect()->route('admin.dashboard')->with('success', 'Logged in as ' . $user->role);
    }
    
    return redirect()->route('admin.login')->with('error', 'User not found');
});

// Test direct access with specific roles
Route::get('/test-role-access/{role}/{page}', function ($role, $page) {
    $emailMap = [
        'guru-bk' => 'bk@sdnpadangsari.sch.id',
        'kepsek' => 'kepsek@sdnpadangsari.sch.id', 
        'wali-kelas' => 'walikelas@sdnpadangsari.sch.id',
        'guru-mapel' => 'gurumapel@sdnpadangsari.sch.id',
        'tendik' => 'tendik@sdnpadangsari.sch.id',
        'super-admin' => 'admin@sdnpadangsari.sch.id'
    ];
    
    if (!isset($emailMap[$role])) {
        return response('Role not found', 404);
    }
    
    $user = User::where('email', $emailMap[$role])->first();
    if ($user) {
        Auth::login($user);
    }
    
    $routes = [
        'dashboard' => 'admin.dashboard',
        'pengaduan' => 'admin.pengaduan.index',
        'teachers' => 'admin.teachers.index',
        'students' => 'admin.students.index',
        'gallery' => 'admin.gallery.index',
        'announcements' => 'admin.announcements.index',
        'categories' => 'admin.categories.index',
        'users' => 'admin.users.index',
    ];
    
    if (isset($routes[$page])) {
        try {
            return redirect()->route($routes[$page]);
        } catch (Exception $e) {
            return response('Error: ' . $e->getMessage(), 500);
        }
    }
    
    return response('Page not found', 404);
});
