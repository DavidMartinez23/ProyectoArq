<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de que Auth esté importado
// use App\Models\Course; // El modelo Course ya debería estar disponible o importado si es necesario

class TeacherDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function __invoke(Request $request) // O podría ser public function index(Request $request)
    {
        $teacher = Auth::user();
        $courses = collect(); // Inicializar como una colección vacía

        // Intentamos cargar los cursos del profesor con sus certificados.
        // 'teacherCourses' o 'courses' debe ser una relación definida en tu modelo User
        // que devuelve los cursos creados por ese usuario (profesor).
        if (method_exists($teacher, 'teacherCourses')) {
            // Carga los cursos del profesor y, para cada curso, sus certificados.
            $courses = $teacher->teacherCourses()->with('certificates')->get();
        } elseif (method_exists($teacher, 'courses')) {
            // Fallback si la relación se llama 'courses'
            $courses = $teacher->courses()->with('certificates')->get();
        }
        // Si ninguna relación existe, $courses permanecerá como una colección vacía,
        // lo cual la vista debería manejar mostrando un mensaje apropiado.

        return view('teacher.dashboard', compact('courses'));
    }
}
