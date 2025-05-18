@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 10px;
    }
    .action-button {
        background-color: #ff6b00;
        border-color: #ff6b00;
        color: white;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 500;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .action-button:hover {
        background-color: #e05d00;
        border-color: #e05d00;
        color: white;
    }
    .subtitle {
        font-size: 1.2rem;
        color: #fff;
        margin: 20px 0;
    }
    .empty-state {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: none;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-title">Panel de Profesor</div>
    
    <a href="{{ route('teacher.courses.create') }}" class="btn action-button">
        <i class="fas fa-plus"></i> Crear Nuevo Curso
    </a>

    <div class="subtitle">Mis Cursos</div>
    
    @if($courses->count() > 0)
        <div class="content-grid">
            @foreach($courses as $course)
                <div class="content-card">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                    @else
                        <div style="height: 180px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book fa-3x text-secondary"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h3>{{ $course->title }}</h3>
                        <p>{{ Str::limit($course->description, 100) }}</p>
                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-primary">Editar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            No has creado ningún curso todavía. ¡Crea tu primer curso!
        </div>
    @endif
</div>
@endsection