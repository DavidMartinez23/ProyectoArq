@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="header-section">
        <h2 class="page-title">Mis Cursos</h2>
        <div class="title-underline"></div>
    </div>

    <div class="search-container">
        <input type="text" 
               class="search-input" 
               placeholder="Buscar en mis cursos"
               id="searchInput">
    </div>
    
    <div class="courses-grid" id="coursesContainer">
        @php
            $activeCourses = $courses->filter(function($course) {
                $completedModulesCount = $course->modules()
                    ->whereHas('completedByUsers', function($query) {
                        $query->where('user_id', Auth::id());
                    })
                    ->count();
                return $completedModulesCount > 0;
            });
        @endphp

        @if($activeCourses->count() > 0)
            @foreach($activeCourses as $course)
                <div class="course-card" data-title="{{ $course->title }}">
                    <div class="course-content">
                        @if($course->image)
                            <div class="course-image">
                                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                            </div>
                        @else
                            <div class="course-image no-image">
                                <i class="fas fa-book"></i>
                            </div>
                        @endif
                        <div class="course-info">
                            <h3 class="course-title">{{ $course->title }}</h3>
                            <p class="course-description">{{ Str::limit($course->description, 100) }}</p>
                            <p class="course-teacher">
                                Profesor: {{ $course->teacher ? $course->teacher->name : 'No asignado' }}
                            </p>
                            
                            <!-- Progreso del curso -->
                            <div class="course-progress">
                                @php
                                    $completedModules = $course->modules()
                                        ->whereHas('completedByUsers', function($query) {
                                            $query->where('user_id', Auth::id());
                                        })
                                        ->count();
                                    $totalModules = $course->modules()->count();
                                    $progressPercentage = ($totalModules > 0) ? ($completedModules / $totalModules) * 100 : 0;
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar" 
                                         style="width: {{ $progressPercentage }}%">
                                    </div>
                                </div>
                                <span class="progress-text">
                                    {{ $completedModules }}/{{ $totalModules }} Módulos completados
                                </span>
                            </div>

                            <a href="{{ route('courses.show', $course) }}" class="btn-view">Continuar Curso</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-courses">
                <div class="alert-message">
                    No has comenzado ningún curso aún. ¡Explora los cursos disponibles en el inicio!
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .header-section {
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        padding-bottom: 0.5rem;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 500;
        color: #fff;
        margin: 0;
        padding: 0.5rem 0;
    }

    .title-underline {
        width: 50px;
        height: 3px;
        background-color: #ff6b00;
        margin-top: 0.5rem;
    }

    .search-container {
        max-width: 800px;
        margin: 0 auto 2rem;
    }

    .search-input {
        width: 100%;
        padding: 12px 20px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        background-color: rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        font-size: 16px;
        color: #333;
        font-weight: 400;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 2rem;
    }

    .course-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
    }

    .course-image {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-info {
        padding: 1.5rem;
    }

    .course-title {
        color: #333;
        font-size: 1.4rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .course-description {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .course-teacher {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .btn-view {
        display: inline-block;
        background: #ff6b00;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
    }

    .btn-view:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }

    .no-courses {
        grid-column: 1 / -1;
        text-align: center;
        padding: 2rem;
    }

    .alert-message {
        background: rgba(255, 255, 255, 0.9);
        padding: 1rem 2rem;
        border-radius: 8px;
        color: #666;
    }

    .no-image {
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .no-image i {
        font-size: 3rem;
        color: #999;
    }

    .course-progress {
        margin: 1rem 0;
    }

    .progress {
        width: 100%;
        height: 8px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-bar {
        height: 100%;
        background: #ff6b00;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .progress-text {
        font-size: 0.85rem;
        color: #666;
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