<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test method isGuru
$user = new App\Models\User();
$user->role = 'guru';

echo method_exists($user, 'isGuru') ? 'Method exists' : 'Method not found';
echo "\n";
echo $user->isGuru() ? 'User is guru' : 'User is not guru';
echo "\n";
