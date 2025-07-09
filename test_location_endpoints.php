<?php
// Test file untuk mengecek endpoint location settings
require_once __DIR__ . '/vendor/autoload.php';

// Test menggunakan cURL
function testGetLocationSettings() {
    $url = 'http://localhost:8000/admin/attendance/location-settings';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "=== GET Location Settings Test ===\n";
    echo "HTTP Code: $httpCode\n";
    echo "Response:\n$response\n\n";
}

function testUpdateLocationSettings() {
    $url = 'http://localhost:8000/admin/attendance/location-settings';

    $data = [
        'school_latitude' => -6.982835,
        'school_longitude' => 110.409355,
        'max_distance' => 500
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-CSRF-TOKEN: test-token-123' // This will fail without proper token, but we can see the response
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "=== POST Location Settings Test ===\n";
    echo "HTTP Code: $httpCode\n";
    echo "Response:\n$response\n\n";
}

echo "Testing Location Settings Endpoints...\n\n";

// Test GET endpoint
testGetLocationSettings();

// Test POST endpoint (will fail due to CSRF, but we can see if route exists)
testUpdateLocationSettings();

echo "Test completed.\n";
