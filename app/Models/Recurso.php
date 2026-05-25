<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;

    protected $table = 'recursos';
    protected $primaryKey = 'id_recurso';
    
    protected $fillable = [
        'nombre',
        'tipo',
        'ubicacion',
        'capacidad',
        'estado',
        'descripcion'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'capacidad' => 'integer'
    ];

    // Accesor para tipo con formato legible
    public function getTipoTextoAttribute()
    {
        $tipos = [
            'salon' => 'Salón',
            'laboratorio' => 'Laboratorio',
            'equipo' => 'Equipo'
        ];
        return $tipos[$this->tipo] ?? $this->tipo;
    }

    // Accesor para estado con formato legible
    public function getEstadoTextoAttribute()
    {
        $estados = [
            'disponible' => 'Disponible',
            'mantenimiento' => 'Mantenimiento',
            'prestado' => 'Prestado'
        ];
        return $estados[$this->estado] ?? $this->estado;
    }

    // Relación con Reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_recurso', 'id_recurso');
    }

    // Scope para recursos disponibles
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    // Scope para filtrar por tipo
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Verificar si está disponible
    public function estaDisponible()
    {
        return $this->estado === 'disponible';
    }
}