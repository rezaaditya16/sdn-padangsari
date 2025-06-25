<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Accessor untuk memastikan images selalu array (fallback)
     */
    public function getImagesAttribute($value)
    {
        // Jika sudah di-cast ke array, return langsung
        if (is_array($value)) {
            return $value;
        }
        
        // Jika masih string, decode manual
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        
        // Fallback ke array kosong
        return [];
    }

    /**
     * Accessor untuk URL array images
     */
    public function getImagesUrlAttribute()
    {
        if (!$this->images) return [];
        
        return collect($this->images)->map(function ($image) {
            return Storage::url($image);
        })->toArray();
    }

    /**
     * Scope untuk galeri yang dipublikasi (semua galeri dianggap published)
     */
    public function scopePublished($query)
    {
        return $query; // Semua galeri dianggap published
    }
}