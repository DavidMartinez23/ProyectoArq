@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .search-bar {
        background-color: transparent;
        padding: 0;
        margin-bottom: 30px;
        width: 100%;
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
    .search-input::placeholder {
        color: rgba(102, 102, 102, 0.8);
        font-weight: 300;
    }
    .search-input:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.8);
        background-color: rgba(255, 255, 255, 0.7);
    }
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #fff;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 10px;
    }
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .search-bar {
            padding: 10px 8px;
        }
        .dashboard-title {
            font-size: 1.1rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="search-bar">
        <input type="text" class="search-input" id="courseSearch" placeholder="¿Qué quieres aprender?">
    </div>

    <div class="dashboard-title">Cursos Disponibles</div>
    <div class="content-grid" id="coursesGrid">
        @forelse($courses as $course)
            <div class="teacher-course-card" data-title="{{ strtolower($course->title) }}">
                <div class="course-image">
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                </div>
                <div class="course-content">
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-teacher">Profesor: {{ $course->teacher->name }}</p>
                    <p class="course-description">{{ Str::limit($course->description, 100) }}</p>
                    <div class="course-actions">
                        <a href="{{ route('courses.show', $course) }}" class="btn-view">Ver Curso</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-courses">
                <p>No hay cursos disponibles en este momento.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .teacher-course-card {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .teacher-course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .course-image {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .teacher-course-card:hover .course-image img {
        transform: scale(1.05);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.2);
    }

    .no-image i {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .course-content {
        padding: 1.5rem;
    }

    .course-content .course-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 0 1rem 0;
    }

    .course-content .course-description {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        min-height: 3rem;
    }

    .course-actions {
        display: flex;
        justify-content: center;
    }

    .course-teacher {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .btn-view {
        width: 100%;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        background: #ff6b00;
        color: #fff;
        border: none;
    }

    .btn-view:hover {
        background: #ff8533;
        transform: translateY(-2px);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('courseSearch');
    const courseCards = document.querySelectorAll('.teacher-course-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let hasVisibleCourses = false;

        courseCards.forEach(card => {
            const title = card.getAttribute('data-title');
            if (title.includes(searchTerm)) {
                card.style.display = 'block';
                hasVisibleCourses = true;
            } else {
                card.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay resultados
        const noCoursesMessage = document.querySelector('.no-courses');
        if (noCoursesMessage) {
            noCoursesMessage.style.display = hasVisibleCourses ? 'none' : 'block';
        }
    });
});
</script>
@endsection