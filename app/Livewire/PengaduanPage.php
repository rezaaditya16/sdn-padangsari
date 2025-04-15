<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaduan; // Pastikan model Pengaduan sudah ada
use Illuminate\Support\Facades\Mail;

class PengaduanPage extends Component
{
    public $pengaduan;

    public function mount()
    {
        $this->pengaduan = Pengaduan::first();
    }

    public function render()
    {
        return view('livewire.pengaduan-page');
    }
}