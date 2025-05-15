@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">Solicitar Certificado del Curso: {{ $course->title }}</h2>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <p class="lead">¡Felicidades por tu dedicación! Para generar tu certificado, por favor, completa la siguiente información:</p>
                    
                    <form action="{{ route('certificates.store', $course->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Nombre Completo (como aparecerá en el certificado)</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->name) }}" required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Correo Electrónico (donde se enviará el certificado)</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-certificate me-2"></i>Generar y Enviar Certificado
                            </button>
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-outline-secondary mt-2">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Curso
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection