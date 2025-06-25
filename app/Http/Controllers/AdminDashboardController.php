<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\ComplaintResponse;

class AdminDashboardController extends Controller
{
    public function kepalaSekolah()
    {
        $user = Auth::user();
        
        // Kepala sekolah melihat pengaduan kategori administrasi dan overview semua
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('category', function($q) {
                          $q->where('target_role', 'kepala_sekolah');
                      });
            })
            ->latest()
            ->get();
            
        // Statistik untuk kepala sekolah
        $allPengaduans = Pengaduan::all(); // Overview semua pengaduan
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
            'all_total' => $allPengaduans->count(), // Total semua pengaduan untuk overview
        ];

        return view('admin.dashboard.kepala-sekolah', compact('pengaduans', 'stats', 'user'));
    }

    public function guruBK()
    {
        $user = Auth::user();
        
        // Guru BK hanya melihat pengaduan bullying/konseling
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('category', function($q) {
                          $q->where('target_role', 'guru_bk');
                      });
            })
            ->latest()
            ->get();
            
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
        ];

        return view('admin.dashboard.guru-bk', compact('pengaduans', 'stats', 'user'));
    }

    public function waliKelas()
    {
        $user = Auth::user();
        
        // Wali kelas melihat pengaduan dari siswa di kelasnya
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('category', function($q) {
                          $q->where('target_role', 'wali_kelas');
                      });
            })
            ->latest()
            ->get();
            
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
        ];

        return view('admin.dashboard.wali-kelas', compact('pengaduans', 'stats', 'user'));
    }

    public function guruMapel()
    {
        $user = Auth::user();
        
        // Guru mapel hanya melihat pengaduan akademik
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('category', function($q) {
                          $q->where('target_role', 'guru_mapel');
                      });
            })
            ->latest()
            ->get();
            
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
        ];

        return view('admin.dashboard.guru-mapel', compact('pengaduans', 'stats', 'user'));
    }

    public function tenagaPendidik()
    {
        $user = Auth::user();
        
        // Tenaga pendidik hanya melihat pengaduan fasilitas
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhereHas('category', function($q) {
                          $q->where('target_role', 'tenaga_pendidik');
                      });
            })
            ->latest()
            ->get();
            
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
        ];

        return view('admin.dashboard.tenaga-pendidik', compact('pengaduans', 'stats', 'user'));
    }

    public function superAdmin()
    {
        $user = Auth::user();
        
        // Super admin bisa melihat semua pengaduan
        $pengaduans = Pengaduan::with(['student', 'category', 'assignedUser', 'complaintResponses.user'])
            ->latest()
            ->get();
            
        $stats = [
            'total' => $pengaduans->count(),
            'diajukan' => $pengaduans->where('status', 'Diajukan')->count(),
            'dalam_proses' => $pengaduans->where('status', 'Diproses')->count(),
            'selesai' => $pengaduans->where('status', 'Selesai')->count(),
        ];

        $categoryStats = Category::withCount('pengaduans')->get();

        return view('admin.dashboard.super-admin', compact('pengaduans', 'stats', 'categoryStats', 'user'));
    }
}
