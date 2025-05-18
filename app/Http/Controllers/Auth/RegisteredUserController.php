<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Registra un nuevo usuario.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario incluyendo el rol
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:student,teacher'], // Validación del rol
        ]);

        // Crear el usuario con el rol seleccionado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Asignar el rol seleccionado
        ]);

        // Disparar evento de registro
        event(new Registered($user));

        // Iniciar sesión automáticamente
        Auth::login($user);

        // Redirigir según el rol
        if ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard')->with('success', 'Registro exitoso como profesor');
        }

        return redirect()->route('dashboard')->with('success', 'Registro exitoso como estudiante');
    }
}