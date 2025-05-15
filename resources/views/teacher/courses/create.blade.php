@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Curso</h1>
    
    <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Título del curso</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Imagen del curso (opcional)</label>
            <input type="file" class="form-control" id="image" name="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Curso</button>
        <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection