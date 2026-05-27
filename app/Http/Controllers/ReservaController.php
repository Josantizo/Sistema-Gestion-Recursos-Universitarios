<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Recurso;
use App\Models\Historial;
use App\Models\Usuario;
use App\Mail\SolicitudReservaDocente;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservaController extends Controller
{
    // Mostrar formulario de reserva
    public function create()
    {
        $recursos = Recurso::where('estado', 'disponible')->get();
        return view('reservas.create', compact('recursos'));
    }

    // Obtener horarios disponibles (para AJAX)
    public function horariosDisponibles(Request $request)
    {
        $recursoId = $request->recurso_id;
        $fecha = $request->fecha;
        
        $reservas = Reserva::where('id_recurso', $recursoId)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->get();
        
        $horariosOcupados = [];
        foreach ($reservas as $reserva) {
            $horariosOcupados[] = [
                'inicio' => Carbon::parse($reserva->hora_inicio)->format('H:i'),
                'fin' => Carbon::parse($reserva->hora_fin)->format('H:i')
            ];
        }
        
        return response()->json($horariosOcupados);
    }

    // Guardar reserva
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'id_recurso' => 'required|exists:recursos,id_recurso',
            'fecha' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'motivo' => 'nullable|string|max:255'
        ], [
            'id_recurso.required' => 'Debes seleccionar un recurso',
            'fecha.required' => 'Debes seleccionar una fecha',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy',
            'hora_inicio.required' => 'Debes seleccionar hora de inicio',
            'hora_fin.required' => 'Debes seleccionar hora de fin',
            'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio'
        ]);

        $usuario = session('usuario');
        
        // Verificar conflictos
        if (Reserva::tieneConflicto(
            $request->id_recurso, 
            $request->fecha, 
            $request->hora_inicio, 
            $request->hora_fin
        )) {
            return back()->with('error', 'El recurso no está disponible en ese horario');
        }

        // Crear reserva
        $reserva = Reserva::create([
            'id_usuario' => $usuario->id_usuario,
            'id_recurso' => $request->id_recurso,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estado' => $usuario->rol === 'administrador' ? 'aprobada' : 'pendiente',
            'motivo' => $request->motivo,
            'fecha_reserva' => now()
        ]);

        // Registrar en historial
        $recurso = Recurso::find($request->id_recurso);
        Historial::registrar(
            $usuario->id_usuario,
            'crear_reserva',
            $usuario->correo,
            "Reserva creada - Recurso: {$recurso->nombre} - Fecha: {$request->fecha}"
        );

        // Notificar a todos los docentes activos si no es admin
        if ($usuario->rol !== 'administrador') {
            $docentes = Usuario::where('rol', 'docente')->where('estado', 'activo')->get();
            foreach ($docentes as $docente) {
                try {
                    Mail::to($docente->correo)->send(new SolicitudReservaDocente($reserva));
                } catch (\Exception $e) {
                    logger()->error("No se pudo enviar el correo de nueva solicitud al docente {$docente->correo}: " . $e->getMessage());
                }
            }
        }

        $mensaje = $usuario->rol === 'administrador' 
            ? 'Reserva creada y aprobada exitosamente' 
            : 'Solicitud de reserva enviada exitosamente. Los docentes han sido notificados.';
            
        return redirect()->route('reservas.mis-reservas')->with('success', $mensaje);
    }

    // Ver mis reservas
    public function misReservas()
    {
        $usuario = session('usuario');
        $reservas = Reserva::with(['usuario', 'recurso'])
            ->where('id_usuario', $usuario->id_usuario)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(10);
            
        return view('reservas.mis-reservas', compact('reservas'));
    }

    // Cancelar reserva
    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $usuario = session('usuario');
        
        // Verificar permiso
        if ($reserva->id_usuario != $usuario->id_usuario && !$usuario->esAdministrador()) {
            return back()->with('error', 'No tienes permiso para cancelar esta reserva');
        }
        
        // Verificar si se puede cancelar
        if (!in_array($reserva->estado, ['pendiente', 'aprobada'])) {
            return back()->with('error', 'Esta reserva no se puede cancelar');
        }
        
        // Cancelar reserva
        $reserva->update(['estado' => 'cancelada']);
        
        // Registrar en historial
        Historial::registrar(
            $usuario->id_usuario,
            'cancelar_reserva',
            $usuario->correo,
            "Reserva #{$id} cancelada - Recurso: {$reserva->recurso->nombre}"
        );
        
        return back()->with('success', 'Reserva cancelada exitosamente');
    }

    // Ver detalle de reserva
    public function show($id)
    {
        $reserva = Reserva::with(['usuario', 'recurso'])->findOrFail($id);
        $usuario = session('usuario');
        
        // Verificar permiso: el solicitante, administrador, o un docente
        if ($reserva->id_usuario != $usuario->id_usuario && !$usuario->esAdministrador() && $usuario->rol !== 'docente') {
            return redirect()->route('dashboard')->with('error', 'No autorizado');
        }
        
        return view('reservas.show', compact('reserva'));
    }
}