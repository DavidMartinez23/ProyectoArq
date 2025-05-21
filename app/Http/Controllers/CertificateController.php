<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\ModuleUser;
use App\Models\StudentProgress; // Asegúrate que este modelo exista y esté bien definido
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Si vas a enviar correos, necesitarás:
// use Illuminate\Support\Facades\Mail;
// use App\Mail\CertificateMail; // Suponiendo que tienes una clase Mail para el certificado

class CertificateController extends Controller
{
    public function index()
{
    // Obtener todos los certificados del usuario ordenados por fecha de emisión
    $certificates = Certificate::where('user_id', Auth::id())
                    ->with(['course', 'course.teacher']) // Carga anticipada de relaciones
                    ->orderBy('issued_at', 'desc')
                    ->get();
    
    return view('certificates.index', compact('certificates'));
}
    public function generate(Course $course)
    {
        $user = Auth::user();

        // Verificar que el usuario ha completado el curso
        // Esta lógica puede variar según cómo almacenes el progreso
        $studentProgress = StudentProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$studentProgress || !$studentProgress->completed) {
             // Opcional: verificar si todos los módulos están marcados en ModuleUser
            $totalModules = $course->modules()->count();
            $completedModules = ModuleUser::where('user_id', $user->id)
                                        ->where('course_id', $course->id)
                                        ->whereNotNull('completed_at') // Asumiendo que 'completed_at' marca un módulo como completo
                                        ->count();
            if ($totalModules == 0 || $completedModules < $totalModules) {
                return redirect()->route('courses.show', $course->id)
                                 ->with('error', 'Debes completar todos los módulos del curso para generar el certificado.');
            }
        }


        return view('certificates.request', compact('course'));
    }
    

    public function store(Request $request, Course $course)
    {
{
    $request->validate([
        'full_name' => 'required|string|max:255',
    ]);

    // Crear un nuevo certificado sin afectar los existentes
    $certificate = Certificate::create([
        'user_id' => Auth::id(),
        'course_id' => $course->id,
        'full_name' => $request->full_name,
        'email' => Auth::user()->email,
        'issued_at' => now(),
    ]);

    return redirect()->route('certificates.success', $certificate);
}
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Doble verificación de completitud del curso
        $studentProgress = StudentProgress::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$studentProgress || !$studentProgress->completed) {
            $totalModules = $course->modules()->count();
            $completedModules = ModuleUser::where('user_id', $user->id)
                                        ->where('course_id', $course->id)
                                        ->whereNotNull('completed_at')
                                        ->count();
            if ($totalModules == 0 || $completedModules < $totalModules) {
                return redirect()->route('courses.show', $course->id)
                                 ->with('error', 'Aún no has completado todos los módulos de este curso.');
            }
        }
        

        $certificate = Certificate::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'issued_at' => now(),
            ]
        );

        // Comentamos la línea de envío de correo para simplificar por ahora
        // Mail::to($validated['email'])->send(new \App\Mail\CertificateMail($certificate));

        // Cambiamos el mensaje de éxito
        return redirect()->route('certificates.success', $certificate->id)
                         ->with('success', '¡Muchas gracias! Hemos registrado tu finalización. Recibirás tu certificado lo más pronto posible.');
    }

    public function success(Certificate $certificate)
    {
        // Asegurarse que el certificado pertenece al usuario autenticado
        if ($certificate->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este certificado.');
        }
        // Puedes simplificar esta vista o mantenerla si el mensaje de sesión es suficiente
        return view('certificates.success', compact('certificate'));
    }
    public function download(Certificate $certificate)
    {
        // Verificar que el certificado pertenece al usuario autenticado
        if ($certificate->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para descargar este certificado.');
        }

        // Por ahora, retornaremos una respuesta temporal
        return response()->json([
            'message' => 'Función de descarga en desarrollo',
            'certificate' => $certificate
        ]);
    }
}
