<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

echo "=== Dashboard Debug Test ===\n";

// Test user authentication
$user = User::where('email', 'admin@sdnpadangsari.sch.id')->first();
if (!$user) {
    echo "❌ Admin user not found!\n";
    exit(1);
}

echo "✅ Admin user found: {$user->name} ({$user->role})\n";

// Simulate login
Auth::login($user);
echo "✅ User logged in\n";

try {
    // Test Dashboard component
    $dashboard = new App\Livewire\Admin\Dashboard();
    echo "✅ Dashboard component created\n";
    
    // Test mount
    $dashboard->mount();
    echo "✅ Dashboard mount() completed\n";
    
    // Test render
    $view = $dashboard->render();
    echo "✅ Dashboard render() completed\n";
    
    echo "\n=== Stats ===\n";
    echo "Total Pengaduan: {$dashboard->totalPengaduan}\n";
    echo "Pengaduan Baru: {$dashboard->pengaduanBaru}\n";
    echo "Total Siswa: {$dashboard->totalSiswa}\n";
    echo "Total Guru: {$dashboard->totalGuru}\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Test completed ===\n";
