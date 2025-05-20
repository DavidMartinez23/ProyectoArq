<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'teacher') {
                return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta sección');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $courses = Auth::user()->courses;
        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course = new Course();
        $course->title = $request->title;
        $course->description = $request->description;
        $course->user_id = auth()->id();
        $course->status = 'published'; // Siempre publicado

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $course->image = $path;
        }

        $course->save();

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Curso creado correctamente.');
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'No tienes permisos para editar este curso');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $course->image = $path;
        }
        
        $course->save();

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Curso actualizado correctamente');
    }

    public function show(Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.courses.index')->with('error', 'No tienes permisos para ver este curso');
        }
        
        return view('teacher.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.courses.index')->with('error', 'No tienes permisos para editar este curso');
        }
        
        return view('teacher.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.courses.index')
                ->with('error', 'No tienes permisos para editar este curso');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses', 'public');
            $course->image = $path;
        }
        
        $course->save();

        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Curso actualizado correctamente');
    }

    public function destroy(Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            return redirect()->route('teacher.courses.index')->with('error', 'No tienes permisos para eliminar este curso');
        }
        
        $course->delete();

        return redirect()->route('teacher.courses.index')->with('success', 'Curso eliminado correctamente');
    }
}
