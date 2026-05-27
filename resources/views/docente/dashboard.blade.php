@extends('layouts.app')

@section('title', 'Panel Docente')

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-12 -translate-y-12">
            <i class="fas fa-graduation-cap text-9xl"></i>
        </div>
        <div class="relative z-10">
            <span class="bg-blue-500/30 text-blue-200 text-xs uppercase tracking-wider font-semibold px-3 py-1 rounded-full">Docente</span>
            <h1 class="text-3xl font-extrabold mt-2">¡Bienvenido, {{ session('usuario')->nombre }}!</h1>
            <p class="text-blue-100 mt-2 text-lg">Panel de Revisión y Aprobación de Recursos Universitarios</p>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-yellow-500 transition hover:shadow-lg hover:-translate-y-1 duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-3xl font-black text-gray-800">{{ $reservasPendientes ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500 uppercase mt-1">Solicitudes Pendientes</p>
                </div>
                <div class="bg-yellow-50 text-yellow-600 p-3.5 rounded-xl">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-green-500 transition hover:shadow-lg hover:-translate-y-1 duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-3xl font-black text-gray-800">{{ $reservasAprobadas ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500 uppercase mt-1">Reservas Aprobadas</p>
                </div>
                <div class="bg-green-50 text-green-600 p-3.5 rounded-xl">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-red-500 transition hover:shadow-lg hover:-translate-y-1 duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-3xl font-black text-gray-800">{{ $reservasRechazadas ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500 uppercase mt-1">Reservas Rechazadas</p>
                </div>
                <div class="bg-red-50 text-red-600 p-3.5 rounded-xl">
                    <i class="fas fa-times-circle text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-md p-6 border-l-4 border-blue-500 transition hover:shadow-lg hover:-translate-y-1 duration-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-3xl font-black text-gray-800">{{ $totalRecursos ?? 0 }}</p>
                    <p class="text-sm font-medium text-gray-500 uppercase mt-1">Recursos Totales</p>
                </div>
                <div class="bg-blue-50 text-blue-600 p-3.5 rounded-xl">
                    <i class="fas fa-cubes text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Solicitudes Recientes -->
        <div class="bg-white rounded-2xl shadow-md p-6 lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Solicitudes Pendientes Recientes</h2>
                <a href="{{ route('docente.reservas', ['estado' => 'pendiente']) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold hover:underline">Ver todas →</a>
            </div>
            
            <div class="space-y-4">
                @forelse($reservasPendientesRecientes ?? [] as $reserva)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition duration-150">
                        <div class="space-y-1">
                            <p class="font-bold text-gray-800">{{ $reserva->recurso->nombre }}</p>
                            <div class="flex flex-wrap gap-2 text-xs text-gray-500 items-center">
                                <span class="font-semibold text-gray-700"><i class="fas fa-user-graduate mr-1"></i>{{ $reserva->usuario->nombre_completo }}</span>
                                <span>&bull;</span>
                                <span><i class="fas fa-calendar-day mr-1"></i>{{ date('d/m/Y', strtotime($reserva->fecha)) }}</span>
                                <span>&bull;</span>
                                <span><i class="fas fa-clock mr-1"></i>{{ $reserva->horario }}</span>
                            </div>
                            @if($reserva->motivo)
                                <p class="text-xs text-gray-600 italic bg-white p-2 rounded border border-gray-100 mt-1">"{{ $reserva->motivo }}"</p>
                            @endif
                        </div>
                        
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('docente.reservas.aprobar', $reserva->id_reserva) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs px-3.5 py-2 rounded-lg font-bold shadow-sm transition">
                                    <i class="fas fa-check mr-1"></i> Aprobar
                                </button>
                            </form>
                            <form method="POST" action="{{ route('docente.reservas.rechazar', $reserva->id_reserva) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs px-3.5 py-2 rounded-lg font-bold shadow-sm transition" onclick="return confirm('¿Rechazar esta solicitud?')">
                                    <i class="fas fa-times mr-1"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-check text-4xl mb-3 text-green-500"></i>
                        <p class="font-medium">No hay solicitudes pendientes de aprobación.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Acciones y Filtros -->
        <div class="bg-white rounded-2xl shadow-md p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-800">Acciones Rápidas</h2>
            <div class="space-y-3">
                <a href="{{ route('docente.reservas') }}" class="flex items-center space-x-3 bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition font-semibold text-gray-700">
                    <div class="bg-blue-100 text-blue-600 p-2.5 rounded-lg">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <span>Historial de Reservas</span>
                </a>
                <a href="{{ route('docente.reservas', ['estado' => 'pendiente']) }}" class="flex items-center space-x-3 bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition font-semibold text-gray-700">
                    <div class="bg-yellow-100 text-yellow-600 p-2.5 rounded-lg">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <span>Ver Solicitudes Pendientes</span>
                </a>
                <a href="{{ route('docente.reservas', ['estado' => 'aprobada']) }}" class="flex items-center space-x-3 bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition font-semibold text-gray-700">
                    <div class="bg-green-100 text-green-600 p-2.5 rounded-lg">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span>Ver Reservas Aprobadas</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
