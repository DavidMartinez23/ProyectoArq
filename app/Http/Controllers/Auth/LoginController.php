<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Eliminamos el middleware guest y lo manejamos a través de las rutas
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === User::ROLE_TEACHER) {
            return redirect()->route('teacher.dashboard')->with([
                'message' => '¡Bienvenido al panel de profesor!',
                'user' => $user->name
            ]);
        }

        return redirect()->route('dashboard')->with([
            'message' => '¡Bienvenido a la plataforma!',
            'user' => $user->name
        ]);
    }
}