@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="header-section">
        <h2 class="page-title">Panel de Profesor</h2>
        <div class="title-underline"></div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="edit-course-container">
        <div class="course-form-section">
            <form method="POST" action="{{ route('teacher.courses.update', $course) }}" enctype="multipart/form-data" class="course-form">
                @csrf
                @method('PUT')
                
                <div class="form-section">
                    <label for="title" class="form-label">Título del Curso</label>
                    <input type="text" class="form-input @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $course->title) }}" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-input @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-section">
                    <label for="image" class="form-label">Imagen del Curso</label>
                    @if($course->image)
                        <div class="current-image">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                        </div>
                    @endif
                    <input type="file" class="form-input file-input @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <span class="help-text">Imagen de portada para el curso (opcional)</span>
                    @error('image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="button-group">
                    <a href="{{ route('teacher.dashboard') }}" class="btn-secondary">Volver al Dashboard</a>
                    <button type="submit" class="btn-primary">Actualizar Curso</button>
                </div>
            </form>

            <form action="{{ route('teacher.courses.destroy', $course) }}" 
                  method="POST" 
                  class="delete-form"
                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este curso? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash"></i> Eliminar Curso
                </button>
            </form>
        </div>
        
        <div class="modules-section">
            <div class="modules-card">
                <div class="modules-header">
                    <h3 class="modules-title">Módulos del Curso</h3>
                </div>
                <div class="modules-body">
                    <a href="{{ route('teacher.modules.create', $course) }}" class="btn-add-module">
                        <i class="fas fa-plus"></i> Agregar Módulo
                    </a>
                    
                    @if($course->modules->count() > 0)
                        <ul class="modules-list">
                            @foreach($course->modules->sortBy('order') as $module)
                                <li class="module-item">
                                    <span class="module-title">{{ $module->title }}</span>
                                    <div class="module-actions">
                                        <a href="{{ route('teacher.modules.edit', [$course, $module]) }}" class="btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('teacher.modules.destroy', [$course, $module]) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('¿Estás seguro de eliminar este módulo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="no-modules">No hay módulos en este curso. ¡Agrega el primero!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-wrapper {
        min-height: calc(100vh - 64px);
        margin-top: 64px;
        padding: 2rem;
        background: transparent;
        color: #fff;
    }

    body {
        background: linear-gradient(135deg, #181e29 0%, #ff6b00 100%);
        min-height: 100vh;
    }

    .header-section {
        max-width: 1200px;
        margin: 0 auto 2rem auto;
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

    .edit-course-container {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .course-form-section {
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
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

    .current-image {
        margin-bottom: 1rem;
    }

    .course-image {
        max-width: 100%;
        max-height: 300px; /* Limitamos la altura máxima */
        width: auto;
        height: auto;
        object-fit: contain; /* Mantiene la proporción sin distorsionar */
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: block;
        margin: 0 auto;
    }

    .current-image {
        margin-bottom: 1rem;
        text-align: center;
        background: rgba(0, 0, 0, 0.2);
        padding: 1rem;
        border-radius: 8px;
    }

    .file-input {
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        border: 2px dashed rgba(255, 255, 255, 0.2);
    }

    .help-text {
        display: block;
        margin-top: 0.25rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
    }

    .error-message {
        color: #ff4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .modules-section {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .modules-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modules-title {
        color: #fff;
        font-size: 1.4rem;
        margin: 0;
    }

    .modules-body {
        padding: 1.5rem;
    }

    .btn-add-module {
        display: inline-block;
        background: #ff6b00;
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-add-module:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }

    .modules-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .module-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .module-title {
        color: #fff;
        font-weight: 500;
    }

    .module-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-edit, .btn-delete {
        padding: 0.5rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-edit {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-delete {
        background: rgba(255, 0, 0, 0.2);
        color: #fff;
    }

    .btn-edit:hover, .btn-delete:hover {
        transform: translateY(-2px);
    }

    .no-modules {
        color: rgba(255, 255, 255, 0.7);
        text-align: center;
        font-style: italic;
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-primary, .btn-secondary {
        padding: 0.75rem 2.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
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

    @media (max-width: 768px) {
        .edit-course-container {
            grid-template-columns: 1fr;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            text-align: center;
        }
    }
    .delete-form {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }
</style>
@endsection