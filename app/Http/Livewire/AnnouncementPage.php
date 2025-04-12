<?php

namespace App\Http\Livewire;

use App\Models\Announcement;
use Livewire\Component;

class AnnouncementPage extends Component
{
    public function render()
    {
        $pengumuman = Announcement::all();
        return view('livewire.announcement-page', compact('pengumuman'));
    }
}
