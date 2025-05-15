@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Añadir Módulo a "{{ $course->title }}"</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.modules.store', $course->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título del Módulo</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="order" class="form-label">Orden</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ $nextOrder ?? 1 }}" min="1">
                            <div class="form-text">Posición del módulo en el curso</div>
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="video_url" class="form-label">URL del Video (YouTube)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                       id="video_url" name="video_url" value="{{ old('video_url') }}" 
                                       placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                            <div class="form-text">Añade un video para este módulo desde YouTube</div>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duración</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration') }}" placeholder="Ej: 15 min">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido del Módulo</label>
                            <div class="mb-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('b')"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('i')"><i class="fas fa-italic"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('h1')">H1</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('h2')">H2</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('h3')">H3</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('ul')"><i class="fas fa-list-ul"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('ol')"><i class="fas fa-list-ol"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="formatText('a')"><i class="fas fa-link"></i></button>
                            </div>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10">{{ old('content') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Escribe el contenido de tu módulo. Usa los botones para dar formato al texto.
                            </div>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.courses.edit', $course->id) }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Módulo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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