<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema de Reservas - @yield('title', 'Inicio')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                         Sistema de Reservas
                    </a>
                </div>
                
                @if(session('usuario'))
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">
                        <i class="fas fa-user"></i> 
                        {{ session('usuario')->nombre }} {{ session('usuario')->apellido }}
                        <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                            {{ session('usuario')->rol }}
                        </span>
                    </span>
                    
                    @if(session('usuario')->rol == 'administrador')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">
                            <i class="fas fa-chart-line"></i> Admin
                        </a>
                    @endif
                    
                    <a href="{{ route('reservas.mis-reservas') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-calendar-alt"></i> Mis Reservas
                    </a>
                    
                    <a href="{{ route('reservas.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        <i class="fas fa-plus"></i> Nueva Reserva
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Mensajes Flash -->
    <div class="container mx-auto mt-4 px-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Contenido Principal -->
    <main class="container mx-auto mt-8 px-4 pb-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8 py-4">
        <div class="container mx-auto text-center text-gray-600">
            <p>Sistema de Gestión de Reservas &copy; {{ date('Y') }}</p>
        </div>
    </footer>

</body>
</html>