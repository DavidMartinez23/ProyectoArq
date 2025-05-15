@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Módulo: {{ $module->title }}</h1>
    
    <form method="POST" action="{{ route('teacher.modules.update', [$course, $module]) }}">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="title" class="form-label">Título del Módulo</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $module->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $module->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="youtube_url" class="form-label">URL de YouTube</label>
            <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $module->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
            <small class="text-muted">Pega el enlace completo del video de YouTube</small>
            @error('youtube_url')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        @if($module->youtube_url)
            <div class="mb-3">
                <label class="form-label">Vista previa del video</label>
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $module->youtube_embed }}" title="{{ $module->title }}" allowfullscreen></iframe>
                </div>
            </div>
        @endif
        
        <div class="mb-3">
            <label for="order" class="form-label">Orden</label>
            <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $module->order) }}" min="1">
            @error('order')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-secondary">Volver al Curso</a>
            <button type="submit" class="btn btn-primary">Actualizar Módulo</button>
        </div>
    </form>
</div>
@endsection