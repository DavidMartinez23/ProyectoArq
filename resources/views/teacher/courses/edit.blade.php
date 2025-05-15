@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Curso: {{ $course->title }}</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('teacher.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Título del curso</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen del curso (opcional)</label>
                    @if($course->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Actualizar Curso</button>
                <a href="{{ route('teacher.courses.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
    
    <hr>
    
    <h2>Módulos del Curso</h2>
    <div class="mb-3">
        <a href="{{ route('teacher.courses.modules.create', $course) }}" class="btn btn-success">
            Agregar Nuevo Módulo
        </a>
    </div>
    
    @if($course->modules->count() > 0)
        <div class="list-group">
            @foreach($course->modules as $module)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>{{ $module->title }}</h5>
                        <div>
                            <a href="{{ route('teacher.courses.modules.edit', [$course, $module]) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('teacher.courses.modules.destroy', [$course, $module]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este módulo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    <p>{{ Str::limit($module->content, 150) }}</p>
                    @if($module->youtube_url)
                        <div class="mt-2">
                            <strong>Video:</strong> <a href="{{ $module->youtube_url }}" target="_blank">{{ $module->youtube_url }}</a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Este curso no tiene módulos. ¡Agrega tu primer módulo!
        </div>
    @endif
</div>
@endsection