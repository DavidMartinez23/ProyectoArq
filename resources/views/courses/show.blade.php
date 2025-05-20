@extends('layouts.app')

@section('content')
<div class="course-container">
    <!-- Contenido principal del curso -->
    <div class="course-main">
        <div class="course-header">
            <h1 class="main-title">{{ $course->title }}</h1>
            <p class="teacher-name">Profesor: {{ $course->teacher->name }}</p>
        </div>

        <div class="course-section">
            <!-- Video del curso -->
            @if($course->video_url)
            <div class="video-container">
                <iframe src="{{ str_replace('watch?v=', 'embed/', $course->video_url) }}" 
                        title="{{ $course->title }}" 
                        allowfullscreen></iframe>
            </div>
            @endif

            <!-- Descripción del curso -->
            <div class="description-section">
                <h2 class="section-title">Descripción del Curso</h2>
                <p class="course-description">{{ $course->description }}</p>
            </div>
            
            <!-- Contenido del curso -->
            <div class="content-section">
                <h2 class="section-title">Contenido del Curso</h2>
                @if($course->modules->count() > 0)
                    <div class="progress-container">
                        <div class="progress-bar">
                            @php
                                $completedModules = auth()->user()->completedModules->where('course_id', $course->id);
                                $progress = ($completedModules->count() / $course->modules->count()) * 100;
                            @endphp
                            <div class="progress-fill" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="progress-text">{{ number_format($progress, 0) }}% Completado</span>
                    </div>

                    <div class="modules-list">
                        @foreach($course->modules->sortBy('order') as $module)
                            <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $module->id]) }}" 
                               class="module-item">
                                <div class="module-info">
                                    <i class="fas fa-play-circle"></i>
                                    <span class="module-title">{{ $module->title }}</span>
                                </div>
                                <span class="module-duration">{{ $module->duration ?? '15 min' }}</span>
                            </a>
                        @endforeach
                    </div>
                    
                    @if($progress == 100)
                        <div class="certificate-section">
                            <a href="{{ route('certificates.generate', ['course' => $course->id]) }}" 
                               class="btn-certificate">
                                <i class="fas fa-certificate"></i>
                                Obtener Certificado
                            </a>
                        </div>
                    @endif
                @else
                    <p class="no-modules">Este curso aún no tiene módulos disponibles.</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="course-sidebar">
        <!-- Detalles del curso -->
        <div class="details-card">
            <h2 class="card-title">Detalles del Curso</h2>
            <ul class="details-list">
                <li>
                    <i class="fas fa-calendar"></i>
                    <span>Creado: {{ $course->created_at->format('d/m/Y') }}</span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>Duración: {{ $course->duration ?? 'Variable' }}</span>
                </li>
                <li>
                    <i class="fas fa-layer-group"></i>
                    <span>Módulos: {{ $course->modules->count() }}</span>
                </li>
            </ul>
            
            @if($nextModule)
                <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $nextModule->id]) }}" 
                   class="btn-continue">
                    Continuar con el curso
                    <i class="fas fa-arrow-right"></i>
                </a>
            @endif
        </div>
        
        <!-- Chat del curso -->
        <div class="comments-card">
            <h2 class="card-title">Comentarios del Curso</h2>
            <div class="comments-container">
                @if(optional($course->comments)->count() > 0)
                    @foreach($course->comments as $comment)
                        <div class="comment-item {{ $comment->user_id == auth()->id() ? 'own-comment' : '' }}">
                            <div class="comment-header">
                                <span class="comment-author">{{ $comment->user->name }}</span>
                                <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-content">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="no-comments">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                @endif
            </div>
            <form action="{{ route('comments.store', $course->id) }}" method="POST" class="comment-form">
                @csrf
                <div class="input-group">
                    <input type="text" name="content" class="comment-input" placeholder="Escribe un comentario...">
                    <button class="btn-submit" type="submit">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .course-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .course-header {
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .main-title {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .teacher-name {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
    }

    .course-section {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .section-title {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.8rem;
        margin: 2rem 0 1rem;
        padding: 0 2rem;
    }

    .course-description {
        color: rgba(255, 255, 255, 0.95) !important;
        font-size: 1.1rem;
        line-height: 1.6;
        padding: 0 2rem 2rem;
    }

    .progress-container {
        padding: 1rem 2rem;
    }

    .progress-bar {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        height: 10px;
        overflow: hidden;
    }

    .progress-fill {
        background: #ff6b00;
        height: 100%;
        border-radius: 20px;
        transition: width 0.3s ease;
    }

    .progress-text {
        display: block;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 0.5rem;
        text-align: right;
    }

    .modules-list {
        padding: 1rem 2rem;
    }

    .module-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .module-item:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .module-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .module-duration {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .details-card, .comments-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .card-title {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .details-list {
        list-style: none;
        padding: 0;
    }

    .details-list li {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 1rem;
    }

    .btn-continue {
        display: block;
        background: #ff6b00;
        color: white;
        text-align: center;
        padding: 1rem;
        border-radius: 8px;
        text-decoration: none;
        margin-top: 1.5rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-continue:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }

    .comments-container {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 1rem;
    }

    .comment-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .own-comment {
        background: rgba(255, 255, 255, 0.1);
        margin-left: 2rem;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .comment-author {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .comment-time {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .comment-content {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
    }

    .comment-form {
        margin-top: 1rem;
    }

    .input-group {
        display: flex;
        gap: 0.5rem;
    }

    .comment-input {
        flex: 1;
        padding: 0.8rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        color: white;
    }

    .btn-submit {
        background: #ff6b00;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #ff8533;
    }

    @media (max-width: 768px) {
        .course-container {
            grid-template-columns: 1fr;
        }

        .main-title {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }
    }

    /* Estilos del certificado */
    .certificate-section {
        padding: 2rem;
        text-align: center;
    }

    .btn-certificate {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #28a745;
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-certificate:hover {
        background: #218838;
        transform: translateY(-2px);
    }

    .btn-certificate i {
        font-size: 1.2rem;
    }
</style>
@endsection