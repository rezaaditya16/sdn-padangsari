<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PENGADUAN FILTERING SECURITY TEST ===\n\n";

// Test 1: Login sebagai parent dari student ID 34
echo "TEST 1: Login sebagai parent dari student ID 34\n";
session()->put('authenticated_student_id', 34);

$component = new App\Livewire\PengaduanPage();
$view = $component->render();
$history = $view->getData()['pengaduanHistory'];

echo "- Jumlah pengaduan yang tampil: " . $history->count() . "\n";
echo "- Student IDs dalam data: " . $history->pluck('student_id')->unique()->implode(', ') . "\n";
echo "- Semua milik student 34? " . ($history->pluck('student_id')->unique()->count() == 1 && $history->first()->student_id == 34 ? 'YES' : 'NO') . "\n\n";

// Test 2: Coba ganti ke student ID lain
echo "TEST 2: Ganti session ke student ID 1\n";
session()->put('authenticated_student_id', 1);

$component2 = new App\Livewire\PengaduanPage();
$view2 = $component2->render();
$history2 = $view2->getData()['pengaduanHistory'];

echo "- Jumlah pengaduan yang tampil: " . $history2->count() . "\n";
if ($history2->count() > 0) {
    echo "- Student IDs dalam data: " . $history2->pluck('student_id')->unique()->implode(', ') . "\n";
} else {
    echo "- Tidak ada data (correct untuk student 1)\n";
}

// Test 3: Security test - coba akses detail pengaduan orang lain
echo "\nTEST 3: Security test - akses detail pengaduan\n";
session()->put('authenticated_student_id', 1); // Login sebagai student 1

try {
    $detailComponent = new App\Livewire\PengaduanDetailPage();
    $detailComponent->mount(1); // Coba akses pengaduan ID 1 yang milik student 34
    echo "- SECURITY BREACH: Bisa akses pengaduan orang lain!\n";
} catch (Exception $e) {
    echo "- SECURITY OK: Tidak bisa akses pengaduan orang lain\n";
    echo "- Error: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETED ===\n";
