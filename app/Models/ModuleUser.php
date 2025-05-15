<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ModuleUser extends Pivot
{
    protected $table = 'module_user';
    
    protected $fillable = [
        'user_id',
        'module_id',
        'course_id',
        'completed_at'
    ];
    
    // Si necesitas timestamps (created_at, updated_at)
    public $timestamps = true;
    
    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}