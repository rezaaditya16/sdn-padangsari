<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Set up session untuk parent dengan student ID 34
session()->put('authenticated_student_id', 34);
session()->put('authenticated_student_name', 'adul mancing');
session()->put('authenticated_student_class', 'VI A');

echo "Session set for Student ID: " . session('authenticated_student_id') . "\n";

// Test PengaduanDetailPage
try {
    $component = new App\Livewire\PengaduanDetailPage();
    $component->mount(1); // ID pengaduan pertama
    
    echo "Mount successful!\n";
    echo "Pengaduan Title: " . $component->pengaduan->title . "\n";
    echo "Student Name: " . $component->pengaduan->student->name . "\n";
    echo "Category: " . ($component->pengaduan->category ? $component->pengaduan->category->name : 'null') . "\n";
    echo "Assigned User: " . ($component->pengaduan->assignedUser ? $component->pengaduan->assignedUser->name : 'null') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
