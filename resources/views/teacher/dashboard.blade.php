@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h2 class="page-title">Panel de Profesor</h2>
        <div class="title-underline"></div>
    </div>
    
    <a href="{{ route('teacher.courses.create') }}" class="btn-create-course">
        <i class="fas fa-plus"></i> Crear Nuevo Curso
    </a>

    <div class="courses-section">
        <h3 class="section-title">Mis Cursos</h3>
        
        @if($courses->count() > 0)
            <div class="courses-grid">
                @foreach($courses as $course)
                    <div class="course-card">
                        <div class="course-image">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-book"></i>
                                </div>
                            @endif
                        </div>
                        <div class="course-content">
                            <h4 class="course-title">{{ $course->title }}</h4>
                            <p class="course-description">{{ Str::limit($course->description, 100) }}</p>
                            <div class="course-status">
                                <span class="status-badge status-published">
                                    Publicado
                                </span>
                            </div>
                            <div class="course-actions">
                                <a href="{{ route('courses.show', $course) }}" class="btn-view">Ver</a>
                                <a href="{{ route('teacher.courses.edit', $course) }}" class="btn-edit">Editar</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-book-open empty-icon"></i>
                <p>No has creado ningún curso todavía. ¡Crea tu primer curso!</p>
            </div>
        @endif
    </div>
</div>

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 64px auto 0;
        padding: 2rem;
    }

    .header-section {
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        padding-bottom: 0.5rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 500;
        color: #fff;
        margin: 0;
        padding: 0.5rem 0;
    }

    .title-underline {
        width: 50px;
        height: 3px;
        background-color: #ff6b00;
        margin-top: 0.5rem;
    }

    .btn-create-course {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #ff6b00;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .btn-create-course:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }

    .section-title {
        font-size: 1.4rem;
        color: #ff6b00;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .course-card {
        background: rgba(24, 30, 41, 0.8);
        border-radius: 15px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255, 107, 0, 0.2);
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(255, 107, 0, 0.15);
        border-color: rgba(255, 107, 0, 0.4);
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .course-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative; /* Agregado para posicionar el badge */
    }

    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        z-index: 1;
    }

    .status-draft {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .status-published {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .course-image {
        position: relative;
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .course-card:hover .course-image img {
        transform: scale(1.05);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.2);
    }

    .no-image i {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-content {
        padding: 1.5rem;
    }

    .course-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #fff;
        margin: 0 0 1rem 0;
    }

    .course-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        min-height: 3rem;
    }

    .course-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-view, .btn-edit {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: rgba(255, 107, 0, 0.2);
        color: #ff6b00;
        border: 1px solid rgba(255, 107, 0, 0.4);
    }

    .btn-view:hover {
        background: rgba(255, 107, 0, 0.3);
        border-color: rgba(255, 107, 0, 0.6);
    }

    .btn-edit {
        background: #ff6b00;
        color: #fff;
        border: none;
    }

    .btn-edit:hover {
        background: #ff8533;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: #fff;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-status {
        margin-bottom: 1rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-draft {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .status-published {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .btn-view, .btn-edit {
        flex: 1;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: rgba(255, 107, 0, 0.2);
        color: #ff6b00;
        border: 1px solid rgba(255, 107, 0, 0.4);
    }

    .btn-view:hover {
        background: rgba(255, 107, 0, 0.3);
        border-color: rgba(255, 107, 0, 0.6);
    }

    .btn-edit {
        background: #ff6b00;
        color: #fff;
        border: none;
    }

    .btn-edit:hover {
        background: #ff8533;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: #fff;
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.5);
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }

        .course-actions {
            flex-direction: column;
        }

        .btn-view, .btn-edit {
            width: 100%;
        }
    }
</style>
@endsection