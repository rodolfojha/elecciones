<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'order',
    ];

    /**
     * Get the course that owns the material
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the type label
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'video' => 'Video',
            'pdf' => 'PDF',
            'image' => 'Imagen',
            'document' => 'Documento',
            default => 'Archivo',
        };
    }

    /**
     * Get the type icon
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'video' => 'fa-solid fa-video',
            'pdf' => 'fa-solid fa-file-pdf',
            'image' => 'fa-solid fa-image',
            'document' => 'fa-solid fa-file',
            default => 'fa-solid fa-file',
        };
    }

    /**
     * Get the type color
     */
    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'video' => 'blue',
            'pdf' => 'red',
            'image' => 'green',
            'document' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Format file size for display
     */
    public function getFormattedSizeAttribute()
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $bytes = floatval($this->file_size);
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
