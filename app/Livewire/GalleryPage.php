<?php

namespace App\Livewire;

use App\Models\Gallery;
use Livewire\Component;

class GalleryPage extends Component
{
    public function render()
    {
        // Ambil semua data galeri dari database
        $galleries = Gallery::all();

        // Kirim data ke view
        return view('livewire.gallery-page', compact('galleries'));
    }
}
