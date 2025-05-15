@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cursos Disponibles</h1>
    
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
                        <p class="card-text"><small class="text-muted">Profesor: {{ $course->user->name }}</small></p>
                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary">Ver Curso</a>
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