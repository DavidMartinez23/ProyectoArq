@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Módulo: {{ $module->title }}</h1>
    
    <form action="{{ route('teacher.courses.modules.update', [$course, $module]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Título del módulo</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $module->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content', $module->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="youtube_url" class="form-label">URL de YouTube (opcional)</label>
            <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $module->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
            <small class="form-text text-muted">Pega aquí el enlace del video de YouTube que quieres mostrar en este módulo.</small>
            @error('youtube_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
        <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection