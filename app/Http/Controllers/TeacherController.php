<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashboard()
    {
        // Obtener el usuario autenticado usando Auth facade
        $user = Auth::user();
        
        // Verificar si el usuario existe y es profesor
        if (!$user || $user->role !== User::ROLE_TEACHER) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para acceder al panel de profesor.');
        }
        
        // Obtener los cursos del profesor usando la columna correcta user_id
        $courses = Course::where('user_id', $user->id)->latest()->get();
        
        // Inicializar $course como null si no hay cursos
        $course = $courses->isNotEmpty() ? $courses->first() : null;
        
        return view('teacher.dashboard', [
            'courses' => $courses,
            'course' => $course,
            'hasCourses' => $courses->isNotEmpty()
        ]);
    }
}