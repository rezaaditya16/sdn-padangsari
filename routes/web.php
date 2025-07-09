<?php
// filepath: d:\sdn-padangsari\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomePage;
use App\Http\Livewire\AboutPage;
use App\Http\Livewire\AchievementPage;
use App\Http\Livewire\AnnouncementPage;
use App\Http\Livewire\ContactPage;
use App\Http\Livewire\GalleryPage;
use App\Http\Livewire\NewsPage;
use App\Http\Livewire\ProfilePage;
use App\Livewire\VisimisiPage;
use App\Livewire\KontakPage;
use App\Livewire\PengumumanPage;
use App\Livewire\PengaduanPage;
use App\Livewire\PengaduanListPage;
use App\Livewire\PengaduanDetailPage;
use App\Livewire\GuruPage;
use App\Livewire\PpdbPage;
use App\Livewire\SiswaPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/achievement', AchievementPage::class)->name('achievement');
Route::get('/announcement', AnnouncementPage::class)->name('announcement');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/galeri', GalleryPage::class)->name('galeri');
Route::get('/news', NewsPage::class)->name('news');
Route::get('/profile', ProfilePage::class)->name('profile');
route::get('/visimisi', VisimisiPage::class)->name('visimisi');
route::get('/kontak', KontakPage::class)->name('kontak');
route::get('/pengumuman', PengumumanPage::class)->name('pengumuman');
route::get('/pengaduan', PengaduanPage::class)->name('pengaduan');
route::get('/pengaduan/login', function () {
    return view('parent-login');
})->name('parent.login');
route::get('/pengaduan/list', PengaduanListPage::class)->name('pengaduan.index')->middleware('parent.auth');
route::get('/pengaduan/detail/{id}', PengaduanDetailPage::class)->name('pengaduan.detail')->middleware('parent.auth');
route::get('/pengaduan/form', PengaduanPage::class)->name('pengaduan.form')->middleware('parent.auth');
route::get('/guru', GuruPage::class)->name('guru');
route::get('/ppdb', PpdbPage::class)->name('ppdb');
route::get('/siswa', SiswaPage::class)->name('siswa');

// Include admin Livewire routes
require __DIR__.'/admin-livewire.php';

// General Authentication Routes
Route::get('/login', [App\Http\Controllers\GeneralAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\GeneralAuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\GeneralAuthController::class, 'logout'])->name('logout');

// Legacy teacher routes (redirect to general login)
Route::get('/teacher/login', function() {
    return redirect()->route('login');
})->name('teacher.login');

Route::post('/teacher/logout', function() {
    return redirect()->route('logout');
})->name('teacher.logout');

// Attendance routes - hanya untuk guru yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [App\Http\Controllers\AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [App\Http\Controllers\AttendanceController::class, 'checkOut'])->name('attendance.checkout');
    Route::get('/attendance/location', [App\Http\Controllers\AttendanceController::class, 'getLocation'])->name('attendance.location');
    Route::get('/attendance/history', [App\Http\Controllers\AttendanceController::class, 'history'])->name('attendance.history');

    // Professional attendance features
    Route::post('/attendance/absence', [App\Http\Controllers\AttendanceController::class, 'submitAbsence'])->name('attendance.absence');
    Route::get('/attendance/discipline-report', [App\Http\Controllers\AttendanceController::class, 'getDisciplineReport'])->name('attendance.discipline-report');
});

// Admin attendance routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'adminIndex'])->name('admin.attendance');
    Route::get('/attendance/dashboard', [App\Http\Controllers\AttendanceController::class, 'adminDashboard'])->name('admin.attendance.dashboard');
    Route::post('/attendance/report', [App\Http\Controllers\AttendanceController::class, 'generateReport'])->name('admin.attendance.report');
    Route::get('/attendance/export', [App\Http\Controllers\AttendanceController::class, 'exportDaily'])->name('admin.attendance.export');

    // Professional attendance management
    Route::post('/attendance/process-absence/{id}', [App\Http\Controllers\AttendanceController::class, 'processAbsence'])->name('admin.attendance.process-absence');
    
    // Location settings routes
    Route::get('/attendance/location-settings', [App\Http\Controllers\AttendanceController::class, 'getLocationSettings'])->name('admin.attendance.location-settings');
    Route::post('/attendance/location-settings', [App\Http\Controllers\AttendanceController::class, 'updateLocationSettings'])->name('admin.attendance.update-location-settings');
});

// Test page untuk location settings (temporary)
Route::get('/test-location-settings', function () {
    return view('test-location-settings');
})->name('test.location.settings');
