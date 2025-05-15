@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $course->title }}</h1>
            <p class="text-muted">Profesor: {{ $course->user->name }}</p>
            
            <div class="mb-4">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="img-fluid rounded">
                @endif
            </div>
            
            <div class="mb-4">
                <h3>Descripción del Curso</h3>
                <p>{{ $course->description }}</p>
            </div>
            
            <div class="mb-4">
                <h3>Módulos</h3>
                @if($course->modules->count() > 0)
                    <div class="accordion" id="moduleAccordion">
                        @foreach($course->modules as $index => $module)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $module->id }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $module->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $module->id }}">
                                        {{ $module->title }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $module->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $module->id }}" data-bs-parent="#moduleAccordion">
                                    <div class="accordion-body">
                                        @if($module->youtube_url)
                                            <div class="ratio ratio-16x9 mb-3">
                                                <iframe src="{{ $module->youtubeEmbed }}" title="{{ $module->title }}" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                        <div>
                                            {!! nl2br(e($module->content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        Este curso aún no tiene módulos disponibles.
                    </div>
                @endif
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Comentarios</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('comments.store', $course) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-3">
                            <textarea class="form-control" name="content" rows="3" placeholder="Escribe un comentario..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                    
                    <hr>
                    
                    <div class="comments-section" style="max-height: 500px; overflow-y: auto;">
                        @forelse($course->comments as $comment)
                            <div class="comment mb-