@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Crear Nuevo Curso</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Título del Curso</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria">
                                        <option value="">Seleccionar categoría</option>
                                        <option value="programacion">Programación</option>
                                        <option value="diseno">Diseño</option>
                                        <option value="marketing">Marketing</option>
                                        <option value="negocios">Negocios</option>
                                        <!-- Añade más categorías según sea necesario -->
                                    </select>
                                    @error('categoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nivel" class="form-label">Nivel</label>
                                    <select class="form-control @error('nivel') is-invalid @enderror" id="nivel" name="nivel">
                                        <option value="">Seleccionar nivel</option>
                                        <option value="principiante">Principiante</option>
                                        <option value="intermedio">Intermedio</option>
                                        <option value="avanzado">Avanzado</option>
                                    </select>
                                    @error('nivel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Imagen del Curso</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Imagen de portada para el curso (opcional)</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="video_url" class="form-label">Video de Introducción (YouTube)</label>
                            <input type="text" class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" name="video_url" value="{{ old('video_url') }}" 
                                   placeholder="Ej: https://www.youtube.com/embed/XXXXXXXXXXX">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Ingresa el código de inserción de YouTube. Ejemplo: <code>&lt;iframe src="https://www.youtube.com/embed/XXXXXXXXXXX" frameborder="0" allowfullscreen&gt;&lt;/iframe&gt;</code>
                            </div>
                        </div>
                        
                        <!-- Eliminar este bloque -->
                        <!--
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" 
                                       {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">
                                    Publicar curso inmediatamente
                                </label>
                            </div>
                        </div>
                        -->
                        
                        <!-- Mantener solo este selector -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado del Curso</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="draft">Borrador</option>
                                <option value="published">Publicado</option>
                            </select>
                            <div class="form-text">Los cursos en borrador no serán visibles para los estudiantes hasta que los publiques.</div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Curso</button>
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
</script>
@endsection