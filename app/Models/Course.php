<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'description',
        'image',
        'video_url',
        'user_id',
        'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_DRAFT, // Valor por defecto
    ];

    /**
     * El profesor que creó este curso.
     */
    public function teacher() // O user(), como la hayas llamado
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Los módulos que pertenecen a este curso.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get the comments for the course.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); // ->latest() is optional, to order by newest
    }

    /**
     * Obtiene los certificados emitidos para este curso.
     * ESTA RELACIÓN ES CRUCIAL Y DEBE ESTAR ASÍ:
     */
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
