<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\Classroom;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalPengaduan = 0;
    public $pengaduanBaru = 0;
    public $pengaduanDiproses = 0;
    public $pengaduanSelesai = 0;
    public $pengaduanHariIni = 0;
    public $totalSiswa = 0;
    public $totalGuru = 0;
    public $totalKategori = 0;
    public $totalPengumuman = 0;
    public $totalGaleri = 0;
    public $totalKelas = 0;
    public $pengaduanSaya = 0;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadStats();
    }

    public function loadStats()
    {
        // Berdasarkan role, filter pengaduan yang bisa dilihat
        $baseQuery = $this->getPengaduanQuery();

        // Stats pengaduan - clone query untuk setiap penggunaan
        $this->totalPengaduan = (clone $baseQuery)->count();
        $this->pengaduanBaru = (clone $baseQuery)->where('status', 'Diajukan')->count();
        $this->pengaduanDiproses = (clone $baseQuery)->where('status', 'Diproses')->count();
        $this->pengaduanSelesai = (clone $baseQuery)->where('status', 'Selesai')->count();
        $this->pengaduanHariIni = (clone $baseQuery)->whereDate('created_at', today())->count();

        // Stats yang assigned ke user ini
        $this->pengaduanSaya = (clone $baseQuery)->where('assigned_to', $this->user->id)->count();

        // Stats umum (hanya untuk admin)
        if ($this->user->role === 'admin') {
            $this->totalSiswa = Student::count();
            $this->totalGuru = Teacher::count();
            $this->totalKategori = Category::count(); // Untuk pengaduan
            $this->totalPengumuman = Announcement::count();
            $this->totalGaleri = Gallery::count();
            $this->totalKelas = Classroom::count();
        } else {
            // Set nilai default untuk non-admin
            $this->totalSiswa = 0;
            $this->totalGuru = 0;
            $this->totalKategori = 0;
            $this->totalPengumuman = 0;
            $this->totalGaleri = 0;
            $this->totalKelas = 0;
        }
    }

    private function getPengaduanQuery()
    {
        $query = Pengaduan::query();

        if ($this->user->role === 'admin') {
            // Super admin bisa melihat semua
            return $query;
        } else {
            // Role lain hanya melihat pengaduan yang sesuai dengan role mereka
            return $query->where(function($q) {
                $q->where('assigned_to', $this->user->id)
                  ->orWhereHas('category', function($categoryQuery) {
                      $categoryQuery->where('target_role', $this->user->role);
                  });
            });
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
