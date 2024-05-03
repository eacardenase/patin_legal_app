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
        Schema::create('process_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id')->constrained()->cascadeOnDelete();
            $table->string('id_reg_actuacion');
            $table->integer('consecutivo_actuacion');
            $table->string('fecha_actuacion');
            $table->string('actuacion');
            $table->text('anotacion');
            $table->string('fecha_registro');
            $table->boolean('con_documentos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_actions');
    }
};
