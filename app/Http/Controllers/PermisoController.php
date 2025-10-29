<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PermisoController extends Controller
{
    /**
     * Mostrar todos los permisos.
     */
    public function index()
    {
        $permisos = Permiso::with('empleado')->orderByDesc('created_at')->get();
        return view('permisos.index', compact('permisos'));
    }

    /**
     * Mostrar formulario de creación.
     */
    public function create()
    {
        $empleados = Empleado::all();
        return view('permisos.create', compact('empleados'));
    }

    /**
     * Guardar un nuevo permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id'   => 'required|exists:empleados,id',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            'motivo'        => 'required|string|max:255',
        ]);

        // Validación opcional: evitar permisos superpuestos
        $conflicto = Permiso::where('empleado_id', $request->empleado_id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                    ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin]);
            })->exists();

        if ($conflicto) {
            return back()->with('error', 'Ya existe un permiso en ese rango de fechas.');
        }

        Permiso::create($request->all());

        return redirect()->route('permisos.index')->with('success', 'Permiso registrado correctamente.');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(Permiso $permiso)
    {
        $empleados = Empleado::all();
        return view('permisos.edit', compact('permiso', 'empleados'));
    }

    /**
     * Actualizar un permiso existente.
     */
    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'empleado_id'   => 'required|exists:empleados,id',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            'motivo'        => 'required|string|max:255',
            'estado'        => 'required|in:PENDIENTE,APROBADO,RECHAZADO',
        ]);

        $permiso->update($request->all());

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado.');
    }

    /**
     * Eliminar un permiso.
     */
    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado.');
    }
}
