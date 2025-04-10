<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $fillable = [
        'name',
        'user_id',
        'checked_in_at',
    ];
    protected $casts = [
        'checked_in_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeToday($query)
    {
        return $query->whereDate('checked_in_at', now()->format('Y-m-d'));
    }
    public function scopeLastWeek($query)
    {
        return $query->whereBetween('checked_in_at', [now()->subWeek(), now()]);
    }
    public function scopeLastMonth($query)
    {
        return $query->whereBetween('checked_in_at', [now()->subMonth(), now()]);
    }   

}
