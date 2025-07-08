<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TESTING PENGADUAN SYSTEM ===\n\n";

// Test 1: Get student data
$student = App\Models\Student::find(34);
if ($student) {
    echo "✅ Student found: {$student->name} (ID: {$student->id})\n";
} else {
    echo "❌ Student not found\n";
    exit;
}

// Test 2: Get pengaduan for this student
$pengaduans = App\Models\Pengaduan::where('student_id', 34)->get();
echo "✅ Found " . $pengaduans->count() . " pengaduan(s) for this student\n";

if ($pengaduans->count() > 0) {
    $pengaduan = $pengaduans->first();
    echo "   - First pengaduan ID: {$pengaduan->id}\n";
    echo "   - Title: {$pengaduan->title}\n";
    echo "   - Status: {$pengaduan->status}\n";
    
    // Test 3: Check relations
    echo "✅ Testing relations:\n";
    echo "   - Category: " . ($pengaduan->category ? $pengaduan->category->name : 'null') . "\n";
    echo "   - Assigned User: " . ($pengaduan->assignedUser ? $pengaduan->assignedUser->name : 'null') . "\n";
    echo "   - Responses: " . $pengaduan->complaintResponses->count() . "\n";
    
    // Test 4: Test PengaduanDetailPage component
    echo "\n✅ Testing PengaduanDetailPage component:\n";
    
    // Set session
    session()->put('authenticated_student_id', 34);
    session()->put('authenticated_student_name', $student->name);
    session()->put('authenticated_student_class', $student->class);
    
    try {
        $component = new App\Livewire\PengaduanDetailPage();
        $component->mount($pengaduan->id);
        
        echo "   - Component mounted successfully\n";
        echo "   - Pengaduan loaded: {$component->pengaduan->title}\n";
        echo "   - Student ID matches: " . ($component->student_id == 34 ? 'Yes' : 'No') . "\n";
        
    } catch (Exception $e) {
        echo "   - ❌ Error: " . $e->getMessage() . "\n";
    }
    
    // Test 5: Test PengaduanListPage component
    echo "\n✅ Testing PengaduanListPage component:\n";
    
    try {
        $component = new App\Livewire\PengaduanListPage();
        $component->mount();
        
        echo "   - Component mounted successfully\n";
        echo "   - Found " . $component->pengaduans->count() . " pengaduan(s)\n";
        echo "   - Student ID matches: " . ($component->student_id == 34 ? 'Yes' : 'No') . "\n";
        
    } catch (Exception $e) {
        echo "   - ❌ Error: " . $e->getMessage() . "\n";
    }
    
} else {
    echo "❌ No pengaduan found for this student\n";
}

echo "\n=== TEST COMPLETED ===\n";
