<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ComplaintResponse;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'role', // Tambahkan 'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi untuk guru yang menjadi wali kelas
    public function classroomAsWaliKelas()
    {
        return $this->hasOne(Classroom::class, 'wali_kelas_id');
    }

    // Relasi untuk pengaduan yang ditugaskan kepada user ini
    public function assignedPengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'assigned_to');
    }

    // Relasi untuk respons pengaduan yang dibuat oleh user ini
    public function complaintResponses()
    {
        return $this->hasMany(ComplaintResponse::class, 'user_id');
    }

    /**
     * Scope a query to only include users of a given role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Role checking methods
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKepalaSekolah()
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isGuruBK()
    {
        return $this->role === 'guru_bk';
    }

    public function isWaliKelas()
    {
        return $this->role === 'wali_kelas';
    }

    public function isGuruMapel()
    {
        return $this->role === 'guru_mapel';
    }

    public function isTenagaPendidik()
    {
        return $this->role === 'tenaga_pendidik';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
