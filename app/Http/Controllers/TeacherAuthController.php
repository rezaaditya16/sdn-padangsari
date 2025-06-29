<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TeacherAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('teacher.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Cek apakah user adalah guru dan memiliki data teacher
            if ($user->role === 'guru' && $user->teacher) {
                $request->session()->regenerate();
                return redirect()->route('attendance.index')->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
            }
            
            // Jika bukan guru atau tidak memiliki data teacher, logout dan redirect kembali
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun ini bukan akun guru atau data guru tidak ditemukan.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('teacher.login')->with('message', 'Berhasil logout');
    }
}
