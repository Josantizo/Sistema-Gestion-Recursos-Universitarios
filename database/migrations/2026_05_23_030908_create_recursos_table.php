<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->id('id_recurso');
            $table->string('nombre', 100);
            $table->enum('tipo', ['salon', 'laboratorio', 'equipo']);
            $table->string('ubicacion', 150);
            $table->integer('capacidad')->nullable();
            $table->enum('estado', ['disponible', 'mantenimiento', 'prestado'])->default('disponible');
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recursos');
    }
};