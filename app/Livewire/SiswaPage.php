<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class SiswaPage extends Component
{
    public $kelasFilter = 'all';

    public function render()
    {
        $students = $this->kelasFilter === 'all'
            ? Student::all()
            : Student::where('class', $this->kelasFilter)->get();

        return view('livewire.siswa-page', compact('students'));
    }
}
