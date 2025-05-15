<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'course_id',
        'full_name',
        'email',
        'issued_at'
    ];
    
    protected $casts = [
        'issued_at' => 'datetime'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}