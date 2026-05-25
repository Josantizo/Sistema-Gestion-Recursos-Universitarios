<?php

namespace Database\Seeders;

use App\Models\Recurso;
use Illuminate\Database\Seeder;

class RecursosSeeder extends Seeder
{
    public function run()
    {
        $recursos = [
            [
                'nombre' => 'Salón A-101',
                'tipo' => 'salon',
                'ubicacion' => 'Edificio A, Piso 1',
                'capacidad' => 30,
                'estado' => 'disponible',
                'descripcion' => 'Salón con proyector, pizarra blanca y aire acondicionado'
            ],
            [
                'nombre' => 'Salón B-202',
                'tipo' => 'salon',
                'ubicacion' => 'Edificio B, Piso 2',
                'capacidad' => 25,
                'estado' => 'disponible',
                'descripcion' => 'Salón con vista al jardín, ideal para clases teóricas'
            ],
            [
                'nombre' => 'Laboratorio de Computación',
                'tipo' => 'laboratorio',
                'ubicacion' => 'Edificio C, Piso 1',
                'capacidad' => 20,
                'estado' => 'disponible',
                'descripcion' => '25 computadoras con software actualizado, impresora 3D'
            ],
            [
                'nombre' => 'Laboratorio de Química',
                'tipo' => 'laboratorio',
                'ubicacion' => 'Edificio D, Piso 1',
                'capacidad' => 15,
                'estado' => 'disponible',
                'descripcion' => 'Equipamiento completo para prácticas de química'
            ],
            [
                'nombre' => 'Proyector Multimedia',
                'tipo' => 'equipo',
                'ubicacion' => 'Bodega Central',
                'capacidad' => null,
                'estado' => 'disponible',
                'descripcion' => 'Proyector Epson Full HD, incluye cable HDMI'
            ],
            [
                'nombre' => 'Auditorio Principal',
                'tipo' => 'salon',
                'ubicacion' => 'Edificio Principal',
                'capacidad' => 150,
                'estado' => 'disponible',
                'descripcion' => 'Auditorio con sonido envolvente y pantalla gigante'
            ]
        ];
        
        foreach ($recursos as $recurso) {
            Recurso::create($recurso);
        }
    }
}