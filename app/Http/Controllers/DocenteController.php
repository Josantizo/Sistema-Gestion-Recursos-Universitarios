<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Recurso;
use App\Models\Reserva;
use App\Models\Historial;
use App\Mail\ReservaResueltaEstudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocenteController extends Controller
{
    // Dashboard principal del docente
    public function dashboard()
    {
        $usuario = session('usuario');

        // Estadísticas
        $totalRecursos = Recurso::count();
        $reservasPendientes = Reserva::where('estado', 'pendiente')->count();
        $reservasAprobadas = Reserva::where('estado', 'aprobada')->count();
        $reservasRechazadas = Reserva::where('estado', 'rechazada')->count();
        
        // Reservas pendientes recientes
        $reservasPendientesRecientes = Reserva::with(['usuario', 'recurso'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('docente.dashboard', compact(
            'totalRecursos', 'reservasPendientes', 'reservasAprobadas', 
            'reservasRechazadas', 'reservasPendientesRecientes'
        ));
    }

    // Listado de todas las reservas
    public function reservas(Request $request)
    {
        $query = Reserva::with(['usuario', 'recurso']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $reservas = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('docente.reservas.index', compact('reservas'));
    }

    // Aprobar una reserva
    public function aprobarReserva($id)
    {
        $reserva = Reserva::with('usuario')->findOrFail($id);
        $docente = session('usuario');

        if ($reserva->estado !== 'pendiente') {
            return back()->with('error', 'Esta reserva no está pendiente de aprobación');
        }

        $reserva->update(['estado' => 'aprobada']);

        // Registrar en historial
        Historial::registrar(
            $docente->id_usuario,
            'aprobar_reserva',
            $docente->correo,
            "Reserva #{$id} aprobada por el docente {$docente->nombre_completo} - Estudiante: {$reserva->usuario->correo}"
        );

        // Enviar correo electrónico al estudiante
        try {
            Mail::to($reserva->usuario->correo)->send(new ReservaResueltaEstudiante($reserva, $docente));
        } catch (\Exception $e) {
            // Log fallback or skip error so redirect happens
            logger()->error("No se pudo enviar el correo de aprobación al estudiante: " . $e->getMessage());
        }

        return back()->with('success', 'Reserva aprobada exitosamente. Se ha enviado un correo al estudiante.');
    }

    // Rechazar una reserva
    public function rechazarReserva($id)
    {
        $reserva = Reserva::with('usuario')->findOrFail($id);
        $docente = session('usuario');

        if ($reserva->estado !== 'pendiente') {
            return back()->with('error', 'Esta reserva no está pendiente de aprobación');
        }

        $reserva->update(['estado' => 'rechazada']);

        // Registrar en historial
        Historial::registrar(
            $docente->id_usuario,
            'rechazar_reserva',
            $docente->correo,
            "Reserva #{$id} rechazada por el docente {$docente->nombre_completo} - Estudiante: {$reserva->usuario->correo}"
        );

        // Enviar correo electrónico al estudiante
        try {
            Mail::to($reserva->usuario->correo)->send(new ReservaResueltaEstudiante($reserva, $docente));
        } catch (\Exception $e) {
            logger()->error("No se pudo enviar el correo de rechazo al estudiante: " . $e->getMessage());
        }

        return back()->with('success', 'Reserva rechazada. Se ha enviado un correo al estudiante.');
    }
}
