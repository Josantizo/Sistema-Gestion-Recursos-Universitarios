@extends('layouts.app')

@section('title', 'Nueva Reserva')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h1 class="text-2xl font-bold mb-6">Crear Nueva Reserva</h1>
    
    <form method="POST" action="{{ route('reservas.store') }}" id="formReserva">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Seleccionar Recurso</label>
            <select name="id_recurso" id="recurso" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                <option value="">-- Selecciona un recurso --</option>
                @foreach($recursos as $recurso)
                    <option value="{{ $recurso->id_recurso }}">
                        {{ $recurso->nombre }} - {{ $recurso->tipo_texto }} (Cap: {{ $recurso->capacidad ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-2">Hora Inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            </div>
            <div>
                <label class="block text-gray-700 mb-2">Hora Fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
            </div>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Motivo</label>
            <textarea name="motivo" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="Describe el motivo de la reserva..."></textarea>
        </div>
        
        <div class="flex justify-between">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-save"></i> Guardar Reserva
            </button>
            <a href="{{ route('reservas.mis-reservas') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('recurso').addEventListener('change', verificarDisponibilidad);
document.getElementById('fecha').addEventListener('change', verificarDisponibilidad);

function verificarDisponibilidad() {
    // Aquí puedes agregar AJAX para verificar disponibilidad
}
</script>
@endsection