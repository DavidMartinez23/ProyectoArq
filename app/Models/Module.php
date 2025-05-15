<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'video_url',
        'order',
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
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
}
