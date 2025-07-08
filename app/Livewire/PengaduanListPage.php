<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Session;

class PengaduanListPage extends Component
{
    public $student_id;
    public $pengaduans;

    public function mount()
    {
        // Get student_id from parent login session
        $this->student_id = Session::get('authenticated_student_id');
        
        if (!$this->student_id) {
            return redirect()->route('parent.login');
        }
        
        // Load pengaduans for this student
        $this->loadPengaduans();
    }

    public function loadPengaduans()
    {
        $this->pengaduans = Pengaduan::with(['category', 'assignedUser', 'complaintResponses'])
            ->where('student_id', $this->student_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.pengaduan-list-page');
    }
}
