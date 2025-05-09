@extends('layouts.app')

@section('content')
<style>
    .welcome-header {
        background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px 10px 0 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .welcome-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-top: 2rem;
        overflow: hidden;
    }

    .welcome-body {
        background: white;
        padding: 2.5rem;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .welcome-user {
        font-size: 1.8rem;
        color: #333;
        margin-bottom: 2rem;
    }

    .dashboard-btn {
        background: #1a73e8;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .dashboard-btn:hover {
        background: #0d47a1;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(26, 115, 232, 0.3);
    }

    .welcome-decoration {
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        right: -30px;
        top: -30px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="welcome-card">
                <div class="welcome-header position-relative">
                    <div class="welcome-decoration"></div>
                    <h1 class="welcome-title">¡Bienvenido a mi página web!</h1>
                </div>
                <div class="welcome-body text-center">
                    <h2 class="welcome-user">
                        Hola, {{ auth()->user()->name }}!
                    </h2>
                    <a href="{{ route('dashboard') }}" class="dashboard-btn">
                        Ir al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection