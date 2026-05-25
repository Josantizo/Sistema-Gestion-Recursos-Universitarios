@extends('layouts.app')

@section('title', 'Editar Recurso')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Editar Recurso</h1>
    
    <form method="POST" action="{{ route('admin.recursos.actualizar', $recurso->id_recurso) }}">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nombre del Recurso</label>
            <input type="text" name="nombre" value="{{ $recurso->nombre }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Tipo</label>
            <select name="tipo" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                <option value="salon" {{ $recurso->tipo == 'salon' ? 'selected' : '' }}>Salón</option>
                <option value="laboratorio" {{ $recurso->tipo == 'laboratorio' ? 'selected' : '' }}>Laboratorio</option>
                <option value="equipo" {{ $recurso->tipo == 'equipo' ? 'selected' : '' }}>Equipo</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Ubicación</label>
            <input type="text" name="ubicacion" value="{{ $recurso->ubicacion }}" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Capacidad</label>
            <input type="number" name="capacidad" value="{{ $recurso->capacidad }}" class="w-full border border-gray-300 rounded-lg px-4 py-2">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Estado</label>
            <select name="estado" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                <option value="disponible" {{ $recurso->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="mantenimiento" {{ $recurso->estado == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="prestado" {{ $recurso->estado == 'prestado' ? 'selected' : '' }}>Prestado</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2">{{ $recurso->descripcion }}</textarea>
        </div>
        
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.recursos') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save"></i> Actualizar Recurso
            </button>
        </div>
    </form>
</div>
@endsection