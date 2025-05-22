<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('teacher')->latest()->get();
        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['teacher', 'modules', 'comments.user']);

        $progress = 0;
        $nextModule = null;

        if (Auth::check()) {
            $user = Auth::user();
            
            $totalModules = $course->modules->count();
            
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
        $course->user_id = Auth::id();

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
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.dashboard')
                ->with('error', 'No tienes permiso para eliminar este curso.');
        }

        $course->delete();

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Curso eliminado correctamente.');
    }
}