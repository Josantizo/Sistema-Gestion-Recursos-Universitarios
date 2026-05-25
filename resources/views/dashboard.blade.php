@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-4">¡Bienvenido, {{ session('usuario')->nombre }}!</h1>
    <p class="text-gray-600 mb-6">Sistema de Gestión de Reservas de Recursos</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-50 p-6 rounded-lg">
            <i class="fas fa-calendar-alt text-3xl text-blue-600 mb-2"></i>
            <h3 class="text-lg font-semibold">Mis Reservas</h3>
            <p class="text-gray-600">Gestiona tus reservas actuales</p>
            <a href="{{ route('reservas.mis-reservas') }}" class="inline-block mt-3 text-blue-600 hover:underline">
                Ver reservas →
            </a>
        </div>
        
        <div class="bg-green-50 p-6 rounded-lg">
            <i class="fas fa-plus-circle text-3xl text-green-600 mb-2"></i>
            <h3 class="text-lg font-semibold">Nueva Reserva</h3>
            <p class="text-gray-600">Reserva un recurso disponible</p>
            <a href="{{ route('reservas.create') }}" class="inline-block mt-3 text-green-600 hover:underline">
                Crear reserva →
            </a>
        </div>
        
        <div class="bg-purple-50 p-6 rounded-lg">
            <i class="fas fa-building text-3xl text-purple-600 mb-2"></i>
            <h3 class="text-lg font-semibold">Recursos</h3>
            <p class="text-gray-600">Consulta los recursos disponibles</p>
            <a href="#" class="inline-block mt-3 text-purple-600 hover:underline">
                Ver recursos →
            </a>
        </div>
    </div>
</div>
@endsection