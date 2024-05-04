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
            $table->string('id_reg_actuacion')->nullable();
            $table->integer('consecutivo_actuacion')->nullable();
            $table->string('fecha_actuacion')->nullable();
            $table->string('actuacion')->nullable();
            $table->text('anotacion')->nullable();
            $table->string('fecha_registro')->nullable();
            $table->boolean('con_documentos')->nullable();
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
