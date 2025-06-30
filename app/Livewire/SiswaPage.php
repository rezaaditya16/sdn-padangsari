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
        // Load students dengan relasi classroom
        $query = Student::with('classroom')->active();

        if (!empty($this->selectedClass)) {
            $query->whereHas('classroom', function($q) {
                $q->where('name', $this->selectedClass);
            });
        }

        $students = $query->orderBy('name')->get();

        // Ambil daftar kelas untuk filter dari tabel classrooms
        $classes = \App\Models\Classroom::orderBy('name')->pluck('name')->toArray();

        return view('livewire.siswa-page', [
            'students' => $students,
            'classes' => $classes,
        ]);
    }
}
