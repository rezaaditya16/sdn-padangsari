<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StudentManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $classroomFilter = '';
    public $showModal = false;
    public $showViewModal = false;
    public $showDeleteModal = false;
    public $editMode = false;
    public $studentId = null;
    public $selectedStudent = null;

    public $form = [
        'nisn' => '',
        'name' => '',
        'birth_date' => '',
        'class' => '',
        'parent_email' => '',
        'photo' => null
    ];

    protected $rules = [
        'form.nisn' => 'required|string|max:255|unique:students,nisn',
        'form.name' => 'required|string|max:255',
        'form.birth_date' => 'required|date',
        'form.class' => 'required|string|max:255',
        'form.parent_email' => 'nullable|email|max:255',
        'form.photo' => 'nullable|image|max:2048'
    ];

    protected $messages = [
        'form.nisn.required' => 'NISN harus diisi.',
        'form.nisn.unique' => 'NISN sudah digunakan.',
        'form.name.required' => 'Nama siswa harus diisi.',
        'form.birth_date.required' => 'Tanggal lahir harus diisi.',
        'form.birth_date.date' => 'Format tanggal tidak valid.',
        'form.class.required' => 'Kelas harus diisi.',
        'form.parent_email.email' => 'Format email tidak valid.',
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

    public function updatingClassroomFilter()
    {
        $this->resetPage();
    }

    public function exportStudents()
    {
        // TODO: Implement export functionality
        session()->flash('message', 'Fitur export akan segera tersedia!');
    }

    public function showCreateModal()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $this->studentId = $id;
        $this->form = [
            'nisn' => $student->nisn,
            'name' => $student->name,
            'birth_date' => $student->birth_date ? $student->birth_date->format('Y-m-d') : '',
            'class' => $student->class,
            'parent_email' => $student->parent_email,
            'photo' => null // Reset untuk upload baru
        ];
        $this->editMode = true;
        $this->showModal = true;
    }

    public function viewStudent($id)
    {
        $this->selectedStudent = Student::findOrFail($id);
        $this->showViewModal = true;
    }

    public function saveStudent()
    {
        // Update validation rules for edit mode
        if ($this->editMode) {
            $rules = $this->rules;
            $rules['form.nisn'] = 'required|string|max:255|unique:students,nisn,' . $this->studentId;
            $this->validate($rules);
        } else {
            $this->validate();
        }

        $data = [
            'nisn' => $this->form['nisn'],
            'name' => $this->form['name'],
            'birth_date' => $this->form['birth_date'],
            'class' => $this->form['class'],
            'parent_email' => $this->form['parent_email'],
        ];
        
        if ($this->form['photo']) {
            $data['photo'] = $this->form['photo']->store('students', 'public');
        }

        if ($this->editMode) {
            $student = Student::findOrFail($this->studentId);
            
            // Hapus foto lama jika ada foto baru
            if ($this->form['photo'] && $student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            
            // Jika tidak ada foto baru, pertahankan foto lama
            if (!$this->form['photo'] && $student->photo) {
                $data['photo'] = $student->photo;
            }
            
            $student->update($data);
            session()->flash('message', 'Data siswa berhasil diperbarui!');
        } else {
            Student::create($data);
            session()->flash('message', 'Data siswa berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function confirmDelete($id)
    {
        $this->studentId = $id;
        $this->selectedStudent = Student::findOrFail($id);
        $this->showDeleteModal = true;
    }

    public function deleteStudent()
    {
        $student = Student::findOrFail($this->studentId);
        
        // Hapus foto jika ada
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        
        $student->delete();
        
        session()->flash('message', 'Data siswa berhasil dihapus!');
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
            'nisn' => '',
            'name' => '',
            'birth_date' => '',
            'class' => '',
            'parent_email' => '',
            'photo' => null
        ];
        $this->studentId = null;
        $this->editMode = false;
        $this->selectedStudent = null;
        $this->resetErrorBag();
    }

    public function getTotalStudentsProperty()
    {
        return Student::count();
    }

    public function getActiveStudentsProperty()
    {
        // For now, all students are considered active since there's no status column
        return Student::count();
    }

    public function getTotalClassroomsProperty()
    {
        return Classroom::count();
    }

    public function getGraduatedStudentsProperty()
    {
        // For now, return 0 since there's no status column to track graduated students
        return 0;
    }

    public function getClassroomsProperty()
    {
        return Classroom::all();
    }

    public function getStudentsProperty()
    {
        return Student::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nisn', 'like', '%' . $this->search . '%')
                      ->orWhere('class', 'like', '%' . $this->search . '%');
            })
            ->when($this->classroomFilter, function ($query) {
                $query->where('classroom_id', $this->classroomFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $students = $this->students;

        return view('livewire.admin.student-management-new', compact('students'));
    }
}
