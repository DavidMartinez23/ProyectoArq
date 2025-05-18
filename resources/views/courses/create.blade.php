@extends('layouts.app')

@section('content')
<div class="main-container">
    <div class="course-creation-container">
        <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" class="course-form">
            @csrf
            
            <div class="header-section">
                <h2 class="page-title">Panel de Profesor</h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="form-section">
                <label for="title" class="form-label">Título del Curso</label>
                <input type="text" class="form-input @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-section">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-input @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-section half">
                    <label for="categoria" class="form-label">Categoría</label>
                    <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria">
                        <option value="">Seleccionar categoría</option>
                        <option value="programacion">Programación</option>
                        <option value="diseno">Diseño</option>
                        <option value="marketing">Marketing</option>
                    </select>
                </div>
                
                <div class="form-section half">
                    <label for="nivel" class="form-label">Nivel</label>
                    <select class="form-select @error('nivel') is-invalid @enderror" id="nivel" name="nivel">
                        <option value="">Seleccionar nivel</option>
                        <option value="principiante">Principiante</option>
                        <option value="intermedio">Intermedio</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>
            </div>
            
            <div class="form-section">
                <label for="image" class="form-label">Imagen del Curso</label>
                <input type="file" class="form-input file-input @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                <span class="help-text">Imagen de portada para el curso (opcional)</span>
            </div>
            
            <div class="form-section">
                <label for="video_url" class="form-label">Video de Introducción (YouTube)</label>
                <input type="text" class="form-input @error('video_url') is-invalid @enderror" 
                       id="video_url" name="video_url" 
                       placeholder="Ej: https://www.youtube.com/embed/XXXXXXXXXXX">
                <span class="help-text">Ingresa el código de inserción de YouTube</span>
            </div>
            
            <div class="form-section">
                <label for="status" class="form-label">Estado del Curso</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="draft">Borrador</option>
                    <option value="published">Publicado</option>
                </select>
                <span class="help-text">Los cursos en borrador no serán visibles para los estudiantes hasta que los publiques.</span>
            </div>
            
            <div class="button-group">
                <a href="{{ route('teacher.dashboard') }}" class="btn-secondary">Cancelar</a>
                <button type="submit" class="btn-primary">Crear Curso</button>
            </div>
        </form>
    </div>
</div>

<style>
    .main-container {
        min-height: calc(100vh - 64px);
        margin-top: 64px;
        background: linear-gradient(135deg, #181e29 0%, #ff6b00 100%);
    }

    .course-creation-container {
        padding: 2rem;
        color: #fff;
    }

    .course-form {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .half {
        flex: 1;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #fff;
        font-weight: 500;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #ff6b00;
        background: rgba(255, 255, 255, 0.15);
    }

    .form-input::placeholder {
        color: rgba(0, 0, 0, 0.6); /* Cambiado el color del placeholder */
    }

    .form-select {
        background-color: rgba(255, 255, 255, 0.9); /* Fondo más claro para los selects */
        color: #333; /* Color de texto más oscuro */
    }

    .form-select option {
        background-color: white;
        color: #333;
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 3rem;
        padding: 1rem;
    }

    .btn-primary, .btn-secondary {
        padding: 0.75rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 1rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
        }
    }

    .header-section {
        position: relative;
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

    .header-section::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 100%;
        height: 1px;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.5), transparent);
    }
</style>

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
</script>
@endsection