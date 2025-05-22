@extends('layouts.app')

@section('content')
    <div class="content-section">
        <h2 class="section-title">Mis Certificados</h2>
        
        <div class="certificates-grid">
            @forelse($certificates as $certificate)
                <div class="certificate-card">
                    <div class="certificate-image">
                        <img src="{{ asset('images/certificate-icon.png') }}" alt="Certificado" class="course-thumbnail">
                    </div>
                    <div class="certificate-content">
                        <h3>{{ $certificate->course->title }}</h3>
                        <p class="teacher">Profesor: {{ $certificate->course->teacher->name }}</p>
                        <p class="description">{{ Str::limit($certificate->course->description, 100) }}</p>
                        
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-certificate empty-icon"></i>
                    <p>Aún no tienes certificados</p>
                    <a href="{{ route('courses.index') }}" class="btn-primary">Explorar Cursos</a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .main-container {
        padding: 2rem;
        margin-left: 250px;
    }

    .search-bar {
        margin-bottom: 2rem;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
    }

    .section-title {
        color: #ffffff !important; /* <- Color blanco forzado */
        font-size: 1.8rem;
        margin-bottom: 2rem;
    }

    .certificates-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .certificate-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .certificate-card:hover {
        transform: translateY(-5px);
    }

    .certificate-image {
        width: 100%;
        height: 160px;
        background: #4a4a4a;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .course-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .certificate-content {
        padding: 1.5rem;
    }

    .certificate-content h3 {
        color: #ff6b00;
        font-size: 1.2rem;
        margin: 0 0 0.5rem 0;
    }

    .teacher {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        line-height: 1.4;
    }

    .btn-primary {
        display: inline-block;
        background: #ff6b00;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .btn-primary:hover {
        background: #ff8533;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem;
        color: rgba(255, 255, 255, 0.6);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #ff6b00;
    }

    @media (max-width: 768px) {
        .main-container {
            margin-left: 0;
            padding: 1rem;
        }

        .certificates-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
