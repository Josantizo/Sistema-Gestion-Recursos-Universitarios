<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'nombre' => 'Admin',
            'apellido' => 'Sistema',
            'correo' => 'admin@sistema.com',
            'contrasena' => 'admin123',
            'rol' => 'administrador',
            'estado' => 'activo'
        ]);
        
        Usuario::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'correo' => 'juan@example.com',
            'contrasena' => '123456',
            'rol' => 'estudiante',
            'estado' => 'activo'
        ]);
        
        Usuario::create([
            'nombre' => 'María',
            'apellido' => 'García',
            'correo' => 'maria@example.com',
            'contrasena' => '123456',
            'rol' => 'docente',
            'estado' => 'activo'
        ]);
    }
}