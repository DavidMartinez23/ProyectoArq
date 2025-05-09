<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-color: #ff6b00;
            --secondary-color: #181e29;
            --hover-color: #ff8533;
            --text-color: #ffffff;
            --sidebar-bg: #1a2236;
            --sidebar-hover: #232c47;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #181e29 0%, #ff6b00 100%);
            color: var(--text-color);
            min-height: 100vh;
            min-width: 100vw;
            width: 100vw;
            height: 100vh;
        }

        /* Sidebar mejorado */
        .sidebar {
            width: 220px;
            background: var(--sidebar-bg);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 80px; /* Aumenta el espacio superior para evitar que el logo se monte */
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 8px rgba(0,0,0,0.08);
            z-index: 100;
        }

        .sidebar-logo {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            letter-spacing: 1px;
            position: absolute;
            top: 24px; /* Espacio desde arriba */
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 101;
            background: transparent;
        }

        .sidebar-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }

        .sidebar-profile i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .sidebar-profile span {
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar-menu li {
            width: 100%;
        }

        .sidebar-menu li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 14px 30px;
            border-radius: 8px;
            margin: 6px 0;
            font-size: 1rem;
            transition: background 0.25s, transform 0.18s, box-shadow 0.18s;
            position: relative;
        }

        .sidebar-menu li a i {
            margin-right: 14px;
            font-size: 1.2rem;
            transition: color 0.2s;
        }

        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: linear-gradient(90deg, var(--primary-color) 60%, var(--hover-color) 100%);
            color: #fff;
            transform: translateX(8px) scale(1.04);
            box-shadow: 0 2px 12px 0 rgba(255,107,0,0.10);
        }

        .sidebar-menu li a:hover i, .sidebar-menu li a.active i {
            color: #fff;
        }

        /* Header mejorado */
        .top-nav {
            background: rgba(24, 30, 41, 0.85);
            padding: 0 2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 64px;
            z-index: 101;
            /* Eliminamos la sombra fuerte */
            box-shadow: none;
            border-bottom: 1px solid rgba(255,255,255,0.04);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            color: var(--text-color);
            font-size: 1rem;
            cursor: pointer;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            background: rgba(255, 107, 0, 0.10);
            transition: background 0.2s;
            position: relative;
        }

        .user-menu:hover, .user-menu:focus-within {
            background: rgba(255, 107, 0, 0.18);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 110%;
            background: #232c47;
            border-radius: 8px;
            min-width: 160px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            z-index: 999;
        }

        /* Mantener abierto el menú si el mouse está sobre el menú o el dropdown */
        .dropdown:hover .dropdown-content,
        .dropdown:focus-within .dropdown-content,
        .dropdown-content:hover,
        .dropdown-content:focus-within {
            display: block;
        }

        .dropdown-content a, .dropdown-content form a {
            color: #fff;
            padding: 12px 18px;
            display: block;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .dropdown-content a:hover, .dropdown-content form a:hover {
            background: var(--primary-color);
            color: #fff;
        }

        .main-content {
            margin-left: 220px;
            margin-top: 74px;
            padding: 2.5rem 2rem 2rem 2rem;
            min-height: calc(100vh - 74px);
            transition: margin-left 0.3s;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .sidebar {
                width: 60px;
                padding-top: 80px;
            }
            .sidebar-logo {
                font-size: 1.1rem;
                left: 0;
                width: 60px;
                text-align: center;
            }
            .sidebar-profile span {
                display: none;
            }
            .main-content {
                margin-left: 60px;
            }
            .top-nav {
                left: 60px;
            }
        }
        @media (max-width: 600px) {
            .sidebar {
                display: none;
            }
            .main-content, .top-nav {
                margin-left: 0;
                left: 0;
            }
            .top-nav {
                width: 100vw;
                min-width: 0;
                left: 0;
            }
        }
    </style>
</head>
<body class="{{ Route::is('login', 'register') ? 'auth-page' : '' }}">
    @if(!Route::is('login', 'register'))
        @auth
            <div class="sidebar">
                <div class="sidebar-logo">
                    <i class="fas fa-graduation-cap"></i> Mi Proyecto
                </div>
                <div class="sidebar-profile">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Inicio</a></li>
                    <li><a href="#"><i class="fas fa-book"></i> Mis Cursos</a></li>
                    <li><a href="#"><i class="fas fa-chart-line"></i> Mi Progreso</a></li>
                    <li><a href="#"><i class="fas fa-certificate"></i> Certificados</a></li>
                    <li><a href="#"><i class="fas fa-comments"></i> Chat</a></li>
                </ul>
            </div>
            <nav class="top-nav">
                <div class="user-menu">
                    <div class="dropdown">
                        <span>
                            <i class="fas fa-user-circle"></i>
                            {{ Auth::user()->name }}
                        </span>
                        <div class="dropdown-content">
                            <a href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-edit"></i> Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        @endauth
    @endif
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
