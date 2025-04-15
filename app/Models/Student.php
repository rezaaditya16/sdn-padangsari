<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'class',
        'classroom_id',
        'photo',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    protected static function booted()
    {
        static::saving(function ($student) {
            if ($student->classroom) {
                $student->class = $student->classroom->name;
            }
        });
    }
}