<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
        'duration_minutes',
        'created_by',
    ];

    /**
     * Get the user who created the course
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all materials for the course
     */
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class)->orderBy('order');
    }

    /**
     * Get videos for the course
     */
    public function videos()
    {
        return $this->materials()->where('type', 'video');
    }

    /**
     * Get PDFs for the course
     */
    public function pdfs()
    {
        return $this->materials()->where('type', 'pdf');
    }

    /**
     * Get images for the course
     */
    public function images()
    {
        return $this->materials()->where('type', 'image');
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Borrador',
            'published' => 'Publicado',
            'archived' => 'Archivado',
            default => 'Desconocido',
        };
    }

    /**
     * Get the status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'published' => 'green',
            'archived' => 'red',
            default => 'gray',
        };
    }
}
