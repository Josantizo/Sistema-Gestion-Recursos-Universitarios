<!-- resources/views/admin/recursos/index.blade.php -->
@extends('layouts.app')

@section('title', 'Gestionar Recursos')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Recursos</h1>
        <a href="{{ route('admin.recursos.crear') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            <i class="fas fa-plus"></i> Nuevo Recurso
        </a>
    </div>

    @php
        $recursos = App\Models\Recurso::paginate(10);
    @endphp

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nombre</th>
                    <th class="px-6 py-3 text-left">Tipo</th>
                    <th class="px-6 py-3 text-left">Ubicación</th>
                    <th class="px-6 py-3 text-left">Capacidad</th>
                    <th class="px-6 py-3 text-left">Estado</th>
                    <th class="px-6 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recursos as $recurso)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $recurso->id_recurso }}</td>
                    <td class="px-6 py-4">{{ $recurso->nombre }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-sm bg-blue-100 text-blue-800">
                            {{ $recurso->tipo_texto }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $recurso->ubicacion }}</td>
                    <td class="px-6 py-4">{{ $recurso->capacidad ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-sm
                            @if($recurso->estado == 'disponible') bg-green-100 text-green-800
                            @elseif($recurso->estado == 'mantenimiento') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $recurso->estado_texto }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.recursos.editar', $recurso->id_recurso) }}" class="text-blue-600 hover:underline mr-3">
                            Editar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        No hay recursos registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $recursos->links() }}
    </div>
</div>
@endsection