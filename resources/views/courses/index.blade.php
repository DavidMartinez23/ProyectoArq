@extends('layouts.app')

@section('content')
<div class="container">
    <div class="search-container mb-4">
        <input type="text" 
               class="form-control search-input" 
               placeholder="¿Qué quieres aprender?"
               id="searchInput">
    </div>

    <h1>Cursos Disponibles</h1>
    
    <div class="row" id="coursesContainer">
        @if($courses->count() > 0)
            @foreach($courses as $course)
                <div class="col-md-4 mb-4 course-card" data-title="{{ $course->title }}">
                    <div class="card h-100">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" class="card-img-top" alt="{{ $course->title }}">
                        @else
                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-book fa-3x"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text">{{ Str::limit($course->description, 100) }}</p>
                            <p class="card-text text-muted mt-auto">
                                <small>Profesor: {{ $course->teacher ? $course->teacher->name : 'No asignado' }}</small>
                            </p>
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-primary mt-auto">Ver Curso</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    No hay cursos disponibles en este momento.
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .search-container {
        position: relative;
        max-width: 800px;
        margin: 0 auto 2rem;
    }

    .search-input {
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid rgba(255, 107, 0, 0.3);
        color: #fff;
        padding: 1rem;
        border-radius: 25px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #ff6b00;
        box-shadow: 0 0 15px rgba(255, 107, 0, 0.2);
        background: rgba(255, 255, 255, 0.15);
    }

    .btn-search {
        background: #ff6b00;
        color: white;
        border: none;
        border-radius: 0 25px 25px 0;
        padding: 0 1.5rem;
        transition: background 0.3s ease;
    }

    .btn-search:hover {
        background: #ff8533;
    }

    .card {
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        color: #ff6b00;
        font-weight: 600;
    }

    .card-text {
        color: rgba(255, 255, 255, 0.8);
    }

    .btn-primary {
        background-color: #ff6b00;
        border: none;
        padding: 0.5rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #ff8533;
        transform: translateY(-2px);
    }

    h1 {
        color: #ffffff;
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 600;
    }

    .alert-info {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        color: #ffffff;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .course-card {
        transition: all 0.3s ease;
        opacity: 1;
        transform: scale(1);
    }

    .course-card.hidden {
        opacity: 0;
        transform: scale(0.8);
        pointer-events: none;
    }

    .no-results {
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
    }

    .no-results.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.course-card');
        
        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase().trim();
            let visibleCount = 0;
    
            cards.forEach(card => {
                const cardTitle = card.querySelector('.card-title').textContent.toLowerCase().trim();
                
                if (searchText === '' || cardTitle.includes(searchText)) {
                    card.classList.remove('hidden');
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
    
            // Actualizar mensaje de no resultados
            const noResultsDiv = document.querySelector('.alert-info');
            if (noResultsDiv) {
                if (visibleCount === 0 && searchText !== '') {
                    noResultsDiv.style.display = 'block';
                } else {
                    noResultsDiv.style.display = 'none';
                }
            }
        });
    });
    </script>
    @endsection