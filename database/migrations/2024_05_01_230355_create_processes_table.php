<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('id_proceso')->unique();
            $table->string('llave_proceso')->unique();
            $table->boolean('es_privado');
            $table->string('fecha_proceso');
            $table->text('despacho');
            $table->text('ponente');
            $table->text('sujetos_procesales');
            $table->text('tipo_proceso');
            $table->text('clase_proceso');
            $table->text('subclase_proceso');
            $table->text('recurso');
            $table->text('ubicacion');
            $table->text('contenido_radicacion');
            $table->string('ultima_actualizacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
