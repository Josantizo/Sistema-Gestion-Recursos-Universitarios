@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Iniciar Sesión</h1>
        <p class="text-gray-600">Accede a tu cuenta</p>
    </div>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Correo Electrónico</label>
            <input type="email" 
                   name="correo" 
                   value="{{ old('correo') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                   required>
            @error('correo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Contraseña</label>
            <input type="password" 
                   name="contrasena" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                   required>
            @error('contrasena')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
        </button>
    </form>
    
    <div class="text-center mt-4">
        <p class="text-gray-600">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</div>
@endsection