@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
        <a href="{{ route('admin.usuarios.crear') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            + Nuevo Usuario
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Rol</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                    <td class="px-4 py-3">{{ $usuario->correo }}</td>
                    <td class="px-4 py-3">{{ ucfirst($usuario->rol) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-sm
                            @if($usuario->estado == 'activo') bg-green-100 text-green-800
                            @elseif($usuario->estado == 'inactivo') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $usuario->estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.usuarios.editar', $usuario->id_usuario) }}" class="text-blue-600 hover:underline">
                            Editar
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection