<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;

class GalleryPage extends Component
{
    public function render()
    {
        // Ambil galeri yang dipublikasi saja, urutkan berdasarkan tanggal terbaru
        $galleries = Gallery::published()
                           ->orderBy('created_at', 'desc')
                           ->get();

        // Kirim data ke view
        return view('livewire.gallery-page', compact('galleries'));
    }
}
