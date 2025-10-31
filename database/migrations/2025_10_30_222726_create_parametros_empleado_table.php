<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parametros_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->string('clave'); // Debe coincidir con alguna clave global en `parametros`
            $table->decimal('valor', 10, 2);
            $table->timestamps();

            $table->unique(['empleado_id', 'clave']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parametros_empleado');
    }
};
