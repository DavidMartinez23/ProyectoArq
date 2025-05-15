<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        if (Auth::user()->role !== 'teacher') {
            abort(403, 'No tienes permisos para acceder aquí.');
        }
        
        return $next($request);
    }
}
