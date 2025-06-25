<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Test route that bypasses all middleware
Route::get('/test-no-middleware/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return 'User not found';
    }
    
    Auth::login($user);
    
    try {
        return view('admin.teachers.index');
    } catch (\Exception $e) {
        return 'View error: ' . $e->getMessage();
    }
})->withoutMiddleware(\App\Http\Middleware\AdminRoleMiddleware::class);

// Test route to see all registered routes
Route::get('/test-routes', function () {
    $routes = [];
    foreach (Route::getRoutes() as $route) {
        $routes[] = [
            'method' => $route->methods()[0],
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'middleware' => $route->middleware(),
            'action' => $route->getActionName()
        ];
    }
    
    // Filter for admin routes
    $adminRoutes = array_filter($routes, function($route) {
        return strpos($route['uri'], 'admin') !== false;
    });
    
    return response()->json($adminRoutes, 200, [], JSON_PRETTY_PRINT);
});

// Test middleware stack for specific route
Route::get('/test-middleware-stack/{route}', function ($route) {
    $routeInstance = Route::getRoutes()->getByName($route);
    
    if (!$routeInstance) {
        return response()->json(['error' => 'Route not found'], 404);
    }
    
    return response()->json([
        'route_name' => $route,
        'uri' => $routeInstance->uri(),
        'middleware' => $routeInstance->middleware(),
        'action' => $routeInstance->getActionName()
    ], 200, [], JSON_PRETTY_PRINT);
});
