<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teacher;

class GuruPage extends Component
{
    public function render()
    {
        // Ambil data guru yang aktif saja
        $teachers = Teacher::active()->orderBy('name')->get();

        return view('livewire.guru-page', [
            'teachers' => $teachers,
        ]);
    }
}
