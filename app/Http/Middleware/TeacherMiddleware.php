<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Debes iniciar sesión primero.');
        }

        $user = Auth::user();
        
        // Verificar si el usuario tiene rol de profesor
        if (!$user || $user->role !== User::ROLE_TEACHER) {
            // Redirigir al dashboard con mensaje de error
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para acceder al panel de profesor. Esta área es solo para profesores.');
        }
        
        // Si todo está bien, continuar con la solicitud
        return $next($request);
    }
}