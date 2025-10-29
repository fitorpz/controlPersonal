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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            // Si quieres horario por empleado:
            $table->unsignedBigInteger('empleado_id')->nullable(); // o null si es general

            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->string('nombre_turno')->nullable(); // ej: Turno mañana

            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
