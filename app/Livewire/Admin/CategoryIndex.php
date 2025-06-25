<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    // Form properties
    public $showForm = false;
    public $editingCategory = null;
    public $name = '';
    public $targetRole = '';
    
    public $roles = [
        'admin' => 'Admin',
        'guru_bk' => 'Guru BK',
        'wali_kelas' => 'Wali Kelas',
        'kepala_sekolah' => 'Kepala Sekolah',
        'guru_mapel' => 'Guru Mapel',
        'tenaga_pendidik' => 'Tenaga Pendidik',
    ];

    protected $rules = [
        'name' => 'required|string|max:255',
        'targetRole' => 'required|string|in:admin,guru_bk,wali_kelas,kepala_sekolah,guru_mapel,tenaga_pendidik',
    ];

    public function mount()
    {
        // Hanya admin yang bisa mengakses kategori
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterRole, function ($query) {
                $query->where('target_role', $this->filterRole);
            })
            ->withCount('pengaduans')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.category-index', [
            'categories' => $categories
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterRole()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategory = $category;
        $this->name = $category->name;
        $this->targetRole = $category->target_role;
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingCategory) {
            // Check if name is unique (excluding current record)
            $this->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $this->editingCategory->id,
            ]);

            $this->editingCategory->update([
                'name' => $this->name,
                'target_role' => $this->targetRole,
            ]);

            session()->flash('message', 'Kategori berhasil diperbarui!');
        } else {
            // Check if name is unique
            $this->validate([
                'name' => 'required|string|max:255|unique:categories,name',
            ]);

            Category::create([
                'name' => $this->name,
                'target_role' => $this->targetRole,
            ]);

            session()->flash('message', 'Kategori berhasil dibuat!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        
        // Check if category has pengaduans
        if ($category->pengaduans()->count() > 0) {
            session()->flash('error', 'Tidak dapat menghapus kategori yang memiliki pengaduan!');
            return;
        }

        $category->delete();
        session()->flash('message', 'Kategori berhasil dihapus!');
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->editingCategory = null;
        $this->name = '';
        $this->targetRole = '';
        $this->resetErrorBag();
    }
}
