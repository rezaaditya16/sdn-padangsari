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
}