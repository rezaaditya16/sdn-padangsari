<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class TeacherManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $teacherId = null;
    public $selectedTeacher = null;

    public $form = [
        'name' => '',
        'position' => '',
        'photo' => null
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255',
        'form.position' => 'required|string|max:255',
        'form.photo' => 'nullable|image|max:2048'
    ];

    protected $messages = [
        'form.name.required' => 'Nama guru harus diisi.',
        'form.position.required' => 'Posisi/jabatan harus diisi.',
        'form.photo.image' => 'File harus berupa gambar.',
        'form.photo.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function mount()
    {
        // Component mounting - authorization handled by middleware
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacherId = $id;
        $this->form = [
            'name' => $teacher->name,
            'position' => $teacher->position,
            'photo' => null // Reset untuk upload baru
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewTeacher($id)
    {
        $this->selectedTeacher = Teacher::findOrFail($id);
        $this->showViewModal = true;
    }

    public function storeTeacher()
    {
        $this->validate();

        $data = [
            'name' => $this->form['name'],
            'position' => $this->form['position'],
        ];
        
        if ($this->form['photo']) {
            $data['photo'] = $this->form['photo']->store('teachers', 'public');
        }

        if ($this->editMode) {
            $teacher = Teacher::findOrFail($this->teacherId);
            
            // Hapus foto lama jika ada foto baru
            if ($this->form['photo'] && $teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            
            // Jika tidak ada foto baru, pertahankan foto lama
            if (!$this->form['photo'] && $teacher->photo) {
                $data['photo'] = $teacher->photo;
            }
            
            $teacher->update($data);
            session()->flash('message', 'Data guru berhasil diperbarui!');
        } else {
            Teacher::create($data);
            session()->flash('message', 'Data guru berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->teacherId = $id;
        $this->selectedTeacher = Teacher::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteTeacher()
    {
        $teacher = Teacher::findOrFail($this->teacherId);
        
        // Hapus foto jika ada
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        
        $teacher->delete();
        
        session()->flash('message', 'Data guru berhasil dihapus!');
        $this->showDeleteModal = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showViewModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'position' => '',
            'photo' => null
        ];
        $this->teacherId = null;
        $this->editMode = false;
        $this->selectedTeacher = null;
        $this->resetErrorBag();
    }

    public function getTotalTeachersProperty()
    {
        return Teacher::count();
    }

    public function getTeachersProperty()
    {
        return Teacher::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $teachers = $this->teachers;

        return view('livewire.admin.teacher-management-new', compact('teachers'));
    }
}
