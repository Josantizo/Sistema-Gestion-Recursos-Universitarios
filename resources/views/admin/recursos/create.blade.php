@extends('layouts.app')

@section('title', 'Crear Recurso')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Recurso</h1>
    
    <form method="POST" action="{{ route('admin.recursos.guardar') }}">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nombre del Recurso</label>
            <input type="text" name="nombre" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tipo</label>
            <select name="tipo" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
                <option value="salon">Salón</option>
                <option value="laboratorio">Laboratorio</option>
                <option value="equipo">Equipo</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Ubicación</label>
            <input type="text" name="ubicacion" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Capacidad</label>
            <input type="number" name="capacidad" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500" placeholder="Opcional">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"></textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.recursos') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 transition">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-save"></i> Guardar Recurso
            </button>
        </div>
    </form>
</div>
@endsection