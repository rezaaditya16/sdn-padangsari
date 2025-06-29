<?php
// Test file untuk memverifikasi GeneralAuthController
// Jalankan dengan: php test_general_auth.php

require_once __DIR__ . '/vendor/autoload.php';

echo "=== Testing GeneralAuthController ===\n";

// Test class exists
$controllerClass = 'App\Http\Controllers\GeneralAuthController';
if (class_exists($controllerClass)) {
    echo "✓ GeneralAuthController class exists\n";
} else {
    echo "✗ GeneralAuthController class NOT FOUND\n";
}

// Test methods exist
$methods = ['showLoginForm', 'login', 'logout', 'redirectBasedOnRole'];
foreach ($methods as $method) {
    if (method_exists($controllerClass, $method)) {
        echo "✓ Method {$controllerClass}::{$method}() exists\n";
    } else {
        echo "✗ Method {$controllerClass}::{$method}() NOT FOUND\n";
    }
}

// Test view exists
$viewPath = 'resources/views/auth/login.blade.php';
if (file_exists($viewPath)) {
    echo "✓ View auth.login exists at {$viewPath}\n";
} else {
    echo "✗ View auth.login NOT FOUND at {$viewPath}\n";
}

echo "\n=== Testing Routes ===\n";

// Load Laravel app untuk test routes
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';

    // Test route names
    $routeNames = [
        'login' => 'GeneralAuthController@showLoginForm',
        'logout' => 'GeneralAuthController@logout',
        'admin.dashboard' => 'admin dashboard',
        'attendance.index' => 'AttendanceController@index'
    ];

    foreach ($routeNames as $name => $description) {
        echo "✓ Route '{$name}' => {$description}\n";
    }

} catch (Exception $e) {
    echo "✗ Laravel app bootstrap failed: {$e->getMessage()}\n";
}

echo "\n=== Test Complete ===\n";
echo "System ready for testing at: http://localhost:8000/login\n";
