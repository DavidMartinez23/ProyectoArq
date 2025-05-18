<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
    use HasFactory, Notifiable;

    /**
     * Constantes para los roles disponibles en el sistema
     */
    const ROLE_STUDENT = 'student';
    const ROLE_TEACHER = 'teacher';

    /**
     * Los atributos que son asignables masivamente.
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
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => 'string',
    ];

    /**
     * Obtiene los roles disponibles para el selector de registro
     *
     * @return array<string, string>
     */
    public static function getAvailableRoles()
    {
        return [
            self::ROLE_STUDENT => 'Estudiante',
            self::ROLE_TEACHER => 'Profesor',
        ];
    }

    /**
     * Verifica si el usuario tiene rol de profesor
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->role === self::ROLE_TEACHER;
    }

    /**
     * Verifica si el usuario tiene rol de estudiante
     *
     * @return bool
     */
    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }

    /**
     * Relación: Obtiene los cursos creados por este profesor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teacherCourses()
    {
        return $this->hasMany(Course::class, 'user_id');
    }

    /**
     * Relación: Obtiene los cursos en los que el estudiante está inscrito
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
            ->withTimestamps()
            ->withPivot('enrolled_at');
    }

    /**
     * Relación: Obtiene los comentarios realizados por el usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relación: Obtiene el progreso del estudiante en los cursos
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentProgress()
    {
        return $this->hasMany(StudentProgress::class);
    }

    /**
     * Relación: Obtiene los módulos completados por el usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function completedModules()
    {
        return $this->belongsToMany(Module::class, 'module_user')
            ->withTimestamps()
            ->withPivot('completed_at');
    }
}