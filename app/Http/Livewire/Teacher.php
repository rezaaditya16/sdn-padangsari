<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Teacher extends Component
{

    public function mount()
    {
        $this->teachers = Teacher::all();
    }

    public function render()
    {
        return view('livewire.teacher', [
            'teachers' => $this->teachers,
        ]);
    }
}
