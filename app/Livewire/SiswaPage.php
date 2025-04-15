<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class SiswaPage extends Component
{
    public $kelasFilter = 'all';

    public function render()
    {
        if ($this->kelasFilter === 'all') {
            $students = Student::all();
        } elseif (str_starts_with($this->kelasFilter, 'Kelas')) {
            $kelasAngka = str_replace('Kelas ', '', $this->kelasFilter); // hasil: "1", "2", dst
            $students = Student::where('class', 'like', $kelasAngka . '%')->get();
        } else {
            $students = Student::where('class', $this->kelasFilter)->get();
        }
    
        return view('livewire.siswa-page', compact('students'));
    }
    

}
