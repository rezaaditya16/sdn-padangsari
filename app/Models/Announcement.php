<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Announcement extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = ['title', 'content', 'image', 'publish_date'];

    // Mutator untuk menyimpan gambar ke disk public
    public function setImageAttribute($value)
    {
        if ($value && is_file($value)) {
            $path = $value->store('announcements', 'public');
            Log::info('Image stored at: ' . $path); // Debugging
            $this->attributes['image'] = $path;
        } else {
            Log::warning('Invalid image file: ' . json_encode($value)); // Debugging jika file tidak valid
        }
    }

    // Accessor untuk mendapatkan URL gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}