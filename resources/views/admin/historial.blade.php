<!-- resources/views/admin/historial.blade.php -->
@extends('layouts.app')

@section('title', 'Historial del Sistema')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Historial de Actividades</h1>

    @php
        $historial = App\Models\Historial::with('usuario')->orderBy('fecha', 'desc')->paginate(20);
    @endphp

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Fecha/Hora</th>
                    <th class="px-4 py-3 text-left">Usuario</th>
                    <th class="px-4 py-3 text-left">Acción</th>
                    <th class="px-4 py-3 text-left">Detalle</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historial as $item)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ date('d/m/Y H:i:s', strtotime($item->fecha)) }}</td>
                    <td class="px-4 py-3">{{ $item->usuario->nombre ?? $item->usuario }} {{ $item->usuario->apellido ?? '' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-sm
                            @if(str_contains($item->accion, 'login')) bg-blue-100 text-blue-800
                            @elseif(str_contains($item->accion, 'crear')) bg-green-100 text-green-800
                            @elseif(str_contains($item->accion, 'cancelar')) bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $item->accion }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $item->detalle }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-500">
                        No hay registros en el historial
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $historial->links() }}
    </div>
</div>
@endsection