@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center text-primary mb-4">Bienvenido a nuestra Plataforma de Cursos</h1>
            <p class="lead text-center">Explora nuestros cursos y comienza tu aprendizaje hoy mismo</p>
        </div>
    </div>

    @auth
        @if(!$hasCheckedIn ?? false)
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Marcar Asistencia</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">Marcar asistencia de hoy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    <div class="row">
        <div class="col-12">
            <h2 class="section-title">Cursos Disponibles</h2>
        </div>
    </div>

    <div class="row">
        @forelse($courses as $course)
        <div class="col-md-4 mb-4">
            <div class="course-card">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-image">
                @else
                    <div class="course-image-placeholder">
                        <i class="fas fa-book-open fa-3x"></i>
                    </div>
                @endif
                <div class="course-content">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-description">{{ Str::limit($course->description, 100) }}</p>
                    <p class="course-teacher">Profesor: {{ $course->user->name }}</p>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">Ver curso</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No hay cursos disponibles en este momento.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection