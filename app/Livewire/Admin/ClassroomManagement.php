<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class ClassroomManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $classroomId = null;
    public $selectedClassroom = null;

    public $form = [
        'name' => '',
    ];

    protected $rules = [
        'form.name' => 'required|string|max:255|unique:classrooms,name',
    ];

    protected $messages = [
        'form.name.required' => 'Nama kelas harus diisi.',
        'form.name.unique' => 'Nama kelas sudah digunakan.',
        'form.name.max' => 'Nama kelas maksimal 255 karakter.',
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

    public function editClassroom($id)
    {
        $classroom = Classroom::findOrFail($id);
        $this->classroomId = $id;
        $this->form = [
            'name' => $classroom->name,
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewClassroom($id)
    {
        $this->selectedClassroom = Classroom::with(['students', 'teachers'])->findOrFail($id);
        $this->showViewModal = true;
    }

    public function storeClassroom()
    {
        // Update validation rules for edit mode
        if ($this->editMode) {
            $rules = $this->rules;
            $rules['form.name'] = 'required|string|max:255|unique:classrooms,name,' . $this->classroomId;
            $this->validate($rules);
        } else {
            $this->validate();
        }

        $data = [
            'name' => $this->form['name'],
        ];

        if ($this->editMode) {
            $classroom = Classroom::findOrFail($this->classroomId);
            $classroom->update($data);
            session()->flash('message', 'Data kelas berhasil diperbarui!');
        } else {
            Classroom::create($data);
            session()->flash('message', 'Data kelas berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->classroomId = $id;
        $this->selectedClassroom = Classroom::with(['students', 'teachers'])->findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteClassroom()
    {
        $classroom = Classroom::findOrFail($this->classroomId);
        
        // Set null classroom_id untuk students dan teachers terkait
        $classroom->students()->update(['classroom_id' => null]);
        $classroom->teachers()->update(['classroom_id' => null]);
        
        $classroom->delete();
        
        session()->flash('message', 'Data kelas berhasil dihapus!');
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
        ];
        $this->classroomId = null;
        $this->editMode = false;
        $this->selectedClassroom = null;
        $this->resetErrorBag();
    }

    public function getTotalClassroomsProperty()
    {
        return Classroom::count();
    }

    public function getClassroomsProperty()
    {
        return Classroom::query()
            ->withCount(['students', 'teachers'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function render()
    {
        $classrooms = $this->classrooms;

        return view('livewire.admin.classroom-management', compact('classrooms'));
    }
}
