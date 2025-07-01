<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Teacher;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Find a teacher user
$user = User::where('role', 'guru')->first();

if (!$user) {
    echo "No teacher user found\n";
    exit;
}

if (!$user->teacher) {
    echo "User has no teacher relation\n";
    exit;
}

echo "Testing check-in for: " . $user->teacher->name . "\n";

// Check if teacher already has attendance today
$today = Carbon::today();
$existing = Attendance::where('teacher_id', $user->teacher->id)
    ->where('date', $today)
    ->first();

if ($existing) {
    echo "Existing attendance found for today:\n";
    echo "ID: " . $existing->id . "\n";
    echo "Status: " . $existing->status . "\n";
    echo "Check-in: " . ($existing->check_in_time ? $existing->check_in_time : 'Not checked in') . "\n";
    echo "Check-out: " . ($existing->check_out_time ? $existing->check_out_time : 'Not checked out') . "\n";
} else {
    echo "No existing attendance for today\n";
}

// Test distance calculation
$lat1 = -6.982835; // School latitude
$lon1 = 110.409355; // School longitude
$lat2 = -6.982835; // Same location for test
$lon2 = 110.409355;

$distance = Attendance::calculateDistance($lat1, $lon1, $lat2, $lon2);
echo "Distance calculation test: " . $distance . " meters\n";

echo "Test completed\n";
