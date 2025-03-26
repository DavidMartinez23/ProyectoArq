<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">

        <!-- Header mejorado -->
        <header id="main-header" class="fixed top-0 left-0 w-full bg-transparent text-white z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold">Mi Proyecto</a>
                <nav class="hidden md:flex space-x-4">
                    <a href="{{ url('/') }}" class="hover:text-gray-300">Inicio</a>
                    <a href="#" class="hover:text-gray-300">Servicios</a>
                    <a href="#" class="hover:text-gray-300">Contacto</a>
                </nav>
                <div>
                    @guest
                        <a href="{{ route('login') }}" class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200 transition">Acceder</a>
                        <a href="{{ route('register') }}" class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200 transition ml-2">Registrarse</a>
                    @else
                        <div class="relative group">
                            <button class="bg-white text-black px-4 py-2 rounded hover:bg-gray-200 transition">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <!-- Contenido principal -->
        <div class="min-h-screen pt-20">
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white text-center py-4">
            <p>&copy; {{ date('Y') }} Mi Proyecto. Todos los derechos reservados.</p>
            <nav class="mt-2">
                <a href="#" class="text-gray-400 hover:text-white mx-2">Política de Privacidad</a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">Términos y Condiciones</a>
                <a href="#" class="text-gray-400 hover:text-white mx-2">Contacto</a>
            </nav>
        </footer>

        <script>
            window.addEventListener('scroll', function() {
                var header = document.getElementById('main-header');
                if (window.scrollY > 50) {
                    header.classList.add('bg-white', 'shadow-md', 'text-black');
                    header.classList.remove('bg-transparent', 'text-white');
                } else {
                    header.classList.remove('bg-white', 'shadow-md', 'text-black');
                    header.classList.add('bg-transparent', 'text-white');
                }
            });
        </script>
    </body>
</html>
