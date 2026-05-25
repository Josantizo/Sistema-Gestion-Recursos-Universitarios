<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue convención)
    protected $table = 'usuarios';
    
    // Llave primaria
    protected $primaryKey = 'id_usuario';
    
    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contrasena',
        'rol',
        'estado'
    ];

    // Ocultar estos campos al convertir a JSON/Array
    protected $hidden = [
        'contrasena'
    ];

    // Cast de tipos de datos
    protected $casts = [
        'fecha_registro' => 'datetime',
        'estado' => 'string',
        'rol' => 'string'
    ];

    // Mutador: Encriptar contraseña automáticamente
    public function setContrasenaAttribute($value)
    {
        $this->attributes['contrasena'] = bcrypt($value);
    }

    // Accesor: Nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // Relación con Reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_usuario', 'id_usuario');
    }

    // Relación con Historial
    public function historiales()
    {
        return $this->hasMany(Historial::class, 'id_usuario', 'id_usuario');
    }

    // Métodos de verificación
    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }

    public function esDocente()
    {
        return $this->rol === 'docente';
    }

    public function esEstudiante()
    {
        return $this->rol === 'estudiante';
    }

    public function estaActivo()
    {
        return $this->estado === 'activo';
    }
}