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
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        if (Auth::user()->role !== User::ROLE_TEACHER) {
            return response()->view('errors.403', [
                'message' => 'No tienes permisos para acceder a esta sección. Esta área es solo para profesores.'
            ], 403);
        }
        
        return $next($request);
    }
}