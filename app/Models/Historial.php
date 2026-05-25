<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    // Desactivar timestamps automáticos
    public $timestamps = false;
    
    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    
    protected $fillable = [
        'id_usuario',
        'accion',
        'usuario',
        'fecha',
        'detalle'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Método estático para registrar acciones fácilmente
    public static function registrar($usuarioId, $accion, $usuarioEmail, $detalle = null)
    {
        return self::create([
            'id_usuario' => $usuarioId,
            'accion' => $accion,
            'usuario' => $usuarioEmail,
            'fecha' => now(),
            'detalle' => $detalle
        ]);
    }

    // Scope para acciones recientes
    public function scopeRecientes($query, $limite = 50)
    {
        return $query->orderBy('fecha', 'desc')->limit($limite);
    }

    // Scope para filtrar por tipo de acción
    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }
}