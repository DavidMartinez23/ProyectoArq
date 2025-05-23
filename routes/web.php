<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ForumController;

// Rutas básicas
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }
    $courses = \App\Models\Course::latest()->take(6)->get();
    return view('dashboard', compact('courses'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/welcome', function () { return view('welcome'); })->name('welcome')->middleware('auth');

// Rutas de autenticación
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Rutas para el foro (accesible para todos los usuarios autenticados)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
    Route::post('/forum', [ForumController::class, 'store'])->name('forum.store');
    Route::delete('/forum/{comment}', [ForumController::class, 'destroy'])->name('forum.destroy');
    Route::post('/forum/{comment}/like', [ForumController::class, 'like'])->name('forum.like');
    Route::post('/forum/{comment}/reply', [ForumController::class, 'reply'])->name('forum.reply');
    Route::post('/forum/{comment}/pin', [ForumController::class, 'pin'])->name('forum.pin');
});

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
    Route::post('/courses/{course}/modules/{module}/complete', [ModuleController::class, 'complete'])->name('modules.complete');
});

// Rutas para certificados
Route::middleware('auth')->group(function () {
    // Vista principal de certificados
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    
    // Generar certificado
    Route::get('/courses/{course}/certificates/generate', [CertificateController::class, 'generate'])
        ->name('certificates.generate');
    
    // Almacenar certificado
    Route::post('/courses/{course}/certificates', [CertificateController::class, 'store'])
        ->name('certificates.store');
    
    // Página de éxito
    Route::get('/certificates/{certificate}/success', [CertificateController::class, 'success'])
        ->name('certificates.success');
    
        // Descargar certificado
    Route::get('/certificates/{certificate}/download', [CertificateController::class, 'download'])
    ->name('certificates.download');
    
    Route::get('/progress', [ProgressController::class, 'index'])->name('progress.index');
});

require __DIR__.'/auth.php';