<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->id();

            // Relación con empleado y usuario que la generó
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->foreignId('generado_por')->nullable()->constrained('users')->onDelete('set null');

            // Periodo (YYYY-MM)
            $table->string('mes', 7);

            // Métricas de asistencia
            $table->integer('dias_trabajados');
            $table->integer('faltas')->default(0);
            $table->integer('retrasos')->default(0);
            $table->decimal('horas_extra', 5, 2)->default(0);

            // Valores económicos base
            $table->decimal('salario_base', 10, 2);

            // Montos generados automáticamente
            $table->decimal('total_descuento', 10, 2)->default(0);
            $table->decimal('total_bonificacion', 10, 2)->default(0);
            $table->decimal('salario_neto', 10, 2);

            // Detalle descriptivo de descuentos y bonos aplicados
            $table->text('detalle_descuento')->nullable();
            $table->text('detalle_bonificacion')->nullable();

            // Estado de la planilla
            $table->enum('estado', ['GENERADO', 'PAGADO'])->default('GENERADO');

            $table->timestamps();

            // Evitar duplicados por empleado y mes
            $table->unique(['empleado_id', 'mes']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planillas');
    }
};
