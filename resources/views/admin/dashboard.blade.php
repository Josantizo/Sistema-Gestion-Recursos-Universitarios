@extends('layouts.app')

@section('title', 'Panel Administrativo')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Panel de Administración</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-100 p-4 rounded">
            <p class="text-2xl font-bold">{{ $totalUsuarios ?? 0 }}</p>
            <p>Usuarios</p>
        </div>
        <div class="bg-green-100 p-4 rounded">
            <p class="text-2xl font-bold">{{ $totalRecursos ?? 0 }}</p>
            <p>Recursos</p>
        </div>
        <div class="bg-yellow-100 p-4 rounded">
            <p class="text-2xl font-bold">{{ $reservasPendientes ?? 0 }}</p>
            <p>Reservas Pendientes</p>
        </div>
        <div class="bg-purple-100 p-4 rounded">
            <p class="text-2xl font-bold">{{ $reservasHoy ?? 0 }}</p>
            <p>Reservas Hoy</p>
        </div>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-xl font-bold mb-3">Reservas Recientes</h2>
            <div class="bg-gray-50 p-4 rounded">
                @forelse($reservasRecientes ?? [] as $reserva)
                    <div class="mb-2 pb-2 border-b">
                        <p><strong>{{ $reserva->recurso->nombre }}</strong> - {{ $reserva->usuario->nombre }}</p>
                        <p class="text-sm text-gray-600">{{ date('d/m/Y', strtotime($reserva->fecha)) }}</p>
                    </div>
                @empty
                    <p>No hay reservas recientes</p>
                @endforelse
            </div>
        </div>
        
        <div>
            <h2 class="text-xl font-bold mb-3">Acciones Rápidas</h2>
            <div class="space-y-2">
                <a href="{{ route('admin.usuarios') }}" class="block bg-gray-100 p-3 rounded hover:bg-gray-200">
                    Gestionar Usuarios
                </a>
                <a href="{{ route('admin.recursos') }}" class="block bg-gray-100 p-3 rounded hover:bg-gray-200">
                    Gestionar Recursos
                </a>
                <a href="{{ route('admin.reservas') }}" class="block bg-gray-100 p-3 rounded hover:bg-gray-200">
                    Gestionar Reservas
                </a>
                <a href="{{ route('admin.historial') }}" class="block bg-gray-100 p-3 rounded hover:bg-gray-200">
                    Ver Historial
                </a>
            </div>
        </div>
    </div>
</div>
@endsection