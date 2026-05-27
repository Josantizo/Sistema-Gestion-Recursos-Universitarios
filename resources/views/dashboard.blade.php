@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">¡Bienvenido, {{ session('usuario')->nombre }}!</h1>
            <p class="text-gray-500 mt-1">Sistema de Gestión de Recursos Universitarios</p>
        </div>
        <div class="bg-blue-50 border border-blue-100 text-blue-800 px-4 py-2 rounded-xl text-sm font-bold flex items-center space-x-2">
            <i class="fas fa-user-circle text-lg"></i>
            <span class="capitalize">Rol: {{ session('usuario')->rol }}</span>
        </div>
    </div>
    
    @if(session('usuario')->rol === 'docente')
        <!-- Docente View -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition">
                <div>
                    <div class="bg-yellow-50 text-yellow-600 p-4 rounded-xl w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-hourglass-half text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Solicitudes por Evaluar</h3>
                    <p class="text-gray-500 mt-2 text-sm">Tienes solicitudes de reservas de estudiantes esperando tu aprobación o rechazo.</p>
                </div>
                <a href="{{ route('docente.dashboard') }}" class="inline-flex items-center space-x-2 mt-6 text-yellow-600 hover:text-yellow-700 font-bold">
                    <span>Ir al Panel de Aprobaciones</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between hover:shadow-lg transition">
                <div>
                    <div class="bg-green-50 text-green-600 p-4 rounded-xl w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-list-ul text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Historial de Solicitudes</h3>
                    <p class="text-gray-500 mt-2 text-sm">Consulta todas las solicitudes previas, su estado actual y detalles de asignación.</p>
                </div>
                <a href="{{ route('docente.reservas') }}" class="inline-flex items-center space-x-2 mt-6 text-green-600 hover:text-green-700 font-bold">
                    <span>Ver Reservas Registradas</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @elseif(session('usuario')->rol === 'administrador')
        <!-- Administrador View -->
        <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-100 text-center space-y-6">
            <div class="bg-indigo-50 text-indigo-600 p-4 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
                <i class="fas fa-cogs text-3xl"></i>
            </div>
            <div class="max-w-md mx-auto space-y-2">
                <h3 class="text-2xl font-bold text-gray-800">Panel de Control General</h3>
                <p class="text-gray-500 text-sm">Como administrador general, puedes gestionar usuarios, recursos, todas las reservas del campus e historiales de auditoría.</p>
            </div>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                </a>
                <a href="{{ route('docente.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fas fa-graduation-cap mr-2"></i> Dashboard Docente
                </a>
            </div>
        </div>
    @else
        <!-- Estudiante View (default) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-xl w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Mis Reservas</h3>
                    <p class="text-gray-500 mt-2 text-sm">Gestiona y consulta el estado de tus solicitudes de reserva actuales.</p>
                </div>
                <a href="{{ route('reservas.mis-reservas') }}" class="inline-flex items-center space-x-1 mt-6 text-blue-600 hover:text-blue-700 font-bold">
                    <span>Ver mis reservas</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-green-50 text-green-600 p-4 rounded-xl w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-plus-circle text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Nueva Reserva</h3>
                    <p class="text-gray-500 mt-2 text-sm">Solicita el préstamo de salones, laboratorios o equipos disponibles.</p>
                </div>
                <a href="{{ route('reservas.create') }}" class="inline-flex items-center space-x-1 mt-6 text-green-600 hover:text-green-700 font-bold">
                    <span>Crear reserva</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200 flex flex-col justify-between">
                <div>
                    <div class="bg-purple-50 text-purple-600 p-4 rounded-xl w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Recursos del Campus</h3>
                    <p class="text-gray-500 mt-2 text-sm">Explora el catálogo completo de infraestructura y equipos de la universidad.</p>
                </div>
                <a href="#" class="inline-flex items-center space-x-1 mt-6 text-purple-600 hover:text-purple-700 font-bold">
                    <span>Ver recursos</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection