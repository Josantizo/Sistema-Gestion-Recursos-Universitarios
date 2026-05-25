@extends('layouts.app')

@section('title', 'Gestionar Reservas')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Gestión de Reservas</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Usuario</th>
                    <th class="px-4 py-3 text-left">Recurso</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Horario</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservas as $reserva)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $reserva->id_reserva }}</td>
                    <td class="px-4 py-3">
                        {{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}<br>
                        <small class="text-gray-500">{{ $reserva->usuario->correo }}</small>
                    </td>
                    <td class="px-4 py-3">{{ $reserva->recurso->nombre }}</td>
                    <td class="px-4 py-3">{{ date('d/m/Y', strtotime($reserva->fecha)) }}</td>
                    <td class="px-4 py-3">{{ date('H:i', strtotime($reserva->hora_inicio)) }} - {{ date('H:i', strtotime($reserva->hora_fin)) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-sm
                            @if($reserva->estado == 'pendiente') bg-yellow-100 text-yellow-800
                            @elseif($reserva->estado == 'aprobada') bg-green-100 text-green-800
                            @elseif($reserva->estado == 'rechazada') bg-red-100 text-red-800
                            @elseif($reserva->estado == 'cancelada') bg-gray-100 text-gray-800
                            @elseif($reserva->estado == 'finalizada') bg-blue-100 text-blue-800
                            @endif">
                            {{ $reserva->estado_texto }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($reserva->estado == 'pendiente')
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('admin.reservas.aprobar', $reserva->id_reserva) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition">
                                        <i class="fas fa-check"></i> Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.reservas.rechazar', $reserva->id_reserva) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        @elseif($reserva->estado == 'aprobada')
                            <form method="POST" action="{{ route('admin.reservas.finalizar', $reserva->id_reserva) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                    <i class="fas fa-flag-checkered"></i> Finalizar
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm">Sin acciones</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-2"></i><br>
                        No hay reservas registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $reservas->links() }}
    </div>
</div>
@endsection