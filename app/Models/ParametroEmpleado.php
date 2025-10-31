<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametroEmpleado extends Model
{
    protected $table = 'parametros_empleado';

    protected $fillable = ['empleado_id', 'clave', 'valor'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
