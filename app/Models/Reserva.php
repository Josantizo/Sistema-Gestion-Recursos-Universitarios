<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';
    protected $primaryKey = 'id_reserva';
    
    protected $fillable = [
        'id_usuario',
        'id_recurso',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'motivo',
        'fecha_reserva'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
        'fecha_reserva' => 'datetime'
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Relación con Recurso
    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'id_recurso', 'id_recurso');
    }

    // Accesor para estado con formato
    public function getEstadoTextoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada',
            'cancelada' => 'Cancelada',
            'finalizada' => 'Finalizada'
        ];
        return $estados[$this->estado] ?? $this->estado;
    }

    // Accesor para horario formateado
    public function getHorarioAttribute()
    {
        return Carbon::parse($this->hora_inicio)->format('H:i') . ' - ' . 
               Carbon::parse($this->hora_fin)->format('H:i');
    }

    // Scope para reservas pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    // Scope para reservas aprobadas
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    // Scope para reservas activas (pendientes o aprobadas)
    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['pendiente', 'aprobada']);
    }

    // Verificar conflicto de horarios
    public static function tieneConflicto($recursoId, $fecha, $horaInicio, $horaFin, $excluirId = null)
    {
        $query = self::where('id_recurso', $recursoId)
            ->where('fecha', $fecha)
            ->whereIn('estado', ['pendiente', 'aprobada'])
            ->where(function($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                  ->orWhereBetween('hora_fin', [$horaInicio, $horaFin])
                  ->orWhere(function($q2) use ($horaInicio, $horaFin) {
                      $q2->where('hora_inicio', '<=', $horaInicio)
                         ->where('hora_fin', '>=', $horaFin);
                  });
            });
        
        if ($excluirId) {
            $query->where('id_reserva', '!=', $excluirId);
        }
        
        return $query->exists();
    }

    // Verificar si la reserva es editable
    public function esEditable()
    {
        return in_array($this->estado, ['pendiente']);
    }
}