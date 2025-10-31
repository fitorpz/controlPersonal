<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foto',
        'edad',
        'ci',
        'codigo',
        'celular',
        'salario_mensual',
        'fecha_ingreso',
        'fecha_retiro',
        'referencia_1_nombre',
        'referencia_1_celular',
        'referencia_2_nombre',
        'referencia_2_celular',
        'ubicacion_domicilio',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function asistencias()
    {
        return $this->hasMany(Asistencia::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class);
    }
}
