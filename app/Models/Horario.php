<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'hora_entrada',
        'hora_salida',
        'nombre_turno',
    ];

    // Relación: Un horario pertenece a un empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
