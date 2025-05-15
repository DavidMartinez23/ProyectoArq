<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Module;
use App\Models\ModuleUser; // Añadir esta línea
use App\Models\StudentProgress;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function create(Course $course)
    {
        // Calcular el siguiente orden para el módulo
        $nextOrder = $course->modules()->count() + 1;
        
        return view('modules.create', compact('course', 'nextOrder'));
    }
    
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:1',
            'duration' => 'nullable|string|max:50',
        ]);
        
        $module = new Module();
        $module->title = $validated['title'];
        $module->content = $validated['content'];
        $module->order = $validated['order'];
        $module->course_id = $course->id;
        
        // Añadir estos campos
        if (isset($validated['video_url'])) {
            $module->video_url = $validated['video_url'];
        }
        
        if (isset($validated['duration'])) {
            $module->duration = $validated['duration'];
        }
        
        $module->save();
    
        return redirect()->route('teacher.courses.edit', $course->id)
            ->with('success', 'Módulo creado correctamente.');
    }
    
    public function show(Course $course, Module $module)
    {
        // Verificar que el módulo pertenece al curso
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        
        // Actualizar el progreso del estudiante
        if (Auth::check()) {
            $progress = StudentProgress::firstOrCreate(
                ['user_id' => Auth::id(), 'course_id' => $course->id],
                ['last_module_id' => $module->id, 'progress_percentage' => 0]
            );
            
            // Actualizar el último módulo visto
            $progress->last_module_id = $module->id;
            $progress->save();
            
            // Determinar si el curso está completado
            $completed = $progress->completed;
        } else {
            $completed = false;
        }
        
        // Obtener el módulo anterior (si existe)
        $prevModule = Module::where('course_id', $course->id)
                            ->where('order', '<', $module->order)
                            ->orderBy('order', 'desc')
                            ->first();
        
        // Obtener el siguiente módulo (si existe)
        $nextModule = Module::where('course_id', $course->id)
                            ->where('order', '>', $module->order)
                            ->orderBy('order')
                            ->first();
        
        // Calcular el progreso del curso
        $completedCount = 0;
        $progress = 0;
        $allCompleted = false;
        $completedModules = [];
        
        if (Auth::check()) {
            $completedModules = ModuleUser::where('user_id', Auth::id())
                                         ->where('course_id', $course->id)
                                         ->pluck('module_id')
                                         ->toArray();
            
            $completedCount = count($completedModules);
            $totalModules = $course->modules->count();
            
            if ($totalModules > 0) {
                $progress = round(($completedCount / $totalModules) * 100);
            }
            
            $allCompleted = ($completedCount == $totalModules);
        }
        
        return view('modules.show', compact(
            'course', 
            'module', 
            'prevModule', 
            'nextModule', 
            'completed',
            'completedModules',
            'completedCount',
            'progress',
            'allCompleted'
        ));
    }
    
    public function edit(Course $course, Module $module)
    {
        // Verificar que el módulo pertenece al curso
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        
        return view('modules.edit', compact('course', 'module'));
    }
    
    public function update(Request $request, Course $course, Module $module)
    {
        // Verificar que el módulo pertenece al curso
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'order' => 'required|integer|min:1',
        ]);
        
        $module->update($validated);
        
        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Módulo actualizado correctamente.');
    }
    
    public function destroy(Course $course, Module $module)
    {
        // Verificar que el módulo pertenece al curso
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        
        $module->delete();
        
        return redirect()->route('teacher.courses.edit', $course)
            ->with('success', 'Módulo eliminado correctamente.');
    }
    
    public function complete(Course $course, Module $module)
    {
        // Verificar que el módulo pertenece al curso
        if ($module->course_id !== $course->id) {
            abort(404);
        }
        
        // Registrar que el usuario ha completado este módulo
        if (Auth::check()) {
            // Crear o actualizar el registro en la tabla module_user
            $moduleUser = ModuleUser::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'module_id' => $module->id,
                    'course_id' => $course->id
                ],
                [
                    'completed_at' => now()
                ]
            );
            
            // Actualizar el progreso del estudiante
            $totalModules = $course->modules->count();
            $completedModules = ModuleUser::where('user_id', Auth::id())
                                         ->where('course_id', $course->id)
                                         ->count();
            
            $progress = ($totalModules > 0) ? round(($completedModules / $totalModules) * 100) : 0;
            
            $studentProgress = StudentProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $course->id
                ],
                [
                    'last_module_id' => $module->id,
                    'progress_percentage' => $progress,
                    'completed' => ($completedModules == $totalModules),
                    'completed_at' => ($completedModules == $totalModules) ? now() : null
                ]
            );
        }
        
        // Redirigir de vuelta al módulo con un mensaje de éxito
        return redirect()->route('modules.show', ['course' => $course->id, 'module' => $module->id])
                         ->with('success', '¡Módulo completado con éxito!');
    }
}
