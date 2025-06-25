<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PengaduanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $categoryFilter = '';
    public $assignedFilter = '';
    public $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'assignedFilter' => ['except' => ''],
    ];

    public function mount()
    {
        // Component mounting - authorization handled by middleware
        // Filter pengaduan berdasarkan role akan diterapkan di query
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingAssignedFilter()
    {
        $this->resetPage();
    }

    public function getPengaduansProperty()
    {
        $user = Auth::user();
        $query = Pengaduan::with(['student', 'category', 'assignedUser'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('message', 'like', '%' . $this->search . '%')
                          ->orWhereHas('student', function ($studentQuery) {
                              $studentQuery->where('name', 'like', '%' . $this->search . '%');
                          });
                });
            })
            ->when($this->statusFilter, function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->when($this->categoryFilter, function ($q) {
                $q->where('category_id', $this->categoryFilter);
            })
            ->when($this->assignedFilter, function ($q) {
                $q->where('assigned_to', $this->assignedFilter);
            });

        // Role-based filtering
        if ($user->role !== 'admin') {
            $query->where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhereHas('category', function($categoryQuery) use ($user) {
                      $categoryQuery->where('target_role', $user->role);
                  });
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return Category::all();
        }
        
        return Category::where('target_role', $user->role)->get();
    }

    public function getAssignedUsersProperty()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return User::whereNotNull('role')->get();
        }
        
        return User::where('id', $user->id)->get();
    }

    public function getStatsProperty()
    {
        $user = Auth::user();
        $baseQuery = Pengaduan::query();

        // Apply role filtering to stats
        if ($user->role !== 'admin') {
            $baseQuery->where(function($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhereHas('category', function($categoryQuery) use ($user) {
                      $categoryQuery->where('target_role', $user->role);
                  });
            });
        }

        return [
            'total' => (clone $baseQuery)->count(),
            'diajukan' => (clone $baseQuery)->where('status', 'Diajukan')->count(),
            'diproses' => (clone $baseQuery)->where('status', 'Diproses')->count(),
            'selesai' => (clone $baseQuery)->where('status', 'Selesai')->count(),
        ];
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->categoryFilter = '';
        $this->assignedFilter = '';
        $this->resetPage();
    }

    /**
     * Quick actions untuk pengaduan
     */
    public function assignToMe($pengaduanId)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduanId);
        $user = Auth::user();

        // Check if user can handle this complaint
        if (!$pengaduan->canBeHandledBy($user->id)) {
            session()->flash('error', 'Anda tidak memiliki akses untuk menangani pengaduan ini.');
            return;
        }

        $pengaduan->update(['assigned_to' => $user->id]);
        session()->flash('message', 'Pengaduan berhasil di-assign ke Anda.');
    }

    public function updateStatus($pengaduanId, $newStatus)
    {
        $pengaduan = Pengaduan::findOrFail($pengaduanId);
        $user = Auth::user();

        // Check if user can handle this complaint
        if (!$pengaduan->canBeHandledBy($user->id)) {
            session()->flash('error', 'Anda tidak memiliki akses untuk mengubah status pengaduan ini.');
            return;
        }

        $pengaduan->update(['status' => $newStatus]);
        
        // Create automatic response for status change
        \App\Models\ComplaintResponse::create([
            'pengaduan_id' => $pengaduanId,
            'user_id' => $user->id,
            'message' => "Status pengaduan diubah menjadi: {$newStatus}",
            'action_type' => $newStatus === 'Selesai' ? 'completion' : 'status_update',
        ]);

        session()->flash('message', "Status pengaduan berhasil diubah menjadi: {$newStatus}");
    }

    public function markAsCompleted($pengaduanId)
    {
        $this->updateStatus($pengaduanId, 'Selesai');
    }

    public function markAsInProgress($pengaduanId)
    {
        $this->updateStatus($pengaduanId, 'Diproses');
    }

    /**
     * Check if user can perform actions on pengaduan
     */
    public function canHandle($pengaduan)
    {
        return $pengaduan->canBeHandledBy(Auth::id());
    }

    /**
     * Get available actions for current user and pengaduan
     */
    public function getAvailableActions($pengaduan)
    {
        $user = Auth::user();
        $actions = [];

        if (!$this->canHandle($pengaduan)) {
            return [];
        }

        // Response action - always available if user can handle
        $actions[] = [
            'label' => 'Beri Tanggapan',
            'icon' => 'fas fa-reply',
            'color' => 'blue',
            'route' => 'admin.pengaduan.response',
            'params' => ['id' => $pengaduan->id]
        ];

        // Status-based actions
        if ($pengaduan->status === 'Diajukan') {
            $actions[] = [
                'label' => 'Mulai Proses',
                'icon' => 'fas fa-play',
                'color' => 'yellow',
                'action' => 'markAsInProgress',
                'params' => $pengaduan->id
            ];
            
            if (!$pengaduan->assigned_to) {
                $actions[] = [
                    'label' => 'Assign ke Saya',
                    'icon' => 'fas fa-user-check',
                    'color' => 'green',
                    'action' => 'assignToMe',
                    'params' => $pengaduan->id
                ];
            }
        }

        if ($pengaduan->status === 'Diproses') {
            $actions[] = [
                'label' => 'Tandai Selesai',
                'icon' => 'fas fa-check-circle',
                'color' => 'green',
                'action' => 'markAsCompleted',
                'params' => $pengaduan->id,
                'confirm' => 'Apakah Anda yakin pengaduan ini sudah selesai? Email notifikasi akan dikirim ke orang tua.'
            ];
        }

        // Admin-only actions
        if ($user->role === 'admin') {
            $actions[] = [
                'label' => 'Detail & Edit',
                'icon' => 'fas fa-edit',
                'color' => 'purple',
                'route' => 'admin.pengaduan.detail',
                'params' => ['id' => $pengaduan->id]
            ];
        }

        return $actions;
    }

    public function render()
    {
        return view('livewire.admin.pengaduan-index', [
            'pengaduans' => $this->pengaduans,
            'categories' => $this->categories,
            'assignedUsers' => $this->assignedUsers,
            'stats' => $this->stats,
        ]);
    }
}
