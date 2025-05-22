<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'order',
        'course_id',
        'video_url'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function completions()
    {
        return $this->hasMany(ModuleUser::class);
    }
    
    public function getYoutubeEmbedAttribute()
    {
        if (!$this->youtube_url) return null;
        
        // Extraer el ID del video de YouTube de la URL
        $pattern = '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $this->youtube_url, $matches);
        
        if (!isset($matches[1])) return null;
        
        $videoId = $matches[1];
        return "https://www.youtube.com/embed/{$videoId}";
    }
    
    /**
     * Los usuarios que han completado este módulo
     */
    public function completedByUsers()
    {
        return $this->belongsToMany(User::class, 'module_user', 'module_id', 'user_id')
                    ->withTimestamps();
    }
}
