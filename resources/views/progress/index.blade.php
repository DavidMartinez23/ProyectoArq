@extends('layouts.app')

@section('content')
<div class="progress-dashboard-container">
    <div class="header-section">
        <h2 class="page-title">Mi Progreso</h2>
        <div class="title-underline"></div>
    </div>

    <!-- Resumen General -->
    <div class="summary-section">
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-book"></i>
                <div class="stat-info">
                    <h3>Cursos Activos</h3>
                    <span class="stat-number">{{ $activeCourses }}</span>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <div class="stat-info">
                    <h3>Tiempo en Sesión</h3>
                    <span class="stat-number" id="sessionTime">0h 0m</span>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-graduation-cap"></i>
                <div class="stat-info">
                    <h3>Cursos Completados</h3>
                    <span class="stat-number">{{ $completedCourses }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfica de Progreso -->
    <div class="progress-chart-section">
        <h2>Progreso Diario</h2>
        <canvas id="progressChart"></canvas>
    </div>

    <!-- Lista de Cursos -->
    <div class="courses-progress-section">
        <h2>Mis Cursos en Progreso</h2>
        <div class="courses-grid">
            @foreach($courseProgress as $progress)
            <div class="course-progress-card" data-start-time="{{ now() }}">
                <div class="course-header">
                    @if($progress->course->image)
                        <img src="{{ asset('storage/' . $progress->course->image) }}" alt="{{ $progress->course->title }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                    <h3>{{ $progress->course->title }}</h3>
                </div>
                <div class="progress-info">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $progress->progress_percentage }}%"></div>
                    </div>
                    <span class="progress-text">{{ $progress->progress_percentage }}% Completado</span>
                </div>
                <div class="course-stats">
                    <div class="stat">
                        <i class="fas fa-layer-group"></i>
                        <span>{{ $progress->completed_modules }}/{{ $progress->course->modules->count() }} Módulos</span>
                    </div>
                    <div class="stat">
                        <i class="fas fa-clock"></i>
                        <span class="course-time">0h 0m</span>
                    </div>
                </div>
                <a href="{{ route('courses.show', $progress->course) }}" class="btn-continue">
                    Continuar Curso
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.progress-dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.main-title {
    font-size: 2rem;
    color: #fff;
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    backdrop-filter: blur(10px);
}

.stat-card i {
    font-size: 2rem;
    color: #ff6b00;
}

.stat-info h3 {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.stat-number {
    color: #fff;
    font-size: 1.5rem;
    font-weight: 600;
}

.progress-chart-section {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 3rem;
    backdrop-filter: blur(10px);
}

.progress-chart-section h2 {
    color: #fff;
    margin-bottom: 1.5rem;
}

.courses-progress-section h2 {
    color: #fff;
    margin-bottom: 1.5rem;
}

.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.course-progress-card {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    overflow: hidden;
    backdrop-filter: blur(10px);
}

.course-header {
    position: relative;
    height: 150px;
    overflow: hidden;
}

.course-header img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.course-header h3 {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 1rem;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
    color: #fff;
    margin: 0;
}

.progress-info {
    padding: 1rem;
}

.progress-bar {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    height: 8px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    background: #ff6b00;
    height: 100%;
    border-radius: 20px;
}

.progress-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
}

.course-stats {
    display: flex;
    justify-content: space-around;
    padding: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.stat {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255, 255, 255, 0.8);
}

.btn-continue {
    display: block;
    background: #ff6b00;
    color: white;
    text-align: center;
    padding: 1rem;
    text-decoration: none;
    transition: background 0.3s ease;
}

.btn-continue:hover {
    background: #ff8533;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($progressDates) !!},
            datasets: [{
                label: 'Progreso Diario',
                data: {!! json_encode($progressData) !!},
                borderColor: '#ff6b00',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(255, 107, 0, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.8)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.8)'
                    }
                }
            }
        }
    });
});

// Contador de tiempo de sesión
let sessionStartTime = new Date();

function updateTimes() {
    // Actualizar tiempo de sesión
    let currentTime = new Date();
    let diff = Math.floor((currentTime - sessionStartTime) / 1000 / 60); // diferencia en minutos
    let hours = Math.floor(diff / 60);
    let minutes = diff % 60;
    document.getElementById('sessionTime').textContent = `${hours}h ${minutes}m`;

    // Actualizar tiempo por curso
    document.querySelectorAll('.course-progress-card').forEach(card => {
        let startTime = new Date(card.dataset.startTime);
        let courseDiff = Math.floor((currentTime - startTime) / 1000 / 60);
        let courseHours = Math.floor(courseDiff / 60);
        let courseMinutes = courseDiff % 60;
        card.querySelector('.course-time').textContent = `${courseHours}h ${courseMinutes}m`;
    });
}

// Actualizar cada minuto
setInterval(updateTimes, 60000);
// Primera actualización inmediata
updateTimes();

// Guardar tiempo cuando el usuario sale de la página
window.addEventListener('beforeunload', function() {
    localStorage.setItem('lastSessionTime', new Date().getTime());
});
</script>
@endpush
@endsection