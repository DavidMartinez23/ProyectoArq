@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Contenido principal del módulo -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $module->title }}</h2>
                    <span class="badge bg-light text-dark">Módulo {{ $module->order }} de {{ $course->modules->count() }}</span>
                </div>
                <div class="card-body">
                    <!-- Video del módulo -->
                    @if($module->video_url)
                    <div class="ratio ratio-16x9 mb-4">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $module->video_url) }}" 
                                title="{{ $module->title }}" 
                                allowfullscreen></iframe>
                    </div>
                    @endif

                    <!-- Contenido del módulo -->
                    <div class="module-content">
                        {!! $module->content !!}
                    </div>
                    
                    <!-- Navegación entre módulos -->
                    <div class="d-flex justify-content-between mt-4">
                        @if(isset($prevModule) && $prevModule)
                            <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $prevModule->id]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Anterior
                            </a>
                        @else
                            <a href="{{ route('courses.show', $course->id) }}" 
                               class="btn btn-outline-secondary">
                                <i class="fas fa-home me-2"></i>Volver al curso
                            </a>
                        @endif
                        
                        @if(isset($completed) && !$completed)
                            <form action="{{ route('modules.complete', ['course' => $course->id, 'module' => $module->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success mt-3">
                                    <i class="fas fa-check-circle me-2"></i> Marcar como completado
                                </button>
                            </form>
                        @endif
                        
                        @if($nextModule)
                            <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $nextModule->id]) }}" 
                               class="btn btn-primary">
                                Siguiente<i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            @if($allCompleted)
                                <a href="{{ route('certificates.generate', ['course' => $course->id]) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-certificate me-2"></i>Obtener Certificado
                                </a>
                            @else
                                <a href="{{ route('courses.show', $course->id) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>Ver todos los módulos
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar con progreso y módulos -->
        <div class="col-md-4">
            <!-- Progreso del curso -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tu Progreso</h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%" 
                             aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $progress }}%
                        </div>
                    </div>
                    <p class="text-center">Has completado {{ $completedCount }} de {{ $course->modules->count() }} módulos</p>
                </div>
            </div>
            
            <!-- Lista de módulos -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Módulos del Curso</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($course->modules->sortBy('order') as $mod)
                            <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $mod->id]) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center
                                      {{ $mod->id == $module->id ? 'active' : '' }}">
                                <div>
                                    @if(in_array($mod->id, $completedModules))
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                    @elseif($mod->id == $module->id)
                                        <i class="fas fa-play-circle text-primary me-2"></i>
                                    @else
                                        <i class="fas fa-circle text-secondary me-2"></i>
                                    @endif
                                    {{ $mod->title }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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