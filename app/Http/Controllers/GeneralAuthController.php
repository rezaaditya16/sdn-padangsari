<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GeneralAuthController extends Controller
{
    /**
     * Tampilkan halaman login general
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard yang sesuai
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    /**
     * Proses login untuk semua role
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole();
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Logout untuk semua role
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect berdasarkan role user
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
            case 'super_admin':
                return redirect()->route('admin.dashboard');
                
            case 'guru':
                return redirect()->route('attendance.index');
                
            case 'kepala_sekolah':
            case 'guru_bk':
            case 'wali_kelas':
            case 'guru_mapel':
            case 'tenaga_pendidik':
                return redirect()->route('admin.pengaduan.index');
                
            default:
                // Jika role tidak dikenali, logout dan redirect ke login
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Role tidak valid.']);
        }
    }
}
