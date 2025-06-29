<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Session;

class PengaduanDetailPage extends Component
{
    public $pengaduan;
    public $student_id;

    public function mount($id)
    {
        // Get student_id from parent login session
        $this->student_id = Session::get('parent_student_id');
        
        if (!$this->student_id) {
            return redirect()->route('parent.login');
        }
        
        // Load pengaduan with relations
        $this->pengaduan = Pengaduan::with(['student', 'category', 'assignedToUser', 'complaintResponses.user'])
            ->where('id', $id)
            ->where('student_id', $this->student_id) // Ensure parent can only see their child's pengaduan
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pengaduan-detail-page');
    }
}
