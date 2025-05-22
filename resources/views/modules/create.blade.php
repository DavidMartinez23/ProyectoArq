@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="header-section">
        <h2 class="page-title">Panel de Profesor</h2>
        <div class="title-underline"></div>
    </div>

    <div class="module-form-container">
        <div class="module-form-content">
            <h3 class="form-subtitle">Añadir Módulo a "{{ $course->title }}"</h3>
            
            <form action="{{ route('teacher.modules.store', $course->id) }}" method="POST" class="module-form">
                @csrf
                
                
                <div class="form-section">
                    <label for="title" class="form-label">Título del Módulo</label>
                    <input type="text" class="form-input @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="order" class="form-label">Orden</label>
                    <input type="number" 
                           class="form-input" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $nextOrder ?? 1) }}" 
                           min="1" 
                           required>
                    <span class="help-text">Posición del módulo en el curso</span>
                    @error('order')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="video_url" class="form-label">URL del Video (YouTube)</label>
                    <div class="input-group">
                        <span class="input-group-icon"><i class="fab fa-youtube"></i></span>
                        <input type="url" class="form-input @error('video_url') is-invalid @enderror" 
                               id="video_url" name="video_url" value="{{ old('video_url') }}" 
                               placeholder="https://www.youtube.com/watch?v=...">
                    </div>
                    <span class="help-text">Añade un video para este módulo desde YouTube</span>
                    @error('video_url')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="duration" class="form-label">Duración</label>
                    <input type="text" class="form-input @error('duration') is-invalid @enderror" 
                           id="duration" name="duration" value="{{ old('duration') }}" 
                           placeholder="Ej: 15 min">
                    @error('duration')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
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
                        <button type="button" class="toolbar-btn" onclick="formatText('a')"><i class="fas fa-link"></i></button>
                    </div>
                    <textarea class="form-input content-editor @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="10">{{ old('content') }}</textarea>
                    <span class="help-text">
                        <i class="fas fa-info-circle"></i>
                        Escribe el contenido de tu módulo. Usa los botones para dar formato al texto.
                    </span>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="button-group">
                    <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn-secondary">Cancelar</a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Guardar Módulo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .main-container {
        min-height: calc(100vh - 64px);
        margin-top: 64px;
        padding: 2rem;
        background: transparent;
    }

    .header-section {
        max-width: 900px;
        margin: 0 auto 2rem;
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
        backdrop-filter: blur(10px);
    }

    .form-subtitle {
        color: #ff6b00;
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

    .help-text {
        display: block;
        margin-top: 0.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
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
        flex: 1;
        border-radius: 0 8px 8px 0;
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
        text-decoration: none;
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

@section('scripts')
<style>
    /* Estilo para el input de orden */
    input[type="number"] {
        color: #333 !important; /* Color de texto oscuro */
        background-color: rgba(255, 255, 255, 0.9) !important; /* Fondo semi-transparente */
    }

    /* Estilo para el placeholder */
    input[type="number"]::placeholder {
        color: rgba(0, 0, 0, 0.5);
    }

    /* Estilo para cuando el input está enfocado */
    input[type="number"]:focus {
        color: #333 !important;
        background-color: #fff !important;
        border-color: #ff6b00 !important;
    }
</style>
<script>
    // Vista previa del video de YouTube
    document.getElementById('video_url').addEventListener('change', function() {
        const videoUrl = this.value;
        if (videoUrl && videoUrl.includes('youtube.com/watch?v=')) {
            const videoId = videoUrl.split('v=')[1].split('&')[0];
            const previewContainer = document.createElement('div');
            previewContainer.className = 'mt-3';
            previewContainer.innerHTML = `
                <p>Vista previa:</p>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/${videoId}" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                </div>
            `;
            
            // Eliminar vista previa anterior si existe
            const oldPreview = this.parentNode.nextElementSibling.nextElementSibling;
            if (oldPreview && oldPreview.classList.contains('mt-3')) {
                oldPreview.remove();
            }
            
            this.parentNode.parentNode.appendChild(previewContainer);
        }
    });

    // Función para formatear texto
    function formatText(tag) {
        const textarea = document.getElementById('content');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        let formattedText = '';
        
        switch(tag) {
            case 'b':
                formattedText = `<strong>${selectedText}</strong>`;
                break;
            case 'i':
                formattedText = `<em>${selectedText}</em>`;
                break;
            case 'h1':
                formattedText = `<h1>${selectedText}</h1>`;
                break;
            case 'h2':
                formattedText = `<h2>${selectedText}</h2>`;
                break;
            case 'h3':
                formattedText = `<h3>${selectedText}</h3>`;
                break;
            case 'ul':
                formattedText = `<ul>\n  <li>${selectedText}</li>\n</ul>`;
                break;
            case 'ol':
                formattedText = `<ol>\n  <li>${selectedText}</li>\n</ol>`;
                break;
            case 'a':
                const url = prompt('Introduce la URL:', 'https://');
                if (url) {
                    formattedText = `<a href="${url}" target="_blank">${selectedText || url}</a>`;
                } else {
                    return;
                }
                break;
        }
        
        textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
        textarea.focus();
        textarea.selectionStart = start + formattedText.length;
        textarea.selectionEnd = start + formattedText.length;
    }
</script>
@endsection