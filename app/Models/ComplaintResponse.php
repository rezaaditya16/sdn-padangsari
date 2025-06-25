<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ComplaintResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'message',
        'attachments',
        'action_type',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get attachments with full URL
     */
    public function getAttachmentUrlsAttribute()
    {
        if (!$this->attachments) {
            return [];
        }

        // Ensure attachments is an array
        $attachments = is_array($this->attachments) ? $this->attachments : [];

        return array_map(function($attachment) {
            return Storage::url($attachment);
        }, $attachments);
    }

    /**
     * Get attachments with full path for email
     */
    public function getAttachmentPathsAttribute()
    {
        if (!$this->attachments) {
            return [];
        }

        // Ensure attachments is an array
        $attachments = is_array($this->attachments) ? $this->attachments : [];

        return array_map(function($attachment) {
            return storage_path('app/public/' . $attachment);
        }, $attachments);
    }
}