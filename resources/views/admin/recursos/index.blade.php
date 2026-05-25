@extends('layouts.app')

@section('title', 'Gestión de Recursos')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Gestión de Recursos</h1>
        <a href="{{ route('admin.recursos.crear') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Nuevo Recurso
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Ubicación</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recursos as $recurso)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $recurso->nombre }}</td>
                    <td class="px-4 py-3">{{ $recurso->tipo_texto }}</td>
                    <td class="px-4 py-3">{{ $recurso->ubicacion }}</td>
                    <td class="px-4 py-3">{{ $recurso->estado_texto }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.recursos.editar', $recurso->id_recurso) }}" class="text-blue-600">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection