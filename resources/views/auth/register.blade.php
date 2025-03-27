@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-black to-orange-600">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-center text-2xl font-bold text-gray-700 mb-6">Registrarse</h2>

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Mensaje de éxito -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-600">Nombre</label>
                <div class="relative">
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-600">Correo electrónico</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-600">Contraseña</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-600">Confirmar Contraseña</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-500">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" id="remember" class="mr-2">
                <label for="remember" class="text-gray-600">Recuérdame</label>
            </div>

            <button type="submit"
                class="w-full bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700 transition">
                Registrarse
            </button>

            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}" class="text-sm text-red-500 hover:underline">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
</div>
@endsection
