@extends('layouts.app') {{-- O el layout que estés usando --}}

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h2 class="mb-0">¡Certificado Generado con Éxito!</h2>
                </div>
                <div class="card-body text-center">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="mb-4">
                        <i class="fas fa-award text-success" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h3 class="mb-3">¡Felicidades, {{ $certificate->full_name }}!</h3>
                    
                    <p class="lead mb-4">
                        Has completado exitosamente el curso "<strong>{{ $certificate->course->title }}</strong>".
                    </p>
                    
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Tu certificado ha sido registrado. Si la funcionalidad de envío por correo está activa, lo recibirás en: <strong>{{ $certificate->email }}</strong>.
                    </div>
                    
                    {{-- Aquí podrías agregar un botón para descargar el PDF si implementas esa funcionalidad --}}
                    {{-- <a href="{{ route('certificates.download', $certificate->id) }}" class="btn btn-primary btn-lg mb-3">
                        <i class="fas fa-download me-2"></i>Descargar Certificado (PDF)
                    </a> --}}
                    
                    <div class="d-grid gap-2 col-md-8 mx-auto">
                        <a href="{{ route('courses.show', $certificate->course_id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver al Curso
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-primary"> {{-- Asumiendo que tienes una ruta 'courses.index' --}}
                            <i class="fas fa-graduation-cap me-2"></i>Explorar Más Cursos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection