<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    protected $messages = [
        'email.required' => 'Email harus diisi.',
        'email.email' => 'Format email tidak valid.',
        'password.required' => 'Password harus diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ];

    public function mount()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
    }

    public function login()
    {
        $this->validate();

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            Session::regenerate();
            
            session()->flash('success', 'Login berhasil! Selamat datang, ' . Auth::user()->name);
            
            return $this->redirectBasedOnRole();
        } else {
            $this->addError('email', 'Email atau password salah.');
        }
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();
        
        // Admin dan Super Admin ke dashboard
        if (in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.dashboard');
        }
        // Role lain ke pengaduan (sesuai dengan middleware redirect.role)
        elseif (in_array($user->role, ['kepala_sekolah', 'guru_bk', 'wali_kelas', 'guru_mapel', 'tenaga_pendidik'])) {
            return redirect()->route('admin.pengaduan.index');
        }
        
        // Role tidak valid, logout dan redirect ke login
        Auth::logout();
        session()->flash('error', 'Role tidak valid untuk mengakses admin panel.');
        return redirect()->route('admin.login');
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
