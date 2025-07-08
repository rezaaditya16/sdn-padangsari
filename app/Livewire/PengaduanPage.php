<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengaduan;
use App\Models\Category;
use App\Models\Student;
use Illuminate\Support\Facades\Session;

class PengaduanPage extends Component
{
    public $title = '';
    public $message = '';
    public $category_id = '';
    public $successMessage = '';
    public $errorMessage = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'message' => 'required|string|min:10',
        'category_id' => 'required|exists:categories,id',
    ];

    public function submit()
    {
        // Validasi form
        $this->validate();

        // Pastikan orang tua sudah login
        $studentId = Session::get('authenticated_student_id');
        if (!$studentId) {
            return redirect()->route('parent.login');
        }

        try {
            // Buat pengaduan baru
            Pengaduan::create([
                'student_id' => $studentId,
                'category_id' => $this->category_id,
                'title' => $this->title,
                'message' => $this->message,
                'status' => 'Diajukan',
            ]);

            // Reset form dan tampilkan pesan sukses
            $this->reset(['title', 'message', 'category_id']);
            $this->successMessage = 'Pengaduan berhasil dikirim. Tim kami akan segera menindaklanjuti.';
            
            // Refresh halaman untuk update history
            $this->dispatch('pengaduan-submitted');
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Terjadi kesalahan saat mengirim pengaduan. Silakan coba lagi.';
        }
    }

    public function logout()
    {
        // Clear session data
        Session::forget(['authenticated_student_id', 'authenticated_student_name', 'authenticated_student_class']);
        
        // Redirect to login page
        return redirect()->route('parent.login');
    }

    public function viewAllPengaduan()
    {
        return redirect()->route('pengaduan.index');
    }

    public function viewPengaduanDetail($pengaduanId)
    {
        return redirect()->route('pengaduan.detail', $pengaduanId);
    }

    public function render()
    {
        // Ambil semua kategori untuk dropdown
        $categories = Category::all();
        
        // Ambil data siswa yang sedang login
        $studentId = Session::get('authenticated_student_id');
        $student = $studentId ? Student::find($studentId) : null;
        
        // Ambil history pengaduan siswa jika sudah login
        $pengaduanHistory = [];
        if ($studentId) {
            $pengaduanHistory = Pengaduan::with(['category', 'assignedUser', 'complaintResponses'])
                ->where('student_id', $studentId)
                ->orderBy('created_at', 'desc')
                ->limit(5) // Tampilkan 5 pengaduan terakhir
                ->get();
        }

        return view('livewire.pengaduan-page', [
            'categories' => $categories,
            'student' => $student,
            'pengaduanHistory' => $pengaduanHistory
        ]);
    }
}