@extends('layouts.app')

@section('content')
<div class="module-container">
    <!-- Encabezado del módulo -->
    <div class="module-header">
        <h1 class="module-title">{{ $module->title }}</h1>
        <p class="module-position">Módulo {{ $module->order }} de {{ $course->modules->count() }}</p>
    </div>

    <!-- Contenido principal -->
    <div class="module-content">
        <!-- Video del módulo -->
        @if($module->video_url)
        <div class="video-container">
            <iframe src="{{ str_replace('watch?v=', 'embed/', $module->video_url) }}" 
                    title="{{ $module->title }}" 
                    allowfullscreen></iframe>
        </div>
        @endif

        <!-- Descripción del módulo -->
        <div class="description-section">
            <p class="module-description">{!! $module->content !!}</p>
        </div>

        <!-- Navegación -->
        <div class="navigation-buttons">
            <a href="{{ route('courses.show', $course->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al curso
            </a>

            @if(!in_array($module->id, $completedModules))
                <form action="{{ route('modules.complete', ['course' => $course->id, 'module' => $module->id]) }}" 
                      method="POST" class="complete-form">
                    @csrf
                    <button type="submit" class="btn-complete">
                        <i class="fas fa-check"></i> Marcar como completado
                    </button>
                </form>
            @endif

            @if($nextModule)
                <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $nextModule->id]) }}" 
                   class="btn-next">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Barra lateral -->
    <div class="module-sidebar">
        <!-- Progreso -->
        <div class="progress-card">
            <h2>Tu Progreso</h2>
            <div class="progress-info">
                <span class="progress-percentage">{{ $progress }}%</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                </div>
                <p class="modules-completed">Has completado {{ $completedCount }} de {{ $course->modules->count() }} módulos</p>
            </div>
        </div>

        <!-- Lista de módulos -->
        <div class="modules-list-card">
            <h2>Módulos del Curso</h2>
            <div class="modules-list">
                @foreach($course->modules->sortBy('order') as $mod)
                    <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $mod->id]) }}" 
                       class="module-item {{ $mod->id == $module->id ? 'active' : '' }}">
                        <div class="module-info">
                            @if(in_array($mod->id, $completedModules))
                                <i class="fas fa-check-circle completed"></i>
                            @elseif($mod->id == $module->id)
                                <i class="fas fa-play-circle current"></i>
                            @else
                                <i class="fas fa-circle pending"></i>
                            @endif
                            <span>{{ $mod->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .module-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .module-header {
        grid-column: 1 / -1;
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }

    .module-title {
        font-size: 2.5rem;
        color: rgba(255, 255, 255, 0.95);
        margin-bottom: 0.5rem;
    }

    .module-position {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
    }

    .module-content {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        backdrop-filter: blur(10px);
    }

    .video-container {
        width: 100%;
        padding-bottom: 56.25%;
        position: relative;
        background: #000;
    }

    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .description-section {
        padding: 2rem;
    }

    .module-description {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .navigation-buttons {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem 2rem;
        gap: 1rem;
    }

    .btn-back, .btn-complete, .btn-next {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-complete {
        background: #28a745;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    .btn-next {
        background: #ff6b00;
        color: #fff;
    }

    .btn-back:hover { background: rgba(255, 255, 255, 0.2); }
    .btn-complete:hover { background: #218838; }
    .btn-next:hover { background: #ff8533; }

    .progress-card, .modules-list-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .progress-info {
        text-align: center;
    }

    .progress-percentage {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 600;
        display: block;
        margin-bottom: 1rem;
    }

    .progress-bar {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        height: 10px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .progress-fill {
        background: #ff6b00;
        height: 100%;
        border-radius: 20px;
        transition: width 0.3s ease;
    }

    .modules-completed {
        color: rgba(255, 255, 255, 0.8);
        margin-top: 0.5rem;
    }

    .modules-list {
        margin-top: 1rem;
    }

    .module-item {
        display: block;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .module-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .module-item.active {
        background: rgba(255, 107, 0, 0.2);
        border-left: 4px solid #ff6b00;
    }

    .completed { color: #28a745; }
    .current { color: #ff6b00; }
    .pending { color: rgba(255, 255, 255, 0.3); }

    @media (max-width: 768px) {
        .module-container {
            grid-template-columns: 1fr;
        }

        .navigation-buttons {
            flex-direction: column;
        }

        .btn-back, .btn-complete, .btn-next {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('styles')
<style>
    .module-content {
        font-size: 1.1rem;
        line-height: 1.6;
    }
    .module-content img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
    }
    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }
    .list-group-item a {
        display: block;
        text-decoration: none;
    }
</style>
@endsection