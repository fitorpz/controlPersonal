<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Muestra todas las asistencias registradas.
     */
    public function index()
    {
        $asistencias = Asistencia::with('empleado.user')->orderByDesc('fecha')->get();
        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Registrar entrada (puede ser desde login sin sesión).
     */
    public function storeEntrada(Request $request)
    {
        $request->validate([
            'ci' => 'required|string',
            'ubicacion_marcaje' => 'nullable|string',
        ]);

        // Buscar empleado por C.I.
        $empleado = Empleado::where('ci', $request->ci)->first();

        if (!$empleado) {
            return back()->with('error', 'Empleado no encontrado con esa C.I.');
        }

        $hoy = Carbon::today()->toDateString();

        // Verificar si ya marcó entrada hoy
        $asistencia = Asistencia::where('empleado_id', $empleado->id)->where('fecha', $hoy)->first();

        if ($asistencia && $asistencia->hora_entrada) {
            return back()->with('error', 'Ya se registró la entrada hoy.');
        }

        // Obtener hora actual
        $horaActual = Carbon::now()->format('H:i:s');

        // Buscar horario del empleado (si tiene)
        $horario = Horario::where('empleado_id', $empleado->id)->first();

        // Calcular estado (PRESENTE o RETRASO)
        $estado = 'PRESENTE';
        if ($horario && $horaActual > $horario->hora_entrada) {
            $estado = 'RETRASO';
        }

        // Crear o actualizar asistencia
        if (!$asistencia) {
            $asistencia = new Asistencia();
            $asistencia->empleado_id = $empleado->id;
            $asistencia->fecha = $hoy;
        }

        $asistencia->hora_entrada = $horaActual;
        $asistencia->ubicacion_marcaje = $request->ubicacion_marcaje;
        $asistencia->estado = $estado;
        $asistencia->save();

        return back()->with('success', 'Entrada registrada correctamente.');
    }

    /**
     * Registrar salida del empleado.
     */
    public function storeSalida(Request $request)
    {
        $request->validate([
            'ci' => 'required|string',
        ]);

        $empleado = Empleado::where('ci', $request->ci)->first();

        if (!$empleado) {
            return back()->with('error', 'Empleado no encontrado con esa C.I.');
        }

        $hoy = Carbon::today()->toDateString();

        $asistencia = Asistencia::where('empleado_id', $empleado->id)->where('fecha', $hoy)->first();

        if (!$asistencia || !$asistencia->hora_entrada) {
            return back()->with('error', 'No se registró entrada hoy.');
        }

        if ($asistencia->hora_salida) {
            return back()->with('error', 'Ya se registró la salida.');
        }

        $horaActual = Carbon::now()->format('H:i:s');

        // Verificar horario de salida (si salió antes)
        $horario = Horario::where('empleado_id', $empleado->id)->first();
        if ($horario && $horaActual < $horario->hora_salida) {
            $asistencia->estado = 'SALIDA_ANTICIPADA';
        }

        $asistencia->hora_salida = $horaActual;
        $asistencia->save();

        return back()->with('success', 'Salida registrada correctamente.');
    }
}
