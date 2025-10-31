<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use App\Models\ParametroEmpleado;
use App\Models\Empleado;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    /**
     * Mostrar todos los parámetros generales y acceso a parámetros por empleado
     */
    public function index()
    {
        $parametros = Parametro::all();
        $empleados = Empleado::with('user')->get();
        return view('parametros.index', compact('parametros', 'empleados'));
    }

    public function create()
    {
        return view('parametros.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|unique:parametros,clave',
            'descripcion' => 'nullable|string',
            'valor' => 'nullable|numeric|min:0',
        ]);

        Parametro::create($request->only('clave', 'descripcion', 'valor'));

        return redirect()->route('parametros.index')->with('success', 'Parámetro creado correctamente.');
    }

    /**
     * Editar un parámetro general
     */
    public function edit(Parametro $parametro)
    {
        return view('parametros.edit', compact('parametro'));
    }

    /**
     * Actualizar un parámetro general
     */
    public function update(Request $request, Parametro $parametro)
    {
        $request->validate([
            'valor' => 'nullable|numeric|min:0',
        ]);

        $parametro->update([
            'valor' => $request->valor,
        ]);

        return redirect()->route('parametros.index')->with('success', 'Parámetro general actualizado correctamente.');
    }

    /**
     * Mostrar y gestionar parámetros personalizados por empleado
     */
    public function showEmpleado(Empleado $empleado)
    {
        $parametrosGenerales = Parametro::all();
        $parametrosEmpleado = ParametroEmpleado::where('empleado_id', $empleado->id)->get()->keyBy('clave');

        return view('parametros.empleado', compact('empleado', 'parametrosGenerales', 'parametrosEmpleado'));
    }

    /**
     * Guardar o actualizar parámetros personalizados para un empleado
     */
    public function updateEmpleado(Request $request, Empleado $empleado)
    {
        foreach ($request->except('_token') as $clave => $valor) {
            if ($valor === null || $valor === '') {
                // Si se deja vacío, elimina el registro personalizado
                ParametroEmpleado::where('empleado_id', $empleado->id)
                    ->where('clave', $clave)
                    ->delete();
                continue;
            }

            ParametroEmpleado::updateOrCreate(
                ['empleado_id' => $empleado->id, 'clave' => $clave],
                ['valor' => $valor]
            );
        }

        return redirect()->route('parametros.index')->with('success', 'Parámetros personalizados del empleado actualizados correctamente.');
    }
}
