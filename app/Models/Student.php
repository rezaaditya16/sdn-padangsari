<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'classroom_id',
        'photo',
        'nisn',
        'birth_date',
        'parent_email'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'student_id');
    }

    /**
     * Validasi login orang tua dengan NISN dan tanggal lahir
     */
    public static function validateParentLogin($nisn, $birthDate)
    {
        return self::where('nisn', $nisn)
                  ->whereDate('birth_date', $birthDate)
                  ->first();
    }

    /**
     * Accessor untuk URL foto siswa
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }

    /**
     * Scope untuk siswa aktif (semua siswa dianggap aktif karena tidak ada field status)
     */
    public function scopeActive($query)
    {
        return $query; // Semua siswa dianggap aktif
    }
}