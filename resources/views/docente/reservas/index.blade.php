@extends('layouts.app')

@section('title', 'Gestionar Solicitudes')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Reservas y Solicitudes</h1>
            <p class="text-gray-500 mt-1">Como docente, puedes revisar, aprobar y rechazar solicitudes de reserva de estudiantes.</p>
        </div>
        
        <!-- Filtros por Estado -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('docente.reservas') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ !request()->filled('estado') ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Todas</a>
            <a href="{{ route('docente.reservas', ['estado' => 'pendiente']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('estado') === 'pendiente' ? 'bg-yellow-500 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Pendientes</a>
            <a href="{{ route('docente.reservas', ['estado' => 'aprobada']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('estado') === 'aprobada' ? 'bg-green-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Aprobadas</a>
            <a href="{{ route('docente.reservas', ['estado' => 'rechazada']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('estado') === 'rechazada' ? 'bg-red-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Rechazadas</a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-xl border border-gray-100">
        <table class="min-w-full bg-white">
            <tbody class="divide-y divide-gray-100">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Recurso</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Horario</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                @forelse($reservas as $reserva)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">#{{ $reserva->id_reserva }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $reserva->usuario->nombre }} {{ $reserva->usuario->apellido }}</div>
                        <div class="text-xs text-gray-400">{{ $reserva->usuario->correo }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $reserva->recurso->nombre }}</div>
                        <div class="text-xs text-gray-500">{{ $reserva->recurso->tipo_texto }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ date('d/m/Y', strtotime($reserva->fecha)) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                        {{ date('H:i', strtotime($reserva->hora_inicio)) }} - {{ date('H:i', strtotime($reserva->hora_fin)) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold
                            @if($reserva->estado == 'pendiente') bg-yellow-50 text-yellow-800 border border-yellow-100
                            @elseif($reserva->estado == 'aprobada') bg-green-50 text-green-800 border border-green-100
                            @elseif($reserva->estado == 'rechazada') bg-red-50 text-red-800 border border-red-100
                            @elseif($reserva->estado == 'cancelada') bg-gray-50 text-gray-600 border border-gray-100
                            @elseif($reserva->estado == 'finalizada') bg-blue-50 text-blue-800 border border-blue-100
                            @endif">
                            {{ $reserva->estado_texto }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($reserva->estado == 'pendiente')
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('docente.reservas.aprobar', $reserva->id_reserva) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1.5 rounded-lg font-bold transition shadow-sm">
                                        <i class="fas fa-check mr-1"></i> Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('docente.reservas.rechazar', $reserva->id_reserva) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1.5 rounded-lg font-bold transition shadow-sm" onclick="return confirm('¿Rechazar esta solicitud?')">
                                        <i class="fas fa-times mr-1"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('reservas.show', $reserva->id_reserva) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs bg-blue-50 hover:bg-blue-100/80 px-2.5 py-1.5 rounded-lg transition inline-block">
                                <i class="fas fa-eye mr-1"></i> Ver Detalle
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-3"></i>
                            <p class="font-bold">No se encontraron solicitudes de reserva</p>
                            <p class="text-sm text-gray-400 mt-1">Intente cambiar el filtro seleccionado.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $reservas->appends(request()->query())->links() }}
    </div>
</div>
@endsection
