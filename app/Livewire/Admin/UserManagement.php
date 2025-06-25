<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    
    // Form properties
    public $showForm = false;
    public $editingUser = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation = '';
    public $role = '';
    public $emailVerified = false;
    
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
        'email' => 'required|email|max:255',
        'role' => 'required|string|in:admin,guru_bk,wali_kelas,kepala_sekolah,guru_mapel,tenaga_pendidik',
        'password' => 'required|string|min:6',
        'passwordConfirmation' => 'required|same:password',
    ];

    public function mount()
    {
        // Hanya admin yang bisa mengakses user management
        if (!in_array(Auth::user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Unauthorized');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterRole, function ($query) {
                $query->where('role', $this->filterRole);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users
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
        $user = User::findOrFail($id);
        $this->editingUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->emailVerified = $user->email_verified_at !== null;
        $this->password = '';
        $this->passwordConfirmation = '';
        $this->showForm = true;
    }

    public function save()
    {
        if ($this->editingUser) {
            // Update validation rules for edit
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $this->editingUser->id,
                'role' => 'required|string|in:admin,guru_bk,wali_kelas,kepala_sekolah,guru_mapel,tenaga_pendidik',
            ];

            // Password is optional when editing
            if (!empty($this->password)) {
                $rules['password'] = 'required|string|min:6';
                $rules['passwordConfirmation'] = 'required|same:password';
            }

            $this->validate($rules);

            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'email_verified_at' => $this->emailVerified ? now() : null,
            ];

            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            $this->editingUser->update($updateData);

            session()->flash('message', 'User berhasil diperbarui!');
        } else {
            // Create validation rules
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'role' => 'required|string|in:admin,guru_bk,wali_kelas,kepala_sekolah,guru_mapel,tenaga_pendidik',
                'password' => 'required|string|min:6',
                'passwordConfirmation' => 'required|same:password',
            ]);

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => $this->role,
                'email_verified_at' => $this->emailVerified ? now() : null,
            ]);

            session()->flash('message', 'User berhasil dibuat!');
        }

        $this->resetForm();
        $this->showForm = false;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        // Don't allow deleting current user
        if ($user->id === Auth::id()) {
            session()->flash('error', 'Tidak dapat menghapus akun sendiri!');
            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus!');
    }

    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
    }

    private function resetForm()
    {
        $this->editingUser = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->passwordConfirmation = '';
        $this->role = '';
        $this->emailVerified = false;
        $this->resetErrorBag();
    }
}
