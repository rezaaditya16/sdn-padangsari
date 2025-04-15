<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class SiswaPage extends Component
{
    public $selectedClass = '';
    
    public function mount()
    {
        // Initialize with empty string to show all students
    }
    
    public function updatedSelectedClass()
    {
        // This method automatically runs when selectedClass is updated
        // We don't need to do anything here as the render() method will handle the filtering
    }
    
    public function render()
    {
        $query = Student::query();
        
        if (!empty($this->selectedClass)) {
            $query->where('class', $this->selectedClass);
        }
        
        $students = $query->get();
        
        return view('livewire.siswa-page', [
            'students' => $students,
        ]);
    }
}