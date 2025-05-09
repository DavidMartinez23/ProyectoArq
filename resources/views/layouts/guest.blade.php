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
        <style>
            body {
                min-height: 100vh;
                margin: 0;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #181e29 0%, #ff6b00 100%);
            }
            .auth-bg {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .auth-card {
                background: #fff;
                padding: 2rem 2.5rem;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.10);
                width: 100%;
                max-width: 400px;
                margin-top: 2rem;
            }
        </style>
    </head>
    <body>
        <div class="auth-bg">
            <div class="auth-card">
                @yield('content')
            </div>
        </div>
    </body>
</html>
