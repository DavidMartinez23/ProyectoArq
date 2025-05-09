@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-bar {
        background-color: #1c2c52;
        padding: 15px 30px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .search-input {
        width: 100%;
        background-color: #283a5d;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        color: white;
        font-size: 14px;
    }

    .search-input::placeholder {
        color: #8b97ab;
    }

    .dashboard-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: #fff;
    }

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .content-card {
        background-color: #1c2c52;
        border-radius: 10px;
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s;
        color: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .content-card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 8px 24px rgba(255,107,0,0.10);
    }

    @media (max-width: 900px) {
        .dashboard-container {
            padding: 0 10px;
        }
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
    @media (max-width: 600px) {
        .dashboard-container {
            padding: 0 4px;
        }
        .search-bar {
            padding: 10px 8px;
        }
        .dashboard-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="search-bar">
        <input type="text" class="search-input" placeholder="¿Qué quieres aprender?">
    </div>

    <div class="dashboard-title">Cursos Recomendados</div>
    <div class="content-grid">
        <div class="content-card">
            <h3>Curso 1</h3>
            <p>Descripción del curso...</p>
        </div>
        <div class="content-card">
            <h3>Curso 2</h3>
            <p>Descripción del curso...</p>
        </div>
        <div class="content-card">
            <h3>Curso 3</h3>
            <p>Descripción del curso...</p>
        </div>
    </div>
</div>
@endsection
