<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id('id_reserva');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_recurso');
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada', 'cancelada', 'finalizada'])->default('pendiente');
            $table->string('motivo', 255)->nullable();
            $table->timestamp('fecha_reserva')->useCurrent();
            $table->timestamps();
            
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_recurso')->references('id_recurso')->on('recursos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};