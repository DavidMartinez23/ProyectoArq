@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('teacher.dashboard') }}" class="list-group-item list-group-item-action active">
                Panel de Profesor
            </a>
            <a href="{{ route('teacher.courses.create') }}" class="list-group-item list-group-item-action">
                Crear Curso
            </a>
            <a href="{{ route('teacher.dashboard') }}" class="list-group-item list-group-item-action">
                Mis Cursos
            </a>
            <!-- Agrega más enlaces si lo deseas -->
        </div>
    </div>
    <div class="col-md-9">
        <h1>Panel de Profesor</h1>
        
        <div class="mb-4">
            <a href="{{ route('teacher.courses.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Crear Nuevo Curso
            </a>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Mis Cursos</h5>
            </div>
            <div class="card-body">
                @if($courses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Módulos</th>
                                    <th>Comentarios</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ $course->modules->count() }}</td>
                                        <td>{{ $course->comments->count() }}</td>
                                        <td>
                                            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este curso?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No has creado ningún curso todavía. ¡Crea tu primer curso!
                    </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-light">
                    <h3 class="mb-0">{{ $course->title }}</h3>
                </div>
                <div class="card-body">
                    {{-- Cambiamos esta condición para que sea más robusta --}}
                    @if(optional($course->certificates)->isEmpty() ?? true)
                        <p class="text-muted">Ningún estudiante ha solicitado un certificado para este curso todavía.</p>
                    @else
                        <h5 class="card-subtitle mb-2 text-muted">Estudiantes que han solicitado certificado:</h5>
                        <ul class="list-group list-group-flush">
                            @foreach($course->certificates as $certificate)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $certificate->full_name }}</strong><br>
                                        <small class="text-muted">Email: {{ $certificate->email }}</small>
                                    </div>
                                    <span class="badge bg-secondary rounded-pill">
                                        Solicitado el: {{ $certificate->issued_at->format('d/m/Y H:i') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection