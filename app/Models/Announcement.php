<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'title',
        'content',
        'image',
        'publish_date',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    /**
     * Scope untuk pengumuman yang dipublikasi (semua pengumuman dianggap published)
     */
    public function scopePublished($query)
    {
        return $query; // Semua pengumuman dianggap published
    }

    /**
     * Accessor untuk URL gambar
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }
}