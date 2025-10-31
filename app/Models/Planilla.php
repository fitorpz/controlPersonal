<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'generado_por',
        'mes',
        'dias_trabajados',
        'faltas',
        'retrasos',
        'horas_extra',
        'salario_base',
        'total_descuento',
        'total_bonificacion',
        'salario_neto',
        'detalle_descuento',
        'detalle_bonificacion',
        'estado',
    ];

    // Relaciones

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function generadoPor()
    {
        return $this->belongsTo(User::class, 'generado_por');
    }
}
