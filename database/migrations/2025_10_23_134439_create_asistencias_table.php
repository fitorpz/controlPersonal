<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();

            // Relación con empleado
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            // Información de fecha y hora
            $table->date('fecha'); // Día del registro
            $table->time('hora_entrada')->nullable(); // Hora al marcar entrada
            $table->time('hora_salida')->nullable();  // Hora al marcar salida

            // Ubicación en el momento del marcaje (URL de OpenStreetMap)
            $table->text('ubicacion_marcaje')->nullable();

            // Estado del día
            $table->enum('estado', ['PRESENTE', 'AUSENTE', 'RETRASO', 'SALIDA_ANTICIPADA'])->default('PRESENTE');

            // Observaciones opcionales
            $table->text('observacion')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
