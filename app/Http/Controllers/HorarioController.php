<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Empleado;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Muestra todos los horarios.
     */
    public function index()
    {
        $horarios = Horario::with('empleado')->get();
        return view('horarios.index', compact('horarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo horario.
     */
    public function create()
    {
        $empleados = Empleado::with('user')->get();
        return view('horarios.create', compact('empleados'));
    }

    /**
     * Almacena un nuevo horario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'nullable|exists:empleados,id',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
            'nombre_turno' => 'nullable|string|max:255',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un horario existente.
     */
    public function edit(Horario $horario)
    {
        $empleados = Empleado::all();
        return view('horarios.edit', compact('horario', 'empleados'));
    }

    /**
     * Actualiza el horario especificado.
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'empleado_id' => 'nullable|exists:empleados,id',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
            'nombre_turno' => 'nullable|string|max:255',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    /**
     * Elimina un horario.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')->with('success', 'Horario eliminado.');
    }
}
