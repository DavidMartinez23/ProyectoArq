@extends('layouts.app')

@section('content')
<div class="header-section">
    <h2 class="page-title">Panel de Profesor</h2>
    <div class="title-underline"></div>
</div>

<div class="module-form-container">
    <div class="module-form-content">
        <h3 class="form-subtitle">Editar Módulo: {{ $module->title }}</h3>
        
        <form method="POST" action="{{ route('teacher.modules.update', [$course, $module]) }}" class="module-form">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <label for="title" class="form-label">Título del Módulo</label>
                <input type="text" class="form-input @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title', $module->title) }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-section">
                <label for="order" class="form-label">Orden</label>
                <input type="number" class="form-input @error('order') is-invalid @enderror" 
                       id="order" name="order" value="{{ old('order', $module->order) }}" min="1">
                <span class="help-text">Posición del módulo en el curso</span>
                @error('order')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-section">
                <label for="youtube_url" class="form-label">URL del Video (YouTube)</label>
                <div class="input-group">
                    <span class="input-group-icon"><i class="fab fa-youtube"></i></span>
                    <input type="url" class="form-input @error('youtube_url') is-invalid @enderror" 
                           id="youtube_url" name="youtube_url" 
                           value="{{ old('youtube_url', $module->youtube_url) }}" 
                           placeholder="https://www.youtube.com/watch?v=...">
                </div>
                <span class="help-text">Añade un video para este módulo desde YouTube</span>
                @error('youtube_url')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if($module->youtube_url)
                <div class="form-section">
                    <label class="form-label">Vista previa del video</label>
                    <div class="video-preview">
                        <iframe src="{{ $module->youtube_embed }}" 
                                title="{{ $module->title }}" 
                                allowfullscreen></iframe>
                    </div>
                </div>
            @endif
            
            <div class="form-section">
                <label for="content" class="form-label">Contenido del Módulo</label>
                <div class="editor-toolbar">
                    <button type="button" class="toolbar-btn" onclick="formatText('b')"><i class="fas fa-bold"></i></button>
                    <button type="button" class="toolbar-btn" onclick="formatText('i')"><i class="fas fa-italic"></i></button>
                    <button type="button" class="toolbar-btn" onclick="formatText('h1')">H1</button>
                    <button type="button" class="toolbar-btn" onclick="formatText('h2')">H2</button>
                    <button type="button" class="toolbar-btn" onclick="formatText('h3')">H3</button>
                    <button type="button" class="toolbar-btn" onclick="formatText('ul')"><i class="fas fa-list-ul"></i></button>
                    <button type="button" class="toolbar-btn" onclick="formatText('ol')"><i class="fas fa-list-ol"></i></button>
                </div>
                <textarea class="form-input content-editor @error('content') is-invalid @enderror" 
                          id="content" name="content" rows="10">{{ old('content', $module->content) }}</textarea>
                @error('content')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="button-group">
                <a href="{{ route('teacher.courses.edit', $course) }}" class="btn-secondary">Volver al Curso</a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Módulo
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .header-section {
        max-width: 1200px;
        margin: 64px auto 2rem;
        padding: 0 2rem;
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

    .module-form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .module-form-content {
        background: transparent;
        border-radius: 15px;
        padding: 2rem;
    }

    .form-subtitle {
        color: #fff;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #fff;
        font-weight: 500;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #ff6b00;
        background: rgba(255, 255, 255, 0.15);
    }

    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.75rem;
        border-radius: 8px 0 0 8px;
        color: #ff6b00;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-right: none;
    }

    .input-group .form-input {
        border-radius: 0 8px 8px 0;
    }

    .help-text {
        display: block;
        margin-top: 0.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
    }

    .video-preview {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
        margin-top: 0.5rem;
    }

    .video-preview iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .editor-toolbar {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }

    .toolbar-btn {
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toolbar-btn:hover {
        background: rgba(255, 107, 0, 0.2);
        border-color: #ff6b00;
    }

    .content-editor {
        min-height: 200px;
        font-family: monospace;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: flex-end;
    }

    .btn-primary, .btn-secondary {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-primary {
        background: #ff6b00;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .error-message {
        color: #ff4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .button-group {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection