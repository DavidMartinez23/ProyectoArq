<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory;
    
    protected $table = 'student_progress';
    
    protected $fillable = [
        'user_id',
        'course_id',
        'last_module_id',
        'progress_percentage',
        'completed',
        'completed_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function lastModule()
    {
        return $this->belongsTo(Module::class, 'last_module_id');
    }
}