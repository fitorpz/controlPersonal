<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios (nombre, apellido, email vendrán de allí)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Datos personales
            $table->string('foto')->nullable(); // Ruta de imagen
            $table->integer('edad');
            $table->string('ci');
            $table->string('codigo', 4)->unique();
            $table->string('celular');

            // Fechas
            $table->date('fecha_ingreso');
            $table->date('fecha_retiro')->nullable();

            // Referencias familiares
            $table->string('referencia_1_nombre');
            $table->string('referencia_1_celular');
            $table->string('referencia_2_nombre')->nullable();
            $table->string('referencia_2_celular')->nullable();

            // Croquis de domicilio (puede ser un link de Google Maps o texto libre)
            $table->text('ubicacion_domicilio')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
