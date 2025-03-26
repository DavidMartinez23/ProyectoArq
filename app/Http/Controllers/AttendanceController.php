<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function store()
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para marcar asistencia.');
        }

        // Obtiene el usuario autenticado
        $user = Auth::user();

        // Registra la asistencia
        Attendance::create([
            'user_id' => $user->id,
            'checked_in_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Asistencia marcada correctamente.');
    }
}
