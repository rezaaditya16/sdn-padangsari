<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Category;
use App\Models\User;
use App\Models\ComplaintResponse;
use App\Mail\PengaduanCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'category_id',
        'assigned_to',
        'title',
        'message',
        'status',
        'responded_at',
        'completed_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Auto-assign pengaduan berdasarkan kategori
     */
    protected static function booted()
    {
        static::creating(function ($pengaduan) {
            // Auto-assign berdasarkan kategori
            if ($pengaduan->category_id) {
                $category = Category::find($pengaduan->category_id);
                if ($category && $category->target_role) {
                    $assignedUser = User::where('role', $category->target_role)->first();
                    if ($assignedUser) {
                        $pengaduan->assigned_to = $assignedUser->id;
                    }
                }
            }
        });

        static::updating(function ($pengaduan) {
            // Update timestamp berdasarkan perubahan status
            if ($pengaduan->isDirty('status')) {
                if ($pengaduan->status === 'Diproses' && !$pengaduan->responded_at) {
                    $pengaduan->responded_at = now();
                } elseif ($pengaduan->status === 'Selesai' && !$pengaduan->completed_at) {
                    $pengaduan->completed_at = now();
                }
            }
        });

        static::updated(function ($pengaduan) {
            // Send email notification when complaint is completed
            if ($pengaduan->wasChanged('status') && $pengaduan->status === 'Selesai') {
                $pengaduan->sendCompletionEmail();
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke User yang ditugaskan untuk menangani pengaduan
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi ke ComplaintResponse
     */
    public function complaintResponses()
    {
        return $this->hasMany(ComplaintResponse::class, 'pengaduan_id');
    }

    /**
     * Send completion email notification
     */
    public function sendCompletionEmail()
    {
        try {
            // Get parent email from student
            $parentEmail = $this->student->parent_email ?? null;
            
            if (!$parentEmail) {
                Log::warning("No parent email found for pengaduan ID: {$this->id}");
                return false;
            }

            // Validate email format
            if (!filter_var($parentEmail, FILTER_VALIDATE_EMAIL)) {
                Log::warning("Invalid parent email format for pengaduan ID: {$this->id}. Email: {$parentEmail}");
                return false;
            }

            // Collect all attachments from responses
            $attachments = [];
            $responses = $this->complaintResponses()->get();
            
            foreach ($responses as $response) {
                if ($response->attachments && is_array($response->attachments)) {
                    foreach ($response->attachment_paths as $path) {
                        if (file_exists($path)) {
                            $attachments[] = $path;
                        }
                    }
                }
            }

            // Send email
            Mail::to($parentEmail)->send(new PengaduanCompletedMail($this, $attachments));
            
            Log::info("Completion email sent for pengaduan ID: {$this->id} to: {$parentEmail}");
            return true;
            
        } catch (\Exception $e) {
            // Handle specific SMTP errors
            if (str_contains($e->getMessage(), '550 5.1.1')) {
                Log::error("Invalid email address for pengaduan ID: {$this->id}. Email: {$parentEmail}. Error: " . $e->getMessage());
            } else {
                Log::error("Failed to send completion email for pengaduan ID: {$this->id}. Error: " . $e->getMessage());
            }
            return false;
        }
    }

    /**
     * Check if user can handle this complaint
     */
    public function canBeHandledBy($userId)
    {
        $user = User::find($userId);
        if (!$user) return false;

        // Admin dapat menangani semua pengaduan
        if ($user->role === 'admin') return true;

        // User lain hanya bisa menangani pengaduan yang di-assign ke mereka
        // atau sesuai dengan role mereka berdasarkan kategori
        return $this->assigned_to == $userId || 
               ($this->category && $this->category->target_role === $user->role);
    }
}