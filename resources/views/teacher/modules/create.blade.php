@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Módulo a: {{ $course->title }}</h1>
    
    <form action="{{ route('teacher.courses.modules.store', $course) }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Título del módulo</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="youtube_url" class="form-label">URL de YouTube (opcional)</label>
            <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=...">
            <small class="form-text text-muted">Pega aquí el enlace del video de YouTube que quieres mostrar en este módulo.</small>
            @error('youtube_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar Módulo</button>
        <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection