@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Mis Reservas</h1>
    
    @if($reservas->isEmpty())
        <div class="text-center py-8">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-600">No tienes reservas aún</p>
            <a href="{{ route('reservas.create') }}" class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Crear primera reserva
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Recurso</th>
                        <th class="px-4 py-2 text-left">Fecha</th>
                        <th class="px-4 py-2 text-left">Horario</th>
                        <th class="px-4 py-2 text-left">Estado</th>
                        <th class="px-4 py-2 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $reserva->recurso->nombre }}</td>
                        <td class="px-4 py-3">{{ date('d/m/Y', strtotime($reserva->fecha)) }}</td>
                        <td class="px-4 py-3">{{ $reserva->horario }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-sm
                                @if($reserva->estado == 'pendiente') bg-yellow-100 text-yellow-800
                                @elseif($reserva->estado == 'aprobada') bg-green-100 text-green-800
                                @elseif($reserva->estado == 'rechazada') bg-red-100 text-red-800
                                @elseif($reserva->estado == 'cancelada') bg-gray-100 text-gray-800
                                @endif">
                                {{ $reserva->estado_texto }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('reservas.show', $reserva->id_reserva) }}" class="text-blue-600 hover:underline mr-2">
                                Ver
                            </a>
                            @if(in_array($reserva->estado, ['pendiente', 'aprobada']))
                            <form method="POST" action="{{ route('reservas.cancelar', $reserva->id_reserva) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Cancelar esta reserva?')">
                                    Cancelar
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $reservas->links() }}
        </div>
    @endif
</div>
@endsection