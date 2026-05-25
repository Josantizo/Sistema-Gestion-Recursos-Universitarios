@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Registro de Usuario</h1>
        <p class="text-gray-600">Crea tu cuenta</p>
    </div>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nombre</label>
                <input type="text" 
                       name="nombre" 
                       value="{{ old('nombre') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       required>
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Apellido</label>
                <input type="text" 
                       name="apellido" 
                       value="{{ old('apellido') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                       required>
                @error('apellido')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
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
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Contraseña</label>
            <input type="password" 
                   name="contrasena" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                   required>
            @error('contrasena')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Confirmar Contraseña</label>
            <input type="password" 
                   name="contrasena_confirmation" 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                   required>
        </div>
        
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-user-plus"></i> Registrarse
        </button>
    </form>
    
    <div class="text-center mt-4">
        <p class="text-gray-600">
            ¿Ya tienes cuenta? 
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Inicia Sesión</a>
        </p>
    </div>
</div>
@endsection