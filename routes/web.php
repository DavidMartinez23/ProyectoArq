<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas básicas
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');  // Añade el nombre 'home' aquí
Route::get('/dashboard', function () {
    $courses = \App\Models\Course::latest()->take(6)->get();
    return view('dashboard', compact('courses'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/welcome', function () { return view('welcome'); })->name('welcome')->middleware('auth');

// Rutas de autenticación
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/marcar-asistencia', [AttendanceController::class, 'store'])->name('attendance.store');
});

// Rutas para profesores (con middleware completo)
Route::middleware(['auth', \App\Http\Middleware\TeacherMiddleware::class])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    
    // Rutas para cursos de profesores
    Route::get('/teacher/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
    Route::post('/teacher/courses', [CourseController::class, 'store'])->name('teacher.courses.store');
    Route::get('/teacher/courses/{course}/edit', [CourseController::class, 'edit'])->name('teacher.courses.edit');
    Route::put('/teacher/courses/{course}', [CourseController::class, 'update'])->name('teacher.courses.update');
    Route::delete('/teacher/courses/{course}', [CourseController::class, 'destroy'])->name('teacher.courses.destroy');
    
    // Rutas para módulos de profesores
    Route::get('/teacher/courses/{course}/modules/create', [ModuleController::class, 'create'])->name('teacher.modules.create');
    Route::post('/teacher/courses/{course}/modules', [ModuleController::class, 'store'])->name('teacher.modules.store');
    Route::get('/teacher/courses/{course}/modules/{module}/edit', [ModuleController::class, 'edit'])->name('teacher.modules.edit');
    Route::put('/teacher/courses/{course}/modules/{module}', [ModuleController::class, 'update'])->name('teacher.modules.update');
    Route::delete('/teacher/courses/{course}/modules/{module}', [ModuleController::class, 'destroy'])->name('teacher.modules.destroy');
    
    // Eliminar esta línea para evitar duplicación
    // Route::resource('courses', CourseController::class);
});

// Rutas para cursos (acceso público)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Rutas para estudiantes autenticados
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Rutas para módulos (acceso público)
Route::middleware('auth')->group(function () {
    Route::get('/courses/{course}/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/courses/{course}/modules/{module}/complete', [App\Http\Controllers\ModuleController::class, 'complete'])->name('modules.complete');
});

// Rutas para certificados
Route::get('/courses/{course}/certificates/generate', [App\Http\Controllers\CertificateController::class, 'generate'])->name('certificates.generate')->middleware('auth');
Route::post('/courses/{course}/certificates', [App\Http\Controllers\CertificateController::class, 'store'])->name('certificates.store')->middleware('auth');
Route::get('/certificates/{certificate}/success', [App\Http\Controllers\CertificateController::class, 'success'])->name('certificates.success')->middleware('auth');
Route::get('/certificates/{certificate}/download', [App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');

require __DIR__.'/auth.php';

