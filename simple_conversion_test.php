<?php
// Simple timezone conversion test
// This is a minimal script that does one task: convert a UTC time to Jakarta time

echo "=== Testing 15:10 to 22:10 conversion with DateTime ===\n";
$utcTime = "2023-06-01 15:10:00"; // The UTC time from database

// Convert with PHP's DateTime (simplest method)
$dt = new DateTime($utcTime, new DateTimeZone('UTC'));
$dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
echo "UTC time:     " . $utcTime . "\n";
echo "Jakarta time: " . $dt->format('Y-m-d H:i:s') . "\n";
echo "Hour only:    " . $dt->format('H:i') . "\n";

// Also make sure our server's configured timezone doesn't interfere
echo "Current server timezone: " . date_default_timezone_get() . "\n";
// Force to Asia/Jakarta and try again
date_default_timezone_set('Asia/Jakarta');
echo "Changed server timezone to: " . date_default_timezone_get() . "\n";

// Convert again after timezone change
$dt2 = new DateTime($utcTime, new DateTimeZone('UTC'));
$dt2->setTimezone(new DateTimeZone('Asia/Jakarta'));
echo "UTC time:     " . $utcTime . "\n";
echo "Jakarta time: " . $dt2->format('Y-m-d H:i:s') . "\n";
echo "Hour only:    " . $dt2->format('H:i') . "\n";
