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
    .content-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .content-card:hover {
        transform: translateY(-5px);
    }
    .content-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .content-card .card-body {
        padding: 15px;
    }
    .content-card h3 {
        margin-top: 0;
        font-size: 18px;
        font-weight: 600;
    }
    .content-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }
    .content-card .btn {
        width: 100%;
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
        <input type="text" class="search-input" placeholder="¿Qué quieres aprender?">
    </div>

    <div class="dashboard-title">Cursos Recomendados</div>
    <div class="content-grid">
        @forelse($courses as $course)
            <div class="content-card" style="background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" style="width:100%;height:180px;object-fit:cover;">
                @else
                    <div style="height: 180px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-book fa-3x text-secondary"></i>
                    </div>
                @endif
                <div class="card-body" style="padding: 15px;">
                    <h3 style="margin-top:0;font-size:18px;font-weight:600;">{{ $course->title }}</h3>
                    <p style="color:#666;font-size:14px;margin-bottom:15px;">{{ Str::limit($course->description, 100) }}</p>
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-primary" style="width:100%;">Ver curso</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info" style="background-color: rgba(255, 255, 255, 0.1); color: #fff; border: none;">
                    No hay cursos disponibles en este momento.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
