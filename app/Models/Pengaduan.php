<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Category;
use App\Models\User;
use App\Models\ComplaintResponse;

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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function assignedToUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Backward compatibility alias
    public function assignedUser()
    {
        return $this->assignedToUser();
    }

    public function complaintResponses()
    {
        return $this->hasMany(ComplaintResponse::class, 'pengaduan_id');
    }

    // Backward compatibility alias
    public function responses()
    {
        return $this->complaintResponses();
    }

    /**
     * Check if a user can handle this pengaduan
     */
    public function canBeHandledBy($userId)
    {
        $user = User::find($userId);
        
        if (!$user) {
            return false;
        }

        // Super admin and admin can handle all pengaduans
        if ($user->isAdmin()) {
            return true;
        }

        // Kepala sekolah can handle all pengaduans
        if ($user->isKepalaSekolah()) {
            return true;
        }

        // If pengaduan is already assigned to this user
        if ($this->assigned_to == $userId) {
            return true;
        }

        // Check if user's role matches the category's target role
        if ($this->category && $this->category->target_role) {
            return $user->hasRole($this->category->target_role);
        }

        // If no specific target role, guru_bk can handle it
        if ($user->isGuruBK()) {
            return true;
        }

        return false;
    }

    /**
     * Auto-assign pengaduan based on category target role
     */
    public function autoAssign()
    {
        // Don't reassign if already assigned
        if ($this->assigned_to) {
            return;
        }

        // Get target role from category
        $targetRole = $this->category->target_role ?? 'guru_bk';

        // Find available user with the target role
        $user = User::where('role', $targetRole)->first();

        // If no user found with target role, assign to guru_bk as fallback
        if (!$user) {
            $user = User::where('role', 'guru_bk')->first();
        }

        // If still no user, assign to admin as last resort
        if (!$user) {
            $user = User::where('role', 'admin')->first();
        }

        // Assign the user
        if ($user) {
            $this->update(['assigned_to' => $user->id]);
        }
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-assign when pengaduan is created
        static::created(function ($pengaduan) {
            $pengaduan->autoAssign();
        });

        // Send email when status is changed to "Selesai"
        static::updated(function ($pengaduan) {
            if ($pengaduan->isDirty('status') && $pengaduan->status === 'Selesai') {
                $pengaduan->completed_at = now();
                $pengaduan->saveQuietly(); // Save without triggering events again
                
                // Send completion email
                try {
                    \Illuminate\Support\Facades\Mail::to($pengaduan->student->parent_email ?? 'noreply@sdnpadangsari.sch.id')
                        ->send(new \App\Mail\PengaduanCompletedMail($pengaduan));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send completion email: ' . $e->getMessage());
                }
            }
        });
    }
}