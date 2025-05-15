@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Contenido principal del curso -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ $course->title }}</h2>
                    <p class="mb-0">Profesor: {{ $course->teacher->name }}</p>
                </div>
                <div class="card-body">
                    <!-- Video del curso -->
                    @if($course->video_url)
                    <div class="ratio ratio-16x9 mb-4">
                        <iframe src="{{ str_replace('watch?v=', 'embed/', $course->video_url) }}" 
                                title="{{ $course->title }}" 
                                allowfullscreen></iframe>
                    </div>
                    @endif

                    <!-- Descripción del curso -->
                    <h4 class="mb-3">Descripción del Curso</h4>
                    <p class="lead">{{ $course->description }}</p>
                    
                    <!-- Contenido del curso -->
                    <div class="mt-4">
                        <h4 class="mb-3">Contenido del Curso</h4>
                        @if($course->modules->count() > 0)
                            <div class="progress mb-3">
                                <div class="progress-bar" role="progressbar" style="width: {{ $progress ?? 0 }}%" 
                                    aria-valuenow="{{ $progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $progress ?? 0 }}% Completado
                                </div>
                            </div>
                            <div class="list-group">
                                @foreach($course->modules->sortBy('order') as $module)
                                    <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $module->id]) }}" 
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-play-circle me-2"></i>
                                            {{ $module->title }}
                                        </div>
                                        <span class="badge bg-primary rounded-pill">{{ $module->duration ?? '15 min' }}</span>
                                    </a>
                                @endforeach
                            </div>
                            
                            @if($progress == 100)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('certificates.generate', ['course' => $course->id]) }}" 
                                       class="btn btn-success">
                                        <i class="fas fa-certificate me-2"></i>Obtener Certificado
                                    </a>
                                </div>
                            @endif
                        @else
                            <p>Este curso aún no tiene módulos disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar con chat y detalles del curso -->
        <div class="col-md-4">
            <!-- Detalles del curso -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Detalles del Curso</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-calendar me-2"></i> Creado: {{ $course->created_at->format('d/m/Y') }}</li>
                        <li class="mb-2"><i class="fas fa-clock me-2"></i> Duración: {{ $course->duration ?? 'Variable' }}</li>
                        <li class="mb-2"><i class="fas fa-layer-group me-2"></i> Módulos: {{ $course->modules->count() }}</li>
                    </ul>
                    
                    @if($nextModule)
                        <div class="d-grid gap-2">
                            <a href="{{ route('modules.show', ['course' => $course->id, 'module' => $nextModule->id]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-arrow-right"></i> Continuar con el curso
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Chat del curso -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Comentarios del Curso</h5>
                </div>
                <div class="card-body chat-container" style="max-height: 400px; overflow-y: auto;">
                    {{-- Modified line --}}
                    @if(optional($course->comments)->count() > 0)
                        @foreach($course->comments as $comment)
                            <div class="mb-3 p-2 {{ $comment->user_id == auth()->id() ? 'bg-light text-end' : 'border-start border-primary border-3 ps-2' }}">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                    @endif
                </div>
                <div class="card-footer">
                    <form action="{{ route('comments.store', $course->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="content" class="form-control" placeholder="Escribe un comentario...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .chat-container::-webkit-scrollbar {
        width: 5px;
    }
    
    .chat-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .chat-container::-webkit-scrollbar-thumb {
        background: #888;
    }
    
    .chat-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection