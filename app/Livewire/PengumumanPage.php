<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;

class PengumumanPage extends Component
{
    public function render()
    {
        // Ambil pengumuman yang dipublikasi saja, urutkan berdasarkan tanggal publish
        $pengumuman = Announcement::published()
                                 ->orderBy('publish_date', 'desc')
                                 ->get();

        // Kirim data ke view
        return view('livewire.pengumuman-page', compact('pengumuman'));
    }
}
