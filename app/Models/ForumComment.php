<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'user_type',
        'parent_id', // Para respuestas
        'likes_count', // Para conteo de likes
        'is_pinned' // Para comentarios fijados
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumComment::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ForumComment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function canDelete($user)
    {
        return $user->id === $this->user_id || $user->role === 'teacher';
    }

    public function isTeacherComment()
    {
        return $this->user_type === 'teacher';
    }
}