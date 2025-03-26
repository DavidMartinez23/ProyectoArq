@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mt-10">Bienvenido a la plataforma</h1>

        <div class="flex justify-center mt-10">
            <div class="bg-white p-6 rounded-lg shadow-md text-center w-96">
                <h2 class="text-lg font-semibold">Registro de Asistencia</h2>
                
                @if(session('success'))
                    <p class="text-green-500 mt-2">{{ session('success') }}</p>
                @endif

                @if(!$hasCheckedIn)
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                            Marcar Asistencia
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 mt-4">Ya has marcado asistencia hoy.</p>
                @endif
            </div>
        </div>
    </div>
@endsection