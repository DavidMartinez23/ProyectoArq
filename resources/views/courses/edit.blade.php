@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Curso: {{ $course->title }}</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-8">
            <form method="POST" action="{{ route('teacher.courses.update', $course) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Título del Curso</label>
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
                    <label for="image" class="form-label">Imagen del Curso (opcional)</label>
                    @if($course->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="img-thumbnail" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="form-control" id="image" name="image">
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('teacher.dashboard') }}" class="btn btn-secondary">Volver al Dashboard</a>
                    <button type="submit" class="btn btn-primary">Actualizar Curso</button>
                </div>
            </form>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Módulos del Curso</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('teacher.modules.create', $course) }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus"></i> Agregar Módulo
                    </a>
                    
                    @if($course->modules->count() > 0)
                        <ul class="list-group">
                            @foreach($course->modules->sortBy('order') as $module)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $module->title }}</span>
                                    <div>
                                        <a href="{{ route('teacher.modules.edit', [$course, $module]) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('teacher.modules.destroy', [$course, $module]) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este módulo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No hay módulos en este curso. ¡Agrega el primero!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection