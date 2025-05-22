<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with('teacher');

        // Implementación de búsqueda
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhereHas('teacher', function($q) use ($searchTerm) {
                      $q->where('name', 'LIKE', "%{$searchTerm}%");
                  });
            });
        }

        // Filtrado por categoría si existe
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $courses = $query->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['teacher', 'modules', 'comments.user']);

        $progress = 0;
        $nextModule = null;

        if (Auth::check()) {
            $user = Auth::user();
            
            // Calcular progreso real del usuario
            $totalModules = $course->modules->count();
            if ($totalModules > 0) {
                $completedModules = $course->modules()
                    ->whereHas('completions', function($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })->count();
                $progress = ($completedModules / $totalModules) * 100;
            }
            
            // Obtener el siguiente módulo no completado
            $nextModule = $course->modules()
                ->whereDoesntHave('completions', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('order')
                ->first();
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
            'category' => 'nullable|string|max:50',
            'difficulty_level' => 'nullable|string|in:principiante,intermedio,avanzado'
        ]);

        $course = new Course();
        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->user_id = Auth::id();
        $course->category = $validated['category'] ?? null;
        $course->difficulty_level = $validated['difficulty_level'] ?? 'principiante';

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
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para editar este curso.');
        }

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para editar este curso.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:50',
            'difficulty_level' => 'nullable|string|in:principiante,intermedio,avanzado'
        ]);

        $course->title = $validated['title'];
        $course->description = $validated['description'];
        $course->category = $validated['category'] ?? $course->category;
        $course->difficulty_level = $validated['difficulty_level'] ?? $course->difficulty_level;

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
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para eliminar este curso.');
        }

        $course->delete();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Curso eliminado correctamente.');
    }

    // Método para buscar cursos (API)
    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $courses = Course::with('teacher')
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orWhereHas('teacher', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->take(5)
            ->get();

        return response()->json($courses);
    }
}