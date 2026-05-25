@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Usuario</h1>
    
    <form method="POST" action="{{ route('admin.usuarios.guardar') }}">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Apellido</label>
                <input type="text" name="apellido" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Correo Electrónico</label>
            <input type="email" name="correo" class="w-full border rounded px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Contraseña</label>
            <input type="password" name="contrasena" class="w-full border rounded px-3 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Rol</label>
            <select name="rol" class="w-full border rounded px-3 py-2">
                <option value="estudiante">Estudiante</option>
                <option value="docente">Docente</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Guardar Usuario
            </button>
        </div>
    </form>
</div>
@endsection