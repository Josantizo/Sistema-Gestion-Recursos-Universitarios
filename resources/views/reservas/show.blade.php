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
    
    <div class="mt-6">
        <a href="{{ route('reservas.mis-reservas') }}" class="bg-gray-400 text-white px-4 py-2 rounded">
            Volver
        </a>
    </div>
</div>
@endsection