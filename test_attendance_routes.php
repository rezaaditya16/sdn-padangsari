<?php
// Test file untuk memverifikasi route attendance
// Jalankan dengan: php test_attendance_routes.php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Route;

// Load Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Test route attendance
echo "=== Testing Attendance Routes ===\n";

$routes = [
    'attendance.index' => '/attendance',
    'attendance.checkin' => '/attendance/checkin',
    'attendance.history' => '/attendance/history',
    'attendance.location' => '/attendance/location',
    'admin.attendance' => '/admin/attendance',
    'teacher.login' => '/teacher/login',
    'teacher.logout' => '/teacher/logout'
];

foreach ($routes as $name => $path) {
    try {
        $route = route($name);
        echo "✓ Route '{$name}' => {$route}\n";
    } catch (Exception $e) {
        echo "✗ Route '{$name}' => ERROR: {$e->getMessage()}\n";
    }
}

echo "\n=== Testing AttendanceController Methods ===\n";

$controllerClass = 'App\Http\Controllers\AttendanceController';
$methods = ['index', 'checkIn', 'adminIndex', 'getLocation', 'history'];

foreach ($methods as $method) {
    if (method_exists($controllerClass, $method)) {
        echo "✓ Method {$controllerClass}::{$method}() exists\n";
    } else {
        echo "✗ Method {$controllerClass}::{$method}() NOT FOUND\n";
    }
}

echo "\n=== Test Complete ===\n";
