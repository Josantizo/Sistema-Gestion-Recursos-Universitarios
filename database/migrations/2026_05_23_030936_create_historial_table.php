<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedBigInteger('id_usuario');
            $table->string('accion', 50);
            $table->string('usuario', 100);
            $table->timestamp('fecha')->useCurrent();
            $table->text('detalle')->nullable();
            
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
