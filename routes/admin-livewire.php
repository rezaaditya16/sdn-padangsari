<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Login page - handle both guest and authenticated users
    Route::get('/login', function () {
        if (Auth::check()) {
            $user = Auth::user();
            // Redirect berdasarkan role jika sudah login
            if (in_array($user->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.pengaduan.index');
            }
        }
        return view('admin.auth.login');
    })->name('admin.login');

    // Protected admin routes
    Route::middleware(['auth', 'admin.role', 'redirect.role'])->group(function () {
        // Dashboard - hanya untuk admin
        Route::get('/', function () {
            $user = Auth::user();
            if (!in_array($user->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.pengaduan.index');
            }
            return view('admin.dashboard');
        })->name('admin.dashboard');
        
        Route::get('/dashboard', function () {
            $user = Auth::user();
            if (!in_array($user->role, ['admin', 'super_admin'])) {
                return redirect()->route('admin.pengaduan.index');
            }
            return view('admin.dashboard');
        })->name('admin.dashboard.index');

        // Pengaduan Management - semua role dapat akses
        Route::get('/pengaduan', function () {
            return view('admin.pengaduan.index');
        })->name('admin.pengaduan.index');
        
        Route::get('/pengaduan/{id}', function ($id) {
            return view('admin.pengaduan.detail', compact('id'));
        })->name('admin.pengaduan.detail');
        
        Route::get('/pengaduan/{id}/response', function ($id) {
            return view('admin.pengaduan.response', compact('id'));
        })->name('admin.pengaduan.response');

        // Routes berikut hanya untuk Admin/Super Admin
        Route::middleware('superadmin')->group(function () {
            // Categories Management
            Route::get('/categories', function () {
                return view('admin.categories.index');
            })->name('admin.categories.index');

            // User Management
            Route::get('/users', function () {
                return view('admin.users.index');
            })->name('admin.users.index');

            // Students Management
            Route::get('/students', function () {
                return view('admin.students.index');
            })->name('admin.students.index');

            // Teachers Management
            Route::get('/teachers', function () {
                return view('admin.teachers.index');
            })->name('admin.teachers.index');

            // Announcements Management
            Route::get('/announcements', function () {
                return view('admin.announcements.index');
            })->name('admin.announcements.index');

            // Gallery Management
            Route::get('/gallery', function () {
                return view('admin.gallery.index');
            })->name('admin.gallery.index');

            // Classroom Management
            Route::get('/classrooms', function () {
                return view('admin.classrooms.index');
            })->name('admin.classrooms.index');

            // Email Settings
            Route::get('/email-settings', function () {
                return view('admin.email-settings');
            })->name('admin.email-settings');

            // Email Template Editor
            Route::get('/email-template-editor', function () {
                return view('admin.email-template-editor');
            })->name('admin.email-template-editor');
        });

        // Logout
        Route::post('/logout', function () {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('admin.login');
        })->name('admin.logout');
    });
});
