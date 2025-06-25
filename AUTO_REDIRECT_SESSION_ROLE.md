# AUTO REDIRECT BERDASARKAN SESSION & ROLE

## Fitur
Sistem akan secara otomatis mengarahkan user berdasarkan status autentikasi dan role mereka:

### 1. User Belum Login
- Mengakses `/admin/login` → Menampilkan halaman login normal
- Bisa melakukan login seperti biasa

### 2. User Sudah Login (Session/Token Aktif)
- Mengakses `/admin/login` → Auto redirect berdasarkan role:
  - **Admin/Super Admin** → `/admin` (Dashboard)
  - **Role Lain** (kepala_sekolah, guru_bk, wali_kelas, guru_mapel, tenaga_pendidik) → `/admin/pengaduan`

## Implementasi

### 1. Route Level (/routes/admin-livewire.php)
```php
Route::get('/login', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Redirect berdasarkan role jika sudah login
        if (in_array($user->role, ['admin', 'super_admin'])) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.pengaduan.index');
        }
    }
    return view('admin.auth.login');
})->name('admin.login');
```

### 2. Livewire Component Level (/app/Livewire/Admin/Login.php)
```php
public function mount()
{
    // Redirect jika sudah login
    if (Auth::check()) {
        return $this->redirectBasedOnRole();
    }
}

private function redirectBasedOnRole()
{
    $user = Auth::user();
    
    // Admin dan Super Admin ke dashboard
    if (in_array($user->role, ['admin', 'super_admin'])) {
        return redirect()->route('admin.dashboard');
    }
    // Role lain ke pengaduan
    elseif (in_array($user->role, ['kepala_sekolah', 'guru_bk', 'wali_kelas', 'guru_mapel', 'tenaga_pendidik'])) {
        return redirect()->route('admin.pengaduan.index');
    }
    
    // Role tidak valid, logout
    Auth::logout();
    session()->flash('error', 'Role tidak valid untuk mengakses admin panel.');
    return redirect()->route('admin.login');
}
```

## Testing

### Test 1: User Belum Login
```bash
curl -i "http://127.0.0.1:8001/admin/login"
# Result: 200 OK - Halaman login ditampilkan
```

### Test 2: Admin Sudah Login
```bash
# Login sebagai admin
curl -c cookies.txt -L "http://127.0.0.1:8001/test-login/super-admin"
# Akses login page
curl -b cookies.txt -i "http://127.0.0.1:8001/admin/login"
# Result: 302 Redirect ke /admin (dashboard)
```

### Test 3: Role Lain Sudah Login
```bash
# Login sebagai guru BK
curl -c cookies.txt -L "http://127.0.0.1:8001/test-login/guru-bk"
# Akses login page
curl -b cookies.txt -i "http://127.0.0.1:8001/admin/login"
# Result: 302 Redirect ke /admin/pengaduan
```

## User Experience

### Skenario 1: User Fresh Login
1. User buka `/admin/login`
2. Masukkan credentials
3. Klik login
4. Auto redirect sesuai role

### Skenario 2: User Session Masih Aktif
1. User buka `/admin/login` (misalnya dari bookmark)
2. Sistem deteksi session aktif
3. **Langsung redirect** tanpa perlu input apapun
4. User langsung masuk ke dashboard/pengaduan sesuai role

### Skenario 3: User Try Direct Access
1. Admin dengan session aktif coba akses `/admin/pengaduan`
2. Middleware `redirect.role` akan redirect ke `/admin` (dashboard)
3. Konsisten dengan logika role-based access

## Benefits
✅ **User Experience**: Tidak perlu login ulang jika session masih aktif  
✅ **Security**: Role validation tetap dijaga  
✅ **Konsisten**: Redirect logic sama di route dan component level  
✅ **Performance**: Mengurangi unnecessary page loads  
✅ **Intuitive**: User langsung diarahkan ke area yang sesuai dengan role mereka  

## Role-Based Redirect Summary
| Role | Destination | Access Level |
|------|-------------|--------------|
| admin | /admin (Dashboard) | Full access |
| super_admin | /admin (Dashboard) | Full access |
| kepala_sekolah | /admin/pengaduan | Pengaduan only |
| guru_bk | /admin/pengaduan | Pengaduan only |
| wali_kelas | /admin/pengaduan | Pengaduan only |
| guru_mapel | /admin/pengaduan | Pengaduan only |
| tenaga_pendidik | /admin/pengaduan | Pengaduan only |
| invalid role | /admin/login (logout) | No access |

---
**Status**: ✅ **IMPLEMENTED & TESTED**  
**Date**: 25 June 2025
