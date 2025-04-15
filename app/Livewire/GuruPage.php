<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;

class GuruPage extends Component
{
    public function render()
    {
        $teachers = Teacher::all();

        return view('livewire.guru-page', [
            'teachers' => $teachers,
        ]);
    }
}
