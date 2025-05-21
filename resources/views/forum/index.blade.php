@extends('layouts.app')

@section('content')
<style>
    /* Importar fuentes personalizadas */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Montserrat:wght@400;600&display=swap');

    /* Estilos para el encabezado del foro */
    .forum-header {
        position: relative;
        width: 100%;
        height: 180px;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #1a237e, #0d47a1);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .forum-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
        padding: 0;
        text-align: center;
        z-index: 2;
    }

    .forum-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 0.5rem;
        text-align: center;
        z-index: 2;
    }

    .forum-pattern {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.1;
    }

    /* Estilos para comentarios de profesores */
    .teacher-comment {
        background: linear-gradient(to right, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.02)) !important;
        border-left: 4px solid #ff6b00 !important;
        box-shadow: 0 4px 6px rgba(255, 107, 0, 0.1) !important;
        position: relative;
        overflow: hidden;
    }

    .teacher-comment::before {
        content: '👨‍🏫';
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 24px;
        opacity: 0.1;
        transform: rotate(15deg);
    }

    /* Estilos para comentarios de estudiantes */
    .student-comment {
        background: linear-gradient(to right, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.02)) !important;
        border-left: 4px solid #10B981 !important;
        position: relative;
        overflow: hidden;
    }

    .student-comment::before {
        content: '👨‍🎓';
        position: absolute;
        top: -5px;
        right: -5px;
        font-size: 24px;
        opacity: 0.1;
        transform: rotate(15deg);
    }

    /* Estilos para respuestas */
    .teacher-reply {
        background: rgba(255, 107, 0, 0.05) !important;
        border-left: 3px solid #ff6b00 !important;
    }

    .student-reply {
        background: rgba(16, 185, 129, 0.05) !important;
        border-left: 3px solid #10B981 !important;
    }

    /* Estilos para etiquetas de rol */
    .role-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-left: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .role-badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    }

    .role-teacher {
        background: linear-gradient(135deg, #ff6b00, #ff8533);
        color: white;
    }

    .role-student {
        background: linear-gradient(135deg, #10B981, #34D399);
        color: white;
    }

    /* Animaciones para likes */
    @keyframes likeAnimation {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .like-button:active svg {
        animation: likeAnimation 0.3s ease;
    }

    /* Estilo para comentarios fijados */
    .pinned-comment {
        position: relative;
        border: 2px solid #ff6b00;
        background: rgba(255, 107, 0, 0.05);
    }

    .pinned-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #ff6b00, #ff8533);
        color: white;
        padding: 0.35rem 1rem;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    /* Mejoras en la interactividad */
    .comment-actions button {
        transition: all 0.2s ease;
    }

    .comment-actions button:hover {
        transform: translateY(-1px);
    }

    /* Estilo para el contador de respuestas */
    .reply-count {
        font-size: 0.85rem;
        color: #666;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reply-count::before {
        content: '';
        display: block;
        width: 4px;
        height: 4px;
        background-color: #666;
        border-radius: 50%;
    }

    /* Estilo para las fechas */
    .comment-date {
        font-size: 0.85rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .comment-date svg {
        width: 16px;
        height: 16px;
    }

    /* Estilos para el formulario de comentarios */
    .comment-form {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .comment-form:focus-within {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .comment-textarea {
        resize: none;
        transition: all 0.3s ease;
    }

    .comment-textarea:focus {
        border-color: #ff6b00;
    }
</style>

<div class="container mx-auto px-4 py-8">
    <!-- Encabezado del foro -->
    <div class="forum-header">
        <div class="forum-pattern"></div>
        <h1 class="forum-title">Foro de Discusión</h1>
        <p class="forum-subtitle">Comparte y aprende con la comunidad</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        @auth
            <form action="{{ route('forum.store') }}" method="POST" class="comment-form mb-8 p-4">
                @csrf
                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Tu comentario:
                    </label>
                    <textarea 
                        name="content" 
                        id="content" 
                        rows="4" 
                        class="comment-textarea shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline transition duration-200"
                        required
                        placeholder="¿Qué quieres compartir con la comunidad?"
                    ></textarea>
                </div>
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Publicar Comentario
                </button>
            </form>
        @else
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 mb-8">
                <p class="text-gray-600 dark:text-gray-400 text-center">
                    Para participar en el foro, por favor 
                    <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-semibold transition duration-200">inicia sesión</a>
                </p>
            </div>
        @endauth

        <div class="space-y-6 mt-6">
            @foreach($comments as $comment)
                @if(!$comment->parent_id)
                    <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 {{ $comment->user->role === 'teacher' ? 'teacher-comment' : 'student-comment' }} {{ $comment->is_pinned ? 'pinned-comment' : '' }}">
                        @if($comment->is_pinned)
                            <div class="pinned-badge">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                Fijado
                            </div>
                        @endif

                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200 text-lg">
                                        {{ $comment->user->name }}
                                    </p>
                                    @if($comment->user->role === 'teacher')
                                        <span class="role-badge role-teacher">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                            </svg>
                                            Profesor
                                        </span>
                                    @else
                                        <span class="role-badge role-student">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                            </svg>
                                            Estudiante
                                        </span>
                                    @endif
                                </div>
                                <p class="comment-date">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $comment->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @auth
                                <div class="flex items-center space-x-4 comment-actions">
                                    <form action="{{ route('forum.like', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="like-button flex items-center space-x-1 text-gray-500 hover:text-orange-500 transition duration-200">
                                            <span class="font-semibold">{{ $comment->likes_count }}</span>
                                            <svg class="w-6 h-6 {{ $comment->isLikedBy(Auth::user()) ? 'text-orange-500' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                            </svg>
                                        </button>
                                    </form>

                                    <button onclick="toggleReplyForm('reply-form-{{ $comment->id }}')" class="flex items-center space-x-2 text-gray-500 hover:text-orange-500 transition duration-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        <span>Responder</span>
                                    </button>

                                    @if(Auth::id() === $comment->user_id || Auth::user()->role === 'teacher')
                                        @if(Auth::user()->role === 'teacher')
                                            <form action="{{ route('forum.pin', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="flex items-center space-x-1 text-gray-500 hover:text-orange-500 transition duration-200" title="{{ $comment->is_pinned ? 'Desfijar comentario' : 'Fijar comentario' }}">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('forum.destroy', $comment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?')" class="flex items-center space-x-2 text-red-500 hover:text-red-700 transition duration-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span>Eliminar</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                        </div>

                        <p class="mt-4 text-gray-700 dark:text-gray-300 whitespace-pre-line text-lg">{{ $comment->content }}</p>

                        @if($comment->replies->count() > 0)
                            <p class="reply-count mt-4">
                                {{ $comment->replies->count() }} {{ Str::plural('respuesta', $comment->replies->count()) }}
                            </p>
                        @endif

                        <!-- Formulario de respuesta -->
                        <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
                            <form action="{{ route('forum.reply', $comment) }}" method="POST" class="space-y-4">
                                @csrf
                                <textarea 
                                    name="content" 
                                    rows="2" 
                                    class="comment-textarea shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline transition duration-200"
                                    required
                                    placeholder="Escribe tu respuesta..."
                                ></textarea>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-300 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        Enviar Respuesta
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Respuestas -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-6 space-y-4 pl-8 border-l-2 border-gray-200">
                                @foreach($comment->replies as $reply)
                                    <div class="bg-white dark:bg-gray-600 p-4 rounded-lg shadow-sm {{ $reply->user->role === 'teacher' ? 'teacher-reply' : 'student-reply' }}">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="flex items-center">
                                                    <p class="font-semibold text-gray-800 dark:text-gray-200">
                                                        {{ $reply->user->name }}
                                                    </p>
                                                    @if($reply->user->role === 'teacher')
                                                        <span class="role-badge role-teacher">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                                                            </svg>
                                                            Profesor
                                                        </span>
                                                    @else
                                                        <span class="role-badge role-student">
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                                                            </svg>
                                                            Estudiante
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="comment-date">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $reply->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            @auth
                                                @if(Auth::id() === $reply->user_id || Auth::user()->role === 'teacher')
                                                    <form action="{{ route('forum.destroy', $reply) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar esta respuesta?')" class="flex items-center space-x-2 text-red-500 hover:text-red-700 transition duration-200">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                            <span>Eliminar</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="mt-2 text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
// Prevenir que los formularios redirijan la página
document.addEventListener('DOMContentLoaded', function() {
    // Prevenir redirección en formularios de like
    const likeForms = document.querySelectorAll('form[action*="forum.like"]');
    likeForms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                if (response.ok) {
                    const data = await response.json();
                    const likeCount = form.querySelector('span');
                    if (likeCount) likeCount.textContent = data.likes_count;
                    const likeButton = form.querySelector('svg');
                    if (likeButton) {
                        likeButton.classList.toggle('text-orange-500');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    // Prevenir redirección en botón de fijar
    const pinForms = document.querySelectorAll('form[action*="forum.pin"]');
    pinForms.forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});

function toggleReplyForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            const textarea = form.querySelector('textarea');
            if (textarea) {
                textarea.focus();
            }
        }
    }
}
</script>
@endpush
@endsection