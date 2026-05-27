@extends('layouts.app')

@section('title', 'Detalle de Reserva')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Detalle de Reserva</h1>
    
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-600">Recurso:</p>
            <p class="font-semibold">{{ $reserva->recurso->nombre }}</p>
        </div>
        <div>
            <p class="text-gray-600">Tipo:</p>
            <p class="font-semibold">{{ $reserva->recurso->tipo_texto }}</p>
        </div>
        <div>
            <p class="text-gray-600">Fecha:</p>
            <p class="font-semibold">{{ date('d/m/Y', strtotime($reserva->fecha)) }}</p>
        </div>
        <div>
            <p class="text-gray-600">Horario:</p>
            <p class="font-semibold">{{ $reserva->horario }}</p>
        </div>
        <div>
            <p class="text-gray-600">Estado:</p>
            <p class="font-semibold">{{ $reserva->estado_texto }}</p>
        </div>
        <div>
            <p class="text-gray-600">Solicitante:</p>
            <p class="font-semibold">{{ $reserva->usuario->nombre_completo }}</p>
        </div>
        @if($reserva->motivo)
        <div class="col-span-2">
            <p class="text-gray-600">Motivo:</p>
            <p class="font-semibold">{{ $reserva->motivo }}</p>
        </div>
        @endif
    </div>
    
    <div class="mt-6 flex space-x-3">
        @if(session('usuario')->rol == 'docente' || session('usuario')->rol == 'administrador')
            <a href="{{ route('docente.reservas') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl transition font-bold text-sm">
                Volver
            </a>
            @if($reserva->estado == 'pendiente')
                <form method="POST" action="{{ route('docente.reservas.aprobar', $reserva->id_reserva) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl font-bold transition text-sm shadow-md">
                        <i class="fas fa-check mr-1"></i> Aprobar
                    </button>
                </form>
                <form method="POST" action="{{ route('docente.reservas.rechazar', $reserva->id_reserva) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-bold transition text-sm shadow-md" onclick="return confirm('¿Rechazar esta solicitud?')">
                        <i class="fas fa-times mr-1"></i> Rechazar
                    </button>
                </form>
            @endif
        @else
            <a href="{{ route('reservas.mis-reservas') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl transition font-bold text-sm">
                Volver
            </a>
        @endif
    </div>
</div>
@endsection