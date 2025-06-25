<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ParentLoginPage extends Component
{
    public $nisn = '';
    public $birth_date = '';
    public $errorMessage = '';

    protected $rules = [
        'nisn' => 'required|string',
        'birth_date' => 'required|date',
    ];

    public function login()
    {
        $this->validate();

        $student = Student::validateParentLogin($this->nisn, $this->birth_date);

        if ($student) {
            // Set session untuk autentikasi
            Session::put('authenticated_student_id', $student->id);
            Session::put('authenticated_student_name', $student->name);
            Session::put('authenticated_student_class', $student->class);

            // Redirect ke halaman pengaduan
            return redirect()->route('pengaduan.form');
        } else {
            $this->errorMessage = 'NISN atau tanggal lahir tidak cocok. Silakan periksa kembali data Anda.';
        }
    }

    public function logout()
    {
        Session::forget(['authenticated_student_id', 'authenticated_student_name', 'authenticated_student_class']);
        return redirect()->route('pengaduan');
    }

    public function render()
    {
        return view('livewire.parent-login-page');
    }
}
