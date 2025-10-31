<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $fillable = ['clave', 'descripcion', 'valor'];

    public static function valor(string $clave, $empleado_id = null)
    {
        // Buscar personalizado primero
        if ($empleado_id) {
            $personalizado = ParametroEmpleado::where('empleado_id', $empleado_id)
                ->where('clave', $clave)
                ->value('valor');

            if (!is_null($personalizado)) {
                return $personalizado;
            }
        }

        // Si no hay personalizado, usar general
        return static::where('clave', $clave)->value('valor') ?? 0;
    }
}
