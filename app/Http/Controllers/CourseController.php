<?php

namespace App\Http\Controllers;

use App\Models\Course; // Make sure Course model is imported
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Añadir esta línea para importar la fachada Auth

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        // Eager load relationships to prevent N+1 issues and ensure they are available
        $course->load(['teacher', 'modules', 'comments.user']); // 'comments.user' to also load the user for each comment

        // Verificar si el usuario está autenticado
        $progress = 0;
        $nextModule = null;

        if (Auth::check()) {
            $user = Auth::user();
            
            // Calcular el progreso del usuario en este curso
            $totalModules = $course->modules->count();
            
            // Temporalmente, establecer progreso en 0 y nextModule como el primer módulo
            $nextModule = $course->modules()->orderBy('order')->first();
        }
        
        return view('courses.show', compact('course', 'progress', 'nextModule'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $course = new Course();
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $course->image = $path;
        }

        $course->save();

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Curso creado correctamente. Ahora puedes agregar módulos.');
    }

    public function edit(Course $course)
    {
        // Verificar que el curso pertenece al profesor autenticado
        if ($course->user_id !== auth()->id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para editar este curso.');
        }

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        // Verificar que el curso pertenece al profesor autenticado
        if ($course->user_id !== auth()->id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para editar este curso.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $course->title = $validated['title'];
        $course->description = $validated['description'];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $course->image = $path;
        }

        $course->save();

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        // Verificar que el curso pertenece al profesor autenticado
        if ($course->user_id !== auth()->id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para eliminar este curso.');
        }

        $course->delete();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Curso eliminado correctamente.');
    }
}
