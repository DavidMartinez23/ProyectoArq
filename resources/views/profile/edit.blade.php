@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <h2>Editar Perfil</h2>
    @if(session('status') == 'profile-updated')
        <div style="color: green; margin-bottom: 10px;">Perfil actualizado correctamente.</div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        <div style="margin-bottom: 15px;">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required style="width:100%;padding:8px;color:#222;">
            @error('name')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <div style="margin-bottom: 15px;">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required style="width:100%;padding:8px;color:#222;">
            @error('email')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" style="background: #ff6b00; color: #fff; border: none; padding: 10px 20px; border-radius: 6px;">Guardar cambios</button>
    </form>
</div>
@endsection
