<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver esta página.');
        }

        $user = Auth::user();

        // Verificar si el usuario ya marcó asistencia hoy
        $hasCheckedIn = Attendance::where('user_id', $user->id)
            ->whereDate('checked_in_at', today())
            ->exists();

        return view('welcome', compact('hasCheckedIn'));
    }
}
