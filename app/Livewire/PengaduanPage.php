<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaduan; // Pastikan model Pengaduan sudah ada
use Illuminate\Support\Facades\Mail;

class PengaduanPage extends Component
{
    public $nama;
    public $surel;
    public $nomor_kontak;
    public $deskripsi;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'surel' => 'required|email|max:255',
        'nomor_kontak' => 'required|string|max:15',
        'deskripsi' => 'required|string|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        // Simpan pengaduan ke database
        Pengaduan::create([
            'nama' => $this->nama,
            'surel' => $this->surel,
            'nomor_kontak' => $this->nomor_kontak,
            'deskripsi' => $this->deskripsi,
        ]);

        // Reset form
        $this->reset(['nama', 'surel', 'nomor_kontak', 'deskripsi']);

        // Kirim pesan sukses
        session()->flash('message', 'Pengaduan Anda berhasil dikirim.');
    }

    public function render()
    {
        return view('livewire.pengaduan-page');
    }
}