<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;

class PengumumanPage extends Component
{
    public function render()
    {
        // Ambil semua data pengumuman dari database
        $pengumuman = Announcement::orderBy('publish_date', 'desc')->get();

        // Kirim data ke view
        return view('livewire.pengumuman-page', compact('pengumuman'));
    }
}
