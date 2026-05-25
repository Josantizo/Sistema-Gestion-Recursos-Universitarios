<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Recurso;
use App\Models\Reserva;
use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard principal
    public function dashboard()
    {
        // Estadísticas
        $totalUsuarios = Usuario::count();
        $totalRecursos = Recurso::count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        $reservasHoy = Reserva::where('fecha', today())->count();
        $reservasAprobadas = Reserva::where('estado', 'aprobada')->count();
        
        // Reservas recientes
        $reservasRecientes = Reserva::with(['usuario', 'recurso'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Recursos más reservados
        $recursosPopulares = Recurso::withCount('reservas')
            ->orderBy('reservas_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalUsuarios', 'totalRecursos', 'reservasPendientes', 
            'reservasHoy', 'reservasAprobadas', 'reservasRecientes',
            'recursosPopulares'
        ));
    }

    // ========== GESTIÓN DE USUARIOS ==========
    
    public function usuarios()
    {
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function crearUsuario()
    {
        return view('admin.usuarios.create');
    }

    public function guardarUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'correo' => 'required|email|unique:usuarios,correo',
            'rol' => 'required|in:estudiante,docente,administrador',
            'contrasena' => 'required|min:6'
        ]);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correo' => $request->correo,
            'contrasena' => $request->contrasena,
            'rol' => $request->rol,
            'estado' => 'activo'
        ]);

        Historial::registrar(
            session('usuario')->id_usuario,
            'crear_usuario',
            session('usuario')->correo,
            "Usuario creado: {$usuario->correo} (Rol: {$usuario->rol})"
        );

        return redirect()->route('admin.usuarios')->with('success', 'Usuario creado exitosamente');
    }

    public function editarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function actualizarUsuario(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'rol' => 'required|in:estudiante,docente,administrador',
            'estado' => 'required|in:activo,inactivo,suspendido'
        ]);

        $usuario->update($request->only(['nombre', 'apellido', 'rol', 'estado']));
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'actualizar_usuario',
            session('usuario')->correo,
            "Usuario actualizado: {$usuario->correo}"
        );

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado exitosamente');
    }

    public function eliminarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        
        // No permitir eliminar el propio usuario
        if ($usuario->id_usuario == session('usuario')->id_usuario) {
            return back()->with('error', 'No puedes eliminarte a ti mismo');
        }
        
        $email = $usuario->correo;
        $usuario->delete();
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'eliminar_usuario',
            session('usuario')->correo,
            "Usuario eliminado: {$email}"
        );

        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado exitosamente');
    }

    // ========== GESTIÓN DE RECURSOS ==========
    
    public function recursos()
    {
        $recursos = Recurso::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.recursos.index', compact('recursos'));
    }

    public function crearRecurso()
    {
        return view('admin.recursos.create');
    }

    public function guardarRecurso(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:salon,laboratorio,equipo',
            'ubicacion' => 'required|string|max:150',
            'capacidad' => 'nullable|integer|min:1',
            'descripcion' => 'nullable|string'
        ]);

        $recurso = Recurso::create($request->all());
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'crear_recurso',
            session('usuario')->correo,
            "Recurso creado: {$recurso->nombre} (Tipo: {$recurso->tipo})"
        );

        return redirect()->route('admin.recursos')->with('success', 'Recurso creado exitosamente');
    }

    public function editarRecurso($id)
    {
        $recurso = Recurso::findOrFail($id);
        return view('admin.recursos.edit', compact('recurso'));
    }

    public function actualizarRecurso(Request $request, $id)
    {
        $recurso = Recurso::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:salon,laboratorio,equipo',
            'ubicacion' => 'required|string|max:150',
            'capacidad' => 'nullable|integer|min:1',
            'estado' => 'required|in:disponible,mantenimiento,prestado',
            'descripcion' => 'nullable|string'
        ]);

        $recurso->update($request->all());
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'actualizar_recurso',
            session('usuario')->correo,
            "Recurso actualizado: {$recurso->nombre}"
        );

        return redirect()->route('admin.recursos')->with('success', 'Recurso actualizado exitosamente');
    }

    public function eliminarRecurso($id)
    {
        $recurso = Recurso::findOrFail($id);
        
        // Verificar si tiene reservas
        if ($recurso->reservas()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el recurso porque tiene reservas asociadas');
        }
        
        $nombre = $recurso->nombre;
        $recurso->delete();
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'eliminar_recurso',
            session('usuario')->correo,
            "Recurso eliminado: {$nombre}"
        );

        return redirect()->route('admin.recursos')->with('success', 'Recurso eliminado exitosamente');
    }

    // ========== GESTIÓN DE RESERVAS ==========
    
    public function reservas()
    {
        $reservas = Reserva::with(['usuario', 'recurso'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.reservas.index', compact('reservas'));
    }

    public function aprobarReserva($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        if ($reserva->estado !== 'pendiente') {
            return back()->with('error', 'Esta reserva no está pendiente de aprobación');
        }
        
        $reserva->update(['estado' => 'aprobada']);
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'aprobar_reserva',
            session('usuario')->correo,
            "Reserva #{$id} aprobada - Usuario: {$reserva->usuario->correo}"
        );
        
        return back()->with('success', 'Reserva aprobada exitosamente');
    }

    public function rechazarReserva($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        if ($reserva->estado !== 'pendiente') {
            return back()->with('error', 'Esta reserva no está pendiente de aprobación');
        }
        
        $reserva->update(['estado' => 'rechazada']);
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'rechazar_reserva',
            session('usuario')->correo,
            "Reserva #{$id} rechazada - Usuario: {$reserva->usuario->correo}"
        );
        
        return back()->with('success', 'Reserva rechazada');
    }

    public function finalizarReserva($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        if ($reserva->estado !== 'aprobada') {
            return back()->with('error', 'Solo se pueden finalizar reservas aprobadas');
        }
        
        $reserva->update(['estado' => 'finalizada']);
        
        Historial::registrar(
            session('usuario')->id_usuario,
            'finalizar_reserva',
            session('usuario')->correo,
            "Reserva #{$id} finalizada"
        );
        
        return back()->with('success', 'Reserva finalizada');
    }

    // ========== HISTORIAL ==========
    
    public function historial()
    {
        $historial = Historial::with('usuario')
            ->orderBy('fecha', 'desc')
            ->paginate(30);
            
        return view('admin.historial', compact('historial'));
    }
}