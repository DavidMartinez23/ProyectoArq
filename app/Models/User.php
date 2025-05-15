<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Asegúrate que sea Authenticatable
use Illuminate\Notifications\Notifiable;
// CORRECTO: La siguiente línea está comentada o eliminada
// use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable 
{
    // CORRECTO: HasApiTokens no está aquí
    use HasFactory, Notifiable; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Los cursos creados por este usuario (si es profesor).
     */
    public function teacherCourses() // O simplemente courses() si así la llamas
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    // Puedes añadir otras relaciones aquí si las necesitas
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function studentProgress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    public function completedModules()
    {
        return $this->belongsToMany(Module::class, 'module_user')->withTimestamps()->withPivot('completed_at');
    }
}
