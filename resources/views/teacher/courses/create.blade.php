@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="dashboard-title">Crear Nuevo Curso</h2>
    
    <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data" class="course-form">
        @csrf
        
        <div class="form-group mb-4">
            <label for="title" class="form-label">Título del Curso</label>
            <input type="text" class="form-input" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group mb-4">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-input" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="category" class="form-label">Categoría</label>
            <select class="form-select" id="category" name="category" required>
                <option value="">Seleccionar categoría</option>
                <option value="programacion">Programación</option>
                <option value="diseno">Diseño</option>
                <option value="marketing">Marketing</option>
            </select>
        </div>

        <div class="form-group mb-4">
            <label for="level" class="form-label">Nivel</label>
            <select class="form-select" id="level" name="level" required>
                <option value="">Seleccionar nivel</option>
                <option value="principiante">Principiante</option>
                <option value="intermedio">Intermedio</option>
                <option value="avanzado">Avanzado</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="image" class="form-label">Imagen del Curso</label>
            <input type="file" class="form-input" id="image" name="image">
            <small class="text-muted">Imagen de portada para el curso (opcional)</small>
        </div>
        
        <div class="button-group">
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Crear Curso</button>
        </div>
    </form>
</div>

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 10px;
    }

    .course-form {
        background: rgba(255, 255, 255, 0.1);
        padding: 2rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #fff;
        font-weight: 500;
        font-size: 1rem;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.9);
        border-radius: 8px;
        font-size: 1rem;
        color: #333;
        transition: all 0.3s ease;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #ff6b00;
        box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2);
    }

    .file-input {
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
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

    .button-group {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #ff6b00;
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background-color: #ff8533;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }

    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
</style>
@endsection