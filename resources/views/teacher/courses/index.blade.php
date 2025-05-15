@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mis Cursos</h1>
    
    <div class="mb-4">
        <a href="{{ route('teacher.courses.create') }}" class="btn btn-success">
            Crear nuevo curso
        </a>
    </div>
    
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
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                    @else
                        <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $course->title }}</h5>
                        <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('teacher.courses.edit', $course) }}" class="btn btn-primary">Editar</a>
                            <form action="{{ route('teacher.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este curso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">
                    No tienes cursos creados. ¡Crea tu primer curso!
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection